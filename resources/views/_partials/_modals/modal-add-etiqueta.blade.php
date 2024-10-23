<style>
    .modal-custom-size {
        max-width: 75%;
        /* Ajusta este valor para hacerlo más grande */
        width: 75%;
        /* Ajusta según tus necesidades */
    }
</style>
<!-- Add New Lote Envasado Modal -->
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
                        <input type="text" id="etiqueta_marca" name="id_marca">

                        <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><button type="button" class="btn btn-primary add-row-add"> <i
                                                class="ri-add-line"></i>
                                        </button></th>
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
                                        <input type="text" class="form-control form-control-sm" name="sku[]"
                                            id="sku">
                                    </td>
                                    <td>
                                        <select class=" form-control select2" name="id_tipo[]" id="id_tipo">
                                            @foreach ($tipos as $nombre)
                                                <option value="{{ $nombre->id_tipo }}">{{ $nombre->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="presentacion[]"
                                            id="presentacion" step="0.01" min="0">
                                    </td>
                                    <td>
                                    <select class="form-control select2" name="clase[]" id="clase">
                                        @foreach ($clases as $clase)
                                        <option value="{{ $clase->clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                                    </select>
                                    </td>
                                    <td>
                                    <select class="form-control select2" name="categoria[]" id="categoria">
                                        @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->categoria }}">{{ $categoria->categoria }}</option>
                                    @endforeach
                                    </select>
                                    </td>
                                    <td>
                                        <input class="form-control form-control-sm" type="file" name="url[]">
                                        <input value="60" class="form-control" type="hidden" name="id_documento[]">
                                        <input value="Etiquetas" class="form-control" type="hidden"
                                            name="nombre_documento[]">
                                        <label for="Etiquetas">Adjuntar Etiqueta</label>
                                    </td>
                                    <td>
                                        <input class="form-control form-control-sm" type="file" name="url[]">
                                        <input value="75" class="form-control" type="hidden" name="id_documento[]">
                                        <input value="Corrugado" class="form-control" type="hidden"
                                            name="nombre_documento[]">
                                        <label for="Corrugado">Adjuntar Corrugado</label>
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
    // Inicializa select2 cuando el modal se muestra
    $('#etiquetas').on('shown.bs.modal', function() {
        $('.select2').select2({
            dropdownParent: $('#etiquetas') // Esto asegura que el dropdown esté dentro del modal
        });
    });

    // Añadir filas dinámicamente también necesita reinicializar select2
    $(document).on('click', '.add-row-add', function() {
        // Aquí añades la lógica para insertar una nueva fila en la tabla
        // Una vez añadida la nueva fila, reinicializa los select2 dentro de la tabla
        $('.select2').select2({
            dropdownParent: $('#etiquetas')
        });
    });
});

</script>