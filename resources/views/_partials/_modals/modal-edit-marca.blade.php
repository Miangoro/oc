<!-- Edit Marca Modal -->
<div class="modal fade" id="editMarca" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar marca</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form method="POST" enctype="multipart/form-data" id="editMarcaForm" class="row g-5" onsubmit="return false">
                    <input type="hidden" id="edit_marca_id" name="id">

                    <div class="col-12">
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
                    <div class="col-12 col-md-12 col-sm-12">
                        <div class="form-floating form-floating-outline">
                            <input id="edit_marca_nombre" type="text" name="marca" class="form-control" placeholder="Introduce el nombre de la marca" />
                            <label for="edit_marca_nombre">Nombre de la marca</label>
                        </div>
                    </div>
                    <hr class="my-6">
                    <h5 class="mb-5">Documentación de la marca</h5>

                    @foreach ($documentos as $documento)
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <label for="file{{ $documento->id_documento }}" class="form-label">{{ $documento->nombre }}</label>
                                <input class="form-control" type="file" id="file{{ $documento->id_documento }}" name="url[]">
                                <input value="{{ $documento->id_documento }}" class="form-control" type="hidden" name="id_documento[]">
                                <input value="{{ $documento->nombre }}" class="form-control" type="hidden" name="nombre_documento[]">
                                <div id="existing_file_{{ $documento->id_documento }}"></div>  <!-- Contenedor para el archivo existente -->
                            </div>
                            <div class="col-md-3">
                                <label for="date{{ $documento->id_documento }}" class="form-label">Fecha de vigencia</label>
                                <div class="input-group">
                                    <input type="date" class="form-control datepicker" id="date{{ $documento->id_documento }}" name="fecha_vigencia[]">
                                    <p id="existing_date_{{ $documento->id_documento }}" class="mt-2"></p> <!-- Mostrar la fecha de vigencia existente -->
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit Marca Modal -->