<!-- Modal para agregar nuevo certificado -->
<div class="modal fade" id="addCertificadoModal" tabindex="-1" aria-labelledby="addCertificadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Nuevo certificado de instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addCertificadoForm">
                    @csrf

                    <!-- Selección de Dictamen -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="select2 form-select" id="id_dictamen" name="id_dictamen" data-placeholder="Selecciona un dictamen" required>
                            <option value="" disabled selected></option>
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
                                <input class="form-control flatpickr-datetime" name="fecha_emision" placeholder="YYYY-MM-DD">
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control flatpickr-datetime" name="fecha_vigencia" placeholder="YYYY-MM-DD" readonly>
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>

                    <!-- Firmante -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="select2 form-select" id="id_firmante" name="id_firmante" aria-label="Nombre Firmante" required>
                            <option value="" disabled selected>Selecciona un firmante</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <label for="formValidationSelect2">Selecciona un firmante</label>
                    </div>
        
                    
                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal para editar certificado -->
<div class="modal fade" id="editCertificadoModal" tabindex="-1" aria-labelledby="editCertificadoModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar certificado de instalaciones</h5>
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
                            <input class="form-control flatpickr-datetime" id="edit_fecha_emision" placeholder="YYYY-MM-DD" name="fecha_emision" required>
                            <label for="">Fecha de emisión</label>
                        </div>
                        <div class="form-floating form-floating-outline flex-fill ms-2">
                            <input class="form-control" id="edit_fecha_vigencia" placeholder="YYYY-MM-DD" name="fecha_vigencia" readonly>
                            <label for="">Fecha de vigencia</label>
                        </div>
                    </div>

                    <!-- Firmante -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="select2 form-select" id="edit_id_firmante" name="id_firmante"  required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <label for="formValidationSelect2">Seleccione un firmante</label>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-pencil-fill"></i> Editar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
