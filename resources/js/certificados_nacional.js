/*
 Page User List
 */
'use strict';


$(document).ready(function () {///flatpickr
  flatpickr(".flatpickr-datetime", {
    dateFormat: "Y-m-d", // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
    enableTime: false,   // Desactiva la  hora
    allowInput: true,    // Permite al usuario escribir la fecha manualmente
    locale: "es",        // idioma a español
  });
});
/*
//FUNCION FECHAS
$('#fecha_emision').on('change', function () {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setDate(fechaInicial.getDate() + 90); // +90 días
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
// FUNCION FECHAS EDIT
$('#edit_fecha_emision').on('change', function () {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setDate(fechaInicial.getDate() + 90); // +90 días
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
*/



///Datatable (jquery)
$(function () {
  let buttons = [];
  let buttons2 = [];
  // Si tiene permiso, agregas el botón
  if (puedeRegistrarCertificadoVentaNacional) {
    buttons.push({
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Certificado</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#ModalAgregar'
          }
    });
  }
    if (puedeFirmarCertificadoVentaNacional) {
    buttons2.push({
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Firmar Docusign</span>',
          className: 'btn btn-info waves-effect waves-light me-2',
          action: function (e, dt, node, config) {
            window.location.href = '/add_firmar_docusign';
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
        url: baseUrl + 'CerVentaNacional-list'
      },
      columns: [
        { data: '' }, // (0)
        { data: 'num_certificado' },//(1)
        {
          data: '',/*null, //soli y serv.
            render: function(data, type, row) {
            return `<span style="font-size:14px"> <strong>${data.folio}</strong><br>
                ${data.n_servicio}<span>`;
            }*/
        },
        {
          data: null, // Se usará null porque combinaremos varios valores
          render: function (data, type, row) {
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
          targets: 1,
          orderable: true,
          searchable: true,
          render: function (data, type, full, meta) {
            var $num_certificado = full['num_certificado'];
            var $id = full['id_certificado'];
            var $folio_nacional = full['folio_solicitud_nacional'];
            var $pdf_firmado = full['pdf_firmado'];

            if ($pdf_firmado) {
              var icono = `<a href="${$pdf_firmado}" target="_blank" title="Ver PDF firmado">
                <i class="ri-file-pdf-2-fill text-success ri-28px cursor-pointer"></i> </a>`;
            } else {
              var icono = '<i data-id="' + $id + '" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfCertificado" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>';
            }

            return '<small class="fw-bold">' + $num_certificado + '</small>' +
              `${icono}` +
              /* '<i data-id="' + $id + '" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfCertificado" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>' + */
              `<br><span class="fw-bold">Solicitud:</span> ${$folio_nacional} <i data-id="${full['id_solicitud_nacional']}" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfSolicitudCertificado" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>
`;
          }
        },
        {
          //Tabla 2
          targets: 2,
          searchable: true,
          orderable: false,
          render: function (data, type, full, meta) {
            var $num_servicio = full['num_servicio'];
            var $folio_solicitud = full['folio_solicitud'];
            if (full['url_acta'] == 'Sin subir') {
              var $acta = '<a href="/img_pdf/FaltaPDF.png" target="_blank"> <img src="/img_pdf/FaltaPDF.png" height="25" width="25" title="Ver documento" alt="FaltaPDF"> </a>'
            } else {
              var $acta = full['url_acta'].map(url => `
                <i data-id="${full['numero_cliente']}/actas/${url}" data-empresa="${full['razon_social']}"
                   class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfActa"
                   data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
                </i>
              `).join('');//concatena en un string.
            }

            return `
            <span class="fw-bold">Dictamen:</span> ${full['num_dictamen']}
              <i data-id="${full['id_dictamen']}" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"
                data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
              </i>
            <br><span class="fw-bold">Servicio:</span> ${$num_servicio}
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
                <b>Lote envasado:</b> ${full['nombre_lote_envasado']} <br>
                <b>Lote granel:</b> ${full['nombre_lote_granel']} <br>
                <b>Marca:</b> ${full['marca']} <br>
                <b>Cajas:</b> ${full['cajas']} <br>
                <b>Botellas:</b> ${full['botellas']}

                ${full['sustituye'] ? `<br><b>Sustituye:</b> ${full['sustituye']}` : ''}
              </div>`;
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
        {//estatus
          targets: 6,
          searchable: false,
          orderable: true,
          className: 'text-center',
          render: function (data, type, full, meta) {
            //estatus
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

            ///revisores PERSONAL
            var $revisor_personal = full['revisor_personal'];
            var $numero_revision_personal = full['numero_revision_personal'];
            const decision_personal = full['decision_personal'];
            const respuestas_personal = full['respuestas_personal'] ? JSON.parse(full['respuestas_personal']) : {};

            const observaciones_personal = Object.values(respuestas_personal).some(r =>
              r.some(({ observacion }) => observacion?.toString().trim()));

            const icono_oc = observaciones_personal
              ? `<i class="ri-alert-fill text-warning"></i>`
              : '';

            let revisor_oc = $revisor_personal !== null ? $revisor_personal : `<b style="color: red;">Sin asignar</b>`;

            let revision_oc = $numero_revision_personal === 1 ? 'Primera revisión - '
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
              r.some(({ observacion }) => observacion?.toString().trim()));

            const icono2 = observaciones2
              ? `<i class="ri-alert-fill text-warning"></i>`
              : '';

            let revisor2 = $revisor_consejo !== null ? $revisor_consejo : `<b style="color: red;">Sin asignar</b>`;

            let revision2 = $numero_revision_consejo === 1 ? 'Primera revisión - '
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

        { // Actions
          targets: -1,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            let cancelado = full['estatus'] == 1;
            let acciones = '';

            //Construir acciones según permisos
            if (cancelado) {
              if (window.puedeSubirCertificadoVentaNacional) {
                acciones += `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" 
                    class="dropdown-item waves-effect text-dark subirPDF"
                    data-bs-toggle="modal" data-bs-target="#ModalCertificadoFirmado">
                    <i class="ri-upload-2-line ri-20px text-secondary"></i> Adjuntar PDF</a>`;
              }

            } else {
              if (window.puedeEditarCertificadoVentaNacional) {
                acciones += `<a data-id="${full['id_certificado']}" 
                    class="dropdown-item waves-effect text-dark editar"
                    data-bs-toggle="modal" data-bs-target="#ModalEditar">
                    <i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>`;
              }
              if (window.puedeSubirCertificadoVentaNacional) {
                acciones += `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" 
                    class="dropdown-item waves-effect text-dark subirPDF"
                    data-bs-toggle="modal" data-bs-target="#ModalCertificadoFirmado">
                    <i class="ri-upload-2-line ri-20px text-secondary"></i> Adjuntar PDF</a>`;
              }
              if (window.puedeAsignarRevisorCertificadoVentaNacional) {
                acciones += `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" 
                    class="dropdown-item waves-effect text-dark"
                    data-bs-toggle="modal" data-bs-target="#asignarRevisorModal">
                    <i class="text-warning ri-user-search-fill"></i> Asignar revisor</a>`;
              }
              if (window.puedeReexpedirCertificadoVentaNacional) {
                acciones += `<a data-id="${full['id_certificado']}" 
                    class="dropdown-item waves-effect text-black reexpedir"
                    data-bs-toggle="modal" data-bs-target="#modalAddReexCerExpor">
                    <i class="ri-file-edit-fill text-success"></i> Reexpedir/Cancelar</a>`;
              }
              if (window.puedeEliminarCertificadoVentaNacional) {
                acciones += `<a data-id="${full['id_certificado']}" 
                    class="dropdown-item waves-effect text-black eliminar">
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

      order: [[1, 'desc']],//por defecto ordene por num_certificado (index 1)
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

      // Opciones NUEVO/FIRMAR/EXPORTAR/exportar default
      buttons: [buttons2, buttons], /* [ */
/*         {//FIRMAR DOCUSIGN
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Firmar Docusign</span>',
          className: 'btn btn-info waves-effect waves-light me-2',
          action: function (e, dt, node, config) {
            window.location.href = '/add_firmar_docusign';
          }
        },
        {//BOTON AGREGAR
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Certificado</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#ModalAgregar'
          }
        } */
     /*  ], */

      ///PAGINA RESPONSIVA
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['num_certificado'];
              //return 'Detalles del ' + 'Dictamen';
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

  });//var DataTable
}// end-datatable



///AGREGAR NUEVO REGISTRO
const formAdd = document.getElementById('FormAgregar');
const fv = FormValidation.formValidation(formAdd, {
    fields: {
      id_solicitud: {
        validators: {
          notEmpty: {
            message: 'El número de solicitud es obligatorio.'
          }
        }
      },
      num_certificado: {
        validators: {
          notEmpty: {
            message: 'El número de certificado es obligatorio.'
          }
        }
      },
      id_firmante: {
        validators: {
          notEmpty: {
            message: 'Seleccione una opcion'
          }
        }
      },
      fecha_emision: {
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
    fecha_vigencia: {
      validators: {
        /*notEmpty: {
            message: 'La fecha de vigencia es obligatoria.'
        },*/
        date: {
          format: 'YYYY-MM-DD',
          message: 'Ingresa una fecha válida (yyyy-mm-dd).'
        }
      }
    },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        eleInvalidClass: 'is-invalid',
        rowSelector: '.form-floating'//clases del formulario
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
}).on('core.form.valid', function (e) {

  //enviar el formulario cuando pase la validación
  var formData = new FormData(formAdd);
    $.ajax({
      url: '/crear',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        console.log('Correcto:', response);
        $('#ModalAgregar').modal('hide');//modal
        $('#FormAgregar')[0].reset();//formulario
        $('.select2').val(null).trigger('change'); //Reset del select2

        // Actualizar la tabla sin reinicializar DataTables
        //dataTable.ajax.reload();
        dataTable.ajax.reload();
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
        console.log('Error:', xhr.responseJSON);
        console.log('Error2:', xhr.responseText);
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



///ELIMINAR REGISTRO
$(document).on('click', '.eliminar', function () {//clase del boton "eliminar"
    var id_certificado = $(this).data('id'); //ID de la clase
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
          url: `${baseUrl}eliminar/${id_certificado}`,
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
            console.log('Error:', error);
            // Mostrar SweetAlert de error
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al eliminar.',
              //footer: `<pre>${error.responseText}</pre>`,
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
$(document).ready(function () {
    // Función para cargar los datos
    $(document).on('click', '.editar', function () {//clase del boton "editar"
      var id_certificado = $(this).data('id');
      $('#edit_id_certificado').val(id_certificado);

      $.ajax({
        url: '/editar/' + id_certificado + '/edit',
        method: 'GET',
        success: function (datos) {
          // Asignar valores a los campos del formulario
          //$('#edit_id_certificado').val(datos.id_certificado).trigger('change');
          $('#edit_id_solicitud').val(datos.id_solicitud).trigger('change');
          $('#edit_num_certificado').val(datos.num_certificado);
          $('#edit_fecha_emision').val(datos.fecha_emision);
          $('#edit_fecha_vigencia').val(datos.fecha_vigencia);
          $('#edit_id_firmante').val(datos.id_firmante).prop('selected', true).change();

          // --- Rellenar hologramas ---
          if (datos.id_hologramas) {
              let valores = [];
              try {
                  let hologramas = Array.isArray(datos.id_hologramas) 
                      ? datos.id_hologramas 
                      : JSON.parse(datos.id_hologramas); // asegurar que sea un array

                  hologramas.forEach(h => {
                      if (h.inicio && h.final && h.id) {
                          valores.push(`${h.id}|${h.inicio}|${h.final}`);
                      }
                  });

                  $('select[name="id_hologramas[]"]').val(valores).trigger('change');
              } catch (e) {
                  console.error("Error al parsear id_hologramas:", e);
                  $('select[name="id_hologramas[]"]').val(null).trigger('change');
              }
          } else {
              $('select[name="id_hologramas[]"]').val(null).trigger('change');
          }

          // Hologramas descripción
          $('input[name="old_hologramas"]').val(datos.old_hologramas ?? '');


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

    // Manejar el envío del formulario de edición
    $('#FormEditar').on('submit', function (e) {
      e.preventDefault();
      var formData = $(this).serialize();
      var id_certificado = $('#edit_id_certificado').val();//Obtener el ID del registro desde el campo oculto

      $.ajax({
        url: '/actualizar/' + id_certificado,
        type: 'PUT',
        data: formData,
        success: function (response) {
          $('#ModalEditar').modal('hide'); // Ocultar el modal de edición
          $('#FormEditar')[0].reset(); // Limpiar el formulario
          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.message,
            customClass: {
              confirmButton: 'btn btn-primary'
            }
          });

          dataTable.ajax.reload(null, false);//Recarga los datos del datatable, "null,false" evita que vuelva al inicio
        },
        error: function (xhr) {
          //error de validación del lado del servidor
          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            var errorMessages = Object.keys(errors).map(function (key) {
              return errors[key].join('<br>');
            }).join('<br>');
            /*var errorMessages = Object.values(errors).map(msgArray =>
              msgArray.join('<br>')).join('<br><hr>');*/

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

/*   //funcion fechas
  $('#rex_fecha_emision').on('change', function () {
    var fecha_emision = $(this).val();
    if (fecha_emision) {
      var fecha = moment(fecha_emision, 'YYYY-MM-DD');
      var fecha_vigencia = fecha.add(90, 'days').format('YYYY-MM-DD');
      $('#rex_fecha_vigencia').val(fecha_vigencia);
    }
  }); */

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
    } else {
      $('#campos_condicionales').slideUp();
    }
  });

  function cargarDatosReexpedicion(id_certificado) {
    console.log('Cargando datos para la reexpedición con ID:', id_certificado);
    clearFields();

    //cargar los datos
    $.get(`/editar/${id_certificado}/edit`).done(function (datos) {
      console.log('Respuesta completa:', datos);

      if (datos.error) {
        showError(datos.error);
        return;
      }

      $('#rex_id_solicitud').val(datos.id_solicitud).trigger('change');
      $('#rex_numero_certificado').val(datos.num_certificado);
      $('#rex_id_firmante').val(datos.id_firmante).trigger('change');
      $('#rex_fecha_emision').val(datos.fecha_emision);
      $('#rex_fecha_vigencia').val(datos.fecha_vigencia);

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
    $('#rex_id_solicitud').val('');
    $('#rex_numero_certificado').val('');
    $('#rex_id_firmante').val('');
    $('#rex_fecha_emision').val('');
    $('#rex_fecha_vigencia').val('');
    $('#rex_observaciones').val('');
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
      'id_solicitud': {
        validators: {
          notEmpty: {
            message: 'El número de solicitud es obligatorio.'
          }
        }
      },
      'num_certificado': {
        validators: {
          notEmpty: {
            message: 'El número de certificado es obligatorio.'
          },
          stringLength: {
            min: 8,
            message: 'Debe tener al menos 8 caracteres.'
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
          /*notEmpty: {
            message: 'La fecha de vigencia es obligatoria.'
          },*/
          date: {
            format: 'YYYY-MM-DD',
            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
          }
        }
      },
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
  $.get(`/obtener-revision-nacional/${idCertificado}`, function (data) {
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
        url: `/eliminar-doc-revision-nacional/${idCertificado}`,
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
  formData.append('id_documento', 133);

  $.ajax({
    url: '/asignar_revisor_nacional',
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
$(document).on('click', '.pdfCertificado', function () {
  var id = $(this).data('id');//Obtén el ID desde el atributo "data-id" en PDF
  var pdfUrl = '/certificado_venta_nacional/' + id; //Ruta del PDF
  var pdfUrlSinMarca = '/certificado_venta_nacional/' + id + '?sinMarca=1'; // PDF sin marca
  var iframe = $('#pdfViewer');
  var spinner = $('#cargando');

  //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
  spinner.show();
  iframe.hide();

  //Cargar el PDF con el ID
  iframe.attr('src', pdfUrl);
  //Configurar el botón para abrir el PDF en una nueva pestaña
  $("#NewPestana").attr('href', pdfUrl).show();

  $("#titulo_modal").text("Certificado de venta nacional");
  $("#subtitulo_modal").text("PDF del Certificado");

  // Crear botón de descarga sin marca de agua
  if ($('#btnDescargarDinamico').length === 0) {
      var botonDescarga = $(`
          <a id="btnDescargarDinamico" href="${pdfUrlSinMarca}" class="btn btn-secondary ms-2" target="_blank" download>
              Certificado sin marca de agua
          </a>
      `);
      $('#NewPestana').after(botonDescarga);
  } else {
      // Solo actualizar href si ya existe
      $('#btnDescargarDinamico').attr('href', pdfUrlSinMarca).show();
  }

  //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
  iframe.on('load', function () {
    spinner.hide();
    iframe.show();
  });
});

///FORMATO PDF SOLICITUD CERTIFICADO
$(document).on('click', '.pdfSolicitudCertificado', function () {
  var id = $(this).data('id');//Obtén el ID desde el atributo "data-id" en PDF
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

  $("#titulo_modal").text("Solicitud de emisión de certificado venta nacional");
  $("#subtitulo_modal").text("PDF de la solicitud");
  //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
  iframe.on('load', function () {
    spinner.hide();
    iframe.show();
  });
});


///FORMATO PDF DICTAMEN
$(document).on('click', '.pdfDictamen', function ()  {
    var id = $(this).data('id');//Obtén el ID desde el atributo "data-id" en PDF
    var pdfUrl = '/dictamen_envasado/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();

    $("#titulo_modal").text("Dictamen de Cumplimiento NOM de Mezcal Envasado");
    $("#subtitulo_modal").text("PDF del Dictamen");
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
        spinner.hide();
        iframe.show();
    });
});


///FORMATO PDF SOLICITUD
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





  ///SUBIR CERTIFICADO FIRMADO
  $('#FormCertificadoFirmado').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: '/certificados/nacional/documento',
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
    $('#modalTitulo').html('Certificado venta nacional firmado <span class="badge bg-info">' + num_certificado + '</span>');

    $.ajax({
      url: `/certificados/nacional/documento/${id}`,
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
          url: `/certificados/nacional/documento/${id_certificado}`,
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






});//end-function(jquery)
