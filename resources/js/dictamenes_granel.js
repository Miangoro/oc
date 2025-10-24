/**
 * Page User List
 */
'use strict';

//flatpickr
$(document).ready(function () {
  flatpickr('.flatpickr-datetime', {
    dateFormat: 'Y-m-d', // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
    enableTime: false, // Desactiva la  hora
    allowInput: true, // Permite al usuario escribir la fecha manualmente
    locale: 'es' // idioma a español
  });
});
//FUNCION FECHAS
$('#fecha_emision').on('change', function () {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
  var fechaVigencia = fechaInicial.toISOString().split('T')[0];
  $('#fecha_vigencia').val(fechaVigencia);
  flatpickr('#fecha_vigencia', {
    dateFormat: 'Y-m-d',
    enableTime: false,
    allowInput: true,
    locale: 'es',
    static: true,
    disable: true
  });
});
//FUNCION FECHAS EDIT
$('#edit_fecha_emision').on('change', function () {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
  var fechaVigencia = fechaInicial.toISOString().split('T')[0];
  $('#edit_fecha_vigencia').val(fechaVigencia);
  flatpickr('#edit_fecha_vigencia', {
    dateFormat: 'Y-m-d',
    enableTime: false,
    allowInput: true,
    locale: 'es',
    static: true,
    disable: true
  });
});

