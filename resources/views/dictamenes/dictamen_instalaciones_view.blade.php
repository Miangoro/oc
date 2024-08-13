@extends('layouts/layoutMaster')

@section('title', 'Dictamenes de Instalaciones')

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
@vite(['resources/js/dictamenes_instalaciones.js'])
@endsection

@section('content')

{{-- <meta name="csrf-token" content="{{ csrf_token() }}">
 --}}
<!-- Users List Table -->
<div class="card">
    <div class="card-header pb-0">
        <h3 class="card-title mb-0">Dictámenes de Instalaciones</h3>
    </div>

    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Tipo de dictamen</th>
                    <th>No. dictamen</th>
                    <th>Inspeccion</th>
                    <th>Fecha de emisión</th>
                    <th>Dictamen</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
        </table>
    </div>


    <!-- Offcanvas Agregar nuevo tipo 
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Nuevo Dictamen</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0 h-100">
            <form class="add-new-user pt-0" id="addNewCategoryForm">
                @csrf
                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control" id="nombre" placeholder="Tipo de maguey o agave" name="nombre" aria-label="Nombre" required>
                    <label for="nombre">Nombre del Tipo</label>
                </div>
                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control" id="ciencitico" placeholder="cientifico" name="cientifico" aria-label="Nombre" required>
                    <label for="cientifico">Nombre 100</label>
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Registrar</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
            </form>
        </div>
    </div>-->




</div>

<!-- Modal -->
@include('_partials/_modals/modal-pdfs-frames')
@include('_partials/_modals/modal-add-dictamen_instalaciones')
<!-- /Modal -->

@endsection
