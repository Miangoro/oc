<!-- Modal para editar instalación -->
<div class="modal fade" id="modalEditInstalacion" tabindex="-1" aria-labelledby="modalEditInstalacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalEditInstalacionLabel" class="modal-title">Editar Instalación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editInstalacionForm">
                    @csrf

                    <div class="form-floating form-floating-outline mb-4">
                        <select id="edit_id_empresa" name="edit_id_empresa" class="form-select select2" required>
                            <option value="" disabled selected>Selecciona la empresa</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}</option>
                            @endforeach
                        </select>
                        <label for="edit_id_empresa">Empresa</label>
                    </div>

                    <div class="row">
                            <div class="col-md-6">
                                <!-- Select de Tipo de Instalación -->
                                <div class="form-floating form-floating-outline mb-3">
                                    <select class="select2 form-select" id="edit_tipo" name="edit_tipo[]" aria-label="Tipo de Instalación" multiple>
                                        <option value="Productora">Productora</option>
                                        <option value="Envasadora">Envasadora</option>
                                        <option value="Comercializadora">Comercializadora</option>
                                        <option value="Almacen y bodega">Almacén y bodega</option>
                                        <option value="Area de maduracion">Área de maduración</option>
                                    </select>
                                    <label for="edit_tipo">Tipo de Instalación</label>
                                </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Input de Estado -->
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select select2" id="edit_estado" name="edit_estado" required>
                                    <option value="" disabled selected>Seleccione un estado</option>
                                    @foreach($estados as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_estado">Estado</label>
                            </div>
                        </div>
                    </div>

                    <!-- Input de Dirección Completa -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="edit_direccion" placeholder="Ingrese la dirección completa" name="edit_direccion" aria-label="Dirección Completa" required>
                        <label for="edit_direccion">Dirección Completa</label>
                    </div>

                    <!-- Input de Responsable de Instalación -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="edit_responsable" placeholder="Ingrese el nombre del responsable de la instalación" name="edit_responsable" aria-label="Responsable de Instalación" required>
                        <label for="edit_responsable">Responsable de Instalación</label>
                    </div>

                    <!-- Select de Tipo de Certificación -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select" id="edit_certificacion" name="edit_certificacion" aria-label="Tipo de Certificación" required>
                            <option value="" disabled selected>Seleccione el tipo de certificación</option>
                            <option value="oc_cidam">Certificación por OC CIDAM</option>
                            <option value="otro_organismo">Certificado por otro organismo</option>
                        </select>
                        <label for="edit_certificacion">Tipo de Certificación</label>
                    </div>

                    <!-- Campos adicionales para "Certificado por otro organismo" -->
                    <div id="edit_certificado_otros" class="d-none">
                        <div class="col-md-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control form-control-sm" type="file" id="edit_file" name="edit_url[]">
                                <input value="0" class="form-control" type="hidden" name="edit_id_documento[]">
                                <input value="Certificado de instalaciones" class="form-control" type="hidden" name="edit_nombre_documento[]">
                                <label for="edit_certificado_instalaciones">Adjuntar Certificado de Instalaciones</label>
                            </div>
                            <div id="archivo_url_display" class="mt-2 text-primary"></div>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="edit_folio" placeholder="Folio/Número del certificado" name="edit_folio" aria-label="Folio/Número del certificado">
                            <label for="edit_folio">Folio/Número del certificado</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-select" id="edit_id_organismo" name="edit_id_organismo" data-placeholder="Seleccione un organismo de certificación" aria-label="Organismo de Certificación">
                                <option value="" disabled selected>Seleccione un organismo de certificación</option>
                                @foreach($organismos as $organismo)
                                    <option value="{{ $organismo->id_organismo }}">{{ $organismo->organismo }}</option>
                                @endforeach
                            </select>
                            <label for="edit_id_organismo">Organismo de Certificación</label>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" class="form-control datepicker" id="edit_fecha_emision" name="edit_fecha_emision" aria-label="Fecha de Emisión" readonly>
                                    <label for="edit_fecha_emision">Fecha de Emisión</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" class="form-control datepicker" id="edit_fecha_vigencia" name="edit_fecha_vigencia" aria-label="Fecha de Vigencia" readonly>
                                    <label for="edit_fecha_vigencia">Fecha de Vigencia</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">Guardar Cambios</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>