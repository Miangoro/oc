/**
 * Page User List
 */

'use strict';


$(function () {
    // Variable declaration for table
    var dt_user_table = $('.datatables-users'),

        select2 = $('.select2'),

        offCanvasForm = $('#modalAddDictamenGranel');

    if (select2.length) {
        var $this = select2;
        select2Focus($this);
        $this.wrap('<div class="position-relative"></div>').select2({
            placeholder: 'Select Country',
            dropdownParent: $this.parent()
        });
    }
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
                url: baseUrl + 'dictamen-granel-list', // Asegúrate de que esta URL coincida con la ruta en tu archivo de rutas
                type: 'GET'
            },
            columns: [
                { data: '' },
                { data: 'id_dictamen' },
                { data: 'num_dictamen' },
                { data: 'id_empresa' },
                { data: 'id_inspeccion' },
                { data: 'id_lote_granel' },
                { data: 'fecha_emision' },
                { data: 'fecha_vigencia' },
                { data: 'fecha_servicio' },
                { data: '' },
                { data: 'action' },
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
                    // Abre el pdf del dictamen
                    // Abre el pdf del dictamen
                    targets: 9,
                    className: 'text-center',
                    render: function (data, type, full, meta) {
                        var $id = full['id_dictamen'];
                        return '<i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-id="' + $id + '" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>';
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
                            `<a data-id="${full['id_dictamen']}" data-bs-toggle="modal" data-bs-target="#modalEditDictamenGranel" href="javascrip:;" class="dropdown-item edit-record text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>` +
                            `<a data-id="${full['id_dictamen']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>` +
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
                            title: 'Predios',
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
                            title: 'Users',
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
                            title: 'Predios',
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
                            title: 'Predios',
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
                            title: 'Predios',
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
                    text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar dictamen a granel</span>',
                    className: 'add-new btn btn-primary waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#modalAddDictamenGranel'
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
                    url: `${baseUrl}dictamen/granel/${id_dictamen}`,
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
                            text: '¡El dictamen ha sido eliminada correctamente!',
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
                    text: 'La eliminación del lote ha sido cancelada',
                    icon: 'info',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            }
        });
    });


    /* agregar un nuevo dictamen */
    $(function () {
        // Configuración CSRF para Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Inicializar FormValidation
        const form = document.getElementById('addNewDictamenGranelForm');
        const fv = FormValidation.formValidation(form, {
            fields: {
                'num_dictamen': {
                    validators: {
                        notEmpty: {
                            message: 'El número de dictamen es obligatorio.'
                        },
                        integer: {
                            message: 'Debe ingresar un número válido.'
                        }
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
                'id_lote_granel': {
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
                            enable: function (field) {
                                return !$(field).val();
                            }
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).',
                            enable: function (field) {
                                return !$(field).val();
                            }
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
                            enable: function (field) {
                                return !$(field).val();
                            }
                        }
                    }
                },
                'fecha_servicio': {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de servicio es obligatoria.',
                            enable: function (field) {
                                return !$(field).val();
                            }
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'Ingresa una fecha válida (yyyy-mm-dd).',
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
            var formData = new FormData(form);

            // Imprimir los datos del formulario para verificar
            console.log('Form Data:', Object.fromEntries(formData.entries()));

            $.ajax({
                url: '/dictamenes-granel',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // Ocultar el modal y resetear el formulario
                    $('#modalAddDictamenGranel').modal('hide');
                    $('#addNewDictamenGranelForm')[0].reset();
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

        // Función para actualizar la validación al cambiar la fecha en el datepicker
        function updateDatepickerValidation() {
            $('#fecha_vigencia').on('change', function () {
                fv.revalidateField('fecha_vigencia');
            });

            $('#fecha_emision').on('change', function () {
                fv.revalidateField('fecha_emision');
            });

            $('#fecha_servicio').on('change', function () {
                fv.revalidateField('fecha_servicio');
            });
        }

        // Función para actualizar la validación al cambiar el valor en los select2
        function updateSelect2Validation() {
            $('#id_empresa').on('change', function () {
                fv.revalidateField('id_empresa');
            });

            $('#id_inspeccion').on('change', function () {
                fv.revalidateField('id_inspeccion');
            });

            $('#id_lote_granel').on('change', function () {
                fv.revalidateField('id_lote_granel');
            });
        }
        // Llamar a las funciones para actualizar la validación
        updateDatepickerValidation();
        updateSelect2Validation();

    });






    $(function () {
        // Configuración CSRF para Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Inicializar FormValidation para el formulario de creación y edición
        const form = document.getElementById('addNEditDictamenGranelForm');
        const fv = FormValidation.formValidation(form, {
            fields: {
                'num_dictamen': {
                    validators: {
                        notEmpty: {
                            message: 'El número de dictamen es obligatorio.'
                        },
                        integer: {
                            message: 'Debe ingresar un número válido.'
                        }
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
                'id_lote_granel': {
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
                url: '/dictamenes/productos/' + dictamenid + '/update',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    dt_user.ajax.reload();
                    $('#modalEditDictamenGranel').modal('hide');
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
                url: '/dictamenes/productos/' + id_dictamen + '/edit',
                method: 'GET',
                success: function (data) {
                    if (data.success) {
                        var dictamen = data.dictamen;

                        // Asignar valores a los campos del formulario
                        $('#edit_num_dictamen').val(dictamen.num_dictamen);
                        $('#edit_id_empresa').val(dictamen.id_empresa).trigger('change');
                        $('#edit_id_inspeccion').val(dictamen.id_inspeccion).trigger('change');
                        $('#edit_id_lote_granel').data('selectedLote', dictamen.id_lote_granel); // Guardar el lote seleccionado
                        $('#edit_fecha_emision').val(dictamen.fecha_emision);
                        $('#edit_fecha_vigencia').val(dictamen.fecha_vigencia);
                        $('#edit_fecha_servicio').val(dictamen.fecha_servicio);

                        // Mostrar el modal
                        $('#modalEditDictamenGranel').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo cargar los datos del dictamen a granel.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                },
                error: function (error) {
                    console.error('Error al cargar los datos del dictamen a granel:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar los datos del dictamen a granel.',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            });
        });

        // Función para actualizar la validación al cambiar la fecha en el datepicker
        function updateDatepickerValidation() {
            $('#edit_fecha_emision').on('change', function () {
                fv.revalidateField('fecha_emision');
            });

            $('#edit_fecha_vigencia').on('change', function () {
                fv.revalidateField('fecha_vigencia');
            });

            $('#edit_fecha_servicio').on('change', function () {
                fv.revalidateField('fecha_servicio');
            });
        }

        // Llamar a la función para actualizar la validación
        updateDatepickerValidation();

    });


    // Reciben los datos del PDF
    $(document).on('click', '.pdf', function () {
        var id = $(this).data('id'); // Obtén el ID desde el atributo data-id
        var iframe = $('#pdfViewer');

        // Cargar el PDF con el ID
        iframe.attr('src', '/dictamen_cumplimiento_mezcal_granel/' + id); // Usa URL absoluta

        $("#titulo_modal").text("Dictamen de Cumplimiento NOM Mezcal a Granel");
        $("#subtitulo_modal").text("PDF de Dictamen");
    });


});