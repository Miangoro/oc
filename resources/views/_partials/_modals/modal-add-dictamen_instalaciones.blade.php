<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addDictamen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Crear nuevo dictamen</h4>
                    <p class="address-subtitle"></p>
                </div>

    <form id="NuevoDictamen">

                @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select" id="tipo_dictamen"
                            name="tipo_dictamen" aria-label="Default select example">
                            <option value="0" disabled selected>Selecciona una opcion</option>
                            <option value="1">Productor</option>
                            <option value="2">Envasador</option>
                            <option value="3">Comercializador</option>
                            <option value="4">Almacen y bodega</option>
                        </select>
                            <label for="">Tipo de Dictamen</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-6">
                    <input type="text" class="form-control" id="num_dictamen" placeholder="no. dictamen" name="num_dictamen" aria-label="Nombre" required>
                    <label for="">No. de dictamen</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-6">
                <input type="date" class="form-control" id="fecha_emision" placeholder="fecha" name="fecha_emision" aria-label="Nombre" required>
                    <label for="">Fecha de emisión</label>
                    </div>
                </div>

                <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-6">
        <input class="form-control" type="date" placeholder="vigencia" id="fecha_vigencia" name="fecha_vigencia" required />
                            <label for="">Vigencia hasta</label>
                        </div>
                </div>
            </div>

            <div class="row">
                <!-- <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select" id="" name="" aria-label="Default select example">
                        </select>
                            <label for="">No. de servicio</label>
                    </div>
                </div> -->

                <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-6">
                    <input type="text" class="form-control" id="categorias" placeholder="categoria" name="categorias" aria-label="Nombre" required>
                    <label for="nombre">Categoria</label>
                    </div>
                </div>

                <!-- <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-6">
                    <input type="text" class="form-control" id="nombre" placeholder="clase" name="nombre" aria-label="Nombre" required>
                    <label for="nombre">Clase</label>
                    </div>
                </div> -->
                <!-- <div class="col-md-3">
                    <div class="form-floating form-floating-outline mb-4">
                        <select  class="form-select" >
                            <option value="clases" disabled selected>Selecciona una clase</option>
                                @foreach ($clases as $clase)
                                    <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                @endforeach
                        </select>
                        <label for="">Clases</label>
                    </div>
                </div>  -->

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

