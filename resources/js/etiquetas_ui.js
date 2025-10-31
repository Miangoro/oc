
'use strict';

// CSRF para Laravel
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Flatpickr global para todos los inputs con esta clase
flatpickr(".flatpickr-datetime", {
    dateFormat: "Y-m-d", // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
    enableTime: false,   // Desactiva la  hora
    allowInput: true,    // Permite al usuario escribir la fecha manualmente
    locale: "es",        // idioma a español
});

// Inicializar Select2
function initializeSelect2($elements) {
    $elements.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>').select2({
            dropdownParent: $this.parent()
        });
    });
}
initializeSelect2($('.select2'));


// Datatable (jquery)
$(function () {

//FUNCIONALIDAD DE LA VISTA datatable
if ($('.datatables-users').length) {
  var dataTable = $('.datatables-users').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '/etiquetas-list-granel'
    },
    columns: [
      // columns according to JSON
      { data: '' },//0
      { data: 'fake_id' },
      { data: 'fecha' },
      { data: 'num_servicio'},
      { data: 'lote'},
      { data: 'cliente'},
      { data: 'num_certificado'},
      { data: ''},//7
      { data: 'action'}
    ],
    columnDefs: [
      { // For Responsive
        targets: 0,
        className: 'control',
        searchable: false,//No será buscable en el cuadro de búsqueda.
        orderable: false,// No se podrá ordenar esta columna al hacer clic en el encabezado.
        responsivePriority: 1, //Los valores mas altos se ocultan primero.
        render: function (data, type, full, meta) {
          return '';
        }
      },
      {//archivo
        targets: 7,
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
            var $id = full['id'];
            return '<i data-id="' + $id + '" class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer pdfMezcalGranel" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>';
        }
      },
      {
        // Actions
        targets: -1,
        title: 'Acciones',
        orderable: false, 
        searchable: false,
        render: function (data, type, full, meta) {
          // Construir y retornar el dropdown
          return `
            <div class="d-flex align-items-center gap-50">
              <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ri-settings-5-fill"></i>&nbsp;Opciones<i class="ri-arrow-down-s-fill ri-20px"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end m-0">
                  <a data-id="${full['id']}" class="dropdown-item waves-effect text-dark editar"
                  data-bs-toggle="modal" data-bs-target="#ModalEditMezcalGranel">
                      <i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>
                  <a data-id="${full['id']}" class="dropdown-item waves-effect text-black eliminar">
                      <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>
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
        text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nueva etiqueta</span>',
        className: 'add-new btn btn-primary waves-effect waves-light',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#ModalAddMezcalGranel'
        }
      }
    ],

    ///PAGINA RESPONSIVA
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: row => 'Detalles de ' + row.data()['num_servicio']
        }),
        type: 'column',
        renderer: (api, rowIdx, columns) => {
            var data = $.map(columns, col => col.title !== '' ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}"><td>${col.title}:</td><td>${col.data}</td></tr>` : '').join('');
            return data ? $('<table class="table"/><tbody />').append(data) : false;
        }
      }
    }

  });
}

///REGISTRAR MEZCAL A GRANEL
const FormAgregar = document.getElementById('FormAddMezcalGranel');
FormValidation.formValidation(FormAgregar, {
  /*fields: { //PARA VALIDACION DE CAMPOS
    'fecha_servicio': {
      validators: {
        notEmpty: {
          message: 'La fecha es obligatorio.'
        }
      }
    }
  },*/
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
  var formData = new FormData(FormAgregar);
  const $submitBtn = $(FormAgregar).find('button[type="submit"]');
  $submitBtn.prop('disabled', true).html('<i class="ri-loader-2-line ri-spin"></i> Guardando...');

  $.ajax({
      url: '/etiqueta-mezcal-granel/add',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar y resetear el formulario
        $('#ModalAddMezcalGranel').modal('hide');
        $('#FormAddMezcalGranel')[0].reset();
        dataTable.ajax.reload(false);// Recargar DataTable
        
        // Alerta de éxito
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
        if (isDev) console.log('Error Completo:', xhr);
        const errorJSON = xhr.responseJSON?.message || "Error al registrar.";
        
          // Alerta de error
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: errorJSON,
              customClass: {
                  confirmButton: 'btn btn-danger'
              }
          });
      },
      complete: function () {
          $submitBtn.prop('disabled', false).html('<i class="ri-add-line"></i> Registrar');
      }
  });
});
// Limpiar formulario al cerrar modal
$('#ModalAddMezcalGranel').on('hidden.bs.modal', function () {
    FormAgregar.reset();
    $('.select2').val(null).trigger('change');
});

