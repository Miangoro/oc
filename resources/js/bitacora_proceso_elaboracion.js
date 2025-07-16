/**
 * Page User List
 */
'use strict';
// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2 = $('.select2'),
    offCanvasForm = $('#offcanvasAddUser');

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
        url: baseUrl + 'bitacoraProcesoElaboracion-list'
      },
      columns: [
        { data: '' }, // Responsive control
        { data: 'fake_id', title: '#' },
        { data: 'fecha_ingreso', title: 'Fecha ingreso' },
        { data: 'nombre_cliente', title: 'Cliente' },
        { data: 'numero_tapada', title: 'N° tapada' },
        { data: 'lote_granel', title: 'Lote granel' },
        { data: 'numero_guia', title: 'N° guía' },
        { data: 'tipo_maguey', title: 'Tipo maguey' },
        { data: 'numero_pinas', title: 'N° piñas' },
        { data: 'kg_maguey', title: 'Kg maguey' },
        { data: 'observaciones', title: 'Observaciones' },
        { data: 'action', title: 'Acciones' }
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
          // Actions botones de eliminar y actualizar(editar)
          targets: -1,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center gap-50">' +
              '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              `<a data-id="${full['id']}" data-bs-toggle="offcanvas" data-bs-target="#editClase" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar bitácora</a>` +
              `<a data-id="${full['id']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar bitácora</a>` +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
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
        '<"me-5 ms-n2"f>' + // input de búsqueda
        '<"d-flex justify-content-start justify-content-md-end align-items-baseline"' +
          '<"filtrosBitacora d-flex gap-2 align-items-center" >' + // filtros personalizados
          '<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center gap-4"lB>' + // botones y length
        '>>' +
        't' + // tabla
        '<"row mx-1"' +
          '<"col-sm-12 col-md-6"i>' + // info
          '<"col-sm-12 col-md-6"p>' + // paginación
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
      buttons: [
        {
          className: 'dt-custom-select p-0 me-2 btn-outline-dark form-select-sm',
          text: '',
          init: function (api, node) {
            $(node).removeClass('btn btn-secondary');

            // Decide si agregar opción 'Todas las Empresas' según tipoUsuario
            const agregarTodas = window.tipoUsuario !== 3;

            const htmlOpciones = agregarTodas
              ? `<option value="">-- Todas las Empresas --</option>${opcionesEmpresas}`
              : opcionesEmpresas;

            $(node).html(`
                      <select id="filtroEmpresa" class="form-select select2" style="min-width: 280px;">
                        ${htmlOpciones}
                      </select>
                    `);

            $(node).find('select').select2();
          }
        },
        {
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar Bitácora</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#RegistrarBitacora'
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data[''];
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
        $('#filtroEmpresa').on('change', function () {
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

  //FUNCIONES DEL FUNCIONAMIENTO DEL CRUD//
  $(document).on('click', '#verBitacoraBtn', function () {
    const empresaId = $('#filtroEmpresa').val();

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

    let urlPDF = `/bitacoraProcesoElabPDF?empresa=${empresaId}`;

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
        $('#titulo_modal').text('Bitácora de control de hologramas de envasador');
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
    var id_bitacora = $(this).data('id');
    var dtrModal = $('.dtr-bs-modal.show');

    // Ocultar modal responsivo en pantalla pequeña si está abierto
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // SweetAlert para confirmar la eliminación
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
        // Enviar solicitud DELETE al servidor
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}bitacoraProcesoElab-list/${id_bitacora}`,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function () {
            dt_user.draw();

            Swal.fire({
              icon: 'success',
              title: '¡Eliminado!',
              text: '¡La bitácora ha sido eliminada correctamente!',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          },
          error: function (error) {
            console.log(error);

            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo eliminar la bitácora. Inténtalo de nuevo más tarde.',
              footer: `<pre>${error.responseText}</pre>`,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La eliminación de la bitácora ha sido cancelada',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    });
  });



    let indexMolienda = 1;
  function agregarFilaMolienda() {
    const html = `
      <div class="card mb-3 border rounded p-3 position-relative">
        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 btn-eliminar">Eliminar</button>
        <div class="row g-3 align-items-center">
          <div class="col-md-3">
            <div class="form-floating form-floating-outline">
              <input type="date" class="form-control" name="molienda[${indexMolienda}][fecha_molienda]" id="fecha_molienda_${indexMolienda}">
              <label for="fecha_molienda_${indexMolienda}">Fecha de molienda</label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" name="molienda[${indexMolienda}][numero_tina]" id="numero_tina_${indexMolienda}">
              <label for="numero_tina_${indexMolienda}">Nº de tina</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-floating form-floating-outline">
              <input type="date" class="form-control" name="molienda[${indexMolienda}][fecha_formulacion]" id="fecha_formulacion_${indexMolienda}">
              <label for="fecha_formulacion_${indexMolienda}">Fecha de formulación</label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-floating form-floating-outline">
              <input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][volumen_formulacion]" id="volumen_formulacion_${indexMolienda}">
              <label for="volumen_formulacion_${indexMolienda}">Volumen de formulación</label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-floating form-floating-outline">
              <input type="date" class="form-control" name="molienda[${indexMolienda}][fecha_destilacion]" id="fecha_destilacion_${indexMolienda}">
              <label for="fecha_destilacion_${indexMolienda}">Fecha de destilación</label>
            </div>
          </div>
        </div>

        <div class="row mt-3 g-3">
          <div class="col-md-4">
            <div class="fw-semibold mb-1">Puntas</div>
            <div class="form-floating form-floating-outline mb-2">
              <input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][puntas_volumen]" id="puntas_volumen_${indexMolienda}">
              <label for="puntas_volumen_${indexMolienda}">Volumen</label>
            </div>
            <div class="form-floating form-floating-outline">
              <input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][puntas_alcohol]" id="puntas_alcohol_${indexMolienda}">
              <label for="puntas_alcohol_${indexMolienda}">% Alc. Vol.</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="fw-semibold mb-1">Mezcal</div>
            <div class="form-floating form-floating-outline mb-2">
              <input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][mezcal_volumen]" id="mezcal_volumen_${indexMolienda}">
              <label for="mezcal_volumen_${indexMolienda}">Volumen</label>
            </div>
            <div class="form-floating form-floating-outline">
              <input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][mezcal_alcohol]" id="mezcal_alcohol_${indexMolienda}">
              <label for="mezcal_alcohol_${indexMolienda}">% Alc. Vol.</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="fw-semibold mb-1">Colas</div>
            <div class="form-floating form-floating-outline mb-2">
              <input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][colas_volumen]" id="colas_volumen_${indexMolienda}">
              <label for="colas_volumen_${indexMolienda}">Volumen</label>
            </div>
            <div class="form-floating form-floating-outline">
              <input type="number" step="0.01" class="form-control" name="molienda[${indexMolienda}][colas_alcohol]" id="colas_alcohol_${indexMolienda}">
              <label for="colas_alcohol_${indexMolienda}">% Alc. Vol.</label>
            </div>
          </div>
        </div>
      </div>
    `;

    $('#seccionMoliendaDinamica').append(html);
    indexMolienda++;
  }

  let indexSegundaDestilacion = 1;
  function agregarFilaSegundaDestilacion() {
    const html = `
      <div class="card mb-3 border rounded p-3 position-relative">
        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 btn-eliminar">Eliminar</button>
        <div class="row g-3 align-items-center">
          <div class="col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="date" class="form-control" name="segunda_destilacion[${indexSegundaDestilacion}][fecha_destilacion]" id="segunda_fecha_destilacion_${indexSegundaDestilacion}">
              <label for="segunda_fecha_destilacion_${indexSegundaDestilacion}">Fecha de destilación</label>
            </div>
          </div>
        </div>

        <div class="row mt-3 g-3">
          <div class="col-md-4">
            <div class="fw-semibold mb-1">Puntas</div>
            <div class="form-floating form-floating-outline mb-2">
              <input type="number" step="0.01" class="form-control" name="segunda_destilacion[${indexSegundaDestilacion}][puntas_volumen]" id="segunda_puntas_volumen_${indexSegundaDestilacion}">
              <label for="segunda_puntas_volumen_${indexSegundaDestilacion}">Volumen</label>
            </div>
            <div class="form-floating form-floating-outline">
              <input type="number" step="0.01" class="form-control" name="segunda_destilacion[${indexSegundaDestilacion}][puntas_alcohol]" id="segunda_puntas_alcohol_${indexSegundaDestilacion}">
              <label for="segunda_puntas_alcohol_${indexSegundaDestilacion}">% Alc. Vol.</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="fw-semibold mb-1">Mezcal</div>
            <div class="form-floating form-floating-outline mb-2">
              <input type="number" step="0.01" class="form-control" name="segunda_destilacion[${indexSegundaDestilacion}][mezcal_volumen]" id="segunda_mezcal_volumen_${indexSegundaDestilacion}">
              <label for="segunda_mezcal_volumen_${indexSegundaDestilacion}">Volumen</label>
            </div>
            <div class="form-floating form-floating-outline">
              <input type="number" step="0.01" class="form-control" name="segunda_destilacion[${indexSegundaDestilacion}][mezcal_alcohol]" id="segunda_mezcal_alcohol_${indexSegundaDestilacion}">
              <label for="segunda_mezcal_alcohol_${indexSegundaDestilacion}">% Alc. Vol.</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="fw-semibold mb-1">Colas</div>
            <div class="form-floating form-floating-outline mb-2">
              <input type="number" step="0.01" class="form-control" name="segunda_destilacion[${indexSegundaDestilacion}][colas_volumen]" id="segunda_colas_volumen_${indexSegundaDestilacion}">
              <label for="segunda_colas_volumen_${indexSegundaDestilacion}">Volumen</label>
            </div>
            <div class="form-floating form-floating-outline">
              <input type="number" step="0.01" class="form-control" name="segunda_destilacion[${indexSegundaDestilacion}][colas_alcohol]" id="segunda_colas_alcohol_${indexSegundaDestilacion}">
              <label for="segunda_colas_alcohol_${indexSegundaDestilacion}">% Alc. Vol.</label>
            </div>
          </div>
        </div>
      </div>
    `;

    $('#seccionSegundaDestilacion').append(html);
    indexSegundaDestilacion++;
  }

  // Delegar evento para eliminar fila (funciona para elementos dinámicos)
  $(document).on('click', '.btn-eliminar', function () {
    $(this).closest('.card').remove();
  });

/* fin chelo */
});
