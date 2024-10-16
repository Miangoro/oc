@extends('layouts/layoutMaster')

@section('title', 'Domicilio Predios')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss','resources\assets\vendor\libs\bootstrap-datepicker\bootstrap-datepicker.scss', 'resources\assets\vendor\libs\spinkit\spinkit.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js','resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/domicilio_predios.js'])
@endsection

<style>
  .icon-no-pdf {
  color: rgba(0, 0, 0, 0.3); /* Cambia el color a un tono más claro */
  opacity: 0.5; /* Baja la opacidad para hacer que se vea más tenue */
}

</style>
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Predios</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Nombre Productor</th>
                        <th>Nombre Predio</th>
                        <th>Ubicación Predio</th>
                        <th>Tipo Predio</th>
                        <th>Puntos Referencia</th>
                        <th>Cuenta con Coordenadas</th>
                        <th>Superficie</th>
                        <th>estatus</th>
                        <th>Solicitud</th>
                        <th>Pre-registro</th>
                        <th>Inspección</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal -->

    @include('_partials/_modals/modal-pdfs-frames')
    @include('_partials/_modals/modal-add-new-predio')
    @include('_partials/_modals/modal-edit-predio')
    @include('_partials/_modals/modal-add-predio-inspeccion')
    @include('_partials/_modals/modal-add-registro-predio')
    @include('_partials/_modals/modal-add-solicitud-georeferenciacion')
    <!-- /Modal -->
@endsection
