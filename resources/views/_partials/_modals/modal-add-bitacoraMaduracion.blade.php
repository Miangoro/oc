<div class="modal fade" id="RegistrarBitacoraMezcal" tabindex="-1" aria-labelledby="registroInventarioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="addBitacora">Agregar Bitácora de maduración</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-8">
                <form id="registroInventarioForm" method="POST">
                    @csrf
                    <div>
                        <div class="card mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                DATOS INICIALES
                            </div>
                            <!-- Datos Iniciales -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select onchange="obtenerGraneles(this.value);" id="id_empresa"
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
                                            <label for="id_empresa" class="form-label">Cliente</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select class=" form-select select2" id="id_instalacion"
                                                name="id_instalacion" aria-label="id_instalacion">
                                                <option value="" disabled selected>Lista de instalaciones</option>
                                                <!-- Aquí se llenarán las opciones con instalaciones del cliente -->
                                            </select>
                                            <label for="id_instalacion" class="form-label">Instalaciones</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                  <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control datepicker" id="fecha"
                                                name="fecha" aria-label="Fecha" placeholder="Fecha" autocomplete="off">
                                            <label for="fecha">Fecha</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="tipo_op" name="tipo_operacion" class=" form-select"
                                                data-error-message="Por favor selecciona el tipo de operación">
                                                <option class="bg-light" value="" disabled selected>Selecciona el
                                                    tipo
                                                    de
                                                    operación</option>
                                                <option value="Entradas">Entradas</option>
                                                <option value="Salidas">Salidas</option>
                                                <option value="Entradas y salidas">Entradas y salidas</option>
                                            </select>
                                            <label for="tipo_op">Tipo de operación</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="id_lote_granel" name="id_lote_granel"
                                                class="select2 form-select" onchange="obtenerDatosGraneles();">
                                                <option value="" disabled selected>Selecciona un lote</option>
                                            </select>
                                            <label for="id_lote_granel">Lote a granel</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="tipo_recipientes"
                                                name="tipo_recipientes" placeholder="Tipo de recipientes"
                                                aria-label="Tipo de recipientes">
                                            <label for="tipo_recipientes">Tipo de recipientes</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="tipo_madera"
                                                name="tipo_madera" placeholder="Tipo de madera"
                                                aria-label="Tipo de madera">
                                            <label for="tipo_madera">Tipo de madera</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="num_recipientes"
                                                name="num_recipientes" placeholder="N° de recipientes"
                                                aria-label="N° de recipientes">
                                            <label for="num_recipientes">N° de recipientes</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="volumen_inicial"
                                                name="volumen_inicial" placeholder="Volumen inicial"
                                                aria-label="Volumen inicial">
                                            <label for="volumen_inicial">Volumen inicial</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="alcohol_inicial" name="alcohol_inicial"
                                                placeholder="% Alc. inicial" aria-label="% Alc. inicial">
                                            <label for="alcohol_inicial">% Alc. inicial</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Entradas / Operaciones Adicionales -->
                    <div id="displayEntradas">
                        <div class="card mt-4 mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                ENTRADAS
                            </div>
                            {{-- <h6></h6> --}}
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="procedencia_entrada"
                                                name="procedencia_entrada" placeholder="Procedencia entrada"
                                                aria-label="Procedencia entrada">
                                            <label for="procedencia_entrada">Procedencia de la entrada</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="num_recipientes_entrada"
                                                name="num_recipientes_entrada"
                                                placeholder="N° de recipientes de entrada"
                                                aria-label="N° de recipientes de entrada">
                                            <label for="num_recipientes_entrada">N° de recipientes de entrada</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="volumen_entrada"
                                                name="volumen_entrada" placeholder="Volumen entrada"
                                                aria-label="Volumen entrada">
                                            <label for="volumen_entrada">Volumen entrada</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="alcohol_entrada" name="alcohol_entrada"
                                                placeholder="% Alc. entrada" aria-label="% Alc. entrada">
                                            <label for="alcohol_entrada">% Alc. Vol. entrada</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Salidas -->
                    <div id="displaySalidas">
                        <div class="card mt-4 mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                SALIDAS
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control datepicker" id="fecha_salida"
                                                name="fecha_salida" placeholder="Fecha de salida"
                                                aria-label="Fecha de salida" autocomplete="off">
                                            <label for="fecha_salida">Fecha de salida</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="num_recipientes_salida"
                                                name="num_recipientes_salida"
                                                placeholder="N° de recipientes de salida"
                                                aria-label="N° de recipientes de salida">
                                            <label for="num_recipientes_salida">N° de recipientes de salida</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="volumen_salida"
                                                name="volumen_salida" placeholder="Volumen" aria-label="Volumen"
                                                required>
                                            <label for="volumen_salida">Volumen</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="alc_vol_salida" name="alc_vol_salida" placeholder="% Alc. Vol."
                                                aria-label="% Alc. Vol." required>
                                            <label for="alc_vol_salida">% Alc. Vol.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="destino_salidas" name="destino"
                                                placeholder="Destino" aria-label="Destino" required>
                                            <label for="destino">Destino</label>
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
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="num_recipientes_final"
                                                name="num_recipientes_final" placeholder="N° de recipientes"
                                                aria-label="N° de recipientes">
                                            <label for="num_recipientes_final">N° de recipientes</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="volumen_final"
                                                name="volumen_final" placeholder="Volumen" aria-label="Volumen"
                                                required>
                                            <label for="volumen_final">Volumen</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="alc_vol_final" name="alc_vol_final" placeholder="% Alc. Vol."
                                                aria-label="% Alc. Vol." required>
                                            <label for="alc_vol_final">% Alc. Vol.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"
                                        placeholder="Escribe observaciones"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- Observaciones -->


                    <!-- Botones -->
                    <div class="d-flex justify-content-center">
                        <button disabled class="btn btn-primary me-2 d-none" type="button" id="loading">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Registrando...
                        </button>
                        <button type="submit" class="btn btn-primary me-2" id="btnRegistrar"><i
                                class="ri-add-line me-1"></i>
                            Registrar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function obtenerGraneles(empresa) {
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatosBitacora/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido = '<option value="" disabled selected>Selecciona un lote</option>';
                    for (let index = 0; index < response.lotes_granel.length; index++) {
                        contenido += '<option value="' + response.lotes_granel[index].id_lote_granel +
                            '">' +
                            response.lotes_granel[index].nombre_lote + '</option>';
                    }
                    if (response.lotes_granel.length == 0) {
                        contenido = '<option value="">Sin lotes registrados</option>';
                    } else {}
                    $('#id_lote_granel').html(contenido);


                    var contenidoIns =
                    '<option value="" disabled selected>Seleccione una instalación</option>';

                    for (let index = 0; index < response.instalaciones.length; index++) {
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);

                        contenidoIns += '<option value="' + response.instalaciones[index].id_instalacion +
                            '">' + tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>';
                    }

                    if (response.instalaciones.length == 0) {
                        contenidoIns = '<option value="">Sin instalaciones registradas</option>';
                    }

                    $('#id_instalacion').html(contenidoIns);

                },
                error: function() {}
            });
        }
    }

    function obtenerDatosGraneles() {
    var lote_granel_id = $("#id_lote_granel").val();
    if (lote_granel_id) {
        $.ajax({
            url: '/getVolumenLoteBitacoraM/' + lote_granel_id,
            method: 'GET',
            success: function(response) {
                $('#volumen_inicial').val(response.volumen_final ?? '');
                $('#alcohol_inicial').val(response.alcohol_final ?? '');
            },
            error: function() {
                console.error('Error al obtener datos del lote o bitácora');
                $('#volumen_inicial').val('');
                $('#alcohol_inicial').val('');
            }
        });
    } else {
        $('#volumen_inicial').val('');
        $('#alcohol_inicial').val('');
    }
}
    function limpiarTipo(tipo) {
        try {
            let tipoArray = JSON.parse(tipo);
            return tipoArray.join(', ');
        } catch (error) {
            return tipo; // En caso de que no sea un JSON válido, regresamos el texto original
        }
    }
</script>
