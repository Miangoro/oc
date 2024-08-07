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
                <form id="addGuiaForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Numero de guias solicitadas"
                                    id="presentacion" name="presentacion" required />
                                <label for="presentacion">Numero de guias solicitadas</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerNombrePredio();  obtenerPlantacionPredio();" id="id_empresa" name="empresa" class="select2 form-select" required>
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($empresa as $id_cliente)
                                        <option value="{{ $id_cliente->id_empresa }}">{{ $id_cliente->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select2 form-select " id="nombre_predio" name="predios" aria-label="Marca" required>
                                    <option value="" selected>Lista de predios</option>
                                </select>
                                <label for="nombre_predio">Lista de predios</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select2 form-select " id="numero_plantas" name="plantacion" aria-label="Marca" required>
                                    <option value="" selected>Plantación del predio</option>
                                </select>
                                <label for="numero_plantas">Plantación del predio</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" id="Folio" class="form-control"
                            placeholder="Folio" aria-label="Folio" name="Folio" required />
                        <label for="sku">Folio</label>
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

    function obtenerNombrePredio() {
        var empresa = $("#id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);

                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.predios.length; index++) {
                    contenido = '<option value="' + response.predios[index].id_empresa + '">' + response
                        .predios[index].nombre_predio + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.predios.length == 0) {
                    contenido = '<option value="">Sin predios registradas</option>';
                }
                $('#nombre_predio').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }
    function obtenerPlantacionPredio() {
        var empresa = $("#id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);

                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.predios.length; index++) {
                    contenido = '<option value="' + response.predios[index].id_empresa + '">' + response
                        .predios[index].numero_plantas + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.predios.length == 0) {
                    contenido = '<option value="">Sin predios registradas</option>';
                }
                $('#numero_plantas').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }

</script>
