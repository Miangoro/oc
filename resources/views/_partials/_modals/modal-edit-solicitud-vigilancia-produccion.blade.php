<div class="modal fade" id="editVigilanciaProduccion" tabindex="-1">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar Vigilancia en producción de lote</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="editVigilanciaProduccionForm">
                    <input type="hidden" name="id_solicitud" id="edit_id_solicitud_vig">
                    <input type="hidden" name="form_type" value="vigilanciaenproduccion">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange=" obtenerGranelesedit(this.value);obtenerGraneles2(this.value);"
                                    id="edit_id_empresa_vig" name="id_empresa" class="select2 form-select id_empresa">
                                    <option value="" selected disabled>Selecciona Empresa</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Empresa</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime"
                                    id="edit_fecha_visita_vig" type="text" name="fecha_visita" />
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6 input-group ">
                                <select class=" form-select select id_instalacion" id="edit_id_instalacion_vig"
                                    name="id_instalacion" aria-label="id_instalacion">
                                    <option value="" disabled selected>Lista de instalaciones</option>
                                </select>
                                <label for="id_instalacion">instalaciones</label>
                                <button type="button" class="btn btn-primary" id="vigi"><i
                                        class="ri-add-line"></i> Agregar nueva instalación</button>
                            </div>
                        </div>
                    </div>
                    {{-- mio --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="obtenerDatosGranelesedit();" id="edit_id_lote_granel_vig"
                                    name="id_lote_granel" class="select2 form-select">
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
                                <select class="select form-select " id="edit_id_categoria_vig" name="id_categoria"
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
                        <select class="select form-select " id="edit_id_clase_vig" name="id_clase"
                            aria-label="id_clase">
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
                        <select class="select form-select " id="edit_id_tipo_vig" name="id_tipo" aria-label="id_tipo">
                            <option value="">Lista de categorias</option>
                            @foreach ($tipos as $tipos)
                                <option value="{{ $tipos->id_tipo }}">{{ $tipos->nombre }} | {{ $tipos->cientifico }}
                                </option>
                            @endforeach
                        </select>
                        <label for="id_tipo">Ingresa tipo de Maguey</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="edit_analisis_vig" name="analisis"
                            placeholder="Ingresa Análisis fisicoquímico" />
                        <label for="analisis">Ingresa Análisis fisicoquímico</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="edit_volumen_vig" name="volumen"
                            placeholder="Ingresa el volumen" />
                        <label for="volumen">%Alc. Vol.</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime"
                            id="edit_fecha_corte_vig" type="text" name="fecha_corte" />
                        <label for="fecha_corte">Fecha de corte</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="edit_kg_maguey_vig" name="kg_maguey"
                            placeholder="Ingresa la cantidad de maguey" />
                        <label for="kg_maguey">Kg. de maguey</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="edit_cant_pinas_vig" name="cant_pinas"
                            placeholder="Ingrese la cantidad de piñas">
                        <label for="cant_pinas">Cantidad de piñas</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="edit_art_vig" name="art"
                            placeholder="Ingrese la cantidad de azúcares" step="0.01">
                        <label for="art">% de azúcares ART totales</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="edit_etapa_vig" name="etapa"
                            placeholder="Ingrese la etapa de proceso">
                        <label for="etapa">Etapa de proceso en la que se encuentra</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="edit_folio_vig" name="folio"
                            placeholder="Ingrese la guai de traslado">
                        <label for="folio">No.guia de traslado</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="edit_nombre_predio_vig" name="nombre_predio"
                            placeholder="Ingrese el predio de procedencia">
                        <label for="nombre_predio">Predio de la procedencia</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating form-floating-outline mb-5">
                    <textarea name="info_adicional" class="form-control h-px-100" id="edit_info_adicional_vig"
                        placeholder="Observaciones..."></textarea>
                    <label for="info_adicional">Información adicional sobre la actividad</label>
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

<script>
    function obtenerDatosGranelesedit() {
        var lote_granel_id = $("#edit_id_lote_granel_vig").val(); // Asegúrate de que el ID coincide

        if (!lote_granel_id) {
            console.error("No se seleccionó un lote a granel.");
            return;
        }

        $.ajax({
            url: `/getDatos2/${lote_granel_id}`, // Ruta dinámica
            method: 'GET',
            success: function(response) {
                // Validar que response y sus objetos existan antes de acceder
                if (response && response.lotes_granel) {
                    $('#edit_id_categoria_vig').val(response.lotes_granel.id_categoria || '');
                    $('#edit_id_clase_vig').val(response.lotes_granel.id_clase || '');
                    $('#edit_id_tipo_vig').val(response.lotes_granel.id_tipo || '');
                    $('#edit_analisis_vig').val(response.lotes_granel.folio_fq || '');
                    $('#edit_volumen_vig').val(response.lotes_granel.cont_alc || '');
                }

                // Validar si hay guías relacionadas
                if (response && response.lotes_granel_guias && response.lotes_granel_guias.length > 0) {
                    var primeraGuia = response.lotes_granel_guias[0].guia || {};
                    $('#edit_kg_maguey_vig').val(primeraGuia.kg_maguey || '');
                    $('#edit_cant_pinas_vig').val(primeraGuia.num_comercializadas || '');
                    $('#edit_art_vig').val(primeraGuia.art || '');
                    $('#edit_folio_vig').val(primeraGuia.folio || '');

                    // Validar si hay predios relacionados
                    if (primeraGuia.predios) {
                        $('#edit_nombre_predio_vig').val(primeraGuia.predios.nombre_predio || '');
                    } else {
                        $('#edit_nombre_predio_vig').val('');
                    }
                } else {
                    // Resetear campos si no hay guías
                    $('#edit_kg_maguey_vig').val('');
                    $('#edit_cant_pinas_vig').val('');
                    $('#edit_art_vig').val('');
                    $('#edit_folio_vig').val('');
                    $('#edit_nombre_predio_vig').val('');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener datos del lote a granel:", error);
                alert("No se pudieron obtener los datos del lote a granel. Intenta nuevamente.");
            }
        });
    }

    function obtenerGranelesedit(empresa) {
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
                } else {
                }
                $('#edit_id_lote_granel_vig').html(contenido);
            },
            error: function() {}
        });
    }

    function obtenerGraneles2(empresa) {
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                var contenido = "";
                for (let index = 0; index < response.instalaciones.length; index++) {
                    contenido = '<option value="' + response.instalaciones[index].id_instalacion + '">' +
                        response.instalaciones[index].tipo + ' | ' +
                        response.instalaciones[index].direccion_completa +
                        '</option>' + contenido;
                }
                if (response.instalaciones.length == 0) {
                    contenido = '<option value="">Sin instalaciones registradas</option>';
                }
                // Actualizar las opciones del select
                $('#edit_id_instalacion_vig').html(contenido);
                // Restaurar el valor previamente seleccionado
                const idInstalacionSeleccionada = $('#edit_id_instalacion_vig').data('selected');
                if (idInstalacionSeleccionada) {
                    $('#edit_id_instalacion_vig')
                        .val(idInstalacionSeleccionada) // Selecciona el valor previo
                        .trigger('change'); // Propaga el cambio al select
                }
            },
            error: function() {
                console.error("Error al cargar las instalaciones.");
            }
        });
    }
</script>