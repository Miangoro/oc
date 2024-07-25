

document.addEventListener('DOMContentLoaded', function() {
    const tipoLoteSelect = document.getElementById('tipo_lote');
    const ocCidamFields = document.getElementById('oc_cidam_fields');
    const otroOrganismoFields = document.getElementById('otro_organismo_fields');

    tipoLoteSelect.addEventListener('change', function() {
        const selectedValue = tipoLoteSelect.value;

        if (selectedValue === 'oc_cidam') {
            ocCidamFields.classList.remove('d-none');
            otroOrganismoFields.classList.add('d-none');
        } else if (selectedValue === 'otro_organismo') {
            ocCidamFields.classList.add('d-none');
            otroOrganismoFields.classList.remove('d-none');
        } else {
            ocCidamFields.classList.add('d-none');
            otroOrganismoFields.classList.add('d-none');
        }
    });

    $(document).ready(function() {
        // Inicializar DataTable
        $('.datatables-users').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/lotes-granel-list',
                type: 'GET'
            },
            columns: [
                { data: 'id_lote_granel' },
                { data: 'id_empresa' },
                { data: 'nombre_lote'},
                { data: 'tipo_lote'},
                { data: 'folio_fq' },
                { data: 'volumen'},
                { data: 'cont_alc' },
                { data: 'id_categoria' },
                { data: 'id_clase' },
                { data: 'id_tipo'},
                { data: 'ingredientes' },
                { data: 'edad'},
                { data: 'id_guia' },
                { data: 'folio_certificado' },
                { data: 'id_organismo' },
                { data: 'fecha_emision' },
                { data: 'fecha_vigencia' },
                { data: 'actions', orderable: false, searchable: false }
            ],
            columnDefs: [
                {
                    targets: 0, // Primera columna
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return meta.row + 1; // Índice incremental
                    }
                },
                {
                    targets: -1,
                    title: 'Acciones',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full) {
                        return (
                            '<div class="d-flex align-items-center gap-50">' +
                            `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_lote_granel']}" data-bs-toggle="offcanvas" data-bs-target="#editCategoria"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
                            `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_lote_granel']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` +
                            '</div>'
                        );
                    }
                }
            ],
            order: [[1, 'desc']],
            dom: 
            '<"card-header d-flex rounded-0 flex-wrap pb-md-0 pt-0"' +
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
                searchPlaceholder: 'Buscar',
                info: 'Mostrar _START_ a _END_ de _TOTAL_ registros',
                paginate: {
                    sFirst: 'Primero',
                    sLast: 'Último',
                    sNext: 'Siguiente',
                    sPrevious: 'Anterior'
                }
            },
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
                    text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar</span>',
                    buttons: [
                        {
                            extend: 'print',
                            title: 'Lotes a granel',
                            text: '<i class="ri-printer-line me-1"></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5],
                                format: {
                                    body: function (inner, rowIndex, columnIndex) {
                                        if (columnIndex === 5) {
                                            return 'ViewSuspend';
                                        }
                                        return inner;
                                    }
                                }
                            },
                            customize: function (win) {
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
                            title: 'Lotes a granel',
                            text: '<i class="ri-file-text-line me-1"></i>CSV',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5],
                                format: {
                                    body: function (inner, rowIndex, columnIndex) {
                                        if (columnIndex === 5) {
                                            return 'ViewSuspend';
                                        }
                                        return inner;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            title: 'Lotes a granel',
                            text: '<i class="ri-file-excel-line me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5],
                                format: {
                                    body: function (inner, rowIndex, columnIndex) {
                                        if (columnIndex === 5) {
                                            return 'ViewSuspend';
                                        }
                                        return inner;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            title: 'Lotes a granel',
                            text: '<i class="ri-file-pdf-line me-1"></i>PDF',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5],
                                format: {
                                    body: function (inner, rowIndex, columnIndex) {
                                        if (columnIndex === 5) {
                                            return 'ViewSuspend';
                                        }
                                        return inner;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'copy',
                            title: 'Lotes a granel',
                            text: '<i class="ri-file-copy-line me-1"></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5],
                                format: {
                                    body: function (inner, rowIndex, columnIndex) {
                                        if (columnIndex === 5) {
                                            return 'ViewSuspend';
                                        }
                                        return inner;
                                    }
                                }
                            }
                        }
                    ]
                },
                {
                    text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Lote</span>',
                    className: 'add-new btn btn-primary waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#offcanvasAddLote'
                    }
                }
            ]
        });

        
// Eliminar registro
$(document).on('click', '.delete-record', function () {
    var id_lote = $(this).data('id');
    var row = $(this).closest('tr');
    // Confirmación con SweetAlert
    Swal.fire({
        title: '¿Está seguro?',
        text: "No podrá revertir este evento",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        customClass: {
            confirmButton: 'btn btn-primary me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {
            // Solicitud de eliminación
            $.ajax({
                type: 'DELETE',
                url: `/lotes_granel_delete/${id_lote}`, // Ajusta la URL aquí
                success: function (response) {
                    $('.datatables-users').DataTable().draw();
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: 'El registro ha sido eliminado correctamente.',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error('Error en la solicitud de eliminación:', textStatus, errorThrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al eliminar el registro.',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: 'Cancelado',
                text: 'El registro no ha sido eliminado',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-secondary'
                }
            });
        }
    });
});



        
    });
});
