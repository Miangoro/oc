<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="editInspeccionLiberacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar Inspección de liberación a barrica/contenedor de vidrio</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="editInspeccionLiberacionForm">
                    <input type="hidden" name="id_solicitud" id="edit_id_solicitud_liberacion">
                    <input type="hidden" name="form_type" value="muestreobarricadaliberacion">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_empresa_liberacion"
                                    onchange="editobtenerInstalacionesLiberacion(); editobtenerGranelesLiberacion(this.value);"
                                    name="id_empresa" class="id_empresa_barricada select2 form-select" required>
                                    <option value="" disabled selected>Selecciona cliente</option>
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
                                    id="edit_fecha_visita" name="fecha_visita" />
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6 input-group ">
                                <select class=" form-select" id="edit_id_instalacion_liberacion" name="id_instalacion"
                                    aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                                <button type="button" class="btn btn-primary" id="modalVigilanciaBarricadaLiberacion"><i
                                        class="ri-add-line"></i> Agregar nueva instalación</button>
                            </div>
                        </div>
                    </div>
                    <p class="address-subtitle" style="color: red">Seleccione un cliente</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="editobtenerDatosGranelesLiberacion();" id="edit_id_lote_granel_liberacion"
                                    name="id_lote_granel_liberacion" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona lote a granel</option>
                                    @foreach ($LotesGranel as $lotesgra)
                                        <option value="{{ $lotesgra->id_lote_granel }}">{{ $lotesgra->nombre_lote }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_lote_granel_liberacion">Lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_categoria_liberacion" name="id_categoria_liberacion"
                                    placeholder="Ingresa una Categoria" readonly style="pointer-events: none;" />
                                <label for="id_categoria_liberacion">Ingresa Categoria</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="edit_id_clase_liberacion"
                                    name="id_clase_liberacion" placeholder="Ingresa una Clase" readonly
                                    style="pointer-events: none;" />
                                <label for="id_clase_liberacion">Ingresa Clase</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_tipo_maguey_liberacion" name="id_tipo_maguey_liberacion"
                                    placeholder="Ingresa un tipo de Maguey" readonly style="pointer-events: none;" />
                                <label for="id_tipo_maguey_liberacion">Ingresa Tipo de Maguey</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="edit_id_edad_liberacion"
                                    name="id_edad_liberacion" placeholder="Ingresa una Edad" readonly
                                    style="pointer-events: none;" />
                                <label for="id_edad_liberacion">Ingresa Edad</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_analisis_liberacion"
                                    name="analisis_liberacion" placeholder="Ingresa Análisis fisicoquímico" />
                                <label for="analisis_liberacion">Ingresa Análisis fisicoquímico</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_volumen_liberacion"
                                    name="volumen_liberacion" placeholder="Ingresa el volumen" />
                                <label for="volumen_liberacion">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_tipo_lote_lib" name="tipo_lote_lib" class="form-select">
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="Liberación de producto en barrica">Liberación de producto en barrica
                                    </option>
                                    <option value="Liberación de producto en contenedor de vidrio">Liberación de
                                        producto en contenedor de vidrio</option>
                                </select>
                                <label for="tipo_lote_lib">Tipo</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control datepicker"
                                    type="date" id="edit_fecha_inicio_lib" name="fecha_inicio_lib" readonly/>
                                <label for="fecha_inicio_lib">Fecha de inicio ingreso/liberación </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control datepicker"
                                    type="date" id="edit_fecha_termino_lib" name="fecha_termino_lib" readonly/>
                                <label for="fecha_termino_lib">Fecha de término ingreso/liberación
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_material_liberacion" name="material_liberacion"
                                    placeholder="Material de los recipientes" />
                                <label for="material_liberacion">Material de los recipientes</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_capacidad_liberacion" name="capacidad_liberacion"
                                    placeholder="Capacidad de recipientes" />
                                <label for="capacidad_liberacion">Capacidad de recipientes</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_num_recipientes_lib"
                                    name="num_recipientes_lib" placeholder="Número de recipientes" />
                                <label for="num_recipientes_lib">Número de recipientes</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_tiempo_dura_lib" name="tiempo_dura_lib"
                                    placeholder="Tiempo de maduración" />
                                <label for="tiempo_dura_lib">Tiempo de maduración</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_id_certificado_liberacion"
                                    name="id_certificado_liberacion" placeholder="Certificado de NOM a granel" />
                                <label for="id_certificado_liberacion">Certificado de NOM a granel </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="edit_info_adicional" placeholder="Observaciones..."></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad (NO. DE GARRAFAS Y
                                CONTENEDORES):</label>
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
    function editobtenerInstalacionesLiberacion() {
        var empresa = $("#edit_id_empresa_liberacion").val();
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);
                var contenido = "";
                for (let index = 0; index < response.instalaciones.length; index++) {
                    // Limpia el campo tipo usando la función limpiarTipo
                    var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);

                    contenido = '<option value="' + response.instalaciones[index].id_instalacion + '">' +
                        tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                        '</option>' +
                        contenido;
                }
                if (response.instalaciones.length == 0) {
                    contenido = '<option value="">Sin instalaciones registradas</option>';
                }
                $('#edit_id_instalacion_liberacion').html(contenido);
            },
            error: function() {}
        });
    }

    function editobtenerGranelesLiberacion(empresa) {
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                var contenido = "";
                for (let index = 0; index < response.lotes_granel.length; index++) {
                    contenido = '<option value="' + response.lotes_granel[index].id_lote_granel + '">' +
                        response
                        .lotes_granel[index].nombre_lote + '</option>' + contenido;
                }
                if (response.lotes_granel.length == 0) {
                    contenido = '<option value="">Sin lotes registrados</option>';
                } else {}
                $('#edit_id_lote_granel_liberacion').html(contenido);
            },
            error: function() {}
        });
    }

    function limpiarTipo(tipo) {
        try {
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            return tipo;
        }
    }

    function editobtenerDatosGranelesLiberacion() {
        var lote_granel_id = $("#edit_id_lote_granel_liberacion").val();
        $.ajax({
            url: '/getDatos2/' + lote_granel_id,
            method: 'GET',
            success: function(response) {
                $('#edit_id_categoria_liberacion').val(response.categoria ? response.categoria.categoria : '');
                $('#edit_id_clase_liberacion').val(response.clase ? response.clase.clase : '');
                if (response.tipo) {
                    var tipoConcatenado = response.tipo.nombre + ' (' + response.tipo.cientifico + ')';
                    $('#edit_id_tipo_maguey_liberacion').val(tipoConcatenado);
                } else {
                    $('#edit_id_tipo_maguey_liberacion').val('');
                }
                $('#edit_id_edad_liberacion').val(response.lotes_granel.edad);
                $('#edit_analisis_liberacion').val(response.lotes_granel.folio_fq);
                $('#edit_volumen_liberacion').val(response.lotes_granel.cont_alc);
            },
            error: function() {
                console.error('Error al obtener los datos del lote granel.');
            }
        });
    }
</script>