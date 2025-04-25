<!-- Modal para agregar un nuevo certificado -->
<div class="modal fade" id="addCertificadoGrenelModal" tabindex="-1" aria-labelledby="addCertificadoGrenelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCertificadoGrenelModalLabel">Agregar certificado de lote a granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCertificadoForm">
                    <!-- Select para el dictamen -->
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select select2" id="num_dictamen" name="num_dictamen" required>
                            <option value="" disabled selected>Seleccione un dictamen</option>
                        @foreach($dictamenes as $dictamen)
                            <option value="{{ $dictamen->id_dictamen }}">
                                {{ $dictamen->num_dictamen }}
                                @if($dictamen->lote_granel && $dictamen->lote_granel->nombre_lote)
                                    | {{ $dictamen->lote_granel->nombre_lote }}
                                @else
                                    | (sin nombre de lote)
                                @endif
                        
                                @if($dictamen->inspeccion && $dictamen->inspeccion->num_servicio)
                                    | {{ $dictamen->inspeccion->num_servicio }}
                                @else
                                    | (sin número de servicio)
                                @endif
                            </option>
                        @endforeach
                        </select>
                        <label for="formValidationSelect2">Seleccione un dictamen</label>
                    </div>
                    
                    <!-- Select para el firmante -->
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select select2" id="id_firmante" name="id_firmante" required>
                            <option value="" disabled selected>Seleccione un firmante</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <label for="formValidationSelect2">Selecciona un firmante</label>
                    </div>

                    <!-- Campo de texto para num_dictamen -->
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="num_certificado" name="num_certificado" placeholder="Número de Dictamen" required>
                        <label for="num_dictamen_text">Número de Certificado</label>
                    </div>

                    <!-- Campos de fecha -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control datepicker" id="fecha_vigencia" name="fecha_vigencia" aria-label="Fecha de Vigencia" readonly>
                                <label for="fecha_vigencia">Fecha de Vigencia</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control datepicker" id="fecha_vencimiento" name="fecha_vencimiento" aria-label="Fecha de Vencimiento" readonly>
                                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="d-flex justify-content-end mt-3">
                    <button id="btnRegistrarCertidicado" type="submit" class="btn btn-primary me-2">Registrar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!--EDITARRR-->
<!-- Modal para editar un certificado -->
<div class="modal fade" id="editCertificadoGranelModal" tabindex="-1" aria-labelledby="editCertificadoGranelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCertificadoGranelModalLabel">Editar certificado a granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCertificadoForm">
                    <!-- Select para el dictamen -->
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select select2" id="edit_num_dictamen" name="id_dictamen" required>
                            <option value="" disabled selected>Seleccione un dictamen</option>
                        @foreach($dictamenes as $dictamen)
                            <option value="{{ $dictamen->id_dictamen }}">
                                {{ $dictamen->num_dictamen }}
                                @if($dictamen->lote_granel && $dictamen->lote_granel->nombre_lote)
                                    | {{ $dictamen->lote_granel->nombre_lote }}
                                @else
                                    | (sin nombre de lote)
                                @endif
                        
                                @if($dictamen->inspeccion && $dictamen->inspeccion->num_servicio)
                                    | {{ $dictamen->inspeccion->num_servicio }}
                                @else
                                    | (sin número de servicio)
                                @endif
                            </option>
                        @endforeach
                        </select>
                        <label for="formValidationSelect2">Seleccione un dictamen</label>
                    </div>

                    <!-- Select para el firmante -->
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select select2" id="edit_id_firmante" name="id_firmante" required>
                            <option value="" disabled selected>Seleccione un firmante</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <label for="formValidationSelect2">Selecciona un firmante</label>
                    </div>

                    <!-- Campo de texto para num_certificado -->
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="edit_num_certificado" name="num_certificado" placeholder="Número de Dictamen" required>
                        <label for="edit_num_certificado">Número de Certificado</label>
                    </div>

                    <!-- Campos de fecha -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control datepicker" id="edit_fecha_vigencia" name="fecha_vigencia" aria-label="Fecha de Vigencia" readonly>
                                <label for="edit_fecha_vigencia">Fecha de Vigencia</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control datepicker" id="edit_fecha_vencimiento" name="fecha_vencimiento" aria-label="Fecha de Vencimiento" readonly>
                                <label for="edit_fecha_vencimiento">Fecha de Vencimiento</label>
                            </div>
                        </div>
                    </div>
               
                <div class="d-flex justify-content-end mt-3">
                    <button id="btnEditarCertificado" type="submit" class="btn btn-primary me-2">Guardar Cambios</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
