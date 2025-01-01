/**
 * App user list (jquery)
 */

'use strict';

$(function () {
  var dataTablePermissions = $('.datatables-permissions'),
    dt_permission,
    userList = baseUrl + 'laravel/user-management',
    offModalForm = $('#addPermissionModal'),
    offModalEditForm = $('#editPermissionModal');

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Permissions List datatable
  if (dataTablePermissions.length) {
    dt_permission = dataTablePermissions.DataTable({
      processing: true,
      serverSide: true,
      ajax: baseUrl + 'permission-list', // JSON file to add data
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id' },
        { data: 'name' },
        { data: 'assigned_to' },
        { data: 'created_date' },
        { data: '' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          // Name
          targets: 2,
          render: function (data, type, full, meta) {
            var $name = full['name'];
            return '<span class="text-nowrap text-heading">' + $name + '</span>';
          }
        },
        {
          // User Role
          targets: 3,
          orderable: false,
          render: function (data, type, full, meta) {
            var $assignedTo = full['assigned_to'],
              $output = '';
            var roleBadgeObj = {
              'Super Admin':
                '<a href="' +
                userList +
                '"><span class="badge rounded-pill bg-label-primary me-4">Super Admin</span></a>',
              'Admin':
                '<a href="' + userList + '"><span class="badge rounded-pill bg-label-success me-4">Admin</span></a>',
              'Company':
                '<a href="' + userList + '"><span class="badge rounded-pill bg-label-warning me-4">Company</span></a>',
              'User':
                '<a href="' + userList + '"><span class="badge rounded-pill bg-label-info me-4">User</span></a>',
              'Restricted':
                '<a href="' +
                userList +
                '"><span class="badge rounded-pill bg-label-danger me-4">Restricted User</span></a>'
            };
            for (var i = 0; i < $assignedTo.length; i++) {
              var val = $assignedTo[i];
              $output += roleBadgeObj[val];
            }
            return '<span class="text-nowrap">' + $output + '</span>';
          }
        },
        {
          // remove ordering from Name
          targets: 4,
          orderable: false,
          render: function (data, type, full, meta) {
            var $date = full['created_date'];
            return '<span class="text-nowrap">' + $date + '</span>';
          }
        },
        {
          // Actions
          targets: -1,
          searchable: false,
          title: 'Actions',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center">' +
              `<button data-id="${full['id']}" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record text-body waves-effect waves-light me-1"><i class="ri-delete-bin-7-line ri-20px"></i></button>` +
              `<span class="text-nowrap"><button data-id="${full['id']}" class="btn btn-sm btn-icon btn-text-secondary edit-record text-body rounded-pill waves-effect waves-light" data-bs-target="#editPermissionModal" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="ri-edit-box-line ri-20px"></i></button></span>` +
              '</div>'
            );
          }
        }
      ],
      order: [[2, 'desc']],
      dom:
        '<"row mx-1"' +
        '<"col-sm-12 col-md-3 mt-5 mt-md-0" l>' +
        '<"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-4"f>B>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: '',
        searchPlaceholder: 'Search Permissions',
        paginate: {
          next: '<i class="ri-arrow-right-s-line"></i>',
          previous: '<i class="ri-arrow-left-s-line"></i>'
        }
      },
      // Buttons with Dropdown
      buttons: [
        {
          text: '<i class="ri-add-line me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add Permission</span>',
          className: 'add-new btn btn-primary mb-5 mb-md-0 waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#addPermissionModal'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      }
    });
  }

  // Delete Record
  $(document).on('click', '.delete-record', function () {
    var permission_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // sweetalert for confirmation of delete
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // delete the data
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}permission-list/${permission_id}`,
          success: function () {
            dt_permission.draw();
          },
          error: function (error) {
            console.log(error);
          }
        });

        // success sweetalert
        Swal.fire({
          icon: 'success',
          title: 'Deleted!',
          text: 'The permission has been deleted!',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelled',
          text: 'The permission is not deleted!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  // Add record
  const fv = FormValidation.formValidation(document.getElementById('addPermissionForm'), {
    fields: {
      modalPermissionName: {
        validators: {
          notEmpty: {
            message: 'Please enter permission name'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        // eleInvalidClass: '',
        eleValidClass: '',
        rowSelector: '.col-12'
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // adding or updating user when form successfully validate
    $.ajax({
      data: $('#addPermissionForm').serialize(),
      url: `${baseUrl}permission-list`,
      type: 'POST',
      success: function (status) {

        offModalForm.modal('hide');
        dt_permission.draw();

        // sweetalert
        Swal.fire({
          icon: 'success',
          title: `Successfully ${status}!`,
          text: `Permission ${status} Successfully.`,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function (err) {
        offModalForm.modal('hide');
        Swal.fire({
          title: 'Duplicate Entry!',
          text: 'Your permission should be unique.',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  // clearing form data when offcanvas hidden
  offModalForm.on('hide.bs.modal', function () {
    fv.resetForm(true);
  });

  // edit record
  $(document).on('click', '.edit-record', function () {
    var permission_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');
    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }
    // get data
    $.get(`${baseUrl}permission-list\/${permission_id}\/edit`, function (data) {
      $('#permissionID').val(data.id);
      $('#editPermissionName').val(data.name);
    });
  });

  const fe = FormValidation.formValidation(document.getElementById('editPermissionForm'), {
    fields: {
      modalPermissionName: {
        validators: {
          notEmpty: {
            message: 'Please enter permission name'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        // eleInvalidClass: '',
        eleValidClass: '',
        rowSelector: '.col-sm-9'
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // adding or updating user when form successfully validate
    $.ajax({
      data: $('#editPermissionForm').serialize(),
      url: `${baseUrl}permission-list`,
      type: 'POST',
      success: function (status) {
        dt_permission.draw();
        offModalEditForm.modal('hide');

        // sweetalert
        Swal.fire({
          icon: 'success',
          title: `Successfully ${status}!`,
          text: `Permission ${status} Successfully.`,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function (err) {
        offModalEditForm.modal('hide');
        Swal.fire({
          title: 'Duplicate Entry!',
          text: 'Your permission should be unique.',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  // clearing form data when offcanvas hidden
  offModalEditForm.on('hide.bs.modal', function () {
    fe.resetForm(true);
  });

});
