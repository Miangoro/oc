// resources/js/catalogo_lotes.js

$(function () {
  // Declaras el arreglo de botones
  let buttons = [];

  // Si tiene permiso, agregas el botón
  if (puedeAgregarElUsuario) {
    buttons.push({
      text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Lote</span>',
      className: 'add-new btn btn-primary waves-effect waves-light',
      attr: {
        'data-bs-toggle': 'modal',
        'data-bs-target': '#offcanvasAddLote'
      }
    });
  }

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
      {
        data: null,
        searchable: true,
        orderable: false,
        render: function (data, type, row) {
          if (row.tipo_lote == 1) {
            return '<span class="fw-bold text-dark">Certificado por OC CIDAM</span>';
          } else {
            return '<span class="fw-bold text-info">Certificado por otro organismo</span>';
          }
        }
      },
      { data: 'nombre_lote' },
      {
        data: null,
        searchable: true,
        orderable: false,
        render: function (data, type, row) {
          var ingredientes = '';
          var edad = '';
          var procedencia = '';

          if (row.ingredientes != 'N/A') {
            ingredientes =
              '<br><span class="fw-bold text-dark small">Ingrediente:</span><span class="small"> ' +
              row.ingredientes +
              '</span>';
          }

          if (row.edad != 'N/A') {
            edad = '<br><span class="fw-bold text-dark small">Edad:</span><span class="small"> ' + row.edad + '</span>';
          }

          // Mostrar los nombres de los lotes de procedencia
          if (row.lote_procedencia != 'No tiene procedencia de otros lotes.') {
            procedencia =
              '<br><span class="fw-bold text-dark small">Lote de procedencia: <br></span><span class="small text-primary"> ' +
              row.lote_procedencia +
              '</span>';
          }

          return (
            '<span class="fw-bold text-dark small">Volumen inicial:</span> <span class="small"> ' +
            row.volumen +
            ' L</span><br><span class="fw-bold text-dark small">Categoría:</span><span class="small"> ' +
            row.id_categoria +
            '</span><br><span class="fw-bold text-dark small">Clase:</span><span class="small"> ' +
            row.id_clase +
            '</span><br><span class="fw-bold text-dark small">Tipo:</span><span class="small"> ' +
            row.id_tipo +
            '</span><br><span class="fw-bold text-dark small">Tanque:</span><span class="small"> ' +
            row.id_tanque +
            '</span>' +
            ingredientes +
            edad +
            procedencia
          );
        }
      },

      {
        data: 'folio_fq',
        render: function (data, type, row) {
          // Separar los folios
          const folios = data ? data.split(',') : [];
          const folioCompleto = folios[0] ?? '';
          const folioAjuste = folios[1] ?? '';

          let html = '';

          // Análisis completo
          if (row.url_fq_completo && folioCompleto) {
            html += `<div><strong>Completo:</strong> <a class="cursor-pointer pdf text-primary" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-url="${row.url_fq_completo}">${folioCompleto}</a></div>`;
          } else if (folioCompleto) {
            html += `<div><strong>Completo:</strong> ${folioCompleto}</div>`;
          }

          // Ajuste de grado
          if (row.url_fq_ajuste && folioAjuste) {
            html += `<div><strong>Ajuste:</strong> <a class="cursor-pointer pdf text-primary" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-url="${row.url_fq_ajuste}">${folioAjuste}</a></div>`;
          } else if (folioAjuste) {
            html += `<div><strong>Ajuste:</strong> ${folioAjuste}</div>`;
          }

          return html || 'N/A';
        }
      },

      { data: 'cont_alc' },
      {
        data: 'volumen_restante',
        render: function (data, type, row) {
          return data + ' L';
        }
      },
      {
        data: null,
        searchable: true,
        orderable: false,
        render: function (data, type, row) {
          if (row.folio_certificado !== 'N/A') {
            return (
              '<span class="fw-bold text-dark small">Organismo:</span> <span class="small">' +
              (row.id_organismo || 'CIDAM') +
              '</span><br><span class="fw-bold text-dark small">Certificado:</span><span class="small"> ' +
              // Verifica si hay URL del certificado

              /*(row.url_certificado
                ? `<a class="text-decoration-underline waves-effect text-primary pdfCerGranel" data-bs-target="#mostrarPdf"
                  data-bs-toggle="modal" data-bs-dismiss="modal"
                  data-id="${row.id_lote_granel}" data-registro="${row.id_empresa}"
                  data-url="${row.url_certificado}">${row.folio_certificado}</a>`
                : row.folio_certificado) +*/
              (row.certificado
                ? `<a href="${row.certificado}" class="text-primary" target="_blank">${row.num_certificado}</a>`
                : row.num_certificado) +

              '</span>' +
              '<br><span class="fw-bold text-dark small">Emisión:</span><span class="small"> ' +
              row.fecha_emision +
              '</span><br><span class="fw-bold text-dark small">Vigencia:</span><span class="small"> ' +
              row.fecha_vigencia +
              '</span>'
            );
          } else {
            return '<span class="badge rounded-pill bg-danger">Sin certificado</span>';
          }
        }
      },

      {
        data: 'estatus',
        searchable: false,
        orderable: false,
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
          let acciones = '';
          if (window.puedeEditarElUsuario) {
            acciones += `<a data-id="${full['id_lote_granel']}" data-bs-toggle="modal" data-bs-target="#offcanvasEditLote" class="dropdown-item edit-record waves-effect text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Editar lotes agranel</a>`;
          }
          if (window.puedeEliminarElUsuario) {
            acciones += `<a data-id="${full['id_lote_granel']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar lotes agranel</a>`;
          }
          // Si no hay acciones, no retornar el dropdown
          if (!acciones.trim()) {
            return `
                <button class="btn btn-sm btn-secondary" disabled>
                  <i class="ri-lock-2-line ri-20px me-1"></i> Opciones
                </button>
              `;
          }
          // Si hay acciones, construir el dropdown
          const dropdown = `<div class="d-flex align-items-center gap-50">
            <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
            <div class="dropdown-menu dropdown-menu-end m-0">
                  ${acciones}
                </div>
              </div>
            `;
          return dropdown;
        }
      }
    ],
    order: [[1, 'desc']],
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
    buttons: buttons,
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
    userView = baseUrl + 'app/user/view/account';
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


  ///FORMATO PDF DICTAMEN
  $(document).on('click', '.pdfCerGranel', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var url = $(this).data('url'); // Aquí obtenemos la URL del certificado
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    //Cargar el PDF con el ID
    iframe.attr('src', url);

    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', url).show();
    $("#titulo_modal").text("Certificado de lote a granel");
    $("#subtitulo_modal").html(registro);
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  if (!window.puedeVerElUsuario) {
    $('#edit_volumen_res').closest('.row').hide(); // oculta toda la fila
  }

  // Reciben los datos del PDF
  $(document).on('click', '.pdf', function () {
    var id = $(this).data('id'); //Obtén el ID desde el atributo "data-id" en PDF
    var pdfUrl = $(this).data('url'); //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    spinner.show();
    iframe.hide();

    iframe.attr('src', pdfUrl);
    $('#NewPestana').attr('href', pdfUrl).show();

    $('#titulo_modal').text('Análisis fisicoquímico');
    // $("#subtitulo_modal").text("PDF del Dictamen");

    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });



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




///REGISTRAR NUEVO LOTE
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
      obtenerDatosEmpresa();
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
          }
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

    $(document).on('input', '.volumen-parcial', function () { /* #agua_entrada */
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
            $select.append(`<option value="${lote.id_lote_granel}">${lote.nombre_lote} (${lote.cont_alc}% Alc. Vol.) (${lote.volumen_restante} L)</option>`);
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
   /*  function calcularVolumenTotal() {
      let totalVolumen = 0;

      // Sumar todos los volúmenes parciales
      $('.volumen-parcial').each(function () {
        const valor = parseFloat($(this).val()) || 0; // Obtener valor o 0 si no es un número
        totalVolumen += valor; // Sumar al total
      });

      // Actualizar el campo de volumen total
      $('#volumen').val(totalVolumen.toFixed(2)); // Mostrar el total con dos decimales
    } */

      function calcularVolumenTotal() {
      let totalVolumen = 0;

      $('.volumen-parcial').each(function () {
        const valor = parseFloat($(this).val()) || 0;
        totalVolumen += valor;
      });

      $('#volumen').val(totalVolumen.toFixed(2));
  }


/*     function calcularVolumenTotal() {
      let totalVolumen = 0;

      $('.volumen-parcial').each(function () {
        const valor = parseFloat($(this).val()) || 0;
        totalVolumen += valor;
      });


      const aguaEntrada = parseFloat($('#agua_entrada').val()) || 0;
      totalVolumen += aguaEntrada;


      $('#volumen').val(totalVolumen.toFixed(2));
    }
 */


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
    $('#tipo_lote').change(function () {
      var tipoLote = $(this).val();

      // Verificar si la opción seleccionada es "Certificación por OC CIDAM"
      if (tipoLote == '1') {
        // Mostrar el campo de guías
        $('#mostrar_guias').removeClass('d-none');

        // Cambiar la clase y el id de volumen
        /* $('#volmen_in').removeClass('col-md-12').addClass('col-md-6').attr('id', 'volmen_in'); */
      } else {
        // Ocultar el campo de guías
        $('#mostrar_guias').addClass('d-none');

        // Restaurar la clase y el id de volumen
        /* $('#volmen_in').removeClass('col-md-6').addClass('col-md-12').attr('id', 'volmen_in'); */
      }
    });

    $(function () {
      $('#tipo_lote').on('change', function () {
        var selectedValue = $(this).val();

        if (selectedValue === '1') {
          $('#oc_cidam_fields').removeClass('d-none');
          $('#otro_organismo_fields').addClass('d-none');

          // Desactivar validaciones para otro organismo
          fv.disableValidator('folio_certificado');
          fv.disableValidator('id_organismo');
          fv.disableValidator('fecha_emision');
          fv.disableValidator('fecha_vigencia');
          fv.disableValidator('documentos[0][url]');
        } else if (selectedValue === '2') {
          $('#oc_cidam_fields').addClass('d-none');
          $('#otro_organismo_fields').removeClass('d-none');

          // Activar validaciones para otro organismo
          fv.enableValidator('folio_certificado');
          fv.enableValidator('id_organismo');
          fv.enableValidator('fecha_emision');
          fv.enableValidator('fecha_vigencia');
          fv.enableValidator('documentos[0][url]');
        } else {
          $('#oc_cidam_fields').addClass('d-none');
          $('#otro_organismo_fields').addClass('d-none');

          // Desactivar validaciones en ambos casos
          fv.disableValidator('folio_certificado');
          fv.disableValidator('id_organismo');
          fv.disableValidator('fecha_emision');
          fv.disableValidator('fecha_vigencia');
          fv.disableValidator('documentos[0][url]');
        }
      });
    });




/* // Detecta cambio de empresa
  $('#id_empresa').on('change', function() {
      obtenerDestinoEmpresa();
  });
// Función para obtener destino de la empresa
async function obtenerDestinoEmpresa() {
    let empresaId = $("#id_empresa").val();
    if (!empresaId) return;

    try {
        const response = await $.get('/getDatosMaquila/' + empresaId);
        let $selectDestino = $('#id_empresa_destino');
        $selectDestino.empty();

        // Obtener datos de la empresa seleccionada
        let empresaSeleccionadaText = $("#id_empresa option:selected").text();
        let numeroCliente = empresaSeleccionadaText.split('|')[0]?.trim() ?? '';
        let razonSocial = empresaSeleccionadaText.split('|')[1]?.trim() ?? '';

        if (response.empresasDestino.length > 1) {
            // Tiene maquiladores: mostrar todos los destinos y habilitar select
            $selectDestino.append(`<option value="" disabled selected>Selecciona una empresa destino</option>`);

            response.empresasDestino.forEach(emp => {
                let numeroClienteDestino = emp.empresa_num_clientes[0]?.numero_cliente
                                            ?? emp.empresa_num_clientes[1]?.numero_cliente
                                            ?? '';
                $selectDestino.append(`<option value="${emp.id_empresa}">${numeroClienteDestino} | ${emp.razon_social}</option>`);
            });
            $selectDestino.prop('disabled', false);
        } else {
            // No tiene maquiladores: mostrar propia empresa visualmente y deshabilitar
            $selectDestino.append(`<option value="${empresaId}" selected>${numeroCliente} | ${razonSocial}</option>`);
            $selectDestino.prop('disabled', true);
        }

    } catch (error) {
        console.error('Error al cargar los datos de la empresa:', error);
        alert('Error al cargar los datos. Por favor, intenta nuevamente.');
    }
} */

//FORMULARIO AGREGAR
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
        id_estado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el origen'
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


        'folio_certificado': {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa el folio del certificado'
            }
          }
        },
        'id_organismo': {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el organismo'
            }
          }
        },
        'fecha_emision': {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la fecha de emisión'
            }
          }
        },
        'fecha_vigencia': {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la fecha de vigencia'
            }
          }
        },
        'documentos[0][url]': {
          validators: {
            notEmpty: {
              message: 'Por favor adjunta el certificado'
            }
          }
        },

        id_empresa_destino: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa destino'
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
      $('#btnAdd').addClass('d-none'); // Ocultar el botón de envío
      $('#btnSpinner').removeClass('d-none'); // Mostrar el spinner de carga
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
          $('input[type="file"][name="url[]"]').val('');
          $('#loteForm').trigger('reset');
          $('#id_empresa').val('').trigger('change');
          $('#id_guia').val('').trigger('change');
          $('#id_organismo').val('').trigger('change');
          $('#tipo_agave').val('').trigger('change');
          $('#btnSpinner').addClass('d-none'); // Ocultar el botón de envío
          $('#btnAdd').removeClass('d-none'); // Mostrar el spinner de carga
          $('#offcanvasAddLote').modal('hide');
          $('.datatables-users').DataTable().ajax.reload(null, false);

    // Diferenciar mensaje normal o advertencia
    if(response.warning) {
        Swal.fire({
            icon: 'warning',
            title: '¡Advertencia!',
            text: response.message,
            confirmButtonClass: 'btn btn-warning',
            customClass: {
              confirmButton: 'btn btn-primary'
            }
        }).then(() => {
            location.reload(); // refresca la página para que veas el registro
        });
    } else if(response.success) {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Lote registrado exitosamente',
            customClass: {
              confirmButton: 'btn btn-primary'
            }
        });
    }
          /*// Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Lote registrado exitosamente',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
          */
        },
        error: function (xhr) {
          // Mostrar alerta de error
          console.log(xhr.responseJSON?.message)
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al agregar el lote a granel',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#btnSpinner').addClass('d-none'); // Ocultar el botón de envío
          $('#btnAdd').removeClass('d-none'); // Mostrar el spinner de carga
        }
          /*
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
          $('#btnSpinner').addClass('d-none'); // Ocultar el botón de envío
          $('#btnAdd').removeClass('d-none'); // Mostrar el spinner de carga
        }
        */
      });
});
    // Inicializar select2 y revalidar el campo cuando cambie
    $('#id_empresa, #id_guia, #tipo_agave').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });

});




