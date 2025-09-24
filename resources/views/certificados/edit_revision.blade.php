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

    <div class="container mt-3 mb-3">
        <div class="card shadow-sm border-0 rounded-3" style="max-width: 100%; margin: auto;">
            <div class="card-header bg-primary text-white text-center py-2">
               <h5 class="mb-0 text-white">Editar revisión de certificado personal <br><span class="badge bg-warning text-dark text-dark">{{ $datos->certificado->num_certificado ?? 'N/A' }}</span></h5>
            </div>
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Tipo de certificado</p>
                        <h5 class="fw-semibold mb-2">{{ $tipo }}</h5> 
                         @php
                            $caracteristicas = json_decode( $datos->certificado->dictamen->inspeccione->solicitud->caracteristicas);
                            $tipo_certificado = $tipo;
                        @endphp
                        @if (isset($caracteristicas->tipo_solicitud) && $caracteristicas->tipo_solicitud === '2')
                            <span class="badge bg-info">Combinado</span>
                        @endif
                        @if ($datos->es_correccion === 'si')
                            <span class="badge bg-danger">Es corrección</span>
                        @endif

                         @if ($datos->certificado->certificadoReexpedido())
                            @php
                                $nuevoId = $datos->certificado->certificadoReexpedido()?->id_certificado;
                                $urlConNuevoId = $nuevoId ? preg_replace('/\d+$/', $nuevoId, $url) : null;
                                 $solicitud =
                                                    $datos->certificado->dictamen->inspeccione->solicitud ?? null;
                                                $loteGranel = $solicitud->lote_granel ?? null;
                                                $loteEnvasado = $solicitud->lote_envasado ?? null;
                                                $empresa = $loteGranel?->empresa ?? null;

                                                $numero_cliente =
                                                    $empresa && $empresa->empresaNumClientes->isNotEmpty()
                                                        ? $empresa->empresaNumClientes->first(
                                                                fn($item) => $item->empresa_id === $empresa->id &&
                                                                    !empty($item->numero_cliente),
                                                            )?->numero_cliente ?? null
                                                        : null;

                            @endphp


                            <p>Este certificado sustituye al certificado <a target="_blank"
                                    href="{{ '/files/' . $numero_cliente . '/certificados_granel/' . $certificadoEscaneado }}">{{ $datos->certificado->certificadoReexpedido()->num_certificado }}</a>
                                @php
                                    $obs = json_decode($datos->certificado->certificadoReexpedido()?->observaciones);
                                @endphp

                                @if (!empty($obs?->observaciones))
                                    <p><strong>Motivo:</strong> {{ $obs->observaciones }}</p>
                                @endif



                            </p>
                        @endif
                        @php
                            $observaciones = $datos->observaciones ?? '';

                            // Buscar y convertir todas las URLs en enlaces <a>
                            $observacionesConEnlaces = preg_replace(
                                '~(https?://[^\s]+)~',
                                '<a href="$1" target="_blank">$1</a>',
                                e($observaciones) // escapamos antes de aplicar HTML
                            );
                                $contieneEnlace = preg_match('~https?://[^\s]+~', $observaciones);
                        @endphp

                       @if (!empty($observaciones) && !$contieneEnlace)
                            <p><strong>Observaciones:</strong> {{ $observaciones }}</p>
                        @endif

                        @if (!empty($datos->evidencias) && count($datos->evidencias) > 0)
                            @foreach ($datos->evidencias as $evidencia)
                                @if (!empty($evidencia))
                                    {{ $evidencia->nombre_documento }}
                                    <a target="_blank" href="/storage/revisiones/{{ $evidencia->url }}">
                                        <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                    </a>
                                @endif
                            @endforeach
                        @endif

                    </div>
                    <div>
                        <p class="text-muted mb-1">Cliente</p>
                        <h5 class="fw-semibold mb-2">
                             @if ($tipo_certificado !== 'Venta nacional')
                            {{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}
                        @else
                             {{ $datos->certificado->solicitud->empresa->razon_social ?? 'N/A' }}
                        @endif
                         </h5>
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
                                    <th>Documento</th>
                                    <th>Respuesta</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($preguntas as $index => $pregunta)

                                    @php
                                        $respuesta = $respuestas_map[$pregunta->id_pregunta] ?? null;
                                        $respuesta_actual = $respuesta['respuesta'] ?? null;
                                    @endphp
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <th>{{ $pregunta->pregunta }} <input value="{{ $pregunta->id_pregunta }}"
                                                type="hidden" name="id_pregunta[]"></th>

                                        @if ($pregunta->documentacion?->documentacionUrls && $pregunta->id_documento != 69)
                                            @php
                                                $empresa =
                                                    $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa;
                                                $cliente = $empresa?->empresaNumClientes?->firstWhere(
                                                    'numero_cliente',
                                                    '!=',
                                                    null,
                                                );

                                                $documento = $datos->obtenerDocumentosClientes(
                                                    $pregunta->id_documento,
                                                    $empresa?->id_empresa,
                                                );

                                                // Validación especial SOLO para el documento de convenio
                                                $mostrarMensajeConvenio = false;

                                                if ($pregunta->id_documento == 82) {
                                                    // ← ID del convenio
                                                    $convenioCorresp = strtolower(
                                                        trim($empresa?->convenio_corresp ?? ''),
                                                    );
                                                    $convenioValido = !in_array($convenioCorresp, [
                                                        'na',
                                                        'n/a',
                                                        'n.a.',
                                                        'no aplica',
                                                        '',
                                                    ]);

                                                    if (!$convenioValido) {
                                                        $documento = null;
                                                        $mostrarMensajeConvenio = true;
                                                    }
                                                }
                                            @endphp

                                            <td>
                                                @if ($cliente && $documento)
                                                    <a target="_blank"
                                                        href="{{ '../files/' . $cliente->numero_cliente . '/' . $documento }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @elseif ($mostrarMensajeConvenio)
                                                    <span class="text-muted">Convenio no aplica</span>
                                                @else
                                                    <span class="text-muted">Sin documento</span>
                                                @endif
                                            </td>
                                        @elseif($pregunta->filtro == 'nombre_empresa')
                                            <td>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}
                                                @if($tipo_certificado == 'Instalaciones de productor')
                                                    @php    
                                                    $empresa =
                                                    $datos->certificado->dictamen->inspeccione->solicitud->empresa;
                                                        $idUsoDom = 83;
                                                        $cliente = $empresa?->empresaNumClientes->firstWhere(
                                                            'numero_cliente',
                                                            '!=',
                                                            null,
                                                        );
                                                        $documento = $datos->obtenerDocumentosClientes(
                                                            $idUsoDom,
                                                            $empresa->id_empresa,
                                                        );
                                                        @endphp
                                                    
                                                    {{-- Mostrar documento solo si es la constancia fiscal --}}

                                                    @if ($cliente && $documento)
                                                        <br>Autorización del uso de la Denominación de Origen Mezcal (DOM)<a target="_blank"
                                                            href="{{ '../files/' . $cliente->numero_cliente . '/' . $documento }}">
                                                            <i
                                                                class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        @elseif ($pregunta->filtro == 'num_certificado')
                                            <td><b
                                                    class="text-danger">{{ $datos->certificado->num_certificado ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'direccion_fiscal')
                                            <td>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'N/A' }}
                                            </td>
                                         @elseif($pregunta->filtro == 'cp')
                                            <td>{{ $datos->certificado->solicitud->empresa->cp ?? 'No registrado' }} 
                                            </td>
                                        @elseif($pregunta->filtro == 'solicitud_exportacion')
                                            <td>
                                                <a target="_blank"
                                                    href="/solicitud_certificado_exportacion/{{ $datos->certificado->id_certificado ?? 'N/A' }}">
                                                    <i
                                                        class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                                </a>
                                            </td>
                                          @elseif($pregunta->filtro == 'domicilioEnvasado')
                                            <td>{{ $datos->certificado->dictamen->inspeccione->solicitud->instalacion_envasado->direccion_completa ?? $datos->certificado->dictamen->inspeccion->solicitud->instalacion->direccion_completa }}
                                            </td>
                                        @elseif($pregunta->filtro == 'pais')
                                            @php
                                                $empresa =
                                                    $datos->certificado->dictamen->inspeccione->solicitud->empresa;
                                                $idConstanciaFiscal = 76;
                                                $cliente = $empresa?->empresaNumClientes->firstWhere(
                                                    'numero_cliente',
                                                    '!=',
                                                    null,
                                                );
                                                $documento = $datos->obtenerDocumentosClientes(
                                                    $idConstanciaFiscal,
                                                    $empresa->id_empresa,
                                                );
                                            @endphp
                                            <td>
                                                {{-- Mostrar documento solo si es la constancia fiscal --}}

                                                @if ($cliente && $documento)
                                                    <a target="_blank"
                                                        href="{{ '../files/' . $cliente->numero_cliente . '/' . $documento }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin documento</span>
                                                @endif
                                                {{-- Mostrar dirección fiscal siempre --}}
                                                {{ $empresa->domicilio_fiscal ?? 'N/A' }}
                                                <br>País: México
                                                <br>C.P: {{ $empresa->cp ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'destinatario')
                                            <td>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->destinatario ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->direccion ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->pais_destino ?? 'N/A' }}
                                                </td>
                                        @elseif($pregunta->filtro == 'solicitud')
                                            <td>
                                                <a target="_blank"
                                                    href="/solicitud_de_servicio/{{ $datos->certificado->dictamen->inspeccione->id_solicitud ?? 'N/A' }}">
                                                    <i
                                                        class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                                </a>
                                                {{ $datos->certificado->dictamen->inspeccione->solicitud->folio ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'categoria_clase')
                                            @php
                                                $solicitud = $datos->certificado->dictamen->inspeccione->solicitud;
                                                $lote_granel = $solicitud->lote_granel;
                                                $lote_envasado = $solicitud->lote_envasado;
                                            @endphp
                                            <td>

                                                {{ $lote_granel->categoria->categoria ?? 'N/A' }}<br>
                                                {{ $lote_envasado->marca->marca ?? 'N/A' }}<br>
                                                {{ $lote_granel->clase->clase ?? 'N/A' }}<br>
                                                {{ $lote_granel->edad ?? 'N/A' }}

                                            </td>
                                        @elseif($pregunta->filtro == 'volumen')
                                            <td>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->presentacion ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->unidad ?? '' }}

                                                </td>
                                        @elseif($pregunta->filtro == 'volumen_granel')
                                            <td>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->volumen ?? 'N/A' }}
                                                    L

                                                </td>
                                        @elseif($pregunta->filtro == 'cont_alc')
                                            <td>{{ round($datos->certificado->dictamen->inspeccione->solicitud->lote_granel->cont_alc) ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'cont_alc_exportacion')
                                            <td>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->cont_alc_envasado ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'nbotellas')
                                            @php
                                                $caracteristicas = json_decode(
                                                    $datos->certificado->dictamen->inspeccione->solicitud
                                                        ->caracteristicas,
                                                    true,
                                                );
                                                $detalle = $caracteristicas['detalles'][0] ?? null;
                                            @endphp

                                            <td>

                                                    {{ $detalle['cantidad_botellas'] ?? 'N/A' }} Botellas<br>
                                                    {{ $detalle['cantidad_cajas'] ?? 'N/A' }} Cajas

                                            </td>
                                        @elseif($pregunta->filtro == 'lotes')
                                            <td>GRANEL:
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->nombre_lote ?? 'N/A' }}<br>
                                                ENVASADO:
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->nombre ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'lote_granel')
                                            <td>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->nombre_lote ?? 'N/A' }}
                                            </td>
                                  @elseif($pregunta->filtro == 'nanalisis')
                                      @php
                                          $folioFq = $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->folio_fq ?? '';

                                          $folios = collect(explode(',', $folioFq))
                                              ->map(fn($f) => trim($f))
                                              ->filter()
                                              ->values();

                                          $primerFolio = $folios->get(0, 'N/A');
                                          $segundoFolio = $folios->get(1, 'N/A');

                                          $documentos = $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->fqs ?? collect();
                                          $doc1 = $documentos->get(0);
                                           $doc2 = $documentos->get(1);
                                      @endphp
                                      <td>
                                          @if ($doc1)
                                              <a target="_blank"
                                                  href="/files/{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)->numero_cliente }}/fqs/{{ $doc1->url }}">
                                                  <i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                              </a>
                                          @endif
                                         Completo: {{ $primerFolio }}
                                         <!--     @if($tipo_certificado == 'Granel' AND $doc2)
                                                <a target="_blank"
                                                    href="/files/{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)->numero_cliente }}/fqs/{{ $doc2->url }}"><i
                                                        class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                                </a>
                                            Ajuste: {{ $segundoFolio }}
                                            @endif -->
                                      </td>

                                  @elseif($pregunta->filtro == 'nanalisis_ajuste')
                                      @php
                                          $documentos = $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->fqs ?? collect();
                                          $doc2 = $documentos->get(1);
                                      @endphp
                                      <td>
                                          @if ($doc2)
                                              <a target="_blank"
                                                  href="/files/{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)->numero_cliente }}/fqs/{{ $doc2->url }}">
                                                  <i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                              </a>
                                          @endif
                                        {{ $segundoFolio }}
                                      </td>
                                        @elseif($pregunta->filtro == 'aduana')
                                            <td>
                                                    {{ json_decode($datos->certificado->dictamen->inspeccione->solicitud->caracteristicas, true)['aduana_salida'] ?? 'N/A' }} <br>
                                                    2208.90.05.00
                                                    <br>
                                                    @foreach ($datos->certificado->dictamen->inspeccione->solicitud->documentacion(55)->get() as $documento)
                                                        <a target="_blank"
                                                            href="/files/{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere(
                                                                'numero_cliente',
                                                                '!=',
                                                                null,
                                                            )->numero_cliente }}/{{ $documento->url }}">
                                                            <i
                                                                class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                                        </a>
                                                    @endforeach
                                                    {{ json_decode($datos->certificado->dictamen->inspeccione->solicitud->caracteristicas, true)['no_pedido'] ?? 'N/A' }}

                                                <br></td>
                                        @elseif($pregunta->filtro == 'domicilio_insta')
                                            <td>

                                                    {{ $datos->certificado->dictamen->instalaciones->direccion_completa ??
                                                        ($datos->certificado->dictamen->inspeccione->solicitud->instalaciones->direccion_completa ?? 'NA') }}

                                            </td>
                                        @elseif($pregunta->filtro == 'correo')
                                            <td>
                                                {{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->correo ?? 'N/A' }}<br>
                                                {{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->telefono ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'fechas')
                                            <td>
                                                {{ $datos?->certificado?->fecha_emision ? Helpers::formatearFecha($datos->certificado->fecha_emision) : 'NA' }}<br>
                                                {{ $datos?->certificado?->fecha_vigencia ? Helpers::formatearFecha($datos->certificado->fecha_vigencia) : 'NA' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'num_dictamen')
                                            @php
                                                // Determina tipo y URL del certificado
                                                $tipo = 'Desconocido';
                                                $url = null;

                                                $dictamen = $datos->certificado?->dictamen;

                                                if ($datos->tipo_certificado == 1 && $datos->certificado?->dictamen) {
                                                    // Certificado normal con dictamen
                                                    $id_dictamen = $datos->certificado->dictamen->tipo_dictamen ?? null;

                                                    switch ($id_dictamen) {
                                                        case 1:
                                                            $tipo = 'Instalaciones de productor';
                                                            $url = '/dictamen_productor/' . $dictamen->id_dictamen;
                                                            break;
                                                        case 2:
                                                            $tipo = 'Instalaciones de envasador';
                                                            $url = '/dictamen_envasador/' . $dictamen->id_dictamen;
                                                            break;
                                                        case 3:
                                                            $tipo = 'Instalaciones de comercializador';
                                                            $url =
                                                                '/dictamen_comercializador/' . $dictamen->id_dictamen;
                                                            break;
                                                        case 4:
                                                            $tipo = 'Instalaciones de almacén y bodega';
                                                            $url = '/dictamen_almacen/' . $dictamen->id_dictamen;
                                                            break;
                                                        case 5:
                                                            $tipo = 'Instalaciones de área de maduración';
                                                            $url = '/dictamen_bodega/' . $dictamen->id_dictamen;
                                                            break;
                                                        default:
                                                            $tipo = 'Desconocido';
                                                    }
                                                } elseif ($datos->tipo_certificado == 2) {
                                                    $tipo = 'Granel';
                                                    $url = '/dictamen_granel/' . $dictamen->id_dictamen;
                                                } elseif ($datos->tipo_certificado == 3) {
                                                    $tipo = 'Exportación';
                                                    $url = '/dictamen_envasado/' . $dictamen->id_dictamen;
                                                }

                                            @endphp

                                            <td>
                                                @if ($dictamen)
                                                    @if ($url)
                                                        <a target="_blank" href="{{ $url }}">
                                                            <i
                                                                class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                        </a>
                                                    @else
                                                        <span>Dictamen no disponible</span>
                                                    @endif
                                                @else
                                                    <span>Dictamen no disponible</span>
                                                @endif
                                                {{ $dictamen->num_dictamen }}
                                            </td>
                                        @elseif($pregunta->filtro == 'certificado_granel')
                                            @php
                                                $solicitud =
                                                    $datos->certificado->dictamen->inspeccione->solicitud ?? null;
                                                $loteGranel = $solicitud->lote_granel ?? null;
                                                $loteEnvasado = $solicitud->lote_envasado ?? null;
                                                $empresa = $loteGranel?->empresa ?? null;

                                                $numero_cliente =
                                                    $empresa && $empresa->empresaNumClientes->isNotEmpty()
                                                        ? $empresa->empresaNumClientes->first(
                                                                fn($item) => $item->empresa_id === $empresa->id &&
                                                                    !empty($item->numero_cliente),
                                                            )?->numero_cliente ?? null
                                                        : null;

                                                $docFirmado = $loteGranel
                                                    ? \App\Models\documentacion_url::where(
                                                        'id_relacion',
                                                        $loteGranel->id_lote_granel,
                                                    )
                                                        ->where('id_documento', 59)
                                                        ->first()
                                                    : null;

                                                $urlFirmado =
                                                    $docFirmado &&
                                                    $docFirmado->url &&
                                                    $numero_cliente &&
                                                    str_ends_with(strtolower($docFirmado->url), '.pdf')
                                                        ? asset(
                                                            "files/{$numero_cliente}/certificados_granel/{$docFirmado->url}",
                                                        )
                                                        : null;
                                            @endphp

                                            <td>
                                                {{-- 📎 Documento firmado PDF (si existe) --}}
                                                @if ($urlFirmado)
                                                    <a target="_blank" href="{{ $urlFirmado }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin certificado firmado adjunto</span>
                                                @endif

                                                {{-- 🧪 Granel --}}
                                                Granel:
                                                {{ $loteGranel?->nombre_lote ?? 'N/A' }}
                                                <br>
                                                <a target="_blank"
                                                    href="/dictamen_envasado/{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->dictamenEnvasado->id_dictamen_envasado }}">
                                                    <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                </a>
                                                Envasado:
                                                {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->nombre ?? 'N/A' }}

                                            </td>
                                        @elseif($pregunta->filtro == 'dom')
                                            <td>
                                                 @php

                                                   
                                                    $empresa = $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->certificadoGranel->dictamen->inspeccione->solicitud->empresa ?? null;
                                                    $numeroCliente = $empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)->numero_cliente ?? null;
                                                    $url = \App\Models\documentacion_url::where('id_empresa', $empresa->id_empresa)
                                                    ->where('id_documento', 83)
                                                    ->value('url');


                                                    $urlDom = '/files/'.$numeroCliente."/".$url;
                                                @endphp
                                             
                                                @if ($url)
                                                    <a target="_blank" href="{{ $urlDom }}">
                                                        <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin documento</span>
                                                @endif
                                            </td>
                                             @elseif($pregunta->filtro == 'convenio_corresponsabilidad')
                                            <td>
                                                 @php
                                                     
                                                    $empresa = $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->certificadoGranel->dictamen->inspeccione->solicitud->empresa ?? null;
                                                    $numeroCliente = $empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)->numero_cliente ?? null;
                                                    $url = \App\Models\documentacion_url::where('id_empresa', $empresa->id_empresa)
                                                    ->where('id_documento', 82)
                                                    ->value('url');


                                                    $urlDom = '/files/'.$numeroCliente."/".$url;
                                                @endphp
                                             
                                                  @if ($url && !in_array($empresa->convenio_corresp, ['NA', 'N/A', ''])) 
                                                    <a target="_blank" href="{{ $urlDom }}">
                                                        <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin documento</span>
                                                @endif
                                            </td>
                                        @elseif($pregunta->filtro == 'categoria')
                                            <td>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->categoria->categoria ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'ingredientes')
                                            <td>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->ingredientes ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'rango_hologramas')
                                        @php
                                            $old = json_decode($datos->certificado->old_hologramas);
                                        @endphp
                                            <td>@if ($old)
                                                @foreach ($old as $key => $folio)
                                                    <div><strong>{{ ucfirst($key) }}:</strong> {{ $folio }}</div>
                                                @endforeach
                                            @else
                                                <div>N/A</div>
                                            @endif
                                            </td>
                                        @elseif($pregunta->filtro == 'edad')
                                            <td>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->edad ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'marca')
                                            <td>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->marca->marca ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'clase')
                                            <td>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->clase->clase ?? 'N/A' }}
                                            </td>
                                        @elseif($pregunta->filtro == 'tipo_maguey')
                                            <td>

                                                    @forelse ($datos->certificado->dictamen->inspeccione->solicitud->lote_granel->tiposRelacionados as $tipo)
                                                        {{ $tipo->nombre }} (<i>{{ $tipo->cientifico }}</i>),
                                                    @empty
                                                        N/A
                                                    @endforelse

                                            </td>
                                        @elseif($pregunta->filtro == 'responsable')
                                            <td>{{ $datos->certificado->firmante->name ?? 'N/A' }}</td>
                                        @elseif($pregunta->filtro == 'direccion_cidam')
                                            <td>Kilómetro 8. Antigua carretera a Pátzcuaro, S/N.
                                                    Col. Otra no especificada en el catálogo.
                                                    C.P. 58341. Morelia, Michoacán. México.</td>
                                        @elseif($pregunta->filtro == 'alcance')
                                            <td> NOM070-SCFI-2016, Bebidas Alcohólicas-Mezcal-Especificaciones.</td>
                                        @elseif($pregunta->filtro == 'cliente')
                                            <td>
                                                    {{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->filter(fn($cliente) => !empty($cliente->numero_cliente))->first()?->numero_cliente ?? 'Sin asignar' }}
                                                </td>
                                        @elseif($pregunta->filtro == 'acta')
                                            <td>
                                                @if ($datos->obtenerDocumentoActa($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->id_solicitud))
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
                                                                '/actas/' .
                                                                $datos->obtenerDocumentoActa($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->id_solicitud)
                                                            : 'NA' }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                    {{ $datos->certificado->dictamen->inspeccione->num_servicio }}
                                                @else
                                                    <span class="text-muted">Sin acta</span>
                                                @endif
                                            </td>
                                        @elseif($pregunta->filtro == 'acta_exportacion')
                                            <td>
                                                @if ($datos->obtenerDocumentoActa($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->id_solicitud))
                                                    {{--  <b>{{ $datos->certificado->dictamen->inspeccione->num_servicio }}</b> --}}
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
                                                                '/actas/' .
                                                                $datos->obtenerDocumentoActa($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->id_solicitud)
                                                            : 'NA' }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                    {{ $datos->certificado->dictamen->inspeccione->num_servicio }}
                                                @else
                                                    <span class="text-muted">Ver arriba</span>
                                                @endif
                                            </td>
                                             @elseif($pregunta->filtro == 'datos_holograma')
                                            <td>{!! $observacionesConEnlaces !!}</td>
                                        @elseif($pregunta->filtro == 'etiqueta')
                                            <td>
                                                @if ($datos->certificado->dictamen->inspeccione->solicitud->etiqueta())
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
                                                                $datos->certificado->dictamen->inspeccione->solicitud->etiqueta()
                                                            : 'NA' }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin etiqueta</span>
                                                @endif
                                            </td>
                                        @elseif($pregunta->filtro == 'corrugado')
                                            <td>
                                                @if ($datos->certificado->dictamen->inspeccione->solicitud->corrugado())
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
                                                                $datos->certificado->dictamen->inspeccione->solicitud->corrugado()
                                                            : 'NA' }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin corrugado</span>
                                                @endif
                                            </td>
                                        @else
                                            <td>Sin datos</td>
                                        @endif
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
            <!-- <div class="col-md-4">
                                                        <iframe width="100%" height="80%" id="pdfViewerDictamenFrame" src="{{ $url }}" frameborder="0"
                                                            style="border-radius: 10px; overflow: hidden;">
                                                        </iframe>
                                                    </div>-->

            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light"><i
                        class="ri-pencil-fill"></i> Editar {{ $datos->numero_revision }}ª revisión</button>
                <a href="/revision/personal" class="btn btn-danger waves-effect"><i
                        class="ri-close-line"></i>Cancelar</a>
            </div>

        </div>
    </form>


@endsection
