/**
 * Page User List
 */
'use strict';
// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2 = $('.select2'),
    offCanvasForm = $('#offcanvasAddUser');

  $(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es'
    });
  });

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
        url: baseUrl + 'bitacoraProcesoElaboracion-list'
      },
      columns: [
        { data: '' }, // Responsive control
        { data: 'fake_id', title: '#' },
        { data: 'fecha_ingreso', title: 'Fecha ingreso' },
        { data: 'nombre_cliente', title: 'Cliente' },
        { data: 'numero_tapada', title: 'N° tapada' },
        { data: 'lote_granel', title: 'Lote granel' },
        { data: 'numero_guia', title: 'N° guía' },
        { data: 'tipo_maguey', title: 'Tipo maguey' },
        { data: 'numero_pinas', title: 'N° piñas' },
        { data: 'kg_maguey', title: 'Kg maguey' },
        { data: 'observaciones', title: 'Observaciones' },
        { data: 'action', title: 'Acciones' }
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
          // Actions botones de eliminar y actualizar(editar)
          targets: -1,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
                let acciones = '';
            if (window.puedeFirmarElUsuario) {
              acciones += `<a data-id="${full['id']}" class="dropdown-item firma-record waves-effect text-warning"> <i class="ri-ball-pen-line ri-20px text-warning"></i> Firmar bitácora</a>`;
            }
            if (window.puedeEditarElUsuario) {
              acciones += `<a data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#EditBitacora" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar bitácora</a>`;
            }
            if (window.puedeEliminarElUsuario) {
              acciones += `<a data-id="${full['id']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar bitácora</a>`;
            }
            // Si no hay acciones, no retornar el dropdown
            if (!acciones.trim()) {
              return `
                <button class="btn btn-sm btn-secondary" disabled>
                  <i class="ri-lock-2-line ri-20px me-1"></i> Opciones
                </button>
              `;
            }
            // Si hay acciones, construir el dropdown
            const dropdown = `<div class="d-flex align-items-center gap-50">
              <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button><div class="dropdown-menu dropdown-menu-end m-0">

                  ${acciones}
                </div>
              </div>
            `;
            return dropdown;
          }
        }
      ],
      order: [[2, 'desc']],
      dom:
        '<"card-header d-flex rounded-0 flex-wrap pb-md-0 pt-0"' +
        '<"me-5 ms-n2"f>' + // input de búsqueda
        '<"d-flex justify-content-start justify-content-md-end align-items-baseline"' +
        '<"filtrosBitacora d-flex gap-2 align-items-center" >' + // filtros personalizados
        '<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center gap-4"lB>' + // botones y length
        '>>' +
        't' + // tabla
        '<"row mx-1"' +
        '<"col-sm-12 col-md-6"i>' + // info
        '<"col-sm-12 col-md-6"p>' + // paginación
        '>',
      lengthMenu: [10, 20, 50, 70, 100], //for length of menu
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Buscar',
        info: 'Mostrar _START_ a _END_ de _TOTAL_ registros',
        emptyTable: 'No hay datos disponibles en la tabla',
        paginate: {
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior'
        }
      },

      // Buttons with Dropdown
      buttons: [
        {
          className: 'dt-custom-select p-0 me-2 btn-outline-dark form-select-sm',
          text: '',
          init: function (api, node) {
            $(node).removeClass('btn btn-secondary');

            // Decide si agregar opción 'Todas las Empresas' según tipoUsuario
            const agregarTodas = window.tipoUsuario !== 3;

            const htmlOpciones = agregarTodas
              ? `<option value="">-- Todas las Empresas --</option>${opcionesEmpresas}`
              : opcionesEmpresas;

            $(node).html(`
                      <select id="filtroEmpresa" class="form-select select2" style="min-width: 280px;">
                        ${htmlOpciones}
                      </select>
                    `);

            $(node).find('select').select2();
          }
        },
        {
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar Bitácora</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#RegistrarBitacora'
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data[''];
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
      },
      initComplete: function () {
        // Mover los selects desde los botones a la zona visible "filtrosBitacora"
        var $botonesFiltros = $('.dt-buttons .dt-custom-select');
        var $contenedorFiltros = $('.filtrosBitacora');
        $botonesFiltros.appendTo($contenedorFiltros);
        // Re-inicializar Select2 para que no se corte el dropdown, usando dropdownParent en body
        $contenedorFiltros.find('select.select2').select2({
          dropdownParent: $(document.body)
        });
        // Opcional: recargar tabla al cambiar filtros
        $('#filtroEmpresa').on('change', function () {
          dt_user.ajax.reload();
        });
      }
    });
  }

  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      select2Focus($this);

      var parent = $this.closest('.modal'); // Detecta si está en modal
      if (parent.length === 0) parent = $('body');

      $this.select2({
        dropdownParent: parent
      });
    });
  }

  // Después de insertar el HTML dinámico
  initializeSelect2($('.select2')); // Re-evalúa todos los .select2 del DOM

  $(document).on('select2:select', '#filtroEmpresa', function (e) {
    const selectedText = $(this).find('option:selected').text();
    $('#filtroEmpresa').next('.select2-container').find('.select2-selection__rendered').attr('title', selectedText);
  });

  //FUNCIONES DEL FUNCIONAMIENTO DEL CRUD//
  $(document).on('click', '#verBitacoraBtn', function () {
    const empresaId = $('#filtroEmpresa').val();

    if (!empresaId) {
      Swal.fire({
        icon: 'warning',
        title: 'Selecciona una empresa',
        text: 'Debes elegir una empresa para ver su bitácora',
        confirmButtonText: 'Aceptar',
        customClass: {
          confirmButton: 'btn btn-warning'
        }
      });
      return;
    }

    let urlPDF = `/bitacoraProcesoElabPDF?empresa=${empresaId}`;

    urlPDF += `&t=${new Date().getTime()}`;

    $('#cargando').show();
    $('#pdfViewer').hide().attr('src', '');
    $('#NewPestana').hide();

    // Hacer una solicitud previa para verificar si hay datos
    $.ajax({
      url: urlPDF,
      method: 'GET',
      xhrFields: { responseType: 'blob' }, // permite manejar el PDF o error
      success: function (data) {
        // Mostrar PDF en iframe
        const blobUrl = URL.createObjectURL(data);
        $('#pdfViewer').attr('src', blobUrl);
        $('#NewPestana').attr('href', blobUrl);
        $('#titulo_modal').text('Bitácora de control de hologramas de envasador');
        /* $('#subtitulo_modal').text('Versión Filtrada'); */
        $('#mostrarPdf').modal('show');

        $('#pdfViewer').on('load', function () {
          $('#cargando').hide();
          $(this).show();
        });
      },
      error: function (xhr) {
        $('#cargando').hide();
        Swal.fire({
          icon: 'info',
          title: 'Sin registros',
          text: xhr.responseJSON?.message || 'No hay datos para mostrar.',
          confirmButtonText: 'Aceptar',
          customClass: {
            confirmButton: 'btn btn-info'
          }
        });
      }
    });
  });

  /*     $('#pdfViewer').on('load', function () {
      $('#cargando').hide();
      $(this).show();
    }); */

      $(document).on('click', '.firma-record', function () {
    var id_bitacora_firma = $(this).data('id');
    var dtrModal = $('.dtr-bs-modal.show');

    // Ocultar modal responsivo en pantalla pequeña si está abierto
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // SweetAlert para confirmar la eliminación
    Swal.fire({
      title: '¿Deseas firmar esta bitácora?',
      /* text: 'No podrá revertir este evento', */
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, firmar',
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
          type: 'POST',
          url: `/FirmaProcesoElab/${id_bitacora_firma}`,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function () {
            dt_user.draw();
            Swal.fire({
              icon: 'success',
              title: '¡Firmado!',
              text: '¡Se ha firmado la bitácora!',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          },
          error: function (error) {
            let mensaje = 'Error desconocido del servidor.';
            let icono = 'error';
            let titulo = 'Error del servidor';
            // Si la respuesta viene como JSON con mensaje
            if (error.responseJSON && error.responseJSON.message) {
              mensaje = error.responseJSON.message;
              // Si es error por permisos
              if (error.status === 403) {
                icono = 'warning';
                titulo = 'Permiso denegado';
              }
              // Si es error de validación o petición mal formada
              else if (error.status === 400 || error.status === 422) {
                titulo = '¡A ocurrido un error!';
              }
            }
            Swal.fire({
              icon: icono,
              title: titulo,
              text: mensaje,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La firma de la bitácora ha sido cancelada',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    });
  });

  /*  */
  $(document).on('click', '.delete-record', function () {
    var id_bitacora = $(this).data('id');
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
          url: `${baseUrl}bitacoraProcesoElab-list/${id_bitacora}`,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function () {
            dt_user.draw();

            Swal.fire({
              icon: 'success',
              title: '¡Eliminado!',
              text: '¡La bitácora ha sido eliminada correctamente!',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          },
          error: function (error) {
            console.log(error);

            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo eliminar la bitácora. Inténtalo de nuevo más tarde.',
              footer: `<pre>${error.responseText}</pre>`,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La eliminación de la bitácora ha sido cancelada',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    });
  });

  $(function () {
    // Configuración de CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('registroInventarioForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el cliente'
            }
          }
        },
        fecha_ingreso: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de ingreso'
            }
          }
        },
        numero_tapada: {
          validators: {
            notEmpty: {
              message: 'Selecciona un número de tapada'
            }
          }
        },
        lote_granel: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el lote'
            }
          }
        },
        'id_tipo[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo de agave'
            }
          }
        },
        numero_guia: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de guía'
            }
          }
        },
        numero_pinas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de piñas'
            },
            numeric: {
              message: 'Debe ser un número'
            }
          }
        },
        kg_maguey: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese los kilogramos de maguey'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        },
        porcentaje_azucar: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el porcentaje de azúcar'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        },
        kg_coccion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese los kilogramos a cocción'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        },
        fecha_inicio_coccion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha inicial de cocción'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'El formato debe ser aaaa-mm-dd'
            }
          }
        },
        fecha_fin_coccion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha final de cocción'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'El formato debe ser aaaa-mm-dd'
            }
          }
        },
        volumen_total_formulado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen total formulado'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        },
        puntas_alcohol: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el porcentaje de alcohol en puntas'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        },
        puntas_volumen: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen de puntas'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        },
        mezcal_volumen: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen de mezcal'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        },
        mezcal_alcohol: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el porcentaje de alcohol en mezcal'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        },
        colas_volumen: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen de colas'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        },
        colas_alcohol: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el porcentaje de alcohol en colas'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          /* rowSelector: '.form-floating' */
          rowSelector: function (field, ele) {
            // field is the field name & ele is the field element
            return '.mb-4, .mb-1';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      $('#btnRegistrar').addClass('d-none');
      $('#loading').removeClass('d-none');
      var formData = $(form).serialize();

      $.ajax({
        url: '/bitacoraProcesoElabStore',
        type: 'POST',
        data: formData,
        success: function (response) {
          // Ocultar el offcanvas
          $('#RegistrarBitacora').modal('hide');
          $('#loading').addClass('d-none');
          $('#btnRegistrar').removeClass('d-none');
          $('#id_empresa').empty().trigger('change');
          $('#registroInventarioForm')[0].reset();
          $('#registroInventarioForm select').val(null).trigger('change');
          $('.datatables-users').DataTable().ajax.reload();
          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.success,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
          error: function (xhr) {
            let errorMsg = 'Error al agregar la bitácora';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
              // Construimos un string con todos los mensajes de error
              const errors = xhr.responseJSON.errors;
              errorMsg = Object.values(errors)
                .map(arr => arr.join(', ')) // cada campo puede tener múltiples errores
                .join('\n'); // separa errores por salto de línea
            }

            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              html: errorMsg.replace(/\n/g, '<br>'), // para que respete saltos de línea en HTML
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
            $('#loading').addClass('d-none');
            $('#btnRegistrar').removeClass('d-none');
          }
      });
    });

    // Inicializar select2 y revalidar el campo cuando cambie
    $('#id_empresa, #id_tipo, #fecha_ingreso, #fecha_fin_coccion, #fecha_inicio_coccion').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });

    /* $(document).ready(function () { */
    let indexMolienda = 1;

    $(document).on('click', '#agregarFilaMolienda', function () {
      let nuevaFila = `
            <tr>
                <td class="text-nowrap">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
                        <i class="ri-close-circle-fill"></i>
                    </button>
                </td>
                <td><input type="text" class="form-control datepicker" name="molienda[${indexMolienda}][fecha_molienda]" placeholder="aaaa-mm-dd"></td>
                <td><input type="text" class="form-control" name="molienda[${indexMolienda}][numero_tina]" placeholder="Nº de tina"></td>
                <td><input type="text" class="form-control datepicker" name="molienda[${indexMolienda}][fecha_formulacion]" placeholder="aaaa-mm-dd"></td>
                <td><input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][volumen_formulacion]" placeholder="Vol."></td>
                <td><input type="text" class="form-control datepicker" name="molienda[${indexMolienda}][fecha_destilacion]" placeholder="aaaa-mm-dd"></td>
                <td><input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][puntas_volumen]" placeholder="Vol."></td>
                <td><input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][puntas_alcohol]" placeholder="% Alc."></td>
                <td><input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][mezcal_volumen]" placeholder="Vol."></td>
                <td><input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][mezcal_alcohol]" placeholder="% Alc."></td>
                <td><input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][colas_volumen]" placeholder="Vol."></td>
                <td><input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][colas_alcohol]" placeholder="% Alc."></td>
            </tr>
        `;

      $('#tablaMolienda').append(nuevaFila);

      // Reinicializa datepicker en los nuevos campos si estás usando uno como flatpickr o bootstrap-datepicker
      $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true });

      indexMolienda++;
    });

    let indexSegundaDestilacion = 1;

    $(document).on('click', '#agregarFilaSegundaDestilacion', function () {
      let filaNueva = `
            <tr>
                <td class="text-nowrap">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
                        <i class="ri-close-circle-fill"></i>
                    </button>
                </td>
                <td>
                    <input type="text" class="form-control datepicker"
                        name="segunda_destilacion[${indexSegundaDestilacion}][fecha_destilacion]"
                        placeholder="aaaa-mm-dd">
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control"
                        name="segunda_destilacion[${indexSegundaDestilacion}][puntas_volumen]"
                        placeholder="Vol.">
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control"
                        name="segunda_destilacion[${indexSegundaDestilacion}][puntas_alcohol]"
                        placeholder="% Alc.">
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control"
                        name="segunda_destilacion[${indexSegundaDestilacion}][mezcal_volumen]"
                        placeholder="Vol.">
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control"
                        name="segunda_destilacion[${indexSegundaDestilacion}][mezcal_alcohol]"
                        placeholder="% Alc.">
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control"
                        name="segunda_destilacion[${indexSegundaDestilacion}][colas_volumen]"
                        placeholder="Vol.">
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control"
                        name="segunda_destilacion[${indexSegundaDestilacion}][colas_alcohol]"
                        placeholder="% Alc.">
                </td>
            </tr>
        `;

      $('#tablaSegundaDestilacion').append(filaNueva);

      // Reinicializa el datepicker si estás usando uno
      $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true });

      indexSegundaDestilacion++;
    });

    function calcularTotales() {
      // --- MOLIENDA: volumen_total_formulado ---
      let totalFormulacion = 0;
      $('[name^="molienda"][name$="[volumen_formulacion]"]').each(function () {
        const val = parseFloat($(this).val()) || 0;
        totalFormulacion += val;
      });
      $('#volumen_total_formulado').val(totalFormulacion.toFixed(2));

      // --- SEGUNDA DESTILACIÓN: Volúmenes ---
      let totalPuntas = 0,
        totalMezcal = 0,
        totalColas = 0;

      $('[name^="segunda_destilacion"][name$="[puntas_volumen]"]').each(function () {
        const val = parseFloat($(this).val()) || 0;
        totalPuntas += val;
      });

      $('[name^="segunda_destilacion"][name$="[mezcal_volumen]"]').each(function () {
        const val = parseFloat($(this).val()) || 0;
        totalMezcal += val;
      });

      $('[name^="segunda_destilacion"][name$="[colas_volumen]"]').each(function () {
        const val = parseFloat($(this).val()) || 0;
        totalColas += val;
      });

      $('#puntas_volumen').val(totalPuntas.toFixed(2));
      $('#mezcal_volumen').val(totalMezcal.toFixed(2));
      $('#colas_volumen').val(totalColas.toFixed(2));
    }

    // Trigger cada que cambie un input relevante
    $(document).on(
      'input',
      '[name^="molienda"][name$="[volumen_formulacion]"], \
                                [name^="segunda_destilacion"][name$="[puntas_volumen]"], \
                                [name^="segunda_destilacion"][name$="[mezcal_volumen]"], \
                                [name^="segunda_destilacion"][name$="[colas_volumen]"]',
      function () {
        calcularTotales();
        // Revalidar campos calculados
        fv.revalidateField('volumen_total_formulado');
        fv.revalidateField('puntas_volumen');
        fv.revalidateField('mezcal_volumen');
        fv.revalidateField('colas_volumen');

      }
    );

    // También cada que agregues fila nueva
    $('#agregarFilaMolienda, #agregarFilaSegundaDestilacion').on('click', function () {
      setTimeout(calcularTotales, 100); // Espera a que se agregue al DOM
    });
    /* }); */

    // Delegar evento para eliminar fila (funciona para elementos dinámicos)
    /*   $(document).on('click', '.btn-eliminar', function () {
    $(this).closest('.card').remove();
  }); */
  });


    $(document).on('click', '.edit-record', function () {
    var bitacoraID = $(this).data('id');
    $('#edit_bitacora_id').val(bitacoraID);
    $.ajax({
      url: '/bitacoraProcesoElab/' + bitacoraID + '/edit',
      method: 'GET',
      success: function (data) {
        if (data.success) {
          var bitacora = data.bitacora;
          $('#edit_bitacora_id').val(bitacora.id);
          $('#edit_id_empresa').val(bitacora.id_empresa).trigger('change');
          
          // MOLIENDA
          $('#tablaMoliendaEdit tbody').html(''); // limpiar antes
          bitacora.molienda.forEach((fila, index) => {
            agregarFilaMoliendaEdit(fila, index);
          });

          // SEGUNDA DESTILACIÓN
          $('#tablaSegundaDestilacionEdit tbody').html('');
          bitacora.segunda_destilacion.forEach((fila, index) => {
            agregarFilaSegundaDestilacionEdit(fila, index);
          });

          $('#EditBitacora').modal('show');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar los datos.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      },
      error: function (error) {
        console.error('Error al cargar los datos', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo cargar los datos.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });


/* bitacoras update */
    $(function () {
    // Configurar CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('EditInventarioForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona una empresa.'
            }
          }
        },
        id_lote_granel: {
          validators: {
            notEmpty: {
              message: 'Selecciona un lote a granel.'
            }
          }
        },
        tipo_operacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona un tipo de operación'
            }
          }
        },
        destino: {
          validators: {
            notEmpty: {
              message: 'Ingresa el destino.'
            }
          }
        },
        volumen_final: {
          validators: {
            notEmpty: {
              message: 'Ingresa el volumen final.'
            },
            numeric: {
              message: 'Debe ser un número.'
            }
          }
        },
        alc_vol_final: {
          validators: {
            notEmpty: {
              message: 'Ingresa el % Alc. Vol. final.'
            },
            numeric: {
              message: 'Debe ser un número decimal.'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: '.form-floating'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      $('#btnEdit').addClass('d-none');
      $('#loadingEdit').removeClass('d-none');
      const formData = $(form).serialize();
      const id = $('#edit_bitacora_id').val();

      $.ajax({
        url: '/bitacorasUpdate/' + id,
        type: 'POST',
        data: formData,
        success: function (response) {
          $('#loadingEdit').addClass('d-none');
          $('#btnEdit').removeClass('d-none');
          $('#EditBitacora').modal('hide');
          $('#EditBitacora')[0].reset();
          $('.datatables-users').DataTable().ajax.reload();
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.success || 'La bitácora fue actualizada correctamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al actualizar la bitácora.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  /* fin chelo */
});
