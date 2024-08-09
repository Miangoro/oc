/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {


    const tieneCoordenadasSelect = document.getElementById('tiene_coordenadas');
    const coordenadasDiv = document.getElementById('coordenadas');
    const latitudInputs = document.querySelectorAll('input[name="latitud[]"]');
    const longitudInputs = document.querySelectorAll('input[name="longitud[]"]');

    tieneCoordenadasSelect.addEventListener('change', function () {
        if (tieneCoordenadasSelect.value === 'Si') {
            coordenadasDiv.classList.remove('d-none');
        } else {
            coordenadasDiv.classList.add('d-none');
            // Limpiar los valores de los inputs de latitud y longitud
            latitudInputs.forEach(input => input.value = '');
            longitudInputs.forEach(input => input.value = '');
        }
    });




    // Variable declaration for table
    var dt_user_table = $('.datatables-users'),
    


        select2 = $('.select2'),
        
        offCanvasForm = $('#modalAddPredio');

    if (select2.length) {
        var $this = select2;
        select2Focus($this);
        $this.wrap('<div class="position-relative"></div>').select2({
            placeholder: 'Select Country',
            dropdownParent: $this.parent()
        });
    }
/* lo del select de arriba lo puedo quitar "creo" */
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
                { data: 'id_predio' },
                { data: 'id_empresa' },
                { data: 'nombre_productor' },
                { data: 'nombre_predio' },
                { data: 'ubicacion_predio' },
                { data: 'tipo_predio' },
                { data: 'puntos_referencia' },
                { data: 'cuenta_con_coordenadas' },
                { data: 'superficie' },
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
                    orderable: true,
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
                  `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_predio']}" data-bs-toggle="modal" data-bs-target="#modalEditPredio"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
                  `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_predio']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` +
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

    
    var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account'
    // Función para inicializar Select2 en elementos específicos
    function initializeSelect2($elements) {
      $elements.each(function () {
        var $this = $(this);
        select2Focus($this);
        $this.wrap('<div class="position-relative"></div>').select2({
          dropdownParent: $this.parent()
        });
      });
    }
  
    initializeSelect2(select2Elements);
  

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
                        text: '¡el predio ha sido eliminado correctamente!',
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
                        text: 'No se pudo eliminar el predio. Inténtalo de nuevo más tarde.',
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
                text: 'La eliminación del predio ha sido cancelada',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});




$(document).ready(function() {
    // Convertir tiposAgave a opciones HTML
    function generateOptions(tipos) {
        return tipos.map(tipo => `<option value="${tipo.id_tipo}">${tipo.nombre}</option>`).join('');
    }

    // Agregar nueva sección
    $('.add-row-plantacion').click(function() {
            /* solo sirve cuando hay más de otro select2 */
            var dt_user_table = $('.datatables-users'),
            select2Elements = $('.select2'),
            userView = baseUrl + 'app/user/view/account'
            // Función para inicializar Select2 en elementos específicos
            function initializeSelect2($elements) {
            $elements.each(function () {
                var $this = $(this);
                select2Focus($this);
                $this.wrap('<div class="position-relative"></div>').select2({
                dropdownParent: $this.parent()
                });
            });
            }
            initializeSelect2(select2Elements);
         /*  */
        var options = generateOptions(tiposAgave); // Usa la función para obtener las opciones
        var newSection = `
            <tr class="plantacion-row">
                <td rowspan="4">
                    <!-- El botón de eliminar estará en cada sección que se agregue -->
                    <button type="button" class="btn btn-danger remove-row-plantacion"><i class="ri-delete-bin-5-fill"></i></button>
                </td>
                <td>
                    <b>Nombre y Especie de Agave/Maguey</b>
                </td>
                <td>
                    <div class="form-floating form-floating-outline mb-3">
                        <select name="id_tipo[]" class=" form-select tipo_agave">
                            <option value="" disabled selected>Tipo de agave</option>
                            ${options}
                        </select>
                        <label for="especie_agave">Nombre y Especie de Agave/Maguey</label>
                    </div>
                </td>
            </tr>
            <tr class="plantacion-row">
                <td>
                    <b>Número de Plantas</b>
                </td>
                <td>
                    <div class="form-floating form-floating-outline">
                        <input type="number" class="form-control" name="numero_plantas[]" placeholder="Número de plantas" step="1">
                        <label for="numero_plantas">Número de Plantas</label>
                    </div>
                </td>
            </tr>
            <tr class="plantacion-row">
                <td>
                    <b>Edad de la Plantación</b>
                </td>
                <td>
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" name="edad_plantacion[]" placeholder="Edad de la plantación (años)" step="1">
                        <label for="edad_plantacion">Edad de la Plantación</label>
                    </div>
                </td>
            </tr>
            <tr class="plantacion-row">
                <td>
                    <p>Tipo de Plantación</p>
                </td>
                <td>
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" name="tipo_plantacion[]" placeholder="Tipo de plantación">
                        <label for="tipo_plantacion">Tipo de Plantación</label>
                    </div>
                </td>
            </tr>`;
        $('.contenidoPlantacion').append(newSection);

        // Inicializar Select2 en el nuevo select
        $('.select2').select2({
            dropdownParent: $('.select2').parent()
        });
    });

    // Eliminar sección
    $(document).on('click', '.remove-row-plantacion', function() {
        $(this).closest('tr').nextUntil('tr:not(.plantacion-row)').addBack().remove();
    });
});





