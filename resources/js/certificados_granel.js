'use strict';

 $(function () {
var dt_user_table = $('.datatables-users'),
select2Elements = $('.select2'),
userView = baseUrl + 'app/user/view/account';

$('#addCertificadoForm .select2').each(function () {
var $this = $(this);
$this.select2({
    dropdownParent: $this.closest('.form-floating')
});
});

$('#asignarRevisorForm .select2').each(function () {
var $this = $(this);
$this.select2({
  dropdownParent: $this.closest('.form-floating')
});
});

$('#editCertificadoForm .select2').each(function () {
  var $this = $(this);
  $this.select2({
    dropdownParent: $this.closest('.form-floating')
  });
  });

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
         { data: ''},                  //6
         { data: 'PDF' },              //7  
         { data: 'Estatus' },          //8  
         { data: 'actions'},           //9
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
            targets: 6,
            render: function (data, type, full, meta) {
                var id_revisor = full['id_revisor'];   // Obtener el id_revisor
                var id_revisor2 = full['id_revisor2']; // Obtener el id_revisor2
        
                // Mensajes para los revisores
                var revisorPersonal, revisorMiembro;
        
                // Para el revisor personal
                if (id_revisor !== 'Sin asignar') {
                    revisorPersonal = `<span class="badge" style="background-color: transparent; color:  #676B7B;"><strong>Revisión OC:</strong> ${id_revisor}</span>`;
                } else {
                    revisorPersonal = `<span class="badge" style="background-color: transparent; color:  #676B7B;"><strong>Revisión OC:</strong> <strong style="color: red;">Sin asignar</strong></span>`;
                }
        
                // Para el revisor miembro
                if (id_revisor2 !== 'Sin asignar') {
                    revisorMiembro = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Revisión Consejo:</strong> ${id_revisor2}</span>`;
                } else {
                    revisorMiembro = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Revisión Consejo:</strong> <strong style="color: red;">Sin asignar</strong></span>`;
                }
        
                // Retorna los revisores en formato HTML
                return `
                    <div style="display: flex; flex-direction: column;">
                        <div style="display: inline;">${revisorPersonal}</div>
                        <div style="display: inline;">${revisorMiembro}</div>
                    </div>
                `;
            }
          },
          {
            // Abre el pdf del certificado
            targets: 7,
            className: 'text-center',
            render: function (data, type, full, meta) {
              return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#PdfDictamenIntalaciones" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="${full['id_certificado']}" data-dictamen="${full['id_dictamen']}"></i>`;
            }
          },
          {
            target: 8, // Suponiendo que este es el índice de la columna que quieres actualizar
            render: function (data, type, full, meta) {
                var estatus = full['estatus']; // Obtener el estatus del certificado
                
                // Determinar el texto y el color del badge según el estatus
                var badgeText = '';
                var colorEstatus = '';
        
                if (estatus == 1) {
                    badgeText = 'Cancelado'; // Si el estatus es 1
                    colorEstatus = 'danger'; // Cambia a color rojo
                } else if (estatus == 2) {
                    badgeText = 'Reexpedido'; // Si el estatus es 2
                    colorEstatus = 'success'; // Cambia a color verde
                } else {
                    var id_revisor = full['id_revisor'];
                    var id_revisor2 = full['id_revisor2'];
        
                    // Verificar si ambos revisores están vacíos o son nulos
                    var isActive = (id_revisor && id_revisor !== 'Sin asignar') || (id_revisor2 && id_revisor2 !== 'Sin asignar'); 
                    badgeText = isActive ? 'Vigente' : 'Sin asignar'; // Establecer el estatus
                    colorEstatus = isActive ? 'success' : 'secondary'; // Color según el estatus
                }
        
                return `<span class="badge rounded-pill bg-label-${colorEstatus}">${badgeText}</span>`;
            }
          }, 
         {
           // Actions
           targets: 9,
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
                // Botón para Editar
                `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#editCertificadoGranelModal" class="dropdown-item edit-record waves-effect text-info">` +
                '<i class="ri-edit-box-line ri-20px text-info"></i> Editar' +
               '</a>' +
                // Botón para eliminar
                `<a data-id="${full['id_certificado']}" class="dropdown-item delete-record waves-effect text-danger">` +
                '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar' +
                '</a>'+
                // Botón adicional: Asignar revisor
                `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#asignarRevisorModal" class="dropdown-item waves-effect text-info">` +
                '<i class="text-warning ri-user-search-fill"></i> <span class="text-warning">Asignar revisor</span>' +
                '</a>' +
                // Botón para reexpedir certificado de instalaciones
                `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#modalReexpedirCertificadoGranel" class="dropdown-item reexpedir-record waves-effect text-info">` +
                '<i class="ri-file-edit-fill"></i>Reexpedir certificado' +
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

  // Eliminar registro
  $(document).on('click', '.delete-record', function () {
    var id_certificado = $(this).data('id'),
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
          url:`/certificados/granel/${id_certificado}`,
          success: function () {
            dt_instalaciones_table.ajax.reload();
          },
          error: function (error) {
            console.log(error);
          }
        });
        Swal.fire({
          icon: 'success',
          title: '¡Eliminado!',
          text: '¡La solicitud ha sido eliminada correctamente!',
          customClass: {
            confirmButton: 'btn btn-success'
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

//Agregar
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

    $('#btnRegistrarCertidicado').on('click', function (event) {
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
                  url: '/certificados/granel',
                  type: 'POST',
                  data: formData,
                  beforeSend: function () {
                      $('#btnRegistrarCertidicado').prop('disabled', true).text('Registrando...');
                  },
                  success: function () {
                      $('#addCertificadoGrenelModal').modal('hide');
                      dt_instalaciones_table.ajax.reload();
                      $('#addCertificadoForm')[0].reset();
              
                      fv.removeField('id_firmante');
                      fv.removeField('num_dictamen');
                      $('#num_dictamen').val(null).trigger('change');
                      $('#id_firmante').val(null).trigger('change');
                      fv.addField('id_firmante', {
                          validators: {
                              notEmpty: {
                                  message: 'Selecciona un firmante.'
                              }
                          }
                      });
                      fv.addField('num_dictamen', {
                          validators: {
                              notEmpty: {
                                  message: 'Selecciona un dictamen.'
                              }
                          }
                      });
            
                      $('#btnRegistrarCertidicado').prop('disabled', false).text('Registrar');
              
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
              
                      // Restablecer el botón
                      $('#btnRegistrarCertidicado').prop('disabled', false).text('Registrar');
              
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
    // Revalidar los campos al cambiar su valor
    $('#id_firmante, #num_dictamen, #fecha_vigencia, #fecha_vencimiento').on('change', function() {
        fv.revalidateField($(this).attr('name'));
    });
});

function setFechaVencimiento() {
  let fechaVigencia = $('#edit_fecha_vigencia').val();
  if (fechaVigencia) {
      let fecha = new Date(fechaVigencia);
      fecha.setFullYear(fecha.getFullYear() + 1);
      let year = fecha.getFullYear();
      let month = String(fecha.getMonth() + 1).padStart(2, '0');
      let day = String(fecha.getDate()).padStart(2, '0');
      let fechaVencimiento = `${year}-${month}-${day}`;
      $('#edit_fecha_vencimiento').val(fechaVencimiento);
      fvEdit.revalidateField('edit_fecha_vencimiento'); 
  }
}

$('#edit_fecha_vigencia').on('change', function () {
  setFechaVencimiento();
});

var globalIdCertificado = null;

$(document).on('click', '.edit-record', function () {
  globalIdCertificado = $(this).data('id');
  var modal = $('#editCertificadoGrenelModal');

  $.ajax({
      url: `/edit-certificados/granel/${globalIdCertificado}`,
      type: 'GET',
      success: function (response) {
          $('#edit_num_dictamen').val(response.id_dictamen).trigger('change');
          $('#edit_id_firmante').val(response.id_firmante).trigger('change');
          $('#edit_num_certificado').val(response.num_certificado);
          $('#edit_fecha_vigencia').val(response.fecha_vigencia);
          $('#edit_fecha_vencimiento').val(response.fecha_vencimiento);
      },
      error: function (error) {
          console.log(error);
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Hubo un problema al cargar los datos del certificado.'
          });
      }
  });
});

const editForm = document.getElementById('editCertificadoForm');
const fvEdit = FormValidation.formValidation(editForm, {
  fields: {
      'num_certificado': {
          validators: {
              notEmpty: {
                  message: 'El número de certificado es obligatorio.'
              }
          }
      },
      'id_firmante': {
          validators: {
              notEmpty: {
                  message: 'El firmante es obligatorio.'
              }
          }
      },
      'num_dictamen': {
          validators: {
              notEmpty: {
                  message: 'El dictamen es obligatorio.'
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
                  message: 'Introduce una fecha válida (YYYY-MM-DD).'
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
                  message: 'Introduce una fecha válida (YYYY-MM-DD).'
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
})
.on('core.form.valid', function () {
  if (!globalIdCertificado) {
      console.log("No se encontró el id del certificado.");
      return;
  }
  var formData = $('#editCertificadoForm').serialize();

  $.ajax({
      type: 'PUT',
      url: `/certificados/granel/${globalIdCertificado}`,
      data: formData,
      success: function (response) {
          Swal.fire({
              icon: 'success',
              title: '¡Éxito!',
              text: response.message,
              customClass: {
                  confirmButton: 'btn btn-success'
              }
          });
          $('#editCertificadoGranelModal').modal('hide');
          $('.datatables-users').DataTable().ajax.reload();
      },
      error: function (error) {
          console.log(error);
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Hubo un problema al actualizar el certificado.',
          });
      }
  });
});

// Revalidar campos dinámicamente al cambiar su valor
$('#edit_num_dictamen, #edit_id_firmante, #edit_fecha_vigencia, #edit_fecha_vencimiento').on('change', function () {
  fvEdit.revalidateField($(this).attr('name'));
});


$(document).ready(function() {
  $('#tipoRevisor').on('change', function() {
      var tipoRevisor = $(this).val();

      if (tipoRevisor) {
          var tipo = (tipoRevisor === '1') ? 1 : 4; 

          $.ajax({
              url: '/ruta-para-obtener-revisores',
              type: 'GET',
              data: { tipo: tipo },
              success: function(response) {

                  if (Array.isArray(response) && response.length > 0) {
                      response.forEach(function(revisor) {
                          $('#nombreRevisor').append('<option value="' + revisor.id + '">' + revisor.name + '</option>');
                      });
                  } else {
                      $('#nombreRevisor').append('<option value="">No hay revisores disponibles</option>');
                  }
              },
              error: function(xhr) {
                  console.log('Error:', xhr.responseText);
                  alert('Error al cargar los revisores. Inténtelo de nuevo.');
              }
          });
      }
  });
});

// Agregar Revisor
$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$('#asignarRevisorForm').hide();

const form = document.getElementById('asignarRevisorForm');
const fv = FormValidation.formValidation(form, {
  fields: {
      'tipoRevisor': {
          validators: {
              notEmpty: {
                  message: 'Debe seleccionar una opción para la revisión.'
              }
          }
      },
      'nombreRevisor': {
          validators: {
              notEmpty: {
                  message: 'Debe seleccionar un nombre para el revisor.'
              }
          }
      },
      'numeroRevision': {
          validators: {
              notEmpty: {
                  message: 'Debe seleccionar un número de revisión.'
              }
          }
      }
  },
  plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: '.mb-3'
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
  }
}).on('core.form.valid', function (e) {
  var formData = new FormData(form);
  var id_certificado = $('#id_certificado').val();
  var tipoRevisor = $('#tipoRevisor').val(); 
  var revisorValue = $('#nombreRevisor').val(); 
  
  console.log('ID Certificado:', id_certificado);
  console.log('Tipo de Revisor:', tipoRevisor);
  console.log('Valor del Revisor:', revisorValue);

  if (tipoRevisor == '1') { 
      formData.append('id_revisor', revisorValue);
      formData.append('id_revisor2', null); 
  } else if (tipoRevisor == '2') {
      formData.append('id_revisor2', revisorValue);
      formData.append('id_revisor', null); 
  }

  // Añadir otros datos
  formData.append('id_certificado', id_certificado);
  var esCorreccion = $('#esCorreccion').is(':checked') ? 'si' : 'no';
  formData.append('esCorreccion', esCorreccion);

  console.log('FormData:', Array.from(formData.entries())); 

  $.ajax({
      url: '/asignar-revisor/granel',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
          $('#asignarRevisorModal').modal('hide');
          Swal.fire({
              icon: 'success',
              title: '¡Éxito!',
              text: response.message,
              customClass: {
                  confirmButton: 'btn btn-success'
              }
          }).then(function () {
              form.reset();
              $('#nombreRevisor').val(null).trigger('change');
              $('#esCorreccion').prop('checked', false);
              fv.resetForm();
              $('.datatables-users').DataTable().ajax.reload();
          });
      },
      error: function (xhr) {
          $('#asignarRevisorModal').modal('hide');
          Swal.fire({
              icon: 'success',
              title: '¡Éxito!',
              text: 'Revisor asignado exitosamente',
              customClass: {
                  confirmButton: 'btn btn-success'
              }
          }).then(function () {
              form.reset();
              $('#nombreRevisor').val(null).trigger('change');
              $('#esCorreccion').prop('checked', false);
              fv.resetForm();
              $('.datatables-users').DataTable().ajax.reload();
          });
      }
  });
});

$('#nombreRevisor').on('change', function () {
  fv.revalidateField($(this).attr('name'));
});

//Reexpedicion y Cancelacion
$(document).on('click', '.reexpedir-record', function () {
  var idCertificado = $(this).data('id');
  console.log("ID del certificado para reexpedir:", idCertificado); 
  $('#reexpedir_id_certificado').val(idCertificado);
});

$('#accion_reexpedir').on('change', function () {
  var selectedValue = $(this).val(); 
  var idCertificado = $('#reexpedir_id_certificado').val(); 
  cargarDatos(idCertificado);
  if (selectedValue == '2') { 
      $('#campos_condicionales').slideDown();
  } else {
      $('#campos_condicionales').slideUp(); 
  }
});

$('#addReexpedirCertificadoGranelForm').on('submit', function (e) {
  e.preventDefault(); 
  var formData = $(this).serialize(); 

  $.ajax({
      url: '/certificados/reexpedir/granel', 
      type: 'POST',
      data: formData,
      success: function (response) {
          console.log('Respuesta del servidor:', response);
          Swal.fire({
              icon: 'success',
              title: 'Éxito',
              text: response.message
          });
          $('#modalReexpedirCertificadoGranel').modal('hide');
          $('#addReexpedirCertificadoGranelForm')[0].reset();
          $('#campos_condicionales').slideUp();
          dt_instalaciones_table.ajax.reload();
      },
      error: function (error) {
          console.log(error);
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: error.responseJSON.message || 'Hubo un problema al procesar el formulario.'
          });
      }
  });
});

function cargarDatos(idCertificado) {
  if (!idCertificado) {
      console.warn("No se proporcionó un ID de certificado válido.");
      return;
  }

  $.ajax({
      url: `/edit-certificados/granel/${idCertificado}`,
      type: 'GET',
      success: function (response) {
          console.log('Datos recibidos del servidor:', response);

          // Llenar los campos con los datos obtenidos
          $('#num_dictamen_rex').val(response.id_dictamen).trigger('change');
          $('#id_firmante_rex').val(response.id_firmante).trigger('change');
          $('#num_certificado_rex').val(response.num_certificado);
          $('#fecha_vigencia_rex').val(response.fecha_vigencia);
          $('#fecha_vencimiento_rex').val(response.fecha_vencimiento);
          $('#observaciones_rex').val(response.observaciones);
      },
      error: function (error) {
          console.log(error);
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Hubo un problema al cargar los datos del certificado.'
          });
      }
  });
}

// Reiniciar campos al cerrar el modal
$('#modalReexpedirCertificadoGranel').on('hidden.bs.modal', function () {
  $('#addReexpedirCertificadoGranelForm')[0].reset(); 
  $('#campos_condicionales').slideUp();
});


$('#asignarRevisorModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var id_certificado = button.data('id'); 
  $('#id_certificado').val(id_certificado);
  console.log('ID Certificado al abrir modal:', id_certificado);
  fv.resetForm();
  form.reset();

  $('#asignarRevisorForm').show();
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