///FUNCION ACTUALIZAR
$(document).ready(function () {

    const edit_tipoLoteSelect = document.getElementById('edit_tipo_lote');
    const edit_ocCidamFields = document.getElementById('edit_oc_cidam_fields');
    const edit_otroOrganismoFields = document.getElementById('edit_otro_organismo_fields');
    const edit_mostrarGuias = document.getElementById('edit_mostrar_guias');
    /* const edit_volumenIn = document.getElementById('edit_volumen_in'); */

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
        /* edit_volumenIn.classList.remove('col-md-12');
        edit_volumenIn.classList.add('col-md-6'); */
      }
      // Si el lote es certificado por otro organismo (Tipo 2)
      else if (selectedValue === '2') {
        // Ocultar campos de CIDAM y mostrar los de otro organismo
        edit_ocCidamFields.classList.add('d-none');
        edit_otroOrganismoFields.classList.remove('d-none');

        // Ocultar los campos de guías y hacer que el volumen ocupe todo el ancho
        edit_mostrarGuias.classList.add('d-none');
        /* edit_volumenIn.classList.remove('col-md-6');
        edit_volumenIn.classList.add('col-md-12'); */
      }
      // Si no hay tipo de lote seleccionado
      else {
        // Ocultar todo
        edit_ocCidamFields.classList.add('d-none');
        edit_otroOrganismoFields.classList.add('d-none');
        edit_mostrarGuias.classList.add('d-none');
       /*  edit_volumenIn.classList.remove('col-md-12');
        edit_volumenIn.classList.add('col-md-6'); */
      }
    }

    var rowIndex = 0;

    // Inicializa rowIndex solo cuando es necesario, y no en cada acción
    function inicializarRowIndex() {
      // Contamos las filas actuales para inicializar el índice
      rowIndex = $('#contenidoGranelesEdit').children('tr').length;
    }



