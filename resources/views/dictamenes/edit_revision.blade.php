@extends('layouts/layoutMaster')

@section('title', 'Revisión de Dictamen')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
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
        padding: 0.04rem !important;
    }

    th {
        color: black !important;
        font-weight: bold !important;
        font-size: 15px !important;
    }
</style>
@section('content')

<!-- PANEL REVISION-->
<div class="container mt-4 mb-4">
  <div class="card shadow-sm border-0 rounded-3">

    <div class="card-header bg-menu-theme text-center py-3">
      <h5 class="mb-0 text-white">
        Revisión del acta <br>
        <span class="badge bg-warning text-dark">{{ $datos->inspeccion->num_servicio ?? 'N/A' }}</span>
      </h5>
    </div>

    <div class="card-body p-4">
      <div class="row gy-3">

        <!-- tipo solicitud Columna 1 -->
        <div class="col-md-4">
          <p class="text-muted mb-1">Tipo de solicitud</p>
          <h5 class="fw-semibold">
          {{ $tipo }}
          </h5>

          <div class="mt-4">
              <p class="text-muted mb-1">Acta</p>
            @php    
              $empresa = $datos->inspeccion->solicitud->empresa;
              $cliente = $empresa?->empresaNumClientes->firstWhere( 'numero_cliente', '!=', null );
              // Acta (tipo 69)
              $acta = \App\Models\Documentacion_url::where('id_empresa', $empresa->id_empresa)
                    ->where('id_documento', 69)
                    ->where('id_relacion', $datos->inspeccion->solicitud->id_solicitud)
                    ->value('url');
              // Evidencias (tipo 70)
              $evidencias = \App\Models\Documentacion_url::where('id_empresa', $empresa->id_empresa)
                  ->where('id_documento', 70)
                  ->where('id_relacion', $datos->inspeccion->solicitud->id_solicitud)
                  ->pluck('url');
            @endphp
                {{-- ACTA --}}
                <a href="{{ asset('files/' . $cliente->numero_cliente . '/actas/' . $acta) }}" target="_blank">
                  <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                </a>
            </div>
        </div>

        <!-- Cliente Columna 2 -->
        <div class="col-md-4">
          <p class="text-muted mb-1">Cliente</p>
          <h5 class="fw-semibold">
            {{ $datos->inspeccion->solicitud->empresa->razon_social ?? 'N/A' }}
          </h5>

            {{-- Evidencias --}}
            @if($evidencias->isNotEmpty())
            <div class="mt-4">
                <p class="text-muted mb-1">Evidencias</p>
                @foreach($evidencias as $index => $evidencia)
                    <a href="{{ asset('files/' . $cliente->numero_cliente . '/actas/' . $evidencia) }}" target="_blank">
                        <i class="ri-file-pdf-2-fill text-primary ri-24px cursor-pointer"></i>
                    </a>
                    @if($index < $evidencias->count() - 1)
                      <!--espacio-->
                    @endif
                @endforeach
            </div>
            @endif
        </div>

        <!-- Revisor Columna 3 -->
        <div class="col-md-4">
          <div class="d-flex align-items-center border border-primary rounded-4 p-3 shadow-lg bg-white position-relative" style="background: linear-gradient(135deg, #e3f2fd, #ffffff);">
            <div class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary text-white shadow-sm" style="font-size: 0.75rem;">
              <i class="ri-star-fill"></i> Revisor
            </div>
            <img src="{{ asset('storage/' .$datos->user->profile_photo_path) }}" alt="Foto revisor"
              class="rounded-circle border border-3 border-white shadow-sm me-3"
              width="60" height="60" style="object-fit: cover;">
            <div>
              <h6 class="mb-0 fw-bold text-primary" style="font-size: 1.1rem;">
                {{ $datos->user->name ?? 'N/A' }}
              </h6>
              <p class="mb-0 text-muted small">Responsable de esta revisión</p>
            </div>
          </div>

          <!-- Inspector Columna extra -->
          <div class="mt-2">
            <div class="d-flex align-items-center border rounded-3 p-2 shadow-sm bg-light">
                <img src="{{ asset('storage/' . $datos->inspeccion->inspector->profile_photo_path) }}"
                    alt="Foto consejo"
                    class="rounded-circle me-3 border border-white shadow-sm"
                    width="50" height="50" style="object-fit: cover;">
                <div>
                    <p class="text-muted mb-0 small">Inspector que realizó la inspección</p>
                    <h6 class="mb-0 fw-semibold">{{ $datos->inspeccion->inspector->name ?? 'N/A' }}</h6>
                </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


    <!-- FORMULARIO -->
    <form id="formularioEditar" method="POST">
        @csrf
        <input type="hidden" id="id_revision" name="id_revision" value="{{ $datos->id_revision }}">
        <input type="hidden" name="numero_revision" value="{{ $datos->numero_revision }}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-datatable table-responsive pt-0">
                        <table class="table table-bordered table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pregunta</th>
                                    <th>Respuesta</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>

                    @php    
                        $empresa = $datos->inspeccion->solicitud->empresa;
                        $cliente = $empresa?->empresaNumClientes->firstWhere( 'numero_cliente', '!=', null );
                    @endphp
                    @foreach ($preguntas as $index => $pregunta)

                        @php
                            $respuesta = $respuestas_map[$pregunta->id_pregunta] ?? null;
                            $respuesta_actual = $respuesta['respuesta'] ?? null;
                        @endphp
                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <th>{{ $pregunta->pregunta }} <input value="{{ $pregunta->id_pregunta }}"
                                    type="hidden" name="id_pregunta[]">
                            </th>

                                
                            <td>
                                <div class="resp">
                                    <select class="form-select form-select-sm" aria-label="Elige la respuesta"
                                        name="respuesta[]">
                                        <option value="" disabled
                                            {{ $respuesta_actual == null ? 'selected' : '' }}>Seleccione
                                        </option>
                                        <option value="C"
                                            {{ $respuesta_actual == 'C' ? 'selected' : '' }}>C</option>
                                        <option value="NC"
                                            {{ $respuesta_actual == 'NC' ? 'selected' : '' }}>NC</option>
                                        <option value="NA"
                                            {{ $respuesta_actual == 'NA' ? 'selected' : '' }}>NA</option>
                                    </select>

                                </div>
                            </td>

                            <td>
                                <textarea name="observaciones[{{ $index }}]" rows="1" name="" id="" class="form-control"
                                    placeholder="Observaciones">{{ $respuesta['observacion'] ?? '' }}</textarea>
                            </td>
                        </tr>
                    @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            

            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light"><i
                        class="ri-pencil-fill"></i> Editar {{ $datos->numero_revision }}ª revisión</button>
                <a href="/revision/unidad_inspeccion" class="btn btn-danger waves-effect"><i
                        class="ri-close-line"></i>Cancelar</a>
            </div>

        </div>
    </form>


@endsection
