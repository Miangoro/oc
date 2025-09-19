'use strict';

$(function () {
  let buttonss = [];
  // Si tiene permiso, agregas el botón
  if (puedeAgregarElUsuario) {
    buttonss.push({
      text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Ticket</span>',
      className: 'add-new btn btn-primary me-2 mb-2 mb-sm-2 mt-4 mt-md-0 waves-effect waves-light',
      attr: {
        'data-bs-toggle': 'modal',
        'data-bs-target': '#RegistrarTicket'
      }
    });
  }

  var dt_user_table = $('.datatables-users');

  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true
  });

  // AJAX setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'tickets-list',
        data: function (d) {
          d.estado = $('#estado').val();
          d.prioridad = $('#prioridad').val();
        }
      },
      columns: [
        { data: '' },             // 0 -> control
        { data: 'fake_id' },      // 1 -> #
        { data: 'folio' },        // 2 -> Folio
        { data: 'asunto' },       // 3 -> Asunto
        { data: 'solicitante' },  // 4 -> Solicitante
        { data: 'prioridad' },    // 5 -> Prioridad
        { data: 'estatus' },      // 6 -> Estatus
        { data: 'created_at' },   // 7 -> Fecha
        { data: 'acciones' }      // 8 -> Acciones
      ],

      columnDefs: [
        {
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, row) {
            return '';
          }
        },
        {
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          targets: 2,
          render: function (data, type, full) {
            var $folio = full['folio'] ?? 'N/A';
            return `<span>${$folio}</span>`;
          }
        },
        {
          targets: 4,
          render: function (data, type, full) {
            var $soli = full['solicitante'] ?? 'N/A';
            return `<span>${$soli}</span>`;
          }
        },
        {
          targets: 5, // columna 'estatus'
          render: function (data, type, full, meta) {
            let prioridad = (data || '').toLowerCase();
            let colorClass = 'secondary'; // color por defecto
            if (prioridad === 'media') colorClass = 'warning';
            else if (prioridad === 'baja') colorClass = 'info';
            else if (prioridad === 'alta') colorClass = 'danger';

            return `<span class="badge py-2 rounded-pill bg-${colorClass} text-white">${data}</span>`;
          }
        },

        {
          targets: 6, // columna 'estatus'
          render: function (data, type, full, meta) {
            let status = (data || '').toLowerCase();
            let colorClass = 'secondary'; // color por defecto

            if (status === 'pendiente') colorClass = 'warning';
            else if (status === 'abierto') colorClass = 'success';
            else if (status === 'cerrado') colorClass = 'dark';

            return `<span class="badge rounded-pill bg-${colorClass} text-white">${data}</span>`;
          }
        },
        {
          // Razón social
          targets: 7,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $created_at = full['created_at'];
            return '<span class="user-email">' + $created_at + '</span>';
          }
        },

        {
          // Actions
          targets: 8,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            let acciones = '';
            if (window.puedeVerElUsuario) {
              acciones += `<a href="/tickets/${full['id_ticket']}/ver" class="dropdown-item waves-effect text-info">
                 <i class="ri-eye-line ri-20px text-info"></i> Ver Ticket
             </a>`;
              /* acciones += `<a data-id="${full['id']}" class="dropdown-item firma-record waves-effect text-warning"> <i class="ri-ball-pen-line ri-20px text-warning"></i> Ver Ticket</a>`; */
            }
            if (window.puedeEliminarElUsuario) {
              acciones += `<a data-id="${full['id_ticket']}" class="dropdown-item delete-record waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar Ticket </a>`;
            }

            // Si hay acciones (bitácora NO firmada)
            if (acciones.trim()) {
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

            // Si la bitácora ya está firmada, mostrar botón visualmente deshabilitado
            return `
            <div class="d-flex align-items-center gap-50">
              <button class="btn btn-sm btn-secondary disabled" style="opacity: 0.6; cursor: not-allowed;" disabled>
                <i class="ri-settings-5-fill ri-20px me-1"></i> Opciones
              </button>
            </div>
          `;
          }
        }
      ],

      order: [[1, 'desc']],
      dom:
        '<"card-header d-flex rounded-0 flex-wrap pb-md-0 pt-0"' +
        /* '<"me-5 ms-n2"f>' + */
        '<"d-flex flex-wrap justify-content-end align-items-center w-100 px-3 pt-2"' +
        '<"filtrosBitacora d-flex gap-2 align-items-center" >' + // ← Aquí irán los selects
        '<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center gap-3"lB>' +
        '>' +
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
        emptyTable: 'No hay datos disponibles en la tabla',
        paginate: {
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior'
        }
      },

      // Opciones Exportar Documentos
      buttons: [buttonss],

      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles del ticket: ' /* + data['nombre_lote'] */;
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== ''
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
      },
      initComplete: function () {
        // Mover los selects desde los botones a la zona visible "filtrosBitacora"
        var $botonesFiltros = $('.dt-buttons .dt-custom-select');
        var $contenedorFiltros = $('.filtrosBitacora');
        $botonesFiltros.appendTo($contenedorFiltros);

        // Re-inicializar Select2 para que no se corte el dropdown, usando dropdownParent en body
        $contenedorFiltros.find('select.select2').select2({
          dropdownParent: $(document.body)
        });

        // Opcional: recargar tabla al cambiar filtros
        $('#filtroEmpresa, #filtroInstalacion').on('change', function () {
          dt_user.ajax.reload();
        });

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
        dropdownParent: $this.parent()
      });
    });
  }

  initializeSelect2(select2Elements);

  $(document).on('select2:select', '#filtroEmpresa', function (e) {
    const selectedText = $(this).find('option:selected').text();
    $('#filtroEmpresa').next('.select2-container').find('.select2-selection__rendered').attr('title', selectedText);
  });

  $('#filtroEmpresa, #filtroInstalacion').on('change', function () {
    $('.datatables-users').DataTable().ajax.reload();
  });

  $(document).ready(function () {
    function cargarInstalaciones() {
      // Si es usuario tipo 3, usar instalaciones precargadas
      if (window.tipoUsuario === 3) {
        $('#filtroInstalacion').html(window.opcionesInstalacionesAutenticadas).trigger('change');
        return;
      }

      let empresaId = $('#filtroEmpresa').val();
      if (!empresaId) {
        $('#filtroInstalacion').html('<option value="">-- Todas las Instalaciones --</option>');
        return;
      }

      $.ajax({
        url: '/getDatos/' + empresaId,
        method: 'GET',
        success: function (response) {
          let opciones = '<option value="">-- Todas las Instalaciones --</option>';
          if (response.instalaciones.length > 0) {
            response.instalaciones.forEach(function (inst) {
              let tipoLimpio = limpiarTipo(inst.tipo);
              opciones += `<option value="${inst.id_instalacion}">${tipoLimpio} | ${inst.direccion_completa}</option>`;
            });
          } else {
            opciones += '<option value="">Sin instalaciones registradas</option>';
          }
          $('#filtroInstalacion').html(opciones).trigger('change');
        },
        error: function () {
          $('#filtroInstalacion').html('<option value="">Error al cargar</option>');
        }
      });
    }

    cargarInstalaciones();
    $('#filtroEmpresa').on('change', cargarInstalaciones);
  });

  // Actualizar la tabla al cambiar un filtro
  $('#estado, #prioridad').on('change', function () {
    /* $('#ticketsTable').DataTable().ajax.reload(); */
    dt_user.ajax.reload();
  });

  //FUNCIONES DEL FUNCIONAMIENTO DEL CRUD//
  $(document).on('click', '#verBitacoraBtn', function () {
    const empresaId = $('#filtroEmpresa').val();
    const instalacionId = $('#filtroInstalacion').val();

    if (!empresaId) {
      Swal.fire({
        icon: 'warning',
        title: 'Selecciona una empresa',
        text: 'Debes elegir una empresa para ver su bitácora',
        confirmButtonText: 'Aceptar',
        customClass: {
          confirmButton: 'btn btn-warning'
        }
      });
      return;
    }

    let urlPDF = `/bitacora_mezcal?empresa=${empresaId}`;
    if (instalacionId) {
      urlPDF += `&instalacion=${instalacionId}`;
    }
    urlPDF += `&t=${new Date().getTime()}`;

    $('#cargando').show();
    $('#pdfViewer').hide().attr('src', '');
    $('#NewPestana').hide();

    // Hacer una solicitud previa para verificar si hay datos
    $.ajax({
      url: urlPDF,
      method: 'GET',
      xhrFields: { responseType: 'blob' }, // permite manejar el PDF o error
      success: function (data) {
        // Mostrar PDF en iframe
        const blobUrl = URL.createObjectURL(data);
        $('#pdfViewer').attr('src', blobUrl);
        $('#NewPestana').attr('href', blobUrl);
        $('#titulo_modal').text('Bitácora Mezcal a Granel Productor');
        /* $('#subtitulo_modal').text('Versión Filtrada'); */
        $('#mostrarPdf').modal('show');

        $('#pdfViewer').on('load', function () {
          $('#cargando').hide();
          $(this).show();
        });
      },
      error: function (xhr) {
        $('#cargando').hide();
        Swal.fire({
          icon: 'info',
          title: 'Sin registros',
          text: xhr.responseJSON?.message || 'No hay datos para mostrar.',
          confirmButtonText: 'Aceptar',
          customClass: {
            confirmButton: 'btn btn-info'
          }
        });
      }
    });
  });

  /*     $('#pdfViewer').on('load', function () {
      $('#cargando').hide();
      $(this).show();
    }); */
  /*  */
  $(document).on('click', '.delete-record', function () {
    var id_ticket = $(this).data('id'); // debe traer un número válido

    if (!id_ticket) {
      console.error("ID de ticket no encontrado en data-id");
      return;
    }

    Swal.fire({
      title: '¿Está seguro?',
      text: 'No podrá revertir este evento',
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
          url: `${baseUrl}tickets/${id_ticket}`, // aquí se envía el ID real
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function () {
            dt_user.draw();

            Swal.fire({
              icon: 'success',
              title: '¡Eliminado!',
              text: '¡El ticket ha sido eliminado correctamente!',
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
              text: 'No se pudo eliminar el ticket. Inténtalo de nuevo más tarde.',
              footer: `<pre>${error.responseText}</pre>`,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      }
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
    const form = document.getElementById('ticketForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        asunto: {
          validators: {
            notEmpty: { message: 'Por favor ingrese el asunto del ticket' }
          }
        },
        descripcion: {
          validators: {
            notEmpty: { message: 'Por favor ingrese la descripción' }
          }
        },
        prioridad: {
          validators: {
            notEmpty: { message: 'Por favor seleccione la prioridad' }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: '.mb-3'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      $('#btnRegistrar').addClass('d-none');
      $('#loading').removeClass('d-none');

      var formData = new FormData(form); // FormData permite enviar archivos

      $.ajax({
        url: '/storeTicket', // Ruta para crear tickets
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#RegistrarTicket').modal('hide');
          $('#loading').addClass('d-none');
          $('#btnRegistrar').removeClass('d-none');
          form.reset();
          $('.datatables-users').DataTable().ajax.reload();

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.success || 'Ticket creado correctamente',
            customClass: { confirmButton: 'btn btn-success' }
          });
        },
        error: function (xhr) {
          let msg = 'Error al registrar el ticket';
          let errors = null;

          try {
            errors = xhr.responseJSON?.errors ?? JSON.parse(xhr.responseText)?.errors;
          } catch (e) {
            errors = null;
          }

          if (xhr.status === 422 && errors) {
            msg = Object.values(errors).flat().join('\n');
          } else if (xhr.responseJSON?.error) {
            msg = xhr.responseJSON.error;
          }

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: msg,
            customClass: { confirmButton: 'btn btn-danger' }
          });

          $('#loading').addClass('d-none');
          $('#btnRegistrar').removeClass('d-none');
        }
      });
    });

    // Manejo dinámico de evidencias
    const container = document.getElementById('evidencias-container');
    const addBtn = document.getElementById('add-evidencia');

    addBtn.addEventListener('click', function () {
      const div = document.createElement('div');
      div.classList.add('input-group', 'mb-2');
      div.innerHTML = `
            <input type="file" name="evidencias[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            <button type="button" class="btn btn-outline-danger remove-evidencia"><i class="ri-close-circle-fill"></i></button>
        `;
      container.appendChild(div);
    });

    container.addEventListener('click', function (e) {
      if (e.target.closest('.remove-evidencia')) {
        e.target.closest('.input-group').remove();
      }
    });
  });

  //end
});
