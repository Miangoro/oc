<!-- Modal para agregar nuevo dictamen de Envasado -->
<div class="modal fade" id="modalAddDictamenEnvasado" tabindex="-1" aria-labelledby="modalAddDictamenEnvasadoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalAddDictamenEnvasadoLabel" class="modal-title">Nuevo Dictamen envasado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addNewDictamenEnvasadoForm" method="POST">
                    @csrf
                    <!-- Fila 1 -->
                    <div class="row mb-4">
                        <!-- Número de Dictamen -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="num_dictamen" name="num_dictamen" autocomplete="off"
                                    placeholder="Número de dictamen">
                                <label for="num_dictamen">Número de Dictamen</label>
                            </div>
                        </div>

                        <!-- Select de Empresa Cliente -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select onchange="obtenerLote()" id="id_empresa" name="id_empresa"
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
                                <select id="id_inspeccion" name="id_inspeccion" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona el número de servicio</option>
                                    @foreach ($inspecciones as $inspeccion)
                                        <option value="{{ $inspeccion->id_inspeccion }}">{{ $inspeccion->num_servicio }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_inspeccion">Número de Servicio</label>
                            </div>
                        </div>
                        <!-- Select de Lote envasado -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="id_lote_envasado" name="id_lote_envasado" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona el lote envasado</option>
                                    <!-- Opciones serán cargadas dinámicamente -->
                                </select>
                                <label for="id_lote_envasado">Lote envasado</label>
                            </div>
                        </div>

                    </div>

                    <!-- Fila 3 -->
                    <div class="row mb-4">
                        <!-- Fecha de Emisión -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control datepicker" id="fecha_emision" name="fecha_emision" autocomplete="off"
                                    placeholder="yyyy-mm-dd">
                                <label for="fecha_emision">Fecha de Emisión</label>
                            </div>
                        </div>

                        <!-- Fecha de Vigencia -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control datepicker" id="fecha_vigencia" name="fecha_vigencia" autocomplete="off"
                                    placeholder="yyyy-mm-dd">
                                <label for="fecha_vigencia">Fecha de Vigencia</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <!-- Fecha de Servicio -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control datepicker" id="fecha_servicio" name="fecha_servicio" autocomplete="off"
                                    placeholder="yyyy-mm-dd">
                                <label for="fecha_servicio">Fecha de Servicio</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select  id="id_firmante" name="id_firmante" class="select2 form-select">
                                <option value="" disabled selected>Selecciona el nombre del firmante</option>
                                @foreach ($inspectores as $inspector)
                                    <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                @endforeach
                             </select>
                                <label for="id_firmante">Nombre del inspector</label>
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
function obtenerLote() {
    var empresa = $("#id_empresa").val();

    if (!empresa) {
        return;
    }

    // Hacer una petición AJAX para obtener los detalles de la empresa
    $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function(response) {
            // Verificar si response.lotes_envasado está definido y es un array
            if (!response || !Array.isArray(response.lotes_envasado)) {
                console.error('Respuesta inesperada del servidor:', response);
                return;
            }

            var contenido = "";
            for (let index = 0; index < response.lotes_envasado.length; index++) {
                contenido += '<option value="' + response.lotes_envasado[index].id_lote_envasado + '">' +
                    response.lotes_envasado[index].nombre_lote + '</option>';
            }
            if (response.lotes_envasado.length === 0) {
                contenido = '<option value="" disabled selected>Sin lotes envasado registrados</option>';
            }
            $('#id_lote_envasado').html(contenido);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los lotes envasado:', error);
        }
    });
}



</script>