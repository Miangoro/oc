<!--Modal para reexpedirdictamen de Envasado -->
<div class="modal fade" id="modalReexpredirDictamenEnvasado" tabindex="-1" aria-labelledby="modalReexpedirDictamenEnvasadoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lz">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="modalReexpedirDictamenEnvasadoLabel" class="modal-title">Reexpedir/Cancelar Dictamen Envasado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addReexpedirDictamenEnvasadoForm" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <!-- Número de Dictamen -->
                        <input type="hidden" id="reexpedir_id_dictamen" name="id_dictamen">
                        
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <select id="cancelar_reexpedir" name="cancelar_reexpedir" class="form-select"
                                    aria-label="Floating label select example" required>
                                    <option value="" disabled selected>¿Que quieres hacer?</option>
                                    <option value="1">Cancelar dictamen</option>
                                    <option value="2">Cancelar y reexpedir dictamen</option>
                                </select>
                                <label for="cancelar_reexpedir">¿Que quieres hacer?</label>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="reexpedirFields" style="display: none;">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline ">
                                    <select id="reexpedir_id_inspeccion" name="id_inspeccion" class="select2 form-select">
                                        <option value="" disabled selected>Selecciona el número de servicio</option>
                                        @foreach ($inspecciones as $inspeccion)
                                            <option value="{{ $inspeccion->id_inspeccion }}">{{ $inspeccion->num_servicio }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="id_inspeccion">No. de servicio</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="reexpedir_num_dictamen"
                                        autocomplete="off" name="num_dictamen" placeholder="Número de dictamen">
                                    <label for="num_dictamen">No. de dictamen</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <select id="reexpedir_id_firmante" name="id_firmante" class="select2 form-select">
                                        <option value="" disabled selected>Selecciona el nombre del firmante</option>
                                        @foreach ($inspectores as $inspector)
                                            <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_firmante">Nombre del inspector</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control flatpickr-datetime" id="reexpedir_fecha_emision" name="fecha_emision"
                                        autocomplete="off" placeholder="yyyy-mm-dd">
                                    <label for="fecha_emision">Fecha de emisión</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" id="reexpedir_fecha_vigencia" autocomplete="off"
                                        name="fecha_vigencia" placeholder="yyyy-mm-dd" readonly>
                                    <label for="fecha_vigencia">Fecha de vigencia</label>
                                </div>
                            </div>
                        </div>

                    </div>
          

                        <div class="form-floating form-floating-outline mb-6">
                            <textarea class="form-control h-px-75" id="observaciones" name="observaciones" placeholder="Motivo de cancelación"
                                autocomplete="off"></textarea>
                            <label for="observaciones">Motivo de cancelación</label>
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
    function obtenerLotess() {
        var empresa = $("#reexpedir_id_empresa").val();
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

                var contenido = "<option value='' disabled selected>Selecciona el lote envasado</option>";
                for (let index = 0; index < response.lotes_envasado.length; index++) {
                    contenido += '<option value="' + response.lotes_envasado[index].id_lote_envasado + '">' +
                        response.lotes_envasado[index].nombre_lote + '</option>';
                }
                if (response.lotes_envasado.length == 0) {
                    contenido =
                        '<option value="" disabled selected>Sin lotes envasado registrados</option>';
                }
                $('#reexpedir_id_lote_envasado').html(contenido);

                // Asegúrate de seleccionar el lote correcto si ya estaba seleccionado
                var selectedLote = $('#reexpedir_id_lote_envasado').data('selectedLote');
                if (selectedLote) {
                    $('#reexpedir_id_lote_envasado').val(selectedLote).trigger('change');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar los lotes envasado:', error);
            }
        });
    }
</script>
