<!-- AGREGAR DICTAMEN INSTALACIONES -->
<div class="modal fade" id="addDictamen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Nuevo dictamen de instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="NuevoDictamen">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_inspeccion" name="id_inspeccion"
                                    data-placeholder="Elige un número de servicio" class="form-select select2"
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
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select" id="tipo_dictamen" name="tipo_dictamen"
                                    aria-label="Default select example">
                                    <option value="" disabled selected>Selecciona una opcion</option>
                                    <option value="1">Productor</option>
                                    <option value="2">Envasador</option>
                                    <option value="3">Comercializador</option>
                                    <option value="4">Almacen y bodega</option>
                                    {{-- <option value="5">Área de maduración</option> --}}
                                </select>
                                <label for="">Tipo de Dictamen</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="num_dictamen" placeholder="no. dictamen"
                                    name="num_dictamen" aria-label="Nombre" required>
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>

                       <!-- <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6 select2-primary">
                                <select id="categorias" name="categorias[]" class="form-select select2"
                                    data-placeholder="Seleccione una o más categorias" multiple>
                                    @foreach ($categoria as $cate)
                                        <option value="{{ $cate->id_categoria }}">{{ $cate->categoria }}</option>
                                    @endforeach
                                </select>
                                <label for="">Categorías de agave</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4 select2-primary">
                                <select name="clases[]" class="form-select select2"
                                    data-placeholder="Seleccione una o más clases" multiple>
                                    @foreach ($clases as $clase)
                                        <option value="{{ $clase->clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                                </select>
                                <label for="">Clases de agave</label>
                            </div>
                        </div>-->

                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control flatpickr-datetime" id="fecha_emision"
                                    placeholder="YYYY-MM-DD" name="fecha_emision" aria-label="Nombre" required readonly>
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="YYYY-MM-DD"
                                    id="fecha_vigencia" name="fecha_vigencia" required readonly />
                                <label for="">Vigencia hasta</label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <!-- Firmante -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="select2 form-select" id="id_firmante" name="id_firmante" aria-label="Nombre Firmante" required>
                                <option value="" disabled selected>Seleccione un firmante</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <label for="formValidationSelect2">Seleccione un firmante</label>
                        </div>
                    </div>

                    {{-- <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div> --}}
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
<div class="modal fade" id="editDictamen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title">Editar dictamen de instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body ">
                <form id="EditarDictamen">
                    <div class="row">
                        <input type="hidden" name="id_dictamen" id="edit_id_dictamen" value="">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_inspeccion" name="id_inspeccion" class="form-select select2"
                                    aria-label="Default select example">
                                    @foreach ($inspeccion as $insp)
                                        {{-- <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }}</option> --}}
                                        <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} | {{ $insp->solicitud->folio }} | {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}</option>
                                    @endforeach
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
                                <input type="text" class="form-control flatpickr-datetime" id="edit_fecha_emision"
                                    placeholder="YYYY-MM-DD" name="fecha_emision" aria-label="Nombre" required readonly>
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="YYYY-MM-DD"
                                    id="edit_fecha_vigencia" name="fecha_vigencia" required readonly />
                                <label for="">Vigencia hasta</label>
                            </div>
                        </div>

                    </div>
                    <!--<div class="row">

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6 select2-primary">
                                <select id="edit_categorias" name="categorias[]" class="form-select select2"
                                    data-placeholder="Seleccione una o más categorias"
                                    data-error-message="Por favor selecciona una categoría de agave" multiple>
                                    @foreach ($categoria as $cate)
                                        <option value="{{ $cate->id_categoria }}">{{ $cate->categoria }}</option>
                                    @endforeach
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
                                    @foreach ($clases as $clase)
                                        <option value="{{ $clase->clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" class="form-control" id="edit_clases" name="clases"> --}}
                                <label for="edit_clases">Clases de agave</label>
                            </div>
                        </div>

                    </div>-->

                    <div class="row">
                        <!-- Firmante -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="select2 form-select" id="edit_id_firmante" name="id_firmante" aria-label="Nombre Firmante" required>
                              
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <label for="formValidationSelect2">Seleccione un firmante</label>
                        </div>
                    </div>

                    {{-- <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Editar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div> --}}
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

