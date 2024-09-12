<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="ActaUnidades" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Acta circunstanciada para Unidades de producción</h4>

                </div>
            </div>
            <form id="ActaUnidadesForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                <input type="hidden" id="edit_id_solicitud2" name="id_solicitud">
                <input type="hidden" id="empresa2" name="empresa">
                @csrf


                <div class="row">
                    <div class="col-md-6 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="no_guia" name="no_guia"
                                placeholder="Ingresa el No. guia" aria-label="Ingresa el No. guia" />
                            <label for="no_guia">Acta número:</label>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-4">
                            <select id="tipo_pago" name="tipo_pago" class="form-select" required>
                                <option value="1">Unidad de producción de Agave </option>
                                <option value="2">Unidad de producción de Mezca</option>
                                <option value="3">Planta de Envasado</option>
                                <option value="4">Comercializadora</option>
                                <option value="5">Almacén</option>

                            </select>
                            <label for="tipo_pago">En la categoría de:</label>
                        </div>
                    </div>

                </div>




                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control" id="no_guia" name="no_guia"
                        placeholder="Lugar de inspeccion:" aria-label="Ingresa el No. guia" />
                    <label for="no_guia">Lugar de inspeccion:</label>
                </div>
                <div class="col-md-6 mb-5">
                    <div class="form-floating form-floating-outline">
                        <input type="date" class="form-control" id="fecha_envio" name="fecha_envio"
                            aria-label="Fecha de Emisión">
                        <label for="fecha_envio">Fecha de inicio</label>
                    </div>
                </div>

                <p class="address-subtitle"><b style="color: red">Designacion: </b>De testigos</b></p>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <button type="button" class="btn btn-primary add-row" data-target="#testigos" data-name-prefix="rango_inicial[]" data-name-suffix="rango_final[]">
                                    <i class="ri-add-line"></i>
                                </button>
                            </th>
                            <th>Nombre del testigo</th>
                            <th>Domicilio</th>
                        </tr>
                    </thead>
                    <tbody id="testigos">
                        <tr>
                            <th>
                                <button type="button" class="btn btn-danger remove-row" disabled>
                                    <i class="ri-delete-bin-5-fill"></i>
                                </button>
                            </th>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="rango_inicial[]" id="folio_inicial" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="rango_final[]" id="folio_final" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div style="padding: 20px"></div>
                <p class="address-subtitle"><b style="color: red">unidad: </b>De producción</p>
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <button type="button" class="btn btn-primary add-row" data-target="#unidadProduccion" data-name-prefix="nombre_predio[]" data-name-superficie="superficie[]" data-name-madurez="madurez[]" data-name-plagas="plagas[]" data-name-plantas="cantidad_plantas[]" data-name-coordenadas="coordenadas[]">
                                    <i class="ri-add-line"></i>
                                </button>
                            </th>
                            <th>Nombre del predio</th>
                            <th>Superficie (hectáreas)</th>
                            <th>Madurez del agave (años)</th>
                            <th>Plagas en el cultivo</th>
                            <th>Cantidad de plantas</th>
                            <th>Coordenadas</th>
                        </tr>
                    </thead>
                    <tbody id="unidadProduccion">
                        <tr>
                            <th>
                                <button type="button" class="btn btn-danger remove-row" disabled>
                                    <i class="ri-delete-bin-5-fill"></i>
                                </button>
                            </th>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="nombre_predio[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="superficie[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="madurez[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="plagas[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="cantidad_plantas[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="coordenadas[]" />
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
