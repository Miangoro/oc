<!-- Add New Address Modal -->
<div class="modal fade" id="aceptarCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Aceptar cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-8">
                <p class="address-subtitle">Convertir a cliente confirmado del Organismo Certificador</p>
                <form id="addNewCliente" class="row g-5" onsubmit="return false">
                    <input name="id_empresa" type="hidden" id="empresaID">
                    <input type="hidden" id="regimenTipo" name="regimenTipo">
                    
                    <div class="contenido">

                    </div>

                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-floating form-floating-outline">
                                <select id="id_contacto" name="id_contacto" class="select2 form-select"
                                    data-allow-clear="true">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                    @endforeach
                                </select>
                                <label for="id_contacto">Persona de contacto CIDAM</label>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="form-floating form-floating-outline select2-primary">
                                <select class="form-select select2" id="actividad" name="actividad[]"
                                    data-placeholder="Seleccione una o más actividades" aria-label="actividad" multiple>
                                    <option value="">Seleccione una actividad</option>
                                    @foreach ($actividadesClientes as $actividad)
                                        <option value="{{ $actividad->id_actividad }}">{{ $actividad->actividad }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="normas">Actividad</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <h5 class="mb-5 info-contrat">Información para el contrato</h5>

                    <div class="persona_fisica d-none">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="date" id="modalAddressAddress1" name="fecha_cedula"
                                        class="form-control" placeholder="12, Business Park" />
                                    <label for="modalAddressAddress1">Fecha de Cédula de Identificación Fiscal</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="text" id="modalAddressAddress2" name="idcif" class="form-control"
                                        placeholder="Mall Road" />
                                    <label for="modalAddressAddress2">idCIF del Servicio deAdministración
                                        Tributaria</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="text" id="modalAddressLandmark" name="clave_ine"
                                        class="form-control" placeholder="Nr. Hard Rock Cafe" />
                                    <label for="modalAddressLandmark">Clave de elector del INE</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="persona_moral d-none">

                        <!-- Sociedad mercantil -->
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="modalAddressCountry" name="sociedad_mercantil" class="select2 form-select"
                                    data-allow-clear="true">
                                    <option value="">Selecciona la opción</option>
                                    <option value="Sociedad de responsabilidad limitada">Sociedad de responsabilidad
                                        limitada</option>
                                    <option value="Sociedad por acciones simplificada">Sociedad por acciones
                                        simplificada</option>
                                    <option value="Sociedad anónima promotora de inversión (SAPI)">Sociedad anónima
                                        promotora de inversión (SAPI)</option>
                                    <option
                                        value="Sociedad anónima promotora de inversión de capital variable (SAPI de CV)">
                                        Sociedad anónima promotora de inversión de capital variable (SAPI de CV)
                                    </option>
                                    <option value="Sociedad anónima de capital variable (empresa SA de CV)">
                                        Sociedad anónima de capital variable (empresa SA de CV)
                                    </option>
                                </select>
                                <label for="modalAddressCountry">Sociedad mercantil</label>
                            </div>
                        </div>

                        <!-- Instrumento público -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="modalAddressCity" name="num_instrumento"
                                        class="form-control" placeholder="Número de instrumento" />
                                    <label for="modalAddressCity">Número de instrumento público</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="modalAddressState" name="vol_instrumento"
                                        class="form-control" placeholder="Volumen" />
                                    <label for="modalAddressState">Volumen de instrumento público</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="date" id="fechaInstrumento" name="fecha_instrumento"
                                        class="form-control" placeholder="Fecha" />
                                    <label for="fechaInstrumento">Fecha instrumento público</label>
                                </div>
                            </div>
                        </div>

                        <!-- Datos del notario público -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="nombreNotario" name="nombre_notario"
                                        class="form-control" placeholder="Nombre del notario" />
                                    <label for="nombreNotario">Nombre del notario público</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="numeroNotario" name="num_notario" class="form-control"
                                        placeholder="Número del notario" />
                                    <label for="numeroNotario">Número de notario público</label>
                                </div>
                            </div>
                        </div>

                        <!-- Estado del notario y número de permiso -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="estadoNotario" name="estado_notario"
                                        class="form-control" placeholder="Estado del notario" />
                                    <label for="estadoNotario">Estado del notario público</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="numeroPermiso" name="num_permiso" class="form-control"
                                        placeholder="Número de permiso" />
                                    <label for="numeroPermiso">Número de permiso</label>
                                    <div id="floatingInputHelp" class="form-text">
                                        (Clave única del documento) emitido por la Secretaría de Economía.
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button disabled class="btn btn-primary me-1 d-none" type="button" id="btnSpinner">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Registrando...
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnAdd"><i
                                class="ri-add-line me-1"></i>
                            Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add New Address Modal -->
