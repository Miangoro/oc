@extends('layouts/layoutMaster')

@section('title', 'Revisión de dictamen')

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
  @vite(['resources/js/dictamenes_revision.js'])
@endsection

@php
  use App\Helpers\Helpers;
@endphp

<style>
    td {
        padding: 0.4rem !important;
    }
    th {
        color: black !important;
        font-weight: bold !important;
        font-size: 15px !important;
    }
</style>

@section('content')


<!-- PANEL -->
<div class="container mt-4 mb-4">
  <div class="card shadow-sm border-0 rounded-3">

    <div class="card-header bg-menu-theme text-center py-3">
      <h5 class="mb-0 text-white">
        Revisión de dictamen <br>
        <span class="badge bg-warning text-dark"></span>
      </h5>
    </div>

    <div class="card-body p-4">
      <div class="row gy-3">

        <!-- Tipo de dictamen -->
        <div class="col-md-4">
          <p class="text-muted mb-1">Tipo de dictamen</p>
          <h5 class="fw-semibold"></h5>
          <span class="badge bg-info">Combinado</span>
          <span class="badge bg-danger">Es corrección</span>

          <div class="mt-2">
            <small class="text-muted">Este certificado sustituye al:</small><br>
            <a target="_blank" href="" class="text-primary fw-bold"></a>
            <p class="mt-1"><strong>Motivo:</strong></p>
          </div>

          <p class="mt-2"><strong>Observaciones:</strong></p>

          <div class="mt-3">
            <p class="text-muted mb-1">Evidencias:</p>
            <div class="d-flex align-items-center gap-2 mb-1">
              <a href="/storage/revisiones/" target="_blank">
                <i class="ri-file-pdf-2-fill text-danger ri-24px"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Cliente -->
        <div class="col-md-4">
          <p class="text-muted mb-1">Cliente</p>
          <h5 class="fw-semibold"></h5>
        </div>

        <!-- Revisor -->
        <div class="col-md-4">
          <div class="d-flex align-items-center border border-primary rounded-4 p-3 shadow-lg bg-white position-relative" style="background: linear-gradient(135deg, #e3f2fd, #ffffff);">
            <div class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary text-white shadow-sm" style="font-size: 0.75rem;">
              <i class="ri-star-fill"></i> Revisor
            </div>
            <img src="" alt="Foto revisor"
              class="rounded-circle border border-3 border-white shadow-sm me-3"
              width="60" height="60" style="object-fit: cover;">
            <div>
              <h6 class="mb-0 fw-bold text-primary" style="font-size: 1.1rem;"></h6>
              <p class="mb-0 text-muted small">Responsable de esta revisión</p>
            </div>
          </div>

          <!-- PDF Dictamen -->
          <div class="mt-3">
            <p class="text-muted mb-1">Dictamen</p>
            <a href="" target="_blank">
              <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<!-- FORMULARIO -->
<form id="formulario" method="POST">
  <input type="hidden" id="id_revision" name="id_revision" value="">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-datatable table-responsive pt-0">

          <table class="table table-bordered table-sm table-hover table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Pregunta</th>
                <th>Documento</th>
                <th>Respuesta</th>
                <th>Observaciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($preguntas as $index => $pregunta)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>
                    {{ $pregunta->pregunta }}
                    <input value="{{ $pregunta->id_pregunta }}" type="hidden" name="id_pregunta[]">
                  </td>
                  <td>
                    <a target="_blank" href="">
                      <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                    </a>
                  </td>
                  <td>
                    <div class="resp">
                        <select class="form-select form-select-sm" aria-label="Elige la respuesta"          name="respuesta[]">
                            <option value="" selected disabled>Seleccione</option>
                            <option value="C">C</option>
                            <option value="NC">NC</option>
                            <option value="NA">NA</option>
                        </select>
                    </div>
                  </td>
                  <td>
                    <textarea id="" name="" name="observaciones[{{ $index }}]" rows="1"  
                        class="form-control" placeholder="Observaciones">
                    </textarea>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          
        </div>
      </div>
    </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">
                <i class="ri-add-line"></i> Registrar revisión
            </button>
            <a href="/revision/unidad_inspeccion" class="btn btn-danger waves-effect">
                <i class="ri-close-line"></i> Cancelar
            </a>
        </div>

  </div>
</form>

@endsection
