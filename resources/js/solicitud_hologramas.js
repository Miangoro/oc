/**
 * Page User List
 */

'use strict';

// Agregar nuevo registro
// validating form and updating user's data
const addHologramasForm = document.getElementById('addHologramasForm');

// Validación del formulario
const fv = FormValidation.formValidation(addHologramasForm, {
  fields: {
    folio: {
      validators: {
        notEmpty: {
          message: 'Por favor introduzca un folio'
        }
      }
    },
    id_empresa: {
      validators: {
        notEmpty: {
          message: 'Por favor seleccione un cliente'
        }
      }
    },
    id_marca: {
      validators: {
        notEmpty: {
          message: 'Por favor ingrese una marca'
        }
      }
    },
    id_solicitante: {
      validators: {
        notEmpty: {
          message: 'falta el ID del usuario'
        }
      }
    },
    cantidad_hologramas: {
      validators: {
        notEmpty: {
          message: 'Por favor ingrese el numero de hologramas solicitados'
        }
      }
    },
    id_direccion: {
      validators: {
        notEmpty: {
          message: 'Por favor ingrese un destino de lote'
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
  //e.preventDefault();
  var formData = new FormData(addHologramasForm);

  $.ajax({
    url: '/hologramas/store', // Actualiza con la URL correcta
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      $('#addHologramas').modal('hide');
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
        text: 'Error al registrar el lote envasado',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    }
  });
});



$(function () {
  // Datatable (jquery)
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#addHologramas');

  // Función para inicializar Select2 en elementos específicos
  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      select2Focus($this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Selecciona una opcion',
        dropdownParent: $this.parent()
      });
    });
  }

  // Inicialización de Select2 para elementos con clase .select2
  initializeSelect2(select2Elements);


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
        url: baseUrl + 'hologramas-list'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id_solicitud' },
        { data: 'folio' },
        { data: 'razon_social' },
        { data: 'id_solicitante' },
        { data: 'id_marca' },
        { data: 'cantidad_hologramas' },
        { data: 'id_direccion' },
        { data: 'folio_inicial' },
        { data: 'folio_final' },
        { data: 'estatus' },
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
          // User full name
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full['folio'];

            // For Avatar badge
            var stateNum = Math.floor(Math.random() * 6);
            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
            var $state = states[stateNum];

            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center user-name">' +
              '<div class="avatar-wrapper">' +
              /*               '<div class="avatar avatar-sm me-3">' + */

              '</d iv>' +
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
        /*          {
                  // User email
                  targets: 6,
                  render: function (data, type, full, meta) {
                    var $email = full['cantidad_hologramas'];
                    return '<span class="user-email">' + $email + '</span>';
                  }
                },  */
        {
          // email verify
          targets: 10,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $verified = full['estatus'];
            var $colorRegimen;

            if ($verified == 'Enviado') {
              $colorRegimen = 'info'; // Azul
            } else if ($verified == 'Pagado') {
              $colorRegimen = 'warning'; // Naranja
            } else if ($verified == 'Pendiente') {
              $colorRegimen = 'danger'; // Rojo
            } else if ($verified == 'Asignado') {
              $colorRegimen = 'secondary'; // Verde
            } else if ($verified == 'Completado') {
              $colorRegimen = 'success'; // Verde
            } else {
              $colorRegimen = 'secondary'; // Color por defecto si no coincide con ninguno
            }

            return `${$verified
              ? '<span class="badge rounded-pill bg-label-' + $colorRegimen + '">' + $verified + '</span>'
              : '<span class="badge rounded-pill bg-label-' + $colorRegimen + '">' + $verified + '</span>'
              }`;
          }
        },

        {
          // email verify
          targets: 11,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $id = full['id_solicitud'];
            return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="${full['id_solicitud']}" data-registro="${full['razon_social']} "></i>`;
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center gap-50">' +
              '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              // Asumiendo que este es el código que ya tienes configurado
/*               `<a id="activar_holograma" data-id="${full['id_solicitud']}" href="javascript:;" class="dropdown-item activar_holograma"><i class="ri-qr-scan-2-line ri-20px text-primary"></i> Activar hologramas</a>` +
 */              `<a id="activar_holograma" data-id="${full['id_solicitud']}" data-bs-toggle="modal" data-bs-target="#activarHologramas" href="javascript:;" class="dropdown-item activar_holograma"><i class="ri-qr-scan-2-line ri-20px text-primary"></i> Activar hologramas</a>` +
              `<a data-id="${full['id_solicitud']}" data-bs-toggle="modal" data-bs-target="#addRecepcion" href="javascript:;" class="dropdown-item edit-recepcion"><i class="ri-article-fill ri-20px text-secondary"></i> Recepción hologramas</a>` +
              `<a data-id="${full['id_solicitud']}" data-bs-toggle="modal" data-bs-target="#addEnvio" href="javascript:;" class="dropdown-item edit-envio"><i class="ri-send-plane-fill ri-20px text-success"></i> Enviar</a>` +
              `<a data-id="${full['id_solicitud']}" data-bs-toggle="modal" data-bs-target="#asignarHolograma" href="javascript:;" class="dropdown-item edit-signar"><i class="ri-qr-scan-fill ri-20px text-dark"></i> Asignar hologramas</a>` +
              `<a data-id="${full['id_solicitud']}" data-bs-toggle="modal" data-bs-target="#addPago" href="javascript:;" class="dropdown-item edit-pay"><i class="ri-bank-card-line ri-20px text-warning"></i> Adjuntar comprobante de pago</a>` +
              `<a data-id="${full['id_solicitud']}" data-bs-toggle="modal" data-bs-target="#editHologramas" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar solicitud</a>` +
              `<a data-id="${full['id_solicitud']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar solicitud</a>` +
/*               '<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line ri-20px"></i></button>' +
 */              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              '<a href="' +
              userView +
              '" class="dropdown-item">View</a>' +
              '<a href="javascript:;" class="dropdown-item">Suspend</a>' +
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



      // Exportar crud en documentos
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
          text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
          buttons: [
            {
              extend: 'print',
              title: 'Categorías de Agave',
              text: '<i class="ri-printer-line me-1" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
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
                columns: [1, 2, 3, 4, 5, 6, 7],
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
              title: 'Categorías de Agave',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
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
              title: 'Categorías de Agave',
              text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],                // prevent avatar to be display
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
              title: 'Categorías de Agave',
              text: '<i class="ri-file-copy-line me-1"></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
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
        },
        {
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Solicitud</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#addHologramas'
          }
        }
      ],
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

  // Eliminar registro
  $(document).on('click', '.delete-record', function () {
    var id_solicitud = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // sweetalert for confirmation of delete
    Swal.fire({
      title: '¿Está seguro?',
      text: "No podrá revertir este evento",
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
          url: `${baseUrl}hologramas-list/${id_solicitud}`,
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


  //Reciben los datos del pdf
  $(document).on('click', '.pdf', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var iframe = $('#pdfViewer');
    iframe.attr('src', '../solicitud_de_holograma/' + id);

    $("#titulo_modal").text("Solicitud de entrega de hologramas");
    $("#subtitulo_modal").text(registro);


  });


  // Editar registro
  // Editar registro
  $(document).on('click', '.edit-record', function () {
    var id_solicitud = $(this).data('id');

    $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {
      // Rellenar el formulario con los datos obtenidos
      $('#editt_id_solicitud').val(data.id_solicitud);

      $('#edit_folio').val(data.folio);
      $('#edit_id_empresa').val(data.id_empresa).trigger('change');
      $('#edit_id_marca').val(data.id_marca).trigger('change');
      $('#edit_id_solicitante').val(data.id_solicitante);
      $('#edit_cantidad_hologramas').val(data.cantidad_hologramas);
      $('#edit_id_direccion').val(data.id_direccion).trigger('change');
      $('#edit_comentarios').val(data.comentarios);

      // Mostrar el modal de edición
      $('#editHologramas').modal('show');
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de la solicitud de holograma',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });

  const editHologramasForm = document.getElementById('editHologramasForm');

  // Validación del formulario
  const fv = FormValidation.formValidation(editHologramasForm, {
    fields: {
      edit_folio: {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca un folio'
          }
        }
      },
      edit_id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un cliente'
          }
        }
      },
      edit_id_marca: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese una marca'
          }
        }
      },
      edit_cantidad_hologramas: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de hologramas solicitados'
          }
        }
      },
      edit_id_direccion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una dirección'
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
  }).on('core.form.valid', function () {
    var formData = new FormData(editHologramasForm);
    var id_solicitud = $('#edit_id_solicitud').val(); // Obtiene el ID de la solicitud

    $.ajax({
      url: '/solicitud_holograma/update/', // URL de la ruta de actualización
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Solicitud actualizada correctamente',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        }).then(function () {
          $('#editHologramas').modal('hide'); // Cierra el modal de edición
          $('.datatables-users').DataTable().ajax.reload(); // Recarga la tabla de datos
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error: ' + textStatus + ' - ' + errorThrown);
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al actualizar la solicitud',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });




  //pago metodo
  $(document).on('click', '.edit-pay', function () {
    var id_solicitud = $(this).data('id');

    $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {
      // Rellenar el formulario con los datos obtenidos
      $('#edit_id_solicitud').val(data.id_solicitud);

      $('#tipo_pago').val(data.tipo_pago);
      $('#empresa').val(data.id_empresa);
      // Mostrar el modal de edición
      $('#addPago').modal('show');
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de la solicitud de holograma',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });

  /*    $('#addEnvioForm').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    console.log()

    $.ajax({
      url: '/solicitud_holograma/update3',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
          title: 'Éxito',
          text: response.success,
          icon: 'success',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
        $('#addEnvio').modal('hide');
        $('.datatables-users').DataTable().ajax.reload();
      },
      error: function (response) {
        console.log(response);

        Swal.fire({
          title: 'Error',
          text: 'Ocurrió un error al actualizar la guía.',
          icon: 'error',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  }); */


  // Selección del formulario
  const addPagoForm = document.getElementById('addPagoForm');

  // Validación del formulario
  const fv2 = FormValidation.formValidation(addPagoForm, {
    fields: {
      tipo_pago: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un tipo de pago'
          }
        }
      },
      'url[]': {
        validators: {
          notEmpty: {
            message: 'Por favor adjunte un comprobante de pago'
          },
          file: {
            extension: 'pdf,doc,docx,jpg,jpeg,png',
            type: 'application/pdf,application/msword,image/jpeg,image/png',
            maxSize: 5242880, // 5 MB
            message: 'El archivo adjunto debe ser un documento válido (PDF, DOC, JPG, PNG) y no mayor de 5MB'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: function (field, ele) {
          return '.mb-4, .mb-5'; // Ajusta según las clases de tus elementos
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // Se ejecuta cuando el formulario es válido
    var formData = new FormData(addPagoForm);

    $.ajax({
      url: '/solicitud_holograma/update2',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#addPago').modal('hide');
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
          text: 'Ocurrió un error al actualizar el pago.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });






  //envio metodo
  $(document).on('click', '.edit-envio', function () {
    var id_solicitud = $(this).data('id');

    $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {


      // Rellenar el formulario con los datos obtenidos
      $('#edit_id_solicitud2').val(data.id_solicitud);

      $('#fecha_envio').val(data.fecha_envio);
      $('#costo_envio').val(data.costo_envio);
      $('#no_guia').val(data.no_guia);
      $('#empresa2').val(data.id_empresa);
      // Mostrar el modal de edición
      $('#addEnvio').modal('show');
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de la solicitud de holograma',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });

  // Validar el formulario y enviar los datos de envío
  const addEnvioForm = document.getElementById('addEnvioForm');

  const fv3 = FormValidation.formValidation(addEnvioForm, {
    fields: {
      fecha_envio: {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca la fecha de envío'
          }
        }
      },
      costo_envio: {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca el costo de envío'
          },
          numeric: {
            message: 'El costo de envío debe ser un número válido'
          }
        }
      },
      no_guia: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de guía'
          }
        }
      },
      'url[]': {
        validators: {
          notEmpty: {
            message: 'Por favor adjunte el comprobante de pago'
          },
          file: {
            extension: 'pdf,doc,docx,jpg,jpeg,png',
            type: 'application/pdf,application/msword,image/jpeg,image/png',
            maxSize: 5242880, // 5 MB
            message: 'El archivo adjunto debe ser un documento válido (PDF, DOC, JPG, PNG) y no mayor de 5MB'
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
    // Prevenir el comportamiento predeterminado

    var formData = new FormData(addEnvioForm);

    $.ajax({
      url: '/solicitud_holograma/update3', // URL de la acción de actualización
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar el modal al éxito
        $('#addEnvio').modal('hide');
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
          text: 'Ocurrió un error al actualizar la guía.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });





  //asignar holograms
  $(document).on('click', '.edit-signar', function () {
    var id_solicitud = $(this).data('id');

    $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {


      // Rellenar el formulario con los datos obtenidos
      $('#id_solicitudAsignar').val(data.id_solicitud);

      $('#asig_folio_inicial').val(data.folio_inicial);
      $('#asig_folio_final').val(data.folio_final);
      $('#empresaAsignar').val(data.id_empresa);
      // Mostrar el modal de edición
      $('#asignarHolograma').modal('show');
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de la solicitud de holograma',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });

  $(document).ready(function () {
    $('#folio_inicial, #folio_final').on('input', function () {
      var folioInicial = $('#folio_inicial').val();
      var folioFinal = $('#folio_final').val();

      var id_solicitud = $('#id_solicitudActivacion').val();


      // Solo ejecutar si ambos campos tienen valor
      if (folioInicial && folioFinal) {
        $.ajax({
          url: '/verificar-folios',
          type: 'POST',
          data: {

            folio_inicial: folioInicial,
            folio_final: folioFinal,
            id_solicitud: id_solicitud

          },
          success: function (response) {
            $("#mensaje").text(response.success || 'Rango de folios disponible.');
            $("#mensaje").attr('class', 'alert alert-solid-success');
            $("#mensaje").show();
            console.log(response);

          },
          error: function (xhr) {
            $("#mensaje").text(xhr.responseJSON.error || 'Ocurrió un error.');
            $("#mensaje").attr('class', 'alert alert-solid-danger');
            $("#mensaje").show();
            console.log(xhr.responseText);

          }
        });
      }
    });
  });


  $('#asignarHologramaForm').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    console.log()

    $.ajax({
      url: '/solicitud_holograma/updateAsignar',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
          title: 'Éxito',
          text: response.success,
          icon: 'success',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
        $('#asignarHolograma').modal('hide');
        $('.datatables-users').DataTable().ajax.reload();
      },
      error: function (response) {
        console.log(response);

        Swal.fire({
          title: 'Error',
          text: 'Ocurrió un error al actualizar la guía.',
          icon: 'error',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  //recepcion hologramas
  $(document).on('click', '.edit-recepcion', function () {
    var id_solicitud = $(this).data('id');

    $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {


      // Rellenar el formulario con los datos obtenidos
      $('#recepcion_id_solicitud').val(data.id_solicitud);

      $('#recepcion_empresa').val(data.id_empresa);
      // Mostrar el modal de edición
      $('#addRecepcion').modal('show');
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de la solicitud de holograma',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });


  //Activar hologramas
/*   $(document).on('click', '.activar_holograma', function () {
    var id_solicitud = $(this).data('id');

    $('#id_solicitudActivacion').val(id_solicitud);

    // Mostrar el modal de edición
    $('#activarHologramas').modal('show');

  }); */

  $(document).on('click', '.edit-holograma', function () {
    var id_solicitud = $(this).data('id');
  
    // Realizar la solicitud AJAX para obtener los datos de la solicitud
    $.get('/solicitud_holograma/editHolograma' + id_solicitud, function (data) {
  
      // Rellenar el formulario con los datos obtenidos
      $('#id_solicitudActivacion').val(data.id_solicitud);
      $('#id_inspeccion').val(data.id_inspeccion).trigger('change'); // Usamos trigger para actualizar el select2
      $('#no_lote_agranel').val(data.no_lote_agranel);
      $('#categoria').val(data.categoria).trigger('change');
      $('#no_analisis').val(data.no_analisis);
      $('#cont_neto').val(data.cont_neto);
      $('#unidad').val(data.unidad).trigger('change');
      $('#clase').val(data.clase).trigger('change');
      $('#contenido').val(data.contenido);
      $('#no_lote_envasado').val(data.no_lote_envasado);
      $('#tipo_agave').val(data.tipo_agave);
      $('#lugar_produccion').val(data.lugar_produccion);
      $('#lugar_envasado').val(data.lugar_envasado);
      $('#cantidad_hologramas').val(data.cantidad_hologramas);
  
      // Limpiar las filas existentes en la tabla de rangos
      $('#contenidoRango').empty();
  
      // Si existen rangos, los añadimos al formulario
      if (data.rangos && data.rangos.length > 0) {
        data.rangos.forEach(function (rango) {
          var rowHtml = `
            <tr>
              <th>
                <button type="button" class="btn btn-danger remove-row"> <i class="ri-delete-bin-5-fill"></i> </button>
              </th>
              <td><input type="number" class="form-control form-control-sm" name="rango_inicial[]" value="${rango.folio_inicial}"></td>
              <td><input type="number" class="form-control form-control-sm" name="rango_final[]" value="${rango.folio_final}"></td>
            </tr>`;
          $('#contenidoRango').append(rowHtml);
        });
      }
  
      // Mostrar el modal de edición
      $('#activarHologramas').modal('show');
  
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de la solicitud de holograma',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });
  
  // Agregar nueva fila para los rangos
  $('.add-row').click(function () {
    var newRow = `
      <tr>
        <th>
          <button type="button" class="btn btn-danger remove-row"> <i class="ri-delete-bin-5-fill"></i> </button>
        </th>
        <td><input type="number" class="form-control form-control-sm" name="rango_inicial[]"></td>
        <td><input type="number" class="form-control form-control-sm" name="rango_final[]"></td>
      </tr>`;
    $('#contenidoRango').append(newRow);
  });
  
  // Eliminar fila de rangos
  $(document).on('click', '.remove-row', function () {
    $(this).closest('tr').remove();
  });
  

/* 
  $('#activarHologramasForm').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    console.log()

    $.ajax({
      url: '/solicitud_holograma/storeActivar',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
          title: 'Éxito',
          text: response.success,
          icon: 'success',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
        $('#activarHologramas').modal('hide');
        $('.datatables-users').DataTable().ajax.reload();
      },
      error: function (response) {
        console.log(response);

        Swal.fire({
          title: 'Error',
          text: 'Ocurrió un error al actualizar la guía.',
          icon: 'error',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  }); */

  const addRecepcionForm = document.getElementById('addRecepcionForm');

  FormValidation.formValidation(addRecepcionForm, {
    fields: {
      'url[]': {
        validators: {
          notEmpty: {
            message: 'Por favor adjunte el comprobante de pago'
          },
          file: {
            extension: 'pdf,doc,docx,jpg,jpeg,png',
            type: 'application/pdf,application/msword,image/jpeg,image/png',
            maxSize: 5242880, // 5 MB
            message: 'El archivo adjunto debe ser un documento válido (PDF, DOC, JPG, PNG) y no mayor de 5MB'
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
    // Prevenir el comportamiento predeterminado

    var formData = new FormData(addRecepcionForm);

    $.ajax({
      url: '/solicitud_holograma/updateRecepcion',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
          title: 'Éxito',
          text: response.success,
          icon: 'success',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
        $('#addRecepcion').modal('hide');
        $('.datatables-users').DataTable().ajax.reload();
      },
      error: function (response) {
        Swal.fire({
          title: 'Error',
          text: 'Ocurrió un error al actualizar la guía.',
          icon: 'error',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });








  //Agregar o eliminar tablas +
  $(document).ready(function () {
    $('.add-row').click(function () {
      // Añade una nueva fila
      var newRow = `
          <tr>
              <th>
                  <button type="button" class="btn btn-danger remove-row"> <i class="ri-delete-bin-5-fill"></i> </button>
              </th>
              <td>
                  <input type="number" class="form-control form-control-sm rango_inicial" name="rango_inicial[]" />
              </td>
              <td>
                  <input type="number" class="form-control form-control-sm" name="rango_final[]">
              </td>
          </tr>`;
      $('#contenidoRango').append(newRow);
    });

    // Función para eliminar una fila
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
    });
  });



});
