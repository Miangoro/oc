<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addSolicitudDictamen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nueva solicitud de dictamen de instalaciones</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addGuiaForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerInstalacion();" id="id_empresa"
                                    name="id_empresa" class="select2 form-select" required>
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input  id="flatpickr-datetime" placeholder="YYYY-MM-DD" class="form-control" type="text"
                                    name="fecha_sugerida" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <select class="select2 form-select " id="id_instalacion" name="id_instalacion" aria-label="id_instalacion"
                                required>
                                <option value="" selected>Lista de instalaciones</option>
                            </select>
                            <label for="id_instalacion">Domicilio para la inspección</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="comentarios" class="form-control h-px-150" id="comentarios" placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
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
    function obtenerInstalacion() {
        var empresa = $("#id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);

                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.instalaciones.length; index++) {
                    contenido = '<option value="' + response.instalaciones[index].id_instalacion + '">' + response
                        .instalaciones[index].tipo + ' | ' + response
                        .instalaciones[index].direccion_completa + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.instalaciones.length == 0) {
                    contenido = '<option value="">Sin instalaciones registradas</option>';
                }
                $('#id_instalacion').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }




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
