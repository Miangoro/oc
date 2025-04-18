<div class="modal fade" id="addLiberacionProducto" tabindex="-1">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Liberación de producto terminado nacional</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addLiberacionProductoForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_empresa_solicitud_lib_ter" onchange="obtenerInstalacion_lib_ter();"
                                    name="id_empresa" class="select2 form-select">
                                    <option disabled selected value="">Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    name="fecha_visita" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6 input-group ">
                                <select class=" form-select" id="id_instalacion_lib_ter" name="id_instalacion"
                                    aria-label="id_instalacion" required>
                                    <option value="" disabled selected>Lista de instalaciones</option>
                                    <!-- Aquí se llenarán las opciones con instalaciones del cliente -->
                                </select>

                                <button type="button" class="btn btn-primary" id="abrirModalInstalaciones"><i
                                        class="ri-add-line"></i> Agregar nueva instalación</button>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Selección del Lote Envasado -->
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="id_lote_envasado_lib_ter" name="id_lote_envasado"
                                    class="select2 form-select" onchange="ObtenerDatosLoteEnv();">
                                    <option disabled selected value="">Selecciona lote envasado</option>
                                    <!-- Opciones dinámicas aquí -->
                                </select>
                                <label for="lote_envasado">Lote Envasado</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Categoría -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="id_categoria_lib_ter" name=""disabled readonly
                                    class="bg-light text-muted form-control" placeholder="Categoría" />
                                <label for="categoria" class="text-muted">Categoría</label>
                            </div>
                            <input type="hidden" id="id_categoria_lib_ter_id" name="id_categoria">
                        </div>

                        <!-- Clase -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="id_clase_lib_ter"disabled readonly name=""
                                    class="bg-light text-muted form-control" placeholder="Clase" />
                                <label for="clase" class="text-muted">Clase</label>
                            </div>
                            <input type="hidden" id="id_clase_lib_ter_id" name="id_clase">
                        </div>
                        <!-- Tipo de Maguey -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="id_tipo_maguey_lib_ter" disabled readonly name=""
                                    class="bg-light text-muted  form-control" placeholder="Tipo de Maguey" />
                                <label for="tipo_maguey" class="text-muted">Tipo de Maguey</label>
                            </div>
                            <input type="hidden" id="id_tipo_maguey_lib_ter_ids" name="id_tipo[]">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Marca -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="marca_lib_ter" name="" disabled readonly
                                    class="bg-light text-muted  form-control" placeholder="Marca" />
                                <label for="marca" class="text-muted">Marca</label>
                            </div>
                            <input type="hidden" id="marca_lib_ter_id" name="marca">
                        </div>
                        <!-- % Alc. Vol. -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="porcentaje_alcohol_lib_ter" name="porcentaje_alcohol"
                                    step="0.1" class="form-control" placeholder="% Alc. Vol." />
                                <label for="porcentaje_alcohol">% Alc. Vol.</label>
                            </div>
                        </div>
                        <!-- Análisis Fisicoquímicos -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="analisis_fisiq_lib_ter" name="analisis_fisicoquimicos"
                                    class="form-control" placeholder="Análisis fisicoquímicos" />
                                <label for="analisis_fisicoquimicos">Análisis Fisicoquímicos</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- Cantidad de Botellas -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="can_botellas_lib_ter" name="cantidad_botellas"
                                    class="form-control" placeholder="Cantidad de Botellas" />
                                <label for="cantidad_botellas">Cantidad de Botellas</label>
                            </div>
                        </div>

                        <!-- Presentación -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="presentacion_lib_ter" name="presentacion"
                                    class="form-control" placeholder="Presentación" />
                                <label for="presentacion">Presentación</label>
                            </div>
                        </div>
                        <!-- Cantidad de Pallets -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="can_pallets_lib_ter" name="cantidad_pallets"
                                    class="form-control" placeholder="Cantidad de Pallets" />
                                <label for="cantidad_pallets">Cantidad de Pallets</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">


                        <!-- Cantidad de Cajas por Pallet -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="cajas_por_pallet_lib_ter" name="cajas_por_pallet"
                                    class="form-control" placeholder="Cantidad de Cajas por Pallet" />
                                <label for="cajas_por_pallet">Cantidad de Cajas por Pallet</label>
                            </div>
                        </div>

                        <!-- Cantidad de Botellas por Caja -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="botellas_por_caja_lib_ter" name="botellas_por_caja"
                                    class="form-control" placeholder="Cantidad de Botellas por Caja" />
                                <label for="botellas_por_caja">Cantidad de Botellas por Caja</label>
                            </div>
                        </div>
                        <!-- Hologramas Utilizados -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="hologramas_utilizados_lib_ter" name="hologramas_utilizados"
                                    class="form-control" placeholder="Hologramas Utilizados" />
                                <label for="hologramas_utilizados">Hologramas Utilizados</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <!-- Hologramas de Mermas -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="hologramas_mermas_lib_ter" name="hologramas_mermas"
                                    class="form-control" placeholder="Hologramas de Mermas" />
                                <label for="hologramas_mermas">Hologramas de Mermas</label>
                            </div>
                        </div>
                        <!-- Certificado de NOM a Granel -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="certificado_nom_granel_lib_ter"
                                    name="certificado_nom_granel" class="form-control"
                                    placeholder="Certificado de NOM a Granel" />
                                <label for="certificado_nom_granel">Certificado de NOM a Granel</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-150" id="comentarios"
                                placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary btnCancelar" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function obtenerInstalacion_lib_ter() {
        var empresa = $("#id_empresa_solicitud_lib_ter").val();

        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            // Hacer una petición AJAX para obtener los detalles de la empresa
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    cargarLotesEnvasado(response.lotes_envasado, response.marcas);
                    // Cargar los detalles de instalaciones en el modal
                    var contenidoInstalaciones = "";
                    for (let index = 0; index < response.instalaciones.length; index++) {
                        // Limpia el campo tipo usando la función limpiarTipo
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);

                        contenidoInstalaciones = '<option value="' + response.instalaciones[index]
                            .id_instalacion + '">' +
                            tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>' +
                            contenidoInstalaciones;
                    }
                    if (response.instalaciones.length == 0) {
                        contenidoInstalaciones = '<option value="">Sin instalaciones registradas</option>';
                    }

                    // Agregar el contenido de las instalaciones al select correspondiente
                    $('#id_instalacion_lib_ter').html(contenidoInstalaciones);

                    // Si hay un valor previo, seleccionarlo automáticamente
                    const idInstalacionPrevio = $('#id_instalacion_lib_ter').data('selected');
                    if (idInstalacionPrevio) {
                        $('#id_instalacion_lib_ter').val(idInstalacionPrevio).trigger('change');
                    }

                    // Cargar los detalles de los lotes envasado en el modal
                    var contenidoLotesEnvasado = "";
                    for (let index = 0; index < response.lotes_envasado.length; index++) {
                        contenidoLotesEnvasado = '<option value="' + response.lotes_envasado[index]
                            .id_lote_envasado + '">' +
                            response.lotes_envasado[index].nombre + '</option>' +
                            contenidoLotesEnvasado;
                    }
                    if (response.lotes_envasado.length == 0) {
                        contenidoLotesEnvasado =
                            '<option disabled selected value="">Sin lotes envasados registrados</option>';
                    }
                    // Agregar el contenido de los lotes envasado al select correspondiente
                    $('#id_lote_envasado_lib_ter').html(contenidoLotesEnvasado);
                    

                },
                error: function() {
                    console.error('Error al cargar los datos de la empresa.');
                }
            });
        }
    }

    function ObtenerDatosLoteEnv() {
        var idLoteEnvasado = $("#id_lote_envasado_lib_ter").val();

        if (idLoteEnvasado !== "" && idLoteEnvasado !== null && idLoteEnvasado !== undefined) {
            // Hacer una petición AJAX para obtener los detalles del lote envasado
            $.ajax({
                url: '/getDatosLoteEnvasado/' + idLoteEnvasado, // Ruta que debe devolver los datos del lote
                method: 'GET',
                success: function(response) {
                    console.log(response);

                    // Asignar los valores de los datos al formulario
                    $('#id_categoria_lib_ter').val(response.primer_lote_granel.nombre_categoria || '');
                    $('#id_categoria_lib_ter_id').val(response.primer_lote_granel.id_categoria || '');
                    //aqui va ir otrro pero con el id
                    $('#id_clase_lib_ter').val(response.primer_lote_granel.nombre_clase || '');
                    $('#id_clase_lib_ter_id').val(response.primer_lote_granel.id_clase || '');
                    //aqui va ir otrro pero con el id

                    if (response.primer_lote_granel && response.primer_lote_granel.tipos) {
                        // Convertir el array de tipos en una lista separada por comas (texto visible)
                        const tiposTexto = response.primer_lote_granel.tipos
                            .map(tipo => tipo.nombre) // Extraer el campo 'nombre'
                            .join(', '); // Unir los nombres con comas

                        // Asignar el texto al campo visible
                        $('#id_tipo_maguey_lib_ter').val(tiposTexto);

                        // Extraer solo los IDs de los tipos
                        const tiposIds = response.primer_lote_granel.tipos.map(tipo => tipo.id_tipo);
                        // Asignar los IDs al campo oculto como una lista separada por comas
                        $('#id_tipo_maguey_lib_ter_ids').val(tiposIds.join(','));
                    } else {
                        // Limpiar los campos si no hay tipos
                        $('#id_tipo_maguey_lib_ter').val('');
                        $('#id_tipo_maguey_lib_ter_ids').val('');
                    }

                    $('#marca_lib_ter').val(response.lotes_envasado.marca.marca || '');
                    $('#marca_lib_ter_id').val(response.lotes_envasado.id_marca || '');
                    $('#porcentaje_alcohol_lib_ter').val(response.primer_lote_granel.cont_alc || '');
                    $('#analisis_fisiq_lib_ter').val(response.primer_lote_granel.folio_fq || '');
                    $('#certificado_nom_granel_lib_ter').val(response.primer_lote_granel
                        .folio_certificado || '');
                    $('#can_botellas_lib_ter').val(response.lotes_envasado.cant_botellas || '');
                    $('#presentacion_lib_ter').val(response.lotes_envasado.presentacion || '');

                },
                error: function() {
                    console.error('Error al cargar los datos del lote envasado.');
                }
            });
        }
    }
</script>
