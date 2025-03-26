'use strict';

$(function () {

  var dt_user_table = $('.datatables-users')

  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '/revision-personal-list',
      },
      columns: [
        { data: '#' },                //0
        { data: 'fake_id' },          //1
        { data: '' },    //2
        { data: 'num_certificado' },  //3
        { data: 'id_revisor' },       //4
        { data: 'created_at' },       //5
        { data: 'updated_at' },       //6
        { data: 'PDF' },              //7
        { data: 'decision' },         //8
        { data: 'actions' }           //9
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
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          targets: 2,
          render: function (data, type, row) {
              var tipoRevision = row['tipo_revision'];
              var icono = '';
      
              if (tipoRevision === 'Instalaciones de productor' || tipoRevision === 'Instalaciones de envasador' || tipoRevision === 'Instalaciones de comercializador' || tipoRevision === 'Instalaciones de almacén o bodega' || tipoRevision === 'Instalaciones de área de maduración') {
                  icono = `<span class="fw-bold mt-1 badge bg-secondary">${tipoRevision}</span>`;
              } 
              if (tipoRevision === 'Granel') {
                icono = `<span class="fw-bold mt-1 badge bg-dark">${tipoRevision}</span>`;
            } 
            if (tipoRevision === 'Exportación') {
              icono = `<span class="fw-bold mt-1 badge bg-primary">${tipoRevision}</span>`;
          } 
              return icono;
          }
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            var $num_certificado = full['num_certificado'];

            
              return `
              <div style="display: flex; flex-direction: column; align-items: start; gap: 4px;">
                <span class="fw-bold">
                  ${$num_certificado}
                </span>
              </div>
              `;
            } 
          
        },
        {
          targets: 4,
          render: function (data, type, full, meta) {
            var $id_revisor = full['id_revisor'];
            return '<span class="user-email">' + $id_revisor + '</span>';
          }
        },
               
        {
          targets: 5,
          render: function (data, type, full, meta) {
            var $created_at = full['created_at'];
            return '<span class="user-email">' + $created_at + '</span>';
          }
        },
        {
          targets: 6,
          render: function (data, type, full, meta) {
            var $updated_at = full['updated_at'];
            return '<span class="user-email">' + $updated_at + '</span>';
          }
        },
        {
          targets: 7,
          className: 'text-center',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
              if (full['decision']!='Pendiente') {
                  // Si existe la decisión, el ícono es funcional (activo)
                  return `
                      <i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"
                         data-bs-target="#PdfDictamenIntalaciones"
                         data-bs-toggle="modal"
                         data-bs-dismiss="modal"
                         data-num-certificado="${full['num_certificado']}"
                         data-tipo="${full['tipo_dictamen']}"
                         data-id="${full['id_revision']}"
                         data-tipo_revision="${full['tipo_revision']}">
                      </i>`;
              } else {
                  // Si la decisión no existe, el ícono se ve como deshabilitado con un color más claro
                  return `
                      <i class="ri-file-pdf-2-fill ri-40px cursor-not-allowed" style="color: lightgray;"></i>`;
              }
          }
        },                    
        {
          targets: 8,
          orderable: 0,
          render: function (data, type, full, meta) {
            var $decision = full['decision'];
            var $colorDesicion;
            var $nombreDesicion;

            switch ($decision) {
              case "positiva":
                $nombreDesicion = 'Revisión positiva';
                $colorDesicion = 'primary';
              break; 

              case "negativa":
                $nombreDesicion = 'Revisión negativa';
                $colorDesicion = 'danger';
              break;
              default:
                $nombreDesicion = 'Pendiente';
                $colorDesicion = 'warning';
            }

            return `<span class="badge rounded-pill bg-${$colorDesicion}">${$nombreDesicion}</span>`;
          }
        },
        {
          // Actions
          targets: 9,
          title: 'Acciones',
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center gap-50">' +
              // Botón de Opciones
              '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
              '<i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>' +
              '</button>' +
              // Menú desplegable
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              // Botón para revisar
              `<a class="dropdown-item waves-effect text-info cuest" ` +
              `href="/add_revision/${full['id_revision']}" ` +
              `data-id="${full['id_revision']}" ` +
              `data-revisor-id="${full['id_revisor']}" ` +
              `data-dictamen-id="${full['id_certificado']}" ` +
              `data-num-certificado="${full['num_certificado']}" ` +
              `data-num-dictamen="${full['num_dictamen']}" ` +
              `data-tipo-dictamen="${full['tipo_dictamen']}" ` +
              `data-fecha-vigencia="${full['fecha_vigencia']}" ` +
              `data-fecha-vencimiento="${full['fecha_vigencia']}" ` +
              `data-tipo="${full['tipo_dictamen']}" ` +
              `data-tipo_revision="${full['tipo_revision']}" ` +
   
              `data-bs-target="#fullscreenModal">` +
              '<i class="ri-eye-fill ri-20px text-info"></i> Revisar' +
              '</a>' +
              // Botón para editar revisión
              `<a class="dropdown-item waves-effect text-primary editar-revision" ` + 
              `data-id="${full['id_revision']}" ` +
              `data-tipo="${full['tipo_dictamen']}" ` +
              `data-tipo_revision="${full['tipo_revision']}" ` +
              `data-accion="editar" ` +  // Identificador
              `data-bs-toggle="modal" ` +
              `data-bs-target="#fullscreenModal">` +
              '<i class="ri-pencil-fill ri-20px text-primary"></i> Editar Revisión' + 
              '</a>' +
              // Botón para Aprobación
              `<a data-id='${full['id_revision']}' data-num-certificado="${full['num_certificado']}" data-bs-toggle="modal" data-bs-target="#modalAprobacion" class="dropdown-item Aprobacion-record waves-effect text-success">` +
              '<i class="ri-checkbox-circle-line text-success"></i> Aprobación' +
              '</a>' +
              // Botón para Historial
              `<a data-id='${full['id_revision']}' class="dropdown-item waves-effect text-warning abrir-historial" ` +
              `data-bs-toggle="modal" data-bs-target="#historialModal">` +
              '<i class="ri-history-line text-warning"></i> Historial' +
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
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        }
      },

      // Opciones Exportar Documentos
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
          text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
          buttons: [
            {
              extend: 'print',
              title: 'Certificados Instalaciones',
              text: '<i class="ri-printer-line me-1" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
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
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-text-line me-1" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
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
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
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
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
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
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-copy-line me-1"></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
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
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de Certificado: ' + data['num_certificado'];            }
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

  // FUNCIONES DEL FUNCIONAMIENTO DEL CRUD

  dt_user.on('draw', function () {
    // Inicializa todos los tooltips después de cada redibujado
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
  // Inicializacion Elementos
  function initializeSelect2($elements) {
      $elements.each(function () {
          var $this = $(this);
          $this.wrap('<div class="position-relative"></div>').select2({
              dropdownParent: $this.parent(),
          });
      });
  }

  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
});

// Registrar Respuesta y mostrar PDF correspondiente
let id_revision;
$(document).on('click', '.cuest', function () {
  id_revision = $(this).data('id');
  let tipo = $(this).data('tipo');
  console.log('ID de Revisión:', id_revision);
  console.log('Tipo:', tipo);
  $('#modal-loading-spinner').show();
  $('#pdfViewerDictamenFrame').hide();

  $('#Registrar').show();
  $('#Editar').hide(); 

  // Genera un parámetro único para evitar el caché
  let timestamp = new Date().getTime();
  let tipoRevision = $(this).data('tipo_revision');
  let url;

  // Decide la URL del PDF según el tipo de revisión
  if (tipoRevision === 'RevisorGranel') {
    url = `/Pre-certificado/${id_revision}?t=${timestamp}`;
  } else {
    url = `/get-certificado-url/${id_revision}/${tipo}?t=${timestamp}`;
  }

  $.ajax({
      url: url,
      type: 'GET',
      success: function (response) {
          if (tipoRevision === 'RevisorGranel') {
              $('#pdfViewerDictamenFrame').attr('src', url + '#zoom=80');
              console.log('PDF cargado (Granel): ' + url);
          } else if (response.certificado_url) {
              let uniqueUrl = response.certificado_url + '?t=' + timestamp;
              $('#pdfViewerDictamenFrame').attr('src', uniqueUrl + '#zoom=80');
              console.log('PDF cargado: ' + uniqueUrl);
          } else {
              console.log('No se encontró el certificado para la revisión ' + id_revision);
          }
      },
      error: function (xhr) {
          console.error('Error al obtener la URL del certificado: ', xhr.responseText);
      },
      complete: function () {
          $('#pdfViewerDictamenFrame').on('load', function () {
              $('#modal-loading-spinner').hide();
              $(this).show();
          });
      }
  });

  // Ajuste de títulos y visibilidad según el tipo de revisión
  if (tipoRevision === 'Revisor') {
    $('#modalFullTitle').text('REVISIÓN POR PARTE DEL PERSONAL DEL OC PARA LA DECISIÓN DE LA CERTIFICACIÓN (INSTALACIONES)');
    $('tbody#revisor').show();
    $('tbody#revisorGranel').hide();
    cargarRespuestas(id_revision); 
  } else if (tipoRevision === 'RevisorGranel') {
    $('#modalFullTitle').text('REVISIÓN POR PARTE DEL PERSONAL DEL OC PARA LA DECISIÓN DE LA CERTIFICACIÓN (GRANEL)');
    $('tbody#revisorGranel').show();
    $('tbody#revisor').hide();
  }
});

$(document).on('click', '#registrarRevision', function () {
  if (typeof id_revision === 'undefined') {
    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: 'El ID de revisión no está definido.',
      customClass: {
        confirmButton: 'btn btn-danger'
      }
    });
    return;
  }

  const respuestas = {};
  const observaciones = {};
  const rows = $('#fullscreenModal .table-container table tbody tr');
  let todasLasRespuestasSonC = true;
  let valid = true;

  rows.each(function (index) {
    // Verificar si la fila está visible antes de realizar la validación
    if ($(this).is(':visible')) {
      let respuesta = $(this).find('select').val();
      const observacion = $(this).find('textarea').val();

      if (!respuesta) {
        $(this).find('select').addClass('is-invalid');
        valid = false;
      } else {
        $(this).find('select').removeClass('is-invalid');
      }

      if (respuesta === '1') {
        respuesta = 'C';
      } else if (respuesta === '2') {
        respuesta = 'NC';
        todasLasRespuestasSonC = false;
      } else if (respuesta === '3') {
        respuesta = 'NA';
        todasLasRespuestasSonC = false;
      } else {
        respuesta = null;
        todasLasRespuestasSonC = false;
      }

      respuestas[`pregunta${index + 1}`] = respuesta;
      observaciones[`pregunta${index + 1}`] = observacion || null;
    }
  });

  if (!valid) {
    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: 'Por favor, completa todos los campos requeridos.',
      customClass: {
        confirmButton: 'btn btn-danger'
      }
    });
    return;
  }

  const decision = todasLasRespuestasSonC ? 'positiva' : 'negativa';

  console.log({
    id_revision: id_revision,
    respuestas: respuestas,
    observaciones: observaciones,
    decision: decision
  });

  $.ajax({
    url: '/revisor/registrar-respuestas',
    type: 'POST',
    contentType: 'application/json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: JSON.stringify({
      id_revision: id_revision,
      respuestas: respuestas,
      observaciones: observaciones,
      decision: decision 
    }),
    success: function (response) {
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: response.message,
        customClass: {
          confirmButton: 'btn btn-success'
        }
      });

      $('#fullscreenModal').modal('hide');
      $('.datatables-users').DataTable().ajax.reload();
    },
    error: function (xhr) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al registrar las respuestas: ' + xhr.responseJSON.message,
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    }
  });
});