///ELIMINAR MEZCAL A GRANEL
$(document).on('click', '.eliminar', function() {
  var id = $(this).data('id');

  Swal.fire({
    title: '¿Estás seguro?',
    text: "No podrás revertir esta acción.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: '<i class="ri-check-line"></i> Sí, eliminar',
    cancelButtonText: '<i class="ri-close-line"></i> Cancelar',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-danger'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'DELETE',
        url: `/etiqueta-mezcal-granel/delete/${id}`,
        success: function(res) {
          dataTable.ajax.reload(false);
          Swal.fire({
              icon: 'success',
              title: '¡Exito!',
              text: res.message,
              customClass: { confirmButton: 'btn btn-primary' }
          });
        },
        error: function(xhr) {
          const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
          if (isDev) console.log('Error Completo:', xhr);
          const errorJSON = xhr.responseJSON?.message || "Error al eliminar.";
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: errorJSON,
              customClass: { confirmButton: 'btn btn-danger' }
          });
        }
      });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire({
        icon: 'info',
        title: '¡Cancelado!',
        text: 'Operación cancelada.',
        customClass: {
          confirmButton: 'btn btn-primary'
        }
      });
    }
  });
});

///OBTENER MEZCAL A GRANEL
$(document).on('click', '.editar', function(){
  var id = $(this).data('id');

  $.ajax({
    url: `/etiqueta-mezcal-granel/edit/${id}`,
    method: 'GET',
    success: function (res) {
      // Llenar modal con datos
      for (const key in res) {
          $(`#ModalEditMezcalGranel [name="${key}"]`).val(res[key]);
      }
      $('#FormEditMezcalGranel').data('id', id);
      $('#ModalEditMezcalGranel').modal('show');
    }, 
    error: function(xhr) {
      const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
      if (isDev) console.log('Error Completo:', xhr);
      const errorJSON = xhr.responseJSON?.message || "Error al obtener datos.";
      Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: errorJSON,
          customClass: { confirmButton: 'btn btn-danger' }
      });
    }
  });
});
///ACTUALIZAR MEZCAL A GRANEL
const FormEditar = document.getElementById('FormEditMezcalGranel');
FormValidation.formValidation(FormEditar, {
  /*fields: {
    'num_servicio': {
        validators: {
            notEmpty: { message: 'El número de servicio es obligatorio.' },
            digits: { message: 'Solo se permiten números.' },
            stringLength: { max: 10, message: 'Máximo 10 dígitos.' }
        }
    },
  },*/
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
  var id = $(FormEditar).data('id');
  const $submitBtn = $(FormEditar).find('button[type="submit"]');
  $submitBtn.prop('disabled', true).html('<i class="ri-loader-2-line ri-spin"></i>Guardando...');

    $.ajax({
      url: `/etiqueta-mezcal-granel/update/${id}`,
      type: 'POST',
      data: new FormData(FormEditar),
      processData: false,
      contentType: false,
      success: function(res){
          $('#ModalEditMezcalGranel').modal('hide');
          dataTable.ajax.reload(false);

        // Alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: res.message,
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      },
      error: function(xhr){
        const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
        if (isDev) console.log('Error Completo:', xhr);
        const errorJSON = xhr.responseJSON?.message || "Error al actualizar.";
        // Alerta de error
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: errorJSON,
            customClass: {
                confirmButton: 'btn btn-danger'
            }
        });
      },
      complete: function(){
          $submitBtn.prop('disabled', false).html('<i class="ri-edit-line"></i> Editar');
      }
    });
});

///FORMATO PDF MEZCAL A GRANEL
$(document).on('click', '.pdfMezcalGranel', function ()  {
  var id = $(this).data('id');
  //var folio = $(this).data('folio');
  var pdfUrl = '/etiqueta_mezcal_granel/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();

    $("#titulo_modal").text("Etiqueta para lotes de mezcal a granel");
    //$("#subtitulo_modal").html('<p class="solicitud badge bg-primary">' + folio + '</p>');
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
});


});//end-function(jquery)





