
//-------------------MODAL AGREGAR SOLICITUDES-------------------
document.addEventListener('DOMContentLoaded', function () {
    const tabs = {
        'tab-mezcal': 'mezcal',
        'tab-alcoholicas': 'alcoholicas',
        'tab-no-alcoholicas': 'no-alcoholicas'
    };

// Función Icono por ID
function obtenerIcono(id_tipo) {
    const id_tipoStr = id_tipo.toString();
   // console.log('ID recibido:', id_tipoStr);
    switch (id_tipoStr) {
        case '1':
            return 'assets/img/solicitudes/muestreoDeAgave.png';
        case '2':
            return 'assets/img/solicitudes/Vigilancia en la producción de lote.png';
        case '3':
            return 'assets/img/solicitudes/muestreo de lote a granel.png';
        case '4':
            return 'assets/img/solicitudes/Vigilancia en el transaldo.png';
        case '5':
            return 'assets/img/solicitudes/inspección de envasado.png';
        case '6':
            return 'assets/img/solicitudes/muestreo de lote envasado.png';
        default:
            return 'assets/img/icons/brands/reddit-rounded.png';
    }
}

    function cargarCards(tipo) {
        fetch(`${obtenerSolicitudesTiposUrl}?tipo=${tipo}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Red no disponible');
                }
                return response.json();
            })
            .then(data => {
                const contentContainerId = Object.keys(tabs).find(key => tabs[key] === tipo) + '-content';
                const contentContainer = document.getElementById(contentContainerId);
                contentContainer.innerHTML = '';

                var solicitudesMap = {
                    1: "#ModalAddSoli052VigilanciaProduccion",
                    2: "#ModalAddSoli052TomaMuestra",
                    3: "#ModalAddSoli052LiberacionProducto",
                    4: "#ModalAddSoli052EmisionCertificadoBebida",
                    5: "#ModalAddSoli052DictaminacionInstalacion",
                    6: "#ModalAddSoli052EmisionCertificadoInstalacion",
                };


                if (Array.isArray(data) && data.length > 0) {
                    data.forEach((item, index) => {
                        const solicitud = solicitudesMap[item.id_tipo] || "#defaultSolicitud";
                        const icono = obtenerIcono(item.id_tipo);
                        //console.log('Ícono asignado:', icono);

                        // Crear la tarjeta
                        const card = document.createElement('div');
                        card.className = 'col-sm-12 col-md-6 col-lg-4 col-xl-3';
                        card.innerHTML = `
                            <div data-bs-target="${solicitud}" data-bs-toggle="modal" data-bs-dismiss="modal" class="card card-hover shadow-sm border-light">
                                <div class="card-body text-center d-flex flex-column align-items-center">
                                    <img src="${icono}" alt="Icono" class="img-fluid mb-3" style="max-width: 80px;"/>
                                    <h5 class="card-title mb-4">${item.tipo || 'Tipo no disponible'}</h5>
                                </div>
                            </div>
                        `;

                        // Agregar la tarjeta al contenedor
                        contentContainer.appendChild(card);

                        // Agregar un "salto de línea" después de las primeras dos tarjetas
                        if (index === 1) { // Después de la segunda tarjeta
                            const clearfix = document.createElement('div');
                            clearfix.className = 'w-100 d-md-none'; // w-100 rompe la fila, d-md-none lo oculta en pantallas medianas y más grandes
                            contentContainer.appendChild(clearfix);
                        }
                    });

                } else {
                    contentContainer.innerHTML = '<p>No se encontraron datos.</p>';
                }
            })
            .catch(error => {
                console.error('Error al obtener los datos:', error);
                const contentContainerId = Object.keys(tabs).find(key => tabs[key] === tipo) + '-content';
                document.getElementById(contentContainerId).innerHTML = '<p class="text-danger">No se pudo cargar la información.</p>';
            });
    }

    // Cargar datos para la pestaña activa por defecto
    cargarCards('mezcal');

    document.querySelectorAll('#myTab a[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', (event) => {
            const tipo = tabs[event.target.id];
            cargarCards(tipo);
        });
    });


    // Escuchar el clic en el botón de cancelar
$(".btnCancelar").on('click', function () {
    // Obtener el modal actual desde el botón que se hizo clic
    const modal = $(this).closest('.modal');

    // Ocultar el modal actual
    modal.modal('hide');

    // Mostrar el modal anterior (ajusta si usas varios niveles)
    $("#verSolicitudes").modal('show');
});


});




//-------------------FUNCIONES SOLICITUDES-------------------

$(function () {
  // Definir la URL base
  //var baseUrl = window.location.origin + '/';

  // Verificamos el permiso del boton DataTable
  let botonesPermiso = [];
  if (puedeAgregarSolicitud) {
    botonesPermiso.push({
      text: '<i class="ri-add-line ri-16px me-0 me-md-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nueva solicitud</span>',
        className: 'add-new btn btn-primary waves-effect waves-light me-2 mb-2 mb-sm-2 mt-4  mt-md-0',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#verSolicitudes'
        }
    });
  }


  const ahora = new Date();
  // 1. Declarar primero los filtros
  const filtros = [
    'Vigilancia en proceso de producción (familia)',
    'Toma de muestra',
    'Liberación de producto terminado',
    'Emisión de certificado de cumplimiento de la bebida',
    'Dictaminación de instalaciones',
    'Renovación de dictaminación de instalaciones',
    'Emisión de certificado de cumplimiento de instalaciones',
  ];

  // 2. Generar los botones dinámicamente
  const filtroButtons = filtros.map(filtro => ({
    text: filtro,
    className: 'dropdown-item',
    action: function (e, dt, node, config) {
      dt_instalaciones_table.search(filtro).draw();
      $('.dt-button-collection').hide(); // Ocultar el dropdown al seleccionar
    }
  }));
  filtroButtons.unshift({
    text: '<i class="ri-close-line text-danger me-2"></i>Quitar filtro',
    className: 'dropdown-item text-danger fw-semibold border',
    action: function (e, dt, node, config) {
      dt_instalaciones_table.search('').draw();
      $('.dt-button-collection').hide(); // Ocultar dropdown también
    }
  });



  //FUNCION FECHAS
  $(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es'
    });
  });
  /*$(document).ready(function () {
    flatpickr(".flatpickr-datetime", {
        dateFormat: "Y-m-d", // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
        enableTime: false,   // Desactiva la  hora
        allowInput: true,    // Permite al usuario escribir la fecha manualmente
        locale: "es",        // idioma a español
    });
  });*/
  //Date picker
  $(document).ready(function () {
    const flatpickrDateTime = document.querySelectorAll('.flatpickr-datetime');

    if (flatpickrDateTime.length) {
      flatpickrDateTime.forEach(element => {
        // Inicializar flatpickr para cada input
        flatpickr(element, {
          enableTime: true, // Habilitar selección de tiempo
          time_24hr: true, // Mostrar tiempo en formato 24 horas
          dateFormat: 'Y-m-d H:i',
          locale: 'es',
          allowInput: true
        });
      });
    }
  });


//Función para inicializar Select2
function initializeSelect2($elements) {
  $elements.each(function () {
    var $this = $(this);
    select2Focus($this);
    $this.wrap('<div class="position-relative"></div>').select2({
      dropdownParent: $this.parent()
    });
  });
}
initializeSelect2($('.select2'));

// ajax setup
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


//FUNCIONALIDAD DE LA VISTA datatable
var dt_instalaciones_table = $('.datatables-solicitudes052').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '/solicitudes052-list',
    },
    columns: [
      { data: '' },
      { data: 'fake_id' },
      {
        //data: 'folio',
        render: function (data, type, full, meta) {
          var $folio = full['folio'];
          var $id = full['id_solicitud'];
          return `<span style="font-weight: bold; font-size: 1.1em;">${$folio}</span>
            <i data-id="${$id}" data-folio="${$folio}" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfSolicitud" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>
          `;
        }
      },
      { data: 'num_servicio' },
      {
        render: function (data, type, full, meta) {
          var $numero_cliente = full['numero_cliente'];
          var $razon_social = full['razon_social'];
          return `
            <div>
              <span  style="font-size:12px;" class="fw-bold">${$numero_cliente}</span><br>
              <small style="font-size:11px;" class="user-email">${$razon_social}</small>
            </div>
          `;
        }
      },
      { data: 'fecha_solicitud' },
      {
        data: 'tipo',
        render: function (data) {
          return `<span class="fw-bold">${data}</span>`;
        }
      },
      {
        data: 'direccion_completa',
        render: function (data, type, row) {
          return `<span style="font-size: 12px;">${data}</span>`; // Tamaño en línea
        }
      },
      { data: 'fecha_visita' },
      { data: 'inspector' },
      {///caracteristicas
         data: null 
        /*data: null,
        render: function (data) {
          switch (data.id_tipo) {
            case 1: //Muestreo de agave
              return `
            <br>
            <span class="fw-bold small">Guías de agave:</span>
            <span class="small"> ${data.guias || 'N/A'}</span>
          `;

            case 2: //Vigilancia en producción de lote
              return `<br><span class="fw-bold small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold small">Nombre del predio:</span><span class="small"> ${data.nombre_predio || 'N/A'}</span>
                      <br>
                      <span class="fw-bold small">Art:</span><span class="small"> ${data.art || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Etapa:</span><span class="small"> ${data.etapa || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha de Corte:</span>
                      <span class="small">${data.fecha_corte || 'N/A'}</span>
                      `;
            case 3:
              return `<br><span class="fw-bold  small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small">${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Certificado de lote:</span><span class="small"> ${data.id_certificado_muestreo || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">%Alc. Vol:</span><span class="small"> ${data.cont_alc || 'N/A'}</span>
                      `;
            case 4:
              return `<br><span class="fw-bold  small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.id_tipo_maguey_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Volumen actual:</span><span class="small"> ${data.id_vol_actual || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Volumen restante:</span><span class="small"> ${data.id_vol_res || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis_traslado || 'N/A'}</span>
                      `;
            case 5:
              return `<br><span class="fw-bold  small">Envasado:</span><span class="small"> ${data.id_lote_envasado || 'N/A'}</span>
                      <br><span class="fw-bold  small">Información adicional:</span><span class="small"> ${data.info_adicional || 'N/A'}</span>`;
            
            case 6:
              return `<br><span class="fw-bold small">Punto de reunión:</span><span class="small"> ${data.punto_reunion || 'N/A'}</span>
                      <br>
                      <span class="fw-bold small">Información adicional:</span><span class="small"> ${data.info_adicional || 'N/A'}</span>`;
            
            default:
              return `<br><span class="fw-bold text-dark small">Información no disponible</span>`;
          }
        }
        */
      },
      { data: 'fecha_servicio' },
      { data: 'estatus',
        render: function (data, type, row) {
          // ACTA
          const acta = row.url_acta;
          const cliente = row.numero_cliente;
          let html = '';
          if (acta && acta !== 'Sin subir') {
            html += `<a href="/files/${cliente}/actas/${acta}" class="text-success" target="_blank"><u>Ver acta</u></a>`;
          } else {
            html += '<span class="badge bg-danger me-1">Sin acta</span>';
          }

          return `<span class="badge bg-warning mb-1">${data}</span><br>`
            + html;
        }
      },

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
        targets: 1,
        searchable: false,
        orderable: false
      },
      {
        targets: 2,
        searchable: false,
        orderable: false
      },
      {
        targets: 3,
        responsivePriority: 4,
        orderable: false
      },
      {
        targets: 4,
        searchable: false,
        orderable: false
      },
      {
        targets: 5,
        searchable: false,
        orderable: false
      },
      {
        //inspector asignado
        targets: 9,
        render: function (data, type, full, meta) {
          var $name = full['inspector'];
          var foto_inspector = full['foto_inspector'];

          // For Avatar badge

          var $output;
          if (foto_inspector != '') {
            $output =
              '<div class="avatar-wrapper"><div class="avatar avatar-sm me-3"> <div class="avatar "><img src="storage/' +
              foto_inspector +
              '" alt class="rounded-circle"></div></div></div>';
          } else {
            $output = '';
          }

          // Creates full output for row
          var $row_output =
            '<div class="d-flex justify-content-start align-items-center user-name">' +
            $output +
            '<div class="d-flex flex-column">' +
            '<a href="#" class="text-truncate text-heading"><span style="font-size: 12px;" class="fw-medium">' +
            $name +
            '</span></a>' +
            '</div>' +
            '</div>';
          return $row_output;
        }
      },
      {//caracteristicas
        targets: 10,
        searchable: false,
        orderable: false
      },
      {///columna 'estatus'
        targets: 13,
        orderable: false,
        searchable: false
      },
      {
        // Acciones
        targets: -1,
        title: 'Acciones',
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
          
          let dropdown = `
                <div class="d-flex align-items-center gap-50">
                  <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end m-0">`;
          

      const fechaString = full['fecha_inspeccion']; // "2025-07-24 10:00:00"

      // Separar fecha y hora
      const [fecha, hora] = fechaString.split(" ");
      const [anio, mes, dia] = fecha.split("-").map(Number);

      // Creamos la fecha en local (los meses van de 0-11)
      const fechaInspeccion = new Date(anio, mes - 1, dia);

      // Normalizamos al inicio del día
      fechaInspeccion.setHours(0, 0, 0, 0);
      ahora.setHours(0, 0, 0, 0);
      // Diferencia en días
      const diffDias = (ahora - fechaInspeccion) / (1000 * 60 * 60 * 24);


        //if (puedeEditarSolicitud && diffDias <= 1) {
        if(puedeEditarSolicitud) {
            dropdown += `
                  <a
                    data-id="${full['id']}"
                    data-id-solicitud="${full['id_solicitud']}"
                    data-tipo="${full['tipo']}"
                    data-id-tipo="${full['id_tipo']}"
                    data-razon-social="${full['razon_social']}"
                    class="cursor-pointer dropdown-item text-dark editar">
                    <i class="text-warning ri-edit-fill"></i> Editar
                  </a>`;
          }
          if (puedeEliminarSolicitud) {
            dropdown += `<a data-id="${full['id']}" data-id-solicitud="${full['id_solicitud']}"
              class="dropdown-item text-danger cursor-pointer eliminar">
              <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>`;
          }

          dropdown +=
            `</div>
                </div>`;

          return dropdown;
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
      //emptyTable: 'No hay solicitudes disponibles', //agregado
      paginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior'
      }
    },

    buttons: botonesPermiso,
    /*buttons: [
      {
        text: '<i class="ri-add-line ri-16px me-0 me-md-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nueva solicitud</span>',
        className: 'add-new btn btn-primary waves-effect waves-light me-2 mb-2 mb-sm-2 mt-4  mt-md-0',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#verSolicitudes'
        }
      }
    ],*/

    ///PAGINA RESPONSIVA
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



//ELIMINAR SOLICITUDES
$(document).on('click', '.eliminar', function () {
    var id_solicitudes = $(this).data('id-solicitud');
    console.log(id_solicitudes);
    $('.modal').modal('hide');

    // Confirmación con SweetAlert
    Swal.fire({
      title: '¿Está seguro?',
      //text: 'No podrá revertir este evento',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      html: `
        <label for="delete-reason" style="margin-bottom: 5px;">Escriba el motivo de la eliminación:</label>
        <input id="delete-reason" class="swal2-input" placeholder="Escriba el motivo de la eliminación" required>
      `,
      preConfirm: () => {
        const reason = Swal.getPopup().querySelector('#delete-reason').value;
        if (!reason) {
          Swal.showValidationMessage('Debe proporcionar un motivo para eliminar');
          return false;
        }
        return reason; // Devuelve el motivo si es válido
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.isConfirmed) {
        const reason = result.value; // El motivo ingresado por el usuario
        // Solicitud de eliminación
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}solicitudes052/${id_solicitudes}`, // Ajusta la URL aquí
          data: { reason: reason }, // Envía el motivo al servidor si es necesario
          success: function () {
            dt_instalaciones_table.ajax.reload();
            // Mostrar mensaje de éxito
            Swal.fire({
              icon: 'success',
              title: '¡Eliminado!',
              text: '¡La solicitud ha sido eliminada correctamente!',
              customClass: {
                confirmButton: 'btn btn-primary'
              }
            });
          },
          error: function(xhr) {
            // Solo mostrar en consola si es desarrollo
            const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);
            if (isDev) console.log('Error al eliminar:', xhr);

            let errorJSON = xhr.responseJSON?.message || "Hubo un problema al eliminar el registro.";
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: errorJSON,
                customClass: { confirmButton: 'btn btn-danger' }
            });
          }
        });
        
      } else if (result.dismiss === Swal.DismissReason.cancel) {//cancelar operacion
        Swal.fire({
          title: '¡Cancelado!',
          text: 'La solicitud no ha sido eliminada',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    });
});



///FORMATO PDF SOLICITUD SERVICIOS
$(document).on('click', '.pdfSolicitud', function () {
    var id = $(this).data('id');
    var folio = $(this).data('folio');
    var pdfUrl = '/solicitud_de_servicio/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();

    $("#titulo_modal").text("Solicitud de servicios NOM-070-SCFI-2016");
    $("#subtitulo_modal").html('<p class="solicitud badge bg-primary">' + folio + '</p>');
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
});



///REGISTRAR SOLICITUD vigilancia en produccion
// Validación del formulario Vigilancia en produccion
const FormAddSoli052VigilanciaProduccion = document.getElementById('FormAddSoli052VigilanciaProduccion');
const fv5 = FormValidation.formValidation(FormAddSoli052VigilanciaProduccion, {
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
    }
  },
  plugins: {
    trigger: new FormValidation.plugins.Trigger(),
    bootstrap5: new FormValidation.plugins.Bootstrap5({
      eleValidClass: '',
      eleInvalidClass: 'is-invalid',
      rowSelector: '.form-floating'//clases del formulario
    }),
    submitButton: new FormValidation.plugins.SubmitButton(),
    autoFocus: new FormValidation.plugins.AutoFocus()
  }
}).on('core.form.valid', function () {
  var formData = new FormData(FormAddSoli052VigilanciaProduccion);

  $('#btnRegisVigiPro').addClass('d-none');
  $('#btnSpinnerVigilanciaProduccion').removeClass('d-none');
  
  $.ajax({
    url: '/solicitudes052/vigilancia-produccion/add',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      $('#btnRegisVigiPro').removeClass('d-none');
      $('#btnSpinnerVigilanciaProduccion').addClass('d-none');
      $('#ModalAddSoli052VigilanciaProduccion').modal('hide');
      FormAddSoli052VigilanciaProduccion.reset();
      $('.select2').val(null).trigger('change');
      //$('.datatables-solicitudes052').DataTable().ajax.reload();
      dt_instalaciones_table.ajax.reload();//Recarga los datos del datatable

      // Mostrar alerta de éxito
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        //text: 'Solicitud vigilancia registrado exitosamente.',
        text: response.message,
        customClass: {
          confirmButton: 'btn btn-primary'
        }
      });
    },
    error: function (xhr) {
      //console.log('Error Completo:', xhr);
      //console.warn('Advertencia:', xhr.responseJSON);
      /*let errorText = JSON.parse(xhr.responseText);
          console.log('Mensaje Text:', errorText.message);*/
    // Para desarrollador: revisar en consola (solo en desarrollo)
    /*if (process.env.NODE_ENV !== 'production') { FORMA 1
        console.log('Error Completo:', xhr);
    }*/
    const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);//FORMA 2
    if (isDev) {
        console.log('Error Completo:', xhr);
    }

      let errorJSON = xhr.responseJSON?.message || "Error al registrar.";
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: errorJSON,
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });

      $('#btnRegisVigiPro').removeClass('d-none');
      $('#btnSpinnerVigilanciaProduccion').addClass('d-none');
    }
  });
});

