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
                                        <td colspan="2" id="tipoCertificado">N/A</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">NO. CERTIFICADO</td>
                                        <td colspan="2" id="numCertificado"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">NO. DICTAMEN</td>
                                        <td colspan="2" id="numDictamen"></td>
                                    </tr>
                                    <tr>
                                        <td>FECHA DE VIGENCIA</td>
                                        <td id="fechaVigencia"></td>
                                        <td>FECHA DE VENCIMIENTO</td>
                                        <td id="fechaVencimiento"></td>
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
                                        <td>CERTIFICADO INSTALACIONES</td>
                                        <td>
                                            <i class="ri-file-pdf-2-fill text-danger ri-30px pdf cursor-pointer" 
                                               data-bs-target="#PdfDictamenIntalaciones" 
                                               data-tipo="" 
                                               data-id="" 
                                               data-registro="" 
                                               style="cursor: pointer;" 
                                               id="pdfIcon"></i>
                                        </td>
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

                        <!-- Tercera Tabla -->
                    <div style="border: 1px solid #8DA399; padding: 20px; border-radius: 5px;">
                        <h5 style="font-size: 1.25rem; color: #2c3e50; font-weight: bold; margin: 20px 0;">
                            REVISION POR PARTE DEL PERSONAL OC PARA LA DECISION DE LA CERTIFICACION
                        </h5>
    
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
                                            <td>CERTIFICADO INSTALACIONES</td>
                                            <td>
                                                <select class="form-select form-select-sm" aria-label="Elige la respuesta">
                                                    <option selected>Selecciona</option>
                                                    <option value="1">C</option>
                                                    <option value="2">NC</option>
                                                    <option value="3">NA</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control" id="floatingInput" placeholder="John Doe" aria-describedby="floatingInputHelp" />
                                                    <label for="floatingInput">Observaciones</label>
                                                  </div>                                 
                                            </td>
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
</div>
