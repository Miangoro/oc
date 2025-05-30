<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addEmisionCetificadoVentaNacional" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Registrar nueva solicitud de emisión de certificado venta nacional
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <form id="addEmisionCetificadoVentaNacionalForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_empresa_solicitud_emision_venta" onchange="obtenerDictamenesEnvasados();"
                                    name="id_empresa" class="id_empresa select2 form-select">
                                    <option value="" disabled selected>Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_dictamen_envasado" name="id_dictamen_envasado"
                                    class="select2 form-select">
                                </select>
                                <label for="id_dictamen_envasado">Dictamen envasado</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="num_cajas" name="num_cajas" class="form-control">
                                <label for="num_cajas">No. de Cajas</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="num_botellas" name="num_botellas" class="form-control"
                                    required>
                                <label for="num_botellas">No. de Botellas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-150" id="comentarios_e_venta_n"
                                placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary"><i class="ri-add-line"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger btnCancelar" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function obtenerDictamenesEnvasados() {
        var empresa = $("#id_empresa_solicitud_emision_venta").val();

        $.ajax({
            url: '/obtener_dictamenes_envasado/' + empresa,
            method: 'GET',
            success: function(response) {
                let opciones = '<option value="" disabled selected>Selecciona dictamen</option>';
                response.forEach(function(dictamen) {
                    opciones += '<option value="' + dictamen.id_dictamen_envasado + '">' +
                        'Dictamen: ' + dictamen.num_dictamen + ' | ' +
                        'Solicitud: ' + dictamen.folio + ' | ' +
                        'Lote envasado: ' + dictamen.lote_nombre +
                        '</option>';
                });
                $('#id_dictamen_envasado').html(opciones).trigger('change');
            },
            error: function() {
                alert('Error al obtener dictámenes envasados.');
            }
        });
    }
</script>
