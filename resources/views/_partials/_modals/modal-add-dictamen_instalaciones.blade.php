

<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addDictamen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Crear nuevo dictamen de instalaciones</h4>
                </div>

        <form id="NuevoDictamen">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select" id="tipo_dictamen"
                            name="tipo_dictamen" aria-label="Default select example">
                            <option value="" disabled selected>Selecciona una opcion</option>
                            <option value="1">Productor</option>
                            <option value="2">Envasador</option>
                            <option value="3">Comercializador</option>
                            <option value="4">Almacen y bodega</option>
                            <option value="5">Área de maduración</option>
                        </select>
                            <label for="">Tipo de Dictamen</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-6">
                    <input type="text" class="form-control" id="num_dictamen" placeholder="no. dictamen" name="num_dictamen" aria-label="Nombre" required>
                    <label for="">No. de dictamen</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-6">
                <input type="date" class="form-control" id="fecha_emision" placeholder="fecha" name="fecha_emision" aria-label="Nombre" required>
                    <label for="">Fecha de emisión</label>
                    </div>
                </div>

                <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-6">
        <input class="form-control" type="date" placeholder="vigencia" id="fecha_vigencia" name="fecha_vigencia" required />
                            <label for="">Vigencia hasta</label>
                        </div>
                </div>
        </div>

        <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <select id="" name="id_inspeccion" class="form-select select2" aria-label="Default select example">
                            <option value="" disabled selected>Elige el número de servicio</option>
                                @foreach ($inspeccion as $insp)
                                <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }}</option>
                                @endforeach
                        </select>
                            <label for="">No. de servicio</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                    <input type="text" class="form-control" id="categorias" placeholder="categoría" name="categorias" aria-label="Nombre" required>
                    <label for="nombre">Categorías</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <select  name="clases[]" class="select2 form-select" multiple  data-error-message="Por favor selecciona una clase">
                           
                                @foreach ($clases as $clase)
                                    <option value="{{ $clase->clase }}">{{ $clase->clase }}</option>
                                @endforeach
                        </select>
                        <label for="">Clases</label>
                    </div>
                </div>  
        </div>

                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
            </form>
            
            </div>
        </div>
    </div>
</div>



    <!-- Offcanvas EDITAR -->
    <div class="modal fade" id="editDictamen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
            <div class="modal-content">
                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body p-0">
                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Editar dictamen</h4>
                    </div>
    
            <form id="EditarDictamen">
                <div class="row">
                    <input type="hidden" name="id_dictamen" id="edit_id_dictamen" value="">
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="edit_tipo_dictamen"
                                name="tipo_dictamen" aria-label="Default select example">
                                <option value="" disabled selected>Selecciona una opcion</option>
                                <option value="1">Productor</option>
                                <option value="2">Envasador</option>
                                <option value="3">Comercializador</option>
                                <option value="4">Almacen y bodega</option>
                            </select>
                                <label for="">Tipo de Dictamen</label>
                        </div>
                    </div>
    
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" id="edit_num_dictamen" placeholder="no. dictamen" name="num_dictamen" aria-label="Nombre" required>
                        <label for="">No. de dictamen</label>
                        </div>
                    </div>
    
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-6">
                    <input type="date" class="form-control" id="edit_fecha_emision" placeholder="fecha" name="fecha_emision" aria-label="Nombre" required>
                        <label for="">Fecha de emisión</label>
                        </div>
                    </div>
    
                    <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-6">
            <input class="form-control" type="date" placeholder="vigencia" id="edit_fecha_vigencia" name="fecha_vigencia" required />
                                <label for="">Vigencia hasta</label>
                            </div>
                    </div>
            </div>
    
            <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-6">
                            <select id="edit_id_inspeccion" name="id_inspeccion" class="form-select" aria-label="Default select example">
                                <option value="" disabled selected>Elige el número de servicio</option>
                                    @foreach ($inspeccion as $insp)
                                    <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }}</option>
                                    @endforeach
                            </select>
                                <label for="">No. de servicio</label>
                        </div>
                    </div>
    
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" id="edit_categorias" placeholder="categoría" name="categorias" aria-label="Nombre" required>
                        <label for="nombre">Categorías</label>
                        </div>
                    </div>
    
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-4">
                            <select id="edit_clases" name="clases" class="form-select" >
                                <option value="" disabled selected>Selecciona una clase</option>
                                    @foreach ($clases as $clase)
                                        <option value="{{ $clase->clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                            </select>
                            <label for="">Clases</label>
                        </div>
                    </div>  
            </div>
    
                        <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                            <button type="submit" class="btn btn-primary">Editar</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancelar</button>
                        </div>
                </form>
                
                </div>
            </div>
        </div>
    </div>




