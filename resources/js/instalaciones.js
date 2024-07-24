$(function () {
  var baseUrl = window.location.origin;

  var dt_instalaciones_table = $('.datatables-users').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + '/instalaciones-list',
      type: 'GET',
      dataSrc: function (json) {
        console.log('Datos de AJAX:', json);
        return json.data;
      }
    },
    columns: [
      { data: 'id_instalacion' },
      { data: 'razon_social' },
      { data: 'tipo' },
      { data: 'estado' },
      { data: 'direccion_completa' },
      { data: 'action' }
    ],
    columnDefs: [
      {
        targets: 0,
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
          return meta.row + 1;
        }
      },
      {
        targets: -1,
        title: 'Acciones',
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
          return (
            '<div class="d-flex align-items-center gap-50">' +
            `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_instalacion']}" data-bs-toggle="offcanvas" data-bs-target="#editInstalacion"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
            `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_instalacion']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` +
            '</div>'
          );
        }
      }
    ],
    order: [[1, 'desc']],
    dom: '<"card-header d-flex rounded-0 flex-wrap pb-md-0 pt-0"' +
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
          // Definición de botones para exportar
        ]
      },
      {
        text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Instalación</span>',
        className: 'add-new btn btn-primary waves-effect waves-light',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-target': '#modalAddInstalacion'
        }
      }
    ]
  });

  $(document).on('click', '.delete-record', function () {
    var id_instalacion = $(this).data('id');
    var url = `${baseUrl}/domicilios/${id_instalacion}`;
    console.log('URL de eliminación:', url);

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
        $.ajax({
          type: 'DELETE',
          url: url,
          success: function (response) {
            console.log('Respuesta de eliminación:', response);
            if (response.success) {
              dt_instalaciones_table.ajax.reload();
              Swal.fire({
                icon: 'success',
                title: '¡Eliminado!',
                text: '¡La solicitud ha sido eliminada correctamente!',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.error || 'Error desconocido',
                customClass: {
                  confirmButton: 'btn btn-danger'
                }
              });
            }
          },
          error: function (xhr, status, error) {
            console.error('Error:', error);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo eliminar el registro',
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
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });
});
