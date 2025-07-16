/*
 Page User List
 */
 'use strict';

$(document).ready(function () {
  flatpickr(".flatpickr-datetime", {
      dateFormat: "Y-m-d", // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
      enableTime: false,   // Desactiva la  hora
      allowInput: true,    // Permite al usuario escribir la fecha manualmente
      locale: "es",        // idioma a español
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


// Variable declaration for table
var dt_user_table = $('.datatables-users'),
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
  var dataTable = dt_user_table.DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + 'no_cumplimiento-list'
    },
    columns: [
      // columns according to JSON
      { data: '' },
      { data: 'num_dictamen' },
      { data: 'num_servicio' },
      { data: null, orderable: false,// Se usará null porque combinaremos varios valores
        render: function(data, type, row) {
          return `
            <strong>${data.numero_cliente}</strong>
            <br> <span style="font-size:11px">${data.razon_social}<span>`;
        }
      },
      { data: null,  render: function(data, type, row) {
          return ` `;
        }},
      { data: 'fecha_emision' },
      { data: null,  render: function(data, type, row) {
          return ` `;
        }},
      { data: 'action', orderable: false, searchable: false }

    ],
    columnDefs: [
      {
        // For Responsive
        targets: 0,
        className: 'control',
        searchable: false,//No será buscable en el cuadro de búsqueda.
        orderable: false,// No se podrá ordenar esta columna al hacer clic en el encabezado.
        responsivePriority: 1, //Los valores mas altos se ocultan primero.
        render: function (data, type, full, meta) {
          return '';
        }
      },
      {
        targets: 1,
        searchable: true,
        orderable: true,
        responsivePriority: 1,
        render: function (data, type, full, meta) {
          var $num_dictamen = full['num_dictamen'];
          return '<small class="fw-bold">'+ $num_dictamen +'</small>' +
              `<i data-id="${full['id_dictamen']}" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"  data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>`;
        }
      },

      {
        // Actions
        targets: -1,
        title: 'Acciones',
        render: function (data, type, full, meta) {

          // Construir y retornar el dropdown
          return `
            <div class="d-flex align-items-center gap-50">
              <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ri-settings-5-fill"></i>&nbsp;Opciones<i class="ri-arrow-down-s-fill ri-20px"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end m-0">
                    <a data-id="${full['id_dictamen']}" data-bs-toggle="modal" data-bs-target="#ModalEditar" href="javascript:;" class="dropdown-item text-dark editar">
                        <i class="ri-edit-box-line ri-20px text-info"></i> Editar
                    </a>
                    <a data-id="${full['id_dictamen']}" class="dropdown-item waves-effect text-dark eliminar">
                        <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar
                    </a>
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
        text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo dictamen</span>',
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



///REGISTRAR
FormValidation.formValidation(FormAgregar, {
  fields: {
    'id_inspeccion': {
      validators: {
        notEmpty: {
          message: 'El número de servicio es obligatorio.'
        }
      }
    },
    'num_dictamen': {
      validators: {
        notEmpty: {
          message: 'El número de dictamen es obligatorio.'
        },
      }
    },
    'id_firmante': {
      validators: {
        notEmpty: {
          message: 'El nombre del firmante es obligatorio.',
        }
      }
    },
    'fecha_emision': {
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
    'fecha_vigencia': {
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
  console.log('Envio de datos:', Object.fromEntries(formData.entries()));// Imprimir los datos para verificar
  $.ajax({
      url: '/registrar/no_cumplimiento',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar y resetear el formulario
        $('#ModalAgregar').modal('hide');
        $('#FormAgregar')[0].reset();
        $('.select2').val(null).trigger('change');
        dataTable.ajax.reload(false);//Recarga los datos del datatable

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



///ELIMINAR
$(document).on('click', '.eliminar', function () {
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
      url: `${baseUrl}dictamen/no_cumplimiento/${id_dictamen}`,
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
      // Acción cancelar, mostrar mensaje informativo
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
$(function () { //$(document).ready(function () {
  
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
  // Inicializar FormValidation para el formulario
  const form = document.getElementById('FormEditar');
  const fv = FormValidation.formValidation(form, {
    fields: {
      'id_inspeccion': {
          validators: {
          notEmpty: {
            message: 'El número de servicio es obligatorio.'
          }
          }
      },
      'num_dictamen': {
          validators: {
          notEmpty: {
            message: 'El número de dictamen es obligatorio.'
          },
          }
      },
      'id_firmante': {
          validators: {
          notEmpty: {
            message: 'El nombre del firmante es obligatorio.',
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
      // Validar y enviar el formulario cuando pase la validación
      var formData = new FormData(form);
      var dictamen = $('#edit_id_dictamen').val();

      $.ajax({
          url: '/dictamen/no_cumplimiento/' + dictamen,
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            dataTable.ajax.reload(null, false);//Recarga los datos del datatable, "null,false" evita que vuelva al inicio
            $('#ModalEditar').modal('hide');//ocultar modal
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

  // Función para cargar los datos
  $(document).on('click', '.editar', function () {
      var id_dictamen = $(this).data('id');
      $('#edit_id_dictamen').val(id_dictamen);

      $.ajax({
          url: '/dictamen/no_cumplimiento/' + id_dictamen,
          method: 'GET',
          success: function (datos) {
              // Asignar valores a los campos del formulario
              $('#edit_id_inspeccion').val(datos.id_inspeccion).trigger('change');
              $('#edit_num_dictamen').val(datos.num_dictamen);
              $('#edit_fecha_emision').val(datos.fecha_emision);
              $('#edit_fecha_vigencia').val(datos.fecha_vigencia);
              $('#edit_id_firmante').val(datos.id_firmante).prop('selected', true).change();
              $('#edit_observaciones').val(datos.observaciones);

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






///FORMATO PDF DICTAMEN
$(document).on('click', '.pdfDictamen', function () {
  var id = $(this).data('id');
  var pdfUrl = '/dictamen_no_cumplimiento/' + id; //Ruta del PDF
  var iframe = $('#pdfViewer');
  var spinner = $('#cargando');
  //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
  spinner.show();
  iframe.hide();
  //Cargar el PDF con el ID
  iframe.attr('src', pdfUrl);
  //Configurar el botón para abrir el PDF en una nueva pestaña
  $("#NewPestana").attr('href', pdfUrl).show();
  $("#titulo_modal").text("Dictamen de No Cumplimiento");
  $("#subtitulo_modal").text("PDF del Dictamen");
  //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
  iframe.on('load', function () {
    spinner.hide();
    iframe.show();
  });
});






});//end-function(jquery)
