$(function () {
  // Definir la URL base
  var baseUrl = window.location.origin + '/';

  // 1. Declarar primero los filtros
  const filtros = [
    'Muestreo de agave (ART)',
    'Dictaminación de instalaciones',
    'Vigilancia en producción de lote',
    'Muestreo de lote a granel',
    'Vigilancia en el traslado del lote',
    'Emisión de certificado NOM a granel',
    'Inspección ingreso a barrica/ contenedor de vidrio',
    'Inspección de liberación a barrica/contenedor de vidrio',
    'Georreferenciación',
    'Inspección de envasado',
    'Muestreo de lote envasado',
    'Liberación de producto terminado nacional',
    'Pedidos para exportación',
    'Emisión de certificado venta nacional',
    'Revisión de etiquetas'
  ];

  // 2. Generar los botones dinámicamente
  const filtroButtons = filtros.map(filtro => ({
    text: filtro,
    className: 'dropdown-item',
    action: function (e, dt, node, config) {
      dt_instalaciones_table.search(filtro).draw();
      $('.dt-button-collection').hide(); // Ocultar el dropdown al seleccionar
    }
  }));
  filtroButtons.unshift({
    text: '<i class="ri-close-line text-danger me-2"></i>Quitar filtro',
    className: 'dropdown-item text-danger fw-semibold border',
    action: function (e, dt, node, config) {
      dt_instalaciones_table.search('').draw();
      $('.dt-button-collection').hide(); // Ocultar dropdown también
    }
  });

  // Inicializar DataTable
  var dt_instalaciones_table = $('.datatables-solicitudes').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + 'solicitudes-list-eliminadas',
      type: 'GET',
      dataSrc: function (json) {
        /*  console.log(json); */ // Ver los datos en la consola
        return json.data;
      },
      error: function (xhr, error, thrown) {
        console.error('Error en la solicitud Ajax:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un problema al cargar los datos.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    },

    columns: [
      { data: '' },
      {
        data: 'folio',
        render: function (data, type, row) {
          return `<span style="font-weight: bold; font-size: 1.1em;">${data}</span>`;
        }
      },
      { data: 'num_servicio' },
      {
        render: function (data, type, full, meta) {
          var $numero_cliente = full['numero_cliente'];
          var $razon_social = full['razon_social'];
          return `
            <div>
              <span  style="font-size:12px;" class="fw-bold">${$numero_cliente}</span><br>
              <small style="font-size:11px;" class="user-email">${$razon_social}</small>
            </div>
          `;
        }
      },
      { data: 'fecha_solicitud' },
      {
        data: 'tipo',
        render: function (data) {
          return `<span class="fw-bold">${data}</span>`;
        }
      },
      {
        data: 'direccion_completa',
        render: function (data, type, row) {
          return `<span style="font-size: 12px;">${data}</span>`; // Tamaño en línea
        }
      },
      { data: 'fecha_visita' },
      { data: 'inspector' },
      {
        data: null,
        render: function (data) {
          switch (data.id_tipo) {
            case 1: //Muestreo de agave
              return `
            <br>
            <span class="fw-bold small">Guías de agave:</span>
            <span class="small"> ${data.guias || 'N/A'}</span>
          `;

            case 2: //Vigilancia en producción de lote
              return `<br><span class="fw-bold small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold small">Nombre del predio:</span><span class="small"> ${data.nombre_predio || 'N/A'}</span>
                      <br>
                      <span class="fw-bold small">Art:</span><span class="small"> ${data.art || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Etapa:</span><span class="small"> ${data.etapa || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha de Corte:</span>
                      <span class="small">${data.fecha_corte || 'N/A'}</span>
                      `;
            case 3:
              return `<br><span class="fw-bold  small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small">${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Certificado de lote:</span><span class="small"> ${data.id_certificado_muestreo || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">%Alc. Vol:</span><span class="small"> ${data.cont_alc || 'N/A'}</span>
                      `;
            case 4:
              return `<br><span class="fw-bold  small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.id_tipo_maguey_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Volumen actual:</span><span class="small"> ${data.id_vol_actual || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Volumen restante:</span><span class="small"> ${data.id_vol_res || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis_traslado || 'N/A'}</span>
                      `;
            case 5:
              return `<br><span class="fw-bold  small">Envasado:</span><span class="small"> ${data.id_lote_envasado || 'N/A'}</span>
                      <br><span class="fw-bold  small">Información adicional:</span><span class="small"> ${data.info_adicional || 'N/A'}</span>`;
            case 7:
              return `<br><span class="fw-bold  small">Granel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis_barricada || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.tipo_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha inicio:</span><span class="small"> ${data.fecha_inicio || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha término:</span><span class="small"> ${data.fecha_termino || 'N/A'}</span>
                       <br>
                      <span class="fw-bold  small">Volumen ingresado:</span><span class="small"> ${data.volumen_ingresado || 'N/A'}</span>
                      `;
            case 8:
              return `<br><span class="fw-bold  small">Envasado:</span><span class="small"> ${data.id_lote_envasado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">%Alc. Vol:</span><span class="small"> ${data.cont_alc || 'N/A'}</span>
                      `;
            case 9:
              return `<br><span class="fw-bold  small">Granel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.tipo_lote_lib || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha inicio:</span><span class="small"> ${data.fecha_inicio || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha término:</span><span class="small"> ${data.fecha_termino || 'N/A'}</span>
                      `;
            case 10:
              return `<br><span class="fw-bold small">Punto de reunión:</span><span class="small"> ${data.punto_reunion || 'N/A'}</span>
                      <br>
                      <span class="fw-bold small">Información adicional:</span><span class="small"> ${data.info_adicional || 'N/A'}</span>`;
            case 11:
              return `<br><span class="fw-bold  small">Envasado:</span><span class="small"> ${data.id_lote_envasado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Granel:</span><span class="small"> ${data.lote_granel || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Marca:</span><span class="small"> ${data.marca || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Cont. Neto.:</span><span class="small"> ${data.presentacion || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Cajas:</span><span class="small"> ${data.cajas || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Botellas:</span><span class="small"> ${data.botellas || 'N/A'}</span>
                       <br>
                       <span class="fw-bold  small">Proforma:</span><span class="small"> ${data.no_pedido || 'N/A'}</span>
                       <br>
                      <span class="fw-bold  small">Certificado:</span><span class="small"> ${data.certificado_exportacion || 'N/A'}</span>
                       ${data.combinado}`;
            case 14:
              return `<span class="fw-bold  small">
                  ${data.renovacion === 'si' ? 'Es renovación' : 'No es renovación'}
              </span>`;

            default:
              return `<br><span class="fw-bold text-dark small">Información no disponible</span>`;
          }
        }
      },
      { data: 'fecha_servicio' },
      { data: '' },
      {
        data: 'estatus',
        render: function (data, type, row) {
          // Define las etiquetas para cada estado
          let estatus_validado_oc = 'bg-warning';
          let estatus_validado_ui = 'bg-warning';
          if (row.estatus_validado_oc == 'Validada') {
            estatus_validado_oc = 'bg-success';
          }
          if (row.estatus_validado_oc == 'Rechazada') {
            estatus_validado_oc = 'bg-danger';
          }

          if (row.estatus_validado_ui == 'Validada') {
            estatus_validado_ui = 'bg-success';
          }
          if (row.estatus_validado_ui == 'Rechazada') {
            estatus_validado_ui = 'bg-danger';
          }
          return `<span class="badge bg-warning mb-1">${data}</span><br>
            <span class="badge ${estatus_validado_oc} mb-1">${row.estatus_validado_oc} por oc</span><br>
            <span class="badge ${estatus_validado_ui}">${row.estatus_validado_ui} por ui</span>`;
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
        targets: 1,
        searchable: false,
        orderable: false
      },
      {
        targets: 2,
        searchable: false,
        orderable: false
      },
      {
        targets: 3,
        responsivePriority: 4,
        orderable: false
      },
      {
        targets: 4,
        searchable: false,
        orderable: false
      },
      {
        targets: 5,
        searchable: false,
        orderable: false
      },
      {
        // User full name
        targets: 8,
        render: function (data, type, full, meta) {
          var $name = full['inspector'];
          var foto_inspector = full['foto_inspector'];
          // For Avatar badge
          var $output;
          if (foto_inspector != '') {
            $output =
              '<div class="avatar-wrapper"><div class="avatar avatar-sm me-3"> <div class="avatar "><img src="storage/' +
              foto_inspector +
              '" alt class="rounded-circle"></div></div></div>';
          } else {
            $output = '';
          }
          // Creates full output for row
          var $row_output =
            '<div class="d-flex justify-content-start align-items-center user-name">' +
            $output +
            '<div class="d-flex flex-column">' +
            '<a href="#" class="text-truncate text-heading"><span style="font-size: 12px;" class="fw-medium">' +
            $name +
            '</span></a>' +
            '</div>' +
            '</div>';
          return $row_output;
        }
      },
      {
        targets: 9,
        searchable: false,
        orderable: false
      },
      {
        targets: 11,
        className: 'text-center',
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
          var $motivo = full['motivo'];
          return '<span class="text-danger fw-bold">'+$motivo+'</span>';
        }
      },
      {
        targets: 12, // o el índice correcto de la columna 'estatus'
        orderable: false,
        searchable: false
      },
      {
        // Acciones
        targets: -1,
        title: 'Acciones',
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
          let dropdown = '';

          if (puedeRestaurarSolicitud) {
            dropdown = `
              <div class="dropdown d-flex align-items-center gap-50">
                <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end m-0">
                  <a
                    data-id="${full['id_tipo']}"
                    data-id-solicitud="${full['id_solicitud']}"
                    data-tipo="${full['tipo']}"
                    data-razon-social="${full['razon_social']}"
                    data-bs-toggle="modal"
                    data-bs-target="#"
                    class="dropdown-item text-dark waves-effect restaurar-record">
                    <i class="text-success ri-history-line"></i> Restaurar Solicitud
                  </a>
                </div>
              </div>`;
          } else {
            dropdown = `
              <div class="d-flex align-items-center gap-50">
                <button class="btn btn-sm btn-secondary text-muted" disabled>
                  <i class="ri-lock-2-fill"></i>&nbsp;Opciones
                </button>
              </div>`;
          }

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
    lengthMenu: [10, 20, 50, 70, 100],
    language: {
      sLengthMenu: '_MENU_',
      search: '',
      searchPlaceholder: 'Buscar',
      info: 'Mostrar _START_ a _END_ de _TOTAL_ registros',
      emptyTable: 'No hay solicitudes eliminadas.',
      paginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior'
      }
    },
    buttons: [
/*       {
        extend: 'collection',
        className:
          'btn btn-outline-primary btn-lg dropdown-toggle me-4 waves-effect waves-light me-2 mb-2 mb-sm-2 mt-4 mt-md-0',
        text: '<i class="ri-filter-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Filtrar</span>',
        buttons: filtroButtons
      } */
      /*       {
        text: '<i class="ri-file-excel-2-fill ri-16px me-0 me-md-2 align-baseline"></i><span class="d-none d-sm-inline-block">Exportar Excel</span>',
        className: 'btn btn-info waves-effect waves-light me-2 mb-2 mb-sm-2 mt-4  mt-md-0',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#exportarExcel'
        }
      }, */
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

  var dt_user_table = $('.datatables-solicitudes'),
    select2Elements = $('.select2');

  // Función para inicializar Select2 en elementos específicos
  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      select2Focus($this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        language: 'es'
      });
    });
  }

  initializeSelect2(select2Elements);
  //funcion para los datepickers formato año/mes/dia
  $(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es'
    });
  });

  // Configuración CSRF para Laravel
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

    $(document).on('click', '.restaurar-record', function() {
      // Obtener el id_solicitud del atributo data-id (o el que uses)
      var id_solicitud = $(this).data('id-solicitud');
      console.log(id_solicitud);
      // Llamar a la función para restaurar
      restaurarSolicitud(id_solicitud);
    });
    function restaurarSolicitud(id_solicitud) {
      Swal.fire({
        title: '¿Restaurar solicitud?',
        text: 'Esta acción revertirá la eliminación de esta solicitud.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, restaurar',
        cancelButtonText: 'Cancelar',
        customClass: {
          confirmButton: 'btn btn-primary me-2',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.isConfirmed) {
          $.ajax({
            url: '/solicitudes-restaurar/' + id_solicitud,
            type: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
              Swal.fire({
                icon: 'success',
                title: 'Restaurado',
                text: response.success,
                confirmButtonText: 'OK',
                customClass: {
                  confirmButton: 'btn btn-primary'
                }
              });
              $('.datatables-solicitudes').DataTable().ajax.reload(); // Refresca tabla
            },
            error: function (xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.error || 'Hubo un error inesperado.',
                customClass: {
                  confirmButton: 'btn btn-danger'
                }
              });
            }
          });
        }
      });
    }



});

