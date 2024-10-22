<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="etiquetas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2"> Subir/Ver etiquetas</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="etiquetasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">
                        <input type="text" id="etiqueta_marca" name="etiqueta_marca">


                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><button type="button" class="btn btn-primary add-row-add"> <i class="ri-add-line"></i>
                                        </button></th>
                                    <th>SKU</th>
                                    <th>Tipo Maguey</th>
                                    <th>Presentación</th>
                                    <th>Clase</th>
                                    <th>Categoria</th>
                                    <th>Etiqueta</th>
                                    <th>Corrugado</th>
                                </tr>
                            </thead>
                            <tbody id="contenidoRango">
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-danger remove-row" disabled> <i
                                                class="ri-delete-bin-5-fill"></i> </button>
                                    </th>
                                    <td>
                                        <select class="id_lote_granel form-control select2" name="id_lote_granel[]" id="id_lote_granel">
                                            <!-- Opciones -->
                                        </select>
                                    </td>
                                    <td>
                                        <select class="id_lote_granel form-control select2" name="id_lote_granel[]" id="id_lote_granel">
                                            <!-- Opciones -->
                                        </select>
                                    </td>
                                    <td>
                                        <select class="id_lote_granel form-control select2" name="id_lote_granel[]" id="id_lote_granel">
                                            <!-- Opciones -->
                                        </select>
                                    </td>                                    <td>
                                        <select class="id_lote_granel form-control select2" name="id_lote_granel[]" id="id_lote_granel">
                                            <!-- Opciones -->
                                        </select>
                                    </td>                                    <td>
                                        <select class="id_lote_granel form-control select2" name="id_lote_granel[]" id="id_lote_granel">
                                            <!-- Opciones -->
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control form-control-sm" type="file" name="url[]">
                                        <input value="51" class="form-control" type="hidden" name="id_documento[]">
                                        <input value="Comprobante de pago" class="form-control" type="hidden"
                                            name="nombre_documento[]">
                                        <label for="Comprobante de pago">Adjuntar Etiqueta</label>
                                    </td>
                                    <td>
                                        <input class="form-control form-control-sm" type="file" name="url[]">
                                        <input value="51" class="form-control" type="hidden" name="id_documento[]">
                                        <input value="Comprobante de pago" class="form-control" type="hidden"
                                            name="nombre_documento[]">
                                        <label for="Comprobante de pago">Adjuntar Etiqueta</label>
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

