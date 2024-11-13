$(function () {
  var dt_user_table = $('.datatables-users'),
  select2Elements = $('.select2'),
  userView = baseUrl + 'app/user/view/account'

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

  $(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es' 
    });
  });

  var baseUrl = window.location.origin + '/';
  var dt_instalaciones_table = $('.datatables-users').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + 'instalaciones-list',
      type: 'GET',
      dataSrc: function (json) {
        console.log(json); 
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
      { data: 'razon_social', responsivePriority: 1 }, 
      { data: 'tipo' },
      { data: 'estado' },
      { data: 'direccion_completa' },
      { data: 'folio' },
      { data: '' },
      { data: 'actions' } 
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
        orderable: true,
        targets: 1,
        render: function (data, type, full, meta) {
          return `<span>${full.fake_id}</span>`;
        }
      },
      {
        targets: 3,
        responsivePriority: 3,
        render: function (data, type, full, meta) {
            var tipos = []; 
            try {
                if (full['tipo']) {
                    tipos = JSON.parse(full['tipo']); 
                }
            } catch (e) {
                tipos = full['tipo'] ? full['tipo'].split(',') : [];
            }
    
            const tipoConfig = {
                'Productora': { color: 'primary', nombre: 'Productora' },     // Azul
                'Envasadora': { color: 'success', nombre: 'Envasadora' },     // Verde
                'Comercializadora': { color: 'info', nombre: 'Comercializadora' }, // Celeste
                'Almacen y bodega': { color: 'danger', nombre: 'Almacén y bodega' }, // Rojo
                'Area de maduracion': { color: 'warning', nombre: 'Área de maduración' } // Amarillo
            };
    
            var badges = ''; 
            tipos.forEach(function(tipo) {
                tipo = tipo.trim();
                const config = tipoConfig[tipo] || { color: 'secondary', nombre: 'Desconocido' }; 
                badges += `<span class="badge rounded-pill bg-label-${config.color}">${config.nombre}</span> `;
            });
    
            return badges || '<span class="badge rounded-pill bg-label-secondary">N/A</span>';
        }
      },      
      {
        targets: 4,
        render: function (data, type, full, meta) {
          var $responsable = full['responsable'];
          return '<span class="user-email">' + $responsable + '</span>';
        }
      },
      {
      // PDF
        targets: 7,
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
            // Botón de Opciones
            '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
            '<i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>' +
            '</button>' +
            // Menú desplegable
            '<div class="dropdown-menu dropdown-menu-end m-0">' +
            // Botón para Modificar
            `<a class="dropdown-item waves-effect text-info edit-record" ` +
            `data-id="${full['id_instalacion']}" ` +
            `data-bs-toggle="modal" ` +
            `data-bs-target="#modalEditInstalacion">` +
            '<i class="ri-edit-box-line ri-20px text-info"></i> Modificar' +
            '</a>' +
            // Botón para Eliminar
            `<a class="dropdown-item waves-effect text-danger delete-record" ` +
            `data-id="${full['id_instalacion']}">` +
            '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar' +
            '</a>' +
            '</div>' + // Cierre del menú desplegable
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
            title: 'Instalaciones',
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
                    return inner.replace(/<[^>]*>/g, ''); 
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 8 || columnIndex === 11) {
                    return 'ViewSuspend';
                  }
                  if (columnIndex === 1) {
                    return inner.replace(/<[^>]*>/g, ''); 
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 1) { 
                    return inner.replace(/<[^>]*>/g, '');
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'copy',
            title: 'Instalaciones',
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
                    return inner.replace(/<[^>]*>/g, '');
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

  // Configuración CSRF para Laravel
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Eliminar registro
  $(document).on('click', '.delete-record', function () {
    var id_instalacion = $(this).data('id'),
        dtrModal = $('.dtr-bs-modal.show');

    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

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
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}instalaciones/${id_instalacion}`, 
          success: function () {
            dt_instalaciones_table.ajax.reload();

            Swal.fire({
              icon: 'success',
              title: '¡Eliminado!',
              text: '¡La Instalacion ha sido eliminada correctamente!',
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
              text: 'Hubo un problema al eliminar la Istalacion.',
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La Instalacion no ha sido eliminada',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  
    // Eliminar registro
    $(document).on('click', '.delete-record', function () {
      var id_instalacion = $(this).data('id'),
          dtrModal = $('.dtr-bs-modal.show');
  
      if (dtrModal.length) {
        dtrModal.modal('hide');
      }
  
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
          $.ajax({
            type: 'DELETE',
            url: `${baseUrl}instalaciones/${id_instalacion}`, 
            success: function () {
              dt_instalaciones_table.ajax.reload();
  
              Swal.fire({
                icon: 'success',
                title: '¡Eliminado!',
                text: '¡La Instalacion ha sido eliminada correctamente!',
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
                text: 'Hubo un problema al eliminar la Instalacion.',
              });
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelado',
            text: 'La Instalacion no ha sido eliminada',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    });
  

    //Agregar
    $('#fecha_emision').on('change', function() {
      var fechaInicial = new Date($(this).val());
      fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
      var year = fechaInicial.getFullYear();
      var month = ('0' + (fechaInicial.getMonth() + 1)).slice(-2);
      var day = ('0' + fechaInicial.getDate()).slice(-2);
      $('#fecha_vigencia').val(year + '-' + month + '-' + day).trigger('change');
    });
  
    $(document).on('change', '#tipo', function () {
      var tipo = $(this).val(); 
      
      var hiddenIdDocumento = $('#certificado-otros').find('input[name="id_documento[]"]');
      var hiddenNombreDocumento = $('#certificado-otros').find('input[name="nombre_documento[]"]');
      var fileCertificado = $('#certificado-otros').find('input[type="file"]');
      
      if (tipo.includes("Productora")) {
          hiddenIdDocumento.val('127');
          hiddenNombreDocumento.val('Certificado de instalaciones');
          fileCertificado.attr('id', 'file-127');
      } else if (tipo.includes("Envasadora")) {
          hiddenIdDocumento.val('128');
          hiddenNombreDocumento.val('Certificado de envasadora');
          fileCertificado.attr('id', 'file-128');
      } else if (tipo.includes("Comercializadora") || tipo.includes("Almacen y bodega") || tipo.includes("Area de maduracion")) {
          hiddenIdDocumento.val('129');
          hiddenNombreDocumento.val('Certificado de comercializadora');
          fileCertificado.attr('id', 'file-129');
      } else {
          hiddenIdDocumento.val('');
          hiddenNombreDocumento.val('');
          fileCertificado.removeAttr('id');
      }
  });
  
  $(document).ready(function () {
    const formAdd = document.getElementById('addNewInstalacionForm');
    const certificadoContainer = $('#certificado-otros');
    const fieldsAdded = new Set();

    const fv = FormValidation.formValidation(formAdd, {
        fields: {
            'id_empresa': {
                validators: {
                    notEmpty: {
                        message: 'El ID de la empresa es obligatorio.'
                    }
                }
            },
            'tipo[]': {
                validators: {
                    notEmpty: {
                        message: 'Selecciona un tipo de instalación.'
                    }
                }
            },
            'estado': {
                validators: {
                    notEmpty: {
                        message: 'Selecciona el estado.'
                    }
                }
            },
            'direccion_completa': {
                validators: {
                    notEmpty: {
                        message: 'La dirección es obligatoria.'
                    }
                }
            },
            'certificacion': {
              validators: {
                  notEmpty: {
                      message: 'La dirección es obligatoria.'
                  }
              }
          },
          'responsable': { 
            validators: {
                notEmpty: {
                    message: 'El nombre del responsable de la instalación es obligatorio.'
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
    });

    function updateCertificadoValidation() {
        const tipo = $('#certificacion').val();

        if (tipo === 'otro_organismo') {
            certificadoContainer.removeClass('d-none');

            if (!fieldsAdded.has('url[]')) {
                fv.addField('url[]', {
                    validators: {
                        notEmpty: {
                            message: 'Debes subir un archivo de certificado.'
                        },
                        file: {
                            extension: 'pdf,jpg,jpeg,png',
                            type: 'application/pdf,image/jpeg,image/png',
                            maxSize: 2097152, 
                            message: 'El archivo debe ser un PDF o una imagen (jpg, png) y no debe superar los 2 MB.'
                        },
                        enabled: function (field) {
                            return $(field).closest('.form-group').css('display') !== 'none';
                        }
                    }
                });
                fieldsAdded.add('url[]');
            }

            if (!fieldsAdded.has('folio')) {
                fv.addField('folio', {
                    validators: {
                        notEmpty: {
                            message: 'El folio o número del certificado es obligatorio.'
                        },
                        enabled: function (field) {
                            return $(field).closest('.form-group').css('display') !== 'none';
                        }
                    }
                });
                fieldsAdded.add('folio');
            }

            if (!fieldsAdded.has('id_organismo')) {
                fv.addField('id_organismo', {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona un organismo de certificación.'
                        },
                        enabled: function (field) {
                            return $(field).closest('.form-group').css('display') !== 'none';
                        }
                    }
                });
                fieldsAdded.add('id_organismo');
            }

            if (!fieldsAdded.has('fecha_emision')) {
                fv.addField('fecha_emision', {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de emisión es obligatoria.'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'La fecha de emisión no es válida.'
                        },
                        enabled: function (field) {
                            return $(field).closest('.form-group').css('display') !== 'none';
                        }
                    }
                });
                fieldsAdded.add('fecha_emision');
            }

            if (!fieldsAdded.has('fecha_vigencia')) {
                fv.addField('fecha_vigencia', {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de vigencia es obligatoria.'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'La fecha de vigencia no es válida.'
                        },
                        enabled: function (field) {
                            return $(field).closest('.form-group').css('display') !== 'none';
                        }
                    }
                });
                fieldsAdded.add('fecha_vigencia');
            }
        } else {
            certificadoContainer.addClass('d-none'); 

            if (fieldsAdded.has('url[]')) {
                fv.removeField('url[]');
                fieldsAdded.delete('url[]');
                $('input[name="url[]"]').removeClass('is-invalid');
            }
            if (fieldsAdded.has('folio')) {
                fv.removeField('folio');
                fieldsAdded.delete('folio');
                $('input[name="folio"]').removeClass('is-invalid');
            }
            if (fieldsAdded.has('id_organismo')) {
                fv.removeField('id_organismo');
                fieldsAdded.delete('id_organismo');
                $('select[name="id_organismo"]').removeClass('is-invalid');
            }
            if (fieldsAdded.has('fecha_emision')) {
                fv.removeField('fecha_emision');
                fieldsAdded.delete('fecha_emision');
                $('input[name="fecha_emision"]').removeClass('is-invalid');
            }
            if (fieldsAdded.has('fecha_vigencia')) {
                fv.removeField('fecha_vigencia');
                fieldsAdded.delete('fecha_vigencia');
                $('input[name="fecha_vigencia"]').removeClass('is-invalid');
            }
        }
    }

    // Revalidar los select2 cuando cambian
    $('#id_empresa, #estado, #fecha_emision').on('change', function () {
        fv.revalidateField($(this).attr('name'));
        if ($(this).val() === '') {
            $(this).removeClass('is-invalid'); 
        }
    });

    $('#tipo').on('change', function () {
      fv.revalidateField('tipo[]');
    });

    $('#certificacion').on('change', function () {
        updateCertificadoValidation();
    });

    function updateDatepickerValidation() {
        $('#fecha_vigencia').on('change', function () {
            const fechaVigencia = $(this).val();
            if (fechaVigencia) {
                const fecha = moment(fechaVigencia, 'YYYY-MM-DD');
                const fechaVencimiento = fecha.add(1, 'years').format('YYYY-MM-DD');
                $('#fecha_vencimiento').val(fechaVencimiento);

                fv.revalidateField('fecha_vigencia');
                fv.revalidateField('fecha_vencimiento');
            }
        });

        $('#fecha_vencimiento').on('change', function () {
            fv.revalidateField('fecha_vencimiento');
        });
    }

    updateCertificadoValidation();
    updateDatepickerValidation();

    // Enviar el formulario si es válido
    fv.on('core.form.valid', function () {
        var formData = new FormData(formAdd); 
        $.ajax({
            url: '/instalaciones',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#btnRegistrarInstalacion').prop('disabled', true).text('Registrando...');
            },
            success: function (response) {
              dt_user_table.DataTable().ajax.reload();
          
              $('#btnRegistrarInstalacion').prop('disabled', false).text('Registrar');
              $('#modalAddInstalacion').modal('hide');
          
              // Desactivar validaciones temporalmente
              fv.disableValidator('id_empresa');
              fv.disableValidator('estado');
              fv.disableValidator('tipo[]');
              $('#addNewInstalacionForm')[0].reset();
          
              // Limpiar selects y quitar clases de error
              $('#id_empresa').val('').trigger('change').removeClass('is-invalid');
              $('#estado').val('').trigger('change').removeClass('is-invalid');
              $('#tipo').val([]).trigger('change').removeClass('is-invalid'); 
              certificadoContainer.addClass('d-none');
          
              // Reactivar validaciones después de reiniciar
              setTimeout(() => {
                  fv.enableValidator('id_empresa');
                  fv.enableValidator('estado');
                  fv.enableValidator('tipo[]');
              }, 0);
          
              // Mostrar mensaje de éxito
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
                  text: 'Error al registrar el certificado',
                  customClass: {
                      confirmButton: 'btn btn-danger'
                  }
              });
          }
        });
    });
});

  //Editar
  $('#edit_fecha_emision').on('change', function() {
    var fechaInicial = new Date($(this).val());
    fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
    var year = fechaInicial.getFullYear();
    var month = ('0' + (fechaInicial.getMonth() + 1)).slice(-2);
    var day = ('0' + fechaInicial.getDate()).slice(-2);
    $('#edit_fecha_vigencia').val(year + '-' + month + '-' + day).trigger('change');
  });

  $(document).ready(function () {
    let instalacionData = {};

    function toggleCamposCertificacion(certificacion) {
        if (certificacion === 'otro_organismo') {
            $('#edit_certificado_otros').removeClass('d-none');           
            $('#edit_folio').val(instalacionData.folio || '');
            $('#edit_id_organismo').val(instalacionData.id_organismo || '').trigger('change');
            $('#edit_fecha_emision').val(instalacionData.fecha_emision || '');
            $('#edit_fecha_vigencia').val(instalacionData.fecha_vigencia || '');
            
            if (instalacionData.archivoUrl) {
                $('#archivo_url_display').html(`
                    <p>Archivo existente: <a href="../files/${instalacionData.numeroCliente}/${instalacionData.archivoUrl}" target="_blank">${instalacionData.archivoUrl}</a></p>
                `);
            } else {
                $('#archivo_url_display').html('No hay archivo disponible.');
            }
        } else {
            $('#edit_certificado_otros').addClass('d-none');
            $('#edit_folio').val(null);
            $('#edit_id_organismo').val(null).trigger('change');
            $('#edit_fecha_emision').val(null);
            $('#edit_fecha_vigencia').val(null);
            $('#archivo_url_display').html('No hay archivo disponible.');
        }
    }
    $('#edit_certificacion').on('change', function () {
        toggleCamposCertificacion($(this).val());
    });
    $(document).on('click', '.edit-record', function () {
      var id_instalacion = $(this).data('id');
      var url = baseUrl + 'domicilios/edit/' + id_instalacion;
  
      $.get(url, function (data) {
          if (data.success) {
              var instalacion = data.instalacion;
              var tipoParsed = JSON.parse(instalacion.tipo);
  
              instalacionData = {
                  folio: instalacion.folio || '',
                  id_organismo: instalacion.id_organismo || '',
                  fecha_emision: instalacion.fecha_emision !== 'N/A' ? instalacion.fecha_emision : '',
                  fecha_vigencia: instalacion.fecha_vigencia !== 'N/A' ? instalacion.fecha_vigencia : '',
                  archivoUrl: data.archivo_url || '',
                  numeroCliente: data.numeroCliente || '',
                  edit_nombre_documento: data.edit_nombre_documento || [], 
                  edit_id_documento: data.edit_id_documento || []
              };
  
              $('#edit_id_empresa').val(instalacion.id_empresa).trigger('change');
              $('#edit_tipo').val(tipoParsed).trigger('change');
              $('#edit_estado').val(instalacion.estado).trigger('change');
              $('#edit_direccion').val(instalacion.direccion_completa);
              $('#edit_responsable').val(instalacion.responsable || '').trigger('change');
              $('#edit_certificacion').val(instalacion.certificacion).trigger('change');
              toggleCamposCertificacion(instalacion.certificacion);
  
              $('#edit_nombre_documento').val(instalacion.edit_nombre_documento).trigger('change');
              $('#edit_id_documento').val(instalacion.edit_id_documento).trigger('change');
  
              $('#editInstalacionForm').data('id', id_instalacion);
              $('#modalEditInstalacion').modal('show');
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'No se pudo cargar los datos de la instalación',
                  customClass: { confirmButton: 'btn btn-primary' }
              });
          }
      }).fail(function (jqXHR, textStatus, errorThrown) {
          console.error('Error en la solicitud:', textStatus, errorThrown);
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error en la solicitud. Inténtalo de nuevo.',
              customClass: { confirmButton: 'btn btn-primary' }
          });
      });
  });
  
  $(document).on('change', '#edit_tipo', function () {
    var tipo = $(this).val();
    var hiddenIdDocumento = $('#edit_certificado_otros').find('input[name="edit_id_documento[]"]');
    var hiddenNombreDocumento = $('#edit_certificado_otros').find('input[name="edit_nombre_documento[]"]');
    var fileCertificado = $('#edit_certificado_otros').find('input[type="file"]');

    if (tipo.includes("Productora")) {
        hiddenIdDocumento.val('127');
        hiddenNombreDocumento.val('Certificado de instalaciones');
        fileCertificado.attr('id', 'file-127');
    } else if (tipo.includes("Envasadora")) {
        hiddenIdDocumento.val('128');
        hiddenNombreDocumento.val('Certificado de envasadora');
        fileCertificado.attr('id', 'file-128');
    } else if (tipo.includes("Comercializadora") || tipo.includes("Almacén y bodega") || tipo.includes("Área de maduración")) {
        hiddenIdDocumento.val('129');
        hiddenNombreDocumento.val('Certificado de comercializadora');
        fileCertificado.attr('id', 'file-129');
    } else {
        hiddenIdDocumento.val('');
        hiddenNombreDocumento.val('');
        fileCertificado.removeAttr('id');
    }
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