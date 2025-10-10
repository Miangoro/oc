/**
 * Lista de clientes prospecto
 */

'use strict';
// Declaras el arreglo de botones
let buttons = [];

// Si tiene permiso, agregas el botón
if (puedeAgregarUsuario) {
  buttons.push({
    text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar cliente prospecto</span>',
    className: 'add-new btn btn-primary waves-effect waves-light',
    attr: {
      'data-bs-toggle': 'modal',
      'data-bs-target': '#AddClientesConfirmados'
    }
  });
}
// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#offcanvasValidarSolicitud');

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
        url: baseUrl + 'empresas-list'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'razon_social' },
        { data: 'domicilio_fiscal' },
        { data: 'regimen' },
        { data: 'regimen' },
        { data: 'id_empresa' },
        { data: '' },
        { data: 'action' }
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
          // Es la razón social
          targets: 2,
          render: function (data, type, full, meta) {
            var $name = full['razon_social'];

            // For Avatar badge
            var stateNum = Math.floor(Math.random() * 6);
            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
            var $state = states[stateNum];
            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center user-name">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar avatar-sm me-3">' +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<a href="' +
              userView +
              '" class="text-truncate text-heading"><span class="fw-medium">' +
              $name +
              '</span></a>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // User email
          targets: 3,
          render: function (data, type, full, meta) {
            var $email = full['domicilio_fiscal'];
            return '<span class="user-email">' + $email + '</span>';
          }
        },

        {
          // email verify
          targets: 4,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $verified = full['regimen'];
            if ($verified == 'Persona física') {
              var $colorRegimen = 'info';
            } else {
              var $colorRegimen = 'warning';
            }
            return `${
              $verified
                ? '<span class="badge rounded-pill  bg-label-' + $colorRegimen + '">' + $verified + '</span>'
                : '<span class="badge rounded-pill  bg-label-' + $colorRegimen + '">' + $verified + '</span>'
            }`;
          }
        },
        {
          targets: 5,
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            var normas = full['normas'] || [];
            if (!Array.isArray(normas) || normas.length === 0) {
              return '<span class="text-muted">N/A</span>';
            }

            return normas
              .map(function (norma) {
                return '<div class="badge bg-secondary me-1">' + norma.norma + '</div>';
              })
              .join('');
          }
        },
        {
          targets: 6,
          className: 'text-center',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            var idEmpresa = full['id_empresa'];
            var normas = full['normas'] || [];
            if (normas.length === 0) {
              return '<i class="ri-file-damage-fill ri-40px icon-no-pdf"></i>';
            }

            // Usar id si está disponible
            //var tieneNorma4 = normas.some(n => n.id_norma == 4);

            // O comparar por nombre si no hay id
            var tieneNorma4 = normas.some(n => n.norma === 'NOM-199-SCFI-2017');

            var clase = tieneNorma4 ? 'pdf2' : 'pdf';

            return `<i class="ri-file-pdf-2-fill text-danger ri-40px ${clase} cursor-pointer"
                     data-bs-target="#mostrarPdf"
                     data-bs-toggle="modal"
                     data-bs-dismiss="modal"
                     data-id="${idEmpresa}"
                     data-registro="${full['razon_social']}"></i>`;
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

            // Acciones que SIEMPRE se deben mostrar
            acciones += `
              <a data-id="${full['id_empresa']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasValidarSolicitud" href="javascript:;" class="dropdown-item validar-solicitud">
                <i class="text-info ri-search-eye-line"></i> Validar solicitud
              </a>
              <a data-id="${full['id_empresa']}" data-regimen="${full['regimen']}"  data-bs-toggle="modal" data-bs-dismiss="modal" onclick="abrirModal(${full['id_empresa']})" href="javascript:;" class="cursor-pointer dropdown-item validar-solicitud2">
                <i class="text-success ri-checkbox-circle-fill"></i> Aceptar cliente
              </a>
               <a data-id="${full['id_empresa']}" data-bs-toggle="modal" data-bs-target="#modalSubirDocumentacion" href="javascript:;" class="dropdown-item subir-docs">
                <i class="text-primary ri-file-upload-fill"></i> Subir documentación
              </a>
            `;
            // Acción condicional: Editar
            if (window.puedeEditarUsuario) {
              acciones += `
                <a data-id="${full['id_empresa']}" data-bs-toggle="modal" data-bs-target="#editCLientesProspectos" class="dropdown-item edit-record waves-effect text-warning">
                  <i class="text-warning ri-edit-fill"></i> Editar
                </a>
              `;
            }
            // Siempre mostrar el dropdown, porque hay acciones obligatorias
            return `
              <div class="d-flex align-items-center gap-50">
                <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end m-0">
                  ${acciones}
                </div>
              </div>
            `;
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
        emptyTable: 'No hay datos disponibles en la tabla',
        paginate: {
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior'
        }
      },
      // Buttons with Dropdown
      buttons: buttons /* [ */,

      /*         {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
          text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
          buttons: [
            {
              extend: 'print',
              title: 'Users',
              text: '<i class="ri-printer-line me-1" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
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
              title: 'Users',
              text: '<i class="ri-file-text-line me-1" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'excel',
              title: 'Users',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              title: 'Users',
              text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'copy',
              title: 'Users',
              text: '<i class="ri-file-copy-line me-1"></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be copy
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            }
          ]
        } */
      /*  ], */
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['razon_social'];
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

  // Delete Record
  $(document).on('click', '.delete-record', function () {
    var user_id = $(this).data('empresa_id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // sweetalert for confirmation of delete
    Swal.fire({
      title: '¿Está seguro?',
      text: 'No podrá revertir este evento',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Si, eliminar',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // delete the data
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}empresas-list/${id_empresa}`,
          success: function () {
            dt_user.draw();
          },
          error: function (error) {
            console.log(error);
          }
        });

        // success sweetalert
        Swal.fire({
          icon: 'success',
          title: '¡Eliminado!',
          text: '¡La solicitud ha sido eliminada correctamente!',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La solicitud no ha sido eliminada',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  $(document).on('click', '.pdf', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var iframe = $('#pdfViewer');
    // Mostrar el spinner y ocultar el iframe
    $('#cargando').show();
    iframe.hide();

    iframe.attr('src', '../solicitudinfo_cliente/' + id);
    var url = '../solicitudinfo_cliente/' + id;

    $('#NewPestana').attr('href', url);

    $('#titulo_modal').text('Solicitud de información del cliente');
    $('#subtitulo_modal').text(registro);
    $('#mostrarPdf').modal('show');
  });

  // Ocultar el spinner cuando el PDF esté completamente cargado
  $('#pdfViewer').on('load', function () {
    $('#cargando').hide(); // Ocultar el spinner
    $(this).show(); // Mostrar el iframe con el PDF
  });

  $(document).on('click', '.pdf2', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var iframe = $('#pdfViewer');
    // Mostrar el spinner y ocultar el iframe
    $('#cargando').show();
    iframe.hide();

    iframe.attr('src', '../solicitudInfoClienteNOM-199/' + id);
    var url = '../solicitudInfoClienteNOM-199/' + id;

    $('#NewPestana').attr('href', url);

    $('#titulo_modal').text('Solicitud de información del cliente');
    $('#subtitulo_modal').text(registro);
    $('#mostrarPdf').modal('show');
  });

  // Ocultar el spinner cuando el PDF esté completamente cargado
  $('#pdfViewer').on('load', function () {
    $('#cargando').hide(); // Ocultar el spinner
    $(this).show(); // Mostrar el iframe con el PDF
  });

  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición de cliente
    const form = document.getElementById('editClienteForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        nombre_cliente: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el nombre del cliente.'
            }
          }
        },
        regimen: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el régimen del cliente.'
            }
          }
        },
        domicilio_fiscal: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el domicilio fiscal.'
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
      var clienteid = $('#edit_id_cliente').val();

      $.ajax({
        url: '/clientes/' + clienteid + '/update',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          // Recargar la tabla de clientes
          dt_user.ajax.reload();
          // Cerrar el modal
          $('#editClientesProspectos').modal('hide');
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
          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            var errorMessages = Object.keys(errors)
              .map(function (key) {
                return errors[key].join('<br>');
              })
              .join('<br>');

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
              text: 'Ha ocurrido un error al actualizar el cliente.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        }
      });
    });

    $(document).on('click', '.edit-record', function () {
      var id = $(this).data('id');
      $('#edit_id_cliente').val(id);
      $.ajax({
        url: '/clientes-list/' + id + '/edit',
        method: 'GET',
        success: function (data) {
          if (data.error) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.error,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
            return;
          }
          $('#edit_nombre_cliente').val(data.razon_social);
          $('#edit_regimen').val(data.regimen).trigger('change');
          $('#edit_domicilio_fiscal').val(data.domicilio_fiscal);
          $('#editClientesProspectos').modal('show');
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar los datos del cliente.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

  // Validar solicitud
  $(document).on('click', '.validar-solicitud', function () {
    var id_empresa = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }
    // changing the title of offcanvas
    //  $('#offcanvasAddUserLabel').html('Edit User');
    $('#empresa_id').val(id_empresa);
  });

  // aceptar cliente
  /*   $(document).on('click', '.validar-solicitud2', function () {
    var id_empresa = $(this).data('id');
    $('#empresaID').val(id_empresa);
  }); */
  $(document).on('click', '.validar-solicitud2', function () {
    var id_empresa = $(this).data('id');
    var regimen = $(this).data('regimen');

    $('#empresaID').val(id_empresa);
    $('#regimenTipo').val(regimen);
    $('.info-contrat').html('');
    // Mostrar bloque según el régimen
    if (regimen === 'Persona moral') {
      $('.persona_moral').removeClass('d-none');
      $('.persona_fisica').addClass('d-none');
      $('.info-contrat').html(
        'Información para el contrato <span class="badge rounded-pill bg-label-warning">Persona moral</span>'
      );
    } else if (regimen === 'Persona física') {
      $('.info-contrat').html(
        'Información para el contrato <span class="badge rounded-pill bg-label-info">Persona física</span>'
      );
      $('.persona_fisica').removeClass('d-none');
      $('.persona_moral').addClass('d-none');
    }
  });

  // changing the title
  $('.add-new').on('click', function () {
    $('#user_id').val(''); //reseting input field
    $('#offcanvasAddUserLabel').html('Add User');
  });

  // validating form and updating user's data
  const addNewUserForm = document.getElementById('addNewUserForm');

  // Validación del formulario de Validación de solicitud
  const fv = FormValidation.formValidation(addNewUserForm, {
    fields: {
      medios: {
        validators: {
          notEmpty: {
            message: 'Por favor selecciona una opción.'
          }
        }
      },
      competencia: {
        validators: {
          notEmpty: {
            message: 'Por favor selecciona una opción.'
          }
        }
      },
      capacidad: {
        validators: {
          notEmpty: {
            message: 'Por favor selecciona una opción.'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        eleValidClass: '',
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          return '.mb-5';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // adding or updating user when form successfully validate
    $('#btnAddV').addClass('d-none');
    $('#btnSpinnerV').removeClass('d-none');
    $.ajax({
      data: $('#addNewUserForm').serialize(),
      url: `${baseUrl}empresas-list`,
      type: 'POST',
      success: function (status) {
        dt_user.draw();
        offCanvasForm.offcanvas('hide');
        $('#btnSpinnerV').addClass('d-none');
        $('#btnAddV').removeClass('d-none');
        // sweetalert
        Swal.fire({
          icon: 'success',
          title: `${status} Exitosamente`,
          text: `Solicitud ${status} Exitosamente.`,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function (err) {
        offCanvasForm.offcanvas('hide');
        let mensaje = 'Ocurrió un error inesperado.'; // Mensaje por defecto
        if (err.responseJSON && err.responseJSON.message) {
          mensaje = err.responseJSON.message; // Mensaje del backend
        }
        Swal.fire({
          title: '¡Error!',
          text: mensaje,
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
        $('#btnSpinnerV').addClass('d-none');
        $('#btnAddV').removeClass('d-none');
      }
    });
  });

  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    const addNewCliente = document.getElementById('addNewCliente');
    const fv2 = FormValidation.formValidation(addNewCliente, {
      fields: {
        id_contacto: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una opción'
            }
          }
        },
        // Persona física
        fecha_cedula: {
          validators: {
            callback: {
              message: 'Por favor selecciona la fecha de cédula.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona física' ? input.value.trim() !== '' : true;
              }
            }
          }
        },
        idcif: {
          validators: {
            callback: {
              message: 'Por favor ingresa el idCIF.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona física' ? input.value.trim() !== '' : true;
              }
            }
          }
        },
        clave_ine: {
          validators: {
            callback: {
              message: 'Por favor ingresa la clave INE.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona física' ? input.value.trim() !== '' : true;
              }
            }
          }
        },

        // Persona moral
        sociedad_mercantil: {
          validators: {
            callback: {
              message: 'Por favor selecciona una sociedad mercantil.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona moral' ? input.value.trim() !== '' : true;
              }
            }
          }
        },
        num_instrumento: {
          validators: {
            callback: {
              message: 'Por favor ingresa el número de instrumento.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona moral' ? input.value.trim() !== '' : true;
              }
            }
          }
        },
        vol_instrumento: {
          validators: {
            callback: {
              message: 'Por favor ingresa el volumen del instrumento.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona moral' ? input.value.trim() !== '' : true;
              }
            }
          }
        },
        fecha_instrumento: {
          validators: {
            callback: {
              message: 'Por favor selecciona la fecha del instrumento.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona moral' ? input.value.trim() !== '' : true;
              }
            }
          }
        },
        nombre_notario: {
          validators: {
            callback: {
              message: 'Por favor ingresa el nombre del notario.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona moral' ? input.value.trim() !== '' : true;
              }
            }
          }
        },
        num_notario: {
          validators: {
            callback: {
              message: 'Por favor ingresa el número del notario.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona moral' ? input.value.trim() !== '' : true;
              }
            }
          }
        },
        estado_notario: {
          validators: {
            callback: {
              message: 'Por favor ingresa el estado del notario.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona moral' ? input.value.trim() !== '' : true;
              }
            }
          }
        },
        num_permiso: {
          validators: {
            callback: {
              message: 'Por favor ingresa el número de permiso.',
              callback: function (input) {
                return $('#regimenTipo').val() === 'Persona moral' ? input.value.trim() !== '' : true;
              }
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.col-12, .col-md-6, .col-md-12, .col-md-4',
          excluded: ':hidden' // <-- Esta línea es la clave para ignorar campos ocultos
        }),

        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      $('#btnAdd').addClass('d-none');
      $('#btnSpinner').removeClass('d-none');
      $.ajax({
        data: $('#addNewCliente').serialize(),
        url: `${baseUrl}aceptar-cliente`,
        type: 'POST',
        success: function (status) {
          dt_user.draw();
          $('#btnSpinner').addClass('d-none');
          $('#btnAdd').removeClass('d-none');
          $('#aceptarCliente').modal('hide');
          Swal.fire({
            icon: 'success',
            title: `Aceptado`,
            text: `Cliente aceptado exitosamente.`,
            customClass: { confirmButton: 'btn btn-success' }
          });
        },
        error: function (xhr) {
          $('#btnSpinner').addClass('d-none');
          $('#btnAdd').removeClass('d-none');

          if (xhr.status === 422) {
            // Errores de validación de Laravel
            const errors = xhr.responseJSON.errors;
            let errorMessages = '';
            for (const key in errors) {
              if (errors.hasOwnProperty(key)) {
                errorMessages += errors[key].join('<br>') + '<br>';
              }
            }
            Swal.fire({
              icon: 'error',
              title: 'Errores de validación',
              html: errorMessages,
              customClass: { confirmButton: 'btn btn-danger' }
            });
          } else {
            // Otro tipo de error
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Ocurrió un error al procesar la solicitud.',
              customClass: { confirmButton: 'btn btn-danger' }
            });
          }
        }
      });
    });

    // Evento al abrir modal
    $(document).on('click', '.validar-solicitud2', function () {
      var id_empresa = $(this).data('id');
      var regimen = $(this).data('regimen') || 'Persona física';

      $('#empresaID').val(id_empresa);
      $('#regimenTipo').val(regimen);

      actualizarSeccionRegimen(regimen);
    });

    // Cambiar vista y validación según régimen
    function actualizarSeccionRegimen(regimen) {
      if (regimen === 'Persona moral') {
        $('.persona_moral').removeClass('d-none');
        $('.persona_fisica').addClass('d-none');
        $('.info-contrat').html(
          'Información para el contrato <span class="badge rounded-pill bg-label-warning">Persona moral</span>'
        );
      } else {
        $('.persona_fisica').removeClass('d-none');
        $('.persona_moral').addClass('d-none');
        $('.info-contrat').html(
          'Información para el contrato <span class="badge rounded-pill bg-label-info">Persona física</span>'
        );
      }
      /*   fv2.revalidateField('fecha_cedula');
      fv2.revalidateField('idcif');
      fv2.revalidateField('clave_ine');
      fv2.revalidateField('sociedad_mercantil');
      fv2.revalidateField('num_instrumento');
      fv2.revalidateField('vol_instrumento');
      fv2.revalidateField('fecha_instrumento');
      fv2.revalidateField('nombre_notario');
      fv2.revalidateField('num_notario');
      fv2.revalidateField('estado_notario');
      fv2.revalidateField('num_permiso'); */
    }

    // Limpiar formulario al cerrar modal
    $('#aceptarCliente').on('hidden.bs.modal', function () {
      fv2.resetForm(true);
      $('#regimenTipo').val('Persona física');
      actualizarSeccionRegimen('Persona física');
    });
  });

  const phoneMaskList = document.querySelectorAll('.phone-mask');

  // Phone Number
  if (phoneMaskList) {
    phoneMaskList.forEach(function (phoneMask) {
      new Cleave(phoneMask, {
        phone: true,
        phoneRegionCode: 'US'
      });
    });
  }

  //AGREGAR CLIENTES CONFIRMADOS
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('ClientesConfirmadosForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        razon_social: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el nombre del cliente/empresa'
            }
          }
        },
        regimen: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el régimen'
            }
          }
        },
        correo: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el correo electrónico'
            }
            /* emailAddress: {
              message: 'Por favor ingrese un correo electrónico válido'
            },
            regexp: {
              regexp: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
              message: 'Por favor ingrese un correo electrónico en un formato válido'
            }*/
          }
        },
        domicilio_fiscal: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el domicilio fiscal'
            }
          }
        },
        telefono: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de teléfono'
            },
            stringLength: {
              min: 10,
              max: 15,
              message: 'El teléfono debe tener entre 10 y 15 caracteres (incluidos espacios y otros caracteres)'
            },
            regexp: {
              regexp: /^[0-9\s\-\(\)]+$/,
              message: 'El teléfono debe contener solo números, espacios, guiones y paréntesis'
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
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    });
    // Escuchar el cambio en el campo #regimen
    /*     $('#regimen').on('change', function () {
      var tipoPersona = $(this).val();

      if (tipoPersona === 'Persona moral') {
        $('#MostrarRepresentante').removeClass('d-none');
        $('#EstadosClass').removeClass('col-md-6').addClass('col-md-4');
        fv.enableValidator('representante');
      } else {
        $('#MostrarRepresentante').addClass('d-none');
        $('#EstadosClass').removeClass('col-md-4').addClass('col-md-6');
        fv.disableValidator('representante');
      }
    }); */

    fv.on('core.form.valid', function () {
      var formData = new FormData(form);
      $.ajax({
        url: '/registrar-clientes-prospectos',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#AddClientesConfirmados').modal('hide');
          $('#ClientesConfirmadosForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-users').DataTable().ajax.reload();

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.message,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
          $('#ClientesConfirmadosForm')[0].reset();
        },
        error: function (xhr) {
          console.log('Error:', xhr.responseText);

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar el cliente',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    // Inicializar select2 y revalidar campos dinámicos
    /*  $('#estado, #normas, #actividad').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    }); */
  });

  $(document).ready(function () {
    // Se activa cuando se hace clic en cualquier botón con la clase .subir-docs
    $(document).on('click', '.subir-docs', function () {
      var prospectoId = $(this).data('id');
      $('#prospecto_id_doc').val(prospectoId);

      // Buscamos el tbody dentro del modal
      var modalTbody = $('#modalSubirDocumentacion').find('tbody');

      // 1. Limpiamos todos los enlaces (sin mostrar nada)
      modalTbody.find('a').each(function () {
        $(this).removeAttr('href').html('-----'); // no mostrar ícono ni texto
      });

      // 2. Hacemos la llamada AJAX
      $.ajax({
        url: '/obtener-documentos-empresa/' + prospectoId,
        type: 'GET',
        success: function (response) {
          // response = { "1": "ruta/archivo1.pdf", "2": null, "3": "ruta/archivo3.pdf" }

          for (const docId in response) {
            const url = response[docId];

            if (url) {
              // solo si existe documento
              const inputElement = modalTbody.find('input[name="documentos[' + docId + ']"]');

              if (inputElement.length) {
                const link = inputElement.closest('tr').find('a');
                const fullUrl = '/storage/' + url;

                // Mostrar el ícono PDF con enlace activo
                link
                  .attr('href', fullUrl)
                  .attr('target', '_blank')
                  .html('<i class="ri-file-pdf-2-fill text-danger ri-40px"></i>');
              }
            }
          }
        },
        error: function (err) {
          console.error('Error al cargar los documentos:', err);
        }
      });
    });
  });

  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // --- SCRIPT PARA SUBIR DOCUMENTACIÓN ---

    // 1. Capturar el ID del prospecto al abrir el modal
    $(document).on('click', '.subir-docs', function () {
      var prospectoId = $(this).data('id');
      $('#prospecto_id_doc').val(prospectoId);
    });

    // 2. Manejar el clic del botón "Guardar Documentos"
    $('#btnGuardarDocumentacion').on('click', function (e) {
      e.preventDefault(); // Evitar el envío tradicional del formulario

      var form = $('#formDocumentacionProspecto')[0];
      var formData = new FormData(form);
      var prospectoId = $('#prospecto_id_doc').val();
      formData.append('prospecto_id', prospectoId); // Asegurarse que el ID vaya en la petición

      // Mostrar un loader mientras se suben los archivos

  // NO RECOMENDADO
    Swal.fire({
      title: 'Subiendo documentos...',
      text: 'Por favor, espere.',
      customClass: {
        confirmButton: 'd-none' // <-- Esto aplicaría display: none;
      },
          didOpen: () => {
          Swal.showLoading();
        }

    });

      $.ajax({
        url: '/registrar-documentos-prospecto/' + prospectoId, // URL para guardar los documentos
        type: 'POST',
        data: formData,
        processData: false, // Necesario para FormData
        contentType: false, // Necesario para FormData
        success: function (response) {
          $('#modalSubirDocumentacion').modal('hide');
          $('#formDocumentacionProspecto')[0].reset();
          $('.datatables-users').DataTable().ajax.reload();

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Documentos guardados correctamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr) {
          console.log('Error:', xhr.responseText);

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Ocurrió un error al subir los documentos.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    // Limpiar el formulario cuando el modal se cierra
    $('#modalSubirDocumentacion').on('hidden.bs.modal', function () {
      $('#formDocumentacionProspecto')[0].reset();
      $('#prospecto_id_doc').val('');
    });
  });
});
