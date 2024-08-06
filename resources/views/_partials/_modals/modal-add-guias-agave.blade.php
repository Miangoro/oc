<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addGuias" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nueva Guia de translado Agave/Maguey</h4>
                    <p class="address-subtitle"></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Numero de guias solicitadas"
                                    id="presentacion" name="presentacion" />
                                <label for="presentacion">Numero de guias solicitadas</label>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <select id="cliente" name="cliente" class="select2 form-select" required>
                                <option value="">Selecciona cliente</option>
                                @foreach ($empresa as $cliente)
                                    <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                                @endforeach
                            </select>
                            <label for="cliente">Cliente</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <select class="select2 form-select " id="id_marca" name="id_marca"aria-label="Marca">
                                <option value="" selected>Lista de predios</option>
                            </select>
                            <label for="id_marca">Lista de predios</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <select class="select2 form-select " id="id_marca" name="id_marca"aria-label="Marca">
                                <option value="" selected>Plantación del predio</option>
                            </select>
                            <label for="id_marca">Plantación del predio</label>
                        </div>
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


<script>
   
</script>
