<!-- Share Project Modal -->
<div class="modal fade" id="expedienteServicio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center">
                    <h4 class="mb-2">Expediente de solicitud</h4>

                </div>

                <div class="card">

                    <table class="table table-bordered align-middle shadow-sm mb-2">
                        <tbody>
                            <tr>
                                <th class="bg-light text-secondary">Folio de Solicitud</th>
                                <td class="fw-bold text-primary fs-5 folio_solicitud"></td>
                            </tr>
                            <tr>
                                <th class="bg-light text-secondary">Número de Servicio</th>
                                <td class="fw-bold text-primary fs-5 numero_servicio"></td>
                            </tr>
                            <tr>
                                <th class="bg-light text-secondary" style="width: 40%;">Tipo de Solicitud</th>
                                <td class="fw-semibold text-dark solicitud"></td>
                            </tr>
                            <tr>
                                <th class="bg-light text-secondary">Cliente</th>
                                <td class="fw-bold text-dark nombre_empresa"></td>
                            </tr>
                                <th class="bg-light text-secondary">Inspector</th>
                                <td class="fst-italic text-dark inspectorName"></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre archivo</th>
                                    <th>Archivo</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                {{--                 <p class="id_soli"></p> --}}
                                {{--
                <p class="numero_tipo"></p>
                <p class="id_deinspeccion"></p> --}}
                                <tr class="table-success">
                                    <td><i class="ri-bank-fill ri-22px text-primary me-4"></i><span class="fw-medium">1.
                                            Solicitud de servicio</span></td>
                                    <td><a id="link_solicitud_servicio" target="_Blank" href="#"><i
                                                class="ri-file-pdf-2-fill ri-40px text-danger"></i></a></td>
                                </tr>
                                <tr class="table-danger">
                                    <td><i class="ri-palette-line ri-22px text-danger me-4"></i><span
                                            class="fw-medium">2. Oficio de comisión</span></td>
                                    <td><a id="link_oficio_comision" target="_blank" href="#"><i
                                                class="ri-file-pdf-2-fill ri-40px text-danger"></i></a></td>
                                </tr>
                                <tr class="table-warning">
                                    <td><i class="ri-shield-user-line ri-22px text-info me-4"></i><span
                                            class="fw-medium">3. Orden de servicio</span></td>
                                    <td><a id="link_orden_servicio" target="_blank" href="#"><i
                                                class="ri-file-pdf-2-fill ri-40px text-danger"></i></a></td>
                                </tr>
                                <tr class="table-info auditoria">
                                    <td><i class="ri-file-list-3-line ri-22px text-primary me-4"></i><span
                                            class="fw-medium auditoria_texto"></span></td>
                                    <td><a id="link_plan_auditoria" target="_Blank" href="#"><i
                                                class="ri-file-pdf-2-fill ri-40px text-danger"></i></a></td>
                                </tr>

                                <tr class="table-light etiquetasNA">
                                    <td><i class="ri-angularjs-line ri-22px text-danger me-4"></i><span
                                            class="fw-medium etiqueta_name"></span></td>
                                    <td><a id="links_etiquetas" target="_blank" href="#">
                                            <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- <td><span class="badge rounded-pill bg-label-warning me-1">Pending</span></td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item waves-effect" href="javascript:void(0);"><i class="ri-pencil-line me-1"></i> Edit</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);"><i class="ri-delete-bin-7-line me-1"></i> Delete</a>
                      </div>
                    </div>
                  </td>-->

                                {{--             <tr class="table-info">
                  <td><i class="ri-lifebuoy-line ri-22px text-primary me-4"></i><span class="fw-medium">Acta de inspección</span></td>
                  <td><a target="_blank" href="/acta_circunstanciada_unidades_produccion"><i  class="ri-file-pdf-2-fill ri-40px text-danger"></i></a></td>
                </tr> --}}
                            </tbody>
                        </table>
                    </div>

                    <div id="contenedor-documentos"></div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--/ Share Project Modal -->
