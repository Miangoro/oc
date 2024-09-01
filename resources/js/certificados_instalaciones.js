'use strict';

document.addEventListener('DOMContentLoaded', function () {
  function updateMaestroMezcaleroVisibility(dictamenSelect, maestroMezcaleroContainer) {
      const selectedOption = dictamenSelect.options[dictamenSelect.selectedIndex];
      const tipoDictamen = selectedOption ? selectedOption.getAttribute('data-tipo-dictamen') : '';

      if (tipoDictamen === '1') {
          maestroMezcaleroContainer.style.display = 'block';
      } else {
          maestroMezcaleroContainer.style.display = 'none';
      }
  }

  function initializeAgregar() {
      const dictamenSelect = document.getElementById('id_dictamen');
      const maestroMezcaleroContainer = document.getElementById('maestroMezcaleroContainer');

      if (dictamenSelect && maestroMezcaleroContainer) {
          updateMaestroMezcaleroVisibility(dictamenSelect, maestroMezcaleroContainer);
          dictamenSelect.addEventListener('change', function () {
              updateMaestroMezcaleroVisibility(dictamenSelect, maestroMezcaleroContainer);
          });
      }
  }

  function initializeEdicion() {
      const dictamenSelect = document.getElementById('edit_id_dictamen');
      const maestroMezcaleroContainer = document.getElementById('edit_maestroMezcaleroContainer');

      if (dictamenSelect && maestroMezcaleroContainer) {
          updateMaestroMezcaleroVisibility(dictamenSelect, maestroMezcaleroContainer);
          dictamenSelect.addEventListener('change', function () {
              updateMaestroMezcaleroVisibility(dictamenSelect, maestroMezcaleroContainer);
          });
      }
  }
  initializeAgregar();
  initializeEdicion();
});


 $(function () {
 
   var dt_user_table = $('.datatables-users'),
     select2 = $('.select2'),
     userView = baseUrl + 'app/user/view/account',
     offCanvasForm = $('#offcanvasAddUser');
 
     var select2Elements = $('.select2');

     function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      select2Focus($this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent()
      });
    });
  }

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
     var dt_user = dt_user_table.DataTable({
       processing: true,
       serverSide: true,
       ajax: {
         url: baseUrl + 'certificados-list',
       },
       columns: [
         { data: '' },
         { data: 'num_dictamen' }, 
         { data: 'num_certificado' },
         { data: 'maestro_mezcalero' },
         { data: 'num_autorizacion' },
         { data: 'fecha_vigencia' },
         { data: 'fecha_vencimiento' },
         { data: 'Certificado' },
         { data: 'actions', orderable: false, searchable: false }
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
           targets: 3,
           render: function (data, type, full, meta) {
             var $num_dictamen = full['num_dictamen'];
             return '<span class="fw-bold">' + $num_dictamen + '</span>';
           }
         }, 
         {
            targets: 4,
            render: function (data, type, full, meta) {
              var $num_servicio = full['num_certificado'];
              return '<span class="user-email">' + $num_servicio + '</span>';
            }
          }, 
          {
            targets: 5,
            render: function (data, type, full, meta) {
              var $maestro_mezcalero = full['maestro_mezcalero'] ?? 'N/A';
              return '<span class="user-email">' + $maestro_mezcalero + '</span>';
            }
          },
          {
            targets: 6,
            render: function (data, type, full, meta) {
              var $num_autorizacion = full['num_autorizacion'];
              return '<span class="user-email">' + $num_autorizacion + '</span>';
            }
          },
          {
            targets: 7,
            render: function (data, type, full, meta) {
              var $fecha_vigencia = full['fecha_vigencia'];
              return '<span class="user-email">' + $fecha_vigencia + '</span>';
            }
          },
          {
            targets: 8,
            render: function (data, type, full, meta) {
              var $fecha_vencimiento = full['fecha_vencimiento'];
              return '<span class="user-email">' + $fecha_vencimiento + '</span>';
            }
          },
          {
            // Abre el pdf del certificado
            targets: 9,
            className: 'text-center',
            render: function (data, type, full, meta) {
             
              return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-tipo="${full['tipo_dictamen']}" data-id="${full['id_certificado']}" data-registro="${full['razon_social']} "></i>`;
            }
          },
         {
           // Actions
           targets: 10,
           title: 'Acciones',
           searchable: false,
           orderable: false,
           render: function (data, type, full, meta) {
             return (
               '<div class="d-flex align-items-center gap-50">' +
                   `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#editCertificadoModal"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
                   `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_certificado']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` +
                 '<div class="dropdown-menu dropdown-menu-end m-0">' +
                 '<a href="' + userView + '" class="dropdown-item">View</a>' +
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
             }
           ]
         },
         {
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Certificado</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#addCertificadoModal'
          }
        }
       ],
        responsive: {
         details: {
           display: $.fn.dataTable.Responsive.display.modal({
             header: function (row) {
               var data = row.data();
               return 'Detalles de ' + data['id_inspeccion'];
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
          url: `${baseUrl}certificados-list/${id_certificado}`,
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

  $(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    const formAddCertificado = document.getElementById('addCertificadoForm');
    const dictamenSelect = document.getElementById('id_dictamen');
    const maestroMezcaleroContainer = document.getElementById('maestroMezcaleroContainer');
  
    // Inicializa la validación del formulario
    const validator = FormValidation.formValidation(formAddCertificado, {
        fields: {
            'id_dictamen': {
                validators: {
                    notEmpty: {
                        message: 'El número de dictamen es obligatorio.'
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
                        message: 'La fecha no es válida.'
                    }
                }
            },
            'fecha_vencimiento': {
                validators: {
                    notEmpty: {
                        message: 'La fecha de vencimiento es obligatoria.',
                        enable: function (field) {
                            return !$(field).val();
                        }
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'La fecha no es válida.',
                        enable: function (field) {
                            return !$(field).val(); 
                        }
                    }
                }
            },
            'maestro_mezcalero': {
                validators: {
                    stringLength: {
                        max: 60,
                        message: 'El nombre del maestro mezcalero debe tener máximo 60 caracteres.'
                    }
                }
            },
            'num_autorizacion': {
                validators: {
                    notEmpty: {
                        message: 'El número de autorización es obligatorio.'
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
  
    function updateMaestroMezcaleroValidation() {
        const selectedOption = dictamenSelect.options[dictamenSelect.selectedIndex];
        const tipoDictamen = selectedOption ? selectedOption.getAttribute('data-tipo-dictamen') : '';
  
        if (tipoDictamen === '1') {
            maestroMezcaleroContainer.style.display = 'block';
            validator.addField('maestro_mezcalero', {
                validators: {
                    notEmpty: {
                        message: 'El nombre del maestro mezcalero es obligatorio'
                    }
                }
            });
        } else {
            maestroMezcaleroContainer.style.display = 'none';
            validator.removeField('maestro_mezcalero');
        }
    }
  
    function updateDatepickerValidation() {
        $('#fecha_vigencia').on('change', function() {
            var fechaVigencia = $(this).val();
            if (fechaVigencia) {
                var fecha = moment(fechaVigencia, 'YYYY-MM-DD');
                var fechaVencimiento = fecha.add(1, 'years').format('YYYY-MM-DD');
                $('#fecha_vencimiento').val(fechaVencimiento);
                
                validator.revalidateField('fecha_vigencia');
                validator.revalidateField('fecha_vencimiento');
            }
        });
  
        $('#fecha_vencimiento').on('change', function() {
            validator.revalidateField('fecha_vencimiento');
        });
    }
  
    validator.on('core.form.valid', function () {
        var fechaVigencia = $('#fecha_vigencia').val();
        var fechaVencimiento = $('#fecha_vencimiento').val();
        if (fechaVigencia) {
            $('#fecha_vigencia').val(moment(fechaVigencia).format('YYYY-MM-DD'));
        }
        if (fechaVencimiento) {
            $('#fecha_vencimiento').val(moment(fechaVencimiento).format('YYYY-MM-DD'));
        }
  
        var formData = $(formAddCertificado).serialize();
  
        $.ajax({
            url: '/certificados-list',
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log('Éxito:', response);
                $('#addCertificadoModal').modal('hide');
                $('#addCertificadoForm')[0].reset();
                dt_user.ajax.reload();
  
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
  
    dictamenSelect.addEventListener('change', updateMaestroMezcaleroValidation);
    updateMaestroMezcaleroValidation();
    updateDatepickerValidation();
  });

  $(document).ready(function() {
    // Escucha el clic en los botones de editar, ya sea en la tabla principal o en el modal responsivo de DataTables
    $(document).on('click', '.edit-record', function() {
      var id_certificado = $(this).data('id');
  
      // Cierra el modal responsivo de DataTables si está abierto
      var dtrModal = $('.dtr-bs-modal.show');
      if (dtrModal.length) {
        dtrModal.modal('hide');
      }
  
      // Solicita los datos del certificado para editar
      $.get(`/certificados-list/${id_certificado}/edit`)
        .done(function(data) {
          if (data.error) {
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: data.error,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
            return;
          }
  
          // Asigna los datos recibidos a los campos del formulario de edición
          $('#edit_id_certificado').val(data.id_certificado);
          $('#edit_id_dictamen').val(data.id_dictamen).trigger('change');
          $('#edit_numero_certificado').val(data.num_certificado);
          $('#edit_no_autorizacion').val(data.num_autorizacion);
          $('#edit_fecha_vigencia').val(data.fecha_vigencia);
          $('#edit_fecha_vencimiento').val(data.fecha_vencimiento);
  
          // Actualiza la visibilidad del campo "Maestro Mezcalero"
          updateMaestroMezcaleroVisibility(data.id_dictamen, data.maestro_mezcalero);
  
          // Muestra el modal de edición
          $('#editCertificadoModal').modal('show');
        })
        .fail(function() {
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'No se pudieron cargar los datos del certificado.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        });
    });
  
    // Función para actualizar la validación del datepicker y la fecha de vencimiento
    function updateDatepickerValidation() {
      $('#edit_fecha_vigencia').on('change', function() {
        var fechaVigencia = $(this).val();
        if (fechaVigencia) {
          var fecha = moment(fechaVigencia, 'YYYY-MM-DD');
          var fechaVencimiento = fecha.add(1, 'years').format('YYYY-MM-DD');
          $('#edit_fecha_vencimiento').val(fechaVencimiento);
        }
      });
    }
  
    // Llama a la función para habilitar la actualización de fecha
    updateDatepickerValidation();
  });
  

  $('#editCertificadoForm').on('submit', function(event) {
      event.preventDefault(); //
      var id_certificado = $('#edit_id_certificado').val();
      var formData = $(this).serialize(); 

      $.ajax({
          url: `/certificados-list/${id_certificado}`,
          type: 'PUT',
          data: formData,
          success: function(response) {
              Swal.fire({
                  icon: 'success',
                  title: '¡Éxito!',
                  text: response.message,
                  customClass: {
                      confirmButton: 'btn btn-success'
                  }
              });
              $('#editCertificadoModal').modal('hide');
              $('.datatables-users').DataTable().ajax.reload();
          },
          error: function(xhr) {
              Swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: 'No se pudieron actualizar los datos del certificado.',
                  customClass: {
                      confirmButton: 'btn btn-danger'
                  }
              });
          }
      });
    });
    
  function updateMaestroMezcaleroVisibility(dictamenId, maestroMezcalero) {
      const dictamenSelect = $('#edit_id_dictamen');
      const maestroMezcaleroContainer = $('#edit_maestroMezcaleroContainer');
      const tipoDictamen = dictamenSelect.find(`option[value="${dictamenId}"]`).data('tipo-dictamen');

      if (tipoDictamen == '1') {
          maestroMezcaleroContainer.show();
          $('#edit_maestro_mezcalero').val(maestroMezcalero === null ? '' : maestroMezcalero); 
      } else {
          maestroMezcaleroContainer.hide();
          $('#edit_maestro_mezcalero').val(''); 
      }
  }

  $('#edit_id_dictamen').on('change', function() {
      const dictamenId = $(this).val();
      const maestroMezcalero = $('#edit_maestro_mezcalero').val(); 

      updateMaestroMezcaleroVisibility(dictamenId, maestroMezcalero);
  });

  $('#editCertificadoModal').on('shown.bs.modal', function() {
      const dictamenId = $('#edit_id_dictamen').val();
      const maestroMezcalero = $('#edit_maestro_mezcalero').val(); 

      updateMaestroMezcaleroVisibility(dictamenId, maestroMezcalero);
  });

//Reciben los datos del pdf del dictamen
$(document).on('click', '.pdf', function () {
  var id = $(this).data('id');
  
  var registro = $(this).data('registro');
      var iframe = $('#pdfViewer');

      var tipo = $(this).data('tipo');
      

      if(tipo == 1 || tipo == 5){ // Productor
        var tipo_dictamen = '../certificado_productor_mezcal/'+id;
        var titulo = "Certificado de productor";
      }

      if(tipo == 2){ // Envasador
        var tipo_dictamen = '../certificado_envasador_mezcal/'+id;
        var titulo = "Certificado de envasador";
      }

      if(tipo == 3 || tipo  == 4){ // Comercializador
        var tipo_dictamen = '../certificado_comercializador/'+id;
        var titulo = "Certificado de comercializador";
      }



      iframe.attr('src', tipo_dictamen);

      $("#titulo_modal").text(titulo);
      $("#subtitulo_modal").text(registro);  
});


  //end
 });
 


