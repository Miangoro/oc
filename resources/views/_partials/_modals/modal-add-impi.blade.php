
<!-- AGREGAR NUEVO TRAMITE MODAL -->
<div class="modal fade" id="ModalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Registrar trámite ante el IMPI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormAgregar">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control flatpickr-datetime" id="fecha_solicitud" name="fecha_solicitud" placeholder="YYYY-MM-DD" value="@php echo date('Y-m-d'); @endphp">
                                <label for="">Fecha de Solicitud</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="tramite" class="form-select" name="tramite" >
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="1">Registro de marca</option>
                                    <option value="2">Trámite USO DE LA DOM</option>
                                    <option value="3">Inscripción de convenio de correponsabilidad</option>
                                    <option value="4">Licenciamiento de marca</option>
                                    <option value="5">Cesión de derechos de marca</option>
                                    <option value="6">Declaración de uso de marca</option>
                                </select>
                                <label for="">Trámite</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="cliente" name="id_empresa" placeholder="Nombre de la empresa">
                                <label for="cliente">Empresa</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="contrasena" placeholder="Contraseña"
                                    name="contrasena" aria-label="Nombre">
                                <label for="">Contraseña</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="pago" placeholder="Pago"
                                    name="pago" aria-label="Nombre">
                                <label for="">Pago</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select" id="estatus" name="estatus"
                                    aria-label="Default select example">
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="1">Pendiente</option>
                                    <option value="2">Trámite</option>
                                    <option value="3">Trámite favorable</option>
                                    <option value="4">Trámite no favorable</option>
                                </select>
                                <label for="">Estatus</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-12">
                                <textarea id="observaciones" name="observaciones" class="form-control h-px-150"
                                        placeholder="Observaciones"></textarea>
                                <label for="">Observaciones</label>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ri-add-line"></i>Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<!-- EDITAR TRAMITE MODAL -->
<div class="modal fade" id="ModalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar trámite ante el IMPI <span id="folio"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

        <div class="modal-body">
            <form id="FormEditar" method="POST">
                <input type="hidden" name="id_impi" id="edit_id_impi">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input id="edit_fecha_solicitud" class="form-control flatpickr-datetime" name="fecha_solicitud" placeholder="YYYY-MM-DD">
                        <label for="">Fecha de Solicitud</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <select id="edit_tramite" class="form-select" name="tramite">
                            <option value="1">Registro de marca</option>
                            <option value="2">Trámite USO DE LA DOM</option>
                            <option value="3">Inscripción de convenio de correponsabilidad</option>
                            <option value="4">Licenciamiento de marca</option>
                            <option value="5">Cesión de derechos de marca</option>
                            <option value="6">Declaración de uso de marca</option>
                        </select>
                        <label for="">Trámite</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                       <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="edit_cliente" name="id_empresa" placeholder="Nombre de la empresa">
                                <label for="cliente">Empresa</label>
                            </div>
                        <label for="id_empresa">Empresa</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input id="edit_contrasena" type="text" class="form-control" placeholder="Contraseña" aria-label="" name="contrasena" />
                        <label for="">Contraseña</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input id="edit_pago" type="text" class="form-control" placeholder="Pago" aria-label="" name="pago" />
                        <label for="">Pago</label>
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
                        <textarea id="edit_observaciones" name="observaciones" class="form-control h-px-150"
                                placeholder="Observaciones"></textarea>
                        <label for="">Observaciones</label>
                    </div>
                </div>


                <div class="d-flex mt-6 justify-content-center">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ri-pencil-fill"></i>Editar</button>
                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                </div>

            </form>
        </div>
        </div>
    </div>
</div>

