
'use strict';

///flatpickr
$(document).ready(function () {
  flatpickr(".flatpickr-datetime", {
      dateFormat: "Y-m-d", // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
      enableTime: false,   // Desactiva la  hora
      allowInput: true,    // Permite al usuario escribir la fecha manualmente
      locale: "es",        // idioma a español
  });
});

//FUNCION FECHAS
$('#fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
  var fechaVigencia = fechaInicial.toISOString().split('T')[0];
  $('#fecha_vigencia').val(fechaVigencia);
  flatpickr("#fecha_vigencia", {
      dateFormat: "Y-m-d",
      enableTime: false,
      allowInput: true,
      locale: "es",
      static: true,
      disable: true
  });
});
//FUNCION FECHAS EDIT
$('#edit_fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
  var fechaVigencia = fechaInicial.toISOString().split('T')[0];
  $('#edit_fecha_vigencia').val(fechaVigencia);
  flatpickr("#edit_fecha_vigencia", {
      dateFormat: "Y-m-d",
      enableTime: false,
      allowInput: true,
      locale: "es",
      static: true,
      disable: true
  });
});




 $(function () {
  let buttons = [];

  if (puedeRegistrarCertificado) {
    // Botón para agregar certificado
    buttons.push({
      text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo certificado</span>',
      className: 'add-new btn btn-primary waves-effect waves-light me-2', // ← Agregamos me-2 para dar espacio
      attr: {
        'data-bs-toggle': 'modal',
        'data-bs-dismiss': 'modal',
        'data-bs-target': '#ModalAgregar'
      }
    });

    // Botón para exportar directorio
    buttons.push({
      text: '<i class="ri-download-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Exportar directorio</span>',
      className: 'btn btn-success waves-effect waves-light',
      action: function (e, dt, node, config) {
        const selectedEmpresa = $('#empresaSelect').val(); // Ajusta los IDs si varían en esta página
        const selectedAnio = $('#anioSelect').val();
        const selectedMes = $('#mesSelect').val();
        const selectedEstatus = $('#estatusSelect').val();

        const params = new URLSearchParams({
          id_empresa: selectedEmpresa,
          anio: selectedAnio,
          mes: selectedMes,
          estatus: selectedEstatus
        }).toString();

        const totalFiltrados = dt.rows({ search: 'applied' }).count();
        Swal.fire({
          title: '¿Exportar directorio?',
          text: `Se exportarán ${totalFiltrados} registros.`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Sí, exportar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '/descargar_reporte_directorio?' + params;
          }
        });
      }
    });
  }

  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
  select2 = $('.select2'),
  userView = baseUrl + 'app/user/view/account',
  offCanvasForm = $('#offcanvasAddUser');

var select2Elements = $('.select2');
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


// ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });



///FUNCIONALIDAD DE LA VISTA datatable
   if (dt_user_table.length) {
     var dataTable = dt_user_table.DataTable({
       processing: true,
       serverSide: true,
       ajax: {
         url: baseUrl + 'certificados-list',
       },
       columns: [
        { data: '' }, // (0)
        { data: 'num_certificado' },//(1)
        { data: ''},
        {data: null, orderable: false,// Se usará null porque combinaremos varios valores
         render: function(data, type, row) {
             return `
             <strong>${data.numero_cliente}</strong><br>
                 <span style="font-size:12px">${data.razon_social}<span>
             `;
           }
        },
        { data: '' },
        { data: 'fechas' },
        { data: '' },//Revisores
        { data: 'action' }
       ],
       columnDefs: [
         {
           targets: 0,
           className: 'control',
           searchable: false,
           orderable: false,
           responsivePriority: 2,
           render: function (data, type, full, meta) {
             return '';
           }
         },
         {
          targets: 1,
          searchable: true,
          orderable: true,
          render: function (data, type, full, meta) {
            var $num_certificado = full['num_certificado'];
            var $tipo =full['tipo_dictamen'];
            var $id = full['id_certificado'];
            var $pdf_firmado  = full['pdf_firmado'];

            if ($pdf_firmado) {
              var $icono = `<a href="${$pdf_firmado}" target="_blank" title="Ver PDF firmado">
                <i class="ri-file-pdf-2-fill text-success ri-28px cursor-pointer"></i> </a>`;
            } else {
              var $icono = `<i data-id="${$id}" data-tipo="${$tipo}" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfCertificado" data-bs-toggle="modal" data-bs-target="#mostrarPdf"></i>`;
            }

            return '<small class="fw-bold">' +$num_certificado+ '</small>' +
                  $icono +
                `<br><small><span class="fw-bold">Dictamen:</span> ${full['num_dictamen']}</small>
                  <i data-id="${full['id_dictamen']}" data-tipo="${full['tipo_dictamen']}" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>`;

            }
        },
        {
        //Tabla 2
          targets: 2,
          searchable: true,
          orderable: true,
          render: function (data, type, full, meta) {
            var $num_servicio = full['num_servicio'];
            var $folio_solicitud = full['folio_solicitud'];
            if ( full['url_acta'] == 'Sin subir' ) {
              var $acta = '<a href="/img_pdf/FaltaPDF.png" target="_blank"> <img src="/img_pdf/FaltaPDF.png" height="25" width="25" title="Ver documento" alt="FaltaPDF"> </a>'
            }else {
              var $acta = full['url_acta'].map(url => `
                <i data-id="${full['numero_cliente']}/actas/${url}" data-empresa="${full['razon_social']}"
                   class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfActa"
                   data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
                </i>
              `).join('');//concatena en un string.
            }

            return `
            <small><b>Servicio:</b> ${$num_servicio}</small>
              <span>${$acta}</span>
            <br><small><b>Solicitud:</b> ${$folio_solicitud}</small>
              <i data-id="${full['id_solicitud']}" data-folio="${$folio_solicitud}"
                class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfSolicitud"
                data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
              </i>
            `;
          }
        },
        {
          targets: 4,
          searchable: true,
          orderable: false,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $tipoDictamen = parseInt(full['tipo_dictamen']);
            var $colorDictamen;
            var $nombreDictamen;

            switch ($tipoDictamen) {
              case 1:
                $nombreDictamen = 'Productor';
                $colorDictamen = 'primary'; // Azul
                break;
              case 2:
                $nombreDictamen = 'Envasador';
                $colorDictamen = 'success'; // Verde
                break;
              case 3:
                $nombreDictamen = 'Comercializador';
                $colorDictamen = 'info'; // Celeste
                break;
              case 4:
                $nombreDictamen = 'Almacén y bodega';
                $colorDictamen = 'danger'; // Rojo
                break;
              case 5:
                $nombreDictamen = 'Área de maduración';
                $colorDictamen = 'warning'; // Amarillo
                break;
              default:
                $nombreDictamen = 'Desconocido';
                $colorDictamen = 'secondary'; // Gris, color por defecto
            }

            // Retorna el badge con el texto y color apropiado
            return `<span class="badge rounded-pill bg-${$colorDictamen}">${$nombreDictamen}</span>
                <br><small>${full['direccion_completa']}
                ${full['sustituye'] ? `<br><b>Sustituye:</b> ${full['sustituye']}` : ''} </small>`;
          }
        },
        {//fechas
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
          targets: 6,
          searchable: false,
          orderable: true,
          className: 'text-center',
          render: function (data, type, full, meta) {
            //estatus
            var $estatus = full['estatus'];
            var $fecha_actual = full['fecha_actual'];
            var $vigencia = full['vigencia'];
            var $pdf_firmado  = full['pdf_firmado'];//si hay archivo subido
            let estatus;
            
            if ($fecha_actual > $vigencia) {
              estatus = '<span class="badge rounded-pill bg-danger">Vencido</span>';
            } else {
              let badge = '';
              let texto = '';
                  if ($estatus == 1) {
                    badge = 'bg-danger';
                    texto = 'Cancelado';
                  } else if ($estatus == 2) {
                    badge = 'bg-warning';
                    texto = 'Reexpedido';
                  } else {
                    badge = $pdf_firmado ? 'bg-success' : 'bg-secondary';
                    texto = $pdf_firmado ? 'Emitido' : 'Pre-certificado';
                  }
              estatus = `<span class="badge rounded-pill ${badge}">${texto}</span>`;
            }

            ///revisores PERSONAL
            var $revisor_personal = full['revisor_personal'];
            var $numero_revision_personal = full['numero_revision_personal'];
            const decision_personal = full['decision_personal'];
            const respuestas_personal = full['respuestas_personal'] ? JSON.parse(full['respuestas_personal']) : {};

            const observaciones_personal = Object.values(respuestas_personal).some(r =>
                r.some(({ observacion }) => observacion?.toString().trim()) );

            const icono_oc = observaciones_personal
              ? `<i class="ri-alert-fill text-warning"></i>`
              : '';

            let revisor_oc = $revisor_personal !== null ? $revisor_personal  : `<b style="color: red;">Sin asignar</b>`;

            let revision_oc = $numero_revision_personal === 1 ? ''
              : $numero_revision_personal === 2 ? 'Segunda revisión - '
              : '';

            let colorClass = '';
              if (decision_personal === 'positiva') {
                colorClass = 'badge rounded-pill bg-primary';
              } else if (decision_personal === 'negativa') {
                colorClass = 'badge rounded-pill bg-danger';
              } else if (decision_personal === 'Pendiente') {
                colorClass = 'badge rounded-pill bg-warning text-dark';
              }

            ///revisores CONSEJO
            var $revisor_consejo = full['revisor_consejo'];
            var $numero_revision_consejo = full['numero_revision_consejo'];
            const decision_consejo = full['decision_consejo'];
            const respuestas_consejo = full['respuestas_consejo'] ? JSON.parse(full['respuestas_consejo']) : {};

            const observaciones2 = Object.values(respuestas_consejo).some(r =>
                r.some(({ observacion }) => observacion?.toString().trim()) );

            const icono2 = observaciones2
              ? `<i class="ri-alert-fill text-warning"></i>`
              : '';

            let revisor2 = $revisor_consejo !== null ? $revisor_consejo  : `<b style="color: red;">Sin asignar</b>`;

            let revision2 = $numero_revision_consejo === 1 ? ''
              : $numero_revision_consejo === 2 ? 'Segunda revisión - '
              : '';

            let colorClass2 = '';
              if (decision_consejo === 'positiva') {
                colorClass2 = 'badge rounded-pill bg-primary';
              } else if (decision_consejo === 'negativa') {
                colorClass2 = 'badge rounded-pill bg-danger';
              } else if (decision_consejo === 'Pendiente') {
                colorClass2 = 'badge rounded-pill bg-warning text-dark';
              }

            return estatus +
              `<div style="flex-direction: column; margin-top: 2px;">
                <div class="small"> <b>Personal:</b>
                  <span class="${colorClass}">${revision_oc} ${revisor_oc}</span>${icono_oc}
                </div>
                <div style="display: inline;" class="small"> <b>Consejo:</b>
                  <span class="${colorClass2}">${revision2} ${revisor2}</span>${icono2}
                </div>
              </div> `;
          }
        },
         {
           // Actions
           targets: 7,
           title: 'Acciones',
           searchable: false,
           orderable: false,
            render: function (data, type, full, meta) {
              if (full['estatus'] == 1) {
                if (window.puedeVerTrazabilidadCertificado) {
                  return `
                    <div class="d-flex align-items-center gap-50">
                      <button class="btn btn-sm btn-danger disabled">
                        Cancelado
                      </button>
                      <div class="dropdown-menu dropdown-menu-end m-0">
                        <a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}"
                          data-bs-toggle="modal" data-bs-target="#ModalTracking"
                          class="dropdown-item waves-effect text-black trazabilidad">
                          <i class="ri-history-line text-secondary"></i> Trazabilidad
                        </a>
                      </div>
                    </div>
                  `;
                } else {
                  return `
                    <button class="btn btn-sm btn-danger disabled">Cancelado</button>
                  `;
                }
              }

              let acciones = '';

              if (window.puedeEditarCertificado) {
                acciones += `<a data-id="${full['id_certificado']}" class="dropdown-item waves-effect text-dark editar" data-bs-toggle="modal" data-bs-target="#ModalEditar">
                              <i class="ri-edit-box-line ri-20px text-info"></i> Editar
                            </a>`;
              }

              if (window.puedeSubirCertificado) {
                acciones += `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" class="dropdown-item waves-effect text-dark subirPDF" data-bs-toggle="modal" data-bs-target="#ModalCertificadoFirmado">
                              <i class="ri-upload-2-line ri-20px text-secondary"></i> Adjuntar PDF
                            </a>`;
              }

              if (window.puedeAsignarRevisorCertificado) {
                acciones += `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" class="dropdown-item waves-effect text-dark" data-bs-toggle="modal" data-bs-target="#asignarRevisorModal">
                              <i class="text-warning ri-user-search-fill"></i> Asignar revisor
                            </a>`;
              }

              if (window.puedeVerTrazabilidadCertificado) {
                acciones += `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" data-bs-toggle="modal" data-bs-target="#ModalTracking" class="dropdown-item waves-effect text-black trazabilidad">
                              <i class="ri-history-line text-secondary"></i> Trazabilidad
                            </a>`;
              }

              if (window.puedeReexpedirCertificado) {
                acciones += `<a data-id="${full['id_certificado']}" class="dropdown-item waves-effect text-black reexpedir" data-bs-toggle="modal" data-bs-target="#ModalReexpedir">
                              <i class="ri-file-edit-fill text-success"></i> Reexpedir/Cancelar
                            </a>`;
              }

              if (window.puedeEliminarCertificado) {
                acciones += `<a data-id="${full['id_certificado']}" class="dropdown-item waves-effect text-black eliminar">
                              <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar
                            </a>`;
              }

              if (!acciones.trim()) {
                return `
                  <button class="btn btn-sm btn-secondary" disabled>
                    <i class="ri-lock-line ri-20px me-1"></i> Opciones
                  </button>
                `;
              }

              return `
                <div class="d-flex align-items-center gap-50">
                  <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ri-settings-5-fill"></i>&nbsp;Opciones<i class="ri-arrow-down-s-fill ri-20px"></i>
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
                 "sFirst":    "Primero",
                 "sLast":     "Último",
                 "sNext":     "Siguiente",
                 "sPrevious": "Anterior"
               }
       },
       // Opciones Exportar Documentos
       buttons: buttons,
        responsive: {
         details: {
           display: $.fn.dataTable.Responsive.display.modal({
             header: function (row) {
               var data = row.data();
               return 'Detalles del certificado: ' + data['num_certificado'];
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




///AGREGAR REGISTRO
$(function () {

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Mostrar/ocultar campos condicionales según el tipo de dictamen
  $('select[name="id_dictamen"]').on('change', function () {
    const tipoDictamen = $(this).find('option:selected').data('tipo-dictamen');

    if (tipoDictamen == 1) {
        $('#CamposCondicionales_tipo').show();
    } else {
        $('#CamposCondicionales_tipo').hide();
        $('#maestro_mezcalero').val('');
        //$('#no_autorizacion').val('');
    }
  });

//Validación del formulario por "name"
  const form = document.getElementById('FormAgregar');
  const fv = FormValidation.formValidation(form, {
    fields: {
    'id_dictamen': {
      validators: {
        notEmpty: {
            message: 'El número de dictamen es obligatorio.'
        }
      }
    },
    'num_certificado': {
        validators: {
          notEmpty: {
              message: 'El número de certificado es obligatorio.'
          }
        }
    },
    'id_firmante': {
      validators: {
        notEmpty: {
            message: 'El nombre del firmante es obligatorio.'
        }
      }
    },
    'fecha_emision': {
      validators: {
        notEmpty: {
            message: 'La fecha de emision es obligatoria.'
        },
        date: {
          format: 'YYYY-MM-DD',
          message: 'Ingresa una fecha válida (yyyy-mm-dd).'
        }
      }
    },
    'fecha_vigencia': {
      validators: {
        notEmpty: {
            message: 'La fecha de vigencia es obligatoria.'
        },
        date: {
          format: 'YYYY-MM-DD',
          message: 'Ingresa una fecha válida (yyyy-mm-dd).'
        }
      }
    },
    'maestro_mezcalero': {
      validators: {
        stringLength: {
          max: 60,
          message: 'Máximo 60 caracteres.'
        }
      }
    },
   /* 'num_autorizacion': {
      validators: {
        regexp: {
          regexp: /^[0-9]*$/,
          message: 'Solo se permiten números.'
        }
      }
    },*/
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
    $.ajax({
      url: '/certificados-list',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar y resetear el formulario
        $('#ModalAgregar').modal('hide');
        $('#FormAgregar')[0].reset();
        dataTable.ajax.reload();//Recarga los datos del datatable

        // Mostrar alerta de éxito
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
        console.log('Error:', xhr);
        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });

  });

});



///ELIMINAR
$(document).on('click', '.eliminar', function () {
  var id_certificado = $(this).data('id');
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
      url: `${baseUrl}certificados-list/${id_certificado}`,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
        success: function (response) {
          dataTable.draw(false);//Actualizar la tabla, "null,false" evita que vuelva al inicio
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
          console.log(error);
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
    // Acción cancelar
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

  // Mostrar/ocultar campos condicionales según el tipo de dictamen
  $('#edit_id_dictamen').on('change', function () {
    const tipoDictamen = $(this).find('option:selected').data('tipo-dictamen');

    if (tipoDictamen == 1) {
        $('#Edit_CamposCondicionales_tipo').show();
    } else {
        $('#Edit_CamposCondicionales_tipo').hide();
        $('#edit_maestro_mezcalero').val('');
        //$('#edit_num_autorizacion').val('');
    }
  });

  // Inicializar FormValidation para el formulario
  const form = document.getElementById('FormEditar');
  const fv = FormValidation.formValidation(form, {
    fields: {
      'id_dictamen': {
        validators: {
          notEmpty: {
              message: 'El número de dictamen es obligatorio.'
          }
        }
      },
      'num_certificado': {
          validators: {
            notEmpty: {
                message: 'El número de certificado es obligatorio.'
            }
          }
      },
      'id_firmante': {
        validators: {
          notEmpty: {
              message: 'El nombre del firmante es obligatorio.'
          }
        }
      },
      'fecha_emision': {
        validators: {
          notEmpty: {
              message: 'La fecha de emision es obligatoria.'
          },
          date: {
            format: 'YYYY-MM-DD',
            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
          }
        }
      },
      'fecha_vigencia': {
        validators: {
          notEmpty: {
              message: 'La fecha de vigencia es obligatoria.'
          },
          date: {
            format: 'YYYY-MM-DD',
            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
          }
        }
      },
      /*'maestro_mezcalero': {
        validators: {
          stringLength: {
            max: 60,
            message: 'Máximo 60 caracteres.'
          }
        }
      },
      'num_autorizacion': {
        validators: {
          regexp: {
            regexp: /^[0-9]*$/,
            message: 'Solo se permiten números.'
          }
        }
      },*/
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
      var id_certificado = $('#edit_id_certificado').val();

      $.ajax({
          url: `/certificados-list/${id_certificado}`,
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            dataTable.ajax.reload(null, false);//Recarga los datos del datatable, "null,false" evita que vuelva al inicio
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
            //error de validación
            if (xhr.status === 422) {
              var errors = xhr.responseJSON.errors;
              var errorMessages = Object.keys(errors).map(function (key) {
                return errors[key].join('<br>');
              }).join('<br>');

              Swal.fire({
                icon: 'error',
                title: '¡Error!',
                html: errorMessages,
                customClass: {
                  confirmButton: 'btn btn-danger'
                }
              });
            } else {//otro tipo de error
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

  // Función para cargar los datos
  $(document).on('click', '.editar', function () {
      var id_certificado = $(this).data('id');
      $('#edit_id_id_certificado').val(id_certificado);

      $.ajax({
          url: `/certificados-list/${id_certificado}/edit`,
          method: 'GET',
          success: function (datos) {

const $select = $('#edit_id_dictamen');
// Eliminar opciones anteriores agregadas dinámicamente, pero dejar los disponibles
$select.find('option[data-dinamico="true"]').remove();
function obtenerTextoTipoDictamen(tipo) {
    switch (String(tipo)) {
        case '1': return 'Productor';
        case '2': return 'Envasador';
        case '3': return 'Comercializador';
        case '4': return 'Almacén y bodega';
        case '5': return 'Área de maduración';
        default: return tipo ?? 'Desconocido';
    }
}
const tipoTexto = obtenerTextoTipoDictamen(datos.tipo_dictamen);
// Si el dictamen guardado no está en los disponibles, agregarlo temporalmente
if (!$select.find(`option[value="${datos.id_dictamen}"]`).length) {
    const texto = `${datos.num_dictamen} | ${tipoTexto} | ${datos.folio ?? 'Sin folio'}`;
    $select.append(`<option value="${datos.id_dictamen}" selected data-dinamico="true">${texto}</option>`);
} else {
    $select.val(datos.id_dictamen).trigger('change');
}

              // Asignar valores a los campos del formulario
              $('#edit_id_certificado').val(datos.id_certificado);
              $('#edit_id_dictamen').val(datos.id_dictamen).trigger('change');
              $('#edit_num_certificado').val(datos.num_certificado);
              $('#edit_fecha_emision').val(datos.fecha_emision);
              $('#edit_fecha_vigencia').val(datos.fecha_vigencia);
              $('#edit_id_firmante').val(datos.id_firmante).prop('selected', true).change();
              $('#edit_maestro_mezcalero').val(datos.maestro_mezcalero || '');
              //$('#edit_num_autorizacion').val(datos.num_autorizacion || '');
            //$('#edit_id_firmante').val(dictamen.id_firmante).trigger('change');//funciona igual que arriba

              flatpickr("#edit_fecha_emision", {//Actualiza flatpickr para mostrar la fecha correcta
                dateFormat: "Y-m-d",
                enableTime: false,
                allowInput: true,
                locale: "es"
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
      var id_certificado = $(this).data('id');
      console.log('ID para reexpedir:', id_certificado);
      $('#rex_id_certificado').val(id_certificado);
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

  // Mostrar/ocultar campos según el tipo de dictamen
  $('#rex_id_dictamen').on('change', function () {
    const tipoDictamen = $(this).find('option:selected').data('tipo-dictamen');

    if (tipoDictamen == 1) {
      $('#rex_CamposCondicionales_tipo').slideDown();
    } else {
      $('#rex_CamposCondicionales_tipo').slideUp();
      $('#rex_maestro_mezcalero').val('');
      //$('#rex_num_autorizacion').val('');
    }
  });

  $(document).on('change', '#accion_reexpedir', function () {
    var accionSeleccionada = $(this).val();
    console.log('Acción seleccionada:', accionSeleccionada);
    var id_certificado = $('#rex_id_certificado').val();

      if (accionSeleccionada && !isLoadingData) {
          isLoadingData = true;
          cargarDatosReexpedicion(id_certificado);
      }

      if (accionSeleccionada === '2') {
        $('#campos_condicionales').slideDown();
      }else {
          $('#campos_condicionales').slideUp();
      }
  });


  function cargarDatosReexpedicion(id_certificado) {
      console.log('Cargando datos para la reexpedición con ID:', id_certificado);
      clearFields();

      //cargar los datos
      $.get(`/certificados-list/${id_certificado}/edit`).done(function (datos) {
      console.log('Respuesta completa:', datos);

          if (datos.error) {
              showError(datos.error);
              return;
          }

//obtener el dictamen ya asignado
const $select = $('#rex_id_dictamen');
// Eliminar opciones anteriores agregadas dinámicamente, pero dejar los disponibles
$select.find('option[data-dinamico="true"]').remove();

// Si el dictamen guardado no está en los disponibles, agregarlo temporalmente
if (!$select.find(`option[value="${datos.id_dictamen}"]`).length) {
    const texto = `${datos.num_dictamen} | ${datos.folio ?? 'Sin folio'}`;
    $select.append(`<option value="${datos.id_dictamen}" selected data-dinamico="true">${texto}</option>`);
} else {
    $select.val(datos.id_dictamen).trigger('change');
}

          $('#rex_id_dictamen').val(datos.id_dictamen).trigger('change');
          $('#rex_numero_certificado').val(datos.num_certificado);
          $('#rex_id_firmante').val(datos.id_firmante).trigger('change');
          $('#rex_fecha_emision').val(datos.fecha_emision);
          $('#rex_fecha_vigencia').val(datos.fecha_vigencia);

          // Mostrar campos adicionales si tipo_dictamen es 1
          if (parseInt(datos.tipo_dictamen) === 1) {
            $('#rex_CamposCondicionales_tipo').stop(true, true).slideDown('fast');
            $('#rex_maestro_mezcalero').val(datos.maestro_mezcalero || '');
            //$('#rex_num_autorizacion').val(datos.num_autorizacion || '');
          } else {
            $('#rex_CamposCondicionales_tipo').stop(true, true).slideUp('fast', function () {
                $('#rex_maestro_mezcalero').val('');
                //$('#rex_num_autorizacion').val('');
            });
          }

          $('#accion_reexpedir').trigger('change');
          isLoadingData = false;

          flatpickr("#rex_fecha_emision", {//Actualiza flatpickr para mostrar la fecha correcta
            dateFormat: "Y-m-d",
            enableTime: false,
            allowInput: true,
            locale: "es"
          });

      }).fail(function () {
              showError('Error al cargar los datos.');
              isLoadingData = false;
      });
  }

  function clearFields() {
      $('#rex_id_dictamen').val('');
      $('#rex_numero_certificado').val('');
      $('#rex_id_firmante').val('');
      $('#rex_fecha_emision').val('');
      $('#rex_fecha_vigencia').val('');
      $('#rex_observaciones').val('');
      $('#rex_maestro_mezcalero').val('');
      //$('#rex_num_autorizacion').val('');
      $('#rex_campos_condicionales_tipo').hide();
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

  $('#ModalReexpedir').on('hidden.bs.modal', function () {
      $('#FormReexpedir')[0].reset();
      clearFields();
      $('#campos_condicionales').hide();
      fieldsValidated = [];
  });

  //validar formulario
  const formReexpedir = document.getElementById('FormReexpedir');
  const validatorReexpedir = FormValidation.formValidation(formReexpedir, {
      fields: {
        'accion_reexpedir': {
            validators: {
                notEmpty: {
                    message: 'Debes seleccionar una acción.'
                }
            }
        },
        'observaciones': {
            validators: {
                notEmpty: {
                    message: 'El motivo de cancelación es obligatorio.'
                }
            }
        },
        'id_dictamen': {
            validators: {
                notEmpty: {
                    message: 'El número de dictamen es obligatorio.'
                }
            }
        },
        'num_certificado': {
            validators: {
                notEmpty: {
                    message: 'El número de certificado es obligatorio.'
                },
                stringLength: {
                  min: 19,
                  message: 'Debe tener al menos 19 caracteres.'
                }
            }
        },
        'id_firmante': {
            validators: {
                notEmpty: {
                    message: 'El nombre del firmante es obligatorio.'
                }
            }
        },
        'fecha_emision': {
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
        'fecha_vigencia': {
          validators: {
            notEmpty: {
              message: 'La fecha de vigencia es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'Ingresa una fecha válida (yyyy-mm-dd).'
            }
          }
        },
        /*'maestro_mezcalero': {
          validators: {
            stringLength: {
              max: 60,
              message: 'Máximo 60 caracteres.'
            }
          }
        },
        'num_autorizacion': {
          validators: {
            regexp: {
              regexp: /^[0-9]*$/,
              message: 'Solo se permiten números.'
            }
          }
        },*/
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





///OBTENER REVISORES
function cargarRevisores() {
  $.get('/ruta-para-obtener-revisores', { tipo: 1 }, function (data) {
    $('#personalOC').empty().append('<option value="" disabled selected>Seleccione personal OC</option>');
    data.forEach(function (rev) {
      $('#personalOC').append(`<option value="${rev.id}">${rev.name}</option>`);
    });
  });

  $.get('/ruta-para-obtener-revisores', { tipo: 4 }, function (data) {
    $('#miembroConsejo').empty().append('<option value="" disabled selected>Seleccione miembro del consejo</option>');
    data.forEach(function (rev) {
      $('#miembroConsejo').append(`<option value="${rev.id}">${rev.name}</option>`);
    });
  });
}
function actualizarEstiloVisualSelects() {///aviso de seleccion
  ['#personalOC', '#miembroConsejo'].forEach(function (id) {
    const select2Container = $(id).next('.select2-container');
    if (!$(id).val()) {
      select2Container.addClass('select2-empty');
    } else {
      select2Container.removeClass('select2-empty');
    }
  });
}
$(document).ready(function () {//funcion cargar y asignar color
    // Inicializar Select2
    $('#personalOC, #miembroConsejo').select2({
      dropdownParent: $('#asignarRevisorModal') // si están dentro de modal
    });
    cargarRevisores();

    // Esperar a que se carguen opciones y aplicar estilo visual
    setTimeout(actualizarEstiloVisualSelects, 500);
    // Actualizar estilo cuando cambie selección
    $('#personalOC, #miembroConsejo').on('change', function () {
      actualizarEstiloVisualSelects();
    });
});

///CARGAR DATOS DE REVISIÓN AL ABRIR EL MODAL
$('#asignarRevisorModal').on('show.bs.modal', function (event) {
  const button = $(event.relatedTarget);
  const idCertificado = button.data('id');

  $('#id_certificado').val(idCertificado);
  $('#folio_certificado').html(`<span class="badge bg-info">${button.data('folio')}</span>`);
  $('#asignarRevisorForm')[0].reset();
  $('.select2').val(null).trigger('change');
  $('#documentoRevision').empty();

  // Cargar observaciones y documento (tipo_revision = 1)
  $.get(`/obtener-revision-insta/${idCertificado}`, function (data) {
    if (data.exists) {
      $('#observaciones').val(data.observaciones || '');
      $('#esCorreccion').prop('checked', data.es_correccion === 'si');

      if (data.documento) {
        $('#documentoRevision').html(`
          <p>Documento actual:
            <a href="${data.documento.url}" target="_blank">${data.documento.nombre}</a>
          </p>
          <button type="button" class="btn btn-outline-danger btn-sm" id="EliminarDocRevisor">
            <i class="ri-delete-bin-line"></i> Eliminar
          </button>
        `);
      } else {
        $('#documentoRevision').html('<p>No hay documento cargado.</p>');
      }
    } else {
      $('#observaciones').val('');
      $('#esCorreccion').prop('checked', false);
      $('#documentoRevision').html('<p>No hay documento cargado.</p>');
    }
  });
});

///ELIMINAR DOCUMENTO REVISION
$(document).on('click', '#EliminarDocRevisor', function () {
  const idCertificado = $('#id_certificado').val();

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
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: `/eliminar-doc-revision-insta/${idCertificado}`,
        method: 'DELETE',
        success: function (res) {
          $('#documentoRevision').html('<p>Documento eliminado.</p>');
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: res.message,
            customClass: {
              confirmButton: 'btn btn-primary'
            }
          });
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: xhr.responseJSON?.message || 'No se pudo eliminar el documento.'
          });
        }
      });
    }
  });
});

///ASIGNAR REVISION
$('#asignarRevisorForm').on('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(this);
  const idCertificado = $('#id_certificado').val();
  formData.append('id_certificado', idCertificado);

  const archivo = $('#archivo_documento').val();
  const nombreDoc = $('#nombre_documento').val();
  if (archivo && !nombreDoc) {
    Swal.fire({ icon: 'warning', title: 'Falta el nombre del documento' });
    return;
  }

  const esCorreccion = $('#esCorreccion').is(':checked') ? 'si' : 'no';
  formData.append('esCorreccion', esCorreccion);
  formData.append('numeroRevision', $('#numeroRevision').val());
  formData.append('id_documento', 133);//fijo

  $.ajax({
    url: '/asignar-revisor',
    method: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (res) {
      $('#asignarRevisorModal').modal('hide');
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: res.message,
        customClass: { confirmButton: 'btn btn-primary' }
      });
      $('#asignarRevisorForm')[0].reset();
      $('.datatables-users').DataTable().ajax.reload();
    },
    error: function (xhr) {
      $('#asignarRevisorModal').modal('hide');
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: xhr.responseJSON?.message || 'Error inesperado.'
      });
    }
  });
});





///FORMATO PDF CERTIFICADO
$(document).on('click', '.pdfCertificado', function ()  {
  var id = $(this).data('id');//Obtén el ID desde el atributo "data-id" en PDF
  var tipo = $(this).data('tipo');
  var iframe = $('#pdfViewer');
  var spinner = $('#cargando');
  let sinMarca;
  let titulo;
  let url;

    switch (tipo) {
      case 1:
        titulo = 'Certificado Productor';
        url = '../certificado_productor_mezcal/' + id;
        sinMarca = '../certificado_productor_mezcal_sin_marca/' + id;
        break;
      case 2:
        titulo = 'Certificado Envasador';
        url = '../certificado_envasador_mezcal/' + id;
        sinMarca = '../certificado_envasador_mezcal_sin_marca/' + id;
        break;
      case 3:
        titulo = 'Certificado Comercializador';
        url = '../certificado_comercializador/' + id;
        sinMarca = '../certificado_comercializador_sin_marca/' + id;
        break;
      case 4:
        titulo = 'Certificado Almacén y bodega';
        url = '';
        sinMarca = '';
        break;
      case 5:
        titulo = 'Certificado Área de maduración';
        url ='';
        sinMarca = '';
        break;
      default:
        titulo = 'Desconocido';
        url ='';
        sinMarca = '';
    }
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', url);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', url).show();

    $("#titulo_modal").text(titulo);
    $("#subtitulo_modal").text("PDF del Certificado");

        if ($('#btnDescargarDinamico').length === 0) {
      var botonDescarga = $(`
        <a id="btnDescargarDinamico" href="${sinMarca}" class="btn btn-secondary ms-2" download>
          Certificado sin marca de agua
        </a>
      `);
      // Insertar el botón junto al de Nueva Pestaña
      $('#NewPestana').after(botonDescarga);
    } else {
      // Solo actualizar el href si ya existe
      $('#btnDescargarDinamico').attr('href', sinMarca).show();
    }

    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
});

///FORMATO PDF DICTAMEN
$(document).on('click', '.pdfDictamen', function ()  {
  var id = $(this).data('id');
  var tipo = $(this).data('tipo');
  var iframe = $('#pdfViewer');
  var spinner = $('#cargando');

    if(tipo == 1){ // Productor
      var url = '../dictamen_productor/'+id;
      var titulo = "Dictamen de productor";
    }
    if(tipo == 2){ // Envasador
      var url = '../dictamen_envasador/'+id;
      var titulo = "Dictamen de envasador";
    }
    if(tipo == 3){ // Comercializador
      var url = '../dictamen_comercializador/'+id;
      var titulo = "Dictamen de comercializador";
    }
    if(tipo == 4){ // Almacén y bodega
      var url = '../dictamen_almacen/'+id;
      var titulo = "Dictamen de almacén y bodega";
    }
    if(tipo == 5){ // Área de maduración
      var url = '../dictamen_maduracion/'+id;
      var titulo = "Dictamen de área de maduración de mezcal";
    }

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    //Cargar el PDF con el ID
    iframe.attr('src', url);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', url).show();
    $("#titulo_modal").text(titulo);
    $("#subtitulo_modal").text("PDF del Dictamen");
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
});

///FORMATO PDF SOLICITUD SERVICIOS
$(document).on('click', '.pdfSolicitud', function ()  {
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
    $("#NewPestana").attr('href', pdfUrl).show();

    $("#titulo_modal").text("Solicitud de servicios");
    $("#subtitulo_modal").html('<p class="solicitud badge bg-primary">' + folio + '</p>');
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
    $("#NewPestana").attr('href', '/files/' + id_acta).show();

    $("#titulo_modal").text("Acta de inspección");
    $("#subtitulo_modal").text(empresa);

    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
});




//Abrir PDF Bitacora
$(document).on('click', '.pdf', function () {
  var id_revisor = $(this).data('id');
  var num_certificado = $(this).data('num-certificado');
  var tipoRevision = $(this).data('tipo_revision');
    console.log('ID de la revision:', id_revisor);
    console.log('Tipo revisor OC/consejo:', tipoRevision);//1=OC, 2=Consejo
    console.log('Número Certificado:', num_certificado);
    // Definir URL según el tipo de revisión
    //if (tipoRevision === 'Instalaciones de productor' || tipoRevision === 'Instalaciones de envasador' || tipoRevision === 'Instalaciones de comercializador' || tipoRevision === 'Instalaciones de almacén o bodega' || tipoRevision === 'Instalaciones de área de maduración') {
    if (tipoRevision === 'Instalaciones de productor' || tipoRevision === 'Instalaciones de envasador' || tipoRevision === 'Instalaciones de comercializador' || tipoRevision === 'Instalaciones de almacén o bodega' || tipoRevision === 'Instalaciones de área de maduración') {
      var url_pdf = '../pdf_bitacora_revision_certificado_instalaciones/' + id_revisor;
    }
    if (tipoRevision === 'Granel') {
      var url_pdf = '../pdf_bitacora_revision_certificado_granel/' + id_revisor;
    }
    //if (tipoRevision === 'Exportación') {
    if (tipoRevision === 2) {
      var url_pdf = '../pdf_bitacora_revision_personal/' + id_revisor;
    }
    if (tipoRevision === 1) {
      var url_pdf = '../pdf_bitacora_revision_personal/' + id_revisor;
    }


    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    $('#cargando').show();
    $('#pdfViewer').hide();

    //Cargar el PDF con el ID
    $('#pdfViewer').attr('src', url_pdf);
    //Abrir PDF en nueva pestaña
    $("#NewPestana").attr('href', url_pdf).show();

    $("#titulo_modal").text("Bitácora de revisión documental");
    $("#subtitulo_modal").html('<span class="badge bg-info">'+num_certificado+'</span>');

    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    $('#pdfViewer').on('load', function () {
      $('#cargando').hide();
      $('#pdfViewer').show();
    });
});

///VER TRAZABILIDAD
$(document).on('click', '.trazabilidad', function () {
  var id_certificado = $(this).data('id');
  $('.num_certificado').text($(this).data('folio'));
  var url = '/trazabilidad-certificados/' + id_certificado;

  $.get(url, function (data) {
    if (data.success) {
      var logs = data.logs;
      var contenedor = $('#ListTracking');
      contenedor.empty();

      let voboPersonalHtml = '';
      let voboClienteHtml = '';
      $('<style>')
      .prop('type', 'text/css')
      .html(`
        .border-blue { border: 2px solid #007bff !important; }
        .border-purple { border: 2px solid #6f42c1 !important; }
        .border-danger { border: 2px solid #ff0000 !important; }
      `)
      .appendTo('head');


      // Extraemos y guardamos los Vo.Bo. (solo uno de cada)
      logs.forEach(function (log) {
        if (!voboPersonalHtml && log.vobo_personal) {
          voboPersonalHtml = `
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="mt-2 pb-3 border border-blue p-3 rounded">
                <h6 class="text-primary"><i class="ri-user-line me-1"></i> Vo.Bo. del Personal</h6>
                ${log.vobo_personal}
              </div>
            </li><hr>`;
        }
        if (!voboClienteHtml && log.vobo_cliente) {
          voboClienteHtml = `
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="mt-2 pb-3 border border-blue p-3 rounded">
                <h6 class="text-success"><i class="ri-user-line me-1"></i> Revisión del cliente</h6>
                ${log.vobo_cliente}
              </div>
            </li><hr>`;
        }
      });

      // Calculamos el máximo orden_personalizado (aseguramos cubrir hasta 7)
      const maxOrdenLogs = logs.length > 0 ? Math.max(...logs.map(l => l.orden_personalizado)) : 0;
      const maxOrden = Math.max(maxOrdenLogs, 7);

      // Insertar logs en orden y colocar Vo.Bo. en posiciones 4 y 7
      for (let i = 1; i <= maxOrden; i++) {
        logs.forEach(log => {
          if (log.orden_personalizado === i) {
            // Mapeamos el tipo a una clase de color
            let borderClase = '';
            switch (log.tipo_bloque) {
              case 'registro':
                borderClase = 'border-blue';
                break;
              case 'asignacion':
                borderClase = 'border-purple';
                break;
              case 'resultado_positivo':
                borderClase = 'border-primary';
                break;
              case 'resultado_negativo':
                borderClase = 'border-danger';
                break;
              case 'cancelado':
                borderClase = 'border-danger';
                break;
              default:
                borderClase = 'border-secondary';
            }

            contenedor.append(`
              <li class="timeline-item timeline-item-transparent">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event border ${borderClase} p-3 rounded">
                  <div class="timeline-header mb-3">
                    <h6 class="mb-0">${log.description}</h6>
                    <small class="text-muted">${log.created_at}</small>
                  </div>
                  <p class="mb-2">${log.contenido}</p>
                  <div class="d-flex align-items-center mb-1">
                    ${log.bitacora} ${log.bitacora2}
                  </div>
                </div>
              </li><hr>
            `);
          }
        });

        // Insertar Vo.Bo. en orden 12 y 23
        if (i === 12 && voboPersonalHtml) {
          contenedor.append(voboPersonalHtml);
        }
        if (i === 23 && voboClienteHtml) {
          contenedor.append(voboClienteHtml);
        }
      }

      $('#ModalTracking').modal('show');
    }
  }).fail(function (xhr) {
    console.error(xhr.responseText);
  });
});




///SUBIR CERTIFICADO FIRMADO
$('#FormCertificadoFirmado').on('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    url: '/certificados/instalacion/documento',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: response.message,
        customClass: {
            confirmButton: 'btn btn-primary'
        }
      });
      $('#ModalCertificadoFirmado').modal('hide');
      $('#FormCertificadoFirmado')[0].reset();
      $('#documentoActual').empty();
      dataTable.ajax.reload(null, false); // Si usas datatables
    },
    error: function (xhr) {

      console.log(xhr.responseText);
      if (xhr.status === 422) {
        // Error de validación
        Swal.fire({
          icon: 'warning',
          title: 'Error al subir',
          text: 'El documento no debe ser mayor a 3MB',
          //footer: `<pre>${xhr.responseText}</pre>`,
          customClass: {
            confirmButton: 'btn btn-warning'
          }
        });
      } else {
        // Otro tipo de error (500, 404, etc.)
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al subir el documento.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }

    }
  });
});

///OBTENER CERTIFICADO FIRMADO
$(document).on('click', '.subirPDF', function () {
  var id = $(this).data('id');
  var num_certificado = $(this).data('folio');
  $('#doc_id_certificado').val(id);
  $('#documentoActual').html('Cargando documento...');
  $('#botonEliminarDocumento').empty(); // <-- Limpia el botón eliminar al cambiar
  $('#modalTitulo').html('Certificado de instalaciones firmado <span class="badge bg-info">' +num_certificado+ '</span>');//Titulo

  $.ajax({
    url: `/certificados/instalacion/documento/${id}`,
    type: 'GET',
    success: function (response) {
      if (response.documento_url && response.nombre_archivo) {
        $('#documentoActual').html(
          `<p>Documento actual:
            <a href="${response.documento_url}" target="_blank">${response.nombre_archivo}</a>
          </p>`);
          $('#botonEliminarDocumento').html(
            `<button type="button" class="btn btn-outline-danger btn-sm" id="btnEliminarDocumento"><i class="ri-delete-bin-line"></i> Eliminar</button>`
          );
      } else {
        $('#documentoActual').html('<p>No hay documento cargado.</p>');
      }
    },
    error: function () {
      $('#documentoActual').html('<p class="text-danger">Error al cargar el documento.</p>');
    }
  });
});

///BORRAR CERTIFICADO FIRMADO
$(document).on('click', '#btnEliminarDocumento', function () {
  const id_certificado = $('#doc_id_certificado').val();

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
        url: `/certificados/instalacion/documento/${id_certificado}`, // ← Ruta ajustada
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
          dataTable.draw(false); //Actualizar la tabla sin reiniciar
          $('#documentoActual').html('<p>No hay documento cargado.</p>');
          $('#botonEliminarDocumento').empty();

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









});
