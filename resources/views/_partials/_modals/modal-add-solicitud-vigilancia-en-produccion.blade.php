<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addVigilanciaProduccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Vigilancia en producción de lote</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addVigilanciaProduccionForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerPredios2(this.value); obtenerGraneles(this.value)"
                                    name="id_empresa" class="select2 form-select id_empresa">
                                    <option value="" disabled>Selecciona cliente</option>
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
                    <div class="form-floating form-floating-outline mb-5">
                        <select onchange="obtenerDatosPredios(this.value);" class="select2 form-select id_predio"
                            name="id_predio" aria-label="id_predio">
                            <option value="" disabled>Lista de predios</option>
                        </select>
                        <label for="id_predio">Domicilio del predio a inspeccionar</label>
                    </div>

                    {{-- mio --}}
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
                                <select class="select form-select id_categoria" name="id_categoria"
                                    aria-label="id_categoria">
                                    <option value="" disabled>Lista de categorias</option>
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
                        <select class="select form-select id_clase" name="id_clase" aria-label="id_clase">
                            <option value="" disabled>Lista de predios</option>
                        </select>
                        <label for="id_clase">Clase</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <select class="select form-select tipo_maguey" name="tipo_maguey" aria-label="tipo_maguey">
                            <option value="" disabled>Lista de categorias</option>
                        </select>
                        <label for="tipo_maguey">Ingresa tipo de Maguey</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="analisis" name=""
                            placeholder="Ingresa Análisis fisicoquímico" />
                        <label for="folio">Ingresa Análisis fisicoquímico</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="" name=""
                            placeholder="Ingresa el volumen" />
                        <label for="folio">%Alc. Vol.</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="date" class="form-control datepicker" id="" name=""
                            placeholder="Ingresa el folio de solicitud" readonly />
                        <label for="folio">Fecha de corte</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="" name=""
                            placeholder="Ingresa la cantidad de maguey" />
                        <label for="folio">Kg. de maguey</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="" name=""
                            placeholder="Ingrese la cantidad">
                        <label for="">Cantidad de piñas</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="" name=""
                            placeholder="Ingrese la cantidad">
                        <label for="">% de azúcares ART totales</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="" name=""
                            placeholder="Ingrese la etapa de proceso">
                        <label for="">Etapa de proceso en la que se encuentra</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="" name=""
                            placeholder="Ingrese la guai de traslado">
                        <label for="">No.guia de traslado</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="" name=""
                            placeholder="Ingrese el predio de procedencia">
                        <label for="">Predio de la procedencia</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating form-floating-outline mb-5">
                    <textarea name="observaciones" class="form-control h-px-100" id="edit_id_observaciones"
                        placeholder="Observaciones..."></textarea>
                    <label for="edit_id_observaciones">Información adicional sobre la actividad</label>
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
    function obtenerDatosGraneles() {
        var lote_granel_id = $("#id_lote_granel").val();

        if (!lote_granel_id) {
            alert("Por favor, selecciona un lote a granel.");
            return;
        }

        $.ajax({
            url: '/getDatos2/' + lote_granel_id,
            method: 'GET',
            success: function(response) {

                $('#id_categoria').val(response.lotes_granel.id_categoria);
                $('#id_categoria').val(response.lotes_granel.id_categoria);
                $('#id_categoria').val(response.lotes_granel.id_categoria);
                $('#id_categoria').val(response.lotes_granel.id_categoria);
                $('#id_categoria').val(response.lotes_granel.id_categoria);
                $('#id_categoria').val(response.lotes_granel.id_categoria);

                $('#id_categoria').val(response.lotes_granel.id_categoria);
                $('#id_categoria').val(response.lotes_granel.id_categoria);
                $('#id_categoria').val(response.lotes_granel.id_categoria);
                $('#id_categoria').val(response.lotes_granel.id_categoria);


                $('#analisis').val(response.lotes_granel.folio_fq);
            },
            error: function() {
                alert('Error al cargar los lotes a granel.');
            }
        });
    }

    //funciones iniciales
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
                } else {

                }
                $('#id_lote_granel').html(contenido);
            },
            error: function() {

            }
        });
    }






    //funciones iniciales
    function obtenerPredios2() {
        var empresa = $(".id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);
                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.instalaciones.length; index++) {
                    contenido = '<option value="' + response.instalaciones[index].id_instalacion + '">' +
                        response
                        .instalaciones[index].tipo + ' | ' + response
                        .instalaciones[index].direccion_completa + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }
                if (response.instalaciones.length == 0) {
                    contenido = '<option value="">Sin instalaciones registradas</option>';

                } else {

                }
                $('#id_instalacion').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }



    function obtenerDatosPredios(id_predio) {
        $.ajax({
            url: '/domicilios-predios/' + id_predio + '/edit',
            method: 'GET',
            success: function(response) {
                console.log(response);
                var info_adicional =
                    'Predio: ' + response.predio.nombre_predio + '. ' +
                    'Punto de referencia: ' + response.predio.puntos_referencia + '. ' +
                    'Superficie: ' + response.predio.superficie + 'H';
                $('.info_adicional').val(info_adicional);
            },
            error: function() {

            }
        });
    }
</script>
