<!-- Modal para reexpedir certificado de instalaciones -->
<div class="modal fade" id="modalAddReexCerExpor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lz">
        <div class="modal-content">
            <div class="modal-header">
                <h5  class="modal-title">Reexpedir Certificado de Instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="formAddReexCerExpor" method="POST" action="{{ route('cer-expor.reex') }}">
                    @csrf
                    <div class="row mb-4">
                        <input type="hidden" id="reexpedir_id_certificado" name="id_certificado">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <select id="accion_reexpedir" name="accion_reexpedir" class="form-select" aria-label="Floating label select example" required>
                                    <option value="" disabled selected>¿Qué quieres hacer?</option>
                                    <option value="1">Cancelar certificado</option>
                                    <option value="2">Cancelar y reexpedir certificado</option>
                                </select>
                                <label for="accion_reexpedir">¿Qué quieres hacer?</label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Campos Condicionales -->
                    <div id="campos_condicionales" style="display: none;">

                        <!-- Selección de Dictamen -->
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-3">
                            <select class="select2 form-select" id="id_dictamen_rex" name="id_dictamen" 
                                data-placeholder="Seleccione un dictamen">
                                <option value="" disabled selected>Seleccione un dictamen</option>
                                @foreach($dictamen as $dictamen)
                                <option value="{{ $dictamen->id_dictamen }}" data-tipo-dictamen="{{ $dictamen->tipo_dictamen }}">
                                    {{ $dictamen->num_dictamen }} - 
                                    @if((string) $dictamen->tipo_dictamen === '1')
                                                Productor
                                    @elseif((string) $dictamen->tipo_dictamen === '2')
                                                Envasador
                                    @elseif((string) $dictamen->tipo_dictamen === '3')
                                                Comercializador
                                    @elseif((string) $dictamen->tipo_dictamen === '4')
                                                Almacén y bodega
                                    @elseif((string) $dictamen->tipo_dictamen === '5')
                                                Área de maduración
                                    @else
                                        {{ $dictamen->tipo_dictamen }}
                                    @endif
                                </option>
                            @endforeach
                            </select>
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>

                        <!-- Número de Certificado -->
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="numero_certificado_rex" placeholder="No. de Certificado" name="num_certificado" aria-label="No. de Certificado">
                            <label for="numero_certificado_rex">No. de Certificado</label>
                        </div>

                        <!-- Firmante -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="select2 form-select" id="id_firmante_rex" name="id_firmante" aria-label="Nombre Firmante">
                                <option value="" disabled selected>Seleccione un firmante</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Campos Opcionales -->
                        <div id="campos_productor" style="display: none;">
                            <div class="form-floating form-floating-outline mb-3" id="maestroMezcaleroContainer">
                                <input type="text" class="form-control" id="maestro_mezcalero_rex" placeholder="Maestro Mezcalero" name="maestro_mezcalero" aria-label="Maestro Mezcalero">
                                <label for="maestro_mezcalero_rex">Maestro Mezcalero</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-3" id="noAutorizacionContainer">
                                <input type="text" class="form-control" id="no_autorizacion_rex" placeholder="No. de Autorización" name="num_autorizacion" aria-label="No. de Autorización">
                                <label for="no_autorizacion_rex">No. de Autorización</label>
                            </div>
                        </div>
                    
                        <!-- Fechas -->
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-floating form-floating-outline flex-fill me-2">
                                <input class="form-control datepicker" id="fecha_vigencia_rex" placeholder="yyyy-mm-dd" name="fecha_emision" aria-label="Fecha de Vigencia" autocomplete="off" readonly>
                                <label for="fecha_vigencia_rex">Fecha de Inicio Vigencia</label>
                            </div>
                            <div class="form-floating form-floating-outline flex-fill ms-2">
                                <input class="form-control datepicker" id="fecha_vencimiento_rex" placeholder="yyyy-mm-dd" name="fecha_vigencia" aria-label="Fecha de Vencimiento" autocomplete="off" readonly>
                                <label for="fecha_vencimiento_rex">Fecha de Vencimiento</label>
                            </div>
                        </div>
                    </div>
                    
                     <div class="form-floating form-floating-outline mb-6">
                        <textarea class="form-control h-px-75" id="observaciones_rex" name="observaciones" placeholder="Escribe el motivo de cancelación" rows="3" required></textarea>
                        <label for="observaciones_rex">Motivo de cancelación</label>
                      </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
