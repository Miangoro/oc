<div class="modal fade" id="RegistrarBitacoraMezcal" tabindex="-1" aria-labelledby="registroInventarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
            <div class="modal-body">
                <form id="registroInventarioForm" action="/ruta-de-envio" method="POST">
                    @csrf

                    <!-- Datos Iniciales -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="date" class="form-control datepicker" id="fecha" name="fecha" aria-label="Fecha" readonly>
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="id_tanque" name="id_tanque" placeholder="ID del Tanque" aria-label="ID del Tanque" required>
                                <label for="id_tanque">ID del Tanque</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="lote_granel" name="lote_granel" placeholder="Lote a Granel" aria-label="Lote a Granel" required>
                                <label for="lote_granel">Lote a Granel</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="operacion_adicional" name="operacion_adicional" placeholder="Operación Adicional" aria-label="Operación Adicional">
                                <label for="operacion_adicional">Operación Adicional</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Categoría -->
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Categoría" aria-label="Categoría" required>
                                <label for="categoria">Categoría</label>
                            </div>
                        </div>
                    
                        <!-- Clase -->
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="clase" name="clase" placeholder="Clase" aria-label="Clase" required>
                                <label for="clase">Clase</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Ingrediente(s) -->
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="ingredientes" name="ingredientes" placeholder="Ingrediente(s)" aria-label="Ingrediente(s)" required>
                                <label for="ingredientes">Ingrediente(s)</label>
                            </div>
                        </div>
                    
                        <!-- Edad (Años) -->
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="number" class="form-control" id="edad" name="edad" placeholder="Edad (Años)" aria-label="Edad (Años)" required>
                                <label for="edad">Edad (Años)</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Tipo de Agave -->
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="tipo_agave" name="tipo_agave" placeholder="Tipo de Agave" aria-label="Tipo de Agave" required>
                                <label for="tipo_agave">Tipo de Agave</label>
                            </div>
                        </div>
                    
                        <!-- Número de Análisis Físicoquímico -->
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="num_analisis" name="num_analisis" placeholder="Número de Análisis Físicoquímico" aria-label="Número de Análisis Físicoquímico" required>
                                <label for="num_analisis">Número de Análisis Físicoquímico</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Número de Certificado -->
                        <div class="mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="num_certificado" name="num_certificado" placeholder="Número de Certificado" aria-label="Número de Certificado" required>
                                <label for="num_certificado">Número de Certificado</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Inventario Inicial -->
                    <div class="form-section mb-5 p-3 border rounded">
                        <h6>INVENTARIO INICIAL</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="volumen" name="volumen" placeholder="Volumen" aria-label="Volumen" required>
                                    <label for="volumen">Volumen</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="alc_vo" name="alc_vo" placeholder="% Alc. VO" aria-label="% Alc. VO" required>
                                    <label for="alc_vo">% Alc. VO</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Entrada -->
                    <div class="form-section mb-5 p-3 border rounded">
                        <h6>ENTRADA</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="procedencia" name="procedencia" placeholder="Procedencia" aria-label="Procedencia" required>
                                    <label for="procedencia">Procedencia</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="volumen" name="volumen" placeholder="Volumen" aria-label="Volumen" required>
                                    <label for="volumen">Volumen</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" step="0.01" class="form-control" id="alc_vol" name="alc_vol" placeholder="% Alc. Vol." aria-label="% Alc. Vol." required>
                                    <label for="alc_vol">% Alc. Vol.</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" step="0.01" class="form-control" id="agua" name="agua" placeholder="Agua" aria-label="Agua" required>
                                    <label for="agua">Agua</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Salidas -->
                    <div class="form-section mb-5 p-3 border rounded">
                        <h6>SALIDAS</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="volumen_salida" name="volumen_salida" placeholder="Volumen" aria-label="Volumen" required>
                                    <label for="volumen_salida">Volumen</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" step="0.01" class="form-control" id="alc_vol_salida" name="alc_vol_salida" placeholder="% Alc. Vol." aria-label="% Alc. Vol." required>
                                    <label for="alc_vol_salida">% Alc. Vol.</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="destino" name="destino" placeholder="Destino" aria-label="Destino" required>
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
                                    <input type="number" class="form-control" id="volumen_final" name="volumen_final" placeholder="Volumen" aria-label="Volumen" required>
                                    <label for="volumen_final">Volumen</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" step="0.01" class="form-control" id="alc_vol_final" name="alc_vol_final" placeholder="% Alc. Vol." aria-label="% Alc. Vol." required>
                                    <label for="alc_vol_final">% Alc. Vol.</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="mb-3">
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Escribe observaciones"></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="file" class="form-control" id="archivo" name="archivo" aria-label="Subir Archivo" required>
                            <label for="archivo">Subir Firma de la UI</label>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Registrar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>