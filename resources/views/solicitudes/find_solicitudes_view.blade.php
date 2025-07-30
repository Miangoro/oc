@extends('layouts.layoutMaster')

@section('title', 'Solicitudes')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/pickr/pickr-themes.scss', 'resources/assets/vendor/libs/spinkit/spinkit.scss'])

@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/moment/moment.js',
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
        'resources/assets/vendor/libs/select2/select2.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
        'resources/assets/vendor/libs/cleavejs/cleave.js',
        'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
        'resources/assets/vendor/libs/flatpickr/flatpickr.js',
        'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
        'resources/assets/vendor/libs/pickr/pickr.js',
        'resources/assets/vendor/libs/flatpickr/l10n/es.js', // Archivo local del idioma
    ])
@endsection



@section('page-script')
    @vite(['resources/js/solicitudes.js'])
    @vite(['resources/js/solicitudes-tipo.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const certificacionSelectAdd = document.getElementById('certificacion');
            const certificadoOtrosDivAdd = document.getElementById('certificado-otros');
            const tipoSelectAdd = document.getElementById('tipo');
            const modalAddInstalacion = document.getElementById('modalAddInstalacion');

            const certificacionSelectEdit = document.getElementById('edit_certificacion');
            const certificadoOtrosDivEdit = document.getElementById('edit_certificado_otros');
            const tipoSelectEdit = document.getElementById('edit_tipo');
            const modalEditInstalacion = document.getElementById('modalEditInstalacion');

            function toggleCertificadoOtros(selectElement, divElement) {
                if (selectElement.value === 'otro_organismo') {
                    divElement.classList.remove('d-none');
                } else {
                    divElement.classList.add('d-none');
                }
            }

            function updateDocumentFields(tipoSelect, divElement) {
                const hiddenIdDocumento = divElement.querySelector('input[name="id_documento[]"]');
                const hiddenNombreDocumento = divElement.querySelector('input[name="nombre_documento[]"]');
                const fileCertificado = divElement.querySelector('input[type="file"]');

                switch (tipoSelect.value) {
                    case 'productora':
                        hiddenIdDocumento.value = '127';
                        hiddenNombreDocumento.value = 'Certificado de instalaciones';
                        fileCertificado.setAttribute('id', 'file-127');
                        break;
                    case 'envasadora':
                        hiddenIdDocumento.value = '128';
                        hiddenNombreDocumento.value = 'Certificado de envasadora';
                        fileCertificado.setAttribute('id', 'file-128');
                        break;
                    case 'comercializadora':
                        hiddenIdDocumento.value = '129';
                        hiddenNombreDocumento.value = 'Certificado de comercializadora';
                        fileCertificado.setAttribute('id', 'file-129');
                        break;
                    default:
                        hiddenIdDocumento.value = '';
                        hiddenNombreDocumento.value = '';
                        fileCertificado.removeAttribute('id');
                        break;
                }
            }

            function setupEventListeners() {
                // Add modal event listeners
                certificacionSelectAdd.addEventListener('change', function() {
                    toggleCertificadoOtros(certificacionSelectAdd, certificadoOtrosDivAdd);
                });

                tipoSelectAdd.addEventListener('change', function() {
                    updateDocumentFields(tipoSelectAdd, certificadoOtrosDivAdd);
                });

                modalAddInstalacion.addEventListener('shown.bs.modal', function() {
                    certificacionSelectAdd.value = '';
                    $(certificacionSelectAdd).trigger('change');
                    tipoSelectAdd.value = '';
                    $(tipoSelectAdd).trigger('change');
                    certificadoOtrosDivAdd.classList.add('d-none');
                });

                modalAddInstalacion.addEventListener('hidden.bs.modal', function() {
                    certificacionSelectAdd.value = '';
                    $(certificacionSelectAdd).trigger('change');
                    tipoSelectAdd.value = '';
                    $(tipoSelectAdd).trigger('change');
                    certificadoOtrosDivAdd.classList.add('d-none');
                });

                // Edit modal event listeners
                if (certificacionSelectEdit) {
                    certificacionSelectEdit.addEventListener('change', function() {
                        toggleCertificadoOtros(certificacionSelectEdit, certificadoOtrosDivEdit);
                    });
                }

                if (tipoSelectEdit && certificadoOtrosDivEdit) {
                    tipoSelectEdit.addEventListener('change', function() {
                        updateDocumentFields(tipoSelectEdit, certificadoOtrosDivEdit);
                    });
                }
                if (modalEditInstalacion) {
                    modalEditInstalacion.addEventListener('shown.bs.modal', function() {
                        if (certificacionSelectEdit) {
                            certificacionSelectEdit.value = '';
                            $(certificacionSelectEdit).trigger('change');
                        }
                        if (tipoSelectEdit) {
                            tipoSelectEdit.value = '';
                            $(tipoSelectEdit).trigger('change');
                        }
                        if (certificadoOtrosDivEdit) {
                            certificadoOtrosDivEdit.classList.add('d-none');
                        }
                    });
                }
                if (modalEditInstalacion) {
                    modalEditInstalacion.addEventListener('hidden.bs.modal', function() {
                        if (certificacionSelectEdit) {
                            certificacionSelectEdit.value = '';
                            $(certificacionSelectEdit).trigger('change');
                        }
                        if (tipoSelectEdit) {
                            tipoSelectEdit.value = '';
                            $(tipoSelectEdit).trigger('change');
                        }
                        if (certificadoOtrosDivEdit) {
                            certificadoOtrosDivEdit.classList.add('d-none');
                        }
                    });
                }

            }

            setupEventListeners();
        });

          window.puedeAgregarSolicitud = @json(auth()->user()->can('Registrar solicitudes'));
          window.puedeEditarSolicitud= @json(auth()->user()->can('Editar solicitudes'));
          window.puedeEliminarSolicitud = @json(auth()->user()->can('Eliminar solicitudes'));
          window.puedeValidarSolicitud = @json(auth()->user()->can('Validar solicitudes'));
          window.puedeExportarSolicitud = @json(auth()->user()->can('Exportar solicitudes'));
    </script>


    <style>
        .text-primary {
            color: #262b43 !important;
        }
    </style>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="mb-0 fw-bold">Solicitudes de servicios</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table style="font-size: 14px" class="datatables-solicitudes table table-bordered  table-hover">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Folio</th>
                        <th>No. de servicio</th>
                        <th>Cliente</th>
                        <th>Fecha de solicitud</th>
                        <th>Solicitud</th>
                        <th>Domicilio de inspección</th>
                        <th>Fecha y hora de visita estimada</th>
                        <th>Inspector asignado</th>
                        <th>Características</th>
                        <th>Fecha y hora de inspección</th>
                        {{-- <th>Formato de solicitud</th> --}}
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>





        <!-- Modal -->
        @include('_partials._modals.modal-pdfs-frames')
        @include('_partials._modals.modal-solicitudes')
        @include('_partials._modals.modal-expediente-servicio')
        @include('_partials._modals.modal-trazabilidad')
        @include('_partials._modals.modal-validad-solicitud')
        @include('_partials._modals.modal-add-solicitud-dictamen-instalaciones')
        @include('_partials._modals.modal-add-solicitud-vigilancia-en-produccion')
        @include('_partials._modals.modal-add-solicitud-vigilancia-traslado-lote')
        @include('_partials._modals.modal-add-solicitud-muestreo-lote-agranel')
        @include('_partials._modals.modal-add-solicitud-inspeccion-de-envasado')
        @include('_partials._modals.modal-add-solicitud-muestreo-lote-envasado')
        @include('_partials._modals.modal-add-solicitud-inspeccion-ingreso-barricada')
        @include('_partials._modals.modal-add-solicitud-liberacion-producto-terminado')
        @include('_partials._modals.modal-add-solicitud-inspeccion-de-liberacion')
        @include('_partials._modals.modal-add-solicitud-pedidos-para-exportacion')
        @include('_partials._modals.modal-add-solicitud-emision-certificado-venta-nacional')
        @include('_partials._modals.modal-add-solicitud-inspeccion-emision-certificado-NOM')
        @include('_partials._modals.modal-add-solicitud-georeferenciacion')
        @include('_partials._modals.modal-add-solicitud-muestreo-agave')



        @include('_partials._modals.modal-export-excel')

        @include('_partials._modals.modal-add-instalaciones')
        @include('_partials._modals.modal-edit-solicitudes-georeferenciacion')
        @include('_partials._modals.modal-edit-solicitud-dictamen-instalaciones')
        @include('_partials._modals.modal-edit-solicitud-vigilancia-produccion')
        @include('_partials._modals.modal-edit-solicitud-muestreo-lote-agranel')
        @include('_partials._modals.modal-edit-solicitud-vigilancia-traslado-lote')
        @include('_partials._modals.modal-edit-solicitud-inspeccion-ingreso-barricada')
        @include('_partials._modals.modal-edit-solicitud-inspeccion-de-liberacion')
        @include('_partials._modals.modal-edit-solicitud-inspeccion-de-envasado')
        @include('_partials._modals.modal-edit-solicitud-pedidos-para-exportacion')
        @include('_partials._modals.modal-edit-solicitud-muestreo-agave')
        @include('_partials._modals.modal-edit-solicitud-liberación-producto-terminado')
        @include('_partials._modals.modal-edit-solicitud-emision-certificado-venta-nacional')


        <!-- /Modal -->

    </div>
