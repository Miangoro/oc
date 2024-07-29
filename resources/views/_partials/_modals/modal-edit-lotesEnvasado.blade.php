<!-- Edit Lote Envasado Modal -->
<div class="modal fade" id="editLoteEnvasado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-edit-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar lote envasado</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="editLoteEnvasadoForm">
                    
                    <input type="hidden" id="edit_id_lote_envasado" name="id">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select id="edit_cliente" name="cliente" class="select2 form-select" required>
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_cliente">Cliente</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="edit_tipo_lote" name="tipo_lote" class="form-select" required onchange="toggleFields()">
                                    <option value="1">Por un solo lote a granel</option>
                                    <option value="2">Por más de un lote a granel</option>
                                </select>
                                <label for="tipo_lote">Conformado por</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select2 form-select" id="edit_lotesGra" name="lotesGra" aria-label="Default select example">
                                    <option value="" selected>Lote Granel</option>
                                    @foreach ($lotes_granel as $lotesGra)
                                        <option value="{{ $lotesGra->id_lote_granel }}">{{ $lotesGra->nombre_lote }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_lotesGra">No de lote granel:</label>
                            </div>
                        </div>
                    </div>

                    <div id="edit_datosOpcion1" class="opcion-datos" style="display: block;">
                        <!-- Datos a mostrar para la opción 1 -->
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="edit_nombre_lote" placeholder="Introduce el nombre del lote" name="nombre_lote" aria-label="Nombre del lote" required />
                            <label for="name">Nombre del lote</label>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" id="edit_sku" class="form-control" placeholder="No. de pedido/SKU" aria-label="No. de pedido/SKU" name="sku" />
                                    <label for="sku">No. de pedido/SKU</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class="select2 form-select" id="edit_marca" name="id_marca" aria-label="Marca">
                                        <option value="" selected>Selecciona una marca</option>
                                        @foreach ($marcas as $marca)
                                            <option value="{{ $marca->id_marca }}">{{ $marca->marca }}</option>
                                        @endforeach
                                    </select>
                                    <label for="edit_marca">Marca</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="text" placeholder="Destino lote" id="edit_destino_lote" name="destino_lote" />
                                    <label for="destino_lote">Destino lote</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="number" placeholder="Ingrese un valor" id="edit_cant_botellas" name="cant_botellas" />
                                    <label for="cantidad_botellas">Cantidad de botellas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="text" placeholder="Presentación de la botella" id="edit_presentacion" name="presentacion" />
                                    <label for="presentacion">Presentación de la botella</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class="select2 form-select" id="edit_unidad" name="unidad" aria-label="Unidad">
                                        <option value="Litros">Litros</option>
                                        <option value="Mililitros">Mililitros</option>
                                        <option value="Centrilitros">Centrilitros</option>
                                    </select>
                                    <label for="unidad">Unidad</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="number" step="0.01" placeholder="Volumen total" id="edit_volumen_total" name="volumen_total" />
                                    <label for="volumen_total">Volumen total</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class="select2 form-select" id="edit_Instalaciones" name="Instalaciones" aria-label="Default select example">
                                        <option value="" selected>Lote Granel</option>
                                        @foreach ($Instalaciones as $Instalaciones)
                                            <option value="{{ $Instalaciones->id_instalacion }}">{{ $Instalaciones->direccion_completa }}</option>
                                        @endforeach
                                    </select>
                                    <label for="edit_Instalaciones">Lugar de envasado</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>