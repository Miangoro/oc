
 <!-- MODAL REEXPEDIR -->
 <div class="modal fade" id="ModalReexpedir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lz">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Reexpedir/Cancelar dictamen de instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormReexpedir" method="POST" action="{{ route('dic-insta.reex') }}">
                    <div class="row mb-4">
                        <input type="hidden" id="rex_id_dictamen" name="id_dictamen">
                        
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <select id="accion_reexpedir" name="accion_reexpedir" class="form-select" required>
                                    <option value="" disabled selected>¿Qué quieres hacer?</option>
                                    <option value="1">Cancelar</option>
                                    <option value="2">Cancelar y reexpedir</option>
                                </select>
                                <label for="">¿Qué quieres hacer?</label>
                            </div>
                        </div>
                    </div>

                <hr>
                    
                
                <!-- Campos Condicionales -->
                <div id="campos_condicionales" style="display: none;">

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                            <select class="select2 form-select" id="rex_id_inspeccion" name="id_inspeccion" 
                                data-placeholder="Selecciona el número de servicio">
                                <option value="" disabled selected>NULL</option>
                                @foreach($inspeccion as $insp)
                                <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} | {{ $insp->solicitud->folio }} | {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}</option>
                            @endforeach
                            </select>
                                <label for="">No. de servicio</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select" id="rex_tipo_dictamen" name="tipo_dictamen"
                                    aria-label="Default select example">
                                    <option value="1">Productor</option>
                                    <option value="2">Envasador</option>
                                    <option value="3">Comercializador</option>
                                    <option value="4">Almacen y bodega</option>
                                </select>
                                <label for="">Tipo de dictamen</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="rex_numero_dictamen"
                                    name="num_dictamen" placeholder="No. de dictamen">
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <select id="rex_id_firmante" name="id_firmante" class="select2 form-select">
                                    @foreach ($users as $inspector)
                                        <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                    @endforeach
                                </select>
                                <label for="">Selecciona un firmante</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control flatpickr-datetime" id="rex_fecha_emision" name="fecha_emision"
                                    placeholder="YYYY-MM-DD">
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control" id="rex_fecha_vigencia" autocomplete="off"
                                    name="fecha_vigencia" placeholder="YYYY-MM-DD" readonly>
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>
                        
                </div>

                    <div class="form-floating form-floating-outline mb-6">
                        <textarea class="form-control h-px-75" id="rex_observaciones" name="observaciones" placeholder="Escribe el motivo de cancelación"
                            rows="3"></textarea>
                        <label for="">Motivo de cancelación</label>
                    </div>
                       

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="ri-close-line"></i> Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
