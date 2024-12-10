<div class="modal fade" id="addVigilanciaProduccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Vigilancia en producción de lote</h4>
                </div>
                <form id="addVigilanciaProduccionForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_empresa_vigilancia" onchange=" obtenerGraneles(this.value);obtenerGranelesInsta(this.value);"
                                    name="id_empresa" class=" select2 form-select" required>
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
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime"
                                    id="fecha_visita" type="text" name="fecha_visita" />
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6 input-group ">
                                <select class=" form-select select id_instalacion" id="id_instalacion"
                                    name="id_instalacion" aria-label="id_instalacion">
                                    <option value="" disabled selected>Lista de instalaciones</option>
                                </select>
                                <label for="id_instalacion">instalaciones</label>
                                <button type="button" class="btn btn-primary" id="modalVigilancia"><i
                                        class="ri-add-line"></i> Agregar nueva instalación</button>
                            </div>
                        </div>
                    </div>
                    <p class="address-subtitle" style="color: red">Seleccione un  cliente</p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="obtenerDatosGraneles();" id="id_lote_granel" name="id_lote_granel"
                                    class="select2 form-select">
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($LotesGranel as $lotesgra)
                                        <option value="{{ $lotesgra->id_lote_granel }}">{{ $lotesgra->nombre_lote }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_lote_granel">Lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select form-select " id="id_categoria" name="id_categoria"
                                    aria-label="id_categoria">
                                    <option value="">Lista de categorias</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->categoria }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_categoria">Categoria</label>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <select class="select form-select " id="id_clase" name="id_clase" aria-label="id_clase">
                            <option value="">Lista de clases</option>
                            @foreach ($clases as $clases)
                                <option value="{{ $clases->id_clase }}">{{ $clases->clase }}
                                </option>
                            @endforeach
                        </select>
                        <label for="id_clase">Clase</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <select class="select2 form-select" id="id_tipo_maguey" name="id_tipo_maguey[]" aria-label="id_tipo" multiple>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }} | {{ $tipo->cientifico }}</option>
                            @endforeach
                        </select>
                        
                        <label for="id_tipo">Ingresa tipo de Maguey</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="analisis" name="analisis"
                            placeholder="Ingresa Análisis fisicoquímico" />
                        <label for="analisis">Ingresa Análisis fisicoquímico</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="volumen" name="volumen"
                            placeholder="Ingresa el volumen" />
                        <label for="volumen">%Alc. Vol.</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" id="fecha_corte"
                            type="text" name="fecha_corte" />
                        <label for="fecha_corte">Fecha de corte</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="kg_maguey" name="kg_maguey"
                            placeholder="Ingresa la cantidad de maguey" />
                        <label for="kg_maguey">Kg. de maguey</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="cant_pinas" name="cant_pinas"
                            placeholder="Ingrese la cantidad de piñas">
                        <label for="cant_pinas">Cantidad de piñas</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="art" name="art"
                            placeholder="Ingrese la cantidad de azúcares" step="0.01">
                        <label for="art">% de azúcares ART totales</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="etapa" name="etapa"
                            placeholder="Ingrese la etapa de proceso">
                        <label for="etapa">Etapa de proceso en la que se encuentra</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="folio" name="folio"
                            placeholder="Ingrese la guai de traslado">
                        <label for="folio">No.guia de traslado</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="nombre_predio" name="nombre_predio"
                            placeholder="Ingrese el predio de procedencia">
                        <label for="nombre_predio">Predio de la procedencia</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating form-floating-outline mb-5">
                    <textarea name="info_adicional" class="form-control h-px-100" id="info_adicional" placeholder="Observaciones..."></textarea>
                    <label for="info_adicional">Información adicional sobre la actividad</label>
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

<script>
    function obtenerDatosGraneles() {
        var lote_granel_id = $("#id_lote_granel").val();
        $.ajax({
            url: '/getDatos2/' + lote_granel_id,
            method: 'GET',
            success: function(response) {
                $('#id_categoria').val(response.lotes_granel.id_categoria);
                $('#id_clase').val(response.lotes_granel.id_clase);
                $('#id_tipo_maguey').val(response.lotes_granel.id_tipo).trigger('change');
                $('#analisis').val(response.lotes_granel.folio_fq);
                $('#volumen').val(response.lotes_granel.cont_alc);
                if (response.lotes_granel_guias.length > 0 && response.lotes_granel_guias[0].guia) {
                    $('#kg_maguey').val(response.lotes_granel_guias[0].guia
                        .kg_maguey);
                } else {
                    $('#kg_maguey').val('');
                }
                if (response.lotes_granel_guias.length > 0 && response.lotes_granel_guias[0].guia) {
                    $('#cant_pinas').val(response.lotes_granel_guias[0].guia
                        .num_comercializadas);
                } else {
                    $('#cant_pinas').val('');
                }
                if (response.lotes_granel_guias.length > 0 && response.lotes_granel_guias[0].guia) {
                    $('#art').val(response.lotes_granel_guias[0].guia.art);
                } else {
                    $('#art').val('');
                }
                if (response.lotes_granel_guias.length > 0 && response.lotes_granel_guias[0].guia) {
                    $('#folio').val(response.lotes_granel_guias[0].guia.folio);
                } else {
                    $('#folio').val('');
                }
                // Acceder a id_predio y nombre_predio de la relación predios
                if (response.lotes_granel_guias[0].guia.predios) {
                    $('#nombre_predio').val(response.lotes_granel_guias[0].guia.predios
                        .nombre_predio); // Nombre del predio
                }
            },
            error: function() {}
        });
    }

    function obtenerGraneles(empresa) {
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
                $('#id_lote_granel').html(contenido);
            },
            error: function() {}
        });
    }

    function obtenerGranelesInsta(empresa) {
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
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
                $('.id_instalacion').html(contenido);
            },
            error: function() {
                console.error('Error al obtener las instalaciones.');
            }
        });
    }

    function limpiarTipo(tipo) {
        try {
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            return tipo;
        }
    }
</script>
