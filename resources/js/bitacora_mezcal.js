'use strict';

$(function () {
  var dt_user_table = $('.datatables-users');

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
        url: baseUrl + 'bitacoraMezcal-list',
      },
      columns: [
        { data: '#' },                //0
        { data: 'fake_id' },          //1
        { data: 'fecha' },             //2
        { data: 'actions' },           //3
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
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $fecha = full['fecha'] ?? 'N/A';
            var $lote_a_granel = full['lote_a_granel'] ?? 'N/A';

            return '<br><span class="fw-bold text-dark small">Lote a Granel: </span>' +
              '<span class="small">' + $lote_a_granel + '</span>';
          }
        },
        {
          targets: 3,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $volumen_salidas = full['volumen_salidas'] ?? 'N/A';
            var $alcohol_salidas = full['alcohol_salidas'] ?? 'N/A';
            var $destino_salidas = full['destino_salidas'] ?? 'N/A';

            return '<span class="fw-bold text-dark small">Volumen de Salidas: </span>' +
              '<span class="small">' + $volumen_salidas + '</span>' +
              '<br><span class="fw-bold text-dark small">Alcohol de Salidas: </span>' +
              '<span class="small">' + $alcohol_salidas + '</span>' +
              '<br><span class="fw-bold text-dark small">Destino de Salidas: </span>' +
              '<span class="small">' + $destino_salidas + '</span>';
          }
        },
        {
          targets: 4,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $volumen_final = full['volumen_final'] ?? 'N/A';
            var $alcohol_final = full['alcohol_final'] ?? 'N/A';

            return '<span class="fw-bold text-dark small">Volumen Final: </span>' +
              '<span class="small">' + $volumen_final + '</span>' +
              '<br><span class="fw-bold text-dark small">Alcohol Final: </span>' +
              '<span class="small">' + $alcohol_final + '</span>';
          }
        },
        /*         {
                  // Abre el pdf Bitacora
                  targets: 5,
                  className: 'text-center',
                  render: function (data, type, full, meta) {
                    return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-id="${full['id']}" data-bs-target="#mostrarPdfDictamen1" data-bs-toggle="modal" data-bs-dismiss="modal"></i>`;

                  }
                }, */
        {
          // Actions
          targets: 5,
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
              `<a data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#editarBitacoraMezcal" class="dropdown-item edit-record waves-effect text-info">` +
              '<i class="ri-edit-box-line ri-20px text-info"></i> Editar' +
              '</a>' +
              // Botón para eliminar
              `<a data-id="${full['id']}" class="dropdown-item delete-record waves-effect text-danger">` +
              '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar' +
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
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        }
      },

      // Opciones Exportar Documentos
      buttons: [
        {
          text: '<i class="ri-eye-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Ver Bitácora</span>',
          className: 'btn btn-info waves-effect waves-light me-2',
          attr: {
            id: 'verBitacoraBtn'
          }
        },
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
              }
            },
            {
              extend: 'excel',
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
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
              }
            },
            {
              extend: 'pdf',
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
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
              }
            },
            {
              extend: 'copy',
              title: 'Certificados Instalaciones',
              text: '<i class="ri-file-copy-line me-1"></i>Copy',
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
              }
            }
          ]
        },
        {
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Bitácora</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#RegistrarBitacoraMezcal'
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de Certificado de Instalaciones: ' + data['num_certificado'];
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

  //FUNCIONES DEL FUNCIONAMIENTO DEL CRUD//
  $(document).on('click', '#verBitacoraBtn', function () {
    const iframe = $('#pdfViewer');
    const urlPDF = '/bitacora_mezcal'; // Ajusta si necesitas pasar un ID o token

    // Mostrar spinner y ocultar PDF
    $('#cargando').show();
    iframe.hide();

    // Reset iframe y botón
    iframe.attr('src', '');
    iframe.attr('src', urlPDF);
    $('#NewPestana').attr('href', urlPDF).hide();

    // Títulos del modal
    $('#titulo_modal').text('Bitácora Mezcal a Granel');
    $('#subtitulo_modal').text('Versión General');

    // Mostrar modal
    $('#mostrarPdf').modal('show');
  });

  // Mostrar PDF y botón cuando el iframe esté listo
  $('#pdfViewer').on('load', function () {
    $('#cargando').hide();
    $(this).show();
    $('#NewPestana').show();
  });

  // En caso de error (opcional)
  $('#pdfViewer').on('error', function () {
    console.error('Error al cargar el PDF. Verifica la ruta.');
    $('#cargando').hide();
  });



  $(function () {
    // Configuración de CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('registroInventarioForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el cliente'
            }
          }
        },
        fecha: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha'
            }
          }
        },
        id_lote_granel: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el lote'
            }
          }
        },
        volumen_salida: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen de salida'
            }
          }
        },
        alc_vol_salida: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el contenido alcohólico de salida'
            }
          }
        },
        destino: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el destino'
            }
          }
        },
        volumen_final: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen final'
            }
          }
        },
        alc_vol_final: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el contenido alcohólico final'
            }
          }
        },

      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: '.form-floating',
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      // Enviar datos por Ajax si el formulario es válido
      var formData = $(form).serialize();

      $.ajax({
        url: '/bitacoraMezcalStore',
        type: 'POST',
        data: formData,
        success: function (response) {
          // Ocultar el offcanvas
          $('#RegistrarBitacoraMezcal').modal('hide');
          $('#registroInventarioForm')[0].reset();
          $('.datatables-users').DataTable().ajax.reload();
          // Mostrar alerta de éxito
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
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al agregar la clase',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

        // Inicializar select2 y revalidar el campo cuando cambie
    $('#id_empresa, #id_lote_granel, #fecha').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });

  });



    $(document).on('click', '.edit-record', function () {
      var bitacoraID = $(this).data('id');
      $('#edit_bitacora_id').val(bitacoraID);
      $.ajax({
        url: '/bitacora_mezcal/' + bitacoraID + '/edit',
        method: 'GET',
        success: function (data) {
          if (data.success) {
            var bitacora = data.bitacora;

            $('#edit_bitacora_id').val(bitacora.id);
            $('#edit_id_empresa').val(bitacora.id_empresa).trigger('change');
            $('#edit_fecha').val(bitacora.fecha);
            $('#edit_id_lote_granel').data('selected', bitacora.id_lote_granel).trigger('change');
            $('#edit_id_instalacion').data('selected', bitacora.id_instalacion).trigger('change');
            $('#edit_volumen_salida').val(bitacora.volumen_salida);
            $('#edit_alc_vol_salida').val(bitacora.alc_vol_salida);
            $('#edit_destino').val(bitacora.destino);
            $('#edit_volumen_final').val(bitacora.volumen_final);
            $('#edit_alc_vol_final').val(bitacora.alc_vol_final);
            $('#edit_observaciones').val(bitacora.observaciones);
            $('#editarBitacoraMezcal').modal('show');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo cargar los datos.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        },
        error: function (error) {
          console.error('Error al cargar los datos', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar los datos.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });


    $(function () {
        // Configurar CSRF para Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Inicializar FormValidation
        const form = document.getElementById('editInventarioForm');
        const fv = FormValidation.formValidation(form, {
            fields: {
                id_empresa: {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona una empresa.'
                        }
                    }
                },
                id_lote_granel: {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona un lote a granel.'
                        }
                    }
                },
                volumen_salida: {
                    validators: {
                        notEmpty: {
                            message: 'Ingresa el volumen de salida.'
                        },
                        numeric: {
                            message: 'Debe ser un número.'
                        }
                    }
                },
                alc_vol_salida: {
                    validators: {
                        notEmpty: {
                            message: 'Ingresa el % Alc. Vol. de salida.'
                        },
                        numeric: {
                            message: 'Debe ser un número decimal.'
                        }
                    }
                },
                destino: {
                    validators: {
                        notEmpty: {
                            message: 'Ingresa el destino.'
                        }
                    }
                },
                volumen_final: {
                    validators: {
                        notEmpty: {
                            message: 'Ingresa el volumen final.'
                        },
                        numeric: {
                            message: 'Debe ser un número.'
                        }
                    }
                },
                alc_vol_final: {
                    validators: {
                        notEmpty: {
                            message: 'Ingresa el % Alc. Vol. final.'
                        },
                        numeric: {
                            message: 'Debe ser un número decimal.'
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
            const formData = $(form).serialize();
            const id = $('#edit_bitacora_id').val();

            $.ajax({
                url: '/bitacorasUpdate/' + id,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#editarBitacoraMezcal').modal('hide');
                    $('#editInventarioForm')[0].reset();
                    $('.datatables-users').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.success || 'La bitácora fue actualizada correctamente.',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Error al actualizar la bitácora.',
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



