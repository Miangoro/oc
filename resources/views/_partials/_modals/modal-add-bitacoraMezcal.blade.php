<div class="modal fade" id="RegistrarBitacoraMezcal" tabindex="-1" aria-labelledby="registroInventarioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBitacora">Agregar Bitácora</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="registroInventarioForm" action="/ruta-de-envio" method="POST">
                    @csrf
                    <!-- Datos Iniciales -->
                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <select {{-- onchange="obtenerDatosEmpresa()" --}} id="id_empresa" name="id_empresa"
                                    class="select2 form-select" data-error-message="por favor selecciona la empresa">
                                    <option value="" disabled selected>Selecciona el cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}</option>
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_empresa" class="form-label">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-4 b-3">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control datepicker" id="fecha" name="fecha"
                                    aria-label="Fecha" readonly>
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="lote_granel" name="lote_granel"
                                    placeholder="Lote a Granel" aria-label="Lote a Granel" required>
                                <label for="lote_granel">Lote a Granel</label>
                            </div>
                        </div>
                    </div>

                    <!-- Salidas -->
                    <div class="form-section mb-5 p-3 border rounded">
                        <h6>SALIDAS</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="volumen_salida" name="volumen_salida"
                                        placeholder="Volumen" aria-label="Volumen" required>
                                    <label for="volumen_salida">Volumen</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" step="0.01" class="form-control" id="alc_vol_salida"
                                        name="alc_vol_salida" placeholder="% Alc. Vol." aria-label="% Alc. Vol."
                                        required>
                                    <label for="alc_vol_salida">% Alc. Vol.</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="destino" name="destino"
                                        placeholder="Destino" aria-label="Destino" required>
                                    <label for="destino">Destino</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventario Final -->
                    <div class="form-section mb-5 p-3 border rounded">
                        <h6>INVENTARIO FINAL</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="volumen_final" name="volumen_final"
                                        placeholder="Volumen" aria-label="Volumen" required>
                                    <label for="volumen_final">Volumen</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" step="0.01" class="form-control" id="alc_vol_final"
                                        name="alc_vol_final" placeholder="% Alc. Vol." aria-label="% Alc. Vol."
                                        required>
                                    <label for="alc_vol_final">% Alc. Vol.</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="mb-3">
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"
                            placeholder="Escribe observaciones"></textarea>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Registrar</button>
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
