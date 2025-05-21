'use strict';

$(function () {
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
        url: baseUrl + 'bitacoraMezcal-list',
      },
      columns: [
        { data: '#' },                //0
        { data: 'fake_id' },          //1
        { data: 'fecha' },             //2
        { data: 'actions' },           //3
      ],
      columnDefs: [
        {
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
          targets: 2,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $fecha = full['fecha'] ?? 'N/A';
            var $lote_a_granel = full['lote_a_granel'] ?? 'N/A';

            return '<br><span class="fw-bold text-dark small">Lote a Granel: </span>' +
              '<span class="small">' + $lote_a_granel + '</span>';
          }
        },
        {
          targets: 3,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $volumen_salidas = full['volumen_salidas'] ?? 'N/A';
            var $alcohol_salidas = full['alcohol_salidas'] ?? 'N/A';
            var $destino_salidas = full['destino_salidas'] ?? 'N/A';

            return '<span class="fw-bold text-dark small">Volumen de Salidas: </span>' +
              '<span class="small">' + $volumen_salidas + '</span>' +
              '<br><span class="fw-bold text-dark small">Alcohol de Salidas: </span>' +
              '<span class="small">' + $alcohol_salidas + '</span>' +
              '<br><span class="fw-bold text-dark small">Destino de Salidas: </span>' +
              '<span class="small">' + $destino_salidas + '</span>';
          }
        },
        {
          targets: 4,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $volumen_final = full['volumen_final'] ?? 'N/A';
            var $alcohol_final = full['alcohol_final'] ?? 'N/A';

            return '<span class="fw-bold text-dark small">Volumen Final: </span>' +
              '<span class="small">' + $volumen_final + '</span>' +
              '<br><span class="fw-bold text-dark small">Alcohol Final: </span>' +
              '<span class="small">' + $alcohol_final + '</span>';
          }
        },
        {
          // Abre el pdf Bitacora
          targets: 5,
          className: 'text-center',
          render: function (data, type, full, meta) {
            return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-id="${full['id']}" data-bs-target="#mostrarPdfDictamen1" data-bs-toggle="modal" data-bs-dismiss="modal"></i>`;

          }
        },
        {
          // Actions
          targets: 6,
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
              // Botón para editar
              `<a data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#editCertificadoModal" class="dropdown-item edit-record waves-effect text-info">` +
              '<i class="ri-edit-box-line ri-20px text-info"></i> Editar' +
              '</a>' +
              // Botón para eliminar
              `<a data-id="${full['id']}" class="dropdown-item delete-record waves-effect text-danger">` +
              '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar' +
              '</a>' +
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
      lengthMenu: [10, 20, 50, 70, 100],
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

      // Opciones Exportar Documentos
      buttons: [
        {
          text: '<i class="ri-eye-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Ver Bitácora</span>',
          className: 'btn btn-info waves-effect waves-light me-2',
          attr: {
            id: 'verBitacoraBtn'
          }
        },
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
          text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
          buttons: [
            {
              extend: 'print',
              title: 'Certificados Instalaciones',
              text: '<i class="ri-printer-line me-1" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
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
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-text-line me-1" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
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
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
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
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
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
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-copy-line me-1"></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7],
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
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Bitácora</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#RegistrarBitacoraMezcal'
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de Certificado de Instalaciones: ' + data['num_certificado'];
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
      }
    });
  }

  //FUNCIONES DEL FUNCIONAMIENTO DEL CRUD//
    $(document).on('click', '#verBitacoraBtn', function () {
      const iframe = $('#pdfViewer');
      const urlPDF = '/bitacora_mezcal'; // Ajusta si necesitas pasar un ID o token

      // Mostrar spinner y ocultar PDF
      $('#cargando').show();
      iframe.hide();

      // Reset iframe y botón
      iframe.attr('src', '');
      iframe.attr('src', urlPDF);
      $('#NewPestana').attr('href', urlPDF).hide();

      // Títulos del modal
      $('#titulo_modal').text('Bitácora Mezcal a Granel');
      $('#subtitulo_modal').text('Versión General');

      // Mostrar modal
      $('#mostrarPdf').modal('show');
    });

    // Mostrar PDF y botón cuando el iframe esté listo
    $('#pdfViewer').on('load', function () {
      $('#cargando').hide();
      $(this).show();
      $('#NewPestana').show();
    });

    // En caso de error (opcional)
    $('#pdfViewer').on('error', function () {
      console.error('Error al cargar el PDF. Verifica la ruta.');
      $('#cargando').hide();
    });




  //end
});



