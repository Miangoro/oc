@extends('layouts/layoutMaster')

@section('title', 'DataTables - Tables')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')

@endsection

@php
    use App\Helpers\Helpers;
@endphp

@section('content')

    <h4>Revisión por parte del personal del OC para la decisión de la certificación</h4>
    <h3>{{ $tipo }}</h3>
    <h3> {{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A'}}</h3>
    <!-- DataTable with Buttons -->
    <div class="row">
        <div class="col-md-8">
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
                                    <th>{{ $pregunta->pregunta }}</th>

                                    @if($pregunta->documentacion?->documentacionUrls && $pregunta->id_documento != 69)
                                        <td>
                                            <a target="_blank" href="{{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->firstWhere('numero_cliente', '!=', null)?->numero_cliente 
                                            ? '../files/' . $datos->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)->numero_cliente . '/' . 
                                                $datos->obtenerDocumentosClientes($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->solicitud->empresa->id_empresa) 
                                                : 'NA' }}">
                                                <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                            </a>
                                        </td>
                                    @elseif($pregunta->filtro == 'nombre_empresa')
                                        <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</b></td>
                                    @elseif ($pregunta->filtro == 'num_certificado')
                                        <td><b class="text-danger">{{ $datos->certificado->num_certificado ?? 'N/A' }}</b></td>
                                    @elseif($pregunta->filtro == 'direccion_fiscal')
                                        <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'N/A' }}</b></td>
                                    @elseif($pregunta->filtro == 'pais')
                                        <td><b>C.P.: {{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->cp ?? 'N/A' }} País: México</b></td>
                                    @elseif($pregunta->filtro == 'destinatario')
                                        <td><b>
                                            {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->destinatario ?? 'N/A' }}
                                            {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->direccion ?? 'N/A' }}
                                            {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->pais_destino ?? 'N/A' }}
                                        </b></td>
                                    @elseif($pregunta->filtro == 'solicitud')
                                        <td>
                                            <b>{{ $datos->certificado->dictamen->inspeccione->solicitud->folio ?? 'N/A' }}</b>
                                            <a target="_blank" href="/solicitud_de_servicio/{{ $datos->certificado->dictamen->inspeccione->id_solicitud ?? 'N/A' }}">
                                                <i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
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
                                    @elseif($pregunta->filtro == 'cont_alc')
                                        <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->cont_alc ?? 'N/A' }}</b></td>
                                    @elseif($pregunta->filtro == 'nbotellas')
                                        <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->detalles[0]['cantidad_botellas'] ?? 'N/A' }}</b></td>
                                    @elseif($pregunta->filtro == 'lote_granel')
                                        <td><b>GRANEL: {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->nombre_lote ?? 'N/A' }}</b><br>
                                            <b>ENVASADO: {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->nombre ?? 'N/A' }}</b></td>
                                    @elseif($pregunta->filtro == 'nanalisis')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->folio_fq ?? 'N/A' }}</b><br></td>
                                    @elseif($pregunta->filtro == 'aduana')
                                            <td><b>
                                                {{ json_decode($datos->certificado->dictamen->inspeccione->solicitud->caracteristicas, true)['aduana_salida'] ?? 'N/A' }} 
                                                2208.90.05.00
                                                {{ json_decode($datos->certificado->dictamen->inspeccione->solicitud->caracteristicas, true)['no_pedido'] ?? 'N/A' }}
                                            </b><br></td>
                                    @elseif($pregunta->filtro == 'domicilio_insta')
                                            <td><b>{{ $datos->certificado->dictamen->instalaciones->direccion_completa ?? 'N/A' }}</b></td>
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
                                                    1 => "/dictamen_productor/",
                                                    2 => "/dictamen_envasador/",
                                                    3 => "/dictamen_comercializador/",
                                                    4 => "/dictamen_almacen/",
                                                    5 => "/dictamen_bodega/",
                                                ];
                                                
                                                $tipoDictamen = $datos->certificado->dictamen->tipo_dictamen ?? null;
                                                $pdf_dictamen = $dictamenRutas[$tipoDictamen] ?? null;
                                            @endphp
                                        
                                            <b>{{ $datos->certificado->dictamen->num_dictamen ?? 'N/A' }}</b>
                                        
                                            @if ($pdf_dictamen)
                                                <a target="_blank" href="{{ $pdf_dictamen.$datos->certificado->dictamen->id_dictamen }}">
                                                    <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                </a>
                                            @else
                                                <span>Dictamen no disponible</span>
                                            @endif
                                        </td>

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
                                                {{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes
                                                    ->filter(fn($cliente) => !empty($cliente->numero_cliente))
                                                    ->first()?->numero_cliente ?? 'Sin asignar' }}
                                            </b></td>
                                        @elseif($pregunta->filtro == 'acta')
                                            <td>
                                                @if($datos->obtenerDocumentoActa($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->id_solicitud) )
                                                <b>{{ $datos->certificado->dictamen->inspeccione->num_servicio }}</b>
                                                <a target="_blank" href="{{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->firstWhere('numero_cliente', '!=', null)?->numero_cliente 
                                                    ? '../files/' . $datos->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)->numero_cliente . '/' .
                                                      $datos->obtenerDocumentoActa($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->id_solicitud)
                                                    : 'NA' }}">
                                                    <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                </a>
                                                
                                                @endif
                                            </td>
                                    
                                    @else
                                        <td>Sin datos</td>
                                    @endif
                                    <td>
                                        <select class="form-select form-select-sm" aria-label="Elige la respuesta"
                                            name="respuesta[{{ $index }}]">
                                            <option value="" selected></option>
                                            <option value="1">C</option>
                                            <option value="2">NC</option>
                                            <option value="3">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea rows="1" name="" id="" class="form-control" placeholder="Observaciones"></textarea>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <iframe width="100%" height="80%" id="pdfViewerDictamenFrame" src="{{ $url }}" frameborder="0"
                style="border-radius: 10px; overflow: hidden;">
            </iframe>
        </div>
    </div>


@endsection
