@extends('layouts/layoutMaster')

@section('title', 'Catálogo Aduana')

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
  @vite(['resources/js/catalogo_aduanas.js'])
@endsection

@section('content')

  <div class="card">
    <div class="card-header pb-0">
    <h3 class="card-title mb-0">Catálogo de Aduanas</h3>
    </div>
    <div class="card-datatable table-responsive">
    <table class="datatables-aduanas table">
      <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Aduana</th>
        <th>Acciones</th>
      </tr>
      </thead>
    </table>
    </div>

    <!-- Offcanvas para agregar nueva aduana -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title">Nueva Aduana</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <form id="addNewClassForm">
      @csrf
      <div class="form-floating form-floating-outline mb-4">
        <input type="text" class="form-control" id="aduana_nombre" name="aduana" required>
        <label for="aduana_nombre">Nombre de la Aduana</label>
      </div>
      <button type="submit" class="btn btn-primary">Registrar</button>
      <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
      </form>
    </div>
    </div>

    <!-- Offcanvas para editar aduana -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editAduana">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title">Editar Aduana</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <form id="editAduanaForm" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" name="id_aduana" id="edit_aduana_id">
      <div class="form-floating form-floating-outline mb-4">
        <input type="text" class="form-control" id="edit_aduana_nombre" name="aduana" required>
        <label for="edit_aduana_nombre">Nombre de la Aduana</label>
      </div>
      <button type="submit" class="btn btn-primary">Confirmar</button>
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
      </form>
    </div>
    </div>
  </div>

  <!-- Modal PDF (si lo necesitas para exportar o vista previa) -->
  @include('_partials/_modals/modal-pdfs-frames')

@endsection