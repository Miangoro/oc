'use strict';
 $(document).ready(function () {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    language: 'es'
  });
});

//const { formatDate } = require("@fullcalendar/core/index.js");
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
  
  initializeSelect2(select2Elements);

  $('#fecha_emision').on('change', function() {
    var fechaInicial = new Date($(this).val());
    fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
    var year = fechaInicial.getFullYear();
    var month = ('0' + (fechaInicial.getMonth() + 1)).slice(-2);
    var day = ('0' + fechaInicial.getDate()).slice(-2);
    
    $('#fecha_vigencia').val(year + '-' + month + '-' + day).trigger('change');
});

$('#edit_fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
  var year = fechaInicial.getFullYear();
  var month = ('0' + (fechaInicial.getMonth() + 1)).slice(-2);
  var day = ('0' + fechaInicial.getDate()).slice(-2);
  
  $('#edit_fecha_vigencia').val(year + '-' + month + '-' + day).trigger('change');

  // Revalidar el campo edit_fecha_vigencia
  fv.revalidateField('edit_fecha_vigencia');
});

 
   // ajax setup
   $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
 
   //FUNCIONALIDAD DE LA VISTA datatable
   if (dt_user_table.length) {
     var dt_user = dt_user_table.DataTable({
       processing: true,
       serverSide: true,
       ajax: {
         url: baseUrl + 'insta'
       },
       columns: [
         { data: '' },
         { data: '' },
         { data: 'tipo_dictamen' },
         { data: 'num_dictamen' },
         { data: 'num_servicio' },
         { data: 'razon_social' },
         { data: 'fecha_emision' },
         { data: '' },
         { data: 'action' }
 
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
         {//Tabla 1
           searchable: false,
           orderable: false,
           targets: 1,
           render: function (data, type, full, meta) {
             return `<span>${full.fake_id}</span>`;
           }
         },
         {
           // Tabla 2
           targets: 2,
           responsivePriority: 4,
           render: function (data, type, full, meta) {
             var $name = full['tipo_dictamen'];
             if ($name == 1){
                return '<span class="text-primary">Productor</span>';
             }
             else if($name == 2){ 
                    return '<span class="text-success">Envasador</span>';
             }
             else if($name == 3){ 
                return '<span class="text-info">Comercializador</span>';
            }
            else if($name == 4){ 
                return '<span class="text-danger">Almacén y bodega</span>';
            }
            else if($name == 5){ 
              return '<span class="text-warning">Área de maduración</span>';
            }
           }
         },
          {
           // Tabla 3
           targets: 3,
           render: function (data, type, full, meta) {
             var $num_dictamen = full['num_dictamen'];
             return '<span class="fw-bold">' + $num_dictamen + '</span>';
           }
         }, 
         {
            // Tabla 4
            targets: 4,
            render: function (data, type, full, meta) {
              var $num_servicio = full['num_servicio'];
              return '<span class="user-email">' + $num_servicio + '</span>';
            }
          }, 
          {
            // Tabla 5
            targets: 6,
            render: function (data, type, full, meta) {
              var $fecha = full['fecha_emision'];
              return '<span class="user-email">' + $fecha + '</span>';
            }
          },
          {
            // Abre el pdf del dictamen
            targets: 7,
            className: 'text-center',
            render: function (data, type, full, meta) {
              var $id = full['id_guia'];
              return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-tipo="${full['tipo_dictamen']}" data-id="${full['id_dictamen']}" data-registro="${full['razon_social']} "></i>`;
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
/*               `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_dictamen']} data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editDictamen"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
              `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_dictamen']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` + */
                   `<a data-id="${full['id_dictamen']}" data-bs-toggle="modal" data-bs-target="#editDictamen" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar dictamen</a>` +
                   `<a data-id="${full['id_dictamen']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar dictamen</a>` +
                   //'<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line ri-20px"></i></button>' +
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
       lengthMenu: [10, 20, 50, 70, 100], //for length of menu
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
 
       buttons: [
         {
           extend: 'collection',
           className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
           text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
           buttons: [
             {
               extend: 'print',
               title: 'Categorías de Agave',
               text: '<i class="ri-printer-line me-1" ></i>Print',
               className: 'dropdown-item',
               exportOptions: {
                 columns: [1, 2, 3],
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
                 columns: [1, 2, 3],
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
               title: 'Categorías de Agave',
               text: '<i class="ri-file-excel-line me-1"></i>Excel',
               className: 'dropdown-item',
               exportOptions: {
                 columns: [1, 2, 3],
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
               title: 'Categorías de Agave',
               text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
               className: 'dropdown-item',
               exportOptions: {
                 columns: [1, 2, 3],
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
               title: 'Categorías de Agave',
               text: '<i class="ri-file-copy-line me-1"></i>Copy',
               className: 'dropdown-item',
               exportOptions: {
                 columns: [1, 2, 3],
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
           text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Dictamen</span>',
           className: 'add-new btn btn-primary waves-effect waves-light',
           attr: {
             /*'data-bs-toggle': 'offcanvas',
             'data-bs-target': '#offcanvasAddUser'*/
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#addDictamen'
           }
         }
       ],
 
      //PAGINA RESPONSIVA
       responsive: {
         details: {
           display: $.fn.dataTable.Responsive.display.modal({
             header: function (row) {
               var data = row.data();
               return 'Detalles de ' + data['num_dictamen'];
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

   //Agregar
   $(document).ready(function () {
    const NuevoDictamen = document.getElementById('NuevoDictamen');
    const fv = FormValidation.formValidation(NuevoDictamen, {
        fields: {
            tipo_dictamen: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione una opción'
                    }
                }
            },
            num_dictamen: {
                validators: {
                    notEmpty: {
                        message: 'Introduzca el no. de dictamen'
                    }
                }
            },
            fecha_emision: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione una fecha'
                    }
                }
            },
            fecha_vigencia: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione una fecha'
                    }
                }
            },
            id_inspeccion: {
                validators: {
                    notEmpty: {
                        message: 'Seleccione una opción'
                    }
                }
            },
            'categorias[]': {
                validators: {
                    notEmpty: {
                        message: 'Seleccione al menos una categoría de agave'
                    }
                }
            },
            'clases[]': {
                validators: {
                    notEmpty: {
                        message: 'Seleccione al menos una clase de agave'
                    }
                }
            },
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
        var categorias = $('#categorias').val(); 
        var clases = $('select[name="clases[]"]').val();
        var categoriasString = Array.isArray(categorias) ? categorias.join(',') : categorias;
        var clasesString = Array.isArray(clases) ? clases.join(',') : clases;

        var formData = $(NuevoDictamen).serializeArray(); 
        formData.push({ name: 'categorias', value: categoriasString }); 
        formData.push({ name: 'clases', value: clasesString });

        $.ajax({
            url: '/insta',
            type: 'POST',
            data: $.param(formData),
            success: function (response) {
                $('#addDictamen').modal('hide'); 
                NuevoDictamen.reset();
                dt_user.ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.success,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
                $('#id_inspeccion').val(null).trigger('change'); 
                $('#categorias').val(null).trigger('change'); 
                $('select[name="clases[]"]').val(null).trigger('change'); 
            },
            error: function (xhr) {
                console.log('Error:', xhr);
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error al subir!',
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            }
        });
    });

    $('#id_inspeccion').on('change', function() {
        fv.revalidateField($(this).attr('name'));
    });
    $('#categorias').on('change', function() {
        fv.revalidateField('categorias[]');
    });
    $('select[name="clases[]"]').on('change', function() {
        fv.revalidateField('clases[]');
    });
    $('#num_dictamen, #fecha_emision, #fecha_vigencia').on('change', function() {
        fv.revalidateField($(this).attr('name'));
    });
    $('#addDictamen').on('hidden.bs.modal', function () {
        fv.resetForm(); 
        NuevoDictamen.reset(); 
    });

    $('#addDictamen').on('show.bs.modal', function () {
      fv.resetForm(); 
  });
});

  //Editar
   $(document).ready(function() {
    $('.datatables-users').on('click', '.edit-record', function() {
        var id_dictamen = $(this).data('id');
  
        $.get('/insta/' + id_dictamen + '/edit', function(data) {
            $('#edit_id_dictamen').val(data.id_dictamen);
            $('#edit_tipo_dictamen').val(data.tipo_dictamen);
            $('#edit_num_dictamen').val(data.num_dictamen);
            $('#edit_fecha_emision').val(data.fecha_emision);
            $('#edit_fecha_vigencia').val(data.fecha_vigencia);
            $('#edit_id_inspeccion').val(data.id_inspeccion);
  
            var categorias = Array.isArray(data.categorias) ? data.categorias : data.categorias.split(',');
            var clases = Array.isArray(data.clases) ? data.clases : data.clases.split(',');
  
            $('#edit_categorias').val(categorias).trigger('change');
            $('#edit_clases').val(clases).trigger('change');
              $('#editDictamen').modal('show');
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Error al obtener los datos',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        });
    });
    $(document).ready(function () {
      const EditarDictamen = document.getElementById('EditarDictamen');
  
      const fv = FormValidation.formValidation(EditarDictamen, {
          fields: {
              tipo_dictamen: {
                  validators: {
                      notEmpty: {
                          message: 'Seleccione una opción'
                      }
                  }
              },
              num_dictamen: {
                  validators: {
                      notEmpty: {
                          message: 'Introduzca el no. de dictamen'
                      }
                  }
              },
              fecha_emision: {
                  validators: {
                      notEmpty: {
                          message: 'Seleccione una fecha'
                      }
                  }
              },
              fecha_vigencia: {
                  validators: {
                      notEmpty: {
                          message: 'Seleccione una fecha'
                      }
                  }
              },
              id_inspeccion: {
                  validators: {
                      notEmpty: {
                          message: 'Seleccione una opción'
                      }
                  }
              },
              'categorias[]': {
                  validators: {
                      notEmpty: {
                          message: 'Seleccione al menos una categoría de agave'
                      }
                  }
              },
              'clases[]': {
                  validators: {
                      notEmpty: {
                          message: 'Seleccione al menos una clase de agave'
                      }
                  }
              },
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
          var categorias = $('#edit_categorias').val(); 
          var clases = $('#edit_clases').val();
          if (!Array.isArray(clases) || clases.length === 0) {
              Swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: 'Seleccione al menos una clase de agave',
                  customClass: {
                      confirmButton: 'btn btn-danger'
                  }
              });
              return; 
          }
  
          var categoriasString = Array.isArray(categorias) ? categorias.join(',') : categorias; 
          var clasesString = Array.isArray(clases) ? clases.join(',') : clases; 
  
          var formData = $(EditarDictamen).serializeArray(); 
          formData.push({ name: 'categorias', value: categoriasString });
          formData.push({ name: 'clases', value: clasesString }); 
          var id_dictamen = $('#edit_id_dictamen').val();
  
          $.ajax({
              url: '/insta/' + id_dictamen,
              type: 'PUT',
              data: $.param(formData), 
              success: function (response) {
                  $('#editDictamen').modal('hide'); 
                  EditarDictamen.reset();
                  $('#edit_categorias').val(null).trigger('change');
                  $('#edit_clases').val(null).trigger('change');
                  $('.datatables-users').DataTable().ajax.reload(null, false);
  
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
                  console.log('Error:', xhr);
                  Swal.fire({
                      icon: 'error',
                      title: '¡Error!',
                      text: 'Error al actualizar el dictamen',
                      customClass: {
                          confirmButton: 'btn btn-danger'
                      }
                  });
              }
          });
      });
  });
});

  // Eliminar registro
  $(document).on('click', '.delete-record', function () {
    var id_dictamen = $(this).data('id');
    var dtrModal = $('.dtr-bs-modal.show');

    if (dtrModal.length) {
        dtrModal.modal('hide');
    }

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

          $.ajax({
                type: 'DELETE',
                url: `${baseUrl}insta/${id_dictamen}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    dt_user.draw();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: '¡El Dictamen ha sido eliminada correctamente!',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                },
                error: function (error) {
                    console.log(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar el dictamen. Inténtalo de nuevo más tarde.',
                        footer: `<pre>${error.responseText}</pre>`,
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }

            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: 'Cancelado',
                text: 'La eliminación del Dictamen ha sido cancelada',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});

//Reciben los datos del pdf del dictamen
$(document).on('click', '.pdf', function () {
  var id = $(this).data('id');
  var registro = $(this).data('registro');
      var iframe = $('#pdfViewer');

      var tipo = $(this).data('tipo');

      if(tipo == 1){ // Productor
        var tipo_dictamen = '../dictamen_productor/'+id;
        var titulo = "Dictamen de productor";
      }

      if(tipo == 2){ // Envasador
        var tipo_dictamen = '../dictamen_envasador/'+id;
        var titulo = "Dictamen de envasador";
      }

      if(tipo == 3){ // Comercializador
        var tipo_dictamen = '../dictamen_comercializador/'+id;
        var titulo = "Dictamen de comercializador";
      }

      if(tipo == 4){ // Almacén y bodega
        var tipo_dictamen = '../dictamen_almacen/'+id;
        var titulo = "Dictamen de almacén y bodega";
      }

      if(tipo == 5){ // Área de maduración
        var tipo_dictamen = '../dictamen_maduracion/'+id;
        var titulo = "Dictamen de área de maduración de mezcal";
      }
      

      iframe.attr('src', tipo_dictamen);

      $("#titulo_modal").text(titulo);
      $("#subtitulo_modal").text(registro);  
});

//end
});
 


