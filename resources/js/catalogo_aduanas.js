$(function () {
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
          render: function (data, type, full, meta) {
            return `<span class="fw-medium">${full.aduana}</span>`;
          }
        },
        {
          targets: 2,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          responsivePriority: 3,
          render: function (data, type, full, meta) {
            return `
              <div class="dropdown">
                <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end m-0">
                  <li>
                    <a data-id="${full.id}" data-bs-toggle="offcanvas" data-bs-target="#editAduana" href="javascript:;" class="dropdown-item edit-record">
                      <i class="ri-edit-box-line ri-20px text-info"></i> Editar aduana
                    </a>
                  </li>
                  <li>
                    <a data-id="${full.id}" class="dropdown-item delete-record text-danger">
                      <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar aduana
                    </a>
                  </li>
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
              var data = row.data();
              return 'Detalles de ' + data['aduana'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col) {
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
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
          text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar</span>',
          buttons: [
            {
              extend: 'print',
              title: 'catalogo aduanas',
              text: '<i class="ri-printer-line me-1"></i>Print',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2] }
            },
            {
              extend: 'csv',
              title: 'catalogo aduanas',
              text: '<i class="ri-file-text-line me-1"></i>CSV',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2] }
            },
            {
              extend: 'excel',
              title: 'catalogo aduanas',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2] }
            },
            {
              extend: 'pdf',
              title: 'catalogo aduanas',
              text: '<i class="ri-file-pdf-line me-1"></i>PDF',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2] }
            },
            {
              extend: 'copy',
              title: 'catalogo aduanas',
              text: '<i class="ri-file-copy-line me-1"></i>Copiar',
              className: 'dropdown-item',
              exportOptions: { columns: [0, 1, 2] }
            }
          ]
        },
        {
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar Aduana</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#offcanvasAddUser'
          }
        }
      ]
    });
  }

  // Configurar CSRF para Laravel
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Validación del formulario de nueva aduana
  const form = document.getElementById('addNewClassForm');
  const fv = FormValidation.formValidation(form, {
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
    var formData = $(form).serialize();

    $.ajax({
      url: '/catalogo',
      type: 'POST',
      data: formData,
      success: function (response) {
        $('#offcanvasAddUser').offcanvas('hide');
        $('#addNewClassForm')[0].reset();
        $('.datatables-aduanas').DataTable().ajax.reload();

        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.success,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function () {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al agregar la aduana',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      },

    });
    $(document).on('click', '.delete-record', function () {
      var id_aduana = $(this).data('id'); // ID del registro
      var dtrModal = $('.dtr-bs-modal.show');

      // Cerrar el modal responsivo si está abierto
      if (dtrModal.length) {
        dtrModal.modal('hide');
      }

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
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
              $('.datatables-aduanas').DataTable().ajax.reload(); // recarga tabla

              Swal.fire({
                icon: 'success',
                title: '¡Eliminado!',
                text: 'La aduana fue eliminada correctamente.',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            },
            error: function (error) {
              console.error(error);

              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo eliminar. Intente más tarde.',
                footer: `<pre>${error.responseText}</pre>`,
                customClass: {
                  confirmButton: 'btn btn-danger'
                }
              });
            }
          });
        } else {
          Swal.fire({
            title: 'Cancelado',
            text: 'La eliminación fue cancelada',
            icon: 'info',
            customClass: {
              confirmButton: 'btn btn-primary'
            }
          });
        }
      });
    });
    $(document).ready(function () {
      // Configurar CSRF para Laravel
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // 👉 Abrir modal de edición y cargar datos por AJAX
      $('.datatables-aduanas').on('click', '.edit-record', function () {
        var id_aduana = $(this).data('id');

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

      // Validación y envío del formulario de edición
      const form = document.getElementById('editAduanaForm');
      const fv = FormValidation.formValidation(form, {
        fields: {
          'aduana': {
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
        var formData = $(form).serialize();
        var id_aduana = $('#edit_aduana_id').val();

        $.ajax({
          url: `/catalogo/aduana/${id_aduana}`,
          type: 'PUT',
          data: formData,
          success: function (response) {
            $('#editAduana').offcanvas('hide');
            $('#editAduanaForm')[0].reset();
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


  });

}
);
