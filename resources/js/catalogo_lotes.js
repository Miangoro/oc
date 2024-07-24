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
                url: '/lotes-list',
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

        // Maneja el clic en los botones de eliminación
        $(document).on('click', '.delete-record', function () {
            var loteId = $(this).data('id');
            var token = $('meta[name="csrf-token"]').attr('content');
            
            Swal.fire({
                title: '¿Está seguro?',
                text: `No podrá revertir este evento. ID del lote: ${loteId}`,
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
                    $.ajax({
                        url: `/lotes_granel_delete/${loteId}`,  // Verifica que esta URL sea correcta
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Eliminado!',
                                    text: response.message,
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                }).then(() => {
                                    // Actualiza la tabla o realiza otra acción según sea necesario
                                    $('.datatables-users').DataTable().ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
                        },
                        error: function (xhr) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Hubo un problema al eliminar el lote.',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    });
                }
            });
        });

        /* insertar datos */
        $(document).on('submit', '#loteForm', function(e) {
            e.preventDefault();
        
            var formData = new FormData(this);
            
            $.ajax({
                url: '/lotes-granel',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message
                        }).then(() => {
                            $('#offcanvasAddLote').modal('hide');
                            // Opcional: Recarga la tabla o actualiza la vista
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    // Mostrar errores específicos de validación
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = '';
                    $.each(errors, function(key, value) {
                        errorMessages += value.join(' ') + '\n';
                    });
        
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessages || 'Hubo un problema al registrar el lote.'
                    });
                }
            });
        });
        
        
        
        document.addEventListener('DOMContentLoaded', function () {
            const tipoLote = document.getElementById('tipo_lote');
            const ocCidamFields = document.getElementById('oc_cidam_fields');
            const otroOrganismoFields = document.getElementById('otro_organismo_fields');
        
            function toggleFields() {
                if (tipoLote.value === 'oc_cidam') {
                    ocCidamFields.classList.remove('d-none');
                    otroOrganismoFields.classList.add('d-none');
                } else if (tipoLote.value === 'otro_organismo') {
                    ocCidamFields.classList.add('d-none');
                    otroOrganismoFields.classList.remove('d-none');
                } else {
                    ocCidamFields.classList.add('d-none');
                    otroOrganismoFields.classList.add('d-none');
                }
            }
        
            tipoLote.addEventListener('change', toggleFields);
            toggleFields(); // Inicializar estado de los campos
        });
        

    });
});
