/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
// resources/js/domicilio_predios.js

    const tieneCoordenadasSelect = document.getElementById('tiene_coordenadas');
    const coordenadasDiv = document.getElementById('coordenadas');
    const latitudInput = document.getElementById('latitud');
    const longitudInput = document.getElementById('longitud');

    tieneCoordenadasSelect.addEventListener('change', function () {
        if (tieneCoordenadasSelect.value === 'Si') {
            coordenadasDiv.classList.remove('d-none');
        } else {
            coordenadasDiv.classList.add('d-none');
            // Limpiar los valores de los inputs
            latitudInput.value = '';
            longitudInput.value = '';
        }
    });

    // Variable declaration for table
    var dt_user_table = $('.datatables-users'),

        select2 = $('.select2'),
        offCanvasForm = $('#offcanvasAddUser');

    if (select2.length) {
        var $this = select2;
        select2Focus($this);
        $this.wrap('<div class="position-relative"></div>').select2({
            placeholder: 'Select Country',
            dropdownParent: $this.parent()
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
        var dt_user = dt_user_table.DataTable({

            processing: true,
            serverSide: true,
            ajax: {
                url: baseUrl + 'predios-list', // Asegúrate de que esta URL coincida con la ruta en tu archivo de rutas
                type: 'GET'
            },
            columns: [
                // columns according to JSON
                { data: '' },
                { data: 'id' },
                { data: 'id_empresa' },
                { data: 'nombre_productor' },
                { data: 'nombre_predio' },
                { data: 'ubicacion_predio' },
                { data: 'tipo_predio' },
                { data: 'puntos_referencia' },
                { data: 'cuenta_con_coordenadas' },
                { data: 'latitud' },
                { data: 'longitud' },
                { data: 'superficie' },
                { data: 'nombre_agave' },
                { data: 'especie_agave' },
                { data: 'numero_plantas' },
                { data: 'edad_plantacion' },
                { data: 'tipo_plantacion' },
                { data: 'action' },
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
                    // User full name
                    targets: 2,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        var $name = full['id_empresa'];

                        // For Avatar badge
                        var stateNum = Math.floor(Math.random() * 6);
                        var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                        var $state = states[stateNum];

                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-start align-items-center user-name">' +
                            '<div class="avatar-wrapper">' +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<span class="fw-medium">' +
                            $name +
                            '</span>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },

                {
            // Actions botones de eliminar y actualizar(editar)
            targets: -1,
            title: 'Acciones',
            searchable: false,
            orderable: false,
            render: function (data, type, full, meta) {
                return (
                  '<div class="d-flex align-items-center gap-50">' +
                  `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#modalEditPredio"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
                  `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` +
                  '<div class="dropdown-menu dropdown-menu-end m-0">' +
                  '<a href="javascript:;" class="dropdown-item">Suspend</a>' +
                  '</div>' +
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
                searchPlaceholder: 'Buscar',
                info: 'Mostrar _START_ a _END_ de _TOTAL_ registros',
                paginate: {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                }
            },


            // Buttons with Dropdown
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
                    text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
                    buttons: [
                        {
                            extend: 'print',
                            title: 'catalogo clases',
                            text: '<i class="ri-printer-line me-1" ></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
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
                            title: 'catalogo clases',
                            text: '<i class="ri-file-text-line me-1" ></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
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
                            title: 'catalogo clases',
                            text: '<i class="ri-file-excel-line me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
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
                            title: 'catalogo clases',
                            text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3],
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
                            title: 'catalogo clases',
                            text: '<i class="ri-file-copy-line me-1"></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
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
                    text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar predios</span>',
                    className: 'add-new btn btn-primary waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#modalAddPredio'
                    }
                }
            ],

            
            // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['nombre_predio'];
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
    var id_predio = $(this).data('id'); // Obtener el ID de la clase
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
                url: `${baseUrl}predios-list/${id_predio}`,
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
                        text: '¡La clase ha sido eliminada correctamente!',
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
                        text: 'No se pudo eliminar la clase. Inténtalo de nuevo más tarde.',
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
                text: 'La eliminación de la clase ha sido cancelada',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});




});
