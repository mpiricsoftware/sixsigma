'use strict';


$(function () {
    var dt_subgroup_table = $('.datatables-subgroup'),
        select2 = $('.select2'),
        offCanvasForm = $('#offcanvasAddsubgroup');

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
    if (dt_subgroup_table.length) {
        var dt_subgroup = dt_subgroup_table.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: baseUrl + 'subgroup-list'
            },
            columns: [
                { data: '' },
                { data: 'id' },
                { data: 'name' },
                { data: 'priority' },
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
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        return `<span>${full.name}</span>`;
                    }
                },
                {
                    targets: 3,
                    render: function (data, type, full, meta) {
                        return `<span>${full.priority}</span>`;
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
                            `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full.id}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddsubgroup"><i class="ri-edit-box-line ri-20px"></i></button>` +
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
            //   {
            //     extend: 'collection',
            //     className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
            //     text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Export </span>',
            //     buttons: [
            //         {
            //             extend: 'print',
            //             title: 'Sites',
            //             text: '<i class="ri-printer-line me-1" ></i>Print',
            //             className: 'dropdown-item',
            //             exportOptions: {
            //                 columns: [1, 2, 3, 4, 5],
            //                 format: {
            //                     body: function (inner, coldex, rowdex) {
            //                         if (inner.length <= 0) return inner;
            //                         var el = $.parseHTML(inner);
            //                         var result = '';
            //                         $.each(el, function (index, item) {
            //                             if (item && item.classList  && item.classList.contains('subgroup-name')) {
            //                                 result = result + item.lastChild.firstChild.textContent;
            //                             } else if (item.innerText === undefined) {
            //                                 result = result + item.textContent;
            //                             } else result = result + item.innerText;
            //                         });
            //                         return result;
            //                     }
            //                 }
            //             },
            //             customize: function (win) {
            //                 //customize print view for dark
            //                 $(win.document.body)
            //                     .css('color', config.colors.headingColor)
            //                     .css('border-color', config.colors.borderColor)
            //                     .css('background-color', config.colors.body);
            //                 $(win.document.body)
            //                     .find('table')
            //                     .addClass('compact')
            //                     .css('color', 'inherit')
            //                     .css('border-color', 'inherit')
            //                     .css('background-color', 'inherit');
            //             }
            //         },
            //         {
            //             extend: 'csv',
            //             title: 'Sites',
            //             text: '<i class="ri-file-text-line me-1" ></i>Csv',
            //             className: 'dropdown-item',
            //             exportOptions: {
            //                 columns: [1, 2, 3, 4, 5],
            //                 // prevent avatar to be print
            //                 format: {
            //                     body: function (inner, coldex, rowdex) {
            //                         if (inner.length <= 0) return inner;
            //                         var el = $.parseHTML(inner);
            //                         var result = '';
            //                         $.each(el, function (index, item) {
            //                             if (item.classList !== undefined && item.classList.contains('subgroup-name')) {
            //                                 result = result + item.lastChild.firstChild.textContent;
            //                             } else if (item.innerText === undefined) {
            //                                 result = result + item.textContent;
            //                             } else result = result + item.innerText;
            //                         });
            //                         return result;
            //                     }
            //                 }
            //             }
            //         },
            //         {
            //             extend: 'excel',
            //             title: 'Sites',
            //             text: '<i class="ri-file-excel-line me-1"></i>Excel',
            //             className: 'dropdown-item',
            //             exportOptions: {
            //                 columns: [1, 2, 3, 4, 5],
            //                 // prevent avatar to be display
            //                 format: {
            //                     body: function (inner, coldex, rowdex) {
            //                         if (inner.length <= 0) return inner;
            //                         var el = $.parseHTML(inner);
            //                         var result = '';
            //                           $.each(el, function (index, item) {
            //                               if (item.classList !== undefined && item.classList.contains('subgroup-name')) {
            //                                   result = result + item.lastChild.firstChild.textContent;
            //                               } else if (item.innerText === undefined) {
            //                                   result = result + item.textContent;
            //                               } else result = result + item.innerText;
            //                           });
            //                         return result;
            //                     }
            //                 }
            //             }
            //         },
            //         {
            //             extend: 'pdf',
            //             title: 'Sites',
            //             text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
            //             className: 'dropdown-item',
            //             exportOptions: {
            //                 columns: [1, 2, 3, 4, 5],
            //                 // prevent avatar to be display
            //                 format: {
            //                     body: function (inner, coldex, rowdex) {
            //                         if (inner.length <= 0) return inner;
            //                         var el = $.parseHTML(inner);
            //                         var result = '';
            //                         $.each(el, function (index, item) {
            //                             if (item.classList !== undefined && item.classList.contains('subgroup-name')) {
            //                                 result = result + item.lastChild.firstChild.textContent;
            //                             } else if (item.innerText === undefined) {
            //                                 result = result + item.textContent;
            //                             } else result = result + item.innerText;
            //                         });
            //                         return result;
            //                     }
            //                 }
            //             }
            //         },
            //         {
            //             extend: 'copy',
            //             title: 'Sites',
            //             text: '<i class="ri-file-copy-line me-1"></i>Copy',
            //             className: 'dropdown-item',
            //             exportOptions: {
            //                 columns: [1, 2, 3, 4, 5],
            //                 // prevent avatar to be copy
            //                 format: {
            //                     body: function (inner, coldex, rowdex) {
            //                         if (inner.length <= 0) return inner;
            //                         var el = $.parseHTML(inner);
            //                         var result = '';
            //                         $.each(el, function (index, item) {
            //                             if (item.classList !== undefined && item.classList.contains('subgroup-name')) {
            //                                 result = result + item.lastChild.firstChild.textContent;
            //                             } else if (item.innerText === undefined) {
            //                                 result = result + item.textContent;
            //                             } else result = result + item.innerText;
            //                         });
            //                         return result;
            //                     }
            //                 }
            //             }
            //         }
            //     ]
            // },
                {
                    text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Add New Subgroup</span>',
                    className: 'add-new btn btn-primary waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'offcanvas',
                        'data-bs-target': '#offcanvasAddsubgroup'
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
        var subgroup_id = $(this).data('id');

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
                    url: `${baseUrl}subgroup-list/${subgroup_id}`,
                    success: function () {
                        dt_subgroup.draw();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'The subgroup has been deleted!',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'The subgroup is not deleted!',
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
        var subgroup_id = $(this).data('id');

        $('#offcanvasAddsubgroupLabel').html('Edit Subgroup');

        $.get(`${baseUrl}subgroup-list/${subgroup_id}/edit`, function (data) {
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#priority').val(data.priority);
        });
    });


    $('.add-new').on('click', function () {
        $('#subgroup').val('');
        $('#offcanvasAddsubgroupLabel').html('Add Subgroup');
    });


    const addNewSubgroupForm = document.getElementById('addNewsubgroupForm');


    const fv = FormValidation.formValidation(addNewSubgroupForm, {
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter name'
                    }
                }
            },
            priority: {
                validators: {
                    notEmpty: {
                        message: 'Please enter priority'
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
            data: $('#addNewsubgroupForm').serialize(),
            url: `${baseUrl}subgroup-list`,
            type: 'POST',
            success: function (status) {
                dt_subgroup.draw();
                offCanvasForm.offcanvas('hide');

                Swal.fire({
                    icon: 'success',
                    title: `Successfully`,
                    text: `Subgroup Added Successfully.`,
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
