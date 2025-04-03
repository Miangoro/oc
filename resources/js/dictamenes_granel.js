/**
 * Page User List
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
//FECHAS
$('#fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
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
//FECHAS EDIT
$('#edit_fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
  var fechaVigencia = fechaInicial.toISOString().split('T')[0]; 
  $('#edit_fecha_vigencia').val(fechaVigencia);

  // Deshabilitar la interacción con flatpickr en #edit_fecha_vigencia
  flatpickr("#edit_fecha_vigencia", {
    dateFormat: "Y-m-d",  
    enableTime: false,   
    allowInput: true,  
    locale: "es",  
    static: true,   
    disable: true  
  });
});




 // Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
  select2 = $('.select2'),
  userView = baseUrl + 'app/user/view/account',
  offCanvasForm = $('#modalAddDictamenGranel');

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
      url: baseUrl + 'dictamen-granel-list', // Asegúrate de que esta URL coincida con la ruta en tu archivo de rutas
      type: 'GET'
    },
    columns: [
      { data: ''},
      { data: 'num_dictamen' },
         { data: 'num_servicio' },
         
         {
           data: null, // Se usará null porque combinaremos varios valores
          
            render: function(data, type, row) {
                return `
                <strong>${data.numero_cliente}</strong><br>
                    <span style="font-size:11px">${data.razon_social}<span>
                    
                `;
            }
          },
      
        { data: 'nombre_lote' }, // Ajusta el ancho aquí
         { data: 'fecha_emision'},
         { data: 'estatus'/*,
          searchable: false, 
          orderable: false,
          render: function (data, type, row) {
              let color, estatus;
              if (data == 1) {
                  color = 'badge rounded-pill bg-danger';
                  estatus = 'Cancelado';
              } else if (data == 2) {
                  color = 'badge rounded-pill bg-success';
                  estatus = 'Reexpedido';
              } else {
                color = 'badge rounded-pill bg-success';
                estatus = 'Emitido';
            }
              // Devolvemos el HTML con el color y el texto que se mostrarán en la tabla
              return '<span class="' + color + '">' + estatus + '</span>';
          }*/
        },
         
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
            var $num_dictamen = full['num_dictamen'];
            var $id = full['id_dictamen'];
            return `<small class="fw-bold">`+ $num_dictamen + `</small>` +
             `<i class="ri-file-pdf-2-fill text-danger ri-28px pdfDictamen cursor-pointer" data-id="` + $id + `" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>`;
          }
        }, 
         {
            // Tabla 3
            targets: 2,
            render: function (data, type, full, meta) {
              var $num_servicio = full['num_servicio'];
              var $folio_solicitud = full['folio_solicitud'];
              var $id_solicitud = full['id_solicitud'];
              return '<span class="fw-bold">Servicio:</span> ' + $num_servicio +

                '<br><span class="fw-bold">Solicitud: </span>' + $folio_solicitud +
                `<i class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfSolicitud" data-id="` + $id_solicitud + `" data-folio="` + $folio_solicitud + `" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>`;
            }
          }, 

          {
            targets: 4,
            responsivePriority: 4,
            render: function (data, type, full, meta) {
         
              // Retorna el badge con el texto y color apropiado
              return `<b>Lote: </b><small>${full['nombre_lote']}</small><br><b>FQs: </b><small>${full['analisis']}</small>`;
            }     
          },
          {
            targets: 5, // Suponiendo que este es el índice de la columna que quieres actualizar
            render: function (data, type, full, meta) {
                // Obtener las fechas de vigencia y vencimiento, o 'N/A' si no están disponibles
                var $fecha_emision = full['fecha_emision'] ?? 'N/A'; // Fecha de vigencia
                var $fecha_vigencia = full['fecha_vigencia'] ?? 'N/A'; // Fecha de vencimiento
        
                // Definir los mensajes de fecha con formato
                var fechaVigenciaMessage = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Emisión:<br></strong> ${$fecha_emision}</span>`;
                var fechaVencimientoMessage = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Vigencia:<br></strong> ${$fecha_vigencia}</span>`;

                // Retorna las fechas en formato de columnas
                return `
                    <div>
                        <div>${fechaVigenciaMessage}</div>
                        <div>${fechaVencimientoMessage}</div>
                        <div style="text-aling: center" class="small">${full['diasRestantes']}</div>
                    </div>
                `;
            }
          }, 
          {
            ///estatus
            targets: 6,
            searchable: false,
            orderable: false,
            responsivePriority: 4,
            render: function (data, type, full, meta) {
              var $estatus = full['estatus'];
              var $emision = full['emision'];
              var $vigencia = full['vigencia'];
              let estatus;
                if ($emision > $vigencia) {
                  estatus = '<span class="badge rounded-pill bg-danger">Vencido</span>';
                } else if ($estatus == 1) {
                    estatus = '<span class="badge rounded-pill bg-danger">Cancelado</span>';
                } else if ($estatus == 2) {
                    estatus = '<span class="badge rounded-pill bg-success">Reexpedido</span>';
                } else {
                  estatus = '<span class="badge rounded-pill bg-success">Emitido</span>';
                }
                
              return estatus;
            }
          },

          /*{
            // User full name
            targets: 1,
            responsivePriority: 4,
            render: function (data, type, full, meta) {
              var $name = full['num_dictamen'];
              var stateNum = Math.floor(Math.random() * 6);
              var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
              var $state = states[stateNum];
              var $row_output =
                '<div class="d-flex justify-content-start align-items-center user-name">' +
                '<div class="avatar-wrapper">' +
                '</div>' +
                '</div>' +
                '<div class="d-flex flex-column">' +
                '<span class="fw-medium">' +
                $name +
                '</span>' +
                '</div>' +
                '</div>';
              return $row_output;
            }
          },*/

      {
        // Actions botones de eliminar y actualizar(editar)
        targets: -1,
        title: 'Acciones',
        searchable: false,
        orderable: true,
        render: function (data, type, full, meta) {
          return (
            '<div class="d-flex align-items-center gap-50">' +
            /*'<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>'+
            '</button>' +*/
            `<button class="btn btn-sm dropdown-toggle hide-arrow ` +(full['estatus'] == 1 ? 'btn-danger disabled' : 'btn-info')+ `" data-bs-toggle="dropdown">` +
                (full['estatus'] == 1 ? 'Cancelado' : '<i class="ri-settings-5-fill"></i>&nbsp;Opciones<i class="ri-arrow-down-s-fill ri-20px"></i>') + 
            '</button>' +
            '<div class="dropdown-menu dropdown-menu-end m-0">' +
              `<a data-id="${full['id_dictamen']}" data-bs-toggle="modal" data-bs-target="#modalEditDictamenGranel" class="dropdown-item edit-record waves-effect "><i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>` +
              `<a data-id="${full['id_dictamen']}" data-bs-toggle="modal" data-bs-target="#modalReexDicInsta" class="dropdown-item waves-effect reexpedir"> <i class="ri-file-edit-fill text-success"></i> Reexpedir/Cancelar</a>` +
              `<a data-id="${full['id_dictamen']}" class="dropdown-item delete-record waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>` +
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
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    },
    // Buttons with Dropdown
    buttons: [
      {
        extend: 'collection',
        className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
        text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
        buttons: [
          {
            extend: 'print',
            title: 'Dictamenes a granel',
            text: '<i class="ri-printer-line me-1" ></i>Print',
            className: 'dropdown-item',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              // prevent avatar to be print
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {

                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                      if (item.lastChild && item.lastChild.firstChild) {
                        result = result + item.lastChild.firstChild.textContent;
                      }
                    } else if (item.innerText === undefined) {
                      result = result + item.textContent;
                    } else {
                      result = result + item.innerText;
                    }
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
            title: 'Dictamenes a granel',
            text: '<i class="ri-file-text-line me-1" ></i>Csv',
            className: 'dropdown-item',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              // prevent avatar to be print
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {

                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                      if (item.lastChild && item.lastChild.firstChild) {
                        result = result + item.lastChild.firstChild.textContent;
                      }
                    } else if (item.innerText === undefined) {
                      result = result + item.textContent;
                    } else {
                      result = result + item.innerText;
                    }

                  });
                  return result;
                }
              }
            }
          },
          {
            extend: 'excel',
            title: 'Dictamenes a granel',
            text: '<i class="ri-file-excel-line me-1"></i>Excel',
            className: 'dropdown-item',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              // prevent avatar to be display
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {
                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                      if (item.lastChild && item.lastChild.firstChild) {
                        result = result + item.lastChild.firstChild.textContent;
                      }
                    } else if (item.innerText === undefined) {
                      result = result + item.textContent;
                    } else {
                      result = result + item.innerText;
                    }
                  });
                  return result;
                }
              }
            }
          },
          {
            extend: 'pdf',
            title: 'Dictamenes a granel',
            text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
            className: 'dropdown-item',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              // prevent avatar to be display
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {
                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                      if (item.lastChild && item.lastChild.firstChild) {
                        result = result + item.lastChild.firstChild.textContent;
                      }
                    } else if (item.innerText === undefined) {
                      result = result + item.textContent;
                    } else {
                      result = result + item.innerText;
                    }
                  });
                  return result;
                }
              }
            }
          },
          {
            extend: 'copy',
            title: 'Dictamenes a granel',
            text: '<i class="ri-file-copy-line me-1"></i>Copy',
            className: 'dropdown-item',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              // prevent avatar to be copy
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {
                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                      if (item.lastChild && item.lastChild.firstChild) {
                        result = result + item.lastChild.firstChild.textContent;
                      }
                    } else if (item.innerText === undefined) {
                      result = result + item.textContent;
                    } else {
                      result = result + item.innerText;
                    }
                  });
                  return result;
                }
              }
            }
          }
        ]
      },
      {
        text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Nuevo dictamen</span>',
        className: 'add-new btn btn-primary waves-effect waves-light',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-target': '#modalAddDictamenGranel'
        }
      }
    ],


    // For responsive popup
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: function (row) {
            var data = row.data();
            return 'Detalles del destino ';
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

  // Inicializar tooltips después de renderizar la tabla
  /*dt_user.on('draw', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });*/

}



