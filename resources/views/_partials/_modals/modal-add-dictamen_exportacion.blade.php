<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addDictExpor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Nuevo Dictamen de Exportación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
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
                                    <option value="" disabled selected>Selecciona un firmante</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <label for="">Selecciona un firmante</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control flatpickr-datetime" id="fecha_emision"
                                placeholder="YYYY-MM-DD" name="fecha_emision" aria-label="Nombre" required>
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="YYYY-MM-DD"
                                    id="fecha_vigencia" name="fecha_vigencia" required readonly />
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2">Registrar</button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Editar Dictamen de Exportación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
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
                                <label for="">Selecciona un firmante</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control flatpickr-datetime" id="edit_fecha_emision"
                                placeholder="YYYY-MM-DD" name="fecha_emision" aria-label="Nombre" required>
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="YYYY-MM-DD"
                                    id="edit_fecha_vigencia" name="fecha_vigencia" required readonly />
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2">Editar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>


                
            </div>
        </div>
    </div>
</div>