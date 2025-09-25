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
        url: baseUrl + 'documentos-procedimientos-list'
      },
      columns: [
        // columns according to JSON
        { data: '' }, //0
        { data: 'id_doc_calidad' }, // 1
        { data: 'archivo' }, // 2
        { data: 'archivo_editable'}, //3
        { data: 'identificacion' }, // 4
        { data: 'nombre' }, // 5
        { data: 'estatus' }, // 6
        { data: '' }, // 7
        { data: 'action' } // 8
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
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        },
{
  targets: 2,
  className: 'text-center',
  searchable: false,
  orderable: false,
  render: function (data, type, full, meta) {
    var archivo = full['archivo']; // ruta del archivo en DB
    if (archivo && archivo !== '') {
      var extension = archivo.split('.').pop().toLowerCase();
      var iconClass = '';
      var colorClass = '';
      var label = '';

      switch (extension) {
        case 'pdf':
          iconClass = 'ri-file-pdf-2-fill';
          colorClass = 'text-danger';
          label = 'PDF';
          break;
        case 'doc':
        case 'docx':
          iconClass = 'ri-file-word-2-fill';
          colorClass = 'text-primary';
          label = 'Word';
          break;
        case 'xls':
        case 'xlsx':
          iconClass = 'ri-file-excel-2-fill';
          colorClass = 'text-success';
          label = 'Excel';
          break;
        case 'jpg':
        case 'jpeg':
        case 'png':
          iconClass = 'ri-image-fill';
          colorClass = 'text-info';
          label = 'Imagen';
          break;
        default:
          iconClass = 'ri-file-fill';
          colorClass = 'text-secondary';
          label = 'Archivo';
      }

      return `
        <i class="${iconClass} ${colorClass} ri-40px PDFDocFind cursor-pointer"
          title="${label}"
          data-bs-target="#mostrarPdf"
          data-bs-toggle="modal"
          data-bs-dismiss="modal"
          data-nombre="${full['nombre']}"
          data-url="/storage/${archivo}"
          data-id="${full['id_doc_calidad']}"
          data-archivo="${archivo}"></i>
      `;
    } else {
      return '<i class="ri-file-fill ri-32px icon-no-pdf text-muted"></i>'; // ícono gris genérico
    }
  }
}
,
{
  targets: 3,
  className: 'text-center',
  searchable: false,
  orderable: false,
  render: function (data, type, full, meta) {
    var archivo = full['archivo_editable']; // ruta en DB
    if (archivo && archivo !== '') {
      // obtener la extensión (en minúsculas)
      var extension = archivo.split('.').pop().toLowerCase();
      var iconClass = '';
      var colorClass = '';
      var label = '';

      switch (extension) {
        case 'pdf':
          iconClass = 'ri-file-pdf-2-fill';
          colorClass = 'text-danger';
          label = 'PDF';
          break;
        case 'doc':
        case 'docx':
          iconClass = 'ri-file-word-2-fill';
          colorClass = 'text-primary';
          label = 'Word';
          break;
        case 'xls':
        case 'xlsx':
          iconClass = 'ri-file-excel-2-fill';
          colorClass = 'text-success';
          label = 'Excel';
          break;
        case 'jpg':
        case 'jpeg':
        case 'png':
          iconClass = 'ri-image-fill';
          colorClass = 'text-info';
          label = 'Imagen';
          break;
        default:
          iconClass = 'ri-file-fill';
          colorClass = 'text-secondary';
          label = 'Archivo';
      }

      return `
        <i class="${iconClass} ${colorClass} ri-40px PDFDocFind cursor-pointer"
          title="${label}"
          data-bs-target="#mostrarPdf"
          data-bs-toggle="modal"
          data-bs-dismiss="modal"
          data-nombre="${full['nombre']}"
          data-url="/storage/${archivo}"
          data-id="${full['id_doc_calidad']}"
          data-archivo="${archivo}"></i>
      `;
    } else {
      return '<i class="ri-file-fill ri-32px icon-no-pdf text-muted"></i>'; // ícono gris genérico
    }
  }
},
        {
          targets: 4,
          render: function (data, type, full, meta) {
            return `<span>${full.identificacion}</span>`;
          }
        },
        {
          targets: 5,
          render: function (data, type, full, meta) {
            return `<span>${full.nombre}</span>`;
          }
        },
        {
          targets: 6,
          render: function (data, type, full, meta) {
            let colorClass = '';
            switch ((full.estatus || '').toLowerCase()) {
              case 'vigente':
                colorClass = 'badge rounded-pill bg-success';
                break;
              case 'obsoleto':
                colorClass = 'badge rounded-pill bg-warning text-dark';
                break;
              case 'descontinuado':
                colorClass = 'badge rounded-pill bg-danger';
                break;
              default:
                colorClass = 'badge rounded-pill bg-secondary';
            }
            return `<span class="${colorClass}">${full.estatus}</span>`;
          }
        },
        {
          searchable: false,
          orderable: false,
          targets: 7,
          render: function (data, type, full, meta) {
            return `
              <button class="btn btn-sm btn-warning ver-versiones" data-id="${full.id_doc_calidad}" type="button">
                Ver versiones
              </button>
            `;
          }
        },
        {
          // Actions botones de eliminar y actualizar(editar)
          targets: 8,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            let acciones = '';

            if (window.puedeEditarElUsuario) {
              acciones += `<a data-id="${full['id_doc_calidad']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser" href="javascript:;" class="dropdown-item edit-record text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Agregar nueva revisión </a>`;
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
      order: [[3, 'desc']],
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

  $(document).ready(function () {
    flatpickr(".flatpickr", {
      dateFormat: "Y-m-d", // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
      enableTime: false,   // Desactiva la  hora
      allowInput: true,    // Permite al usuario escribir la fecha manualmente
      locale: "es",        // idioma a español
    });
  });

  $('.datatables-users').on('click', '.ver-versiones', function () {
    let idDoc = $(this).data('id');

    // Abrir modal
    $('#modalEditDoc').modal('show');

    // Mostrar loader
    $("#cargando").show();
    $("#historialContent").html('');

    // Llamada AJAX
    $.ajax({
      url: `/documentos-procedimientos/${idDoc}/historial`,
      type: 'GET',
      success: function (response) {
        $("#cargando").hide();

        if (response.data.length === 0) {
          $('#historialContent').html('<p>No hay versiones registradas.</p>');
          return;
        }

        let html = `
        <div class="table-responsive">
          <table class="table table-striped">
            <thead >
              <tr>
                <th>ID</th>
                <th>Archivo</th>
                <th>Identificación</th>
                <th>Nombre del documento</th>
                <th>Estatus</th>
                <th>Versiones</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
      `;

        response.data.forEach((item, index) => {
          html += `
          <tr>
            <td>${index + 1}</td>
            <td>
              ${item.archivo
              ? `<i class="ri-file-pdf-2-fill text-danger ri-40px PDFDocFind cursor-pointer"
                  data-bs-toggle="modal"
                  data-bs-target="#mostrarPdf"
                  data-nombre="${item.nombre}"
                  data-url="/storage/${item.archivo}">
                </i>
                `
              : `<i class="ri-file-pdf-2-fill ri-24px icon-no-pdf"></i>`}
            </td>
            <td>${item.identificacion}</td>
            <td>${item.nombre}</td>
            <td>${item.estatus}</td>
            <td>${item.edicion}</td>
            <td>
              <button class="btn btn-sm btn-info edit-record-historial" data-id="${item.id}">
                <i class="ri-edit-box-line ri-20px me-1"></i> Editar
              </button>
            </td>
          </tr>
        `;
        });

        html += `</tbody></table></div>`;
        $('#historialContent').html(html);
      },
      error: function () {
        $("#cargando").hide();
        $('#historialContent').html('<p class="text-danger">No se pudo cargar el historial.</p>');
      }
    });
  });

  //FORMATO PDF REGISTRO DE PREDIO
  $(document).on('click', '.PDFDocFind', function () {
    var registro = $(this).data('nombre');
    var pdfUrl = $(this).data('url'); // <- Aquí tomas la URL directamente
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();
    $("#titulo_modal").text(registro);
    $("#subtitulo_modal").empty();

    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
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
        area: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el área'
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
        archivo_editable: {
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
      $('#btnRegistrarDoc').addClass('d-none')
      $('#loadingDoc').removeClass('d-none');

      $.ajax({
        url: '/documentos-procedimientos-upload',
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
          $('#loadingDoc').addClass('d-none');
          $('#btnRegistrarDoc').removeClass('d-none');
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
          $('#loadingDoc').addClass('d-none');
          $('#btnRegistrarDoc').removeClass('d-none');
        }
      });
    });
    // Inicializar select2 y revalidar el campo cuando cambie
    $('#doc_reviso, #doc_aprobo').on('change', function () {
      fv.revalidateField($(this).attr('name'));
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
          url: `${baseUrl}documentos-procedimientos/${id_doc}`,
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
      var id_doc = $(this).data('id');

      $.get('/documentos-procedimientos/' + id_doc + '/edit', function (data) {
        // Inputs
        $('#edit_id_doc_calidad').val(data.id_doc_calidad);
        $('#edit_nombre').val(data.nombre);
        $('#edit_identificacion').val(data.identificacion);
        $('#edit_area').val(data.area).trigger('change'); // para select
        $('#edit_edicion').val(data.edicion);
        /* $('#edit_fecha_edicion').val(data.fecha_edicion); */
        $('#edit_fecha_edicion').val(moment(data.fecha_edicion).format('YYYY-MM-DD'));
        $('#edit_estatus').val(data.estatus).trigger('change');

        // archivo (si ya existe)

        if (data.archivo) {
          $("#edit_archivo").removeAttr("required"); // no forzar cargar de nuevo
          $("#edit_archivo").next('small').remove();
          $("#edit_archivo").after(
            `<small class="text-muted">Archivo actual: <a href="/storage/${data.archivo}" target="_blank">Ver PDF</a></small>`
          );
        }

        $('#edit_modifico').val(data.modifico);
        $('#edit_reviso').val(data.reviso).trigger('change');
        $('#edit_aprobo').val(data.aprobo).trigger('change');

        // Mostrar el modal
        $('#modalEditHistorial').modal('show');
      }).fail(function () {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al obtener los datos del documento',
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
      const form = document.getElementById('formEditHistorial');
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
          area: {
            validators: {
              notEmpty: {
                message: 'Por favor seleccione el área'
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
          archivo_editable: {
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
        var formData = new FormData(form);
        $('#btnEditDoc').addClass('d-none');
        $('#loadingEdit').removeClass('d-none');

        var id_doc = $('#edit_id_doc_calidad').val();
        $.ajax({
          url: '/documentos-procedimientos/' + id_doc,
          type: 'POST',
          data: formData,
          processData: false, // IMPORTANTE: No procesar los datos
          contentType: false, // IMPORTANTE: Dejar que jQuery gestione el content-type
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            $('#modalEditHistorial').modal('hide');
            $('#formEditHistorial')[0].reset();

            $('#loadingEdit').addClass('d-none');
            $('#btnEditDoc').removeClass('d-none');

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
              text: 'Error al actualizar el documento',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
            $('#loadingEdit').addClass('d-none');
            $('#btnEditDoc').removeClass('d-none');
          }
        });
      });
      $('#edit_reviso, #edit_aprobo').on('change', function () {
        fv.revalidateField($(this).attr('name'));
      });

    });
  });




  //editar un campo de la tabla
  $(document).ready(function () {
    // Abrir el modal y cargar datos para editar
    $(document).on('click', '.edit-record-historial', function () {
      var id_doc = $(this).data('id');

      $.get('/documentos-procedimientos-historial/' + id_doc + '/edit', function (data) {
        // Inputs
        $('#edit_id').val(data.id);
        $('#edit_edit_nombre').val(data.nombre);
        $('#edit_edit_identificacion').val(data.identificacion);
        $('#edit_edit_area').val(data.area).trigger('change'); // para select
        $('#edit_edit_edicion').val(data.edicion);
        /* $('#edit_fecha_edicion').val(data.fecha_edicion); */
        $('#edit_edit_fecha_edicion').val(moment(data.fecha_edicion).format('YYYY-MM-DD'));
        $('#edit_edit_estatus').val(data.estatus).trigger('change');

        // archivo (si ya existe)
        if (data.archivo) {
          $("#edit_edit_archivo").removeAttr("required"); // no forzar cargar de nuevo

          // Eliminar aviso previo si existe
          $("#edit_edit_archivo").next('small').remove();

          // Agregar nuevo aviso
          $("#edit_edit_archivo").after(
            `<small class="text-muted">Archivo actual: <a href="/storage/${data.archivo}" target="_blank">Ver PDF</a></small>`
          );
        }


        $('#edit_edit_modifico').val(data.modifico);
        $('#edit_edit_reviso').val(data.reviso).trigger('change');
        $('#edit_edit_aprobo').val(data.aprobo).trigger('change');

        // Mostrar el modal
        $('#modalEditHistorialEdit').modal('show');
      }).fail(function () {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al obtener los datos del documento',
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
      const form = document.getElementById('formEditHistorialEdit');
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
          area: {
            validators: {
              notEmpty: {
                message: 'Por favor seleccione el área'
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
          archivo_editable: {
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
        var formData = new FormData(form);
        var id_doc = $('#edit_id').val();
        $.ajax({
          url: '/documentos-procedimientos-historial/' + id_doc,
          type: 'POST',
          data: formData,
          processData: false, // IMPORTANTE: No procesar los datos
          contentType: false, // IMPORTANTE: Dejar que jQuery gestione el content-type
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            $('#modalEditHistorialEdit').modal('hide');
            $('#formEditHistorialEdit')[0].reset();
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
              text: 'Error al actualizar el documento',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      });
      $('#edit_edit_reviso, #edit_edit_aprobo').on('change', function () {
        fv.revalidateField($(this).attr('name'));
      });

    });
  });

  $(document).ready(function () {
    // Guardamos todos los usuarios en un array desde los options originales
    var usuarios = [];
    $('#doc_reviso option[data-tipo]').each(function () {
      usuarios.push({
        id: $(this).val(),
        nombre: $(this).text(),
        tipo: $(this).data('tipo')
      });
    });

    $('#area').on('change', function () {
      var selectedArea = $(this).val(); // 1 = OC, 2 = UI
      var tipo = selectedArea == '1' ? 'OC' : (selectedArea == '2' ? 'UI' : '');

      // Limpiar opciones de usuarios pero conservar las dos primeras opciones
      $('#doc_reviso, #doc_aprobo').each(function () {
        $(this).find('option').not(':lt(2)').remove();
      });

      // Agregar usuarios según el tipo a ambos selects
      usuarios.forEach(function (user) {
        if (user.tipo == tipo) {
          $('#doc_reviso').append(`<option value="${user.id}" data-tipo="${user.tipo}">${user.nombre}</option>`);
          $('#doc_aprobo').append(`<option value="${user.id}" data-tipo="${user.tipo}">${user.nombre}</option>`);
        }
      });

      // Refrescar Select2 y seleccionar la opción por defecto
      $('#doc_reviso, #doc_aprobo').val('').trigger('change');
    });
  });



  $(document).ready(function () {
    // Guardamos todos los usuarios en un array desde los options originales
    var usuariosEdit = [];
    $('#edit_reviso option').each(function () {
      var tipo = $(this).data('tipo') || '';
      usuariosEdit.push({
        id: $(this).val(),
        nombre: $(this).text(),
        tipo: tipo
      });
    });

    $('#edit_area').on('change', function () {
      var selectedArea = $(this).val(); // 1 = OC, 2 = UI
      var tipo = selectedArea == '1' ? 'OC' : (selectedArea == '2' ? 'UI' : '');

      // Limpiar opciones pero conservar las dos primeras
      $('#edit_reviso, #edit_aprobo').each(function () {
        $(this).find('option').not(':lt(2)').remove();
      });

      // Agregar usuarios filtrados por tipo
      usuariosEdit.forEach(function (user) {
        if (user.tipo == tipo) {
          $('#edit_reviso').append(`<option value="${user.id}" data-tipo="${user.tipo}">${user.nombre}</option>`);
          $('#edit_aprobo').append(`<option value="${user.id}" data-tipo="${user.tipo}">${user.nombre}</option>`);
        }
      });

      // Refrescar Select2 y seleccionar opción por defecto
      $('#edit_reviso, #edit_aprobo').val('').trigger('change');
    });
  });


  $(document).ready(function () {
    // Guardamos todos los usuarios en un array desde los options originales
    var usuariosEditHist = [];
    $('#edit_edit_reviso option').each(function () {
      var tipo = $(this).data('tipo') || '';
      usuariosEditHist.push({
        id: $(this).val(),
        nombre: $(this).text(),
        tipo: tipo
      });
    });

    $('#edit_edit_area').on('change', function () {
      var selectedArea = $(this).val(); // 1 = OC, 2 = UI
      var tipo = selectedArea == '1' ? 'OC' : (selectedArea == '2' ? 'UI' : '');

      // Limpiar opciones pero conservar las dos primeras
      $('#edit_edit_reviso, #edit_edit_aprobo').each(function () {
        $(this).find('option').not(':lt(2)').remove();
      });

      // Agregar usuarios filtrados por tipo
      usuariosEditHist.forEach(function (user) {
        if (user.tipo == tipo) {
          $('#edit_edit_reviso').append(`<option value="${user.id}" data-tipo="${user.tipo}">${user.nombre}</option>`);
          $('#edit_edit_aprobo').append(`<option value="${user.id}" data-tipo="${user.tipo}">${user.nombre}</option>`);
        }
      });

      // Refrescar Select2 y seleccionar opción por defecto
      $('#edit_edit_reviso, #edit_edit_aprobo').val('').trigger('change');
    });
  });


});
