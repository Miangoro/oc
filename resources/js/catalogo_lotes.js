// resources/js/catalogo_lotes.js

$(function() {
    const tipoLoteSelect = document.getElementById('tipo_lote');
    const ocCidamFields = document.getElementById('oc_cidam_fields');
    const otroOrganismoFields = document.getElementById('otro_organismo_fields');

    tipoLoteSelect.addEventListener('change', function() {
        const selectedValue = tipoLoteSelect.value;

        if (selectedValue === '1') {
            ocCidamFields.classList.remove('d-none');
            otroOrganismoFields.classList.add('d-none');
        } else if (selectedValue === '2') {
            ocCidamFields.classList.add('d-none');
            otroOrganismoFields.classList.remove('d-none');
        } else {
            ocCidamFields.classList.add('d-none');
            otroOrganismoFields.classList.add('d-none');
        }
    });

    $('.select2').select2(); // Inicializa select2 en el documento

//DATE PICKER

$(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd'
    });
  
  });
  
  
    // Inicializar DataTable
    var dt_user = $('.datatables-users').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/lotes-granel-list',
            type: 'GET'
        },
        columns: [
            { data: 'id_lote_granel' },
            { data: 'id_empresa' },
            { data: 'nombre_lote' },
            { data: 'tipo_lote' },
            { data: 'folio_fq' },
            { data: 'volumen' },
            { data: 'cont_alc' },
            { data: 'id_categoria' },
            { data: 'id_clase' },
            { data: 'id_tipo' },
            { data: 'ingredientes' },
            { data: 'edad' },
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
                        `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_lote_granel']}" data-bs-toggle="modal" data-bs-target="#offcanvasEditLote"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
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
                        text: '<i class="ri-file-copy-line me-1"></i>Copy',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
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
        ],
    });
// Delete Record
$(document).on('click', '.delete-record', function () {
    var id_lote= $(this).data('id'); // Obtener el ID de la clase
    var dtrModal = $('.dtr-bs-modal.show');

    // Ocultar modal responsivo en pantalla pequeña si está abierto
    if (dtrModal.length) {
        dtrModal.modal('hide');
    }

    // SweetAlert para confirmar la eliminación
    Swal.fire({
        title: '¿Está seguro?',
        text: 'No podrá revertir este evento',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        customClass: {
            confirmButton: 'btn btn-primary me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.isConfirmed) {
            // Enviar solicitud DELETE al servidor
            $.ajax({
                type: 'DELETE',
                url: `${baseUrl}lotes-granel-list/${id_lote}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    // Actualizar la tabla después de eliminar el registro
                    dt_user.draw();

                    // Mostrar SweetAlert de éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: '¡El lote ha sido eliminada correctamente!',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                },
                error: function (error) {
                    console.log(error);
                    // Mostrar SweetAlert de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar el lote. Inténtalo de nuevo más tarde.',
                        footer: `<pre>${error.responseText}</pre>`,
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }

            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Acción cancelada, mostrar mensaje informativo
            Swal.fire({
                title: 'Cancelado',
                text: 'La eliminación del lote ha sido cancelada',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});


    
$('#loteForm').on('submit', function(event) {
    event.preventDefault(); // Evita el envío por defecto del formulario

    // Crear un nuevo FormData con los datos del formulario
    var formData = new FormData(this);

    // Agregar el token CSRF al FormData
    formData.append('_token', $('input[name="_token"]').val());

    // Depurar el contenido de FormData
    for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'), // Usa la URL definida en el atributo 'action' del formulario
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            // Mostrar mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Registrado!',
                text: 'El lote ha sido registrado correctamente.',
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            }).then(function() {
                // Actualizar DataTable
                dt_user.draw();
                // Cerrar modal
                $('#offcanvasAddLote').modal('hide');
                // Resetear formulario
                $('#loteForm')[0].reset();
                // Ocultar campos adicionales
                ocCidamFields.classList.add('d-none');
                otroOrganismoFields.classList.add('d-none');
            });
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            // Mostrar mensaje de error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo registrar el lote. Inténtalo de nuevo más tarde.',
                footer: `<pre>${xhr.responseText}</pre>`,
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }
    });
});

/*  */
/*  */
$(document).ready(function() {

    // Evento para abrir el modal
    $('.edit-record').on('click', function() {
        var id_lote_granel = $(this).data('id');
        var url = baseUrl + '/lotes-a-granel/' + id_lote_granel + '/edit';
        
        $.get(url, function(response) {
            console.log(response); // Verifica la respuesta del servidor
            if (response.success) {
                var lote = response.lote;
                console.log(lote); // Verifica el objeto lote

                // Solo rellenar los campos Nombre del Lote y Empresa
                $('#nombre_lote').val(lote.nombre_lote);
                $('#id_empresa').val(lote.id_empresa).trigger('change'); // trigger change si usas select2
                
                // Mostrar el modal
                $('#offcanvasEditLote').modal('show');
            } else {
                // Muestra un mensaje de error más detallado
                var errorMessage = response.message || 'Error al cargar los datos.';
                alert(errorMessage);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // Manejo de errores de la solicitud AJAX
            alert('Error en la solicitud: ' + textStatus + ' - ' + errorThrown);
        });
    });
});




});
