<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addSolicitudGeoreferenciacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nueva solicitud de georeferenciación</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addRegistrarSolicitudGeoreferenciacion">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerPredios();" 
                                    name="id_empresa" class="select2 form-select id_empresa" required>
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
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    name="fecha_visita" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <select class="select2 form-select id_predio" name="id_predio" aria-label="id_predio"
                                required>
                                <option value="" selected>Lista de predios</option>
                            </select>
                            <label for="id_predio">Domicilio del predio a inspeccionar</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="Dirección del punto de reunión" class="form-control" type="text"
                                    name="punto_reunion" />
                                <label for="num_anterior">Dirección del punto de reunión</label>
                            </div>
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
    function obtenerPredios() {
        var empresa = $(".id_empresa").val();
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
                        .predios[index].nombre_predio + ' | ' +  response
                        .predios[index].ubicacion_predio + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }
                if (response.predios.length == 0) {
                    contenido = '<option value="">Sin predios registrados</option>';
                }
                $('.id_predio').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }


</script>