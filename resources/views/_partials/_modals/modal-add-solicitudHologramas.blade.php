<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addHologramas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nueva Solicitud de Hologramas</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addHologramasForm">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="folio"
                            placeholder="Introduce el nombre del lote" name="folio"
                            aria-label="Ingrese el folio" />
                        <label for="name">Ingresa el folio de solicitud</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-4">
                        <select onchange=" obtenerMarcas(); obtenerDirecciones();" id="id_empresa" name="id_empresa"
                            class="select2 form-select">
                            <option value="">Selecciona cliente</option>
                            @foreach ($Empresa as $cliente)
                                <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                            @endforeach
                        </select>
                        <label for="id_empresa">Cliente</label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-6">
                            <select class="select2 form-select id_marca" id="id_marca" name="id_marca"
                                aria-label="Marca">
                                <option value="" selected>Selecciona una marca</option>

                            </select>
                            <label for="id_marca">Marca</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <input class="form-control" type="number" placeholder="Ingrese un valor"
                                id="cantidad_hologramas" name="cantidad_hologramas" />
                            <label for="cantidad_hologramas">No. de hologramas solicitados</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-6">
                            <select class="select2 form-select " id="id_direccion" name="id_direccion"
                                aria-label="Direccion">
                                <option value="id_direccion" selected>Selecciona una direccion</option>

                            </select>
                            <label for="">Direccion</label>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <textarea name="observaciones" class="form-control h-px-100" id="comentarios" placeholder="Observaciones..."></textarea>
                        <label for="comentarios">Comentarios</label>
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
    function obtenerMarcas() {
        var empresa = $("#id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.marcas.length; index++) {
                    contenido = '<option value="' + response.marcas[index].id_marca + '">' + response
                        .marcas[index].marca + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.marcas.length == 0) {
                    contenido = '<option value="">Sin marcas registradas</option>';
                }
                $('#id_marca').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }
</script>