// Limpiar formulario y validación al cerrar el modal
$('#ModalAddSoli052VigilanciaProduccion').on('hidden.bs.modal', function () {
    FormAddSoli052VigilanciaProduccion.reset();// Resetear campos
    fv5.resetForm(true);// Limpiar validaciones
    $('.select2').val(null).trigger('change');// Limpiar Select2
});



///OBTENER DATOS SOLICITUDES
$(document).on('click', '.editar', function () {
  const id_solicitud = $(this).data('id-solicitud');
  const id_tipo = parseInt($(this).data('id-tipo')); // Convertir a número

    // Cierra cualquier modal u offcanvas visible
    $('.modal').modal('hide');

    // Variables para el modal
    let modal = null;
    if (id_tipo === 1) {
      modal = $('#ModalEditSoli052VigilanciaProduccion');
    } else if (id_tipo === 2) {
      modal = $('#editMuestreoLoteAgranel');
    } else if (id_tipo === 3) {
      modal = $('#editLiberacionProducto');
    } else if (id_tipo === 4) {
      modal = $('#editSolicitudEmisionCertificado');
    } else if (id_tipo === 5) {
      modal = $('#editSolicitudDictamen');
    } else if (id_tipo === 6) {
      modal = $('#');//Pendiente
    } else {
      console.error('Tipo no válido:', id_tipo);
      return; // Salimos si el tipo no es válido
    }

      // Hacemos la solicitud AJAX para obtener los datos
      $.ajax({
        url: `/solicitudes052/${id_solicitud}`, // Ruta única
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            const datos = response.data;// Rellenar campos según el tipo de modal
            //$('.solicitud').text(datos.folio);
            
            //Vigilancia en proceso de producción
            if (id_tipo === 1) {
              modal.find('#edit_id_solicitud_vig').val(id_solicitud);

              modal.find('#id_empresa_vigilancia_edit').val(datos.id_empresa).trigger('change');
              modal.find('#fecha_solicitud_edit').val(datos.fecha_solicitud);
              modal.find('#fecha_visita_vigi_edit').val(datos.fecha_visita);
              modal.find('#id_instalacion_vigi_edit').val(datos.id_instalacion).trigger('change');

              // Características
              const caracteristicas = response.caracteristicas || {};
              modal.find('#nombre_produccion_edit').val(caracteristicas.nombre_produccion || '');
              modal.find('#etapa_proceso_edit').val(caracteristicas.etapa_proceso || '');
              modal.find('#cantidad_pinas_edit').val(caracteristicas.cantidad_pinas || '');

              // Información adicional
              modal.find('#info_adicional_edit').val(datos.info_adicional || '');
              //para documentos subidos
              /*modal.find('.linksGuias').html('');
              if (response.documentos && Array.isArray(response.documentos)) {
                const numeroCliente = response.numero_cliente;

                const guias = response.documentos.filter(doc => doc.id_documento === 71);

                if (guias.length > 0) {
                  guias.forEach(doc => {
                    const url = `/storage/uploads/${numeroCliente}/${doc.url}`;
                    const fileName = doc.url.split('/').pop();

                    // Botón de eliminar con el id del documento
                    const botonEliminar = `
                      <button type="button"
                              class="btn btn-outline-danger btn-sm btn-eliminar-doc"
                              data-id="${doc.id}"
                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                        <i class="ri-delete-bin-line"></i> Eliminar
                      </button>
                    `;
                    
                    const linkHtml = `
                      <div class="d-flex justify-content-end align-items-end mb-1">
                        <a href="${url}" target="_blank" class="me-3">
                          <i class="ri-file-check-fill me-1"></i> ${fileName}
                        </a>
                        ${botonEliminar}
                      </div>
                    `;

                    modal.find('.linksGuias').append(linkHtml);
                  });
                } else {
                  modal.find('.linksGuias').html('<div class="text-muted text-end me-6">Sin guías de traslado</div>');
                }
              } else {
                modal.find('.linksGuias').html('<div class="text-muted text-end me-6">Sin guías de traslado</div>');
              }*/
              
            ///solicitud 
            } else if (id_tipo === 3) {
              modal.find('#edit_id_solicitud_muestreo').val(id_solicitud);
              modal.find('#edit_id_empresa_muestreo').val(response.data.id_empresa).trigger('change');
              modal.find('#fecha_sol_edit_muestreo_lote').val(response.data.fecha_solicitud);
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_muestreo').data('selected', response.data.id_instalacion);

              if (response.caracteristicas && response.caracteristicas.id_lote_granel) {
                modal
                  .find('#edit_id_lote_granel_muestreo')
                  .data('selected', response.caracteristicas.id_lote_granel)
                  .trigger('change');
              } else {
                modal.find('#edit_id_lote_granel_muestreo').val('');
              }
              if (response.caracteristicas && response.caracteristicas.tipo_analisis) {
                modal.find('#edit_destino_lote').val(response.caracteristicas.tipo_analisis).trigger('change');
              } else {
                modal.find('#edit_destino_lote').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_categoria_muestreo) {
                modal.find('#edit_id_categoria_muestreo_id').val(response.caracteristicas.id_categoria_muestreo);
              } else {
                modal.find('#edit_id_categoria_muestreo_id').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_clase_muestreo) {
                modal.find('#edit_id_clase_muestreo_id').val(response.caracteristicas.id_clase_muestreo);
              } else {
                modal.find('#edit_id_clase_muestreo_id').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_tipo_maguey_muestreo) {
                modal.find('#edit_id_tipo_maguey_muestreo_ids').val(response.caracteristicas.id_tipo_maguey_muestreo);
              } else {
                modal.find('#edit_id_tipo_maguey_muestreo_ids').val('');
              }
              if (response.caracteristicas) {
                // Categoría
                modal.find('#edit_id_categoria_muestreo').val(response.caracteristicas.categoria || 'N/A');

                // Clase
                modal.find('#edit_id_clase_muestreo').val(response.caracteristicas.clase || 'N/A');
                // Tipos de Maguey
                modal.find('#edit_id_tipo_maguey_muestreo').val(response.caracteristicas.nombre.join(', ') || 'N/A');
              }
              if (response.caracteristicas && response.caracteristicas.analisis_muestreo) {
                modal.find('#edit_analisis_muestreo').val(response.caracteristicas.analisis_muestreo);
              } else {
                modal.find('#edit_analisis_muestreo').val('');
              }
              if (response.caracteristicas && response.caracteristicas.volumen_muestreo) {
                modal.find('#edit_volumen_muestreo').val(response.caracteristicas.volumen_muestreo);
              } else {
                modal.find('#edit_volumen_muestreo').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_certificado_muestreo) {
                modal.find('#edit_id_certificado_muestreo').val(response.caracteristicas.id_certificado_muestreo);
              } else {
                modal.find('#edit_id_certificado_muestreo').val('');
              }
              modal.find('#edit_info_adicional').val(response.data.info_adicional);

            ///solicitud
            } else if (id_tipo === 8) {
              modal.find('#edit_id_solicitud_liberacion_terminado').val(id_solicitud);
              modal.find('#edit_id_empresa_solicitud_lib_ter').val(response.data.id_empresa).trigger('change');
              modal.find('#sol_LPTN').val(response.data.fecha_solicitud);
              modal.find('#edit_fecha_liberacion_terminado').val(response.data.fecha_visita);
              modal
                .find('#edit_id_instalacion_lib_ter')
                .data('selected', response.data.id_instalacion)
                .trigger('change');

              if (response.caracteristicas) {
                modal
                  .find('#edit_id_lote_envasado_lib_ter')
                  .data('selected', response.caracteristicas.id_lote_envasado || '');
                modal.find('#edit_id_categoria_lib_ter').val(response.caracteristicas.categoria || '');
                modal.find('#edit_id_clase_lib_ter').val(response.caracteristicas.clase || '');
                modal.find('#edit_id_tipo_maguey_lib_ter').val(response.caracteristicas.nombre || '');
                modal.find('#edit_marca_lib_ter').val(response.caracteristicas.marca || '');
                modal.find('#edit_porcentaje_alcohol_lib_ter').val(response.caracteristicas.cont_alc || '');
                modal.find('#edit_analisis_fisiq_lib_ter').val(response.caracteristicas.analisis || '');
                modal.find('#edit_can_botellas_lib_ter').val(response.caracteristicas.cantidad_botellas || '');
                modal.find('#edit_presentacion_lib_ter').val(response.caracteristicas.presentacion || '');
                modal.find('#edit_can_pallets_lib_ter').val(response.caracteristicas.cantidad_pallets || '');
                modal.find('#edit_cajas_por_pallet_lib_ter').val(response.caracteristicas.cajas_por_pallet || '');
                modal.find('#edit_botellas_por_caja_lib_ter').val(response.caracteristicas.botellas_por_caja || '');
                modal
                  .find('#edit_hologramas_utilizados_lib_ter')
                  .val(response.caracteristicas.hologramas_utilizados || '');
                modal.find('#edit_hologramas_mermas_lib_ter').val(response.caracteristicas.hologramas_mermas || '');
                modal
                  .find('#edit_certificado_nom_granel_lib_ter')
                  .val(response.caracteristicas.certificado_nom_granel || '');
              }

              modal.find('#edit_comentarios_lib_ter').val(response.data.info_adicional);

            ///solicitud 
            } else if (id_tipo === 13) {
              modal.find('#id_solicitud_emision_v').val(id_solicitud);
              modal.find('#edit_id_empresa_solicitud_emision_venta').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita_emision_v').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_emision_v').val(response.data.id_instalacion);

              let caracteristicas = {};
              if (typeof response.data.caracteristicas === 'string') {
                try {
                  caracteristicas = JSON.parse(response.data.caracteristicas);
                } catch (e) {
                  console.error('Error al parsear caracteristicas:', e);
                }
              }
              if (caracteristicas.id_dictamen_envasado) {
                modal.find('#edit_id_dictamen_envasado').data('selected', caracteristicas.id_dictamen_envasado || '');
              }
              if (caracteristicas.id_lote_envasado) {
                modal.find('#edit_id_lote_envasado_emision_v').val(caracteristicas.id_lote_envasado || '');
              }
              if (caracteristicas.cantidad_cajas) {
                modal.find('#edit_num_cajas').val(caracteristicas.cantidad_cajas);
              }
              if (caracteristicas.cantidad_botellas) {
                modal.find('#edit_num_botellas').val(caracteristicas.cantidad_botellas);
              }
              if (caracteristicas.cont_alc) {
                modal.find('#edit_cont_alc').val(caracteristicas.cont_alc);
              }

              modal.find('#edit_comentarios_e_venta_n').val(response.data.info_adicional);

            ///solicitud 
            } else if (id_tipo === 14) {
              // Aquí va el tipo correspondiente para tu caso
              // Llenar los campos del modal con los datos de la solicitud
              modal.find('#edit_id_solicitud').val(id_solicitud);
              modal.find('#edit_id_empresa').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_sol_dic_ins').val(response.data.fecha_solicitud);
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion').val(response.data.id_instalacion).trigger('change');
              modal.find('#edit_info_adicional').val(response.data.info_adicional);
              modal.find('#instalacion_id').val(response.data.id_instalacion);
              modal.find('#instalacion_id').val(response.data.id_instalacion);

              // Aquí vamos a manejar las características (clases, categorías, renovacion)
              if (response.caracteristicas) {
                // Llenar las categorías si están presentes
                if (response.caracteristicas.categorias) {
                  modal.find('#edit_categoria_in').val(response.caracteristicas.categorias).trigger('change');
                }
                // Llenar las clases si están presentes
                if (response.caracteristicas.clases) {
                  modal.find('#edit_clases_in').val(response.caracteristicas.clases).trigger('change');
                }
                // Llenar la renovación si está presente
                if (response.caracteristicas.renovacion) {
                  modal.find('#edit_renovacion_in').val(response.caracteristicas.renovacion).trigger('change');
                }
              } else {
                // Si no hay características, vaciar los campos correspondientes
                modal.find('#edit_categoria_in').val([]).trigger('change');
                modal.find('#edit_clases_in').val([]).trigger('change');
                modal.find('#edit_renovacion_in').val('').trigger('change');
              }
            }


            // Mostrar el modal de edición
            modal.modal('show');
        },
        error: function (xhr) {
          const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);//FORMA 2
          if (isDev) {
              console.log('Error Completo:', xhr);
          }

          let errorJSON = xhr.responseJSON?.message || "Error al cargar los datos.";
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: errorJSON,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
        }
    });
});