//------------------- AGAVE ART -------------------
$(function () {

//FUNCIONALIDAD DE LA VISTA datatable
if ($('.datatables-users2').length) {
  var dataTable2 = $('.datatables-users2').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '/etiquetas-list-art'
    },
    columns: [
      // columns according to JSON
      { data: '' },//0
      { data: 'fake_id' },
      { data: 'fecha' },
      { data: 'num_servicio'},
      { data: 'lote'},
      { data: 'cliente'},
      { data: 'tipo_agave'},
      { data: ''},//7
      { data: 'action'}
    ],
    columnDefs: [
      { // For Responsive
        targets: 0,
        className: 'control',
        searchable: false,//No será buscable en el cuadro de búsqueda.
        orderable: false,// No se podrá ordenar esta columna al hacer clic en el encabezado.
        responsivePriority: 1, //Los valores mas altos se ocultan primero.
        render: function (data, type, full, meta) {
          return '';
        }
      },
      {//archivo
        targets: 7,
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
            var $id = full['id'];
            return '<i data-id="' + $id + '" class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer pdfCertificado" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>';
        }
      },
      {
        // Actions
        targets: -1,
        title: 'Acciones',
        orderable: false, 
        searchable: false,
        render: function (data, type, full, meta) {
          // Construir y retornar el dropdown
          return `
            <div class="d-flex align-items-center gap-50">
              <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ri-settings-5-fill"></i>&nbsp;Opciones<i class="ri-arrow-down-s-fill ri-20px"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end m-0">
                  <a data-id="${full['id']}" class="dropdown-item waves-effect text-dark editar2"
                  data-bs-toggle="modal" data-bs-target="#ModalEditAgaveArt">
                      <i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>
                  <a data-id="${full['id']}" class="dropdown-item waves-effect text-black eliminar2">
                      <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>
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
        text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nueva etiqueta</span>',
        className: 'add-new btn btn-primary waves-effect waves-light',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#ModalAddAgaveArt'
        }
      }
    ],

    ///PAGINA RESPONSIVA
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: row => 'Detalles de ' + row.data()['num_servicio']
        }),
        type: 'column',
        renderer: (api, rowIdx, columns) => {
            var data = $.map(columns, col => col.title !== '' ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}"><td>${col.title}:</td><td>${col.data}</td></tr>` : '').join('');
            return data ? $('<table class="table"/><tbody />').append(data) : false;
        }
      }
    }

  });
}

///REGISTRAR AGAVE ART
const FormAgregar = document.getElementById('FormAddAgaveArt');
FormValidation.formValidation(FormAgregar, {

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
  var formData = new FormData(FormAgregar);
  const $submitBtn = $(FormAgregar).find('button[type="submit"]');
  $submitBtn.prop('disabled', true).html('<i class="ri-loader-2-line ri-spin"></i> Guardando...');

  $.ajax({
      url: '/etiqueta-agave-art/add',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar y resetear el formulario
        $('#ModalAddAgaveArt').modal('hide');
        $('#FormAddAgaveArt')[0].reset();
        dataTable2.ajax.reload(false);// Recargar DataTable
        
        // Alerta de éxito
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
        if (isDev) console.log('Error Completo:', xhr);
        const errorJSON = xhr.responseJSON?.message || "Error al registrar.";
        
          // Alerta de error
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: errorJSON,
              customClass: {
                  confirmButton: 'btn btn-danger'
              }
          });
      },
      complete: function () {
          $submitBtn.prop('disabled', false).html('<i class="ri-add-line"></i> Registrar');
      }
  });
});
// Limpiar formulario al cerrar modal
$('#ModalAddAgaveArt').on('hidden.bs.modal', function () {
    FormAgregar.reset();
    $('.select2').val(null).trigger('change');
});

