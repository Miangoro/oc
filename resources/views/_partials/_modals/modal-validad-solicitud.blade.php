
<div class="modal fade" id="addSolicitudValidar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Validación de la solicitud de servicio</h4>
                    <p class="solicitud badge bg-primary"></p>
                    <div class="datos-importantes">
                        <table style="font-size: 11px;" class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Número de Solicitud:</th>
                                    <td id="numeroSolicitud">12345</td>
                                    <td  class="text-dark fw-bold" style="font-size: 11px;" scope="row" rowspan="4">Datos de la solicitud</td>
                                    <td rowspan="4">aqui los datos</td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Cliente:</th>
                                    <td id="clienteNombre">Nombre del Cliente</td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Fecha de Solicitud:</th>
                                    <td id="fechaSolicitud">21/10/2024</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <form id="addRegistrarSolicitudValidar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <span class="fs-6 fw-bold text-dark">Se cuenta con todos los medios para realizar todas las actividades de evaluación para la Certificación:</span>
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
                                    <span class="fs-6 fw-bold text-dark">El organismo de Certificación tiene la competencia para realizar la Certificación:</span>
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
                                    <span class="fs-6 fw-bold text-dark">El organismo de Certificación tiene la capacidad para llevar a cabo las actividades certificación:</span>
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
                    </div>

                        <div id="muestreoLoteBlancoNuevo">
                        <h4 class="address-title mb-2">Muestreo de Lote a Granel (Blanco o Joven Nuevo - 1era vez -)</h4>
                        <div class="datos-importantes">
                            <table style="font-size: 11px;" class="table table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre del Lote:</th>
                                        <td id="nombreLote">Lote 001</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Categoría:</th>
                                        <td id="categoriaLote">Blanco</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Clase:</th>
                                        <td id="claseLote">Joven</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Especie de Agave:</th>
                                        <td id="especieAgave">Espadín</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Tipo de Análisis:</th>
                                        <td id="tipoAnalisis">Químico</td>
                                    </tr>
                                    <tr>
                                        <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Vigilancia de Producción:</th>
                                        <td id="vigilanciaProduccion">Sí</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div id="muestreoLoteRemuestreo">
                      <h4 class="address-title mb-2">Muestreo de Lote a Granel (Re-muestreo por ajuste de parámetros fuera de especificación)</h4>
                      <div class="datos-importantes">
                          <table style="font-size: 11px;" class="table table-bordered table-sm">
                              <tbody>
                                  <tr>
                                      <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre del Lote:</th>
                                      <td id="nombreLoteRemuestreo"></td>
                                  </tr>
                                  <tr>
                                      <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Categoría:</th>
                                      <td id="categoriaRemuestreo"></td>
                                  </tr>
                                  <tr>
                                      <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Clase:</th>
                                      <td id="claseRemuestreo"></td>
                                  </tr>
                                  <tr>
                                      <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Especie de Agave:</th>
                                      <td id="especieAgaveRemuestreo"></td>
                                  </tr>
                                  <tr>
                                      <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Tipo de Análisis:</th>
                                      <td id="tipoAnalisisRemuestreo"></td>
                                  </tr>
                                  <tr>
                                      <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ (del lote que no pasa):</th>
                                      <td id="fqRemuestreo"></td>
                                  </tr>
                                  <tr>
                                      <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Acta de Vigilancia:</th>
                                      <td id="actaVigilanciaRemuestreo"></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>

                  <div id="muestreoLoteAjustes">
                    <h4 class="address-title mb-2">Muestreo de Lote a Granel (Otras clases o ajustes)</h4>
                    <div class="datos-importantes">
                        <table style="font-size: 11px;" class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre del Lote:</th>
                                    <td id="nombreLoteAjustes"></td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Categoría:</th>
                                    <td id="categoriaAjustes"></td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Clase:</th>
                                    <td id="claseAjustes"></td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Especie de Agave:</th>
                                    <td id="especieAgaveAjustes"></td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Tipo de Análisis:</th>
                                    <td id="tipoAnalisisAjustes"></td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:</th>
                                    <td id="fqAjustes"></td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Certificado:</th>
                                    <td id="certificadoAjustes"></td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Volumen del Lote:</th>
                                    <td id="volumenLoteAjustes"></td>
                                </tr>
                                <tr>
                                    <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Acta de Vigilancia:</th>
                                    <td id="actaVigilanciaAjustes"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="vigilanciaTraslado">
                  <h4 class="address-title mb-2">Vigilancia en el Traslado de Lote</h4>
                  <div class="datos-importantes">
                      <table style="font-size: 11px;" class="table table-bordered table-sm">
                          <tbody>
                              <tr>
                                  <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Nombre del Lote:</th>
                                  <td id="nombreLoteTraslado"></td>
                              </tr>
                              <tr>
                                  <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Categoría:</th>
                                  <td id="categoriaTraslado"></td>
                              </tr>
                              <tr>
                                  <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Clase:</th>
                                  <td id="claseTraslado"></td>
                              </tr>
                              <tr>
                                  <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Especie de Agave:</th>
                                  <td id="especieAgaveTraslado"></td>
                              </tr>
                              <tr>
                                  <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Contenido Alcohólico:</th>
                                  <td id="contenidoAlcoholTraslado"></td>
                              </tr>
                              <tr>
                                  <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">FQ:</th>
                                  <td id="fqTraslado"></td>
                              </tr>
                              <tr>
                                  <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Certificado a Granel:</th>
                                  <td id="certificadoGranelTraslado"></td>
                              </tr>
                              <tr>
                                  <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Volumen del Lote Actual:</th>
                                  <td id="volumenLoteActualTraslado"></td>
                              </tr>
                              <tr>
                                  <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Volumen Trasladado:</th>
                                  <td id="volumenTrasladado"></td>
                              </tr>
                              <tr>
                                  <th class="text-dark fw-bold" style="font-size: 11px;" scope="row">Volumen Sobrante:</th>
                                  <td id="volumenSobrante"></td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>

                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5 mt-4">
                            <textarea name="info_adicional" class="form-control h-px-150 info_adicional" id="info" placeholder="Información comentarios u observaciones sobre esta solicitud..."></textarea>
                            <label for="comentarios">Comentarios u observaciones sobre esta solicitud</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>


</script>
