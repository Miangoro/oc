// resources/js/catalogo_lotes.js

$(function () {

  const tipoLoteSelect = document.getElementById('tipo_lote');
  const ocCidamFields = document.getElementById('oc_cidam_fields');
  const otroOrganismoFields = document.getElementById('otro_organismo_fields');


  tipoLoteSelect.addEventListener('change', function () {
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
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es'
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
      {
        data: null,
        searchable: true, orderable: false,
        render: function (data, type, row) {

          if (row.tipo_lote == 1) {
            return '<span class="fw-bold text-dark">Certificado por OC CIDAM</span>';
          } else {
            return '<span class="fw-bold text-info">Certificado por otro organismo</span>';
          }
        }
      },
      {
        data: null,
        searchable: true,
        orderable: false,
        render: function (data, type, row) {
          var ingredientes = '';
          var edad = '';
          var procedencia = '';

          if (row.ingredientes != 'N/A') {
            ingredientes = '<br><span class="fw-bold text-dark small">Ingrediente:</span><span class="small"> ' + row.ingredientes + '</span>';
          }

          if (row.edad != 'N/A') {
            edad = '<br><span class="fw-bold text-dark small">Edad:</span><span class="small"> ' + row.edad + '</span>';
          }

          // Mostrar los nombres de los lotes de procedencia
          if (row.lote_procedencia != 'No tiene procedencia de otros lotes.') {
            procedencia = '<br><span class="fw-bold text-dark small">Lote de procedencia:</span><span class="small"> ' + row.lote_procedencia + '</span>';
          }

          return '<span class="fw-bold text-dark small">Volumen inicial:</span> <span class="small"> ' + row.volumen +
            ' L</span><br><span class="fw-bold text-dark small">Categoría:</span><span class="small"> ' + row.id_categoria +
            '</span><br><span class="fw-bold text-dark small">Clase:</span><span class="small"> ' + row.id_clase +
            '</span><br><span class="fw-bold text-dark small">Tipo:</span><span class="small"> ' + row.id_tipo + '</span>' +
            ingredientes + edad + procedencia;
        }
      },
      { data: 'folio_fq' },
      { data: 'cont_alc' },
      {
        data: 'volumen_restante',
        render: function (data, type, row) {
          return data + ' L';
        }
      },
      {
        data: null,
        searchable: true, orderable: false,
        render: function (data, type, row) {

          if (row.folio_certificado != 'N/A') {
            return '<span class="fw-bold text-dark small">Organismo:</span> <span class="small"> ' + row.id_organismo +
              '</span><br><span class="fw-bold text-dark small">Certificado:</span><span class="small"> ' + row.folio_certificado +
              '</span><br><span class="fw-bold text-dark small">Fecha de emisión:</span><span class="small"> ' + row.fecha_emision +
              '</span><br><span class="fw-bold text-dark small">Fecha de vigencia:</span><span class="small"> ' + row.fecha_vigencia + '</span>';
          } else {
            return '<span class="badge rounded-pill bg-danger">Sin certificado</span>';
          }
        }
      },
      {
        data: 'estatus',
        searchable: false, orderable: false,
        render: function (data, type, row) {
          return '<span class="badge rounded-pill bg-success">' + data + '</span>';
        }
      },
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
            `<a data-id="${full['id_lote_granel']}" data-bs-toggle="modal" data-bs-target="#offcanvasEditLote" class="dropdown-item edit-record waves-effect text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Editar lotes agranel</a>` +
            `<a data-id="${full['id_lote_granel']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar lotes agranel</a>` +
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
    var id_lote = $(this).data('id'); // Obtener el ID de la clase
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
              text: '¡El lote ha sido eliminado correctamente!',
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

  /* registro de un lote */
  $(document).ready(function () {

    var lotesDisponibles = []; // Variable para almacenar los lotes disponibles

    let rowIndex = 0; // Contador global para el índice de las filas


    $('#es_creado_a_partir').change(function () {
      var valor = $(this).val();
      if (valor === 'si') {
        $('#addLotes').removeClass('d-none');
        if ($('#contenidoGraneles').children('tr').length === 0) {
          agregarFilaLotes(); // Llamar a la función para agregar la fila
        }
      } else {
        $('#addLotes').addClass('d-none');
        $('#contenidoGraneles').empty(); // Limpiar filas existentes

        // Verificar si hay alguna fila de volumen[${rowIndex}][volumen_parcial] antes de eliminar la validación
        if (fv.getFieldElements(`volumenes[${rowIndex}][volumen_parcial]`).length > 0) {
          fv.removeField(`volumenes[${rowIndex}][volumen_parcial]`); // Solo eliminar si existe
        }
      }
    });



    $('.add-row-lotes').click(function () {
      agregarFilaLotes(); // Usar la función para agregar fila
    });

    function agregarFilaLotes() {
      rowIndex++; // Incrementar el índice global

      var newRow = `
        <tr data-row-index="${rowIndex}">
            <th>
                <button type="button" class="btn btn-danger remove-row-lotes">
                    <i class="ri-delete-bin-5-fill fs-5"></i>
                </button>
            </th>
            <td>
                <select class="id_lote_granel form-control-sm select2" name="lote[${rowIndex}][id]" id="id_lote_granel_${rowIndex}">
                    <!-- Opciones se cargarán dinámicamente -->
                </select>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm volumen-parcial" name="volumenes[${rowIndex}][volumen_parcial]" id="volumen_parcial_${rowIndex}">
            </td>
        </tr>`;

      $('#contenidoGraneles').append(newRow);

      // Inicializar select2 para el nuevo select
      initializeSelect2($('.select2'));

      // Revalidar el campo después de agregar la fila

      fv.addField(`volumenes[${rowIndex}][volumen_parcial]`, {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el volumen parcial'
          },
          numeric: {
            message: 'El volumen debe ser un número válido'
          },

        }
      });

      // Revalidar ambos campos después de agregar la fila
      fv.revalidateField(`lote[${rowIndex}][id]`);
      fv.revalidateField(`volumenes[${rowIndex}][volumen_parcial]`);
      // Esperar 100ms para asegurarse que los campos estén bien procesados
    }

    $(document).on('click', '.remove-row-lotes', function () {
      // Obtén la fila y el índice de la fila a eliminar
      var row = $(this).closest('tr');
      var rowIndex = row.data('row-index');

      // Verifica si los campos existen antes de intentar eliminarlos
      /*       if (fv.getFieldElements(`volumenes[${rowIndex}][volumen_parcial]`).length > 0) {
                fv.removeField(`volumenes[${rowIndex}][volumen_parcial]`);
            } */
      fv.removeField(`volumenes[${rowIndex}][volumen_parcial]`);

      // Ahora elimina la fila del DOM
      row.remove();

      // Recalcula el volumen total al eliminar la fila
      calcularVolumenTotal();
    });



    $(document).on('input', '.volumen-parcial', function () {
      calcularVolumenTotal(); // Recalcular total en cada cambio
    });

    $(document).on('lotesCargados', function (event, lotesGranel) {
      lotesDisponibles = lotesGranel;
      cargarLotesEnSelect();
    });




    // Función para cargar lotes en los select dentro de las filas
    function cargarLotesEnSelect() {
      $('.id_lote_granel').each(function () {
        var $select = $(this);
        var valorSeleccionado = $select.val();

        $select.empty(); // Vaciar las opciones actuales

        if (lotesDisponibles.length > 0) {
          lotesDisponibles.forEach(function (lote) {
            // Usar backticks para agregar la opción correctamente
            $select.append(`<option value="${lote.id_lote_granel}">${lote.nombre_lote}</option>`);
          });
          if (valorSeleccionado) {
            $select.val(valorSeleccionado); // Seleccionar el valor si ya está definido
          }
        } else {
          $select.append('<option value="" disabled selected>Sin lotes registrados</option>');
        }
      });
    }

    // Función para calcular el volumen total
    function calcularVolumenTotal() {
      let totalVolumen = 0;

      // Sumar todos los volúmenes parciales
      $('.volumen-parcial').each(function () {
        const valor = parseFloat($(this).val()) || 0; // Obtener valor o 0 si no es un número
        totalVolumen += valor; // Sumar al total
      });

      // Actualizar el campo de volumen total
      $('#volumen').val(totalVolumen.toFixed(2)); // Mostrar el total con dos decimales

    }


    $(document).on('change', '.id_lote_granel', function () {
      var loteSeleccionado = $(this).val();
      var $volumenParcialInput = $(this).closest('tr').find('.volumen-parcial'); // Encuentra el campo de Volumen parcial correspondiente

      // Verifica si hay un lote seleccionado
      if (!loteSeleccionado) {
        $volumenParcialInput.val(''); // Limpia el campo si no hay un lote seleccionado
        return;
      }

      // Realiza una petición AJAX para obtener el volumen_restante del lote seleccionado
      $.ajax({
        url: '/lotes-a-granel/' + loteSeleccionado + '/volumen', // Nueva ruta GET para obtener el volumen
        method: 'GET',
        success: function (response) {
          // Suponiendo que el volumen_restante viene en la respuesta
          if (response.volumen_restante) {
            $volumenParcialInput.val(response.volumen_restante);
          } else {
            $volumenParcialInput.val('0'); // Si no hay volumen restante
          }
        },
        error: function (xhr, status, error) {
          console.error('Error al obtener el volumen del lote:', error);
          alert('Error al obtener el volumen. Por favor, intenta nuevamente.');
        }
      });
    });


  // Al cambiar el valor del tipo de lote
  $('#tipo_lote').change(function() {
    var tipoLote = $(this).val();

    // Verificar si la opción seleccionada es "Certificación por OC CIDAM"
    if (tipoLote == '1') {
        // Mostrar el campo de guías
        $('#mostrar_guias').removeClass('d-none');

        // Cambiar la clase y el id de volumen
        $('#volmen_in').removeClass('col-md-12').addClass('col-md-6').attr('id', 'volmen_in');

        // Validar que las guías sean seleccionadas
        fv.addField('id_guia[]', {
            validators: {
                notEmpty: {
                    message: 'Por favor selecciona al menos una guía'
                }
            }
        });
    } else {
        // Ocultar el campo de guías
        $('#mostrar_guias').addClass('d-none');

        // Restaurar la clase y el id de volumen
        $('#volmen_in').removeClass('col-md-6').addClass('col-md-12').attr('id', 'volmen_in');

        // Eliminar la validación de las guías
        fv.removeField('id_guia[]');
    }
});


    const addNewLote = document.getElementById('loteForm');
    const fv = FormValidation.formValidation(addNewLote, {
      fields: {
        nombre_lote: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el cliente'
            }
          }
        },
        es_creado_a_partir: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la opción'
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
        volumen: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el volumen'
            }
          }
        },
        cont_alc: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el contenido alcoholico'
            }
          }
        },
        id_categoria: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la categoría'
            }
          }
        },
        id_clase: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la clase'
            }
          }
        },
        'id_tipo[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo de agave'
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
      // Depurar los datos del formulario
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
            text: 'Lote registrado exitosamente',
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
    // Inicializar select2 y revalidar el campo cuando cambie
    $('#id_empresa, #id_guia, #tipo_agave').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });

  });











  $(document).ready(function () {


    const edit_tipoLoteSelect = document.getElementById('edit_tipo_lote');
    const edit_ocCidamFields = document.getElementById('edit_oc_cidam_fields');
    const edit_otroOrganismoFields = document.getElementById('edit_otro_organismo_fields');
    const edit_mostrarGuias = document.getElementById('edit_mostrar_guias');
    const edit_volumenIn = document.getElementById('edit_volumen_in');

    // Selecciona los campos de archivo y de texto
    const edit_otroOrganismoFileField = document.getElementById('file-59');

    // Lógica para cambiar los campos visibles y la validación de las guías
    function updateFieldsAndValidation() {
      const selectedValue = edit_tipoLoteSelect.value;

      // Si el lote es certificado por OC CIDAM (Tipo 1)
      if (selectedValue === '1') {
        // Mostrar campos de CIDAM y ocultar los de otro organismo
        edit_ocCidamFields.classList.remove('d-none');
        edit_otroOrganismoFields.classList.add('d-none');

        // Mostrar los campos de guías y volumen de tipo lote
        edit_mostrarGuias.classList.remove('d-none');
        edit_volumenIn.classList.remove('col-md-12');
        edit_volumenIn.classList.add('col-md-6');

        // Agregar la validación de las guías
        fv.addField('id_guia[]', {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione al menos un folio de guía'
            }
          }
        });
      }
      // Si el lote es certificado por otro organismo (Tipo 2)
      else if (selectedValue === '2') {
        // Ocultar campos de CIDAM y mostrar los de otro organismo
        edit_ocCidamFields.classList.add('d-none');
        edit_otroOrganismoFields.classList.remove('d-none');

        // Ocultar los campos de guías y hacer que el volumen ocupe todo el ancho
        edit_mostrarGuias.classList.add('d-none');
        edit_volumenIn.classList.remove('col-md-6');
        edit_volumenIn.classList.add('col-md-12');

        // Eliminar la validación de las guías
        fv.removeField('id_guia[]');
      }
      // Si no hay tipo de lote seleccionado
      else {
        // Ocultar todo
        edit_ocCidamFields.classList.add('d-none');
        edit_otroOrganismoFields.classList.add('d-none');
        edit_mostrarGuias.classList.add('d-none');
        edit_volumenIn.classList.remove('col-md-12');
        edit_volumenIn.classList.add('col-md-6');

        // Eliminar la validación de las guías en caso de que no se seleccione un tipo de lote
        fv.removeField('id_guia[]');
      }
    }

    var rowIndex = 0;

