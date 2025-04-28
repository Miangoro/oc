/*
 Page User List
 */
'use strict';
/*
$(document).ready(function () {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    language: 'es' // Configura el idioma a español
  });
});

///FUNCION FECHAS
$('#fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setDate(fechaInicial.getDate() + 91);//Sumar 90 días a la fecha inicial
  $('#fecha_vigencia').datepicker("setDate", fechaInicial);
});

///FUNCION FECHAS EDIT
$('#edit_fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setDate(fechaInicial.getDate() + 91);
  $('#edit_fecha_vigencia').datepicker("setDate", fechaInicial);
});
*/

$(document).ready(function () {///flatpickr
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
$('#edit_fecha_emision').on('change', function() {
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



///Datatable (jquery)
$(function () {
 
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
         url: baseUrl + 'CerExpo-list'
       },
       columns: [
         { data: '' }, // (0)
         { data: 'num_certificado' },//(1)
         { data: '',/*null, //soli y serv.
            render: function(data, type, row) {
            return `<span style="font-size:14px"> <strong>${data.folio}</strong><br>
                ${data.n_servicio}<span>`;
            }*/
         },
         {data: null, // Se usará null porque combinaremos varios valores
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
          render: function (data, type, full, meta) {
            var $num_certificado = full['num_certificado'];
            var $id = full['id_certificado'];
            return '<small class="fw-bold">' + $num_certificado + '</small>' +
                '<i data-id="' +$id+ '" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfCertificado" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>' +
                `<br><span class="fw-bold">Solicitud:</span> <i data-id="${full['id_certificado']}" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfSolicitudCertificado" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>`;
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
              var $acta = '<a href="/img_pdf/FaltaPDF.png"> <img src="/img_pdf/FaltaPDF.png" height="25" width="25" title="Ver documento" alt="FaltaPDF"> </a>'
            }else {
              var $acta = full['url_acta'].map(url => `
                <i data-id="${full['numero_cliente']}/${url}" data-empresa="${full['razon_social']}"
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
          targets: 4,
          searchable: false,
          orderable: false,
          responsivePriority: 4, 
          render: function (data, type, full, meta) {
            var $ = full[''];
            return `<div class="small">
                <b>Lote envasado:</b> ${full['nombre_lote']}  
              </div>`;
            }
        },
        {
          targets: 5,
          searchable: false,
          orderable: false,
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
        searchable: true,
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
                estatus = '<span class="badge rounded-pill bg-success">Reexpedido</span>';
            } else {
              estatus = '<span class="badge rounded-pill bg-success">Emitido</span>';
            }
          //revisores
          var id_revisor = full['id_revisor'];   // Obtener el id_revisor
          var id_revisor2 = full['id_revisor2']; // Obtener el id_revisor2
          // Mensajes para los revisores
          var revisorPersonal, revisorMiembro;
          // Para el revisor personal
          if (id_revisor !== 'Sin asignar') {
              revisorPersonal = `<span class="badge" style="background-color: transparent; color:  #676B7B;"><strong>Personal:</strong> ${id_revisor}</span>`;
          } else {
              revisorPersonal = `<span class="badge" style="background-color: transparent; color:  #676B7B;"><strong>Personal:</strong> <strong style="color: red;">Sin asignar</strong></span>`;
          }
          // Para el revisor miembro
          if (id_revisor2 !== 'Sin asignar') {
              revisorMiembro = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Consejo:</strong> ${id_revisor2}</span>`;
          } else {
              revisorMiembro = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Consejo:</strong> <strong style="color: red;">Sin asignar</strong></span>`;
          }
  
          // Retorna los revisores en formato HTML
          return estatus+
            ` <div style="display: flex; flex-direction: column; align-items: flex-start;">
                  <div style="display: inline;">${revisorPersonal}</div>
                  <div style="display: inline;">${revisorMiembro}</div>
              </div>
            `;
        }
        },
 
         {
           // Actions
           targets: -1,
           title: 'Acciones',
           searchable: false,
           orderable: false,
           render: function (data, type, full, meta) {
             return (
              '<div class="d-flex align-items-center gap-50">' +
                `<button class="btn btn-sm dropdown-toggle hide-arrow ` + (full['estatus'] == 1 ? 'btn-danger disabled' : 'btn-info') + `" data-bs-toggle="dropdown">` +
                (full['estatus'] == 1 ? 'Cancelado' : '<i class="ri-settings-5-fill"></i>&nbsp;Opciones<i class="ri-arrow-down-s-fill ri-20px"></i>') + 
                '</button>' +
                  '<div class="dropdown-menu dropdown-menu-end m-0">' +
                    `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#ModalEditar" href="javascript:;" class="dropdown-item text-dark editar"> <i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>` +
                    `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#asignarRevisorModal" class="dropdown-item waves-effect text-dark"> <i class="text-warning ri-user-search-fill"></i> Asignar revisor </a>` +
                    `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#modalAddReexCerExpor" class="dropdown-item waves-effect text-black reexpedir"> <i class="ri-file-edit-fill text-success"></i> Reexpedir/Cancelar</a>` +
                    `<a data-id="${full['id_certificado']}" class="dropdown-item waves-effect text-black eliminar"> <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>` +
                  '<div class="dropdown-menu dropdown-menu-end m-0">' +
                    '<a href="' + userView + '" class="dropdown-item">View</a>' +
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
                 "sFirst":    "Primero",
                 "sLast":     "Último",
                 "sNext":     "Siguiente",
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
               title: 'Categorías de Agave',
               text: '<i class="ri-printer-line me-1" ></i>Print',
               className: 'dropdown-item',
               exportOptions: {
                 columns: [1, 2, 3],
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
               title: 'Users',
               text: '<i class="ri-file-text-line me-1" ></i>Csv',
               className: 'dropdown-item',
               exportOptions: {
                 columns: [1, 2, 3],
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
               title: 'Categorías de Agave',
               text: '<i class="ri-file-excel-line me-1"></i>Excel',
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
               extend: 'pdf',
               title: 'Categorías de Agave',
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
               title: 'Categorías de Agave',
               text: '<i class="ri-file-copy-line me-1"></i>Copy',
               className: 'dropdown-item',
               exportOptions: {
                 columns: [1, 2, 3],
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
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Firmar Docusign</span>',
          className: 'btn btn-info waves-effect waves-light me-2',
          action: function (e, dt, node, config) {
            window.location.href = '/add_firmar_docusign';
          }
        },
        
         {
           text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Certificado</span>',
           className: 'add-new btn btn-primary waves-effect waves-light',
           attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#ModalAgregar'
           }
         }
       ],
 
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

       
  });
}// end-datatable

 
 
///AGREGAR NUEVO REGISTRO
//const form = document.getElementById('FormAgregar');
//Validación del formulario por "name"
const fv = FormValidation.formValidation(FormAgregar, {
    fields: {
        num_certificado: {
            validators: {
                notEmpty: {
                    message: 'El número de certificado es obligatorio.'
                }
            }
        },
        id_dictamen: {
          validators: {
              notEmpty: {
                  message: 'El número de dictamen es obligatorio.'
              }
          }
        },
        fecha_emision: {
            validators: {
                notEmpty: {
                  message: 'La fecha de emisión es obligatoria.',
                },
                date: {
                  format: 'YYYY-MM-DD',
                  message: 'Ingresa una fecha válida (yyyy-mm-dd).',
                }
            }
        },
        fecha_vigencia: {
            validators: {
                notEmpty: {
                  message: 'La fecha de vigencia es obligatoria.',
                },
                date: {
                  format: 'YYYY-MM-DD',
                  message: 'Ingresa una fecha válida (yyyy-mm-dd).',
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

  var formData = new FormData(FormAgregar);
    $.ajax({
        url: '/creaCerExp',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          console.log('Error222:', response);
            $('#ModalAgregar').modal('hide');//modal
            $('#FormAgregar')[0].reset();//formulario
  
            // Actualizar la tabla sin reinicializar DataTables
            dataTable.ajax.reload();
            // Mostrar alerta de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: response.success,
                customClass: {
                  confirmButton: 'btn btn-primary'
                }
            });
        },
        error: function (xhr) {
          console.log('Error:', xhr);
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
          url: `${baseUrl}deletCerExp/${id_certificado}`,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function () {
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
$(document).ready(function() {
  // Función para cargar los datos
  $(document).on('click', '.editar', function () {//clase del boton "editar"
      var id_certificado = $(this).data('id');
      $('#edit_id_certificado').val(id_certificado);

      $.ajax({
          url: '/editCerExp/' + id_certificado + '/edit',
          method: 'GET',
          success: function (datos) {
              // Asignar valores a los campos del formulario
              //$('#edit_id_certificado').val(datos.id_certificado).trigger('change');
              $('#edit_num_certificado').val(datos.num_certificado);
              $('#edit_id_dictamen').val(datos.id_dictamen).trigger('change');
              $('#edit_fecha_emision').val(datos.fecha_emision);
              $('#edit_fecha_vigencia').val(datos.fecha_vigencia);
              $('#edit_id_firmante').val(datos.id_firmante).prop('selected', true).change();
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

  // Manejar el envío del formulario de edición
  $('#FormEditar').on('submit', function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      var id_certificado = $('#edit_id_certificado').val();//Obtener el ID del registro desde el campo oculto

      $.ajax({
          url: '/editCerExp/' + id_certificado,
          type: 'PUT',
          data: formData,
          success: function(response) {
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

  //funcion fechas
  $('#rex_fecha_emision').on('change', function () {
    var fecha_emision = $(this).val();
    if (fecha_emision) {
        var fecha = moment(fecha_emision, 'YYYY-MM-DD');
        var fecha_vigencia = fecha.add(90, 'days').format('YYYY-MM-DD');
        $('#rex_fecha_vigencia').val(fecha_vigencia);
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
      $.get(`/editCerExp/${id_certificado}/edit`).done(function (datos) {
      console.log('Respuesta completa:', datos);
  
          if (datos.error) {
              showError(datos.error);
              return;
          }

          $('#rex_id_dictamen').val(datos.id_dictamen).trigger('change');
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
      $('#rex_id_dictamen').val('');
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
            notEmpty: {
              message: 'La fecha de vigencia es obligatoria.'
            },
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



///FORMATO PDF CERTIFICADO
$(document).on('click', '.pdfCertificado', function ()  {
  var id = $(this).data('id');//Obtén el ID desde el atributo "data-id" en PDF
  var pdfUrl = '/certificado_exportacion/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');
      
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    
    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();

    $("#titulo_modal").text("Certificado de Exportación");
    $("#subtitulo_modal").text("PDF del Certificado");
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
});

///FORMATO PDF SOLICITUD CERTIFICADO
$(document).on('click', '.pdfSolicitudCertificado', function ()  {
  var id = $(this).data('id');//Obtén el ID desde el atributo "data-id" en PDF
  var pdfUrl = '/solicitud_certificado_exportacion/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');
      
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    
    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();

    $("#titulo_modal").text("Solicitud de emisión de Certificado para Exportación");
    $("#subtitulo_modal").text("PDF de la solicitud");
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
});

///FORMATO PDF DICTAMEN
$(document).on('click', '.pdfDictamen', function ()  {
  var id = $(this).data('id');
  var pdfUrl = '/dictamen_exportacion/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();
    $("#titulo_modal").text("Dictamen de Cumplimiento para Producto de Exportación");
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



///OBTENER REVISORES
$(document).ready(function() {
  $('#tipoRevisor').on('change', function() {
      var tipoRevisor = $(this).val();

      $('#nombreRevisor').empty().append('<option value="">Seleccione un revisor</option>');

      if (tipoRevisor) {
          var tipo = (tipoRevisor === '1') ? 1 : 4; 

          $.ajax({
              url: '/ruta-para-obtener-revisores',
              type: 'GET',
              data: { tipo: tipo },
              success: function(response) {

                  if (Array.isArray(response) && response.length > 0) {
                      response.forEach(function(revisor) {
                          $('#nombreRevisor').append('<option value="' + revisor.id + '">' + revisor.name + '</option>');
                      });
                  } else {
                      $('#nombreRevisor').append('<option value="">No hay revisores disponibles</option>');
                  }
              },
              error: function(xhr) {
                  console.log('Error:', xhr.responseText);
                  alert('Error al cargar los revisores. Inténtelo de nuevo.');
              }
          });
      }
  });
});

///ASIGNAR REVISOR
$('#asignarRevisorForm').hide();

const form = document.getElementById('asignarRevisorForm');
const fv2 = FormValidation.formValidation(form, {
  fields: {
      'tipoRevisor': {
          validators: {
              notEmpty: {
                  message: 'Debe seleccionar una opción para la revisión.'
              }
          }
      },
      'nombreRevisor': {
          validators: {
              notEmpty: {
                  message: 'Debe seleccionar un nombre para el revisor.'
              }
          }
      },
      'numeroRevision': {
          validators: {
              notEmpty: {
                  message: 'Debe seleccionar un número de revisión.'
              }
          }
      }
  },
  plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: '.mb-3'
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
  }
}).on('core.form.valid', function (e) {
  var formData = new FormData(form);
  var id_certificado = $('#id_certificado').val();
  var tipoRevisor = $('#tipoRevisor').val(); 
  var revisorValue = $('#nombreRevisor').val(); 
  
  console.log('ID Certificado:', id_certificado);
  console.log('Tipo de Revisor:', tipoRevisor);
  console.log('Valor del Revisor:', revisorValue);

  if (tipoRevisor == '1') { 
      formData.append('id_revisor', revisorValue);
      formData.append('id_revisor2', null); 
  } else if (tipoRevisor == '2') {
      formData.append('id_revisor2', revisorValue);
      formData.append('id_revisor', null); 
  }

  // Añadir otros datos
  formData.append('id_certificado', id_certificado);
  var esCorreccion = $('#esCorreccion').is(':checked') ? 'si' : 'no';
  formData.append('esCorreccion', esCorreccion);

  console.log('FormData:', Array.from(formData.entries())); 

  $.ajax({
      url: '/asignar_revisor_exportacion',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
          $('#asignarRevisorModal').modal('hide');
          Swal.fire({
              icon: 'success',
              title: '¡Éxito!',
              text: response.message,
              customClass: {
                  confirmButton: 'btn btn-success'
              }
          }).then(function () {
              form.reset();
              $('#nombreRevisor').val(null).trigger('change');
              $('#esCorreccion').prop('checked', false);
              fv.resetForm();
              $('.datatables-users').DataTable().ajax.reload();
          });
      },
      error: function (xhr) {
          $('#asignarRevisorModal').modal('hide');
          Swal.fire({
              icon: 'success',
              title: '¡Éxito!',
              text: 'Revisor asignado exitosamente',
              customClass: {
                  confirmButton: 'btn btn-success'
              }
          }).then(function () {
              form.reset();
              $('#nombreRevisor').val(null).trigger('change');
              $('#esCorreccion').prop('checked', false);
              fv.resetForm();
              $('.datatables-users').DataTable().ajax.reload();
          });
      }
  });
});

$('#nombreRevisor').on('change', function () {
  fv.revalidateField($(this).attr('name'));
});

$('#asignarRevisorModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var id_certificado = button.data('id'); 
  $('#id_certificado').val(id_certificado);
  console.log('ID Certificado al abrir modal:', id_certificado);
  fv.resetForm();
  form.reset();

  $('#asignarRevisorForm').show();
});




 
 

});//end-function(jquery)
