/**
 * Page User List
 */
'use strict';
$(document).ready(function () {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    language: 'es' // Configura el idioma a español
  });
});

// Agregar nuevo registro
// Validando formulario y actualizando datos del usuario
const addNewGuia = document.getElementById('addGuiaForm');
// Validación del formulario
const fv = FormValidation.formValidation(addGuiaForm, {
  fields: {

    empresa: {
      validators: {
        notEmpty: {
          message: 'Por favor seleccione una empresa'
        }
      }
    },
    numero_guias: {
      validators: {
        notEmpty: {
          message: 'Por favor introduzca un numero de guias a solicitar'
        }
      }
    },
    predios: {
      validators: {
        notEmpty: {
          message: 'Por favor seleccione una empresa para continuar'
        }
      }
    },
    plantacion: {
      validators: {
        notEmpty: {
          message: 'Por favor seleccione una empresa para continuar'
        }
      }
    }



  },
  plugins: {
    trigger: new FormValidation.plugins.Trigger(),
    bootstrap5: new FormValidation.plugins.Bootstrap5({
      eleValidClass: '',
      rowSelector: function (field, ele) {
        return '.mb-5, .mb-6'; // Ajusta según las clases de tus elementos
      }
    }),
    submitButton: new FormValidation.plugins.SubmitButton(),
    autoFocus: new FormValidation.plugins.AutoFocus()
  }
}).on('core.form.valid', function (e) {
  //e.preventDefault();
  var formData = new FormData(addGuiaForm);

  $.ajax({
    url: '/guias/store', // Actualiza con la URL correcta
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      $('#addGuias').modal('hide');
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
        text: 'Error al registrar la guía dde traslado',
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
    offCanvasForm = $('#addGuias');

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
        url: baseUrl + 'guias-list'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id_guia' },
        {
          data: null,
          searchable: true, orderable: false,
          render: function (data, type, row) {
              var empresa = '';
              var razonSocial = '';
      
              if(row.id_empresa != 'N/A'){
                  empresa = '<br><span class="fw-bold text-dark small">Número del cliente:</span><span class="small"> ' + row.id_empresa + '</span>';
              }
              if(row.razon_social != 'N/A'){
                  razonSocial = '<br><span class="fw-bold text-dark small">Nombre del cliente:</span><span class="small"> ' + row.razon_social + '</span>';
              }
      
              return '<span class="fw-bold text-dark small">Número del cliente:</span> <span class="small"> ' + row.id_empresa + 
              '</span><br><span class="fw-bold text-dark small">Nombre del cliente:</span><span class="small"> ' + row.razon_social  
              ;
          }
      },
        { data: 'folio' },
        { data: 'run_folio' },
        { data: 'id_predio' },
        { data: 'numero_guias' },
        { data: 'numero_plantas' },
        { data: 'num_anterior' },
        { data: 'num_comercializadas' },
        { data: 'mermas_plantas' },
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
            var $name = full['id_empresa'];

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
          targets: 2,
          render: function (data, type, full, meta) {
            var $email = full['razon_social'];
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
/*         {
          // email verify
          targets: 11,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $id = full['id_guia'];
            return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdfGUias" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="${full['id_guia']}" data-registro="${full['razon_social']} "></i>`;
          }
        }, */
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
              `<a data-id="${full['id_guia']}" data-bs-toggle="modal" data-bs-target="#editGuias" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Llenar guia de traslado</a>` +
              `<a data-id="${full['run_folio']}" data-bs-toggle="modal" data-bs-target="#verGuiasRegistardas" href="javascript:;" class="dropdown-item ver-registros"><i class="ri-id-card-line ri-20px text-warning"></i> Ver/Llenar guias de traslado</a>` +
              `<a data-id="${full['id_guia']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar guia de traslado</a>` +
              /*               `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_guia']}" data-bs-toggle="modal" data-bs-target="#editGuias"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
                            `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_guia']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` + */
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
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar nueva Solicitud de Guia de Traslado</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#addGuias'
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
          url: `${baseUrl}guias-list/${user_id}`,
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

  // Reciben los datos del pdf
  $(document).on('click', '.pdf', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var pdfUrl = '../guia_de_translado/' + id; // Ruta del PDF

    var iframe = $('#pdfViewerGuias');
    $('#loading-spinner-chelo').show();//se el agrega esto
    iframe.hide();//se el agrega esto
    iframe.attr('src', '../guia_de_translado/' + id);

    $("#titulo_modal_GUIAS").text("Guia de traslado");
    $("#subtitulo_modal_GUIAS").text(registro);
    $('#mostrarPdfGUias').modal('show');
    var descargarBtn = $('#descargarPdfBtn');
    // Actualizar el enlace de descarga
    descargarBtn.off('click').on('click', function (e) {
      e.preventDefault();
      downloadPdfAsZip(pdfUrl, 'Guia_de_traslado_' + registro + '.pdf');
    });
  });
  // Ocultar el spinner cuando el PDF esté completamente cargado
  $('#pdfViewerGuias').on('load', function () {
    $('#loading-spinner-chelo').hide(); // Ocultar el spinner
    $(this).show(); // Mostrar el iframe con el PDF
  });

  // Función para descargar el PDF dentro de un ZIP
  function downloadPdfAsZip(pdfUrl, fileName) {
    // Crear una nueva instancia de JSZip
    var zip = new JSZip();

    // Descargar el archivo PDF
    fetch(pdfUrl)
      .then(response => response.blob())
      .then(blob => {
        // Añadir el archivo al ZIP
        zip.file(fileName, blob);

        // Generar el archivo ZIP
        zip.generateAsync({ type: "blob" })
          .then(function (zipBlob) {
            // Guardar el archivo ZIP usando FileSaver.js
            saveAs(zipBlob, fileName.replace('.pdf', '.zip'));
          });
      })
      .catch(error => console.error('Error al descargar el PDF:', error));
  }

  /*// Reciben los datos del pdf
  $(document).on('click', '.pdf', function () {
      var id = $(this).data('id');
      var registro = $(this).data('registro');
      var pdfUrl = '../guia_de_translado/' + id; // Ruta del PDF
  
      // Actualizar el iframe con el PDF
      var iframe = $('#pdfViewerGuias');
      iframe.attr('src', pdfUrl);
  
      // Actualizar el título y subtítulo del modal
      $("#titulo_modal_GUIAS").text("Guia de traslado");
      $("#subtitulo_modal_GUIAS").text(registro);
  
      // Actualizar el enlace de descarga
      var descargarBtn = $('#descargarPdfBtn');
      descargarBtn.attr('href', pdfUrl);
      descargarBtn.attr('download', 'Guia_de_traslado_' + registro + '.pdf'); // Nombre del archivo a descargar
  });
  */



  $(document).on('click', '.edit-record', function () {
    var id_guia = $(this).data('id');

    $.get('/edit/' + id_guia, function (data) {
      // Rellenar el formulario con los datos obtenidos
      $('#editt_id_guia').val(data.id_guia);
      $('#edit_id_empresa').val(data.id_empresa).trigger('change');
      $('#edit_numero_guias').val(data.numero_guias);
      $('#edit_nombre_predio').val(data.id_predio).trigger('change'); // Cambiado a 'id_predio'
      $('#edit_id_plantacion').val(data.id_plantacion).trigger('change');
      $('#edit_num_anterior').val(data.num_anterior);
      $('#edit_num_comercializadas').val(data.num_comercializadas);
      $('#edit_mermas_plantas').val(data.mermas_plantas);
      $('#edit_numero_plantas').val(data.numero_plantas);
      $('#edit_edad').val(data.edad);
      $('#edit_id_art').val(data.art);
      $('#edit_kg_magey').val(data.kg_maguey);
      $('#edit_no_lote_pedido').val(data.no_lote_pedido);
      $('#edit_fecha_corte').val(data.fecha_corte);
      $('#edit_id_observaciones').val(data.observaciones);
      $('#edit_nombre_cliente').val(data.nombre_cliente);
      $('#edit_no_cliente').val(data.no_cliente);
      $('#edit_fecha_ingreso').val(data.fecha_ingreso);
      $('#edit_domicilio').val(data.domicilio);


      // Mostrar el modal de edición
      $('#editGuias').modal('show');
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de la guía de traslado',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });




//edit guias tablas
// Evento de click para ver los registros y preparar la descarga de PDFs
$(document).on('click', '.ver-registros', function () {
  var run_folio = $(this).data('id');

  $.get('/editGuias/' + run_folio, function (data) {
      $('#tablita').empty();

      // Array para almacenar URLs y nombres de los PDFs
      var pdfFiles = [];

      // Iterar sobre los datos y rellenar la tabla con los datos obtenidos
      data.forEach(function (item) {
          var razon_social = item.empresa ? item.empresa.razon_social : 'Indefinido';
          var pdfUrl = '../guia_de_translado/' + item.id_guia;
          var filename = 'Guia_de_traslado_' + item.folio + '.pdf';

          // Agregar cada archivo PDF a la lista para el ZIP
          pdfFiles.push({ url: pdfUrl, filename: filename });

          // Agregar la fila a la tabla con el icono del PDF
          var fila = `
              <tr>
                  <td>${item.folio}</td>
                  <td>
                      <i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" 
                          data-bs-target="#mostrarPdfGUias" 
                          data-bs-toggle="modal" 
                          data-bs-dismiss="modal" 
                          data-id="${item.id_guia}" 
                          data-registro="${razon_social}">
                      </i>
                  </td>
              </tr>
          `;
          $('#tablita').append(fila);
      });

      // Mostrar el modal de edición
      $('#verGuiasRegistardas').modal('show');

      // Evento para descargar todos los PDFs en un archivo ZIP
      $('#descargarPdfBtn').off('click').on('click', function (e) {
          e.preventDefault();
          downloadPdfsAsZip(pdfFiles, `Guias_de_traslado_${run_folio}.zip`);
      });
  }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al obtener los datos de la guía de traslado',
          customClass: {
              confirmButton: 'btn btn-danger'
          }
      });
  });
});

// Función para descargar múltiples PDFs en un archivo ZIP
function downloadPdfsAsZip(pdfFiles, zipFileName) {
  // Mostrar alerta de "Procesando..."
  Swal.fire({
      title: 'Procesando...',
      text: 'Por favor espera mientras se comprimen los archivos.',
      allowOutsideClick: false,
      didOpen: () => {
          Swal.showLoading();
      }
  });

  var zip = new JSZip();

  // Crear una lista de promesas para descargar cada PDF
  var pdfPromises = pdfFiles.map(file =>
      fetch(file.url)
          .then(response => response.blob())
          .then(blob => {
              zip.file(file.filename, blob); // Añadir el archivo al ZIP
          })
          .catch(error => console.error('Error al descargar el PDF:', error))
  );

  // Esperar a que todas las descargas terminen y crear el ZIP
  Promise.all(pdfPromises).then(() => {
      zip.generateAsync({ type: "blob" })
          .then(function (zipBlob) {
              // Descargar el archivo ZIP
              saveAs(zipBlob, zipFileName);

              // Cerrar la alerta de "Procesando..." después de que el ZIP esté listo
              Swal.close();
          })
          .catch(error => {
              console.error('Error al generar el archivo ZIP:', error);
              Swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: 'Hubo un problema al generar el archivo ZIP.',
                  customClass: {
                      confirmButton: 'btn btn-danger'
                  }
              });
          });
  });
}







  const editGuiaForm = document.getElementById('editGuiaForm');

  // Validación del formulario
  const fv2 = FormValidation.formValidation(editGuiaForm, {
    fields: {
      id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un cliente'
          }
        }
      },
      numero_guias: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de guías solicitadas'
          }
        }
      },
      predios: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un predio'
          }
        }
      },
      plantacion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una plantación'
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
    var formData = new FormData(editGuiaForm);

    $.ajax({
      url: '/update/', // Actualiza con la URL correcta
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#editGuias').modal('hide');
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
          text: 'Error al registrar la guía de traslado',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });



});
