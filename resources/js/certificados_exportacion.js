/*
 Page User List
 */
'use strict';
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
//Sumar 1 año a la fecha inicial
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
//Sumar 1 día a la fecha inicial
  fechaInicial.setDate(fechaInicial.getDate() + 1);
  //Establecer el calendario de #fecha_vigencia en el año sumado
  $('#fecha_vigencia').datepicker("setDate", fechaInicial);
});

///FUNCION FECHAS EDIT
$('#edit_fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  //Sumar 1 año a la fecha inicial
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
  //Sumar 1 día a la fecha inicial
  fechaInicial.setDate(fechaInicial.getDate() + 1);
  //Establecer el calendario de #fecha_vigencia en el año sumado
  $('#edit_fecha_vigencia').datepicker("setDate", fechaInicial);
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
  var dt_user = dt_user_table.DataTable({
       processing: true,
       serverSide: true,
       ajax: {
         url: baseUrl + 'CerExpo-list'
       },
       columns: [

         { data: '' }, // (0)
         { data: null, //soli y serv. (1)
            render: function(data, type, row) {
            return `<span style="font-size:14px"> <strong>${data.folio}</strong><br>
                ${data.n_servicio}<span>`;
            }
         },
         {data: null, // Se usará null porque combinaremos varios valores
          render: function(data, type, row) {
              return `
              <strong>${data.numero_cliente}</strong><br>
                  <span style="font-size:12px">${data.razon_social}<span>
              `;
            }
         },
         { data: 'num_certificado' },
         { data: 'fechas' },
         { data: '' },
         { data: 'no_dictamen' },
         { data: '' },
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
          //Tabla 3
           targets: 3,
           render: function (data, type, full, meta) {
             var $num_certificado = full['num_certificado'];
             return '<span>' + $num_certificado + '</span>';
           }
         }, 
         {
          targets: 4,
          searchable: true,
          render: function (data, type, full, meta) {
            var $fech = full['fechas'];
            return '<span class="small">' + $fech + '</span>';
            }
        },

        {
          ///PDF CERTIFICADO
          targets: 5,
          searchable: false,
          orderable: false,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $id = full['id_certificado'];
            return '<i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-id="' + $id + '" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>';
          }
        },
        {
        targets: 6,
        render: function (data, type, full, meta) {
          var $id_dictamen = full['no_dictamen'];
          return '<span>' + $id_dictamen + '</span>';
        }
        }, 
        {
        targets: 7,
        render: function (data, type, full, meta) {
          //var $id_dictamen = full['no_dictamen'];
          return `
            <div style="display: flex; flex-direction: column;">
                <div style="display: inline;"> <span class="badge" style="background-color: transparent; color:  #676B7B;"><strong>Revisión OC:</strong> <strong style="color: red;">Sin asignar</strong></span> </div>
                <div style="display: inline;"> <span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Revisión Consejo:</strong> <strong style="color: red;">Sin asignar</strong></span> </div>
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
              '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
                   `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#editCerExpor" href="javascript:;" class="dropdown-item edit-record text-info"> <i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>` +
                   `<a data-id="${full['id_certificado']}" class="dropdown-item delete-record  waves-effect text-danger"> <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>` +
                   //Botón Asignar revisor
                   `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#asignarRevisorModal" class="dropdown-item waves-effect text-warning"> <i class="text-warning ri-user-search-fill"></i> Asignar revisor </a>` +
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
           text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Certificado</span>',
           className: 'add-new btn btn-primary waves-effect waves-light',
           attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#addCerExpor'
           }
         }
       ],
 
 ///PAGINA RESPONSIVA
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: function (row) {
            var data = row.data();
            return 'Detalles de ' + data['id_dictamen'];
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
// validating form and updating user's data
//const NuevoDictamenExport = document.getElementById('NuevoDictamenExport');

//Validación del formulario por "name"
const fv = FormValidation.formValidation(NuevoCertificadoExport, {
    fields: {
        num_certificado: {
            validators: {
                notEmpty: {
                    message: 'Introduzca el no. de certificado'
                }
            }
        },
        id_dictamen: {
          validators: {
              notEmpty: {
                  message: 'Seleccione una opcion'
              }
          }
        },
        fecha_emision: {
            validators: {
                notEmpty: {
                    message: 'Seleccione una fecha'
                }
            }
        },
        fecha_vigencia: {
            validators: {
                notEmpty: {
                    message: 'Seleccione una fecha'
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
            rowSelector: function (field, ele) {
                return '.mb-4, .mb-5, .mb-6'; // Ajusta según las clases de tus elementos
            }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
    }
}).on('core.form.valid', function (e) {

  var formData = new FormData(NuevoCertificadoExport);
    $.ajax({
        url: '/creaCerExp',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          console.log('Error222:', response);
            $('#addCerExpor').modal('hide');//modal
            $('#NuevoCertificadoExport')[0].reset();//formulario
  
            // Actualizar la tabla sin reinicializar DataTables
      //es lo mismo que abajo$('.datatables-users').DataTable().ajax.reload();
            dt_user.ajax.reload();
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
          console.log('Error:', xhr);
            // Mostrar alerta de error
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '¡Error al registrar!',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }
    });
});



///ELIMINAR REGISTRO
$(document).on('click', '.delete-record', function () {//clase del boton "eliminar"
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
          url: `${baseUrl}deletCerExp/${id_certificado}`,
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
                  text: '¡El Certificado ha sido eliminado correctamente!',
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
                  text: 'No se pudo eliminar el certificado. Inténtelo más tarde.',
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
            text: 'La eliminación del Certificado ha sido cancelada',
            icon: 'info',
            customClass: {
                confirmButton: 'btn btn-primary'
            }
        });
      }
  });
});



