/**
 * Page company list (jquery)
 */

'use strict';

$(function () {
    var dataTableCompany = $('.datatables-company'),
      select2 = $('.select2'),
      offModalForm = $('#addCompanyModal'),
      offModalEditForm = $('#editCompanyModal');

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

    // Company List datatable
    if (dataTableCompany.length) {
      // alert("HIIII");
      var dt_company = dataTableCompany.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: baseUrl + 'company-list'
        },

        columns: [
          // columns according to JSON
          { data: '' },
          { data: 'id' },
          { data: 'company_name' },
          { data: 'email' },
          { data: 'billing_country' },
          { data: 'billing_state' },
          { data: 'billing_city' },
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
              return `<span>${full.fake_id}</span>`;
            }
          },
          {
            // Name
            targets: 2,
            render: function (data, type, full, meta) {
              var $name = full['company_name'];
              return '<span class="text-nowrap text-heading">' + $name + '</span>';
            }
          },
          {
            // User Role
            targets: 3,
            orderable: false,
            render: function (data, type, full, meta) {
              var $email = full['email'];
              return '<span class="text-nowrap text-heading">' + $email + '</span>';
            }
          },
          {
            // country
            targets: 4,
            orderable: false,
            render: function (data, type, full, meta) {
              var $country = full.country;
              return '<span class="text-nowrap">' + $country + '</span>';
            }
          },
          {
            // state
            targets: 5,
            orderable: false,
            render: function (data, type, full, meta) {
              var $state = full.state;
              return '<span class="text-nowrap">' + $state + '</span>';
            }
          },
          {
            // state
            targets: 6,
            orderable: false,
            render: function (data, type, full, meta) {
              var $city = full.city;
              return '<span class="text-nowrap">' + $city + '</span>';
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
                `<span class="text-nowrap"><button data-id="${full['id']}" class="btn btn-sm btn-icon btn-text-secondary edit-record text-body rounded-pill waves-effect waves-light" data-bs-target="#editCompanyModal" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="ri-edit-box-line ri-20px"></i></button></span>` +
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
          searchPlaceholder: 'Search Company',
          paginate: {
            next: '<i class="ri-arrow-right-s-line"></i>',
            previous: '<i class="ri-arrow-left-s-line"></i>'
          }
        },
        // Buttons with Dropdown
        buttons: [
          {
            text: '<i class="ri-add-line me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add Company</span>',
            className: 'add-new btn btn-primary mb-5 mb-md-0 waves-effect waves-light',
            attr: {
              'data-bs-toggle': 'modal',
              'data-bs-target': '#addCompanyModal'
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
                return 'Details of ' + data['company_name'];
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
      var company_id = $(this).data('id'),
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
            url: `${baseUrl}company-list/${company_id}`,
            success: function () {
              dt_company.draw();
            },
            error: function (error) {
              console.log(error);
            }
          });

          // success sweetalert
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'The Company has been deleted!',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelled',
            text: 'The Company is not deleted!',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    });

    const addCompanyForm = document.getElementById('addCompanyForm');

    // company form validation
    const fa = FormValidation.formValidation(addCompanyForm, {
        fields: {
            company_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter name'
                    }
                }
            },
            comp_id: {
                validators: {
                    notEmpty: {
                        message: 'Please select company'
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
        // adding or updating company when form successfully validate
        $.ajax({
            data: $('#addCompanyForm').serialize(),
            url: `${baseUrl}company-list`,
            type: 'POST',
            success: function (status) {
                dt_company.draw();
                offModalForm.modal('hide');

                // sweetalert
                Swal.fire({
                    icon: 'success',
                    title: `Successfully ${status}!`,
                    text: `Company ${status} Successfully.`,
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
      var company_id = $(this).data('id'),
        dtrModal = $('.dtr-bs-modal.show');
      // hide responsive modal in small screen
      if (dtrModal.length) {
        dtrModal.modal('hide');
      }
      // get data
      $.get(`${baseUrl}company-list\/${company_id}\/edit`, function (data) {
        // alert(data.company_name);
        $('#companyID').val(data.company['id']);
        $('#user_id').val(data.user['id']);
        $('.company_name').val(data.company['company_name']);
        $('.email').val(data.company['email']);
        $('.phone').val(data.company['phone']);
        $('.gst').val(data.company['gst']);
        $('.cin_no').val(data.company['cin_no']);
        $('.billing_address').val(data.company['billing_address']);
        $('.billing_city').val(data.company['billing_city']);
        $('.billing_state').val(data.company['billing_state']);
        $('.billing_country').val(data.company['billing_country']);
        $('.billing_zipcode').val(data.company['billing_zipcode']);
      });
    });

    const fe = FormValidation.formValidation(document.getElementById('editCompanyForm'), {
      fields: {
        company_name: {
          validators: {
            notEmpty: {
              message: 'Please enter company name'
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
        data: $('#editCompanyForm').serialize(),
        url: `${baseUrl}company-list`,
        type: 'POST',
        success: function (status) {
          dt_company.draw();
          offModalEditForm.modal('hide');

          // sweetalert
          Swal.fire({
            icon: 'success',
            title: `Successfully ${status}!`,
            text: `Company ${status} Successfully.`,
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

$('.billing_country').on('change', function()
{
    var countryId = $(this).val();
    var currentModal = $(this).closest('.modal'); // Get the current modal
    var billing_state_id = currentModal.find('.billing_state');
    $.ajax({
        url: 'company/add/getstate',
        method: "GET",
        data: {country_id: countryId},
        dataType: 'json',
        success: function(response) {
            // var billing_state_id = $('#billing_state');
            billing_state_id.empty();
            billing_state_id.append('<option value="">Select state</option>');
            $.each(response.states, function(index, states) {
                billing_state_id.append('<option value="' + states.id + '">' + states.name + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});


$('.billing_state').on('change', function()
{
    var stateId = $(this).val();
    var currentModal = $(this).closest('.modal'); // Get the current modal
    var billing_city_id = currentModal.find('.billing_city');
    $.ajax({
        url: 'company/add/getcities',
        method: "GET",
        data: {state_id: stateId},
        dataType: 'json',
        success: function(response){
            // var billing_city_id = $('#billing_city');
            billing_city_id.empty();
            billing_city_id.append('<option value="">Select city</option>');
            $.each(response.cities, function(index, cities){
                billing_city_id.append('<option value="' + cities.id + '">' + cities.name + '</option>');
            });
        },
        error: function(xhr, status, error){
            console.error(error);
        }
    });
});
