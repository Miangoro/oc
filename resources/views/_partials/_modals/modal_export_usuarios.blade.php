<!-- Modal para exportar Excel -->
<div class="modal fade" id="exportarExcel" tabindex="-1" aria-labelledby="exportarExcelLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalexportarExcel" class="modal-title">Generar Reporte Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reporteForm" action="{{ route('usuarios.exportar') }}" method="GET">
                    @csrf
                    <div class="mb-4">
                        <p class="text-start text-muted"><i class="ri-filter-fill"></i> Filtrar Datos </p>
                    </div>
                    <div class="row">
                        <!-- Filtro Cliente -->
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select name="id_empresa" class="select2 form-select"
                                    data-error-message="por favor selecciona la empresa">
                                    {{--                      <option value="" disabled selected>Selecciona el cliente</option> --}}
                                    <option value="">Todos</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                    </div>
                    <!-- Botones del modal -->
                    <div class="col-12 mt-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <!-- Botón Restablecer Filtros a la izquierda -->
                        <div class="order-1">
                            <button type="button" id="restablecerFiltros" class="btn btn-info">
                                <i class="ri-filter-off-fill"></i> Restablecer Filtros
                            </button>
                        </div>

                        <!-- Botones Generar Reporte y Cancelar a la derecha -->
                        <div class="d-flex flex-wrap justify-content-end gap-3 order-2">
                            <button type="submit" id="generarReporte" class="btn btn-primary">
                                <i class="ri-file-excel-2-fill"></i> Generar
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script></script>
