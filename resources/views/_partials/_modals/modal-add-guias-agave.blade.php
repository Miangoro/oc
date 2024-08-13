<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addGuias" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nueva Guia de traslado Agave/Maguey</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addGuiaForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerNombrePredio(); obtenerPlantacionPredio();" id="id_empresa"
                                    name="empresa" class="select2 form-select" required>
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($empresa as $id_cliente)
                                        <option value="{{ $id_cliente->id_empresa }}">{{ $id_cliente->razon_social }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Número de guías solicitadas"
                                    id="numero_guias" name="numero_guias" required />
                                <label for="numero_guias">Número de guías solicitadas</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select " id="nombre_predio" name="predios" aria-label="Marca"
                            required>
                            <option value="" selected>Lista de predios</option>
                        </select>
                        <label for="nombre_predio">Lista de predios</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select " id="id_plantacion" name="plantacion" aria-label="Marca"
                            required>
                            <option value="" selected>Plantación del predio</option>
                        </select>
                        <label for="id_plantacion">Características del predio</label>
                    </div>

                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Datos para Guía de traslado</h4>
                        <p class="address-subtitle"> <b style="color: red"> (DATOS NO OBLIGATORIOS SI NO CUENTA CON
                                ELLOS DEJAR LOS ESPACIOS VACIOS)</b></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Número de plantas anterior"
                                    id="num_anterior" name="anterior" oninput="calcularPlantasActualmente()" />
                                <label for="num_anterior">Número de plantas anterior</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number"
                                    placeholder="Número de plantas comercializadas" id="num_comercializadas"
                                    name="comercializadas" oninput="calcularPlantasActualmente()" />
                                <label for="num_comercializadas">Número de plantas comercializadas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Mermas plantas"
                                    id="mermas_plantas" name="mermas"   oninput="calcularPlantasActualmente()"/>
                                <label for="mermas_plantas">Mermas plantas</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Número de plantas actualmente"
                                    id="numero_plantas" name="plantas" readonly />
                                <label for="numero_plantas">Número de plantas actualmente</label>
                            </div>
                        </div>
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
                    contenido = '<option value="' + response.predios[index].id_predio + '">' + response
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
                for (let index = 0; index < response.plantacion.length; index++) {
                    contenido = '<option value="' + response.plantacion[index].id_plantacion +
                        '">Número de plantas: ' + response
                        .plantacion[index].num_plantas + ' | Tipo de agave: ' + response
                        .plantacion[index].nombre + ' ' + response
                        .plantacion[index].cientifico + ' | Año de platanción: ' + response
                        .plantacion[index].anio_plantacion + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.plantacion.length == 0) {
                    contenido = '<option value="">Sin predios registradas</option>';
                }
                $('#id_plantacion').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }

/*     function obtenerNumplanta() {
        var empresa = $("#id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);

                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.plantacion.length; index++) {
                    contenido = '<option value="' + response.plantacion[index].id_plantacion +
                        '">Número de plantas: ' + response
                        .plantacion[index].num_plantas + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.plantacion.length == 0) {
                    contenido = '<option value="">Sin predios registradas</option>';
                }
                $('#num_anterior').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    } */

// Función para restar los campos
// Función para restar los campos
function calcularPlantasActualmente() {
    // Obtener los valores de los inputs
    const numAnterior = parseFloat(document.getElementById('num_anterior').value) || 0;
    const numComercializadas = parseFloat(document.getElementById('num_comercializadas').value) || 0;
    const mermasPlantas = parseFloat(document.getElementById('mermas_plantas').value) || 0;

    // Calcular el número de plantas actualmente
    let plantasActualmente = numAnterior - numComercializadas - mermasPlantas;

    // Evitar números negativos
    if (plantasActualmente < 0) {
        plantasActualmente = 0;
    }

    // Asignar el valor calculado al input
    document.getElementById('numero_plantas').value = plantasActualmente;
}




    //Limpia en el boton cancelar
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#addGuias .btn-outline-secondary').addEventListener('click',
            function() {
                document.getElementById('addGuiaForm').reset();
                $('.select2').val(null).trigger('change'); // Reset select2 fields
            });
    });

    //Limpia al registrar
    document.addEventListener('DOMContentLoaded', (event) => {
        const modal = document.getElementById('addGuias');
        const form = document.getElementById('addGuiaForm');

        modal.addEventListener('hidden.bs.modal', (event) => {
            form.reset();
            // Limpia select2
            $('#id_empresa').val('').trigger('change');
            $('#nombre_predio').val('').trigger('change');
            $('#id_plantacion').val('').trigger('change');
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
            $('#nombre_predio').val('').trigger('change');
            $('#id_plantacion').val('').trigger('change');
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
