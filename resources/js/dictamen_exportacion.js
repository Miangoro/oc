/*
 Page User List
 */
 'use strict';
 /* $(document).ready(function () {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    language: 'es' // Configura el idioma a español
  });
});
///FECHAS
$('#fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);//Sumar 1 año a la fecha inicial
  fechaInicial.setDate(fechaInicial.getDate() + 1);//Sumar 1 día a la fecha inicial
  //Establecer el calendario de #fecha_vigencia en el año sumado
  $('#fecha_vigencia').datepicker("setDate", fechaInicial);
});
///FECHAS EDIT
$('#edit_fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);//Sumar 1 año a la fecha inicial
  fechaInicial.setDate(fechaInicial.getDate() + 1); //Sumar 1 día a la fecha inicial
  //Establecer el calendario de #fecha_vigencia en el año sumado
  $('#edit_fecha_vigencia').datepicker("setDate", fechaInicial);
}); */
$(document).ready(function () {
  flatpickr(".flatpickr-datetime", {
      dateFormat: "Y-m-d", // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
      enableTime: false,   // Desactiva la  hora
      allowInput: true,    // Permite al usuario escribir la fecha manualmente
      locale: "es",        // idioma a español
  });
});
//FECHAS
$('#fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);// Sumar 1 año a la fecha inicial
  //fechaInicial.setDate(fechaInicial.getDate() + 1); // Sumar 1 día a la fecha inicial
  // Establecer la fecha de vigencia al año sumado sin que el calendario se recargue
  var fechaVigencia = fechaInicial.toISOString().split('T')[0]; // Formato YYYY-MM-DD
  // Actualizamos el valor de #fecha_vigencia
  $('#fecha_vigencia').val(fechaVigencia);
  // Deshabilitar la interacción con flatpickr en #fecha_vigencia.
  flatpickr("#fecha_vigencia", {
      dateFormat: "Y-m-d", // Formato de la fecha
      enableTime: false,    // Desactiva la hora
      allowInput: true,     // Permite la escritura manual
      locale: "es",         // Español
      static: true,         // Establece el calendario como no interactivo
      disable: true          // Español
  });
});
//FECHAS EDIT
$('#edit_fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);// Sumar 1 año a la fecha iniciaL
  // Establecer el valor en el campo edit_fecha_vigencia
  var fechaVigencia = fechaInicial.toISOString().split('T')[0]; // Formato YYYY-MM-DD
  // Actualizamos el valor de #edit_fecha_vigencia
  $('#edit_fecha_vigencia').val(fechaVigencia);

  // Deshabilitar la interacción con flatpickr en #edit_fecha_vigencia
  flatpickr("#edit_fecha_vigencia", {
    dateFormat: "Y-m-d",  // Formato de la fecha
    enableTime: false,     // Desactiva la hora
    allowInput: true,      // Permite la escritura manual
    locale: "es",          // Español
    static: true,          // Hace que el calendario no se muestre como interactivo
    disable: true          // Deshabilita la selección
  });
});




 // Datatable (jquery)
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
 
 
   //FUNCIONALIDAD DE LA VISTA datatable
   if (dt_user_table.length) {
     var dt_user = dt_user_table.DataTable({
       processing: true,
       serverSide: true,
       ajax: {
         url: baseUrl + 'expor-list'
       },
       columns: [
         // columns according to JSON
         { data: '' },
         { data: 'num_dictamen' },
         { data: 'id_inspeccion' },
         {
          data: null, // Se usará null porque combinaremos varios valores
          render: function(data, type, row) {
              return `
              <strong>${data.numero_cliente}</strong><br>
                  <span style="font-size:12px">${data.razon_social}<span>
              `;
            }
         },
         { data: 'fechas' },
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
           // Tabla 1
           targets: 1,
           render: function (data, type, full, meta) {
             var $num_dictamen = full['num_dictamen'];
             return '<span class="fw-bold">' + $num_dictamen + '</span>';
           }
         }, 
         {
            // Tabla 2
            targets: 2,
            render: function (data, type, full, meta) {
              var $id_inspeccion = full['id_inspeccion'];
              return '<span class="user-email">' + $id_inspeccion + '</span>';
            }
          }, 

          {
            // Tabla 4
            targets: 4,
            searchable: true,
            render: function (data, type, full, meta) {
              var $fech = full['fechas'];
              return '<span class="small">' + $fech + '</span>';
              }
          },
          {
            ///PDF
            targets: 5,
            searchable: false,
            orderable: false,
            className: 'text-center',
            render: function (data, type, full, meta) {
              var $id = full['id_dictamen'];
              return '<i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-id="' + $id + '" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>';
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
                    //Botón Editar
                   `<a data-id="${full['id_dictamen']}" data-bs-toggle="modal" data-bs-target="#editDictExpor" href="javascript:;" class="dropdown-item text-info edit-record"><i class="ri-edit-box-line ri-20px"></i> Editar dictamen</a>` +
                   //Botón Reexpedir Certificado
                   `<a data-id="${full['id_dictamen']}" data-bs-toggle="modal" data-bs-target="#modalAddReexDicExpor" class="dropdown-item waves-effect reexpedir"> <i class="ri-file-edit-fill"></i> Reexpedir/Cancelar</a>` +
                   //Botón Eliminar
                   `<a data-id="${full['id_dictamen']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar dictamen</a>` +
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
           text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Dictamen</span>',
           className: 'add-new btn btn-primary waves-effect waves-light',
           attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#addDictExpor'
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
   } 
 
 
 

// Agregar nuevo registro
// validating form and updating user's data
//const NuevoDictamenExport = document.getElementById('NuevoDictamenExport');

// Validación del formulario
const fv = FormValidation.formValidation(NuevoDictamenExport, {
    fields: {
        num_dictamen: {
            validators: {
                notEmpty: {
                    message: 'Introduzca el no. de dictamen'
                }
            }
        },
        id_inspeccion: {
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

  var formData = new FormData(NuevoDictamenExport);
    $.ajax({
        url: '/registrar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          console.log('Error222:', response);
            $('#addDictExpor').modal('hide');//div que encierra al formulario #addDictamen
            $('#NuevoDictamenExport')[0].reset();
  
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
                text: 'Error al subir!',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }
    });
  });



  // Eliminar registro
  $(document).on('click', '.delete-record', function () {
    var id_dictamen = $(this).data('id'); // Obtener el ID de la clase
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
                url: `${baseUrl}eliminar2/${id_dictamen}`,
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
                        text: '¡El Dictamen ha sido eliminada correctamente!',
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
                        text: 'No se pudo eliminar el dictamen. Inténtelo más tarde.',
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
                text: 'La eliminación del Dictamen ha sido cancelada',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});



// FUNCION PARA EDITAR un registro
$(document).ready(function() {
  // Abrir el modal y cargar datos para editar
  $('.datatables-users').on('click', '.edit-record', function() {
      var id_dictamen = $(this).data('id');

      // Realizar la solicitud AJAX para obtener los datos de la clase
      $.get('/editar2/' + id_dictamen + '/edit', function(data) {
        
          // Rellenar el formulario con los datos obtenidos
          $('#edit_id_dictamen').val(data.id_dictamen);
          $('#edit_num_dictamen').val(data.num_dictamen);
          $('#edit_id_inspeccion').val(data.id_inspeccion).prop('selected', true).change();
          $('#edit_fecha_emision').val(data.fecha_emision);
          $('#edit_fecha_vigencia').val(data.fecha_vigencia);
          $('#edit_id_firmante').val(data.id_firmante).prop('selected', true).change();
          //$('#edit_id_firmante').val(data.id_firmante).trigger('change');


          // Mostrar el modal de edición
          $('#editDictExpor').modal('show');
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
  $('#EditarDictamenExport').on('submit', function(e) {
      e.preventDefault();

      var formData = $(this).serialize();
      var id_dictamen = $('#edit_id_dictamen').val(); // Obtener el ID de la clase desde el campo oculto

      $.ajax({
          url: '/editar2/' + id_dictamen,
          type: 'PUT',
          data: formData,
          success: function(response) {
              $('#editDictExpor').modal('hide'); // Ocultar el modal de edición "DIV"
              $('#EditarDictamenExport')[0].reset(); // Limpiar el formulario "FORM"
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
                  text: 'Error al actualizar el dictamen',
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




///REEXPEDIR DICTAMEN 
//Evento para saber que dictamen Reexpedir
let isLoadingData = false;
let fieldsValidated = []; 

$(document).ready(function () {
    $(document).on('click', '.reexpedir', function () {
        var id_dictamen = $(this).data('id');
        console.log('ID Dictamen para reexpedir:', id_dictamen);
        $('#reexpedir_id_dictamen').val(id_dictamen);
        $('#modalAddReexDicExpor').modal('show');
    });

    $('#fecha_emision_rex').on('change', function () {
        var fecha_emision = $(this).val();
        if (fecha_emision) {
            var fecha = moment(fecha_emision, 'YYYY-MM-DD');
            var fecha_vigencia = fecha.add(1, 'years').format('YYYY-MM-DD');
            $('#fecha_vigencia_rex').val(fecha_vigencia);
        }
    });

    $(document).on('change', '#accion_reexpedir', function () {
        var accionSeleccionada = $(this).val();
        console.log('Acción seleccionada:', accionSeleccionada);
        var id_dictamen = $('#reexpedir_id_dictamen').val();

        if (accionSeleccionada && !isLoadingData) {
            isLoadingData = true;
            cargarDatosReexpedicion(id_dictamen);
        }

        if (accionSeleccionada === '2') {
          $('#campos_condicionales').slideDown();
        }else {
            $('#campos_condicionales').slideUp();
        }


    });



  $(document).on('change', '#accion_reexpedir', function () {
    var accionSeleccionada = $(this).val();
    console.log('Acción seleccionada:', accionSeleccionada);
    var id_dictamen = $('#reexpedir_id_dictamen').val();

    let shouldShowProductorFields = false;

    if (accionSeleccionada && !isLoadingData) {
        isLoadingData = true;
        cargarDatosReexpedicion(id_dictamen);
    }

    if (accionSeleccionada === '2') {
      $('#campos_condicionales').slideDown();
    }else {
        $('#campos_condicionales').slideUp();
    }

});
  
  function cargarDatosReexpedicion(id_dictamen) {
      console.log('Cargando datos para la reexpedición con ID:', id_dictamen);
      clearFields();
  
      $.get(`/editar2/${id_dictamen}/edit`)
          .done(function (data) {
              console.log('Respuesta completa:', data);
  
              if (data.error) {
                  showError(data.error);
                  return;
              }
  
              $('#id_inspeccion_rex').val(data.id_inspeccion).trigger('change');
              $('#numero_dictamen_rex').val(data.num_dictamen);
              $('#id_firmante_rex').val(data.id_firmante).trigger('change');
              $('#fecha_emision_rex').val(data.fecha_emision);
              $('#fecha_vigencia_rex').val(data.fecha_vigencia);
              $('#observaciones_rex').val(data.observaciones);
  
 
  
              $('#accion_reexpedir').trigger('change'); 
              isLoadingData = false;
  
          })
          .fail(function () {
              showError('No se pudieron cargar los datos para la reexpedición.');
              isLoadingData = false;
          });
  }
  
    function clearFields() {
        $('#numero_dictamen_rex').val('');
        $('#id_firmante_rex').val('');
        $('#fecha_emision_rex').val('');
        $('#fecha_vigencia_rex').val('');
        $('#observaciones_rex').val('');
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



    $('#modalAddReexDicExpor').on('hidden.bs.modal', function () {
        $('#formAddReexDicExpor')[0].reset();
        clearFields();
        $('#campos_condicionales').hide();
        fieldsValidated = []; 
    });

    const formReexpedir = document.getElementById('formAddReexDicExpor');
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
            'num_dictamen': {
                validators: {
                    notEmpty: {
                        message: 'El número de dictamen es obligatorio.'
                    }
                }
            },
            'id_inspeccion': {
                validators: {
                    notEmpty: {
                        message: 'Debes seleccionar una acción.'
                    }
                }
            },
            'id_firmante': {
                validators: {
                    notEmpty: {
                        message: 'Debes seleccionar una acción.'
                    }
                }
            },
            'fecha_emision': {
                validators: {
                    notEmpty: {
                        message: 'Debes seleccionar una acción.'
                    }
                }
            },
            'fecha_vigencia': {
                validators: {
                    notEmpty: {
                        message: 'Debes seleccionar una acción.'
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
                $('#modalAddReexDicExpor').modal('hide');
                formReexpedir.reset();

                dt_user_table.DataTable().ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            },
            error: function (jqXHR) {
                console.log('Error en la solicitud:', jqXHR);
                let errorMessage = 'No se pudo registrar la reexpedición. Por favor, verifica los datos.';
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


 
 
 
 });//end-function(jquery)
 