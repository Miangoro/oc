'use strict';

// Datatable (jquery)
$(function () {
  let buttons = [];

  // Si tiene permiso, agregas el botón
  if (puedeAgregarElUsuario) {
    buttons.push({
      text: '<i class="ri-chat-new-line ri-20px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar Mensaje</span>',
      className: 'add-new btn btn-primary waves-effect waves-light',
      attr: {
        'data-bs-toggle': 'offcanvas',
        'data-bs-target': '#offcanvasAddMensaje'
      }
    });
  }

  const colorMaper = {
    'Normal': '',          // vacío = color por defecto
    'primary': '#2EAC6B',
    'secondary': '#6D788D',
    'success': '#72E128',
    'danger': '#FF4D49',
    'warning': '#FDB528',
    'info': '#26C6F9',
    'dark': '#312D4B'
};

  // Variable declaration for table
  var dt_user_table = $('.datatables-users');
  $('.select2').select2();
  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Imágenes datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'mensajes-list',
        type: 'GET'
      },
      columns: [
        { data: '' /* null, orderable: false, searchable: false  */ }, // checkbox o expand
        { data: 'fake_id' }, // 1 id o consecutivo
        { data: 'usuario_registro' }, //2
        { data: 'usuario_destino' },  //3 nombre del usuario destino
        { data: 'titulo' },  //4 nuevo  titulo
        { data: 'tipo_titulo' },  //5 nuevo tipo de titulo
        { data: 'mensaje' },  // 6 mensaje
        { data: 'tipo' }, //7 tipo de texto
        { data: 'orden' },  //8 orden
        { data: 'estatus' }, //9 estatus
        { data: 'acciones' } //10 botones de acción
      ],
      columnDefs: [
        {
          // For Responsive
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
          searchable: false,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          targets: 2,
          render: function (data, type, full, meta) {
            return `<span>${full.usuario_registro}</span>`;
          }
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            return `<span>${full.usuario_destino}</span>`;
          }
        },
        {
            targets: 4, // Título
            render: function (data, type, full, meta) {
                const color = colorMaper[full.tipo_titulo] ?? '#000';
                return `<span style="color: ${color}">${full.titulo ?? 'N/A'}</span>`;
            }
        },
        {
            targets: 5, // Tipo del título
            render: function (data, type, full, meta) {
                const color = colorMaper[full.tipo_titulo] ?? '#000';
                return `<span style="color: ${color}">${full.tipo_titulo}</span>`;
            }
        },
        {
            targets: 6, // Mensaje
            render: function (data, type, full, meta) {
                const color = colorMaper[full.tipo] ?? '#000';
                return `<span style="color: ${color}">${full.mensaje}</span>`;
            }
        },
        {
            targets: 7, // Tipo del mensaje
            render: function (data, type, full, meta) {
                const color = colorMaper[full.tipo] ?? '#000';
                return `<span style="color: ${color}">${full.tipo}</span>`;
            }
        },
        {
          targets: 8,
          render: function (data, type, full, meta) {
            return `<span>${full.orden}</span>`;
          }
        },
        {
          targets: 9, // o la columna que quieras
          render: function (data, type, full, meta) {
            let color = full.estatus === 'Activo' ? 'info' : 'danger';
            return `<span class="badge rounded-pill bg-${color}">${full.estatus}</span>`;
          }
        },
        {
          // Actions botones de eliminar y actualizar(editar)
          targets: 10,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            let acciones = '';

            if (window.puedeEditarElUsuario) {
              acciones += `<li><a data-id="${full['id']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEditMensaje" href="javascript:;" class="dropdown-item edit-record text-info"><i class="ri-message-2-line ri-20px text-info"></i> Editar mensaje</a></li>`;
            }
            if (window.puedeEliminarElUsuario) {
              acciones += `<li><a data-id="${full['id']}" class="dropdown-item delete-record text-danger waves-effect"><i class="ri-chat-delete-line ri-20px text-danger"></i> Eliminar mensaje</a></li>`;
            }


            /*             if (window.puedeEditarElUsuario) {
                          acciones += `<a data-id="${full['id_clase']}" data-bs-toggle="offcanvas" data-bs-target="#editClase" href="javascript:;" class="dropdown-item edit-record"><i class="ri-image-edit-fill ri-20px text-info"></i> Editar información</a`;
                        }
                        if (window.puedeEliminarElUsuario) {
                          acciones += `<a data-filename="${full['nombre']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar imagen</a>`;
                        } */
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
          }
        }
      ],
      order: [[1, 'asc']],
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
        sZeroRecords: 'No se encontraron resultados',
        search: '',
        searchPlaceholder: 'Buscar',
        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
        info: 'Mostrar _START_ a _END_ de _TOTAL_ registros',
        infoFiltered: '(filtrado de _MAX_ registros en total)',
        emptyTable: 'No hay datos disponibles en la tabla',
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
              return 'Detalles del mensaje'/*  + data['clase'] */;
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

  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      $this.select2({
        dropdownParent: $this.closest('.offcanvas') // <-- importante
      });
    });
  }

  // Inicializar los select2 al cargar la página
  initializeSelect2($('.select2'));

  // También puedes inicializar cuando se muestre el offcanvas
  $('#offcanvasAddMensaje').on('shown.bs.offcanvas', function () {
    initializeSelect2($(this).find('.select2'));
  });

      // Cuando se abre un offcanvas
    $(document).on('show.bs.offcanvas', function () {
      // Cierra cualquier modal que DataTables haya abierto
      $('.dtr-bs-modal').modal('hide');
    });

  $(document).ready(function () {
      // Mapa completo de colores (como los badges de Bootstrap)
      const colorMap = {
          'Normal': '#3B4056',    // gris oscuro
          'primary': '#2EAC6B',
          'secondary': '#6D788D',
          'success': '#72E128',
          'danger': '#FF4D49',
          'warning': '#FDB528',
          'info': '#26C6F9',
          'dark': '#312D4B'
      };

      // Cambiar color al seleccionar tipo
      $('#tipo, #edit_tipo').on('change', function () {
          const val = $(this).val();
          $(this).css('color', colorMap[val] || '#3B4056'); // default gris
      });

      // Cambiar color al seleccionar tipo_titulo
      $('#tipo_titulo, #edit_tipo_titulo').on('change', function () {
          const val = $(this).val();
          $(this).css('color', colorMap[val] || '#3B4056'); // default gris
      });
  });

  $(function () {
    // Configuración de CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // SUBIR IMAGEN
    const formUpload = document.getElementById('addNewMensajeForm'); // formulario offcanvas
    const fvUpload = FormValidation.formValidation(formUpload, {
      fields: {
        id_usuario_destino: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un usuario.'
            }
          }
        },
        mensaje: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un mensaje.'
            },
          },
          tipo: {
            validators: {
              notEmpty: {
                message: 'Por favor seleccione un tipo.'
              },
            }
          },
        },
        titulo: { // campo independiente
          validators: {
            maxLength: {
              max: 50,
              message: 'El título no debe exceder los 50 caracteres.'
            }
          }
        },
        tipo_titulo: { // campo independiente
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo de título.'
            },
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
      $('#btnAdd').addClass('d-none');
      $('#loading').removeClass('d-none');
      // FormData para archivos
      var formData = new FormData(formUpload);

      $.ajax({
        url: '/mensajes-upload',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#offcanvasAddMensaje').offcanvas('hide');
          $('#addNewMensajeForm')[0].reset();
          $('.select2').val(null).trigger('change'); // resetear select2
          $('#tipo_titulo, #tipo').css('color', '#3B4056'); // resetear color a gris
          /* dt_user.draw();  */ // recargar DataTable
          $('.datatables-users').DataTable().ajax.reload();
          $('#btnAdd').removeClass('d-none');
          $('#loading').addClass('d-none');

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Mensaje creado correctamente',
            customClass: { confirmButton: 'btn btn-success' }
          });
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al guardar el mensaje',
            customClass: { confirmButton: 'btn btn-danger' }
          });
          $('#btnAdd').removeClass('d-none');
          $('#loading').addClass('d-none');
        }
      });
    });

    // ELIMINAR IMAGEN
    $(document).on('click', '.delete-record', function () {
      const id = $(this).data('id'); // ✅ ahora tomamos el ID real

      Swal.fire({
        title: '¿Está seguro?',
        text: 'No podrá revertir esta acción',
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
          $.ajax({
            type: 'DELETE',
            url: `/mensajes/${id}`, // ✅ ruta con el ID correcto
            success: function (response) {
              $('.datatables-users').DataTable().ajax.reload();

              Swal.fire({
                icon: 'success',
                title: '¡Eliminado!',
                text: response.message ?? 'Mensaje eliminado correctamente',
                customClass: { confirmButton: 'btn btn-success' }
              });
            },
            error: function (xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message ?? 'No se pudo eliminar el mensaje',
                customClass: { confirmButton: 'btn btn-danger' }
              });
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelado',
            text: 'La eliminación del mensaje ha sido cancelada',
            icon: 'info',
            customClass: { confirmButton: 'btn btn-primary' }
          });
        }
      });
    });





  });



  // Detectar clic en el ícono de editar imagen
  $(document).on('click', '.edit-record', function () {
    const id = $(this).data('id');

    $.get(`/mensajes/${id}/edit`, function (data) {
      // Rellenar los campos del formulario
      $('#edit_mensaje_id').val(data.id);
      $('#edit_id_usuario_destino').val(data.id_usuario_destino).trigger('change');
      $('#edit_titulo').val(data.titulo);
      $('#edit_tipo_titulo').val(data.tipo_titulo).trigger('change');
      $('#edit_mensaje').val(data.mensaje);
      $('#edit_tipo').val(data.tipo).trigger('change');
      $('#edit_orden').val(data.orden);
      // Activar o desactivar el switch según el valor de 'activo'
      if (data.activo == 1) {
        $('#edit_activo').prop('checked', true);
      } else {
        $('#edit_activo').prop('checked', false);
      }

      // ✅ Obtener instancia existente o crear una sola vez
      const offcanvasEl = document.getElementById('offcanvasEditMensaje');
      let offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
      if (!offcanvas) {
        offcanvas = new bootstrap.Offcanvas(offcanvasEl);
      }
      offcanvas.show();
    }).fail(function () {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'No se pudieron cargar los datos del mensaje.',
        confirmButtonText: 'Cerrar',
        customClass: { confirmButton: 'btn btn-danger' }
      });
    });
  });



  $(function () {
    // Configuración de CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición de imagen
    const form = document.getElementById('editMensajeForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_usuario_destino: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un usuario.'
            }
          }
        },
        mensaje: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un mensaje.'
            },
          },
          tipo: {
            validators: {
              notEmpty: {
                message: 'Por favor seleccione un tipo.'
              },
            }
          }
        },
        orden: {
          validators: {
            notEmpty: {
              message: 'El orden es obligatorio.'
            },
            numeric: {
              message: 'El orden debe ser un número.'
            }
          }
        },
        titulo: { // campo independiente
          validators: {
            maxLength: {
              max: 50,
              message: 'El título no debe exceder los 50 caracteres.'
            }
          }
        },
        tipo_titulo: { // campo independiente
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo de título.'
            },
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: '.form-floating, .mb-3' // soporta ambos estilos
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      let id = $('#edit_mensaje_id').val();
      let formData = $(form).serialize();
      $('#btnEdit').addClass('d-none');
      $('#updating').removeClass('d-none');
      $.ajax({
        url: '/mensajes/' + id,
        type: 'PUT', // método correcto para actualizar
        data: formData,
        success: function (response) {
          const offcanvasEl = document.getElementById('offcanvasEditMensaje');
          const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
          if (offcanvas) {
            offcanvas.hide();
          }

          $('#editMensajeForm')[0].reset();
          $('.datatables-users').DataTable().ajax.reload();
          $('#btnEdit').removeClass('d-none');
          $('#updating').addClass('d-none');
          Swal.fire({
            icon: 'success',
            title: '¡Actualizado!',
            text: response.message ?? 'Imagen actualizada correctamente.',
            confirmButtonText: 'OK',
            customClass: { confirmButton: 'btn btn-success' }
          });
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: xhr.responseJSON?.message ?? 'No se pudo actualizar la imagen.',
            confirmButtonText: 'Cerrar',
            customClass: { confirmButton: 'btn btn-danger' }
          });
          $('#btnEdit').removeClass('d-none');
          $('#updating').addClass('d-none');
        }
      });
    });
  });

  /* offcanvasEl.addEventListener('hidden.bs.offcanvas', function () {
    $('.offcanvas-backdrop').remove();
    $('body').removeClass('offcanvas-backdrop');
  });
   */

  //fin
});
