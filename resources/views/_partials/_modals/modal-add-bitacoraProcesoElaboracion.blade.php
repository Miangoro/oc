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
                    <!-- PROCESO DE ELABORACIÓN DE MEZCAL -->
                    <div>
                        <div class="card mb-4 border rounded">
                            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                PROCESO DE ELABORACIÓN DE MEZCAL (PRODUCTOR ARTESANAL)
                            </div>
                            <div class="card-body">

                                <!-- GENERALES -->
                                <div class="row">
                                    <div class="col-md-1 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control datepicker" id="fecha_ingreso"
                                                name="fecha_ingreso" placeholder="Fecha de ingreso">
                                            <label for="fecha_ingreso">Fecha de ingreso</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline"
                                            onchange="cargarInstalaciones();">
                                            <select id="id_empresa" name="id_empresa" class="select2 form-select">
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
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="id_instalacion" name="id_instalacion"
                                                class="select2 form-select">
                                                <option value="" disabled selected>Seleccione una instalación
                                                </option>
                                            </select>
                                            <label for="id_instalacion" class="form-label">Selecciona la
                                                instalación</label>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="lote_granel"
                                                name="lote_granel" placeholder="Lote a granel">
                                            <label for="lote_granel">Lote a granel</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="numero_tapada"
                                                name="numero_tapada" placeholder="Nº de tapada">
                                            <label for="numero_tapada">Nº de tapada</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- IDENTIFICACIÓN DEL MAGUEY -->
                                <div class="row">
                                    <!-- IDENTIFICACIÓN DEL MAGUEY -->
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="5"
                                                            class="text-center bg-label-info text-dark text-uppercase fs-6 fw-bold py-3">
                                                            IDENTIFICACIÓN DEL MAGUEY
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>N° de guía</th>
                                                        <th style="width: 200px;">Tipo de maguey</th>
                                                        <th>N° de piñas</th>
                                                        <th>Kg. de maguey</th>
                                                        <th>% de art.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><span class="position-relative d-block mb-1"><input
                                                                    type="text" class="form-control" id="numero_guia"
                                                                    name="numero_guia" placeholder="N° de guía"></span>
                                                        </td>
                                                        <td> {{-- <span class="position-relative d-block mb-1"> --}}
                                                            <div class="form-floating form-floating-outline mb-4">
                                                                <select id="tipo_agave" name="id_tipo[]"
                                                                    class="select2 form-select mb-4" multiple>
                                                                    @foreach ($tipos as $tipo)
                                                                        <option value="{{ $tipo->id_tipo }}">
                                                                            {{ $tipo->nombre }}
                                                                            ({{ $tipo->cientifico }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>{{-- </span> --}}
                                                            </div>
                                                        </td>
                                                        <td><span class="position-relative d-block mb-1"><input
                                                                    type="number" class="form-control"
                                                                    id="numero_pinas" name="numero_pinas"
                                                                    placeholder="N° de piñas"></span></td>
                                                        <td><span class="position-relative d-block mb-1"><input
                                                                    type="number" step="0.01" class="form-control"
                                                                    id="kg_maguey" name="kg_maguey"
                                                                    placeholder="Kg. de maguey"></span></td>
                                                        <td><span class="position-relative d-block mb-1"><input
                                                                    type="number" step="0.01" class="form-control"
                                                                    placeholder="% de art." id="porcentaje_azucar"
                                                                    name="porcentaje_azucar"></sapn>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- COCCIÓN -->
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="5"
                                                            class="text-center bg-label-info text-dark text-uppercase fs-6 fw-bold py-3">
                                                            COCCIÓN
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Kg. a cocción</th>
                                                        <th>Fecha inicial</th>
                                                        <th>Fecha final</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <span class="position-relative d-block mb-1">
                                                                <input type="number" step="0.01"
                                                                    class="form-control" id="kg_coccion"
                                                                    name="kg_coccion" placeholder="Kg. a cocción">
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="position-relative d-block mb-1">
                                                                <input type="text" class="form-control datepicker"
                                                                    id="fecha_inicio_coccion"
                                                                    name="fecha_inicio_coccion"
                                                                    placeholder="aaaa-mm-dd">
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="position-relative d-block mb-1">
                                                                <input type="text" class="form-control datepicker"
                                                                    id="fecha_fin_coccion" name="fecha_fin_coccion"
                                                                    placeholder="aaaa-mm-dd">
                                                            </span>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECCIÓN DINÁMICA: MOLIENDA, FORMULACIÓN, FERMENTACIÓN Y DESTILACIÓN DE MOSTOS -->
                        <div class="card mb-4 border rounded">
                            <div class="card-body">
                                <!-- MOLIENDA, FORMULACIÓN, FERMENTACIÓN Y DESTILACIÓN DE MOSTOS -->
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                        <thead class="table-light align-middle">
                                            <tr>
                                                <th colspan="12"
                                                    class="text-center bg-label-primary text-uppercase fs-6 fw-bold py-3">
                                                    MOLIENDA, FORMULACIÓN, FERMENTACIÓN Y DESTILACIÓN DE MOSTOS
                                                </th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        id="agregarFilaMolienda">
                                                        <i class="ri-add-circle-fill text-white"></i>
                                                    </button>
                                                </th>
                                                <th rowspan="2">Fecha de molienda</th>
                                                <th rowspan="2">Nº de tina</th>
                                                <th rowspan="2">Fecha de formulación</th>
                                                <th rowspan="2">Volumen de formulación</th>
                                                <th rowspan="2">Fecha de destilación</th>
                                                <th colspan="2">Puntas</th>
                                                <th colspan="2">Mezcal</th>
                                                <th colspan="2">Colas</th>
                                            </tr>
                                            <tr>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaMolienda">
                                            <tr>
                                                <td class="text-nowrap">
                                                    <button type="button" class="btn btn-danger btn-sm" disabled
                                                        {{-- onclick="this.closest('tr').remove()" --}}>
                                                        <i class="ri-close-circle-fill"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control datepicker"
                                                        name="molienda[0][fecha_molienda]" placeholder="aaaa-mm-dd">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        name="molienda[0][numero_tina]" placeholder="Nº de tina">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control datepicker"
                                                        name="molienda[0][fecha_formulacion]"
                                                        placeholder="aaaa-mm-dd">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][volumen_formulacion]" placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control datepicker"
                                                        name="molienda[0][fecha_destilacion]"
                                                        placeholder="aaaa-mm-dd">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][puntas_volumen]" placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][puntas_alcohol]" placeholder="% Alc.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][mezcal_volumen]" placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][mezcal_alcohol]" placeholder="% Alc.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][colas_volumen]" placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda[0][colas_alcohol]" placeholder="% Alc.">
                                                </td>
                                            </tr>

                                        </tbody>


                                        <tfoot>
                                            <tr class="fw-bold bg-light">
                                                <td class="text-end" colspan="4">VOLUMEN TOTAL</td>

                                                <!-- Total volumen formulación final -->
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda_final[volumen_formulacion_final]"
                                                        placeholder="Vol. final">
                                                </td>

                                                <!-- fecha destilación final -->
                                                <td class="text-end">TOTAL FINAL</td>

                                                <!-- Puntas Final -->
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda_final[puntas_volumen_final]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda_final[puntas_alcohol_final]"
                                                        placeholder="% Alc.">
                                                </td>

                                                <!-- Mezcal Final -->
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda_final[mezcal_volumen_final]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda_final[mezcal_alcohol_final]"
                                                        placeholder="% Alc.">
                                                </td>

                                                <!-- Colas Final -->
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda_final[colas_volumen_final]" placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="molienda_final[colas_alcohol_final]"
                                                        placeholder="% Alc.">
                                                </td>
                                            </tr>
                                        </tfoot>


                                    </table>
                                </div>
                            </div>
                        </div>


                        <!-- CARD SEGUNDA DESTILACIÓN -->
                        <div class="card mb-4 border rounded">
                            <div class="card-body">
                                <!-- SEGUNDA DESTILACIÓN -->
                                <div class="table-responsive mb-4">
                                    <table
                                        class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                        <thead class="table-light align-middle">
                                            <tr>
                                                <th colspan="8"
                                                    class="text-center bg-label-warning text-uppercase fs-6 fw-bold py-3">
                                                    SEGUNDA DESTILACIÓN
                                                </th>
                                            </tr>
                                            <tr>
                                                <td rowspan="2"> <button type="button"
                                                        class="btn btn-primary btn-sm"
                                                        id="agregarFilaSegundaDestilacion">
                                                        <i class="ri-add-circle-fill text-white"></i>
                                                    </button></td>
                                                <th rowspan="2">Fecha de destilación</th>
                                                <th colspan="2">Puntas</th>
                                                <th colspan="2">Mezcal</th>
                                                <th colspan="2">Colas</th>
                                            </tr>
                                            <tr>

                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaSegundaDestilacion">
                                            <tr>
                                                <td class="text-nowrap">
                                                    <button type="button" class="btn btn-danger btn-sm" disabled
                                                        {{--  onclick="this.closest('tr').remove()" --}}>
                                                        <i class="ri-close-circle-fill"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control datepicker"
                                                        name="segunda_destilacion[0][fecha_destilacion]"
                                                        placeholder="aaaa-mm-dd">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][puntas_volumen]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][puntas_alcohol]"
                                                        placeholder="% Alc.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][mezcal_volumen]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][mezcal_alcohol]"
                                                        placeholder="% Alc.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][colas_volumen]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion[0][colas_alcohol]"
                                                        placeholder="% Alc.">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold bg-light">
                                                <td class="text-end" colspan="2">VOLUMEN TOTAL</td>

                                                <!-- Puntas Final -->
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion_final[puntas_volumen_final]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion_final[puntas_alcohol_final]"
                                                        placeholder="% Alc.">
                                                </td>

                                                <!-- Mezcal Final -->
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion_final[mezcal_volumen_final]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion_final[mezcal_alcohol_final]"
                                                        placeholder="% Alc.">
                                                </td>

                                                <!-- Colas Final -->
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion_final[colas_volumen_final]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="segunda_destilacion_final[colas_alcohol_final]"
                                                        placeholder="% Alc.">
                                                </td>
                                            </tr>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- CARD TERCERA DESTILACIÓN -->
                        <div class="card mb-4 border rounded">
                            <div class="card-body">
                                <!-- TERCERA DESTILACIÓN -->
                                <div class="table-responsive mb-4">
                                    <table
                                        class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                        <thead class="table-light align-middle">
                                            <tr>
                                                <th colspan="8"
                                                    class="text-center bg-label-dark text-uppercase fs-6 fw-bold py-3">
                                                    TERCERA DESTILACIÓN
                                                </th>
                                            </tr>
                                            <tr>
                                                <td rowspan="2">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        id="agregarFilaTerceraDestilacion">
                                                        <i class="ri-add-circle-fill text-white"></i>
                                                    </button>
                                                </td>
                                                <th rowspan="2">Fecha de destilación</th>
                                                <th colspan="2">Puntas</th>
                                                <th colspan="2">Mezcal</th>
                                                <th colspan="2">Colas</th>
                                            </tr>
                                            <tr>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                                <th>Volumen</th>
                                                <th>% Alc. Vol.</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaTerceraDestilacion">
                                            <tr>
                                                <td class="text-nowrap">
                                                    <button type="button" class="btn btn-danger btn-sm" disabled>
                                                        <i class="ri-close-circle-fill"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control datepicker"
                                                        name="tercera_destilacion[0][fecha_destilacion]"
                                                        placeholder="aaaa-mm-dd">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion[0][puntas_volumen]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion[0][puntas_alcohol]"
                                                        placeholder="% Alc.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion[0][mezcal_volumen]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion[0][mezcal_alcohol]"
                                                        placeholder="% Alc.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion[0][colas_volumen]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion[0][colas_alcohol]"
                                                        placeholder="% Alc.">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold bg-light">
                                                <td class="text-end" colspan="2">VOLUMEN TOTAL</td>

                                                <!-- Puntas Final -->
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion_final[puntas_volumen_final]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion_final[puntas_alcohol_final]"
                                                        placeholder="% Alc.">
                                                </td>

                                                <!-- Mezcal Final -->
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion_final[mezcal_volumen_final]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion_final[mezcal_alcohol_final]"
                                                        placeholder="% Alc.">
                                                </td>

                                                <!-- Colas Final -->
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion_final[colas_volumen_final]"
                                                        placeholder="Vol.">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" class="form-control"
                                                        name="tercera_destilacion_final[colas_alcohol_final]"
                                                        placeholder="% Alc.">
                                                </td>
                                            </tr>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                        </div>


                        <!-- CARD / OBSERVACIONES -->
                        <div class="card mb-4 border rounded">
                            <div class="card-body">
                                <!-- TOTAL -->
                                <div class="table-responsive mb-4">
                                    <table
                                        class="table table-bordered table-sm mb-0 align-middle text-center table-hover">
                                        <thead class="table-light align-middle">
                                            <tr>
                                                <th colspan="7"
                                                    class="text-center bg-label-info text-dark text-uppercase fs-6 fw-bold py-3">
                                                    TOTAL
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Molienda volumen total formulado</th>
                                                <th>Puntas Volumen</th>
                                                <th>Puntas % Alc. Vol.</th>
                                                <th>Mezcal Volumen</th>
                                                <th>Mezcal % Alc. Vol.</th>
                                                <th>Colas Volumen</th>
                                                <th>Colas % Alc. Vol.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01"
                                                            class="form-control bg-light"
                                                            name="volumen_total_formulado"
                                                            id="volumen_total_formulado" style="pointer-events: none;"
                                                            readonly placeholder="Vol.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01"
                                                            class="form-control bg-light" readonly
                                                            style="pointer-events: none;" name="puntas_volumen"
                                                            id="puntas_volumen" placeholder="Vol.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="puntas_alcohol" id="puntas_alcohol"
                                                            placeholder="% Alc.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01"
                                                            class="form-control bg-light" readonly
                                                            style="pointer-events: none;" name="mezcal_volumen"
                                                            id="mezcal_volumen" placeholder="Vol.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="mezcal_alcohol" id="mezcal_alcohol"
                                                            placeholder="% Alc.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01"
                                                            class="form-control bg-light" readonly
                                                            style="pointer-events: none;" name="colas_volumen"
                                                            id="colas_volumen" placeholder="Vol.">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="position-relative d-block mb-1">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="colas_alcohol" id="colas_alcohol"
                                                            placeholder="% Alc.">
                                                    </span>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <div class="mt-5">
                                        <label for="observaciones"
                                            class="form-label fw-bold fs-6">Observaciones</label>
                                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"
                                            placeholder="Escribe observaciones"></textarea>
                                    </div>
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

<script>
    function cargarInstalaciones() {
        var empresa = $("#id_empresa").val();
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatosBitacora/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido =
                        '<option value="" disabled selected>Seleccione una instalación</option>';

                    for (let index = 0; index < response.instalaciones.length; index++) {
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);

                        contenido += '<option value="' + response.instalaciones[index].id_instalacion +
                            '">' + tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>';
                    }

                    if (response.instalaciones.length == 0) {
                        contenido = '<option value="">Sin instalaciones registradas</option>';
                    }

                    $('#id_instalacion').html(contenido);
                },
                error: function() {}
            });
        }
    }


    function limpiarTipo(tipo) {
        try {
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            return tipo;
        }
    }
</script>
