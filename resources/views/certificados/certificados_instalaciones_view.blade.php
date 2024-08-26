@extends('layouts.layoutMaster')

@section('title', 'Catálogo Categorías')

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

@section('page-script')
@vite(['resources/js/certificados_instalaciones.js'])
@endsection

@section('content')

<!-- Users List Table -->
<div class="card">
    <div class="card-header pb-0">
        <h3 class="card-title mb-0">Certificados Instalaciones</h3>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>No. Certificado</th>
                    <th>Maestro Mezcalero</th>
                    <th>Fecha de Vigencia</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="addCertificadoForm" tabindex="-1" aria-labelledby="addCertificadoFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCertificadoFormLabel">Agregar Certificado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addCertificadoForm">
          <!-- Campo de Dictamen -->
          <div class="form-floating form-floating-outline mb-3">
            <select class="form-select" id="id_dictamen" name="id_dictamen" aria-label="Dictamen" data-placeholder="Seleccione un dictamen">
              <option value="">Seleccione un dictamen</option>
              @foreach($dictamenes as $dictamen)
                <option value="{{ $dictamen->id_dictamen }}">{{ $dictamen->num_dictamen }}</option>
              @endforeach
            </select>
            <label for="id_dictamen">Dictamen</label>
          </div>

          <!-- Otros campos del formulario -->
          <!-- Agrega aquí los demás campos necesarios para el registro del certificado -->

          <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary me-2">Registrar</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
