'use strict';

$(function () {
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
        url: baseUrl + 'bitacoraMezcal-list',
        data: function (d) {
          d.empresa = $('#filtroEmpresa').val();
          d.instalacion = $('#filtroInstalacion').val();
        }
      },
      columns: [
      { data: null }, // 0 -> # (control o vacío)
      { data: 'fake_id' }, // 1 -> ID
      { data: 'razon_social' }, // 2 -> Cliente (campo directo)
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
          render: function (data, type, full, meta) {
            var $fecha = full['fecha'] ?? 'N/A';
            var $id_lote_granel = full['nombre_lote'] ?? 'N/A';
            var $folio_fq = full['folio_fq'] ?? 'N/A';
            var $certificado = full['folio_certificado'] ?? 'N/A';
            return (
              '<span class="fw-bold small">Fecha: </span>' +
              '<span class="small">' +
              $fecha +
              '</span>' +
              '<br><span class="fw-bold small">Lote a Granel: </span>' +
              '<span class="small">' +
              $id_lote_granel +
              '</span>' +
              '<br><span class="fw-bold small">Folio FQ: </span>' +
              '<span class="small">' +
              $folio_fq +
              '</span>' +
              '<br><span class="fw-bold small">Certificado: </span>' +
              '<span class="small">' +
              $certificado +
              '</span>'
            );
          }
        },
        {
          targets: 4,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $procedencia_entrada = full['procedencia_entrada'] ?? 'N/A';
            var $volumen_entrada = full['volumen_entrada'] ?? 'N/A';
            var $alcohol_entrada = full['alcohol_entrada'] ?? 'N/A';
            var $agua_entrada = full['agua_entrada'] ?? 'N/A';

            return (
              '<span class="fw-bold small">Procedencia: </span>' +
              '<span class="small">' +
              $procedencia_entrada +
              '</span>' +
              '<br><span class="fw-bold small">Volumen: </span>' +
              '<span class="small">' +
              $volumen_entrada +
              '</span>' +
              '<br><span class="fw-bold small">%Alc. Vol.: </span>' +
              '<span class="small">' +
              $alcohol_entrada +
              '</span>' +
              '<br><span class="fw-bold small">Agua Agregada: </span>' +
              '<span class="small">' +
              $agua_entrada +
              '</span>'
            );
          }
        },
        ////salidas
        {
          targets: 5,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $volumen_salidas = full['volumen_salidas'] ?? 'N/A';
            var $alcohol_salidas = full['alcohol_salidas'] ?? 'N/A';
            var $destino_salidas = full['destino_salidas'] ?? 'N/A';

            return (
              '<span class="fw-bold small">Volumen de Salidas: </span>' +
              '<span class="small">' +
              $volumen_salidas +
              '</span>' +
              '<br><span class="fw-bold small">%Alc. Vol. de Salidas: </span>' +
              '<span class="small">' +
              $alcohol_salidas +
              '</span>' +
              '<br><span class="fw-bold small">Destino de Salidas: </span>' +
              '<span class="small">' +
              $destino_salidas +
              '</span>'
            );
          }
        },
        {
          targets: 6,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $volumen_final = full['volumen_final'] ?? 'N/A';
            var $alcohol_final = full['alcohol_final'] ?? 'N/A';

            return (
              '<span class="fw-bold small">Volumen Final: </span>' +
              '<span class="small">' +
              $volumen_final +
              '</span>' +
              '<br><span class="fw-bold small">%Alc. Vol. Final: </span>' +
              '<span class="small">' +
              $alcohol_final +
              '</span>'
            );
          }
        },
        {
          targets: 7,
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
          targets: 8,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center gap-50">' +
              '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
              '<i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>' +
              '</button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              //firmar
              `<a data-id="${full['id']}" class="dropdown-item firma-record waves-effect text-warning">` +
              '<i class="ri-ball-pen-line ri-20px text-warning"></i> Firmar bitácora</a>' +
              /* data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddFirma" */
              // Botón para editar
              `<a data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#editarBitacoraMezcal" class="dropdown-item edit-record waves-effect text-info">` +
              '<i class="ri-edit-box-line ri-20px text-info"></i> Editar bitácora ' +
              '</a>' +
              // Botón para eliminar
              `<a data-id="${full['id']}" class="dropdown-item delete-record waves-effect text-danger">` +
              '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar bitácora ' +
              '</a>' +
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
        '<"d-flex flex-wrap justify-content-between align-items-center w-100 px-3 pt-2"' +
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
          text: '', // 👈 importante que esté vacío
          init: function (api, node, config) {
            // Remover clases no deseadas que DataTables agrega
            $(node).removeClass('btn btn-secondary');

            // Inyectar el select correctamente
            $(node).html(`
              <select id="filtroEmpresa" class="form-select select2" style="min-width: 280px;">
                <option value="">-- Todas las Empresas --</option>
                ${opcionesEmpresas}
              </select>
            `);

            // Activar Select2
            $(node).find('select').select2();
          }
        },
        {
          text: '',
          className: 'dt-custom-select p-0 me-2 btn-outline-dark form-select-sm',
          init: function (api, node, config) {
            $(node).removeClass('btn btn-secondary');
            $(node).html(`
              <select id="filtroInstalacion" class="form-select select2" style="min-width: 280px;">
                <option value="">-- Todas las Instalaciones --</option>
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
        {
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Bitácora</span>',
          className: 'add-new btn btn-primary me-2 mb-2 mb-sm-2 mt-4 mt-md-0 waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#RegistrarBitacoraMezcal'
          }
        }
      ],

      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de Certificado de Instalaciones: ' + data['nombre_lote'];
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
    $('#filtroEmpresa').next('.select2-container').find('.select2-selection__rendered').attr('title', selectedText);
  });

  $('#filtroEmpresa, #filtroInstalacion').on('change', function () {
    $('.datatables-users').DataTable().ajax.reload();
  });

  $(document).ready(function () {
    $('#filtroEmpresa').on('change', function () {
      let empresaId = $(this).val();

      if (empresaId) {
        $.ajax({
          url: '/getDatos/' + empresaId,
          method: 'GET',
          success: function (response) {
            let opciones = '<option value="">-- Todas las Instalaciones --</option>';

            if (response.instalaciones.length > 0) {
              response.instalaciones.forEach(function (inst) {
                let tipoLimpio = limpiarTipo(inst.tipo); // función tuya, asumo que limpia el texto
                opciones += `<option value="${inst.id_instalacion}">${tipoLimpio} | ${inst.direccion_completa}</option>`;
              });
            } else {
              opciones += '<option value="">Sin instalaciones registradas</option>';
            }

            $('#filtroInstalacion').html(opciones).trigger('change'); // actualiza Select2 también
          },
          error: function () {
            $('#filtroInstalacion').html('<option value="">Error al cargar</option>');
          }
        });
      } else {
        $('#filtroInstalacion').html('<option value="">-- Todas las Instalaciones --</option>');
      }
    });
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
    const iframe = $('#pdfViewer');
    // Construye la URL con filtros
    let urlPDF = `/bitacora_mezcal?empresa=${empresaId}`;
    if (instalacionId) {
      urlPDF += `&instalacion=${instalacionId}`;
    }
    urlPDF += `&t=${new Date().getTime()}`;
    // Spinner y reset
    $('#cargando').show();
    iframe.hide().attr('src', '');
    iframe.attr('src', urlPDF);
    $('#NewPestana').attr('href', urlPDF).hide();
    // Títulos del modal
    $('#titulo_modal').text('Bitácora Mezcal a Granel');
    $('#subtitulo_modal').text('Versión Filtrada');
    // Mostrar modal
    // Ocultar el spinner cuando el PDF esté completamente cargado
    $('#pdfViewer').on('load', function () {
      $('#cargando').hide();
      $(this).show();
    });
    $('#mostrarPdf').modal('show');
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
          url: `${baseUrl}bitacoraMezcal-list/${id_bitacora}`,
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
        id_lote_granel: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el lote'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la instalación'
            }
          }
        },
        volumen_final: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen final'
            }
          }
        },
        alc_vol_final: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el contenido alcohólico final'
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
        url: '/bitacoraMezcalStore',
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
          $('#id_lote_granel').empty().trigger('change');
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
    $('#id_empresa, #id_lote_granel, #fecha').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });
  });

  $(document).on('click', '.edit-record', function () {
    var bitacoraID = $(this).data('id');
    $('#edit_bitacora_id').val(bitacoraID);
    $.ajax({
      url: '/bitacora_mezcal/' + bitacoraID + '/edit',
      method: 'GET',
      success: function (data) {
        if (data.success) {
          var bitacora = data.bitacora;

          $('#edit_bitacora_id').val(bitacora.id);
          $('#edit_id_empresa').val(bitacora.id_empresa).trigger('change');
          $('#edit_fecha').val(bitacora.fecha);
          $('#edit_id_lote_granel').data('selected', bitacora.id_lote_granel).trigger('change');
          $('#edit_id_instalacion').data('selected', bitacora.id_instalacion).trigger('change');
          $('#edit_operacion_adicional').val(bitacora.operacion_adicional);
          $('#edit_volumen_inicial').val(bitacora.volumen_inicial);
          $('#edit_alcohol_inicial').val(bitacora.alcohol_inicial);
          /*  */
          $('#edit_tipo_op').val(bitacora.tipo_operacion).trigger('change');

          $('#edit_procedencia_entrada').val(bitacora.procedencia_entrada);
          $('#edit_volumen_entrada').val(bitacora.volumen_entrada);
          $('#edit_alcohol_entrada').val(bitacora.alcohol_entrada);
          $('#edit_agua_entrada').val(bitacora.agua_entrada);
          $('#edit_volumen_salida').val(bitacora.volumen_salida);
          $('#edit_alc_vol_salida').val(bitacora.alc_vol_salida);
          $('#edit_destino').val(bitacora.destino);
          $('#edit_volumen_final').val(bitacora.volumen_final);
          $('#edit_alc_vol_final').val(bitacora.alc_vol_final);
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
        }
      });
    });
  });

  $(document).ready(function () {
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
          volumenInicial * alcoholInicial + volumenEntrada * alcoholEntrada - volumenSalida * alcoholSalida;

        alcoholFinal = alcoholTotal / volumenFinal;
      }

      $('#volumen_final').val(volumenFinal.toFixed(2));
      $('#alc_vol_final').val(alcoholFinal.toFixed(2));
    }

    $(
      '#volumen_inicial, #alcohol_inicial, #volumen_entrada, #alcohol_entrada, #agua_entrada, #volumen_salida, #alc_vol_salida'
    ).on('input', calcular);
  });

  $(document).ready(function () {
    $('#tipo_op').on('change', function () {
      const tipo = $(this).val();

      if (tipo == 'Entradas') {
        $('#displaySalidas').fadeOut(100, function () {
          $(this).css('display', 'none');
          $('#displayEntradas').css({ opacity: 0, display: 'block' }).animate({ opacity: 1 }, 200);
        });
      } else if (tipo == 'Salidas') {
        $('#displayEntradas').fadeOut(100, function () {
          $(this).css('display', 'none');
          $('#displaySalidas').css({ opacity: 0, display: 'block' }).animate({ opacity: 1 }, 200);
        });
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
        url: '/Firmar_bitacorasMezcal/' + id,
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
  });

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
          url: `/FirmaBitacoraMezcal/${id_bitacora_firma}`,
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

  //end
});
