<!-- Modal para agregar nuevo certificado -->
<div class="modal fade" id="addCertificadoModal" tabindex="-1" aria-labelledby="addCertificadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCertificadoModalLabel">Agregar certificado de instalaciones</h5>
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
                                    {{ $dictamen->num_dictamen }} | 
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
                        <label for="formValidationSelect2">Seleccione un dictamen</label>
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
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control datepicker" id="fecha_vigencia" name="fecha_vigencia" aria-label="Fecha de Inicio Vigencia" readonly>
                                <label for="fecha_vigencia">Fecha de Inicio Vigencia</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control datepicker" id="fecha_vencimiento" name="fecha_vencimiento" aria-label="Fecha de Vencimiento" readonly>
                                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                            </div>
                        </div>
                    </div>

                    <!-- Firmante -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="select2 form-select" id="id_firmante" name="id_firmante" aria-label="Nombre Firmante" required>
                            <option value="" disabled selected>Seleccione un firmante</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <label for="formValidationSelect2">Seleccione un firmante</label>
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
