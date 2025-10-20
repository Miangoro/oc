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
                    <input type="hidden" id="prospecto_id_doc" name="prospecto_id">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Descripción del Documento</th>
                                    <th scope="col" class="text-center">Subir Archivo</th>
                                    <th scope="col" class="text-center">Documento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Acta constitutiva (Copia simple)</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[1]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Poder notarial del representante legal (Solo en caso de no estar incluido en el
                                        acta constitutiva)</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[2]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Copia de identificación oficial del Titular (en caso de ser persona física) o
                                        representante legal (en caso de ser persona moral).</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[3]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Comprobante del domicilio fiscal</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[4]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Contrato de prestación de servicios (Proporcionado por el OCP del CIDAM)</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[5]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">6</th>
                                    <td>Carta de designación de persona autorizada para realizar los trámites.</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[33]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">7</th>
                                    <td>Constancia de situación fiscal</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[76]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">8</th>
                                    <td>Carta de asignación de número de cliente</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[77]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">9</th>
                                    <td>Solicitud de información al cliente</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[78]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">10</th>
                                    <td>Copia de identificación oficial vigente de la persona autorizada</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[79]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">11</th>
                                    <td>Convenio de corresponsabilidad inscrito ante el IMPI entre el comercializador y
                                        un productor autorizado</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[82]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">12</th>
                                    <td>Requisitos a evaluar NOM-070-SCFI-2016</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[126]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">14</th>
                                    <td>Plano de distribución</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[43]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">15</th>
                                    <td>Registro COFEPRIS</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[81]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">16</th>
                                    <td>Pre-registro de predios de maguey o agave</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[137]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">17</th>
                                    <td>Título de la marca</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[107]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">18</th>
                                    <td>Constancia de inscripción al Padrón de Bebidas Alcohólicas</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[62]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">139</th>
                                    <td>Contrato de prestación de servicios para la verificación de etiquetas</td>
                                    <td>
                                        <input type="file" class="form-control" name="documentos[139]">
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"><i class="fas fa-file-pdf text-danger fs-4"></i>--</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarDocumentacion">Guardar
                    Documentos</button>
            </div>
        </div>
    </div>
</div>
