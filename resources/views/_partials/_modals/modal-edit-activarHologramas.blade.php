<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="edit_activarHologramas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnCloseModal"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Modificar Hologramas Activos</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="edit_activarHologramasForm" method="POST" enctype="multipart/form-data"
                    onsubmit="return false">
                    <div class="row">
                        <input type="hidden" id="edit_id" name="id">
                        <input type="hidden" id="edit_id_solicitud" name="edit_id_solicitud">
                        <div class="form-floating form-floating-outline mb-6">
                            <select id="edit_id_inspeccion" name="edit_id_inspeccion" class="form-select select2"
                                aria-label="Default select example">
                                <option value="" disabled selected>Elige un numero de inspección</option>
                                @foreach ($inspeccion as $insp)
                                    <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }}</option>
                                @endforeach
                            </select>
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
                                <select class=" form-select select2" id="edit_categoria" name="edit_categoria"
                                    aria-label="categoría">
                                    <option value="" disabled selected>Elige una categoría</option>
                                    @foreach ($categorias as $cate)
                                        <option value="{{ $cate->categoria }}">{{ $cate->categoria }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_categoria">Categoría Mezcal</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="No de análisis de laboratorio:"
                                    id="edit_no_analisis" name="edit_no_analisis" />
                                <label for="edit_no_analisis">No de análisis de laboratorio:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" step="0.01"
                                    placeholder="Contenido neto por botellas (ml/L):" id="edit_cont_neto"
                                    name="edit_cont_neto" />
                                <label for="edit_cont_neto">Contenido neto por botellas (ml/L):</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" id="edit_unidad" name="edit_unidad" aria-label="Unidad">
                                    <option value="Litros">Litros</option>
                                    <option value="Mililitros">Mililitros</option>
                                    <option value="Centilitros">Centilitros</option>
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
                                <input class="form-control" type="text" placeholder="Contenido Alcohólico:"
                                    id="edit_contenido" name="edit_contenido" />
                                <label for="edit_contenido">Contenido Alcohólico:</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="No. de lote de envasado:"
                                    id="edit_no_lote_envasado" name="edit_no_lote_envasado" />
                                <label for="edit_no_lote_envasado">No. de lote de envasado:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select class=" form-select select2" id="edit_id_tipo" name="edit_id_tipo"
                                    aria-label="categoría">
                                    <option value="" disabled selected>Elige una categoría</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_id_tipo">Categoría Agave</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Lugar de producción:"
                                    id="edit_lugar_produccion" name="edit_lugar_produccion" />
                                <label for="edit_lugar_produccion">Lugar de producción: </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" step="0.01"
                                    placeholder="Lugar de envasado:" id="edit_lugar_envasado"
                                    name="edit_lugar_envasado" />
                                <label for="edit_lugar_envasado">Lugar de envasado:</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Activar</h4>
                        <p class="address-subtitle"></p>
                    </div>
                    {{--                     <div style="display: none;" id="mensaje" role="alert"></div>
 --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><button type="button" class="btn btn-primary add-row-edit"> <i
                                            class="ri-add-line"></i>
                                    </button></th>
                                <th>Rango inicial</th>
                                <th>Rango final</th>
                            </tr>
                        </thead>
                        <tbody id="edit_contenidoRango">
                            <tr>
                                <th>
                                    <button type="button" class="btn btn-danger remove-row" disabled> <i
                                            class="ri-delete-bin-5-fill"></i> </button>
                                </th>
                                <td>
                                    <input type="number" class="form-control form-control-sm"
                                        name="edit_rango_inicial[]" id="folio_inicial" placeholder="Rango inicial"
                                        min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm"
                                        name="edit_rango_final[]" id="folio_final" placeholder="Rango final"
                                        min="0">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Mermas (Opcional)</h4>
                        <p class="address-subtitle"></p>
                    </div>
                    {{--                     <div style="display: none;" id="mensaje" role="alert"></div>
 --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><button type="button" class="btn btn-primary add-row-editMermas"> <i
                                            class="ri-add-line"></i>
                                    </button></th>
                                <th>Mermas</th>
                            </tr>
                        </thead>
                        <tbody id="edit_contenidoMermas">
                            <tr>
                                <th>
                                    <button type="button" class="btn btn-danger remove-row" disabled> <i
                                            class="ri-delete-bin-5-fill"></i> </button>
                                </th>
                                <td>
                                    <input type="number" class="form-control form-control-sm" name="edit_mermas[]"
                                        id="mermas" min="0" placeholder="Mermas">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close" id="btnCancelModal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    //funcion para reditrigir a otra vista
    document.addEventListener("DOMContentLoaded", function() {
        // Selecciona los botones por su id
        const closeModalButtons = [document.getElementById("btnCloseModal"), document.getElementById(
            "btnCancelModal")];

        closeModalButtons.forEach(button => {
            button.addEventListener("click", function(event) {
                // Encuentra el modal padre del botón de cierre
                const modalElement = button.closest('.modal');

                // Asegúrate de que no sea el modal #verGuiasRegistardas
                if (modalElement && modalElement.id !== "activosHologramas") {
                    // Espera a que el modal actual se cierre antes de abrir el nuevo modal
                    setTimeout(() => {
                        // Abre el modal de guías registradas
                        const activosHologramasModal = new bootstrap.Modal(document
                            .getElementById("activosHologramas"));
                        activosHologramasModal.show();
                    },
                    300); // Ajusta el tiempo para asegurar que el modal anterior se cierre completamente
                }
            });
        });
    });
</script>
