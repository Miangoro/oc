/**
 * Page User List
 */

'use strict';


$(function () {

    var dt_user_table = $('.datatables-users'),
        select2Elements = $('.select2')
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
    /* lo del select de arriba lo puedo quitar "creo" */
    // ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //DATE PICKER

    $(document).ready(function () {

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

    });

    // Users datatable
    if (dt_user_table.length) {
        var dt_user = dt_user_table.DataTable({

            processing: true,
            serverSide: true,
            ajax: {
                url: baseUrl + 'dictamen-envasado-list', // Asegúrate de que esta URL coincida con la ruta en tu archivo de rutas
                type: 'GET'
            },
            columns: [
                { data: null, defaultContent: '' },
                { data: 'id_dictamen_envasado' },
                { data: 'num_dictamen' },
                { data: 'id_empresa' },
                { data: 'id_inspeccion' },
                { data: 'id_lote_envasado' },
                { data: 'fecha_emision' },
                { data: 'fecha_vigencia' },
                { data: 'fecha_servicio' },
                { data: null, defaultContent: '' },
                {
                    data: 'estatus',
                    searchable: false, orderable: false,
                    render: function (data, type, row) {
                        var estatusClass = '';
                        if (data === 'Emitido') {
                            estatusClass = 'badge rounded-pill bg-success';
                        } else if (data === 'Cancelado') {
                            estatusClass = 'badge rounded-pill bg-danger';
                        }
                        return '<span class="' + estatusClass + '">' + data + '</span>';
                    }
                },
                { data: 'action', orderable: false, searchable: false }
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
                    orderable: true,
                    targets: 1,
                    render: function (data, type, full, meta) {
                        return `<span>${full.fake_id}</span>`;
                    }
                },

                {
                    // User full name
                    targets: 2,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        var $name = full['num_dictamen'];

                        // For Avatar badge
                        var stateNum = Math.floor(Math.random() * 6);
                        var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                        var $state = states[stateNum];

                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-start align-items-center user-name">' +
                            '<div class="avatar-wrapper">' +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<span class="fw-medium">' +
                            $name +
                            '</span>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    // Abre el pdf del dictamen
                    targets: 9,
                    className: 'text-center',
                    searchable: false, orderable: false,
                    render: function (data, type, full, meta) {
                        var $id = full['id_dictamen_envasado'];
                        return '<i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-id="' + $id + '" data-bs-target="#mostrarPdfDictamen" data-bs-toggle="modal" data-bs-dismiss="modal"></i>';
                    }
                },

                {
                    // Actions botones de eliminar y actualizar(editar)
                    targets: -1,
                    title: 'Acciones',
                    searchable: false,
                    orderable: true,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="d-flex align-items-center gap-50">' +
                            '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>' +
                            '<div class="dropdown-menu dropdown-menu-end m-0">' +
                            `<a data-id="${full['id_dictamen_envasado']}" data-bs-toggle="modal" data-bs-target="#modalEditDictamenEnvasado" class="dropdown-item edit-record waves-effect text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>` +
                            `<a data-id="${full['id_dictamen_envasado']}" data-bs-toggle="modal" data-bs-target="#modalReexpredirDictamenEnvasado" class="dropdown-item reexpedir-record waves-effect text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Reexpedir dictamen</a>` +
                            `<a data-id="${full['id_dictamen_envasado']}" class="dropdown-item delete-record waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>` +
                            '<div class="dropdown-menu dropdown-menu-end m-0">' +
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
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            // Buttons with Dropdown
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
                    text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
                    buttons: [
                        {
                            extend: 'print',
                            title: 'Dictamenes envasado',
                            text: '<i class="ri-printer-line me-1" ></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                                // prevent avatar to be print
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {

                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                if (item.lastChild && item.lastChild.firstChild) {
                                                    result = result + item.lastChild.firstChild.textContent;
                                                }
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else {
                                                result = result + item.innerText;
                                            }
                                        });

                                        return result;
                                    }
                                }
                            },
                            customize: function (win) {
                                //customize print view for dark
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
                            title: 'Dictamenes envasado',
                            text: '<i class="ri-file-text-line me-1" ></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                                // prevent avatar to be print
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {

                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                if (item.lastChild && item.lastChild.firstChild) {
                                                    result = result + item.lastChild.firstChild.textContent;
                                                }
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else {
                                                result = result + item.innerText;
                                            }

                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            title: 'Dictamenes envasado',
                            text: '<i class="ri-file-excel-line me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                if (item.lastChild && item.lastChild.firstChild) {
                                                    result = result + item.lastChild.firstChild.textContent;
                                                }
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else {
                                                result = result + item.innerText;
                                            }
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            title: 'Dictamenes envasado',
                            text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                if (item.lastChild && item.lastChild.firstChild) {
                                                    result = result + item.lastChild.firstChild.textContent;
                                                }
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else {
                                                result = result + item.innerText;
                                            }
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'copy',
                            title: 'Dictamenes envasado',
                            text: '<i class="ri-file-copy-line me-1"></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                                // prevent avatar to be copy
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                if (item.lastChild && item.lastChild.firstChild) {
                                                    result = result + item.lastChild.firstChild.textContent;
                                                }
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else {
                                                result = result + item.innerText;
                                            }
                                        });
                                        return result;
                                    }
                                }
                            }
                        }
                    ]
                },
                {
                    text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar dictamen envasado</span>',
                    className: 'add-new btn btn-primary waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#modalAddDictamenEnvasado'
                    }
                }
            ],


            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Detalles del destino ';
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
    }

    // Delete Record eliminar un dictamen
    $(document).on('click', '.delete-record', function () {
        var id_dictamen = $(this).data('id'); // Obtener el ID de la clase
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
                    url: `${baseUrl}dictamen/envasado/${id_dictamen}`,
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
                            text: '¡El dictamen ha sido eliminado correctamente!',
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
                            text: 'No se pudo eliminar el dictamen.',
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
                    text: 'La eliminación del dictamen ha sido cancelada',
                    icon: 'info',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            }
        });
    });
    /* funcion para ingresar un nuevo dictamen*/

    /* agregar un nuevo dictamen */
    $(function () {
        // Configuración CSRF para Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Inicializar FormValidation
        const form = document.getElementById('addNewDictamenEnvasadoForm');
        const fv = FormValidation.formValidation(form, {
            fields: {
                'num_dictamen': {
                    validators: {
                        notEmpty: {
                            message: 'El número de dictamen es obligatorio.'
                        },
                    }
                },
                'id_empresa': {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona una empresa cliente.'
                        }
                    }
                },
                'id_inspeccion': {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona el número de servicio.'
                        }
                    }
                },
                'id_lote_envasado': {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona el lote.'
                        }
                    }
                },
                'fecha_emision': {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de emisión es obligatoria.',
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).',
                        }
                    }
                },
                'fecha_vigencia': {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de vigencia es obligatoria.',
                            enable: function (field) {
                                return !$(field).val();
                            }
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).',
                        }
                    }
                },
                'fecha_servicio': {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de servicio es obligatoria.',
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).',
                        }
                    }
                },
                'id_firmante': {
                    validators: {
                        notEmpty: {
                            message: 'El nombre del firmante es obligatorio.',
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
            var formData = new FormData(form);
            $.ajax({
                url: '/dictamenes-envasado',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // Ocultar el modal y resetear el formulario
                    $('#modalAddDictamenEnvasado').modal('hide');
                    $('#addNewDictamenEnvasadoForm')[0].reset();
                    $('.select2').val(null).trigger('change');
                    $('.datatables-users').DataTable().ajax.reload();

                    // Mostrar mensaje de éxito
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
                    // Mostrar mensaje de error
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Error al registrar el dictamen de granel',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            });
        });

        // Inicializar select2
        $('#id_empresa, #id_inspeccion, #id_lote_envasado, #fecha_emision, #fecha_vigencia, #fecha_servicio, #id_firmante').on('change', function () {
            // Revalidar el campo cuando se cambia el valor del select2
            fv.revalidateField($(this).attr('name'));
        });
    });

    
    /* editar el dictamen envasado */
    $(function () {
        // Configuración CSRF para Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Inicializar FormValidation para el formulario de creación y edición
        const form = document.getElementById('addNEditDictamenEnvasadoForm');
        const fv = FormValidation.formValidation(form, {
            fields: {
                'num_dictamen': {
                    validators: {
                        notEmpty: {
                            message: 'El número de dictamen es obligatorio.'
                        },
                    }
                },
                'id_empresa': {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona una empresa cliente.'
                        }
                    }
                },
                'id_inspeccion': {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona el número de servicio.'
                        }
                    }
                },
                'id_lote_envasado': {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona el lote.'
                        }
                    }
                },
                'fecha_emision': {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de emisión es obligatoria.'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
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
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
                        }
                    }
                },
                'fecha_servicio': {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de servicio es obligatoria.'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
                        }
                    }
                },
                'id_firmante': {
                    validators: {
                        notEmpty: {
                            message: 'El nombre del firmante es obligatorio.',
                            enable: function (field) {
                                return !$(field).val();
                            }
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
            // Validar y enviar el formulario cuando pase la validación
            var formData = new FormData(form);
            var dictamenid = $('#edit_id_dictamen').val();

            $.ajax({
                url: '/dictamenes/envasado/' + dictamenid + '/update',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    dt_user.ajax.reload();
                    $('#modalEditDictamenEnvasado').modal('hide');
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
                        var errorMessages = Object.keys(errors).map(function (key) {
                            return errors[key].join('<br>');
                        }).join('<br>');

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
                            text: 'Ha ocurrido un error al actualizar el dictamen.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                }
            });
        });

        // Función del botón de editar para cargar los datos del dictamen
        $(document).on('click', '.edit-record', function () {
            var id_dictamen = $(this).data('id');
            $('#edit_id_dictamen').val(id_dictamen);

            $.ajax({
                url: '/dictamenes/envasado/' + id_dictamen + '/edit',
                method: 'GET',
                success: function (data) {
                    if (data.success) {
                        var dictamen = data.dictamen;
                        // Asignar valores a los campos del formulario
                        $('#edit_num_dictamen').val(dictamen.num_dictamen);
                        $('#edit_id_empresa').val(dictamen.id_empresa).trigger('change');
                        $('#edit_id_inspeccion').val(dictamen.id_inspeccion).trigger('change');
                        $('#edit_id_lote_envasado').data('selectedLote', dictamen.id_lote_envasado); // Guardar el lote seleccionado
                        $('#edit_fecha_emision').val(dictamen.fecha_emision);
                        $('#edit_fecha_vigencia').val(dictamen.fecha_vigencia);
                        $('#edit_fecha_servicio').val(dictamen.fecha_servicio);
                        $('#edit_id_firmante').val(dictamen.id_firmante).trigger('change');
                        // Mostrar el modal
                        $('#modalEditDictamenEnvasado').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo cargar los datos del dictamen envasado.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                },
                error: function (error) {
                    console.error('Error al cargar los datos del dictamen envasado:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar los datos del dictamen envasado.',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            });
        });

        // Inicializar select2
        $('#edit_fecha_emision, #edit_fecha_vigencia, #edit_fecha_servicio').on('change', function () {
            // Revalidar el campo cuando se cambia el valor del select2
            fv.revalidateField($(this).attr('name'));
        });
    });

    /* reexpedir dictamen a granel */
    $(function () {
        // Configuración CSRF para Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Variables para almacenar los valores originales
        var originalValues = {};

        // Inicializar FormValidation para el formulario de creación y edición
        const form = document.getElementById('addReexpedirDictamenEnvasadoForm');
        const fv = FormValidation.formValidation(form, {
            fields: {
                num_dictamen: {
                    validators: {
                        notEmpty: {
                            message: 'El número de dictamen es obligatorio.'
                        },
                    }
                },
                id_empresa: {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona una empresa cliente.'
                        }
                    }
                },
                id_inspeccion: {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona el número de servicio.'
                        }
                    }
                },
                id_lote_envasado: {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona el lote.'
                        }
                    }
                },
                fecha_emision: {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de emisión es obligatoria.'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
                        }
                    }
                },
                fecha_vigencia: {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de vigencia es obligatoria.'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
                        }
                    }
                },
                fecha_servicio: {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de servicio es obligatoria.'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).'
                        }
                    }
                },
                id_firmante: {
                    validators: {
                        notEmpty: {
                            message: 'El nombre del firmante es obligatorio.'
                        }
                    }
                },
                observaciones: {
                    validators: {
                        notEmpty: {
                            message: 'El motivo de la cancelación es obligatorio.'
                        },
                    }
                },
                cancelar_reexpedir: {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona una opción.'
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
            // Enviar el formulario cuando la validación es exitosa
            var formData = new FormData(form);
            var dictamenid = $('#reexpedir_id_dictamen').val();

            $.ajax({
                url: '/dictamenes/envasado/' + dictamenid + '/reexpedir',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    dt_user.ajax.reload(); // Recargar la tabla de datos
                    $('#modalReexpredirDictamenEnvasado').modal('hide'); // Cerrar el modal
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
                        var errorMessages = Object.keys(errors).map(function (key) {
                            return errors[key].join('<br>');
                        }).join('<br>');

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
                            text: 'Ha ocurrido un error al actualizar el dictamen.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                }
            });
        });

        // Guardar los valores originales cuando se edita un dictamen
        $(document).on('click', '.reexpedir-record', function () {
            var id_dictamen = $(this).data('id');
            $('#reexpedir_id_dictamen').val(id_dictamen);

            $.ajax({
                url: '/dictamenes/envasado/' + id_dictamen + '/edit',
                method: 'GET',
                success: function (data) {
                    if (data.success) {
                        var dictamen = data.dictamen;

                        // Asignar valores a los campos del formulario
                        $('#reexpedir_num_dictamen').val(dictamen.num_dictamen);
                        $('#reexpedir_id_empresa').val(dictamen.id_empresa).trigger('change');
                        $('#reexpedir_id_inspeccion').val(dictamen.id_inspeccion).trigger('change');
                        $('#reexpedir_id_lote_envasado').data('selectedLote', dictamen.id_lote_envasado);
                        $('#reexpedir_fecha_emision').val(dictamen.fecha_emision);
                        $('#reexpedir_fecha_vigencia').val(dictamen.fecha_vigencia);
                        $('#reexpedir_fecha_servicio').val(dictamen.fecha_servicio);
                        $('#reexpedir_id_firmante').val(dictamen.id_firmante).trigger('change');

                        // Guardar los valores originales en un objeto
                        originalValues = {
                            num_dictamen: dictamen.num_dictamen,
                            id_empresa: dictamen.id_empresa,
                            id_inspeccion: dictamen.id_inspeccion,
                            id_lote_envasado: dictamen.id_lote_envasado,
                            fecha_emision: dictamen.fecha_emision,
                            fecha_vigencia: dictamen.fecha_vigencia,
                            fecha_servicio: dictamen.fecha_servicio,
                            id_firmante: dictamen.id_firmante
                        };

                        // Mostrar el modal
                        $('#modalReexpedirDictamenEnvasado').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo cargar los datos del dictamen envasado.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                },
                error: function (error) {
                    console.error('Error al cargar los datos del dictamen envasado:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar los datos del dictamen envasado.',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            });
        });

        // Restablecer los valores originales cuando se cambia la opción a "Cancelar"
        $('#cancelar_reexpedir').change(function () {
            if ($(this).val() == '2') {
                $('.reexpedirFields').show();
                enableReexpedirFields();
            } else {
                $('.reexpedirFields').hide();
                disableReexpedirFields();

                // Restablecer los valores originales
                $('#reexpedir_num_dictamen').val(originalValues.num_dictamen);
                $('#reexpedir_id_empresa').val(originalValues.id_empresa).trigger('change');
                $('#reexpedir_id_inspeccion').val(originalValues.id_inspeccion).trigger('change');
                $('#reexpedir_id_lote_envasado').data('selectedLote', originalValues.id_lote_envasado);
                $('#reexpedir_fecha_emision').val(originalValues.fecha_emision);
                $('#reexpedir_fecha_vigencia').val(originalValues.fecha_vigencia);
                $('#reexpedir_fecha_servicio').val(originalValues.fecha_servicio);
                $('#reexpedir_id_firmante').val(originalValues.id_firmante).trigger('change');
            }
        });
        // Funciones para habilitar y deshabilitar validación de los campos
        function enableReexpedirFields() {
            fv.enableValidator('fecha_emision')
                .enableValidator('fecha_vigencia')
                .enableValidator('fecha_servicio')
                .enableValidator('id_firmante');
        }

        function disableReexpedirFields() {
            fv.disableValidator('fecha_emision')
                .disableValidator('fecha_vigencia')
                .disableValidator('fecha_servicio')
                .disableValidator('id_firmante');
        }

                // Inicializar select2
                $('#reexpedir_fecha_emision, #reexpedir_fecha_vigencia, #ereexpedir_fecha_servicio').on('change', function () {
                    // Revalidar el campo cuando se cambia el valor del select2
                    fv.revalidateField($(this).attr('name'));
                });

    });
    
        // Reciben los datos del PDF
        $(document).on('click', '.pdf', function () {
            var id = $(this).data('id'); // Obtén el ID desde el atributo data-id
            var iframe = $('#pdfViewerDictamen');
            var spinner = $('#loading-spinner');
            // Mostrar el spinner y ocultar el iframe antes de cargar el PDF
            spinner.show();
            iframe.hide();
    
            // Cargar el PDF con el ID
            iframe.attr('src', '/Dictamen-MezcalEnvasado/' + id); // Usa URL absoluta
    
            $("#titulo_modal_Dictamen").text("Dictamen de Cumplimiento NOM de Mezcal Envasado");
            $("#subtitulo_modal_Dictamen").text("PDF de Dictamen");
    
            // Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
            iframe.on('load', function () {
                spinner.hide();
                iframe.show();
            });
        });

});