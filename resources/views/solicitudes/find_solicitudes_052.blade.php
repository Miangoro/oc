@extends('layouts.layoutMaster')

@section('title', 'Solicitudes 052')

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
    @vite(['resources/js/solicitudes_052.js'])
    {{-- <script>
          window.puedeAgregarSolicitud = @json(auth()->user()->can('Registrar solicitudes 052'));
          window.puedeEditarSolicitud= @json(auth()->user()->can('Editar solicitudes 052'));
          window.puedeEliminarSolicitud = @json(auth()->user()->can('Eliminar solicitudes 052'));
          window.puedeValidarSolicitud = @json(auth()->user()->can('Validar solicitudes 052'));
          window.puedeExportarSolicitud = @json(auth()->user()->can('Exportar solicitudes 052'));
    </script> --}}
@endsection


@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!--Vista de la tabla-->
<div class="card">
    <div class="card-header pb-0">
        <h3 class="mb-0 fw-bold">Solicitudes de servicios NMX-V-052-NORMEX-2016</h3>
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
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>


    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    @include('_partials/_modals/modal-solicitudes-052')
    <!--solicitudes-->
    @include('_partials/_modals/modal-add-solicitud052-vigilancia-produccion')
    @include('_partials/_modals/modal-add-solicitud052-toma-muestra')
    @include('_partials/_modals/modal-add-solicitud052-liberacion-producto-terminado')
    @include('_partials/_modals/modal-add-solicitud052-emision-certificado-bebida')
    @include('_partials/_modals/modal-add-solicitud052-dictaminacion-instalacion')
    {{-- @include('_partials/_modals/modal-add-solicitud052-emision-certificado-instalacion') --}}
</div>
@endsection


<script>
    /*document.addEventListener('DOMContentLoaded', function() {
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
    });*/
</script>
