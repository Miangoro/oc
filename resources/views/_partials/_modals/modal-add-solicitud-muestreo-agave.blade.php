<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addSolicitudMuestreoAgave" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nueva solicitud de muestreo de agave</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addRegistrarSolicitudMuestreoAgave">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerInstalacionesMuestreoAgave();" 
                                    name="id_empresa" class="select2 form-select id_empresa_dic2" required>
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }} | {{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    name="fecha_visita" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <select class="select2 form-select" id="id_instalacion_dic2" name="id_instalacion" aria-label="id_instalacion" required>
                                <option value="" selected>Lista de instalaciones</option>
                            </select>
                            <label for="id_predio">Domicilio de la instalación de producción</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <select multiple class="select2 form-select" id="id_instalacion" name="id_guia" aria-label="id_instalacion" required>
                                <option value="" selected>Lista de guías de agave</option>
                            </select>
                            <label for="id_predio">Guías de agave expedidas por OC CIDAM</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-150" id="comentarios" placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary btnCancelar" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function obtenerInstalacionesMuestreoAgave() {
        var empresa = $(".id_empresa_dic2").val();

        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);
                var contenido = "";
            for (let index = 0; index < response.instalaciones_produccion.length; index++) {
                // Limpia el campo tipo usando la función limpiarTipo
                var tipoLimpio = limpiarTipo(response.instalaciones_produccion[index].tipo);

                contenido = '<option value="' + response.instalaciones_produccion[index].id_instalacion + '">' +
                    tipoLimpio + ' | ' + response.instalaciones_produccion[index].direccion_completa + '</option>' +
                    contenido;
            }
            if (response.instalaciones_produccion.length == 0) {
                contenido = '<option value="">Sin instalaciones registradas</option>';
            }
            $('#id_instalacion_dic2').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }
    // Función para limpiar el campo tipo
function limpiarTipo(tipo) {
    try {
        // Convierte el JSON string a un array y únelos en una cadena limpia
        return JSON.parse(tipo).join(', ');
    } catch (e) {
        // Si no es JSON válido, regresa el valor original
        return tipo;
    }
}


</script>