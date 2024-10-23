/**
 * Page User List
 */
'use strict';

// Agregar nuevo registro
// validating form and updating user's data
const addNewMarca = document.getElementById('addNewMarca');

// Validación del formulario
const fv = FormValidation.formValidation(addNewMarca, {
  fields: {
    cliente: {
      validators: {
        notEmpty: {
          message: 'Por favor seleccione el cliente'
        }
      }
    },
    marca: {
      validators: {
        notEmpty: {
          message: 'Por favor introduzca el nombre de la marca'
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
}).on('core.form.valid', function (e) {
  // e.preventDefault();
  var formData = new FormData(addNewMarca);

  $.ajax({
    url: '/catalago-list',
    type: 'POST',
    data: formData,
    processData: false, // Evita la conversión automática de datos a cadena
    contentType: false, // Evita que se establezca el tipo de contenido
    success: function (response) {
      $('#addMarca').modal('hide');
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
        text: 'Error al agregar la marca',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    }
  });
});



//DATE PICKER
//Datepicker inicializador

$(document).ready(function () {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });

});

$(function () {
  // Datatable (jquery)
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#addMarca');

  // Función para inicializar Select2 en elementos específicos
  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      select2Focus($this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Selecciona cliente',
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
        url: baseUrl + 'catalago-list'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id_marca' },
        { data: 'folio' },
        { data: 'marca' },
        { data: 'razon_social' }, // Nueva columna para la razón social
        { data: 'id_norma' },
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
          // User email
          targets: 3,
          render: function (data, type, full, meta) {
            var $email = full['marca'];
            return '<span class="user-email">' + $email + '</span>';
          }
        },

        /*{
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
        /*{
           // email verify
           targets: 5,
           className: 'text-center',
           render: function (data, type, full, meta) {
             var $id = full['id_marca'];
             return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="${full['id_marca']}" data-registro="${full['folio']} "></i>`;
           }
         },*/

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
              /*               `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_marca']}" data-bs-toggle="modal" data-bs-target="#editMarca"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
                            `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_marca']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` + */
              `<a data-id="${full['id_marca']}" data-bs-toggle="modal" data-bs-target="#editMarca" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar marca</a>` +
              `<a data-id="${full['id_marca']}" data-bs-toggle="modal" data-bs-target="#etiquetas" href="javascript:;" class="dropdown-item edit-chelo"><i class="ri-price-tag-2-line ri-20px text-success"></i> Subir/Ver etiquetas</a>` +
              `<a data-id="${full['id_marca']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar marca</a>` +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
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
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar nueva marca</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#addMarca'
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
          url: `${baseUrl}catalago-list/${user_id}`,
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

  /*$(document).on('click', '.pdf', function () {
        var id = $(this).data('id');
        var registro = $(this).data('registro');
            var iframe = $('#pdfViewer');
            iframe.attr('src', '../solicitudinfo_cliente/'+id);

            $("#titulo_modal").text("Solicitud de información del cliente");
            $("#subtitulo_modal").text(registro);
            
          
  });*/
  $(document).ready(function () {
    // Abrir el modal y cargar datos para editar
    $(document).on('click', '.edit-record', function () {
      var id_marca = $(this).data('id');

      // Limpiar campos y contenido residual del formulario de edición
      $('#editMarcaForm')[0].reset();
      $('.existing-file').html(''); // Asegúrate de que todos los contenedores de archivos existentes estén vacíos
      $('.existing-date').text(''); // Asegúrate de que todos los contenedores de fechas existentes estén vacíos

      // Realizar la solicitud AJAX para obtener los datos de la marca
      $.get('/marcas-list/' + id_marca + '/edit', function (data) {
        var marca = data.marca;
        var documentacion_urls = data.documentacion_urls;
        var numCliente = data.numeroCliente;


        // Rellenar el formulario con los datos obtenidos
        $('#edit_marca_id').val(marca.id_marca);
        $('#edit_marca_nombre').val(marca.marca);
        $('#edit_cliente').val(marca.id_empresa).trigger('change');
        $('#edit_id_norma').val(marca.id_norma).trigger('change');


        // Mostrar archivos existentes en los mismos espacios de entrada de archivo
        documentacion_urls.forEach(function (doc) {
          console.log(doc.url);
          var existingFileDivId = '#existing_file_' + doc.id_documento;
          $(existingFileDivId).html(`<p>Archivo existente: <a href="../files/${numCliente}/${doc.url}" target="_blank">${doc.url}</a></p>`);

          var existingDateId = '#existing_date_' + doc.id_documento;
          $(existingDateId).text('Fecha de vigencia: ' + doc.fecha_vigencia);

          var existingDateId = '#Editdate' + doc.id_documento;
          $(existingDateId).val(doc.fecha_vigencia);





          $('#date' + doc.id_documento).val(doc.fecha_vigencia);  // Rellenar la fecha existente en el campo de fecha
        });

        $('#editMarca').modal('show');
      });
    });
  });



    // Enviar el formulario de actualización de marca
    $('#editMarcaForm').submit(function (e) {
      e.preventDefault();

      var formData = new FormData(this);

      $.ajax({
        url: '/marcas-list/update',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          Swal.fire({
            title: 'Éxito',
            text: response.success,
            icon: 'success',
            buttonsStyling: false,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
          $('#editMarca').modal('hide');
          $('#editMarcaForm')[0].reset();
          $('.datatables-users').DataTable().ajax.reload();
        },
        error: function (response) {

          Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al actualizar la marca.',
            icon: 'error',
            buttonsStyling: false,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    });


//envio metodo
$(document).on('click', '.edit-chelo', function () {
  var id_marca = $(this).data('id');

  console.log(id_marca)
  // Realizar la solicitud AJAX para obtener los datos de la marca
  $.get('/marcas-list/' + id_marca + '/edit', function (data) {
    var marca = data.marca;

    // Rellenar el campo con el ID de la marca obtenida
    $('#edit_marca_id').val(marca.id_marca);

    // Mostrar el modal de edición de etiquetas
    $('#etiquetas').modal('show');
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





});