// Inicializa rowIndex solo cuando es necesario, y no en cada acción
function inicializarRowIndex() {
  // Contamos las filas actuales para inicializar el índice
  rowIndex = $('#contenidoGranelesEdit').children('tr').length;
}


    $(document).on('click', '.edit-record', function () {
      var loteId = $(this).data('id');
      $('#edit_lote_id').val(loteId);

      $.ajax({
        url: '/lotes-a-granel/' + loteId + '/edit',
        method: 'GET',
        success: function (data) {
          if (data.success) {
            var lote = data.lote;
            var guias = data.guias; // IDs y folios de las guías recibidos
            var lotes = data.lotes;
            var volumenes = data.volumenes;
            var nombreLotes = data.nombreLotes; // Este array contiene los nombres de los lote
            var organismoId = data.organismo;
            var tipos = data.tipos;

            $('#contenidoGranelesEdit').html('');
            $('#edit_tipo_agave').empty();

            inicializarRowIndex(); // Reiniciar rowIndex en función de las filas cargadas

            // Código para cargar los datos del lote, incluyendo el bucle para agregar las filas
            if (data.lotes.length > 0) {
              data.lotes.forEach(function (loteId) {
                var loteNombre = data.nombreLotes[loteId] || 'Lote no disponible';
                var volumen = data.volumenes[rowIndex] || '';

                var filaHtml = `
                  <tr>
                    <th>
                      <button type="button" class="btn btn-danger remove-row-lotes-edit"> <i class="ri-delete-bin-5-fill"></i> </button>
                    </th>
                    <td>
                      <select class="id_lote_granel select2" name="edit_lotes[${rowIndex}][id]" id="edit_id_lote_granel_${rowIndex}">
                        <option value="${loteId}">${loteNombre}</option>
                      </select>
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm volumen-parcial" name="edit_volumenes[${rowIndex}][volumen_parcial]" id="edit_volumen_parcial_${rowIndex}" value="${volumen}">
                    </td>
                  </tr>`;

                $('#contenidoGranelesEdit').append(filaHtml);

                // Inicializa Select2 para esta fila
                initializeSelect2($('#edit_id_lote_granel_' + rowIndex));

                // Incrementa el índice global después de agregar la fila
                rowIndex++;
              });

              $('#editLotesGranel').removeClass('d-none');
            } else {
              $('#editLotesGranel').addClass('d-none');
            }

            // Rellenar el modal con los datos del lote
            $('#edit_nombre_lote').val(lote.nombre_lote);
            $('#edit_id_empresa').val(lote.id_empresa).trigger('change');
            $('#edit_tipo_lote').val(lote.tipo_lote);
            // Agrega manualmente las opciones usando los folios como el texto visible

            // Asigna los valores seleccionados (solo IDs)
            var guiasIds = guias.map(function (guia) { return guia.id; });
            $('#edit_id_guia').val(guiasIds).trigger('change');

            $('#edit_volumen').val(lote.volumen);
            $('#edit_cont_alc').val(lote.cont_alc);
            $('#edit_id_categoria').val(lote.id_categoria).trigger('change');
            $('#edit_clase_agave').val(lote.id_clase).trigger('change');
             // Si es un array, asegúrate de usar `.val()` con un array de valores
            // Cargar las opciones estáticas (de $tipos)
            $.each(tipos, function (index, tipo) {
              var option = new Option(tipo.nombre, tipo.id_tipo);
              $('#edit_tipo_agave').append(option);
          });
            // Asignar las opciones seleccionadas del lote
            $('#edit_tipo_agave').val(data.id_tipo).trigger('change');
            // Mostrar campos condicionales
            if (lote.tipo_lote == '1') {
              $('#edit_oc_cidam_fields').removeClass('d-none');
              $('#edit_otro_organismo_fields').addClass('d-none');
              $('#edit_ingredientes').val(lote.ingredientes);
              $('#edit_edad').val(lote.edad);

              // Mostrar las guías solo si el lote es CIDAM
              $('#edit_mostrar_guias').removeClass('d-none');
              $('#edit_volumen_in').removeClass('col-md-12').addClass('col-md-6');

              // Añadir guías al campo select de guías
              guias.forEach(function (guia) {
                $('#edit_id_guia').append(new Option(guia.folio, guia.id));
              });

              // Agregar validación para guías si es necesario
              if (!fv.hasField('id_guia[]')) {
                fv.addField('id_guia[]', {
                  validators: {
                    notEmpty: {
                      message: 'Por favor seleccione al menos un folio de guía'
                    }
                  }
                });
              }
            } else if (lote.tipo_lote == '2') {
              $('#edit_otro_organismo_fields').removeClass('d-none');
              $('#edit_oc_cidam_fields').addClass('d-none');
              $('#edit_folio_certificado').val(lote.folio_certificado);
              $('#edit_organismo_certificacion').val(organismoId).trigger('change');
              $('#edit_fecha_emision').val(lote.fecha_emision);
              $('#edit_fecha_vigencia').val(lote.fecha_vigencia);

                // Ocultar el campo de las guías si es tipo 2
                  $('#edit_mostrar_guias').addClass('d-none');
                  $('#edit_volumen_in').removeClass('col-md-6').addClass('col-md-12');

                  // Eliminar las opciones de guías si es tipo 2
                  $('#edit_id_guia').empty();

                  // Eliminar validación de guías si es tipo 2
                  if (fv.hasField('id_guia[]')) {
                    fv.removeField('id_guia[]');
                  }

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
              var ultimoDocumentoCompletoId = null;     // Variable para almacenar el último ID de documento completo
              var ultimoDocumentoAjusteId = null;       // Variable para almacenar el último ID de documento de ajuste

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
                  ultimoDocumentoCompletoId = documento.id_documento; // Guardar el ID
                }

                // Mostrar el documento de ajuste
                if (documento.tipo.includes('Ajuste de grado') && documento.url && !documentoAjusteUrlAsignado) {
                  var fileNameAjuste = documento.url.split('/').pop();
                  archivoUrlDisplayAjuste.html('Documento ajuste disponible: <a href="../files/' + data.numeroCliente + '/' + documento.url + '" target="_blank" class="text-primary">' + fileNameAjuste + '</a>');
                  folioFqAjusteInput.val(documento.nombre);
                  documentoAjusteUrlAsignado = true; // Marcar como asignado
                  ultimoDocumentoAjusteId = documento.id_documento; // Guardar el ID
                }
              });

              // Si no se asignó un documento completo, mostrar un mensaje
              if (!documentoCompletoUrlAsignado && ultimoDocumentoCompletoId !== null) {
                $('#archivo_url_display_completo_' + ultimoDocumentoCompletoId).html('No hay archivo completo disponible.');
              }
              // Si no se asignó un documento de ajuste, mostrar un mensaje
              if (!documentoAjusteUrlAsignado && ultimoDocumentoAjusteId !== null) {
                $('#archivo_url_display_ajuste_' + ultimoDocumentoAjusteId).html('No hay archivo de ajuste disponible.');
              }
            } else {
              console.log('No hay documentos disponibles.');
            }

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


    var lotesDisponiblesEdit = [];

    $('#edit_es_creado_a_partir').change(function () {
      var valor = $(this).val();

      if (valor === 'si') {
        $('#editLotesGranel').removeClass('d-none');
        if ($('#contenidoGranelesEdit').children('tr').length === 0) {
          agregarFilaLotesEdit();
        }
      } else {
        $('#editLotesGranel').addClass('d-none');
        $('#contenidoGranelesEdit').empty();
        rowIndex = 0;
      }
    });

    $('.add-row-lotes-edit').click(function () {
      agregarFilaLotesEdit();
    });


    // Función para agregar una nueva fila en la tabla de lotes de edición
    function agregarFilaLotesEdit() {
      // Inicializa el índice solo si es necesario
      inicializarRowIndex();  // Asegúrate de que el índice se calcule bien

      var newRow = `
        <tr>
          <th>
            <button type="button" class="btn btn-danger remove-row-lotes-edit">
              <i class="ri-delete-bin-5-fill fs-5"></i>
            </button>
          </th>
          <td>
            <select class="id_lote_granel form-control-sm select2" name="edit_lotes[${rowIndex}][id]" id="edit_id_lote_granel_${rowIndex}">
              <!-- Opciones de lotes se cargarán dinámicamente -->
            </select>
          </td>
          <td>
            <input type="text" class="form-control form-control-sm volumen-parcial-edit" name="edit_volumenes[${rowIndex}][volumen_parcial]" id="edit_volumen_parcial_${rowIndex}">
          </td>
        </tr>`;

      $('#contenidoGranelesEdit').append(newRow);

      // Actualiza los lotes en los selects
      cargarLotesEnSelectEdit();
      initializeSelect2($(`#edit_id_lote_granel_${rowIndex}`));

      // Incrementar rowIndex después de agregar la fila
      rowIndex++;  // Incrementar el índice después de agregar la fila
    }


    // Recalcula todos los índices de las filas para evitar duplicados
    function recalcularIndices() {
      rowIndex = 0;  // Reasignamos el índice global
      $('#contenidoGranelesEdit').find('tr').each(function () {
        // Actualizamos el índice en cada fila
        $(this).find('select').attr('name', `edit_lotes[${rowIndex}][id]`).attr('id', `edit_id_lote_granel_${rowIndex}`);
        $(this).find('input').attr('name', `edit_volumenes[${rowIndex}][volumen_parcial]`).attr('id', `edit_volumen_parcial_${rowIndex}`);
        rowIndex++;  // Incrementamos el índice
      });
    }



    // Eliminar una fila de lotes en modo edición y actualizar los índices
    $(document).on('click', '.remove-row-lotes-edit', function () {
      $(this).closest('tr').remove();
      recalcularIndices();  // Llamada para recalcular los índices
      if ($('#contenidoGranelesEdit').children('tr').length <= 1) {
        $('.remove-row-lotes-edit').attr('disabled', true);
      }
    });



    // Escuchar cambios en los campos de volumen parcial en modo edición
    $(document).on('input', '.volumen-parcial-edit', function () {
      calcularVolumenTotalEdit(); // Recalcular total en cada cambio
    });

    // Cargar lotes en los selects dentro de filas en modo edición
// Cargar lotes en los selects dentro de filas en modo edición
    function cargarLotesEnSelectEdit() {
      $('.id_lote_granel').each(function () {
        var $select = $(this);
        var valorSeleccionado = $select.val();
        $select.empty();
        if (lotesDisponiblesEdit.length > 0) {
          lotesDisponiblesEdit.forEach(function (lote) {
            $select.append(`<option value="${lote.id_lote_granel}">${lote.nombre_lote}</option>`);
          });
          if (valorSeleccionado) {
            $select.val(valorSeleccionado);
          }
        } else {
          $select.append('<option value="" disabled selected>Sin lotes registrados</option>');
        }
      });
    }


    const editLoteForm = document.getElementById('loteFormEdit');

    // Configuración de FormValidation
    const fv = FormValidation.formValidation(editLoteForm, {
      fields: {
        nombre_lote: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el nombre del lote'
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
        volumen: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen del lote'
            }
          }
        },
        cont_alc: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el contenido alcohólico'
            }
          }
        },
        id_categoria: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la categoría'
            }
          }
        },
        id_clase: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la clase'
            }
          }
        },
        id_tipo: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo'
            }
          }
        },
        'id_tipo[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo'
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.mb-4'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      var formData = new FormData(editLoteForm);
      var loteId = $('#edit_lote_id').val();

      $.ajax({
        url: '/lotes-a-granel/' + loteId,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
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
        error: function (xhr) {
          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            var errorMessages = Object.keys(errors).map(function (key) {
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


    // Inicializar select2 y revalidar el campo cuando cambie
    $('#id_empresa, #id_guia, #tipo_agave').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });

// Inicializar la página con los valores correctos
document.addEventListener('DOMContentLoaded', updateFieldsAndValidation);

// Añadir el listener para el cambio en el tipo de lote
edit_tipoLoteSelect.addEventListener('change', updateFieldsAndValidation);

  });



});
