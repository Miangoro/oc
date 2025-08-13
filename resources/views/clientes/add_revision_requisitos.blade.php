@extends('layouts/layoutMaster')

@section('title', 'Revisión de certificado')

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
    @vite(['resources/js/certificados_personal.js'])
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


    <div class="container mt-4 mb-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-menu-theme text-center py-3">
                <h5 class="mb-0 text-white">
                    Requisitos a evaluar NOM-070-SCFI-2016<br>
                    <span class="badge bg-warning text-dark">{{ $cliente->empresaNumClientes[0]->numero_cliente ?? 'N/A' }} {{ $cliente->razon_social ?? 'N/A' }}</span>
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="row gy-3">




                </div>

                <!-- Cliente -->
                <div class="col-md-4">
                    <p class="text-muted mb-1">Contacto OC</p>
                    <h5 class="fw-semibold">
                        {{ $cliente->contacto->name ?? 'N/A' }}
                    </h5>
                </div>

                <div class="col-md-4">
                    <p class="text-muted mb-1">Dirección de la instalación</p>
                    <h5 class="fw-semibold">
                        {{ $cliente->instalaciones[0]->direccion_completa ?? 'N/A' }}
                    </h5>
                </div>

            </div> <!-- /row -->
        </div>
    </div>




    <!-- DataTable with Buttons -->
    <form id="formulario" method="POST">
        @csrf
        <input type="hidden" id="id_revision" name="id_revision" value="{{ $datos->id_revision ?? '' }}">
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
                                @php
    $actividadesMostradas = [];
@endphp

@foreach ($preguntas as $index => $pregunta)

    @php
        $actividadActual = $pregunta->actividad->actividad ?? '';
    @endphp

    @if (!in_array($actividadActual, $actividadesMostradas))
        @php
            $actividadesMostradas[] = $actividadActual;
        @endphp
        <tr>
            <th colspan="5" class="bg-light text-dark">{{ $actividadActual ?? 'Documentación general' }}</th>
        </tr>
    @endif

    <tr>
        <th>{{ $index + 1 }}</th>
        <th>
            {{ $pregunta->pregunta }}
            <input value="{{ $pregunta->id_pregunta }}" type="hidden" name="id_pregunta[]">
        </th>

        @if ($pregunta->documentacion?->documentacionUrls && $pregunta->id_documento != 69)
            @php
                $empresa = $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa;
                $cliente = $empresa?->empresaNumClientes?->firstWhere('numero_cliente', '!=', null);
                $documento = $datos->obtenerDocumentosClientes($pregunta->id_documento, $empresa?->id_empresa);
            @endphp

            <td>
                @if ($cliente && $documento)
                    <a target="_blank" href="{{ '../files/' . $cliente->numero_cliente . '/' . $documento }}">
                        <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                    </a>
                @else
                    <span class="text-muted">Sin documento</span>
                @endif
            </td>
        @elseif($pregunta->filtro == 'solicitud_exportacion')
            <td>
                <a target="_blank"
                    href="/solicitud_certificado_exportacion/{{ $datos->certificado->id_certificado ?? 'N/A' }}">
                    <i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                </a>
            </td>
        @elseif($pregunta->filtro == 'domicilioEnvasado')
            <td>
                {{ $datos->certificado->dictamen->inspeccione->solicitud->instalacion_envasado->direccion_completa ?? 'N/A' }}
            </td>
            <td>
                <a target="_blank"
                    href="/dictamen_exportacion/{{ $datos->certificado->dictamen->id_dictamen ?? 'N/A' }}">
                    <i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                </a>
            </td>
        @else
            <td>Sin datos</td>
        @endif

        <td>
            <div class="resp">
                <select class="form-select form-select-sm" name="respuesta[]" aria-label="Elige la respuesta">
                    <option value="" selected disabled>Seleccione</option>
                    <option value="C">C</option>
                    <option value="NC">NC</option>
                    <option value="NA">NA</option>
                </select>
            </div>
        </td>

        <td>
            <textarea name="observaciones[{{ $index }}]" rows="1" class="form-control" placeholder="Observaciones"></textarea>
        </td>
    </tr>
@endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        

            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light"><i class="ri-add-line"></i>
                    Registrar revisión</button>
                <a href="/revision/personal" class="btn btn-danger waves-effect"><i
                        class="ri-close-line"></i>Cancelar</a>
            </div>

        </div>
    </form>


@endsection
