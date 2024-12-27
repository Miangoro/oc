<div class="modal fade" id="addMuestreoLoteAgranel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Muestreo de Lote a granel</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addMuestreoLoteAgranelForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_empresa_muestreo"
                                    onchange="obtenerInstalacionesMuestreo(); obtenerGranelesMuestreo(this.value);"
                                    name="id_empresa" class="id_empresa_muestreo select2 form-select" required>
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
                                    id="fecha_visita" name="fecha_visita" />
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6 input-group ">
                                <select class=" form-select" id="id_instalacion_muestreo" name="id_instalacion"
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
                                <select onchange="obtenerDatosGranelesMuestreo();" id="id_lote_granel_muestreo"
                                    name="id_lote_granel_muestreo" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona lote a granel</option>
                                    @foreach ($LotesGranel as $lotesgra)
                                        <option value="{{ $lotesgra->id_lote_granel }}">{{ $lotesgra->nombre_lote }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_lote_granel_muestreo">Lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="tipo_analisis" name="destino_lote" class="form-select">
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="Análisis completo">Análisis completo</option>
                                    <option value="Ajuste de grado alcohólico">Ajuste de grado alcohólico</option>
                                </select>
                                <label for="destino_lote">Tipo</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="id_categoria_muestreo" name="id_categoria_muestreo"
                                    placeholder="Ingresa una Categoria" readonly style="pointer-events: none;" />
                                <label for="id_categoria_muestreo">Ingresa Categoria</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="id_clase_muestreo"
                                    name="id_clase_muestreo" placeholder="Ingresa una Clase" readonly
                                    style="pointer-events: none;" />
                                <label for="id_clase_muestreo">Ingresa Clase</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control bg-light text-muted marca"
                                id="id_tipo_maguey_muestreo" name="id_tipo_maguey_muestreo[0]"
                                placeholder="Ingresa un tipo de Maguey" readonly style="pointer-events: none;" />
                            <label for="id_tipo_maguey_muestreo">Ingresa Tipo de Maguey</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="analisis_muestreo"
                                    name="analisis_muestreo" placeholder="Ingresa Análisis fisicoquímico" />
                                <label for="analisis_muestreo">Ingresa Análisis fisicoquímico</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="volumen_muestreo"
                                    name="volumen_muestreo" placeholder="Ingresa el volumen" />
                                <label for="volumen_muestreo">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="id_certificado_muestreo"
                                    name="id_certificado_muestreo"
                                    placeholder="Ingresa el Certificado de NOM a granel" />
                                <label for="id_certificado_muestreo">Ingresa Certificado de NOM a granel</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="info_adicional" placeholder="Observaciones..."></textarea>
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
    function obtenerInstalacionesMuestreo() {
        var empresa = $("#id_empresa_muestreo").val();
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);
                var contenido = "";
                for (let index = 0; index < response.instalaciones.length; index++) {
                    var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);
                    contenido = '<option value="' + response.instalaciones[index].id_instalacion + '">' +
                        tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                        '</option>' +
                        contenido;
                }
                if (response.instalaciones.length == 0) {
                    contenido = '<option value="">Sin instalaciones registradas</option>';
                }
                $('#id_instalacion_muestreo').html(contenido);
            },
            error: function() {}
        });
    }

    function obtenerGranelesMuestreo(empresa) {
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
                $('#id_lote_granel_muestreo').html(contenido);
            },
            error: function() {}
        });
    }

    function limpiarTipo(tipo) {
        if (tipo.startsWith('[') && tipo.endsWith(']')) {
            try {
                return JSON.parse(tipo).join(', ');
            } catch (e) {
                return tipo;
            }
        }
        return tipo;
    }

    function obtenerDatosGranelesMuestreo() {
        var lote_granel_id = $("#id_lote_granel_muestreo").val();
        $.ajax({
            url: '/getDatos2/' + lote_granel_id,
            method: 'GET',
            success: function(response) {
                $('#id_categoria_muestreo').val(response.categoria ? response.categoria.categoria : '');
                $('#id_clase_muestreo').val(response.clase ? response.clase.clase : '');
                if (response.tipo && response.tipo.length > 0) {
                    //Obtener varios tipos
                    var tiposConcatenados = response.tipo.map(function(tipo) {
                        return tipo.nombre + ' (' + tipo.cientifico + ')';
                    }).join(', ');
                    $('#id_tipo_maguey_muestreo').val(tiposConcatenados);
                } else {
                    $('#id_tipo_maguey_muestreo').val('');
                }
                $('#analisis_muestreo').val(response.lotes_granel.folio_fq || '');
                $('#volumen_muestreo').val(response.lotes_granel.cont_alc || '');
                $('#id_certificado_muestreo').val(response.lotes_granel.folio_certificado || '');
            },
            error: function() {
                console.error('Error al obtener los datos del lote granel.');
            }
        });
    }

    // Limpiar campos al cerrar el modal
    $('#addMuestreoLoteAgranel').on('hidden.bs.modal', function() {
        $('#id_empresa_muestreo').val('');
        $('#id_instalacion_muestreo').html('<option value="" selected>Lista de instalaciones</option>');
        $('#id_lote_granel_muestreo').val('');
        $('#destino_lote').val('');
        $('#id_categoria_muestreo').val('');
        $('#id_clase_muestreo').val('');
        $('#id_tipo_maguey_muestreo').val('');
        $('#analisis_muestreo').val('');
        $('#volumen_muestreo').val('');
        $('#id_certificado_muestreo').val('');
        $('#info_adicional').val('');
        if (typeof formValidator !== 'undefined') {
            formValidator.resetForm(true);
        }
    });
</script>
