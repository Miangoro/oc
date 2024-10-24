/**
 * Lista de clientes prospecto
 */

'use strict';

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
        url: baseUrl + 'clientes-list'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'numero_cliente' },
        { data: 'razon_social' },
        { data: 'domicilio_fiscal' },
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
          // User email
          targets: 2,
          render: function (data, type, full, meta) {
            var numero_cliente = full['numero_cliente'];




            var array = numero_cliente.split("<br>");
            var $row_output = "";
            array.forEach(function (numero1) {

              var numero = numero1.split(",");

              // Creates full output for row

              $row_output += '<div class="d-flex justify-content-start align-items-center user-name">' +
                '<div class="avatar-wrapper">' +
                '<div class="avatar avatar-sm me-3">' +

                '</div>' +
                '</div>' +
                '<div class="d-flex flex-column">' +
                '<a data-pdf="' + numero[1] + '" id="pdf" data-bs-target="#mostrarPdf" href="javascript:;" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="' + numero[0] + '" data-registro="' + numero[0] + '" class="text-truncate text-heading"><span class="fw-medium">' +
                numero[0] +
                '</span></a>' +
                '</div>' +
                '</div>';


            });
            return $row_output;
          }
        },
        {
          // Es la razón social
          targets: 3,
          responsivePriority: 4,
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
          // Domicilio fiscal
          targets: 4,
          render: function (data, type, full, meta) {
            var $email = full['domicilio_fiscal'];
            return '<span class="user-email">' + $email + '</span>';
          }
        },
        {
          // Régimen fiscal
          targets: 5,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $verified = full['regimen'];
            if ($verified == 'Persona física') {
              var $colorRegimen = 'info';
            } else {
              var $colorRegimen = 'warning';
            }
            return `${$verified
              ? '<span class="badge rounded-pill  bg-label-' + $colorRegimen + '">' + $verified + '</span>'
              : '<span class="badge rounded-pill  bg-label-' + $colorRegimen + '">' + $verified + '</span>'
              }`;
          }
        },
        {
          // PDF
          targets: 6,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $id = full['id_empresa'];
            return `<i id="pdf2" style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-regimen="${full['regimen']}" data-id="${full['id_empresa']}" data-registro="${full['razon_social']} "></i>`;
          }
        },
        {
          // Acciones
          targets: -1,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center gap-50">' +

              '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +

              `<a data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#editCliente"   onclick="abrirModal(${full['id_empresa']})" href="javascript:;" class="cursor-pointer dropdown-item validar-solicitud2"><i class="text-warning ri-edit-fill"></i>Editar</a>` +
              `<a data-id="${full['id_empresa']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasValidarSolicitud" href="javascript:;" class="dropdown-item validar-solicitud"><i class="text-info ri-search-eye-line"></i>Otra opción</a>` +

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
        },
        {
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar nuevo Confirmado</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#AddClientesConfirmados'
          }
        }
      ],
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

  $(document).ready(function () {
    var dt_user_table = $('.datatables-users'),
      select2Elements = $('.select2'),
      userView = baseUrl + 'app/user/view/account';

    // Inicializar Select2 en los elementos especificados
    initializeSelect2(select2Elements);
  });

  // Función para inicializar Select2
  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      select2Focus($this); // Asegúrate de que select2Focus esté definida o sea necesaria
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent()
      });
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



  $(document).on('click', '#pdf2', function () {
    var id = $(this).data('id');
    var regimen = $(this).data('regimen');
    var registro = $(this).data('registro');

    var iframe = $('#pdfViewer');
    if (regimen == 'Persona física') {
      var pdf = "../prestacion_servicio_fisica/";
    }

    if (regimen == 'Persona moral') {
      var pdf = "../prestacion_servicio_moral/";
    }


    iframe.attr('src', pdf + id);

    $("#titulo_modal").text("Contrato");
    $("#subtitulo_modal").text(registro);


  });

  $(document).on('click', '#pdf', function () {
    var id = $(this).data('id');
    var tipo_pdf = $(this).data('pdf');
    var registro = $(this).data('registro');
    var iframe = $('#pdfViewer');
    if (tipo_pdf == 1) {
      var pdf = "../carta_asignacion/";
    }

    if (tipo_pdf == 2) {
      var pdf = "../carta_asignacion052/";
    }
    iframe.attr('src', pdf + id);

    $("#titulo_modal").text("Carta de asignación de número de cliente");
    $("#subtitulo_modal").text(registro);


  });

  // edit record
  $(document).on('click', '.edit-record', function () {
    var id_empresa = $(this).data('id_empresa'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // changing the title of offcanvas
    $('#offcanvasAddUserLabel').html('Edit User');

    // get data
    $.get(`${baseUrl}empresas-list\/${user_id}\/edit`, function (data) {
      $('#empresa_id').val(data.id);
      $('#add-user-fullname').val(data.name);
      $('#add-user-email').val(data.email);
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
  $(document).on('click', '.validar-solicitud2', function () {
    var id_empresa = $(this).data('id');


    $('#empresaID').val(id_empresa);
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
      }, competencia: {
        validators: {
          notEmpty: {
            message: 'Por favor selecciona una opción.'
          }
        }
      }, capacidad: {
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
    $.ajax({
      data: $('#addNewUserForm').serialize(),
      url: `${baseUrl}empresas-list`,
      type: 'POST',
      success: function (status) {
        dt_user.draw();
        offCanvasForm.offcanvas('hide');

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
        Swal.fire({
          title: 'Duplicate Entry!',
          text: 'Your email should be unique.',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });
  /* 
  
  
    // validating form and updating user's data
    const addNewCliente = document.getElementById('addNewCliente');
  
    // Validación del formulario de aceptar cliente
    const fv2 = FormValidation.formValidation(addNewCliente, {
      fields: {
          'numero_cliente[]': {
            validators: {
                notEmpty: {
                    message: 'Por favor introduzca el número de cliente.'
                }
            }
        },fecha_cedula: {
          validators: {
              notEmpty: {
                  message: 'Por favor introduzca la fecha de cédula de identificación fiscal.'
              }
          }
      },idcif: {
        validators: {
            notEmpty: {
                message: 'Por favor introduzca el idCIF del Servicio deAdministración Tributaria.'
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
            return '.col-sm-12';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      // adding or updating user when form successfully validate
      $.ajax({
        data: $('#addNewCliente').serialize(),
        url: `${baseUrl}aceptar-cliente`,
        type: 'POST',
        success: function (status) {
          dt_user.draw();
          offCanvasForm.offcanvas('hide');
  
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
          Swal.fire({
            title: 'Duplicate Entry!',
            text: 'Your email should be unique.',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    }); */

  // clearing form data when offcanvas hidden
  offCanvasForm.on('hidden.bs.offcanvas', function () {
    fv2.resetForm(true);
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
  //AQUI termina


  // FUNCION PARA EDITAR un registro
  $(document).ready(function () {
    // Abrir el modal y cargar datos para editar
    $(document).on('click', '.edit-record', function () {
      var id = $(this).data('id');


      // Realizar la solicitud AJAX para obtener los datos de la clase
      $.get('/cliente_confirmado/' + id + '/edit', function (data) {
        $('#edit_id').val(data.id);
        $('#edit_id_empresa').val(data.id_empresa);
        $('#edit_num_cliente').val(data.num_cliente);
        $('#edit_id_norma').val(data.id_norma);


        // Mostrar el modal de edición
        $('#editCliente').offcanvas('show');
      }).fail(function () {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al obtener los datos',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      });
    });

    // Manejar el envío del formulario de edición
    $('#editClienteForm').on('submit', function (e) {
      e.preventDefault();

      var formData = $(this).serialize();
      var id = $('#edit_id').val(); // Obtener el ID de la clase desde el campo oculto

      $.ajax({
        url: '/cliente_confirmado/' + id_tipo,
        type: 'PUT',
        data: formData,
        success: function (response) {
          $('#editCliente').offcanvas('hide'); // Ocultar el modal de edición "DIV"
          $('#editClienteForm')[0].reset(); // Limpiar el formulario "FORM"

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.success,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });

          // Recargar los datos en la tabla sin reinicializar DataTables
          $('.datatables-users').DataTable().ajax.reload();
        },
        error: function (xhr) {
          console.log('Error:', xhr.responseText);
          // Mostrar alerta de error
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


  /* agregar un nuevo dictamen */
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
            },
          }
        },
        regimen: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el régimen'
            },
          }
        },
        domicilio_fiscal: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el domicilio fiscal'
            },
          }
        },
        estado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un estado'
            },
          }
        },
        representante: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el representante'
            },
          }
        },
        rfc: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el RFC'
            },
            stringLength: {
              max: 13,
              message: 'El RFC no puede tener más de 13 caracteres'
            },
          }
        },
        correo: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el correo electrónico'
            },
            emailAddress: {
              message: 'Por favor ingrese un correo electrónico válido'
            },
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
                  // Aceptar dígitos, espacios, guiones y paréntesis
                  regexp: /^[0-9\s\-\(\)]+$/,
                  message: 'El teléfono debe contener solo números, espacios, guiones y paréntesis'
              }
          }
      },      
        id_contacto: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un contacto'
            }
          }
        },
       'normas[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una norma'
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
      $.ajax({
        url: '/registrar-clientes',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Ocultar el modal y resetear el formulario
          $('#AddClientesConfirmados').modal('hide');
          $('#ClientesConfirmadosForm')[0].reset();
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
            text: 'Error al registrar el cliente',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    // Inicializar select2
    $('#estado, #normas').on('change', function () {
      // Revalidar el campo cuando se cambia el valor del select2
      fv.revalidateField($(this).attr('name'));
    });

  });







});
