<div class="modal fade" id="addMarca" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nueva marca</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form method="POST" enctype="multipart/form-data" id="addNewMarca" class="row g-5"
                    onsubmit="return false">
                    <div class="col-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <select id="cliente" name="cliente" class="select2 form-select" required>
                                <option value="" disabled selected>Selecciona cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id_empresa }}">
                                        {{ $cliente->empresaNumClientes[0]->numero_cliente ?? $cliente->empresaNumClientes[1]->numero_cliente }}
                                        | {{ $cliente->razon_social }}</option>
                                @endforeach
                            </select>
                            <label for="cliente">Cliente</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <select id="id_norma" name="id_norma" class="select2 form-select" required>
                                <option value=""disabled selected>Selecciona una norma</option>
                                @foreach ($catalogo_norma_certificar as $normas)
                                    <option value="{{ $normas->id_norma }}">{{ $normas->norma }}</option>
                                @endforeach
                            </select>
                            <label for="id_norma">Normas</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-sm-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <input id="marca" type="text" name="marca" class="form-control"
                                placeholder="Introduce el nombre de la marca" />
                            <label for="marca">Nombre de la marca</label>
                        </div>
                    </div>
                    <hr class="my-6">
                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Documentación de la marca</h4>
                        <p class="address-subtitle" style="color: red">Seleccione una fecha al subir un documento</p>
                    </div>
                    @foreach ($documentos as $documento)
                        <div class="row mb-3">
                            <div class="col-md-9 mb-5">
                                <label for="file{{ $documento->id_documento }}"
                                    class="form-label">{{ $documento->nombre }}</label>
                                <input class="form-control" type="file" id="file{{ $documento->id_documento }}"
                                    data-id="{{ $documento->id_documento }}" name="url[]">
                                <input value="{{ $documento->id_documento }}" class="form-control" type="hidden"
                                    name="id_documento[]">
                                <input value="{{ $documento->nombre }}" class="form-control" type="hidden"
                                    name="nombre_documento[]">
                            </div>
                            <div class="col-md-3 mb-5">
                                <label for="date{{ $documento->id_documento }}" class="form-label">Fecha de
                                    vigencia</label>
                                <div class="input-group">
                                    <input placeholder="YYYY-MM-DD" readonly type="text"
                                        class="form-control datepicker" id="date{{ $documento->id_documento }}"
                                        name="fecha_vigencia[]">
                                </div>
                            </div>
                        </div>
                    @endforeach
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
