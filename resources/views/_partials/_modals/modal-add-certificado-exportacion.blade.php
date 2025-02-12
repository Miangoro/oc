<!-- Add New Certificado Exportación -->
<div class="modal fade" id="addCerExpor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple">
        <div class="modal-content">

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Crear nuevo Certificado de Exportación</h4>
                </div>

                <form id="NuevoCertificadoExport">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="form-select select2" name="id_dictamen" data-placeholder="Seleccione un dictamen">
                                    <option value="" disabled selected>NULL</option>
                                    @foreach ($dictamen as $dic)
                                        <option value="{{ $dic->id_dictamen }}">{{ $dic->num_dictamen }} | </option>
                                    @endforeach
                                </select>
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" name="num_certificado" placeholder="no. certificado">
                                <label for="">No. de certificado</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="select2 form-select" name="id_firmante">
                                    <option value="" disabled selected>Seleccione un firmante</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <label for="">Seleccione un firmante</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                            <input type="text" class="form-control datepicker" name="fecha_emision"
                                id="fecha_emision">
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="date" class="form-control datepicker" name="fecha_vigencia"
                                id="fecha_vigencia" readonly />
                                <label for="">Vigencia hasta</label>
                            </div>
                        </div>
                    </div>


            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                <button type="submit" class="btn btn-primary">Registrar</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Editar Certificado Exportación  -->
<div class="modal fade" id="editCerExpor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar Certificado de Exportación</h4>
                </div>

                <form id="EditarCertificadoExport">
                    <div class="row">
                        <input type="hidden" name="id_certificado" id="id_certificado" value="">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="form-select select2" name="id_dictamen" 
                                    id="edit_id_dictamen">
                                    @foreach ($dictamen as $dic)
                                        <option value="{{ $dic->id_dictamen }}">{{ $dic->num_dictamen }} | </option>
                                    @endforeach
                                </select>
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" name="num_certificado" 
                                    id="edit_num_certificado"  placeholder="no. certificado">
                                <label for="">No. de certificado</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="select2 form-select" name="id_firmante"
                                    id="edit_id_firmante">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <label for="">Seleccione un firmante</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="date" class="form-control datepicker" name="fecha_emision"
                                    id="edit_fecha_emision">
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="date" class="form-control datepicker" name="fecha_vigencia"
                                    id="edit_fecha_vigencia" readonly />
                                <label for="">Vigencia hasta</label>
                            </div>
                        </div>
                    </div>


            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                <button type="submit" class="btn btn-primary">Editar</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
                </form>
            </div>
        </div>
    </div>
</div>