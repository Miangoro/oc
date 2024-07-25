<!-- Add New Address Modal -->
<div class="modal fade" id="addlostesEnvasado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nuevo lote envasado</h4>
                    <p class="address-subtitle"></p>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <select id="cliente" name="cliente" class="select2 form-select" required>
                                <option value="">Selecciona cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                                @endforeach
                            </select>
                            <label for="cliente">Cliente</label>
                        </div>
                    </div>
            
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-6">
                            <select class=" form-select" id="conformadoPor" aria-label="Default select example">
                                <option value="1">Por un solo lote a granel</option>
                                <option value="2">Por más de un lote a granel</option>
                            </select>
                            <label for="conformadoPor">Conformado por</label>
                        </div>
                    </div>
            
                    <div class="col-md-3">
                        <div class="form-floating form-floating-outline mb-6">
                            <select class="select2 form-select" id="lotesGra" name="lotesGra" aria-label="Default select example">
                                <option value="" selected>Lote Granel</option>
                                @foreach ($lotes_granel as $lotesGra)
                                    <option value="{{ $lotesGra->id_lote_granel }}">{{ $lotesGra->folio_fq }}</option>
                                @endforeach
                            </select>
                            <label for="lotesGra">No de lote granel:</label>
                        </div>
                    </div>
                </div>
            
                <div id="datosOpcion1" class="opcion-datos">
                    <!-- Datos a mostrar para la opción 1 -->
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="add-user-fullname" placeholder="Introduce el nombre del lote" name="name" aria-label="Ana Gómez" />
                        <label for="add-user-fullname">Nombre del lote</label>
                    </div>
            
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" id="add-user-email" class="form-control" placeholder="No. de pedido/SKU" aria-label="ana.gmz@example.com" name="email" />
                                <label for="add-user-email">No. de pedido/SKU</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select2 form-select" id="marca" name="marca" aria-label="Default select example">
                                    <option value="" selected>Selecciona una marca</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id_marca }}">{{ $marca->marca }}</option>
                                    @endforeach
                                </select>
                                <label for="marca">Marca</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Destino lote" id="html5-text-input" />
                                <label for="html5-text-input">Destino lote</label>
                            </div>
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" placeholder="Ingrese un valor" id="html5-number-input" />
                                <label for="html5-number-input">Cantidad de botellas</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Presentacion de la botella" id="html5-text-input" />
                                <label for="html5-text-input">Presentacion de la botella</label>
                            </div>
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select2 form-select" id="unidad" aria-label="Default select example">
                                    <option value="1">Litros</option>
                                    <option value="2">Mililitros</option>
                                    <option value="3">Centrilitros</option>
                                </select>
                                <label for="unidad">Unidad</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Volumen en litros" id="html5-text-input" />
                                <label for="html5-text-input">Volumen en litros</label>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div id="datosOpcion2" class="opcion-datos">
                    <!-- Datos a mostrar para la opción 2 -->
                    <!-- Agrega aquí los datos específicos que deseas mostrar para la opción 2 -->
                </div>
            </div>
            
            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                <button type="submit" class="btn btn-primary">Registrar</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
</div>

<script></script>


<!--/ Add New Address Modal -->
<!--  <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Cancelar</button>
                </div>-->
