/**
 * Page User List
 */
'use strict';

// Datatable (jquery)
$(function () {

  // Declaras el arreglo de botones
  let buttons = [];

  // Si tiene permiso, agregas el botón
  if (puedeAgregarUsuario) {
    buttons.push({
      text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar nuevo usuario</span>',
      className: 'add-new btn btn-primary waves-effect waves-light',
      attr: {
        'data-bs-toggle': 'offcanvas',
        'data-bs-target': '#offcanvasAddUser'
      }
    });
  }



  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2 = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#offcanvasAddUser');

  //SELECT UNICO
  /*if (select2.length) {
    var $this = select2;
    select2Focus($this);
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Seleccione el cliente',
      dropdownParent: $this.parent()
    });
  }*/
  //FUNSION PARA INICIALIZAR VARIOS SELECT2
  var select2Elements = $('.select2');
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

  // Users datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'user-list'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id' },
        { data: 'name' },
        { data: 'instalacionesTexto' },
        { data: 'email' },
        { data: 'telefono' },
        { data: 'password_original' },
        {
          orderable: false,
          render: function (data, type, full, meta) {
            var $numero_cliente = full['numero_cliente'];
            var $razon_social = full['razon_social'];
            return `
              <div>
                <span class="fw-bold">${$numero_cliente}</span><br>
                <small style="font-size:12px;" class="user-email">${$razon_social}</small>
              </div>
            `;
          }
        },
        { data: 'contacto' },
        { data: 'rol' },
        { data: 'id' },
        {
          data: 'estatus',
          render: function (data, type, row) {
            if (data === 'Inactivo' || !data) {
              return `<span class="badge rounded-pill badge text-bg-danger">${data}</span>`;
            } else {
              return `<span class="badge rounded-pill badge text-bg-success">${data}</span>`;
            }
          }
        },
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
            var $name = full['name'];

            // For Avatar badge
            var stateNum = Math.floor(Math.random() * 6);
            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
            var $state = states[stateNum],
              $name = full['name'],
              $initials = $name.match(/\b\w/g) || [],
              $output;
            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
            $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';

            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center user-name">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar avatar-sm me-3">' +
              $output +
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
          targets: 3,
          render: function (data, type, full, meta) {
            return '<span style="font-size:14px;">' + (full['instalacionesTexto'] ?? '(Not Found)') + '</span>';
          }
        },
        {
          // User email
          targets: 4,
          render: function (data, type, full, meta) {
            var $email = full['email'];
            return '<span class="user-email">' + $email + '</span>';
          }
        },
        {
          // User telefono
          targets: 5,
          render: function (data, type, full, meta) {
            var $tel = full['telefono'];
            return '<span class="user-email">' + $tel + '</span>';
          }
        },
        {
          // contraseña
          targets: 6,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $pass = full['password_original'];
            return '<span class="text-heading fw-medium">' + $pass + '</span>';
          }
        },
        {
          // Razón social
          targets: 7,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $cliente = full['razon_social'];
            return '<span class="user-email">' + $cliente + '</span>';
          }
        },
        {
          targets: 8,
          render: function (data, type, full, meta) {
            return '<span>' + (full['contacto'] ?? 'sin persona de contacto') + '</span>';
          }
        },
        {
          //PDF carta asignacion
          targets: 10,
          className: 'text-center',
          render: function (data, type, full, meta) {
            return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdfCartAsignacion cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="${full['id']}" data-nombre="${full['name']}"></i>`;
          }
        },
        {
          // Actions
          targets: 12,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {

            let acciones = '';

            if (window.puedeEditarUsuario) {
              acciones += `<a data-id="${full['id']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar clientes</a>`;
            }
            if (window.puedeEliminarUsuario) {
              acciones += `<a data-id="${full['id']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar clientes</a>`;
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
        info: 'Displaying _START_ to _END_ of _TOTAL_ entries'
      },
      // Buttons with Dropdown
      buttons: buttons,
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['name'];
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
    var user_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // sweetalert for confirmation of delete
    Swal.fire({
      title: '¿Está seguro de eliminar este usuario?',
      text: "¡No podrá revertirlo!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: '¡Si, eliminarlo!',
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
          url: `${baseUrl}user-list/${user_id}`,
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
          text: '¡El usuario ha sido eliminado!',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: '¡El usuario no ha sido eliminado!',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    });
  });




  //RECIBE LOS DATOS DEL PDF
  $(document).on('click', '.pdfCartAsignacion', function () {
    var id = $(this).data('id');
    var nombre = $(this).data('nombre');
    var iframe = $('#pdfViewer');//contenido
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    //Cargar el PDF con el ID
    iframe.attr('src', '../pdf_asignacion_usuario/' + id);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', '../pdf_asignacion_usuario/' + id).show();
    //Titulos
    $("#titulo_modal").text("Carta de asignación de usuario y contraseña para plataforma del OC");
    $("#subtitulo_modal").text(nombre);
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });




  //EDIT record
  $(document).on('click', '.edit-record', function () {
    var user_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');
    $('#statusDnone').removeClass('d-none');
    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // changing the title of offcanvas
    $('#offcanvasAddUserLabel').html('Editar usuario');
    $('#registrar-editar').html('Editar');

    // get data
    $.get(`${baseUrl}user-list\/${user_id}\/edit`, function (data) {
      $('#user_id').val(data.id);
      $('#add-user-fullname').val(data.name);
      $('#add-user-email').val(data.email);
      $('#add-user-tel').val(data.telefono);
      //$('#id_empresa').val(data.id_empresa).prop('selected', true).change();
      $('#id_empresa').val(data.id_empresa).trigger('change');
      $('#add-estatus').val(data.estatus).change();
      $('#id_contacto').val(data.id_contacto).trigger('change');
      $('#rol_id').val(data.roles[0].name).prop('selected', true).change();

      // esperar a que AJAX termine y entonces setear instalaciones
      $(document).one('ajaxStop', function () {
        if (data.id_instalacion && data.id_instalacion.length > 0) {
          $('#id_instalacion').val(data.id_instalacion).trigger('change');
        }
      });

    });
  });



  // changing the title
  $('.add-new').on('click', function () {
    $('#user_id').val(''); //reseting input field
    $('#offcanvasAddUserLabel').html('Agregar usuario');
    $('#registrar-editar').html('Registrar');
    $('#add-estatus').val('Activo').change();
    $('#statusDnone').addClass('d-none');
  });

  // validating form and updating user's data
  const addNewUserForm = document.getElementById('addNewUserForm');

  // user form validation
  const fv = FormValidation.formValidation(addNewUserForm, {
    fields: {
      name: {
        validators: {
          notEmpty: {
            message: 'Por favor introduce el nombre completo'
          }
        }
      },
      email: {
        validators: {
          notEmpty: {
            message: 'Por favor introduce un correo'
          },
          emailAddress: {
            message: 'Correo inválido'
          }
        }
      },
      telefono: {
        validators: {
          notEmpty: {
            message: 'Por favor introduce un número de teléfono'
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
      },
      id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor selecciona un cliente'
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
      url: `${baseUrl}user-list`,
      type: 'POST',
      success: function (status) {
        dt_user.draw();
        offCanvasForm.offcanvas('hide');

        // sweetalert
        Swal.fire({
          icon: 'success',
          title: `¡Correctamente ${status}!`,
          text: `Usuario ${status} correctamente.`,
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

  // clearing form data when offcanvas hidden
  offCanvasForm.on('hidden.bs.offcanvas', function () {
    fv.resetForm(true);

    $('#addNewUserForm select').val(null).trigger('change');//Limpia selects del formulario
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
});
