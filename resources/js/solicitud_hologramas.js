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
                    message: 'Por favor introduzca el nombre del lote'
                }
            }
        },
        id_empresa: {
            validators: {
                notEmpty: {
                    message: 'Por favor introduzca el nombre del lote'
                }
            }
        },
        id_marca: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese un numero de pedido/SKU'
                }
            }
        },
        id_solicitante: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese un numero de pedido/SKU'
                }
            }
        },
        cantidad_hologramas: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese un digito'
                }
            }
        },
        id_direccion: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese un destino de lote'
                }
            }
        },
        comentarios: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese un digito'
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
        /* {
          // User email
          targets: 3,
          render: function (data, type, full, meta) {
            var $email = full['categoria'];
            return '<span class="user-email">' + $email + '</span>';
          }
        }, */
/*         {
          // email verify
          targets: 4,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $verified = full['regimen'];
            if($verified=='Persona física'){
              var $colorRegimen = 'info';
            }else{
              var $colorRegimen = 'warning';
            }
            return `${
              $verified
                ? '<span class="badge rounded-pill  bg-label-'+$colorRegimen+'">' + $verified + '</span>'
                : '<span class="badge rounded-pill  bg-label-'+$colorRegimen+'">' + $verified + '</span>'
            }`;
          }
        },*/
         {
          // email verify
          targets: 8,
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
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
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
              return 'Detalles de ' + data['categoria'];
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
        iframe.attr('src', '../solicitud_de_holograma/'/* +id */);

        $("#titulo_modal").text("Solicitud de entrega de hologramas");
        $("#subtitulo_modal").text(registro);
        
      
});


// Editar registro
// Editar registro
$(document).on('click', '.edit-record', function () {
  var id_solicitud = $(this).data('id');

  $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {
      // Rellenar el formulario con los datos obtenidos
      $('#edit_id_solicitud').val(data.id_solicitud);
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

// Manejo del envío del formulario de edición de Hologramas
$('#editHologramasForm').on('submit', function (e) {
  e.preventDefault(); // Evita el comportamiento predeterminado del formulario

  var formData = $(this).serialize(); // Serializa los datos del formulario
  var id_solicitud = $('#edit_id_solicitud').val(); // Obtiene el ID de la solicitud

  $.ajax({
      url: '/solicitud_holograma/update/' + id_solicitud, // URL de la ruta de actualización
      method: 'PUT', // Método HTTP
      data: formData, // Datos enviados
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



//end
});
