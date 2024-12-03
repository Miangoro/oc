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

//const { formatDate } = require("@fullcalendar/core/index.js");

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


///FECHAS FORMAT ADD
$('#fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());

//Sumar 1 año a la fecha inicial
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
//Sumar 1 día a la fecha inicial
  fechaInicial.setDate(fechaInicial.getDate() + 1);

//Formatear la fecha en YYYY-MM-DD
  var year = fechaInicial.getFullYear();
  var month = ('0' + (fechaInicial.getMonth() + 1)).slice(-2); // Los meses empiezan desde 0
  var day = ('0' + fechaInicial.getDate() ).slice(-2); // Usamos el día original

//Asignar la fecha final al input correspondiente
  //$('#fecha_vigencia').val(year + '/' + month + '/' + day);//misma funcion que la linea de abajo

//Establecer el calendario de #fecha_vigencia en el año sumado
  //$('#fecha_vigencia').datepicker("option", "yearRange", (year) + ":" + (year)); //rango de años
  $('#fecha_vigencia').datepicker("setDate", fechaInicial); // un dia menos, calendario bien
});


//7FECHAS FORMAT EDIT
$('#edit_fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());

  //Sumar 1 año a la fecha inicial
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
  //Sumar 1 día a la fecha inicial
  fechaInicial.setDate(fechaInicial.getDate() + 1);

  //Establecer el calendario de #fecha_vigencia en el año sumado
  $('#edit_fecha_vigencia').datepicker("setDate", fechaInicial); // un dia menos, calendario bien
});



  
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
         url: baseUrl + 'insta'
       },
       columns: [
         // columns according to JSON
         { data: '' },
         { data: 'tipo_dictamen' },
         { data: 'num_dictamen' },
         { data: 'num_servicio' },
         { data: 'razon_social' },
         { data: 'direccion_completa' },
         { data: 'fecha_emision' },
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
         /*{//Tabla 1
           searchable: false,
           orderable: false,
           targets: 1,
           render: function (data, type, full, meta) {
             return `<span>${full.fake_id}</span>`;
           }
         },*/
         {
           // Tabla 2
           targets: 1,
           responsivePriority: 4,
           render: function (data, type, full, meta) {
             var $name = full['tipo_dictamen'];
             if ($name == 1){
                return '<span class="text-primary">Productor</span>';
             }
             else if($name == 2){ 
                    return '<span class="text-success">Envasador</span>';
             }
             else if($name == 3){ 
                return '<span class="text-info">Comercializador</span>';
            }
            else if($name == 4){ 
                return '<span class="text-danger">Almacén y bodega</span>';
            }
            else if($name == 5){ 
              return '<span class="text-warning">Área de maduración</span>';
            }

             //return $name;
           }
         },
          {
           // Tabla 3
           targets: 2,
           render: function (data, type, full, meta) {
             var $num_dictamen = full['num_dictamen'];
             return '<span class="fw-bold">' + $num_dictamen + '</span>';
           }
         }, 
         {
            // Tabla 4
            targets: 3,
            render: function (data, type, full, meta) {
              var $num_servicio = full['num_servicio'];
              return '<span class="user-email">' + $num_servicio + '</span>';
            }
          }, 
          {
            // Tabla 5
            targets: 6,
            render: function (data, type, full, meta) {
              var $fechaE = full['fecha_emision'];
              var $fechaV = full['fecha_vigencia'];
              /*return '<span ><b>Fecha Emisión:</b>' + $fechaE + '<br>' +
              '<b>Fecha Vigencia:</b>' + $fechaE + '</span>';*/
              return '<span class="fw-bold text-dark small">Fecha Emisión:</span> <span class="small">' + $fechaE + '</span> <br>' +
              '<span class="fw-bold text-dark small">Fecha Vigencia:</span> <span class="small">' + $fechaV + '</span>';
            }
          },
          {
            // Abre el pdf del dictamen
            targets: 7,
            className: 'text-center',
            //searchable: false, orderable: false, //Inhabilita "thead" busqueda/orden
            render: function (data, type, full, meta) {
              var $id = full['id_dictamen'];
              return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-tipo="${full['tipo_dictamen']}" data-id="${full['id_dictamen']}" data-registro="${full['razon_social']} "></i>`;
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
/*               `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_dictamen']} data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editDictamen"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
              `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_dictamen']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` + */
                   `<a data-id="${full['id_dictamen']}" data-bs-toggle="modal" data-bs-target="#editDictamen" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar dictamen</a>` +
                   `<a data-id="${full['id_dictamen']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar dictamen</a>` +
                   //'<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line ri-20px"></i></button>' +
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
             /*'data-bs-toggle': 'offcanvas',
             'data-bs-target': '#offcanvasAddUser'*/
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#addDictamen'
           }
         }
       ],
 
 ///PAGINA RESPONSIVA
       responsive: {
         details: {
           display: $.fn.dataTable.Responsive.display.modal({
             header: function (row) {
               var data = row.data();
               return 'Detalles de ' + data['inspeccion'];
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
//const NuevoDictamen = document.getElementById('NuevoDictamen');

// Validación del formulario
const fv = FormValidation.formValidation(NuevoDictamen, {
    fields: {
      tipo_dictamen: {
            validators: {
                notEmpty: {
                    message: 'Seleccione una opcion'
                }
            }
        },
        num_dictamen: {
            validators: {
                notEmpty: {
                    message: 'Introduzca el no. de dictamen'
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
        id_inspeccion: {
            validators: {
                notEmpty: {
                    message: 'Seleccione una opcion'
                }
            }
        },
        'categorias[]': {
            validators: {
                notEmpty: {
                    message: 'Seleccione una categoría de agave'
                }
            }
        },
        'clases[]': {
            validators: {
                notEmpty: {
                    message: 'Seleccione una clase de agave'
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

  var formData = new FormData(NuevoDictamen);
/*$('#NuevoDictamen').on('submit', function (e) {//id del formulario #addNewCategory
    e.preventDefault();
    var formData = $(this).serialize();*/
    $.ajax({
        url: '/insta',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          console.log('Error222:', response);
            $('#addDictamen').modal('hide');//div que encierra al formulario #addDictamen
            $('#NuevoDictamen')[0].reset();
  
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
                url: `${baseUrl}insta/${id_dictamen}`,
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




//RECIBE LOS DATOS DEL PDF
$(document).on('click', '.pdf', function () {
  var id = $(this).data('id');//Obtén el ID desde el atributo "data-id" en opciones
  var registro = $(this).data('registro');//ID de razon social "data-registro"
  var tipo = $(this).data('tipo');
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    

      if(tipo == 1){ // Productor
        var tipo_dictamen = '../dictamen_productor/'+id;
        var titulo = "Dictamen de productor";
      }
      if(tipo == 2){ // Envasador
        var tipo_dictamen = '../dictamen_envasador/'+id;
        var titulo = "Dictamen de envasador";
      }
      if(tipo == 3){ // Comercializador
        var tipo_dictamen = '../dictamen_comercializador/'+id;
        var titulo = "Dictamen de comercializador";
      }
      if(tipo == 4){ // Almacén y bodega
        var tipo_dictamen = '../dictamen_almacen/'+id;
        var titulo = "Dictamen de almacén y bodega";
      }
      if(tipo == 5){ // Área de maduración
        var tipo_dictamen = '../dictamen_maduracion/'+id;
        var titulo = "Dictamen de área de maduración de mezcal";
      }
      
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    
    //Cargar el PDF con el ID
      iframe.attr('src', tipo_dictamen);
    //Configurar el botón para abrir el PDF en una nueva pestaña
      $("#NewPestana").attr('href', tipo_dictamen).show();

      $("#titulo_modal").text(titulo);
      $("#subtitulo_modal").text(registro);  

    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
      iframe.on('load', function () {
        spinner.hide();
        iframe.show();
      });
});




// FUNCION PARA EDITAR un registro
$(document).ready(function() {
  // Abrir el modal y cargar datos para editar
  $('.datatables-users').on('click', '.edit-record', function() {
      var id_dictamen = $(this).data('id');

      // Realizar la solicitud AJAX para obtener los datos de la clase
      $.get('/insta/' + id_dictamen + '/edit', function(data) {
        
          // Rellenar el formulario con los datos obtenidos
          $('#edit_id_dictamen').val(data.id_dictamen);
          $('#edit_tipo_dictamen').val(data.tipo_dictamen);
          $('#edit_num_dictamen').val(data.num_dictamen);
          $('#edit_fecha_emision').val(data.fecha_emision);
          $('#edit_fecha_vigencia').val(data.fecha_vigencia);
          $('#edit_id_inspeccion').val(data.id_inspeccion).prop('selected', true).change();
          //$('#edit_categorias').val(data.categorias);
          //$('#edit_clases').val(data.clases);
          $('#edit_categorias').val(data.categorias).trigger('change');
          $('#edit_clases').val(data.clases).trigger('change');


          // Mostrar el modal de edición
          $('#editDictamen').modal('show');
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
  $('#EditarDictamen').on('submit', function(e) {
      e.preventDefault();

      var formData = $(this).serialize();
      var id_dictamen = $('#edit_id_dictamen').val(); // Obtener el ID de la clase desde el campo oculto

      $.ajax({
          url: '/insta/' + id_dictamen,
          type: 'PUT',
          data: formData,
          success: function(response) {
              $('#editDictamen').modal('hide'); // Ocultar el modal de edición "DIV"
              $('#EditarDictamen')[0].reset(); // Limpiar el formulario "FORM"
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


 
 
 
 });
 



