$(function () {
    let buttons = [];

  // Si tiene permiso, agregas el botón
  if (puedeAgregarElUsuario) {
    buttons.push({
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar Aduana</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#offcanvasAddUser'
          }
    });
  }

  const tabla = $('.datatables-aduanas');

  if (tabla.length) {
    tabla.DataTable({
      ajax: '/catalogo/aduana/data',
      columns: [
        { data: 'id' },
        { data: 'aduana' },
        { data: null }
      ],
      columnDefs: [
        {
          targets: 0,
          title: 'ID',
          orderable: true,
          searchable: false,
          responsivePriority: 1
        },
        {
          targets: 1,
          title: 'Aduana',
          responsivePriority: 2,
          render: function (data, type, full) {
            return `<span class="fw-medium">${full.aduana}</span>`;
          }
        },
        {
          targets: 2,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          responsivePriority: 3,
          render: function (data, type, full) {
            let acciones = '';

            // Acción: Editar aduana
            if (window.puedeEditarElUsuario) {
              acciones += `
                <li>
                  <a data-id="${full.id}" class="dropdown-item edit-record text-info fw-medium" style="cursor: pointer;">
                    <i class="ri-edit-box-line ri-20px text-info"></i> Editar aduana
                  </a>
                </li>`;
            }

            // Acción: Eliminar aduana
            if (window.puedeEliminarElUsuario) {
              acciones += `
                <li>
                  <a data-id="${full.id}" class="dropdown-item delete-record text-danger fw-medium" style="cursor: pointer;">
                    <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar aduana
                  </a>
                </li>`;
            }

            // Si no hay acciones → mostrar botón deshabilitado
            if (!acciones.trim()) {
              return `
                <button class="btn btn-sm btn-secondary" disabled>
                  <i class="ri-lock-2-line ri-20px me-1"></i> Opciones
                </button>
              `;
            }

            // Si hay acciones → mostrar dropdown
            return `
              <div class="dropdown">
                <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end m-0">
                  ${acciones}
                </ul>
              </div>
            `;
          }




        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              const data = row.data();
              return 'Detalles de ' + data['aduana'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            const data = $.map(columns, function (col) {
              return col.title
                ? `<tr><td>${col.title}</td><td>${col.data}</td></tr>`
                : '';
            }).join('');
            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
          }
        }
      },
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
      lengthMenu: [10, 20, 50, 70, 100],
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
      buttons: buttons,
    });
  }

  // Configurar CSRF
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Validación y envío del formulario de agregar
  const formAdd = document.getElementById('addNewClassForm');
  const fvAdd = FormValidation.formValidation(formAdd, {
    fields: {
      aduana: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el nombre de la aduana.'
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
    const formData = $(formAdd).serialize();

    $.ajax({
      url: '/catalogo/aduana',
      type: 'POST',
      data: formData,
      success: function (response) {
        const offcanvasAdd = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasAddUser'));
        offcanvasAdd.hide();
        formAdd.reset();
        tabla.DataTable().ajax.reload();

        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.success,
          customClass: { confirmButton: 'btn btn-success' }
        });
      },
      error: function () {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al agregar la aduana',
          customClass: { confirmButton: 'btn btn-danger' }
        });
      }
    });
  });

  // 🔴 Evento: Eliminar aduana
  $(document).on('click', '.delete-record', function () {
    const id_aduana = $(this).data('id');
    const dtrModal = $('.dtr-bs-modal.show');
    if (dtrModal.length) dtrModal.modal('hide');

    Swal.fire({
      title: '¿Está seguro?',
      text: 'Esta acción no se puede revertir',
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
          url: `/catalogo/aduana/${id_aduana}`,
          success: function () {
            tabla.DataTable().ajax.reload();

            Swal.fire({
              icon: 'success',
              title: '¡Eliminado!',
              text: 'La aduana fue eliminada correctamente.',
              customClass: { confirmButton: 'btn btn-success' }
            });
          },
          error: function (error) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo eliminar. Intente más tarde.',
              footer: `<pre>${error.responseText}</pre>`,
              customClass: { confirmButton: 'btn btn-danger' }
            });
          }
        });
      } else {
        Swal.fire({
          title: 'Cancelado',
          text: 'La eliminación fue cancelada',
          icon: 'info',
          customClass: { confirmButton: 'btn btn-primary' }
        });
      }
    });
  });

  //Evento: Editar aduana
  $(document).on('click', '.edit-record', function () {
    const id_aduana = $(this).data('id');
    const dtrModal = $('.dtr-bs-modal.show');
    if (dtrModal.length) dtrModal.modal('hide');

    $.get(`/catalogo/aduana/${id_aduana}/edit`, function (data) {
      $('#edit_aduana_id').val(data.id);
      $('#edit_aduana_nombre').val(data.aduana);

      const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('editAduana'));
      offcanvasEdit.show();
    }).fail(function () {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'No se pudieron cargar los datos de la aduana.',
        customClass: { confirmButton: 'btn btn-danger' }
      });
    });
  });

  const formEdit = document.getElementById('editAduanaForm');
  const fvEdit = FormValidation.formValidation(formEdit, {
    fields: {
      aduana: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el nombre de la aduana.'
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
    const formData = $(formEdit).serialize();
    const id_aduana = $('#edit_aduana_id').val();

    $.ajax({
      url: `/catalogo/aduana/${id_aduana}`,
      type: 'PUT',
      data: formData,
      success: function (response) {
        const offcanvasEdit = bootstrap.Offcanvas.getInstance(document.getElementById('editAduana'));
        offcanvasEdit.hide();
        formEdit.reset();
        $('.datatables-aduanas').DataTable().ajax.reload();

        Swal.fire({
          icon: 'success',
          title: '¡Actualizado!',
          text: response.success,
          customClass: { confirmButton: 'btn btn-success' }
        });
      },
      error: function () {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'No se pudo actualizar la aduana.',
          customClass: { confirmButton: 'btn btn-danger' }
        });
      }
    });
  });
});
