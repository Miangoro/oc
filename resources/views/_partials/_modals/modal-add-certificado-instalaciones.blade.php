<!-- Modal para agregar nuevo certificado -->
<div class="modal fade" id="addCertificadoModal" tabindex="-1" aria-labelledby="addCertificadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCertificadoModalLabel">Agregar Certificado de Instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCertificadoForm">
                    @csrf

                    <!-- Selección de Dictamen -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="select2 form-select" id="id_dictamen" name="id_dictamen" aria-label="No. Dictamen" required>
                            <option value="" disabled selected>Seleccione un dictamen</option>
                            @foreach($dictamenes as $dictamen)
                                <option value="{{ $dictamen->id_dictamen }}" data-tipo-dictamen="{{ $dictamen->tipo_dictamen }}">
                                    {{ $dictamen->num_dictamen }} - 
                                    @if((string) $dictamen->tipo_dictamen === '1')
                                        <strong>Productor</strong>
                                    @elseif((string) $dictamen->tipo_dictamen === '2')
                                        <strong>Envasador</strong>
                                    @elseif((string) $dictamen->tipo_dictamen === '3')
                                        <strong>Comercializador</strong>
                                    @elseif((string) $dictamen->tipo_dictamen === '4')
                                        <strong>Almacén y bodega</strong>
                                    @elseif((string) $dictamen->tipo_dictamen === '5')
                                        <strong>Área de maduración</strong>
                                    @else
                                        {{ $dictamen->tipo_dictamen }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Número de Certificado -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="numero_certificado" placeholder="No. de Certificado" name="num_certificado" aria-label="No. de Certificado" required>
                        <label for="numero_certificado">No. de Certificado</label>
                    </div>

                    <!-- Maestro Mezcalero -->
                    <div class="form-floating form-floating-outline mb-3" id="maestroMezcaleroContainer" style="display: none;">
                        <input type="text" class="form-control" id="maestro_mezcalero" placeholder="Maestro Mezcalero" name="maestro_mezcalero" aria-label="Maestro Mezcalero">
                        <label for="maestro_mezcalero">Maestro Mezcalero</label>
                    </div>

                    <!-- Número de Autorización -->
                    <div class="form-floating form-floating-outline mb-3" id="noAutorizacionContainer" style="display: none;">
                        <input type="text" class="form-control" id="no_autorizacion" placeholder="No. de Autorización" name="num_autorizacion" aria-label="No. de Autorización">
                        <label for="no_autorizacion">No. de Autorización</label>
                    </div>

                    <!-- Fechas -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="form-floating form-floating-outline flex-fill me-2">
                            <input class="form-control datepicker" id="fecha_vigencia" placeholder="yyyy-mm-dd" name="fecha_vigencia" aria-label="Fecha de Vigencia" autocomplete="off" required>
                            <label for="fecha_vigencia">Fecha de Inicio Vigencia</label>
                        </div>
                        <div class="form-floating form-floating-outline flex-fill ms-2">
                            <input class="form-control datepicker" id="fecha_vencimiento" placeholder="yyyy-mm-dd" name="fecha_vencimiento" aria-label="Fecha de Vencimiento" autocomplete="off" required>
                            <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">Registrar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
