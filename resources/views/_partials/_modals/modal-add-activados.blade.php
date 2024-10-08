<!-- Add New Lote Envasado Modal -->
<style>
    .modal-custom-size {
        max-width: 90%;
        /* Ajusta este valor para hacerlo más grande */
        width: 90%;
        /* Ajusta según tus necesidades */
    }
</style>
<div class="modal fade" id="activosHologramas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Hologramas Activos</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="activosHologramasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">
                        <input type="text" id="edit_id" name="id">

                        <input type="text" class="id_solicitudActivacion" id="id_solicitud" name="id_solicitud">

                        <div class="form-floating form-floating-outline mb-6">
                            <input id="edit_id_inspeccion" name="edit_id_inspeccion" class="form-select " aria-label="Default select example">

                                <label for="edit_id_inspeccion">No. de servicio</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_no_lote_agranel"
                                    placeholder="Introduce el nombre del lote" name="edit_no_lote_agranel"
                                    aria-label="Nombre del lote" />
                                <label for="edit_no_lote_agranel">No de lote granel:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select class=" form-select select2" id="edit_categoria" name="edit_categoria" aria-label="categoria">
                                    <option value="" disabled selected>Elige una categoria</option>
                                    @foreach ($categorias as $cate)
                                    <option value="{{ $cate->edit_categoria }}">{{ $cate->categoria }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_categoria">Categoría</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="No de análisis de laboratorio:" id="edit_no_analisis"
                                    name="edit_no_analisis" />
                                <label for="edit_no_analisis">No de análisis de laboratorio:</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" step="0.01" placeholder="Contenido neto por botellas (ml/L):"
                                    id="edit_cont_neto" name="edit_cont_neto" />
                                <label for="edit_cont_neto">Contenido neto por botellas (ml/L):</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" id="edit_unidad" name="edit_unidad" aria-label="Unidad">
                                    <option value="Litros">Litros</option>
                                    <option value="Mililitros">Mililitros</option>
                                    <option value="Centrilitros">Centrilitros</option>
                                </select>
                                <label for="edit_unidad">Unidad</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" id="edit_clase" name="edit_clase" aria-label="Clase">
                                    <option value="Blanco o Joven">Blanco o Joven</option>
                                    <option value="Maduro en Vidrio">Maduro en Vidrio</option>
                                    <option value="Reposado">Reposado</option>
                                    <option value="Añejo">Añejo</option>
                                    <option value="Abocado con">Abocado con</option>
                                    <option value="Destilado con">Destilado con</option>
                                    <option value="No aplica">No aplica</option>
                                </select>
                                <label for="edit_clase">Clase</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Contenido Alcohólico:" id="edit_contenido"
                                    name="edit_contenido" />
                                <label for="edit_contenido">Contenido Alcohólico:</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder=">No. de lote de envasado:" id="edit_no_lote_envasado"
                                    name="edit_no_lote_envasado" />
                                <label for="edit_no_lote_envasado">No. de lote de envasado:</label>
                            </div>
                        </div>
  {{--                       <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" step="0.01" placeholder="Volumen total"
                                    id="no_botellas" name="no_botellas" readonly />
                                <label for="no_botellas">No. Botellas (Hologramas):</label>
                            </div>
                        </div> --}}

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select class=" form-select select2" id="edit_id_tipo" name="edit_id_tipo" aria-label="categoria">
                                    <option value="" disabled selected>Elige una categoria</option>
                                    @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->edit_id_tipo }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_id_tipo">Categoría</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Lugar de producción:" id="edit_lugar_produccion"
                                    name="edit_lugar_produccion" />
                                <label for="edit_lugar_produccion">Lugar de producción: </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" step="0.01" placeholder="Lugar de envasado:"
                                    id="edit_lugar_envasado" name="edit_lugar_envasado"  />
                                <label for="edit_lugar_envasado">Lugar de envasado:</label>
                            </div>
                        </div>

                    </div>

                   

                    <div style="display: none;" id="mensaje" role="alert"></div>


                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                    <th>id</th>
                                    <th>id_inspeccion</th>
                                    <th>Numero lote agranel</th>
                                    <th>Categorria</th>
                                    <th>Análisis de laboratorio</th>
                                    <th>Contenido neto</th>
                                    <th>Unidad</th>
                                    <th>Clase</th>
                                    <th>Contenido Alcohólico</th>
                                    <th>No. de lote de envasado</th>
                                    <th>Categoría</th>
                                    <th>Lugar de producción</th>
                                    <th>Lugar de envasado</th>
                                <th>Rango inicial</th>
                                <th>Rango final</th>
                            </tr>
                        </thead>
                        <tbody id="edit_contenidoRango">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <td>
                                    <input type="text" class="form-control form-control-sm" name="rango_inicial[]"
                                        id="folio_inicial" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" name="rango_final[]"
                                        id="folio_final" readonly>
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

