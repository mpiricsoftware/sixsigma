'use strict';


$(function () {
    var dt_subplan_table = $('.datatables-subplan'),
        select2 = $('.select2'),
        offCanvasForm = $('#offcanvasAddsubplan');

    if (select2.length) {
        select2.wrap('<div class="position-relative"></div>').select2({
            dropdownParent: select2.parent()
        });
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (dt_subplan_table.length) {
        var dt_subplan = dt_subplan_table.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: baseUrl + 'subplan-list'
            },
            columns: [
                { data: '' },
                { data: 'id' },
                { data: 'subgroup_id' },
                { data: 'name' },
                { data: 'price' },
                // { data: 'monthly'},
                // { data: 'yearly'},
                { data: 'option'},
                { data: 'user_limit' },
                { data: 'site_limit' },
                { data: 'company_limit' },
                { data: 'features'},
                { data: 'description'},
                { data: 'action' }
            ],
            columnDefs: [
                {
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
                        return `<span>${full.id}</span>`;
                    }
                },
                {
                  targets: 2,
                  render: function (data, type, full, meta) {
                      return `<span>${full.subgroup_id}</span>`;
                  }
              },
                {
                    targets: 3,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        return `<span>${full.name}</span>`;
                    }
                },
                {
                    targets: 4,
                    render: function (data, type, full, meta) {
                        return `<span>${full.price}</span>`;
                    }
                },
                {
                  targets: 5,
                  render: function (data, type, full, meta) {
                      return `<span>${full.option}</span>`;
                  }
                },

                {
                  targets: 6,
                  render: function (data, type, full, meta) {
                      return `<span>${full.user_limit}</span>`;
                  }
              },
              {
                targets: 7,
                render: function (data, type, full, meta) {
                    return `<span>${full.site_limit}</span>`;
                }

            },
            {
              targets: 8,
              render: function (data, type, full, meta) {
                  return `<span>${full.company_limit}</span>`;
              }

          },
            {
              targets: 9,
              render: function (data, type, full, meta) {
                  return `<span>${full.features}</span>`;
              }
          },
          {
            targets: 10,
            render: function (data, type, full, meta) {
                return `<span>${full.description}</span>`;
            }
          },
                {
                    targets: -1,
                    title: 'Actions',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="d-flex align-items-center gap-50">' +
                            `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full.id}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddsubplan"><i class="ri-edit-box-line ri-20px"></i></button>` +
                            `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full.id}"><i class="ri-delete-bin-7-line ri-20px"></i></button>` +
                            '</div>'
                        );
                    }
                }
            ],
            order: [[2, 'desc']],
            dom: '<"card-header d-flex rounded-0 flex-wrap pb-md-0 pt-0"' +
                '<"me-5 ms-n2"f>' +
                '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center gap-4"lB>>' +
                '>t' +
                '<"row mx-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            lengthMenu: [10, 20, 50, 70, 100],
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
            buttons: [

                {
                    text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Add SubPlan</span>',
                    className: 'add-new btn btn-primary waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'offcanvas',
                        'data-bs-target': '#offcanvasAddsubplan'
                    }
                }


            ],
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
                            return col.title !== ''
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
        var subplan_id = $(this).data('id');

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
                $.ajax({
                    type: 'DELETE',
                    url: `${baseUrl}subplan-list/${subplan_id}`,
                    success: function () {
                        dt_subplan.draw();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'The subplan has been deleted!',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'The subplan is not deleted!',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    });

    // Edit Record
    $(document).on('click', '.edit-record', function () {
        var subplan_id = $(this).data('id');

        $('#offcanvasAddsubplanLabel').html('Edit SubPlan');

        $.get(`${baseUrl}subplan-list/${subplan_id}/edit`, function (data) {
            $('#id').val(data.id);
            $('#subgroup_id').val(data.subgroup_id);
            $('#name').val(data.name);
            $('#price').val(data.price);
            if (data.option === 'monthly') {
              $('#monthly').attr('checked', true);
              $('#yearly').attr('checked', false);
          } else if (data.option === 'yearly') {
              $('#yearly').attr('checked', true);
              $('#monthly').attr('checked', false);
          }
          $('#user_limit').val(data.user_limit);
          $('#site_limit').val(data.site_limit);
          $('#company_limit').val(data.company_limit);
          $('#features').val(data.features);
          $('#description').val(data.description);
        });

    });


    $('.add-new').on('click', function () {
        $('#subplan').val('');
        $('#offcanvasAddsubplanLabel').html('Add Subplan');
    });


    const addNewSubplanForm = document.getElementById('addNewsubplanForm');


    const fv = FormValidation.formValidation(addNewSubplanForm, {
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter name'
                    }
                }
            },
            price: {
                validators: {
                    notEmpty: {
                        message: 'Please enter price'
                    }
                }
            },
            plan_duration: {
                validators: {
                    notEmpty: {
                        message: 'Please select plan'
                    }
                }
            },
            features: {
                validators: {
                    notEmpty: {
                        message: 'Please enter features'
                    }
                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: 'Please enter description'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                rowSelector: function (field, ele) {
                    return '.mb-5';
                }
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        }
    }).on('core.form.valid', function () {
        $.ajax({
            data: $('#addNewsubplanForm').serialize(),
            url: `${baseUrl}subplan-list`,
            type: 'POST',
            success: function (status) {
                dt_subplan.draw();
                offCanvasForm.offcanvas('hide');

                Swal.fire({
                    icon: 'success',
                    title: `Successfully`,
                    text: `Subplan Added Successfully.`,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            },
            error: function (err) {
                offCanvasForm.offcanvas('hide');
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an issue with your request.',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    });


    offCanvasForm.on('hidden.bs.offcanvas', function () {
        fv.resetForm(true);
    });
});