///AGREGAR NUEVO DICTAMEN
$(function () {
  // Configuración CSRF para Laravel
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Inicializar FormValidation
  const form = document.getElementById('addNewDictamenGranelForm');
  const fv = FormValidation.formValidation(form, {
    fields: {
      'id_inspeccion': {
        validators: {
          notEmpty: {
            message: 'Selecciona el número de servicio.'
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
            enable: function (field) {
              return !$(field).val();
            }
          }
        }
      },
      'fecha_emision': {
        validators: {
          notEmpty: {
            message: 'La fecha de emisión es obligatoria.',
            enable: function (field) {
              return !$(field).val();
            }
          },
          date: {
            format: 'YYYY-MM-DD',
            message: 'Ingresa una fecha válida (yyyy-mm-dd).',
            enable: function (field) {
              return !$(field).val();
            }
          }
        }
      },
      'fecha_vigencia': {
        validators: {
          notEmpty: {
            message: 'La fecha de vigencia es obligatoria.',
            enable: function (field) {
              return !$(field).val();
            }
          },
          date: {
            format: 'YYYY-MM-DD',
            message: 'Ingresa una fecha válida (yyyy-mm-dd).',
            enable: function (field) {
              return !$(field).val();
            }
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
    var formData = new FormData(form);
    // Imprimir los datos del formulario para verificar
    console.log('Form Data:', Object.fromEntries(formData.entries()));

    $.ajax({
      url: '/dictamenes-granel',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar el modal y resetear el formulario
        $('#modalAddDictamenGranel').modal('hide');
        $('#addNewDictamenGranelForm')[0].reset();
        $('.select2').val(null).trigger('change');
        $('.datatables-users').DataTable().ajax.reload();

        // Mostrar mensaje de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.message,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function (xhr) {
        console.log('Error:', xhr.responseText);
        // Mostrar mensaje de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar el dictamen de granel',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // Función para actualizar la validación al cambiar la fecha en el datepicker
  function updateDatepickerValidation() {
    $('#fecha_vigencia').on('change', function () {
      fv.revalidateField('fecha_vigencia');
    });

    $('#fecha_emision').on('change', function () {
      fv.revalidateField('fecha_emision');
    });
  }

  // Función para actualizar la validación al cambiar el valor en los select2
  function updateSelect2Validation() {
    $('#id_inspeccion').on('change', function () {
      fv.revalidateField('id_inspeccion');
    });
  }
  // Llamar a las funciones para actualizar la validación
  updateDatepickerValidation();
  updateSelect2Validation();

});



//ELIMINAR
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
        url: `${baseUrl}dictamen/granel/${id_dictamen}`,
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
            text: '¡El dictamen ha sido eliminado correctamente!',
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
            text: 'No se pudo eliminar el dictamen.',
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
        text: 'La eliminación del dictamen ha sido cancelada',
        icon: 'info',
        customClass: {
          confirmButton: 'btn btn-primary'
        }
      });
    }
  });
});



///EDITAR
$(function () {
  // Configuración CSRF para Laravel
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Inicializar FormValidation para el formulario de creación y edición
  const form = document.getElementById('addNEditDictamenGranelForm');
  const fv = FormValidation.formValidation(form, {
    fields: {
      'num_dictamen': {
        validators: {
          notEmpty: {
            message: 'El número de dictamen es obligatorio.'
          },
        }
      },
      'id_inspeccion': {
        validators: {
          notEmpty: {
            message: 'Selecciona el número de servicio.'
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
      'id_firmante': {
        validators: {
          notEmpty: {
            message: 'El nombre del firmante es obligatorio.',
            enable: function (field) {
              return !$(field).val();
            }
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
    // Validar y enviar el formulario cuando pase la validación
    var formData = new FormData(form);
    var dictamenid = $('#edit_id_dictamen').val();

    $.ajax({
      url: '/dictamenes/productos/' + dictamenid + '/update',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        dt_user.ajax.reload();
        $('#modalEditDictamenGranel').modal('hide');
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.message,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function (xhr) {
        if (xhr.status === 422) {
          var errors = xhr.responseJSON.errors;
          var errorMessages = Object.keys(errors).map(function (key) {
            return errors[key].join('<br>');
          }).join('<br>');

          Swal.fire({
            icon: 'error',
            title: 'Error',
            html: errorMessages,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ha ocurrido un error al actualizar el dictamen.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      }
    });
  });

  // Función del botón de editar para cargar los datos del dictamen
  $(document).on('click', '.edit-record', function () {
    var id_dictamen = $(this).data('id');
    $('#edit_id_dictamen').val(id_dictamen);

    $.ajax({
      url: '/dictamenes/productos/' + id_dictamen + '/edit',
      method: 'GET',
      success: function (data) {
        if (data.success) {
          var dictamen = data.dictamen;
          // Asignar valores a los campos del formulario
          $('#edit_num_dictamen').val(dictamen.num_dictamen);
          $('#edit_id_inspeccion').val(dictamen.id_inspeccion).trigger('change');
          $('#edit_fecha_emision').val(dictamen.fecha_emision);
          $('#edit_fecha_vigencia').val(dictamen.fecha_vigencia);
          $('#edit_id_firmante').val(dictamen.id_firmante).trigger('change');
          // Mostrar el modal
          $('#modalEditDictamenGranel').modal('show');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar los datos del dictamen a granel.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      },
      error: function (error) {
        console.error('Error al cargar los datos del dictamen a granel:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo cargar los datos del dictamen a granel.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // Función para actualizar la validación al cambiar la fecha en el datepicker
  function updateDatepickerValidation() {
    $('#edit_fecha_emision').on('change', function () {
      fv.revalidateField('fecha_emision');
    });

    $('#edit_fecha_vigencia').on('change', function () {
      fv.revalidateField('fecha_vigencia');
    });
  }
  // Llamar a la función para actualizar la validación
  updateDatepickerValidation();
});



///VER PDF DICTAMEN
$(document).on('click', '.pdfDictamen', function ()  {
  var id = $(this).data('id');//Obtén el ID desde el atributo "data-id" en PDF
  var pdfUrl = '/dictamen_granel/' + id; //Ruta del PDF
  var iframe = $('#pdfViewer');
  var spinner = $('#cargando');
      
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    
    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();

    $("#titulo_modal").text("Dictamen de Cumplimiento NOM Mezcal a Granel");
    $("#subtitulo_modal").text("PDF del Dictamen");
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
});

///FORMATO PDF SOLICITUD DICTAMEN
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



///FQ'S
$(document).on('click', '.ver-folio-fq', function (e) {
  e.preventDefault();

  var idDictamen = $(this).data('id');

  $.ajax({
    url: '/dictamenes/productos/' + idDictamen + '/foliofq',
    method: 'GET',
    success: function (response) {
      console.log('Response:', response); // Verifica todo el objeto de respuesta

      if (response.success) {
        var documentos = response.documentos;
        var $tableBody = $('#documentosTableBody');
        $tableBody.empty(); // Limpiar contenido previo

        // Mostrar ícono al archivo PDF si está disponible
        var documentoOtroOrganismo = documentos.find(doc => doc.tipo.includes('Certificado de lote a granel'));
        var nombre = documentoOtroOrganismo && documentoOtroOrganismo.nombre ? documentoOtroOrganismo.nombre : 'Sin nombre disponible';

        if (documentoOtroOrganismo) {
          $tableBody.append('<tr><td>Certificado de lote a granel:</td><td>' + nombre + '</td><td><a href="#" class="ver-pdf" data-url="../files/' + response.numeroCliente + '/' + documentoOtroOrganismo.url + '" data-title="' + nombre + '"><i class="ri-file-pdf-2-fill text-danger fs-1"></i></a></td></tr>');
        } else {
          $tableBody.append('<tr><td>Certificado de lote a granel:</td><td>Sin nombre disponible</td><td>No hay certificado disponible.</td></tr>');
        }

        // Documentos certificados por OC CIDAM
        var documentoCompletoAsignado = false;
        var documentoAjusteAsignado = false;

        documentos.forEach(function (documento) {
          var nombreDocumento = documento.nombre || 'Sin nombre disponible';
          var documentoHtml = '<a href="#" class="ver-pdf" data-url="../files/' + response.numeroCliente + '/' + documento.url + '" data-title="' + nombreDocumento + '"><i class="ri-file-pdf-2-fill text-danger fs-1"></i></a>';

          if (documento.tipo.includes('Análisis completo') && !documentoCompletoAsignado) {
            $tableBody.append('<tr><td>Certificado (Análisis Completo):</td><td>' + nombreDocumento + '</td><td>' + documentoHtml + '</td></tr>');
            documentoCompletoAsignado = true;
          }
          if (documento.tipo.includes('Ajuste de grado') && !documentoAjusteAsignado) {
            $tableBody.append('<tr><td>Certificado (Ajuste de Grado):</td><td>' + nombreDocumento + '</td><td>' + documentoHtml + '</td></tr>');
            documentoAjusteAsignado = true;
          }
        });

        if (!documentoCompletoAsignado) {
          $tableBody.append('<tr><td>Certificado (Análisis Completo):</td><td>Sin nombre disponible</td><td>No hay certificado disponible.</td></tr>');
        }
        if (!documentoAjusteAsignado) {
          $tableBody.append('<tr><td>Certificado (Ajuste de Grado):</td><td>Sin nombre disponible</td><td>No hay certificado disponible.</td></tr>');
        }

        // Mostrar el modal de ver documentos
        $('#modalVerDocumento').modal('show');
      } else {
        console.log('No success in response'); // Mensaje si el success es falso
        $('#documentosTableBody').html('<tr><td colspan="3">No se pudo cargar el documento.</td></tr>');
      }
    },
    error: function (xhr, status, error) {
      console.log('Error AJAX:', error);
      $('#documentosTableBody').html('<tr><td colspan="3">Ocurrió un error al intentar cargar el documento.</td></tr>');
    }
  });
});

//VER PDF FQ'S
$(document).on('click', '.ver-pdf', function (e) {
  e.preventDefault();
  var url = $(this).data('url'); // Obtén la URL del PDF desde el atributo data-url
  var title = $(this).data('title'); // Obtén el título del PDF desde el atributo data-title
  var iframe = $('#pdfViewerFolio');
  var spinner = $('#loading-spinner');

  // Mostrar el spinner y ocultar el iframe antes de cargar el PDF
  spinner.show();
  iframe.hide();

  // Actualizar el título del modal
  $("#titulo_modal_Folio").text(title);
  // Ocultar el modal de ver documentos antes de mostrar el modal del PDF
  $('#modalVerDocumento').modal('hide');
  // Mostrar el modal para el PDF
  $('#mostrarPdfFolio').modal('show');

  // Cargar el PDF en el iframe
  iframe.attr('src', url);

  // Asegurarse de que el evento `load` del iframe está manejado correctamente
  iframe.off('load').on('load', function () {
    spinner.hide();
    iframe.show();
  });

  // Reabrir el modal de ver documentos cuando se cierre el modal del PDF
  $('#mostrarPdfFolio').on('hidden.bs.modal', function () {
    $('#modalVerDocumento').modal('show');
  });
});




///REEXPEDIR DICTAMEN
let isLoadingData = false;
let fieldsValidated = []; 

$(document).ready(function () {
    $(document).on('click', '.reexpedir', function () {
        var id_dictamen = $(this).data('id');
        console.log('ID Dictamen para reexpedir:', id_dictamen);
        $('#reexpedir_id_dictamen').val(id_dictamen);
        $('#modalReexDicInsta').modal('show');
    });

    //funcion fechas
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
  
  function cargarDatosReexpedicion(id_dictamen) {
      console.log('Cargando datos para la reexpedición con ID:', id_dictamen);
      clearFields();
  
      $.get(`/dictamenes/productos/${id_dictamen}/edit`).done(function (data) {
      console.log('Respuesta completa:', data);
      var dictamen = data.dictamen;
  
            if (data.error) {
                showError(data.error);
                return;
            }

            $('#id_inspeccion_rex').val(dictamen.id_inspeccion).trigger('change');
            $('#numero_dictamen_rex').val(dictamen.num_dictamen);
            $('#id_firmante_rex').val(dictamen.id_firmante).trigger('change');
            $('#fecha_emision_rex').val(dictamen.fecha_emision);
            $('#fecha_vigencia_rex').val(dictamen.fecha_vigencia);
            //$('#observaciones_rex').val(dictamen.observaciones);

            $('#accion_reexpedir').trigger('change'); 
            isLoadingData = false;




  
      }).fail(function () {
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

  $('#modalReexDicInsta').on('hidden.bs.modal', function () {
      $('#formReexDicInsta')[0].reset();
      clearFields();
      $('#campos_condicionales').hide();
      fieldsValidated = []; 
  });

    const formReexpedir = document.getElementById('formReexDicInsta');
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
            'id_inspeccion': {
                validators: {
                    notEmpty: {
                        message: 'Debes seleccionar una acción.'
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
                $('#modalReexDicInsta').modal('hide');
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





});
