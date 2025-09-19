<div class="modal fade" id="RegistrarBitacoraMezcal" tabindex="-1" aria-labelledby="registroInventarioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="addBitacora">Registrar bitácora de inventario de producto terminado
                    (Envasador)</h5>
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
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select  id="id_empresa" onchange="cargarInstalaciones();"
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
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control datepicker" id="fecha"
                                                name="fecha"  placeholder="aaaa-mm-dd">
                                            <label for="fecha">Fecha</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="tipo_op" name="tipo_operacion" class=" form-select"
                                                data-error-message="Por favor selecciona el tipo de operación">
                                                <option class="bg-light" value="" disabled selected>Selecciona
                                                    el
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
                                </div>

                                <!-- NUEVOS CAMPOS AGREGADOS -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select class="form-select select2" id="lote_granel"
                                                name="lote_granel" onchange="obtenerDatosGraneles();">
                                                <option value="" disabled selected>Selecciona un lote a granel
                                                </option>
                                            </select>
                                            <label for="id_lote_granel">Lote a granel</label>
                                        </div>
                                    </div>
                                     <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select class="form-select select2" id="lote_envasado" onchange="obtenerDatosGranelesInspecciones();"
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
                                            <select id="id_instalacion" name="id_instalacion"
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
                                            <select id="id_marca" name="id_marca" class="select2 form-select">
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
                                            <select id="id_categoria" name="id_categoria" class="select2 form-select">
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
                                            <select id="id_clase" name="id_clase" class="select2 form-select">
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
                                            <input type="text" class="form-control" id="proforma_predio"
                                                name="proforma_predio" placeholder="Proforma del predio">
                                            <label for="proforma_predio">Proforma del predio</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="folio_fq"
                                                name="folio_fq" placeholder="Análisis Fisicoquímicos">
                                            <label for="folio_fq">Análisis Fisicoquímicos</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select id="id_tipo" name="id_tipo[]" class="select2 form-select mb-4"
                                                multiple >
                                                @foreach ($tipos as $tipo)
                                                    <option value="{{ $tipo->id_tipo }}">
                                                        {{ $tipo->nombre }}
                                                        ({{ $tipo->cientifico }})
                                                    </option>
                                                @endforeach
                                            </select>{{-- </span> --}}
                                            <label for="id_tipo" class="form-label">Tipos de agave</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="alc_vol" name="alc_vol"
                                                placeholder="% Alc. Vol.">
                                            <label for="alc_vol">% Alc. Vol.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="sku" name="sku"
                                                placeholder="SKU">
                                            <label for="sku">SKU</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" min="0" class="form-control"
                                                id="cantidad_botellas_cajas" name="cantidad_botellas_cajas"
                                                placeholder="Cantidad de botellas/cajas">
                                            <label for="cantidad_botellas_cajas">Cantidad de botellas/cajas</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edad" name="edad"
                                                placeholder="Edad">
                                            <label for="edad">Edad</label>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input class="form-control" id="ingredientes" name="ingredientes"
                                                placeholder="Ingredientes">
                                            <label for="ingredientes">Ingredientes</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="cant_cajas_inicial"
                                                name="cant_cajas_inicial" placeholder="Cantidad de cajas inicial"
                                                aria-label="Cantidad de cajas inicial">
                                            <label for="cant_cajas_inicial">Cantidad de cajas inicial</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="cant_bot_inicial"
                                                name="cant_bot_inicial" placeholder="Cantidad de botellas inicial"
                                                aria-label="Cantidad de botellas inicial">
                                            <label for="cant_bot_inicial">Cantidad de botellas inicial</label>
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="procedencia_entrada"
                                                name="procedencia_entrada" placeholder="Procedencia entrada"
                                                aria-label="Procedencia entrada">
                                            <label for="procedencia_entrada">Procedencia de la entrada</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="cant_cajas_entrada"
                                                name="cant_cajas_entrada" placeholder="Cantidad de cajas"
                                                aria-label="Cantidad de cajas">
                                            <label for="cant_cajas_entrada">Cantidad de cajas</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="cant_bot_entrada"
                                                name="cant_bot_entrada" placeholder="Cantidad de botellas"
                                                aria-label="Cantidad de botellas">
                                            <label for="cant_bot_entrada">Cantidad de botellas</label>
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
                                    <div class="col-md-12 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="destino_salidas"
                                                name="destino_salidas" placeholder="Destino" aria-label="Destino">
                                            <label for="destino_salidas">Destino</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="cant_cajas_salidas"
                                                name="cant_cajas_salidas" placeholder="Cantidad de cajas"
                                                aria-label="Cantidad de cajas">
                                            <label for="cant_cajas_salidas">Cantidad de cajas</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="cant_bot_salidas"
                                                name="cant_bot_salidas" placeholder="Cantidad de botellas"
                                                aria-label="Cantidad de botellas">
                                            <label for="cant_bot_salidas">Cantidad de botellas</label>
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
                                            <input type="number" class="form-control" id="cant_cajas_final"
                                                name="cant_cajas_final" placeholder="Cantidad de cajas"
                                                aria-label="Cantidad de cajas">
                                            <label for="cant_cajas_final">Cantidad de cajas</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" id="cant_bot_final"
                                                name="cant_bot_final" placeholder="Cantidad de botellas"
                                                aria-label="Cantidad de botellas">
                                            <label for="cant_bot_final">Cantidad de botellas</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="id_solicitante"
                                                name="id_solicitante" placeholder="Nombre del solicitante"
                                                aria-label="Nombre del solicitante" required>
                                            <label for="nombre_solicitante">Nombre del solicitante</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="capacidad"
                                                name="capacidad" placeholder="Capacidad" aria-label="Capacidad"
                                                required>
                                            <label for="capacidad">Capacidad</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="mermas" name="mermas"
                                                placeholder="Mermas" aria-label="Mermas" required>
                                            <label for="mermas">Mermas</label>
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

    function obtenerDatosGraneles() {
        var lote_granel_id = $("#lote_granel").val();
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
            $.ajax({
                url: '/getDatos2/' + lote_granel_id,
                method: 'GET',
                success: function(response) {
                    // Setear valores para los campos individuales
                    $('#volumen_inicial').val(response.lotes_granel.volumen_restante);
                    $('#alc_vol').val(response.lotes_granel.cont_alc);
                    $('#folio_fq').val(response.lotes_granel.folio_fq);
                    $('#edad').val(response.lotes_granel.edad);
                    $('#ingredientes').val(response.lotes_granel.ingredientes);
                    $('#id_tipo').val('');
                   if (Array.isArray(response.tipo)) {
                    response.tipo.forEach(t => {
                        $('#id_tipo').append(
                            $('<option>', {
                                value: t.id_tipo,
                                text: `${t.nombre} (${t.cientifico})`,
                                selected: true // si deseas marcarlo automáticamente
                            })
                        );
                    });
                }

                  $('#id_tipo').trigger('change');
                     // Categoría
                if (response.lotes_granel.categoria) {
                    $('#id_categoria').val(response.lotes_granel.categoria.id_categoria).trigger('change');
                } else {
                    $('#id_categoria').val('').trigger('change');
                }

                // Clase
                if (response.lotes_granel.clase) {
                    $('#id_clase').val(response.lotes_granel.clase.id_clase).trigger('change');
                } else {
                    $('#id_clase').val('').trigger('change');
                }

                },
                error: function() {
                    console.error('Error al obtener datos de graneles');
                }
            });
        } else {;
            $('#volumen_inicial, #alc_vol, #folio_fq, #edad, #ingredientes').val('');
             $('#id_tipo, #id_categoria, #id_clase').val('').trigger('change');
        }
    }

     function obtenerDatosGranelesInspecciones() {
    var lote_envasado_id = $("#lote_envasado").val();
    if (lote_envasado_id !== "" && lote_envasado_id !== null && lote_envasado_id !== undefined) {

        $.ajax({
            url: '/getDatosLoteEnvasado/' + lote_envasado_id,
            method: 'GET',
            success: function(response) {
                const lotes_envasado = response.lotes_envasado || {};
                const skuLimpio = limpiarSku(lotes_envasado.sku);
                $('#sku').val(skuLimpio);

                $('#cantidad_botellas_cajas').val(lotes_envasado.cant_botellas || '');
            },
            error: function() {
                console.error('Error al obtener los datos del lote granel.');
                $('#sku').val();
                $('#cantidad_botellas_cajas').val();
            }
        });
    }
}

function limpiarSku(sku) {
    try {
        const parsed = JSON.parse(sku);
        if (parsed && typeof parsed === 'object' && parsed.inicial) {
            return parsed.inicial;
        }
        return 'Sin definir';
    } catch (e) {
        return 'Sin definir';
    }
}
 function cargarInstalaciones() {
        var empresa = $("#id_empresa").val();
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatosBitacora/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido =
                    '<option value="" disabled selected>Seleccione una instalación</option>';

                    for (let index = 0; index < response.instalaciones.length; index++) {
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);

                        contenido += '<option value="' + response.instalaciones[index].id_instalacion +
                            '">' + tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>';
                    }

                    if (response.instalaciones.length == 0) {
                        contenido = '<option value="">Sin instalaciones registradas</option>';
                    }

                    $('#id_instalacion').html(contenido);
                },
                error: function() {}
            });
        }
    }


    function limpiarTipo(tipo) {
        try {
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            return tipo;
        }
    }
</script>


