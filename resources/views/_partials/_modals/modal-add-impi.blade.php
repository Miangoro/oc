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
             {{-- <input type="hidden" name="folio" value="otro"> --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="date" class="form-control datepicker" name="fecha_solicitud" 
                            placeholder="seleccione la fecha">
                        <label for="">Fecha de Solicitud</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select" name="tramite">
                            <option value="0" disabled selected>Selecciona una opcion</option>
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
                        <input type="number" class="form-control" placeholder="Nombre del cliente" aria-label="" name="cliente" />
                        <label for="">Nombre del cliente</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" placeholder="Contraseña de impi" aria-label="" name="contrasena" />
                        <label for="">CONTRASEÑA DE IMPI</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" placeholder="Pago de impi" aria-label="" name="pago" />
                        <label for="">PAGO DE IMPI</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select" name="estatus"
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
                    <button type="submit" id="" class="btn btn-primary me-sm-3 me-1 data-submit">Registrar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>



<!-- Offcanvas EDITAR -->
<div class="modal fade" id="editImpi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0">
            <div class="text-center mb-6">
                <h4 class="address-title mb-2">EDITAR</h4>
            </div>

            <form id="EditarImpi">
                <input type="hidden" name="id_impi" id="edit_id_impi" value="">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input id="edit_fecha_solicitud" type="date" class="form-control datepicker" name="fecha_solicitud" 
                            placeholder="seleccione la fecha">
                        <label for="">Fecha de Solicitud</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <select id="edit_tramite" class="form-select" name="tramite">
                            <option value="0" disabled selected>Selecciona una opcion</option>
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
                        <input id="edit_cliente" type="number" class="form-control" placeholder="Nombre del cliente" aria-label="" name="cliente" />
                        <label for="">Nombre del cliente</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input id="edit_contra" type="text" class="form-control" placeholder="Contraseña de impi" aria-label="" name="contrasena" />
                        <label for="">CONTRASEÑA DE IMPI</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input id="edit_pago" type="text" class="form-control" placeholder="Pago de impi" aria-label="" name="pago" />
                        <label for="">PAGO DE IMPI</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <select id="edit_estatus" class="form-select" name="estatus"
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
                        <textarea id="edit_obs" name="observaciones" class="form-control h-px-150" 
                                placeholder="Observaciones"></textarea>
                        <label for="">Observaciones</label>
                    </div>
                </div>
                
                <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                    <button type="submit" id="" class="btn btn-primary me-sm-3 me-1 data-submit">Registrar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
