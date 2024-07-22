/**
 * Page Instalaciones List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_instalaciones_table = $('.datatables-users'),
    select2 = $('.select2'),
    offCanvasForm = $('#offcanvasAddInstalacion'); // Cambio de offcanvasAddUser a offcanvasAddInstalacion

  // Configuración de Select2
  if (select2.length) {
    var $this = select2;
    select2Focus($this);
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Option',
      dropdownParent: $this.parent()
    });
  }

  // Configuración de AJAX
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // InstalaDataTable
  if (dt_instalaciones_table.length) {
    var dt_instalaciones = dt_instalaciones_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'instalaciones-list'
      },
      columns: [
        { data: '' },
        { data: 'id_instalacion' },
        { data: 'razon_social' },
        { data: 'tipo' },
        { data: 'direccion_completa' },
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
            return `<span>${full.id_instalacion}</span>`;
          }
        },
        {
          // Razon Social
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full.razon_social;

            // Creates full output for row
            return `
              <div class="d-flex justify-content-start align-items-center user-name">
                <div class="d-flex flex-column">
                  <a href="${userView}" class="text-truncate text-heading">
                    <span class="fw-medium">${$name}</span>
                  </a>
                </div>
              </div>`;
          }
        },
        {
          // Tipo
          targets: 3,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full.tipo;

            return `
              <div class="d-flex justify-content-start align-items-center user-name">
                <div class="d-flex flex-column">
                  <span class="fw-medium">${$name}</span>
                </div>
              </div>`;
          }
        },
        {
          // Direccion Completa
          targets: 4,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full.direccion_completa;

            return `
              <div class="d-flex justify-content-start align-items-center user-name">
                <div class="d-flex flex-column">
                  <span class="fw-medium">${$name}</span>
                </div>
              </div>`;
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return `
              <div class="d-flex align-items-center gap-50">
                <button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full.id_instalacion}" data-bs-toggle="offcanvas" data-bs-target="#editInstalacion">
                  <i class="ri-edit-box-line ri-20px text-info"></i>
                </button>
                <button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full.id_instalacion}">
                  <i class="ri-delete-bin-7-line ri-20px text-danger"></i>
                </button>
                <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="ri-more-2-line ri-20px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end m-0">
                  <a href="${userView}" class="dropdown-item">View</a>
                  <a href="javascript:;" class="dropdown-item">Suspend</a>
                </div>
              </div>`;
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
      lengthMenu: [10, 20, 50, 70, 100], // for length of menu
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
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
          text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar</span>',
          buttons: [
            {
              extend: 'print',
              title: 'Instalaciones',
              text: '<i class="ri-printer-line me-1"></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
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
              title: 'Instalaciones',
              text: '<i class="ri-file-text-line me-1"></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
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
              title: 'Instalaciones',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4],
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
        }
      ]
    });

    // Evento para abrir el offcanvas de edición
    dt_instalaciones_table.on('click', '.edit-record', function () {
      var id = $(this).data('id');

      $.ajax({
        type: 'GET',
        url: baseUrl + 'instalaciones/' + id,
        success: function (response) {
          if (response) {
            // Rellena el formulario con los datos recibidos
            $('#editInstalacion #id_instalacion').val(response.id_instalacion);
            $('#editInstalacion #tipo').val(response.tipo);
            $('#editInstalacion #direccion_completa').val(response.direccion_completa);
            $('#editInstalacion #id_empresa').val(response.id_empresa).trigger('change');
          }
        },
        error: function () {
          Swal.fire('Error', 'No se pudo cargar la información de la instalación.', 'error');
        }
      });
    });

    // Evento para eliminar registro
    dt_instalaciones_table.on('click', '.delete-record', function () {
      var id = $(this).data('id');

      Swal.fire({
        title: 'Confirmar',
        text: '¿Estás seguro de que quieres eliminar este registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            type: 'DELETE',
            url: baseUrl + 'instalaciones/' + id,
            success: function (response) {
              if (response.success) {
                Swal.fire('Eliminado', 'El registro ha sido eliminado.', 'success');
                dt_instalaciones.ajax.reload();
              } else {
                Swal.fire('Error', 'No se pudo eliminar el registro.', 'error');
              }
            },
            error: function () {
              Swal.fire('Error', 'No se pudo eliminar el registro.', 'error');
            }
          });
        }
      });
    });
  }
});
