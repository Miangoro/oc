<!-- Modal -->
<div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div style="border-bottom: 2px solid #E0E1E3; background-color: aliceblue;">
                <div class="modal-header" style="margin-bottom: 20px;">
                    <h5 class="modal-title custom-title" id="modalFullTitle" style="font-weight: bold;">
                        REVISION POR PARTE DEL PERSONAL DEL OC PARA LA DECISION DE LA CERTIFICACION (INSTALACIONES)
                        <span id="revisorName" style="font-weight: normal; margin-left: 10px; color: #D29F42; text-transform: uppercase; font-weight: bold;"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body d-flex" style="overflow-x: hidden;">
                <!-- Contenido Principal -->
                <div class="main-content" style="flex: 1; padding: 15px; height: 100vh; display: flex; flex-direction: column; gap: 10px; margin-top: -20px;">
                    <!-- Contenedor para las tablas -->
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <!-- Primera Tabla -->
                        <div class="table-container" style="flex: 1; min-width: 250px;">
                            <table class="table table-sm table-bordered table-hover table-striped" style="font-size: 11px;">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="4" scope="col" style="font-size: 11px; text-align: center;">Información del Certificado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2">TIPO DE CERTIFICADO</td>
                                        <td colspan="2" id="tipoCertificado">N/A</td> <!-- Asegúrate de que el ID coincida con el que usaste en JavaScript -->
                                    </tr>
                                    <tr>
                                        <td colspan="2">NO. CERTIFICADO</td>
                                        <td colspan="2" id="numCertificado"></td> <!-- Aquí puedes agregar el ID para el contenido -->
                                    </tr>
                                    <tr>
                                        <td colspan="2">NO. DICTAMEN</td>
                                        <td colspan="2" id="numDictamen"></td> <!-- Aquí puedes agregar el ID para el contenido -->
                                    </tr>
                                    <tr>
                                        <td>FECHA DE VIGENCIA</td>
                                        <td id="fechaVigencia"></td> <!-- Aquí puedes cambiar por la fecha de emisión -->
                                        <td>FECHA DE VENCIMIENTO</td>
                                        <td id="fechaVencimiento"></td> <!-- Aquí puedes cambiar por la fecha de vigencia -->
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>

                        <!-- Segunda Tabla -->
                        <div class="table-container" style="flex: 1; min-width: 250px;">
                            <table class="table table-sm table-bordered table-hover table-striped" style="font-size: 11px;">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="2" scope="col" style="font-size: 11px; text-align: center;">Detalles Adicionales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>---</td>
                                        <td>---</td>
                                    </tr>
                                    <tr>
                                        <td>---</td>
                                        <td>---</td>
                                    </tr>
                                    <tr>
                                        <td>---</td>
                                        <td>---</td>
                                    </tr>
                                    <tr>
                                        <td>---</td>
                                        <td>---</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <!-- Primera Tabla -->
                        <div class="table-container" style="flex: 1; min-width: 250px;">
                            <table class="table table-sm table-bordered table-hover table-striped" style="font-size: 12px;">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="font-size: 11px;">#</th>
                                        <th style="font-size: 11px;">DOCUMENTOS</th>
                                        <th style="font-size: 11px;">Elige la respuesta</th>
                                        <th style="font-size: 11px;">Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Documento 1</td>
                                        <td>
                                            <select class="form-select" aria-label="Elige la respuesta">
                                                <option selected>Selecciona</option>
                                                <option value="1">Opción 1</option>
                                                <option value="2">Opción 2</option>
                                            </select>
                                        </td>
                                        <td>Observación 1</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Documento 2</td>
                                        <td>
                                            <select class="form-select" aria-label="Elige la respuesta">
                                                <option selected>Selecciona</option>
                                                <option value="1">Opción 1</option>
                                                <option value="2">Opción 2</option>
                                            </select>
                                        </td>
                                        <td>Observación 2</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Documento 3</td>
                                        <td>
                                            <select class="form-select" aria-label="Elige la respuesta">
                                                <option selected>Selecciona</option>
                                                <option value="1">Opción 1</option>
                                                <option value="2">Opción 2</option>
                                            </select>
                                        </td>
                                        <td>Observación 3</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Documento 4</td>
                                        <td>
                                            <select class="form-select" aria-label="Elige la respuesta">
                                                <option selected>Selecciona</option>
                                                <option value="1">Opción 1</option>
                                                <option value="2">Opción 2</option>
                                            </select>
                                        </td>
                                        <td>Observación 4</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Documento 5</td>
                                        <td>
                                            <select class="form-select" aria-label="Elige la respuesta">
                                                <option selected>Selecciona</option>
                                                <option value="1">Opción 1</option>
                                                <option value="2">Opción 2</option>
                                            </select>
                                        </td>
                                        <td>Observación 5</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Documento 6</td>
                                        <td>
                                            <select class="form-select" aria-label="Elige la respuesta">
                                                <option selected>Selecciona</option>
                                                <option value="1">Opción 1</option>
                                                <option value="2">Opción 2</option>
                                            </select>
                                        </td>
                                        <td>Observación 6</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Segunda Tabla -->
                        <div class="table-container" style="flex: 1; min-width: 250px;">
                            <table class="table table-sm table-bordered table-hover table-striped" style="font-size: 11px;">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="2" scope="col" style="font-size: 11px; text-align: center;">Detalles Adicionales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>---</td>
                                        <td>---</td>
                                    </tr>
                                    <tr>
                                        <td>---</td>
                                        <td>---</td>
                                    </tr>
                                    <tr>
                                        <td>---</td>
                                        <td>---</td>
                                    </tr>
                                    <tr>
                                        <td>---</td>
                                        <td>---</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
                
        </div>
    </div>
</div>