// Quitar Validacion al llenar Select
$(document).on('change', 'select[name^="respuesta"], textarea[name^="observaciones"], select[name^="tipo"]', function () {
  $(this).removeClass('is-invalid'); 
});

// Limpiar Validacion al cerrar Modal
$(document).on('hidden.bs.modal', '#fullscreenModal', function () {
  const respuestas = document.querySelectorAll('select[name^="respuesta"]');
  respuestas.forEach((respuesta) => {
      respuesta.classList.remove('is-invalid'); 
      respuesta.value = ''; 
  });
});

function cargarRespuestas(id_revision) {
  $.ajax({
      url: `/revisor/obtener-respuestas/${id_revision}`,
      type: 'GET',
      success: function (response) {
          const respuestasGuardadas = response.respuestas || {};
          const rows = $('#fullscreenModal .table-container table tbody tr');

          // Recorre cada fila de la tabla
          rows.each(function (index) {
              const respuestaKey = `pregunta${index + 1}`;
              const respuestaGuardada = respuestasGuardadas[respuestaKey]?.respuesta || '';
              const observacionGuardada = respuestasGuardadas[respuestaKey]?.observacion || '';

              // Establece la respuesta en el select
              let respuestaSelect = '';
              if (respuestaGuardada === 'C') {
                  respuestaSelect = '1';
              } else if (respuestaGuardada === 'NC') {
                  respuestaSelect = '2';
              } else if (respuestaGuardada === 'NA') {
                  respuestaSelect = '3';
              }

              $(this).find('select').val(respuestaSelect || ''); // Asigna la respuesta
              $(this).find('textarea').val(observacionGuardada); // Asigna la observación
          });

          // Establecer la decisión si está disponible
          const decision = response.decision || null;
          $('#floatingSelect').val(decision);
      },
      error: function (xhr) {
          console.error('Sin Respuestas');
      }
  });
}

