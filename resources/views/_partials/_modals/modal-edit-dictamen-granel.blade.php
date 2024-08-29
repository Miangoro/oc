<!-- Modal para agregar nuevo dictamen de granel -->
<div class="modal fade" id="modalEditDictamenGranel" tabindex="-1" aria-labelledby="modalAddDictamenGranelLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalAddDictamenGranelLabel" class="modal-title">Editar Dictamen a Granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addNEditDictamenGranelForm" method="POST">
                    @csrf
                    <!-- Fila 1 -->
                    <div class="row mb-4">
                        <!-- Número de Dictamen -->
                        <input type="hidden" id="edit_id_dictamen" name="id_dictamen">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="edit_num_dictamen" name="num_dictamen"
                                    placeholder="Número de dictamen">
                                <label for="num_dictamen">Número de Dictamen</label>
                            </div>
                        </div>

                        <!-- Select de Empresa Cliente -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select onchange="obtenerLotes()" id="edit_id_empresa" name="id_empresa"
                                    class="select2 form-select">
                                    <option value="" disabled selected>Selecciona la empresa cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Empresa Cliente</label>
                            </div>
                        </div>
                    </div>

                    <!-- Fila 2 -->
                    <div class="row mb-4">
                        <!-- Select de Inspección -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="edit_id_inspeccion" name="id_inspeccion" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona el número de servicio</option>
                                    @foreach ($inspecciones as $inspeccion)
                                        <option value="{{ $inspeccion->id_inspeccion }}">{{ $inspeccion->num_servicio }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_inspeccion">Número de Servicio</label>
                            </div>
                        </div>

                        <!-- Select de Lote Granel -->
                        <!-- Select de Lote Granel -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="edit_id_lote_granel" name="id_lote_granel" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona el lote</option>
                                    <!-- Opciones serán cargadas dinámicamente -->
                                </select>
                                <label for="id_lote_granel">Lote</label>
                            </div>
                        </div>

                    </div>

                    <!-- Fila 3 -->
                    <div class="row mb-4">
                        <!-- Fecha de Emisión -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control datepicker" id="edit_fecha_emision" name="fecha_emision"
                                    placeholder="yyyy-mm-dd">
                                <label for="fecha_emision">Fecha de Emisión</label>
                            </div>
                        </div>

                        <!-- Fecha de Vigencia -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control datepicker" id="edit_fecha_vigencia" name="fecha_vigencia"
                                    placeholder="yyyy-mm-dd">
                                <label for="fecha_vigencia">Fecha de Vigencia</label>
                            </div>
                        </div>

                        <!-- Fecha de Servicio -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control datepicker" id="edit_fecha_servicio" name="fecha_servicio"
                                    placeholder="yyyy-mm-dd">
                                <label for="fecha_servicio">Fecha de Servicio</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function obtenerLotes() {
    var empresa = $("#edit_id_empresa").val();
    if (!empresa) {
        return;
    }
    // Hacer una petición AJAX para obtener los detalles de la empresa
    $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function(response) {
            if (response.error) {
                console.error(response.error);
                return;
            }

            var contenido = "<option value='' disabled selected>Selecciona el lote</option>";
            for (let index = 0; index < response.lotes_granel.length; index++) {
                contenido += '<option value="' + response.lotes_granel[index].id_lote_granel + '">' +
                    response.lotes_granel[index].nombre_lote + '</option>';
            }
            if (response.lotes_granel.length == 0) {
                contenido = '<option value="" disabled selected>Sin lotes registrados</option>';
            }
            $('#edit_id_lote_granel').html(contenido);

            // Asegúrate de seleccionar el lote correcto si ya estaba seleccionado
            var selectedLote = $('#edit_id_lote_granel').data('selectedLote');
            if (selectedLote) {
                $('#edit_id_lote_granel').val(selectedLote).trigger('change');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los lotes a granel:', error);
        }
    });
}
</script>
