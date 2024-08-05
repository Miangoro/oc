$(function () {
  // Definir la URL base
  var baseUrl = window.location.origin + '/';

  // Inicializar DataTable
  var dt_instalaciones_table = $('.datatables-users').DataTable({

    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + 'instalaciones-list',
      type: 'GET',
      dataSrc: function (json) {
        console.log(json); // Ver los datos en la consola
        return json.data;
      },
      error: function (xhr, error, thrown) {
        console.error('Error en la solicitud Ajax:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un problema al cargar los datos.',
        });
      }
    },
    columns: [
      { data: '' },
      { data: 'id_instalacion' },
      { data: 'razon_social' },
      { data: 'tipo' },
      { data: 'estado' },
      { data: 'direccion_completa' },
      { data: 'folio' },
      { data: 'organismo' },
      { data: '' },
      { data: 'fecha_emision' },
      { data: 'fecha_vigencia' },
      { data: 'actions' } // Asegúrate de que el campo de acción esté correctamente definido
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
        // email verify
        targets: 8,
        className: 'text-center',
        render: function (data, type, full, meta) {

          if (full['url'] && full['url'].trim() !== '') {
            return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-url="${full['url']}" data-registro="${full['url']}"></i>`;
        } else {
            return '---';
        }
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
            `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_instalacion']}" data-bs-toggle="modal" data-bs-target="#modalEditInstalacion"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
            `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_instalacion']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` +
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
          {
            extend: 'print',
            title: 'Instalaciones',
            text: '<i class="ri-printer-line me-1"></i>Print',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5],
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
            title: 'Instalaciones',
            text: '<i class="ri-file-text-line me-1"></i>CSV',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 5) {
                    return 'ViewSuspend';
                  }
                  return inner;
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
              columns: [0, 1, 2, 3, 4, 5],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 5) {
                    return 'ViewSuspend';
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'pdf',
            title: 'Instalaciones',
            text: '<i class="ri-file-pdf-line me-1"></i>PDF',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 5) {
                    return 'ViewSuspend';
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'copy',
            title: 'Instalaciones',
            text: '<i class="ri-file-copy-line me-1"></i>Copy',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 5) {
                    return 'ViewSuspend';
                  }
                  return inner;
                }
              }
            }
          }
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

  var dt_user_table = $('.datatables-users'),
  select2Elements = $('.select2'),
  userView = baseUrl + 'app/user/view/account'
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

  // Configuración CSRF para Laravel
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Eliminar registro
  $(document).on('click', '.delete-record', function () {
    var id_instalacion = $(this).data('id');

    // Confirmación con SweetAlert
    Swal.fire({
      title: '¿Está seguro?',
      text: "No podrá revertir este evento",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // Solicitud de eliminación
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}instalaciones/${id_instalacion}`, // Ajusta la URL aquí
          success: function () {
            dt_instalaciones_table.draw();
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


  $(function () {


    
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar select2
    $('.select2').select2();

    // Inicializar FormValidation
    const form = document.getElementById('addNewInstalacionForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        'id_empresa': {
          validators: {
            notEmpty: {
              message: 'Selecciona una empresa.'
            }
          }
        },
        'tipo': {
          validators: {
            notEmpty: {
              message: 'Selecciona un tipo de instalación.'
            }
          }
        },
        'estado': {
          validators: {
            notEmpty: {
              message: 'Selecciona un estado.'
            }
          }
        },
        'direccion_completa': {
          validators: {
            notEmpty: {
              message: 'Ingrese la dirección completa.'
            }
          }
        },
        'certificacion': {
          validators: {
            notEmpty: {
              message: 'Selecciona el tipo de certificación.'
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',  // Clase para campos válidos
          eleInvalidClass: '', // Clase para campos inválidos
          rowSelector: '.form-floating' // Selector para el contenedor del campo
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }

    }).on('core.form.valid', function (e) {

      // Validar el formulario


          var formData = new FormData(form);

          $.ajax({
            url: '/instalaciones',
            type: 'POST',
            data: formData,
            processData: false, // Evita la conversión automática de datos a cadena
            contentType: false, // Evita que se establezca el tipo de contenido
            success: function (response) {
              // Ocultar el modal y reiniciar el formulario
              $('#modalAddInstalacion').modal('hide');
              $('#addNewInstalacionForm')[0].reset();

              // Reiniciar los campos select2
              $('.select2').val(null).trigger('change');

              // Recargar los datos en la tabla
              $('.datatables-users').DataTable().ajax.reload();

              console.log(response);

              Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: response.message, // Mensaje de éxito de la respuesta
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            },
            error: function (xhr) {
              console.log('Error:', xhr.responseText); // Muestra el error en la consola

              Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Error al agregar la instalación', // Mensaje de error
                customClass: {
                  confirmButton: 'btn btn-danger'
                }
              });
            }
          });


    });
  });


  //new
  $(document).on('click', '.edit-record', function () {
    var id_instalacion = $(this).data('id');
    var url = baseUrl + 'domicilios/edit/' + id_instalacion;

    // Limpiar campos del formulario antes de cargar nuevos datos
    $('#edit_certificado_otros').addClass('d-none');
    $('#archivo_url_display').html('No hay archivo disponible.');

    $.get(url, function (data) {
        if (data.success) {
            var instalacion = data.instalacion;

            // Asignar valores a los campos
            $('#edit_id_empresa').val(instalacion.id_empresa).trigger('change');
            $('#edit_tipo').val(instalacion.tipo).trigger('change');
            $('#edit_estado').val(instalacion.estado).trigger('change');
            $('#edit_direccion').val(instalacion.direccion_completa);

            // Verificar si hay valores en los campos adicionales
            var tieneCertificadoOtroOrganismo = instalacion.folio || instalacion.id_organismo ||
                (instalacion.fecha_emision && instalacion.fecha_emision !== 'N/A') ||
                (instalacion.fecha_vigencia && instalacion.fecha_vigencia !== 'N/A') ||
                data.archivo_url;

            if (tieneCertificadoOtroOrganismo) {
                $('#edit_certificacion').val('otro_organismo').trigger('change');
                $('#edit_certificado_otros').removeClass('d-none');

                $('#edit_folio').val(instalacion.folio || '');
                $('#edit_id_organismo').val(instalacion.id_organismo || '').trigger('change');
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
    }).fail(function() {
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

$(document).ready(function() {
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
                    footer: `<pre>${JSON.stringify(xhr.responseJSON, null, 2)}</pre>`,
                });
            }
        });
    });
});


$(document).on('click', '.pdf', function () {
  var url = $(this).data('url');
  var registro = $(this).data('registro');
      var iframe = $('#pdfViewer');
      iframe.attr('src', '../files/'+url);

      $("#titulo_modal").text("Certificado de instalaciones");
      $("#subtitulo_modal").text(registro);


});


//end
});
