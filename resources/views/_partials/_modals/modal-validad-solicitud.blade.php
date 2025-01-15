<div class="modal fade" id="addSolicitudValidar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Validación de la solicitud de servicio</h4>
                    <p id="tipoSolicitud" class="solicitud badge bg-primary fs-4"></p>
                    <div class="datos-importantes">
                       

                       


                    </div>
                </div>

                <div id="addRegistrarSolicitudValidar">
                  <!--  <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <span class="fs-6 fw-bold text-dark">Se cuenta con todos los medios para realizar
                                        todas las actividades de evaluación para la Certificación:</span>
                                    <p>
                                        <label>
                                            <input name="medios" type="radio" value="Si" />
                                            <span><strong>Sí</strong></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input name="medios" type="radio" value="No" />
                                            <span><strong>No</strong></span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <span class="fs-6 fw-bold text-dark">El organismo de Certificación tiene la
                                        competencia para realizar la Certificación:</span>
                                    <p>
                                        <label>
                                            <input name="competencia" type="radio" value="Si" />
                                            <span><strong>Sí</strong></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input name="competencia" type="radio" value="No" />
                                            <span><strong>No</strong></span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <span class="fs-6 fw-bold text-dark">El organismo de Certificación tiene la
                                        capacidad para llevar a cabo las actividades certificación:</span>
                                    <p>
                                        <label>
                                            <input name="capacidad" type="radio" value="Si" />
                                            <span><strong>Sí</strong></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input name="capacidad" type="radio" value="No" />
                                            <span><strong>No</strong></span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <span class="fs-6 fw-bold text-dark">¿La solicitud está completa?:</span>
                                    <p>
                                        <label>
                                            <input name="completa" type="radio" value="Si" />
                                            <span><strong>Sí</strong></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input name="completa" type="radio" value="No" />
                                            <span><strong>No</strong></span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>-->

                    <div id="muestreoAgave" class="d-none terminado">
                        <div class="datos-importantes">
                            <table style="font-size: 12px;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Razón
                                            Social:</th>
                                        <td class="razonSocial"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleRazonSocialEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio Fiscal:</th>
                                        <td class="domicilioFiscal"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioFiscalEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio de Instalaciones (Unidad de Producción Autorizada):
                                        </th>
                                        <td class="domicilioInstalacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha y
                                            Hora de Visita:</th>
                                        <td class="fechaHora"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleFechaHoraVisitaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Guías de traslado de agave:</th>
                                        <td class="guiasTraslado"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumple">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="vigilanciaProduccion" class="d-none terminado">
                        <div class="datos-importantes">
                            <table style="font-size: 12px;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Razón
                                            Social:</th>
                                        <td class="razonSocial"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleRazonSocialEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio Fiscal:</th>
                                        <td class="domicilioFiscal"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioFiscalEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio de Instalaciones (Unidad de Producción Autorizada):
                                        </th>
                                        <td class="domicilioInstalacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha y
                                            Hora de Visita:</th>
                                        <td class="fechaHora"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleFechaHoraVisitaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Guías de traslado de agave:</th>
                                        <td class="guiasTraslado"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumple">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="dictamenInstalaciones" class="d-none terminado">
                        <div class="datos-importantes">
                            <table style="font-size: 12px;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Razón
                                            Social:</th>
                                        <td class="razonSocial"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleRazonSocialEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio Fiscal:</th>
                                        <td class="domicilioFiscal"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioFiscalEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio de Instalaciones (Unidad de Producción o Envasadora Autorizada):
                                        </th>
                                        <td class="domicilioInstalacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha y
                                            Hora de Visita:</th>
                                        <td class="fechaHora"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleFechaHoraVisitaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Acta
                                            Constitutiva:</th>
                                        <td class="actaConstitutiva"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleActaConstitutivaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">CSF:
                                        </th>
                                        <td class="csf"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleCsfDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Comprobante de Posesión:</th>
                                        <td class="comprobantePosesion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleComprobantePosesionDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Plano
                                            de Distribución:</th>
                                        <td class="planoDistribucion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumplePlanoDistribucionDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="muestreoLoteAjustes" class="d-none terminado">
                        <div class="datos-importantes">
                            <table style="font-size: 12px;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Razón
                                            Social:</th>
                                        <td class="razonSocial"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleRazonSocialEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio Fiscal:</th>
                                        <td class="domicilioFiscal"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioFiscalEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio de Instalaciones (Unidad de Producción o Envasadora Autorizada):
                                        </th>
                                        <td class="domicilioInstalacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha y
                                            Hora de Visita:</th>
                                        <td class="fechaHora"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleFechaHoraVisitaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre
                                            del Lote:</th>
                                        <td class="nombreLote"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleNombreLoteRemuestreo">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Categoría:</th>
                                        <td class="categoria"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleCategoriaRemuestreo">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Clase:
                                        </th>
                                        <td class="clase"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleClaseRemuestreo">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Especie
                                            de Agave:</th>
                                        <td class="tipos"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleEspecieAgaveRemuestreo">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Tipo de
                                            Análisis:</th>
                                        <td class="tipoAnalisis"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleTipoAnalisisRemuestreo">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Acta de
                                            Vigilancia de producción:</th>
                                        <td id="actaVigilanciaRemuestreo"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleActaVigilanciaRemuestreo">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

              

                    <div id="vigilanciaTraslado" class="d-none terminado">
                        <div class="datos-importantes">
                            <table style="font-size: 12px;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Razón
                                            Social:</th>
                                        <td class="razonSocial"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleRazonSocialEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio Fiscal:</th>
                                        <td class="domicilioFiscal"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioFiscalEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio de Instalaciones (Unidad de Producción o Envasadora Autorizada):
                                        </th>
                                        <td class="domicilioInstalacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha y
                                            Hora de Visita:</th>
                                        <td class="fechaHora"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleFechaHoraVisitaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre
                                            del Lote:</th>
                                        <td class="nombreLote"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleNombreLoteTraslado">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Categoría:</th>
                                        <td class="categoria"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleCategoriaTraslado">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Clase:
                                        </th>
                                        <td class="clase"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleClaseTraslado">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Especie
                                            de Agave:</th>
                                        <td class="tipos"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleEspecieAgaveTraslado">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Contenido Alcohólico:</th>
                                        <td class="cont_alc"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleContenidoAlcoholTraslado">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:
                                        </th>
                                        <td class="fq"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleFqTraslado">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Certificado a Granel:</th>
                                        <td class="certificadoGranel"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleCertificadoGranelTraslado">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Volumen
                                            del Lote Actual:</th>
                                        <td class="volumenActual"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleVolumenLoteActualTraslado">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Volumen
                                            Trasladado:</th>
                                        <td class="volumenTrasladado"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleVolumenTrasladado">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Volumen
                                            Sobrante:</th>
                                        <td class="volumenSobrante"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleVolumenSobrante">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="inspeccionEnvasado" class="d-none terminado">
                        <div class="datos-importantes">
                            <table style="font-size: 11px;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Razón
                                            Social:</th>
                                        <td class="razonSocial"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleRazonSocialEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio Fiscal:</th>
                                        <td class="domicilioFiscal"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioFiscalEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio de Instalaciones (Unidad de Producción o Envasadora Autorizada):
                                        </th>
                                        <td class="domicilioInstalacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha y
                                            Hora de Visita:</th>
                                        <td class="fechaHora"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleFechaHoraVisitaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre
                                            del Lote a Granel:</th>
                                        <td class="nombreLote"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre
                                            del Lote Envasado:</th>
                                        <td class="nombreLoteEnvasado"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Cajas/Botellas:</th>
                                        <td class="cajasBotellas"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Categoría:</th>
                                        <td class="categoria"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Clase:</th>
                                        <td class="clase"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Especie de Agave:</th>
                                        <td class="tipos"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Contenido Alcohólico:</th>
                                        <td class="cont_alc"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:
                                        </th>
                                        <td class="fq"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleFqEnvasado">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Certificado a Granel:</th>
                                        <td class="certificadoGranel"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleCertificadoGranelEnvasado">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Tipo
                                            (Sin/Con Etiqueta):</th>
                                        <td id="tipoEtiquetaEnvasado"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleTipoEtiquetaEnvasado">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Inicio
                                            y Término de Envasado:</th>
                                        <td id="inicioTerminoEnvasado"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleInicioTerminoEnvasado">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Destino
                                            (Nacional/Internacional):</th>
                                        <td id="destinoEnvasado"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleDestinoEnvasado">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="inspeccionIngresoBarrica" class="d-none terminado">
                        <div class="datos-importantes">
                            <table style="font-size: 12px;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Razón
                                            Social:</th>
                                        <td class="razonSocial"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleRazonSocialEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio Fiscal:</th>
                                        <td class="domicilioFiscal"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioFiscalEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio de Instalaciones (Unidad de Producción o Envasadora Autorizada):
                                        </th>
                                        <td class="domicilioInstalacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha y
                                            Hora de Visita:</th>
                                        <td class="fechaHora"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleFechaHoraVisitaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre
                                            del Lote a Granel:</th>
                                        <td class="nombreLote"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Categoría:</th>
                                        <td class="categoria"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Clase:</th>
                                        <td class="clase"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Especie de Agave:</th>
                                        <td class="tipos"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Contenido Alcohólico:</th>
                                        <td class="cont_alc"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:
                                        </th>
                                        <td class="fq"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleFqEnvasado">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Certificado a Granel:</th>
                                        <td class="certificadoGranel"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleCertificadoGranelEnvasado">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">MATERIAL DEL RECIPIENTE:</td>
                                        <td class="materialRecipiente"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleRecipiente"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">CAPACIDAD DEL RECIPIENTE:
                                        </td>
                                        <td class="capacidadRecipiente"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleCapacidadRecipientes" style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">NÚMERO DE RECIPIENTES:</td>
                                        <td class="numeroRecipiente"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleNumeroRecipientes"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">VOLUMEN INGRESADO:</td>
                                        <td class="volumenIngresado"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleVolumenIngresado"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                   <!-- <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">TIEMPO DE MADURACIÓN:</td>
                                        <td class="tiempoMaduracion"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleTiempoMaduracion"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>-->
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">TIPO DE INGRESO (BARRICA O VIDRIO):</td>
                                        <td class="tipoIngreso"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleTipoRecipiente"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="liberacionBarricaVidrio" class="d-none terminado">
                        <h4 class="address-title mb-2">Liberación de Barrica/Contenedor de Vidrio</h4>
                        <div class="datos-importantes">
                            <table style="font-size: 12px;" class="table table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Razón
                                            Social:</th>
                                        <td class="razonSocial"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleRazonSocialEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio Fiscal:</th>
                                        <td class="domicilioFiscal"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioFiscalEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio de Instalaciones (Unidad de Producción o Envasadora Autorizada):
                                        </th>
                                        <td class="domicilioInstalacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha y
                                            Hora de Visita:</th>
                                        <td class="fechaHora"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleFechaHoraVisitaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre
                                            del Lote a Granel:</th>
                                        <td class="nombreLote"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Categoría:</th>
                                        <td class="categoria"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Clase:</th>
                                        <td class="clase"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Especie de Agave:</th>
                                        <td class="tipos"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Contenido Alcohólico:</th>
                                        <td class="cont_alc"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:
                                        </th>
                                        <td class="fq"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleFqEnvasado">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Certificado a Granel:</th>
                                        <td class="certificadoGranel"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleCertificadoGranelEnvasado">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">MATERIAL DEL RECIPIENTE:</td>
                                        <td class="materialRecipiente"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleRecipiente"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">CAPACIDAD DEL RECIPIENTE:
                                        </td>
                                        <td class="capacidadRecipiente"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleCapacidadRecipientes" style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">NÚMERO DE RECIPIENTES:</td>
                                        <td class="numeroRecipiente"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleNumeroRecipientes"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">VOLUMEN LIBERADO:</td>
                                        <td class="volumenlIBERADO"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleVolumenIngresado"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">TIEMPO DE MADURACIÓN:</td>
                                        <td class="tiempoMaduracion"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleTiempoMaduracion"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bold" style="font-size: 11px;">TIPO DE LIBERACIÓN (BARRICA O VIDRIO):</td>
                                        <td class="tipoLiberacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm" id="cumpleTipoRecipiente"
                                                style="font-size: 11px;">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="liberacionPTNacional" class="d-none terminado">
                        <h4 class="address-title mb-2">Liberación de PT Nacional</h4>
                        <div class="datos-importantes">
                            <table style="font-size: 11px;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Razón Social (Emisor):</th>
                                        <td id="razonSocialEmisorLiberacionPTNacional"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Razón Social (Receptor):</th>
                                        <td id="razonSocialReceptorLiberacionPTNacional"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Domicilio Fiscal (Emisor):</th>
                                        <td id="domicilioFiscalEmisorLiberacionPTNacional"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Domicilio de Instalaciones
                                            (Unidad de Producción o Envasadora Autorizada):</th>
                                        <td id="domicilioInstalacionesEmisorLiberacionPTNacional"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Fecha y Hora de Visita:</th>
                                        <td id="fechaHoraVisitaLiberacionPTNacional"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Nombre del Lote a Granel:</th>
                                        <td id="nombreLoteGranelLiberacionPTNacional"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Nombre del Lote Envasado:</th>
                                        <td class="nombreLoteEnvasado"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Cajas/Botellas:</th>
                                        <td class="cajasBotellas"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Categoría:</th>
                                        <td class="categoria"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Clase:</th>
                                        <td class="clase"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Especie de Agave:</th>
                                        <td class="tipos"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Contenido Alcohólico:</th>
                                        <td class="cont_alc"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">FQ:</th>
                                        <td class="fq"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Certificado a Granel:</th>
                                        <td class="certificadoGranel"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Rango de Hologramas:</th>
                                        <td id="rangoHologramasLiberacionPTNacional"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" scope="row">Dictamen de Envasado:</th>
                                        <td id="dictamenEnvasadoLiberacionPTNacional"></td>
                                        <td>
                                            <select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="liberacionPTExportacion" class="d-none terminado">
                       
                        <div class="datos-importantes">
                            <table style="font-size: 11px;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Razón
                                            Social:</th>
                                        <td class="razonSocial"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleRazonSocialEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio Fiscal:</th>
                                        <td class="domicilioFiscal"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioFiscalEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio de Instalaciones (Unidad de Producción o Envasadora Autorizada):
                                        </th>
                                        <td class="domicilioInstalacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha y
                                            Hora de Visita:</th>
                                        <td class="fechaHora"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleFechaHoraVisitaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre
                                            del Lote a Granel:</th>
                                        <td class="nombreLote"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre
                                            del Lote Envasado:</th>
                                        <td class="nombreLoteEnvasado"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Cajas/Botellas:</th>
                                        <td class="cajasBotellas"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Categoría:</th>
                                        <td class="categoria"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Clase:</th>
                                        <td class="clase"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Especie de Agave:</th>
                                        <td class="tipos"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Contenido Alcohólico:</th>
                                        <td class="cont_alc"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:
                                        </th>
                                        <td class="fq"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Certificado a Granel:</th>
                                        <td class="certificadoGranel"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Dictamen de Envasado:</th>
                                        <td id="dictamenEnvasadoLiberacionPTExportacion"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Factura Proforma:</th>
                                        <td id="facturaProformaLiberacionPTExportacion"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="georreferencia" class="d-none terminado">
                       
                        <div class="datos-importantes">
                            <table style="font-size: 12px;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Descripción</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Dato</th>
                                        <th class="text-dark fw-bold" style="font-size: 11px;">Cumple</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Razón
                                            Social:</th>
                                        <td class="razonSocial"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleRazonSocialEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio Fiscal:</th>
                                        <td class="domicilioFiscal"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioFiscalEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Nombre del predio:
                                        </th>
                                        <td class="nombrePredio"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Domicilio del predio:
                                        </th>
                                        <td class="domicilioInstalacion"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleDomicilioInstalacionesEmisorDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha y
                                            Hora de Visita:</th>
                                        <td class="fechaHora"></td>
                                        <td>
                                            <select class="form-control form-control-sm"
                                                id="cumpleFechaHoraVisitaDictamen">
                                                <option disabled selected>Seleccionar</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Comprobante de posesión del Predio:</th>
                                        <td class="comprobantePosesion"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">
                                            Preregistro:</th>
                                        <td class="preregistro"></td>
                                        <td><select class="form-control form-control-sm">
                                                <option disabled selected>Seleccionar</option>
                                                <option>Sí</option>
                                                <option>No</option>
                                            </select></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

               


                   <!-- <div class="row">
                        <div class="form-floating form-floating-outline mb-5 mt-4">
                            <textarea name="info_adicional" class="form-control h-px-150 info_adicional" id="info"
                                placeholder="Información comentarios u observaciones sobre esta solicitud..."></textarea>
                            <label for="comentarios">Comentarios u observaciones sobre esta solicitud</label>
                        </div>
                    </div>-->
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Validar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script></script>
