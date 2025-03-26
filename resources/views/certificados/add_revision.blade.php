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
    @vite(['resources/js/revision_certificado.js'])
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
        font-size: 16px !important;
    }
</style>
@section('content')

    <div class="container mt-3 mb-3">
        <div class="card shadow-sm border-0 rounded-3" style="max-width: 100%; margin: auto;">
            <div class="card-header bg-primary text-white text-center py-2">
                <h5 class="mb-0">Revisión de certificado</h5>
            </div>
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Tipo de certificado</p>
                        <h5 class="fw-semibold mb-2">{{ $tipo }}</h5>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Cliente</p>
                        <h5 class="fw-semibold mb-2">
                            {{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</h5>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Revisor</p>
                        <h5 class="fw-semibold mb-0">{{ $datos->user->name ?? 'N/A' }}</h5>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Certificado</p>
                        <a target="_blank" href="{{ $url ?? 'N/A' }}"><i
                                class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- DataTable with Buttons -->
    <form id="formulario" method="POST">
        @csrf
        <input type="hidden" id="id_revision" name="id_revision" value="{{ $datos->id_revision }}">
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
                                        <th>{{ $index + 1 }}</th>
                                        <th>{{ $pregunta->pregunta }} <input value="{{ $pregunta->id_pregunta }}"
                                                type="hidden" name="id_pregunta[]"></th>

                                        @if ($pregunta->documentacion?->documentacionUrls && $pregunta->id_documento != 69)
                                            <td>
                                                <a target="_blank"
                                                    href="{{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->firstWhere(
                                                        'numero_cliente',
                                                        '!=',
                                                        null,
                                                    )?->numero_cliente
                                                        ? '../files/' .
                                                            $datos->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere(
                                                                'numero_cliente',
                                                                '!=',
                                                                null,
                                                            )->numero_cliente .
                                                            '/' .
                                                            $datos->obtenerDocumentosClientes(
                                                                $pregunta->id_documento,
                                                                $datos->certificado->dictamen->inspeccione->solicitud->empresa->id_empresa,
                                                            )
                                                        : 'NA' }}">
                                                    <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                </a>
                                            </td>
                                        @elseif($pregunta->filtro == 'nombre_empresa')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</b>
                                            </td>
                                        @elseif ($pregunta->filtro == 'num_certificado')
                                            <td><b
                                                    class="text-danger">{{ $datos->certificado->num_certificado ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'direccion_fiscal')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'pais')
                                            <td><b>C.P.:
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->cp ?? 'N/A' }}
                                                    País: México</b></td>
                                        @elseif($pregunta->filtro == 'destinatario')
                                            <td><b>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->destinatario ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->direccion ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->pais_destino ?? 'N/A' }}
                                                </b></td>
                                        @elseif($pregunta->filtro == 'solicitud')
                                            <td>
                                                <b>{{ $datos->certificado->dictamen->inspeccione->solicitud->folio ?? 'N/A' }}</b>
                                                <a target="_blank"
                                                    href="/solicitud_de_servicio/{{ $datos->certificado->dictamen->inspeccione->id_solicitud ?? 'N/A' }}">
                                                    <i
                                                        class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                                </a>
                                            </td>
                                        @elseif($pregunta->filtro == 'categoria_clase')
                                            <td><b>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->categoria->categoria ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->clase->clase ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->tipos ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->marca->marca ?? 'N/A' }}
                                                </b></td>
                                        @elseif($pregunta->filtro == 'volumen')
                                            <td><b>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->presentacion ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->unidad ?? '' }}

                                                </b></td>
                                        @elseif($pregunta->filtro == 'volumen_granel')
                                                <td><b>
                                                        {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->volumen ?? 'N/A' }} L
    
                                                    </b></td>
                                        @elseif($pregunta->filtro == 'cont_alc')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->cont_alc ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'nbotellas')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->detalles[0]['cantidad_botellas'] ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'lotes')
                                            <td><b>GRANEL:
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->nombre_lote ?? 'N/A' }}</b><br>
                                                <b>ENVASADO:
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->nombre ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'lote_granel')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->nombre_lote ?? 'N/A' }}</b></td>
                                        @elseif($pregunta->filtro == 'nanalisis')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->folio_fq ?? 'N/A' }}</b><br>
                                            </td>
                                        @elseif($pregunta->filtro == 'aduana')
                                            <td><b>
                                                    {{ json_decode($datos->certificado->dictamen->inspeccione->solicitud->caracteristicas, true)['aduana_salida'] ?? 'N/A' }}
                                                    2208.90.05.00
                                                    {{ json_decode($datos->certificado->dictamen->inspeccione->solicitud->caracteristicas, true)['no_pedido'] ?? 'N/A' }}
                                                </b><br></td>
                                        @elseif($pregunta->filtro == 'domicilio_insta')
                                            <td>
                                                <b>
                                                    {{ $datos->certificado->dictamen->instalaciones->direccion_completa ??
                                                        ($datos->certificado->dictamen->inspeccione->solicitud->instalaciones->direccion_completa ?? 'NA') }}
                                                </b>
                                            </td>
                                        @elseif($pregunta->filtro == 'correo')
                                            <td>
                                                <b>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->correo ?? 'N/A' }}</b><br>
                                                <b>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->telefono ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'fechas')
                                            <td>
                                                <b>{{ $datos?->certificado?->fecha_vigencia ? Helpers::formatearFecha($datos->certificado->fecha_vigencia) : 'NA' }}</b><br>
                                                <b>{{ $datos?->certificado?->fecha_vencimiento ? Helpers::formatearFecha($datos->certificado->fecha_vencimiento) : 'NA' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'num_dictamen')
                                            <td>
                                                @php
                                                    $dictamenRutas = [
                                                        1 => '/dictamen_productor/',
                                                        2 => '/dictamen_envasador/',
                                                        3 => '/dictamen_comercializador/',
                                                        4 => '/dictamen_almacen/',
                                                        5 => '/dictamen_bodega/',
                                                    ];

                                                    $tipoDictamen =
                                                        $datos->certificado->dictamen->tipo_dictamen ?? null;
                                                    $pdf_dictamen = $dictamenRutas[$tipoDictamen] ?? null;
                                                @endphp

                                                <b>{{ $datos->certificado->dictamen->num_dictamen ?? 'N/A' }}</b>

                                                @if ($pdf_dictamen)
                                                    <a target="_blank"
                                                        href="{{ $pdf_dictamen . $datos->certificado->dictamen->id_dictamen }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @else
                                                    <span>Dictamen no disponible</span>
                                                @endif
                                            </td>
                                        @elseif($pregunta->filtro == 'categoria')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->categoria->categoria ?? 'N/A' }}</b></td>
                                        @elseif($pregunta->filtro == 'marca')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->marca->marca ?? 'N/A' }}</b></td>
                                        @elseif($pregunta->filtro == 'clase')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->clase->clase ?? 'N/A' }}</b></td>
                                        @elseif($pregunta->filtro == 'tipo_maguey')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->tipos ?? 'N/A' }}</b><br></td>
                                        @elseif($pregunta->filtro == 'responsable')
                                            <td><b>{{ $datos->certificado->firmante->name ?? 'N/A' }}</b></td>
                                        @elseif($pregunta->filtro == 'direccion_cidam')
                                            <td><b>Kilómetro 8. Antigua carretera a Pátzcuaro, S/N.
                                                    Col. Otra no especificada en el catálogo.
                                                    C.P. 58341. Morelia, Michoacán. México.</b></td>
                                        @elseif($pregunta->filtro == 'alcance')
                                            <td><b> NOM070-SCFI-2016, Bebidas Alcohólicas-Mezcal-Especificaciones.</b></td>
                                        @elseif($pregunta->filtro == 'cliente')
                                            <td><b>
                                                    {{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->filter(fn($cliente) => !empty($cliente->numero_cliente))->first()?->numero_cliente ?? 'Sin asignar' }}
                                                </b></td>
                                        @elseif($pregunta->filtro == 'acta')
                                            <td>
                                                @if ($datos->obtenerDocumentoActa($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->id_solicitud))
                                                    <b>{{ $datos->certificado->dictamen->inspeccione->num_servicio }}</b>
                                                    <a target="_blank"
                                                        href="{{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->firstWhere(
                                                            'numero_cliente',
                                                            '!=',
                                                            null,
                                                        )?->numero_cliente
                                                            ? '../files/' .
                                                                $datos->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere(
                                                                    'numero_cliente',
                                                                    '!=',
                                                                    null,
                                                                )->numero_cliente .
                                                                '/' .
                                                                $datos->obtenerDocumentoActa($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->id_solicitud)
                                                            : 'NA' }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @else
                                            <td>Sin datos</td>
                                        @endif
                                        <td>
                                            <div class="resp">
                                                <select class="form-select form-select-sm" aria-label="Elige la respuesta"
                                                    name="respuesta[]">
                                                    <option value="" selected disabled>Seleccione</option>
                                                    <option value="C">C</option>
                                                    <option value="NC">NC</option>
                                                    <option value="NA">NA</option>
                                                </select>
                                            </div>
                                        </td>

                                        <td>
                                            <textarea name="observaciones[{{ $index }}]" rows="1" name="" id="" class="form-control"
                                                placeholder="Observaciones"></textarea>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4">
                <iframe width="100%" height="80%" id="pdfViewerDictamenFrame" src="{{ $url }}" frameborder="0"
                    style="border-radius: 10px; overflow: hidden;">
                </iframe>
            </div>-->

            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">Registrar revisión</button>
                <a href="/revision/personal" class="btn btn-outline-danger waves-effect">Cancelar</a>
            </div>

        </div>
    </form>


@endsection
