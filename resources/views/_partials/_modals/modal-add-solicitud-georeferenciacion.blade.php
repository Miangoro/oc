<!-- Add New Solicitud Georreferenciacion Modal -->
<div class="modal fade" id="addSolicitudGeoreferenciacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Registrar nueva solicitud de georeferenciación</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-8">
                <form id="addRegistrarSolicitudGeoreferenciacion">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerPredios2(this.value); " name="id_empresa"
                                    class="select2 form-select id_empresa" required id="id_empresa_georefere">
                                    <option selected disabled value="">Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
{{-- obtenerDestinoEmpresa();
<div class="col-md-4">
    <div class="form-floating form-floating-outline mb-6">
        <select id="id_empresa_destino" name="id_empresa_destino" class="select2 form-select" data-error-message="por favor selecciona la empresa">
            <option value="" disabled selected>Selecciona la empresa destino</option>
        </select>
        <label for="id_empresa_destino" class="form-label">Empresa destino</label>
    </div>
</div>
 --}}

                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    name="fecha_solicitud" id="fecha_sol_geo" value="@php
                                      echo date('Y-m-d H:i');
                                    @endphp">
                                <label for="fecha_solicitud">Fecha y hora de la solicitud</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    name="fecha_visita" id="fecha_visita_geo" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <select onchange="obtenerDatosPredios(this.value);" class="select2 form-select id_predio"
                                name="id_predio" aria-label="id_predio" id="id_predio_georefe">
                                <option value="" disabled selected>Lista de predios</option>
                            </select>
                            {{-- <label for="id_predio">Domicilio del predio a inspeccionar</label> --}}
                            <label >Domicilio de inspección</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="Dirección del punto de reunión" class="form-control" type="text"
                                    name="punto_reunion" id="punto_reunion_georefere" />
                                <label for="num_anterior">Dirección del punto de reunión</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-150 info_adicional" id="info"
                                placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button disabled class="btn btn-primary me-1 d-none" type="button"
                            id="btnSpinnerGeoreferenciacion">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Registrando...
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnRegistrarGeo"><i
                                class="ri-add-line me-1"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger btnCancelar" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line me-1"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function obtenerPredios2(empresa) {
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    // Cargar los detalles en el modal
                    var contenido = "";
                    for (let index = 0; index < response.predios.length; index++) {
                        contenido = '<option value="' + response.predios[index].id_predio + '">' + response
                            .predios[index].nombre_predio + ' | ' + response
                            .predios[index].ubicacion_predio + '</option>' + contenido;
                    }
                    if (response.predios.length == 0) {
                        contenido = '<option value="">Sin predios registrados</option>';
                    }
                    $('.id_predio').html(contenido);
                    if (response.predios.length != 0) {
                        obtenerDatosPredios($(".id_predio").val());
                    } else {
                        $('.info_adicional').val("");
                    }


                },
                error: function() {
                    //alert('Error al cargar los lotes a granel.');
                }
            });
        }
    }

    function obtenerDatosPredios(id_predio) {
        if (id_predio !== "" && id_predio !== null && id_predio !== undefined) {
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
    }





/*
///NUEVA FUNCION
function obtenerDestinoEmpresa() {
    var empresa = $("#id_empresa_georefere").val();
    if (!empresa) return;

    $.ajax({
        url: '/getDatosMaquila/' + empresa,
        method: 'GET',
        success: function(response) {
            var $selectDestino = $('#id_empresa_destino');
             var $selectDestinoContainer = $('#select_destino');
            var $selectEmpresaContainer = $('#select_empresa');
            $selectDestino.empty();

            var opciones = [];

            if (response.empresasDestino.length > 0) {
                response.empresasDestino.forEach(function(emp) {
                    var numeroCliente = (emp.empresa_num_clientes[0]?.numero_cliente ??
                                         emp.empresa_num_clientes[1]?.numero_cliente ?? '');
                    opciones.push(`<option value="${emp.id_empresa}">${numeroCliente} | ${emp.razon_social}</option>`);
                });
            } else {
                opciones.push(`<option value="${empresa}" selected>Propia empresa</option>`);
            }

            $selectDestino.append(opciones.join(''));

            // Deshabilitar si solo hay una opción
            if ($selectDestino.find('option').length === 1) {
                $selectDestino.prop('disabled', true);
                 $selectDestinoContainer.addClass('d-none'); // Oculta el select destino si solo hay uno
                $selectEmpresaContainer.removeClass('col-md-12').addClass('col-md-12'); // Mantiene la empresa principal full width
            } else {
                $selectDestino.prop('disabled', false);
                $selectDestinoContainer.removeClass('d-none');
                $selectEmpresaContainer.removeClass('col-md-12').addClass('col-md-6'); // Ajusta ancho
            }

            $(document).trigger('empresaDestinoCargada', [$selectDestino]);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los datos de la empresa:', error);
            alert('Error al cargar los datos. Por favor, intenta nuevamente.');
        }
    });
} 

    // Llamar a obtenerDatosEmpresa cuando se selecciona la empresa
    $('#id_empresa').change(function() {
        obtenerDestinoEmpresa();
    }); 
*/

</script>
