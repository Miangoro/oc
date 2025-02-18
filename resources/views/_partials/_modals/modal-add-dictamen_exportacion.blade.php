<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addDictExpor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Crear nuevo dictamen de Exportación</h4>
                </div>

                <form id="NuevoDictamenExport">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_inspeccion" name="id_inspeccion"
                                    data-placeholder="Seleccione el número de servicio" class="form-select select2"
                                    aria-label="Default select example">
                                    <option value="" disabled selected>NULL</option>
                                    @foreach ($inspeccion as $insp)
                                        <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} | {{ $insp->solicitud->folio }} | {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}</option>
                                    @endforeach
                                </select>
                                <label for="">No. de servicio</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="num_dictamen" placeholder="no. dictamen"
                                    name="num_dictamen" aria-label="Nombre" required>
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>
                        <!-- Firmante -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="select2 form-select" id="id_firmante" name="id_firmante" aria-label="Nombre Firmante">
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
                                <input type="date" class="form-control datepicker" id="fecha_emision"
                                    placeholder="fecha" name="fecha_emision" aria-label="Nombre" required>
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control datepicker" type="date" placeholder="vigencia"
                                    id="fecha_vigencia" name="fecha_vigencia" required readonly />
                                <label for="">Vigencia hasta</label>
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
<div class="modal fade" id="editDictExpor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar dictamen Exportación</h4>
                    <span id="folio_dictamen" class="badge bg-primary"></span>
                </div>

                <form id="EditarDictamenExport">
                    <div class="row">
                        <input type="hidden" name="id_dictamen" id="edit_id_dictamen" value="">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_inspeccion" name="id_inspeccion" class="form-select select2"
                                    aria-label="Default select example">
                                    @foreach ($inspeccion as $insp)
                                        <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} | {{ $insp->solicitud->folio }} | {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}</option>
                                    @endforeach
                                </select>
                                <label for="">No. de servicio</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="edit_num_dictamen"
                                    placeholder="no. dictamen" name="num_dictamen" aria-label="Nombre" required>
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>
                        <!-- Firmante -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="select2 form-select" id="edit_id_firmante" name="id_firmante" aria-label="Nombre Firmante" required>
                                
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <label for="formValidationSelect2">Seleccione un firmante</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="date" class="form-control datepicker" id="edit_fecha_emision"
                                    placeholder="fecha" name="fecha_emision" aria-label="Nombre" required>
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