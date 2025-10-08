<!-- Modal para agregar documentación del cliente prospecto -->
<div class="modal fade" id="modalSubirDocumentacion" tabindex="-1" aria-labelledby="modalDocLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDocLabel">Documentación General</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formDocumentacionProspecto" enctype="multipart/form-data">
                    @csrf
                    <input type="" id="prospecto_id_doc" name="prospecto_id">

                    <div class="table-responsive ">
                        <table class="table table-hover table-striped">
                            <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Descripción del Documento</th>
                                    <th scope="col" class="text-center">Subir Archivo</th>
                                    <th scope="col" class="text-center">Documento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Fila 1 -->
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Acta constitutiva (Copia simple)</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_acta_constitutiva">
                                    </td>
                                    <td class="text-center">
                                        <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <!-- Fila 2 -->
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Poder notarial del representante legal (Solo en caso de no estar incluido en el acta constitutiva)</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_poder_notarial">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <!-- Fila 3 -->
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Copia de identificación oficial del Titular (en caso de ser persona física) o representante legal (en caso de ser persona moral).</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_identificacion_oficial">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <!-- Fila 4 -->
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Comprobante del domicilio fiscal</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_domicilio_fiscal">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                 <!-- Fila 5 -->
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Contrato de prestación de servicios (Proporcionado por el OCP del CIDAM)</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_contrato_servicios">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <!-- Fila 6 -->
                                <tr>
                                    <th scope="row">6</th>
                                    <td>Carta de designación de persona autorizada para realizar los trámites.</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_carta_designacion">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <!-- Fila 7 -->
                                <tr>
                                    <th scope="row">7</th>
                                    <td>Constancia de situación fiscal</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_situacion_fiscal">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <!-- Fila 8 -->
                                <tr>
                                    <th scope="row">8</th>
                                    <td>Carta de asignación de número de cliente</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_carta_asignacion">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <!-- Fila 9 -->
                                <tr>
                                    <th scope="row">9</th>
                                    <td>Solicitud de información al cliente</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_solicitud_informacion">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <!-- Fila 10 -->
                                <tr>
                                    <th scope="row">10</th>
                                    <td>Copia de identificación oficial vigente de la persona autorizada</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_identificacion_autorizada">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                 <!-- Fila 11 -->
                                 <tr>
                                    <th scope="row">11</th>
                                    <td>Convenio de corresponsabilidad inscrito ante el IMPI entre el comercializador y un productor autorizado</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_convenio_corresponsabilidad">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                 <!-- Fila 12 -->
                                 <tr>
                                    <th scope="row">12</th>
                                    <td>Requisitos a evaluar NOM-070-SCFI-2016</td>
                                    <td>
                                        <input type="file" class="form-control" name="doc_requisitos_nom_070">
                                    </td>
                                    <td class="text-center">
                                         <a href="#" target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarDocumentacion">Guardar Documentos</button>
            </div>
        </div>
    </div>
</div>

