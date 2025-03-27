<!-- Modal para agregar nuevo dictamen de Envasado -->
<div class="modal fade" id="modalAddDictamenEnvasado" tabindex="-1" aria-labelledby="modalAddDictamenEnvasadoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="modalAddDictamenEnvasadoLabel" class="modal-title">Nuevo Dictamen de Envasado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addNewDictamenEnvasadoForm" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_inspeccion" name="id_inspeccion" class="select2 form-select" data-placeholder="Selecciona el número de servicio">
                                    <option value="" disabled selected></option>
                                    @foreach ($inspecciones as $inspeccion)
                                        <option value="{{ $inspeccion->id_inspeccion }}">{{ $inspeccion->num_servicio }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_inspeccion">No. de servicio</label>
                            </div>
                        </div>
                    </div>
               
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="num_dictamen" name="num_dictamen" autocomplete="off"
                                    placeholder="Número de dictamen">
                                <label for="num_dictamen">No. de dictamen</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select  id="id_firmante" name="id_firmante" class="select2 form-select">
                                <option value="" disabled selected>Selecciona un firmante</option>
                                @foreach ($inspectores as $inspector)
                                    <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                @endforeach
                             </select>
                                <label for="id_firmante">Selecciona un firmante</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control flatpickr-datetime" id="fecha_emision" name="fecha_emision" autocomplete="off"
                                    placeholder="yyyy-mm-dd">
                                <label for="fecha_emision">Fecha de emisión</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" id="fecha_vigencia" name="fecha_vigencia" readonly
                                    placeholder="yyyy-mm-dd">
                                <label for="fecha_vigencia">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-center mt-6">
                        <button type="submit" class="btn btn-primary me-2">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- EDITAR DICTAMEN DE ENVASADO -->
<div class="modal fade" id="modalEditDictamenEnvasado" tabindex="-1" aria-labelledby="modalAddDictamenEnvasadoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="modalAddDictamenEnvasadoLabel" class="modal-title">Editar Dictamen Envasado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addNEditDictamenEnvasadoForm" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="edit_id_dictamen" name="id_dictamen">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_inspeccion" name="id_inspeccion" class="select2 form-select"  data-placeholder="Selecciona el número de servicio">
                                    @foreach ($inspecciones as $inspeccion)
                                        <option value="{{ $inspeccion->id_inspeccion }}">{{ $inspeccion->num_servicio }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_inspeccion">No. de servicio</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="edit_num_dictamen" name="num_dictamen" autocomplete="off"
                                    placeholder="Número de dictamen">
                                <label for="num_dictamen">No. de dictamen</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select  id="edit_id_firmante" name="id_firmante" class="select2 form-select">
                                @foreach ($inspectores as $inspector)
                                    <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                @endforeach
                             </select>
                                <label for="id_firmante">Nombre del inspector</label>
                            </div>
                        </div>
                    </div>
                 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control flatpickr-datetime" id="edit_fecha_emision" name="fecha_emision" autocomplete="off"
                                    placeholder="yyyy-mm-dd">
                                <label for="fecha_emision">Fecha de Emisión</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" id="edit_fecha_vigencia" name="fecha_vigencia" readonly
                                    placeholder="yyyy-mm-dd">
                                <label for="fecha_vigencia">Fecha de Vigencia</label>
                            </div>
                        </div>
                    </div>
   
                    
                    <div class="d-flex justify-content-center mt-6">
                        <button type="submit" class="btn btn-primary me-2">Editar</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
