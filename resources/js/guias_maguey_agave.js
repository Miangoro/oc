'use strict';

$(function () {

  // Declaras el arreglo de botones
  let buttons = [];
  // Si tiene permiso, agregas el botón
  if (puedeAgregarElUsuario) {
    buttons.push({
      text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nueva guía de traslado</span>',
      className: 'add-new btn btn-primary waves-effect waves-light',
      attr: {
        'data-bs-toggle': 'modal',
        'data-bs-dismiss': 'modal',
        'data-bs-target': '#addGuias'
      }
    });
  }

  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#addGuias');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });



//DATATABLE
if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'guias-list'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id_predio'},
        { data: null, // Se usará null porque combinaremos varios valores
          render: function (data, type, row) {
            return `
              <strong>${data.numero_cliente}</strong><br>
                  <span style="font-size:12px">${data.razon_social}<span>
              `;
          }
        },
        { data: 'folio' },
        { data: 'run_folio' },
        { data: 'id_guia' },//5
        /* { data: 'numero_plantas' },
        { data: 'num_anterior' },
        { data: 'num_comercializadas' },
        { data: 'mermas_plantas' }, */

        { data: null,
          render: function (data, type, row) {
            return `<small>${data.caracteristicas}</small>`;
          }
        },
        { data: '' },//archivos adjuntos
        { data: 'action' }
      ],
      columnDefs: [
        { orderable: false, targets: [0,1,2,3,5,6,7,8] },//solo ordenamos RUN-FOLIO
        {
          // For Responsive
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
          targets: 5,
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return `
            <i data-id="${full['id_guia']}" class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer pdfGuia"  data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>
            `;
          }
        },

        /* {
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        }, */
        {
          targets: 7,
          render: function (data, type, full, meta) {
            let documentos = '';

            if (full['documento_guia']) {
              documentos += `
                <small>Guía escaneada:</small> <a href="${full['documento_guia']}" target="_blank" title="Ver Guía">
                  <i class="ri-file-pdf-2-fill text-success ri-28px cursor-pointer"></i>
                </a> <br>`;
            } else {
              documentos += `<span class="text-muted small">Sin guía escaneada</span>`;
            }

            if (full['documento_art']) {
              documentos += `
                <small>Resultados ART:</small> <a href="${full['documento_art']}" target="_blank" title="Ver Resultados Art">
                  <i class="ri-file-pdf-2-fill text-success ri-28px"></i>
                </a>`;
            } else {
              documentos += `<br><span class="text-muted small">Sin resultados art</span>`;
            }

            return documentos;
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            let acciones = '';
            /*GUIAS ANTERIOR
              acciones += `<a data-id="${full['run_folio']}" data-bs-toggle="modal" data-bs-target="#verGuiasRegistardas" href="javascript:;" class="dropdown-item ver-registros"><i class="ri-id-card-line ri-20px text-primary"></i> Ver guías</a>`;
            */
            if (window.puedeEditarElUsuario) {
      /*acciones += `<a data-id="${full['run_folio']}" data-bs-toggle="modal" data-bs-target="#ModalEditSolGuias" href="javascript:;" class="dropdown-item editSolGuias"><i class="ri-edit-box-line ri-20px text-info"></i> Editar solicitud de guía</a>`;*/
              acciones += `<a data-id="${full['id_guia']}" data-bs-toggle="modal" data-bs-target="#editGuias" href="javascript:;" class="dropdown-item edit-guia"> <i class="ri-edit-box-line ri-20px text-info"> </i> Llenar guía de traslado</a>`;
            }

            if ( window.puedeSubirPdf ) {
              acciones += `<a data-id="${full['id_guia']}" data-bs-toggle="modal" data-bs-target="#ModalSubirPDF" href="javascript:;" class="dropdown-item subirPDF"><i class="ri-book-marked-line ri-20px text-primary"></i> Adjuntar PDF</a>`;
            }
      
            if (window.puedeEliminarElUsuario) {
              acciones += `<a data-id="${full['id_guia']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar guía de traslado</a>`;
            }
            // Si no hay acciones, no retornar el dropdown
            if (!acciones.trim()) {
              return `
                <button class="btn btn-sm btn-secondary" disabled>
                  <i class="ri-lock-line ri-20px me-1"></i> Opciones
                </button>
              `;
            }
            // Si hay acciones, construir el dropdown
            const dropdown = `<div class="d-flex align-items-center gap-50">
              <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
              <div class="dropdown-menu dropdown-menu-end m-0">
                  ${acciones}
                </div>
              </div>
            `;
            return dropdown;
              /* `<button class="btn btn-sm btn-icon edit-guia btn-text-secondary rounded-pill waves-effect" data-id="${full['id_guia']}" data-bs-toggle="modal" data-bs-target="#editGuias"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
                            `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_guia']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` + */
          }
        }
      ],
      order: [[5, 'desc']],
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
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior'
        }
      },
      // Buttons with Dropdown
      buttons: buttons,
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['folio'];
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

  //Inicializar DatePicker
  $(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es' // Configura el idioma a español
    });
  });

  /*
  // Agregar nuevo registro y validacion
  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    //Obtener nombre predio
    function obtenerNombrePredio() {
      var empresa = $("#id_empresa").val();
      $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function (response) {
          console.log(response);
          var contenido = "";
          for (let index = 0; index < response.predios.length; index++) {
            contenido = '<option value="' + response.predios[index].id_predio + '">' + response
              .predios[index].nombre_predio + '</option>' + contenido;
          }
          if (response.predios.length == 0) {
            contenido = '<option value="">Sin predios registradas</option>';
          }
          $('#nombre_predio').html(contenido);
          formValidator.revalidateField('predios');
        },
        error: function () {
        }
      });
    }

    //Obtener plantacion
    function obtenerPlantacionPredio() {
      var empresa = $("#id_empresa").val();
      $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function (response) {
          console.log(response);
          var contenido = "";
          for (let index = 0; index < response.predio_plantacion.length; index++) {
            contenido = '<option value="' + response.predio_plantacion[index].id_plantacion +
              '" " data-num-plantas="' + response.predio_plantacion[index].num_plantas + '">Número de plantas: ' + response
                .predio_plantacion[index].num_plantas + ' | Tipo de agave: ' + response
                  .predio_plantacion[index].nombre + ' ' + response
                    .predio_plantacion[index].cientifico + ' | Año de platanción: ' + response
                      .predio_plantacion[index].anio_plantacion + '</option>' + contenido;
          }
          if (response.predio_plantacion.length == 0) {
            contenido = '<option value="">Sin predios registradas</option>';
          }
          $('#id_plantacion').html(contenido);
          $('#id_plantacion').on('change', function () {
            var selectedOption = $(this).find('option:selected');
            var numPlantas = selectedOption.data('num-plantas');
            $('#num_anterior').val(numPlantas);
          });
          $('#id_plantacion').trigger('change');
          formValidator.revalidateField('plantacion');
        },
        error: function () {
        }
      });
    }

    $('#id_empresa').on('change', function () {
      obtenerNombrePredio();  // Cargar las marcas
      obtenerPlantacionPredio();  // Cargar las direcciones
      formValidator.revalidateField('empresa');  // Revalidar el campo de empresa
    });
*/
// Agregar nuevo registro y validacion
$(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    let datosEmpresa = null;

    // Obtener los Predios del Cliente Seleccionado
    function obtenerNombrePredio() {
      var empresa = $('#id_empresa').val();
      $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function (response) {
          console.log('ver que manda:', response);
          datosEmpresa = response;

          let contenido = '';
          if (response.predios.length > 0) {
            contenido += '<option value="" disabled>Selecciona un predio</option>';
            response.predios.forEach(predio => {
              //contenido += `<option value="${predio.id_predio}">Nombre: ${predio.nombre_predio} | No.: ${predio.num_predio}</option>`;
            if (predio.num_predio !== 'Sin asignar') {//sin folio asignado
                contenido += `<option value="${predio.id_predio}">Nombre: ${predio.nombre_predio} | No.: ${predio.num_predio}</option>`;
              }
            });

            // Si no hay predios válidos después del filtro
            if (contenido === '<option value="" disabled>Selecciona un predio</option>') {
              contenido = '<option value="" disabled>Sin predios asignados</option>';
            }
          } else {
            contenido = '<option value="" disabled>Sin predios registrados</option>';
          }

          $('#nombre_predio').html(contenido).val('').trigger('change.select2');
          $('#id_plantacion')
            .html('<option value="" disabled>Selecciona un predio primero</option>')
            .val('')
            .trigger('change.select2');
          $('#num_anterior').val('');
          formValidator.revalidateField('predios');
        },
        error: function () {
          console.error('Error al cargar predios.');
        }
      });
    }

    //Obtener las Plantaciones del Predio seleccionado
    $('#nombre_predio').on('change', function () {
      const id_predio = $(this).val();
      if (!datosEmpresa || !id_predio) return;

      //muestra las plantas en 0 pero no permite seleccionar
      const plantaciones = datosEmpresa.predio_plantacion.filter(p => p.id_predio == id_predio);
      let contenido = '<option value="" disabled>Selecciona una plantación</option>';
      plantaciones.forEach(item => {
        const disabled = item.num_plantas == 0 ? 'disabled' : '';
        contenido += `<option value="${item.id_plantacion}" data-num-plantas="${item.num_plantas}" ${disabled}>
          Número de plantas: ${item.num_plantas} | Tipo de agave: ${item.nombre} ${item.cientifico} | Año de plantación: ${item.anio_plantacion}
        </option>`;
      });
      //PARA NO MOSTRAR CUANDO SEAN = 0 
      /*const plantaciones = datosEmpresa.predio_plantacion.filter(p => p.id_predio == id_predio && p.num_plantas > 0);
      let contenido = '<option value="" disabled>Selecciona una plantación</option>';
      plantaciones.forEach(item => {
        contenido += `<option value="${item.id_plantacion}" data-num-plantas="${item.num_plantas}">
        Número de plantas: ${item.num_plantas} | Tipo de agave: ${item.nombre} ${item.cientifico} | Año de plantación: ${item.anio_plantacion}
      </option>`;
      });*/
      
      if (plantaciones.length === 0) {
        contenido = '<option value="" disabled>Sin características registradas</option>';
      }

      $('#id_plantacion').html(contenido).val('').trigger('change.select2');
      formValidator.revalidateField('plantacion');
    });

    // Mostrar número de plantas al seleccionar una plantación
    $('#id_plantacion')
      .off('change')
      .on('change', function () {
        const numPlantas = $(this).find('option:selected').data('num-plantas') || '';
        $('#num_anterior').val(numPlantas);
        formValidator.revalidateField('plantacion');
      });

    // Validar select de predio al cambiar
    $('#nombre_predio').on('change', function () {
      formValidator.revalidateField('predios');
    });

    // Evento al cambiar cliente
    $('#id_empresa').on('change', function () {
      obtenerNombrePredio();
      formValidator.revalidateField('empresa');
    });

    

    // Validaciónes Formulario
    const addGuiaForm = document.getElementById('addGuiaForm');
    const formValidator = FormValidation.formValidation(addGuiaForm, {
      fields: {
        empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente'
            }
          }
        },
        numero_guias: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca un número de guías a solicitar'
            },
            between: {
              min: 1,
              max: 100,
              message: 'El número de guías debe estar entre 1 y 100'
            },
            regexp: {
              regexp: /^(?!0)\d+$/,
              message: 'El número no debe comenzar con 0'
            }
          }
        },
        predios: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un predio'
            }
          }
        },
        plantacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una plantación'
            }
          }
        },

       // Campos no obligatorios pero con validación de tipo
        anterior: {
          validators: {
            numeric: {
              message: 'Solo se permiten números'
            },
            greaterThan: {
              min: 0,
              message: 'Debe ser un valor mayor o igual a 0'
            }
          }
        },
        comercializadas: {
          validators: {
            numeric: {
              message: 'Solo se permiten números'
            },
            greaterThan: {
              min: 0,
              message: 'Debe ser un valor mayor o igual a 0'
            }
          }
        },
        mermas: {
          validators: {
            numeric: {
              message: 'Solo se permiten números'
            },
            greaterThan: {
              min: 0,
              message: 'Debe ser un valor mayor o igual a 0'
            }
          }
        },

        //nuevos campos opcionales
        edad: {
          validators: {
            stringLength: {
              max: 255,
              message: 'Máximo 255 caracteres'
            }
          }
        },
        art: {
          validators: {
            numeric: {
              message: 'Debe ser un número'
            },
            greaterThan: {
              min: 0,
              message: 'Debe ser mayor o igual a 0'
            }
          }
        },
        kg_maguey: {
          validators: {
            numeric: {
              message: 'Debe ser un número'
            },
            greaterThan: {
              min: 0,
              message: 'Debe ser mayor o igual a 0'
            }
          }
        },
        no_lote_pedido: {
          validators: {
            stringLength: {
              max: 255,
              message: 'Máximo 255 caracteres'
            }
          }
        },
        fecha_corte: {
          validators: {
            date: {
              format: 'YYYY-MM-DD',
              message: 'Fecha inválida'
            }
          }
        },
        

      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.form-floating'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function (e) {
      var formData = new FormData(addGuiaForm);
      //deshabilita el boton al guardar
      const $submitBtn = $(addGuiaForm).find('button[type="submit"]');
      // Cambiar a modo cargando
      $submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line"></i> Guardando...');

      $.ajax({
        url: '/guias/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addGuias').modal('hide');
          $('.datatables-users').DataTable().ajax.reload();

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.success,
            customClass: {
              confirmButton: 'btn btn-primary'
            }
          });
          $submitBtn.prop('disabled', false).html('<i class="ri-add-line"></i> Registrar');//boton deshabilitado
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar la guía de traslado',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
           $submitBtn.prop('disabled', false).html('<i class="ri-add-line"></i> Registrar');//boton deshabilitado
        }

      });
    });

    // Limpiar campos al cerrar el modal
      $('#addGuias').on('hidden.bs.modal', function () {
      $('#id_empresa').val('').trigger('change.select2');
      $('#nombre_predio').html('').trigger('change.select2');
      $('#id_plantacion').html('').trigger('change.select2');
      $('#numero_guias').val('');
      $('#num_comercializadas').val('');
      $('#mermas_plantas').val('');
      $('#numero_plantas').val('');
      //// Nuevos campos
      $('#edad').val('');
      $('#art').val('');
      $('#kg_magey').val('');
      $('#no_lote_pedido').val('');
      $('#fecha_corte').val('');
      $('#observaciones').val('');
      $('#nombre_cliente').val('');
      $('#no_cliente').val('');
      $('#fecha_ingreso').val('');
      $('#domicilio').val('');
      $('input[type="file"]').val('');
      formValidator.resetForm(true);
    });

    initializeSelect2(select2Elements);
});








