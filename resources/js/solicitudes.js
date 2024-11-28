$(function () {
  // Definir la URL base
  var baseUrl = window.location.origin + '/';

  // Inicializar DataTable
  var dt_instalaciones_table = $('.datatables-solicitudes').DataTable({

    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + 'solicitudes-list',
      type: 'GET',
      dataSrc: function (json) {
        /*  console.log(json); */ // Ver los datos en la consola
        return json.data;
      },
      error: function (xhr, error, thrown) {
        console.error('Error en la solicitud Ajax:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un problema al cargar los datos.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    },
    columns: [
      { data: '' },
      { data: '' },
      { data: 'folio' },
      { data: 'num_servicio' },
      { data: 'razon_social' },
      { data: 'fecha_solicitud' },
      { data: 'tipo' },
      { data: 'direccion_completa' },
      { data: 'fecha_visita' },
      { data: 'inspector' },
      { data: 'fecha_servicio' },
      { data: '' },
      { data: 'estatus' },
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
        orderable: true,
        targets: 1,
        render: function (data, type, full, meta) {
          return `<span>${full.fake_id}</span>`;
        }
      },
      {
        // User full name
        targets: 9,
        responsivePriority: 4,
        render: function (data, type, full, meta) {
          var $name = full['inspector'];
          var foto_inspector = full['foto_inspector'];

          // For Avatar badge

          var $output;
          if (foto_inspector != '') {
            $output = '<div class="avatar-wrapper"><div class="avatar avatar-sm me-3"> <div class="avatar "><img src="storage/' + foto_inspector + '" alt class="rounded-circle"></div></div></div>';
          } else {
            $output = '';
          }

          // Creates full output for row
          var $row_output =
            '<div class="d-flex justify-content-start align-items-center user-name">' +
            $output +
            '<div class="d-flex flex-column">' +
            '<a href="#" class="text-truncate text-heading"><span class="fw-medium">' +
            $name +
            '</span></a>' +
            '</div>' +
            '</div>';
          return $row_output;
        }
      },
      {

        targets: 11,
        className: 'text-center',
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {


          return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-id="${full['id_solicitud']}" data-registro="${full['id_solicitud']}"></i>`;

        }
      },
      {
        // Acciones
        targets: -1,
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

            `<a data-id="${full['id']}" data-bs-toggle="modal" onclick="abrirModalTrazabilidad(${full['id_solicitud']},'${full['tipo']}','${full['razon_social']}')" href="javascript:;" class="cursor-pointer dropdown-item validar-solicitud2">` +
            '<i class="text-warning ri-user-search-fill"></i>Trazabilidad</a>' +

            `<a data-id="${full['id']}" data-bs-toggle="modal" onclick="abrirModalValidarSolicitud(${full['id_solicitud']},'${full['tipo']}','${full['razon_social']}')" href="javascript:;" class="dropdown-item validar-solicitud">` +
            '<i class="text-success ri-search-eye-line"></i>Validar solicitud</a>' +

            `<a
              data-id="${full['id']}"
              data-id-solicitud="${full['id_solicitud']}"
              data-tipo="${full['tipo']}"
              data-id-tipo="${full['id_tipo']}"
              data-razon-social="${full['razon_social']}"
              class="cursor-pointer dropdown-item edit-record-tipo">` +
            '<i class="text-warning ri-edit-fill"></i>Editar</a>' +

            `<a data-id="${full['id']}" data-bs-toggle="modal" onclick="abrirModal(${full['id_solicitud']},'${full['tipo']}','${full['razon_social']}')" href="javascript:;" class="dropdown-item validar-solicitud">` +
            '<i class="text-info ri-folder-3-fill"></i>Expediente del servicio</a>' +

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
            title: 'Solicitudes',
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
            title: 'Solicitudes',
            text: '<i class="ri-file-text-line me-1"></i>CSV',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 8 || columnIndex === 11) {
                    return 'ViewSuspend';
                  }
                  if (columnIndex === 1) { // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'excel',
            title: 'Solicitudes',
            text: '<i class="ri-file-excel-line me-1"></i>Excel',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 8 || columnIndex === 11) {
                    return 'ViewSuspend';
                  }
                  if (columnIndex === 1) { // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'pdf',
            title: 'Solicitudes',
            text: '<i class="ri-file-pdf-line me-1"></i>PDF',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 1) { // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'copy',
            title: 'Solicitudes',
            text: '<i class="ri-file-copy-line me-1"></i>Copiar',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 8 || columnIndex === 11) {
                    return 'ViewSuspend';
                  }
                  if (columnIndex === 1) { // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          }
        ]
      },
      {
        text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nueva solicitud</span>',
        className: 'add-new btn btn-primary waves-effect waves-light',
        attr: {
          /*'data-bs-toggle': 'offcanvas',
          'data-bs-target': '#offcanvasAddUser'*/
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#verSolicitudes'
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

  var dt_user_table = $('.datatables-solicitudes'),
    select2Elements = $('.select2')

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


  //Date picker
  $(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es' // Configura el idioma a español
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
            dt_instalaciones_table.ajax.reload();

            // Mostrar mensaje de éxito
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


  $(document).ready(function () {
    $(document).on('click', '.edit-record-tipo', function () {
      // Obtenemos los datos del botón
      const id_solicitud = $(this).data('id-solicitud');
      const id_tipo = parseInt($(this).data('id-tipo')); // Convertir a número

      // Cierra cualquier modal u offcanvas visible
      $('.modal').modal('hide');

      // Variables para el modal
      let modal = null;

      // Validamos el tipo y configuramos el modal correspondiente
      if (id_tipo === 2) {
        modal = $('#editVigilanciaProduccion');
      } else if (id_tipo === 10) {
        modal = $('#editClienteModalTipo10');
      } else if (id_tipo === 14) {
        modal = $('#editSolicitudDictamen');
      } else {
        console.error('Tipo no válido:', id_tipo);
        return; // Salimos si el tipo no es válido
      }

      // Hacemos la solicitud para obtener los datos
      $.ajax({
        url: `/datos-solicitud/${id_solicitud}`, // Ruta única
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            // Rellenar campos según el tipo de modal
            const datos = response.data;

            if (id_tipo === 2) {
              modal.find('#edit_id_solicitud_vig').val(id_solicitud);
              modal.find('#edit_id_empresa_vig').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita_vig').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_vig').data('selected', response.data.id_instalacion);

              // Acceder al campo `punto_reunion` desde `caracteristicas`
              if (response.caracteristicas && response.caracteristicas.id_lote_granel) {
                modal.find('#edit_id_lote_granel_vig').val(response.caracteristicas.id_lote_granel);
              } else {
                modal.find('#edit_id_lote_granel_vig').val(''); // Si no existe, deja vacío
              }
              if (response.caracteristicas && response.caracteristicas.id_categoria) {
                modal.find('#edit_id_categoria_vig').val(response.caracteristicas.id_categoria);
              } else {
                modal.find('#edit_id_categoria_vig').val(''); // Si no existe, deja vacío
              } if (response.caracteristicas && response.caracteristicas.id_clase) {
                modal.find('#edit_id_clase_vig').val(response.caracteristicas.id_clase);
              } else {
                modal.find('#edit_id_clase_vig').val(''); // Si no existe, deja vacío
              } if (response.caracteristicas && response.caracteristicas.id_tipo) {
                modal.find('#edit_id_tipo_vig').val(response.caracteristicas.id_tipo);
              } else {
                modal.find('#edit_id_tipo_vig').val(''); // Si no existe, deja vacío
              }
              if (response.caracteristicas && response.caracteristicas.analisis) {
                modal.find('#edit_analisis_vig').val(response.caracteristicas.analisis);
              } else {
                modal.find('#edit_analisis_vig').val(''); // Si no existe, deja vacío
              }
              if (response.caracteristicas && response.caracteristicas.volumen) {
                modal.find('#edit_volumen_vig').val(response.caracteristicas.volumen);
              } else {
                modal.find('#edit_volumen_vig').val(''); // Si no existe, deja vacío
              }
              if (response.caracteristicas && response.caracteristicas.fecha_corte) {
                modal.find('#edit_fecha_corte_vig').val(response.caracteristicas.fecha_corte);
              } else {
                modal.find('#edit_fecha_corte_vig').val(''); // Si no existe, deja vacío
              }
              if (response.caracteristicas && response.caracteristicas.kg_maguey) {
                modal.find('#edit_kg_maguey_vig').val(response.caracteristicas.kg_maguey);
              } else {
                modal.find('#edit_kg_maguey_vig').val(''); // Si no existe, deja vacío
              }
              if (response.caracteristicas && response.caracteristicas.cant_pinas) {
                modal.find('#edit_cant_pinas_vig').val(response.caracteristicas.cant_pinas);
              } else {
                modal.find('#edit_cant_pinas_vig').val(''); // Si no existe, deja vacío
              }
              if (response.caracteristicas && response.caracteristicas.art) {
                modal.find('#edit_art_vig').val(response.caracteristicas.art);
              } else {
                modal.find('#edit_art_vig').val(''); // Si no existe, deja vacío
              }
              if (response.caracteristicas && response.caracteristicas.etapa) {
                modal.find('#edit_etapa_vig').val(response.caracteristicas.etapa);
              } else {
                modal.find('#edit_etapa_vig').val(''); // Si no existe, deja vacío
              }
              if (response.caracteristicas && response.caracteristicas.folio) {
                modal.find('#edit_folio_vig').val(response.caracteristicas.folio);
              } else {
                modal.find('#edit_folio_vig').val(''); // Si no existe, deja vacío
              }
              if (response.caracteristicas && response.caracteristicas.nombre_predio) {
                modal.find('#edit_nombre_predio_vig').val(response.caracteristicas.nombre_predio);
              } else {
                modal.find('#edit_nombre_predio_vig').val(''); // Si no existe, deja vacío
              }
              modal.find('#edit_info_adicional_vig').val(response.data.info_adicional);
              // Otros campos específicos para tipo 10
            } else if (id_tipo === 10) {
              modal.find('#id_solicitud_geo').val(id_solicitud);
              modal.find('#edit_id_empresa_geo').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita_geo').val(response.data.fecha_visita);
              modal.find('#edit_id_predio_geo').data('selected', response.data.id_predio);
              // Acceder al campo `punto_reunion` desde `caracteristicas`
              if (response.caracteristicas && response.caracteristicas.punto_reunion) {
                modal.find('#edit_punto_reunion_geo').val(response.caracteristicas.punto_reunion);
              } else {
                modal.find('#edit_punto_reunion_geo').val(''); // Si no existe, deja vacío
              }
              modal.find('#edit_info_adicional_geo').val(response.data.info_adicional);
              // Otros campos específicos para tipo 10
            } else if (id_tipo === 14) {
              modal.find('#edit_id_solicitud').val(id_solicitud);
              modal.find('#edit_id_empresa').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion').val(response.data.id_instalacion).trigger('change');
              modal.find('#edit_info_adicional').val(response.data.info_adicional);


              modal.find('#instalacion_id').val(response.data.id_instalacion);



              // Otros campos específicos para tipo 14
            }
            // Muestra el modal después de rellenar los datos
            modal.modal('show');
          } else {
            console.error('Error al cargar los datos:', response.message);
          }
        },
        error: function (xhr, status, error) {
          console.error('Error en la solicitud:', error);
        },
      });
    });
  });

  /* formulario para enviar los datos y actualizar */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de actualización
    const formUpdate = document.getElementById('editFormTipo10');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        'id_empresa': {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        'fecha_visita': {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha y hora para la inspección.'
            }
          }
        },
        'id_predio': {
          validators: {
            notEmpty: {
              message: 'Selecciona un predio para la inspección.'
            }
          }
        },
        'punto_reunion': {
          validators: {
            notEmpty: {
              message: 'Introduce la dirección para el punto de reunión.'
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
    }).on('core.form.valid', function (e) {
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#id_solicitud_geo').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editClienteModalTipo10').modal('hide'); // Oculta el modal
          $('#editFormTipo10')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(); // Recarga la tabla
          console.log(response);

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
            text: 'Error al actualizar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  /*funcion para solicitud de dictaminacion  */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de dictaminación
    const formDictaminacion = document.getElementById('addEditSolicitud');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
      fields: {
        'id_empresa': {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        'fecha_visita': {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
        'id_instalacion': {
          validators: {
            notEmpty: {
              message: 'Selecciona una instalación.'
            }
          }
        },
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
    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(formDictaminacion);

      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editSolicitudDictamen').modal('hide');
          $('#addEditSolicitud')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

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
            text: 'Error al actualizar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  /*  */
  /* formulario para enviar los datos y actualizar */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de actualización
    const formUpdate = document.getElementById('editVigilanciaProduccionForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        'id_empresa': {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        'fecha_visita': {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha y hora para la inspección.'
            }
          }
        },
        'id_predio': {
          validators: {
            notEmpty: {
              message: 'Selecciona un predio para la inspección.'
            }
          }
        },
        'punto_reunion': {
          validators: {
            notEmpty: {
              message: 'Introduce la dirección para el punto de reunión.'
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
    }).on('core.form.valid', function (e) {
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_vig').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editVigilanciaProduccion').modal('hide'); // Oculta el modal
          $('#editVigilanciaProduccionForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(); // Recarga la tabla
          console.log(response);

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
            text: 'Error al actualizar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });



  ///
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de muestreo de agave
    const form3 = document.getElementById('addRegistrarSolicitudMuestreoAgave');
    const fv3 = FormValidation.formValidation(form3, {
      fields: {
        'id_empresa': {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        'fecha_visita': {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
        'punto_reunion': {
          validators: {
            notEmpty: {
              message: 'Introduce la dirección para el punto de reunión.'
            }
          }
        },
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

    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(form3);

      $.ajax({
        url: '/registrar-solicitud-muestreo-agave',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudMuestreoAgave').modal('hide');
          $('#addRegistrarSolicitudMuestreoAgave')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    // Inicializar FormValidation para la solicitud de dictaminación de instalaciones
    const form = document.getElementById('addRegistrarSolicitud');
    const fv = FormValidation.formValidation(form, {
      fields: {
        'id_empresa': {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        'fecha_visita': {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
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

    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(form);

      $.ajax({
        url: '/solicitudes-list',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudDictamen').modal('hide');
          $('#addRegistrarSolicitud')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud registrada correctamente',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    // Inicializar FormValidation para la solicitud de georeferenciacion
    const form2 = document.getElementById('addRegistrarSolicitudGeoreferenciacion');
    const fv2 = FormValidation.formValidation(form2, {
      fields: {
        'id_empresa': {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        'fecha_visita': {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
        'punto_reunion': {
          validators: {
            notEmpty: {
              message: 'Introduce la dirección para el punto de reunión.'
            }
          }
        },
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

    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(form2);

      $.ajax({
        url: '/registrar-solicitud-georeferenciacion',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudGeoreferenciacion').modal('hide');
          $('#addRegistrarSolicitudGeoreferenciacion')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud registrada correctamente',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

  });

  //new new
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('editInstalacionForm');
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
    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(form);

      $.ajax({
        url: baseUrl + 'instalaciones/' + $('#editInstalacionForm').data('id'),
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
          $('#editInstalacionForm')[0].reset();
          $('.select2').val(null).trigger('change');

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
            text: 'Error al actualizar la instalación',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    // Mostrar u ocultar campos adicionales según el tipo de certificación
    $('#edit_certificacion').on('change', function () {
      if ($(this).val() === 'otro_organismo') {
        $('#edit_certificado_otros').removeClass('d-none');

        // Agregar la validación a los campos adicionales
        fv.addField('url[]', {
          validators: {
            notEmpty: {
              message: 'Debes subir un archivo de certificado.'
            },
            file: {
              extension: 'pdf,jpg,jpeg,png',
              type: 'application/pdf,image/jpeg,image/png',
              maxSize: 2097152, // 2 MB en bytes
              message: 'El archivo debe ser un PDF o una imagen (jpg, png) y no debe superar los 2 MB.'
            }
          }
        });

        fv.addField('folio', {
          validators: {
            notEmpty: {
              message: 'El folio o número del certificado es obligatorio.'
            }
          }
        });

        fv.addField('id_organismo', {
          validators: {
            notEmpty: {
              message: 'Selecciona un organismo de certificación.'
            }
          }
        });

        fv.addField('fecha_emision', {
          validators: {
            notEmpty: {
              message: 'La fecha de emisión es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'La fecha de emisión no es válida.'
            }
          }
        });

        fv.addField('fecha_vigencia', {
          validators: {
            notEmpty: {
              message: 'La fecha de vigencia es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'La fecha de vigencia no es válida.'
            }
          }
        });

      } else {
        $('#edit_certificado_otros').addClass('d-none');

        // Quitar la validación de los campos adicionales
        fv.removeField('url[]');
        fv.removeField('folio');
        fv.removeField('id_organismo');
        fv.removeField('fecha_emision');
        fv.removeField('fecha_vigencia');
      }
    });
  });

  //new
  $(document).on('click', '.edit-record', function () {
    var id_instalacion = $(this).data('id');
    var url = baseUrl + 'domicilios/edit/' + id_instalacion;

    // Solicitud para obtener los datos de la instalación
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
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error en la solicitud:', textStatus, errorThrown);

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

  // Limpiar los campos del formulario cuando el modal se oculta
  $('#modalEditInstalacion').on('hidden.bs.modal', function () {
    $('#edit_certificado_otros').addClass('d-none');
    $('#archivo_url_display').html('No hay archivo disponible.');

    // Limpiar campos individuales
    $('#edit_id_empresa').val('').trigger('change');
    $('#edit_tipo').val('').trigger('change');
    $('#edit_estado').val('').trigger('change');
    $('#edit_direccion').val('');
    $('#edit_certificacion').val('oc_cidam').trigger('change');
    $('#edit_folio').val('');
    $('#edit_id_organismo').val('').trigger('change');
    $('#edit_fecha_emision').val('');
    $('#edit_fecha_vigencia').val('');
  });


  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Validación del formulario Vigilancia en produccion
    const addVigilanciaProduccionForm = document.getElementById('addVigilanciaProduccionForm');
    const fv5 = FormValidation.formValidation(addVigilanciaProduccionForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de visita.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_granel: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote agranel.'
            }
          }
        },
        id_categoria: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una categoría.'
            }
          }
        },
        id_clase: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una clase.'
            }
          }
        },
        id_tipo: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo de maguey.'
            }
          }
        },
        analisis: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el análisis fisicoquímico.'
            }
          }
        },
        art: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el porcentaje de alcohol (% Alc. Vol.).'
            },
            between: {
              min: 1,
              max: Infinity,
              message: 'El número debe ser superior a 0 y sin negativos'
            },
            regexp: {
              regexp: /^(?!0)\d+$/,
              message: 'El número no debe comenzar con 0'
            }
          }
        },
        fecha_corte: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de visita.'
            }
          }
        },
        kg_maguey: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la cantidad de maguey en kg.'
            }
          }
        },
        cant_pinas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la cantidad de piñas.'
            }
          }
        },
        art: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número art'
            },
            between: {
              min: 1,
              max: Infinity,
              message: 'El número debe ser superior a 0 y sin negativos'
            },
            regexp: {
              regexp: /^(?!0)\d+$/,
              message: 'El número no debe comenzar con 0'
            }
          }
        },
        etapa: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la etapa del proceso.'
            }
          }
        },
        folio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de guía de traslado.'
            }
          }
        },
        nombre_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el nombre del predio.'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: function (field, ele) {
            return '.mb-4, .mb-5, .mb-6';
          }

        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      var formData = new FormData(addVigilanciaProduccionForm);

      $.ajax({
        url: '/hologramas/storeVigilanciaProduccion', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {

          $('#addVigilanciaProduccion').modal('hide');
          $('#addVigilanciaProduccionForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud vigilancia registrado exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function () {
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar la vigilancia en producción.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
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

  $(document).ready(function () {
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


  $(document).on('click', '.pdf2', function () {
    var url = $(this).data('url');
    var registro = $(this).data('registro');
    var id_solicitud = $(this).data('id');
    var iframe = $('#pdfViewer');
    iframe.attr('src', 'solicitud_de_servicio/' + id_solicitud);

    $("#titulo_modal").text("Solicitud de servicios NOM-070-SCFI-2016");
    $("#subtitulo_modal").text(registro);
  });

  var openedFromFirstModal = false;



  $('#abrirModalInstalaciones').on('click', function () {
    var clienteSeleccionado = $('#id_empresa_solicitudes').val();

    openedFromFirstModal = true;
    $('#addSolicitudDictamen').modal('hide');
    $('#id_empresa option[value="' + clienteSeleccionado + '"]').prop('selected', true); // Marcar la opción seleccionada
    $('#id_empresa').trigger('change');
    $('#modalAddInstalacion').modal('show');

  });

  // Al cerrar el segundo modal
  $('#modalAddInstalacion').on('hidden.bs.modal', function () {
    if (openedFromFirstModal) {
      openedFromFirstModal = false;
      $('#addSolicitudDictamen').modal('show');
    }
  });

  // Al registrar el segundo modal
  $('#btnRegistrarInstalacion').on('click', function () {
    var clienteSeleccionado = $('#id_empresa').val();
    if (openedFromFirstModal) {
      openedFromFirstModal = false;
      // $('#modalAddInstalacion').modal('hide');

      $('#id_empresa_solicitudes option[value="' + clienteSeleccionado + '"]').prop('selected', true); // Marcar la opción seleccionada
      $('#id_empresa_solicitudes').trigger('change');
      obtenerInstalacion();
      alert(clienteSeleccionado);

      $('#addSolicitudDictamen').modal('show');


    }

  });

  //Vigilancia boton instalaciones
  $(document).ready(function () {
    let openedFromFirstModal = false;

    $('#modalVigilancia').on('click', function () {
      var clienteSeleccionado = $('.id_empresa').val();
      // Verificar si hay una empresa seleccionada
      if (!clienteSeleccionado) {
        Swal.fire({
          icon: 'warning',
          title: 'Espere!',
          text: 'Por favor, selecciona un cliente primero.',
          customClass: {
            confirmButton: 'btn btn-danger'
          },
          buttonsStyling: false
        });
        return;
      }
      $('#addVigilanciaProduccion').modal('hide');
      // Marcar que el nuevo modal fue abierto desde el anterior
      openedFromFirstModal = true;
      // Preseleccionar la empresa en el modal de nueva instalación
      $('#modalAddInstalacion #id_empresa').val(clienteSeleccionado).trigger('change');
      $('#modalAddInstalacion').modal('show');
    });
    $('#modalAddInstalacion').on('hidden.bs.modal', function () {
      if (openedFromFirstModal) {
        $('#addVigilanciaProduccion').modal('show');
        openedFromFirstModal = false;
      }
    });
  });

  /* seccion para exportacion */
  $(document).ready(function () {
    // Obtener el select y las secciones
    var $tipoSolicitud = $('#tipo_solicitud');
    var $pedidosEx = $('#pedidos_Ex');
    var $etiquetasEx = $('#etiquetas_Ex');

    // Manejar el evento de cambio
    $tipoSolicitud.on('change', function () {
      var valorSeleccionado = $tipoSolicitud.val();
      if (valorSeleccionado === '2') {
        // Ocultar secciones
        $pedidosEx.hide();
        $etiquetasEx.hide();
      } else {
        // Mostrar secciones
        $pedidosEx.show();
        $etiquetasEx.show();
      }
    });
  });

  $(document).ready(function () {
    // Contador para asignar IDs únicos
    let sectionCount = 1;

    // Manejar el evento de clic en el botón "Agregar Tabla"
    $('#add-characteristics').click(function () {
        sectionCount++;
        // Clonar la sección original
        let newSection = $('#caracteristicas_Ex').clone();
        // Cambiar el ID de la nueva sección
        newSection.attr('id', 'caracteristicas_Ex_' + sectionCount);

        // Limpiar los valores de los inputs en la nueva sección
        newSection.find('input').val('');
        newSection.find('select').prop('selectedIndex', 0);

        // Asignar un índice único a los nombres de los inputs y selects
        newSection.find('input, select').each(function() {
            let name = $(this).attr('name');
            if (name) {
                // Cambiar el nombre para incluir el índice
                $(this).attr('name', name.replace(/\[\]/, '[' + (sectionCount - 1) + ']'));
            }
        });

        // Agregar la nueva sección al contenedor
        newSection.appendTo('#sections-container');
    });

    // Manejar el evento de clic en el botón "Eliminar tabla"
    $('#delete-characteristics').click(function () {
        // Verificar si hay más de una sección
        if (sectionCount > 1) {
            $('#caracteristicas_Ex_' + sectionCount).remove();
            sectionCount--;
        } else {
            // Usar SweetAlert para mostrar el mensaje
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'No se puede eliminar la sección original.',
                customClass: {
                  confirmButton: 'btn btn-warning'
              }
            });
        }
    });
});

});


