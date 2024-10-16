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
         { data: 'fake_id' },
         { data: 'id_revisor' },
         { data: 'num_certificado' },
         { data: 'created_at' },
         { data: 'updated_at' },
         { data: 'tipo_dictamen' },
         { data: 'PDF' },
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
              return '<span class="user-email"><strong>' + $num_certificado + '</strong></span>';
            }
          },      
          {
            targets: 4,
            render: function (data, type, full, meta) {
              var $created_at = full['created_at'];
              return '<span class="user-email">' + $created_at + '</span>';
            }
          },     
          {
            targets: 5,
            render: function (data, type, full, meta) {
              var $updated_at = full['updated_at'];
              return '<span class="user-email">' + $updated_at + '</span>';
            }
          }, 
          {
            targets: 6,
            responsivePriority: 4,
            render: function (data, type, full, meta) {
              var $tipoDictamen = full['tipo_dictamen'];
              var $colorDictamen;
              var $nombreDictamen;
          
              switch ($tipoDictamen) {
                case 1:
                  $nombreDictamen = 'Productor';
                  $colorDictamen = 'primary'; // Azul
                  break;
                case 2:
                  $nombreDictamen = 'Envasador';
                  $colorDictamen = 'success'; // Verde
                  break;
                case 3:
                  $nombreDictamen = 'Comercializador';
                  $colorDictamen = 'info'; // Celeste
                  break;
                case 4:
                  $nombreDictamen = 'Almacén y bodega';
                  $colorDictamen = 'danger'; // Rojo
                  break;
                case 5:
                  $nombreDictamen = 'Área de maduración';
                  $colorDictamen = 'warning'; // Amarillo
                  break;
                default:
                  $nombreDictamen = 'Desconocido';
                  $colorDictamen = 'secondary'; // Gris, color por defecto
              }
          
              // Retorna el badge con el texto y color apropiado
              return `<span class="badge rounded-pill bg-label-${$colorDictamen}">${$nombreDictamen}</span>`;
            }     
          },     
          {
            // Abre el pdf del certificado
            targets: 7,
            className: 'text-center',
            render: function (data, type, full, meta) {
              return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#PdfDictamenIntalaciones" data-bs-toggle="modal" data-bs-dismiss="modal" data-tipo="${full['tipo_dictamen']}" data-id="${full['id_certificado']}" data-registro="${full['num_certificado']} "></i>`;
            }
          },
         {
           // Actions
           targets: 8,
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
                    '<i class="ri-eye-fill ri-20px text-info"></i> Revisar' +
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
   
// Manejar el evento de clic en el botón de "Registrar Revisión"
$('#registrarRevision').on('click', function(e) {
  e.preventDefault();

  var respuestas = [];
  var rows = $('table tbody tr'); // Seleccionar todas las filas de la tabla

  // Recorrer cada fila de la tabla para obtener los valores de respuesta y observación
  rows.each(function() {
      var selectElement = $(this).find('select.form-select'); // Seleccionar el dropdown
      var textareaElement = $(this).find('textarea'); // Seleccionar el campo de observación

      // Verificar si el elemento select y textarea existen
      if (selectElement.length && textareaElement.length) {
          var respuesta = selectElement.val(); // Obtener la respuesta seleccionada
          var observacion = textareaElement.val(); // Obtener el valor del textarea
          var idPregunta = $(this).find('td:first').text().trim(); // Obtener el ID de la pregunta (el número de la fila)

          // Verificar si hay respuesta u observación válida antes de registrar
          if ((respuesta && respuesta !== 'Selecciona') || (observacion && observacion.trim() !== '')) {
              respuestas.push({
                  id_pregunta: idPregunta,
                  respuesta: respuesta !== 'Selecciona' ? respuesta : null, // Si no hay respuesta válida, guardamos null
                  observacion: observacion ? observacion.trim() : null // Si no hay observación, guardamos null
              });
          }
      }
  });

  // Si no hay respuestas válidas, mostrar un error
  if (respuestas.length === 0) {
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se ha proporcionado ninguna respuesta ni observación.'
      });
      return;
  }

  var id_revision = $('.cuest').data('id'); // Obtener el ID de la revisión

  // Crear el objeto de datos a enviar
  var formData = {
      respuestas: respuestas,
      id_revision: id_revision,
  };

  // Mostrar en consola los datos que se van a enviar (para depuración)
  console.log("Datos enviados:", formData);

  // Realizar la solicitud AJAX al servidor
  $.ajax({
      url: '/revisor/registrar-respuestas', // URL del controlador en el servidor
      type: 'POST',
      data: JSON.stringify(formData),
      contentType: 'application/json',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token para proteger la solicitud
      },
      success: function(response) {
          // Cerrar el modal al completar la operación
          $('#fullscreenModal').modal('hide');

          // Mostrar mensaje de éxito
          Swal.fire({
              icon: 'success',
              title: '¡Éxito!',
              text: response.message,
              customClass: {
                  confirmButton: 'btn btn-success'
              }
          });

          // Recargar la tabla si es necesario
          $('.datatables-revision').DataTable().ajax.reload();
      },
      error: function(xhr) {
          // Manejar el error en caso de que falle el registro
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al registrar las respuestas y observaciones.',
              customClass: {
                  confirmButton: 'btn btn-danger'
              }
          });
      }
  });

});





//end
});



