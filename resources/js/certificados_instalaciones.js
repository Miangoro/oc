'use strict';

 $(function () {
  var dt_user_table = $('.datatables-users');

  $('#asignarRevisorForm .select2').each(function () {
    var $this = $(this);
    $this.select2({
      dropdownParent: $this.closest('.form-floating')
    });
  });

  $('#addCertificadoModal .select2').each(function () {
    var $this = $(this);
    $this.select2({
      dropdownParent: $this.closest('.form-floating')
    });
  });

  $('#editCertificadoModal .select2').each(function () {
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
     var dt_user = dt_user_table.DataTable({
       processing: true,
       serverSide: true,
       ajax: {
         url: baseUrl + 'certificados-list',
       },
       columns: [
         { data: '' },                //0
         //{ data: 'fake_id' },          //1
         { data: 'Cliente' },          //2  
         { data: 'domicilio_instalacion' },          //3
   
         { data: 'num_certificado' }, //4
         { data: 'num_dictamen' },    //5
         { data: 'num_servicio' },    //6
         { data: 'fechas' },           //7
         { data: 'id_revisor' },       //8
         //{ data: 'Certificado' },
         //{ data: 'diasRestantes' }, //
         { data: 'estatus' },          //9
         { data: 'actions'},           //10
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
         /*{
           searchable: false,
           orderable: false,
           targets: 1,
           render: function (data, type, full, meta) {
             return `<span>${full.fake_id}</span>`;
           }
         },*/
         {
          targets: 1,
          render: function (data, type, full, meta) {
            var $numero_cliente = full['numero_cliente'];
            var $razon_social = full['razon_social'];
            return `
              <div>
                <span class="fw-bold">${$numero_cliente}</span><br>
                <small>${$razon_social}</small>
              </div>
            `;
          }
        },
         {
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $tipoDictamen = parseInt(full['tipo_dictamen']);
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
            return `<span class="badge rounded-pill bg-${$colorDictamen}">${$nombreDictamen}</span><br><small>${full['domicilio_instalacion']}</small>`;
          }     
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            var $num_certificado = full['num_certificado'];
            return '<span class="fw-bold">' + $num_certificado + '</span>' +
              `<i style class="ri-file-pdf-2-fill text-danger ri-28px pdf cursor-pointer" data-es="2" data-bs-target="#PdfDictamenIntalaciones" data-bs-toggle="modal" data-bs-dismiss="modal" data-tipo="${full['tipo_dictamen']}" data-id="${full['id_certificado']}" data-registro="${full['num_certificado']} "></i>`;
          }
        },
          {
           targets: 4,
           render: function (data, type, full, meta) {
             var $num_dictamen = full['num_dictamen'];
             return `<small>`+ $num_dictamen + `</small>` +
              `<i style class="ri-file-pdf-2-fill text-danger ri-28px pdf cursor-pointer" data-es="1" data-bs-target="#PdfDictamenIntalaciones" data-bs-toggle="modal" data-bs-dismiss="modal" data-tipo="${full['tipo_dictamen']}" data-id="${full['id_dictamen']}" data-registro="${full['num_dictamen']} "></i>`;
           }
         }, 
         {
          targets: 5,
          render: function (data, type, full, meta) {
            var $num_servicio = full['num_servicio'] ?? 'N/A';
            return '<small>' + $num_servicio + '</small>';
          }
        },
         
          {
            targets: 6, // Suponiendo que este es el índice de la columna que quieres actualizar
            render: function (data, type, full, meta) {
        
                // Obtener las fechas de vigencia y vencimiento, o 'N/A' si no están disponibles
                var $fecha_vigencia = full['fecha_vigencia'] ?? 'N/A'; // Fecha de vigencia
                var $fecha_vencimiento = full['fecha_vencimiento'] ?? 'N/A'; // Fecha de vencimiento
                
        
                // Definir los mensajes de fecha con formato
                var fechaVigenciaMessage = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Vigencia:<br></strong> ${$fecha_vigencia}</span>`;
                var fechaVencimientoMessage = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Vencimiento:<br></strong> ${$fecha_vencimiento}</span>`;
        
                // Retorna las fechas en formato de columnas
                return `
                    <div>
                        <div>${fechaVigenciaMessage}</div>
                        <div>${fechaVencimientoMessage}</div>
                        <div style="text-aling: center">${full['diasRestantes']}</div>
                    </div>
                `;
            }
          },   
          {
            targets: 7,
            render: function (data, type, full, meta) {
                var $revisor_oc = full['id_revisor'];   // Obtener el id_revisor
                var $revisor_consejo = full['id_revisor2']; // Obtener el id_revisor2
                return '<span class="small"> <b>OC:</b> <strong style="color: red;">' + $revisor_oc + '</strong></span> <br> <span class="small"><b>Consejo:</b> <strong style="color: red;">' + $revisor_consejo + '</strong></span>';
              /*
                // Mensajes para los revisores
                var revisorPersonal, revisorMiembro;
                // Para el revisor personal
                if (id_revisor !== 'Sin asignar') {
                    revisorPersonal = `<span class="badge" style="background-color: transparent; color:  #676B7B;"><strong>OC:</strong> ${id_revisor}</span>`;
                } else {
                    revisorPersonal = `<span class="badge" style="background-color: transparent; color:  #676B7B;"><strong>OC:</strong> <strong style="color: red;">Sin asignar</strong></span>`;
                }
                // Para el revisor miembro
                if (id_revisor2 !== 'Sin asignar') {
                    revisorMiembro = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Consejo:</strong> ${id_revisor2}</span>`;
                } else {
                    revisorMiembro = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Consejo:</strong> <strong style="color: red;">Sin asignar</strong></span>`;
                }
                // Retorna los revisores en formato HTML
                return ` <div style="display: flex; flex-direction: column;">
                        <div style="display: inline;">${revisorPersonal}</div>
                        <div style="display: inline;">${revisorMiembro}</div>
                    </div> `;
              */
            }
          },
          /*{
            // Abre el pdf del DICTAMEN
            targets: 9,
            className: 'text-center',
            render: function (data, type, full, meta) {
              return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-es="1" data-bs-target="#PdfDictamenIntalaciones" data-bs-toggle="modal" data-bs-dismiss="modal" data-tipo="${full['tipo_dictamen']}" data-id="${full['id_dictamen']}" data-registro="${full['num_dictamen']} "></i>`;
            }
          },
          {
            // Abre el pdf del certificado
            targets: 9,
            className: 'text-center',
            render: function (data, type, full, meta) {
              return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-es="2" data-bs-target="#PdfDictamenIntalaciones" data-bs-toggle="modal" data-bs-dismiss="modal" data-tipo="${full['tipo_dictamen']}" data-id="${full['id_certificado']}" data-registro="${full['num_certificado']} "></i>`;
            }
          },
          {
            targets: 9,
            render: function (data, type, full, meta) {
              return full['diasRestantes'];
            }
          },*/
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
        
                return `<span class="badge rounded-pill bg-${colorEstatus}">${badgeText}</span>`;
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
                  // Botón para editar
                  `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#editCertificadoModal" class="dropdown-item edit-record waves-effect text-info">` +
                    '<i class="ri-edit-box-line ri-20px text-info"></i> Editar' +
                  '</a>' +
                  // Botón para eliminar
                  `<a data-id="${full['id_certificado']}" class="dropdown-item delete-record waves-effect text-danger">` +
                    '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar' +
                  '</a>' +
                  // Botón adicional: Asignar revisor
                  `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#asignarRevisorModal" class="dropdown-item waves-effect text-info">` +
                    '<i class="text-warning ri-user-search-fill"></i> <span class="text-warning">Asignar revisor</span>' +
                  '</a>' +
                  // Botón para reexpedir certificado de instalaciones
                  `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#modalReexpedirCertificadoInstalaciones" class="dropdown-item reexpedir-record waves-effect text-info">` +
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
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo certificado</span>',
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
               return 'Detalles del certificado: ' + data['num_certificado'];
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

//Agregar
  $(document).ready(function () {
    const formAddCertificado = document.getElementById('addCertificadoForm');
    const dictamenSelect = $('#id_dictamen');
    const maestroMezcaleroContainer = document.getElementById('maestroMezcaleroContainer');
    const noAutorizacionContainer = document.getElementById('noAutorizacionContainer');

    const validator = FormValidation.formValidation(formAddCertificado, {
        fields: {
            'id_dictamen': {
                validators: {
                    notEmpty: {
                        message: 'El número de dictamen es obligatorio.'
                    }
                }
            },
            'id_firmante': {
                validators: {
                    notEmpty: {
                        message: 'El nombre del firmante es obligatorio.'
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

    const fieldsAdded = new Set();

    function updateMaestroMezcaleroValidation() {
        const selectedData = dictamenSelect.select2('data')[0];
        const tipoDictamen = selectedData ? selectedData.element.dataset.tipoDictamen : '';

        if (tipoDictamen === '1') {
            maestroMezcaleroContainer.style.display = 'block';

            if (!fieldsAdded.has('maestro_mezcalero')) {
                try {
                    validator.addField('maestro_mezcalero', {
                        validators: {
                            notEmpty: {
                                message: 'El nombre del maestro mezcalero es obligatorio'
                            }
                        }
                    });
                    fieldsAdded.add('maestro_mezcalero'); 
                } catch (error) {
                    console.error('Error al añadir la validación del campo maestro_mezcalero:', error);
                }
            }

            noAutorizacionContainer.style.display = 'block';

            if (!fieldsAdded.has('num_autorizacion')) {
                try {
                    validator.addField('num_autorizacion', {
                        validators: {
                            notEmpty: {
                                message: 'El número de autorización es obligatorio.'
                            },
                            numeric: {
                                message: 'El número de autorización debe ser numérico.'
                            }
                        }
                    });
                    fieldsAdded.add('num_autorizacion');
                } catch (error) {
                    console.error('Error al añadir la validación del campo num_autorizacion:', error);
                }
            }
        } else {
            maestroMezcaleroContainer.style.display = 'none';

            if (fieldsAdded.has('maestro_mezcalero')) {
                try {
                    validator.removeField('maestro_mezcalero');
                    fieldsAdded.delete('maestro_mezcalero'); 
                } catch (error) {
                    console.error('Error al eliminar la validación del campo maestro_mezcalero:', error);
                }
            }

            noAutorizacionContainer.style.display = 'none';

            if (fieldsAdded.has('num_autorizacion')) {
                try {
                    validator.removeField('num_autorizacion');
                    fieldsAdded.delete('num_autorizacion');
                } catch (error) {
                    console.error('Error al eliminar la validación del campo num_autorizacion:', error);
                }
            }
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
                $('#id_dictamen').val(null).trigger('change');
                $('#id_firmante').val(null).trigger('change');
                $('#num_certificado').val(null).trigger('change');
                maestroMezcaleroContainer.style.display = 'none'; 
                noAutorizacionContainer.style.display = 'none'; 
                fieldsAdded.clear(); 

                dt_user_table.DataTable().ajax.reload();

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

    // Revalidar Select2
    $('#id_dictamen, #id_firmante, #num_certificado').on('change', function() { 
        validator.revalidateField($(this).attr('name'));
    });

    dictamenSelect.on('change', updateMaestroMezcaleroValidation);
    updateMaestroMezcaleroValidation();
    updateDatepickerValidation();

    $('#addCertificadoModal').on('show.bs.modal', function () {
        validator.resetForm();
        fieldsAdded.clear();
    });
});



// Editar
$(document).ready(function() {
  const formEditCertificado = document.getElementById('editCertificadoForm');
  const validatorEdit = FormValidation.formValidation(formEditCertificado, {
      fields: {
          'id_dictamen': {
              validators: {
                  notEmpty: {
                      message: 'El número de dictamen es obligatorio.'
                  }
              }
          },
          'id_firmante': {
            validators: {
                notEmpty: {
                    message: 'El número de certificado es obligatorio.'
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
                      message: 'La fecha de vencimiento es obligatoria.'
                  },
                  date: {
                      format: 'YYYY-MM-DD',
                      message: 'La fecha no es válida.'
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
  }).on('core.form.valid', function() {
      var id_certificado = $('#edit_id_certificado').val();
      var formData = $(formEditCertificado).serialize();

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
          error: function() {
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

  let isMaestroMezcaleroValidated = false;
  let isAutorizacionValidated = false;

  function updateVisibility(dictamenId, maestroMezcalero, numAutorizacion) {
    const dictamenSelect = $('#edit_id_dictamen');
    const maestroMezcaleroContainer = $('#edit_maestroMezcaleroContainer');
    const autorizacionContainer = $('#edit_autorizacionContainer');
    const tipoDictamen = dictamenSelect.find(`option[value="${dictamenId}"]`).data('tipo-dictamen');

    if (tipoDictamen == '1') {
        maestroMezcaleroContainer.show();
        $('#edit_maestro_mezcalero').val(maestroMezcalero ? maestroMezcalero : '');

        if (!isMaestroMezcaleroValidated) {
            validatorEdit.addField('maestro_mezcalero', {
                validators: {
                    notEmpty: {
                        message: 'El nombre del maestro mezcalero es obligatorio.'
                    }
                }
            });
            isMaestroMezcaleroValidated = true;
        }
    } else {
        maestroMezcaleroContainer.hide();
        $('#edit_maestro_mezcalero').val('');

        if (isMaestroMezcaleroValidated) {
            validatorEdit.removeField('maestro_mezcalero');
            isMaestroMezcaleroValidated = false;
        }
    }

    if (tipoDictamen == '1') { 
        autorizacionContainer.show();
        $('#edit_num_autorizacion').val(numAutorizacion ? numAutorizacion : '');

        if (!isAutorizacionValidated) {
            validatorEdit.addField('num_autorizacion', {
                validators: {
                    notEmpty: {
                        message: 'El número de autorización es obligatorio.'
                    },
                    numeric: {
                        message: 'El número de autorización debe ser numérico.'
                    }
                }
            });
            isAutorizacionValidated = true;
        }
    } else {
        autorizacionContainer.hide();
        $('#edit_num_autorizacion').val('');

        if (isAutorizacionValidated) {
            validatorEdit.removeField('num_autorizacion');
            isAutorizacionValidated = false;
        }
    }
}


  $(document).on('click', '.edit-record', function() {
      var id_certificado = $(this).data('id');

      var dtrModal = $('.dtr-bs-modal.show');
      if (dtrModal.length) {
          dtrModal.modal('hide');
      }

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

              $('#edit_id_certificado').val(data.id_certificado);
              $('#edit_id_dictamen').val(data.id_dictamen).trigger('change');
              $('#edit_numero_certificado').val(data.num_certificado);
              $('#edit_no_autorizacion').val(data.num_autorizacion);
              $('#edit_fecha_vigencia').val(data.fecha_vigencia);
              $('#edit_fecha_vencimiento').val(data.fecha_vencimiento);
              $('#edit_id_firmante').val(data.id_firmante).trigger('change');

              updateVisibility(data.id_dictamen, data.maestro_mezcalero, data.num_autorizacion);

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

  $('#edit_fecha_vigencia').on('change', function() {
      var fechaVigencia = $(this).val();
      if (fechaVigencia) {
          var fecha = moment(fechaVigencia, 'YYYY-MM-DD');
          var fechaVencimiento = fecha.add(1, 'years').format('YYYY-MM-DD');
          $('#edit_fecha_vencimiento').val(fechaVencimiento);

          validatorEdit.revalidateField('fecha_vencimiento');
      }
  });

  $('#edit_id_dictamen').on('change', function() {
      const dictamenId = $(this).val();
      const maestroMezcalero = $('#edit_maestro_mezcalero').val();
      const numAutorizacion = $('#edit_num_autorizacion').val();
      updateVisibility(dictamenId, maestroMezcalero, numAutorizacion);
  });

  $('#editCertificadoModal').on('shown.bs.modal', function() {
    const dictamenId = $('#edit_id_dictamen').val();
    const maestroMezcalero = $('#edit_maestro_mezcalero').val();
    const numAutorizacion = $('#edit_num_autorizacion').val();
    updateVisibility(dictamenId, maestroMezcalero, numAutorizacion);
});
});

$(document).on('click', '.pdf', function () {
  var id = $(this).data('id');
  var registro = $(this).data('registro');
  var tipo = $(this).data('tipo');
  var es = $(this).data('es');

  var tipo_dictamen = '';
  var titulo = '';

  if(es==2){
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
  }else{
    if (tipo == 1 || tipo == 5) { // Productor
      tipo_dictamen = '../dictamen_productor/' + id;
      titulo = "Dictamen de productor";
    } else if (tipo == 2) { // Envasador
      tipo_dictamen = '../dictamen_envasador/' + id;
      titulo = "Dictamen de envasador";
    } else if (tipo == 3 || tipo == 4) { // Comercializador
      tipo_dictamen = '../dictamen_comercializador/' + id;
      titulo = "Dictamen de comercializador";
    }
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
});

$('#pdfViewerDictamen').on('load', function () {
  $('#loading-spinner').hide();
  $('#pdfViewerDictamen').show();
});


$(document).ready(function() {
  $('#tipoRevisor').on('change', function() {
      var tipoRevisor = $(this).val();

      $('#nombreRevisor').empty().append('<option value="">Seleccione un nombre</option>');

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
      url: '/asignar-revisor',
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

$('#asignarRevisorModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var id_certificado = button.data('id'); 
  $('#id_certificado').val(id_certificado);
  console.log('ID Certificado al abrir modal:', id_certificado);
  fv.resetForm();
  form.reset();

  $('#asignarRevisorForm').show();
});


//Reexpedicion y Cancelacion

//Evento para saber que certificado Reexpedir
let isLoadingData = false;
let fieldsValidated = []; 

$(document).ready(function () {
    $(document).on('click', '.reexpedir-record', function () {
        var id_certificado = $(this).data('id');
        console.log('ID Certificado para reexpedir:', id_certificado);
        $('#reexpedir_id_certificado').val(id_certificado);
        $('#modalReexpedirCertificadoInstalaciones').modal('show');
    });

    $('#fecha_vigencia_rex').on('change', function () {
        var fechaVigencia = $(this).val();
        if (fechaVigencia) {
            var fecha = moment(fechaVigencia, 'YYYY-MM-DD');
            var fechaVencimiento = fecha.add(1, 'years').format('YYYY-MM-DD');
            $('#fecha_vencimiento_rex').val(fechaVencimiento);
        }
    });

    $(document).on('change', '#accion_reexpedir', function () {
        var accionSeleccionada = $(this).val();
        console.log('Acción seleccionada:', accionSeleccionada);
        var id_certificado = $('#reexpedir_id_certificado').val();

        if (accionSeleccionada && !isLoadingData) {
            isLoadingData = true;
            cargarDatosReexpedicion(id_certificado);
        }

        if (accionSeleccionada === '2') {
            $('#campos_condicionales').slideDown();
        }else {
            $('#campos_condicionales').slideUp();
        }
    });

    $(document).on('change', '#id_dictamen_rex', function () {
      var tipoDictamen = $('#id_dictamen_rex option:selected').data('tipo-dictamen');
      console.log('Tipo de Dictamen seleccionado:', tipoDictamen);
  
      if (tipoDictamen === 1) {
          $('#campos_productor').show();
          addFieldValidation('maestro_mezcalero', 'El nombre del maestro mezcalero es obligatorio.');
          addFieldValidation('num_autorizacion', 'El campo No. Autorización es obligatorio.', true);
      } else {
          $('#campos_productor').hide(); 
          clearProductorFields();
          removeFieldValidation('maestro_mezcalero');
          removeFieldValidation('num_autorizacion');
      }
  
      const shouldShowProductorFields = $('#accion_reexpedir').val() === '2' && tipoDictamen === 1;
      if (shouldShowProductorFields) {
          $('#campos_productor').show();
      }

  });

  $(document).on('change', '#accion_reexpedir', function () {
    var accionSeleccionada = $(this).val();
    console.log('Acción seleccionada:', accionSeleccionada);
    var id_certificado = $('#reexpedir_id_certificado').val();

    let shouldShowProductorFields = false;

    if (accionSeleccionada && !isLoadingData) {
        isLoadingData = true;
        cargarDatosReexpedicion(id_certificado);
    }

    $('#campos_productor').hide(); 

    if (accionSeleccionada === '2') {
      $('#campos_condicionales').slideDown();
    }else {
        $('#campos_condicionales').slideUp();
    }

    const tipoDictamen = $('#id_dictamen_rex option:selected').data('tipo-dictamen');
    if (tipoDictamen === 1) {
        shouldShowProductorFields = true; 
    }

    if (shouldShowProductorFields) {
        $('#campos_productor').show();
    }
});
  
  function cargarDatosReexpedicion(id_certificado) {
      console.log('Cargando datos para la reexpedición con ID:', id_certificado);
      clearFields();
  
      $.get(`/certificados-list/${id_certificado}/edit`)
          .done(function (data) {
              console.log('Respuesta completa:', data);
  
              if (data.error) {
                  showError(data.error);
                  return;
              }
  
              $('#id_dictamen_rex').val(data.id_dictamen).trigger('change');
  
              $('#numero_certificado_rex').val(data.num_certificado);
              $('#id_firmante_rex').val(data.id_firmante).trigger('change');
              $('#fecha_vigencia_rex').val(data.fecha_vigencia);
              $('#fecha_vencimiento_rex').val(data.fecha_vencimiento);
              $('#observaciones_rex').val(data.observaciones);
  
              const tipoDictamen = $('#id_dictamen_rex option:selected').data('tipo-dictamen');
              console.log('Tipo de Dictamen seleccionado:', tipoDictamen);
              if (Number(tipoDictamen) === 1) {
                  $('#campos_productor').show(); 
                  $('#maestro_mezcalero_rex').val(data.maestro_mezcalero || ''); 
                  $('#no_autorizacion_rex').val(data.num_autorizacion || '');
                  console.log('Campos de Productor cargados y mostrados.');
              } else {
                  $('#campos_productor').hide(); 
                  clearProductorFields();
                  console.log('Campos de Productor ocultos porque el tipo no es 1.');
              }
  
              $('#accion_reexpedir').trigger('change'); 
              isLoadingData = false;
  
              console.log('Campos de productor visibles:', $('#campos_productor').is(':visible'));
          })
          .fail(function () {
              showError('No se pudieron cargar los datos para la reexpedición.');
              isLoadingData = false;
          });
  }
  
    function clearFields() {
        $('#maestro_mezcalero_rex').val('');
        $('#no_autorizacion_rex').val('');
        $('#numero_certificado_rex').val('');
        $('#id_firmante_rex').val('');
        $('#fecha_vigencia_rex').val('');
        $('#fecha_vencimiento_rex').val('');
        $('#observaciones_rex').val('');
    }

    function clearProductorFields() {
        $('#maestro_mezcalero_rex').val(''); 
        $('#no_autorizacion_rex').val(''); 
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: message,
            customClass: {
                confirmButton: 'btn btn-danger'
            }
        });
    }

    function addFieldValidation(field, message, isNumeric = false) {
        if (!fieldsValidated.includes(field)) {
            const validators = {
                notEmpty: {
                    message: message
                }
            };
            if (isNumeric) {
                validators.numeric = {
                    message: 'El campo debe contener solo números.'
                };
            }
            validatorReexpedir.addField(field, {
                validators: validators
            });
            fieldsValidated.push(field);
        }
    }

    function removeFieldValidation(field) {
        if (fieldsValidated.includes(field)) {
            validatorReexpedir.removeField(field);
            fieldsValidated = fieldsValidated.filter(f => f !== field);
        }
    }

    $('#modalReexpedirCertificadoInstalaciones').on('hidden.bs.modal', function () {
        $('#addReexpedirCertificadoInstalacionesForm')[0].reset();
        clearFields();
        $('#campos_condicionales').hide();
        $('#campos_productor').hide();
        fieldsValidated = []; 
    });

    const formReexpedir = document.getElementById('addReexpedirCertificadoInstalacionesForm');
    const validatorReexpedir = FormValidation.formValidation(formReexpedir, {
        fields: {
            'accion_reexpedir': {
                validators: {
                    notEmpty: {
                        message: 'Debes seleccionar una acción.'
                    }
                }
            },
            'observaciones': {
                validators: {
                    notEmpty: {
                        message: 'El motivo de cancelación es obligatorio.'
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
        const formData = $(formReexpedir).serialize();

        $.ajax({
            url: $(formReexpedir).attr('action'),
            method: 'POST',
            data: formData,
            success: function (response) {
                $('#modalReexpedirCertificadoInstalaciones').modal('hide');
                formReexpedir.reset();

                dt_user_table.DataTable().ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            },
            error: function (jqXHR) {
                console.log('Error en la solicitud:', jqXHR);
                let errorMessage = 'No se pudo registrar la reexpedición. Por favor, verifica los datos.';
                try {
                    let response = JSON.parse(jqXHR.responseText);
                    errorMessage = response.message || errorMessage;
                } catch (e) {
                    console.error('Error al parsear la respuesta del servidor:', e);
                }
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: errorMessage,
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            }
        });
    });
});

//end
});



