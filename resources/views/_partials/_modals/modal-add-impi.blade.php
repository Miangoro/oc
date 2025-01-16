<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addImpi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0">
            <div class="text-center mb-6">
                <h4 class="address-title mb-2">Crear nuevo registro</h4>
            </div>

            <form id="AgregarImpi">
            <input type="hidden" name="id" id="user_id">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="date" class="form-control datepicker" name="fecha" 
                            placeholder="seleccione la fecha">
                        <label for="">Fecha de Solicitud</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select" id="tipo_dictamen" name="tramite">
                            <option value="" disabled selected>Selecciona una opcion</option>
                            <option value="1">Registro de marca</option>
                            <option value="2">Trámite USO DE LA DOM</option>
                            <option value="3">Inscripción de convenio de correponsabilidad</option>
                            <option value="4">Liceciamiento de la marca</option>
                            <option value="5">Cesión de derechos de marca</option>
                            <option value="6">Declaración de uso de marca</option>
                        </select>
                        <label for="">Trámite</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input id="add-puesto" type="text" class="form-control" placeholder="Nombre del cliente" aria-label="" name="puesto" />
                        <label for="">Nombre del cliente</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input id="add-puesto" type="text" class="form-control" placeholder="Contraseña de impi" aria-label="" name="puesto" />
                        <label for="">CONTRASEÑA DE IMPI</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input id="add-puesto" type="text" class="form-control" placeholder="Pago de impi" aria-label="" name="puesto" />
                        <label for="">PAGO DE IMPI</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select" id="estatus" name="estatus"
                            aria-label="Default select example">
                            <option value="1">Pendiente</option>
                            <option value="2">Trámite</option>
                            <option value="3">Trámite favorable</option>
                            <option value="4">Trámite no favorable</option>
                        </select>
                        <label for="">Estatus</label>
                    </div>
                </div>
            </div>
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline mb-12">
                        <textarea name="observaciones" class="form-control h-px-150" 
                                placeholder="Observaciones"></textarea>
                        <label for="">Observaciones</label>
                    </div>
                </div>
                
                <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                    {{-- <button type="submit" id="" class="btn btn-primary me-sm-3 me-1 data-submit">Registrar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button> --}}
                </div>
            </form>
        </div>
        </div>
    </div>
</div>



<!-- Offcanvas EDITAR 
<div class="modal fade" id="addImpi" tabindex="-1" aria-hidden="true">
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

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_inspeccion" name="id_inspeccion" class="form-select select2"
                                    aria-label="Default select example">
                                    {{-- @foreach ($inspeccion as $insp) --}}
                                        {{-- <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }}</option> --}}
                                        {{-- <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} | {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}</option>
                                    @endforeach --}}
                                </select>
                                {{-- <input class="form-control" type="text" id="edit_id_inspeccion" name="id_inspeccion"/> --}}
                                <label for="">No. de servicio</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select" id="edit_tipo_dictamen" name="tipo_dictamen"
                                    aria-label="Default select example">
                                    <option value="" disabled selected>Selecciona una opcion</option>
                                    <option value="1">Productor</option>
                                    <option value="2">Envasador</option>
                                    <option value="3">Comercializador</option>
                                    <option value="4">Almacen y bodega</option>
                                </select>
                                <label for="">Tipo de Dictamen</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="edit_num_dictamen"
                                    placeholder="no. dictamen" name="num_dictamen" aria-label="Nombre" required>
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="date" class="form-control datepicker" id="edit_fecha_emision"
                                    placeholder="fecha" name="fecha_emision" aria-label="Nombre" required readonly>
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control datepicker" type="date" placeholder="vigencia"
                                    id="edit_fecha_vigencia" name="fecha_vigencia" required readonly />
                                <label for="">Vigencia hasta</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6 select2-primary">
                                <select id="edit_categorias" name="categorias[]" class="form-select select2"
                                    data-placeholder="Seleccione una o más categorias"
                                    data-error-message="Por favor selecciona una categoría de agave" multiple>
                                    {{-- @foreach ($categoria as $cate)
                                        <option value="{{ $cate->id_categoria }}">{{ $cate->categoria }}</option>
                                    @endforeach --}}
                                </select>
                                {{-- <input type="text" class="form-control" id="edit_categorias" name="categorias"> --}}
                                <label for="edit_categorias">Categorías de agave</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4 select2-primary">
                                <select id="edit_clases" name="clases[]" class="form-select select2"
                                    data-placeholder="Seleccione una o más clases"
                                    data-error-message="Por favor selecciona una clase de agave" multiple>
                                    {{-- @foreach ($clases as $clase)
                                        <option value="{{ $clase->clase }}">{{ $clase->clase }}</option>
                                    @endforeach --}}
                                </select>
                                {{-- <input type="text" class="form-control" id="edit_clases" name="clases"> --}}
                                <label for="edit_clases">Clases de agave</label>
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
</div> -->

