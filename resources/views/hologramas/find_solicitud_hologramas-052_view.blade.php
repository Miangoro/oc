@extends('layouts/layoutMaster')

@section('title', 'Solicitud Holograma')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
  'resources/assets/vendor/libs/spinkit/spinkit.scss',
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss'

])
@endsection

<!-- Vendor Scripts -->
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
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',

])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/solicitud_hologramas-052.js'])
@endsection

@section('content')

{{-- <meta name="csrf-token" content="{{ csrf_token() }}">
 --}}
<!-- Users List Table -->
<div class="card">
  <div class="card-header pb-0">
    <h3 class="card-title mb-0">Solicitud de Hologramas NMX-V-052-NORMEX-2016</h3>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>Id</th>
          <th>Folio</th>
          <th>Fecha</th>
          <th>Datos del cliente/Maquilador</th>
          <th>Solicitante</th>
          <th>Marca</th>
          <th>Hologramas</th>
          <th>inicial</th>
          <th>final</th>
          <th>estatus</th>
          <th>pdf</th>
          <th>Acciones</th>
        </tr>
      </thead>
    </table>
  </div>


</div>

<!-- Modal -->
@include('_partials/_modals/modal-pdfs-frames')
 @include('_partials/_modals/modal-add-solicitudHologramas052')
 @include('_partials/_modals/modal-add-activarHologramas052')
 @include('_partials/_modals/modal-edit-activarHologramas052')
 @include('_partials/_modals/modal-add-recepcionHologramas052')
 @include('_partials/_modals/modal-add-solicitudPagoHologramas052')
 @include('_partials/_modals/modal-add-asignarHologramas052')
 @include('_partials/_modals/modal-add-envioHologramas052')
@include('_partials/_modals/modal-edit-solicitudHologramas052')
@include('_partials/_modals/modal-add-activados052')
<!-- /Modal -->

@endsection

<script>

</script>