///EDITAR SOL DE GUIAS
$(document).on('click', '.edit-guia', function () {
    var id_guia = $(this).data('id');
    console.log('ver id:' ,id_guia);

    $.get('/edit/' + id_guia, function (data) {
      // Rellenar el formulario con los datos obtenidos
      $('#editt_id_guia').val(data.id_guia);
      $('#edit_id_empresa').val(data.id_empresa).trigger('change');
      $('#edit_numero_guias').val(data.numero_guias);
      //$('#edit_nombre_predio').val(data.id_predio).trigger('change'); // Cambiado a 'id_predio'
      editobtenerNombrePredio(function() {
          $('#edit_nombre_predio').val(data.id_predio).trigger('change');
      });

      // Ahora cargas las plantaciones y cuando terminen, seleccionas la correcta
      /*$.ajax({
        url: '/getDatos/' + data.id_empresa,
        method: 'GET',
        success: function(response) {
          let contenido = '';
          response.predio_plantacion.forEach(p => {
            contenido += `<option value="${p.id_plantacion}">Número de plantas: ${p.num_plantas} | Tipo de agave: ${p.nombre} ${p.cientifico} | Año de plantación: ${p.anio_plantacion}</option>`;
          });
          $('#edit_id_plantacion').html(contenido);
          
          // Seleccionar el valor que viene de la base
          $('#edit_id_plantacion').val(data.id_plantacion).trigger('change');
        }
      });*/
      // Uso:
      editobtenerPlantacionPredio(function() {
          $('#edit_id_plantacion').val(data.id_plantacion).trigger('change');
      });
      

      $('#edit_num_anterior').val(data.num_anterior);
      $('#edit_num_comercializadas').val(data.num_comercializadas);
      $('#edit_mermas_plantas').val(data.mermas_plantas);
      $('#edit_numero_plantas').val(data.numero_plantas);
      $('#edit_edad').val(data.edad);
      $('#edit_id_art').val(data.art);
      $('#edit_kg_magey').val(data.kg_maguey);
      $('#edit_no_lote_pedido').val(data.no_lote_pedido);
      $('#edit_fecha_corte').val(data.fecha_corte);
      $('#edit_id_observaciones').val(data.observaciones);
      $('#edit_nombre_cliente').val(data.nombre_cliente);
      $('#edit_no_cliente').val(data.no_cliente);
      $('#edit_fecha_ingreso').val(data.fecha_ingreso);
      $('#edit_domicilio').val(data.domicilio);
      // Mostrar el modal de edición
      $('#editGuias').modal('show');
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de la guía de traslado',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
});


  //ACTUALIZAR Guias y validacion
  const editGuiaForm = document.getElementById('editGuiaForm');
  const fv2 = FormValidation.formValidation(editGuiaForm, {
    fields: {
      id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un cliente'
          }
        }
      },
      numero_guias: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de guías solicitadas'
          }
        }
      },
      predios: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un predio'
          }
        }
      },
      plantacion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una plantación'
          }
        }
      }
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
    var formData = new FormData(editGuiaForm);
    var id = $('#editt_id_guia').val();
      //deshabilita el boton al editar
      const $submitBtn = $(editGuiaForm).find('button[type="submit"]');
      $submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line"></i> Guardando...');// Cambiar a modo cargando
    $.ajax({
      url: '/update/' + id, // Actualiza con la URL correcta
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#editGuias').modal('hide');
        $('.datatables-users').DataTable().ajax.reload();
        // Mostrar alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.success,
          customClass: {
              confirmButton: 'btn btn-primary'
          }
        });
        $submitBtn.prop('disabled', false).html('<i class="ri-pencil-fill"></i> Actualizar');//boton deshabilitado
      },
      error: function (xhr) {
        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar la guía de traslado',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
        $submitBtn.prop('disabled', false).html('<i class="ri-pencil-fill"></i> Actualizar');//boton deshabilitado
      }
    });
});