$(document).ready(function () {

    // Añadir nueva fila de coordenadas
    $(document).on('click', '.add-row-cordenadas', function () {
        var newRow = `
            <tr>
                <td>
                    <button type="button" class="btn btn-danger remove-row-cordenadas"><i class="ri-delete-bin-5-fill"></i></button>
                </td>
                <td>
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" name="latitud[]" placeholder="Latitud">
                        <label>Latitud</label>
                    </div>
                </td>
                <td>
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" name="longitud[]" placeholder="Longitud">
                        <label>Longitud</label>
                    </div>
                </td>
            </tr>`;
        $('#coordenadas tbody').append(newRow);

        // Habilitar el botón de eliminar si hay más de una fila
        if ($('#coordenadas tbody tr').length > 1) {
            $('.remove-row-cordenadas').prop('disabled', false);
        }
    });

    // Eliminar fila de coordenadas
    $(document).on('click', '.remove-row-cordenadas', function () {
        $(this).closest('tr').remove();

        // Deshabilitar el botón de eliminar si no hay más filas
        if ($('#coordenadas tbody tr').length <= 1) {
            $('#coordenadas').find('.remove-row-cordenadas').prop('disabled', true);
        }
    });

    // Deshabilitar el botón de eliminar si solo hay una fila inicial
    if ($('#coordenadas tbody tr').length <= 1) {
        $('#coordenadas').find('.remove-row-cordenadas').prop('disabled', true);
    }
});

/* registrar un nuevo predio */

const addNewPredio = document.getElementById('addNewPredioForm');
const fv = FormValidation.formValidation(addNewPredio, {
    fields: {
        id_empresa: {
            validators: {
                notEmpty: {
                    message: 'Por favor selecciona la empresa cliente'
                }
            }
        },/*
      nombre_productor: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingresa el nombre del productor'
                }
            }
        }, 
        nombre_predio: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingresa el nombre del predio'
                }
            }
        },
        tipo_predio: {
            validators: {
                notEmpty: {
                    message: 'Por favor selecciona el tipo de predio'
                }
            }
        },
        superficie: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingresa la superficie del predio'
                },
                numeric: {
                    message: 'Por favor ingresa un valor numérico válido'
                }
            }
        }   */
    },
    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: function (field, ele) {
                return '.mb-4';
            }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
    }
}).on('core.form.valid', function (e) {
    var formData = new FormData(addNewPredio);

    $.ajax({
        url: '/predios-list',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            addNewPredio.reset();
            $('#id_empresa').val('').trigger('change');
            $('#modalAddPredio').modal('hide');
            $('.datatables-users').DataTable().ajax.reload();
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: response.message,
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Error al agregar el predio',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }
    });
});


$(document).on('click', '.edit-record', function () {
    var predioId = $(this).data('id');
    $('#edit_id_predio').val(predioId);

    $.ajax({
        url: '/domicilios-predios/' + predioId + '/edit',
        method: 'GET',
        success: function (data) {
            console.log(data); // Verifica la respuesta del servidor

            if (data.success) {
                var predio = data.predio;

                // Rellenar el modal con los datos del lote
                $('#edit_id_empresa').val(predio.id_empresa).trigger('change');
                $('#edit_nombre_productor').val(predio.nombre_productor)
                $('#edit_nombre_predio').val(predio.nombre_predio);
                $('#edit_ubicacion_predio').val(predio.ubicacion_predio);
                $('#edit_tipo_predio').val(predio.tipo_predio);
                $('#edit_puntos_referencia').val(predio.puntos_referencia);
                $('#edit_tiene_coordenadas').val(predio.tiene_coordenadas).trigger('change');
                $('#edit_superficie').val(predio.superficie);


                // Mostrar el modal
                $('#modalEditPredio').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar los datos del predio.',
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            }
        },
        error: function (error) {
            console.error('Error al cargar los datos del predio:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar los datos del predio.',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }
    });
});


$('#addEditPredioForm').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    var predioId = $('#edit_id_predio').val(); // Asegúrate de que este ID esté correctamente asignado

    $.ajax({
        url: '/domicilios-predios/' + predioId,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response); // Verifica la respuesta del servidor
            $('#modalEditPredio').modal('hide');
            $('.datatables-users').DataTable().ajax.reload();

            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: response.message,
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        },
        error: function(xhr) {
            console.error('Error al actualizar el predio:', xhr);
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                var errorMessages = Object.keys(errors).map(function(key) {
                    return errors[key].join('<br>');
                }).join('<br>');

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorMessages,
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al actualizar el predio.',
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            }
        }
    });
});


});
