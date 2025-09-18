'use strict';

$(function () {
  let buttonss = [];
  // Si tiene permiso, agregas el botón
  if (puedeAgregarElUsuario) {
    buttonss.push({
      text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Bitácora</span>',
      className: 'add-new btn btn-primary me-2 mb-2 mb-sm-2 mt-4 mt-md-0 waves-effect waves-light',
      attr: {
        'data-bs-toggle': 'modal',
        'data-bs-target': '#RegistrarBitacoraMezcal'
      }
    });
  }

  var dt_user_table = $('.datatables-users');

  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true
  });

  // AJAX setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'bitacoraHologramasCom-list',
        data: function (d) {
          d.empresa = $('#filtroEmpresa').val();
          d.instalacion = $('#filtroInstalacion').val();
        }
      },
      columns: [
        { data: null }, // 0 -> # (control o vacío)
        { data: 'fake_id' }, // 1 -> ID
        { data: 'razon_social' }, // 2 -> Cliente (campo directo)
        {data: 'id_instalacion'},
        { data: null }, // 3 -> Datos Iniciales (fecha + lote)
        { data: null }, // 4 -> Entradas
        { data: null }, // 5 -> Salidas
        { data: null }, // 6 -> Inventario Final
        { data: 'id_firmante' }, // 7 -> Estatus (para badge)
        { data: null } // 8 -> Acciones
      ],
      columnDefs: [
        {
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, row) {
            return '';
          }
        },
        {
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          targets: 2,
          responsivePriority: 1,
          render: function (data, type, full) {
            var $empresa = full['cliente'] ?? 'N/A';
            return `<span>${$empresa}</span>`;
          }
        },
         {
          targets: 3,
          responsivePriority: 1,
          render: function (data, type, full) {
            var $id_instalacion = full['id_instalacion'] ?? 'N/A';
            return `<span>${$id_instalacion}</span>`;
          }
        },
        {
          targets: 4,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $fecha = full['fecha'] ?? 'N/A';
            var $id_lote_envasado = full['nombre_lote'] ?? 'N/A';
            var $obs = full['observaciones'];
            var $tipo_operacion = full['tipo_operacion'];
            var $serie_inicial = (full['serie_inicial'] ?? '').trim();
              var $num_sellos_inicial = full['num_sellos_inicial'] ?? 'N/A';

            let html = `
             <br><span class="fw-bold small">Serie Inicial:</span>
            <span class="small">${$serie_inicial || 'N/A'}</span>
            <br><span class="fw-bold small">N° Sellos Inicial:</span>
            <span class="small">${$num_sellos_inicial || 'N/A'}</span><br>
              <span class="fw-bold small">Fecha: </span>
              <span class="small">${$fecha}</span><br>
              <span class="fw-bold small">Lote envasado: </span>
              <span class="small">${$id_lote_envasado}</span>
            `;

            if ($tipo_operacion && $tipo_operacion !== 'N/A') {
              html += `
        <br><span class="fw-bold small">Actividad: </span>
        <span class="small">${$tipo_operacion}</span>
      `;
            }

            if ($obs && $obs !== 'N/A' && $obs !== '0' && $obs !== 0) {
              html += `
        <br><span class="fw-bold small">Observaciones: </span>
        <span class="small">${$obs}</span>
      `;
            }

            return html;
          }
        },
        {
          targets: 5,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $serie_entrada = full['serie_entrada'] ?? 'N/A';
            var $num_sellos_entrada = full['num_sellos_entrada'] ?? 'N/A';
            return (
              '<span class="fw-bold small">Serie: </span>' +
              '<span class="small">' +
              $serie_entrada +
              '</span>' +
              '<br><span class="fw-bold small">N° de sellos: </span>' +
              '<span class="small">' +
              $num_sellos_entrada +
              '</span>'
            );
          }
        },
        ////salidas
        {
          targets: 6,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $serie_salidas = full['serie_salidas'] ?? 'N/A';
            var $num_sellos_salidas = full['num_sellos_salidas'] ?? 'N/A';
            return (
              '<span class="fw-bold small">Serie de Salidas: </span>' +
              '<span class="small">' +
              $serie_salidas +
              '</span>' +
              '<br><span class="fw-bold small">N° de sellos de Salidas: </span>' +
              '<span class="small">' +
              $num_sellos_salidas +
              '</span>'
            );
          }
        },
        {
          targets: 7,
          responsivePriority: 1,
         render: function (data, type, full, meta) {
            var $serie_mermas = (full['serie_merma'] || '').trim();
            var $num_sellos_merma = (full['mermas'] ?? '').toString().trim();
            var $serie_final = (full['serie_final'] ?? 'N/A').trim();
            var $num_sellos_final = (full['num_sellos_final'] ?? 'N/A').trim();

            let html =
                '<span class="fw-bold small">Serie Final: </span>' +
                '<span class="small">' + $serie_final + '</span>' +
                '<br><span class="fw-bold small">N° de sellos Final: </span>' +
                '<span class="small">' + $num_sellos_final + '</span>';

          if ($serie_mermas !== '' && $serie_mermas !== '0') {
                html +=
                    '<br><span class="fw-bold small">Serie mermas: </span>' +
                    '<span class="small">' + $serie_mermas + '</span>';
            }

            if ($num_sellos_merma !== '' && $num_sellos_merma !== '0') {
                html +=
                    '<br><span class="fw-bold small">N° de sellos Mermas: </span>' +
                    '<span class="small">' + $num_sellos_merma + '</span>';
            }

            return html;
        }

        },
        {
          targets: 8,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $estatus = full['id_firmante'] ?? null;
            let $badges = '';
            let $texto = '';
            if ($estatus != 0 && $estatus != null) {
              $texto = 'Firmado';
              $badges = 'bg-success';
            } else {
              $texto = 'Sin firmar';
              $badges = 'bg-warning';
            }
            return `<span class="badge rounded-pill ${$badges} mb-1">${$texto}</span>`;
          }
        },
        {
          // Actions
          targets: 9,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            let acciones = '';
            const estaFirmado = full['id_firmante'] != 0 && full['id_firmante'] != null;
            const esAdminBitacoras = window.adminBitacoras === true;
            const esUsuarioTipo2 = window.tipoUsuario === 2; // ✅ Detecta tipo de usuario

            // Permitir firmar si NO está firmada, si es admin, o si es usuario tipo 2
            if (!estaFirmado || esAdminBitacoras || esUsuarioTipo2) {
              if (window.puedeFirmarElUsuario) {
                const textoFirma = (estaFirmado && esUsuarioTipo2)
                  ? 'Volver a firmar bitácora'
                  : 'Firmar bitácora';

                acciones += `<a data-id="${full['id']}" class="dropdown-item firma-record waves-effect text-warning">
                              <i class="ri-ball-pen-line ri-20px text-warning"></i> ${textoFirma}</a>`;
              }

              // 👇 Solo permitir editar/eliminar si NO es tipo 2
              if (window.puedeEditarElUsuario) {
                acciones += `<a data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#editarBitacoraMezcal"
                              class="dropdown-item edit-record waves-effect text-info">
                              <i class="ri-edit-box-line ri-20px text-info"></i> Editar bitácora</a>`;
              }

              if (window.puedeEliminarElUsuario) {
                acciones += `<a data-id="${full['id']}" class="dropdown-item delete-record waves-effect text-danger">
                              <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar bitácora </a>`;
              }
            }

            // Si no hay acciones, mostrar botón deshabilitado
            if (!acciones.trim()) {
              return `
                <button class="btn btn-sm btn-secondary" disabled>
                  <i class="ri-settings-5-fill ri-20px me-1"></i> Opciones
                </button>
              `;
            }

            // Si hay acciones, construir el dropdown
            return `
              <div class="d-flex align-items-center gap-50">
                <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end m-0">
                  ${acciones}
                </div>
              </div>
            `;
          }

        }
      ],

      order: [[1, 'desc']],
      dom:
        '<"card-header d-flex rounded-0 flex-wrap pb-md-0 pt-0"' +
        '<"me-5 ms-n2"f>' +
        '<"d-flex flex-wrap justify-content-end align-items-center w-100 px-3 pt-2"' +
        '<"filtrosBitacora d-flex gap-2 align-items-center" >' + // ← Aquí irán los selects
        '<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center gap-3"lB>' +
        '>' +
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
        emptyTable: 'No hay datos disponibles en la tabla',
        paginate: {
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior'
        }
      },

      // Opciones Exportar Documentos
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
          className: 'dt-custom-select p-0 me-2 btn-outline-dark form-select-sm',
          text: '',
          init: function (api, node) {
            $(node).removeClass('btn btn-secondary');

            // Si usuario tipo 3 y tiene instalaciones, usar las precargadas
            let htmlOpciones = window.tipoUsuario === 3
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
          text: '<i class="ri-eye-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Ver Bitácora</span>',
          className: 'btn btn-info waves-effect waves-light me-2 mb-2 mb-sm-2 mt-4 mt-md-0',
          attr: {
            id: 'verBitacoraBtn'
          }
        },
        buttonss
      ],

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

  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account';
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

  $(document).on('select2:select', '#filtroEmpresa', function (e) {
    const selectedText = $(this).find('option:selected').text();
    $('#filtroEmpresa, #filtroInstalacion').next('.select2-container').find('.select2-selection__rendered').attr('title', selectedText);
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
  $(document).on('click', '#verBitacoraBtn', function () {
    const empresaId = $('#filtroEmpresa').val();
    const instalacionId = $('#filtroInstalacion').val();

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

    let urlPDF = `/bitacora_hologramas_com?empresa=${empresaId}`;
    if (instalacionId) {
      urlPDF += `&instalacion=${instalacionId}`;
    }
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
        $('#titulo_modal').text('Bitácora de control de hologramas de comercializador');
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
          url: `${baseUrl}bitacoraHologramasCom-list/${id_bitacora}`,
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
        fecha: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha'
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
        id_lote_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el lote'
            }
          }
        },
        serie_final: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la serie final'
            }
          }
        },
        num_sellos_final: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa el N° de sellos final'
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
      $('#btnRegistrar').addClass('d-none');
      $('#loading').removeClass('d-none');
      var formData = $(form).serialize();

      $.ajax({
        url: '/bitacoraHologramasComStore',
        type: 'POST',
        data: formData,
        success: function (response) {
          // Ocultar el offcanvas
          $('#RegistrarBitacoraMezcal').modal('hide');
          $('#loading').addClass('d-none');
          $('#btnRegistrar').removeClass('d-none');
          $('#registroInventarioForm')[0].reset();
          $('#registroInventarioForm select').val(null).trigger('change');
          $('#id_instalacion').empty().trigger('change');
          $('#id_lote_envasado').empty().trigger('change');
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
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al agregar la bitácora',
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
    $('#id_empresa, #id_lote_envasado, #fecha').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });
  });

  $(document).on('click', '.edit-record', function () {
    var bitacoraID = $(this).data('id');
    $('#edit_bitacora_id').val(bitacoraID);
    $.ajax({
      url: '/bitacora_hologramas_com/' + bitacoraID + '/edit',
      method: 'GET',
      success: function (data) {
        if (data.success) {
          var bitacora = data.bitacora;

          $('#edit_bitacora_id').val(bitacora.id);
          $('#edit_id_empresa').val(bitacora.id_empresa).trigger('change');
          $('#edit_fecha').val(bitacora.fecha);
          $('#edit_id_instalacion').data('selected', bitacora.id_instalacion);
          $('#edit_id_lote_envasado').data('selected', bitacora.id_lote_envasado).trigger('change');
          $('#edit_serie_inicial').val(bitacora.serie_inicial);
          $('#edit_num_sellos_inicial').val(bitacora.num_sellos_inicial);
          /*  */
          $('#edit_tipo_op').val(bitacora.tipo_operacion).trigger('change');

          $('#edit_serie_entrada').val(bitacora.serie_entrada);
          $('#edit_num_sellos_entrada').val(bitacora.num_sellos_entrada);
          $('#edit_serie_salida').val(bitacora.serie_salida);
          $('#edit_num_sellos_salida').val(bitacora.num_sellos_salida);
          $('#edit_serie_final').val(bitacora.serie_final);
          $('#edit_num_sellos_final').val(bitacora.num_sellos_final);
          $('#edit_serie_merma').val(bitacora.serie_merma);
          $('#edit_num_sellos_merma').val(bitacora.num_sellos_merma);
          $('#edit_observaciones').val(bitacora.observaciones);
          $('#editarBitacoraMezcal').modal('show');
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

  $(function () {
    // Configurar CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('editInventarioForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona una empresa.'
            }
          }
        },
        id_lote_envasado: {
          validators: {
            notEmpty: {
              message: 'Selecciona un lote envasado.'
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
        serie_final: {
          validators: {
            notEmpty: {
              message: 'Ingresa la serie final.'
            }
          }
        },
        num_sellos_final: {
          validators: {
            notEmpty: {
              message: 'Ingresa el N° de sellos final.'
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
        url: '/bitacorasHologramasComUpdate/' + id,
        type: 'POST',
        data: formData,
        success: function (response) {
          $('#loadingEdit').addClass('d-none');
          $('#btnEdit').removeClass('d-none');
          $('#editarBitacoraMezcal').modal('hide');
          $('#editInventarioForm')[0].reset();
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
          $('#loadingEdit').addClass('d-none');
          $('#btnEdit').removeClass('d-none');
        }
      });
    });
  });

  /*   $(document).ready(function () {
    function calcular() {
      let volumenInicial = parseFloat($('#volumen_inicial').val()) || 0;
      let alcoholInicial = parseFloat($('#alcohol_inicial').val()) || 0;

      let volumenEntrada = parseFloat($('#volumen_entrada').val()) || 0;
      let alcoholEntrada = parseFloat($('#alcohol_entrada').val()) || 0;
      let aguaEntrada = parseFloat($('#agua_entrada').val()) || 0;

      let volumenSalida = parseFloat($('#volumen_salida').val()) || 0;
      let alcoholSalida = parseFloat($('#alc_vol_salida').val()) || 0;

      // Cálculo con agua incluida
      let volumenFinal = volumenInicial + volumenEntrada + aguaEntrada - volumenSalida;
      let alcoholFinal = 0;

      if (volumenFinal > 0) {
        let alcoholTotal =
          volumenInicial * alcoholInicial + serieEntrada * alcoholEntrada - serieSalida * alcoholSalida;

        alcoholFinal = alcoholTotal / serieFinal;
      }

      $('#serie_final').val(serieFinal.toFixed(2));
      $('#alc_vol_final').val(alcoholFinal.toFixed(2));
    }

    $(
      '#serie_inicial, #alcohol_inicial, #serie_entrada, #alcohol_entrada, #agua_entrada, #serie_salida, #alc_vol_salida'
    ).on('input', calcular);
  }); */

  $(document).ready(function () {
    $('#tipo_op').on('change', function () {
      const tipo = $(this).val();

      if (tipo == 'Entradas') {
        $('#displaySalidas').fadeOut(100, function () {
          $(this).css('display', 'none');
          $('#displayEntradas').css({ opacity: 0, display: 'block' }).animate({ opacity: 1 }, 200);
        });
      } else if (tipo == 'Salidas') {
        $('#displayEntradas, #displaySalidas').stop(true, true).hide();

        $('#displayEntradas').fadeOut(100, function () {
          $(this).css('display', 'none');
          $('#displaySalidas').css({ opacity: 0, display: 'block' }).animate({ opacity: 1 }, 200);
        });
      } else if (tipo == 'Entradas y salidas') {
        $('#displayEntradas').css({ opacity: 0, display: 'block' }).animate({ opacity: 1 }, 300);
        $('#displaySalidas').css({ opacity: 0, display: 'block' }).animate({ opacity: 1 }, 400);
      } else {
        $('#displayEntradas, #displaySalidas').fadeOut(200);
      }
    });
    $('#displayEntradas, #displaySalidas').hide();
  });

  $(document).ready(function () {
    $('#edit_tipo_op').on('change', function () {
      const tipo = $(this).val();

      if (tipo == 'Entradas') {
        $('#editDisplaySalidas').fadeOut(100, function () {
          $(this).css('display', 'none');
          $('#editDisplayEntradas').css({ opacity: 0, display: 'block' }).animate({ opacity: 1 }, 200);
        });
      } else if (tipo == 'Salidas') {
        $('#editDisplayEntradas').fadeOut(100, function () {
          $(this).css('display', 'none');
          $('#editDisplaySalidas').css({ opacity: 0, display: 'block' }).animate({ opacity: 1 }, 200);
        });
      } else if (tipo == 'Entradas y salidas') {
        $('#editDisplayEntradas').css({ opacity: 0, display: 'block' }).animate({ opacity: 1 }, 300);
        $('#editDisplaySalidas').css({ opacity: 0, display: 'block' }).animate({ opacity: 1 }, 400);
      } else {
        $('#editDisplayEntradas, #editDisplaySalidas').fadeOut(200);
      }
    });

    $('#editDisplayEntradas, #editDisplaySalidas').hide();
  });

  /*     $(document).on('click', '.firma-record', function () {
      var bitacoraID = $(this).data('id');
      $('#bitacora_id_firma').val(bitacoraID);
    });
 */
  /*   $(function () {
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
        PersonaFirmante: {
          validators: {
            notEmpty: {
              message: 'Seleccione un firmante.'
            }
          }
        },
        password: {
          validators: {
            notEmpty: {
              message: 'Ingresa su contraseña.'
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
      const formData = $(form).serialize();
      const id = $('#bitacora_id_firma').val();

      $.ajax({
        url: '/FirmaBitacoraMezcalEnvasador/' + id,
        type: 'POST',
        data: formData,
        success: function (response) {
          $('#offcanvasAddFirma').offcanvas('hide');
          $('#addFirma')[0].reset();
          $('.datatables-users').DataTable().ajax.reload();
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.success || 'La bitácora fue firmada correctamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'aqui debe haber un mensaje de error',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
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
          url: `/FirmaBitacoraHologramasCom/${id_bitacora_firma}`,
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

  $(document).ready(function () {
    // Al abrir modal, disparas la carga inicial para el cliente seleccionado
    $('#RegistrarBitacoraMezcal').on('shown.bs.modal', function () {
      var empresaSeleccionada = $('#id_empresa').val();
      if (empresaSeleccionada) {
        obtenerGraneles(empresaSeleccionada);
      } else {
        /* obtenerDatosGraneles(); */
      }
    });

    // También cuando cambia el select
    $('#id_empresa').on('change', function () {
      var empresa = $(this).val();
      obtenerGraneles(empresa);
    });
  });

  //end
});
