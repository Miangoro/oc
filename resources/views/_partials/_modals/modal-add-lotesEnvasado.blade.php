<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addlostesEnvasado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nuevo lote envasado</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addNewLoteForm">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="obtenerGraneles(); obtenerMarcas(); obtenerDirecciones();"
                                    id="id_empresa" name="id_empresa" class="select2 form-select">
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>

                       {{--  <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="tipo_lote" name="tipo_lote" class="form-select" required
                                    onchange="toggleFields()">
                                    <option value="Por un solo lote a granel">Por un solo lote a granel</option>
                                    <option value="Por más de un lote a granel">Por más de un lote a granel</option>
                                </select>
                                <label for="tipo_lote">Conformado por</label>
                            </div>
                        </div> --}}
                    </div>

{{--                     <div id="datosOpcion1" class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6">
                            <select class="select2 form-select id_lote_granel" name="id_lote_granel[]"
                                aria-label="Default select example">


                            </select>
                            <label for="id_lote_granel">No de lote granel:</label>
                        </div>
                    </div> --}}

                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="nombre_lote"
                                placeholder="Introduce el nombre del lote" name="nombre_lote"
                                aria-label="Nombre del lote" />
                            <label for="nombre_lote">Nombre del lote</label>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" id="sku" class="form-control"
                                        placeholder="No. de pedido/SKU" aria-label="No. de pedido/SKU" name="sku" />
                                    <label for="sku">No. de pedido/SKU</label>
                                </div>
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
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="text" placeholder="Destino lote"
                                        id="destino_lote" name="destino_lote" />
                                    <label for="destino_lote">Destino lote</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="number" placeholder="Ingrese un valor"
                                        id="cantidad_botellas" name="cant_botellas" min="0" />
                                    <label for="cantidad_botellas">Cantidad de botellas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="number" placeholder="Presentación de la botella"
                                        id="presentacion" name="presentacion" min="0"/>
                                    <label for="presentacion">Presentación de la botella</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class=" form-select" id="unidad" name="unidad" aria-label="Unidad">
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
                                        placeholder="Volumen total" id="volumen_total" name="volumen_total"
                                        readonly />
                                    <label for="volumen_total">Volumen total en Litros</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class="select2 form-select id_instalacion" id="id_instalacion"
                                        name="lugar_envasado" aria-label="Default select example">

                                    </select>
                                    <label for="id_instalacion">Lugar de envasado</label>
                                </div>
                            </div>


                        </div>
                        


                    <div id="datosOpcion2">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><button type="button" class="btn btn-primary add-row"> <i
                                                class="ri-add-line"></i> </button></th>
                                    <th>Lote a granel</th>
                                    <th>Volumen parcial</th>
                                </tr>
                            </thead>
                            <tbody id="contenidoGraneles">
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-danger remove-row" disabled> <i
                                                class="ri-delete-bin-5-fill"></i> </button>
                                    </th>
                                    <td>
                                        <select class="id_lote_granel form-control select2" name="id_lote_granel[]" id="id_lote_granel">
                                            <!-- Opciones -->
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            name="volumen_parcial[]" id="volumen_parcial">
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
                    contenido = '<option value="' + response.lotes_granel[index].id_empresa + '">' +
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
                    if (response.instalaciones[index].tipo === 'envasadora' || response.instalaciones[index]
                        .tipo === 'Envasadora') {
                        contenido += '<option value="' + response.instalaciones[index].id_instalacion +
                            '">' +
                            response.instalaciones[index].direccion_completa + '</option>';
                    }
                }

                if (contenido === "") {
                    contenido = '<option value="">Sin lotes a granel registrados</option>';
                }

                $('.id_instalacion').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }


    document.addEventListener('DOMContentLoaded', function() {
        function calcularVolumenTotal() {
            var cantidadBotellas = parseFloat(document.getElementById('cantidad_botellas').value) || 0;
            var presentacion = parseFloat(document.getElementById('presentacion').value) || 0;
            var unidad = document.getElementById('unidad').value;

            var volumenTotal;

            if (unidad === "Litros") {
                volumenTotal = cantidadBotellas * presentacion;
            } else if (unidad === "Mililitros") {
                volumenTotal = (cantidadBotellas * presentacion) / 1000;
            } else if (unidad === "Centrilitros") {
                volumenTotal = (cantidadBotellas * presentacion) / 100;
            } else {
                volumenTotal = ''; // Limpiar el campo si la unidad no es Litros ni Mililitros
            }

            document.getElementById('volumen_total').value = volumenTotal ? volumenTotal.toFixed(2) : '';
        }

        // Añadir eventos de cambio a los campos relevantes
        document.getElementById('cantidad_botellas').addEventListener('input', calcularVolumenTotal);
        document.getElementById('presentacion').addEventListener('input', calcularVolumenTotal);
        document.getElementById('unidad').addEventListener('change', calcularVolumenTotal);
    });


    //Limpia en cancelar
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#addlostesEnvasado .btn-outline-secondary').addEventListener('click',
            function() {
                document.getElementById('addNewLoteForm').reset();
                $('.select2').val(null).trigger('change'); // Reset select2 fields
            });
    });
    //Limpia en registrar
    document.addEventListener('DOMContentLoaded', (event) => {
        const modal = document.getElementById('addlostesEnvasado');
        const form = document.getElementById('addNewLoteForm');

        modal.addEventListener('hidden.bs.modal', (event) => {
            form.reset();
            // Limpia select2
            $('#id_empresa').val('').trigger('change');
            $('#id_lote_granel').val('').trigger('change');
            $('#id_marca').val('').trigger('change');
            $('#id_instalacion').val('').trigger('change');
            // Si hay campos adicionales que necesitan ser limpiados
            document.querySelectorAll('.select2').forEach((select) => {
                $(select).val('').trigger('change');
            });
        });

        form.addEventListener('submit', (event) => {
            // Evitar el comportamiento predeterminado del formulario
            event.preventDefault();

            // Simular envío del formulario (ejemplo: hacer una solicitud AJAX)
            // Aquí podrías realizar la solicitud AJAX

            // Después de enviar el formulario, restablecerlo y cerrar el modal
            form.reset();
            // Limpia select2
            $('#id_empresa').val('').trigger('change');
            $('#id_lote_granel').val('').trigger('change');
            $('#id_marca').val('').trigger('change');
            $('#id_instalacion').val('').trigger('change');
            // Si hay campos adicionales que necesitan ser limpiados
            document.querySelectorAll('.select2').forEach((select) => {
                $(select).val('').trigger('change');
            });

            // Cerrar el modal
            const modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
        });
    });

</script>