//Abrir PDF Bitacora
$(document).on('click', '.pdf', function () {
  var id_revisor = $(this).data('id');
  var tipoRevision = $(this).data('tipo_revision'); // Nuevo: tipo de revisión
  var num_certificado = $(this).data('num-certificado');

  console.log('ID del Revisor:', id_revisor);
  console.log('Tipo de Revisión:', tipoRevision);
  console.log('Número de Certificado:', num_certificado);

  // Definir URL según el tipo de revisión
  var url_pdf = '../pdf_bitacora_revision_personal/' + id_revisor;


  console.log('URL del PDF:', url_pdf);

  // Configurar encabezados del modal
  $('#titulo_modal_Dictamen').text("Bitácora de revisión documental");
  $('#subtitulo_modal_Dictamen').text(num_certificado);

  // Configurar botón para abrir PDF
  var openPdfBtn = $('#openPdfBtnDictamen');
  openPdfBtn.attr('href', url_pdf);
  openPdfBtn.show();

  // Mostrar modal de PDF
  $('#PdfDictamenIntalaciones').modal('show');
  $('#loading-spinner').show();
  $('#pdfViewerDictamen').hide();

  // Cargar PDF en iframe
  $('#pdfViewerDictamen').attr('src', url_pdf);
});

// Ocultar spinner y mostrar PDF cuando el iframe se haya cargado
$('#pdfViewerDictamen').on('load', function () {
  $('#loading-spinner').hide();
  $('#pdfViewerDictamen').show();
});

