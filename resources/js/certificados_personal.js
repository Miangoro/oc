'use strict';

 $(function () {
 
   var dt_user_table = $('.datatables-users')
 
   if (dt_user_table.length) {
     var dt_user = dt_user_table.DataTable({
       processing: true,
       serverSide: true,
       ajax: {
        url: '/personal-list',
    },    
       columns: [
         { data: 'id_revision' },
         { data: 'id_revisor' },
         { data: 'id_revisor' },
         { data: 'id_revisor' },
         { data: 'fecha_vigencia' },
         { data: 'id_revisor' },
         { data: 'id_revisor' },
         { data: 'id_revisor' },
         
         { data: 'actions'}
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
           orderable: false,
           targets: 1,
           render: function (data, type, full, meta) {
             return `<span>${full.fake_id}</span>`;
           }
         },       
          {
            targets: 2,
            render: function (data, type, full, meta) {
              var $id_revisor = full['id_revisor'];
              return '<span class="user-email">' + $id_revisor + '</span>';
            }
          },     
          {
            targets: 3,
            render: function (data, type, full, meta) {
              var $num_certificado = full['num_certificado'];
              return '<span class="badge bg-info">' + $num_certificado + '</span>';
            }
          },     
         {
           // Actions
           targets: 4,
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
                  // Botón para revisar
                  `<a class="dropdown-item waves-effect text-info cuest" ` +
                    `data-id="${full['id_revision']}" ` +
                    `data-revisor-id="${full['id_revisor']}" ` +
                    `data-dictamen-id="${full['id_certificado']}" ` + 
                    `data-num-certificado="${full['num_certificado']}" ` + 
                    `data-num-dictamen="${full['num_dictamen']}" ` + 
                    `data-tipo-dictamen="${full['tipo_dictamen']}" ` +
                    `data-fecha-vigencia="${full['fecha_vigencia']}" ` +
                    `data-fecha-vencimiento="${full['fecha_vencimiento']}" ` +
                    `data-bs-toggle="modal" ` +
                    `data-bs-target="#fullscreenModal">` +
                    '<i class="ri-user-search-fill ri-20px text-info"></i> Revisar certificado' +
                  '</a>' +
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
                 "sFirst":    "Primero",
                 "sLast":     "Último",
                 "sNext":     "Siguiente",
                 "sPrevious": "Anterior"
               }
       },
 
       // Opciones Exportar Documentos
       buttons: [
         {
           extend: 'collection',
           className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
           text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
           buttons: [
             {
               extend: 'print',
               title: 'Certificados Instalaciones',
               text: '<i class="ri-printer-line me-1" ></i>Print',
               className: 'dropdown-item',
               exportOptions: {
                 columns: [1, 2, 3, 4],
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
               title: 'Certificados Instalaciones',
               text: '<i class="ri-file-text-line me-1" ></i>Csv',
               className: 'dropdown-item',
               exportOptions: {
                 columns: [1, 2, 3, 4],
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
               title: 'Certificados Instalaciones',
               text: '<i class="ri-file-excel-line me-1"></i>Excel',
               className: 'dropdown-item',
               exportOptions: {
                columns: [1, 2, 3, 4],
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
               title: 'Certificados Instalaciones',
               text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
               className: 'dropdown-item',
               exportOptions: {
                columns: [1, 2, 3, 4],
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
               title: 'Certificados Instalaciones',
               text: '<i class="ri-file-copy-line me-1"></i>Copy',
               className: 'dropdown-item',
               exportOptions: {
                columns: [1, 2, 3, 4],
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
       ],
        responsive: {
         details: {
           display: $.fn.dataTable.Responsive.display.modal({
             header: function (row) {
               var data = row.data();
               return 'Detalles de Cerificados de Instalaciones';
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
   } 

   // FUNCIONES DEL FUNCIONAMIENTO DEL CRUD
   
   $(document).on('click', '.cuest', function () {
    var id_revision = $(this).data('id');
    var id_revisor = $(this).data('revisor-id');  
    var id_certificado = $(this).data('dictamen-id');  
    var num_certificado = $(this).data('num-certificado'); 
    var num_dictamen = $(this).data('num-dictamen'); 
    var tipo_dictamen = $(this).data('tipo-dictamen'); 
    var fecha_vigencia = $(this).data('fecha-vigencia'); 
    var fecha_vencimiento = $(this).data('fecha-vencimiento'); 
    var pdf_url = $(this).data('pdf-url');

    // Imprimir en consola
    console.log('ID de Revisión:', id_revision);
    console.log('ID del Revisor correspondiente:', id_revisor);
    console.log('ID del Certificado:', id_certificado);
    console.log('Número de Certificado:', num_certificado); 
    console.log('Número de Dictamen:', num_dictamen);
    console.log('Tipo de Dictamen:', tipo_dictamen); 
    console.log('Fecha de Vigencia:', fecha_vigencia); 
    console.log('Fecha de Vencimiento:', fecha_vencimiento); 

    //Cargar datos a la Vista
    $('#edit_id_revision').val(id_revision); 
    $('#revisorName').text(`${id_revisor}`); 
    $('#numCertificado').text(`${num_certificado}`); 
    $('#numDictamen').text(`${num_dictamen}`); 
    $('#fechaVigencia').text(fecha_vigencia); 
    $('#fechaVencimiento').text(fecha_vencimiento); 

    // Mostrar el tipo de dictamen en el modal
    var $colorDictamen, $nombreDictamen;
    switch (tipo_dictamen) {
        case 1:
            $nombreDictamen = 'Productor';
            $colorDictamen = 'primary'; 
            break;
        case 2:
            $nombreDictamen = 'Envasador';
            $colorDictamen = 'success'; 
            break;
        case 3:
            $nombreDictamen = 'Comercializador';
            $colorDictamen = 'info'; 
            break;
        case 4:
            $nombreDictamen = 'Almacén y bodega';
            $colorDictamen = 'danger'; 
            break;
        case 5:
            $nombreDictamen = 'Área de maduración';
            $colorDictamen = 'warning'; 
            break;
        default:
            $nombreDictamen = 'Desconocido';
            $colorDictamen = 'secondary'; 
    }

    $('#tipoCertificado').html(`<span class="badge rounded-pill bg-label-${$colorDictamen}">${$nombreDictamen}</span>`);
    // Cargar el PDF en el iframe dentro de la tabla
    $('#pdfViewer').attr('src', pdf_url).removeAttr('hidden'); 
    $('#pdfIcon')
        .attr('data-id', id_certificado) 
        .attr('data-tipo', tipo_dictamen)
        .attr('data-registro', num_certificado) 
        .show(); 

    // Mostrar el modal correspondiente
    $('#fullscreenModal').modal('show');
});

$(document).on('click', '.pdf', function () {
  var id = $(this).data('id'); 
  var registro = $(this).data('registro');
  var tipo = $(this).data('tipo'); 

  var tipo_dictamen = '';
  var titulo = '';

  // Establecer el título según el tipo de dictamen
  if (tipo == 1 || tipo == 5) { // Productor
      tipo_dictamen = '../certificado_productor_mezcal/' + id;
      titulo = "Certificado de productor";
  } else if (tipo == 2) { // Envasador
      tipo_dictamen = '../certificado_envasador_mezcal/' + id;
      titulo = "Certificado de envasador";
  } else if (tipo == 3 || tipo == 4) { // Comercializador
      tipo_dictamen = '../certificado_comercializador/' + id;
      titulo = "Certificado de comercializador";
  }

  $('#loading-spinner').show();
  $('#pdfViewerDictamen').hide();

  $('#titulo_modal_Dictamen').text(titulo);
  $('#subtitulo_modal_Dictamen').text(registro);

  var openPdfBtn = $('#openPdfBtnDictamen');
  openPdfBtn.attr('href', tipo_dictamen);
  openPdfBtn.show();

  $('#PdfDictamenIntalaciones').modal('show');
  $('#pdfViewerDictamen').attr('src', tipo_dictamen); 
  $('#pdfViewerDictamenFrame').attr('src', tipo_dictamen); 
});

// Cuando el PDF se carga
$('#pdfViewerDictamen').on('load', function () {
  $('#loading-spinner').hide();
  $('#pdfViewerDictamen').show();
});

$('#fullscreenModal').draggable({
  handle: ".modal-header", // Permitir arrastrar solo desde el encabezado
  containment: "window" // Restringir el movimiento a la ventana
});


//end
});