///OBTENER LOTE
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
            var tipos = data.tipos || [];
            var lote_original_id = data.lote.lote_original_id;
            if (lote_original_id) {
              $('#edit_es_creado_a_partir').val('si').trigger('change');
            } else {
              $('#edit_es_creado_a_partir').val('no').trigger('change');
            }

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
                      <input type="text" class="form-control form-control-sm volumen-parcial-edit" name="edit_volumenes[${rowIndex}][volumen_parcial]" id="edit_volumen_parcial_${rowIndex}" value="${volumen}">
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

      // Obtener empresa_destino asignada y cargar select
      let empresaDestinoAsignada = lote.id_empresa_destino ?? null;
      obtenerDestinoEmpresaEdit(empresaDestinoAsignada);

            $('#edit_tipo_lote').val(lote.tipo_lote);
            $('#edit_id_tanque').val(lote.id_tanque);
            $('#edit_agua_entrada').val(lote.agua_entrada);
            $('#edit_id_estado').val(lote.id_estado).trigger('change');

            /* $('#edit_id_estado').val(lote.id_estado).trigger('change'); */
            // Asigna los valores seleccionados (solo IDs)
            var guiasIds = guias.map(function (guia) {
              return guia.id;
            });
            $('#edit_id_guia').val(guiasIds).trigger('change');
            $('#edit_volumen').val(lote.volumen);
            if (window.puedeVerElUsuario && $('#edit_volumen_restante').length > 0) {
              $('#edit_volumen_restante').val(lote.volumen_restante);
            }
            $('#edit_volumen_total').val(lote.volumen_con_agua);
            $('#edit_cont_alc').val(lote.cont_alc);
            $('#edit_id_categoria').val(lote.id_categoria).trigger('change');
            $('#edit_clase_agave').val(lote.id_clase).trigger('change');

            var fqs = data.lote.folio_fq.split(',');
            $('#folio_fq_completo_58').val(fqs[0]);
            $('#folio_fq_ajuste_134').val(fqs[1]);

            var id_tipo = Array.isArray(data.id_tipo) ? data.id_tipo.map(String) : [];

            var $select = $('#edit_tipo_agave');
            $select.empty();
            // 1. Agregar primero los seleccionados en el orden exacto de `id_tipo`
            id_tipo.forEach(function (id) {
              var tipo = tipos.find(t => String(t.id_tipo) === id);
              if (tipo) {
                var option = new Option(`${tipo.nombre} (${tipo.cientifico})`, tipo.id_tipo, true, true);
                $select.append(option);
              }
            });
            // 2. Agregar el resto de tipos que no están seleccionados
            tipos.forEach(function (tipo) {
              if (!id_tipo.includes(String(tipo.id_tipo))) {
                var option = new Option(`${tipo.nombre} (${tipo.cientifico})`, tipo.id_tipo);
                $select.append(option);
              }
            });

            // Mostrar campos condicionales
            if (lote.tipo_lote == '1') {
              $('#edit_oc_cidam_fields').removeClass('d-none');
              $('#edit_otro_organismo_fields').addClass('d-none');
              $('#edit_ingredientes').val(lote.ingredientes);
              $('#edit_edad').val(lote.edad);

              // Mostrar las guías solo si el lote es CIDAM
              $('#edit_mostrar_guias').removeClass('d-none');
              /* $('#edit_volumen_in').removeClass('col-md-12').addClass('col-md-6'); */
              // Añadir guías al campo select de guías
              guias.forEach(function (guia) {
                $('#edit_id_guia').append(new Option(guia.folio, guia.id));
              });
            } else if (lote.tipo_lote == '2') {
              $('#edit_otro_organismo_fields').removeClass('d-none');
              $('#edit_oc_cidam_fields').addClass('d-none');
              $('#edit_folio_certificado').val(lote.folio_certificado);
              $('#edit_organismo_certificacion').val(organismoId).trigger('change');
              $('#edit_fecha_emision').val(lote.fecha_emision);
              $('#edit_fecha_vigencia').val(lote.fecha_vigencia);

              // Ocultar el campo de las guías si es tipo 2
              $('#edit_mostrar_guias').addClass('d-none');
              /* $('#edit_volumen_in').removeClass('col-md-6').addClass('col-md-12'); */
              // Eliminar las opciones de guías si es tipo 2
              $('#edit_id_guia').empty();
              // Mostrar enlace al archivo PDF si está disponible
              // Mostrar enlace al archivo PDF si está disponible
              $('#archivo_url_display_otro_organismo').html('');
              var archivoDisponible = false;
              var documentos = data.documentos;

              documentos.forEach(function (documento) {
                const id = documento.id_documento;

                if (id == 59 && documento.url) {
                  // Solo si id_documento es 59 y tiene URL
                  archivoDisponible = true;
                  var fileName = documento.url.split('/').pop();

                  let botonEliminar = `
                    <button type="button"
                            class="btn btn-danger btn-sm btn-eliminar-doc"
                            data-id="${documento.id}" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        Eliminar documento
                    </button>
                  `;

                  $('#archivo_url_display_otro_organismo').html(
                    'Documento disponible: <a href="../files/' +
                    data.numeroCliente +
                    '/certificados_granel/' +
                    documento.url +
                    '" target="_blank" class="text-primary">' +
                    fileName +
                    '</a>' +
                    '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                    botonEliminar +
                    '</span>'
                  );
                }
              });

              if (!archivoDisponible) {
                $('#archivo_url_display_otro_organismo').html('No hay archivo disponible.');
              }
            } else {
              $('#edit_oc_cidam_fields').addClass('d-none');
              $('#edit_otro_organismo_fields').addClass('d-none');
            }

            var documentos = data.documentos;

            if (Array.isArray(fqs)) {
              // Asignar siempre los valores de los folios, aunque no haya documentos
              if (fqs[0]) {
                $('input[id^="folio_fq_completo_"]').val(fqs[0].split(',')[0]);
              }

              if (fqs[1]) {
                $('input[id^="folio_fq_ajuste_"]').val(fqs[1].split(',')[0]);
              }
            }

            if (documentos && documentos.length > 0) {
              var documentoCompletoUrlAsignado = false;
              var documentoAjusteUrlAsignado = false;

              // Limpiar previamente los mensajes en el modal (ya no limpiamos inputs)
              $('#archivo_url_display_completo_58').html('');
              $('#archivo_url_display_ajuste_134').html('');
              $('#deleteArchivo58').html('');
              $('#deleteArchivo134').html('');

              documentos.forEach(function (documento) {
                const id = documento.id_documento;
                const fileName = documento.url.split('/').pop();
                const fileUrl = '../files/' + data.numeroCliente + '/fqs/' + documento.url;

                let botonEliminar = `

                    <button type="button"
                            class="btn btn-danger btn-sm btn-eliminar-doc"
                            data-id="${documento.id}" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        Eliminar documento
                    </button>

                `;
                if (id == 58) {
                  $('#archivo_url_display_completo_58').html(
                    `Documento completo disponible: <a href="${fileUrl}" target="_blank" class="text-primary">${fileName}</a>`
                  );
                  $('#deleteArchivo58').html(`${botonEliminar}`);

                  documentoCompletoUrlAsignado = true;
                }
                if (id == 134) {
                  $('#archivo_url_display_ajuste_134').html(
                    `Documento ajuste disponible: <a href="${fileUrl}" target="_blank" class="text-primary">${fileName}</a>`
                  );
                  $('#deleteArchivo134').html(`${botonEliminar}`);
                  documentoAjusteUrlAsignado = true;
                }
              });

              // Mostrar mensajes si no se asignó alguno
              if (!documentoCompletoUrlAsignado) {
                $('#archivo_url_display_completo_58').html('No hay archivo completo disponible.');
                $('#deleteArchivo58').html('');
              }
              if (!documentoAjusteUrlAsignado) {
                $('#archivo_url_display_ajuste_134').html('No hay archivo de ajuste disponible.');
                $('#deleteArchivo134').html('');
              }
            } else {
              console.log('No hay documentos disponibles.');
              $('td[id^="archivo_url_display_"]').html('No hay documentos disponibles.');
              $('#deleteArchivo58').html('');
              $('#deleteArchivo134').html('');
            }

            /* aqui termina lo de mostar rutas */

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
          obtenerLotesEdit();
        }
      } else {
        $('#editLotesGranel').addClass('d-none');
        $('#contenidoGranelesEdit').empty();
        rowIndex = 0;
      }
    });

    $('.add-row-lotes-edit').click(function () {
      agregarFilaLotesEdit();
      obtenerLotesEdit();
    });

    // Función para agregar una nueva fila en la tabla de lotes de edición
    function agregarFilaLotesEdit() {
      // Inicializa el índice solo si es necesario
      /* inicializarRowIndex(); */ // Asegúrate de que el índice se calcule bien

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
      /* cargarLotesEnSelectEdit();
      initializeSelect2($(`#edit_id_lote_granel_${rowIndex}`)); */
      const selectId = `edit_id_lote_granel_${rowIndex}`;
      cargarLotesEnSelectEdit(selectId);
      initializeSelect2($(`#${selectId}`));

      // Incrementar rowIndex después de agregar la fila
      rowIndex++; // Incrementar el índice después de agregar la fila
    }

    // Recalcula todos los índices de las filas para evitar duplicados
    function recalcularIndices() {
      rowIndex = 0; // Reasignamos el índice global
      $('#contenidoGranelesEdit')
        .find('tr')
        .each(function () {
          // Actualizamos el índice en cada fila
          $(this)
            .find('select')
            .attr('name', `edit_lotes[${rowIndex}][id]`)
            .attr('id', `edit_id_lote_granel_${rowIndex}`);
          $(this)
            .find('input')
            .attr('name', `edit_volumenes[${rowIndex}][volumen_parcial]`)
            .attr('id', `edit_volumen_parcial_${rowIndex}`);
          rowIndex++; // Incrementamos el índice
        });
    }

    // Eliminar una fila de lotes en modo edición y actualizar los índices
    $(document).on('click', '.remove-row-lotes-edit', function () {
      $(this).closest('tr').remove();
      recalcularIndices(); // Llamada para recalcular los índices
      if ($('#contenidoGranelesEdit').children('tr').length <= 1) {
        $('.remove-row-lotes-edit').attr('disabled', true);
      }
    });

    // Cargar lotes en los selects dentro de filas en modo edición
    // Cargar lotes en los selects dentro de filas en modo edición
    /*  function cargarLotesEnSelectEdit() {
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
     } */
    function cargarLotesEnSelectEdit(idSelect) {
      const $select = $(`#${idSelect}`);
      const valorSeleccionado = $select.val();

      $select.empty();

      if (lotesDisponiblesEdit.length > 0) {
        $select.append('<option value="">Seleccione un lote</option>');
        lotesDisponiblesEdit.forEach(function (lote) {
          $select.append(`<option value="${lote.id_lote_granel}">${lote.nombre_lote}</option>`);
        });
        if (valorSeleccionado) {
          $select.val(valorSeleccionado);
        }
      } else {
        $select.append('<option value="" disabled selected>Sin lotes registrados</option>');
      }
    }

    $(document).on('input', '.volumen-parcial-edit', function () {/* #edit_agua_entrada */
      actualizarVolumenTotalEdit();
    });


   /*  function actualizarVolumenTotalEdit() {
      let total = 0;

      $('.volumen-parcial-edit').each(function () {
        const val = parseFloat($(this).val());
        if (!isNaN(val)) {
          total += val;
        }
      });

      $('#edit_volumen').val(total.toFixed(2)); // Reemplaza con el ID correcto del campo total
    } */

      function actualizarVolumenTotalEdit() {
        let total = 0;

        // Sumar todos los volúmenes parciales
        $('.volumen-parcial-edit').each(function () {
          const val = parseFloat($(this).val()) || 0;
          total += val;
        });

        // Actualizar el campo de volumen total
        $('#edit_volumen').val(total.toFixed(2)); // ID del total en el formulario de edición
      }

