/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Selecciona los elementos para el formulario de edición


  $(document).on('change', '#edit_tiene_coordenadas', function () {
    var tieneCoordenadasSelectEdit = $(this);
    var coordenadasDivEdit = $('#edit_coordenadas');

    if (tieneCoordenadasSelectEdit.val() === 'Si') {
      coordenadasDivEdit.removeClass('d-none');
    } else {
      coordenadasDivEdit.addClass('d-none');
    }
  });

  $(document).ready(function () {
    const tieneCoordenadasSelect = document.getElementById('tiene_coordenadas');
    const coordenadasDiv = document.getElementById('coordenadas');
    const latitudInputs = document.querySelectorAll('input[name="latitud[]"]');
    const longitudInputs = document.querySelectorAll('input[name="longitud[]"]');

    if (tieneCoordenadasSelect && coordenadasDiv) {
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
    }
  });




  // Variable declaration for table
  var dt_user_table = $('.datatables-users');
    //DATE PICKER
    $(document).ready(function () {
      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
      });

    });

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
        {
          data: 'estatus',
          searchable: false, orderable: false,
          render: function (data, type, row) {
            return '<span class="badge rounded-pill bg-success">' + data + '</span>';
          }
        },
        { data: '' },
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
          // Pdf de pre-registro
          targets: 11,
          className: 'text-center',
          searchable: false, orderable: false,
          render: function (data, type, full, meta) {
            var $id = full['id_guia'];
            return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="${full['id_predio']}" data-registro="${full['id_empresa']} "></i>`;
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
              '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              `<a data-id="${full['id_predio']}" data-bs-toggle="modal" data-bs-target="#modalAddPredioInspeccion" class="dropdown-item inspeccion-record waves-effect text-primary"><i class="ri-add-circle-line ri-20px text-primary"></i> Registrar inspección</a>` +
              `<a data-id="${full['id_predio']}" data-bs-toggle="modal" data-bs-target="#modalEditPredio" class="dropdown-item edit-record waves-effect text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>` +
              `<a data-id="${full['id_predio']}" class="dropdown-item delete-record waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>` +
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
              title: 'Predios',
              text: '<i class="ri-printer-line me-1" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {

                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        if (item.lastChild && item.lastChild.firstChild) {
                          result = result + item.lastChild.firstChild.textContent;
                        }
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else {
                        result = result + item.innerText;
                      }
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
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {

                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        if (item.lastChild && item.lastChild.firstChild) {
                          result = result + item.lastChild.firstChild.textContent;
                        }
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else {
                        result = result + item.innerText;
                      }

                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'excel',
              title: 'Predios',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        if (item.lastChild && item.lastChild.firstChild) {
                          result = result + item.lastChild.firstChild.textContent;
                        }
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else {
                        result = result + item.innerText;
                      }
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              title: 'Predios',
              text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        if (item.lastChild && item.lastChild.firstChild) {
                          result = result + item.lastChild.firstChild.textContent;
                        }
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else {
                        result = result + item.innerText;
                      }
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'copy',
              title: 'Predios',
              text: '<i class="ri-file-copy-line me-1"></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                // prevent avatar to be copy
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        if (item.lastChild && item.lastChild.firstChild) {
                          result = result + item.lastChild.firstChild.textContent;
                        }
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else {
                        result = result + item.innerText;
                      }
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

/* creacion seccion de plantacion */
$(document).ready(function () {
  // Definir los contenedores
  const containerAdd = '.contenidoPlantacion';           // Contenedor para agregar plantaciones
  const containerEdit = '.edit_ContenidoPlantacion';      // Contenedor para editar plantaciones
  const containerInspeccion = '.inspeccion_ContenidoPlantacion'; // Contenedor para inspección

  // Función para generar las opciones de tipos de agave
  function generateOptions(tipos) {
      return tipos.map(tipo => `<option value="${tipo.id_tipo}">${tipo.nombre}</option>`).join('');
  }

  // Función para agregar una nueva sección de plantación
  function addRow(container) {
      var options = generateOptions(tiposAgave); // Asumiendo que `tiposAgave` es un array con los tipos de agave
      var newSection = `
          <tr class="plantacion-row">
              <td rowspan="4">
                  <button type="button" class="btn btn-danger remove-row-plantacion"><i class="ri-delete-bin-5-fill"></i></button>
              </td>
              <td><b>Nombre y Especie de Agave/Maguey</b></td>
              <td>
                  <div class="form-floating form-floating-outline mb-3">
                      <select name="id_tipo[]" class="select2 form-select tipo_agave" required>
                          <option value="" disabled selected>Tipo de agave</option>
                          ${options}
                      </select>
                      <label for="especie_agave"></label>
                  </div>
              </td>
          </tr>
          <tr class="plantacion-row">
              <td><b>Número de Plantas</b></td>
              <td>
                  <div class="form-floating form-floating-outline">
                      <input type="number" class="form-control" name="numero_plantas[]" placeholder="Número de plantas" step="1" autocomplete="off" required>
                      <label for="numero_plantas">Número de Plantas</label>
                  </div>
              </td>
          </tr>
          <tr class="plantacion-row">
              <td><b>Edad de la Plantación</b></td>
              <td>
                  <div class="form-floating form-floating-outline">
                      <input type="number" class="form-control" name="edad_plantacion[]" placeholder="Edad de la plantación (años)" step="1" autocomplete="off" required>
                      <label for="edad_plantacion">Edad de la Plantación</label>
                  </div>
              </td>
          </tr>
          <tr class="plantacion-row">
              <td><b>Tipo de Plantación</b></td>
              <td>
                  <div class="form-floating form-floating-outline">
                      <input type="text" class="form-control" name="tipo_plantacion[]" placeholder="Tipo de plantación" autocomplete="off" required>
                      <label for="tipo_plantacion">Tipo de Plantación</label>
                  </div>
              </td>
          </tr>`;

      // Agregar la nueva sección al contenedor correspondiente (al final)
      $(container).append(newSection);

      // Inicializar Select2 en los nuevos campos
      $(container).find('.select2').select2();
      // Inicializar los elementos select2
      var select2Elements = $('.select2');
      initializeSelect2(select2Elements);

      // Añadir validación a los nuevos campos
      fv.addField('id_tipo[]', {
          validators: {
              notEmpty: {
                  message: 'Por favor selecciona el tipo de agave/maguey'
              }
          }
      });
      fv.addField('numero_plantas[]', {
          validators: {
              notEmpty: {
                  message: 'Por favor ingresa el número de plantas'
              },
              numeric: {
                  message: 'Por favor ingresa un valor numérico válido'
              }
          }
      });
      fv.addField('edad_plantacion[]', {
          validators: {
              notEmpty: {
                  message: 'Por favor ingresa la edad de la plantación'
              },
              numeric: {
                  message: 'Por favor ingresa un valor numérico válido'
              }
          }
      });
      fv.addField('tipo_plantacion[]', {
          validators: {
              notEmpty: {
                  message: 'Por favor ingresa el tipo de plantación'
              }
          }
      });

      // Habilitar el botón de eliminación para las nuevas filas
      if ($(container).find('.plantacion-row').length > 1) {
          $(container).find('.remove-row-plantacion').not(':first').prop('disabled', false);
      }

      // Revalidar el formulario completo para asegurar que todos los campos sean validados
      fv.validate();
  }

  // Evento para agregar filas de plantación (para agregar, editar e inspección)
  $('.add-row-plantacion').on('click', function () {
      // Determinar en qué sección estamos
      const isEdit = $(this).closest('.edit_InformacionAgave').length > 0;
      const isInspeccion = $(this).closest('.inspeccion_InformacionAgave').length > 0;

      let container = containerAdd; // Por defecto, usar contenedor de agregar
      if (isEdit) {
          container = containerEdit;
      } else if (isInspeccion) {
          container = containerInspeccion;
      }

      addRow(container);
  });

  // Evento para eliminar filas de plantación
  $(document).on('click', '.remove-row-plantacion', function () {
      var $currentRow = $(this).closest('tr');
      var container = $currentRow.closest('tbody');

      if ($currentRow.index() === 0) return; // No permitir eliminar la primera fila

      $currentRow.nextUntil('tr:not(.plantacion-row)').addBack().remove();

      // Deshabilitar el botón de eliminación si queda solo una fila
      if (container.find('.plantacion-row').length <= 1) {
          container.find('.remove-row-plantacion').prop('disabled', true);
      }

      // Revalidar el formulario después de eliminar
      fv.validate();
  });

  // Deshabilitar el botón de eliminación en la primera fila de cada contenedor
  $(containerAdd).find('.remove-row-plantacion').first().prop('disabled', true);
  $(containerEdit).find('.remove-row-plantacion').first().prop('disabled', true);
  $(containerInspeccion).find('.remove-row-plantacion').first().prop('disabled', true);
});


  // Definir fv en un alcance global
let fv;

$(document).ready(function () {
    const tieneCoordenadasSelect = document.getElementById('tiene_coordenadas');
    const coordenadasDiv = document.getElementById('coordenadas');
    const coordenadasBody = document.getElementById('coordenadas-body');
    const editCoordenadasBody = document.getElementById('coordenadas-body-edit');
    const inspeccionCoordenadasBody = document.getElementById('coordenadas-body-inspeccion');

    // Función para agregar una nueva fila de coordenadas
    function addCoordinateRow(body) {
        const newRow = `
            <tr>
                <td>
                    <button type="button" class="btn btn-danger remove-row-cordenadas"><i class="ri-delete-bin-5-fill"></i></button>
                </td>
                <td>
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" name="latitud[]" placeholder="Latitud" autocomplete="off" required>
                        <label>Latitud</label>
                    </div>
                </td>
                <td>
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" name="longitud[]" placeholder="Longitud" autocomplete="off" required>
                        <label>Longitud</label>
                    </div>
                </td>
            </tr>`;
        body.insertAdjacentHTML('beforeend', newRow);

        // Añadir validación a los nuevos campos
        fv.addField('latitud[]', {
            validators: {
                notEmpty: {
                    message: 'Por favor ingresa la latitud'
                },
                numeric: {
                    message: 'Por favor ingresa un valor numérico válido para la latitud'
                }
            }
        });
        fv.addField('longitud[]', {
            validators: {
                notEmpty: {
                    message: 'Por favor ingresa la longitud'
                },
                numeric: {
                    message: 'Por favor ingresa un valor numérico válido para la longitud'
                }
            }
        });

        updateRemoveButtonState(body);
    }

    // Función para eliminar una fila de coordenadas
    function removeCoordinateRow(button, body) {
        const $tableBody = $(button).closest('tbody');
        if ($tableBody.children('tr').length > 1) {
            $(button).closest('tr').remove();
        }
        updateRemoveButtonState(body);
    }

    // Función para actualizar el estado del botón de eliminar
    function updateRemoveButtonState(body) {
        $(body).find('tbody tr').each(function () {
            $(this).find('.remove-row-cordenadas').prop('disabled', $(this).siblings('tr').length === 0);
        });
    }

    // Inicializar el estado del botón de eliminar en todas las tablas al cargar la página
    updateRemoveButtonState(coordenadasBody);
    updateRemoveButtonState(editCoordenadasBody);
    updateRemoveButtonState(inspeccionCoordenadasBody);

    // Evento para cambiar la visibilidad de las coordenadas basado en la selección
    if (tieneCoordenadasSelect && coordenadasDiv) {
        tieneCoordenadasSelect.addEventListener('change', function () {
            if (tieneCoordenadasSelect.value === 'Si') {
                coordenadasDiv.classList.remove('d-none');
                if (coordenadasBody.children.length === 0) {
                    addCoordinateRow(coordenadasBody);
                }
            } else {
                coordenadasDiv.classList.add('d-none');
                coordenadasBody.innerHTML = ''; // Limpiar todos los campos
            }
        });
    }

    // Manejo de eventos para añadir y eliminar filas de coordenadas en la vista principal
    $(document).on('click', '.add-row-cordenadas', function () {
        addCoordinateRow(coordenadasBody);
    });

    $(document).on('click', '.remove-row-cordenadas', function () {
        removeCoordinateRow(this, coordenadasBody);
    });

    // Manejo de eventos para añadir y eliminar filas de coordenadas en el modal de edición
    $(document).on('click', '.add-row-cordenadas-edit', function () {
        addCoordinateRow(editCoordenadasBody);
    });

    $(document).on('click', '.remove-row-cordenadas', function () {
        removeCoordinateRow(this, editCoordenadasBody);
    });

    // Manejo de eventos para añadir y eliminar filas de coordenadas en la sección de inspección
    $(document).on('click', '.add-row-cordenadas-inspeccion', function () {
        addCoordinateRow(inspeccionCoordenadasBody);
    });

    $(document).on('click', '.remove-row-cordenadas', function () {
        removeCoordinateRow(this, inspeccionCoordenadasBody);
    });
});



  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const addNewPredio = document.getElementById('addNewPredioForm');
    fv = FormValidation.formValidation(addNewPredio, { // Usa la variable fv global
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona la empresa cliente'
            }
          }
        },
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
        puntos_referencia: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa los puntos de referencia'
            }
          }
        },
        ubicacion_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la ubicación del predio'
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
        },
        tiene_coordenadas: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona si el predio cuenta con coordenadas'
            }
          }
        },
        url: {
          validators: {
            notEmpty: {
              message: 'Por favor adjunta el documento requerido'
            },
            file: {
              extension: 'pdf', // Solo permite archivos PDF
              type: 'application/pdf', // Tipo MIME para archivos PDF
              maxSize: 2097152, // Tamaño máximo de 2MB (2 * 1024 * 1024 bytes)
              message: 'El archivo debe ser un PDF y no debe superar los 2MB'
            }
          }
        },
        'id_tipo[]': {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el tipo de agave/maguey'
            }
          }
        },
        'numero_plantas[]': {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa el número de plantas'
            },
            numeric: {
              message: 'Por favor ingresa un valor numérico válido'
            }
          }
        },
        'edad_plantacion[]': {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la edad de la plantación'
            },
            numeric: {
              message: 'Por favor ingresa un valor numérico válido'
            }
          }
        },
        'tipo_plantacion[]': {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa el tipo de plantación'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: function (field, ele) {
            return '.form-floating';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    });

    // Manejo del envío del formulario
    fv.on('core.form.valid', function (e) {
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
          // Limpiar el contenido del modal (si es necesario)
          limpiarModal();
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

    // Inicializar select2 y revalidar el campo cuando cambie
    $('#id_empresa, .tipo_agave').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });
  });


  function limpiarModal() {
    // Aquí puedes añadir cualquier lógica necesaria para resetear el contenido del modal
    $('#modalAddPredio .plantacion-row').remove();
    $('#modalAddPredio #coordenadas tbody tr').remove();
    // Reiniciar select2 si es necesario
    $('.select2').val('').trigger('change');
    // Reiniciar otros elementos o plugins que uses dentro del modal
  }



  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const addEditPredioForm = document.getElementById('addEditPredioForm');
    const fv = FormValidation.formValidation(addEditPredioForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona la empresa cliente'
            }
          }
        },
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
        puntos_referencia: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa los puntos de referencia'
            }
          }
        },
        ubicacion_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la ubicación del predio'
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
        },
        tiene_coordenadas: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona si el predio cuenta con coordenadas'
            }
          }
        },
        url: {
          validators: {
            notEmpty: {
              message: 'Por favor adjunta el documento requerido'
            },
            file: {
              extension: 'pdf', // Solo permite archivos PDF
              type: 'application/pdf', // Tipo MIME para archivos PDF
              maxSize: 2097152, // Tamaño máximo de 2MB (2 * 1024 * 1024 bytes)
              message: 'El archivo debe ser un PDF y no debe superar los 2MB'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: function (field, ele) {
            return '.form-floating';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function (e) {
      var formData = new FormData(addEditPredioForm);
      var predioId = $('#edit_id_predio').val(); // Asegúrate de que este ID esté correctamente asignado

      $.ajax({
        url: '/domicilios-predios/' + predioId,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          addEditPredioForm.reset();
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
        error: function (xhr) {
          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            var errorMessages = Object.keys(errors).map(function (key) {
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

    // Manejar el clic en el botón de editar
    $(document).on('click', '.edit-record', function () {
      var predioId = $(this).data('id'); // Obtener el ID del predio a editar
      $('#edit_id_predio').val(predioId);

      // Solicitar los datos del predio desde el servidor
      $.ajax({
        url: '/domicilios-predios/' + predioId + '/edit',
        method: 'GET',
        success: function (data) {
          if (data.success) {
            var predio = data.predio;

            // Rellenar el formulario con los datos del predio
            $('#edit_id_empresa').val(predio.id_empresa).trigger('change');
            $('#edit_nombre_productor').val(predio.nombre_productor);
            $('#edit_nombre_predio').val(predio.nombre_predio);
            $('#edit_ubicacion_predio').val(predio.ubicacion_predio);
            $('#edit_tipo_predio').val(predio.tipo_predio);
            $('#edit_puntos_referencia').val(predio.puntos_referencia);
            $('#edit_tiene_coordenadas').val(predio.cuenta_con_coordenadas).trigger('change');
            $('#edit_superficie').val(predio.superficie);

            console.log(data.documentos); // Verifica el contenido

            if (Array.isArray(data.documentos)) {
              $('#archivo_url_contrato').empty(); // Limpia el contenido existente

              data.documentos.forEach(function (documento) {
                var nombre = documento.nombre; // Nombre del documento
                var url = documento.url; // URL del documento

                // Codificar la URL del archivo
                var urlCodificada = encodeURIComponent(url);

                // Construir la URL completa utilizando el numeroCliente
                var urlCompleta = '../files/' + data.numeroCliente + '/' + urlCodificada;

                // Agregar el enlace al documento en el div
                $('#archivo_url_contrato').append(`
                                    <a href="${urlCompleta}" target="_blank">${nombre}</a>
                                    <br>
                                `);
              });
            } else {
              console.error('data.documentos no es un array:', data.documentos);
            }

            // Limpiar las filas de coordenadas anteriores
            $('#edit_coordenadas tbody').empty();

            // Rellenar coordenadas o añadir una fila vacía si no hay coordenadas
            if (predio.cuenta_con_coordenadas === 'Si' && data.coordenadas.length > 0) {
              data.coordenadas.forEach(function (coordenada) {
                var newRow = `
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger remove-row-cordenadas"><i class="ri-delete-bin-5-fill"></i></button>
                            </td>
                            <td>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="latitud[]" value="${coordenada.latitud}" placeholder="Latitud" autocomplete="off">
                                    <label for="latitud">Latitud</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="longitud[]" value="${coordenada.longitud}" placeholder="Longitud" autocomplete="off">
                                    <label for="longitud">Longitud</label>
                                </div>
                            </td>
                        </tr>`;
                $('#edit_coordenadas tbody').append(newRow);
              });
            } else {
              var emptyRow = `
                    <tr>
                        <td>
                            <button type="button" class="btn btn-danger remove-row-cordenadas"><i class="ri-delete-bin-5-fill"></i></button>
                        </td>
                        <td>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="latitud[]" placeholder="Latitud">
                                <label for="latitud">Latitud</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="longitud[]" placeholder="Longitud">
                                <label for="longitud">Longitud</label>
                            </div>
                        </td>
                    </tr>`;
              $('#edit_coordenadas tbody').append(emptyRow);
            }

            // Mostrar u ocultar la sección de coordenadas basado en la presencia de coordenadas
            if (predio.cuenta_con_coordenadas === 'Si' && data.coordenadas.length > 0) {
              $('#edit_coordenadas').removeClass('d-none');
            } else {
              $('#edit_coordenadas').addClass('d-none');
            }

            // Limpiar las filas de plantaciones anteriores
            $('.edit_ContenidoPlantacion').empty();

            // Cargar tipos de agave en el select
            var tipoOptions = data.tipos.map(function (tipo) {
              return `<option value="${tipo.id_tipo}">${tipo.nombre}</option>`;
            }).join('');

            // Rellenar plantaciones o añadir una fila vacía si no hay plantaciones
            if (data.plantaciones.length > 0) {
              data.plantaciones.forEach(function (plantacion) {
                var newRow = `
                                <tr class="plantacion-row">
                                    <td rowspan="4">
                                        <button type="button" class="btn btn-danger remove-row-plantacion"><i class="ri-delete-bin-5-fill"></i></button>
                                    </td>
                                    <td><b>Nombre y Especie de Agave/Maguey</b></td>
                                    <td>
                                        <div class="form-floating form-floating-outline mb-3">
                                            <select name="id_tipo[]" class="select2 form-select tipo_agave">
                                                <option disabled>Tipo de agave</option>
                                                ${tipoOptions}
                                            </select>
                                            <label for="especie_agave"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="plantacion-row">
                                    <td><b>Número de Plantas</b></td>
                                    <td>
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" name="numero_plantas[]" value="${plantacion.num_plantas}" placeholder="Número de plantas" step="1" autocomplete="off">
                                            <label for="numero_plantas">Número de Plantas</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="plantacion-row">
                                    <td><b>Edad de la Plantación</b></td>
                                    <td>
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" name="edad_plantacion[]" value="${plantacion.anio_plantacion}" placeholder="Edad de la plantación (años)" step="1" autocomplete="off">
                                            <label for="edad_plantacion">Edad de la Plantación</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="plantacion-row">
                                    <td><b>Tipo de Plantación</b></td>
                                    <td>
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" name="tipo_plantacion[]" value="${plantacion.tipo_plantacion}" placeholder="Tipo de plantación" autocomplete="off">
                                            <label for="tipo_plantacion">Tipo de Plantación</label>
                                        </div>
                                    </td>
                                </tr>`;
                $('.edit_ContenidoPlantacion').append(newRow);
                // Seleccionar el tipo de agave actual
                $('.edit_ContenidoPlantacion').find('select[name="id_tipo[]"]').last().val(plantacion.id_tipo);
              });
              // Inicializar los elementos select2
              var select2Elements = $('.select2');
              initializeSelect2(select2Elements);
            } else {
              var emptyRow = `
                            <tr>
                                <td rowspan="4">
                                    <button type="button" class="btn btn-danger remove-row-plantacion"><i class="ri-delete-bin-5-fill"></i></button>
                                </td>
                                <td><b>Nombre y Especie de Agave/Maguey</b></td>
                                <td>
                                    <div class="form-floating form-floating-outline mb-3">
                                        <select name="id_tipo[]" class="select2 form-select tipo_agave">
                                            <option value="" disabled>Tipo de agave</option>
                                            ${tipoOptions}
                                        </select>
                                        <label for="especie_agave"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Número de Plantas</b></td>
                                <td>
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control" name="numero_plantas[]" placeholder="Número de plantas" step="1">
                                        <label for="numero_plantas">Número de Plantas</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Edad de la Plantación</b></td>
                                <td>
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control" name="edad_plantacion[]" placeholder="Edad de la plantación (años)" step="1">
                                        <label for="edad_plantacion">Edad de la Plantación</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Tipo de Plantación</b></td>
                                <td>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="tipo_plantacion[]" placeholder="Tipo de plantación">
                                        <label for="tipo_plantacion">Tipo de Plantación</label>
                                    </div>
                                </td>
                            </tr>`;
              $('.edit_ContenidoPlantacion').append(emptyRow);
            }

            // Mostrar el modal
            $('#modalEditPredio').modal('show');

            // Aplicar validaciones a las coordenadas dinámicas
            $('#edit_coordenadas input').each(function () {
              fv.addField($(this).attr('name'), {
                validators: {
                  notEmpty: {
                    message: 'Este campo es requerido'
                  },
                  numeric: {
                    message: 'Por favor ingresa un valor numérico válido'
                  }
                }
              });
            });

            // Aplicar validaciones a las plantaciones dinámicas
            $('.edit_ContenidoPlantacion input').each(function () {
              fv.addField($(this).attr('name'), {
                validators: {
                  notEmpty: {
                    message: 'Este campo es requerido'
                  },
                  numeric: {
                    message: 'Por favor ingresa un valor numérico válido'
                  }
                }
              });
            });
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
  });


  //Reciben los datos del pdf
  $(document).on('click', '.pdf', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var iframe = $('#pdfViewer');
    iframe.attr('src', '../pre-registro_predios/' + id);

    $("#titulo_modal").text("Pre-registro de predios de maguey o agave");
    $("#subtitulo_modal").text(registro);
  });

    $(document).ready(function () {
      // Función para agregar una nueva fila de características
      function addRow() {
          const newRow = `
              <tr class="caracteristicas-row">
                  <td rowspan="5">
                      <button type="button" class="btn btn-danger remove-row-caracteristicas"><i class="ri-delete-bin-5-fill"></i></button>
                  </td>
              </tr>
              <tr class="caracteristicas-row">
                  <td>No. planta</td>
                  <td><input type="number" class="form-control" name="no_planta[]" placeholder="Número de planta" required></td>
              </tr>
              <tr class="caracteristicas-row">
                  <td>Altura (m)</td>
                  <td><input type="number" step="0.01" class="form-control" name="altura[]" placeholder="Altura (m)" required></td>
              </tr>
              <tr class="caracteristicas-row">
                  <td>Diámetro (m)</td>
                  <td><input type="number" step="0.01" class="form-control" name="diametro[]" placeholder="Diámetro (m)" required></td>
              </tr>
              <tr class="caracteristicas-row">
                  <td>Número de hojas</td>
                  <td><input type="number" class="form-control" name="numero_hojas[]" placeholder="Número de hojas" required></td>
              </tr>`;

          $('#plant-table tbody').append(newRow);

          // Añadir validación a los nuevos campos
          addValidationFields();

          // Habilitar el botón de eliminar si hay más de una fila
          if ($('#plant-table tbody .caracteristicas-row').length > 1) {
              $('#plant-table .remove-row-caracteristicas').not(':first').prop('disabled', false);
          }
      }

      // Función para agregar validaciones a los campos de características
      function addValidationFields() {
          // Validación para No. planta
          fv.addField('no_planta[]', {
              validators: {
                  notEmpty: {
                      message: 'Por favor ingresa el número de planta'
                  },
                  integer: {
                      message: 'Por favor ingresa un número entero válido para el número de planta'
                  }
              }
          });

          // Validación para Altura
          fv.addField('altura[]', {
              validators: {
                  notEmpty: {
                      message: 'Por favor ingresa la altura'
                  },
                  numeric: {
                      message: 'Por favor ingresa un valor numérico válido para la altura'
                  },
                  greaterThan: {
                      value: 0,
                      message: 'La altura debe ser un número mayor que 0'
                  }
              }
          });

          // Validación para Diámetro
          fv.addField('diametro[]', {
              validators: {
                  notEmpty: {
                      message: 'Por favor ingresa el diámetro'
                  },
                  numeric: {
                      message: 'Por favor ingresa un valor numérico válido para el diámetro'
                  },
                  greaterThan: {
                      value: 0,
                      message: 'El diámetro debe ser un número mayor que 0'
                  }
              }
          });

          // Validación para Número de hojas
          fv.addField('numero_hojas[]', {
              validators: {
                  notEmpty: {
                      message: 'Por favor ingresa el número de hojas'
                  },
                  integer: {
                      message: 'Por favor ingresa un número entero válido para el número de hojas'
                  },
                  greaterThan: {
                      value: 0,
                      message: 'El número de hojas debe ser un número mayor que 0'
                  }
              }
          });
      }

      // Evento para agregar filas
      $('.add-row-caracteristicas').on('click', function () {
          addRow();
      });

      // Evento para eliminar filas
      $(document).on('click', '.remove-row-caracteristicas', function () {
          const $currentRow = $(this).closest('tr');
          if ($currentRow.index() === 0) return; // No permitir eliminar la primera fila

          $currentRow.nextUntil('tr:not(.caracteristicas-row)').addBack().remove();

          // Deshabilitar el botón de eliminación si queda solo una fila
          if ($('#plant-table tbody .caracteristicas-row').length <= 1) {
              $('#plant-table .remove-row-caracteristicas').prop('disabled', true);
          }
      });

      // Deshabilitar el botón de eliminación en la primera fila
      $('#plant-table .remove-row-caracteristicas').first().prop('disabled', true);
  });


  /* seccion para la inserccion de los datos de los predios inspecciones */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const addAddPredioInspeccionForm = document.getElementById('addAddPredioInspeccionForm');
    const fv = FormValidation.formValidation(addAddPredioInspeccionForm, {
      fields: {
        no_orden_servicio:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número del servicio'
            }
          }
        },
        no_cliente:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número del cliente'
            }
          }
        },
        id_empresa:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el nombre del cliente'
            }
          }
        },
        id_tipo_agave:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el tipo de agave'
            }
          }
        },
        domicilio_fiscal:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el domicilio fiscal'
            }
          }
        },
        telefono: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el teléfono'
            },
            regexp: {
              regexp: /^[0-9]{10}$/, // Aquí puedes ajustar la cantidad de dígitos que necesitas
              message: 'Por favor ingrese un número de teléfono válido de 10 dígitos'
            },
            stringLength: {
              min: 10,
              max: 10,
              message: 'El teléfono debe tener exactamente 10 dígitos'
            }
          }
        },
        ubicacion_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la ubicación del predio'
            }
          }
        },
        fecha_inspeccion:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de inspección'
            }
          }
        },
        localidad:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la localidad'
            }
          }
        },
        distrito:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el distrito'
            }
          }
        },
        municipio:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el municipio'
            }
          }
        },
        estado:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el estado'
            }
          }
        },
        nombre_paraje:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el nombre del paraje'
            }
          }
        },
        zona_dom:{
          validators: {
            notEmpty: {
              message: 'Por favor selecciona la opción'
            }
          }
        },
        id_tipo_maguey:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el tipo de maguey'
            }
          }
        },
        marco_plantacion:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el '
            }
          }
        },
        distancia_surcos:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese '
            }
          }
        },
        distancia_plantas:{
          validators: {
            notEmpty: {
              message: 'Por favor ingrese'
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
        },
        tiene_coordenadas: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona si el predio cuenta con coordenadas'
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: function (field, ele) {
            return '.form-floating';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function (e) {
      var formData = new FormData(addAddPredioInspeccionForm);
      var predioId = $('#inspeccion_id_predio').val(); // Asegúrate de que este ID esté correctamente asignado

      $.ajax({
        url: '/domicilios-predios/' + predioId + '/inspeccion',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          addAddPredioInspeccionForm.reset();
          $('#modalAddPredioInspeccion').modal('hide');
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

    // Manejar el clic en el botón de editar
    $(document).on('click', '.inspeccion-record', function () {
      var predioId = $(this).data('id'); // Obtener el ID del predio a editar
      $('#inspeccion_id_predio').val(predioId);

      // Solicitar los datos del predio desde el servidor
      $.ajax({
        url: '/domicilios-predios/' + predioId + '/edit',
        method: 'GET',
        success: function (data) {
          if (data.success) {
            var predio = data.predio;
            console.log(data)

            // Rellenar el formulario con los datos del predio
            $('#inspeccion_id_empresa').val(predio.id_empresa).trigger('change');
            $('#inspeccion_ubicacion_predio').val(predio.ubicacion_predio);
            $('#inspeccion_tiene_coordenadas').val(predio.cuenta_con_coordenadas);
            $('#inspeccion_superficie').val(predio.superficie);
            // Limpiar las filas de coordenadas anteriores
            $('#coordenadas-body-inspeccion').empty();
            // Rellenar coordenadas o añadir una fila vacía si no hay coordenadas
            if (predio.cuenta_con_coordenadas === 'Si' && data.coordenadas.length > 0) {
              data.coordenadas.forEach(function (coordenada) {
                var newRow = `
                      <tr>
                          <td>
                              <button type="button" class="btn btn-danger remove-row-cordenadas"><i class="ri-delete-bin-5-fill"></i></button>
                          </td>
                          <td>
                              <div class="form-floating form-floating-outline">
                                  <input type="text" class="form-control" name="latitud[]" value="${coordenada.latitud}" placeholder="Latitud" autocomplete="off">
                                  <label for="latitud">Latitud</label>
                              </div>
                          </td>
                          <td>
                              <div class="form-floating form-floating-outline">
                                  <input type="text" class="form-control" name="longitud[]" value="${coordenada.longitud}" placeholder="Longitud" autocomplete="off">
                                  <label for="longitud">Longitud</label>
                              </div>
                          </td>
                      </tr>`;
                $('#coordenadas-body-inspeccion').append(newRow);
              });
            } else {
              var emptyRow = `
                  <tr>
                      <td>
                          <button type="button" class="btn btn-danger remove-row-cordenadas"><i class="ri-delete-bin-5-fill"></i></button>
                      </td>
                      <td>
                          <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" name="latitud[]" placeholder="Latitud">
                              <label for="latitud">Latitud</label>
                          </div>
                      </td>
                      <td>
                          <div class="form-floating form-floating-outline">
                              <input type="text" class="form-control" name="longitud[]" placeholder="Longitud">
                              <label for="longitud">Longitud</label>
                          </div>
                      </td>
                  </tr>`;
              $('#inspeccion_coordenadas tbody').append(emptyRow);
            }

            // Mostrar u ocultar la sección de coordenadas basado en la presencia de coordenadas
            if (predio.cuenta_con_coordenadas === 'Si' && data.coordenadas.length > 0) {
              $('#inspeccion_coordenadas').removeClass('d-none');
            } else {
              $('#inspeccion_coordenadas').addClass('d-none');
            }

            // Limpiar las filas de plantaciones anteriores
            $('.inspeccion_ContenidoPlantacion').empty();

            // Cargar tipos de agave en el select
            var tipoOptions = data.tipos.map(function (tipo) {
              return `<option value="${tipo.id_tipo}">${tipo.nombre}</option>`;
            }).join('');

            // Rellenar plantaciones o añadir una fila vacía si no hay plantaciones
            if (data.plantaciones.length > 0) {
              data.plantaciones.forEach(function (plantacion) {
                var newRow = `
                              <tr class="plantacion-row">
                                  <td rowspan="4">
                                      <button type="button" class="btn btn-danger remove-row-plantacion"><i class="ri-delete-bin-5-fill"></i></button>
                                  </td>
                                  <td><b>Nombre y Especie de Agave/Maguey</b></td>
                                  <td>
                                      <div class="form-floating form-floating-outline mb-3">
                                          <select name="id_tipo[]" class="select2 form-select tipo_agave">
                                              <option disabled>Tipo de agave</option>
                                              ${tipoOptions}
                                          </select>
                                          <label for="especie_agave"></label>
                                      </div>
                                  </td>
                              </tr>
                              <tr class="plantacion-row">
                                  <td><b>Número de Plantas</b></td>
                                  <td>
                                      <div class="form-floating form-floating-outline">
                                          <input type="number" class="form-control" name="numero_plantas[]" value="${plantacion.num_plantas}" placeholder="Número de plantas" step="1" autocomplete="off">
                                          <label for="numero_plantas">Número de Plantas</label>
                                      </div>
                                  </td>
                              </tr>
                              <tr class="plantacion-row">
                                  <td><b>Edad de la Plantación</b></td>
                                  <td>
                                      <div class="form-floating form-floating-outline">
                                          <input type="number" class="form-control" name="edad_plantacion[]" value="${plantacion.anio_plantacion}" placeholder="Edad de la plantación (años)" step="1" autocomplete="off">
                                          <label for="edad_plantacion">Edad de la Plantación</label>
                                      </div>
                                  </td>
                              </tr>
                              <tr class="plantacion-row">
                                  <td><b>Tipo de Plantación</b></td>
                                  <td>
                                      <div class="form-floating form-floating-outline">
                                          <input type="text" class="form-control" name="tipo_plantacion[]" value="${plantacion.tipo_plantacion}" placeholder="Tipo de plantación" autocomplete="off">
                                          <label for="tipo_plantacion">Tipo de Plantación</label>
                                      </div>
                                  </td>
                              </tr>`;
                $('.inspeccion_ContenidoPlantacion').append(newRow);
                // Seleccionar el tipo de agave actual
                $('.inspeccion_ContenidoPlantacion').find('select[name="id_tipo[]"]').last().val(plantacion.id_tipo);
              });
              // Inicializar los elementos select2
              var select2Elements = $('.select2');
              initializeSelect2(select2Elements);
            } else {
              var emptyRow = `
                          <tr>
                              <td rowspan="4">
                                  <button type="button" class="btn btn-danger remove-row-plantacion"><i class="ri-delete-bin-5-fill"></i></button>
                              </td>
                              <td><b>Nombre y Especie de Agave/Maguey</b></td>
                              <td>
                                  <div class="form-floating form-floating-outline mb-3">
                                      <select name="id_tipo[]" class="select2 form-select tipo_agave">
                                          <option value="" disabled>Tipo de agave</option>
                                          ${tipoOptions}
                                      </select>
                                      <label for="especie_agave"></label>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><b>Número de Plantas</b></td>
                              <td>
                                  <div class="form-floating form-floating-outline">
                                      <input type="number" class="form-control" name="numero_plantas[]" placeholder="Número de plantas" step="1">
                                      <label for="numero_plantas">Número de Plantas</label>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><b>Edad de la Plantación</b></td>
                              <td>
                                  <div class="form-floating form-floating-outline">
                                      <input type="number" class="form-control" name="edad_plantacion[]" placeholder="Edad de la plantación (años)" step="1">
                                      <label for="edad_plantacion">Edad de la Plantación</label>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><b>Tipo de Plantación</b></td>
                              <td>
                                  <div class="form-floating form-floating-outline">
                                      <input type="text" class="form-control" name="tipo_plantacion[]" placeholder="Tipo de plantación">
                                      <label for="tipo_plantacion">Tipo de Plantación</label>
                                  </div>
                              </td>
                          </tr>`;
              $('.inspeccion_ContenidoPlantacion').append(emptyRow);
            }

            // Mostrar el modal
            $('#modalAddPredioInspeccion').modal('show');

            // Aplicar validaciones a las coordenadas dinámicas
            $('#edit_coordenadas input').each(function () {
              fv.addField($(this).attr('name'), {
                validators: {
                  notEmpty: {
                    message: 'Este campo es requerido'
                  },
                  numeric: {
                    message: 'Por favor ingresa un valor numérico válido'
                  }
                }
              });
            });

            // Aplicar validaciones a las plantaciones dinámicas
            $('.inspeccion_ContenidoPlantacion input').each(function () {
              fv.addField($(this).attr('name'), {
                validators: {
                  notEmpty: {
                    message: 'Este campo es requerido'
                  },
                  numeric: {
                    message: 'Por favor ingresa un valor numérico válido'
                  }
                }
              });
            });
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
              // Inicializar select2 y revalidar el campo cuando cambie
              $('#fecha_inspeccion, #tipoMaguey, #inspeccion_id_empresa, #tipoAgave, #estado').on('change', function () {
                fv.revalidateField($(this).attr('name'));
              });
  });


});