///ELIMINAR AGAVE ART
$(document).on('click', '.eliminar2', function() {
  var id = $(this).data('id');

  Swal.fire({
    title: '¿Estás seguro?',
    text: "No podrás revertir esta acción.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: '<i class="ri-check-line"></i> Sí, eliminar',
    cancelButtonText: '<i class="ri-close-line"></i> Cancelar',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-danger'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'DELETE',
        url: `/etiqueta-agave-art/delete/${id}`,
        success: function(res) {
          dataTable2.ajax.reload(false);
          Swal.fire({
              icon: 'success',
              title: '¡Exito!',
              text: res.message,
              customClass: { confirmButton: 'btn btn-primary' }
          });
        },
        error: function(xhr) {
          const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
          if (isDev) console.log('Error Completo:', xhr);
          const errorJSON = xhr.responseJSON?.message || "Error al eliminar.";
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: errorJSON,
              customClass: { confirmButton: 'btn btn-danger' }
          });
        }
      });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire({
        icon: 'info',
        title: '¡Cancelado!',
        text: 'Operación cancelada.',
        customClass: {
          confirmButton: 'btn btn-primary'
        }
      });
    }
  });
});

///OBTENER AGAVE ART
$(document).on('click', '.editar2', function(){
  var id = $(this).data('id');

  $.ajax({
    url: `/etiqueta-agave-art/edit/${id}`,
    method: 'GET',
    success: function (res) {
      // Llenar modal con datos
      for (const key in res) {
          $(`#ModalEditAgaveArt [name="${key}"]`).val(res[key]);
      }
      $('#FormEditAgaveArt').data('id', id);
      $('#ModalEditAgaveArt').modal('show');
    }, 
    error: function(xhr) {
      const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
      if (isDev) console.log('Error Completo:', xhr);
      const errorJSON = xhr.responseJSON?.message || "Error al obtener datos.";
      Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: errorJSON,
          customClass: { confirmButton: 'btn btn-danger' }
      });
    }
  });
});
///ACTUALIZAR AGAVE ART
const FormEditar = document.getElementById('FormEditAgaveArt');
FormValidation.formValidation(FormEditar, {
  
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
  var id = $(FormEditar).data('id');
  const $submitBtn = $(FormEditar).find('button[type="submit"]');
  $submitBtn.prop('disabled', true).html('<i class="ri-loader-2-line ri-spin"></i>Guardando...');

    $.ajax({
      url: `/etiqueta-agave-art/update/${id}`,
      type: 'POST',
      data: new FormData(FormEditar),
      processData: false,
      contentType: false,
      success: function(res){
          $('#ModalEditAgaveArt').modal('hide');
          dataTable2.ajax.reload(false);

        // Alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: res.message,
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      },
      error: function(xhr){
        const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
        if (isDev) console.log('Error Completo:', xhr);
        const errorJSON = xhr.responseJSON?.message || "Error al actualizar.";
        // Alerta de error
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: errorJSON,
            customClass: {
                confirmButton: 'btn btn-danger'
            }
        });
      },
      complete: function(){
          $submitBtn.prop('disabled', false).html('<i class="ri-edit-line"></i> Editar');
      }
    });
});


});//end-function(jquery)





//------------------- INGRESO MADURACION -------------------
$(function () {

//FUNCIONALIDAD DE LA VISTA datatable
if ($('.datatables-users3').length) {
  var dataTable3 = $('.datatables-users3').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '/etiquetas-list-maduracion'
    },
    columns: [
      // columns according to JSON
      { data: '' },//0
      { data: 'fake_id' },
      { data: 'fecha' },
      { data: 'num_servicio'},
      { data: 'lote'},
      { data: 'cliente'},
      { data: 'num_certificado'},
      { data: ''},//7
      { data: 'action'}
    ],
    columnDefs: [
      { // For Responsive
        targets: 0,
        className: 'control',
        searchable: false,//No será buscable en el cuadro de búsqueda.
        orderable: false,// No se podrá ordenar esta columna al hacer clic en el encabezado.
        responsivePriority: 1, //Los valores mas altos se ocultan primero.
        render: function (data, type, full, meta) {
          return '';
        }
      },
      {//archivo
        targets: 7,
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
            var $id = full['id'];
            return '<i data-id="' + $id + '" class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer pdfCertificado" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>';
        }
      },
      {
        // Actions
        targets: -1,
        title: 'Acciones',
        orderable: false, 
        searchable: false,
        render: function (data, type, full, meta) {
          // Construir y retornar el dropdown
          return `
            <div class="d-flex align-items-center gap-50">
              <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ri-settings-5-fill"></i>&nbsp;Opciones<i class="ri-arrow-down-s-fill ri-20px"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end m-0">
                  <a data-id="${full['id']}" class="dropdown-item waves-effect text-dark editar3"
                  data-bs-toggle="modal" data-bs-target="#ModalEditMaduracion">
                      <i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>
                  <a data-id="${full['id']}" class="dropdown-item waves-effect text-black eliminar3">
                      <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>
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
        text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nueva etiqueta</span>',
        className: 'add-new btn btn-primary waves-effect waves-light',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#ModalAddMaduracion'
        }
      }
    ],

    ///PAGINA RESPONSIVA
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: row => 'Detalles de ' + row.data()['num_servicio']
        }),
        type: 'column',
        renderer: (api, rowIdx, columns) => {
            var data = $.map(columns, col => col.title !== '' ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}"><td>${col.title}:</td><td>${col.data}</td></tr>` : '').join('');
            return data ? $('<table class="table"/><tbody />').append(data) : false;
        }
      }
    }

  });
}

