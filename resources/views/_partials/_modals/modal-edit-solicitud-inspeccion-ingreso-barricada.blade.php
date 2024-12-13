<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="editInspeccionIngresoBarricada" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar Inspeccion ingreso a barrica/ contenedor de vidrio</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="editInspeccionIngresoBarricadaForm">
                    <input type="hidden" name="id_solicitud" id="edit_id_solicitud_barricada">
                    <input type="hidden" name="form_type" value="muestreobarricada">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_empresa_barricada"
                                    onchange="editobtenerInstalacionesBarricada(); editobtenerGranelesBarricada(this.value);"
                                    name="id_empresa" class="id_empresa_barricada select2 form-select" required>
                                    <option value="" disabled selected>Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }} | {{ $empresa->razon_social }}</option>
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
                                <select class=" form-select" id="edit_id_instalacion_barricada" name="id_instalacion"
                                    aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                                <button type="button" class="btn btn-primary" id="modalMuestreo"><i
                                        class="ri-add-line"></i> Agregar nueva instalación</button>
                            </div>
                        </div>
                    </div>
                    <p class="address-subtitle" style="color: red">Seleccione un cliente</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="editobtenerDatosGranelesBarricada();" id="edit_id_lote_granel_barricada"
                                    name="id_lote_granel_barricada" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona lote a granel</option>
                                    @foreach ($LotesGranel as $lotesgra)
                                        <option value="{{ $lotesgra->id_lote_granel }}">{{ $lotesgra->nombre_lote }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_lote_granel_barricada">Lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_categoria_barricada" name="id_categoria_barricada"
                                    placeholder="Ingresa una Categoria" readonly style="pointer-events: none;" />
                                <label for="id_categoria_barricada">Ingresa Categoria</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="edit_id_clase_barricada"
                                    name="id_clase_barricada" placeholder="Ingresa una Clase" readonly
                                    style="pointer-events: none;" />
                                <label for="id_clase_barricada">Ingresa Clase</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_tipo_maguey_barricada" name="id_tipo_maguey_barricada"
                                    placeholder="Ingresa un tipo de Maguey" readonly style="pointer-events: none;" />
                                <label for="id_tipo_maguey_barricada">Ingresa Tipo de Maguey</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="edit_id_edad"
                                    name="id_edad" placeholder="Ingresa una Edad" readonly
                                    style="pointer-events: none;" />
                                <label for="id_edad">Ingresa Edad</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_analisis_barricada"
                                    name="analisis_barricada" placeholder="Ingresa Análisis fisicoquímico" />
                                <label for="analisis_barricada">Ingresa Análisis fisicoquímico</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_volumen_barricada"
                                    name="volumen_barricada" placeholder="Ingresa el volumen" />
                                <label for="volumen_barricada">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_tipo_lote" name="tipo_lote" class="form-select">
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="Ingreso de producto en barrica">Ingreso de producto en barrica
                                    </option>
                                    <option value="Ajuste de grado alcohólico">Ingreso de porductos en contenido de
                                        vidrio</option>
                                </select>
                                <label for="tipo_lote">Tipo</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control datepicker"
                                    type="date" id="edit_fecha_inicio" name="fecha_inicio" readonly/>
                                <label for="fecha_inicio">Fecha de inicio ingreso/liberación </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control datepicker"
                                    type="date" id="edit_fecha_termino" name="fecha_termino" readonly/>
                                <label for="fecha_termino">Fecha de término ingreso/liberación
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_material" name="material"
                                    placeholder="Material de los recipientes" />
                                <label for="material">Material de los recipientes</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_capacidad" name="capacidad"
                                    placeholder="Capacidad de recipientes" />
                                <label for="capacidad">Capacidad de recipientes</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_num_recipientes"
                                    name="num_recipientes" placeholder="Número de recipientes" />
                                <label for="num_recipientes">Número de recipientes</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_tiempo_dura" name="tiempo_dura"
                                    placeholder="Tiempo de maduración" />
                                <label for="tiempo_dura">Tiempo de maduración</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_id_certificado_barricada"
                                    name="id_certificado_barricada" placeholder="Certificado de NOM a granel" />
                                <label for="id_certificado_barricada">Certificado de NOM a granel </label>
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
                        <button type="reset" class="btn btn-outline-secondary " data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function editobtenerInstalacionesBarricada() {
        var empresa = $("#edit_id_empresa_barricada").val();
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
                $('#edit_id_instalacion_barricada').html(contenido);
            },
            error: function() {}
        });
    }

    function editobtenerGranelesBarricada(empresa) {
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
                $('#edit_id_lote_granel_barricada').html(contenido);
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

    function editobtenerDatosGranelesBarricada() {
        var lote_granel_id = $("#edit_id_lote_granel_barricada").val();
        $.ajax({
            url: '/getDatos2/' + lote_granel_id,
            method: 'GET',
            success: function(response) {
                $('#edit_id_categoria_barricada').val(response.categoria ? response.categoria.categoria : '');
                $('#edit_id_clase_barricada').val(response.clase ? response.clase.clase : '');
                if (response.tipo) {
                    var tipoConcatenado = response.tipo.nombre + ' (' + response.tipo.cientifico + ')';
                    $('#edit_id_tipo_maguey_barricada').val(tipoConcatenado);
                } else {
                    $('#edit_id_tipo_maguey_barricada').val('');
                }
                $('#edit_id_edad').val(response.lotes_granel.edad);
                $('#edit_analisis_barricada').val(response.lotes_granel.folio_fq);
                $('#edit_volumen_barricada').val(response.lotes_granel.cont_alc);
            },
            error: function() {
                console.error('Error al obtener los datos del lote granel.');
            }
        });
    }
</script>
