@extends('layouts/layoutMaster')

@section('title', 'Catalogo Clases')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
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
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/lotes_envasado.js'])
@endsection

@section('content')

{{-- <meta name="csrf-token" content="{{ csrf_token() }}">
 --}}
<!-- Users List Table -->
<div class="card">
  <div class="card-header pb-0">
    <h3 class="card-title mb-0">Listas de Lotes envasados</h3>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>Id</th>
          <th>No. de CLiente</th>
          <th>Nombre del Cliente</th>
          <th>Tipo de lote</th>
          <th>Nombre lote</th>
          <th>Marca</th>
          <th>cantidad botellas</th>
          <th>Presentacion</th>
          <th>Volumen total</th>
          <th>Destino lote</th>
          <th>Lugar de envasado</th>
          <th>No. de pedido/SKU</th>
          <th>Acciones</th>
        </tr>
      </thead>
    </table>
  </div>


</div>

<!-- Modal -->
@include('_partials/_modals/modal-pdfs-frames')
@include('_partials/_modals/modal-add-lotesEnvasado')
@include('_partials/_modals/modal-edit-lotesEnvasado')


<!-- /Modal -->
@endsection
