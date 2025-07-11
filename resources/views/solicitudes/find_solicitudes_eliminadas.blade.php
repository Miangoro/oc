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
                        <th>Formato de solicitud</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>





        <!-- Modal -->
        @include('_partials._modals.modal-pdfs-frames')


        @include('_partials._modals.modal-export-excel')

        <!-- /Modal -->

    </div>
@endsection

<script>
</script>
