/**
 * Page form list (jquery)
 */

'use strict';

$(function () {
    var dataTableform = $('.datatables-form'),
      select2 = $('.select2'),
      offModalForm = $('#addformModal'),
      offModalEditForm = $('#editformModal');

    if (select2.length) {
        select2.each(function () {
            var $this = $(this);
            select2Focus($this);
            $this.wrap('<div class="position-relative"></div>').select2({
                placeholder: 'Select value',
                dropdownParent: $this.parent()
            });
        });
    }

    // ajax setup
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // form List datatable
    if (dataTableform.length) {
      // alert("HIIII");
      var dt_form = dataTableform.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: baseUrl + 'form-list'
        },

        columns: [
          // columns according to JSON
          { data: '' },
          { data: 'id' },
          { data: 'name' },
          { data: 'action' }
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
              return `<span>${full.fack_id}</span>`;
            }
          },
          {
            // Name
            targets: 2,
            render: function (data, type, full, meta) {
              return `<span>${full.name}</span>`;
            }
          },


          {
            // Actions
            targets: -1,
            searchable: false,
            title: 'Actions',
            orderable: false,
            render: function (data, type, full, meta) {
              let showpage = showUrl.replace(':id', full['id']);
              return (
                '<div class="d-flex align-items-center">' +
                `<a href="${showpage}" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect" title="Preview"><i class="ri-eye-line ri-20px"></i></a>`+
                `<button data-id="${full['id']}" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record text-body waves-effect waves-light me-1"><i class="ri-delete-bin-7-line ri-20px"></i></button>` +
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
          searchPlaceholder: 'Search form',
          paginate: {
            next: '<i class="ri-arrow-right-s-line"></i>',
            previous: '<i class="ri-arrow-left-s-line"></i>'
          }
        },
        // Buttons with Dropdown
        buttons: [
          {
            text: '<i class="ri-add-line me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add form</span>',
            className: 'add-new btn btn-primary mb-5 mb-md-0 waves-effect waves-light',
            attr: {
              'data-bs-toggle': 'modal',
              'data-bs-target': '#addformModal'
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
                return 'Details of ' + data['form_name'];
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
      var form_id = $(this).data('id'),
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
            url: `${baseUrl}form-list/${form_id}`,
            success: function () {
              dt_form.draw();
            },
            error: function (error) {
              console.log(error);
            }
          });

          // success sweetalert
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'The form has been deleted!',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelled',
            text: 'The form is not deleted!',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    });

    const addformForm = document.getElementById('addformForm');

    // form form validation
    const fa = FormValidation.formValidation(addformForm, {
        fields: {
            form_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter name'
                    }
                }
            },
            comp_id: {
                validators: {
                    notEmpty: {
                        message: 'Please select form'
                    }
                }
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                // Use this for enabling/changing valid/invalid class
                eleValidClass: '',
                rowSelector: function (field, ele) {
                    // field is the field name & ele is the field element
                    return '.form-floating';
                }
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            // Submit the form when all fields are valid
            // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        }
    }).on('core.form.valid', function () {
        // adding or updating form when form successfully validate
        const formData = new FormData(addformForm);
        $.ajax({
            url: `${baseUrl}form-list`,
            type: 'POST',
            data: formData,
            processData: false,  // Prevents jQuery from processing data
            contentType: false,
            success: function (status) {
                dt_form.draw();
                offModalForm.modal('hide');

                // sweetalert
                Swal.fire({
                    icon: 'success',
                    title: `Successfully Added!`,
                    text: `form Added Successfully.`,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            },
            error: function (err) {
                offModalForm.modal('hide');
                Swal.fire({
                    title: 'Oops!',
                    text: 'Something went wrong.',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    });

    // clearing form data when offcanvas hidden
    offModalForm.on('hidden.bs.modal', function () {
        fa.resetForm(true);
    });

    // edit record
    $(document).on('click', '.edit-record', function () {
      var form_id = $(this).data('id'),
        dtrModal = $('.dtr-bs-modal.show');
      // hide responsive modal in small screen
      if (dtrModal.length) {
        dtrModal.modal('hide');
      }
      // get data
      $.get(`${baseUrl}form_-list\/${form_id}\/edit`, function (data) {
        // alert(data.form__name);
        $('#form_id').val(data.val['id']);
        $('#name').val(data.val['name']);


      });
    });

    const fe = FormValidation.formValidation(document.getElementById('editformForm'), {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter form name'
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
          rowSelector: '.form-floating'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      // adding or updating user when form successfully validate
      $.ajax({
        data: $('#editformForm').serialize(),
        url: `${baseUrl}form-list`,
        type: 'POST',
        success: function (status) {
          dt_form.draw();
          offModalEditForm.modal('hide');

          // sweetalert
          Swal.fire({
            icon: 'success',
            title: `Successfully Stored!`,
            text: `form Stored Successfully.`,
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
$('#addSection').on('click', function() {
  let sectionData = {
      section_name: $('#section_name').val(),
      section_description: $('#section_description').val(),
      questions: []
  };

  $('.question-container').each(function() {
      sectionData.questions.push({
          question_text: $(this).find('.question_text').val(),
          question_description: $(this).find('.question_description').val(),
          type: $(this).find('.question_type').val(),
          options: $(this).find('.question_options').val(),
      });
  });

  $.ajax({
      type: 'POST',
      url: '/section-list/store',
      success: function(response) {
          alert('Section added successfully!');
      },

  });
});





