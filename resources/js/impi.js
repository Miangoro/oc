/* Page User List */
'use strict';

$(document).ready(function () {
  flatpickr(".flatpickr-datetime", {
      dateFormat: "Y-m-d", // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
      enableTime: false,   // Desactiva la  hora
      allowInput: true,    // Permite al usuario escribir la fecha manualmente
      locale: "es",        // idioma a español
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
         url: baseUrl + 'tramite-list'
       },
       columns: [
         // columns according to JSON
         { data: '' },
         { data: 'folio' },
         { data: 'fecha_solicitud' },
         { data: 'razon_social' },
         { data: 'tramite' },
         { data: 'contrasena' },
         { data: 'pago' },
         { data: 'contacto' },
         { data: 'observaciones' },
         { data: 'estatus' },
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
          // Tabla 3 (empresa y folio)
          targets: 3,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $razon_social = full['id_empresa'] ?? 'N/A';
            return '<span class="user-email">' + $razon_social + '</span>';
          }
        },
        {
          // Tabla 4 (tramite)
          targets: 4,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
           var $tramite = full['tramite'];

           if ($tramite == 1){
             return '<span style="color:red;">Registro de marca</span>';
           }
           else if($tramite == 2){
                 return '<span style="color:red;">Trámite USO DE LA DOM</span>';
           }
           else if($tramite == 3){
             return '<span style="color:red;">Inscripción de convenio de correponsabilidad</span>';
           }
           else if($tramite == 4){
             return '<span style="color:red;">Licenciamiento de la marca</span>';
           }
           else if($tramite == 5){
            return '<span style="color:red;">Cesión de derechos de marca</span>';
          }
          else if($tramite == 6){
            return '<span style="color:red;">Declaración de uso de marca</span>';
          }else{
            return ' ';
          }
          }
        },
         {
           // Tabla 9 (estatus)
           targets: 9,
           responsivePriority: 4,
           render: function (data, type, full, meta) {
            var $name = full['estatus'];

            if ($name == 1){
              return '<span class="badge rounded-pill bg-dark">Pendiente</span>';
            }
            else if($name == 2){
                  return '<span class="badge rounded-pill bg-warning">Tramite</span>';
            }
            else if($name == 3){
              return '<span class="badge rounded-pill bg-primary">Tramite favorable</span>';
            }
            else if($name == 4){
              return '<span class="badge rounded-pill bg-danger">Tramite no favorable</span>';
            }else{
              return ' ';
            }
           }
         },
          {
           // Tabla 7 telefono y correo
           targets: 7,
           render: function (data, type, full, meta) {
             var $contacto = full['contacto'] ?? '';
             /*return '<span class="fw-bold">Telefono:</span> <br>'+
              '<span class="fw-bold">Correo:</span>';*/
              return '<span class="user-email">' + $contacto + '</span>';
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

                   `<a data-id="${full['id_impi']}" data-bs-toggle="modal" data-bs-target="#ModalEditar" class="dropdown-item waves-effect editar text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Editar evento</a>` +

                   `<a data-id="${full['id_impi']}" data-bs-toggle="modal" data-bs-target="#addEvento"  class="dropdown-item waves-effect add-event text-primary"><i class="ri-add-circle-line  ri-20px text-primary"></i> Agregar evento </a> ` +

                   `<a data-id="${full['id_impi']}" data-bs-toggle="modal" data-bs-target="#ModalTracking" class="dropdown-item waves-effect text-warning trazabilidad" >
                   <i class="ri-history-line ri-20px text-warning"></i> Trazabilidad</a> ` +

                   `<a data-id="${full['id_impi']}" class="dropdown-item waves-effect text-danger eliminar"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar evento</a>` +

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
           text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Trámite</span>',
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
               return 'Detalles de ' + data['id_impi'];
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




///FUNCION PARA REGISTRAR
//Inicializar validacion del formulario
const formAdd = document.getElementById('FormAgregar');
const fv = FormValidation.formValidation(formAdd, {
    fields: {//valida por name
      fecha_solicitud: {
            validators: {
                notEmpty: {
                    message: 'Seleccione una fecha'
                }
            }
        },
        tramite: {
          validators: {
              notEmpty: {
                  message: 'Seleccione el trámite'
              }
          }
      },
      id_empresa: {
            validators: {
                notEmpty: {
                    message: 'Seleccione el cliente'
                }
            }
        },
        contrasena: {
            validators: {
                notEmpty: {
                    message: 'Introduzca una contraseña'
                }
            }
        },
        pago: {
            validators: {
                notEmpty: {
                    message: 'Introduzca el pago'
                }
            }
        },
        estatus: {
          validators: {
              notEmpty: {
                  message: 'Seleccione un estatus'
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
}).on('core.form.valid', function (e) {

//enviar el formulario cuando pase la validación
  var formData = new FormData(formAdd);
    $.ajax({
        url: 'registrarImpi',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          console.log('Registrado:', response);
            $('#ModalAgregar').modal('hide');
            $('#FormAgregar')[0].reset();

            dt_user.ajax.reload();
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
          console.log('Error:', xhr.responseJSON);
          //console.log('Error2:', xhr.responseText);
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

// Limpiar formulario y validación al cerrar el modal
$('#ModalAgregar').on('hidden.bs.modal', function () {
    formAdd.reset();// Resetear los campos del formulario
    fv.resetForm(true);// Limpiar validaciones y errores
    $('.select2').val(null).trigger('change');// Si tienes Select2, también limpiar selección
});




///FUNCION PARA ELIMINAR
$(document).on('click', '.eliminar', function () {
    var id_dictamen = $(this).data('id'); // Obtener el ID del registro
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
                url: `${baseUrl}eliminarImpi/${id_dictamen}`,
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
                        text: '¡El registro ha sido eliminado correctamente!',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                },
                error: function (error) {
                    console.log('Error:', error.responseJSON);
                    //console.log('Error2:', error.responseText);
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
                title: 'Cancelado',
                text: 'La eliminación ha sido cancelada',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});



///FUNCION PARA OBTENER DATOS
//$(document).ready(function() {
//$(function () {

  // Abrir el modal y cargar datos para editar
  $(document).on('click', '.editar', function () {
      var id_dictamen = $(this).data('id');
      $('#edit_id_impi').val(id_dictamen);

      // Realizar la solicitud AJAX para obtener los datos de la clase
      $.ajax({
          url: '/obtenerImpi/' + id_dictamen + '/edit',
          method: 'GET',
          success: function (data) {
            // Rellenar el formulario con los datos obtenidos
            $('#edit_fecha_solicitud').val(data.fecha_solicitud);
            $('#edit_tramite').val(data.tramite).prop('selected', true).change();
            $('#edit_cliente').val(data.id_empresa).prop('selected', true).change();
            $('#edit_contrasena').val(data.contrasena);
            $('#edit_pago').val(data.pago);
            $('#edit_estatus').val(data.estatus).prop('selected', true).change();
            $('#edit_observaciones').val(data.observaciones);
            //$('#edit_categorias').val(data.categorias).trigger('change');

            // Mostrar el modal de edición
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

  ///FUNCION PARA ACTUALIZAR
  // Inicializar validacion del formulario
  const formEdit = document.getElementById('FormEditar');
  const fv2 = FormValidation.formValidation(formEdit, {
    fields: {
      fecha_solicitud: {
            validators: {
                notEmpty: {
                    message: 'Seleccione una fecha'
                }
            }
        },
      tramite: {
        validators: {
            notEmpty: {
                message: 'Seleccione el trámite'
            }
        }
      },
      id_empresa: {
          validators: {
              notEmpty: {
                  message: 'Seleccione el cliente'
              }
          }
      },
      contrasena: {
          validators: {
              notEmpty: {
                  message: 'Introduzca una contraseña'
              }
          }
      },
      pago: {
          validators: {
              notEmpty: {
                  message: 'Introduzca el pago'
              }
          }
      },
      estatus: {
        validators: {
            notEmpty: {
                message: 'Seleccione un estatus'
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
      //enviar el formulario cuando pase la validación
      var formData = new FormData(formEdit);
      var id_impi = $('#edit_id_impi').val();

      $.ajax({
          url: '/actualizarImpi/'+ id_impi,
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            dt_user.ajax.reload(null, false);
            $('#ModalEditar').modal('hide');//ocultar modal
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
            console.log('Error:', xhr.responseJSON);
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al actualizar.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
      });
  });

//});







// Cuando das clic en "Agregar evento"
$(document).on('click', '.add-event', function() {
    let id = $(this).data('id'); // trae el id_impi del botón
    $('#id_impi').val(id); // lo guardamos en el input hidden

    // Realizar la solicitud AJAX para obtener los datos de la clase
      $.ajax({
          url: '/obtenerImpi/' + id + '/edit',
          method: 'GET',
          success: function (data) {
            console.log(data.estatus)
            //$('#estatus').val(data.estatus).trigger('change');
            //$('#estatus').val(data.estatus).prop('selected', true).change();
            $('#edit_estatus').val(data.estatus).prop('selected', true).change();

            // Mostrar el modal de edición
            $('#addEvento').modal('show');
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
///REGISTRAR EVENTO
const fv3 = FormValidation.formValidation(NuevoEvento, {
  fields: {
//valida por name
    evento: {
      validators: {
          notEmpty: {
              message: 'Este campo es obligatorio.'
          }
      }
    },
    descripcion: {
      validators: {
          notEmpty: {
              message: 'Este campo es obligatorio.'
          }
      }
    },
    /*estatus: {
      validators: {
          notEmpty: {
              message: 'Seleccione '
          }
      }
    },
    anexo: {
        validators: {
            notEmpty: {
                message: 'Introduzca una contraseña'
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
}).on('core.form.valid', function (e) {

var formData = new FormData(NuevoEvento);
  $.ajax({
      url: 'crearEvento',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        console.log('Registrado:', response);
          $('#addEvento').modal('hide');//modal que encierra al formulario #addEvento
          $('#NuevoEvento')[0].reset();
          dt_user.ajax.reload();
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
        console.log('Error:', xhr.responseJSON);
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




///VER TRAZABILIDAD
/* $(document).on("click", ".trazabilidad", function () {
    let idImpi = $(this).data("id");
    $("#ListTracking").html(""); // limpia la lista

    $.get(`/trazabilidadImpi/${idImpi}`, function (data) {
        if (data.length === 0) {
            $("#ListTracking").append(
                `<li class="timeline-item timeline-item-transparent">
                    <span class="timeline-point timeline-point-secondary"></span>
                    <div class="mt-2 pb-3 border border-secondary p-3 rounded text-center">
                        <h6 class="text-muted">Sin eventos registrados</h6>
                    </div>
                </li>`
            );
        } else {
            data.forEach(ev => {
                $("#ListTracking").append(`
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-primary"></span>
                        <div class="mt-2 pb-3 border border-blue p-3 rounded">
                            <h6 class="text-primary mb-1"><i class="ri-user-fill me-1"></i> ${ev.evento}</h6>
                            <p class="mb-2">${ev.descripcion}</p>
                            ${ev.url_anexo
                                ? `<a href="/storage/tramites_impi/${ev.url_anexo}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ri-file-download-line me-1"></i> Ver anexo
                                   </a>`
                                : ""
                            }
                            <p class="text-muted small mt-2 mb-0">
                                <i class="ri-time-line me-1"></i> ${new Date(ev.created_at).toLocaleString()}
                            </p>
                        </div>
                    </li>
                    <hr>
                `);
            });
        }
    });
}); */
/* $(document).on("click", ".trazabilidad", function () {
    let idImpi = $(this).data("id");
    $("#ListTracking").html(""); // limpia la lista

    $.get(`/trazabilidadImpi/${idImpi}`, function (data) {
        if (data.length === 0) {
            $("#ListTracking").append(
                `<li class="timeline-item timeline-item-transparent">
                    <span class="timeline-point timeline-point-secondary"></span>
                    <div class="mt-2 pb-3 border border-secondary p-3 rounded text-center">
                        <h6 class="text-muted">Sin eventos registrados</h6>
                    </div>
                </li>`
            );
        } else {
            data.forEach(ev => {
                $("#ListTracking").append(`
                  <li class="timeline-item timeline-item-transparent">
                      <span class="timeline-point timeline-point-primary"></span>
                      <div class="mt-2 pb-3 border border-blue p-3 rounded">

                          <!-- Header con evento y botones -->
                          <div class="d-flex justify-content-between align-items-center mb-2">
                              <h6 class="text-primary mb-0">
                                  <i class="ri-user-fill me-1"></i> ${ev.evento}
                              </h6>
                              <div class="flex-shrink-0">
                                  <button class="btn btn-info btn-sm me-1 edit-event" data-id="${ev.id_evento}">
                                      <i class="ri-edit-2-line"></i>
                                  </button>
                                  <button class="btn btn-danger btn-sm delete-event" data-id="${ev.id_evento}">
                                      <i class="ri-delete-bin-line"></i>
                                  </button>
                              </div>
                          </div>

                          <!-- Descripción recortada -->
                          <p class="mb-2" style="max-width:100%;" title="${ev.descripcion}">
                              ${ev.descripcion}
                          </p>

                          <!-- Anexo -->
                          ${ev.url_anexo
                              ? `<a href="/storage/tramites_impi/${ev.url_anexo}" target="_blank" class="btn btn-sm btn-primary">
                                  <i class="ri-file-download-line me-1"></i> Ver anexo
                                </a>`
                              : ""
                          }

                          <!-- Fecha -->
                          <p class="text-muted small mt-2 mb-0">
                              <i class="ri-time-line me-1"></i> ${new Date(ev.created_at).toLocaleString()}
                          </p>
                      </div>
                  </li>
                  <hr>
              `);

            });
        }
    });
}); */

function cargarTrazabilidad(idImpi) {
    /* $("#ListTracking").html(""); */ // limpiar lista
    $("#ListTracking li.timeline-item").remove();
    $('hr').remove(); // Eliminar líneas horizontales previas
    $("#cargando").show();
    $.get(`/trazabilidadImpi/${idImpi}`, function (data) {
    $("#cargando").hide();
        if (data.length === 0) {
            $("#ListTracking").append(`
                <li class="timeline-item timeline-item-transparent">
                    <span class="timeline-point timeline-point-secondary"></span>
                    <div class="mt-2 pb-3 border border-secondary p-3 rounded text-center">
                        <h6 class="text-muted">Sin eventos registrados</h6>
                    </div>
                </li>
            `);
        } else {
            data.forEach(ev => {
                $("#ListTracking").append(`
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-primary"></span>
                        <div class="mt-2 pb-3 border border-blue p-3 rounded">

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="text-primary mb-0">
                                    <i class="ri-user-fill me-1"></i> ${ev.evento}
                                </h6>
                                <div class="flex-shrink-0">
                                    <button class="btn btn-info btn-sm me-1 edit-event" data-id="${ev.id_evento}">
                                        <i class="ri-edit-2-line"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-event" data-id="${ev.id_evento}">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>

                            <p class="mb-2" style="max-width:100%;" title="${ev.descripcion}">
                                ${ev.descripcion}
                            </p>

                            ${ev.url_anexo
                                ? `<a href="/storage/tramites_impi/${ev.url_anexo}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="ri-file-download-line me-1"></i> Ver anexo
                                  </a>`
                                : ""
                            }

                            <p class="text-muted small mt-2 mb-0">
                                <i class="ri-time-line me-1"></i> ${new Date(ev.created_at).toLocaleString()}
                            </p>
                        </div>
                    </li>
                    <hr>
                `);
            });
        }
    });
}

$(document).on("click", ".trazabilidad", function () {
    let idImpi = $(this).data("id");
    cargarTrazabilidad(idImpi);
    $("#ModalTracking").modal("show");
});

/* $(document).on("click", ".edit-event", function () {
    let idEvento = $(this).data("id");

    // Limpia el formulario
    $("#EditEventoForm")[0].reset();

    // Petición AJAX para traer datos del evento
    $.get(`/impi/evento/${idEvento}`, function (data) {
        $('#ModalTracking').modal('hide'); // Cerrar modal de trazabilidad
        // Rellenar inputs del modal
        $("#EditEvento input[name='id']").val(data.id);
        $("#EditEvento input[name='evento']").val(data.evento);
        $("#EditEvento textarea[name='descripcion']").val(data.descripcion);
        $('#url_anexo').html(data.url_anexo); // Limpiar el contenedor del anexo

        // Abrir modal
        $("#EditEvento").modal("show");
    });
}); */




$(document).ready(function() {

  // Inicializar validación
  const fvEdit = FormValidation.formValidation(
    document.getElementById('EditEventoForm'),
    {
      fields: {
        evento: {
          validators: {
            notEmpty: {
              message: 'El evento es obligatorio.'
            }
          }
        },
        descripcion: {
          validators: {
            notEmpty: {
              message: 'La descripción es obligatoria.'
            },
            stringLength: {
              max: 500,
              message: 'La descripción no puede exceder 500 caracteres.'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          rowSelector: '.form-floating',
          eleValidClass: '',
          eleInvalidClass: 'is-invalid'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }
  );

fvEdit.on('core.form.valid', function() {
    var form = document.getElementById('EditEventoForm');
    var formData = new FormData(form); // <-- incluye archivos

    $.ajax({
        url: "/impi/evento/update",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $("#EditEvento").modal("hide");
            dt_user.ajax.reload();
            Swal.fire({
              icon: "success",
              title: "¡Éxito!",
              text: response.message,
              customClass: { confirmButton: 'btn btn-primary' }
            });
            /* $("#ModalTracking").modal('show'); // Reabrir modal de trazabilidad */
            // Recargar la trazabilidad actualizada
            cargarTrazabilidad(response.id_impi);
            $("#ModalTracking").modal("show");
        },
        error: function(xhr) {
            Swal.fire({
              icon: "error",
              title: "¡Error!",
              text: xhr.responseJSON?.message || "No se pudo actualizar el evento",
              customClass: { confirmButton: 'btn btn-danger' }
            });
        }
    });
});



  // Abrir modal con datos del evento
  $(document).on("click", ".edit-event", function () {
    let idEvento = $(this).data("id");

    $("#EditEventoForm")[0].reset();   // limpiar formulario
    $("#url_anexo").html('');          // limpiar contenedor del anexo

    $.get(`/impi/evento/${idEvento}`, function(data) {
      $("#ModalTracking").modal('hide'); // cerrar modal de trazabilidad

      // Rellenar formulario
      $("#EditEventoForm input[name='id_evento']").val(data.id_evento);
      $("#EditEventoForm input[name='evento']").val(data.evento);
      $('#2edit_estatus').val(data.estatus).prop('selected', true).change();
      $("#EditEventoForm textarea[name='descripcion']").val(data.descripcion);
      // Mostrar enlace al anexo si existe
        if (data.url_anexo) {
            $("#url_anexo").html(`
                <a href="/storage/tramites_impi/${data.url_anexo}" target="_blank" class="btn btn-sm btn-primary mt-2">
                    <i class="ri-file-download-line me-1"></i> Ver anexo
                </a>
            `);
        }

      // Abrir modal de edición
      $("#EditEvento").modal("show");
    });
  });

});



//delete event
$(document).on("click", ".delete-event", function () {
    let idEvento = $(this).data("id");

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
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/impi/evento/delete/${idEvento}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    dt_user.ajax.reload(); // refrescar DataTable o trazabilidad
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: response.message,
                        customClass: { confirmButton: 'btn btn-primary' }
                    });
                    $("#ModalTracking").modal('hide'); // cerrar modal de trazabilidad
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: xhr.responseJSON?.message || 'No se pudo eliminar el evento',
                        customClass: { confirmButton: 'btn btn-danger' }
                    });
                }
            });
        }
    });

});




});//fin dataquery
