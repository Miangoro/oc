<!-- Modal para exportar Excel -->
<div class="modal fade" id="exportarExcel" tabindex="-1" aria-labelledby="exportarExcelLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5 id="modalexportarExcel" class="modal-title">Generar Reporte Excel</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="reporteForm" action="{{ route('solicitudes.exportar') }}" method="GET">
                  @csrf
                  <div class="row">
                      <!-- Filtro Cliente -->
                      <div class="col-md-6 mb-4">
                          <div class="form-floating form-floating-outline mb-4">
                              <select name="id_empresa" class="select2 form-select" data-error-message="por favor selecciona la empresa">
                                  <option value="" disabled selected>Selecciona el cliente</option>
                                  <option value="" >Todos</option>
                                  @foreach ($empresas as $empresa)
                                      <option value="{{ $empresa->id_empresa }}">
                                          {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }} | {{ $empresa->razon_social }}
                                      </option>
                                  @endforeach
                              </select>
                              <label for="id_empresa">Cliente</label>
                          </div>
                      </div>

                      <!-- Filtro Año -->
                      <div class="col-md-6 mb-4">
                          <div class="form-floating form-floating-outline mb-4">
                              <select class="form-select" id="anio" name="anio">
                                  <option value="" disabled selected>Seleccione un año</option>
                                  <option value="" >Todos</option>
                                  <option value="2025">2025</option>
                                  <option value="2024">2024</option>
                                  <option value="2023">2023</option>
                                  <option value="2022">2022</option>
                                  <option value="2021">2021</option>
                              </select>
                              <label for="anio">Año</label>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <!-- Filtro Estatus -->
                      <div class="col-md-6 mb-4">
                          <div class="form-floating form-floating-outline mb-4">
                              <select class="form-select" id="estatus" name="estatus">
                                  <option value="" disabled selected>Seleccione un estatus</option>
                                  <option value="todos">Todos</option>
                                  <option value="pendiente">Pendiente</option>
                                  <option value="con_acta">Con acta</option>
                              </select>
                              <label for="estatus">Estatus</label>
                          </div>
                      </div>

                      <!-- Filtro Mes -->
                      <div class="col-md-6 mb-4">
                          <div class="form-floating form-floating-outline mb-4">
                              <select class="form-select" id="mes" name="mes">
                                  <option value="" disabled selected>Seleccione un mes</option>
                                  <option value="todos">Todos los meses</option>
                                  <option value="01">Enero</option>
                                  <option value="02">Febrero</option>
                                  <option value="03">Marzo</option>
                                  <option value="04">Abril</option>
                                  <option value="05">Mayo</option>
                                  <option value="06">Junio</option>
                                  <option value="07">Julio</option>
                                  <option value="08">Agosto</option>
                                  <option value="09">Septiembre</option>
                                  <option value="10">Octubre</option>
                                  <option value="11">Noviembre</option>
                                  <option value="12">Diciembre</option>
                              </select>
                              <label for="mes">Mes</label>
                          </div>
                      </div>
                  </div>

                  <!-- Botones del modal -->
                  <div class="col-12 mt-4 d-flex flex-wrap justify-content-end gap-4 row-gap-4">
                      <button type="submit"id="generarReporte"  class="btn btn-primary">Generar Reporte</button>
                      <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
