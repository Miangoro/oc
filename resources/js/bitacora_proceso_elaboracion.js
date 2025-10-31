/**
 * Page User List
 */
'use strict';
// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users');

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
        url: baseUrl + 'bitacoraProcesoElaboracion-list',
        data: function (d) {
          d.empresa = $('#filtroEmpresa').val();
          d.instalacion = $('#filtroInstalacion').val();
        }
      },
      columns: [
        { data: '' }, // Responsive control
        { data: 'fake_id', title: '#' },
        { data: 'fecha_ingreso', title: 'Fecha ingreso' },
        { data: 'instalacion' },
        { data: 'cliente', title: 'Cliente' },
        { data: 'numero_tapada', title: 'N° tapada' },
        { data: 'lote_granel', title: 'Lote granel' },
        { data: 'numero_guia', title: 'N° guía' },
        { data: 'id_tipo_maguey', title: 'Tipo maguey' },
        { data: 'numero_pinas', title: 'N° piñas' },
        { data: 'kg_maguey', title: 'Kg maguey' },
        { data: 'observaciones', title: 'Observaciones' },
        {
          data: 'bitacora',
          className: 'text-center',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return `<i class="ri-file-pdf-2-fill text-danger ri-48px verBitacoraBtn cursor-pointer"
                      data-id="${full['id']}" data-empresa="${full['cliente']}"
                      data-bs-toggle="modal" data-bs-target="#mostrarPdf"></i>`;
          }
        },
        {
          data: 'id_firmante',
          searchable: false,
          orderable: false,
          render: function (data, type, full) {
            if (!data) return `<span class="badge bg-warning rounded-pill">Sin firmar</span>`;

            try {
              const etapas = JSON.parse(data);

              // Validar que todos tengan un firmante distinto de 0
              const todasFirmadas = Object.values(etapas).every(e => e.id_firmante && e.id_firmante != 0);

              if (todasFirmadas) {
                return `<span class="badge bg-success rounded-pill">Firmado</span>`;
              } else {
                return `<span class="badge bg-warning rounded-pill">Sin firmar</span>`;
              }
            } catch {
              return `<span class="badge bg-secondary rounded-pill">Error</span>`;
            }
          }
        },
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
              acciones += `<a data-id="${full['id']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddFirma" class="dropdown-item firma-record waves-effect text-warning"> <i class="ri-ball-pen-line ri-20px text-warning"></i> Firmar bitácora</a>`;
            }
            if (window.puedeEditarElUsuario) {
              acciones += `<a data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#EditBitacora" class="dropdown-item edit-record waves-effect text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Editar bitácora</a>`;
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
      order: [[1, 'desc']],
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
                      <select id="filtroEmpresa" class="form-select select2" style="min-width: 300px;">
                        ${htmlOpciones}
                      </select>
                    `);

            $(node).find('select').select2();
          }
        },
        {
          className: 'dt-custom-select p-0 me-2 btn-outline-dark form-select-sm',
          text: '',
          init: function (api, node) {
            $(node).removeClass('btn btn-secondary');

            // Si usuario tipo 3 y tiene instalaciones, usar las precargadas
            let htmlOpciones =
              window.tipoUsuario === 3
                ? window.opcionesInstalacionesAutenticadas
                : '<option value="">-- Todas las Instalaciones --</option>';

            $(node).html(`
              <select id="filtroInstalacion" class="form-select select2" style="min-width: 280px;">
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
              return 'Detalles de la bitácora';
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
        $('#filtroEmpresa, #filtroInstalacion').on('change', function () {
          dt_user.ajax.reload();
        });
      }
    });
  }

  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);

      if ($this.hasClass('select2-hidden-accessible')) {
        $this.select2('destroy'); // reiniciar si ya está inicializado
      }
      // Detectar contenedor padre específico o general
      var $offcanvasFirma = $this.closest('#offcanvasAddFirma');
      var dropdownParent;
      if ($offcanvasFirma.length) {
        dropdownParent = $offcanvasFirma;
      } else {
        // Si no es offcanvasAddFirma, buscar otro offcanvas o modal
        var $modal = $this.closest('.modal');
        var $offcanvas = $this.closest('.offcanvas');

        if ($modal.length) {
          dropdownParent = $modal;
        } else if ($offcanvas.length) {
          dropdownParent = $offcanvas;
        } else {
          dropdownParent = $('body');
        }
      }

      $this.select2({
        dropdownParent: dropdownParent,
        width: '100%'
      });
    });
  }

  // Inicializa al cargar la página
  $(document).ready(function () {
    initializeSelect2($('.select2'));
  });

  /*
  initializeSelect2($('.select2'));
 */

  $(document).on('select2:select', '#filtroEmpresa', function (e) {
    const selectedText = $(this).find('option:selected').text();
    $('#filtroEmpresa').next('.select2-container').find('.select2-selection__rendered').attr('title', selectedText);
  });
  $('#filtroEmpresa, #filtroInstalacion').on('change', function () {
    $('.datatables-users').DataTable().ajax.reload();
  });
  $(document).ready(function () {
    function cargarInstalaciones() {
      // Si es usuario tipo 3, usar instalaciones precargadas
      if (window.tipoUsuario === 3) {
        $('#filtroInstalacion').html(window.opcionesInstalacionesAutenticadas).trigger('change');
        return;
      }

      let empresaId = $('#filtroEmpresa').val();
      if (!empresaId) {
        $('#filtroInstalacion').html('<option value="">-- Todas las Instalaciones --</option>');
        return;
      }

      $.ajax({
        url: '/getDatos/' + empresaId,
        method: 'GET',
        success: function (response) {
          let opciones = '<option value="">-- Todas las Instalaciones --</option>';
          if (response.instalaciones.length > 0) {
            response.instalaciones.forEach(function (inst) {
              let tipoLimpio = limpiarTipo(inst.tipo);
              opciones += `<option value="${inst.id_instalacion}">${tipoLimpio} | ${inst.direccion_completa}</option>`;
            });
          } else {
            opciones += '<option value="">Sin instalaciones registradas</option>';
          }
          $('#filtroInstalacion').html(opciones).trigger('change');
        },
        error: function () {
          $('#filtroInstalacion').html('<option value="">Error al cargar</option>');
        }
      });
    }

    cargarInstalaciones();
    $('#filtroEmpresa').on('change', cargarInstalaciones);
  });

  //FUNCIONES DEL FUNCIONAMIENTO DEL CRUD//
  /*   $(document).on('click', '.verBitacoraBtn', function () {
    const empresaId = $(this).data('empresa');
    const id = $(this).data('id');

    if (!empresaId) {
      Swal.fire({
        icon: 'warning',
        title: 'Empresa no válida',
        text: 'No se encontró la empresa asociada a esta fila.',
        confirmButtonText: 'Aceptar',
        customClass: {
          confirmButton: 'btn btn-warning'
        }
      });
      return;
    }
    let urlPDF = `/bitacoraProcesoElabPDF?empresa=${empresaId}`;
    if (id) {
      urlPDF += `&id=${id}`;
    }
    urlPDF += `&t=${new Date().getTime()}`; // evita caché
    $('#cargando').show();
    $('#pdfViewer').hide().attr('src', '');
    $('#NewPestana').hide();

    $.ajax({
      url: urlPDF,
      method: 'GET',
      xhrFields: { responseType: 'blob' },
      success: function (data) {
        const blobUrl = URL.createObjectURL(data);
        $('#pdfViewer').attr('src', blobUrl);
        $('#NewPestana').attr('href', blobUrl);
        $('#titulo_modal').text('BITÁCORA PROCESO DE ELABORACIÓN DE MEZCAL');
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
  }); */

  //FORMATO PFD PRE-REGISTRO DE PREDIOS
  $(document).on('click', '.verBitacoraBtn', function () {
    var id = $(this).data('id');
    var empresa = $(this).data('empresa');
    var pdfUrl = 'bitacoraProcesoElabPDF/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $('#NewPestana').attr('href', pdfUrl).show();

    $('#titulo_modal').text('BITÁCORA PROCESO DE ELABORACIÓN DE MEZCAL');
    $('#subtitulo_modal').html(empresa);
    //$("#subtitulo_modal").html('<p class="solicitud badge bg-primary">' + empresa + '</p>');
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  /*     $('#pdfViewer').on('load', function () {
      $('#cargando').hide();
      $(this).show();
    }); */
  // Cuando abras el modal o al limpiar
  /*   $('#RegistrarBitacora').on('show.bs.modal', function () {
      console.log('entro vez');
      // En molienda
      $("#tablaMolienda tr:not(:first)").remove();
      // En segunda destilación
      $("#tablaSegundaDestilacion tr:not(:first)").remove();
  });
 */

  $(document).on('click', '.firma-record', function () {
    // Cierra todos los modales de Bootstrap que estén abiertos
    var dtrModal = $('.dtr-bs-modal.show');

    // Ocultar modal responsivo en pantalla pequeña si está abierto
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // Tu lógica después de cerrar modales
    var bitacoraID = $(this).data('id');
    $('#bitacora_id_firma').val(bitacoraID);
  });

  /*   $(document).ready(function () {
    $('.select2').select2({
      dropdownParent: $('#offcanvasAddFirma'), // o el contenedor correspondiente si no es un offcanvas
      width: '100%'
    });
  }); */
  $(function () {
    // Configurar CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('addFirma');
    const fv = FormValidation.formValidation(form, {
      fields: {
        'etapa_proceso[]': {
          validators: {
            notEmpty: {
              message: 'Seleccione por lo menos una etapa.'
            }
          }
        }
        /*         password: {
          validators: {
            notEmpty: {
              message: 'Ingresa su contraseña.'
            }
          }
        } */
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
      $('#btnFirma').addClass('d-none');
      $('#btnSpinner').removeClass('d-none');

      const formData = $(form).serialize();
      const id = $('#bitacora_id_firma').val();

      $.ajax({
        url: '/FirmaProcesoElab/' + id,
        type: 'POST',
        data: formData,
        success: function (response) {
          $('#offcanvasAddFirma').offcanvas('hide');
          $('#addFirma')[0].reset();
          $('.datatables-users').DataTable().ajax.reload();
          $('#btnSpinner').addClass('d-none');
          $('#btnFirma').removeClass('d-none');
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.success || 'La bitácora fue firmada correctamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (error) {
          let mensaje = 'Error desconocido del servidor.';
          let icono = 'error';
          let titulo = 'Error del servidor';

          if (error.responseJSON?.message) {
            mensaje = error.responseJSON.message;

            if (error.status === 403) {
              icono = 'warning';
              titulo = 'Permiso denegado';
            } else if ([400, 422].includes(error.status)) {
              titulo = '¡Ha ocurrido un error!';
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
          $('#btnSpinner').addClass('d-none');
          $('#btnFirma').removeClass('d-none');
        }
      });
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
        }
        /* volumen_total_formulado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen total formulado'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        }, */
        /*   puntas_alcohol: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el porcentaje de alcohol en puntas'
            },
            numeric: {
              message: 'Debe ser un número válido'
            }
          }
        }, */
        /*   puntas_volumen: {
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
        } */
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

    let indexTerceraDestilacion = 1;

    $(document).on('click', '#agregarFilaTerceraDestilacion', function () {
      let filaNueva = `
        <tr>
            <td class="text-nowrap">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
                    <i class="ri-close-circle-fill"></i>
                </button>
            </td>
            <td>
                <input type="text" class="form-control datepicker"
                    name="tercera_destilacion[${indexTerceraDestilacion}][fecha_destilacion]"
                    placeholder="aaaa-mm-dd">
            </td>
            <td>
                <input type="number" step="0.01" class="form-control"
                    name="tercera_destilacion[${indexTerceraDestilacion}][puntas_volumen]"
                    placeholder="Vol.">
            </td>
            <td>
                <input type="number" step="0.01" class="form-control"
                    name="tercera_destilacion[${indexTerceraDestilacion}][puntas_alcohol]"
                    placeholder="% Alc.">
            </td>
            <td>
                <input type="number" step="0.01" class="form-control"
                    name="tercera_destilacion[${indexTerceraDestilacion}][mezcal_volumen]"
                    placeholder="Vol.">
            </td>
            <td>
                <input type="number" step="0.01" class="form-control"
                    name="tercera_destilacion[${indexTerceraDestilacion}][mezcal_alcohol]"
                    placeholder="% Alc.">
            </td>
            <td>
                <input type="number" step="0.01" class="form-control"
                    name="tercera_destilacion[${indexTerceraDestilacion}][colas_volumen]"
                    placeholder="Vol.">
            </td>
            <td>
                <input type="number" step="0.01" class="form-control"
                    name="tercera_destilacion[${indexTerceraDestilacion}][colas_alcohol]"
                    placeholder="% Alc.">
            </td>
        </tr>
    `;

      $('#tablaTerceraDestilacion').append(filaNueva);

      // Reinicializa el datepicker si estás usando uno
      $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true });

      indexTerceraDestilacion++;
    });

    // También cada que agregues fila nueva
    $('#agregarFilaMolienda, #agregarFilaSegundaDestilacion').on('click', function () {
      setTimeout(calcularTotales, 100); // Espera a que se agregue al DOM
    });
  });

  let edit_indexMolienda = 0;
  let edit_indexSegundaDestilacion = 0;
  let edit_indexTerceraDestilacion = 0;

  $(function () {
    $(document).on('click', '.edit-record', function () {
      var bitacoraID = $(this).data('id');
      $('#edit_bitacora_id').val(bitacoraID);
      $.ajax({
        url: '/bitacoraProcesoElab/' + bitacoraID + '/edit',
        method: 'GET',
        success: function (data) {
          if (data.success) {
            const bitacora = data.bitacora;
            const totales = data.bitacora.totales;

            const molienda = totales.find(t => t.etapa == 1);
            const segunda = totales.find(t => t.etapa == 2);
            const tercera = totales.find(t => t.etapa == 3);

            // Cargar campos simples
            $('#edit_fecha_ingreso').val(bitacora.fecha_ingreso);
            $('#edit_id_empresa').val(bitacora.id_empresa).trigger('change');
            $('#edit_id_instalacion').data('selected', bitacora.id_instalacion);
            $('#edit_lote_granel').val(bitacora.lote_granel);
            $('#edit_numero_tapada').val(bitacora.numero_tapada);
            $('#edit_numero_guia').val(bitacora.numero_guia);
            $('#edit_numero_pinas').val(bitacora.numero_pinas);
            $('#edit_kg_maguey').val(bitacora.kg_maguey);
            $('#edit_porcentaje_azucar').val(bitacora.porcentaje_azucar);
            $('#edit_kg_coccion').val(bitacora.kg_coccion);
            $('#edit_fecha_inicio_coccion').val(bitacora.fecha_inicio_coccion);
            $('#edit_fecha_fin_coccion').val(bitacora.fecha_fin_coccion);

            // Totales
            $('#edit_volumen_total_formulado').val(bitacora.volumen_total_formulado);
            $('#edit_puntas_volumen').val(bitacora.puntas_volumen);
            $('#edit_puntas_alcohol').val(bitacora.puntas_alcohol);
            $('#edit_mezcal_volumen').val(bitacora.mezcal_volumen);
            $('#edit_mezcal_alcohol').val(bitacora.mezcal_alcohol);
            $('#edit_colas_volumen').val(bitacora.colas_volumen);
            $('#edit_colas_alcohol').val(bitacora.colas_alcohol);
            $('#edit_observaciones').val(bitacora.observaciones);

            // Molienda (etapa 1)
            if (molienda) {
              $('#edit_molienda_volumen_formulacion_final').val(molienda.volumen_formulacion);
              $('#edit_molienda_puntas_volumen_final').val(molienda.puntas_volumen);
              $('#edit_molienda_puntas_alcohol_final').val(molienda.puntas_porcentaje);
              $('#edit_molienda_mezcal_volumen_final').val(molienda.mezcal_volumen);
              $('#edit_molienda_mezcal_alcohol_final').val(molienda.mezcal_porcentaje);
              $('#edit_molienda_colas_volumen_final').val(molienda.colas_volumen);
              $('#edit_molienda_colas_alcohol_final').val(molienda.colas_porcentaje);
            }

            // Segunda destilación (etapa 2)
            if (segunda) {
              $('#edit_segunda_puntas_volumen_final').val(segunda.puntas_volumen);
              $('#edit_segunda_puntas_alcohol_final').val(segunda.puntas_porcentaje);
              $('#edit_segunda_mezcal_volumen_final').val(segunda.mezcal_volumen);
              $('#edit_segunda_mezcal_alcohol_final').val(segunda.mezcal_porcentaje);
              $('#edit_segunda_colas_volumen_final').val(segunda.colas_volumen);
              $('#edit_segunda_colas_alcohol_final').val(segunda.colas_porcentaje);
            }

            // Tercera destilación (etapa 3)
            if (tercera) {
              $('#edit_tercera_puntas_volumen_final').val(tercera.puntas_volumen);
              $('#edit_tercera_puntas_alcohol_final').val(tercera.puntas_porcentaje);
              $('#edit_tercera_mezcal_volumen_final').val(tercera.mezcal_volumen);
              $('#edit_tercera_mezcal_alcohol_final').val(tercera.mezcal_porcentaje);
              $('#edit_tercera_colas_volumen_final').val(tercera.colas_volumen);
              $('#edit_tercera_colas_alcohol_final').val(tercera.colas_porcentaje);
            }


            // Tipos de maguey (select múltiple con Select2, por ejemplo)
            if (bitacora.id_tipo) {
              $('#edit_tipo_agave').val(bitacora.id_tipo).trigger('change');
            }
            // Tablas relacionales
            $('#edit_tablaMolienda').empty();
            edit_indexMolienda = 0;
            bitacora.molienda.forEach(fila => {
              agregarFilaMoliendaEdit(fila, edit_indexMolienda++);
            });

            $('#edit_tablaSegundaDestilacion').empty();
            edit_indexSegundaDestilacion = 0;
            bitacora.segunda_destilacion.forEach(fila => {
              agregarFilaSegundaDestilacionEdit(fila, edit_indexSegundaDestilacion++);
            });

            $('#edit_tablaTerceraDestilacion').empty();
            edit_indexTerceraDestilacion = 0;
            // Cargar filas existentes de la bitácora
            bitacora.tercera_destilacion.forEach(fila => {
              agregarFilaTerceraDestilacionEdit(fila, edit_indexTerceraDestilacion++);
            });
            // Mostrar modal
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

    function agregarFilaMoliendaEdit(fila = {}, index) {
      const nuevaFila = `
          <tr>
            <td>
              <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
                <i class="ri-close-circle-fill"></i>
              </button>
            </td>
            <td><input type="text" class="form-control datepicker" name="molienda[${index}][fecha_molienda]" value="${fila.fecha_molienda || ''}"></td>
            <td><input type="text" class="form-control" name="molienda[${index}][numero_tina]" value="${fila.numero_tina || ''}"></td>
            <td><input type="text" class="form-control datepicker" name="molienda[${index}][fecha_formulacion]" value="${fila.fecha_formulacion || ''}"></td>
            <td><input type="number" step="0.01" class="form-control" name="molienda[${index}][volumen_formulacion]" value="${fila.volumen_formulacion || ''}"></td>
            <td><input type="text" class="form-control datepicker" name="molienda[${index}][fecha_destilacion]" value="${fila.fecha_destilacion || ''}"></td>
            <td><input type="number" step="0.01" class="form-control" name="molienda[${index}][puntas_volumen]" value="${fila.puntas_volumen || ''}"></td>
            <td><input type="number" step="0.01" class="form-control" name="molienda[${index}][puntas_alcohol]" value="${fila.puntas_porcentaje || ''}"></td>
            <td><input type="number" step="0.01" class="form-control" name="molienda[${index}][mezcal_volumen]" value="${fila.mezcal_volumen || ''}"></td>
            <td><input type="number" step="0.01" class="form-control" name="molienda[${index}][mezcal_alcohol]" value="${fila.mezcal_porcentaje || ''}"></td>
            <td><input type="number" step="0.01" class="form-control" name="molienda[${index}][colas_volumen]" value="${fila.colas_volumen || ''}"></td>
            <td><input type="number" step="0.01" class="form-control" name="molienda[${index}][colas_alcohol]" value="${fila.colas_porcentaje || ''}"></td>
          </tr>
        `;
      $('#edit_tablaMolienda').append(nuevaFila);
      $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true });
    }

    function agregarFilaSegundaDestilacionEdit(fila = {}, index) {
      const nuevaFila = `
        <tr>
          <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
              <i class="ri-close-circle-fill"></i>
            </button>
          </td>
          <td><input type="text" class="form-control datepicker" name="segunda_destilacion[${index}][fecha_destilacion]" value="${fila.fecha_destilacion || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="segunda_destilacion[${index}][puntas_volumen]" value="${fila.puntas_volumen || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="segunda_destilacion[${index}][puntas_alcohol]" value="${fila.puntas_porcentaje || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="segunda_destilacion[${index}][mezcal_volumen]" value="${fila.mezcal_volumen || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="segunda_destilacion[${index}][mezcal_alcohol]" value="${fila.mezcal_porcentaje || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="segunda_destilacion[${index}][colas_volumen]" value="${fila.colas_volumen || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="segunda_destilacion[${index}][colas_alcohol]" value="${fila.colas_porcentaje || ''}"></td>
        </tr>
      `;
      $('#edit_tablaSegundaDestilacion').append(nuevaFila);
      $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true });
    }

    // Función para agregar fila de tercera destilación en edición
    function agregarFilaTerceraDestilacionEdit(fila = {}, index) {
      const nuevaFila = `
        <tr>
          <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
              <i class="ri-close-circle-fill"></i>
            </button>
          </td>
          <td><input type="text" class="form-control datepicker" name="tercera_destilacion[${index}][fecha_destilacion]" value="${fila.fecha_destilacion || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="tercera_destilacion[${index}][puntas_volumen]" value="${fila.puntas_volumen || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="tercera_destilacion[${index}][puntas_alcohol]" value="${fila.puntas_porcentaje || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="tercera_destilacion[${index}][mezcal_volumen]" value="${fila.mezcal_volumen || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="tercera_destilacion[${index}][mezcal_alcohol]" value="${fila.mezcal_porcentaje || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="tercera_destilacion[${index}][colas_volumen]" value="${fila.colas_volumen || ''}"></td>
          <td><input type="number" step="0.01" class="form-control" name="tercera_destilacion[${index}][colas_alcohol]" value="${fila.colas_porcentaje || ''}"></td>
        </tr>
      `;
      $('#edit_tablaTerceraDestilacion').append(nuevaFila);
      $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true });
    }

    $('#edit_agregarFilaMolienda').on('click', function () {
      agregarFilaMoliendaEdit({}, edit_indexMolienda++);
    });

    $('#edit_agregarFilaSegundaDestilacion').on('click', function () {
      agregarFilaSegundaDestilacionEdit({}, edit_indexSegundaDestilacion++);
    });
    // Botón para agregar fila nueva de tercera destilación
    $('#edit_agregarFilaTerceraDestilacion').on('click', function () {
      agregarFilaTerceraDestilacionEdit({}, edit_indexTerceraDestilacion++);
    });
  });



  $(document).ready(function () {

    // --- 1. FUNCIÓN DEL TOTAL GENERAL (LA NUEVA) ---
    // Esta función lee los 'tfoot' de las 3 tablas y actualiza la tabla 'TOTAL'
    function calcularTotalGeneral() {

      // 1. Molienda (Caso especial, solo se copia)
      let totalFormulacion = parseFloat($('#molienda_final_volumen_formulacion_final').val()) || 0;

      // 2. Puntas (Suma de los 3 totales)
      let totalPuntas = (parseFloat($('#molienda_final_puntas_volumen_final').val()) || 0) +
        (parseFloat($('#segunda_destilacion_final_puntas_volumen_final').val()) || 0) +
        (parseFloat($('#tercera_destilacion_final_puntas_volumen_final').val()) || 0);

      // 3. Mezcal (Suma de los 3 totales)
      let totalMezcal = (parseFloat($('#molienda_final_mezcal_volumen_final').val()) || 0) +
        (parseFloat($('#segunda_destilacion_final_mezcal_volumen_final').val()) || 0) +
        (parseFloat($('#tercera_destilacion_final_mezcal_volumen_final').val()) || 0);

      // 4. Colas (Suma de los 3 totales)
      let totalColas = (parseFloat($('#molienda_final_colas_volumen_final').val()) || 0) +
        (parseFloat($('#segunda_destilacion_final_colas_volumen_final').val()) || 0) +
        (parseFloat($('#tercera_destilacion_final_colas_volumen_final').val()) || 0);

      // --- Asignar los valores a la tabla TOTAL ---
      $('#volumen_total_formulado').val(totalFormulacion.toFixed(2));
      $('#puntas_volumen').val(totalPuntas.toFixed(2));
      $('#mezcal_volumen').val(totalMezcal.toFixed(2));
      $('#colas_volumen').val(totalColas.toFixed(2));

      // NOTA: Los campos de % Alcohol no se calculan porque no son 'readonly'
      // y la lógica (promedio ponderado) es más compleja.
      // Si la necesitas, avísame.
    }


    // --- 2. FUNCIÓN MOLIENDA (MODIFICADA) ---
    // (Esta es la primera que me pediste, ahora con 1 línea extra al final)
    function calcularTotalesMolienda() {
      let totalFormulacion = 0;
      let totalPuntas = 0;
      let totalMezcal = 0;
      let totalColas = 0;

      $('#tablaMolienda input[name*="[volumen_formulacion]"]').each(function () {
        totalFormulacion += parseFloat($(this).val()) || 0;
      });
      $('#tablaMolienda input[name*="[puntas_volumen]"]').each(function () {
        totalPuntas += parseFloat($(this).val()) || 0;
      });
      $('#tablaMolienda input[name*="[mezcal_volumen]"]').each(function () {
        totalMezcal += parseFloat($(this).val()) || 0;
      });
      $('#tablaMolienda input[name*="[colas_volumen]"]').each(function () {
        totalColas += parseFloat($(this).val()) || 0;
      });

      $('#molienda_final_volumen_formulacion_final').val(totalFormulacion.toFixed(2));
      $('#molienda_final_puntas_volumen_final').val(totalPuntas.toFixed(2));
      $('#molienda_final_mezcal_volumen_final').val(totalMezcal.toFixed(2));
      $('#molienda_final_colas_volumen_final').val(totalColas.toFixed(2));

      // --- ¡LÍNEA NUEVA! ---
      // Cada vez que Molienda se actualiza, también actualiza el Total General
      calcularTotalGeneral();
    }


    // --- 3. FUNCIÓN SEGUNDA DESTILACIÓN (MODIFICADA) ---
    // (La del script anterior, con 1 línea extra al final)
    function calcularTotalesSegundaDestilacion() {
      let totalPuntas = 0;
      let totalMezcal = 0;
      let totalColas = 0;

      $('#tablaSegundaDestilacion input[name*="[puntas_volumen]"]').each(function () {
        totalPuntas += parseFloat($(this).val()) || 0;
      });
      $('#tablaSegundaDestilacion input[name*="[mezcal_volumen]"]').each(function () {
        totalMezcal += parseFloat($(this).val()) || 0;
      });
      $('#tablaSegundaDestilacion input[name*="[colas_volumen]"]').each(function () {
        totalColas += parseFloat($(this).val()) || 0;
      });

      $('#segunda_destilacion_final_puntas_volumen_final').val(totalPuntas.toFixed(2));
      $('#segunda_destilacion_final_mezcal_volumen_final').val(totalMezcal.toFixed(2));
      $('#segunda_destilacion_final_colas_volumen_final').val(totalColas.toFixed(2));

      // --- ¡LÍNEA NUEVA! ---
      calcularTotalGeneral();
    }


    // --- 4. FUNCIÓN TERCERA DESTILACIÓN (MODIFICADA) ---
    // (La del script anterior, con 1 línea extra al final)
    function calcularTotalesTerceraDestilacion() {
      let totalPuntas = 0;
      let totalMezcal = 0;
      let totalColas = 0;

      $('#tablaTerceraDestilacion input[name*="[puntas_volumen]"]').each(function () {
        totalPuntas += parseFloat($(this).val()) || 0;
      });
      $('#tablaTerceraDestilacion input[name*="[mezcal_volumen]"]').each(function () {
        totalMezcal += parseFloat($(this).val()) || 0;
      });
      $('#tablaTerceraDestilacion input[name*="[colas_volumen]"]').each(function () {
        totalColas += parseFloat($(this).val()) || 0;
      });

      $('#tercera_destilacion_final_puntas_volumen_final').val(totalPuntas.toFixed(2));
      $('#tercera_destilacion_final_mezcal_volumen_final').val(totalMezcal.toFixed(2));
      $('#tercera_destilacion_final_colas_volumen_final').val(totalColas.toFixed(2));

      // --- ¡LÍNEA NUEVA! ---
      calcularTotalGeneral();
    }


    // --- 5. DISPARADORES DE EVENTOS (LISTENERS) ---

    // Tabla Molienda
    const selectorMolienda = 'input[name*="[volumen_formulacion]"], input[name*="[puntas_volumen]"], input[name*="[mezcal_volumen]"], input[name*="[colas_volumen]"]';
    $('#tablaMolienda').on('input', selectorMolienda, calcularTotalesMolienda);
    $('#tablaMolienda').on('click', '.btn-danger', function () {
      $(this).closest('tr').remove();
      calcularTotalesMolienda();
    });

    // Tabla Segunda Destilación
    const selectorSegunda = 'input[name*="[puntas_volumen]"], input[name*="[mezcal_volumen]"], input[name*="[colas_volumen]"]';
    $('#tablaSegundaDestilacion').on('input', selectorSegunda, calcularTotalesSegundaDestilacion);
    $('#tablaSegundaDestilacion').on('click', '.btn-danger', function () {
      $(this).closest('tr').remove();
      calcularTotalesSegundaDestilacion();
    });

    // Tabla Tercera Destilación
    const selectorTercera = 'input[name*="[puntas_volumen]"], input[name*="[mezcal_volumen]"], input[name*="[colas_volumen]"]';
    $('#tablaTerceraDestilacion').on('input', selectorTercera, calcularTotalesTerceraDestilacion);
    $('#tablaTerceraDestilacion').on('click', '.btn-danger', function () {
      $(this).closest('tr').remove();
      calcularTotalesTerceraDestilacion();
    });


    // --- 6. LLAMADA INICIAL AL CARGAR LA PÁGINA ---
    // Se ejecutan las 3 funciones de subtotal.
    // Cada una, al terminar, llamará a calcularTotalGeneral()
    calcularTotalesMolienda();
    calcularTotalesSegundaDestilacion();
    calcularTotalesTerceraDestilacion();

  });

  /* metodo para la sumatoria de los totales volumenes al editar  */

  $(document).ready(function() {

    // -----------------------------------------------------------------
    // --- SCRIPT EXCLUSIVO PARA EL MODAL DE EDITAR (prefijo 'edit_') ---
    // -----------------------------------------------------------------

    /**
     * =============================================
     * FUNCIÓN 1: TOTAL GENERAL (SOLO PARA 'EDIT')
     * =============================================
     * Lee los tfoot de las 3 tablas 'edit_' y actualiza la tabla 'TOTAL'
     */
    function calcularTotalGeneralEdit() {

        // 1. Molienda (Toma el valor directo del tfoot de Molienda)
        let totalFormulacion = parseFloat($('#edit_molienda_volumen_formulacion_final').val()) || 0;

        // 2. Puntas (Suma de los 3 totales 'edit_')
        let totalPuntas = (parseFloat($('#edit_molienda_puntas_volumen_final').val()) || 0) +
                          (parseFloat($('#edit_segunda_puntas_volumen_final').val()) || 0) +
                          (parseFloat($('#edit_tercera_puntas_volumen_final').val()) || 0);

        // 3. Mezcal (Suma de los 3 totales 'edit_')
        let totalMezcal = (parseFloat($('#edit_molienda_mezcal_volumen_final').val()) || 0) +
                          (parseFloat($('#edit_segunda_mezcal_volumen_final').val()) || 0) +
                          (parseFloat($('#edit_tercera_mezcal_volumen_final').val()) || 0);

        // 4. Colas (Suma de los 3 totales 'edit_')
        let totalColas = (parseFloat($('#edit_molienda_colas_volumen_final').val()) || 0) +
                         (parseFloat($('#edit_segunda_colas_volumen_final').val()) || 0) +
                         (parseFloat($('#edit_tercera_colas_volumen_final').val()) || 0);

        // --- Asignar los valores a la tabla TOTAL (con IDs 'edit_') ---
        $('#edit_volumen_total_formulado').val(totalFormulacion.toFixed(2));
        $('#edit_puntas_volumen').val(totalPuntas.toFixed(2));
        $('#edit_mezcal_volumen').val(totalMezcal.toFixed(2));
        $('#edit_colas_volumen').val(totalColas.toFixed(2));
    }


    /**
     * =============================================
     * FUNCIÓN 2: MOLIENDA (SOLO PARA 'EDIT')
     * =============================================
     */
    function calcularTotalesEditMolienda() {
        let totalFormulacion = 0, totalPuntas = 0, totalMezcal = 0, totalColas = 0;

        $('#edit_tablaMolienda input[name*="[volumen_formulacion]"]').each(function() {
            totalFormulacion += parseFloat($(this).val()) || 0;
        });
        $('#edit_tablaMolienda input[name*="[puntas_volumen]"]').each(function() {
            totalPuntas += parseFloat($(this).val()) || 0;
        });
        $('#edit_tablaMolienda input[name*="[mezcal_volumen]"]').each(function() {
            totalMezcal += parseFloat($(this).val()) || 0;
        });
        $('#edit_tablaMolienda input[name*="[colas_volumen]"]').each(function() {
            totalColas += parseFloat($(this).val()) || 0;
        });

        // Escribe en el tfoot 'edit_'
        $('#edit_molienda_volumen_formulacion_final').val(totalFormulacion.toFixed(2));
        $('#edit_molienda_puntas_volumen_final').val(totalPuntas.toFixed(2));
        $('#edit_molienda_mezcal_volumen_final').val(totalMezcal.toFixed(2));
        $('#edit_molienda_colas_volumen_final').val(totalColas.toFixed(2));

        // --- Llama a la calculadora general 'edit_' ---
        calcularTotalGeneralEdit();
    }


    /**
     * =============================================
     * FUNCIÓN 3: SEGUNDA DESTILACIÓN (SOLO PARA 'EDIT')
     * =============================================
     */
    function calcularTotalesEditSegunda() {
        let totalPuntas = 0, totalMezcal = 0, totalColas = 0;

        $('#edit_tablaSegundaDestilacion input[name*="[puntas_volumen]"]').each(function() {
            totalPuntas += parseFloat($(this).val()) || 0;
        });
        $('#edit_tablaSegundaDestilacion input[name*="[mezcal_volumen]"]').each(function() {
            totalMezcal += parseFloat($(this).val()) || 0;
        });
        $('#edit_tablaSegundaDestilacion input[name*="[colas_volumen]"]').each(function() {
            totalColas += parseFloat($(this).val()) || 0;
        });

        // Escribe en el tfoot 'edit_'
        $('#edit_segunda_puntas_volumen_final').val(totalPuntas.toFixed(2));
        $('#edit_segunda_mezcal_volumen_final').val(totalMezcal.toFixed(2));
        $('#edit_segunda_colas_volumen_final').val(totalColas.toFixed(2));

        // --- Llama a la calculadora general 'edit_' ---
        calcularTotalGeneralEdit();
    }


    /**
     * =============================================
     * FUNCIÓN 4: TERCERA DESTILACIÓN (SOLO PARA 'EDIT')
     * =============================================
     */
    function calcularTotalesEditTercera() {
        let totalPuntas = 0, totalMezcal = 0, totalColas = 0;

        $('#edit_tablaTerceraDestilacion input[name*="[puntas_volumen]"]').each(function() {
            totalPuntas += parseFloat($(this).val()) || 0;
        });
        $('#edit_tablaTerceraDestilacion input[name*="[mezcal_volumen]"]').each(function() {
            totalMezcal += parseFloat($(this).val()) || 0;
        });
        $('#edit_tablaTerceraDestilacion input[name*="[colas_volumen]"]').each(function() {
            totalColas += parseFloat($(this).val()) || 0;
        });

        // Escribe en el tfoot 'edit_'
        $('#edit_tercera_puntas_volumen_final').val(totalPuntas.toFixed(2));
        $('#edit_tercera_mezcal_volumen_final').val(totalMezcal.toFixed(2));
        $('#edit_tercera_colas_volumen_final').val(totalColas.toFixed(2));

        // --- Llama a la calculadora general 'edit_' ---
        calcularTotalGeneralEdit();
    }


    /**
     * =============================================
     * SECCIÓN 5: DISPARADORES DE EVENTOS ('LISTENERS')
     * =============================================
     * Asigna las funciones anteriores a los eventos de 'input'
     */

    // Disparadores para Molienda (edit)
    const selectorMoliendaEdit = 'input[name*="[volumen_formulacion]"], input[name*="[puntas_volumen]"], input[name*="[mezcal_volumen]"], input[name*="[colas_volumen]"]';
    $('#edit_tablaMolienda').on('input', selectorMoliendaEdit, calcularTotalesEditMolienda);
    $('#edit_tablaMolienda').on('click', '.btn-danger', function() {
        $(this).closest('tr').remove();
        calcularTotalesEditMolienda();
    });

    // Disparadores para Segunda Destilación (edit)
    const selectorSegundaEdit = 'input[name*="[puntas_volumen]"], input[name*="[mezcal_volumen]"], input[name*="[colas_volumen]"]';
    $('#edit_tablaSegundaDestilacion').on('input', selectorSegundaEdit, calcularTotalesEditSegunda);
    $('#edit_tablaSegundaDestilacion').on('click', '.btn-danger', function() {
        $(this).closest('tr').remove();
        calcularTotalesEditSegunda();
    });

    // Disparadores para Tercera Destilación (edit)
    const selectorTerceraEdit = 'input[name*="[puntas_volumen]"], input[name*="[mezcal_volumen]"], input[name*="[colas_volumen]"]';
    $('#edit_tablaTerceraDestilacion').on('input', selectorTerceraEdit, calcularTotalesEditTercera);
    $('#edit_tablaTerceraDestilacion').on('click', '.btn-danger', function() {
        $(this).closest('tr').remove();
        calcularTotalesEditTercera();
    });


    /**
     * =============================================
     * SECCIÓN 6: LLAMADA INICIAL
     * =============================================
     * Calcula todo en cuanto cargue el modal por si ya tiene datos
     */
    calcularTotalesEditMolienda();
    calcularTotalesEditSegunda();
    calcularTotalesEditTercera();

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

        numero_guia: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de guía'
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
        }
        /*  volumen_total_formulado: {
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
        } */
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          /*  rowSelector: '.form-floating' */
          rowSelector: function (field, ele) {
            // field is the field name & ele is the field element
            return '.mb-4, .mb-1';
          }
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
        url: '/bitacoraProcesoElabUpdate/' + id,
        type: 'POST',
        data: formData,
        success: function (response) {
          $('#loadingEdit').addClass('d-none');
          $('#btnEdit').removeClass('d-none');
          $('#EditBitacora').modal('hide');
          $('#EditInventarioForm')[0].reset();
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
          $('#loadingEdit').addClass('d-none');
          $('#btnEdit').removeClass('d-none');
        }
      });
    });
  });

  $(document).ready(function () {
    // Al abrir modal, disparas la carga inicial para el cliente seleccionado
    $('#RegistrarBitacora').on('shown.bs.modal', function () {
      var empresaSeleccionada = $('#id_empresa').val();
      if (empresaSeleccionada) {
        cargarInstalaciones(empresaSeleccionada);
      } else {
      }
    });

    // También cuando cambia el select
    $('#id_empresa').on('change', function () {
      var empresa = $(this).val();
      cargarInstalaciones(empresa);
    });
  });

  /* fin chelo */
});