/*
///EDITAR SOL DE GUIAS
$(function () {
  // Configuración CSRF para Laravel
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });


// Función para obtener los datos
  $(document).on('click', '.editSolGuias', function () {
      var id_run_folio = $(this).data('id');

      //$.get('/edit/' + id_run_folio, function (data) {
      $.ajax({
        url: '/edit/' +id_run_folio,
        method: 'GET',
        success: function (data) {
          // Rellenar el formulario con los datos obtenidos
          $('#id_guia').val(data.id_run_folio);
          

          // Ahora cargas las plantaciones y cuando terminen, seleccionas la correcta
          $.ajax({
            url: '/getDatos/' + data.id_empresa,
            method: 'GET',
            success: function(response) {
              let contenido = '';
              response.predio_plantacion.forEach(p => {
                contenido += `<option value="${p.id_plantacion}">Número de plantas: ${p.num_plantas} | Tipo de agave: ${p.nombre} ${p.cientifico} | Año de plantación: ${p.anio_plantacion}</option>`;
              });
              $('#id_plantacion').html(contenido);
              
              // Seleccionar el valor que viene de la base
              $('#id_plantacion').val(data.id_plantacion).trigger('change');
            }
          });

          $('#num_anterior').val(data.num_anterior);
          $('#num_comercializadas').val(data.num_comercializadas);
          $('#mermas_plantas').val(data.mermas_plantas);
          $('#numero_plantas').val(data.numero_plantas);
          $('#edad').val(data.edad);
          $('#art').val(data.art);
          $('#kg_magey').val(data.kg_maguey);
          $('#no_lote_pedido').val(data.no_lote_pedido);
          $('#fecha_corte').val(data.fecha_corte);
          $('#observaciones').val(data.observaciones);
          $('#nombre_cliente').val(data.nombre_cliente);
          $('#no_cliente').val(data.no_cliente);
          $('#fecha_ingreso').val(data.fecha_ingreso);
          $('#domicilio').val(data.domicilio);
          // Mostrar el modal de edición
          $('#ModalEditSolGuias').modal('show');
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
  });//fin funcion obtener


  // Inicializar validacion para el formulario
  const formEditguias = document.getElementById('FormEditGuias');
  const fv = FormValidation.formValidation(formEditguias, {
    fields: {
        empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente'
            }
          }
        },
        numero_guias: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca un número de guías a solicitar'
            },
            between: {
              min: 1,
              max: 100,
              message: 'El número de guías debe estar entre 1 y 100'
            },
            regexp: {
              regexp: /^(?!0)\d+$/,
              message: 'El número no debe comenzar con 0'
            }
          }
        },
        predios: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un predio'
            }
          }
        },
        plantacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una plantación'
            }
          }
        },

       // Campos no obligatorios pero con validación de tipo
        anterior: {
          validators: {
            numeric: {
              message: 'Solo se permiten números'
            },
            greaterThan: {
              min: 0,
              message: 'Debe ser un valor mayor o igual a 0'
            }
          }
        },
        comercializadas: {
          validators: {
            numeric: {
              message: 'Solo se permiten números'
            },
            greaterThan: {
              min: 0,
              message: 'Debe ser un valor mayor o igual a 0'
            }
          }
        },
        mermas: {
          validators: {
            numeric: {
              message: 'Solo se permiten números'
            },
            greaterThan: {
              min: 0,
              message: 'Debe ser un valor mayor o igual a 0'
            }
          }
        },

        //nuevos campos opcionales
        edad: {
          validators: {
            stringLength: {
              max: 255,
              message: 'Máximo 255 caracteres'
            }
          }
        },
        art: {
          validators: {
            numeric: {
              message: 'Debe ser un número'
            },
            greaterThan: {
              min: 0,
              message: 'Debe ser mayor o igual a 0'
            }
          }
        },
        kg_maguey: {
          validators: {
            numeric: {
              message: 'Debe ser un número'
            },
            greaterThan: {
              min: 0,
              message: 'Debe ser mayor o igual a 0'
            }
          }
        },
        no_lote_pedido: {
          validators: {
            stringLength: {
              max: 255,
              message: 'Máximo 255 caracteres'
            }
          }
        },
        fecha_corte: {
          validators: {
            date: {
              format: 'YYYY-MM-DD',
              message: 'Fecha inválida'
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
    //e.preventDefault();
    var formData = new FormData(formEditguias);
    $.ajax({
      url: '/update/', // Actualiza con la URL correcta
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#ModalEditSolGuias').modal('hide');
        $('.datatables-users').DataTable().ajax.reload();
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
        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al ACTUALIZAR',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });//fin funcion validar formulario


});
*/







  // Eliminar registro
  $(document).on('click', '.delete-record', function () {
    var user_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }
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
      if (result.value) {
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}guias-list/${user_id}`,
          success: function () {
            dt_user.draw();
          },
          error: function (error) {
            console.log(error);
          }
        });
        Swal.fire({
          icon: 'success',
          title: '¡Exito!',
          text: 'Eliminado correctamente.',
          customClass: {
            confirmButton: 'btn btn-primary'
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

  




  //VER Y DESCARGAR GUIAS (por guia)
  $(document).on('click', '.ver-registros', function () {
    var run_folio = $(this).data('id');

    $.get('/editGuias/' + run_folio, function (data) {
      $('#tablita').empty();

      // Array para almacenar URLs y nombres de los PDFs
      var pdfFiles = [];

      data.forEach(function (item) {
        var razon_social = item.empresa ? item.empresa.razon_social : 'Indefinido';
        var pdfUrl = '../guia_de_translado/' + item.id_guia;
        var filename = 'Guia_de_traslado_' + item.folio + '.pdf';

        pdfFiles.push({ url: pdfUrl, filename: filename });

        var fila = `
              <tr>
                  <td>${item.folio}</td>

                  <td>
                      <i class="ri-file-pdf-2-fill text-danger ri-40px pdfGuia cursor-pointer"
                          data-bs-target="#mostrarPdf"
                          data-bs-toggle="modal"
                          data-bs-dismiss="modal"
                          data-id="${item.id_guia}"
                          data-registro="${razon_social}">
                      </i>
                  </td>

                  <td>
                      <button type="button" class="btn btn-info">
                          <a data-id="${item.id_guia}" class="dropdown-item waves-effect subirPDF"
                              style="color:#FFF"
                              data-bs-toggle="modal"
                              data-bs-target="#ModalSubirPDF">
                              <i class="ri-book-marked-line"></i> Adjuntar PDF's
                          </a>
                      </button>
                  </td>

              </tr>
          `;
        $('#tablita').append(fila);
      });

      $('#verGuiasRegistardas').modal('show');

      // Descargar todos los PDFs en un archivo ZIP
      $('#descargarPdfBtn')
        .off('click')
        .on('click', function (e) {
          e.preventDefault();
          downloadPdfsAsZip(pdfFiles, `Guias_de_traslado_${run_folio}.zip`);
        });
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de la guía de traslado',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });

  // Función para descargar múltiples PDFs en un archivo ZIP
  function downloadPdfsAsZip(pdfFiles, zipFileName) {
    Swal.fire({
      title: '🔄 Procesando...',
      text: 'Por favor espera mientras se comprimen los archivos.',
      allowOutsideClick: false,
      customClass: {},
      didOpen: () => {
        Swal.showLoading();
      }
    });
    var zip = new JSZip();
    // Crear una lista de promesas para descargar cada PDF
    var pdfPromises = pdfFiles.map(file =>
      fetch(file.url)
        .then(response => response.blob())
        .then(blob => {
          zip.file(file.filename, blob); // Añadir el archivo al ZIP
        })
        .catch(error => console.error('Error al descargar el PDF:', error))
    );

    // Esperar a que todas las descargas terminen y crear el ZIP
    Promise.all(pdfPromises).then(() => {
      zip
        .generateAsync({ type: 'blob' })
        .then(function (zipBlob) {
          // Descargar el archivo ZIP
          saveAs(zipBlob, zipFileName);
          // Cerrar la alerta de "Procesando..." después de que el ZIP esté listo
          Swal.close();
        })
        .catch(error => {
          console.error('Error al generar el archivo ZIP:', error);
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Hubo un problema al generar el archivo ZIP.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        });
    });
  }





  ///SUBIR DOCUMENTOS GUIA Y ART
  $('#formSubirPDF').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: '/guias/subir_documento',
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
        $('#ModalSubirPDF').modal('hide');
        $('#formSubirPDF')[0].reset();
        $('#docActual').empty();
        dt_user.ajax.reload(null, false); // Si usas datatables
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
/// OBTENER DOCUMENTO GUÍA O ART
$(document).on('click', '.subirPDF', function () {
    let id_guia = $(this).data('id');
    $('#id_guia').val(id_guia);

    // Para cada documento que tienes en el formulario
    [71, 132].forEach(function (docId) {
        let docContainer = $(`#docActual_${docId}`);
        let delContainer = $(`#EliminarDoc_${docId}`);

        docContainer.html('Cargando documento...');
        delContainer.empty();

        $.ajax({
            url: `/guias/mostrar_documento/${id_guia}/${docId}`,
            type: 'GET',
            success: function (response) {
                if (response.documento_url && response.nombre_archivo) {
                    docContainer.html(
                        `<p>Documento actual:
                            <a href="${response.documento_url}" target="_blank">${response.nombre_archivo}</a>
                        </p>`
                    );
                    delContainer.html(
                        `<button type="button" 
                                 class="btn btn-outline-danger btn-sm btnEliminarDocumento" 
                                 data-id_guia="${id_guia}" 
                                 data-id_documento="${docId}">
                            <i class="ri-delete-bin-line"></i> Eliminar
                        </button>`
                    );
                } else {
                    docContainer.html('<p>No hay documento cargado.</p>');
                }
            },
            error: function () {
                docContainer.html('<p class="text-danger">Error al cargar el documento.</p>');
            }
        });
    });
});

