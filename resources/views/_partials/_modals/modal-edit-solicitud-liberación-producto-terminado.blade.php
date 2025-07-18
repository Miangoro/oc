<div class="modal fade" id="editLiberacionProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar solicitud de iberación de producto terminado nacional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <form id="editLiberacionProductoForm">
                    <p class="solicitud badge bg-primary"></p>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" name="id_solicitud" id="edit_id_solicitud_liberacion_terminado">
                            <input type="hidden" name="form_type" value="LiberacionProductoTerminado">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_empresa_solicitud_lib_ter"
                                    onchange="editObtenerInstalacion_lib_ter();" name="id_empresa"
                                    class="select2 form-select">
                                    <option disabled selected value="">Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    name="fecha_solicitud" autocomplete="off" id="sol_LPTN">
                                <label for="fecha_solicitud">Fecha y hora de la solicitud</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input id="edit_fecha_liberacion_terminado" placeholder="YYYY-MM-DD"
                                    class="form-control flatpickr-datetime" type="text" name="fecha_visita" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select select2" id="edit_id_instalacion_lib_ter"
                                    name="id_instalacion" aria-label="id_instalacion" required>
                                    <option value="" disabled selected>Lista de instalaciones</option>
                                    <!-- Aquí se llenarán las opciones con instalaciones del cliente -->
                                </select>
                                <label >Domicilio de inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Selección del Lote Envasado -->
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="edit_id_lote_envasado_lib_ter" name="id_lote_envasado"
                                    class="select2 form-select" onchange="editObtenerDatosLoteEnv();">
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
                                <input type="text" id="edit_id_categoria_lib_ter" disabled readonly
                                    class="bg-light text-muted form-control" placeholder="Categoría" />
                                <label for="categoria" class="text-muted">Categoría</label>
                            </div>
                        </div>

                        <!-- Clase -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="edit_id_clase_lib_ter"disabled readonly
                                    class="bg-light text-muted form-control" placeholder="Clase" />
                                <label for="clase" class="text-muted">Clase</label>
                            </div>
                        </div>
                        <!-- Tipo de Maguey -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="edit_id_tipo_maguey_lib_ter" disabled readonly
                                    class="bg-light text-muted  form-control" placeholder="Tipo de Maguey" />
                                <label for="tipo_maguey" class="text-muted">Tipo de Maguey</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Marca -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="edit_marca_lib_ter" disabled readonly
                                    class="bg-light text-muted  form-control" placeholder="Marca" />
                                <label for="marca" class="text-muted">Marca</label>
                            </div>
                        </div>
                        <!-- % Alc. Vol. -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="edit_porcentaje_alcohol_lib_ter" disabled
                                    name="porcentaje_alcohol" step="0.1" class="form-control bg-light text-muted"
                                    placeholder="% Alc. Vol." />
                                <label for="porcentaje_alcohol">% Alc. Vol.</label>
                            </div>
                        </div>
                        <!-- Análisis Fisicoquímicos -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="edit_analisis_fisiq_lib_ter" disabled
                                    name="analisis_fisicoquimicos" class="form-control bg-light text-muted"
                                    placeholder="Análisis fisicoquímicos" readonly />
                                <label for="analisis_fisicoquimicos">Análisis Fisicoquímicos</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <!-- Certificado de NOM a Granel -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="edit_certificado_nom_granel_lib_ter"
                                    name="certificado_nom_granel" disabled class="form-control bg-light tex-muted"
                                    placeholder="Certificado de NOM a Granel" readonly />
                                <label for="certificado_nom_granel">Certificado de NOM a Granel</label>
                            </div>
                        </div>
                        <!-- Cantidad de Botellas -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="edit_can_botellas_lib_ter" name="cantidad_botellas"
                                    class="form-control" placeholder="Cantidad de Botellas" />
                                <label for="cantidad_botellas">Cantidad de Botellas</label>
                            </div>
                        </div>

                        <!-- Presentación -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="edit_presentacion_lib_ter" name="presentacion"
                                    class="form-control" placeholder="Presentación" />
                                <label for="presentacion">Presentación</label>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <!-- Cantidad de Pallets -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="edit_can_pallets_lib_ter" name="cantidad_pallets"
                                    class="form-control" placeholder="Cantidad de Pallets" />
                                <label for="cantidad_pallets">Cantidad de Pallets</label>
                            </div>
                        </div>
                        <!-- Cantidad de Cajas por Pallet -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="edit_cajas_por_pallet_lib_ter" name="cajas_por_pallet"
                                    class="form-control" placeholder="Cantidad de Cajas por Pallet" />
                                <label for="cajas_por_pallet">Cantidad de Cajas por Pallet</label>
                            </div>
                        </div>

                        <!-- Cantidad de Botellas por Caja -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="edit_botellas_por_caja_lib_ter" name="botellas_por_caja"
                                    class="form-control" placeholder="Cantidad de Botellas por Caja" />
                                <label for="botellas_por_caja">Cantidad de Botellas por Caja</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Hologramas Utilizados -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="edit_hologramas_utilizados_lib_ter"
                                    name="hologramas_utilizados" class="form-control"
                                    placeholder="Hologramas Utilizados" />
                                <label for="hologramas_utilizados">Hologramas Utilizados</label>
                            </div>
                        </div>
                        <!-- Hologramas de Mermas -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="edit_hologramas_mermas_lib_ter" name="hologramas_mermas"
                                    class="form-control" placeholder="Hologramas de Mermas" />
                                <label for="hologramas_mermas">Hologramas de Mermas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-150" id="edit_comentarios_lib_ter"
                                placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="btneditlib"><i
                                class="ri-pencil-fill"></i> Editar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function editObtenerInstalacion_lib_ter() {
        var empresa = $("#edit_id_empresa_solicitud_lib_ter").val();

        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            // Hacer una petición AJAX para obtener los detalles de la empresa
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    /* cargarLotesEnvasado(response.lotes_envasado, response.marcas); */
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
                    $('#edit_id_instalacion_lib_ter').html(contenidoInstalaciones);

                    // Si hay un valor previo, seleccionarlo automáticamente
                    const idInstalacionPrevio = $('#edit_id_instalacion_lib_ter').data('selected');
                    if (idInstalacionPrevio) {
                        $('#edit_id_instalacion_lib_ter').val(idInstalacionPrevio).trigger('change');
                    }
                    const idinsta = $('#edit_id_instalacion_lib_ter').data('selected');
                    if (idinsta) {
                        $('#edit_id_instalacion_lib_ter').val(idinsta);
                    } else if (response.instalaciones.length == 0) {
                        $('#edit_id_instalacion_lib_ter').val("");
                    }

                    // Cargar los detalles de los lotes envasado en el modal
                    var contenidoLotesEnvasado = "";
                    for (let index = 0; index < response.lotes_envasado.length; index++) {
                        contenidoLotesEnvasado = '<option value="' + response.lotes_envasado[index]
                            .id_lote_envasado + '">' +
                            response.lotes_envasado[index].nombre + ' Botellas: ' + response.lotes_envasado[
                                index].cant_botellas + '</option>' +
                            contenidoLotesEnvasado;
                    }
                    if (response.lotes_envasado.length == 0) {
                        contenidoLotesEnvasado =
                            '<option disabled selected value="">Sin lotes envasados registrados</option>';
                    }
                    // Agregar el contenido de los lotes envasado al select correspondiente
                    $('#edit_id_lote_envasado_lib_ter').html(contenidoLotesEnvasado);

                    const idenva = $('#edit_id_lote_envasado_lib_ter').data('selected');
                    if (idenva) {
                        $('#edit_id_lote_envasado_lib_ter').val(idenva);
                    } else if (response.lotes_envasado.length == 0) {
                        $('#edit_id_lote_envasado_lib_ter').val("");
                    }
                    editObtenerDatosLoteEnvPrimero();
                },
                error: function() {
                    console.error('Error al cargar los datos de la empresa.');
                }
            });
        }
    }

    function editObtenerDatosLoteEnvPrimero() {
        var idLoteEnvasado = $("#edit_id_lote_envasado_lib_ter").val();
        if (idLoteEnvasado !== "" && idLoteEnvasado !== null && idLoteEnvasado !== undefined) {
            $.ajax({
                url: '/getDatosLoteEnvasado/' + idLoteEnvasado,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#edit_id_categoria_lib_ter').val(response.primer_lote_granel.nombre_categoria || '');
                    $('#edit_id_clase_lib_ter').val(response.primer_lote_granel.nombre_clase || '');
                    if (response.primer_lote_granel && response.primer_lote_granel.tipos) {
                        // Convertir el array de tipos en una lista separada por comas (texto visible)
                        const tiposTexto = response.primer_lote_granel.tipos
                            .map(tipo => tipo.nombre) // Extraer el campo 'nombre'
                            .join(', '); // Unir los nombres con comas

                        // Asignar el texto al campo visible
                        $('#edit_id_tipo_maguey_lib_ter').val(tiposTexto);
                        // Asignar los IDs al campo oculto como una lista separada por comas
                    } else {
                        // Limpiar los campos si no hay tipos
                        $('#edit_id_tipo_maguey_lib_ter').val('');
                    }
                    $('#edit_marca_lib_ter').val(response.lotes_envasado.marca.marca || '');
                    $('#edit_porcentaje_alcohol_lib_ter').val(response.primer_lote_granel.cont_alc || '');
                    $('#edit_analisis_fisiq_lib_ter').val(response.primer_lote_granel.folio_fq || '');
                    $('#edit_certificado_nom_granel_lib_ter').val(response.primer_lote_granel
                        .folio_certificado || '');
                },
                error: function() {
                    console.error('Error al cargar los datos del lote envasado.');
                }
            });
        }
    }

    function editObtenerDatosLoteEnv() {
        var idLoteEnvasado = $("#edit_id_lote_envasado_lib_ter").val();

        if (idLoteEnvasado !== "" && idLoteEnvasado !== null && idLoteEnvasado !== undefined) {
            // Hacer una petición AJAX para obtener los detalles del lote envasado
            $.ajax({
                url: '/getDatosLoteEnvasado/' + idLoteEnvasado, // Ruta que debe devolver los datos del lote
                method: 'GET',
                success: function(response) {
                    console.log(response);

                    // Asignar los valores de los datos al formulario
                    $('#edit_id_categoria_lib_ter').val(response.primer_lote_granel.nombre_categoria || '');
                    //aqui va ir otrro pero con el id
                    $('#edit_id_clase_lib_ter').val(response.primer_lote_granel.nombre_clase || '');

                    //aqui va ir otrro pero con el id

                    if (response.primer_lote_granel && response.primer_lote_granel.tipos) {
                        // Convertir el array de tipos en una lista separada por comas (texto visible)
                        const tiposTexto = response.primer_lote_granel.tipos
                            .map(tipo => tipo.nombre) // Extraer el campo 'nombre'
                            .join(', '); // Unir los nombres con comas

                        // Asignar el texto al campo visible
                        $('#edit_id_tipo_maguey_lib_ter').val(tiposTexto);
                        // Asignar los IDs al campo oculto como una lista separada por comas
                    } else {
                        // Limpiar los campos si no hay tipos
                        $('#edit_id_tipo_maguey_lib_ter').val('');
                    }

                    $('#edit_marca_lib_ter').val(response.lotes_envasado.marca.marca || '');

                    $('#edit_porcentaje_alcohol_lib_ter').val(response.primer_lote_granel.cont_alc || '');
                    $('#edit_analisis_fisiq_lib_ter').val(response.primer_lote_granel.folio_fq || '');
                    $('#edit_certificado_nom_granel_lib_ter').val(response.primer_lote_granel
                        .folio_certificado || '');

                    $('#edit_can_botellas_lib_ter').val(response.lotes_envasado.cant_botellas || '');
                    $('#edit_presentacion_lib_ter').val(response.lotes_envasado.presentacion || '');

                },
                error: function() {
                    console.error('Error al cargar los datos del lote envasado.');
                }
            });
        }
    }
</script>
