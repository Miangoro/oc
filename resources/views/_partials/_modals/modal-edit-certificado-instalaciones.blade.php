<div class="modal fade" id="editCertificadoModal" tabindex="-1" aria-labelledby="editCertificadoModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCertificadoModalLabel">Editar Certificado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCertificadoForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id_certificado" name="id_certificado">
                    
                    <!-- Campo para Dictamen -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select select2" id="edit_id_dictamen" name="id_dictamen" aria-label="No. Dictamen" required>
                            <option value="" disabled selected>Seleccione un dictamen</option>
                            @foreach($dictamenes as $dictamen)
                                <option value="{{ $dictamen->id_dictamen }}" data-tipo-dictamen="{{ $dictamen->tipo_dictamen }}">{{ $dictamen->num_dictamen }}</option>
                            @endforeach
                        </select>
                        <label for="edit_id_dictamen">No. Dictamen</label>
                    </div>

                    <!-- Campo para Número de Certificado -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="edit_numero_certificado" placeholder="No. de Certificado" name="num_certificado" aria-label="No. de Certificado" required>
                        <label for="edit_numero_certificado">No. de Certificado</label>
                    </div>

                    <!-- Campo para Maestro Mezcalero -->
                    <div id="edit_maestroMezcaleroContainer" class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="edit_maestro_mezcalero" placeholder="Maestro Mezcalero" name="maestro_mezcalero" aria-label="Maestro Mezcalero">
                        <label for="edit_maestro_mezcalero">Maestro Mezcalero</label>
                    </div>

                    <!-- Campo para Número de Autorización -->
                    <div class="form-floating form-floating-outline mb-3">
                         <input type="text" class="form-control" id="edit_no_autorizacion" placeholder="No. de Autorización" name="num_autorizacion" aria-label="No. de Autorización" required>
                         <label for="edit_no_autorizacion">No. de Autorización</label>
                    </div>

                    <!-- Campos para Fechas -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="form-floating form-floating-outline flex-fill me-2">
                            <input type="text" class="form-control datepicker" id="edit_fecha_vigencia" placeholder="yyyy-mm-dd" name="fecha_vigencia" aria-label="Fecha de Vigencia" required>
                            <label for="edit_fecha_vigencia">Fecha de Inicio Vigencia</label>
                        </div>
                        <div class="form-floating form-floating-outline flex-fill ms-2">
                            <input type="text" class="form-control datepicker" id="edit_fecha_vencimiento" placeholder="yyyy-mm-dd" name="fecha_vencimiento" aria-label="Fecha de Vencimiento" required>
                            <label for="edit_fecha_vencimiento">Fecha de Vencimiento</label>
                        </div>
                    </div>

                    <!-- Botones del Formulario -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>