<form id="addNewInstalacionForm">
    <!-- Modal para agregar nueva instalación -->
    <div class="modal fade" id="modalAddInstalacion" tabindex="-1" aria-labelledby="modalAddInstalacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalAddInstalacionLabel" class="modal-title">Nueva Instalación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addNewInstalacionForm">
                        @csrf

                        <div class="form-floating form-floating-outline mb-4">
                            <select id="id_empresa" name="id_empresa" class="form-select select2" required>
                                <option value="" disabled selected>Selecciona la empresa</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}</option>
                                @endforeach
                            </select>
                            <label for="id_empresa">Empresa</label>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Select de Tipo de Instalación -->
                                <div class="form-floating form-floating-outline mb-3">
                                    <select class="select2 form-select" id="tipo" name="tipo[]" aria-label="Tipo de Instalación" multiple>
                                        <option value="Productora">Productora</option>
                                        <option value="Envasadora">Envasadora</option>
                                        <option value="Comercializadora">Comercializadora</option>
                                        <option value="Almacen y bodega">Almacén y bodega</option>
                                        <option value="Area de maduracion">Área de maduración</option>
                                    </select>
                                    <label for="tipo">Tipo de Instalación</label>
                                </div>
                            </div>
                                <!-- Input de Estado -->
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-3">
                                    <select class="form-select select2" id="estado" name="estado" required>
                                        <option value="" disabled selected>Seleccione un estado</option>
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="estado">Estado</label>
                                </div>
                            </div>
                        </div>

                        <!-- Input de Dirección Completa -->
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="direccion" placeholder="Ingrese la dirección completa" name="direccion_completa" aria-label="Dirección Completa" required>
                            <label for="direccion">Dirección Completa</label>
                        </div>

                        <!-- Input de Responsable de Instalación -->
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="responsable" placeholder="Ingrese el nombre del responsable de la instalación" name="responsable" aria-label="Responsable de Instalación" required>
                            <label for="responsable_instalacion">Responsable de Instalación</label>
                        </div>

                        <!-- Select de Tipo de Certificación -->
                        <div class="form-floating form-floating-outline mb-3 mt-4">
                            <select class="form-select" id="certificacion" name="certificacion" aria-label="Tipo de Certificación" required>
                                <option value="" disabled selected>Seleccione el tipo de certificación</option>
                                <option value="oc_cidam">Certificación por OC CIDAM</option>
                                <option value="otro_organismo">Certificado por otro organismo</option>
                            </select>
                            <label for="certificacion">Tipo de Certificación</label>
                        </div>

                        <!-- Campos adicionales para "Certificado por otro organismo" -->
                               <div id="certificado-otros" class="d-none mt-4">
                                <div class="col-md-12 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control form-control-sm" type="file" id="file" name="url[]">
                                        <input value="0" class="form-control" type="hidden" name="id_documento[]">
                                        <input value="Certificado de instalaciones" class="form-control" type="hidden" name="nombre_documento[]">
                                        <label for="certificado_instalaciones">Adjuntar Certificado de instalaciones</label>
                                    </div>
                                </div>

                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="folio" placeholder="Folio/Número del certificado" name="folio" aria-label="Folio/Número del certificado">
                                <label for="folio_certificado">Folio/Número del certificado</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select" id="id_organismo" name="id_organismo" data-placeholder="Seleccione un organismo de certificación" aria-label="Organismo de Certificación">
                                    <option value="" disabled selected>Seleccione un organismo de certificación</option>
                                    @foreach($organismos as $organismo)
                                        <option value="{{ $organismo->id_organismo }}">{{ $organismo->organismo }}</option>
                                    @endforeach
                                </select>
                                <label for="id_organismo">Organismo de Certificación</label>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" class="form-control datepicker" id="fecha_emision" name="fecha_emision" aria-label="Fecha de Emisión" readonly>
                                        <label for="fecha_emision">Fecha de Emisión</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" class="form-control datepicker" id="fecha_vigencia" name="fecha_vigencia" aria-label="Fecha de Vigencia" readonly>
                                        <label for="fecha_vigencia">Fecha de Vigencia</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button id="btnRegistrarInstalacion" type="submit" class="btn btn-primary me-2">Registrar</button>
                            <button type="reset" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>