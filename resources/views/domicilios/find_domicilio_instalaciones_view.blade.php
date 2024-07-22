@extends('layouts/layoutMaster')

@section('title', 'Instalaciones')

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
@vite(['resources/js/instalaciones.js'])
@endsection

@section('content')

<!-- Actions and DataTable -->
<div class="card">
  <div class="card-header pb-0">
    <h3 class="card-title mb-0">Instalaciones</h3>
    <div class="card-toolbar">

  <div class="card-datatable table-responsive">
    <table class="datatables-users table" id="instalacionesTable">
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>ID</th>
          <th>Cliente</th>
          <th>Tipo</th>
          <th>Dirección</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($instalaciones as $instalacion)
            <tr>
                <td></td>
                <td>{{ $instalacion->id_instalaciones }}</td>
                <td>{{ $instalacion->empresa ? $instalacion->empresa->razon_social : 'N/A' }}</td>
                <td>{{ $instalacion->tipo }}</td>
                <td>{{ $instalacion->direccion_completa }}</td>
            </tr>
        @endforeach
    </tbody>

    </table>
  </div>


<!-- Modal for PDFs or Frames -->
@include('_partials/_modals/modal-pdfs-frames')

@endsection
