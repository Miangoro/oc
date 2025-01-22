
<!-- AGREGAR NUEVO TRAMITE MODAL -->
<div class="modal fade" id="addDictamen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Crear nuevo IMPI</h4>
                </div>

                <form id="NuevoDictamen">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="date" class="form-control datepicker" id="fecha_solicitud"
                                    placeholder="fecha" name="fecha_solicitud" aria-label="Nombre">
                                <label for="">Fecha de Solicitud</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                {{-- <input type="text" class="form-control" id="tramite" placeholder="no. dictamen"
                                    name="tramite" aria-label="Nombre"> --}}
                                <select id="tramite" class="form-select" name="tramite">
                                    <option value="" disabled selected>Selecciona una opcion</option>
                                    <option value="1">Registro de marca</option>
                                    <option value="2">Trámite USO DE LA DOM</option>
                                    <option value="3">Inscripción de convenio de correponsabilidad</option>
                                    <option value="4">Licenciamiento de la marca</option>
                                    <option value="5">Cesión de derechos de marca</option>
                                    <option value="6">Declaración de uso de marca</option>
                                </select>
                                <label for="">Tramite</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                {{-- <input type="number" class="form-control" id="cliente" placeholder="no. dictamen"
                                    name="id_empresa" aria-label="Nombre">
                                <label for="">cliente</label> --}}
                                <select id="cliente" name="id_empresa" class="form-select select2">
                                    <option value="" disabled selected>Selecciona la empresa</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }} | {{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Empresa</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="contrasena" placeholder="no. dictamen"
                                    name="contrasena" aria-label="Nombre">
                                <label for="">contraseña</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="pago" placeholder="no. dictamen"
                                    name="pago" aria-label="Nombre">
                                <label for="">Pago</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select" id="estatus" name="estatus"
                                    aria-label="Default select example">
                                    <option value="" disabled selected>Selecciona una opcion</option>
                                    <option value="1">Pendiente</option>
                                    <option value="2">Tramite</option>
                                    <option value="3">Tramite favorable</option>
                                    <option value="4">Tramite no favorable</option>
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



<!-- EDITAR TRAMITE MODAL -->
<div class="modal fade" id="editDictamen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0">
            <div class="text-center mb-6">
                <h4 class="address-title mb-2">EDITAR</h4>
            </div>

            <form id="EditarDictamen">
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
                            <option value="1">Registro de marca</option>
                            <option value="2">Trámite USO DE LA DOM</option>
                            <option value="3">Inscripción de convenio de correponsabilidad</option>
                            <option value="4">Licenciamiento de la marca</option>
                            <option value="5">Cesión de derechos de marca</option>
                            <option value="6">Declaración de uso de marca</option>
                        </select>
                        <label for="">Trámite</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        {{-- <input id="edit_cliente" type="number" class="form-control" placeholder="Nombre del cliente" aria-label="" name="id_empresa" />
                        <label for="">Nombre del cliente</label> --}}
                        <select id="edit_cliente" name="id_empresa" class="form-select select2">
                            {{-- <option value="" disabled selected>Selecciona la empresa</option> --}}
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->id_empresa }}">
                                    {{ $empresa->empresaNumClientes[0]->numero_cliente ?? 
                                    $empresa->empresaNumClientes[1]->numero_cliente }} | 
                                    {{ $empresa->razon_social }}
                                </option>
                            @endforeach
                        </select>
                        <label for="id_empresa">Empresa</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-4">
                        <input id="edit_contrasena" type="text" class="form-control" placeholder="Contraseña de impi" aria-label="" name="contrasena" />
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
                        <textarea id="edit_observaciones" name="observaciones" class="form-control h-px-150" 
                                placeholder="Observaciones"></textarea>
                        <label for="">Observaciones</label>
                    </div>
                </div>
                
                <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                    <button type="submit" id="" class="btn btn-primary me-sm-3 me-1 data-submit">Editar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>