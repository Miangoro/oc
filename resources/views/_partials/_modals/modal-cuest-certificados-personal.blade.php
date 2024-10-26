@php
    use App\Helpers\Helpers;
@endphp

<!-- Modal -->
<div class="modal fade" id="fullscreenModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div style="border-bottom: 2px solid #E0E1E3; background-color: #F2F3F4;">
                <div class="modal-header" style="margin-bottom: 20px;">
                    <h5 class="modal-title custom-title" id="modalFullTitle" style="font-weight: bold;">
                        REVISIÓN POR PARTE DEL PERSONAL DEL OC PARA LA DECISIÓN DE LA CERTIFICACIÓN (INSTALACIONES)
                    </h5>
                    <span style="font-weight: normal; margin-left: 10px; color: #3498db; text-transform: uppercase; font-weight: bold;">
                        {{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->razon_social }}
                    </span>
                    <span style="font-weight: normal; margin-left: 5px; color: #000000; text-transform: uppercase; font-weight: bold;">
                        / <!-- Guion en negro -->
                    </span>
                    <span style="font-weight: normal; margin-left: 5px; color: #e74c3c; text-transform: uppercase; font-weight: bold;">
                        {{ $revisor->user->name }} 
                    </span>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body d-flex" style="overflow-x: hidden;">
                <!-- Contenido Principal -->
                <div class="main-content" style="flex: 1; padding: 15px; height: 100vh; display: flex; flex-direction: column; gap: 10px; margin-top: -20px;">

                    <div class="row">
                        <div class="col-md-7">
                            <div style="border: 1px solid #8DA399; padding: 20px; border-radius: 5px; margin-bottom: 30px;">
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <div class="table-container" style="flex: 1; min-width: 250px;">
                                        <table class="table table-sm table-bordered table-hover table-striped" style="font-size: 12px;">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th style="font-size: 11px;">#</th>
                                                    <th style="font-size: 11px;">Pregunta</th>
                                                    <th style="font-size: 11px;">Documento</th>
                                                    <th style="font-size: 11px;">Respuesta</th>
                                                    <th style="font-size: 11px;">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $contador = 1; @endphp
                                                @foreach($preguntas as $index => $pregunta)
                                                <tr>
                                                    <td>{{ $contador++ }}</td>
                                                    <td>{{ $pregunta->pregunta }}</td>
                                                    @if($pregunta->documentacion?->documentacionUrls)
                                                        <td>
                                                            <a target="_Blank" href="../files/{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes[0]->numero_cliente }}/{{ $revisor->obtenerDocumentosClientes($pregunta->id_documento,$revisor->certificado->dictamen->inspeccione->solicitud->empresa->id_empresa); }}">
                                                                <i class="ri-file-pdf-2-fill text-danger ri-30px cursor-pointer"></i>
                                                            </a>
                                                        </td>
                                                    @elseif($pregunta->filtro == 'cliente')
                                                        <td><b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->first()->numero_cliente ?? 'Sin asignar' }}</b></td>
                                                    @elseif($pregunta->filtro == 'direccion_fiscal')
                                                        <td><b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal }}</b></td>
                                                    @elseif($pregunta->filtro == 'num_certificado')
                                                        <td><b>{{ $revisor->certificado->num_certificado }}</b></td>
                                                    @elseif($pregunta->filtro == 'nombre_empresa')
                                                        <td><b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->razon_social }}</b></td>
                                                    @elseif($pregunta->filtro == 'domicilio_insta')
                                                        <td><b>{{ $revisor->certificado->dictamen->instalaciones->direccion_completa }}</b></td>
                                                    @elseif($pregunta->filtro == 'correo')
                                                        <td>
                                                            <b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->correo }}</b><br>
                                                            <b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->telefono }}</b>
                                                        </td>
                                                    @elseif($pregunta->filtro == 'fechas')
                                                        <td>
                                                            <b>{{ Helpers::formatearFecha($revisor->certificado->fecha_vigencia) }}</b><br>
                                                            <b>{{ Helpers::formatearFecha($revisor->certificado->fecha_vencimiento) }}</b>
                                                        </td>
                                                    @else
                                                        <td>Sin datos</td>
                                                    @endif
                                                    <td>
                                                        <select class="form-select form-select-sm" aria-label="Elige la respuesta" name="respuesta[{{ $index }}]">
                                                            <option value="" selected>Selecciona</option>
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
                                <hr>
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-primary" id="registrarRevision">
                                        Registrar Revisión
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 position-relative" style="height: 80%;">
                            <div id="modal-loading-spinner" class="text-center" style="display: none; 
                                 position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 10;
                                 display: flex; justify-content: center; align-items: center;">
                                <div class="sk-circle-fade sk-primary" style="width: 4rem; height: 4rem;">
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                </div>
                            </div>
                        
                            <iframe width="100%" height="80%" id="pdfViewerDictamenFrame" 
                                    src="" 
                                    frameborder="0" 
                                    style="border-radius: 10px; overflow: hidden;">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div>