@endsection

<script>
     function abrirModal(id_solicitud, id_inspeccion, tipo, nombre_empresa, id_tipo, folio, noservicio, inspectorName) {

        $('.id_soli').text(id_solicitud);
        $('.id_deinspeccion').text(id_inspeccion);
        $('.solicitud').text(tipo);
        $('.nombre_empresa').text(nombre_empresa);
        $('.numero_tipo').text(id_tipo);
        $('.folio_solicitud').html('<b class="text-primary">' + (folio) + '</b>');
        $('.numero_servicio').html('<b class="text-primary">' + noservicio + '</b>');
        $('.inspectorName').html(inspectorName);


        const links = [{
                id: '#link_solicitud_servicio',
                href: '{{ url('solicitud_de_servicio') }}/' + id_solicitud
            },
            {
                id: '#link_oficio_comision',
                href: '{{ url('oficio_de_comision') }}/' + id_inspeccion
            },
            {
                id: '#link_orden_servicio',
                href: '{{ url('orden_de_servicio') }}/' + id_inspeccion
            },
            {
                id: '#link_plan_auditoria',
                href: '{{ url('plan_de_auditoria') }}/' + id_inspeccion
            },

            {
                id: '#links_etiquetas',
                href: ''
            }
        ];

        // Restaurar enlaces e íconos
        links.forEach(link => {
            if (link.id !== '#links_etiquetas') { // se maneja aparte por id_tipo
                $(link.id)
                    .attr('href', link.href)
                    .removeClass('text-secondary opacity-50')
                    .find('i')
                    .removeClass('text-secondary opacity-50')
                    .addClass('text-danger');
            } else {
                $(link.id)
                    .removeClass('text-secondary opacity-50')
                    .find('i')
                    .removeClass('text-secondary opacity-50')
                    .addClass('text-danger');
            }
        });


        ///PLAN DE AUDITORIA
        let audiHref = '{{ url('plan_de_auditoria') }}/' + id_inspeccion;
        let auditoria_texto = 'Plan de auditoría';
    
        if (inspectorName != 'Sin inspector') {
            $('#link_plan_auditoria').attr('href', audiHref);
            $('.auditoria_texto').text(auditoria_texto);
            $('.auditoria').show(); // mostrar el tr
        } else {
            $('.auditoria').hide(); // ocultar el tr
        }


        // Etiquetas específicas según tipo
        let etiquetaHref = '';
        let etiquetaTexto = 'Etiquetas';

        switch (parseInt(id_tipo)) {
            case 1:
                etiquetaHref = '{{ url('etiqueta_agave_art') }}/' + id_solicitud;
                etiquetaTexto = 'Etiqueta para agave (%ART)';
                break;
            case 3:
                etiquetaHref = '{{ url('etiquetas_tapas_sellado') }}/' + id_solicitud;
                etiquetaTexto = 'Etiqueta para tapa de la muestra';
                break;
            case 4:
            case 5:
                etiquetaHref = '{{ url('etiqueta_lotes_mezcal_granel') }}/' + id_solicitud;
                etiquetaTexto = 'Etiqueta para lotes de mezcal a granel';
                break;
            case 7:
                etiquetaHref = '{{ url('etiqueta-barrica') }}/' + id_solicitud;
                etiquetaTexto = 'Etiqueta de ingreso a barricas';
                break;
        }

        if (etiquetaHref !== '') {
            $('#links_etiquetas').attr('href', etiquetaHref);
            $('.etiqueta_name').text(etiquetaTexto);
            $('.etiquetasNA').show(); // mostrar el tr
        } else {
            $('.etiquetasNA').hide(); // ocultar el tr
        }

        $.ajax({
            url: '/getDocumentosSolicitud/' +
            id_solicitud, // URL del servidor (puede ser .php, .json, .html, etc.)
            type: 'GET', // O puede ser 'GET'
            dataType: 'json', // Puede ser 'html', 'text', 'json', etc.
            success: function(response) {
                if (response.success) {

                    const documentos = response.data;
                    const fqs = response.fqs;
                    const url_etiqueta = response.url_etiqueta;
                    const urls_certificados = response.url_certificado;
                    const url_corrugado = response.url_corrugado;
                    const url_evidencias = response.url_evidencias;
                    const url_etiqueta_envasado = response.url_etiqueta_envasado;
                    let html = `
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" colspan="2">Documentación de la solicitud</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    if (documentos.length > 0) {
                        documentos.forEach(function(doc) {
                            let carpeta = '';
                            if (doc.id_documento == 69 || doc.id_documento == 70) {
                                carpeta = 'actas/';
                            }
                            html += `
                            <tr>
                                <td>${doc.nombre}</td>
                                <td>
                                    <a href="/files/${response.numero_cliente}/${carpeta}${doc.url}" target="_blank">
                                        <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                    </a>
                                </td>
                            </tr>`;
                        });
                    } else {
                        html += ``;
                    }

                    if (url_etiqueta_envasado) {
                     
                            html += `
                                    <tr>
                                        <td>Etiqueta</td>
                                        <td>
                                            <a href="/files/${response.numero_cliente}/${url_etiqueta_envasado}" target="_blank">
                                                <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>`;
                       
                    }

                    if (urls_certificados && urls_certificados.length > 0) {
                        urls_certificados.forEach(function(url) {
                            html += `
                                    <tr>
                                        <td>Certificado de granel</td>
                                        <td>
                                            <a href="/files/${response.numero_cliente_lote}/certificados_granel/${url}" target="_blank">
                                                <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>`;
                        });
                    }




                    if (fqs) {
                        fqs.forEach(function(fq) {
                            html += `
                            <tr>
                                <td>${fq.nombre_documento}</td>
                                <td>
                                    <a href="/files/${response.numero_cliente_lote}/fqs/${fq.url}" target="_blank">
                                        <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                    </a>
                                </td>
                            </tr>`;
                        });
                    }

                    if (url_etiqueta) {

                        html += `
                            <tr>
                                <td>Etiqueta</td>
                                <td>
                                    <a href="/files/${response.numero_cliente}/${url_etiqueta}" target="_blank">
                                        <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                    </a>
                                </td>
                            </tr>`;

                    }

                    if (url_corrugado) {

                        html += `
                            <tr>
                                <td>Corrugado</td>
                                <td>
                                    <a href="/files/${response.numero_cliente}/${url_corrugado}" target="_blank">
                                        <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                    </a>
                                </td>
                            </tr>`;

                    }


                    html += `</tbody></table>`;
                    $('#contenedor-documentos').html(html);
                }
            },


            error: function(xhr, status, error) {
                // Aquí si algo salió mal
                console.error('Error AJAX:', error);
                $('#contenedor-documentos').html('');
            }
        });

        $('#expedienteServicio').modal('show');


    }

    function abrirModalValidarSolicitud(id_solicitud, tipo, nombre_empresa) {

        /* $.ajax({
             url: '/lista_empresas/' + id_empresa,
             method: 'GET',
             success: function(response) {
                 // Cargar los detalles en el modal
                 var contenido = "";

               for (let index = 0; index < response.normas.length; index++) {
                 contenido = '<input value="'+response.normas[index].id_norma+'" type="hidden" name="id_norma[]"/><div class="col-12 col-md-12 col-sm-12"><div class="form-floating form-floating-outline"><input type="text" id="numero_cliente'+response.normas[index].id_norma+'" name="numero_cliente[]" class="form-control" placeholder="Introducir el número de cliente" /><label for="modalAddressFirstName">Número de cliente para la norma '+response.normas[index].norma+'</label></div></div><br>' + contenido;
                 console.log(response.normas[index].norma);
               }

                 $('#expedienteServicio').modal('show');
             },
             error: function() {
                 alert('Error al cargar los detalles de la empresa.');
             }
         });*/
        $('.solicitud').text(tipo);
        $('.nombre_empresa').text(nombre_empresa);
        $('#addSolicitudValidar').modal('show');

    }

    function abrirModalTrazabilidad(id_solicitud, tipo, nombre_empresa) {
        // Asignar valores en el modal
        $("#id_solicitud").val(id_solicitud);
        $('.solicitud').text(tipo);

        // Construir la URL para la solicitud AJAX
        var url = baseUrl + 'trazabilidad/' + id_solicitud;

        // Hacer la solicitud AJAX para obtener los logs
        $.get(url, function(data) {
            if (data.success) {
                // Recibir los logs y mostrarlos en el modal
                var logs = data.logs;
                var logsContainer = $('#logsContainer');
                logsContainer.empty(); // Limpiar el contenedor de logs

                // Iterar sobre los logs y agregarlos al contenedor
                logs.forEach(function(log) {
                    logsContainer.append(`

                <li class="timeline-item timeline-item-transparent">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                        <div class="timeline-header mb-3">
                        <h6 class="mb-0">${log.description}</h6>
                        <small class="text-muted">${log.created_at}</small>
                        </div>
                        <p class="mb-2">  ${log.contenido}</p>
                        <div class="d-flex align-items-center mb-1">

                        </div>
                    </div>
                    </li><hr>
                `);
                });

                // Mostrar el modal
                $('#trazabilidad').modal('show');
            }
        }).fail(function(xhr) {
            console.error(xhr.responseText);
        });
    }




    document.addEventListener('DOMContentLoaded', function() {
        // Función para obtener parámetros de la URL
        function getParameterByName(name) {
            const url = window.location.href;
            const regex = new RegExp(`[?&]${name}(=([^&#]*)|&|#|$)`);
            const results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        // Verificar si el modal debe abrirse
        const modalToOpen = getParameterByName('abrirModal');
        if (modalToOpen === 'nuevaSolicitud') {
            $('#verSolicitudes').modal('show'); // Abrir modal
        }
    });
</script>
