<div class="modal fade" id="editInspeccionEnvasado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar Inspección de envasado</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="editInspeccionEnvasadoForm">
                    <input type="hidden" name="id_solicitud" id="edit_id_solicitud_inspeccion">
                    <input type="hidden" name="form_type" value="inspeccionenvasado">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_empresa_inspeccion"
                                    onchange="editobtenerInstalacionesInspecciones(); editobtenerGranelesInspecciones(this.value);"
                                    name="id_empresa" class="id_empresa_inspeccion select2 form-select" required>
                                    <option value="" disabled selected>Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}</option>
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
                                <select class=" form-select" id="edit_id_instalacion_inspeccion" name="id_instalacion"
                                    aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                                <button type="button" class="btn btn-primary" id="modalMuestreoInspeccion"><i
                                        class="ri-add-line"></i> Agregar nueva instalación</button>
                            </div>
                        </div>
                    </div>
                    <p class="address-subtitle" style="color: red">Seleccione un cliente</p>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-4">
                            <select onchange="editobtenerDatosGranelesInspecciones();"
                                id="edit_id_lote_granel_inspeccion" name="id_lote_granel_inspeccion"
                                class="select2 form-select">
                                <option value="" disabled selected>Selecciona lote a granel</option>
                                @foreach ($LotesGranel as $lotesgra)
                                    <option value="{{ $lotesgra->id_lote_granel }}">{{ $lotesgra->nombre_lote }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="id_lote_granel_inspeccion">Lote a granel</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_categoria_inspeccion" name="id_categoria_inspeccion"
                                    placeholder="Ingresa una Categoria" readonly style="pointer-events: none;" />
                                <label for="id_categoria_inspeccion">Ingresa Categoria</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_clase_inspeccion" name="id_clase_inspeccion"
                                    placeholder="Ingresa una Clase" readonly style="pointer-events: none;" />
                                <label for="id_clase_inspeccion">Ingresa Clase</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control bg-light text-muted"
                                id="edit_id_tipo_maguey_inspeccion" name="id_tipo_maguey_inspeccion"
                                placeholder="Ingresa un tipo de Maguey" readonly style="pointer-events: none;" />
                            <label for="id_tipo_maguey_inspeccion">Ingresa Tipo de Maguey</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="edit_id_marca"
                                    name="id_marca" placeholder="Ingresa una Categoria" readonly
                                    style="pointer-events: none;" />
                                <label for="id_marca">Ingresa Marca</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_volumen_inspeccion"
                                    name="volumen_inspeccion" placeholder="Ingresa el volumen" />
                                <label for="volumen_inspeccion">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_analisis_inspeccion"
                                    name="analisis_inspeccion" placeholder="Ingresa Análisis fisicoquímico" />
                                <label for="analisis_inspeccion">Ingresa Análisis fisicoquímico</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_tipo_inspeccion" name="id_tipo_inspeccion" class="form-select">
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="Con etiqueta">Con etiqueta</option>
                                    <option value="Sin etiqueta">Sin etiqueta</option>
                                </select>
                                <label for="id_tipo_inspeccion">Tipo</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_id_cantidad_bote"
                                    name="id_cantidad_bote" placeholder="Cantidad de botellas" />
                                <label for="id_cantidad_bote">Cantidad de botellas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_id_cantidad_caja"
                                    name="id_cantidad_caja" placeholder="Cantidad de cajas" />
                                <label for="id_cantidad_caja">Cantidad de cajas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control " id="edit_id_inicio_envasado"
                                    name="id_inicio_envasado" placeholder="Inicio de envasado" />
                                <label for="id_inicio_envasado">Inicio de envasado</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control " id="edit_id_previsto" name="id_previsto"
                                    placeholder="Termino previsto del envasado" />
                                <label for="id_previsto">Termino previsto del envasado</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_id_certificado_inspeccion"
                                    name="id_certificado_inspeccion"
                                    placeholder="Ingresa el Certificado de NOM a granel" />
                                <label for="id_certificado_inspeccion">Ingresa Certificado de NOM a granel</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="edit_info_adicional"
                                placeholder="Observaciones..."></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad (NO. DE GARRAFAS Y
                                CONTENEDORES):</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary " data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editobtenerInstalacionesInspecciones() {
        var empresa = $("#edit_id_empresa_inspeccion").val();
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    var contenido = "";
                    for (let index = 0; index < response.instalaciones.length; index++) {
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);
                        contenido = '<option value="' + response.instalaciones[index].id_instalacion +
                            '">' +
                            tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>' +
                            contenido;
                    }
                    if (response.instalaciones.length == 0) {
                        contenido = '<option value="">Sin instalaciones registradas</option>';
                    }
                    $('#edit_id_instalacion_inspeccion').html(contenido);
                },
                error: function() {}
            });
        }
    }

    function editobtenerGranelesInspecciones(empresa) {
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
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
                    $('#edit_id_lote_granel_inspeccion').html(contenido);
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

    function editobtenerDatosGranelesInspecciones() {
        var lote_granel_id = $("#edit_id_lote_granel_inspeccion").val();
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
            $.ajax({
                url: '/getDatos2/' + lote_granel_id,
                method: 'GET',
                success: function(response) {
                    $('#edit_id_categoria_inspeccion').val(response.categoria ? response.categoria
                        .categoria :
                        '');
                    $('#edit_id_clase_inspeccion').val(response.clase ? response.clase.clase : '');
                    if (response.tipo && response.tipo.length > 0) {
                        var tiposConcatenados = response.tipo.map(function(tipo) {
                            return tipo.nombre + ' (' + tipo.cientifico + ')';
                        }).join(', '); // Unir con coma
                        $('#edit_id_tipo_maguey_inspeccion').val(tiposConcatenados);
                    } else {
                        $('#edit_id_tipo_maguey_inspeccion').val('');
                    }
                    $('#edit_id_marca').val(response.marca || '');
                    $('#edit_analisis_inspeccion').val(response.lotes_granel.folio_fq);
                    $('#edit_volumen_inspeccion').val(response.lotes_granel.cont_alc);
                    $('#edit_id_certificado_inspeccion').val(response.lotes_granel.folio_certificado);
                },
                error: function() {
                    console.error('Error al obtener los datos del lote granel.');
                }
            });
        }
    }
</script>
