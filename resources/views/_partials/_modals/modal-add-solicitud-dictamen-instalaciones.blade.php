<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addSolicitudDictamen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Registrar nueva solicitud de dictaminación de instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <form id="addRegistrarSolicitud">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_empresa_solicitudes" onchange="obtenerInstalaciones(); " name="id_empresa"
                                    class="id_empresa_dic select2 form-select" required>
                                    <option value="" disabled selected>Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}</option>
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>


{{-- 
obtenerDestinoEmpresa();
<div class="col-md-4">
    <div class="form-floating form-floating-outline mb-6">
        <select id="id_empresa_destino" name="id_empresa_destino" class="select2 form-select" data-error-message="por favor selecciona la empresa">
            <option value="" disabled selected>Selecciona la empresa destino</option>

        </select>
        <label for="id_empresa_destino" class="form-label">Empresa destino</label>
    </div>
</div> --}}



                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    name="fecha_solicitud" id="fecha_sol_dic_ins"
                                    value="@php echo date('Y-m-d H:i'); @endphp">
                                <label for="fecha_solicitud">Fecha y hora de la solicitud</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    id="fechaSoliInstalacion" name="fecha_visita" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select select2" id="id_instalacion_dic" name="id_instalacion"
                                    aria-label="id_instalacion">
                                    <option value="" disabled selected>Lista de instalaciones</option>

                                </select>
                                 <label >Domicilio de inspección</label>
                            </div> {{-- Domicilio de la instalación --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6 select2-dark">
                                <select name="categorias[]" class="form-select select2"
                                    placeholder="Seleccione una o más categorias" multiple id="categoriaDictamenIns">
                                    @foreach ($categorias as $cate)
                                        <option value="{{ $cate->id_categoria }}">{{ $cate->categoria }}</option>
                                    @endforeach
                                </select>
                                <label for="">Categorías de mezcal</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4 select2-dark">
                                <select id="clasesDicIns" name="clases[]" class="form-select select2"
                                    placeholder="Seleccione una o más clases" multiple>
                                    @foreach ($clases as $clase)
                                        <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                                </select>
                                <label for="">Clases de mezcal</label>
                            </div>
                        </div>

                        <!-- Nuevo select para renovación -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select name="renovacion" id="renovacion" class="form-select">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="si">Sí</option>
                                    <option value="no">No</option>
                                </select>
                                <label for="renovacion">¿Es renovación?</label>
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
                        <button disabled class="btn btn-primary me-1 d-none" type="button"
                            id="loading_dictamen">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Registrando...
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnRegistrarDicIns"><i
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
    function obtenerInstalaciones() {
        var empresa = $(".id_empresa_dic").val();
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
                    $('#id_instalacion_dic').html(contenido);
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




/* 
function obtenerDestinoEmpresa() {
    var empresa = $("#id_empresa_solicitudes").val();
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
