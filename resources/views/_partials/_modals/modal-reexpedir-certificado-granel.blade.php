<!-- Modal para reexpedir certificado de instalaciones -->
<div class="modal fade" id="modalReexpedirCertificadoGranel" tabindex="-1" aria-labelledby="modalReexpedirCertificadoGranelLabel">
    <div class="modal-dialog modal-lz">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalReexpedirCertificadoInstalacionesLabel" class="modal-title">Reexpedir certificado de lote a granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addReexpedirCertificadoGranelForm" method="POST" action="{{ route('certificados.reexpedir') }}" novalidate>
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

                       <!-- Select para el dictamen -->
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select select2" id="num_dictamen_rex" name="id_dictamen" required>
                            <option value="" disabled selected>Seleccione un dictamen</option>
                            @foreach($dictamenes as $dictamen)
                                <option value="{{ $dictamen->id_dictamen }}">{{ $dictamen->num_dictamen }}</option>
                            @endforeach
                        </select>
                        <label for="formValidationSelect2">Seleccione un dictamen</label>
                    </div>

                    <!-- Select para el firmante -->
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select select2" id="id_firmante_rex" name="id_firmante" required>
                            <option value="" disabled selected>Seleccione un firmante</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <label for="formValidationSelect2">Selecciona un firmante</label>
                    </div>

                    <!-- Campo de texto para num_dictamen -->
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" id="num_certificado_rex" name="num_certificado" placeholder="Número de Dictamen" required>
                        <label for="num_dictamen_text">Número de Certificado</label>
                    </div>

                    <!-- Campos de fecha -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control datepicker" id="fecha_vigencia_rex" name="fecha_vigencia" aria-label="Fecha de Vigencia" readonly>
                                <label for="fecha_vigencia">Fecha de Vigencia</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control datepicker" id="fecha_vencimiento_rex" name="fecha_vencimiento" aria-label="Fecha de Vencimiento" readonly>
                                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                            </div>
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