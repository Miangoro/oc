<div class="modal fade" id="editarBitacoraMezcal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="editBitacora">Editar Bitácora de hologramas (Envasador)</h5>
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select onchange="obtenerGranelesEdit(this.value);" id="edit_id_empresa"
                                                name="id_empresa" class="select2 form-select"
                                                data-error-message="por favor selecciona la empresa">
                                                <option value="" disabled selected>Selecciona el cliente</option>
                                                @foreach ($empresas as $empresa)
                                                    <option value="{{ $empresa->id_empresa }}">
                                                        {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                                        | {{ $empresa->razon_social }}</option>
                                                @endforeach
                                            </select>
                                            <label for="id_empresa" class="form-label">Cliente</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control datepicker" id="edit_fecha" placeholder="Fecha"
                                                name="fecha" aria-label="Fecha">
                                            <label for="fecha">Fecha</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select id="edit_tipo_op" name="tipo_operacion" class=" form-select"
                                                data-error-message="Por favor selecciona el tipo de operación">
                                                <option value="" disabled selected>Selecciona el tipo de operación
                                                </option>
                                                <option value="Entradas">Entradas</option>
                                                <option value="Salidas">Salidas</option>
                                                <option value="Entradas y salidas">Entradas y salidas</option>
                                            </select>
                                            <label for="tipo_op">Tipo de operación</label>
                                        </div>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select id="edit_id_lote_envasado" name="id_lote_envasado"
                                                class="select2 form-select">
                                                <option value="">Selecciona un lote envasado</option>
                                            </select>
                                            <label for="id_lote_envasado">Lote envasado</label>
                                        </div>
                                    </div>
                                </div>
                                {{--                                 <div class="row">


                                </div> --}}

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_serie_inicial"
                                                name="serie_inicial" placeholder="Serie inicial"
                                                aria-label="serie inicial">
                                            <label for="serie_inicial">Serie inicial</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_num_sellos_inicial"
                                                name="num_sellos_inicial" placeholder="Número de sellos inicial"
                                                aria-label="N° de sellos inicial">
                                            <label for="num_sellos_inicial">N° de sellos inicial</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Entradas / Operaciones Adicionales -->
                    <div id="editDisplayEntradas">
                        <div class="card mt-4 mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                ENTRADAS
                            </div>
                            {{-- <h6></h6> --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_serie_entrada"
                                                name="serie_entrada" placeholder="Serie entrada"
                                                aria-label="Serie entrada">
                                            <label for="serie_entrada">Serie entrada</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="edit_num_sellos_entrada" name="num_sellos_entrada"
                                                placeholder="N° de sellos entrada" aria-label="N° DE SELLOS entrada">
                                            <label for="num_sellos_entrada">N° de sellos entrada</label>
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
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_serie_salida"
                                                name="serie_salida" placeholder="Serie salida"
                                                aria-label="Serie salida" required>
                                            <label for="serie_salida">Serie salidas</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_num_sellos_salida"
                                                name="num_sellos_salida" placeholder="N° de sellos  Salida"
                                                aria-label="N° de sellos  Salida" required>
                                            <label for="num_sellos_salida">N° de sellos salidas</label>
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
                                            <input type="text" class="form-control" id="edit_serie_final"
                                                name="serie_final" placeholder="Serie final" aria-label="Serie final"
                                                required>
                                            <label for="serie_final">Serie final</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="1" class="form-control"
                                                id="edit_num_sellos_final" name="num_sellos_final"
                                                placeholder="N° de sellos final" aria-label="N° de sellos final"
                                                required>
                                            <label for="num_sellos_final">N° de sellos final</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card mt-4 mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-warning fw-bold fs-6 px-4 py-4 mb-5">
                                MERMAS
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_serie_merma"
                                                name="serie_merma" placeholder="Serie merma"
                                                aria-label="Serie merma">
                                            <label for="serie_merma">Serie merma</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="1" class="form-control"
                                                id="edit_num_sellos_merma" name="num_sellos_merma"
                                                placeholder="N° de sellos merma" aria-label="N° de sellos merma">
                                            <label for="num_sellos_merma">N° de sellos merma</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
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
    function obtenerGranelesEdit(empresa) {
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatosBitacora/' + empresa,
                method: 'GET',
                success: function(response) {
                var contenido = "";
                for (let index = 0; index < response.lotes_envasado.length; index++) {
                    const lote = response.lotes_envasado[index];
                    const nombre = lote.nombre ?? 'Sin nombre';
                    const botellas = lote.cant_botellas ?? 0;
                    contenido += `<option value="${lote.id_lote_envasado}">${nombre} | Botellas: ${botellas}</option>`;
                }

                if (response.lotes_envasado.length === 0) {
                    contenido = '<option value="">Sin lotes registrados</option>';
                }

                    $('#edit_id_lote_envasado').html(contenido);

                    $('#edit_id_lote_envasado').html(contenido);
                    const idlote = $('#edit_id_lote_envasado').data('selected');
                    if (idlote) {
                        $('#edit_id_lote_envasado').val(idlote).trigger('change');
                    }

                      var contenidoI = '<option value="" disabled>Seleccione una instalación</option>';
                var instalacion_id = $("#edit_id_instalacion").data('selected') || "";

                for (let index = 0; index < response.instalaciones.length; index++) {
                    var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);
                    var seleccionado = (instalacion_id == response.instalaciones[index].id_instalacion) ? "selected" : "";

                    contenidoI += '<option ' + seleccionado + ' value="' + response.instalaciones[index].id_instalacion + '">' +
                        tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                        '</option>';
                }

                if (response.instalaciones.length == 0) {
                    contenidoI = '<option value="">Sin instalaciones registradas</option>';
                }

                $('#edit_id_instalacion').html(contenidoI);

                // Si hay un valor seleccionado, aplicarlo después de insertar las opciones
                if (instalacion_id) {
                    $('#edit_id_instalacion').val(instalacion_id).trigger('change');
                }

                },
                error: function() {}
            });
        }
    }

    function limpiarTipo(tipo) {
        try {
            let tipoArray = JSON.parse(tipo);
            return tipoArray.join(', ');
        } catch (error) {
            return tipo;
        }
    }
</script>
