<!-- Modal para agregar nuevo predio -->
<div class="modal fade" id="modalEditDestino" tabindex="-1" aria-labelledby="modalEditDestinoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary bg-gradient">
                <h6 id="modalEditDestinoLabel" class="modal-title text-white mb-4">Editar dirección de destino</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body my-8">
                <form id="EditDestinoForm">
                    @csrf
                    <input type="hidden" class="mb-4" id="edit_destinos_id" name="id_direccion">

                    <!-- Tipo de Dirección -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="edit_tipo_direccion" name="tipo_direccion" class="form-select">
                                    <option value="" disabled selected>Selecciona el tipo de dirección</option>
                                    <option value="1">Para exportación</option>
                                    <option value="2">Para venta nacional</option>
                                    <option value="3">Para envío de hologramas</option>
                                </select>
                                <label for="tipo_direccion">Tipo de Dirección</label>
                            </div>
                        </div>

                        <!-- Select de Empresa Cliente -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <select id="edit_id_empresa" onchange="obtenerEtiquetasEdit(this.value);"
                                    name="id_empresa" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona la empresa cliente
                                    </option>
                                    @foreach ($empresas as $empresa)
                                        @if ($empresa->tipo == 2)
                                            <option value="{{ $empresa->id_empresa }}">
                                                {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                                | {{ $empresa->razon_social }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <label for="id_empresa">Empresa Cliente</label>
                            </div>
                        </div>
                    </div>
                    <!-- Domicilio Completo -->
                    <div class="form-floating form-floating-outline mb-4">
                        <textarea class="form-control" id="edit_direccion" name="direccion" placeholder="Domicilio completo" autocomplete="off"></textarea>
                        <label for="direccion">Domicilio Completo</label>
                    </div>
                    <!-- Campos adicionales para exportación -->
                    <div id="exportacionFieldsEdit" style="display: none;">
                        <div class="row mb-4">
                            <!-- Nombre del Destinatario -->
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="edit_destinatario"
                                        name="destinatario" placeholder="Nombre del destinatario" autocomplete="off">
                                    <label for="destinatario">Nombre del Destinatario</label>
                                </div>
                            </div>
                            {{-- </div>

                                <div class="row mb-4"> --}}
                            <!-- Aduana de Despacho -->
                            {{-- <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_aduana" name="aduana"
                                                placeholder="Aduana de despacho"  autocomplete="off">
                                            <label for="aduana">Aduana de Despacho</label>
                                        </div>
                                    </div> --}}

                            <!-- País de Destino -->
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="edit_pais_destino"
                                        name="pais_destino" placeholder="País de destino" autocomplete="off">
                                    <label for="pais_destino">País de Destino</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Campos adicionales para envío de hologramas -->
                    <div id="hologramasFieldsEdit" style="display: none;">
                        <div class="row mb-4">
                            <!-- Correo -->
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" class="form-control" id="edit_correo_recibe"
                                        name="correo_recibe" placeholder="Correo electrónico" autocomplete="off">
                                    <label for="correo_recibe">Correo Electrónico</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <!-- Nombre Completo del Recibe Hologramas -->
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="edit_nombre_recibe"
                                        name="nombre_recibe" autocomplete="off"
                                        placeholder="Nombre completo del receptor de hologramas">
                                    <label for="nombre_recibe">Nombre Completo del Recibe Hologramas</label>
                                </div>
                            </div><!-- Celular -->
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="edit_celular_recibe"
                                        name="celular_recibe" placeholder="Número de teléfono" autocomplete="off">
                                    <label for="celular_recibe">Celular</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <select placeholder="Selecciona una etiqueta" multiple
                                    class="form-select select2 id_etiqueta" id="edit_id_etiqueta"
                                    name="id_etiqueta[]" aria-label="Default select example">
                                </select>
                                <label for="etiqueta">Seleccione una etiqueta</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <button disabled class="btn btn-primary me-2 d-none" type="button"
                            id="loadingEdit">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Actualizando...
                        </button>
                        <button type="submit" class="btn btn-primary me-2" id="btnEdit"><i class="ri-pencil-fill me-1"></i>
                            Editar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal"><i
                                class="ri-close-line me-1"></i>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    /*      function obtenerEtiquetasEdit() {
        var empresa = $('#edit_id_empresa').val();
        if (!empresa) return;

        $.ajax({
            url: '/etiquetas/' + empresa,
            method: 'GET',
            success: function(response) {
                var contenido2 = '';

                response.forEach(function(etiqueta) {
                    contenido2 += `
                          <option value="${etiqueta.id_etiqueta}"
                              data-id_marca="${etiqueta.id_marca}"
                              data-sku="${etiqueta.sku}"
                              data-id_categoria="${etiqueta.id_categoria}"
                              data-id_clase="${etiqueta.id_clase}"
                              data-id_tipo="${etiqueta.id_tipo}">
                            ${etiqueta.marca_nombre} | ${etiqueta.presentacion}${etiqueta.unidad} | ${etiqueta.alc_vol}% Alc. Vol. | ${etiqueta.sku} | ${etiqueta.clase_nombre} | ${etiqueta.categoria_nombre} | ${etiqueta.tipo_nombre}
                          </option>`;
                });

                $('#edit_id_etiqueta').html(contenido2).trigger('change');

                const edit_etiqueta = $('#edit_id_etiqueta').data('selected');
                if (edit_etiqueta) {
                    $('#edit_id_etiqueta').val(edit_etiqueta);
                }

            }
        });
    } */

    function obtenerEtiquetasEdit(id_empresa = null, idsSeleccionadas = []) {
        if (!id_empresa) {
            id_empresa = $('#edit_id_empresa').val();
        }

        // Asegúrate de que sea un array
        if (!Array.isArray(idsSeleccionadas)) {
            idsSeleccionadas = [];
        }

        if (!id_empresa) return;
        $.ajax({
            url: '/etiquetas/' + id_empresa,
            method: 'GET',
            success: function(response) {
                var $select = $('#edit_id_etiqueta');
                $select.empty();

                response.forEach(function(etiqueta) {
                    var selected = idsSeleccionadas.includes(String(etiqueta.id_etiqueta));
                    var option = new Option(
                        `${etiqueta.marca_nombre} | ${etiqueta.presentacion}${etiqueta.unidad} | ${etiqueta.alc_vol}% Alc. Vol. | ${etiqueta.sku} | ${etiqueta.clase_nombre} | ${etiqueta.categoria_nombre} | ${etiqueta.tipo_nombre}`,
                        etiqueta.id_etiqueta,
                        selected,
                        selected
                    );
                    $select.append(option);
                });

                $select.trigger('change');
            }
        });
    }
</script>
