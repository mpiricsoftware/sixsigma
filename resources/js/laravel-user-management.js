/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // alert('rwr');
    // Variable declaration for table
    var dt_user_table = $('.datatables-users'),
      select2 = $('.select2'),
      userView = userViewUrl,
      modalForm = $('#modalAddUser');

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

    // Users datatable
    if (dt_user_table.length) {
      var ajexUrl = baseUrl + 'user-list';
      // alert(ajexUrl);
      var dt_user = dt_user_table.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: ajexUrl
        },
        columns: [
          // columns according to JSON
          { data: '' },
          // { data: 'id' },
          {data: 'name'},
          {data: 'lastname'},
          {data: 'company' },
          {data: 'state' },
          {data: 'city'},
          {data: 'mobileno'},
          {data: 'status'},
          { data: 'email_verified_at' },
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
          // {
          //   searchable: false,
          //   orderable: false,
          //   targets: 1,
          //   render: function (data, type, full, meta) {
          //     return `<span>${full.fake_id}</span>`;
          //   }
          // },
          {
            // User full name
            targets: 1,
            orderable: false,
            responsivePriority: 4,
            render: function (data, type, full, meta) {
              var $name = full['name'];
              var $email = full['email'];
              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6);
              var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
              var $state = states[stateNum],
                $name = full['name'],
                $initials = $name.match(/\b\w/g) || [],
                $output;
              $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
              $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';

              // Creates full output for row
              var $row_output =
                '<div class="d-flex justify-content-start align-items-center user-name">' +
                '<div class="avatar-wrapper">' +
                '<div class="avatar avatar-sm me-3">' +
                $output +
                '</div>' +
                '</div>' +
                '<div class="d-flex flex-column">' +
                '<a href="' +
                userView.replace(':id', full['id']) +
                '" class="text-truncate text-heading"><span class="fw-medium">' +
                $name +
                '</span></a>' +
                '<span class="user-email text-muted">' + $email + '</span>' +
                '</div>' +
                '</div>';
              return $row_output;
            }
          },
          {
            // Company
            targets: 2,
            orderable: false,
            render: function (data, type, full, meta) {
              var $lastname = full.lastname;
              return '<span class="text-nowrap">' + $lastname + '</span>';
            }
          },
          {
            // Company
            targets: 3,
            orderable: false,
            render: function (data, type, full, meta) {
              var $company = full.company;
              return '<span class="text-nowrap">' + $company + '</span>';
            }
          },
          {
            // Country
            targets: 4,
            orderable: false,
            render: function (data, type, full, meta) {
                var $state = full.state ;
                return '<span class="text-nowrap">' + $state  + '</span>';
            }
          },
          {
            // Country
            targets: 5,
            orderable: false,
            render: function (data, type, full, meta) {
                var $city = full.city ;
                return '<span class="text-nowrap">' + $city  + '</span>';
            }
          },
          {
             target: 6,
             orderable: false,
             render: function (data, type, full, meta)
             {
              var $mobileno = full.mobileno;
              return '<span class="text-nowrap">' + $mobileno + '</span>';
             }
          },
          {
            targets: 7,
            orderable: false,
            render: function (data, type, full, meta) {
              var status = full.status;
              var icon = '';

              switch (status) {
                case '1':
                    icon = '<span class="badge bg-label-success rounded-pill">Active</span>';
                    break;
                case '0':
                    icon = '<span class="badge bg-label-warning rounded-pill">Inactive</span>';
                    break;
                default:
                    icon = '<span class="badge bg-label-secondary rounded-pill">Unknown</span>';
                    break;
            }


              return '<span class="text-nowrap">' + icon + '</span>';
            }
          },
          {
            // email verify
            targets: 8,
            orderable: false,
            className: 'text-center',
            render: function (data, type, full, meta) {
              var $verified = full['email_verified_at'];
              return `${
                $verified
                  ? '<i class="ri-shield-check-line ri-24px text-success"></i>'
                  : '<i class="ri-shield-line ri-24px text-danger" ></i>'
              }`;
            },
            orderable: false,
          },
          {
            // Actions
            targets: -1,
            title: 'Actions',
            searchable: false,
            orderable: false,
            render: function (data, type, full, meta) {
              return (
                '<div class="d-flex align-items-center gap-50">' +
                '<a href="' + userView.replace(':id', full['id']) + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect" title="Preview"><i class="ri-eye-line ri-20px"></i></a>' +
                `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#modalAddUser"><i class="ri-edit-box-line ri-20px"></i></button>` +
                '</div>'
              );
            }
          }
        ],
        order: [[2, 'desc']],
        dom:
          '<"card-header d-flex rounded-0 flex-wrap pb-md-0 pt-0"' +
          '<"me-5 ms-n2"f>' +
          '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center gap-4"lB>>' +
          '>t' +
          '<"row mx-1"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
        lengthMenu: [10, 20, 50, 70, 100], //for length of menu
        language: {
          sLengthMenu: '_MENU_',
          search: '',
          searchPlaceholder: 'Search',
          info: 'Displaying _START_ to _END_ of _TOTAL_ entries',
          paginate: {
            next: '<i class="ri-arrow-right-s-line"></i>',
            previous: '<i class="ri-arrow-left-s-line"></i>'
          }
        },
        // Buttons with Dropdown
        buttons: [
          {
            extend: 'collection',
            className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
            text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Export </span>',
            buttons: [
              {
                extend: 'print',
                title: 'Users',
                text: '<i class="ri-printer-line me-1" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [1, 2, 3, 4, 5],
                  // prevent avatar to be print
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                          result = result + item.lastChild.firstChild.textContent;
                        } else if (item.innerText === undefined) {
                          result = result + item.textContent;
                        } else result = result + item.innerText;
                      });
                      return result;
                    }
                  }
                },
                customize: function (win) {
                  //customize print view for dark
                  $(win.document.body)
                    .css('color', config.colors.headingColor)
                    .css('border-color', config.colors.borderColor)
                    .css('background-color', config.colors.body);
                  $(win.document.body)
                    .find('table')
                    .addClass('compact')
                    .css('color', 'inherit')
                    .css('border-color', 'inherit')
                    .css('background-color', 'inherit');
                }
              },
              {
                extend: 'csv',
                title: 'Users',
                text: '<i class="ri-file-text-line me-1" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [1, 2, 3, 4, 5],
                  // prevent avatar to be print
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                          result = result + item.lastChild.firstChild.textContent;
                        } else if (item.innerText === undefined) {
                          result = result + item.textContent;
                        } else result = result + item.innerText;
                      });
                      return result;
                    }
                  }
                }
              },
              {
                extend: 'excel',
                title: 'Users',
                text: '<i class="ri-file-excel-line me-1"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [1, 2, 3, 4, 5],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                          result = result + item.lastChild.firstChild.textContent;
                        } else if (item.innerText === undefined) {
                          result = result + item.textContent;
                        } else result = result + item.innerText;
                      });
                      return result;
                    }
                  }
                }
              },
              {
                extend: 'pdf',
                title: 'Users',
                text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [1, 2, 3, 4, 5],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                          result = result + item.lastChild.firstChild.textContent;
                        } else if (item.innerText === undefined) {
                          result = result + item.textContent;
                        } else result = result + item.innerText;
                      });
                      return result;
                    }
                  }
                }
              },
              {
                extend: 'copy',
                title: 'Users',
                text: '<i class="ri-file-copy-line me-1"></i>Copy',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [1, 2, 3, 4, 5],
                  // prevent avatar to be copy
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
                          result = result + item.lastChild.firstChild.textContent;
                        } else if (item.innerText === undefined) {
                          result = result + item.textContent;
                        } else result = result + item.innerText;
                      });
                      return result;
                    }
                  }
                }
              }
            ]
          },
          {
            text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Add New User</span>',
            className: 'add-new btn btn-dark custom-rounded-0 waves-effect waves-light',
            attr: {
              'data-bs-toggle': 'modal',
              'data-bs-target': '#modalAddUser'
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
      var user_id = $(this).data('id'),
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
            url: `${baseUrl}user-list/${user_id}`,
            success: function () {
              dt_user.draw();
            },
            error: function (error) {
              console.log(error);
            }
          });

          // success sweetalert
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'The user has been deleted!',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelled',
            text: 'The User is not deleted!',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    });

    // edit record
    $(document).on('click', '.edit-record', function () {
      var user_id = $(this).data('id'),
        dtrModal = $('.dtr-bs-modal.show');

      // hide responsive modal in small screen
      if (dtrModal.length) {
        dtrModal.modal('hide');
      }

      // changing the title of modal
      $('#modalAddUserLabel').html('Edit User');

      // get data
      $.get(`${baseUrl}user-list\/${user_id}\/edit`, function (data) {
        $('#user_id').val(data.id);
        $('#add-user-fullname').val(data.name);
        $('#add-user-email').val(data.email);
        $('#add-user-company').val(data.company);
        $('#username').val(data.username);
        $('#add-user-lastname').val(data.lastname);
        $('#address').val(data.address);
        $('#country').val(data.country).trigger('change');
        setTimeout(function () {
            $('#state').val(data.state).trigger('change');
        }, 500);
        setTimeout(function () {
            $('#city').val(data.city).trigger('change');
        }, 1000);
        $('#office_no').val(data.office_no);
        $('#mobileno').val(data.mobileno);
        $('#usertype').val(data.usertype).trigger('change');
        console.log(data.usertype);

    });

    });

    // changing the title
    $('.add-new').on('click', function () {
      $('#user_id').val(''); //reseting input field
      $('#addNewUserForm')[0].reset();
      $('#usertype').val(null).trigger('select2.change');
      $('#modalAddUserLabel').html('Add New User');
    });

    // validating form and updating user's data
    const addNewUserForm = document.getElementById('addNewUserForm');

    // user form validation
    const fv1 = FormValidation.formValidation(addNewUserForm, {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter fullname'
            }
          }
        },
        email: {
          validators: {
            notEmpty: {
              message: 'Please enter your email'
            },
            emailAddress: {
              message: 'The value is not a valid email address'
            }
          }
        },
        company: {
          validators: {
            notEmpty: {
              message: 'Please enter your company'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          eleValidClass: '',
          rowSelector: function (field, ele) {
            // field is the field name & ele is the field element
            return '.col-12';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      // adding or updating user when form successfully validate
      $.ajax({
        data: $('#addNewUserForm').serialize(),
        url: `${baseUrl}user-list`,
        type: 'POST',
        success: function (status) {
          dt_user.draw();
          modalForm.modal('hide');

          // sweetalert
          Swal.fire({
            icon: 'success',
            title: `Successfully ${status}!`,
            text: `User ${status} Successfully.`,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (err) {
          modalForm.modal('hide');
          Swal.fire({
            title: 'Duplicate Entry!',
            text: 'Your email should be unique.',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    });

    // clearing form data when modal hidden
    modalForm.on('hidden.bs.modal', function () {
        fv1.resetForm(true);
    });

    // const phoneMaskList = document.querySelectorAll('.phone-mask');

    // // Phone Number
    // if (phoneMaskList) {
    //   phoneMaskList.forEach(function (phoneMask) {
    //     new Cleave(phoneMask, {
    //       phone: true,
    //       phoneRegionCode: 'US'
    //     });
    //   });
    // }
});
// Handle country change
$('.country').on('change', function() {
  var countryId = $(this).val();
  var currentModal = $(this).closest('.modal'); // Get the current modal
  var stateSelect = currentModal.find('.state'); // Select the state dropdown

  $.ajax({
    url: 'getstate', // Correct route for fetching states
      method: "GET",
      data: {country_id: countryId},
      dataType: 'json',
      success: function(response) {
          stateSelect.empty(); // Clear previous options
          stateSelect.append('<option value="">Select state</option>');
          $.each(response.state, function(index, state) { // Correct the property to 'state'
              stateSelect.append('<option value="' + state.id + '">' + state.name + '</option>');
          });
      },
      error: function(xhr, status, error) {
          console.error(error);
      }
  });
});

// Handle state change
$('.state').on('change', function() {
  var stateId = $(this).val();
  var currentModal = $(this).closest('.modal'); // Get the current modal
  var citySelect = currentModal.find('.city'); // Select the city dropdown

  $.ajax({
    url: 'getcity', // Correct route for fetching cities
      method: "GET",
      data: {state_id: stateId},
      dataType: 'json',
      success: function(response) {
          citySelect.empty(); // Clear previous options
          citySelect.append('<option value="">Select city</option>');
          $.each(response.city, function(index, city) { // Correct the property to 'city'
              citySelect.append('<option value="' + city.id + '">' + city.name + '</option>');
          });
      },
      error: function(xhr, status, error) {
          console.error(error);
      }
  });
});
