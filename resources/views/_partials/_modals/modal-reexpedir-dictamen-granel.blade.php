<!-- Modal para agregar nuevo dictamen de granel -->
<div class="modal fade" id="modalReexDicInsta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lz">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Reexpedir/Cancelar dictamen a granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="formReexDicInsta" method="POST" action="{{ route('dic-insta.reex') }}">
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

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                            <select class="select2 form-select" id="id_inspeccion_rex" name="id_inspeccion" 
                                data-placeholder="Selecciona el no. de servicio">
                                <option value="" disabled selected>NULL</option>
                                @foreach($inspecciones as $insp)
                                <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} | {{ $insp->solicitud->folio }} | {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}</option>
                            @endforeach
                            </select>
                                <label for="">No. de servicio</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="numero_dictamen_rex"
                                    autocomplete="off" name="num_dictamen" placeholder="No. de dictamen">
                                <label for="num_dictamen">No. de dictamen</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <select id="id_firmante_rex" name="id_firmante" class="select2 form-select">
                                    @foreach ($inspectores as $inspector)
                                        <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                    @endforeach
                                </select>
                                <label for="id_firmante">Selecciona un firmante</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control flatpickr-datetime" id="fecha_emision_rex" name="fecha_emision"
                                    autocomplete="off" placeholder="YYYY-MM-DD">
                                <label for="fecha_emision">Fecha de emisión</label>
                            </div>
                        </div>
                            <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control" id="fecha_vigencia_rex" autocomplete="off"
                                    name="fecha_vigencia" placeholder="YYYY-MM-DD" readonly>
                                <label for="fecha_vigencia">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>
                        
                </div>

                    <div class="form-floating form-floating-outline mb-6">
                        <textarea class="form-control h-px-75" id="observaciones_rex" name="observaciones" placeholder="Escribe el motivo de cancelación"
                            rows="3"></textarea>
                        <label for="observaciones">Motivo de cancelación</label>
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