// Abrir modal Aprobacion
$(document).on('click', '.Aprobacion-record', function() {
  const idRevision = $(this).data('id');
  const certificado = $(this).data('num-certificado');
  const select2Elements = $('#id_firmante'); 
  initializeSelect2(select2Elements);

  $('#modalAprobacion').modal('show');
  $('#numero-certificado').text(certificado);
  $('#btnRegistrar').data('id-revisor', idRevision);
  
  // Cargar los datos de aprobación
  $.ajax({
      url: `/aprobacion/${idRevision}`,
      method: 'GET',
      success: function(data) {
          $('#id_firmante').val(data.revisor.id_aprobador || '').trigger('change');
          $('#respuesta-aprobacion').val(data.revisor.aprobacion || '').prop('selected', true);
          if (data.revisor.fecha_aprobacion && data.revisor.fecha_aprobacion !== '0000-00-00') {
              $('#fecha-aprobacion').val(data.revisor.fecha_aprobacion);
          } else {
              $('#fecha-aprobacion').val(''); 
          }
      },
      error: function(xhr) {
          console.error(xhr.responseJSON.message);
          alert('Error al cargar los datos de la aprobación.');
      }
  });
});

// Registrar Aprobacion
$(function () {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  // Inicializar FormValidation
  const form = document.getElementById('formAprobacion');
  const fv = FormValidation.formValidation(form, {
      fields: {
          'respuesta-aprobacion': {
              validators: {
                  notEmpty: {
                      message: 'Selecciona una respuesta de aprobación.'
                  }
              }
          },
          'fecha-aprobacion': {
              validators: {
                  notEmpty: {
                      message: 'Por favor, ingresa una fecha de aprobación.'
                  },
                  date: {
                      format: 'YYYY-MM-DD',
                      message: 'Por favor, ingresa una fecha válida en formato AAAA-MM-DD.'
                  }
              }
          },
          'id_firmante': {
              validators: {
                  notEmpty: {
                      message: 'Por favor, selecciona la persona que aprueba.'
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
      const idRevisor = $('#btnRegistrar').data('id-revisor'); 
      const aprobacion = $('#respuesta-aprobacion').val(); 
      const fechaAprobacion = $('#fecha-aprobacion').val(); 
      const idAprobador = $('#id_firmante').val(); 

      $.ajax({
          url: '/registrar-aprobacion', 
          type: 'POST',
          data: {
              _token: $('meta[name="csrf-token"]').attr('content'),
              id_revisor: idRevisor,
              aprobacion: aprobacion,
              fecha_aprobacion: fechaAprobacion,
              id_aprobador: idAprobador 
          },
          success: function(response) {
              Swal.fire({
                  icon: 'success',
                  title: '¡Éxito!',
                  text: 'Aprobación registrada exitosamente.',
                  customClass: {
                      confirmButton: 'btn btn-success'
                  }
              });
              $('#modalAprobacion').modal('hide');
              form.reset();
              $('.select2').val(null).trigger('change');
          },
          error: function(xhr) {
              Swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: xhr.responseJSON.message,
                  customClass: {
                      confirmButton: 'btn btn-danger'
                  }
              });
          }
      });
  });

  // Revalidaciones
  $('#id_firmante').on('change', function() {
      if ($(this).val()) {
          fv.revalidateField($(this).attr('name'));
      }
  });

  $('#respuesta-aprobacion').on('change', function() {
      fv.revalidateField($(this).attr('name'));
  });

  $('#fecha-aprobacion').on('change', function() {
      fv.revalidateField($(this).attr('name'));
  });
});

// Limpiar campos al cerrar el modal
$('#modalAprobacion').on('hidden.bs.modal', function () {
  $('#id_firmante, #respuesta-aprobacion, #fecha-aprobacion').val('');
  $('#respuesta-aprobacion').prop('selected', true);
});


// Historial
$(document).on('click', '.abrir-historial', function() {
  const id_revision = $(this).data('id'); 
  console.log('ID de revisión clicado:', id_revision); 
  $('#historialModal').modal('show'); 
});

function cargarHistorial(id_revision) {
  console.log('Cargando historial para ID de revisión:', id_revision);
  $('#historialRespuestasContainer').html('<p>Cargando historial...</p>');
  $('#respuestasContainer').html(''); 

  $.ajax({
      url: `/obtener/historial/${id_revision}`, 
      method: 'GET',
      success: function(data) {
          console.log('Datos recibidos:', data);
          if (!data.respuestas || data.respuestas.length === 0) {
              $('#historialRespuestasContainer').html('<p>No hay historial disponible.</p>');
              return;
          }

          let botonesHTML = ''; 
          if (!data.respuestas[0].respuestas || Object.keys(data.respuestas[0].respuestas).length === 0) {
              $('#historialRespuestasContainer').html('<p>No hay historial disponible para esta revisión.</p>');
              return; 
          }

          $.each(data.respuestas[0].respuestas, function(revisionKey, revisionData) {
              botonesHTML += `
                  <button class="btn btn-primary btn-lg mb-2" 
                          data-revision="${revisionKey}" 
                          data-respuestas='${JSON.stringify(revisionData)}'>
                      <i class="fas fa-history"></i>${revisionKey} <!-- Icono de historial -->
                  </button>
              `;
          });

          $('#historialRespuestasContainer').html(botonesHTML);
          $('.btn-primary').on('click', function() {
              const respuestas = $(this).data('respuestas'); 
              mostrarRespuestas(respuestas); 
          });
      },
      error: function(xhr) {
          $('#historialRespuestasContainer').html('<p>Error al cargar el historial.</p>');
          $('#respuestasContainer').html(''); 
          console.error('Error al cargar el historial:', xhr); 
      }
  });
}

function mostrarRespuestas(respuestas) {
  if (typeof respuestas === 'string') {
      respuestas = JSON.parse(respuestas); 
  }

  let respuestasHTML = `
      <div class="table-responsive">
          <table class="table table-striped table-bordered">
              <thead class="table-light">
                  <tr>
                      <th class="text-start">#</th> <!-- Nueva columna para el número de pregunta -->
                      <th class="text-start">Pregunta</th> <!-- Alineación a la izquierda -->
                      <th class="text-center">C</th>
                      <th class="text-center">NC</th>
                      <th class="text-center">NA</th>
                      <th class="text-start">Observaciones</th> <!-- Nueva columna de Observaciones -->
                  </tr>
              </thead>
              <tbody>
  `;

  const preguntas = [
      { key: 'pregunta1', label: 'CONTRATO DE PRESTACIÓN DE SERVICIOS' },
      { key: 'pregunta2', label: 'CONSTANCIA SITUACIÓN FISCAL Y RFC' },
      { key: 'pregunta3', label: 'CARTA NO. CLIENTE' },
      { key: 'pregunta4', label: 'NOMBRE DE LA EMPRESA O PERSONA FÍSICA' },
      { key: 'pregunta5', label: 'DIRECCIÓN FISCAL' },
      { key: 'pregunta6', label: 'SOLICITUD DEL SERVICIO DE DICTAMINACIÓN DE INSTALACIONES' },
      { key: 'pregunta7', label: 'NÚMERO DE CERTIFICADO DE INSTALACIONES' },
      { key: 'pregunta8', label: 'NOMBRE DE LA EMPRESA O PERSONA FÍSICA' },
      { key: 'pregunta9', label: 'DOMICILIO FISCAL DE LAS INSTALACIONES' },
      { key: 'pregunta10', label: 'CORREO ELECTRÓNICO Y NÚMERO TELEFÓNICO' },
      { key: 'pregunta11', label: 'FECHA DE VIGENCIA Y VENCIMIENTO DEL CERTIFICADO' },
      { key: 'pregunta12', label: 'ALCANCE DE LA CERTIFICACIÓN' },
      { key: 'pregunta13', label: 'NO. DE CLIENTE' },
      { key: 'pregunta14', label: 'NÚMERO DE DICTAMEN EMITIDO POR LA UVEM' },
      { key: 'pregunta15', label: 'ACTA DE LA UNIDAD DE INSPECCIÓN (FECHA DE INICIO, TÉRMINO Y FIRMAS)' },
      { key: 'pregunta16', label: 'NOMBRE Y PUESTO DEL RESPONSABLE DE LA EMISIÓN DEL CERTIFICADO' },
      { key: 'pregunta17', label: 'NOMBRE Y DIRECCIÓN DEL ORGANISMO CERTIFICADOR CIDAM' },
  ];

  preguntas.forEach((pregunta, index) => {
      const respuesta = respuestas[pregunta.key]; 
      const observacion = respuesta?.observacion ? respuesta.observacion : '---'; 

      respuestasHTML += `
          <tr>
              <td class="text-start">${index + 1}</td> <!-- Número de pregunta -->
              <td>${pregunta.label}</td>
              <td class="text-center">${respuesta?.respuesta === 'C' ? 'C' : '---'}</td>
              <td class="text-center ${respuesta?.respuesta === 'NC' ? 'text-danger' : ''}">${respuesta?.respuesta === 'NC' ? 'NC' : '---'}</td>
              <td class="text-center">${respuesta?.respuesta === 'NA' ? 'NA' : '---'}</td>
              <td class="text-start">${observacion}</td> <!-- Nueva celda para Observaciones -->
          </tr>
      `;
  });

  respuestasHTML += `
              </tbody>
          </table>
      </div>
  `;
  document.getElementById('respuestasContainer').innerHTML = respuestasHTML;
}

// Editar Respuestas
let id_revision_edit;
$(document).on('click', '.abrir-historial', function() {
  id_revision_edit = $(this).data('id'); 
  console.log('ID de revisión clicado:', id_revision_edit);
  cargarHistorial(id_revision_edit); 
  $('#historialModal').modal('show'); 
});

$(document).on('click', '.editar-revision', function () {
  id_revision_edit = $(this).data('id'); 
  let tipox = $(this).data('tipo');
  console.log('ID de revisión clicado:', id_revision_edit);
  console.log('Tipo:', tipox);
  cargarRespuestas(id_revision_edit);

  let tipoRevision = $(this).data('tipo_revision');
  console.log("Tipo de revisión: " + tipoRevision);

  // Ajuste de títulos y visibilidad según el tipo de revisión
  if (tipoRevision === 'Revisor') {
    $('#modalFullTitle').text('REVISIÓN POR PARTE DEL PERSONAL DEL OC PARA LA DECISIÓN DE LA CERTIFICACIÓN (INSTALACIONES)');
    $('tbody#revisor').show();
    $('tbody#revisorGranel').hide();
    cargarRespuestas(id_revision_edit);
  } else if (tipoRevision === 'RevisorGranel') {
    $('#modalFullTitle').text('REVISIÓN POR PARTE DEL PERSONAL DEL OC PARA LA DECISIÓN DE LA CERTIFICACIÓN (GRANEL)');
    $('tbody#revisorGranel').show();
    $('tbody#revisor').hide();
  }

  $('#fullscreenModal').modal('show');
  $('#Editar').show(); 
  $('#Registrar').hide();
  $('#modal-loading-spinner').show();
  $('#pdfViewerDictamenFrame').hide();

  // Genera un parámetro único para evitar el caché
  let timestamp = new Date().getTime();
  let url;

  // Ruta del PDF según el tipo de revisión
  if (tipoRevision === 'Revisor') {
    url = '/get-certificado-url/' + id_revision_edit + '/' + tipox + '?t=' + timestamp;
  } else if (tipoRevision === 'RevisorGranel') {
    url = '/Pre-certificado/' + id_revision_edit + '?t=' + timestamp;
  }

  $.ajax({
      url: url,
      type: 'GET',
      success: function (response) {
          if (response.certificado_url || tipoRevision === 'RevisorGranel') {
              let uniqueUrl = response.certificado_url 
                ? response.certificado_url + '?t=' + timestamp 
                : url;
              $('#pdfViewerDictamenFrame').attr('src', uniqueUrl + '#zoom=80');
              console.log('PDF cargado: ' + uniqueUrl);
          } else {
              console.log('No se encontró el certificado para la revisión ' + id_revision_edit);
          }
      },
      error: function (xhr) {
          console.error('Error al obtener la URL del certificado: ', xhr.responseText);
      },
      complete: function () {
          $('#pdfViewerDictamenFrame').on('load', function () {
              $('#modal-loading-spinner').hide();
              $(this).show();
          });
      }
  });
});

$(document).on('click', '#editarRevision', function () {
  $('#registrarRevision').hide(); 

  console.log('ID de revisión usado en editarRevision:', id_revision_edit);
  
  if (!id_revision_edit) {
    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: 'El ID de revisión no está definido.',
      customClass: {
        confirmButton: 'btn btn-danger'
      }
    });
    return;
  }

  const respuestas = {};
  const observaciones = {};
  const rows = $('#fullscreenModal .table-container table tbody tr');
  let todasLasRespuestasSonC = true;
  let valid = true;

  rows.each(function (index) {
    if ($(this).is(':visible')) {
    let respuesta = $(this).find('select').val();
    const observacion = $(this).find('textarea').val();

    if (!respuesta) {
      $(this).find('select').addClass('is-invalid');
      valid = false;
    } else {
      $(this).find('select').removeClass('is-invalid');
    }

    if (respuesta === '1') {
      respuesta = 'C';
    } else if (respuesta === '2') {
      respuesta = 'NC';
      todasLasRespuestasSonC = false;
    } else if (respuesta === '3') {
      respuesta = 'NA';
      todasLasRespuestasSonC = false;
    } else {
      respuesta = null;
      todasLasRespuestasSonC = false;
    }

    respuestas[`pregunta${index + 1}`] = respuesta;
    observaciones[`pregunta${index + 1}`] = observacion || null;
  }
  });

  if (!valid) {
    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: 'Por favor, completa todos los campos requeridos.',
      customClass: {
        confirmButton: 'btn btn-danger'
      }
    });
    return;
  }

  const decision = todasLasRespuestasSonC ? 'positiva' : 'negativa';

  console.log({
    id_revision: id_revision_edit,
    respuestas: respuestas,
    observaciones: observaciones,
    decision: decision
  });

  $.ajax({
    url: `/editar-respuestas`,
    type: 'POST',
    contentType: 'application/json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: JSON.stringify({
      id_revision: id_revision_edit,
      respuestas: respuestas,
      observaciones: observaciones,
      decision: decision 
    }),
    success: function (response) {
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: response.message,
        customClass: {
          confirmButton: 'btn btn-success'
        }
      });

      $('#fullscreenModal').modal('hide');
      $('.datatables-users').DataTable().ajax.reload();
    },
    error: function (xhr) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al editar las respuestas: ' + xhr.responseJSON.message,
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    }
  });
});

// Quitar Validación al llenar Select
$(document).on('change', 'select[name^="respuesta"], textarea[name^="observaciones"], select[name^="tipo"]', function () {
  $(this).removeClass('is-invalid'); 
});

// Limpiar Validación al cerrar Modal
$(document).on('hidden.bs.modal', '#fullscreenModal', function () {
  const respuestas = document.querySelectorAll('select[name^="respuesta"]');
  respuestas.forEach((respuesta) => {
    respuesta.classList.remove('is-invalid'); 
    respuesta.value = ''; 
  });
});

//end
});