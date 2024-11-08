'use strict';
$(function () {

  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#addMarca');

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
        { data: '' },
        { data: 'id_marca' },
        { data: 'folio' },
        { data: 'marca' },
        { data: 'razon_social' },
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
              `<a data-id="${full['id_marca']}" data-bs-toggle="modal" data-bs-target="#editMarca" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar marca</a>` +
              `<a data-id="${full['id_marca']}" data-bs-toggle="modal" data-bs-target="#etiquetas" href="javascript:;" class="dropdown-item edit-etiquetas"><i class="ri-price-tag-2-line ri-20px text-success"></i> Subir/Ver etiquetas</a>` +
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
      lengthMenu: [10, 20, 50, 70, 100],
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

  // Inicializacion Elementos
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

  // Inicializacion DatePicker
  $(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es'
    });
  });

  // Registrar Aprobacion
  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    const addNewMarca = document.getElementById('addNewMarca');
    const fv = FormValidation.formValidation(addNewMarca, {
      fields: {
        cliente: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el cliente'
            }
          }
        },
        id_norma: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una norma'
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
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function (e) {
      var formData = new FormData(addNewMarca);
      $.ajax({
        url: '/catalago-list',
        type: 'POST',
        data: formData,
        processData: false, // Evita la conversión automática de datos a cadena
        contentType: false, // Evita que se establezca el tipo de contenido
        success: function (response) {
          // Reinicializar el select2 para cliente e id_norma
          $('#cliente').val(null).trigger('change'); // Limpiar el select2 de cliente
          $('#id_norma').val(null).trigger('change'); // Limpiar el select2 de id_norma

          // Ocultar el modal después de enviar el formulario
          $('#addMarca').modal('hide');

          // Recargar la tabla de DataTables
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

    // Revalidaciones
    $('#cliente').on('change', function () {
      if ($(this).val()) {
        fv.revalidateField($(this).attr('name'));
      }
    });
    $('#id_norma').on('change', function () {
      if ($(this).val()) {
        fv.revalidateField($(this).attr('name'));
      }
    });

    $('#marca').on('change', function() {
      fv.revalidateField($(this).attr('name'));
  });
  });

  // Limpiar campos al cerrar el modal
  $('#addMarca').on('hidden.bs.modal', function () {
    $('#cliente, #id_norma, #marca').val('');
    $('#marca').prop('selected', true);
  });

  initializeSelect2(select2Elements);

  // Eliminar Registro Marca
  $(document).on('click', '.delete-record', function () {
    var user_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }
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
          url: `${baseUrl}catalago-list/${user_id}`,
          success: function () {
            dt_user.draw();
          },
          error: function (error) {
            console.log(error);
          }
        });
        Swal.fire({
          icon: 'success',
          title: '¡Eliminado!',
          text: '¡La marca ha sido eliminada correctamente!',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La marca no ha sido eliminada',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  // Editar Registro Marca
  $(document).ready(function () {
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

  // Actualizar Registro Marca
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

  // Agregar nuevo registro Etiquetas
  $(document).on('click', '.edit-etiquetas', function () {
    var id_marca = $(this).data('id');
    console.log(id_marca);
    $.get('/marcas-list/' + id_marca + '/editEtiquetas', function (data) {
      var marca = data.marca;
      var tipo = data.tipos;
      var clase = data.clases;
      var categoria = data.categorias;
      var documentos = data.documentacion_urls; // Documentos asociados

      // Rellenar el campo con el ID de la marca obtenida
      $('#etiqueta_marca').val(marca.id_marca);

      $('#contenidoRango').empty();

      var tipos = "";
      tipo.forEach(function (item) {
        tipos += "<option value='" + item.id_tipo + "'>" + item.nombre + "</option>";
      });

      var clases = "";
      clase.forEach(function (item) {
        clases += "<option value='" + item.id_clase + "'>" + item.clase + "</option>";
      });

      var categorias = "";
      categoria.forEach(function (item) {
        categorias += "<option value='" + item.id_categoria + "'>" + item.categoria + "</option>";
      });
      // Crear nuevas filas en la tabla con los datos de las etiquetas y documentos
      marca.sku.forEach(function (sku, index) {
        var id_tipo = marca.id_tipo[index];
        var presentacion = marca.presentacion[index];
        var id_clase = marca.id_clase[index];
        var id_categoria = marca.id_categoria[index];

        // Obtenemos los documentos correspondientes por id_doc
        var documento_etiquetas = documentos.find(doc => doc.nombre_documento === 'Etiquetas' && doc.id_doc === (index + 1));
        var documento_corrugado = documentos.find(doc => doc.nombre_documento === 'Corrugado' && doc.id_doc === (index + 1));

        var newRow = `
                  <tr>
                      <th>
                          <button type="button" class="btn btn-danger remove-row">
                              <i class="ri-delete-bin-5-fill"></i>
                          </button>
                      </th>
                      <td>
                          <input type="text" class="form-control form-control-sm" name="sku[]" min="0" value="${sku}">
                      </td>
                      <td>
                          <select class="form-control select2" name="id_tipo[]" id="id_tipo${index}">
                              ${tipos}
                          </select>
                      </td>
                      <td>
                          <input type="number" class="form-control form-control-sm" name="presentacion[]" min="0" value="${presentacion}">
                      </td>
                      <td>
                          <select class="form-control select2" name="id_clase[]" id="id_clase${index}">
                              ${clases}
                          </select>
                      </td>
                      <td>
                          <select class="form-control select2" name="id_categoria[]" id="id_categoria${index}">
                              ${categorias}
                          </select>
                      </td>
                      <td>
                          <div style="display: flex; align-items: center;">
                              <input class="form-control form-control-sm" type="file" name="url[]" style="flex: 1;">
                              ${documento_etiquetas ?
            `<a href="/storage/uploads/${data.numeroCliente}/${documento_etiquetas.url}" target="_blank" style="margin-left: 10px;">
                                      <i class="ri-file-pdf-2-line ri-20px" aria-hidden="true"></i> 
                                  </a>`
            : ''}
                          </div>
                          <input value="60" class="form-control" type="hidden" name="id_documento[]">
                          <input value="Etiquetas" class="form-control" type="hidden" name="nombre_documento[]">
                      </td>
                      <td>
                          <div style="display: flex; align-items: center;">
                              <input class="form-control form-control-sm" type="file" name="url[]" style="flex: 1;">
                              ${documento_corrugado ?
            `<a href="/storage/uploads/${data.numeroCliente}/${documento_corrugado.url}" target="_blank" style="margin-left: 10px;">
                                      <i class="ri-file-pdf-2-line ri-20px" aria-hidden="true"></i> 
                                  </a>`
            : ''}
                          </div>
                          <input value="75" class="form-control" type="hidden" name="id_documento[]">
                          <input value="Corrugado" class="form-control" type="hidden" name="nombre_documento[]">
                      </td>
                  </tr>`;

        $('#contenidoRango').append(newRow);

        // Inicializar select2 y establecer el valor seleccionado
        $('#id_tipo' + index).select2({
          dropdownParent: $('#etiquetas')
        }).val(id_tipo).trigger('change'); // Establecer el valor correcto

        $('#id_clase' + index).select2({
          dropdownParent: $('#etiquetas')
        }).val(id_clase).trigger('change');

        $('#id_categoria' + index).select2({
          dropdownParent: $('#etiquetas')
        }).val(id_categoria).trigger('change');
      });
      $('#etiquetas').modal('show');
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de las etiquetas',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });

  // Actualizar registro Etiquetas
  $('#etiquetasForm').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    console.log()

    $.ajax({
      url: '/etiquetado/updateEtiquetas',
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
        $('#etiquetas').modal('hide');
        $('.datatables-users').DataTable().ajax.reload();
      },
      error: function (response) {
        console.log(response);

        Swal.fire({
          title: 'Error',
          text: 'Ocurrió un error al actualizar la etiqueta.',
          icon: 'error',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });
});