// Datatable (jquery)
$(function () {
  let buttons = [];
  // Si tiene permiso, agregas el botón
  if (puedeAgregarElUsuario) {
    buttons.push({
      text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Nuevo dictamen</span>',
      className: 'add-new btn btn-primary waves-effect waves-light',
      attr: {
        'data-bs-toggle': 'modal',
        'data-bs-target': '#ModalAgregar'
      }
    });
  }

  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2');
  function initializeSelect2($elements) {
    //Función para inicializar Select2
    $elements.each(function () {
      var $this = $(this);
      select2Focus($this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent()
      });
    });
  }
  initializeSelect2(select2Elements);

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //FUNCIONALIDAD DE LA VISTA datatable
  if (dt_user_table.length) {
    var dataTable = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'dictamen-granel-list', //Asegúrate de que esta URL coincida con la ruta en tu archivo de rutas
        type: 'GET'
      },
      columns: [
        { data: '' }, //0
        { data: 'num_dictamen' }, //1
        { data: 'num_servicio' }, //2
        {
          data: null,
          orderable: false, // Se usará null porque combinaremos varios valores
          render: function (data, type, row) {
            return `
              <strong>${data.numero_cliente}</strong><br>
              <span style="font-size:11px">${data.razon_social}<span> `;
          }
        },
        { data: 'nombre_lote' },
        { data: 'fechas' },
        { data: 'estatus' },
        { data: 'action', orderable: false, searchable: false }
      ],
      columnDefs: [
        {
          targets: 0,
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          targets: 1,
          searchable: true,
          orderable: true,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $num_dictamen = full['num_dictamen'];
            return (
              `<small class="fw-bold">` +
              $num_dictamen +
              `</small>` +
              `<i data-id="${full['id_dictamen']}" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"  data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>`
            );
          }
        },
        {
          targets: 2,
          searchable: true,
          orderable: true,
          render: function (data, type, full, meta) {
            var $num_servicio = full['num_servicio'];
            var $folio_solicitud = full['folio_solicitud'];
            if (full['url_acta'] == 'Sin subir') {
              var $acta =
                '<a href="/img_pdf/FaltaPDF.png" target="_blank"> <img src="/img_pdf/FaltaPDF.png" height="25" width="25" title="Ver documento" alt="FaltaPDF"> </a>';
            } else {
              var $acta = full['url_acta']
                .map(
                  url => `
                <i data-id="${full['numero_cliente']}/actas/${url}" data-empresa="${full['razon_social']}"
                    class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfActa"
                    data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
                </i>
              `
                )
                .join('');
            }

            return `
            <span class="fw-bold">Servicio:</span> ${$num_servicio}
              <span>${$acta}</span>
            <br><span class="fw-bold">Solicitud:</span> ${$folio_solicitud}
              <i data-id="${full['id_solicitud']}" data-folio="${$folio_solicitud}"
                class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfSolicitud"
                data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
              </i>
              `;
          }
        },
        {
          //caracteristicas
          targets: 4,
          searchable: true,
          orderable: false,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            return `<div class="small">
                <b>Lote granel:</b> ${full['nombre_lote']} <br>
                <b>FQs:</b> ${
                  Array.isArray(full['fq_documentos']) && full['fq_documentos'].length > 0
                    ? full['fq_documentos'].map(item =>
                        item.url
                          ? `<a href="${item.url}" class="text-primary" target="_blank">${item.folio ?? ''}</a>`
                          : `${item.folio ?? ''}`
                      ).join(', ')
                    : 'Sin FQ registrado'
                } <br>
                <b>Certificado:</b> ${full['certificado'] 
                    ? `<a href="${full['certificado']}" class="text-primary" target="_blank">${full['num_certificado']}</a>`
                    : `${full['num_certificado']}`
                }

                ${full['sustituye'] ? `<br><b>Sustituye:</b> ${full['sustituye']}` : ''}
              </div>`;
          }//<b>FQs: </b> ${full['analisis']}
        },
        {
          //fechas
          targets: 5,
          searchable: true,
          orderable: true,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $fecha_emision = full['fecha_emision'] ?? 'No encontrado';
            var $fecha_vigencia = full['fecha_vigencia'] ?? 'No encontrado';
            return `
                <div>
                    <div><span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Emisión:<br></strong> ${$fecha_emision}</span></div>
                    <div><span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Vigencia:<br></strong> ${$fecha_vigencia}</span></div>
                    <div class="small">${full['diasRestantes']}</div>
                </div> `;
          }
        },
        {
          ///estatus
          targets: 6,
          searchable: false,
          orderable: true,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $estatus = full['estatus'];
            var $fecha_actual = full['fecha_actual'];
            var $vigencia = full['vigencia'];
            let estatus;
            if ($fecha_actual > $vigencia) {
              estatus = '<span class="badge rounded-pill bg-danger">Vencido</span>';
            } else if ($estatus == 1) {
              estatus = '<span class="badge rounded-pill bg-danger">Cancelado</span>';
            } else if ($estatus == 2) {
              estatus = '<span class="badge rounded-pill bg-warning">Reexpedido</span>';
            } else {
              estatus = '<span class="badge rounded-pill bg-success">Emitido</span>';
            }

            return estatus;
          }
        },

        { // Actions botones de eliminar y editar
          targets: -1,
          title: 'Acciones',
          render: function (data, type, full, meta) {
            let cancelado = full['estatus'] == 1;
            let acciones = '';

            //Construir acciones según permisos
            if (cancelado) {
              
            } else {
              if (window.puedeEditarElUsuario) {
                acciones += `<a data-id="${full['id_dictamen']}" 
                    class="dropdown-item waves-effect text-dark editar"
                    data-bs-toggle="modal" data-bs-target="#ModalEditar">
                    <i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>`;
              }
              if (window.puedeReexpedirElUsuario) {
                acciones += `<a data-id="${full['id_dictamen']}" 
                    class="dropdown-item waves-effect text-black reexpedir"
                    data-bs-toggle="modal" data-bs-target="#ModalReexpedir">
                    <i class="ri-file-edit-fill text-success"></i> Reexpedir/Cancelar</a>`;
              }
              if (window.puedeEliminarElUsuario) {
                acciones += `<a data-id="${full['id_dictamen']}" 
                    class="dropdown-item waves-effect text-dark eliminar">
                    <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>`;
              }
            }


            //🔒 Botones sin permisos deshabilitados
            if (!acciones.trim()) {
                return cancelado
                    ? `<button class="btn btn-sm btn-danger" disabled><i class="ri-close-line ri-20px me-1"></i>Cancelado</button>`
                    : `<button class="btn btn-sm btn-secondary" disabled><i class="ri-lock-2-line ri-20px me-1"></i>Opciones</button>`;
            }

            //✅ Botones con permisos
            return `<div class="d-flex align-items-center gap-50">
                      <button class="btn btn-sm btn-${cancelado ? 'danger' : 'info'} 
                        dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="${cancelado ? 'ri-close-line' : 'ri-settings-5-fill'} ri-20px me-1"></i>
                          ${cancelado ? 'Cancelado' : 'Opciones'} 
                          ${cancelado ? '' : '<i class="ri-arrow-down-s-fill ri-20px"></i>'}
                      </button>
                      <div class="dropdown-menu dropdown-menu-end m-0">
                          ${acciones}
                      </div>
                  </div>`;
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
      lengthMenu: [10, 20, 50, 70, 100], //for length of menu
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
      // Buttons with Dropdown
      buttons: buttons,

      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['num_dictamen'];
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



///AGREGAR
$(function () {
  // Configuración CSRF para Laravel
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Inicializar FormValidation
  const form = document.getElementById('FormAgregar');
  const fv = FormValidation.formValidation(form, {
    fields: {
      id_inspeccion: {
        validators: {
          notEmpty: {
            message: 'El número de servicio es obligatorio.'
          }
        }
      },
      num_dictamen: {
        validators: {
          notEmpty: {
            message: 'El número de dictamen es obligatorio.'
          }
        }
      },
      id_firmante: {
        validators: {
          notEmpty: {
            message: 'El nombre del firmante es obligatorio.'
          }
        }
      },
      fecha_emision: {
        validators: {
          notEmpty: {
            message: 'La fecha de emisión es obligatoria.'
          },
          date: {
            format: 'YYYY-MM-DD',
            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
          }
        }
      },
      fecha_vigencia: {
        validators: {
          notEmpty: {
            message: 'La fecha de vigencia es obligatoria.'
          },
          date: {
            format: 'YYYY-MM-DD',
            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
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
    var formData = new FormData(form);

  //deshabilita el boton al guardar
  const $submitBtn = $(form).find('button[type="submit"]');
  $submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line"></i> Guardando...');// Cambiar nombre

    $.ajax({
      url: '/dictamenes-granel',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar el modal y resetear el formulario
        $('#ModalAgregar').modal('hide');
        $('#FormAgregar')[0].reset();
        $('.select2').val(null).trigger('change');
        dataTable.ajax.reload();
        // Mostrar mensaje de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.message,
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      },
      error: function (xhr) {
        const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
        if (isDev) {
            console.log('Error:', xhr);
        }
        // Mostrar mensaje de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      },
      complete: function() {
        $submitBtn.prop('disabled', false).html('<i class="ri-add-line"></i> Registrar');
      }
    });
  });
});



  ///ELIMINAR
  $(document).on('click', '.eliminar', function () {
    var id_dictamen = $(this).data('id');
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
      confirmButtonText: '<i class="ri-check-line"></i> Sí, eliminar',
      cancelButtonText: '<i class="ri-close-line"></i> Cancelar',
      customClass: {
        confirmButton: 'btn btn-primary me-2',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.isConfirmed) {
        // Enviar solicitud DELETE al servidor
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}dictamen/granel/${id_dictamen}`,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            dataTable.draw(false);
            // Mostrar SweetAlert de éxito
            Swal.fire({
              icon: 'success',
              title: '¡Exito!',
              text: response.message,
              customClass: {
                confirmButton: 'btn btn-primary'
              }
            });
          },
          error: function (error) {
            console.log('Error:', error);
            // Mostrar SweetAlert de error
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al eliminar.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // Acción cancelada, mostrar mensaje informativo
        Swal.fire({
          title: '¡Cancelado!',
          text: 'La eliminación ha sido cancelada.',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    });
  });

  ///EDITAR
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario
    const form = document.getElementById('FormEditar');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_inspeccion: {
          validators: {
            notEmpty: {
              message: 'El número de servicio es obligatorio.'
            }
          }
        },
        num_dictamen: {
          validators: {
            notEmpty: {
              message: 'El número de dictamen es obligatorio.'
            }
          }
        },
        id_firmante: {
          validators: {
            notEmpty: {
              message: 'El nombre del firmante es obligatorio.'
            }
          }
        },
        fecha_emision: {
          validators: {
            notEmpty: {
              message: 'La fecha de emisión es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'Ingresa una fecha válida (yyyy-mm-dd).'
            }
          }
        },
        fecha_vigencia: {
          validators: {
            notEmpty: {
              message: 'La fecha de vigencia es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'Ingresa una fecha válida (yyyy-mm-dd).'
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
      // Validar y enviar el formulario cuando pase la validación
      var formData = new FormData(form);
      var dictamen = $('#edit_id_dictamen').val();

      $.ajax({
        url: '/dictamenes/granel/' + dictamen + '/update',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          dataTable.ajax.reload(null, false);
          $('#ModalEditar').modal('hide');
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.message,
            customClass: {
              confirmButton: 'btn btn-primary'
            }
          });
        },
        error: function (xhr) {
          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            var errorMessages = Object.keys(errors)
              .map(function (key) {
                return errors[key].join('<br>');
              })
              .join('<br>');

            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              html: errorMessages,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al actualizar.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        }
      });
    });

    // Función para cargar los datos del dictamen
    $(document).on('click', '.editar', function () {
      var id_dictamen = $(this).data('id');
      $('#edit_id_dictamen').val(id_dictamen);

      cargarLotes();

      $.ajax({
        url: '/dictamenes/granel/' + id_dictamen + '/edit',
        method: 'GET',
        success: function (datos) {

          //obtener la inspeccion ya asignada
          const $select = $('#edit_id_inspeccion');
          // Eliminar opciones anteriores agregadas dinámicamente, pero dejar los disponibles
          $select.find('option[data-dinamico="true"]').remove();

          // Si la inspeccion guardada no está en los disponibles, agregarlo temporalmente
          if (!$select.find(`option[value="${datos.id_inspeccion}"]`).length) {
            const texto = `${datos.num_servicio} | ${datos.folio ?? 'Sin folio'} | ${datos.direccion_completa}`;
            $select.append(`<option value="${datos.id_inspeccion}" selected data-dinamico="true">${texto}</option>`);
          } else {
            $select.val(datos.id_inspeccion).trigger('change');
          }

          // Asignar valores a los campos del formulario
          $('#edit_id_inspeccion').val(datos.id_inspeccion).trigger('change');
          $('#edit_num_dictamen').val(datos.num_dictamen);
          $('#edit_fecha_emision').val(datos.fecha_emision);
          $('#edit_fecha_vigencia').val(datos.fecha_vigencia);
          $('#edit_id_firmante').val(datos.id_firmante).prop('selected', true).change();

          flatpickr('#edit_fecha_emision', {
            //Actualiza flatpickr
            dateFormat: 'Y-m-d',
            enableTime: false,
            allowInput: true,
            locale: 'es'
          });
          // Mostrar el modal
          $('#ModalEditar').modal('show');
        },
        error: function (error) {
          console.error('Error al cargar los datos:', error);
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al cargar los datos.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });



  ///REEXPEDIR
let isLoadingData = false;
let fieldsValidated = [];
$(document).ready(function () {
    $(document).on('click', '.reexpedir', function () {
      var id_dictamen = $(this).data('id');
      console.log('ID Dictamen para reexpedir:', id_dictamen);
      $('#rex_id_dictamen').val(id_dictamen);
      $('#ModalReexpedir').modal('show');
    });

    //funcion fechas
    $('#rex_fecha_emision').on('change', function () {
      var fecha_emision = $(this).val();
      if (fecha_emision) {
        var fecha = moment(fecha_emision, 'YYYY-MM-DD');
        var fecha_vigencia = fecha.add(1, 'years').format('YYYY-MM-DD');
        $('#rex_fecha_vigencia').val(fecha_vigencia);
      }
    });

    $(document).on('change', '#accion_reexpedir', function () {
      var accionSeleccionada = $(this).val();
      console.log('Acción seleccionada:', accionSeleccionada);
      var id_dictamen = $('#rex_id_dictamen').val();

      if (accionSeleccionada && !isLoadingData) {
        isLoadingData = true;
        cargarDatosReexpedicion(id_dictamen);
      }

      if (accionSeleccionada === '2') {
        $('#campos_condicionales').slideDown();
      } else {
        $('#campos_condicionales').slideUp();
      }
    });

    function cargarDatosReexpedicion(id_dictamen) {
      console.log('Cargando datos para la reexpedición con ID:', id_dictamen);
      clearFields();

      $.get(`/dictamenes/granel/${id_dictamen}/edit`)
        .done(function (datos) {
          console.log('Respuesta completa:', datos);

          if (datos.error) {
            showError(datos.error);
            return;
          }

          //obtener la inspeccion ya asignada
          const $select = $('#rex_id_inspeccion');
          // Eliminar opciones anteriores agregadas dinámicamente, pero dejar los disponibles
          $select.find('option[data-dinamico="true"]').remove();

          // Si la inspeccion guardada no está en los disponibles, agregarlo temporalmente
          if (!$select.find(`option[value="${datos.id_inspeccion}"]`).length) {
            const texto = `${datos.num_servicio} | ${datos.folio ?? 'Sin folio'} | ${datos.direccion_completa}`;
            $select.append(`<option value="${datos.id_inspeccion}" selected data-dinamico="true">${texto}</option>`);
          } else {
            $select.val(datos.id_inspeccion).trigger('change');
          }

          // Asignar valores a los campos del formulario
          $('#rex_id_inspeccion').val(datos.id_inspeccion).trigger('change');
          $('#rex_numero_dictamen').val(datos.num_dictamen);
          $('#rex_fecha_emision').val(datos.fecha_emision);
          $('#rex_fecha_vigencia').val(datos.fecha_vigencia);
          $('#rex_id_firmante').val(datos.id_firmante).trigger('change');

          $('#accion_reexpedir').trigger('change');
          isLoadingData = false;

          flatpickr('#rex_fecha_emision', {
            //Actualiza flatpickr
            dateFormat: 'Y-m-d',
            enableTime: false,
            allowInput: true,
            locale: 'es'
          });
        })
        .fail(function () {
          showError('Error al cargar los datos.');
          isLoadingData = false;
        });
    }

    function clearFields() {
      $('#rex_id_inspeccion').val('');
      $('#rex_numero_dictamen').val('');
      $('#rex_id_firmante').val('');
      $('#rex_fecha_emision').val('');
      $('#rex_fecha_vigencia').val('');
      $('#rex_observaciones').val('');
      $('.nombre_lote').val('');
      $('.folio_fq').val('');
      $('.volumen').val('');
      $('.cont_alc').val('');
      $('.edad').val('');
      $('.ingredientes').val('');
      $('.id_categoria').val('');
      $('.id_clase').val('');
      $('.id_tipo').val([]).change();
      $('#id_inspeccion').val('').change();
    }

    function showError(message) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: message,
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    }

    $('#ModalAgregar').on('hidden.bs.modal', function () {
      clearFields();
      fieldsValidated = [];
    });

    $('#ModalEditar').on('hidden.bs.modal', function () {
      clearFields();
      fieldsValidated = [];
    });

    $('#ModalReexpedir').on('hidden.bs.modal', function () {
      $('#FormReexpedir')[0].reset();
      clearFields();
      $('#campos_condicionales').hide();
      fieldsValidated = [];
    });

    const formReexpedir = document.getElementById('FormReexpedir');
    const validatorReexpedir = FormValidation.formValidation(formReexpedir, {
      fields: {
        accion_reexpedir: {
          validators: {
            notEmpty: {
              message: 'Debes seleccionar una acción.'
            }
          }
        },
        observaciones: {
          validators: {
            notEmpty: {
              message: 'El motivo de cancelación es obligatorio.'
            }
          }
        },
        id_inspeccion: {
          validators: {
            notEmpty: {
              message: 'El número de servicio es obligatorio.'
            }
          }
        },
        num_dictamen: {
          validators: {
            notEmpty: {
              message: 'El número de dictamen es obligatorio.'
            },
            stringLength: {
              min: 8,
              message: 'Debe tener al menos 8 caracteres.'
            }
          }
        },
        id_firmante: {
          validators: {
            notEmpty: {
              message: 'El nombre del firmante es obligatorio.'
            }
          }
        },
        fecha_emision: {
          validators: {
            notEmpty: {
              message: 'La fecha de emisión es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'Ingresa una fecha válida (yyyy-mm-dd).'
            }
          }
        },
        fecha_vigencia: {
          validators: {
            notEmpty: {
              message: 'La fecha de vigencia es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'Ingresa una fecha válida (yyyy-mm-dd).'
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
      const formData = $(formReexpedir).serialize();

      $.ajax({
        url: $(formReexpedir).attr('action'),
        method: 'POST',
        data: formData,
        success: function (response) {
          $('#ModalReexpedir').modal('hide');
          formReexpedir.reset();

          dt_user_table.DataTable().ajax.reload();
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.message,
            customClass: {
              confirmButton: 'btn btn-primary'
            }
          });
        },
        error: function (jqXHR) {
          console.log('Error en la solicitud:', jqXHR);
          let errorMessage = 'No se pudo registrar. Por favor, verifica los datos.';
          try {
            let response = JSON.parse(jqXHR.responseText);
            errorMessage = response.message || errorMessage;
          } catch (e) {
            console.error('Error al parsear la respuesta del servidor:', e);
          }
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: errorMessage,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
});



  ///FORMATO PDF DICTAMEN
  $(document).on('click', '.pdfDictamen', function () {
    var id = $(this).data('id'); //Obtén el ID desde el atributo "data-id" en PDF
    var pdfUrl = '/dictamen_granel/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $('#NewPestana').attr('href', pdfUrl).show();

    $('#titulo_modal').text('Dictamen de Cumplimiento NOM Mezcal a Granel');
    $('#subtitulo_modal').text('PDF del Dictamen');
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  ///FORMATO PDF SOLICITUD
  $(document).on('click', '.pdfSolicitud', function () {
    var id = $(this).data('id');
    var folio = $(this).data('folio');
    var pdfUrl = '/solicitud_de_servicio/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $('#NewPestana').attr('href', pdfUrl).show();

    $('#titulo_modal').text('Solicitud de servicios');
    $('#subtitulo_modal').html('<p class="solicitud badge bg-primary">' + folio + '</p>');
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  ///FORMATO PDF ACTA
  $(document).on('click', '.pdfActa', function () {
    var id_acta = $(this).data('id');
    var empresa = $(this).data('empresa');
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', '/files/' + id_acta);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $('#NewPestana')
      .attr('href', '/files/' + id_acta)
      .show();

    $('#titulo_modal').text('Acta de inspección');
    $('#subtitulo_modal').text(empresa);

    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  /*
///FQ'S
$(document).on('click', '.ver-folio-fq', function (e) {
  e.preventDefault();

  var idDictamen = $(this).data('id');

  $.ajax({
    url: '/dictamenes/granel/' + idDictamen + '/foliofq',
    method: 'GET',
    success: function (response) {
      console.log('Response:', response); // Verifica todo el objeto de respuesta

      if (response.success) {
        var documentos = response.documentos;
        var $tableBody = $('#documentosTableBody');
        $tableBody.empty(); // Limpiar contenido previo

        // Mostrar ícono al archivo PDF si está disponible
        var documentoOtroOrganismo = documentos.find(doc => doc.tipo.includes('Certificado de lote a granel'));
        var nombre = documentoOtroOrganismo && documentoOtroOrganismo.nombre ? documentoOtroOrganismo.nombre : 'Sin nombre disponible';

        if (documentoOtroOrganismo) {
          $tableBody.append('<tr><td>Certificado de lote a granel:</td><td>' + nombre + '</td><td><a href="#" class="ver-pdf" data-url="../files/' + response.numeroCliente + '/' + documentoOtroOrganismo.url + '" data-title="' + nombre + '"><i class="ri-file-pdf-2-fill text-danger fs-1"></i></a></td></tr>');
        } else {
          $tableBody.append('<tr><td>Certificado de lote a granel:</td><td>Sin nombre disponible</td><td>No hay certificado disponible.</td></tr>');
        }

        // Documentos certificados por OC CIDAM
        var documentoCompletoAsignado = false;
        var documentoAjusteAsignado = false;

        documentos.forEach(function (documento) {
          var nombreDocumento = documento.nombre || 'Sin nombre disponible';
          var documentoHtml = '<a href="#" class="ver-pdf" data-url="../files/' + response.numeroCliente + '/' + documento.url + '" data-title="' + nombreDocumento + '"><i class="ri-file-pdf-2-fill text-danger fs-1"></i></a>';

          if (documento.tipo.includes('Análisis completo') && !documentoCompletoAsignado) {
            $tableBody.append('<tr><td>Certificado (Análisis Completo):</td><td>' + nombreDocumento + '</td><td>' + documentoHtml + '</td></tr>');
            documentoCompletoAsignado = true;
          }
          if (documento.tipo.includes('Ajuste de grado') && !documentoAjusteAsignado) {
            $tableBody.append('<tr><td>Certificado (Ajuste de Grado):</td><td>' + nombreDocumento + '</td><td>' + documentoHtml + '</td></tr>');
            documentoAjusteAsignado = true;
          }
        });

        if (!documentoCompletoAsignado) {
          $tableBody.append('<tr><td>Certificado (Análisis Completo):</td><td>Sin nombre disponible</td><td>No hay certificado disponible.</td></tr>');
        }
        if (!documentoAjusteAsignado) {
          $tableBody.append('<tr><td>Certificado (Ajuste de Grado):</td><td>Sin nombre disponible</td><td>No hay certificado disponible.</td></tr>');
        }

        // Mostrar el modal de ver documentos
        $('#modalVerDocumento').modal('show');
      } else {
        console.log('No success in response'); // Mensaje si el success es falso
        $('#documentosTableBody').html('<tr><td colspan="3">No se pudo cargar el documento.</td></tr>');
      }
    },
    error: function (xhr, status, error) {
      console.log('Error AJAX:', error);
      $('#documentosTableBody').html('<tr><td colspan="3">Ocurrió un error al intentar cargar el documento.</td></tr>');
    }
  });
});

//VER PDF FQ'S
$(document).on('click', '.ver-pdf', function (e) {
  e.preventDefault();
  var url = $(this).data('url'); // Obtén la URL del PDF desde el atributo data-url
  var title = $(this).data('title'); // Obtén el título del PDF desde el atributo data-title
  var iframe = $('#pdfViewerFolio');
  var spinner = $('#loading-spinner');

  // Mostrar el spinner y ocultar el iframe antes de cargar el PDF
  spinner.show();
  iframe.hide();

  // Actualizar el título del modal
  $("#titulo_modal_Folio").text(title);
  // Ocultar el modal de ver documentos antes de mostrar el modal del PDF
  $('#modalVerDocumento').modal('hide');
  // Mostrar el modal para el PDF
  $('#mostrarPdfFolio').modal('show');

  // Cargar el PDF en el iframe
  iframe.attr('src', url);

  // Asegurarse de que el evento `load` del iframe está manejado correctamente
  iframe.off('load').on('load', function () {
    spinner.hide();
    iframe.show();
  });

  // Reabrir el modal de ver documentos cuando se cierre el modal del PDF
  $('#mostrarPdfFolio').on('hidden.bs.modal', function () {
    $('#modalVerDocumento').modal('show');
  });
});
*/
});
