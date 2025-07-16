<div class="modal fade" id="RegistrarBitacora" tabindex="-1" aria-labelledby="registroInventarioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="addBitacora">Agregar Bitácora de mezcal a granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-8">
                <form id="registroInventarioForm" method="POST">
                    @csrf
                    <!-- PROCESO DE ELABORACIÓN DE MEZCAL - FORMULARIO BLADE AL ESTILO QUE USAS -->
                    <div>
                        <div class="card mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                PROCESO DE ELABORACIÓN DE MEZCAL (PRODUCTOR ARTESANAL)
                            </div>
                            <div class="card-body">

                                <!-- GENERALES -->
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="date" class="form-control" id="fecha_ingreso"
                                                name="fecha_ingreso">
                                            <label for="fecha_ingreso">Fecha de ingreso</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select onchange="obtenerGraneles(this.value);" id="id_empresa"
                                                name="id_empresa" class="select2 form-select"
                                                data-error-message="por favor selecciona la empresa">
                                                @if ($tipo_usuario != 3)
                                                    <option value="" disabled selected>Selecciona el cliente
                                                    </option>
                                                @endif
                                                @foreach ($empresas as $empresa)
                                                    <option value="{{ $empresa->id_empresa }}">
                                                        {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                                        | {{ $empresa->razon_social }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="id_empresa" class="form-label">Cliente</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="lote_granel"
                                                name="lote_granel">
                                            <label for="lote_granel">Lote a granel</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="numero_tapada"
                                                name="numero_tapada">
                                            <label for="numero_tapada">Nº de tapada</label>
                                        </div>
                                    </div>
                                </div>





                                <!-- IDENTIFICACIÓN DEL MAGUEY -->
<div class="row">
  <!-- IDENTIFICACIÓN DEL MAGUEY -->
  <div class="col-md-8">
    <div class="fw-bold text-uppercase text-primary mb-2">Identificación del maguey</div>
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>N° de guía</th>
            <th>Tipo de maguey</th>
            <th>N° de piñas</th>
            <th>Kg. de maguey</th>
            <th>% de art.</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="text" class="form-control" id="numero_guia" name="numero_guia"></td>
            <td>
              <select id="tipo_maguey" name="tipo_maguey" class="form-select">
                <option value="" disabled selected>Tipo</option>
                <option value="Espadín">Espadín</option>
                <option value="Tobalá">Tobalá</option>
                <option value="Cuishe">Cuishe</option>
                <option value="Tepextate">Tepextate</option>
              </select>
            </td>
            <td><input type="number" class="form-control" id="numero_pinas" name="numero_pinas"></td>
            <td><input type="number" step="0.01" class="form-control" id="kg_maguey" name="kg_maguey"></td>
            <td><input type="number" step="0.01" class="form-control" id="porcentaje_azucar" name="porcentaje_azucar"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- COCCIÓN -->
  <div class="col-md-4">
    <div class="fw-bold text-uppercase text-primary mb-2">Cocción</div>
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>Kg. a cocción</th>
            <th>Fecha inicial</th>
            <th>Fecha final</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="number" step="0.01" class="form-control" id="kg_coccion" name="kg_coccion"></td>
            <td><input type="date" class="form-control" id="fecha_inicio_coccion" name="fecha_inicio_coccion"></td>
            <td><input type="date" class="form-control" id="fecha_fin_coccion" name="fecha_fin_coccion"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

                                <!-- SECCIÓN DINÁMICA: MOLIENDA, FORMULACIÓN, FERMENTACIÓN Y DESTILACIÓN DE MOSTOS -->
                                <div class="mt-4 mb-2 fw-bold text-uppercase text-primary">Molienda, formulación,
                                    fermentación y destilación de mostos</div>
                                <div id="seccionMoliendaDinamica">
                                    <!-- Ejemplo fila dinámica de molienda -->
                                    <div class="card mb-3 border rounded p-3 position-relative">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                            onclick="this.closest('.card').remove()">Eliminar</button>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-3">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="date" class="form-control"
                                                        name="molienda[0][fecha_molienda]" id="fecha_molienda_0">
                                                    <label for="fecha_molienda_0">Fecha de molienda</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control"
                                                        name="molienda[0][numero_tina]" id="numero_tina_0">
                                                    <label for="numero_tina_0">Nº de tina</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="date" class="form-control"
                                                        name="molienda[0][fecha_formulacion]"
                                                        id="fecha_formulacion_0">
                                                    <label for="fecha_formulacion_0">Fecha de formulación</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][volumen_formulacion]"
                                                        id="volumen_formulacion_0">
                                                    <label for="volumen_formulacion_0">Volumen de formulación</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="date" class="form-control"
                                                        name="molienda[0][fecha_destilacion]"
                                                        id="fecha_destilacion_0">
                                                    <label for="fecha_destilacion_0">Fecha de destilación</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Detalles Puntas, Mezcal, Colas -->
                                        <div class="row mt-3 g-3">
                                            <!-- Puntas -->
                                            <div class="col-md-4">
                                                <div class="fw-semibold mb-1">Puntas</div>
                                                <div class="form-floating form-floating-outline mb-2">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][puntas_volumen]" id="puntas_volumen_0">
                                                    <label for="puntas_volumen_0">Volumen</label>
                                                </div>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][puntas_alcohol]" id="puntas_alcohol_0">
                                                    <label for="puntas_alcohol_0">% Alc. Vol.</label>
                                                </div>
                                            </div>
                                            <!-- Mezcal -->
                                            <div class="col-md-4">
                                                <div class="fw-semibold mb-1">Mezcal</div>
                                                <div class="form-floating form-floating-outline mb-2">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][mezcal_volumen]" id="mezcal_volumen_0">
                                                    <label for="mezcal_volumen_0">Volumen</label>
                                                </div>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][mezcal_alcohol]" id="mezcal_alcohol_0">
                                                    <label for="mezcal_alcohol_0">% Alc. Vol.</label>
                                                </div>
                                            </div>
                                            <!-- Colas -->
                                            <div class="col-md-4">
                                                <div class="fw-semibold mb-1">Colas</div>
                                                <div class="form-floating form-floating-outline mb-2">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][colas_volumen]" id="colas_volumen_0">
                                                    <label for="colas_volumen_0">Volumen</label>
                                                </div>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][colas_alcohol]" id="colas_alcohol_0">
                                                    <label for="colas_alcohol_0">% Alc. Vol.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary mb-4"
                                    onclick="agregarFilaMolienda()">+ Agregar fila molienda</button>

                                <!-- SECCIÓN DINÁMICA: SEGUNDA DESTILACIÓN -->
                                <div class="mt-4 mb-2 fw-bold text-uppercase text-primary">Segunda destilación</div>
                                <div id="seccionSegundaDestilacion">
                                    <!-- Ejemplo fila dinámica de segunda destilación -->
                                    <div class="card mb-3 border rounded p-3 position-relative">
                                        <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                            onclick="this.closest('.card').remove()">Eliminar</button>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="date" class="form-control"
                                                        name="segunda_destilacion[0][fecha_destilacion]"
                                                        id="segunda_fecha_destilacion_0">
                                                    <label for="segunda_fecha_destilacion_0">Fecha de
                                                        destilación</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Detalles Puntas, Mezcal, Colas -->
                                        <div class="row mt-3 g-3">
                                            <!-- Puntas -->
                                            <div class="col-md-4">
                                                <div class="fw-semibold mb-1">Puntas</div>
                                                <div class="form-floating form-floating-outline mb-2">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][puntas_volumen]"
                                                        id="segunda_puntas_volumen_0">
                                                    <label for="segunda_puntas_volumen_0">Volumen</label>
                                                </div>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][puntas_alcohol]"
                                                        id="segunda_puntas_alcohol_0">
                                                    <label for="segunda_puntas_alcohol_0">% Alc. Vol.</label>
                                                </div>
                                            </div>
                                            <!-- Mezcal -->
                                            <div class="col-md-4">
                                                <div class="fw-semibold mb-1">Mezcal</div>
                                                <div class="form-floating form-floating-outline mb-2">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][mezcal_volumen]"
                                                        id="segunda_mezcal_volumen_0">
                                                    <label for="segunda_mezcal_volumen_0">Volumen</label>
                                                </div>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][mezcal_alcohol]"
                                                        id="segunda_mezcal_alcohol_0">
                                                    <label for="segunda_mezcal_alcohol_0">% Alc. Vol.</label>
                                                </div>
                                            </div>
                                            <!-- Colas -->
                                            <div class="col-md-4">
                                                <div class="fw-semibold mb-1">Colas</div>
                                                <div class="form-floating form-floating-outline mb-2">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][colas_volumen]"
                                                        id="segunda_colas_volumen_0">
                                                    <label for="segunda_colas_volumen_0">Volumen</label>
                                                </div>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][colas_alcohol]"
                                                        id="segunda_colas_alcohol_0">
                                                    <label for="segunda_colas_alcohol_0">% Alc. Vol.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary mb-4"
                                    onclick="agregarFilaSegundaDestilacion()">+ Agregar fila segunda
                                    destilación</button>

                                <!-- TOTAL / OBSERVACIONES -->
                                <div class="mt-4 mb-2 fw-bold text-uppercase text-primary">Total</div>
                                <div class="row g-3">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" step="0.01"
                                                id="volumen_total_formulado" name="volumen_total_formulado">
                                            <label for="volumen_total_formulado">Volumen total formulado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="puntas_volumen" name="puntas_volumen">
                                            <label for="puntas_volumen">Puntas Volumen</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="puntas_alcohol" name="puntas_alcohol">
                                            <label for="puntas_alcohol">Puntas % Alc. Vol.</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="mezcal_volumen" name="mezcal_volumen">
                                            <label for="mezcal_volumen">Mezcal Volumen</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="mezcal_alcohol" name="mezcal_alcohol">
                                            <label for="mezcal_alcohol">Mezcal % Alc. Vol.</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="colas_volumen" name="colas_volumen">
                                            <label for="colas_volumen">Colas Volumen</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" step="0.01" class="form-control"
                                                id="colas_alcohol" name="colas_alcohol">
                                            <label for="colas_alcohol">Colas % Alc. Vol.</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="observaciones" class="form-label fw-bold">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"
                                        placeholder="Escribe observaciones"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Botones -->
                    <div class="d-flex justify-content-center">
                        <button disabled class="btn btn-primary me-2 d-none" type="button" id="loading">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Registrando...
                        </button>
                        <button type="submit" class="btn btn-primary me-2" id="btnRegistrar"><i
                                class="ri-add-line me-1"></i>
                            Registrar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script></script>