///EDITAR REGISTRO
$(document).ready(function() {
  // Abrir el modal y cargar datos para editar
  $('.datatables-users').on('click', '.edit-record', function() {//clase del boton "editar"
      var id_certificado = $(this).data('id');//ID de la clase

      // Realizar la solicitud AJAX para obtener los datos de la clase
      $.get('/editCerExp/' + id_certificado + '/edit', function(data) {
        
          // Rellenar el formulario con los datos obtenidos
          $('#id_certificado').val(data.id_certificado);
          $('#edit_num_certificado').val(data.num_certificado);
          $('#edit_id_dictamen').val(data.id_dictamen).prop('selected', true).change();
          //$('#edit_id_dictamen').val(data.id_dictamen).trigger('change');
          $('#edit_fecha_emision').val(data.fecha_emision);
          $('#edit_fecha_vigencia').val(data.fecha_vigencia);
          $('#edit_id_firmante').val(data.id_firmante).trigger('change');//funcion en select
          //$('#edit_id_firmante').val(data.id_firmante).prop('selected', true).change();
          
          // Mostrar el modal de edición
          $('#editCerExpor').modal('show');
      }).fail(function() {
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al obtener los datos',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
          });
      });
  });

  // Manejar el envío del formulario de edición
  $('#EditarCertificadoExport').on('submit', function(e) {
      e.preventDefault();

      var formData = $(this).serialize();
      var id_certificado = $('#id_certificado').val();//Obtener el ID del registro desde el campo oculto

      $.ajax({
          url: '/editCerExp/' + id_certificado,
          type: 'PUT',
          data: formData,
          success: function(response) {
              $('#editCerExpor').modal('hide'); // Ocultar el modal de edición
              $('#EditarCertificadoExport')[0].reset(); // Limpiar el formulario
              // Mostrar alerta de éxito
              Swal.fire({
                  icon: 'success',
                  title: '¡Éxito!',
                  text: response.success,
                  customClass: {
                      confirmButton: 'btn btn-success'
                  }
              });
              // Recargar los datos en la tabla sin reinicializar DataTables
              $('.datatables-users').DataTable().ajax.reload();
          },
          error: function(xhr) {
            console.log('Error:', xhr.responseText);
              // Mostrar alerta de error
              Swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: '¡Error al actualizar el certificado!',
                  customClass: {
                      confirmButton: 'btn btn-danger'
                  }
              });
          }
      });
  });
});



///FORMATO PDF
$(document).on('click', '.pdf', function ()  {
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



 
 

});//end-function(jquery)
