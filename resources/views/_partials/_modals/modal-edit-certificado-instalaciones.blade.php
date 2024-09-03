<!-- Modal para editar certificado -->
<div class="modal fade" id="editCertificadoModal" tabindex="-1" aria-labelledby="editCertificadoModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCertificadoModalLabel">Editar Certificado de Instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCertificadoForm">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_id_certificado" name="id_certificado">

                    <!-- Selección de Dictamen -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="select2 form-select" id="edit_id_dictamen" name="id_dictamen" aria-label="No. Dictamen" required>
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
                        <input type="text" class="form-control" id="edit_numero_certificado" placeholder="No. de Certificado" name="num_certificado" aria-label="No. de Certificado" required>
                        <label for="edit_numero_certificado">No. de Certificado</label>
                    </div>

                    <!-- Maestro Mezcalero -->
                    <div id="edit_maestroMezcaleroContainer" class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="edit_maestro_mezcalero" placeholder="Maestro Mezcalero" name="maestro_mezcalero" aria-label="Maestro Mezcalero">
                        <label for="edit_maestro_mezcalero">Maestro Mezcalero</label>
                    </div>

                    <!-- Número de Autorización -->
                    <div id="edit_autorizacionContainer" class="form-floating form-floating-outline mb-3" style="display: none;">
                        <input type="text" class="form-control" id="edit_num_autorizacion" placeholder="No. de Autorización" name="num_autorizacion" aria-label="No. de Autorización">
                        <label for="edit_num_autorizacion">No. de Autorización</label>
                    </div>

                    <!-- Fechas -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="form-floating form-floating-outline flex-fill me-2">
                            <input type="text" class="form-control datepicker" id="edit_fecha_vigencia" readonly placeholder="yyyy-mm-dd" name="fecha_vigencia" aria-label="Fecha de Vigencia" autocomplete="off" required>
                            <label for="edit_fecha_vigencia">Fecha de Inicio Vigencia</label>
                        </div>
                        <div class="form-floating form-floating-outline flex-fill ms-2">
                            <input type="text" class="form-control datepicker" id="edit_fecha_vencimiento" readonly placeholder="yyyy-mm-dd" name="fecha_vencimiento" aria-label="Fecha de Vencimiento" autocomplete="off" required>
                            <label for="edit_fecha_vencimiento">Fecha de Vencimiento</label>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
