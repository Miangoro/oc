<div class="modal fade" id="editarBitacora" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="editBitacora">Editar bitácora de inventario de producto terminado
                    (Comercializador)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-8">
                <form id="editInventarioForm" method="POST">
                    @csrf
                    <input type="hidden" id="edit_bitacora_id" name="edit_bitacora_id">
                    <!-- Datos Iniciales -->
                    <div>
                        <div class="card mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                DATOS INICIALES
                            </div>
                            <!-- Datos Iniciales -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="edit_id_empresa" onchange="obtenerInstalacionEdit();"
                                                name="id_empresa" class="select2 form-select"
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
                                            <label for="edit_id_empresa" class="form-label">Cliente</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control datepicker" id="edit_fecha"
                                                name="fecha" aria-label="Fecha"  placeholder="aaaa-mm-dd">
                                            <label for="edit_fecha">Fecha</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="edit_tipo_op" name="tipo_operacion" class="form-select"
                                                data-error-message="Por favor selecciona el tipo de operación">
                                                <option class="bg-light" value="" disabled selected>Selecciona el
                                                    tipo de operación</option>
                                                <option value="Entradas">Entradas</option>
                                                <option value="Salidas">Salidas</option>
                                                <option value="Entradas y salidas">Entradas y salidas</option>
                                            </select>
                                            <label for="edit_tipo_op">Tipo de operación</label>
                                        </div>
                                    </div>
                                </div>


                                <!-- NUEVOS CAMPOS AGREGADOS -->
                                <div class="row">
                                      <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select class="form-select select2" id="edit_lote_granel"
                                                name="lote_granel"{{--  onchange="editObtenerDatosGraneles();" --}}>
                                                <option value="" disabled selected>Selecciona un lote a granel
                                                </option>
                                            </select>
                                            <label for="id_lote_granel">Lote a granel</label>
                                        </div>
                                    </div>
                                     <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select class="form-select select2" id="edit_lote_envasado" {{-- onchange="editObtenerDatosGranelesInspecciones();" --}}
                                                name="lote_envasado">
                                                <option value="" disabled selected>Selecciona un lote envasado
                                                </option>
                                            </select>
                                            <label for="id_lote_envasado">Lote envasado</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="edit_id_instalacion" name="id_instalacion"
                                                class="select2 form-select">
                                                <option value="" disabled selected>Seleccione una instalación
                                                </option>
                                            </select>
                                            <label for="id_instalacion" class="form-label">Selecciona la
                                                instalación</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="edit_id_marca" name="id_marca" class="select2 form-select">
                                                <option value="" disabled selected>Seleccione una marca</option>
                                                <!-- Opciones dinámicas -->
                                            </select>
                                            <label for="id_marca">Marca</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="edit_id_categoria" name="id_categoria" class="select2 form-select">
                                                <option value="" disabled selected>Selecciona una categoría
                                                </option>
                                                @foreach ($categorias as $categoria)
                                                    <option value="{{ $categoria->id_categoria }}">
                                                        {{ $categoria->categoria }}</option>
                                                @endforeach
                                            </select>
                                            <label for="id_categoria">Categoría</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="edit_id_clase" name="id_clase" class="select2 form-select">
                                                <option value="" disabled selected>Selecciona una clase</option>
                                                @foreach ($clases as $clase)
                                                    <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                                @endforeach
                                            </select>
                                            <label for="id_clase">Clase</label>
                                        </div>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_proforma_predio"
                                                name="proforma_predio" placeholder="Proforma del predio">
                                            <label for="proforma_predio">Proforma del predio</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_folio_fq"
                                                name="folio_fq" placeholder="Análisis Fisicoquímicos">
                                            <label for="folio_fq">Análisis Fisicoquímicos</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select id="edit_id_tipo" name="id_tipo[]" class="select2 form-select mb-4"
                                                multiple>
                                                @foreach ($tipos as $tipo)
                                                    <option value="{{ $tipo->id_tipo }}">
                                                        {{ $tipo->nombre }}
                                                        ({{ $tipo->cientifico }})
                                                    </option>
                                                @endforeach
                                            </select>{{-- </span> --}}
                                            <label for="edit_id_tipo" class="form-label">Tipos de agave</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                  <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_alc_vol" name="alc_vol"
                                                placeholder="% Alc. Vol.">
                                            <label for="alc_vol">% Alc. Vol.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_sku" name="sku"
                                                placeholder="SKU">
                                            <label for="sku">SKU</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" min="0" class="form-control"
                                                id="edit_cantidad_botellas_cajas" name="cantidad_botellas_cajas"
                                                placeholder="Cantidad de botellas/cajas">
                                            <label for="cantidad_botellas_cajas">Cantidad de botellas/cajas</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                  <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_edad" name="edad"
                                                placeholder="Edad">
                                            <label for="edad">Edad</label>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input class="form-control" id="edit_ingredientes" name="ingredientes"
                                                placeholder="Ingredientes">
                                            <label for="ingredientes">Ingredientes</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="edit_cant_cajas_inicial"
                                                name="cant_cajas_inicial" placeholder="Cantidad de cajas inicial"
                                                aria-label="Cantidad de cajas inicial">
                                            <label for="cant_cajas_inicial">Cantidad de cajas inicial</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="edit_cant_bot_inicial"
                                                name="cant_bot_inicial" placeholder="Cantidad de botellas inicial"
                                                aria-label="Cantidad de botellas inicial">
                                            <label for="cant_bot_inicial">Cantidad de botellas inicial</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- Entradas --}}
                    <div id="editDisplayEntradas">
                        <div class="card mt-4 mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                ENTRADAS
                            </div>
                            {{-- <h6></h6> --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_procedencia_entrada"
                                                name="procedencia_entrada" placeholder="Procedencia entrada"
                                                aria-label="Procedencia entrada">
                                            <label for="edit_procedencia_entrada">Procedencia de la entrada</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="edit_cant_cajas_entrada"
                                                name="cant_cajas_entrada" placeholder="Cantidad de cajas"
                                                aria-label="Cantidad de cajas">
                                            <label for="edit_cant_cajas_entrada">Cantidad de cajas</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="edit_cant_bot_entrada"
                                                name="cant_bot_entrada" placeholder="Cantidad de botellas"
                                                aria-label="Cantidad de botellas">
                                            <label for="edit_cant_bot_entrada">Cantidad de botellas</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Salidas -->
                    <div id="editDisplaySalidas">
                        <div class="card mt-4 mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                SALIDAS
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_destino_salidas"
                                                name="destino_salidas" placeholder="Destino" aria-label="Destino">
                                            <label for="edit_destino_salidas">Destino</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="edit_cant_cajas_salidas"
                                                name="cant_cajas_salidas" placeholder="Cantidad de cajas"
                                                aria-label="Cantidad de cajas">
                                            <label for="edit_cant_cajas_salidas">Cantidad de cajas</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="edit_cant_bot_salidas"
                                                name="cant_bot_salidas" placeholder="Cantidad de botellas"
                                                aria-label="Cantidad de botellas">
                                            <label for="edit_cant_bot_salidas">Cantidad de botellas</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Inventario Final -->
                    <div>
                        <div class="card mt-4 mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                INVENTARIO FINAL
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="edit_cant_cajas_final"
                                                name="cant_cajas_final" placeholder="Cantidad de cajas"
                                                aria-label="Cantidad de cajas">
                                            <label for="edit_cant_cajas_final">Cantidad de cajas</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="edit_cant_bot_final"
                                                name="cant_bot_final" placeholder="Cantidad de botellas"
                                                aria-label="Cantidad de botellas">
                                            <label for="edit_cant_bot_final">Cantidad de botellas</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_id_solicitante"
                                                name="id_solicitante" placeholder="Nombre del solicitante"
                                                aria-label="Nombre del solicitante" required>
                                            <label for="edit_nombre_solicitante">Nombre del solicitante</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_capacidad"
                                                name="capacidad" placeholder="Capacidad" aria-label="Capacidad"
                                                required>
                                            <label for="edit_capacidad">Capacidad</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_mermas"
                                                name="mermas" placeholder="Mermas" aria-label="Mermas" required>
                                            <label for="edit_mermas">Mermas</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <textarea class="form-control" id="edit_observaciones" name="observaciones" rows="3"
                                        placeholder="Escribe observaciones"></textarea>
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


    function editObtenerDatosGraneles() {
        var lote_granel_id = $("#id_lote_granel").val();
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
            $.ajax({
                url: '/getDatos2/' + lote_granel_id,
                method: 'GET',
                success: function(response) {
                    // Setear valores para los campos individuales
                    $('#volumen_inicial').val(response.lotes_granel.volumen_restante);
                    $('#alcohol_inicial').val(response.lotes_granel.cont_alc);
                    $('#folio_fq').val(response.lotes_granel.folio_fq);
                },
                error: function() {
                    console.error('Error al obtener datos de graneles');
                }
            });
        } else {
            $('#volumen_inicial').val('');
            $('#alcohol_inicial').val('');
            $('#folio_fq').val('');
        }
         }


function obtenerInstalacionEdit() {
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
