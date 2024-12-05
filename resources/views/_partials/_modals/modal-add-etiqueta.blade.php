<style>
    .modal-custom-size {
        max-width: 100%;
        width: auto%;
    }
</style>
<div class="modal fade" id="etiquetas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2"> Subir/Ver etiquetas</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="etiquetasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">
                        <input type="hidden" id="etiqueta_marca" name="id_marca">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><button type="button" class="btn btn-primary add-row-add"> <i
                                                    class="ri-add-line"></i>
                                            </button></th>
                                        <th>Destino de exportación</th>
                                        <th>SKU</th>
                                        <th>Tipo Maguey</th>
                                        <th>Presentación</th>
                                        <th>Clase</th>
                                        <th>Categoria</th>
                                        <th>Etiqueta</th>
                                        <th>Corrugado</th>

                                    </tr>
                                </thead>
                                <tbody id="contenidoRango">
                                    <tr>
                                        <th>
                                            <button type="button" class="btn btn-danger remove-row" disabled> <i
                                                    class="ri-delete-bin-5-fill"></i> </button>
                                        </th>
                                        <td>
                                            <select class=" form-control select2" name="id_direccion[]"
                                                id="id_direccion">
                                                @foreach ($direcciones as $direccion)
                                                    <option value="{{ $direccion->id_direccion }}">
                                                        {{ $direccion->direccion }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                         
                                            <input type="text" class="form-control form-control-sm" name="sku[]"
                                                id="sku">
                                        </td>
                                        <td>
                                            <select class=" form-control select2" name="id_tipo[]" id="id_tipo">
                                                @foreach ($tipos as $nombre)
                                                    <option value="{{ $nombre->id_tipo }}">{{ $nombre->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm"
                                                name="presentacion[]" id="presentacion" step="0.01" min="0">
                                        </td>
                                        <td>
                                            <select class="form-control select2" name="id_clase[]" id="id_clase">
                                                @foreach ($clases as $clase)
                                                    <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select2" name="id_categoria[]"
                                                id="id_categoria">
                                                @foreach ($categorias as $categoria)
                                                    <option value="{{ $categoria->id_categoria }}">
                                                        {{ $categoria->categoria }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="file" name="url[]">
                                            <input value="60" class="form-control" type="hidden"
                                                name="id_documento[]">
                                            <input value="Etiquetas" class="form-control" type="hidden"
                                                name="nombre_documento[]">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="file" name="url[]">
                                            <input value="75" class="form-control" type="hidden"
                                                name="id_documento[]">
                                            <input value="Corrugado" class="form-control" type="hidden"
                                                name="nombre_documento[]">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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


<script>
    $(document).ready(function() {
        $('#etiquetas').on('shown.bs.modal', function() {
            $('#contenidoRango .select2').select2({
                dropdownParent: $('#etiquetas')
            });
        });
        //Agregar o eliminar filas en la tabla
        var i = 0;
        $('.add-row-add').click(function() {
            let opciones = `
            @foreach ($tipos as $nombre)
                <option value="{{ $nombre->id_tipo }}">{{ $nombre->nombre }}</option>
            @endforeach
        `;
            let opciones2 = `
            @foreach ($clases as $clase)
                <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
            @endforeach
        `;
            let opciones3 = `
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}">{{ $categoria->categoria }}</option>
            @endforeach
        `;
            let opciones4 = `
            @foreach ($direcciones as $direccion)
                <option value="{{ $direccion->id_direccion }}">
                    {{ $direccion->direccion }}
                </option>
            @endforeach
        `;
            var newRow = `
            <tr>
                <th>
                    <button type="button" class="btn btn-danger remove-row"> <i class="ri-delete-bin-5-fill"></i> </button>
                </th>
                                                <td><select class="form-control select2" name="id_direccion[]">` +
                opciones4 + `</select></td>
                <td><input type="text" class="form-control form-control-sm" name="sku[]" id="sku"></td>
                <td><select class="form-control select2" name="id_tipo[]">` + opciones + `</select></td>
                <td><input type="number" class="form-control form-control-sm" name="presentacion[]" step="0.01" min="0"></td>
                <td><select class="form-control select2" name="id_clase[]">` + opciones2 + `</select></td>
                <td><select class="form-control select2" name="id_categoria[]">` + opciones3 + `</select></td>
                <td><input class="form-control form-control-sm" type="file" name="url[]"><input value="60" class="form-control" type="hidden" name="id_documento[]"><input value="Etiquetas" class="form-control" type="hidden" name="nombre_documento[]"></td>
                <td><input class="form-control form-control-sm" type="file" name="url[]"><input value="75" class="form-control" type="hidden" name="id_documento[]"><input value="Corrugado" class="form-control" type="hidden" name="nombre_documento[]"></td>
            </tr>`;

            $('#contenidoRango').append(newRow);
            // Reinicializa select2 en todos los selects agregados
            $('#contenidoRango .select2').select2({
                dropdownParent: $('#etiquetas')
            });
            i++;
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
