$(function () {
  // Definir la URL base
  var baseUrl = window.location.origin + '/';

  // Inicializar DataTable
  var dt_instalaciones_table = $('.datatables-solicitudes').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + 'solicitudes-list',
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
      { data: '' },
      { data: 'folio' },
      { data: 'num_servicio' },
      {
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
      { data: 'fecha_solicitud' },
      {
        data: 'tipo',
        render: function (data) {
          return `<span class="fw-bold">${data}</span>`;
        }
      },
      {
        data: 'direccion_completa',
        render: function(data, type, row) {
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
            <span class="fw-bold text-dark small">Guías de agave:</span>
            <span class="small"> ${data.guias || 'N/A'}</span>
          `;

            case 2: //Vigilancia en producción de lote
              return `<br><span class="fw-bold text-dark small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Nombre del predio:</span><span class="small"> ${data.nombre_predio || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Art:</span><span class="small"> ${data.art || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Etapa:</span><span class="small"> ${data.etapa || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Fecha de Corte:</span>
                      <span class="small">${data.fecha_corte || 'N/A'}</span>
                      `;
            case 3:
              return `<br><span class="fw-bold text-dark small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Tipo:</span><span class="small">${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Certificado de lote:</span><span class="small"> ${data.id_certificado_muestreo || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">%Alc. Vol:</span><span class="small"> ${data.cont_alc || 'N/A'}</span>
                      `;
            case 4:
              return `<br><span class="fw-bold text-dark small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Categoría:</span><span class="small"> ${data.id_categoria_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Clase:</span><span class="small"> ${data.id_clase_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Tipo:</span><span class="small"> ${data.id_tipo_maguey_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Volumen actual:</span><span class="small"> ${data.id_vol_actual || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Volumen restante:</span><span class="small"> ${data.id_vol_res || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Análisis:</span><span class="small"> ${data.analisis_traslado || 'N/A'}</span>
                      `;
            case 5:
              return `<br><span class="fw-bold text-dark small">Lote envasado:</span><span class="small"> ${data.id_lote_envasado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Tipo:</span><span class="small"> ${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Marca:</span><span class="small"> ${data.id_marca || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">%Alc. Vol:</span><span class="small"> ${data.volumen_inspeccion || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Análisis:</span><span class="small"> ${data.analisis_inspeccion || 'N/A'}</span>
                      `;
            case 7:
              return `<br><span class="fw-bold text-dark small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Tipo:</span><span class="small"> ${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Análisis:</span><span class="small"> ${data.analisis_barricada || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Tipo:</span><span class="small"> ${data.tipo_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Fecha inicio:</span><span class="small"> ${data.fecha_inicio || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Fecha término:</span><span class="small"> ${data.fecha_termino || 'N/A'}</span>
                       <br>
                      <span class="fw-bold text-dark small">Volumen ingresado:</span><span class="small"> ${data.volumen_ingresado || 'N/A'}</span>
                      `;
            case 8:
              return `<br><span class="fw-bold text-dark small">Lote envasado:</span><span class="small"> ${data.id_lote_envasado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Tipo:</span><span class="small"> ${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">%Alc. Vol:</span><span class="small"> ${data.cont_alc || 'N/A'}</span>
                      `;
            case 9:
              return `<br><span class="fw-bold text-dark small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Tipo:</span><span class="small"> ${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Tipo:</span><span class="small"> ${data.tipo_lote_lib || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Fecha inicio:</span><span class="small"> ${data.fecha_inicio || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Fecha término:</span><span class="small"> ${data.fecha_termino || 'N/A'}</span>
                      `;
            case 10:
              return `<br><span class="fw-bold text-dark small">Punto de reunión:</span><span class="small"> ${data.punto_reunion || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Información adicional:</span><span class="small"> ${data.info_adicional || 'N/A'}</span>`;
            case 11:
              return `<br><span class="fw-bold text-dark small">Lote envasado:</span><span class="small"> ${data.id_lote_envasado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Lote granel:</span><span class="small"> ${data.lote_granel || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Marca:</span><span class="small"> ${data.marca || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Cont. Neto.:</span><span class="small"> ${data.presentacion || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Cajas:</span><span class="small"> ${data.cajas || 'N/A'}</span>
                      <br>
                      <span class="fw-bold text-dark small">Botellas:</span><span class="small"> ${data.botellas || 'N/A'}</span>
                       <br>
                       <span class="fw-bold text-dark small">Proforma:</span><span class="small"> ${data.no_pedido || 'N/A'}</span>
                       <br>
                      <span class="fw-bold text-dark small">Certificado:</span><span class="small"> ${data.certificado_exportacion || 'N/A'}</span>`;
            case 14:
              return `<span class="fw-bold text-dark small">
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
        render: function(data, type, row) {
            // Define las etiquetas para cada estado
            let estatus_validado_oc = 'bg-warning';
            let estatus_validado_ui = 'bg-warning';
            if(row.estatus_validado_oc=='Validada'){
              estatus_validado_oc = 'bg-success';
            }
            if(row.estatus_validado_oc=='Rechazada'){
              estatus_validado_oc = 'bg-danger';
            }

            if(row.estatus_validado_ui=='Validada'){
              estatus_validado_ui = 'bg-success';
            }
            if(row.estatus_validado_ui=='Rechazada'){
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
        searchable: false,
        orderable: true,
        targets: 1,
        render: function (data, type, full, meta) {
          return `<span>${full.fake_id}</span>`;
        }
      },
      {
        // User full name
        targets: 9,
        responsivePriority: 4,
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
        targets: 12,
        className: 'text-center',
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
          return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-id="${full['id_solicitud']}" data-registro="${full['folio']}"></i>`;
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
            '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
            '<i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>' +
            '</button>' +
            '<div class="dropdown-menu dropdown-menu-end m-0">' +
            `<a data-id="${full['id']}" data-bs-toggle="modal" onclick="abrirModalTrazabilidad(${full['id_solicitud']},'${full['tipo']}','${full['razon_social']}')" href="javascript:;" class="cursor-pointer dropdown-item validar-solicitud2">` +
            '<i class="text-warning ri-user-search-fill"></i> Trazabilidad</a>' +
            `<a
            data-id="${full['id_tipo']}"
            data-id-solicitud="${full['id_solicitud']}"
            data-tipo="${full['tipo']}"
            data-razon-social="${full['razon_social']}"
            data-bs-toggle="modal"
            data-bs-target="#addSolicitudValidar"
            class="dropdown-item text-dark waves-effect validar-solicitudes">
            <i class="text-success ri-search-eye-line"></i> Validar solicitud
          </a>` +
            `<a
              data-id="${full['id']}"
              data-id-solicitud="${full['id_solicitud']}"
              data-tipo="${full['tipo']}"
              data-id-tipo="${full['id_tipo']}"
              data-razon-social="${full['razon_social']}"
              class="cursor-pointer dropdown-item text-dark edit-record-tipo">` +
            '<i class="text-warning ri-edit-fill"></i> Editar</a>' +

            // Aquí agregamos la opción de eliminar
            `<a  data-id="${full['id']}"   data-id-solicitud="${full['id_solicitud']}" class="dropdown-item text-danger delete-recordes cursor-pointer">` +
            '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>' +
            '</div>' +
            '</div>'
          );
        }
      }
    ],
    order: [[1, 'desc']],
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
        text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
        buttons: [
          {
            extend: 'print',
            title: 'Solicitudes',
            text: '<i class="ri-printer-line me-1"></i>Imprimir',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {
                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                      result += item.lastChild.firstChild.textContent;
                    } else if (item.innerText === undefined) {
                      result += item.textContent;
                    } else {
                      result += item.innerText;
                    }
                  });
                  return result;
                }
              }
            },
            customize: function (win) {
              // Customize print view for dark
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
            title: 'Solicitudes',
            text: '<i class="ri-file-text-line me-1"></i>CSV',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 8 || columnIndex === 11) {
                    return 'ViewSuspend';
                  }
                  if (columnIndex === 1) {
                    // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'excel', //extension a descargar
            title: 'Solicitudes de servicio',
            text: '<i class="ri-file-excel-line me-1"></i>Excel',
            className: 'dropdown-item',
            exportOptions: {
              //define como se exportan los datos
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], //N°. de columnas a exportar
              modifier: {
                //Incluye todos los datos
                page: 'all' //Exporta todos los datos de todas las páginas
                //order: 'current' //Mantiene el orden actual
              },
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  //Personaliza el contenido de las celdas
                  /*if (columnIndex === 8 || columnIndex === 11) { //Reemplaza el contenido de la celda con la cadena return
                    return 'ViewSuspend';
                  }*/
                  return inner.replace(/<[^>]*>/g, ''); //Elimina todas las etiquetas HTML de las columnas
                }
              }
            }
          },
          {
            extend: 'pdf',
            title: 'Solicitudes',
            text: '<i class="ri-file-pdf-line me-1"></i>PDF',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 1) {
                    // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'copy',
            title: 'Solicitudes',
            text: '<i class="ri-file-copy-line me-1"></i>Copiar',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 8 || columnIndex === 11) {
                    return 'ViewSuspend';
                  }
                  if (columnIndex === 1) {
                    // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          }
        ]
      },
      {
        text: '<i class="ri-file-excel-2-fill ri-16px me-0 me-md-2 align-baseline"></i><span class="d-none d-sm-inline-block">Exportar Excel</span>',
        className: 'btn btn-info waves-effect waves-light me-2 mb-2 mb-sm-2 mt-4  mt-md-0',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#exportarExcel'
        }
      },
      {
        text: '<i class="ri-add-line ri-16px me-0 me-md-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nueva solicitud</span>',
        className: 'add-new btn btn-primary waves-effect waves-light me-2 mb-2 mb-sm-2 mt-4  mt-md-0',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#verSolicitudes'
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


  var dt_user_table = $('.datatables-solicitudes'),
    select2Elements = $('.select2');

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

  // Eliminar registro
  $(document).on('click', '.delete-recordes', function () {
    var id_solicitudes = $(this).data('id-solicitud');
    console.log(id_solicitudes);
    $('.modal').modal('hide');

    // Confirmación con SweetAlert
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
      html: `
        <label for="delete-reason" style="margin-bottom: 5px;">Escriba el motivo de la eliminación:</label>
        <input id="delete-reason" class="swal2-input" placeholder="Escriba el motivo de la eliminación" required>
      `,
      preConfirm: () => {
        const reason = Swal.getPopup().querySelector('#delete-reason').value;
        if (!reason) {
          Swal.showValidationMessage('Debe proporcionar un motivo para eliminar');
          return false;
        }
        return reason; // Devuelve el motivo si es válido
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.isConfirmed) {
        const reason = result.value; // El motivo ingresado por el usuario
        // Solicitud de eliminación
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}solicitudes-lista/${id_solicitudes}`, // Ajusta la URL aquí
          data: { reason: reason }, // Envía el motivo al servidor si es necesario
          success: function () {
            dt_instalaciones_table.ajax.reload();
            // Mostrar mensaje de éxito
            Swal.fire({
              icon: 'success',
              title: '¡Eliminado!',
              text: '¡La solicitud ha sido eliminada correctamente!',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          },
          error: function (xhr, textStatus, errorThrown) {
            console.error('Error al eliminar:', textStatus, errorThrown);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Hubo un problema al eliminar el registro.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La solicitud no ha sido eliminada',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  $(document).on('click', '.open-modal', function () {
    // Ocultar el modal antes de abrir
    $('.modal').modal('hide');

    var id_solicitud = $('.id_solicitud').text(); // Extrae el texto de ID Solicitud
    var tipo = $('.tiposs').text(); // Extrae el texto del Tipo
    console.log(id_solicitud);
    console.log(tipo);

    // Verificar si el tipo es igual a 3
    if (tipo === "3") {
        var url = 'Etiqueta-2401ESPTOB';  // URL de la ruta

        var iframe = $('#pdfViewerDictamen1');
        var spinner = $('#loading-spinner1');  // Spinner
        spinner.show();
        iframe.hide();

        // Asegurarse de que la URL esté bien formada
        iframe.attr('src', url + '/' + id_solicitud);    // Concatenar la URL con el ID de la solicitud

        // Configurar el botón para abrir el PDF en una nueva pestaña
        $('#openPdfBtnDictamen1')
          .attr('href', url + '/' + id_solicitud)
          .show();

        // Configuración del título y subtítulo del modal
        $('#titulo_modal_Dictamen1').text('Etiquetas');

        // Obtener el texto del título de la solicitud
        var solicitudTitleText = $('#solicitud_title').text().trim();
        $('#subtitulo_modal_Dictamen1').html('<p class="solicitud badge bg-primary"> ' + solicitudTitleText + '</p>');

        // Mostrar el modal
        $('#modalDictamen').modal('show');

        // Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
        iframe.on('load', function () {
            console.log('PDF cargado en el iframe.');
            spinner.hide();
            iframe.show();
        });
    } else {
        console.log("El tipo no es 3. No se cargará el PDF.");
    }
});



$(document).on('click', '.expediente-record', function () {
  // Accediendo a los valores de los atributos data-
  var id = $(this).data('id');
  var id_solicitud = $(this).data('id-solicitud');
  var tipo = $(this).data('tipo');
  var id_tipo = $(this).data('id-tipo');
  var razon_social = $(this).data('razon-social');

  // Ahora puedes hacer lo que necesites con estos valores
/*   console.log("ID:", id);
  console.log("ID Solicitud:", id_solicitud);
  console.log("Tipo:", tipo);
  console.log("ID Tipo:", id_tipo);
  console.log("Razón Social:", razon_social); */

  $('#expedienteServicio .id_solicitud').text(id_solicitud);
  $('#expedienteServicio .tiposs').text(id_tipo);
  // Aquí puedes utilizar estos datos para abrir un modal, hacer una solicitud AJAX, etc.
  abrirModal(id_solicitud, tipo, razon_social);
});





  $(document).ready(function () {
    $(document).on('click', '.edit-record-tipo', function () {
      // Obtenemos los datos del botón
      const id_solicitud = $(this).data('id-solicitud');
      const id_tipo = parseInt($(this).data('id-tipo')); // Convertir a número

      // Cierra cualquier modal u offcanvas visible
      $('.modal').modal('hide');

      // Variables para el modal
      let modal = null;

      // Validamos el tipo y configuramos el modal correspondiente
      if (id_tipo === 1) {
        modal = $('#editSolicitudMuestreoAgave');
      } else if (id_tipo === 2) {
        modal = $('#editVigilanciaProduccion');
      } else if (id_tipo === 3) {
        modal = $('#editMuestreoLoteAgranel');
      } else if (id_tipo === 4) {
        modal = $('#editVigilanciaTraslado');
      } else if (id_tipo === 5) {
        modal = $('#editInspeccionEnvasado');
      } else if (id_tipo === 7) {
        modal = $('#editInspeccionIngresoBarricada');
      } else if (id_tipo === 8) {
        modal = $('#editLiberacionProducto');
      } else if (id_tipo === 9) {
        modal = $('#editInspeccionLiberacion');
      } else if (id_tipo === 10) {
        modal = $('#editClienteModalTipo10');
      }  else if (id_tipo === 11) {
        modal = $('#editPedidoExportacion');
      } else if (id_tipo === 14) {
        modal = $('#editSolicitudDictamen');
      } else {
        console.error('Tipo no válido:', id_tipo);
        return; // Salimos si el tipo no es válido
      }

      // Hacemos la solicitud para obtener los datos
      $.ajax({
        url: `/datos-solicitud/${id_solicitud}`, // Ruta única
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            // Rellenar campos según el tipo de modal
            const datos = response.data;

            $('.solicitud').text(datos.folio);
            if (id_tipo === 1) {
              modal.find('#edit_id_solicitud_muestr').val(id_solicitud);
              modal.find('#id_empresa_muestr').val(response.data.id_empresa).trigger('change');
              modal.find('#fecha_visita_muestr').val(response.data.fecha_visita);
              modal.find('#id_instalacion_dic23').data('selected', response.data.id_instalacion);

              if (response.caracteristicas && response.caracteristicas.id_guia) {
                modal.find('#edit_id_guiass').data('selected', response.caracteristicas.id_guia);
              } else {
                modal.find('#edit_id_guiass').val('');
              }
              modal.find('#edit_info_adicional_muestr').val(response.data.info_adicional);
            }

            if (id_tipo === 2) {
              modal.find('#edit_id_solicitud_vig').val(id_solicitud);
              modal.find('#edit_id_empresa_vig').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita_vig').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_vig').data('selected', response.data.id_instalacion);

              // Acceder al campo `punto_reunion` desde `caracteristicas`
              if (response.caracteristicas && response.caracteristicas.id_lote_granel) {
                modal.find('#edit_id_lote_granel_vig').val(response.caracteristicas.id_lote_granel);
              } else {
                modal.find('#edit_id_lote_granel_vig').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_categoria) {
                modal.find('#edit_id_categoria_vig').val(response.caracteristicas.id_categoria);
              } else {
                modal.find('#edit_id_categoria_vig').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_clase) {
                modal.find('#edit_id_clase_vig').val(response.caracteristicas.id_clase);
              } else {
                modal.find('#edit_id_clase_vig').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_tipo_maguey) {
                const idTipos = response.caracteristicas.id_tipo_maguey; // Asegúrate de que sea un arreglo
                modal.find('#edit_id_tipo_vig').val(idTipos).trigger('change'); // Asigna los valores seleccionados
              } else {
                modal.find('#edit_id_tipo_vig').val([]).trigger('change'); // Si no hay valores, limpia el select
              }

              if (response.caracteristicas && response.caracteristicas.analisis) {
                modal.find('#edit_analisis_vig').val(response.caracteristicas.analisis);
              } else {
                modal.find('#edit_analisis_vig').val('');
              }
              if (response.caracteristicas && response.caracteristicas.cont_alc) {
                modal.find('#edit_volumen_vig').val(response.caracteristicas.cont_alc);
              } else {
                modal.find('#edit_volumen_vig').val('');
              }
              if (response.caracteristicas && response.caracteristicas.fecha_corte) {
                modal.find('#edit_fecha_corte_vig').val(response.caracteristicas.fecha_corte);
              } else {
                modal.find('#edit_fecha_corte_vig').val('');
              }
              if (response.caracteristicas && response.caracteristicas.kg_maguey) {
                modal.find('#edit_kg_maguey_vig').val(response.caracteristicas.kg_maguey);
              } else {
                modal.find('#edit_kg_maguey_vig').val('');
              }
              if (response.caracteristicas && response.caracteristicas.cant_pinas) {
                modal.find('#edit_cant_pinas_vig').val(response.caracteristicas.cant_pinas);
              } else {
                modal.find('#edit_cant_pinas_vig').val('');
              }
              if (response.caracteristicas && response.caracteristicas.art) {
                modal.find('#edit_art_vig').val(response.caracteristicas.art);
              } else {
                modal.find('#edit_art_vig').val('');
              }
              if (response.caracteristicas && response.caracteristicas.etapa) {
                modal.find('#edit_etapa_vig').val(response.caracteristicas.etapa);
              } else {
                modal.find('#edit_etapa_vig').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_guias) {
                modal.find('#edit_edit_id_guias_vigiP').data('selected', response.caracteristicas.id_guias);
              } else {
                modal.find('#edit_edit_id_guias_vigiPs').val('');
              }
              if (response.caracteristicas && response.caracteristicas.nombre_predio) {
                modal.find('#edit_nombre_predio_vig').val(response.caracteristicas.nombre_predio);
              } else {
                modal.find('#edit_nombre_predio_vig').val('');
              }
              modal.find('#edit_info_adicional_vig').val(response.data.info_adicional);

              //Muestreo lote a granel
            } else if (id_tipo === 3) {
              modal.find('#edit_id_solicitud_muestreo').val(id_solicitud);
              modal.find('#edit_id_empresa_muestreo').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_muestreo').data('selected', response.data.id_instalacion);

              if (response.caracteristicas && response.caracteristicas.id_lote_granel) {
                modal.find('#edit_id_lote_granel_muestreo').data('selected', response.caracteristicas.id_lote_granel).trigger('change');
              } else {
                modal.find('#edit_id_lote_granel_muestreo').val('');
              }
              if (response.caracteristicas && response.caracteristicas.tipo_analisis) {
                modal.find('#edit_destino_lote').val(response.caracteristicas.tipo_analisis).trigger('change');
              } else {
                modal.find('#edit_destino_lote').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_categoria_muestreo) {
                modal.find('#edit_id_categoria_muestreo_id').val(response.caracteristicas.id_categoria_muestreo);
              } else {
                modal.find('#edit_id_categoria_muestreo_id').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_clase_muestreo) {
                modal.find('#edit_id_clase_muestreo_id').val(response.caracteristicas.id_clase_muestreo);
              } else {
                modal.find('#edit_id_clase_muestreo_id').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_tipo_maguey_muestreo) {
                modal.find('#edit_id_tipo_maguey_muestreo_ids').val(response.caracteristicas.id_tipo_maguey_muestreo);
              } else {
                modal.find('#edit_id_tipo_maguey_muestreo_ids').val('');
              }
              if (response.caracteristicas) {
                // Categoría
                modal.find('#edit_id_categoria_muestreo').val(response.caracteristicas.categoria || 'N/A');

                // Clase
                modal.find('#edit_id_clase_muestreo').val(response.caracteristicas.clase || 'N/A');
                // Tipos de Maguey
                modal.find('#edit_id_tipo_maguey_muestreo').val(
                    response.caracteristicas.nombre.join(', ') || 'N/A'
                );
            }
              if (response.caracteristicas && response.caracteristicas.analisis_muestreo) {
                modal.find('#edit_analisis_muestreo').val(response.caracteristicas.analisis_muestreo);
              } else {
                modal.find('#edit_analisis_muestreo').val('');
              }
              if (response.caracteristicas && response.caracteristicas.volumen_muestreo) {
                modal.find('#edit_volumen_muestreo').val(response.caracteristicas.volumen_muestreo);
              } else {
                modal.find('#edit_volumen_muestreo').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_certificado_muestreo) {
                modal.find('#edit_id_certificado_muestreo').val(response.caracteristicas.id_certificado_muestreo);
              } else {
                modal.find('#edit_id_certificado_muestreo').val('');
              }
              modal.find('#edit_info_adicional').val(response.data.info_adicional);
              //Vigilancia solicitud de vigilancia traslado lotes
            } else if (id_tipo === 4) {
              modal.find('#edit_id_solicitud_traslado').val(id_solicitud);
              modal.find('#edit_id_empresa_traslado').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_traslado').data('selected', response.data.id_instalacion);
              modal.find('#instalacion_id_traslado').val(response.data.id_instalacion);


              if (response.caracteristicas) {
                modal.find('#lote_id_traslado').val(response.caracteristicas.id_lote_granel || '');
                modal.find('#edit_id_lote_granel_traslado').val(response.caracteristicas.id_lote_granel || '');
                modal.find('#edit_id_categoria_traslado').val(response.caracteristicas.id_categoria_traslado || '');
                modal.find('#edit_id_clase_traslado').val(response.caracteristicas.id_clase_traslado || '');
                modal.find('#edit_id_tipo_maguey_traslado').val(response.caracteristicas.id_tipo_maguey_traslado || '');
                modal.find('#edit_id_salida').val(response.caracteristicas.id_salida || '');
                modal.find('#edit_id_contenedor').val(response.caracteristicas.id_contenedor || '');
                modal.find('#edit_id_sobrante').val(response.caracteristicas.id_sobrante || '');
                modal.find('#edit_id_vol_actual').val(response.caracteristicas.id_vol_actual || '');
                modal.find('#edit_id_vol_traslado').val(response.caracteristicas.id_vol_traslado || '');
                modal.find('#edit_id_vol_res').val(response.caracteristicas.id_vol_res || '');
                modal.find('#edit_analisis_traslado').val(response.caracteristicas.analisis_traslado || '');
                modal.find('#edit_volumen_traslado').val(response.caracteristicas.volumen_traslado || '');
                modal.find('#edit_id_certificado_traslado').val(response.caracteristicas.id_certificado_traslado || '');
              }

              if (response.caracteristicas && response.caracteristicas.instalacion_vigilancia) {
                modal
                  .find('#edit_instalacion_vigilancia')
                  .val(response.caracteristicas.instalacion_vigilancia) // Establece el valor
                  .trigger('change'); // Asegúrate de que select2 lo actualice visualmente
              } else {
                modal.find('#edit_instalacion_vigilancia').val('').trigger('change');
              }

              modal.find('#edit_info_adicional').val(response.data.info_adicional);
            } else if (id_tipo === 5) {
              modal.find('#edit_id_solicitud_inspeccion').val(id_solicitud);
              modal.find('#edit_id_empresa_inspeccion').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_inspeccion').data('selected', response.data.id_instalacion);

              if (response.caracteristicas && response.caracteristicas.id_lote_granel_inspeccion) {
                modal.find('#edit_id_lote_granel_inspeccion').val(response.caracteristicas.id_lote_granel_inspeccion);
              } else {
                modal.find('#edit_id_lote_granel_inspeccion').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_categoria_inspeccion) {
                modal.find('#edit_id_categoria_inspeccion').val(response.caracteristicas.id_categoria_inspeccion);
              } else {
                modal.find('#edit_id_categoria_inspeccion').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_clase_inspeccion) {
                modal.find('#edit_id_clase_inspeccion').val(response.caracteristicas.id_clase_inspeccion);
              } else {
                modal.find('#edit_id_clase_inspeccion').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_tipo_maguey_inspeccion) {
                modal.find('#edit_id_tipo_maguey_inspeccion').val(response.caracteristicas.id_tipo_maguey_inspeccion);
              } else {
                modal.find('#edit_id_tipo_maguey_inspeccion').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_marca) {
                modal.find('#edit_id_marca').val(response.caracteristicas.id_marca);
              } else {
                modal.find('#edit_id_marca').val('');
              }
              if (response.caracteristicas && response.caracteristicas.volumen_inspeccion) {
                modal.find('#edit_volumen_inspeccion').val(response.caracteristicas.volumen_inspeccion);
              } else {
                modal.find('#edit_volumen_inspeccion').val('');
              }
              if (response.caracteristicas && response.caracteristicas.analisis_inspeccion) {
                modal.find('#edit_analisis_inspeccion').val(response.caracteristicas.analisis_inspeccion);
              } else {
                modal.find('#edit_analisis_inspeccion').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_tipo_inspeccion) {
                modal.find('#edit_id_tipo_inspeccion').val(response.caracteristicas.id_tipo_inspeccion);
              } else {
                modal.find('#edit_id_tipo_inspeccion').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_cantidad_bote) {
                modal.find('#edit_id_cantidad_bote').val(response.caracteristicas.id_cantidad_bote);
              } else {
                modal.find('#edit_id_cantidad_bote').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_cantidad_caja) {
                modal.find('#edit_id_cantidad_caja').val(response.caracteristicas.id_cantidad_caja);
              } else {
                modal.find('#edit_id_cantidad_caja').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_inicio_envasado) {
                modal.find('#edit_id_inicio_envasado').val(response.caracteristicas.id_inicio_envasado);
              } else {
                modal.find('#edit_id_inicio_envasado').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_previsto) {
                modal.find('#edit_id_previsto').val(response.caracteristicas.id_previsto);
              } else {
                modal.find('#edit_id_previsto').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_certificado_inspeccion) {
                modal.find('#edit_id_certificado_inspeccion').val(response.caracteristicas.id_certificado_inspeccion);
              } else {
                modal.find('#edit_id_certificado_inspeccion').val('');
              }
              modal.find('#edit_info_adicional').val(response.data.info_adicional);
              //Inspeccion ingreso barricada
            } else if (id_tipo === 7) {
              modal.find('#edit_id_solicitud_barricada').val(id_solicitud);
              modal.find('#edit_id_empresa_barricada').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_barricada').data('selected', response.data.id_instalacion);
              modal.find('#instalacion_ingreso').val(response.data.id_instalacion);
              modal.find('#lote_ingreso').val(response.caracteristicas.id_lote_granel);

              if (response.caracteristicas) {
                modal.find('#edit_id_lote_granel_barricada').val(response.caracteristicas.id_lote_granel || '');
                modal.find('#edit_id_categoria_barricada_id').val(response.caracteristicas.id_categoria || '');
                modal.find('#edit_id_categoria_barricada').val(response.caracteristicas.categoria || '');
                modal.find('#edit_id_clase_barricada_id').val(response.caracteristicas.id_clase || '');
                modal.find('#edit_id_clase_barricada').val(response.caracteristicas.clase || '');
                modal.find('#edit_id_tipo_maguey_barricada_ids').val(response.caracteristicas.id_tipo_maguey || '');
                modal.find('#edit_id_tipo_maguey_barricada').val(
                  response.caracteristicas.nombre.join(', ') || 'N/A'
              );
                modal.find('#edit_volumen_ingresado').val(response.caracteristicas.volumen_ingresado || '');
                modal.find('#edit_analisis_barricada').val(response.caracteristicas.analisis || '');
                modal.find('#edit_alc_vol_barrica').val(response.caracteristicas.cont_alc || '');
                modal.find('#edit_tipo_lote').val(response.caracteristicas.tipoIngreso || '');
                modal.find('#edit_fecha_inicio').val(response.caracteristicas.fecha_inicio || '');
                modal.find('#edit_fecha_termino').val(response.caracteristicas.fecha_termino || '');
                modal.find('#edit_material').val(response.caracteristicas.material || '');
                modal.find('#edit_capacidad').val(response.caracteristicas.capacidad || '');
                modal.find('#edit_num_recipientes').val(response.caracteristicas.num_recipientes || '');
                modal.find('#edit_tiempo_dura').val(response.caracteristicas.tiempo_dura || '');
                modal.find('#edit_id_certificado_barricada').val(response.caracteristicas.id_certificado || '');
              }

              modal.find('#edit_info_adicional').val(response.data.info_adicional);

              //liberacion inspeccion
            }
            else if (id_tipo === 8) {
              modal.find('#edit_id_solicitud_liberacion_terminado').val(id_solicitud);
              modal.find('#edit_id_empresa_solicitud_lib_ter').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_liberacion_terminado').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_lib_ter').data('selected', response.data.id_instalacion).trigger('change');

              if (response.caracteristicas) {
                modal.find('#edit_id_lote_envasado_lib_ter').data('selected', response.caracteristicas.id_lote_envasado || '');
                modal.find('#edit_id_categoria_lib_ter').val(response.caracteristicas.categoria || '');
                modal.find('#edit_id_categoria_lib_ter_id').val(response.caracteristicas.id_categoria || '');
                modal.find('#edit_id_clase_lib_ter').val(response.caracteristicas.clase || '');
                modal.find('#edit_id_clase_lib_ter_id').val(response.caracteristicas.id_clase || '');
                modal.find('#edit_id_tipo_maguey_lib_ter').val(response.caracteristicas.nombre || '');
                modal.find('#edit_id_tipo_maguey_lib_ter_ids').val(response.caracteristicas.id_tipo_maguey || '');
                modal.find('#edit_marca_lib_ter').val(response.caracteristicas.marca || '');
                modal.find('#edit_marca_lib_ter_id').val(response.caracteristicas.id_marca || '');
                modal.find('#edit_porcentaje_alcohol_lib_ter').val(response.caracteristicas.cont_alc || '');
                modal.find('#edit_analisis_fisiq_lib_ter').val(response.caracteristicas.analisis || '');
                modal.find('#edit_can_botellas_lib_ter').val(response.caracteristicas.cantidad_botellas || '');
                modal.find('#edit_presentacion_lib_ter').val(response.caracteristicas.presentacion || '');
                modal.find('#edit_can_pallets_lib_ter').val(response.caracteristicas.cantidad_pallets || '');
                modal.find('#edit_cajas_por_pallet_lib_ter').val(response.caracteristicas.cajas_por_pallet || '');
                modal.find('#edit_botellas_por_caja_lib_ter').val(response.caracteristicas.botellas_por_caja || '');
                modal.find('#edit_hologramas_utilizados_lib_ter').val(response.caracteristicas.hologramas_utilizados || '');
                modal.find('#edit_hologramas_mermas_lib_ter').val(response.caracteristicas.hologramas_mermas || '');
                modal.find('#edit_certificado_nom_granel_lib_ter').val(response.caracteristicas.certificado_nom_granel || '');
              }

              modal.find('#edit_comentarios_lib_ter').val(response.data.info_adicional);
            }
            else if (id_tipo === 9) {
              modal.find('#edit_id_solicitud_liberacion').val(id_solicitud);
              modal.find('#edit_id_empresa_liberacion').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_liberacion').data('selected', response.data.id_instalacion);

              // Mapeo de campos de `caracteristicas` a los inputs correspondientes
              const fields = {
                  id_lote_granel: '#edit_id_lote_granel_liberacion',
                  id_categoria: '#edit_id_categoria_liberacion_id',
                  categoria: '#edit_id_categoria_liberacion',
                  id_clase: '#edit_id_clase_liberacion_id',
                  clase: '#edit_id_clase_liberacion',
                  id_tipo_maguey: '#edit_id_tipo_maguey_liberacion_ids',
                  nombre: '#edit_id_tipo_maguey_liberacion',
                  edad: '#edit_id_edad_liberacion',
                  analisis: '#edit_analisis_liberacion',
                  cont_alc: '#edit_volumen_liberacion',
                  tipoLiberacion: '#edit_tipo_lote_lib',
                  fecha_inicio: '#edit_fecha_inicio_lib',
                  fecha_termino: '#edit_fecha_termino_lib',
                  material: '#edit_material_liberacion',
                  capacidad: '#edit_capacidad_liberacion',
                  num_recipientes: '#edit_num_recipientes_lib',
                  tiempo_dura: '#edit_tiempo_dura_lib',
                  id_certificado: '#edit_id_certificado_liberacion'
              };

              // Iterar sobre el mapeo y asignar valores
              Object.entries(fields).forEach(([key, selector]) => {
                  const value = response.caracteristicas?.[key] || ''; // Asignar '' si no existe
                  modal.find(selector).val(value);
              });

              modal.find('#edit_info_adicional').val(response.data.info_adicional || '');
          }
           else if (id_tipo === 10) {
              modal.find('#id_solicitud_geo').val(id_solicitud);
              modal.find('#edit_id_empresa_geo').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita_geo').val(response.data.fecha_visita);
              modal.find('#edit_id_predio_geo').data('selected', response.data.id_predio);
              // Acceder al campo `punto_reunion` desde `caracteristicas`
              if (response.caracteristicas && response.caracteristicas.punto_reunion) {
                modal.find('#edit_punto_reunion_geo').val(response.caracteristicas.punto_reunion);
              } else {
                modal.find('#edit_punto_reunion_geo').val(''); // Si no existe, deja vacío
              }
              modal.find('#edit_info_adicional_geo').val(response.data.info_adicional);
              // Otros campos específicos para tipo 10
              }
              else if (id_tipo === 11) {

                  modal.find('.id_solicitud').val(id_solicitud);
                  modal.find('#id_empresa_solicitud_exportacion_edit').val(response.data.id_empresa).trigger('change');
                  modal.find('#fecha_visita_edit').val(response.data.fecha_visita);
                  modal.find('.instalacion_id').val(response.data.id_instalacion);
                  if (response.caracteristicas) {
                    modal.find('#tipo_solicitud_edit').val(response.caracteristicas.tipo_solicitud).trigger('change');
                    modal.find('.direccion_id').val(response.caracteristicas.direccion_destinatario);
                    modal.find('.aduana_salida').val(response.caracteristicas.aduana_salida);
                    modal.find('.no_pedido').val(response.caracteristicas.no_pedido);
                    modal.find('.instalacion_envasado_id').val(response.caracteristicas.id_instalacion_envasado);
                    modal.find('.etiqueta_id').val(response.caracteristicas.id_etiqueta);
                    var lotesEnvasado = response.caracteristicas.detalles.map(function(detalle) {
                      return detalle.id_lote_envasado;
                  });

                    modal.find('.lote_envasado_id').val(lotesEnvasado.join(','));
                    var cantidadDeLotes = response.caracteristicas.detalles.length;

                    // Primero eliminar todos los bloques extras si es necesario
                    if (cantidadDeLotes === 1) {
                        // Mantener solo el primer bloque
                        $('#sections-container2').not(':first').remove();
                        modal.find('#cantidad_cajas0').val(response.caracteristicas.detalles[0].cantidad_cajas);
                        modal.find('#cantidad_botellas0').val(response.caracteristicas.detalles[0].cantidad_botellas);
                    } else {
                        // Si hay más de uno, agregamos los que faltan
                        for (var i = 1; i < cantidadDeLotes; i++) {
                            $('#add-characteristics').click();
                            modal.find('#cantidad_cajas'+(i-1)).val(response.caracteristicas.detalles[i-1].cantidad_cajas);
                            modal.find('#cantidad_botellas'+(i-1)).val(response.caracteristicas.detalles[i-1].cantidad_botellas);
                        }
                    }
                }

                modal.find('#comentarios_edit').val(response.data.info_adicional);

            } else if (id_tipo === 14) {
              // Aquí va el tipo correspondiente para tu caso
              // Llenar los campos del modal con los datos de la solicitud
              modal.find('#edit_id_solicitud').val(id_solicitud);
              modal.find('#edit_id_empresa').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion').val(response.data.id_instalacion).trigger('change');
              modal.find('#edit_info_adicional').val(response.data.info_adicional);
              modal.find('#instalacion_id').val(response.data.id_instalacion);
              modal.find('#instalacion_id').val(response.data.id_instalacion);

              // Aquí vamos a manejar las características (clases, categorías, renovacion)
              if (response.caracteristicas) {
                // Llenar las categorías si están presentes
                if (response.caracteristicas.categorias) {
                  modal.find('#edit_categoria_in').val(response.caracteristicas.categorias).trigger('change');
                }
                // Llenar las clases si están presentes
                if (response.caracteristicas.clases) {
                  modal.find('#edit_clases_in').val(response.caracteristicas.clases).trigger('change');
                }
                // Llenar la renovación si está presente
                if (response.caracteristicas.renovacion) {
                  modal.find('#edit_renovacion_in').val(response.caracteristicas.renovacion).trigger('change');
                }
              } else {
                // Si no hay características, vaciar los campos correspondientes
                modal.find('#edit_categoria_in').val([]).trigger('change');
                modal.find('#edit_clases_in').val([]).trigger('change');
                modal.find('#edit_renovacion_in').val('').trigger('change');
              }
            }
            // Muestra el modal después de rellenar los datos
            modal.modal('show');
          } else {
            console.error('Error al cargar los datos:', response.message);
          }
        },
        error: function (xhr, status, error) {
          console.error('Error en la solicitud:', error);
        }
      });
    });
  });


  /* formulario para enviar los datos y actualizar */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de actualización
    const formUpdate = document.getElementById('editFormTipo10');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha y hora para la inspección.'
            }
          }
        },
        id_predio: {
          validators: {
            notEmpty: {
              message: 'Selecciona un predio para la inspección.'
            }
          }
        },
        punto_reunion: {
          validators: {
            notEmpty: {
              message: 'Introduce la dirección para el punto de reunión.'
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
    }).on('core.form.valid', function (e) {
      var formData = new FormData(formUpdate);
       $('#btnEditGeo').prop('disabled', true);

        $('#btnEditGeo').html('<span class="spinner-border spinner-border-sm me-2"></span> Actualizando...');
        setTimeout(function () {
            $('#btnEditGeo').prop('disabled', false);
            $('#btnEditGeo').html('<i class="ri-add-line"></i> Registrar');
        }, 2000);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#id_solicitud_geo').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editClienteModalTipo10').modal('hide'); // Oculta el modal
          $('#editFormTipo10')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);


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
  });
  /*funcion para solicitud de dictaminacion  */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de dictaminación
    const formDictaminacion = document.getElementById('addEditSolicitud');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona una instalación.'
            }
          }
        },
        'clases[]': {
          validators: {
            notEmpty: {
              message: 'Selecciona al menos una clase.'
            }
          }
        },
        'categorias[]': {
          validators: {
            notEmpty: {
              message: 'Selecciona al menos una categoria.'
            }
          }
        },
        renovacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona si es renovación o no.'
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
    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(formDictaminacion);
       $('#btnEditDicIns').prop('disabled', true);

        $('#btnEditDicIns').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
        setTimeout(function () {
            $('#btnEditDicIns').prop('disabled', false);
            $('#btnEditDicIns').html('<i class="ri-add-line"></i> Registrar');
        }, 2000);
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editSolicitudDictamen').modal('hide');
          $('#addEditSolicitud')[0].reset();
          $('.select2').val(null).trigger('change');

          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);


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
  });
  /*  */
  /* formulario para enviar los datos y actualizar */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de actualización
    const formUpdate = document.getElementById('editVigilanciaProduccionForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha y hora para la inspección.'
            }
          }
        },
        id_predio: {
          validators: {
            notEmpty: {
              message: 'Selecciona un predio para la inspección.'
            }
          }
        },
        punto_reunion: {
          validators: {
            notEmpty: {
              message: 'Introduce la dirección para el punto de reunión.'
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
    }).on('core.form.valid', function (e) {
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);

      // Agregar los valores seleccionados del select múltiple al FormData
      $('#edit_id_tipo_vig')
        .find('option:selected')
        .each(function () {
          formData.append('edit_id_tipo_vig[]', $(this).val());
        });

      $('#edit_edit_id_guias_vigiP')
        .find('option:selected')
        .each(function () {
          formData.append('id_guias[]', $(this).val());
        });

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_vig').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editVigilanciaProduccion').modal('hide'); // Oculta el modal
          $('#editVigilanciaProduccionForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
        // Recarga la tabla manteniendo la página actual
        $('.datatables-solicitudes').DataTable().ajax.reload(null, false);

          console.log(response);

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
  });
  //metodo update para muestrteo de lote agranel
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editMuestreoLoteAgranelForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona una instalación.'
            }
          }
        },
        id_lote_granel_muestreo: {
          validators: {
            notEmpty: {
              message: 'Selecciona un lote a granel.'
            }
          }
        },
        destino_lote: {
          validators: {
            notEmpty: {
              message: 'Selecciona un tipo.'
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
    }).on('core.form.valid', function (e) {
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_muestreo').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editMuestreoLoteAgranel').modal('hide'); // Oculta el modal
          $('#editMuestreoLoteAgranelForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);

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

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al actualizar la solicitud de muestreo',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //medoto update para viligancia tarslado
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editVigilanciaTrasladoForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona una instalación.'
            }
          }
        },
        id_lote_granel_traslado: {
          validators: {
            notEmpty: {
              message: 'Selecciona un lote a granel.'
            }
          }
        },
        id_vol_traslado: {
          validators: {
            notEmpty: {
              message: 'Ingresa el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen debe ser un número válido.'
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
    }).on('core.form.valid', function (e) {
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_traslado').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editVigilanciaTraslado').modal('hide'); // Oculta el modal
          $('#editVigilanciaTrasladoForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla

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

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al actualizar la vigilancia en el traslado del lote',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //metodo para actualizar inspeccion barricada
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editInspeccionIngresoBarricadaForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona una instalación.'
            }
          }
        },
        id_lote_granel_barricada: {
          validators: {
            notEmpty: {
              message: 'Selecciona un lote a granel.'
            }
          }
        },
        volumen_barricada: {
          validators: {
            notEmpty: {
              message: 'Ingresa el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen debe ser un número válido.'
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
    }).on('core.form.valid', function (e) {
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_barricada').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editInspeccionIngresoBarricada').modal('hide'); // Oculta el modal
          $('#editInspeccionIngresoBarricadaForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);// Recarga la tabla

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

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al actualizar la inspección ingreso a la barrica/contenedor de vidrio',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
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

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editInspeccionEnvasadoForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona una instalación.'
            }
          }
        },
        id_lote_granel_inspeccion: {
          validators: {
            notEmpty: {
              message: 'Selecciona un lote a granel.'
            }
          }
        },
        volumen_inspeccion: {
          validators: {
            notEmpty: {
              message: 'Ingresa el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen debe ser un número válido.'
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
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_inspeccion').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editInspeccionEnvasado').modal('hide'); // Oculta el modal
          $('#editInspeccionEnvasadoForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(); // Recarga la tabla

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
  });

  //metodo para liberacion
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editInspeccionLiberacionForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona una instalación.'
            }
          }
        },
        id_lote_granel_liberacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona un lote a granel.'
            }
          }
        },
        volumen_liberacion: {
          validators: {
            notEmpty: {
              message: 'Ingresa el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen debe ser un número válido.'
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
    }).on('core.form.valid', function (e) {
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_liberacion').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editInspeccionLiberacion').modal('hide'); // Oculta el modal
          $('#editInspeccionLiberacionForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla

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

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al actualizar la inspección de liberación.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
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

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editLiberacionProductoForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona una instalación.'
            }
          }
        },
        id_lote_envasado: {
          validators: {
            notEmpty: {
              message: 'Selecciona un lote envasado.'
            }
          }
        },
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
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);
       $('#btneditlib').prop('disabled', true);

        $('#btneditlib').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
        setTimeout(function () {
            $('#btneditlib').prop('disabled', false);
            $('#btneditlib').html('<i class="ri-add-line"></i> Editar');
        }, 2000);
      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_liberacion_terminado').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editLiberacionProducto').modal('hide'); // Oculta el modal
          $('#editLiberacionProductoForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla
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
  });

  //actualizar muestreo lote
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de muestreo
    const formDictaminacion = document.getElementById('editRegistrarSolicitudMuestreoAgave');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona una instalación.'
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
    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(formDictaminacion);

      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_muestr').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editSolicitudMuestreoAgave').modal('hide');
          $('#editRegistrarSolicitudMuestreoAgave')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);
          console.log(response);

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
  });

    //Editar pedidos para exportación
    $(function () {
      // Configuración CSRF para Laravel
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // Inicializar FormValidation para la solicitud de muestreo
      const formDictaminacion = document.getElementById('editPedidoExportacionForm');
      const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
        fields: {
        'cantidad_botellas[0]': {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca el número de botellas'
            }
          }
        },
        'cantidad_cajas[0]': {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca el número de cajas'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de la visita.'
            }
          }
        },

        id_etiqueta: {
          selector: "input[name='id_etiqueta']",
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una etiqueta.'
            }
          }
        },

        direccion_destinatario: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una dirección del destinatario.'
            }
          }
        },
        aduana_salida: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la aduana de salida.'
            }
          }
        },
        no_pedido: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de pedido.'
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
      }).on('core.form.valid', function (e) {
        // Validar el formulario
        var formData = new FormData(formDictaminacion);

           // Construir las características como un JSON completo
      const caracteristicas = {
        tipo_solicitud: $('#tipo_solicitud_edit').val(),
        direccion_destinatario: $('#direccion_destinatario_ex_edit').val(),
        aduana_salida: $('[name="aduana_salida"]').val(),
        no_pedido: $('[name="no_pedido"]').val(),
        factura_proforma: $('[name="factura_proforma"]')[0].files[0], // Archivo
        factura_proforma_cont: $('[name="factura_proforma_cont"]')[0].files[0], // Archivo
        detalles: [] // Aquí van las filas de la tabla de características
      };

      // Agregar cada fila de la tabla dinámica al JSON
      $('#tabla-marcas tbody tr').each(function () {
        const row = $(this);
        caracteristicas.detalles.push({
          lote_envasado: row.find('.evasado_export').val(),
          cantidad_botellas: row.find('.cantidad-botellas').val(),
          cantidad_cajas: row.find('.cantidad-cajas').val(),
          presentacion: row.find('.presentacion').val()
        });
      });

      // Añadir el JSON al FormData como string
      formData.append('caracteristicas', JSON.stringify(caracteristicas));

        $.ajax({
          url: '/actualizar-solicitudes/' + $('#solicitud_id_pedidos').val(),
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#editPedidoExportacion').modal('hide');
            $('#editPedidoExportacionForm')[0].reset();
            $('.select2').val(null).trigger('change');
            $('.datatables-solicitudes').DataTable().ajax.reload(null, false);


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
    });

  ///
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de muestreo de agave
    const form3 = document.getElementById('addRegistrarSolicitudMuestreoAgave');
    const fv3 = FormValidation.formValidation(form3, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
        punto_reunion: {
          validators: {
            notEmpty: {
              message: 'Introduce la dirección para el punto de reunión.'
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
    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(form3);

      $.ajax({
        url: '/registrar-solicitud-muestreo-agave',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudMuestreoAgave').modal('hide');
          $('#addRegistrarSolicitudMuestreoAgave')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud de muestreo registrado exitosamente.',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    // Inicializar FormValidation para la solicitud de dictaminación de instalaciones
    const form = document.getElementById('addRegistrarSolicitud');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona la instalación'
            }
          }
        },
        renovacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona la opción'
            }
          }
        },
        'clases[]': {
          validators: {
            notEmpty: {
              message: 'Selecciona la clase'
            }
          }
        },
        'categorias[]': {
          validators: {
            notEmpty: {
              message: 'Selecciona la clase'
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
    }).on('core.form.valid', function (e) {
      var formData = new FormData(form);
             $('#btnRegistrarDicIns').prop('disabled', true);

        $('#btnRegistrarDicIns').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
        setTimeout(function () {
            $('#btnRegistrarDicIns').prop('disabled', false);
            $('#btnRegistrarDicIns').html('<i class="ri-add-line"></i> Registrar');
        }, 2000);

      $.ajax({
        url: '/solicitudes-list',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudDictamen').modal('hide');
          $('#addRegistrarSolicitud')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud registrada correctamente',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    // Inicializar select2 y manejar eventos de cambio por "name"
    $(
      'select[name="clases[]"], select[name="categorias[]"], select[name="id_instalacion"], select[name="id_empresa"]'
    ).on('change', function () {
      // Revalidar el campo cuando se cambia el valor del select2
      fv.revalidateField($(this).attr('name'));
    });

    // Inicializar FormValidation para la solicitud de georeferenciacion
    const form2 = document.getElementById('addRegistrarSolicitudGeoreferenciacion');
    const fv2 = FormValidation.formValidation(form2, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
        punto_reunion: {
          validators: {
            notEmpty: {
              message: 'Introduce la dirección para el punto de reunión.'
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
    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(form2);
       $('#btnRegistrarGeo').prop('disabled', true);

        $('#btnRegistrarGeo').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
        setTimeout(function () {
            $('#btnRegistrarGeo').prop('disabled', false);
            $('#btnRegistrarGeo').html('<i class="ri-add-line"></i> Registrar');
        }, 2000);
      $.ajax({
        url: '/registrar-solicitud-georeferenciacion',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudGeoreferenciacion').modal('hide');
          $('#addRegistrarSolicitudGeoreferenciacion')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud registrada correctamente',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

  //new new
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('editInstalacionForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona una empresa.'
            }
          }
        },
        tipo: {
          validators: {
            notEmpty: {
              message: 'Selecciona un tipo de instalación.'
            }
          }
        },
        estado: {
          validators: {
            notEmpty: {
              message: 'Selecciona un estado.'
            }
          }
        },
        direccion_completa: {
          validators: {
            notEmpty: {
              message: 'Ingrese la dirección completa.'
            }
          }
        },
        certificacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona el tipo de certificación.'
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
    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(form);

      $.ajax({
        url: baseUrl + 'instalaciones/' + $('#editInstalacionForm').data('id'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
          xhr.setRequestHeader('X-HTTP-Method-Override', 'PUT');
        },
        success: function (response) {
          dt_instalaciones_table.ajax.reload();
          $('#modalEditInstalacion').modal('hide');
          $('#editInstalacionForm')[0].reset();
          $('.select2').val(null).trigger('change');

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

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al actualizar la instalación',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
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

      // Inicializar FormValidation para el formulario de edición
      const formUpdate = document.getElementById('editLiberacionProductoForm');
      const fvUpdate = FormValidation.formValidation(formUpdate, {
        fields: {
          id_empresa: {
            validators: {
              notEmpty: {
                message: 'Selecciona el cliente.'
              }
            }
          },
          fecha_visita: {
            validators: {
              notEmpty: {
                message: 'Selecciona la fecha y hora para la inspección.'
              }
            }
          },
          id_instalacion: {
            validators: {
              notEmpty: {
                message: 'Selecciona una instalación.'
              }
            }
          },
          id_lote_envasado: {
            validators: {
              notEmpty: {
                message: 'Selecciona un lote envasado.'
              }
            }
          },
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
        // Obtener los datos del formulario
        var formData = new FormData(formUpdate);

        // Hacer la solicitud AJAX
        $.ajax({
          url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_liberacion_terminado').val(),
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#editLiberacionProducto').modal('hide'); // Oculta el modal
            $('#editLiberacionProductoForm')[0].reset(); // Resetea el formulario
            $('.select2').val(null).trigger('change'); // Resetea los select2
            $('.datatables-solicitudes').DataTable().ajax.reload(); // Recarga la tabla
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
    });


    // Mostrar u ocultar campos adicionales según el tipo de certificación
    $('#edit_certificacion').on('change', function () {
      if ($(this).val() === 'otro_organismo') {
        $('#edit_certificado_otros').removeClass('d-none');

        // Agregar la validación a los campos adicionales
        fv.addField('url[]', {
          validators: {
            notEmpty: {
              message: 'Debes subir un archivo de certificado.'
            },
            file: {
              extension: 'pdf,jpg,jpeg,png',
              type: 'application/pdf,image/jpeg,image/png',
              maxSize: 2097152, // 2 MB en bytes
              message: 'El archivo debe ser un PDF o una imagen (jpg, png) y no debe superar los 2 MB.'
            }
          }
        });

        fv.addField('folio', {
          validators: {
            notEmpty: {
              message: 'El folio o número del certificado es obligatorio.'
            }
          }
        });

        fv.addField('id_organismo', {
          validators: {
            notEmpty: {
              message: 'Selecciona un organismo de certificación.'
            }
          }
        });

        fv.addField('fecha_emision', {
          validators: {
            notEmpty: {
              message: 'La fecha de emisión es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'La fecha de emisión no es válida.'
            }
          }
        });

        fv.addField('fecha_vigencia', {
          validators: {
            notEmpty: {
              message: 'La fecha de vigencia es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'La fecha de vigencia no es válida.'
            }
          }
        });
      } else {
        $('#edit_certificado_otros').addClass('d-none');

        // Quitar la validación de los campos adicionales
        fv.removeField('url[]');
        fv.removeField('folio');
        fv.removeField('id_organismo');
        fv.removeField('fecha_emision');
        fv.removeField('fecha_vigencia');
      }
    });
  });


  //new
  $(document).on('click', '.edit-record', function () {
    var id_instalacion = $(this).data('id');
    var url = baseUrl + 'domicilios/edit/' + id_instalacion;

    // Solicitud para obtener los datos de la instalación
    $.get(url, function (data) {
      if (data.success) {
        var instalacion = data.instalacion;

        // Asignar valores a los campos
        $('#edit_id_empresa').val(instalacion.id_empresa).trigger('change');
        $('#edit_tipo').val(instalacion.tipo).trigger('change');
        $('#edit_estado').val(instalacion.estado).trigger('change');
        $('#edit_direccion').val(instalacion.direccion_completa);

        // Verificar si hay valores en los campos adicionales
        var tieneCertificadoOtroOrganismo =
          instalacion.folio ||
          instalacion.id_organismo ||
          (instalacion.fecha_emision && instalacion.fecha_emision !== 'N/A') ||
          (instalacion.fecha_vigencia && instalacion.fecha_vigencia !== 'N/A') ||
          data.archivo_url;

        if (tieneCertificadoOtroOrganismo) {
          $('#edit_certificacion').val('otro_organismo').trigger('change');
          $('#edit_certificado_otros').removeClass('d-none');

          $('#edit_folio').val(instalacion.folio || '');
          $('#edit_id_organismo')
            .val(instalacion.id_organismo || '')
            .trigger('change');
          $('#edit_fecha_emision').val(instalacion.fecha_emision !== 'N/A' ? instalacion.fecha_emision : '');
          $('#edit_fecha_vigencia').val(instalacion.fecha_vigencia !== 'N/A' ? instalacion.fecha_vigencia : '');

          // Mostrar URL del archivo debajo del campo de archivo
          var archivoUrl = data.archivo_url || '';
          var numCliente = data.numeroCliente;
          if (archivoUrl) {
            try {
              $('#archivo_url_display').html(`
                              <p>Archivo existente:</span> <a href="../files/${numCliente}/${archivoUrl}" target="_blank">${archivoUrl}</a></p>`);
            } catch (e) {
              $('#archivo_url_display').html('URL del archivo no válida.');
            }
          } else {
            $('#archivo_url_display').html('No hay archivo disponible.');
          }
        } else {
          $('#edit_certificacion').val('oc_cidam').trigger('change');
          $('#edit_certificado_otros').addClass('d-none');
          $('#archivo_url_display').html('No hay archivo disponible.');
        }

        // Mostrar el modal
        $('#modalEditInstalacion').modal('show');
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo cargar los datos de la instalación',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error en la solicitud:', textStatus, errorThrown);

      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Error en la solicitud. Inténtalo de nuevo.',
        customClass: {
          confirmButton: 'btn btn-primary'
        }
      });
    });
  });

  // Limpiar los campos del formulario cuando el modal se oculta
  $('#modalEditInstalacion').on('hidden.bs.modal', function () {
    $('#edit_certificado_otros').addClass('d-none');
    $('#archivo_url_display').html('No hay archivo disponible.');

    // Limpiar campos individuales
    $('#edit_id_empresa').val('').trigger('change');
    $('#edit_tipo').val('').trigger('change');
    $('#edit_estado').val('').trigger('change');
    $('#edit_direccion').val('');
    $('#edit_certificacion').val('oc_cidam').trigger('change');
    $('#edit_folio').val('');
    $('#edit_id_organismo').val('').trigger('change');
    $('#edit_fecha_emision').val('');
    $('#edit_fecha_vigencia').val('');
  });

  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Validación del formulario Vigilancia en produccion
    const addVigilanciaProduccionForm = document.getElementById('addVigilanciaProduccionForm');
    const fv5 = FormValidation.formValidation(addVigilanciaProduccionForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de visita.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: function (field, ele) {
            return '.mb-4, .mb-5, .mb-6';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      var formData = new FormData(addVigilanciaProduccionForm);

      // Agregar los valores seleccionados del select múltiple al FormData
      $('#id_tipo_maguey')
        .find('option:selected')
        .each(function () {
          formData.append('id_tipo_maguey[]', $(this).val());
        });

      $('#edit_id_guias_vigiP')
        .find('option:selected')
        .each(function () {
          formData.append('id_guias[]', $(this).val());
        });

      $.ajax({
        url: '/hologramas/storeVigilanciaProduccion', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addVigilanciaProduccion').modal('hide');
          $('#addVigilanciaProduccionForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud vigilancia registrado exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function () {
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar la vigilancia en producción.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

  // Validación del formulario Muestreo Lote Agranel
  const addMuestreoLoteAgranelForm = document.getElementById('addMuestreoLoteAgranelForm');
  const fvMuestreo = FormValidation.formValidation(addMuestreoLoteAgranelForm, {
    fields: {
      id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una empresa.'
          }
        }
      },
      fecha_visita: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese la fecha y hora de la visita.'
          }
        }
      },
      id_instalacion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una instalación.'
          }
        }
      },
      id_lote_granel: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un lote a granel.'
          }
        }
      },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: function (field, ele) {
          return '.mb-4, .mb-5, .mb-6';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    const formData = new FormData(addMuestreoLoteAgranelForm);

    $.ajax({
      url: '/hologramas/storeMuestreoLote', // Actualiza con la URL correcta
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Cerrar modal y reiniciar formulario
        $('#addMuestreoLoteAgranel').modal('hide');
        $('#addMuestreoLoteAgranelForm')[0].reset();
        $('.select2').val(null).trigger('change');
        $('.datatables-solicitudes').DataTable().ajax.reload();

        // Mostrar alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Solicitud de Muestreo registrado exitosamente.',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function () {
        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar el muestreo.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });


  // Validación del formulario Inspección Ingreso Barricada
  const addInspeccionIngresoBarricadaForm = document.getElementById('addInspeccionIngresoBarricadaForm');
  const fvBarricada = FormValidation.formValidation(addInspeccionIngresoBarricadaForm, {
    fields: {
      id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un cliente.'
          }
        }
      },
      fecha_visita: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese la fecha y hora sugerida para la inspección.'
          }
        }
      },
      id_instalacion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una instalación.'
          }
        }
      },
      id_lote_granel_barricada: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un lote a granel.'
          }
        }
      },
      tipo_lote: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un tipo.'
          }
        }
      },
      analisis_barricada: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el análisis fisicoquímico.'
          }
        }
      },
      volumen_barricada: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el porcentaje de alcohol.'
          },
          numeric: {
            message: 'Por favor ingrese un valor numérico válido.'
          }
        }
      },
      fecha_inicio: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese la fecha de inicio.'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: function (field, ele) {
          return '.mb-4, .mb-5, .mb-6';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    const formData = new FormData(addInspeccionIngresoBarricadaForm);

    $.ajax({
      url: '/hologramas/storeInspeccionBarricada', // Actualiza con la URL correcta
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Cerrar modal y reiniciar formulario
        $('#addInspeccionIngresoBarricada').modal('hide');
        $('#addInspeccionIngresoBarricadaForm')[0].reset();
        $('.select2').val(null).trigger('change');
        $('.datatables-solicitudes').DataTable().ajax.reload();

        // Mostrar alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Inspección barricada registrada exitosamente.',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function () {
        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar la inspección.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // Validación del formulario Inspección Liberación Barrica/Contenedor de Vidrio
  const addInspeccionLiberacionForm = document.getElementById('addInspeccionLiberacionForm');
  const fvLiberacion = FormValidation.formValidation(addInspeccionLiberacionForm, {
    fields: {
      id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un cliente.'
          }
        }
      },
      fecha_visita: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese la fecha y hora sugerida para la inspección.'
          }
        }
      },
      id_instalacion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una instalación.'
          }
        }
      },
      id_lote_granel_liberacion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un lote a granel.'
          }
        }
      },
      tipo_lote_lib: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un tipo.'
          }
        }
      },
      analisis_liberacion: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el análisis fisicoquímico.'
          }
        }
      },
      volumen_liberacion: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el volumen.'
          },
          numeric: {
            message: 'Por favor ingrese un valor numérico válido.'
          }
        }
      },
      fecha_inicio_lib: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese la fecha de inicio.'
          }
        }
      },
      fecha_termino_lib: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese la fecha de término.'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: function (field, ele) {
          return '.mb-4, .mb-5, .mb-6';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    const formData = new FormData(addInspeccionLiberacionForm);

    $.ajax({
      url: '/hologramas/storeInspeccionBarricadaLiberacion', // Actualiza con la URL correcta
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Cerrar modal y reiniciar formulario
        $('#addInspeccionLiberacion').modal('hide');
        $('#addInspeccionLiberacionForm')[0].reset();
        $('.select2').val(null).trigger('change');
        $('.datatables-solicitudes').DataTable().ajax.reload();

        // Mostrar alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Inspección de liberacion barricada registrada exitosamente.',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function () {
        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar la inspección.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // Validación del formulario inpeccion de envasado
  const addInspeccionEnvasadoForm = document.getElementById('addInspeccionEnvasadoForm');
  const fvEnvasado = FormValidation.formValidation(addInspeccionEnvasadoForm, {
    fields: {
      id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un cliente.'
          }
        }
      },
      fecha_visita: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese la fecha y hora sugerida para la inspección.'
          }
        }
      },
      id_instalacion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una instalación.'
          }
        }
      },
      id_lote_granel_inspeccion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un lote a granel.'
          }
        }
      },
      id_tipo_inspeccion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un tipo.'
          }
        }
      },
      analisis_inspeccion: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el análisis fisicoquímico.'
          }
        }
      },
      volumen_inspeccion: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el volumen.'
          },
          numeric: {
            message: 'Por favor ingrese un valor numérico válido.'
          }
        }
      },
      id_cantidad_bote: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese la cantidad de botellas.'
          },
          numeric: {
            message: 'Por favor ingrese un valor numérico válido.'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: '.mb-4, .mb-5, .mb-6'
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    const formData = new FormData(addInspeccionEnvasadoForm);

    $.ajax({
      url: '/hologramas/storeInspeccionEnvasado', // Cambiar a la ruta correspondiente
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Cerrar modal y reiniciar formulario
        $('#addInspeccionEnvasado').modal('hide');
        $('#addInspeccionEnvasadoForm')[0].reset();
        $('.select2').val(null).trigger('change');
        $('.datatables-inspecciones').DataTable().ajax.reload();

        // Mostrar alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Inspección de envasado registrada exitosamente.',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function () {
        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar la inspección.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  //Validar vigilancia en traslado
  const addVigilanciaTrasladoForm = document.getElementById('addVigilanciaTrasladoForm');
  const fvVigilancia = FormValidation.formValidation(addVigilanciaTrasladoForm, {
    fields: {
      id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una empresa.'
          }
        }
      },
      fecha_visita: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese la fecha y hora de la inspección.'
          }
        }
      },
      id_instalacion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una instalación.'
          }
        }
      },
      id_lote_granel_traslado: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un lote a granel.'
          }
        }
      },
      id_vol_traslado: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el volumen trasladado.'
          },
          numeric: {
            message: 'El volumen trasladado debe ser un número válido.',
            thousandsSeparator: '',
            decimalSeparator: '.'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: function (field, ele) {
          return '.mb-4, .mb-5, .mb-6';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    const formData = new FormData(addVigilanciaTrasladoForm);
    $.ajax({
      url: '/hologramas/storeVigilanciaTraslado', // Cambia a la URL correcta
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Cerrar modal y reiniciar formulario
        $('#addVigilanciaTraslado').modal('hide');
        $('#addVigilanciaTrasladoForm')[0].reset();
        $('.select2').val(null).trigger('change');
        $('.datatables-solicitudes').DataTable().ajax.reload();

        // Mostrar alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Vigilancia traslado registrada exitosamente.',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function () {
        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar la vigilancia.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  /*funcion para solicitud de liberacion producto termiando  */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de dictaminación
    const formDictaminacion = document.getElementById('addLiberacionProductoForm');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona una instalación.'
            }
          }
        },
        id_lote_envasado: {
          validators: {
            notEmpty: {
              message: 'Selecciona al menos un lote envasado.'
            }
          }
        },
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
    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(formDictaminacion);
       $('#btnRegistrarlib').prop('disabled', true);

        $('#btnRegistrarlib').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
        setTimeout(function () {
            $('#btnRegistrarlib').prop('disabled', false);
            $('#btnRegistrarlib').html('<i class="ri-add-line"></i> Registrar');
        }, 2000);

      $.ajax({
        url: '/registrar-solicitud-lib-prod-term',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addLiberacionProducto').modal('hide');
          $('#addLiberacionProductoForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'La liberación del producto se registró exitosamente.',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

  // Manejar el cambio en el tipo de instalación
  $(document).on('change', '#edit_tipo', function () {
    var tipo = $(this).val();
    var hiddenIdDocumento = $('#edit_certificado_otros').find('input[name="id_documento[]"]');
    var hiddenNombreDocumento = $('#edit_certificado_otros').find('input[name="nombre_documento[]"]');
    var fileCertificado = $('#edit_certificado_otros').find('input[type="file"]');

    switch (tipo) {
      case 'productora':
        hiddenIdDocumento.val('127');
        hiddenNombreDocumento.val('Certificado de instalaciones');
        fileCertificado.attr('id', 'file-127');
        break;
      case 'envasadora':
        hiddenIdDocumento.val('128');
        hiddenNombreDocumento.val('Certificado de envasadora');
        fileCertificado.attr('id', 'file-128');
        break;
      case 'comercializadora':
        hiddenIdDocumento.val('129');
        hiddenNombreDocumento.val('Certificado de comercializadora');
        fileCertificado.attr('id', 'file-129');
        break;
      default:
        hiddenIdDocumento.val('');
        hiddenNombreDocumento.val('');
        fileCertificado.removeAttr('id');
        break;
    }
  });

  $(document).ready(function () {
    $('#modalEditInstalacion').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var id_instalacion = button.data('id');
      var modal = $(this);

      modal.find('#editInstalacionForm').data('id', id_instalacion);
    });

    $('#editInstalacionForm').submit(function (e) {
      e.preventDefault();

      var id_instalacion = $(this).data('id');
      var form = $(this)[0];
      var formData = new FormData(form);

      $.ajax({
        url: baseUrl + 'instalaciones/' + id_instalacion,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
          xhr.setRequestHeader('X-HTTP-Method-Override', 'PUT');
        },
        success: function (response) {
          dt_instalaciones_table.ajax.reload();
          $('#modalEditInstalacion').modal('hide');

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
          console.error('Error en la solicitud AJAX:', xhr.responseJSON);

          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al actualizar los datos.',
            footer: `<pre>${JSON.stringify(xhr.responseJSON, null, 2)}</pre>`
          });
        }
      });
    });
  });

  $(document).on('click', '.pdf2', function () {
    var url = $(this).data('url');
    var registro = $(this).data('registro');
    var id_solicitud = $(this).data('id');
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    //Cargar el PDF con el ID
    iframe.attr('src', 'solicitud_de_servicio/' + id_solicitud);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $('#NewPestana')
      .attr('href', 'solicitud_de_servicio/' + id_solicitud)
      .show();

    $('#titulo_modal').text('Solicitud de servicios NOM-070-SCFI-2016');
    $('#subtitulo_modal').html('<p class="solicitud badge bg-primary">' + registro + '</p>');
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  var openedFromFirstModal = false;

  $('#abrirModalInstalaciones').on('click', function () {
    var clienteSeleccionado = $('#id_empresa_solicitudes').val();

    openedFromFirstModal = true;
    $('#addSolicitudDictamen').modal('hide');
    $('#id_empresa option[value="' + clienteSeleccionado + '"]').prop('selected', true); // Marcar la opción seleccionada
    $('#id_empresa').trigger('change');
    $('#modalAddInstalacion').modal('show');
  });

  // Al cerrar el segundo modal
  $('#modalAddInstalacion').on('hidden.bs.modal', function () {
    if (openedFromFirstModal) {
      openedFromFirstModal = false;
      $('#addSolicitudDictamen').modal('show');
    }
  });

  // Al registrar el segundo modal
  $('#btnRegistrarInstalacion').on('click', function () {
    var clienteSeleccionado = $('#id_empresa').val();
    if (openedFromFirstModal) {
      openedFromFirstModal = false;
      // $('#modalAddInstalacion').modal('hide');

      $('#id_empresa_solicitudes option[value="' + clienteSeleccionado + '"]').prop('selected', true); // Marcar la opción seleccionada
      $('#id_empresa_solicitudes').trigger('change');
      obtenerInstalacion();


      $('#addSolicitudDictamen').modal('show');
    }
  });

  //Vigilancia boton instalaciones
  $(document).ready(function () {
    let openedFromFirstModal = false;

    $('#modalVigilancia').on('click', function () {
      var clienteSeleccionado = $('.id_empresa').val();
      // Verificar si hay una empresa seleccionada
      if (!clienteSeleccionado) {
        Swal.fire({
          icon: 'warning',
          title: 'Espere!',
          text: 'Por favor, selecciona un cliente primero.',
          customClass: {
            confirmButton: 'btn btn-danger'
          },
          buttonsStyling: false
        });
        return;
      }
      $('#addVigilanciaProduccion').modal('hide');
      // Marcar que el nuevo modal fue abierto desde el anterior
      openedFromFirstModal = true;
      // Preseleccionar la empresa en el modal de nueva instalación
      $('#modalAddInstalacion #id_empresa').val(clienteSeleccionado).trigger('change');
      $('#modalAddInstalacion').modal('show');
    });
    $('#modalAddInstalacion').on('hidden.bs.modal', function () {
      if (openedFromFirstModal) {
        $('#addVigilanciaProduccion').modal('show');
        openedFromFirstModal = false;
      }
    });
  });

  //Muestreo de lote a granel
  $(document).ready(function () {
    let openedFromFirstModal = false;

    $('#modalMuestreo').on('click', function () {
      var clienteSeleccionado = $('.id_empresa_muestreo').val();
      // Verificar si hay una empresa seleccionada
      if (!clienteSeleccionado) {
        Swal.fire({
          icon: 'warning',
          title: 'Espere!',
          text: 'Por favor, selecciona un cliente primero.',
          customClass: {
            confirmButton: 'btn btn-danger'
          },
          buttonsStyling: false
        });
        return;
      }
      $('#addMuestreoLoteAgranel').modal('hide');
      // Marcar que el nuevo modal fue abierto desde el anterior
      openedFromFirstModal = true;
      // Preseleccionar la empresa en el modal de nueva instalación
      $('#modalAddInstalacion #id_empresa').val(clienteSeleccionado).trigger('change');
      $('#modalAddInstalacion').modal('show');
    });
    $('#modalAddInstalacion').on('hidden.bs.modal', function () {
      if (openedFromFirstModal) {
        $('#addMuestreoLoteAgranel').modal('show');
        openedFromFirstModal = false;
      }
    });
  });

  //Muestreo de vigilancia traslado
  $(document).ready(function () {
    let openedFromFirstModal = false;

    $('#modalVigilanciaTraslado').on('click', function () {
      var clienteSeleccionado = $('.id_empresa_traslado').val();
      // Verificar si hay una empresa seleccionada
      if (!clienteSeleccionado) {
        Swal.fire({
          icon: 'warning',
          title: 'Espere!',
          text: 'Por favor, selecciona un cliente primero.',
          customClass: {
            confirmButton: 'btn btn-danger'
          },
          buttonsStyling: false
        });
        return;
      }
      $('#addVigilanciaTraslado').modal('hide');
      // Marcar que el nuevo modal fue abierto desde el anterior
      openedFromFirstModal = true;
      // Preseleccionar la empresa en el modal de nueva instalación
      $('#modalAddInstalacion #id_empresa').val(clienteSeleccionado).trigger('change');
      $('#modalAddInstalacion').modal('show');
    });
    $('#modalAddInstalacion').on('hidden.bs.modal', function () {
      if (openedFromFirstModal) {
        $('#addVigilanciaTraslado').modal('show');
        openedFromFirstModal = false;
      }
    });
  });

  //Muestreo de inpeccion ingreso barricada
  $(document).ready(function () {
    let openedFromFirstModal = false;

    $('#modalVigilanciaBarricada').on('click', function () {
      var clienteSeleccionado = $('.id_empresa_barricada').val();
      // Verificar si hay una empresa seleccionada
      if (!clienteSeleccionado) {
        Swal.fire({
          icon: 'warning',
          title: 'Espere!',
          text: 'Por favor, selecciona un cliente primero.',
          customClass: {
            confirmButton: 'btn btn-danger'
          },
          buttonsStyling: false
        });
        return;
      }
      $('#addInspeccionIngresoBarricada').modal('hide');
      // Marcar que el nuevo modal fue abierto desde el anterior
      openedFromFirstModal = true;
      // Preseleccionar la empresa en el modal de nueva instalación
      $('#modalAddInstalacion #id_empresa').val(clienteSeleccionado).trigger('change');
      $('#modalAddInstalacion').modal('show');
    });
    $('#modalAddInstalacion').on('hidden.bs.modal', function () {
      if (openedFromFirstModal) {
        $('#addInspeccionIngresoBarricada').modal('show');
        openedFromFirstModal = false;
      }
    });
  });

  //Muestreo de inpeccion liberacion barricada
  $(document).ready(function () {
    let openedFromFirstModal = false;

    $('#modalVigilanciaBarricadaLiberacion').on('click', function () {
      var clienteSeleccionado = $('.id_empresa_liberacion').val();
      // Verificar si hay una empresa seleccionada
      if (!clienteSeleccionado) {
        Swal.fire({
          icon: 'warning',
          title: 'Espere!',
          text: 'Por favor, selecciona un cliente primero.',
          customClass: {
            confirmButton: 'btn btn-danger'
          },
          buttonsStyling: false
        });
        return;
      }
      $('#addInspeccionLiberacion').modal('hide');
      // Marcar que el nuevo modal fue abierto desde el anterior
      openedFromFirstModal = true;
      // Preseleccionar la empresa en el modal de nueva instalación
      $('#modalAddInstalacion #id_empresa').val(clienteSeleccionado).trigger('change');
      $('#modalAddInstalacion').modal('show');
    });
    $('#modalAddInstalacion').on('hidden.bs.modal', function () {
      if (openedFromFirstModal) {
        $('#addInspeccionLiberacion').modal('show');
        openedFromFirstModal = false;
      }
    });
  });

  //Muestreo de inspeccion de envasado
  $(document).ready(function () {
    let openedFromFirstModal = false;

    $('#modalMuestreoInspeccion').on('click', function () {
      var clienteSeleccionado = $('.id_empresa_inspeccion').val();
      // Verificar si hay una empresa seleccionada
      if (!clienteSeleccionado) {
        Swal.fire({
          icon: 'warning',
          title: 'Espere!',
          text: 'Por favor, selecciona un cliente primero.',
          customClass: {
            confirmButton: 'btn btn-danger'
          },
          buttonsStyling: false
        });
        return;
      }
      $('#addInspeccionEnvasado').modal('hide');
      // Marcar que el nuevo modal fue abierto desde el anterior
      openedFromFirstModal = true;
      // Preseleccionar la empresa en el modal de nueva instalación
      $('#modalAddInstalacion #id_empresa').val(clienteSeleccionado).trigger('change');
      $('#modalAddInstalacion').modal('show');
    });
    $('#modalAddInstalacion').on('hidden.bs.modal', function () {
      if (openedFromFirstModal) {
        $('#addInspeccionEnvasado').modal('show');

        openedFromFirstModal = false;
      }
    });
  });

  /* seccion para exportacion */
  $(document).ready(function () {
    // Obtener el select y las secciones
    var $tipoSolicitud = $('#tipo_solicitud');
    var $pedidosEx = $('#pedidos_Ex');
    var $etiquetasEx = $('#etiquetas_Ex');
    var $botonesCharacteristics = $('#botones_characteristics');

    // Manejar el evento de cambio
    $tipoSolicitud.on('change', function () {
      var valorSeleccionado = $tipoSolicitud.val();


      if (valorSeleccionado === '2' || valorSeleccionado === '5') {
        $botonesCharacteristics.removeClass('d-none'); // Mostrar los botones
      } else {
        $botonesCharacteristics.addClass('d-none'); // Ocultar los botones
      }
    });
  });

  $(document).ready(function () {
    // Contador para las secciones dinámicas
    let sectionCount = 1;

    // Función para agregar una nueva sección dinámica
    $('#add-characteristics').click(function () {
      // Validar que se haya seleccionado una empresa
      let empresaSeleccionada = $('#id_empresa_solicitud_exportacion').val()
    ? $('#id_empresa_solicitud_exportacion').val()
    : $('#id_empresa_solicitud_exportacion_edit').val();




      if (!empresaSeleccionada) {
        // Mostrar alerta si no se seleccionó ninguna empresa
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'Debe seleccionar un cliente antes de agregar una nueva sección.',
          customClass: {
            confirmButton: 'btn btn-warning'
          }
        });
        return; // Salir del evento si no se seleccionó una empresa
      }

      // Crear una nueva sección dinámica
      var newSection = `
        <div class="card mt-4" id="caracteristicas_Ex_${sectionCount}">
            <div class="card-body">
                <h5>Características del Producto</h5>
                <div class="row caracteristicas-row">
                    <div class="col-md-8">
                        <div class="form-floating form-floating-outline mb-4">
                            <select name="lote_envasado[${sectionCount}]" class="select2 form-select evasado_export">
                                <option value="" disabled selected>Selecciona un lote envasado</option>
                                <!-- Opciones dinámicas -->
                            </select>
                            <label for="lote_envasado">Selecciona el lote envasado</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" disabled class="form-control" name="lote_granel[${sectionCount}]" id="lote_granel_${sectionCount}" placeholder="Lote a granel">
                            <label for="lote_granel">Lote a granel</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="number" class="form-control" id="cantidad_botellas${sectionCount}" name="cantidad_botellas[${sectionCount}]" placeholder="Cantidad de botellas">
                            <label for="cantidad_botellas">Cantidad de botellas</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="number" class="form-control" id="cantidad_cajas${sectionCount}" name="cantidad_cajas[${sectionCount}]" placeholder="Cantidad de cajas">
                            <label for="cantidad_cajas">Cantidad de cajas</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" name="presentacion[${sectionCount}]" placeholder="Ej. 750ml">
                            <label for="presentacion">Presentación</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      `;

      // Agregar la nueva sección al contenedor
      $('#sections-container').append(newSection);
      $('#sections-container2').append(newSection);

      // Cargar opciones dinámicas para los selects de la nueva sección
      cargarLotes(empresaSeleccionada, sectionCount);


      // Inicializar Select2 en los nuevos selects
      var select2Elements = $('.select2');
      initializeSelect2(select2Elements);

      // Incrementar el contador para la siguiente sección
      sectionCount++;
    });

    // Función para cargar los lotes dinámicamente en la nueva sección
    // Función para cargar los lotes dinámicamente en la nueva sección
    function cargarLotes(empresaSeleccionada, sectionCount) {
      $.ajax({
        url: '/getDatos/' + empresaSeleccionada, // Usa la empresa seleccionada para cargar los lotes
        method: 'GET',
        success: function (response) {
          // Lote envasado
          var contenidoLotesEnvasado = '';
          var marcas = response.marcas;
          var dictamenEnvasado = response.lotesEnvasado;

          for (let index = 0; index < response.lotes_envasado.length; index++) {
            var skuLimpio = limpiarSku(response.lotes_envasado[index].sku);
            var marcaEncontrada = marcas.find(function (marca) {
              return marca.id_marca === response.lotes_envasado[index].id_marca;
            });
            var nombreMarca = marcaEncontrada ? marcaEncontrada.marca : 'Sin marca';

            var num_dictamen = dictamenEnvasado ? dictamenEnvasado[index].dictamen_envasado.num_dictamen : 'Sin dictamen de envasado';

            contenidoLotesEnvasado += `
          <option value="${response.lotes_envasado[index].id_lote_envasado}">
            ${skuLimpio} | ${response.lotes_envasado[index].nombre} | ${nombreMarca} | ${num_dictamen}
          </option>`;
          }

          if (response.lotes_envasado.length == 0) {
            contenidoLotesEnvasado = '<option value="" disabled selected>Sin lotes envasados registrados</option>';
          }

          // Actualizar las opciones del select para la nueva sección
          $('#caracteristicas_Ex_' + sectionCount + ' .evasado_export').html(contenidoLotesEnvasado);
        },
        error: function () {
          console.error('Error al cargar los lotes.');
          Swal.fire({
            icon: 'error',
            title: 'Error al cargar los datos',
            text: 'Hubo un problema al intentar cargar los lotes. Intenta nuevamente más tarde.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    }



    // Eliminar la última sección
    $('#delete-characteristics').click(function () {
      var totalSections = $('#sections-container .card').length; // Total de secciones en el contenedor
      var lastSection = $('#sections-container .card').last(); // Última sección

      // Solo eliminar si hay más de una sección (no borrar la sección original)
      if (totalSections > 1) {
        lastSection.remove(); // Eliminar la última sección
        sectionCount--; // Decrementar el contador
      } else {
        // Mensaje de advertencia con SweetAlert
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'No se puede eliminar la sección original.',
          customClass: {
            confirmButton: 'btn btn-warning'
          }
        });
      }
    });
  });

  /* Enviar formulario store add exportacion */
  $(function () {
    // Configuración de CSRF para las solicitudes AJAX
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Validación del formulario Pedido de Exportación
    const addPedidoExportacionForm = document.getElementById('addPedidoExportacionForm');
    const fv = FormValidation.formValidation(addPedidoExportacionForm, {
      fields: {
        tipo_solicitud: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo de solicitud.'
            }
          }
        },
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        id_instalacion_envasado_2: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un domicilio de envasado.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un domicilio para la inspección.'
            }
          }
        },


        'cantidad_botellas[0]': {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca el número de botellas'
            }
          }
        },
        'cantidad_cajas[0]': {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca el número de cajas'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de la visita.'
            }
          }
        },

        id_etiqueta: {
          selector: "input[name='id_etiqueta']",
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una etiqueta.'
            }
          }
        },
        factura_proforma: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la factura'
            }
          }
        },
        direccion_destinatario: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una dirección del destinatario.'
            }
          }
        },
        aduana_salida: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la aduana de salida.'
            }
          }
        },
        no_pedido: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de pedido.'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: function (field, ele) {
            return '.mb-4, .mb-5, .mb-6';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      // Recolectar el resto de los datos del formulario
      const formData = new FormData(addPedidoExportacionForm);

      // Construir las características como un JSON completo
      const caracteristicas = {
        tipo_solicitud: $('#tipo_solicitud').val(),
        direccion_destinatario: $('#direccion_destinatario_ex').val(),
        aduana_salida: $('[name="aduana_salida"]').val(),
        no_pedido: $('[name="no_pedido"]').val(),
        factura_proforma: $('[name="factura_proforma"]')[0].files[0], // Archivo
        factura_proforma_cont: $('[name="factura_proforma_cont"]')[0].files[0], // Archivo
        detalles: [] // Aquí van las filas de la tabla de características
      };

      // Agregar cada fila de la tabla dinámica al JSON
      $('#tabla-marcas tbody tr').each(function () {
        const row = $(this);
        caracteristicas.detalles.push({
          lote_envasado: row.find('.lote-envasado').val(),
          cantidad_botellas: row.find('.cantidad-botellas').val(),
          cantidad_cajas: row.find('.cantidad-cajas').val(),
          presentacion: row.find('.presentacion').val()
        });
      });

      // Añadir el JSON al FormData como string
      formData.append('caracteristicas', JSON.stringify(caracteristicas));

      $.ajax({
        url: '/exportaciones/storePedidoExportacion', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Reiniciar el formulario
          $('#addPedidoExportacionForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          $('#addPedidoExportacion').modal('hide');
          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'El pedido de exportación se registró exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function () {
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Hubo un error al registrar el pedido de exportación.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

  // Mapeo entre IDs de tipo de solicitud y IDs de divs
  const divsPorSolicitud = {
    1: ['muestreoAgave'],
    2: ['vigilanciaProduccion'],
    4: ['vigilanciaTraslado'],
    14: ['dictamenInstalaciones'],
    10: ['georreferencia'],
    11: ['liberacionPTExportacion'],
    3: ['muestreoLoteAjustes', 'guiastraslado'],
    5: ['inspeccionEnvasado'],
    7: ['inspeccionIngresoBarrica'],
    9: ['liberacionBarricaVidrio']
  };

  // Función para manejar la visibilidad de divs según el tipo de solicitud
  function manejarVisibilidadDivs(idTipo) {
    // Ocultamos todos los divs
    Object.values(divsPorSolicitud)
      .flat()
      .forEach(divId => {
        $(`#${divId}`).addClass('d-none');
      });
    const divsMostrar = divsPorSolicitud[idTipo];
    if (divsMostrar) {
      divsMostrar.forEach(divId => {
        $(`#${divId}`).removeClass('d-none');

        document.querySelectorAll('.d-none select').forEach(el => {
         // el.disabled = true;

        });

      });
    }

  }
  // Manejar el clic en los enlaces con clase "validar-solicitudes"
  $(document).on('click', '.validar-solicitudes', function () {
    // Leer los datos desde los atributos data-*
    var idTipo = $(this).data('id');
    var id_solicitud = $(this).data('id-solicitud');
    var tipoName = $(this).data('tipo');
    var razon_social = $(this).data('razon-social');
    $('#tipoSolicitud').text(tipoName);

      // Manejar la visibilidad de divs si aplica
      manejarVisibilidadDivs(idTipo);


    $.ajax({
      url: `/getDatosSolicitud/${id_solicitud}`,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          $('#solicitud_id').val(id_solicitud);
          $('.domicilioFiscal').text(response.data.empresa.domicilio_fiscal);
          // Validar si `direccion_completa` no está vacío
          if (response.data.instalacion) {
            $('.domicilioInstalacion').html(response.data.instalacion.direccion_completa + " <b>Vigencia: </b>"+response.data.instalacion.fecha_vigencia);
          } else {
            // Si está vacío, usar `ubicacion_predio`
            $('.domicilioInstalacion').text(response.data?.predios?.ubicacion_predio);
            $('.nombrePredio').text(response.data?.predios?.nombre_predio);
            $('.preregistro').html(
              "<a target='_Blank' href='/pre-registro_predios/" +
                response.data?.predios?.id_predio +
                "'><i class='ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer'></i></a>"
            );
          }



          $('.razonSocial').text(response?.data?.empresa?.razon_social || 'No disponible');
          $('.fechaHora').text(response?.fecha_visita_formateada || 'No disponible');

          $('.nombreLote').text(response?.data?.lote_granel?.nombre_lote || 'No disponible');


          $('.guiasTraslado').text(response?.data?.caracteristicas?.guias || 'No disponible');

          // Validar categoría
          $('.categoria').text(
            response?.data?.lote_granel?.categoria?.categoria ||
              response?.data?.lote_envasado?.lotes_envasado_granel?.[0]?.lotes_granel?.[0]?.categoria?.categoria ||
              'No disponible'
          );

          // Validar clase
          $('.clase').text(
            response?.data?.lote_granel?.clase?.clase ||
              response?.data?.lote_envasado?.lotes_envasado_granel?.[0]?.lotes_granel?.[0]?.clase?.clase ||
              'No disponible'
          );

          $('.cont_alc').text(response?.data?.lote_granel?.cont_alc || 'No disponible');
          $('.fq').text(response?.data?.lote_granel?.folio_fq || 'No disponible');
          $('.certificadoGranel').text(response?.data?.lote_granel?.certificadoGranel?.num_certificado || 'No disponible');

          $('.tipos').text(response?.tipos_agave || 'No disponible');


          // Validar nombre del lote envasado
          $('.nombreLoteEnvasado').text(response?.data?.lote_envasado?.nombre || 'Nombre no disponible');

          var caracteristicas = JSON.parse(response.data?.caracteristicas);
          var tipos = {
            1: 'Análisis completo',
            2: 'Ajuste de grado alcohólico'
        };

        var texto = tipos[caracteristicas?.tipo_analisis] || 'No disponible';

        $('.tipoAnalisis').text(texto);
          $('.materialRecipiente').text(caracteristicas.material);
          $('.capacidadRecipiente').text(caracteristicas.capacidad);
          $('.numeroRecipiente').text(caracteristicas.num_recipientes);
          $('.tiempoMaduracion').text(caracteristicas.tiempo_dura);
          $('.tipoIngreso').text(caracteristicas.tipoIngreso);
          $('.volumenLiberado').text(caracteristicas.volumen_liberacion);
          $('.tipoLiberacion').text(caracteristicas.tipoLiberacion);
          $('.volumenActual').text(caracteristicas.id_vol_actual);
          $('.volumenTrasladado').text(caracteristicas.id_vol_traslado);
          $('.volumenSobrante').text(caracteristicas.id_vol_res);
          $('.volumenIngresado').text(caracteristicas.volumen_ingresado);
          $('.etiqueta').html('<a href="files/'+response.data.empresa.empresa_num_clientes[0].numero_cliente+'/'+response?.url_etiqueta+'" target="_blank"><i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i></a>');
          $('.dictamenEnvasado').html('<a href="/dictamen_envasado/'+response?.data?.lote_envasado?.dictamen_envasado?.id_dictamen_envasado+'" target="_blank"><i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i></a>');

          // Verificar si 'detalles' existe y es un arreglo
          if (caracteristicas.detalles && Array.isArray(caracteristicas.detalles)) {
            // Recorrer cada elemento de 'detalles'
            $('.cajasBotellas').text('');
            caracteristicas.detalles.forEach(function (detalle) {
              // Asumiendo que '.cajasBotellas' es un contenedor de varias cajas, agregamos el texto en cada una
              $('.cajasBotellas').append(
                detalle.cantidad_cajas + ' Cajas y ' + detalle.cantidad_botellas + ' Botellas<br>'
              );
            });
          } else {
            // Si 'detalles' no existe o no es un arreglo
            $('.cajasBotellas').text('No hay detalles disponibles.');
          }

          // Estructura de configuración para los documentos
          const documentConfig = [
            {
              ids: [45, 66, 113],
              targetClass: '.comprobantePosesion',
              noDocMessage: 'No hay comprobante de posesión',
              condition: (documento, response) => documento.id_relacion == response.data.id_instalacion
            },
            {
              ids: [34],
              targetClass: '.comprobantePosesion',
              noDocMessage: 'No hay contrato de arrendamiento',
              condition: (documento, response) => documento.id_relacion == response.data.id_predio
            },
            {
              ids: [43, 106, 112],
              targetClass: '.planoDistribucion',
              noDocMessage: 'No hay plan de distribución',
              condition: (documento, response) => documento.id_relacion == response.data.id_instalacion
            },
            {
              ids: [76],
              targetClass: '.csf',
              noDocMessage: 'No hay CSF',
              condition: (documento, response) => documento.id_empresa == response.data.id_empresa
            },
            {
              ids: [1],
              targetClass: '.actaConstitutiva',
              noDocMessage: 'No hay acta constitutiva',
              condition: (documento, response) => documento.id_empresa == response.data.id_empresa
            },
            {
              ids: [55],
              targetClass: '.proforma',
              noDocMessage: 'No hay factura proforma',
              condition: (documento, response) => documento.id_empresa == response.data.id_empresa
            },
            {
              ids: [128],
              targetClass: '.domicilioInstalacion',
              noDocMessage: 'No hay dictamen de instalaciones',
              condition: (documento, response) => documento.id_relacion == response.data.id_instalacion
            }
          ];

          // Variable para seguimiento de documentos encontrados
          const documentsFound = {};

          // Inicializamos cada grupo como no encontrado
          documentConfig.forEach(config => {
            documentsFound[config.targetClass] = false;
          });

          // Iterar sobre los documentos
          $.each(response.documentos, function (index, documento) {
            documentConfig.forEach(config => {
              if (
                config.ids.includes(documento.id_documento) &&
                config.condition(documento, response) // Usar la condición dinámica
              ) {
                const link = $('<a>', {
                  href: 'files/' + response.data.empresa.empresa_num_clientes[0].numero_cliente + '/' + documento.url,
                  target: '_blank'
                });

                link.html('<i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i>');
                if (documento.id_documento === 128) {
                  $(config.targetClass).append(link);
                } else {
                  $(config.targetClass).empty().append(link);
                }
                documentsFound[config.targetClass] = true;
              }
            });
          });

          // Mostrar mensajes para documentos no encontrados
          documentConfig.forEach(config => {
            if (!documentsFound[config.targetClass]) {
              $(config.targetClass).text(config.noDocMessage);
            }
          });
        } else {
          console.warn('No se encontró información para la solicitud.');
        }
      },
      error: function (xhr, status, error) {
        console.error('Error al obtener los datos:', error);
      }
    });


  });

  $(document).ready(function () {
    $('#reporteForm').on('submit', function (e) {
      e.preventDefault(); // Prevenir el envío tradicional del formulario
      const exportUrl = $(this).attr('action'); // Obtener la URL del formulario
      // Obtener los datos del formulario (filtros)
      const formData = $(this).serialize(); // serializa los datos del formulario en una cadena de consulta
      // Mostrar el SweetAlert de "Generando Reporte"
      Swal.fire({
        title: 'Generando Reporte...',
        text: 'Por favor espera mientras se genera el reporte.',
        icon: 'info',
        didOpen: () => {
          Swal.showLoading(); // Muestra el icono de carga
        },
        customClass: {
          confirmButton: false
        }
      });
      // Realizar la solicitud GET para descargar el archivo
      $.ajax({
        url: exportUrl,
        type: 'GET',
        data: formData,
        xhrFields: {
          responseType: 'blob' // Necesario para manejar la descarga de archivos
        },
        success: function (response) {
          // Crear un enlace para descargar el archivo
          const link = document.createElement('a');
          const url = window.URL.createObjectURL(response);
          link.href = url;
          link.download = 'reporte_solicitudes.xlsx';
          link.click();
          window.URL.revokeObjectURL(url);
          $('#exportarExcel').modal('hide');
          Swal.fire({
            title: '¡Éxito!',
            text: 'El reporte se generó exitosamente.',
            icon: 'success',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr, status, error) {
          console.error('Error al generar el reporte:', error);
          $('#exportarExcel').modal('hide');
          Swal.fire({
            title: '¡Error!',
            text: 'Ocurrió un error al generar el reporte.',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
//funcion para exportar en excel
  $(document).ready(function () {
    $('#restablecerFiltros').on('click', function () {
      $('#reporteForm')[0].reset();
      $('.select2').val('').trigger('change');
      console.log('Filtros restablecidos.');
    });
  });

  $(document).ready(function () {
    $('#id_soli').on('change', function () {
      var selectedValues = $(this).val(); // Obtener los valores seleccionados

      if (selectedValues && selectedValues.includes('')) {
        // Si "Todas" es seleccionado
        $('#id_soli option').each(function () {
          if ($(this).val() !== '') {
            $(this).prop('selected', false); // Deseleccionar otras opciones
            $(this).prop('disabled', true); // Deshabilitar otras opciones
          }
        });
      } else {
        // Si seleccionas cualquier otra opción
        if (selectedValues && selectedValues.length > 0) {
          $('#id_soli option[value=""]').prop('disabled', true); // Deshabilitar "Todas"
        } else {
          // Si no hay opciones seleccionadas, habilitar todas
          $('#id_soli option').each(function () {
            $(this).prop('disabled', false); // Habilitar todas las opciones
          });
        }
      }
    });
  });
});

  //Date picker
  $(document).ready(function () {
    const flatpickrDateTime = document.querySelectorAll('.flatpickr-datetime');

    if (flatpickrDateTime.length) {
      flatpickrDateTime.forEach((element) => {
        // Inicializar flatpickr para cada input
        flatpickr(element, {
          enableTime: true, // Habilitar selección de tiempo
          time_24hr: true, // Mostrar tiempo en formato 24 horas
          dateFormat: 'Y-m-d H:i',
          locale: 'es',
          allowInput: true,
        });
      });
    }
  });



  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de muestreo de agave
    const form3 = document.getElementById('addRegistrarSolicitudMuestreoAgave');
    const fv3 = FormValidation.formValidation(form3, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
        punto_reunion: {
          validators: {
            notEmpty: {
              message: 'Introduce la dirección para el punto de reunión.'
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
    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(form3);

      $.ajax({
        url: '/registrar-solicitud-muestreo-agave',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudMuestreoAgave').modal('hide');
          $('#addRegistrarSolicitudMuestreoAgave')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud de muestreo registrado exitosamente.',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    // Inicializar FormValidation para las validaciones por parte del personal oc
    const form = document.getElementById('addValidarSolicitud');

    const fv = FormValidation.formValidation(form, {
      excluded: ':disabled',
      fields: {
       /* razonSocial: {
          validators: {
            notEmpty: {
              message: 'Selecciona la respuesta'
            }
          }
        },
        razonSocial1: {
          validators: {
            notEmpty: {
              message: 'Selecciona la respuesta'
            }
          }
        },
        domicilioFiscal: {
          validators: {
            notEmpty: {
              message: 'Selecciona la respuesta'
            }
          }
        },
        domicilioInstalacion: {
          validators: {
            notEmpty: {
              message: 'Selecciona la respuesta'
            }
          }
        },
        fechaHora: {
          validators: {
            notEmpty: {
              message: 'Selecciona la respuesta'
            }
          }
        },
        actaConstitutiva: {
          validators: {
            notEmpty: {
              message: 'Selecciona la respuesta'
            }
          }
        },
        csf: {
          validators: {
            notEmpty: {
              message: 'Selecciona la respuesta'
            }
          }
        },
        comprobantePosesion: {
          validators: {
            notEmpty: {
              message: 'Selecciona la respuesta'
            }
          }
        },
        planoDistribucion: {
          validators: {
            notEmpty: {
              message: 'Selecciona la respuesta'
            }
          }
        }, */
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: '.marcar'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }


    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(form);

      $.ajax({
        url: '/registrarValidarSolicitud',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudValidar').modal('hide');
          $('#addValidarSolicitud')[0].reset();
          $('.datatables-solicitudes').DataTable().ajax.reload();


          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud validada correctamente',
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
            text: 'Error al validar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });





  });