///REGISTRAR INGRESO MADURACION
const FormAgregar = document.getElementById('FormAddMaduracion');
FormValidation.formValidation(FormAgregar, {

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
  var formData = new FormData(FormAgregar);
  const $submitBtn = $(FormAgregar).find('button[type="submit"]');
  $submitBtn.prop('disabled', true).html('<i class="ri-loader-2-line ri-spin"></i> Guardando...');

  $.ajax({
      url: '/etiqueta-maduracion/add',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar y resetear el formulario
        $('#ModalAddMaduracion').modal('hide');
        $('#FormAddMaduracion')[0].reset();
        dataTable3.ajax.reload(false);// Recargar DataTable
        
        // Alerta de éxito
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
        if (isDev) console.log('Error Completo:', xhr);
        const errorJSON = xhr.responseJSON?.message || "Error al registrar.";
        
          // Alerta de error
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: errorJSON,
              customClass: {
                  confirmButton: 'btn btn-danger'
              }
          });
      },
      complete: function () {
          $submitBtn.prop('disabled', false).html('<i class="ri-add-line"></i> Registrar');
      }
  });
});
// Limpiar formulario al cerrar modal
$('#ModalAddMaduracion').on('hidden.bs.modal', function () {
    FormAgregar.reset();
    $('.select2').val(null).trigger('change');
});

///ELIMINAR INGRESO MADURACION
$(document).on('click', '.eliminar3', function() {
  var id = $(this).data('id');

  Swal.fire({
    title: '¿Estás seguro?',
    text: "No podrás revertir esta acción.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: '<i class="ri-check-line"></i> Sí, eliminar',
    cancelButtonText: '<i class="ri-close-line"></i> Cancelar',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-danger'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'DELETE',
        url: `/etiqueta-maduracion/delete/${id}`,
        success: function(res) {
          dataTable3.ajax.reload(false);
          Swal.fire({
              icon: 'success',
              title: '¡Exito!',
              text: res.message,
              customClass: { confirmButton: 'btn btn-primary' }
          });
        },
        error: function(xhr) {
          const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
          if (isDev) console.log('Error Completo:', xhr);
          const errorJSON = xhr.responseJSON?.message || "Error al eliminar.";
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: errorJSON,
              customClass: { confirmButton: 'btn btn-danger' }
          });
        }
      });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire({
        icon: 'info',
        title: '¡Cancelado!',
        text: 'Operación cancelada.',
        customClass: {
          confirmButton: 'btn btn-primary'
        }
      });
    }
  });
});

