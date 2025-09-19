<div class="modal fade" id="EditBitacora" tabindex="-1" aria-labelledby="EditarInventarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="editBitacora">Editar Bitácora de mezcal a granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-8">
                <form id="EditInventarioForm" method="POST">
                    @csrf
                    <!-- PROCESO DE ELABORACIÓN DE MEZCAL -->
                    <div>
                        <div class="card mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                PROCESO DE ELABORACIÓN DE MEZCAL (PRODUCTOR ARTESANAL)
                            </div>
                            <div class="card-body">
                                <!-- GENERALES -->
                                <input type="hidden" name="id" id="edit_bitacora_id">
                                <div class="row">
                                    <div class="col-md-1 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control datepicker"
                                                id="edit_fecha_ingreso" name="fecha_ingreso"
                                                placeholder="Fecha de ingreso">
                                            <label for="fecha_ingreso">Fecha de ingreso</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline" onchange="obtenerInstalacion();">
                                            <select id="edit_id_empresa" name="id_empresa" class="select2 form-select"
                                                data-error-message="por favor selecciona la empresa">
                                                @if ($tipo_usuario != 3)
                                                    <option value="" disabled selected>Selecciona el cliente
                                                    </option>
                                                @endif
                                                @foreach ($empresas as $empresa)
                                                    <option value="{{ $empresa->id_empresa }}">
                                                        {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                                        | {{ $empresa->razon_social }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="id_empresa" class="form-label">Cliente</label>
                                        </div>
                                    </div>
                                     <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="edit_id_instalacion" name="id_instalacion" class="select2 form-select">
                                            <option value="" disabled selected>Seleccione una instalación</option>
                                            </select>
                                            <label for="id_instalacion" class="form-label">Selecciona la instalación</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_lote_granel"
                                                name="lote_granel" placeholder="Lote a granel">
                                            <label for="lote_granel">Lote a granel</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_numero_tapada"
                                                name="numero_tapada" placeholder="Nº de tapada">
                                            <label for="numero_tapada">Nº de tapada</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- IDENTIFICACIÓN DEL MAGUEY -->
                                <div class="row">
                                    <!-- IDENTIFICACIÓN DEL MAGUEY -->
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="5"
                                                            class="text-center bg-label-info text-dark text-uppercase fs-6 fw-bold py-3">
                                                            IDENTIFICACIÓN DEL MAGUEY
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>N° de guía</th>
                                                        <th style="width: 200px;">Tipo de maguey</th>
                                                        <th>N° de piñas</th>
                                                        <th>Kg. de maguey</th>
                                                        <th>% de art.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><span class="position-relative d-block mb-1"><input
                                                                    type="text" class="form-control"
                                                                    id="edit_numero_guia" name="numero_guia"
                                                                    placeholder="N° de guía"></span>
                                                        </td>
                                                        <td> {{-- <span class="position-relative d-block mb-1"> --}}
                                                            <div class="form-floating form-floating-outline mb-4">
                                                                <select id="edit_tipo_agave" name="id_tipo[]"
                                                                    class="select2 form-select mb-4" multiple>
                                                                    @foreach ($tipos as $tipo)
                                                                        <option value="{{ $tipo->id_tipo }}">
                                                                            {{ $tipo->nombre }}
                                                                            ({{ $tipo->cientifico }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>{{-- </span> --}}
                                                            </div>
                                                        </td>
                                                        <td><span class="position-relative d-block mb-1"><input
                                                                    type="number" class="form-control"
                                                                    id="edit_numero_pinas" name="numero_pinas"
                                                                    placeholder="N° de piñas"></span></td>
                                                        <td><span class="position-relative d-block mb-1"><input
                                                                    type="number" step="0.01" class="form-control"
                                                                    id="edit_kg_maguey" name="kg_maguey"
                                                                    placeholder="Kg. de maguey"></span></td>
                                                        <td><span class="position-relative d-block mb-1"><input
                                                                    type="number" step="0.01" class="form-control"
                                                                    placeholder="% de art." id="edit_porcentaje_azucar"
                                                                    name="porcentaje_azucar"></sapn>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- COCCIÓN -->
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="5"
                                                            class="text-center bg-label-info text-dark text-uppercase fs-6 fw-bold py-3">
                                                            COCCIÓN
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Kg. a cocción</th>
                                                        <th>Fecha inicial</th>
                                                        <th>Fecha final</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <span class="position-relative d-block mb-1">
                                                                <input type="number" step="0.01"
                                                                    class="form-control" id="edit_kg_coccion"
                                                                    name="kg_coccion" placeholder="Kg. a cocción">
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="position-relative d-block mb-1">
                                                                <input type="text" class="form-control datepicker"
                                                                    id="edit_fecha_inicio_coccion"
                                                                    name="fecha_inicio_coccion"
                                                                    placeholder="aaaa-mm-dd">
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="position-relative d-block mb-1">
                                                                <input type="text" class="form-control datepicker"
                                                                    id="edit_fecha_fin_coccion"
                                                                    name="fecha_fin_coccion" placeholder="aaaa-mm-dd">
                                                            </span>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN DINÁMICA: MOLIENDA, FORMULACIÓN, FERMENTACIÓN Y DESTILACIÓN DE MOSTOS -->
                        <div class="card mb-4 border rounded">
                            <div class="card-body">
                                <!-- MOLIENDA, FORMULACIÓN, FERMENTACIÓN Y DESTILACIÓN DE MOSTOS -->
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                        <thead class="table-light align-middle">
                                            <tr>
                                                <th colspan="12"
                                                    class="text-center bg-label-primary text-uppercase fs-6 fw-bold py-3">
                                                    MOLIENDA, FORMULACIÓN, FERMENTACIÓN Y DESTILACIÓN DE MOSTOS
                                                </th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        id="edit_agregarFilaMolienda">
                                                        <i class="ri-add-circle-fill text-white"></i>
                                                    </button>
                                                </th>
                                                <th rowspan="2">Fecha de molienda</th>
                                                <th rowspan="2">Nº de tina</th>
                                                <th rowspan="2">Fecha de formulación</th>
                                                <th rowspan="2">Volumen de formulación</th>
                                                <th rowspan="2">Fecha de destilación</th>
                                                <th colspan="2">Puntas</th>
                                                <th colspan="2">Mezcal</th>
                                                <th colspan="2">Colas</th>
                                            </tr>
                                            <tr>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                            </tr>
                                        </thead>
                                        <tbody id="edit_tablaMolienda">
                                            {{-- filas dinamicas --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <!-- CARD SEGUNDA DESTILACIÓN -->
                        <div class="card mb-4 border rounded">
                            <div class="card-body">
                                <!-- SEGUNDA DESTILACIÓN -->
                                <div class="table-responsive mb-4">
                                    <table
                                        class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                        <thead class="table-light align-middle">
                                            <tr>
                                                <th colspan="8"
                                                    class="text-center bg-label-primary text-uppercase fs-6 fw-bold py-3">
                                                    SEGUNDA DESTILACIÓN
                                                </th>
                                            </tr>
                                            <tr>
                                                <td rowspan="2"> <button type="button"
                                                        class="btn btn-primary btn-sm"
                                                        id="edit_agregarFilaSegundaDestilacion">
                                                        <i class="ri-add-circle-fill text-white"></i>
                                                    </button></td>
                                                <th rowspan="2">Fecha de destilación</th>
                                                <th colspan="2">Puntas</th>
                                                <th colspan="2">Mezcal</th>
                                                <th colspan="2">Colas</th>
                                            </tr>
                                            <tr>

                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                            </tr>
                                        </thead>
                                        <tbody id="edit_tablaSegundaDestilacion">
                                            {{-- filas dinamicas --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- CARD / OBSERVACIONES -->
                        <div class="card mb-4 border rounded">
                            <div class="card-body">
                                <!-- TOTAL -->
                                <div class="table-responsive mb-4">
                                    <table
                                        class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                        <thead class="table-light align-middle">
                                            <tr>
                                                <th colspan="7"
                                                    class="text-center bg-label-info text-dark text-uppercase fs-6 fw-bold py-3">
                                                    TOTAL
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Molienda volumen total formulado</th>
                                                <th>Puntas Volumen</th>
                                                <th>Puntas % Alc. Vol.</th>
                                                <th>Mezcal Volumen</th>
                                                <th>Mezcal % Alc. Vol.</th>
                                                <th>Colas Volumen</th>
                                                <th>Colas % Alc. Vol.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01"
                                                            class="form-control bg-light"
                                                            name="volumen_total_formulado"
                                                            id="edit_volumen_total_formulado"
                                                            style="pointer-events: none;" readonly placeholder="Vol.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01"
                                                            class="form-control bg-light" readonly
                                                            style="pointer-events: none;" name="puntas_volumen"
                                                            id="edit_puntas_volumen" placeholder="Vol.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="puntas_alcohol" id="edit_puntas_alcohol"
                                                            placeholder="% Alc.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01"
                                                            class="form-control bg-light" readonly
                                                            style="pointer-events: none;" name="mezcal_volumen"
                                                            id="edit_mezcal_volumen" placeholder="Vol.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="mezcal_alcohol" id="edit_mezcal_alcohol"
                                                            placeholder="% Alc.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01"
                                                            class="form-control bg-light" readonly
                                                            style="pointer-events: none;" name="colas_volumen"
                                                            id="edit_colas_volumen" placeholder="Vol.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="colas_alcohol" id="edit_colas_alcohol"
                                                            placeholder="% Alc.">
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-5">
                                        <label for="observaciones"
                                            class="form-label fw-bold fs-6">Observaciones</label>
                                        <textarea class="form-control" id="edit_observaciones" name="observaciones" rows="3"
                                            placeholder="Escribe observaciones"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- Botones -->
                    <div class="d-flex justify-content-center">
                        <button disabled class="btn btn-primary me-2 d-none" type="button" id="loadingEdit">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Actualizando...
                        </button>
                        <button type="submit" class="btn btn-primary me-2" id="btnEdit"><i
                                class="ri-pencil-fill me-1"></i>
                            Editar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function obtenerInstalacion() {
    var empresa = $("#edit_id_empresa").val();
    if (empresa !== "" && empresa !== null && empresa !== undefined) {

        $.ajax({
            url: '/getDatosBitacora/' + empresa,
            method: 'GET',
            success: function(response) {
                var contenido = '<option value="" disabled>Seleccione una instalación</option>';
                var instalacion_id = $("#edit_id_instalacion").data('selected') || "";

                for (let index = 0; index < response.instalaciones.length; index++) {
                    var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);
                    var seleccionado = (instalacion_id == response.instalaciones[index].id_instalacion) ? "selected" : "";

                    contenido += '<option ' + seleccionado + ' value="' + response.instalaciones[index].id_instalacion + '">' +
                        tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                        '</option>';
                }

                if (response.instalaciones.length == 0) {
                    contenido = '<option value="">Sin instalaciones registradas</option>';
                }

                $('#edit_id_instalacion').html(contenido);

                // Si hay un valor seleccionado, aplicarlo después de insertar las opciones
                if (instalacion_id) {
                    $('#edit_id_instalacion').val(instalacion_id).trigger('change');
                }
            },
            error: function() {
                console.error('Error al cargar las instalaciones.');
            }
        });
    }
}


</script>
