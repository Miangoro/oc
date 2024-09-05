<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="activarHologramas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Activar Hologramas</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="activarHologramasForm">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="no_lote_agranel"
                                    placeholder="Introduce el nombre del lote" name="no_lote_agranel"
                                    aria-label="Nombre del lote" />
                                <label for="no_lote_agranel">No de lote granel:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" id="categoria" class="form-control"
                                    placeholder="No. de pedido/SKU" aria-label="No. de pedido/SKU" name="categoria" />
                                <label for="categoria">Categoría</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Destino lote" id="no_analisis"
                                    name="no_analisis" />
                                <label for="no_analisis">No de análisis de laboratorio:</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" step="0.01" placeholder="Costo de envio"
                                    id="cont_neto" name="cont_neto" />
                                <label for="cont_neto">Contenido neto por botellas (ml/L):</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" id="unidad" name="unidad" aria-label="Unidad">
                                    <option value="Litros">Litros</option>
                                    <option value="Mililitros">Mililitros</option>
                                    <option value="Centrilitros">Centrilitros</option>
                                </select>
                                <label for="unidad">Unidad</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" id="clase" name="clase" aria-label="Unidad">
                                    <option value=">Blanco o Joven">Blanco o Joven</option>
                                    <option value="Maduro en Vidrio">Maduro en Vidrio</option>
                                    <option value="Reposado">Reposado</option>
                                    <option value="Añejo">Añejo</option>
                                    <option value="Abocado con">Abocado con</option>
                                    <option value="Destilado con">Destilado con</option>
                                    <option value="No aplica">No aplica</option>
                                </select>
                                <label for="clase">Clase</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Destino lote" id="contenido"
                                    name="contenido" />
                                <label for="contenido">Contenido Alcohólico:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Destino lote" id="no_lote_envasado"
                                    name="no_lote_envasado" />
                                <label for="no_lote_envasado">No. de lote de envasado:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" step="0.01" placeholder="Volumen total"
                                    id="no_botellas" name="no_botellas" readonly />
                                <label for="no_botellas">No. Botellas (Hologramas):</label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Destino lote" id="tipo_agave"
                                    name="tipo_agave" />
                                <label for="tipo_agave">Tipo de agave</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Destino lote" id="lugar_produccion"
                                    name="lugar_produccion" />
                                <label for="lugar_produccion">Lugar de producción: </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" step="0.01" placeholder="Volumen total"
                                    id="lugar_envasado" name="lugar_envasado" readonly />
                                <label for="lugar_envasado">Lugar de envasado:</label>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="number" id="cantidad_hologramas" name="cantidad_hologramas" placeholder="Número de hologramas solicitados" readonly />
                            <label for="cantidad_hologramas">Número de hologramas solicitados</label>
                        </div>
                    </div>

                    <div style="display: none;" id="mensaje" role="alert"></div>


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><button type="button" class="btn btn-primary add-row"> <i class="ri-add-line"></i>
                                    </button></th>
                                <th>Rango inicial</th>
                                <th>Rango final</th>
                            </tr>
                        </thead>
                        <tbody id="contenidoRango">
                            <tr>
                                <th>
                                    <button type="button" class="btn btn-danger remove-row" disabled> <i
                                            class="ri-delete-bin-5-fill"></i> </button>
                                </th>
                                <td>
                                    <input type="number" class="form-control form-control-sm" name="rango_inicial[]"
                                        id="rango_inicial">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" name="rango_final[]"
                                        id="rango_final">
                                </td>
                            </tr>
                        </tbody>
                    </table>




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


<script></script>