///OBTENER INGRESO MADURACION
$(document).on('click', '.editar3', function(){
  var id = $(this).data('id');

  $.ajax({
    url: `/etiqueta-maduracion/edit/${id}`,
    method: 'GET',
    success: function (res) {
      // Llenar modal con datos
      for (const key in res) {
          $(`#ModalEditMaduracion [name="${key}"]`).val(res[key]);
      }
      $('#FormEditMaduracion').data('id', id);
      $('#ModalEditMaduracion').modal('show');
    }, 
    error: function(xhr) {
      const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
      if (isDev) console.log('Error Completo:', xhr);
      const errorJSON = xhr.responseJSON?.message || "Error al obtener datos.";
      Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: errorJSON,
          customClass: { confirmButton: 'btn btn-danger' }
      });
    }
  });
});
///ACTUALIZAR INGRESO MADURACION
const FormEditar = document.getElementById('FormEditMaduracion');
FormValidation.formValidation(FormEditar, {
  
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
  var id = $(FormEditar).data('id');
  const $submitBtn = $(FormEditar).find('button[type="submit"]');
  $submitBtn.prop('disabled', true).html('<i class="ri-loader-2-line ri-spin"></i>Guardando...');

    $.ajax({
      url: `/etiqueta-maduracion/update/${id}`,
      type: 'POST',
      data: new FormData(FormEditar),
      processData: false,
      contentType: false,
      success: function(res){
          $('#ModalEditMaduracion').modal('hide');
          dataTable3.ajax.reload(false);

        // Alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: res.message,
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      },
      error: function(xhr){
        const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
        if (isDev) console.log('Error Completo:', xhr);
        const errorJSON = xhr.responseJSON?.message || "Error al actualizar.";
        // Alerta de error
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: errorJSON,
            customClass: {
                confirmButton: 'btn btn-danger'
            }
        });
      },
      complete: function(){
          $submitBtn.prop('disabled', false).html('<i class="ri-edit-line"></i> Editar');
      }
    });
});


});//end-function(jquery)





//------------------- TAPA MUESTRA -------------------
$(function () {

//FUNCIONALIDAD DE LA VISTA datatable
if ($('.datatables-users4').length) {
  var dataTable4 = $('.datatables-users4').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '/etiquetas-list-tapa'
    },
    columns: [
      // columns according to JSON
      { data: '' },//0
      { data: 'fake_id' },
      { data: 'fecha' },
      { data: 'num_servicio'},
      { data: 'lote'},
      { data: 'cliente'},
      { data: 'num_certificado'},
      { data: ''},//7
      { data: 'action'}
    ],
    columnDefs: [
      { // For Responsive
        targets: 0,
        className: 'control',
        searchable: false,//No será buscable en el cuadro de búsqueda.
        orderable: false,// No se podrá ordenar esta columna al hacer clic en el encabezado.
        responsivePriority: 1, //Los valores mas altos se ocultan primero.
        render: function (data, type, full, meta) {
          return '';
        }
      },
      {//archivo
        targets: 7,
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
            var $id = full['id'];
            return '<i data-id="' + $id + '" class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer pdfCertificado" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>';
        }
      },
      {
        // Actions
        targets: -1,
        title: 'Acciones',
        orderable: false, 
        searchable: false,
        render: function (data, type, full, meta) {
          // Construir y retornar el dropdown
          return `
            <div class="d-flex align-items-center gap-50">
              <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ri-settings-5-fill"></i>&nbsp;Opciones<i class="ri-arrow-down-s-fill ri-20px"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end m-0">
                  <a data-id="${full['id']}" class="dropdown-item waves-effect text-dark editar4"
                  data-bs-toggle="modal" data-bs-target="#ModalEditTapaMuestra">
                      <i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>
                  <a data-id="${full['id']}" class="dropdown-item waves-effect text-black eliminar4">
                      <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>
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
        text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nueva etiqueta</span>',
        className: 'add-new btn btn-primary waves-effect waves-light',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#ModalAddTapaMuestra'
        }
      }
    ],

    ///PAGINA RESPONSIVA
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: row => 'Detalles de ' + row.data()['num_servicio']
        }),
        type: 'column',
        renderer: (api, rowIdx, columns) => {
            var data = $.map(columns, col => col.title !== '' ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}"><td>${col.title}:</td><td>${col.data}</td></tr>` : '').join('');
            return data ? $('<table class="table"/><tbody />').append(data) : false;
        }
      }
    }

  });
}

