// resources/js/catalogo_lotes.js

$(function() {

    const tipoLoteSelect = document.getElementById('tipo_lote');
    const ocCidamFields = document.getElementById('oc_cidam_fields');
    const otroOrganismoFields = document.getElementById('otro_organismo_fields');
    
    
    tipoLoteSelect.addEventListener('change', function() {
        const selectedValue = tipoLoteSelect.value;
    
        if (selectedValue === '1') {
            ocCidamFields.classList.remove('d-none');
            otroOrganismoFields.classList.add('d-none');
                
        } else if (selectedValue === '2') {
            ocCidamFields.classList.add('d-none');
            otroOrganismoFields.classList.remove('d-none');
            

        } else {
            ocCidamFields.classList.add('d-none');
            otroOrganismoFields.classList.add('d-none');
        }
    });
    


    $('.select2').select2(); // Inicializa select2 en el documento

//DATE PICKER

$(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd'
    });
  
  });
  
  
    // Inicializar DataTable
    var dt_user = $('.datatables-users').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/lotes-granel-list',
            type: 'GET'
        },
        columns: [
            { data: '' },
            { data: 'id_lote_granel' },
            { data: 'id_empresa' },
            { data: 'nombre_lote' },
            { data: 'tipo_lote' },
            { data: 'folio_fq' },
            { data: 'volumen' },
            { data: 'cont_alc' },
            { data: 'id_categoria' },
            { data: 'id_clase' },
            { data: 'id_tipo' },
         /* { : 'id_guia' }, */
            { data: 'ingredientes' },
            { data: 'edad' },
            { data: 'folio_certificado' },
            { data: 'id_organismo' },
            { data: 'fecha_emision' },
            { data: 'fecha_vigencia', orderable: false, searchable: false  },
            { data: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [
            {
                // For Responsive
                className: 'control',
                searchable: false,
                orderable: true,
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
              `<a data-id="${full['id_lote_granel']}" data-bs-toggle="modal" data-bs-target="#offcanvasEditLote" class="dropdown-item edit-record waves-effect text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>` +
              `<a data-id="${full['id_lote_granel']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>` +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              '<a class="dropdown-item">Suspend</a>' +
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
                text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar</span>',
                buttons: [
                    {
                        extend: 'print',
                        title: 'Lotes a granel',
                        text: '<i class="ri-printer-line me-1"></i>Print',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                            format: {
                                body: function (inner, rowIndex, columnIndex) {
                                    if (columnIndex === 5) {
                                        return 'ViewSuspend';
                                    }
                                    return inner;
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
                        title: 'Lotes a granel',
                        text: '<i class="ri-file-text-line me-1"></i>CSV',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
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
                        title: 'Lotes a granel',
                        text: '<i class="ri-file-excel-line me-1"></i>Excel',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
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
                        title: 'Lotes a granel',
                        text: '<i class="ri-file-pdf-line me-1"></i>PDF',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
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
                        text: '<i class="ri-file-copy-line me-1"></i>Copy',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
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
                text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Lote</span>',
                className: 'add-new btn btn-primary waves-effect waves-light',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#offcanvasAddLote'
                }
            }
        ],

      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['nombre_lote'];
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


// Delete Record
$(document).on('click', '.delete-record', function () {
    var id_lote= $(this).data('id'); // Obtener el ID de la clase
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
                url: `${baseUrl}lotes-granel-list/${id_lote}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    // Actualizar la tabla después de eliminar el registro
                    dt_user.draw();

                    // Mostrar SweetAlert de éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: '¡El lote ha sido eliminada correctamente!',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                },
                error: function (error) {
                    console.log(error);
                    // Mostrar SweetAlert de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar el lote. Inténtalo de nuevo más tarde.',
                        footer: `<pre>${error.responseText}</pre>`,
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }

            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Acción cancelada, mostrar mensaje informativo
            Swal.fire({
                title: 'Cancelado',
                text: 'La eliminación del lote ha sido cancelada',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});

const addNewLote = document.getElementById('loteForm');
/* registro de un nuevo lote */
const fv = FormValidation.formValidation(addNewLote, {
    fields: {
        nombre_lote: {
            validators: {
                notEmpty: {
                message: 'Por favor seleccione el cliente'
                }
            }
        },
      id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione el cliente'
          }
        }
      },
      tipo_lote: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione el tipo de lote'
          }
        }
      },
      'id_guia[]': {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un folio de guía'
          }
        }
      },
      volumen: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un folio de guía'
          }
        }
      },
      cont_alc: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un folio de guía'
          }
        }
      },
      id_categoria: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un folio de guía'
          }
        }
      },
      id_clase: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un folio de guía'
          }
        }
      },
      id_tipo: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un folio de guía'
          }
        }
      },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        eleValidClass: '',
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          return '.mb-4';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function (e) {
   // e.preventDefault();
    var formData = new FormData(addNewLote);
  
    $.ajax({
      url: '/lotes-granel-list',
      type: 'POST',
      data: formData,
      processData: false, // Evita la conversión automática de datos a cadena
      contentType: false, // Evita que se establezca el tipo de contenido
      success: function (response) {
        $('#loteForm').trigger("reset");
        $('#id_empresa').val('').trigger('change');
        $('#id_guia').val('').trigger('change');
        $('#offcanvasAddLote').modal('hide');
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
          text: 'Error al agregar el lote a granel',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });




$(document).on('click', '.edit-record', function () {
    var loteId = $(this).data('id');
    $('#edit_lote_id').val(loteId);

    $.ajax({
        url: '/lotes-a-granel/' + loteId + '/edit',
        method: 'GET',
        success: function (data) {
            console.log(data); // Verifica la respuesta del servidor

            if (data.success) {
                var lote = data.lote;

                // Rellenar el modal con los datos del lote
                $('#edit_nombre_lote').val(lote.nombre_lote);
                $('#edit_id_empresa').val(lote.id_empresa).trigger('change');
                $('#edit_tipo_lote').val(lote.tipo_lote);
                $('#edit_id_guia').val(data.guias).trigger('change');
                $('#edit_volumen').val(lote.volumen);
                $('#edit_cont_alc').val(lote.cont_alc);
                $('#edit_id_categoria').val(lote.id_categoria).trigger('change');
                $('#edit_clase_agave').val(lote.id_clase).trigger('change');
                $('#edit_tipo_agave').val(lote.id_tipo).trigger('change');

                // Mostrar campos condicionales
                if (lote.tipo_lote == '1') {
                    $('#edit_oc_cidam_fields').removeClass('d-none');
                    $('#edit_otro_organismo_fields').addClass('d-none');
                    $('#edit_ingredientes').val(lote.ingredientes);
                    $('#edit_edad').val(lote.edad);
                } else if (lote.tipo_lote == '2') {
                    $('#edit_otro_organismo_fields').removeClass('d-none');
                    $('#edit_oc_cidam_fields').addClass('d-none');
                    $('#edit_folio_certificado').val(lote.folio_certificado);
                    $('#edit_organismo_certificacion').val(lote.id_organismo);
                    $('#edit_fecha_emision').val(lote.fecha_emision);
                    $('#edit_fecha_vigencia').val(lote.fecha_vigencia);

                    // Mostrar enlace al archivo PDF si está disponible
                    var archivoDisponible = false;
                    var documentos = data.documentos;
                    documentos.forEach(function (documento) {
                        if (documento.url) {
                            archivoDisponible = true;
                            var fileName = documento.url.split('/').pop();
                            $('#archivo_url_display_otro_organismo').html('Documento disponible: <a href="../files/' + data.numeroCliente + '/' + documento.url + '" target="_blank" class="text-primary">' + fileName + '</a>');
                        }
                    });
                    if (!archivoDisponible) {
                        $('#archivo_url_display_otro_organismo').html('No hay archivo disponible.');
                    }
                } else {
                    $('#edit_oc_cidam_fields').addClass('d-none');
                    $('#edit_otro_organismo_fields').addClass('d-none');
                }
                // Actualizar la tabla de documentos
                var documentos = data.documentos;
                if (documentos && documentos.length > 0) {
                    var documentoCompletoUrlAsignado = false; // Variable para controlar la asignación del documento completo
                    var documentoAjusteUrlAsignado = false;   // Variable para controlar la asignación del documento de ajuste

                    documentos.forEach(function (documento) {
                        var archivoUrlDisplayCompleto = $('#archivo_url_display_completo_' + documento.id_documento);
                        var archivoUrlDisplayAjuste = $('#archivo_url_display_ajuste_' + documento.id_documento);
                        var folioFqCompletoInput = $('#folio_fq_completo_' + documento.id_documento);
                        var folioFqAjusteInput = $('#folio_fq_ajuste_' + documento.id_documento);
                        
                        // Mostrar el documento completo
                        if (documento.tipo.includes('Análisis completo') && documento.url && !documentoCompletoUrlAsignado) {
                            var fileNameCompleto = documento.url.split('/').pop();
                            archivoUrlDisplayCompleto.html('Documento completo disponible: <a href="../files/' + data.numeroCliente + '/' + documento.url + '" target="_blank" class="text-primary">' + fileNameCompleto + '</a>');
                            folioFqCompletoInput.val(documento.nombre);
                            documentoCompletoUrlAsignado = true; // Marcar como asignado
                        }

                        // Mostrar el documento de ajuste
                        if (documento.tipo.includes('Ajuste de grado') && documento.url && !documentoAjusteUrlAsignado) {
                            var fileNameAjuste = documento.url.split('/').pop();
                            archivoUrlDisplayAjuste.html('Documento ajuste disponible: <a href="../files/' + data.numeroCliente + '/' + documento.url + '" target="_blank" class="text-primary">' + fileNameAjuste + '</a>');
                            folioFqAjusteInput.val(documento.nombre);
                            documentoAjusteUrlAsignado = true; // Marcar como asignado
                        }
                    });

                    // Si no se asignó un documento completo, mostrar un mensaje
                    if (!documentoCompletoUrlAsignado) {
                        $('#archivo_url_display_completo_' + documento.id_documento).html('No hay archivo completo disponible.');
                    }

                    // Si no se asignó un documento de ajuste, mostrar un mensaje
                    if (!documentoAjusteUrlAsignado) {
                        $('#archivo_url_display_ajuste_' + documento.id_documento).html('No hay archivo de ajuste disponible.');
                    }
                } else {
                    console.log('No hay documentos disponibles.');
                }

                console.log('Documentos:', documentos);
                documentos.forEach(function (documento) {
                    console.log('Documento ID:', documento.id_documento);
                    console.log('Tipo:', documento.tipo);
                    console.log('URL:', documento.url);
                    
                    var archivoUrlDisplayCompleto = $('#archivo_url_display_completo_' + documento.id_documento);
                    var archivoUrlDisplayAjuste = $('#archivo_url_display_ajuste_' + documento.id_documento);
                    
                    console.log('Completo ID:', '#archivo_url_display_completo_' + documento.id_documento);
                    console.log('Ajuste ID:', '#archivo_url_display_ajuste_' + documento.id_documento);
                });

                
                // Mostrar el modal
                $('#offcanvasEditLote').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar los datos del lote.',
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            }
        },
        error: function (error) {
            console.error('Error al cargar los datos del lote:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar los datos del lote.',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }
    });
});



    const edit_tipoLoteSelect = document.getElementById('edit_tipo_lote');
    const edit_ocCidamFields = document.getElementById('edit_oc_cidam_fields');
    const edit_otroOrganismoFields = document.getElementById('edit_otro_organismo_fields');

    // Selecciona los campos de archivo y de texto
    const edit_otroOrganismoFileField = document.getElementById('file-59');

    edit_tipoLoteSelect.addEventListener('change', function() {
        const edit_selectedValue = edit_tipoLoteSelect.value;

        if (edit_selectedValue === '1') {
            edit_ocCidamFields.classList.remove('d-none');
            edit_otroOrganismoFields.classList.add('d-none');
        
        } else if (edit_selectedValue === '2') {
            edit_ocCidamFields.classList.add('d-none');
            edit_otroOrganismoFields.classList.remove('d-none');

        } else {
            edit_ocCidamFields.classList.add('d-none');
            edit_otroOrganismoFields.classList.add('d-none');

        }
    });



$('#loteFormEdit').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    console.log([...formData.entries()]); // Mostrar el contenido del FormData

    var loteId = $('#edit_lote_id').val();

    $.ajax({
        url: '/lotes-a-granel/' + loteId,
        type: 'POST', // Cambiar a POST, el método PUT se define en el formData
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            dt_user.ajax.reload();
            $('#offcanvasEditLote').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: response.message,
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                var errorMessages = Object.keys(errors).map(function(key) {
                    return errors[key].join('<br>');
                }).join('<br>');

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorMessages,
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al actualizar el lote.',
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            }
        }
    });
});

    



});
