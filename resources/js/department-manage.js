/**
 * Page Department List
 */

'use strict';

// Datatable (jquery)
$(function () {
    // Variable declaration for table
    var dt_department_table = $('.datatables-department'),
        select2 = $('.select2'),
        offCanvasForm = $('#offcanvasAddDepartment');

    if (select2.length) {
        var $this = select2;
        select2Focus($this);
        $this.wrap('<div class="position-relative"></div>').select2({
            // placeholder: 'Select Country',
            dropdownParent: $this.parent()
        });
    }

    // ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Department datatable
    if (dt_department_table.length) {
        var dt_department = dt_department_table.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: baseUrl + 'department-list'
            },
            columns: [
                // columns according to JSON
                { data: '' },
                { data: 'id' },
                { data: 'name' },
                { data: 'site_id' },
                { data: 'comp_id' },
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
                    // department name
                    targets: 2,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        var $name = full['name'];

                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-start align-items-center department-name">' +
                            '<div class="d-flex flex-column">' +
                            '<a href="#" class="text-truncate text-heading"><span class="fw-medium">' +
                            $name +
                            '</span></a>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    // department site
                    targets: 3,
                    render: function (data, type, full, meta) {
                        var $company = full.site;
                        return '<span class="department-site">' + $company + '</span>';
                    }
                },
                {
                    // department company
                    targets: 4,
                    render: function (data, type, full, meta) {
                        var $company = full.company;
                        return '<span class="department-company">' + $company + '</span>';
                    }
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
                            `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddDepartment"><i class="ri-edit-box-line ri-20px"></i></button>` +
                            `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id']}"><i class="ri-delete-bin-7-line ri-20px"></i></button>` +
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
                            title: 'Departments',
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
                                            if (item.classList !== undefined && item.classList.contains('department-name')) {
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
                            title: 'Departments',
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
                                            if (item.classList !== undefined && item.classList.contains('department-name')) {
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
                            title: 'Departments',
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
                                              if (item.classList !== undefined && item.classList.contains('department-name')) {
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
                            title: 'Departments',
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
                                            if (item.classList !== undefined && item.classList.contains('department-name')) {
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
                            title: 'Departments',
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
                                            if (item.classList !== undefined && item.classList.contains('department-name')) {
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
                    text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Add New Department</span>',
                    className: 'add-new btn btn-primary waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'offcanvas',
                        'data-bs-target': '#offcanvasAddDepartment'
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
        var department_id = $(this).data('id'),
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
                  url: `${baseUrl}department-list/${department_id}`,
                  success: function () {
                      dt_department.draw();
                  },
                  error: function (error) {
                      console.log(error);
                  }
              });

              // success sweetalert
              Swal.fire({
                  icon: 'success',
                  title: 'Deleted!',
                  text: 'The department has been deleted!',
                  customClass: {
                      confirmButton: 'btn btn-success'
                  }
              });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
              Swal.fire({
                  title: 'Cancelled',
                  text: 'The department is not deleted!',
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
        var department_id = $(this).data('id'),
            dtrModal = $('.dtr-bs-modal.show');

        // hide responsive modal in small screen
        if (dtrModal.length) {
            dtrModal.modal('hide');
        }

        // changing the title of offcanvas
        $('#offcanvasAddDepartmentLabel').html('Edit Department');

        // get data
        $.get(`${baseUrl}department-list\/${department_id}\/edit`, function (data) {
            $('#department_id').val(data.id);
            $('#name').val(data.name);
            $('#site_id option:selected').val(data.site_id);
            $('#comp_id option:selected').val(data.comp_id);
        });
    });

    // changing the title
    $('.add-new').on('click', function () {
        $('#department_id').val(''); //reseting input field
        $('#offcanvasAddDepartmentLabel')[0].reset();
        $('#offcanvasAddDepartmentLabel').html('Add Department');
    });

    // validating form and updating department's data
    const addNewDepartmentForm = document.getElementById('addNewDepartmentForm');

    // department form validation
    const fv = FormValidation.formValidation(addNewDepartmentForm, {
        fields: {
            name: {
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
                    return '.mb-5';
                }
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            // Submit the form when all fields are valid
            // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        }
    }).on('core.form.valid', function () {
        // adding or updating department when form successfully validate
        $.ajax({
            data: $('#addNewDepartmentForm').serialize(),
            url: `${baseUrl}department-list`,
            type: 'POST',
            success: function (status) {
                dt_department.draw();
                offCanvasForm.offcanvas('hide');

                // sweetalert
                Swal.fire({
                    icon: 'success',
                    title: `Successfully ${status}!`,
                    text: `Department ${status} Successfully.`,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            },
            error: function (err) {
                offCanvasForm.offcanvas('hide');
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

    // clearing form data when offcanvas hidden
    offCanvasForm.on('hidden.bs.offcanvas', function () {
        fv.resetForm(true);
    });
});