///REGISTRAR TAPA MUESTRA
const FormAgregar = document.getElementById('FormAddTapaMuestra');
FormValidation.formValidation(FormAgregar, {

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
  var formData = new FormData(FormAgregar);
  const $submitBtn = $(FormAgregar).find('button[type="submit"]');
  $submitBtn.prop('disabled', true).html('<i class="ri-loader-2-line ri-spin"></i> Guardando...');

  $.ajax({
      url: '/etiqueta-tapa-muestra/add',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar y resetear el formulario
        $('#ModalAddTapaMuestra').modal('hide');
        $('#FormAddTapaMuestra')[0].reset();
        dataTable4.ajax.reload(false);// Recargar DataTable
        
        // Alerta de éxito
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
        if (isDev) console.log('Error Completo:', xhr);
        const errorJSON = xhr.responseJSON?.message || "Error al registrar.";
        
          // Alerta de error
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: errorJSON,
              customClass: {
                  confirmButton: 'btn btn-danger'
              }
          });
      },
      complete: function () {
          $submitBtn.prop('disabled', false).html('<i class="ri-add-line"></i> Registrar');
      }
  });
});
// Limpiar formulario al cerrar modal
$('#ModalAddTapaMuestra').on('hidden.bs.modal', function () {
    FormAgregar.reset();
    $('.select2').val(null).trigger('change');
});

///ELIMINAR TAPA MUESTRA
$(document).on('click', '.eliminar4', function() {
  var id = $(this).data('id');

  Swal.fire({
    title: '¿Estás seguro?',
    text: "No podrás revertir esta acción.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: '<i class="ri-check-line"></i> Sí, eliminar',
    cancelButtonText: '<i class="ri-close-line"></i> Cancelar',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-danger'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'DELETE',
        url: `/etiqueta-tapa-muestra/delete/${id}`,
        success: function(res) {
          dataTable4.ajax.reload(false);
          Swal.fire({
              icon: 'success',
              title: '¡Exito!',
              text: res.message,
              customClass: { confirmButton: 'btn btn-primary' }
          });
        },
        error: function(xhr) {
          const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
          if (isDev) console.log('Error Completo:', xhr);
          const errorJSON = xhr.responseJSON?.message || "Error al eliminar.";
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: errorJSON,
              customClass: { confirmButton: 'btn btn-danger' }
          });
        }
      });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire({
        icon: 'info',
        title: '¡Cancelado!',
        text: 'Operación cancelada.',
        customClass: {
          confirmButton: 'btn btn-primary'
        }
      });
    }
  });
});

///OBTENER TAPA MUESTRA
$(document).on('click', '.editar4', function(){
  var id = $(this).data('id');

  $.ajax({
    url: `/etiqueta-tapa-muestra/edit/${id}`,
    method: 'GET',
    success: function (res) {
      // Llenar modal con datos
      for (const key in res) {
          $(`#ModaEditTapaMuestra [name="${key}"]`).val(res[key]);
      }
      $('#FormEditTapaMuestra').data('id', id);
      $('#ModaEditTapaMuestra').modal('show');
    }, 
    error: function(xhr) {
      const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
      if (isDev) console.log('Error Completo:', xhr);
      const errorJSON = xhr.responseJSON?.message || "Error al obtener datos.";
      Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: errorJSON,
          customClass: { confirmButton: 'btn btn-danger' }
      });
    }
  });
});
///ACTUALIZAR TAPA MUESTRA
const FormEditar = document.getElementById('FormEditTapaMuestra');
FormValidation.formValidation(FormEditar, {
  
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
  var id = $(FormEditar).data('id');
  const $submitBtn = $(FormEditar).find('button[type="submit"]');
  $submitBtn.prop('disabled', true).html('<i class="ri-loader-2-line ri-spin"></i>Guardando...');

    $.ajax({
      url: `/etiqueta-tapa-muestra/update/${id}`,
      type: 'POST',
      data: new FormData(FormEditar),
      processData: false,
      contentType: false,
      success: function(res){
          $('#ModaEditTapaMuestra').modal('hide');
          dataTable4.ajax.reload(false);

        // Alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: res.message,
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      },
      error: function(xhr){
        const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
        if (isDev) console.log('Error Completo:', xhr);
        const errorJSON = xhr.responseJSON?.message || "Error al actualizar.";
        // Alerta de error
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: errorJSON,
            customClass: {
                confirmButton: 'btn btn-danger'
            }
        });
      },
      complete: function(){
          $submitBtn.prop('disabled', false).html('<i class="ri-edit-line"></i> Editar');
      }
    });
});


});//end-function(jquery)