///EDITAR SOLICITUDES
//Validación del formulario Vigilancia en produccion
const FormEditSoli052VigilanciaProduccion = document.getElementById('FormEditSoli052VigilanciaProduccion');
const fvUpdate = FormValidation.formValidation(FormEditSoli052VigilanciaProduccion, {
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
    var formData = new FormData(FormEditSoli052VigilanciaProduccion);

      $('#btnEditVigiProd').addClass('d-none');
      $('#btnSpinnerEditVigilanciaProduccion').removeClass('d-none');

    // Hacer la solicitud AJAX
    $.ajax({
        url: '/solicitudes052/' + $('#edit_id_solicitud_vig').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#btnSpinnerEditVigilanciaProduccion').addClass('d-none');
          $('#btnEditVigiProd').removeClass('d-none');

          $('#ModalEditSoli052VigilanciaProduccion').modal('hide'); //ocultar modal
          $('#FormEditSoli052VigilanciaProduccion')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          
          // Recarga la tabla manteniendo la página actual
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.message,
            customClass: {
              confirmButton: 'btn btn-primary'
            }
          });
        },
        error: function (xhr) {
          const isDev = ['localhost', '127.0.0.1', '::1'].includes(window.location.hostname);//FORMA 2
          if (isDev) {
              console.log('Error Completo:', xhr);
          }

          let errorJSON = xhr.responseJSON?.message || "Error al actualizar.";
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: errorJSON,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });

          $('#btnSpinnerEditVigilanciaProduccion').addClass('d-none');
          $('#btnEditVigiProd').removeClass('d-none');
        }
    });
});

  

  //metodo update para muestrteo de lote agranel
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editMuestreoLoteAgranelForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
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
              message: 'Por favor seleccione la fecha y hora para la inspección.'
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
        id_lote_granel_muestreo: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        destino_lote: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo.'
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
      $('#btnEditMLote').prop('disabled', true);
      $('#btnEditMLote').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditMLote').prop('disabled', false);
        $('#btnEditMLote').html('<i class="ri-add-line"></i> Editar');
      }, 3000);
      // Hacer la solicitud AJAX
      $.ajax({
        //url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_muestreo').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editMuestreoLoteAgranel').modal('hide'); // Oculta el modal
          $('#editMuestreoLoteAgranelForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);

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
            text: 'Error al actualizar la solicitud de muestreo',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //medoto update para viligancia tarslado
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editVigilanciaTrasladoForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
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
              message: 'Por favor seleccione la fecha y hora para la inspección.'
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
        id_lote_granel_traslado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        id_vol_traslado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen debe ser un número válido.'
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
      $('#btnEditVigiLote').prop('disabled', true);
      $('#btnEditVigiLote').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditVigiLote').prop('disabled', false);
        $('#btnEditVigiLote').html('<i class="ri-add-line"></i> Editar');
      }, 2000);

      // Hacer la solicitud AJAX
      $.ajax({
        //url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_traslado').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editVigilanciaTraslado').modal('hide'); // Oculta el modal
          $('#editVigilanciaTrasladoForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla

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
            text: 'Error al actualizar la vigilancia en el traslado del lote',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //metodo para actualizar inspeccion barricada
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editInspeccionIngresoBarricadaForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
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
              message: 'Por favor seleccione la fecha y hora para la inspección.'
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
        id_lote_granel_barricada: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        volumen_barricada: {
          validators: {
            notEmpty: {
              message: 'por favor ingrese el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen debe ser un número válido.'
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
      $('#btnEditIngresoBarrica').prop('disabled', true);
      $('#btnEditIngresoBarrica').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditIngresoBarrica').prop('disabled', false);
        $('#btnEditIngresoBarrica').html('<i class="ri-add-line"></i> Editar');
      }, 2000);
      // Hacer la solicitud AJAX
      $.ajax({
        //url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_barricada').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editInspeccionIngresoBarricada').modal('hide'); // Oculta el modal
          $('#editInspeccionIngresoBarricadaForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla

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
            text: 'Error al actualizar la inspección ingreso a la barrica/contenedor de vidrio',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //edit inspeccion de envasado
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editInspeccionEnvasadoForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
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
              message: 'Por favor seleccione la fecha y hora para la inspección.'
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
        edit_id_lote_envasado_inspeccion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote envasado.'
            }
          }
        },
        id_cantidad_caja: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la cantidad de cajas.'
            }
          }
        },
        id_inicio_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese inicio de envasado.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'El formato de la fecha debe ser AAAA-MM-DD (ej. 2025-05-30).'
            }
          }
        },
        id_previsto: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el término previsto del envasado.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'El formato de la fecha debe ser AAAA-MM-DD (ej. 2025-05-30).'
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
    }).on('core.form.valid', function () {
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);
      $('#enviarInspec').prop('disabled', true);

      $('#enviarInspec').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#enviarInspec').prop('disabled', false);
        $('#enviarInspec').html('<i class="ri-add-line"></i> Editar');
      }, 2500);
      // Hacer la solicitud AJAX
      $.ajax({
        //url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_inspeccion').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editInspeccionEnvasado').modal('hide'); // Oculta el modal
          $('#editInspeccionEnvasadoForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla

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
    // Inicializar select2 y revalidar el campo cuando cambie
    $('#edit_id_lote_envasado_inspeccion, #edit_id_inicio_envasado, #edit_id_previsto').on('change', function () {
      fvUpdate.revalidateField($(this).attr('name'));
    });
  });

  //add inspeccion de envsasado
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Validación del formulario inpeccion de envasado
    const addInspeccionEnvasadoForm = document.getElementById('addInspeccionEnvasadoForm');
    const fvEnvasado = FormValidation.formValidation(addInspeccionEnvasadoForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora sugerida para la inspección.'
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
        id_lote_envasado_inspeccion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote envasado.'
            }
          }
        },
        id_cantidad_caja: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la cantidad de cajas.'
            }
          }
        },
        id_inicio_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese inicio de envasado.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'El formato de la fecha debe ser AAAA-MM-DD (ej. 2025-05-30).'
            }
          }
        },
        id_previsto: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el término previsto del envasado.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'El formato de la fecha debe ser AAAA-MM-DD (ej. 2025-05-30).'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.mb-4, .mb-5, .mb-6'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      const formData = new FormData(addInspeccionEnvasadoForm);
      $('#btnAddInspEnv').prop('disabled', true);

      $('#btnAddInspEnv').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnAddInspEnv').prop('disabled', false);
        $('#btnAddInspEnv').html('<i class="ri-add-line"></i> Registrar');
      }, 3000);

      $.ajax({
        //url: '/hologramas/storeInspeccionEnvasado', // Cambiar a la ruta correspondiente
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Cerrar modal y reiniciar formulario
          $('#addInspeccionEnvasado').modal('hide');
          $('#addInspeccionEnvasadoForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Inspección de envasado registrada exitosamente.',
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
            text: 'Error al registrar la inspección.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    // Inicializar select2 y revalidar el campo cuando cambie
    $(
      '#id_empresa_inspeccion, #fecha_visita_inspeccion_envasado, #id_lote_envasado_inspeccion, #id_inicio_envasado, #id_previsto, #id_instalacion_inspeccion'
    ).on('change', function () {
      fvEnvasado.revalidateField($(this).attr('name'));
    });
  });

  //metodo para liberacion
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editInspeccionLiberacionForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
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
              message: 'Por favor seleccione la fecha y hora para la inspección.'
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
        id_lote_granel_liberacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        volumen_liberacion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen debe ser un número válido.'
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
      $('#btnEditLiberacion').prop('disabled', true);
      $('#btnEditLiberacion').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditLiberacion').prop('disabled', false);
        $('#btnEditLiberacion').html('<i class="ri-add-line"></i> Editar');
      }, 3000);

      // Hacer la solicitud AJAX
      $.ajax({
        //url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_liberacion').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editInspeccionLiberacion').modal('hide'); // Oculta el modal
          $('#editInspeccionLiberacionForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla

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
            text: 'Error al actualizar la inspección de liberación.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //edit liberacion
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editLiberacionProductoForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
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
              message: 'Por favor seleccione la fecha y hora para la inspección.'
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
        id_lote_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote envasado.'
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
    }).on('core.form.valid', function () {
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);
      $('#btneditlib').prop('disabled', true);

      $('#btneditlib').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      // Hacer la solicitud AJAX
      $.ajax({
        //url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_liberacion_terminado').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editLiberacionProducto').modal('hide'); // Oculta el modal
          $('#btneditlib').prop('disabled', false);
          $('#btneditlib').html('<i class="ri-add-line"></i> Editar');
          $('#editLiberacionProductoForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla
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

  //actualizar muestreo lote
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de muestreo
    const formDictaminacion = document.getElementById('editRegistrarSolicitudMuestreoAgave');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
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
      var formData = new FormData(formDictaminacion);
      $('#btnEditMA').addClass('d-none');
      $('#loading_mu_agv_edit').removeClass('d-none');
      $.ajax({
        //url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_muestr').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editSolicitudMuestreoAgave').modal('hide');
          $('#loading_mu_agv_edit').addClass('d-none');
          $('#btnEditMA').removeClass('d-none');
          $('#editRegistrarSolicitudMuestreoAgave')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);
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
          let mensaje = 'Ocurrió un error inesperado.';

          if (xhr.responseJSON?.message) {
            mensaje = xhr.responseJSON.message;
          }

          // Si Laravel devuelve errores de validación
          if (xhr.responseJSON?.errors) {
            const errores = xhr.responseJSON.errors;
            mensaje = Object.values(errores)
              .map(arr => `• ${arr.join(', ')}`)
              .join('\n');
          }

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: mensaje,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#loading_mu_agv_edit').addClass('d-none');
          $('#btnEditMA').removeClass('d-none');
        }
      });
    });
  });

  //Editar pedidos para exportación
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de muestreo
    const formDictaminacion = document.getElementById('editPedidoExportacionForm');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
      fields: {
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de la visita.'
            }
          }
        },

        id_etiqueta: {
          selector: "input[name='id_etiqueta']",
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una etiqueta.'
            }
          }
        },

        direccion_destinatario: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una dirección del destinatario.'
            }
          }
        },
        aduana_salida: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la aduana de salida.'
            }
          }
        },
        no_pedido: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de pedido.'
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
      $('#btnEditExport').addClass('d-none');
      $('#btnSpinnerPedidosExportacionEdit').removeClass('d-none');
      var formData = new FormData(formDictaminacion);

      // Construir las características como un JSON completo
      const caracteristicas = {
        tipo_solicitud: $('#tipo_solicitud_edit').val(),
        direccion_destinatario: $('#direccion_destinatario_ex_edit').val(),
        aduana_salida: $('[name="aduana_salida"]').val(),
        no_pedido: $('[name="no_pedido"]').val(),
        factura_proforma: $('[name="factura_proforma"]')[0].files[0], // Archivo
        factura_proforma_cont: $('[name="factura_proforma_cont"]')[0].files[0], // Archivo
        detalles: [] // Aquí van las filas de la tabla de características
      };

      // Agregar cada fila de la tabla dinámica al JSON
      $('#tabla-marcas tbody tr').each(function () {
        const row = $(this);
        caracteristicas.detalles.push({
          lote_envasado: row.find('.evasado_export').val(),
          cantidad_botellas: row.find('.cantidad-botellas').val(),
          cantidad_cajas: row.find('.cantidad-cajas').val(),
          presentacion: row.find('.presentacion').val()
        });
      });

      // Añadir el JSON al FormData como string
      formData.append('caracteristicas', JSON.stringify(caracteristicas));

      $.ajax({
        //url: '/actualizar-solicitudes/' + $('#solicitud_id_pedidos').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#btnSpinnerPedidosExportacionEdit').addClass('d-none');
          $('#btnEditExport').removeClass('d-none');
          $('#editPedidoExportacion').modal('hide');
          $('#editPedidoExportacionForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);

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
          let errores = xhr.responseJSON?.errors;
          let mensaje = 'Error al actualizar la solicitud.';

          if (errores) {
            // Extrae el primer error
            let primerCampo = Object.keys(errores)[0];
            mensaje = errores[primerCampo][0]; // Muestra solo el primer mensaje
          }

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: mensaje,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });

          $('#btnSpinnerPedidosExportacionEdit').addClass('d-none');
          $('#btnEditExport').removeClass('d-none');
        }
      });
    });
  });

  // editar emision certificado venta nacional
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de actualización
    const formUpdate = document.getElementById('editEmisionCetificadoVentaNacionalForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        id_dictamen_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un dictamen de envasado.'
            }
          }
        },
        cantidad_botellas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la cantidad de botellas.'
            }
          }
        },
        cantidad_cajas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la cantidad de cajas.'
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
      var formData = new FormData(formUpdate);
      $('#btnEditremi').prop('disabled', true);
      $('#btnEditremi').html('<span class="spinner-border spinner-border-sm me-2"></span> Actualizando...');
      // Hacer la solicitud AJAX
      $.ajax({
        //url: '/actualizar-solicitudes/' + $('#id_solicitud_emision_v').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editSolicitudEmisionCertificado').modal('hide'); // Oculta el modal
          $('#btnEditremi').prop('disabled', false);
          $('#btnEditremi').html('<i class="ri-add-line"></i> Editar');
          $('#editEmisionCetificadoVentaNacionalForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);
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
    // Inicializar FormValidation para la solicitud de dictaminación de instalaciones
    const form = document.getElementById('FormAddSoli052DictaminacionInstalacion');
    const fv = FormValidation.formValidation(form, {
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
              message: 'Por favor seleccione la fecha sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la instalación.'
            }
          }
        },
        renovacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una opción.'
            }
          }
        },
        'clases[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una clase'
            }
          }
        },
        'categorias[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una categoria'
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
      var formData = new FormData(form);
      $('#btnRegistrarDicIns').addClass('d-none');
      $('#loading_dictamen').removeClass('d-none');
      $.ajax({
        //url: '/solicitudes052-list',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#loading_dictamen').addClass('d-none');
          $('#btnRegistrarDicIns').removeClass('d-none');
          $('#ModalAddSoli052DictaminacionInstalacion').modal('hide');
          $('#FormAddSoli052DictaminacionInstalacion')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes052').DataTable().ajax.reload();
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
          let mensaje = 'Ocurrió un error inesperado.';

          if (xhr.responseJSON?.message) {
            mensaje = xhr.responseJSON.message;
          }

          // Si Laravel devuelve errores de validación
          if (xhr.responseJSON?.errors) {
            const errores = xhr.responseJSON.errors;
            mensaje = Object.values(errores)
              .map(arr => `• ${arr.join(', ')}`)
              .join('\n');
          }

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: mensaje,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#loading_dictamen').addClass('d-none');
          $('#btnRegistrarDicIns').removeClass('d-none');
        }
      });
    });
    // Inicializar select2 y manejar eventos de cambio por "name"
    $(
      '#id_empresa_solicitudes, #fechaSoliInstalacion, #id_instalacion_dic, #categoriaDictamenIns, #clasesDicIns, #renovacion'
    ).on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });
  });










  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Validación del formulario Muestreo Lote Agranel
    const FormAddSoli052TomaMuestra = document.getElementById('FormAddSoli052TomaMuestra');
    const fvMuestreo = FormValidation.formValidation(FormAddSoli052TomaMuestra, {
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
              message: 'Por favor ingrese la fecha y hora de la visita.'
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
              message: 'Por favor seleccione un lote a granel.'
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
      const formData = new FormData(FormAddSoli052TomaMuestra);
      $('#btnRegistrMLote').prop('disabled', true);
      $('#btnRegistrMLote').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnRegistrMLote').prop('disabled', false);
        $('#btnRegistrMLote').html('<i class="ri-add-line"></i> Registrar');
      }, 3000);

      $.ajax({
        //url: '/hologramas/storeMuestreoLote', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Cerrar modal y reiniciar formulario
          $('#ModalAddSoli052TomaMuestra').modal('hide');
          $('#FormAddSoli052TomaMuestra')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes052').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud de Muestreo registrado exitosamente.',
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
            text: 'Error al registrar el muestreo.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    $('#id_empresa_muestreo, #fecha_visita_muestreoLo, #id_instalacion_muestreoLo, #id_lote_granel_muestreo').on(
      'change',
      function () {
        fvMuestreo.revalidateField($(this).attr('name'));
      }
    );
  });

  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Validación del formulario Inspección Ingreso Barricada
    const addInspeccionIngresoBarricadaForm = document.getElementById('addInspeccionIngresoBarricadaForm');
    const fvBarricada = FormValidation.formValidation(addInspeccionIngresoBarricadaForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora sugerida para la inspección.'
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
        id_lote_granel_barricada: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        tipo_lote: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo.'
            }
          }
        },
        analisis_barricada: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el análisis fisicoquímico.'
            }
          }
        },
        volumen_barricada: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el porcentaje de alcohol.'
            },
            numeric: {
              message: 'Por favor ingrese un valor numérico válido.'
            }
          }
        },
        fecha_inicio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de inicio.'
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
      const formData = new FormData(addInspeccionIngresoBarricadaForm);
      $('#btnReIngresoBarrica').prop('disabled', true);
      $('#btnReIngresoBarrica').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnReIngresoBarrica').prop('disabled', false);
        $('#btnReIngresoBarrica').html('<i class="ri-add-line"></i> Registrar');
      }, 2000);
      $.ajax({
       // url: '/hologramas/storeInspeccionBarricada', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Cerrar modal y reiniciar formulario
          $('#addInspeccionIngresoBarricada').modal('hide');
          $('#addInspeccionIngresoBarricadaForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes052').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Inspección barricada registrada exitosamente.',
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
            text: 'Error al registrar la inspección.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    $(
      '#id_empresa_barricada, #fecha_visita_ingreso_barrica, #id_instalacion_barricada, #id_lote_granel_barricada, #fecha_inicio_ingreso_barrica'
    ).on('change', function () {
      fvBarricada.revalidateField($(this).attr('name'));
    });
  });

  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Validación del formulario Inspección Liberación Barrica/Contenedor de Vidrio
    const addInspeccionLiberacionForm = document.getElementById('addInspeccionLiberacionForm');
    const fvLiberacion = FormValidation.formValidation(addInspeccionLiberacionForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora sugerida para la inspección.'
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
        id_lote_granel_liberacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        tipo_lote_lib: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo.'
            }
          }
        },
        analisis_liberacion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el análisis fisicoquímico.'
            }
          }
        },
        volumen_liberacion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen.'
            },
            numeric: {
              message: 'Por favor ingrese un valor numérico válido.'
            }
          }
        },
        fecha_inicio_lib: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de inicio.'
            }
          }
        },
        fecha_termino_lib: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de término.'
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
      const formData = new FormData(addInspeccionLiberacionForm);
      $('#btnAddLiberacion').prop('disabled', true);
      $('#btnAddLiberacion').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnAddLiberacion').prop('disabled', false);
        $('#btnAddLiberacion').html('<i class="ri-add-line"></i> Registrar');
      }, 3000);

      $.ajax({
        //url: '/hologramas/storeInspeccionBarricadaLiberacion', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Cerrar modal y reiniciar formulario
          $('#addInspeccionLiberacion').modal('hide');
          $('#addInspeccionLiberacionForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes052').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Inspección de liberacion barricada registrada exitosamente.',
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
            text: 'Error al registrar la inspección.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    $(
      '#id_empresa_liberacion, #fecha_visita_liberacion, #id_instalacion_liberacion, #id_lote_granel_liberacion, #fecha_inicio_libe_inspe, #fecha_termino_libe_inspe'
    ).on('change', function () {
      fvLiberacion.revalidateField($(this).attr('name'));
    });
  });

  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    //Validar vigilancia en traslado
    const addVigilanciaTrasladoForm = document.getElementById('addVigilanciaTrasladoForm');
    const fvVigilancia = FormValidation.formValidation(addVigilanciaTrasladoForm, {
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
              message: 'Por favor ingrese la fecha y hora de la inspección.'
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
        instalacion_vigilancia: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una dirección de destino.'
            }
          }
        },
        id_lote_granel_traslado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        id_vol_traslado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen trasladado debe ser un número válido.',
              thousandsSeparator: '',
              decimalSeparator: '.'
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
      const formData = new FormData(addVigilanciaTrasladoForm);
      $('#btnReVigiLote').prop('disabled', true);
      $('#btnReVigiLote').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnReVigiLote').prop('disabled', false);
        $('#btnReVigiLote').html('<i class="ri-add-line"></i> Registrar');
      }, 3000);
      $.ajax({
        //url: '/hologramas/storeVigilanciaTraslado', // Cambia a la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Cerrar modal y reiniciar formulario
          $('#addVigilanciaTraslado').modal('hide');
          $('#addVigilanciaTrasladoForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes052').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Vigilancia traslado registrada exitosamente.',
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
            text: 'Error al registrar la vigilancia.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    $(
      '#id_empresa_traslado, #fecha_visita_traslado, #id_instalacion_traslado, #instalacion_vigilancia, #id_lote_granel_traslado'
    ).on('change', function () {
      fvVigilancia.revalidateField($(this).attr('name'));
    });
  });


  //envio de emision de certificado de venta nacional
  ///
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Inicializar FormValidation para la solicitud de dictaminación de instalaciones
    const form = document.getElementById('ModalAddSoli052EmisionCertificadoBebida');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        id_dictamen_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un dictamen de envasado.'
            }
          }
        },
        cantidad_botellas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la cantidad de botellas.'
            }
          }
        },
        cantidad_cajas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la cantidad de cajas.'
            }
          }
        },
        cont_alc: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el %Alc. Vol.'
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
      var formData = new FormData(form);
      $('#btnRegistraremi').prop('disabled', true);

      $('#btnRegistraremi').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      $.ajax({
        //url: '/storeEmisionCertificadoVentaNacional', // Cambia a la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#ModalAddSoli052EmisionCertificadoBebida').modal('hide');
          $('#btnRegistraremi').prop('disabled', false);
          $('#btnRegistraremi').html('<i class="ri-add-line"></i> Registrar');
          $('#ModalAddSoli052EmisionCertificadoBebida')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes052').DataTable().ajax.reload();
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
    // Inicializar select2 y manejar eventos de cambio por "name"
    $(
      '#id_empresa_solicitudes, #fechaSoliInstalacion, #id_instalacion_dic, #categoriaDictamenIns, #clasesDicIns, #renovacion'
    ).on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });
  });

  //funcion para solicitud de liberacion producto termiando 
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de dictaminación
    const formDictaminacion = document.getElementById('FormAddSoli052LiberacionProducto');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
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
              message: 'Por favor seleccione la fecha sugerida para la inspección.'
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
        id_lote_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione al menos un lote envasado.'
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
      var formData = new FormData(formDictaminacion);
      $('#btnRegistrarlib').prop('disabled', true);
      $('#btnRegistrarlib').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      $.ajax({
       // url: '/registrar-solicitud-lib-prod-term',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#ModalAddSoli052LiberacionProducto').modal('hide');
          $('#btnRegistrarlib').prop('disabled', false);
          $('#btnRegistrarlib').html('<i class="ri-add-line"></i> Registrar');
          $('#FormAddSoli052LiberacionProducto')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes052').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'La liberación del producto se registró exitosamente.',
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
    $(
      '#id_empresa_solicitud_lib_ter, #fecha_visita_liberacion_produto, #id_instalacion_lib_ter, #id_lote_envasado_lib_ter'
    ).on('change', function () {
      fvDictaminacion.revalidateField($(this).attr('name'));
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

  $(document).on('click', '.pdf2', function () {
    var url = $(this).data('url');
    var registro = $(this).data('registro');
    var id_solicitud = $(this).data('id');
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    //Cargar el PDF con el ID
    iframe.attr('src', 'solicitud_de_servicio/' + id_solicitud);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $('#NewPestana')
      .attr('href', 'solicitud_de_servicio/' + id_solicitud)
      .show();

    $('#titulo_modal').text('Solicitud de servicios NOM-070-SCFI-2016');
    $('#subtitulo_modal').html('<p class="solicitud badge bg-primary">' + registro + '</p>');
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  //seccion para exportacion 
  $(document).ready(function () {
    const $tipoSolicitud = $('#tipo_solicitud');
    const $seccionCombinado = $('#seccionCajasBotellasCombinado');
    const $seccionExportacion = $('#seccionCajasBotellas');
    const $botonesCharacteristics = $('#botones_characteristics');

    $tipoSolicitud.on('change', function () {
      const tipo = $(this).val();

      if (tipo === '2') {
        // Combinado: ocultar inputs originales y activar sección nueva
        $('#cant_botellas_exportac').removeAttr('name');
        $('#cant_cajas_exportac').removeAttr('name');
        $('#presentacion_exportac').removeAttr('name');

        $('#cant_botellas_exportac2').attr('name', 'cantidad_botellas[0]');
        $('#cant_cajas_exportac2').attr('name', 'cantidad_cajas[0]');
        $('#presentacion_exportac2').attr('name', 'presentacion[0]');

        $seccionExportacion.removeClass('d-none');
        $seccionCombinado.addClass('d-none');

        // Mostrar botones para tablas adicionales
        $botonesCharacteristics.removeClass('d-none');
      } else {
        // Otro tipo: regresar a inputs originales
        $('#cant_botellas_exportac2').removeAttr('name');
        $('#cant_cajas_exportac2').removeAttr('name');
        $('#presentacion_exportac2').removeAttr('name');

        $('#cant_botellas_exportac').attr('name', 'cantidad_botellas[0]');
        $('#cant_cajas_exportac').attr('name', 'cantidad_cajas[0]');
        $('#presentacion_exportac').attr('name', 'presentacion[0]');

        $seccionCombinado.removeClass('d-none');
        $seccionExportacion.addClass('d-none');

        // Ocultar botones
        $botonesCharacteristics.addClass('d-none');
      }
    });

    // Ejecutar una vez al cargar (por si ya tiene valor)
    if ($tipoSolicitud.val() === '2') {
      $tipoSolicitud.trigger('change');
    }
  });

  $(document).ready(function () {
    $('#editPedidoExportacion').on('hidden.bs.modal', function () {
      // Elimina todas las tarjetas menos la primera dentro de sections-container2
      $('#sections-container2 .card').not(':first').remove();
      sectionCountEdit = 1;
      let tbody = $('#tablaLotesEdit tbody');
      tbody.empty(); // Limpia los datos anteriores
    });
  });

  $(document).ready(function () {
    var $tipoSolicitudEdit = $('#tipo_solicitud_edit');
    var $botonesCharacteristicsEdit = $('#botones_characteristics_edit');
    var $seccionCombinadoEdit = $('#seccionCajasBotellasCombinadoEdit');
    var $seccionExportacionEdit = $('#seccionCajasBotellasEdit');

    function actualizarSeccionesEdit() {
      if ($tipoSolicitudEdit.val() === '2') {
        // COMBINADO (tipo 2) => mostrar card, ocultar combinado
        $botonesCharacteristicsEdit.removeClass('d-none');
        $seccionExportacionEdit.removeClass('d-none');
        $seccionCombinadoEdit.addClass('d-none');

        // Remover name del combinado
        $('#cantidad_botellas_edit0').removeAttr('name');
        $('#cantidad_cajas_edit0').removeAttr('name');
        $('#presentacion_edit0').removeAttr('name');

        // Agregar name a la sección "card"
        $('#2cantidad_botellas_edit0').attr('name', 'cantidad_botellas[0]');
        $('#2cantidad_cajas_edit0').attr('name', 'cantidad_cajas[0]');
        $('#2presentacion_edit0').attr('name', 'presentacion[0]');
      } else {
        // Otro tipo => mostrar combinado, ocultar card
        $botonesCharacteristicsEdit.addClass('d-none');
        $seccionExportacionEdit.addClass('d-none');
        $seccionCombinadoEdit.removeClass('d-none');

        // Remover name del card
        $('#2cantidad_botellas_edit0').removeAttr('name');
        $('#2cantidad_cajas_edit0').removeAttr('name');
        $('#2presentacion_edit0').removeAttr('name');

        // Agregar name a la sección original
        $('#cantidad_botellas_edit0').attr('name', 'cantidad_botellas[0]');
        $('#cantidad_cajas_edit0').attr('name', 'cantidad_cajas[0]');
        $('#presentacion_edit0').attr('name', 'presentacion[0]');
      }
    }

    // Evento change
    $tipoSolicitudEdit.on('change', actualizarSeccionesEdit);

    // Llamar una vez al cargar por si ya tiene valor
    actualizarSeccionesEdit();
  });

  $(document).ready(function () {
    let sectionCount = 1;

    $('#add-characteristics').click(function () {
      let empresaSeleccionada = $('#id_empresa_solicitud_exportacion').val();
      if (!empresaSeleccionada) {
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'Debe seleccionar un cliente antes de agregar una nueva sección.',
          customClass: { confirmButton: 'btn btn-warning' }
        });
        return;
      }

      var newSection = `
      <div class="card mt-4" id="caracteristicas_Ex${sectionCount}">
                              <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                Características del Producto
                            </div>
        <div class="card-body">
          <div class="row caracteristicas-row">
            <div class="col-md-8">
              <div class="form-floating form-floating-outline mb-4">
                <select  class="select2 form-select evasado_export" onchange="cargarDetallesLoteEnvasadoDinamico(this, ${sectionCount})">
                  <option value="" disabled selected>Selecciona un lote envasado</option>
                </select>
                <label for="lote_envasado">Selecciona el lote envasado</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-4">
                <input type="text" disabled class="form-control" name="lote_granel[${sectionCount}]" id="lote_granel_${sectionCount}" placeholder="Lote a granel">
                <label for="lote_granel">Lote a granel</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
      $('#sections-container').append(newSection);
      cargarLotes(empresaSeleccionada, sectionCount);
      initializeSelect2($('.select2'));
      sectionCount++;
    });

    function cargarLotes(empresaSeleccionada, sectionCount) {
      $.ajax({
        url: '/getDatos/' + empresaSeleccionada,
        method: 'GET',
        success: function (response) {
          var contenidoLotesEnvasado = '<option value="" disabled selected>Selecciona un lote envasado</option>';
          var marcas = response.marcas;
          for (let index = 0; index < response.lotes_envasado.length; index++) {
            var lote = response.lotes_envasado[index];
            var skuLimpio = limpiarSku(lote.sku);
            var marcaEncontrada = marcas.find(marca => marca.id_marca === lote.id_marca);
            var nombreMarca = marcaEncontrada ? marcaEncontrada.marca : 'Sin marca';
            var num_dictamen = lote.dictamen_envasado
              ? lote.dictamen_envasado.num_dictamen
              : 'Sin dictamen de envasado';
            contenidoLotesEnvasado += `<option value="${lote.id_lote_envasado}">${skuLimpio} ${lote.nombre} ${nombreMarca} ${num_dictamen}</option>`;
          }
          if (response.lotes_envasado.length == 0) {
            contenidoLotesEnvasado = '<option value="" disabled selected>Sin lotes envasados registrados</option>';
          }
          $(`#caracteristicas_Ex${sectionCount} .evasado_export`).html(contenidoLotesEnvasado);
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error al cargar los datos',
            text: 'Hubo un problema al intentar cargar los lotes.',
            customClass: { confirmButton: 'btn btn-danger' }
          });
        }
      });
    }

    $('#delete-characteristics').click(function () {
      var totalSections = $('#sections-container .card').length;
      var lastSection = $('#sections-container .card').last();
      if (totalSections > 1) {
        lastSection.remove();
        sectionCount--;
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'No se puede eliminar la sección original.',
          customClass: { confirmButton: 'btn btn-warning' }
        });
      }
    });

    $('#id_empresa_solicitud_exportacion').on('change', function () {
      cargarDatosCliente();

      // Obtener el nuevo valor de empresa
      let empresaSeleccionada = $(this).val();

      // Si no hay valor, no hacer nada
      if (!empresaSeleccionada) return;

      // Recorrer todas las secciones generadas y recargar sus selects
      $('#sections-container .card').each(function (i, card) {
        let sectionIndex = $(card).attr('id').replace('caracteristicas_Ex', '');
        cargarLotes(empresaSeleccionada, sectionIndex);
      });
    });
  });

  



  /*
///????
$(document).on('click', '.btn-eliminar-doc', function () {
    const idDoc = $(this).data('id');

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
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          //url: `/documentos-productor/${idDoc}`, // tu ruta para eliminar
          type: 'POST',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function (res) {
            if (res.success) {
                Swal.fire({
                    title: 'Eliminado',
                    text: res.message,
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    },
                    buttonsStyling: false
                });

                // Refrescar la lista de guías
                $(`button[data-id="${idDoc}"]`).closest('div').remove();
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
      }
       else if (result.dismiss === Swal.DismissReason.cancel) {
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
*/
  /* seccion de editar solicitudes exportacion */
  // ==================== EDITAR ====================
  let sectionCountEdit = 1;

  $('#add-characteristics_edit_1').click(function () {
        let empresaSeleccionada = $('#id_empresa_solicitud_exportacion_edit').val();
        if (!empresaSeleccionada) {
          Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'Debe seleccionar un cliente antes de agregar una nueva sección.',
            customClass: { confirmButton: 'btn btn-warning' }
          });
          return;
        }

        var newSection = `
        <div class="card mt-4" id="caracteristicas_Ex_edit_${sectionCountEdit}">
                                <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                  Características del Producto
                              </div>
          <div class="card-body">
            <div class="row caracteristicas-row">
              <div class="col-md-8">
                <div class="form-floating form-floating-outline mb-4">
                  <select name="lote_envasado_edit[${sectionCountEdit}]" class="select2 form-select evasado_export_edit" onchange="cargarDetallesLoteEnvasadoDinamicoEdit2(this, ${sectionCountEdit})">
                    <option value="" disabled selected>Selecciona un lote envasado</option>
                  </select>
                  <label for="lote_envasado">Selecciona el lote envasado</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating form-floating-outline mb-4">
                  <input type="text" disabled class="form-control" name="lote_granel_edit[${sectionCountEdit}]" id="lote_granel_edit_${sectionCountEdit}" placeholder="Lote a granel">
                  <label for="lote_granel">Lote a granel</label>
                </div>
              </div>



            </div>
          </div>
        </div>
      `;
        $('#sections-container2').append(newSection);
        cargarLotesEdit2(empresaSeleccionada, sectionCountEdit);
        initializeSelect2($('.select2'));
        sectionCountEdit++;
      }); 



  $(document).ready(function () {
    $('#add-characteristics_edit').click(function () {
      let empresaSeleccionada = $('#id_empresa_solicitud_exportacion_edit').val();
      if (!empresaSeleccionada) {
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'Debe seleccionar un cliente antes de agregar una nueva sección.',
          customClass: { confirmButton: 'btn btn-warning' }
        });
        return;
      }

      var newSection = `
      <div class="card mt-4" id="caracteristicas_Ex_edit_${sectionCountEdit}" >
                                 <div class="badge rounded-2 bg-label-primary  fw-bold fs-6 px-4 py-4 mb-5">
                                Características del Producto
                            </div>
        <div class="card-body">
          <div class="row caracteristicas-row">
            <div class="col-md-8">
              <div class="form-floating form-floating-outline mb-4">
                <select class="select2 form-select evasado_export_edit" onchange="cargarDetallesLoteEnvasadoDinamicoEdit(this, ${sectionCountEdit})">
                  <option value="" disabled selected>Selecciona un lote envasado</option>
                </select>
                <label for="lote_envasado">Selecciona el lote envasado</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-4">
                <input type="text" disabled class="form-control" name="lote_granel_edit[${sectionCountEdit}]" id="lote_granel_edit_${sectionCountEdit}" placeholder="Lote a granel">
                <label for="lote_granel">Lote a granel</label>
              </div>
            </div>



          </div>
        </div>
      </div>
    `;
      $('#sections-container2').append(newSection);
      cargarLotesEdit(empresaSeleccionada, sectionCountEdit);
      initializeSelect2($('.select2'));
      sectionCountEdit++;
    });

    // Eliminar la última sección (editar)
    $('#delete-characteristics_edit').click(function () {
      var totalSections = $('#sections-container2 .card').length;
      var lastSection = $('#sections-container2 .card').last();
      if (totalSections > 1) {
        lastSection.remove();
        sectionCountEdit--;
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'No se puede eliminar la sección original.',
          customClass: { confirmButton: 'btn btn-warning' }
        });
      }
    });
  });

  function cargarLotesEdit(empresaSeleccionada, sectionCountEdit) {
    $.ajax({
      url: '/getDatos/' + empresaSeleccionada,
      method: 'GET',
      success: function (response) {
        var contenidoLotesEnvasado = '<option value="" disabled selected>Selecciona un lote envasado</option>';
        var marcas = response.marcas;
        for (let index = 0; index < response.lotes_envasado.length; index++) {
          var lote = response.lotes_envasado[index];
          var skuLimpio = limpiarSku(lote.sku);
          var marcaEncontrada = marcas.find(marca => marca.id_marca === lote.id_marca);
          var nombreMarca = marcaEncontrada ? marcaEncontrada.marca : 'Sin marca';
          var num_dictamen = lote.dictamen_envasado ? lote.dictamen_envasado.num_dictamen : 'Sin dictamen de envasado';
          contenidoLotesEnvasado += `<option value="${lote.id_lote_envasado}">${skuLimpio} ${lote.nombre} ${nombreMarca} ${num_dictamen}</option>`;
        }
        if (response.lotes_envasado.length == 0) {
          contenidoLotesEnvasado = '<option value="" disabled selected>Sin lotes envasados registrados</option>';
        }
        const select = $(`#caracteristicas_Ex_edit_${sectionCountEdit} .evasado_export_edit`);
        select.html(contenidoLotesEnvasado);

        // ✅ Verificar si hay un valor seleccionado previamente
        const selectedPrevio = select.data('selected');
        if (selectedPrevio) {
          select.val(selectedPrevio).trigger('change');
        }
      },
      error: function () {
        Swal.fire({
          icon: 'error',
          title: 'Error al cargar los datos',
          text: 'Hubo un problema al intentar cargar los lotes.',
          customClass: { confirmButton: 'btn btn-danger' }
        });
      }
    });
  }

  function cargarDetallesLoteEnvasadoEdit(idLoteEnvasado) {
    if (idLoteEnvasado) {
      $.ajax({
        url: '/getDetalleLoteEnvasado/' + idLoteEnvasado,
        method: 'GET',
        success: function (response) {
          console.log(response); // Verifica la respuesta en la consola
          console.log('Entro en el de modal edit');

          let tbody = $('#tablaLotesEdit tbody');
          tbody.empty(); // Limpia los datos anteriores
          if (response.lote_envasado) {
            let filaEnvasado = `
                        <tr>
                            <td>1</td>
                            <td>${response.lote_envasado.nombre}
                            <input type="text" class="d-none form-control form-control-sm" name="lote_envasado[0][id_lote_envasado]" autocomplete="off" value="${response.lote_envasado.id_lote_envasado || 'N/A'}" />
                            </td>
                            <td>${limpiarSku(response.lote_envasado.sku) == '{"inicial":""}' ? 'SKU no definido' : limpiarSku(response.lote_envasado.sku)}</td>
                            <td>
                            <input type="text" class="form-control form-control-sm" name="lote_envasado[0][cont_alc]" autocomplete="off" value="${response.lote_envasado.cont_alc_envasado || 'N/A'}" />
                            </td>
                            <td>${response.lote_envasado.presentacion || 'N/A'} ${response.lote_envasado.unidad || ''}</td>

                            <td>Botellas: ${response.lote_envasado.cant_botellas}
                        </tr>`;
            tbody.append(filaEnvasado);
          }

          // Verifica si hay lotes a granel asociados y los muestra
          if (response.detalle && response.detalle.length > 0) {
            tbody.append(`
            <tr style="background-color: #f5f5f7;">
                <th>#</th>
                <th>Nombre de lote a granel</th>
                <th>Folio FQ</th>
                <th>Cont. Alc.</th>
                <th colspan="2">Categoría / Clase / Tipos de Maguey</th>
            </tr>`);
            let nombre_lote_granel = '';
            response.detalle.forEach((lote, index) => {
              let filaGranel = `
                            <tr>
                                <td>${index + 2}</td>
                                <td>
                                ${lote.nombre_lote}<br>
                                <b>Certificado: </b>
                                ${lote.certificado_granel ? lote.certificado_granel.num_certificado : 'Sin definir'}
                                </td>
                                  <td>
                                    <input type="text" class="form-control d-none form-control-sm" name="lotes_granel[0][id_lote_granel]" value="${lote.id_lote_granel || ''}" />
                                    <input type="text" class="form-control form-control-sm" name="lotes_granel[0][folio_fq]" value="${lote.folio_fq || ''}" />
                                  </td>

                                  <td>
                                    ${lote.cont_alc || ''}
                                  </td>
                               <td colspan="2">
                                ${lote.categoria.categoria || 'N/A'}<br>
                                ${lote.clase.clase || 'N/A'}<br>
                                ${lote.tiposMaguey.length ? lote.tiposMaguey.map(tipo => tipo.nombre + ' (<i>' + tipo.cientifico + '</i>)').join('<br>') : 'N/A'}
                            </td>

                            </tr>`;
              tbody.append(filaGranel);
              nombre_lote_granel += lote.nombre_lote;
            });

            $('.lotes_granel_export_edit').val(nombre_lote_granel);
          } else {
            tbody.append(`<tr><td colspan="4" class="text-center">No hay lotes a granel asociados</td></tr>`);
          }
        },
        error: function () {
          console.error('Error al cargar el detalle del lote envasado.');
        }
      });
    }
  }

  //fin de la seccion de editar solicitudes exportacion

  //Enviar formulario store add exportacion
  $(function () {
    // Configuración de CSRF para las solicitudes AJAX
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Validación del formulario Pedido de Exportación
    const addPedidoExportacionForm = document.getElementById('addPedidoExportacionForm');
    window.fv_pedido = FormValidation.formValidation(addPedidoExportacionForm, {
      fields: {
        tipo_solicitud: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo de solicitud.'
            }
          }
        },
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        id_instalacion_envasado_2: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un domicilio de envasado.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un domicilio para la inspección.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de la visita.'
            }
          }
        },

        id_etiqueta: {
          selector: "input[name='id_etiqueta']",
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una etiqueta.'
            }
          }
        },
        factura_proforma: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la factura'
            },
            file: {
              extension: 'pdf,jpg,jpeg,png',
              type: 'application/pdf,image/jpeg,image/png',
              maxSize: 5 * 1024 * 1024, // 5 MB en bytes
              message: 'El archivo debe ser PDF o imagen y pesar máximo 5 MB'
            }
          }
        },
        direccion_destinatario: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una dirección del destinatario.'
            }
          }
        },
        aduana_salida: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la aduana de salida.'
            }
          }
        },
        no_pedido: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de pedido.'
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
      // Recolectar el resto de los datos del formulario
      const formData = new FormData(addPedidoExportacionForm);
      $('#btnAddExport').addClass('d-none');
      $('#btnSpinnerPedidosExportacion').removeClass('d-none');
      const caracteristicas = {
        tipo_solicitud: $('#tipo_solicitud').val(),
        direccion_destinatario: $('#direccion_destinatario_ex').val(),
        aduana_salida: $('[name="aduana_salida"]').val(),
        cont_alc: $('[name="cont_alc"]').val(),
        no_pedido: $('[name="no_pedido"]').val(),
        factura_proforma: $('[name="factura_proforma"]')[0].files[0], // Archivo
        factura_proforma_cont: $('[name="factura_proforma_cont"]')[0].files[0], // Archivo
        detalles: [] // Aquí van las filas de la tabla de características
      };

      // Agregar cada fila de la tabla dinámica al JSON
      $('#tabla-marcas tbody tr').each(function () {
        const row = $(this);
        caracteristicas.detalles.push({
          lote_envasado: row.find('.lote-envasado').val(),
          cantidad_botellas: row.find('.cantidad-botellas').val(),
          cantidad_cajas: row.find('.cantidad-cajas').val(),
          presentacion: row.find('.presentacion').val()
        });
      });

      // Añadir el JSON al FormData como string
      formData.append('caracteristicas', JSON.stringify(caracteristicas));

      $.ajax({
        //url: '/exportaciones/storePedidoExportacion', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Reiniciar el formulario
          $('#btnSpinnerPedidosExportacion').addClass('d-none');
          $('#btnAddExport').removeClass('d-none');
          resetearFormularioExportacion();
          $('.datatables-solicitudes052').DataTable().ajax.reload();
          $('#addPedidoExportacion').modal('hide');
          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'El pedido de exportación se registró exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr, status, error) {
          let mensaje = 'Hubo un error al registrar el pedido de exportación.';

          if (xhr.responseJSON) {
            // Si hay errores de validación
            if (xhr.responseJSON.errors) {
              // Construir mensaje concatenando todos los errores
              const errores = xhr.responseJSON.errors;
              mensaje = Object.values(errores)
                .flat() // en caso que haya arrays de mensajes
                .join('\n'); // separa por salto de línea
            } else if (xhr.responseJSON.message) {
              mensaje = xhr.responseJSON.message;
            }
          } else if (xhr.responseText) {
            try {
              const json = JSON.parse(xhr.responseText);
              if (json.message) mensaje = json.message;
            } catch (e) {
              mensaje = xhr.responseText;
            }
          }

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            html: mensaje.replace(/\n/g, '<br>'), // reemplaza saltos de línea por <br>
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });

          $('#btnSpinnerPedidosExportacion').addClass('d-none');
          $('#btnAddExport').removeClass('d-none');
        }
      });

    });
    $(
      '#id_empresa_solicitud_exportacion, #fecha_visita_exportacion, #id_instalacion_exportacion, #direccion_destinatario, #id_instalacion_envasado_2'
    ).on('change', function () {
      const nombreCampo = $(this).attr('name');
      if (nombreCampo && window.fv_pedido) {
        window.fv_pedido.revalidateField(nombreCampo);
      }
    });
  });

  function resetearFormularioExportacion() {
    $('#addPedidoExportacionForm')[0].reset();
    $('.select2').val(null).trigger('change');
    $('input[type="file"]').val(''); // limpia archivos

    $('#sections-container .card').not(':first').remove();
    $('#encabezado_etiquetas').html('Elegir Etiquetas y Corrugados');

    $('#id_instalacion_exportacion, #id_instalacion_envasado_2, #lote_envasadoExportPe').empty();
    $('#tablaLotes tbody').empty();

    const $seccionCombinado = $('#seccionCajasBotellasCombinado');
    const $seccionExportacion = $('#seccionCajasBotellas');
    const $botonesCharacteristics = $('#botones_characteristics');
    $('#cant_botellas_exportac2').removeAttr('name');
    $('#cant_cajas_exportac2').removeAttr('name');
    $('#presentacion_exportac2').removeAttr('name');
    $('#cant_botellas_exportac').attr('name', 'cantidad_botellas[0]');
    $('#cant_cajas_exportac').attr('name', 'cantidad_cajas[0]');
    $('#presentacion_exportac').attr('name', 'presentacion[0]');
    $seccionCombinado.removeClass('d-none');
    $seccionExportacion.addClass('d-none');
    // Ocultar botones
    $botonesCharacteristics.addClass('d-none');

    const $destinatario = $('#direccion_destinatario');
    $destinatario.val('').trigger('change'); // Asegura que no quede valor residual
    $destinatario.empty().append('<option value="0" disabled selected>Seleccione una dirección</option>');


    if (window.fv_pedido && typeof window.fv_pedido.resetForm === 'function') {
      // Esperar brevemente para asegurar que el DOM siga presente
      setTimeout(() => {
        window.fv_pedido.resetForm(true);
      }, 100);
    }

  }


  // Mapeo entre IDs de tipo de solicitud y IDs de divs
  const divsPorSolicitud = {
    1: ['muestreoAgave'],
    2: ['vigilanciaProduccion'],
    4: ['vigilanciaTraslado'],
    14: ['dictamenInstalaciones'],
    10: ['georreferencia'],
    11: ['liberacionPTExportacion'],
    3: ['muestreoLoteAjustes', 'guiastraslado'],
    5: ['inspeccionEnvasado'],
    7: ['inspeccionIngresoBarrica'],
    8: ['liberacionPTNacional'],
    9: ['liberacionBarricaVidrio']
  };

  // Función para manejar la visibilidad de divs según el tipo de solicitud
  function manejarVisibilidadDivs(idTipo) {
    // Ocultamos todos los divs
    Object.values(divsPorSolicitud)
      .flat()
      .forEach(divId => {
        $(`#${divId}`).addClass('d-none');
      });
    const divsMostrar = divsPorSolicitud[idTipo];
    if (divsMostrar) {
      divsMostrar.forEach(divId => {
        $(`#${divId}`).removeClass('d-none');

        document.querySelectorAll('.d-none select').forEach(el => {
          // el.disabled = true;
        });
      });
    }
  }

  function limpiarCamposDictamen() {
    $(
      '.cajasBotellas, .guiasTraslado, .cajasBotellasTN, .solicitudPdf, .proforma, .csf, .razonSocial, .domicilioFiscal, .domicilioInstalacion, .nombrePredio, .preregistro, .fechaHora, .nombreLote, .guiasTraslado, .categoria, .clase, .cont_alc, .fq, .certificadoGranel, .tipos, .nombreLoteEnvasado, .tipoAnalisis, .materialRecipiente, .capacidadRecipiente, .numeroRecipiente, .tiempoMaduracion, .tipoIngreso, .volumenLiberado, .tipoLiberacion, .volumenActual, .volumenTrasladado, .volumenSobrante, .volumenIngresado, .inicioTerminoEnvasado, .destinoEnvasado, .etiqueta, .acta'
    ).html('');
  }





  $(document).ready(function () {
    $('#reporteForm').on('submit', function (e) {
      e.preventDefault();
      const exportUrl = $(this).attr('action');
      const formData = $(this).serialize();

      Swal.fire({
        title: 'Generando Reporte...',
        text: 'Por favor espera mientras se genera el reporte.',
        icon: 'info',
        didOpen: () => {
          Swal.showLoading();
        },
        customClass: {
          confirmButton: false
        }
      });

      $.ajax({
        url: exportUrl,
        type: 'GET',
        data: formData,
        xhrFields: {
          responseType: 'blob'
        },
        success: function (response, status, xhr) {
          const disposition = xhr.getResponseHeader('Content-Disposition');
          let filename = 'reporte.xlsx';

          if (disposition && disposition.indexOf('filename=') !== -1) {
            const matches = disposition.match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/);
            if (matches != null && matches[1]) {
              filename = matches[1].replace(/['"]/g, '');
            }
          }

          const link = document.createElement('a');
          const url = window.URL.createObjectURL(response);
          link.href = url;
          link.download = filename;
          link.click();
          window.URL.revokeObjectURL(url);

          $('#exportarExcel').modal('hide');

          Swal.fire({
            title: '¡Éxito!',
            text: `El reporte se generó exitosamente.`,
            icon: 'success',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr, status, error) {
          console.error('Error al generar el reporte:', error);
          $('#exportarExcel').modal('hide');
          Swal.fire({
            title: '¡Error!',
            text: 'Ocurrió un error al generar el reporte.',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

  //funcion para exportar en excel
  $(document).ready(function () {
    $('#restablecerFiltros').on('click', function () {
      $('#reporteForm')[0].reset();
      $('.select2').val('').trigger('change');
      console.log('Filtros restablecidos.');
    });
  });

  $(document).ready(function () {
    $('#id_soli').on('change', function () {
      var selectedValues = $(this).val(); // Obtener los valores seleccionados

      if (selectedValues && selectedValues.includes('')) {
        // Si "Todas" es seleccionado
        $('#id_soli option').each(function () {
          if ($(this).val() !== '') {
            $(this).prop('selected', false); // Deseleccionar otras opciones
            $(this).prop('disabled', true); // Deshabilitar otras opciones
          }
        });
      } else {
        // Si seleccionas cualquier otra opción
        if (selectedValues && selectedValues.length > 0) {
          $('#id_soli option[value=""]').prop('disabled', true); // Deshabilitar "Todas"
        } else {
          // Si no hay opciones seleccionadas, habilitar todas
          $('#id_soli option').each(function () {
            $(this).prop('disabled', false); // Habilitar todas las opciones
          });
        }
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

    // Inicializar FormValidation para la solicitud de muestreo de agave
    const form3 = document.getElementById('addRegistrarSolicitudMuestreoAgave');
    const fv3 = FormValidation.formValidation(form3, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha sugerida para la inspección.'
            }
          }
        },
        punto_reunion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la dirección para el punto de reunión.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un domicilio para la inspección.'
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
      var formData = new FormData(form3);
      $('#btnRegistrarMA').addClass('d-none');
      $('#loading_mu_agv').removeClass('d-none');
      $;
      $.ajax({
        //url: '/registrar-solicitud-muestreo-agave',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudMuestreoAgave').modal('hide');
          $('#loading_mu_agv').addClass('d-none');
          $('#btnRegistrarMA').removeClass('d-none');
          $('#addRegistrarSolicitudMuestreoAgave')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes052').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud de muestreo registrado exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr) {
          let mensaje = 'Ocurrió un error inesperado.';

          if (xhr.responseJSON?.message) {
            mensaje = xhr.responseJSON.message;
          }

          // Si Laravel devuelve errores de validación
          if (xhr.responseJSON?.errors) {
            const errores = xhr.responseJSON.errors;
            mensaje = Object.values(errores)
              .map(arr => `• ${arr.join(', ')}`)
              .join('\n');
          }

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: mensaje,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#loading_mu_agv').addClass('d-none');
          $('#btnRegistrarMA').removeClass('d-none');
        }
      });
    });
    $('#id_empresa_dic2mues, #fecha_visita_dic2, #id_instalacion_dic2').on('change', function () {
      fv3.revalidateField($(this).attr('name'));
    });
  });




  $(function () {
    if ($('#dropzone-multi').length) {
      new Dropzone('#dropzone-multi', {
        //url: '/upload',
        acceptedFiles: 'application/pdf',
        maxFilesize: 5,
        addRemoveLinks: true,
        dictDefaultMessage: 'Arrastra aquí los archivos o haz clic para seleccionar',
        dictRemoveFile: 'Eliminar',
        previewTemplate: document.querySelector('#tpl-preview').innerHTML,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function () {
          this.on('success', function (file, response) {
            console.log('Subido:', response);
          });
          this.on('removedfile', function (file) {
            console.log('Archivo eliminado:', file);
          });
        }
      });
    }
  });









});//fin function

