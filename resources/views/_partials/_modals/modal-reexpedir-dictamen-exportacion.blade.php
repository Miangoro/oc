<!-- Modal para reexpedir dictamen de instalaciones -->
<div class="modal fade" id="modalAddReexDicExpor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lz">
        <div class="modal-content">
            <div class="modal-header">
                <h5  class="modal-title">Reexpedir Dictamen de Exportación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <form id="formAddReexDicExpor" method="POST" action="{{ route('dic-expor.reex') }}">
                    @csrf
                    <div class="row mb-4">
                        <input type="hidden" id="reexpedir_id_dictamen" name="id_dictamen">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <select id="accion_reexpedir" name="accion_reexpedir" class="form-select" required>
                                    <option value="" disabled selected>¿Qué quieres hacer?</option>
                                    <option value="1">Cancelar dictamen</option>
                                    <option value="2">Cancelar y reexpedir dictamen</option>
                                </select>
                                <label for="accion_reexpedir">¿Qué quieres hacer?</label>
                            </div>
                        </div>
                    </div>

            <hr>

            <!-- Campos Condicionales -->
            <div id="campos_condicionales" style="display: none;">

                        <!-- Selección de Servicio -->
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-3">
                            <select class="select2 form-select" id="id_inspeccion_rex" name="id_inspeccion" 
                                data-placeholder="Seleccione el no. de servicio">
                                <option value="" disabled selected>NULL</option>
                                @foreach($inspeccion as $insp)
                                <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} | {{ $insp->solicitud->folio }} | {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}</option>
                            @endforeach
                            </select>
                                <label for="">No. de servicio</label>
                            </div>
                        </div>

                        <!-- Número de Dictamen -->
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="numero_dictamen_rex" placeholder="No. de dictamen" name="num_dictamen" aria-label="No. de Certificado">
                            <label for="numero_dictamen_rex">No. de Dictamen</label>
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

                        <!-- Fechas -->
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-floating form-floating-outline flex-fill me-2">
                                <input class="form-control datepicker" id="fecha_emision_rex" placeholder="yyyy-mm-dd" name="fecha_emision" aria-label="Fecha de Vigencia" autocomplete="off" readonly>
                                <label for="fecha_emision_rex">Fecha de emisión</label>
                            </div>
                            <div class="form-floating form-floating-outline flex-fill ms-2">
                                <input class="form-control datepicker" id="fecha_vigencia_rex" placeholder="yyyy-mm-dd" name="fecha_vigencia" aria-label="Fecha de Vencimiento" autocomplete="off" readonly>
                                <label for="fecha_vigencia_rex">Vigencia hasta</label>
                            </div>
                        </div>
            </div>
                    
                     <div class="form-floating form-floating-outline mb-6">
                        <textarea class="form-control h-px-75" id="observaciones_rex" name="observaciones" placeholder="Escribe el motivo de cancelación" rows="3"></textarea>
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
