'use strict';

 $(function () {
var dt_user_table = $('.datatables-users'),
select2Elements = $('.select2'),
userView = baseUrl + 'app/user/view/account';

function initializeSelect2($elements) {
   $elements.each(function () {
       var $this = $(this);
       $this.wrap('<div class="position-relative"></div>').select2({
           dropdownParent: $this.parent()
       });
   });
}

initializeSelect2(select2Elements);

  $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true
  });

   // AJAX setup
   $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
 
   if (dt_user_table.length) {
    var dt_instalaciones_table = $('.datatables-users').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
         url: baseUrl + 'certificados/granel-list',
       },
       columns: [
         { data: '#' },                //0
         { data: 'fake_id' },          //1
         { data: 'id_dictamen' },      //2       
         { data: 'id_firmante' },      //3
         { data: 'fecha_vigencia' },   //4  
         { data: 'fecha_vencimiento' },//5  
         { data: 'PDF' },              //6  
         { data: 'actions'},           //6
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
              var $id_dictamen = full['id_dictamen'];
              return '<span class="fw-bold">' + $id_dictamen + '</span>';
            }
          }, 
          {
            targets: 3,
            render: function (data, type, full, meta) {
              var $id_firmante = full['id_firmante'];
              return '<span class="user-email">' + $id_firmante + '</span>';
            }
          }, 
          {
            targets: 4,
            render: function (data, type, full, meta) {
              var $fecha_vigencia = full['fecha_vigencia'];
              return '<span class="user-email">' + $fecha_vigencia + '</span>';
            }
          }, 
          {
            targets: 5,
            render: function (data, type, full, meta) {
              var $fecha_vencimiento = full['fecha_vencimiento'];
              return '<span class="user-email">' + $fecha_vencimiento + '</span>';
            }
          }, 
          {
            // Abre el pdf del certificado
            targets: 6,
            className: 'text-center',
            render: function (data, type, full, meta) {
              return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#PdfDictamenIntalaciones" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="${full['id_certificado']}" data-dictamen="${full['id_dictamen']}"></i>`;
            }
          },
         {
           // Actions
           targets: 7,
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
                  // Botón para e
                  `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#editCertificadoModal" class="dropdown-item edit-record waves-effect text-info">` +
                    '<i class="ri-edit-box-line ri-20px text-info"></i> Editar' +
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
                 columns: [1, 2, 3, 4, 5, 6, 7],
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
                 columns: [1, 2, 3, 4, 5 ,6, 7],
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
                columns: [1, 2, 3, 4, 5 ,6, 7],
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
                columns: [1, 2, 3, 4, 5 ,6, 7],
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
                columns: [1, 2, 3, 4, 5 ,6],
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
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Certificado</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#addCertificadoGrenelModal'
          }
        }
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

//FUNCIONES DEL FUNCIONAMIENTO DEL CRUD//

// Agregar
$(function () {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  function setFechaVencimiento() {
      let fechaVigencia = $('#fecha_vigencia').val();
      if (fechaVigencia) {
          let fecha = new Date(fechaVigencia);
          fecha.setFullYear(fecha.getFullYear() + 1);
          let year = fecha.getFullYear();
          let month = String(fecha.getMonth() + 1).padStart(2, '0');
          let day = String(fecha.getDate()).padStart(2, '0');
          let fechaVencimiento = `${year}-${month}-${day}`;
          $('#fecha_vencimiento').val(fechaVencimiento);
          fv.revalidateField('fecha_vencimiento'); 
      }
  }

  $('#fecha_vigencia').on('change', function () {
      setFechaVencimiento();
  });

  const form = document.getElementById('addCertificadoForm'); 
  const fv = FormValidation.formValidation(form, {
      fields: {
          'id_firmante': {
              validators: {
                  notEmpty: {
                      message: 'Selecciona un firmante.'
                  }
              }
          },
          'num_dictamen': {
              validators: {
                  notEmpty: {
                      message: 'Selecciona un dictamen.'
                  }
              }
          },
          'num_certificado': {
              validators: {
                  notEmpty: {
                      message: 'El número de certificado es obligatorio.'
                  }
              }
          },
          'fecha_vigencia': {
              validators: {
                  notEmpty: {
                      message: 'La fecha de vigencia es obligatoria.'
                  },
                  date: {
                      format: 'YYYY-MM-DD',
                      message: 'Introduce una fecha de vigencia válida (YYYY-MM-DD).'
                  }
              }
          },
          'fecha_vencimiento': {
              validators: {
                  notEmpty: {
                      message: 'La fecha de vencimiento es obligatoria.'
                  },
                  date: {
                      format: 'YYYY-MM-DD',
                      message: 'Introduce una fecha de vencimiento válida (YYYY-MM-DD).'
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
  });

  $('#btnRegistrarInstalacion').on('click', function (event) {
      event.preventDefault();

      fv.validate().then(function (status) {
          if (status === 'Valid') {
              var formData = {
                  id_firmante: $('#id_firmante').val(),
                  id_dictamen: $('#num_dictamen').val(),
                  num_certificado: $('#num_certificado').val(),
                  fecha_vigencia: $('#fecha_vigencia').val(),
                  fecha_vencimiento: $('#fecha_vencimiento').val(),
              };

              $.ajax({
                  url: '/certificados',
                  type: 'POST',
                  data: formData,
                  success: function () {
                      $('#addCertificadoGrenelModal').modal('hide');
                      dt_instalaciones_table.ajax.reload();

                      Swal.fire({
                          icon: 'success',
                          title: '¡Registrado!',
                          text: '¡El certificado ha sido registrado correctamente!',
                          customClass: {
                              confirmButton: 'btn btn-success'
                          }
                      });
                  },
                  error: function (xhr, textStatus, errorThrown) {
                      console.error('Error al registrar:', textStatus, errorThrown);
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Hubo un problema al registrar el certificado.',
                      });
                  }
              });
          }
      });
  });

  $('#id_firmante, #num_dictamen, #fecha_vigencia, #fecha_vencimiento').on('change', function() {
      fv.revalidateField($(this).attr('name'));
  });
});

$(document).on('click', '.pdf', function () {
  var id = $(this).data('id');
  var dictamen = $(this).data('dictamen');

  $('#loading-spinner').show();
  $('#pdfViewerDictamen').hide();

  $('#titulo_modal_Dictamen').text("Certificado Granel");
  $('#subtitulo_modal_Dictamen').text(dictamen);

  var pdfUrl = '/Pre-certificado/' + id;
  $('#openPdfBtnDictamen').attr('href', pdfUrl).show();
  $('#pdfViewerDictamen').attr('src', pdfUrl);

  $('#PdfDictamenIntalaciones').modal('show');
});

$('#pdfViewerDictamen').on('load', function () {
  $('#loading-spinner').hide();
  $('#pdfViewerDictamen').show();
});

//end
});