/*       function actualizarVolumenTotalEdit() {
        let total = 0;

        // Sumar todos los volúmenes parciales
        $('.volumen-parcial-edit').each(function () {
          const val = parseFloat($(this).val()) || 0;
          total += val;
        });

        // Sumar el agua de entrada si existe
        const aguaEntrada = parseFloat($('#edit_agua_entrada').val()) || 0;
        total += aguaEntrada;

        // Actualizar el campo de volumen total
        $('#edit_volumen').val(total.toFixed(2)); // ID del total en el formulario de edición
      }
 */


// Detecta cambio de empresa en edición
$('#edit_id_empresa').on('change', function() {
    obtenerDestinoEmpresaEdit();
});
// Función para obtener destinos de la empresa en edición
async function obtenerDestinoEmpresaEdit(selectedDestino = null) {
    let empresaId = $("#edit_id_empresa").val();
    if (!empresaId) return;

    try {
        const response = await $.get('/getDatosMaquila/' + empresaId);
        let $selectDestino = $('#edit_id_empresa_destino');
        $selectDestino.empty();

        // Obtener texto de la empresa seleccionada
        let empresaSeleccionadaText = $("#edit_id_empresa option:selected").text();
        let numeroCliente = empresaSeleccionadaText.split('|')[0]?.trim() ?? '';
        let razonSocial = empresaSeleccionadaText.split('|')[1]?.trim() ?? '';

        if (response.empresasDestino.length > 1) {
            // Tiene maquiladores: mostrar todos los destinos y habilitar select
            response.empresasDestino.forEach(emp => {
                let numeroClienteDestino = emp.empresa_num_clientes[0]?.numero_cliente
                                            ?? emp.empresa_num_clientes[1]?.numero_cliente
                                            ?? '';
                let selected = selectedDestino == emp.id_empresa ? 'selected' : '';
                $selectDestino.append(`<option value="${emp.id_empresa}" ${selected}>${numeroClienteDestino} | ${emp.razon_social}</option>`);
            });
            $selectDestino.prop('disabled', false);
        } else {
            // No tiene maquiladores: mostrar propia empresa visualmente y deshabilitar
            $selectDestino.append(`<option value="${empresaId}" selected>${numeroCliente} | ${razonSocial}</option>`);
            $selectDestino.prop('disabled', true);
        }

    } catch (error) {
        console.error('Error al cargar maquiladora:', error);
        alert('Error al cargar los datos. Por favor, intenta nuevamente.');
    }
}
///FORMULARIO EDITAR
const editLoteForm = document.getElementById('loteFormEdit');
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
        id_estado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el origen'
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
        }
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
      $('#btnEdit').addClass('d-none'); // Ocultar el botón de envío
      $('#btnSpinnerEdit').removeClass('d-none'); // Mostrar el spinner de carga
      var formData = new FormData(editLoteForm);
      var loteId = $('#edit_lote_id').val();
  ///ACTUALIZAR LOTE
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
          $('#edit_certificado_lote').val('');
          $('input[type="file"][name="url[]"]').val('');
          $('#btnSpinnerEdit').addClass('d-none'); // Ocultar el spinner de carga
          $('#btnEdit').removeClass('d-none'); // Mostrar el botón de envío
          dt_user.ajax.reload(null, false);
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
            var errorMessages = Object.keys(errors)
              .map(function (key) {
                return errors[key].join('<br>');
              })
              .join('<br>');

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
          $('#btnSpinnerEdit').addClass('d-none'); // Ocultar el spinner de carga
          $('#btnEdit').removeClass('d-none'); // Mostrar el botón de envío
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

});///fin funcion actualizar


  // Mover el último seleccionado al final visualmente
  $('#tipo_agave').on('select2:select', function (e) {
    const selectedElement = $(e.params.data.element);
    selectedElement.detach();
    $(this).append(selectedElement).trigger('change.select2');
  });

  $('#edit_tipo_agave').on('select2:select', function (e) {
    const selectedElement = $(e.params.data.element);
    selectedElement.detach();
    $(this).append(selectedElement).trigger('change.select2');
  });



