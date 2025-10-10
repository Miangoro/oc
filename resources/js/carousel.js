'use strict';

// Datatable (jquery)
$(function () {
  let buttons = [];

  // Si tiene permiso, agregas el botón
  if (puedeAgregarElUsuario) {
    buttons.push({
      text: '<i class="ri-image-add-fill ri-20px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar Imagen</span>',
      className: 'add-new btn btn-primary waves-effect waves-light',
      attr: {
        'data-bs-toggle': 'offcanvas',
        'data-bs-target': '#offcanvasAddUser'
      }
    });
  }

  // Variable declaration for table
  var dt_user_table = $('.datatables-users');

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
        url: baseUrl + 'imagenes-list',
        type: 'GET'
      },
      columns: [
        { data: '' },        // 0 → responsive
        { data: 'fake_id' }, // 1 → ID real en BD
        { data: 'nombre' },  // 2
        { data: 'url' },     // 3
        { data: 'orden' },   // 4
        { data: null }       // 5 → acciones
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
          orderable: false,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          targets: 2,
          render: function (data, type, full, meta) {
            return `<span>${full.nombre}</span>`;
          }
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            return `
              <div class="card shadow-sm border-0" style="width: 130px;">
                <img src="${full.url}"
                    alt="${full.nombre}"
                    class="card-img-top rounded img-preview"
                    data-src="${full.url}"
                    style="cursor: pointer; object-fit: cover; height: 70px;" />
              </div>
            `;
          }
        },
       {
          targets: 4,
           render: function (data, type, full, meta) {
            return `<span>${full.orden}</span>`;
          }
        },
        {
          // Actions botones de eliminar y actualizar(editar)
          targets: 5,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            let acciones = '';

            if (window.puedeEditarElUsuario) {
              acciones += `<li><a data-id="${full['id_carousel']}" data-bs-toggle="offcanvas" data-bs-target="#editCarousel" href="javascript:;" class="dropdown-item edit-record text-info"><i class="ri-image-edit-fill ri-20px text-info"></i> Editar información</a></li>`;
            }
            if (window.puedeEliminarElUsuario) {
              acciones += `<li><a data-id="${full['id_carousel']}" class="dropdown-item delete-record text-danger waves-effect"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar imagen</a></li>`;
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
      order: [[0, 'asc']],
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
              return 'Detalles de ' + data['clase'];
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

  // Detectar clic en la imagen
  $(document).on('click', '.img-preview', function () {
    let src = $(this).data('src');
    $('#previewImage').attr('src', src);
    $('#imagePreviewModal').modal('show');
  });




  $(function () {
    // Configuración de CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // SUBIR IMAGEN
    const formUpload = document.getElementById('addNewImageForm'); // formulario offcanvas
    const fvUpload = FormValidation.formValidation(formUpload, {
      fields: {
        clase: {
          // aquí el campo 'clase' lo usaremos como nombre o título de la imagen opcional
          validators: {
            notEmpty: {
              message: 'Por favor selecciona una imagen.'
            }
          }
        },
        imagen: {
          validators: {
            notEmpty: {
              message: 'Debes seleccionar un archivo de imagen'
            },
            file: {
              extension: 'jpg,jpeg,png,gif',
              type: 'image/jpeg,image/png,image/gif',
              maxSize: 5 * 1024 * 1024, // 5 MB
              message: 'Solo se permiten imágenes de máximo 5MB'
            }
          },
          nombre_imagen: {
            validators: {
              stringLength: {
                max: 100,
                message: 'El nombre de la imagen no debe exceder 100 caracteres'
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
      // FormData para archivos
      var formData = new FormData(formUpload);

      $.ajax({
        url: '/imagenes-upload',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#offcanvasAddUser').offcanvas('hide');
          $('#addNewImageForm')[0].reset();
          /* dt_user.draw();  */ // recargar DataTable
          $('.datatables-users').DataTable().ajax.reload();

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Imagen subida correctamente',
            customClass: { confirmButton: 'btn btn-success' }
          });
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'No se pudo subir la imagen',
            customClass: { confirmButton: 'btn btn-danger' }
          });
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
            url: `/carousel/${id}`, // ✅ ruta con el ID correcto
            success: function (response) {
              $('.datatables-users').DataTable().ajax.reload();

              Swal.fire({
                icon: 'success',
                title: '¡Eliminado!',
                text: response.message ?? 'Imagen eliminada correctamente',
                customClass: { confirmButton: 'btn btn-success' }
              });
            },
            error: function (xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message ?? 'No se pudo eliminar la imagen',
                customClass: { confirmButton: 'btn btn-danger' }
              });
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelado',
            text: 'La eliminación de la imagen ha sido cancelada',
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

  $.get(`/carousel/${id}/edit`, function (data) {
    // Rellenar los campos del formulario
    $('#edit_carousel_id').val(data.id_carousel);
    $('#edit_carousel_nombre').val(data.nombre);
    $('#preview_edit_image').attr('src', data.url);
    $('#edit_carousel_orden').val(data.orden);

    // ✅ Obtener instancia existente o crear una sola vez
    const offcanvasEl = document.getElementById('editCarousel');
    let offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
    if (!offcanvas) {
      offcanvas = new bootstrap.Offcanvas(offcanvasEl);
    }
    offcanvas.show();
  }).fail(function () {
    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: 'No se pudieron cargar los datos de la imagen.',
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
      const form = document.getElementById('editImageForm');
      const fv = FormValidation.formValidation(form, {
        fields: {
          nombre: {
            validators: {
              notEmpty: {
                message: 'El nombre de la imagen es obligatorio.'
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
          }
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
        let id = $('#edit_carousel_id').val();
        let formData = $(form).serialize();

        $.ajax({
          url: '/carousel/' + id,
          type: 'PUT', // método correcto para actualizar
          data: formData,
          success: function (response) {
            const offcanvasEl = document.getElementById('editCarousel');
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
            if (offcanvas) {
              offcanvas.hide();
            }

            $('#editImageForm')[0].reset();
            $('.datatables-users').DataTable().ajax.reload();

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
