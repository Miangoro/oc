/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
  let buttons = [];

  // Si tiene permiso, agregas el botón
  if (puedeAgregarElUsuario) {
    buttons.push({
      text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Subir nuevo archivo</span>',
      className: 'add-new btn btn-primary waves-effect waves-light',
      attr: {
        'data-bs-toggle': 'modal',
        'data-bs-target': '#modalAddDoc'
      }
    });
  }
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2 = $('.select2'),
    offCanvasForm = $('#offcanvasAddUser');

  if (select2.length) {
    var $this = select2;
    select2Focus($this);
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Country',
      dropdownParent: $this.parent()
    });
  }

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Users datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'documentos-referencia-list'
      },
      columns: [
        // columns according to JSON
        { data: '' }, //0
        { data: 'id_doc_calidad' }, // 1
        { data: 'archivo' }, // 2
        { data: 'identificacion' }, // 3
        { data: 'nombre' }, // 4
        { data: 'estatus' }, // 5
        { data: '' }, // 6
        { data: 'action' } // 7
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
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          // User full name
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full['archvio'];

            // For Avatar badge
            var stateNum = Math.floor(Math.random() * 6);
            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
            var $state = states[stateNum];

            // Creates full output for row
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
        },
        {
          searchable: false,
          orderable: false,
          targets: 3,
          render: function (data, type, full, meta) {
            return `<span>${full.identificacion}</span>`;
          }
        },
        {
          searchable: false,
          orderable: false,
          targets: 4,
          render: function (data, type, full, meta) {
            return `<span>${full.nombre}</span>`;
          }
        },
        {
          searchable: false,
          orderable: false,
          targets: 5,
          render: function (data, type, full, meta) {
            return `<span>${full.estatus}</span>`;
          }
        },
        {
          searchable: false,
          orderable: false,
          targets: 6,
          render: function (data, type, full, meta) {
            return `
              <button
                type="button"
                class="btn btn-sm btn-warning ver-versiones"
                data-id="${full.id_doc_calidad}">
                Ver versiones
              </button>
            `;
          }
        },
        {
          // Actions botones de eliminar y actualizar(editar)
          targets: 7,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            let acciones = '';

            if (window.puedeEditarElUsuario) {
              acciones += `<a data-id="${full['id_doc_calidad']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Agregar nueva revisión </a>`;
            }
            if (window.puedeEliminarElUsuario) {
              acciones += `<a data-id="${full['id_doc_calidad']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar documento</a>`;
            }
            // Si no hay acciones, no retornar el dropdown
            if (!acciones.trim()) {
              return `
                <button class="btn btn-sm btn-secondary" disabled>
                  <i class="ri-lock-2-line ri-20px me-1"></i> Opciones
                </button>
              `;
            }
            // Si hay acciones, construir el dropdown
            const dropdown = `<div class="d-flex align-items-center gap-50">
                           <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                           <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                           <div class="dropdown-menu dropdown-menu-end m-0">
                  ${acciones}
                </div>
              </div>
            `;
            return dropdown;
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

  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account';
  // Función para inicializar Select2 en elementos específicos
  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      select2Focus($this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        language: {
          noResults: function () {
            return "No se encontraron registros";
          }
        }
      });
    });
  }


  initializeSelect2(select2Elements);

$('.datatables-users').on('click', '.ver-versiones', function() {
  let idDoc = $(this).data('id');
  // Aquí puedes abrir un modal o llamar AJAX para mostrar las versiones del documento
  console.log('Ver versiones del documento ID:', idDoc);
});


  $(function () {
    // Configuración de CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('formAddDoc');
    const fv = FormValidation.formValidation(form, {
      fields: {
        nombre: {
          // Ajusta el nombre del campo según el formulario
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el nombre del documento.'
            }
          }
        },
        identificacion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la identificación.'
            }
          }
        },
        edicion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la edición.'
            }
          }
        },
        fecha_edicion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha de edición.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'La fecha no es válida (formato: AAAA-MM-DD).'
            }
          }
        },
        estatus: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el estatus.'
            }
          }
        },
        archivo: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un archivo.'
            },
            file: {
              extension: 'pdf,doc,docx,xls,xlsx,png,jpg,jpeg',
              type: 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,image/png,image/jpeg',
              message: 'Solo se permiten archivos PDF, Word, Excel o imágenes.'
            }
          }
        },
        modifico: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese quién modificó.'
            }
          }
        },
        reviso: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese quién revisó.'
            }
          }
        },
        aprobo: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese quién aprobó.'
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
      // Enviar datos por Ajax si el formulario es válido
      var formData = new FormData(form);

      $.ajax({
        url: '/documentos-referencia-upload',
        type: 'POST',
        data: formData,
        processData: false, // IMPORTANTE: No procesar los datos
        contentType: false, // IMPORTANTE: Dejar que jQuery gestione el content-type
        success: function (response) {
          // Ocultar el modal
          $('#modalAddDoc').modal('hide');
          // Resetear el formulario
          $('#formAddDoc')[0].reset();
          // Recargar la tabla DataTables
          $('.datatables-users').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.success,
            customClass: { confirmButton: 'btn btn-success' }
          });
        },
        error: function (xhr) {
          let errors = xhr.responseJSON.errors;
          console.log(errors);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: xhr.responseJSON.message || 'Ocurrió un error al registrar el documento.',
            customClass: { confirmButton: 'btn btn-danger' }
          });
        }
      });
    });
  });

// Delete Record
$(document).on('click', '.delete-record', function () {
    var id_doc = $(this).data('id'); // Obtener el ID del documento
    var dtrModal = $('.dtr-bs-modal.show');

    // Ocultar modal responsivo en pantalla pequeña si está abierto
    if (dtrModal.length) {
        dtrModal.modal('hide');
    }

    // SweetAlert para confirmar la eliminación
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
            // Enviar solicitud DELETE al servidor
            $.ajax({
                type: 'DELETE',
                url: `${baseUrl}documentos-referencia/${id_doc}`,
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
                        text: 'El documento ha sido eliminado correctamente',
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
                        text: 'No se pudo eliminar el documento. Inténtalo de nuevo más tarde.',
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
                text: 'La eliminación del documento ha sido cancelada',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});


  //editar un campo de la tabla
  $(document).ready(function () {
    // Abrir el modal y cargar datos para editar
    $('.datatables-users').on('click', '.edit-record', function () {
      var id_clase = $(this).data('id');
      // Realizar la solicitud AJAX para obtener los datos de la clase
      $.get('/clases-list/' + id_clase + '/edit', function (data) {
        // Rellenar el formulario con los datos obtenidos
        $('#edit_clase_id').val(data.id_clase);
        $('#edit_clase_nombre').val(data.clase);
        // Mostrar el modal de edición
        $('#editClase').offcanvas('show');
      }).fail(function () {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al obtener los datos de la clase',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
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

      // Inicializar FormValidation para el formulario de edición
      const form = document.getElementById('editClassForm');
      const fv = FormValidation.formValidation(form, {
        fields: {
          edit_clase: {
            // Ajusta los nombres según tu formulario
            validators: {
              notEmpty: {
                message: 'Por favor ingrese el nombre de la clase.'
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
        var id_clase = $('#edit_clase_id').val();
        $.ajax({
          url: '/clases-list/' + id_clase,
          type: 'POST',
          data: formData,
          success: function (response) {
            $('#editClase').offcanvas('hide');
            $('#editClassForm')[0].reset();
            $('.datatables-users').DataTable().ajax.reload();
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
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al actualizar la clase',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      });
    });
  });
});