///ELIMINAR LOTE
  $(document).on('click', '.btn-eliminar-doc', function () {
    var idDocumento = $(this).data('id');
    var dtrModal = $('.dtr-bs-modal.show');

    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    Swal.fire({
      title: '¿Está seguro?',
      text: 'Este documento será eliminado y no podrá recuperarse.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
      customClass: {
        confirmButton: 'btn btn-danger me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST', // o DELETE si defines la ruta así
          url: `${baseUrl}eliminar_documento`, // ajusta esta URL a tu ruta
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: idDocumento
          },
          success: function (response) {
            if (response.success) {
              $('#edit_certificado_lote').val('');
              $('input[type="file"][name="url[]"]').val('');
              dt_user.ajax.reload(null, false);
              $('#offcanvasEditLote').modal('hide');
              Swal.fire({
                icon: 'success',
                title: '¡Eliminado!',
                text: 'El documento ha sido eliminado correctamente.',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo eliminar el documento.',
                customClass: {
                  confirmButton: 'btn btn-danger'
                }
              });
            }
          },
          error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Ocurrió un error en el servidor.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La eliminación del documento ha sido cancelada.',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    });
  });





  $(document).ready(function () {
    // Al abrir el modal, cargar marcas para el cliente seleccionado
    $('#offcanvasAddLote').on('shown.bs.modal', function () {
      obtenerDatosEmpresa();
    });
        // Llamar a obtenerDatosEmpresa cuando se selecciona la empresa
    /* $('#id_empresa').change(function() { */
/*       var empresa = $("#id_empresa").val();
      if (!empresa) return;
        obtenerDestinoEmpresa(); */
   /*  }); */


  });



});
