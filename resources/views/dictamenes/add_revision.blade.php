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


<!-- PANEL REVISION-->
<div class="container mt-4 mb-4">
  <div class="card shadow-sm border-0 rounded-3">

    <div class="card-header bg-menu-theme text-center py-3">
      <h5 class="mb-0 text-white">
        Revisión del acta <br>
        <span class="badge bg-warning text-dark">{{ $revision->inspeccion->num_servicio ?? 'N/A' }}</span>
      </h5>
    </div>

    <div class="card-body p-4">
      <div class="row gy-3">

        <!-- tipo solicitud Columna 1 -->
        <div class="col-md-4">
          <p class="text-muted mb-1 mr-2">Tipo de solicitud
            @if ($revision->es_correccion === 'si')
              <span class="badge bg-danger" style="margin-top: -10px; margin-left: 5px">Es corrección</span>
            @endif
          </p>
          <h5 class="fw-semibold">
          {{ $tipo }}
          </h5>

          <div class="mt-4">
              <p class="text-muted mb-1">Acta</p>
              <span class="fw-semibold"> </span>
            @php    
              $empresa = $revision->inspeccion->solicitud->empresa;
              $cliente = $empresa?->empresaNumClientes->firstWhere( 'numero_cliente', '!=', null );
              // Acta (tipo 69)
              $acta = \App\Models\Documentacion_url::where('id_empresa', $empresa->id_empresa)
                    ->where('id_documento', 69)
                    ->where('id_relacion', $revision->inspeccion->solicitud->id_solicitud)
                    ->value('url');
              // Evidencias (tipo 70)
              $evidencias = \App\Models\Documentacion_url::where('id_empresa', $empresa->id_empresa)
                  ->where('id_documento', 70)
                  ->where('id_relacion', $revision->inspeccion->solicitud->id_solicitud)
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
            {{ $revision->inspeccion->solicitud->empresa->razon_social ?? 'N/A' }}
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
            <img src="{{ asset('storage/' .$revision->user->profile_photo_path) }}" alt="Foto revisor"
              class="rounded-circle border border-3 border-white shadow-sm me-3"
              width="60" height="60" style="object-fit: cover;">
            <div>
              <h6 class="mb-0 fw-bold text-primary" style="font-size: 1.1rem;">
                {{ $revision->user->name ?? 'N/A' }}
              </h6>
              <p class="mb-0 text-muted small">Responsable de esta revisión</p>
            </div>
          </div>

          <!-- Inspector -->
          <div class="mt-2">
            <div class="d-flex align-items-center border rounded-3 p-2 shadow-sm bg-light">
                <img src="{{ asset('storage/' . $revision->inspeccion->inspector->profile_photo_path) }}"
                    alt="Foto consejo"
                    class="rounded-circle me-3 border border-white shadow-sm"
                    width="50" height="50" style="object-fit: cover;">
                <div>
                    <p class="text-muted mb-0 small">Inspector que realizó el servicio</p>
                    <h6 class="mb-0 fw-semibold">{{ $revision->inspeccion->inspector->name ?? 'N/A' }}</h6>
                </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Sección documentación extra -->
    <div class="card pt-2">
        <div class="mt-5">
            <div id="contenedor-documentos" class="mt-3"></div>
        </div>
    </div>


  </div>
</div>



<!-- FORMULARIO -->
<form id="formulario" method="POST">
  <input type="hidden" id="id_revision" name="id_revision" value="{{ $revision->id_revision }}">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-datatable table-responsive pt-0">

          <table class="table table-bordered table-sm table-hover table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Pregunta</th>
                {{-- <th>Documento</th> --}}
                <th>Respuesta</th>
                <th>Observaciones</th>
              </tr>
            </thead>
            <tbody>
              
              @php    
                $empresa = $revision->inspeccion->solicitud->empresa;
                $cliente = $empresa?->empresaNumClientes->firstWhere( 'numero_cliente', '!=', null );
              @endphp
              @foreach ($preguntas as $index => $pregunta)

                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>
                    {{ $pregunta->pregunta }}
                    <input value="{{ $pregunta->id_pregunta }}" type="hidden" name="id_pregunta[]">
                  </td>

                  <!--COLUMNA DOCUMENTO-->
                  {{-- <td>
                    @if($pregunta->filtro == 'acta')
                      {{ $revision->inspeccion->num_servicio}}
                    @php
                      $acta = null;
                      if ($pregunta->id_documento) {
                        // Obtiene acta específica
                        $acta = \App\Models\Documentacion_url::where('id_empresa', $empresa->id_empresa)
                                ->where('id_documento', 69)
                                ->where('id_relacion', $revision->inspeccion->solicitud->id_solicitud)
                                ->value('url');
                      }
                    @endphp
                      @if($acta)
                        <a target="_blank" href="{{ asset('files/' . $cliente->numero_cliente . '/actas/' . $acta) }}">
                          <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                        </a>
                      @else
                          <span class="text-muted">Sin documento</span>
                      @endif
                    @endif
                  </td> --}}

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

                  <!--OBSERVACIONES-->
                  <td>
                    <textarea id="" name="observaciones[{{ $index }}]" rows="1"  
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
                <i class="ri-add-line"></i> Registrar {{ $revision->numero_revision }}ª revisión
            </button>
            <a href="/revision/unidad_inspeccion" class="btn btn-danger waves-effect">
                <i class="ri-close-line"></i> Cancelar
            </a>
        </div>

  </div>
</form>

@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {
    let id_solicitud = @json($id_solicitud);

    if (id_solicitud) {
        $.ajax({
            url: '/getDocumentosSolicitud/' + id_solicitud,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let html = `<table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th colspan="2" class="text-center fw-semibold text-white">
                                                Documentación previa de la solicitud
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                    // Solicitud de servicio
                    html += `
                        <tr>
                            <td>Solicitud de servicios</td>
                            <td>
                                <a href="/solicitud_de_servicio/${id_solicitud}" target="_blank">
                                    <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                </a>
                            </td>
                        </tr>`;

                    // Certificados granel
                    if (response.url_certificado.length > 0) {
                        response.url_certificado.forEach(url => {
                            html += `
                                <tr>
                                    <td>Certificado de granel</td>
                                    <td>
                                        <a href="/files/${response.numero_cliente_lote}/certificados_granel/${url}" target="_blank">
                                            <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                        </a>
                                    </td>
                                </tr>`;
                        });
                    }

                    // FQs
                    if (response.fqs.length > 0) {
                        response.fqs.forEach(fq => {
                            html += `
                                <tr>
                                    <td>${fq.nombre_documento}</td>
                                    <td>
                                        <a href="/files/${response.numero_cliente_lote}/fqs/${fq.url}" target="_blank">
                                            <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                        </a>
                                    </td>
                                </tr>`;
                        });
                    }

                    html += `</tbody></table>`;
                    $('#contenedor-documentos').html(html);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error AJAX:', error);
                $('#contenedor-documentos').html('<p class="text-muted">No se pudo cargar la documentación previa.</p>');
            }
        });
    }
});
</script>