/// BORRAR DOCUMENTO GUÍA O ART
$(document).on('click', '.btnEliminarDocumento', function () {
    let id_guia = $(this).data('id_guia');
    let id_documento = $(this).data('id_documento');

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
            $.ajax({
                type: 'DELETE',
                url: `/guias/borrar_documento/${id_guia}/${id_documento}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    dt_user.draw(false);
                    $(`#docActual_${id_documento}`).html('<p>No hay documento cargado.</p>');
                    $(`#EliminarDoc_${id_documento}`).empty();

                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                },
                error: function (error) {
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





//FORMATO PDF GUIAS
$(document).on('click', '.pdfGuia', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var pdfUrl = '/guia_de_translado/' + id;
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');
    var descargarBtn = $('#descargarPdfBtn');

    // Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    // Cargar el PDF en el iframe
    iframe.attr('src', pdfUrl);

    //Configurar el botón para abrir el PDF en una nueva pestaña
    $('#NewPestana').attr('href', pdfUrl).show();
    $('#titulo_modal').text('Guía de traslado');
    $('#subtitulo_modal').text(registro);

    // Configurar el botón para abrir o descargar el PDF
    descargarBtn.off('click').on('click', function (e) {
      e.preventDefault();
      downloadPdfAsZip(pdfUrl, 'Guia_de_traslado_' + registro + '.pdf');
    });

    // Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
});








  
}); //fin function
