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
                        <div class="col-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="obtenerGraneles(); obtenerMarcas(); obtenerDirecciones();"
                                    id="edit_cliente" name="id_empresa" class="select2 form-select" required>
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_cliente">Cliente</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="edit_tipo_lote" name="tipo_lote" class="form-select" required onchange="mostrarLotes()">
                                    <option value="1">Por un solo lote a granel</option>
                                    <option value="2">Por más de un lote a granel</option>
                                </select>
                                <label for="tipo_lote">Conformado por</label>
                            </div>
                        </div>
                    </div>
                    <div id="edit_datosOpcion1" div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6">
                            <select class="select2 form-select id_lote_granel" id="edit_lote_granel"
                                name="id_lote_granel" aria-label="Default select example">
                                <option value="" selected>Lote Granel</option>
                                @foreach ($lotes_granel as $lotesGra)
                                    <option value="{{ $lotesGra->id_empresa }}">{{ $lotesGra->nombre_lote }}</option>
                                @endforeach
                            </select>
                            <label for="edit_lote_granel">No de lote granel:</label>
                        </div>
                    </div>


                    <div class="opcion-datos" style="display: block;">
                        <!-- Datos a mostrar para la opción 1 -->
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="edit_nombre_lote"
                                placeholder="Introduce el nombre del lote" name="nombre_lote"
                                aria-label="Nombre del lote" required />
                            <label for="name">Nombre del lote</label>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" id="edit_sku" class="form-control"
                                        placeholder="No. de pedido/SKU" aria-label="No. de pedido/SKU" name="sku" />
                                    <label for="sku">No. de pedido/SKU</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class="select2 form-select id_marca" id="edit_marca" name="id_marca"
                                        aria-label="Marca">
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
                                    <input class="form-control" type="text" placeholder="Destino lote"
                                        id="edit_destino_lote" name="destino_lote" />
                                    <label for="destino_lote">Destino lote</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="number" placeholder="Ingrese un valor"
                                        id="edit_cant_botellas" name="cant_botellas" />
                                    <label for="cantidad_botellas">Cantidad de botellas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="text" placeholder="Presentación de la botella"
                                        id="edit_presentacion" name="presentacion" />
                                    <label for="presentacion">Presentación de la botella</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class="select2 form-select" id="edit_unidad" name="unidad"
                                        aria-label="Unidad">
                                        <option value="Litros">Litros</option>
                                        <option value="Mililitros">Mililitros</option>
                                        <option value="Centrilitros">Centrilitros</option>
                                    </select>
                                    <label for="unidad">Unidad</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="number" step="0.01"
                                        placeholder="Volumen total" id="edit_volumen_total" name="volumen_total" />
                                    <label for="volumen_total">Volumen total</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class="select2 form-select id_instalacion" id="edit_Instalaciones"
                                        name="lugar_envasado" aria-label="Default select example">
                                        <option value="" selected>Lote Granel</option>
                                        @foreach ($Instalaciones as $Instalacion)
                                            <option value="{{ $Instalacion->id_instalacion }}">
                                                {{ $Instalacion->direccion_completa }}</option>
                                        @endforeach
                                    </select>
                                    <label for="edit_Instalaciones">Lugar de envasado</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="edit_datosOpcion2">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><button type="button" class="btn btn-primary add-row"> <i class="ri-add-line"></i> </button></th>
                                    <th>Lote a granel</th>
                                    <th>Volumen parcial</th>
                                </tr>
                            </thead>
                            <tbody id="contenidoGraneles">
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-danger remove-row" disabled> <i class="ri-delete-bin-5-fill"></i> </button>
                                    </th>
                                    <td>
                                        <select class="id_lote_granel form-control select2" name="id_lote_granel[]" >
                                            <!-- Opciones -->
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="volumen_parcial[]">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>


                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function obtenerGraneles() {
        var empresa = $("#id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.lotes_granel.length; index++) {
                    contenido = '<option value="' + response.lotes_granel[index].id_lote_granel + '">' +
                        response.lotes_granel[index].nombre_lote + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.lotes_granel.length == 0) {
                    contenido = '<option value="">Sin lotes a granel registrados</option>';
                }
                $('.id_lote_granel').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }

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


    function obtenerDirecciones() {
        var empresa = $("#id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.instalaciones.length; index++) {
                    contenido = '<option value="' + response.instalaciones[index].id_instalacion + '">' +
                        response.instalaciones[index].direccion_completa + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.instalaciones.length == 0) {
                    contenido = '<option value="">Sin lotes a granel registrados</option>';
                }
                $('.id_instalacion').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }


    document.addEventListener('DOMContentLoaded', function () {
        function calcularVolumenTotal() {
            var cantidadBotellas = parseFloat(document.getElementById('edit_cant_botellas').value) || 0;
            var edit_presentacion = parseFloat(document.getElementById('edit_presentacion').value) || 0;
            var edit_unidad = document.getElementById('edit_unidad').value;

            var volumenTotal;

            if (edit_unidad === "Litros") {
                volumenTotal = cantidadBotellas * edit_presentacion;
            } else if (edit_unidad === "Mililitros") {
                volumenTotal = (cantidadBotellas * edit_presentacion) / 1000;
            } else if (edit_unidad === "Centrilitros") {
                volumenTotal = (cantidadBotellas * edit_presentacion) / 100;
            } else {
                volumenTotal = ''; // Limpiar el campo si la unidad no es Litros ni Mililitros
            }

            document.getElementById('edit_volumen_total').value = volumenTotal ? volumenTotal.toFixed(2) : '';
        }

        // Añadir eventos de cambio a los campos relevantes
        document.getElementById('edit_cant_botellas').addEventListener('input', calcularVolumenTotal);
        document.getElementById('edit_presentacion').addEventListener('input', calcularVolumenTotal);
        document.getElementById('edit_unidad').addEventListener('change', calcularVolumenTotal);
    });

    
</script>
