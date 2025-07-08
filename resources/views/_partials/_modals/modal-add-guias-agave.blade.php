<!-- MODAL AGREGAR -->
<div class="modal fade" id="addGuias" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Registrar nueva Guía de traslado Agave/Maguey</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <p class="address-subtitle"></p>
            </div>

            <div class="modal-body">
                <form id="addGuiaForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <select id="id_empresa" name="empresa" class="select2 form-select" required>
                                <option value="" disabled selected>Selecciona cliente</option>
                                @foreach ($empresa as $id_cliente)
                                    <option value="{{ $id_cliente->id_empresa }}">
                                        {{ $id_cliente->empresaNumClientes[0]->numero_cliente ?? $id_cliente->empresaNumClientes[1]->numero_cliente }}
                                        | {{ $id_cliente->razon_social }}</option>
                                    </option>
                                @endforeach
                            </select>
                            <label for="id_empresa">Cliente</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="number" placeholder="Número de guías solicitadas"
                                id="numero_guias" name="numero_guias" required />
                            <label for="numero_guias">Número de guías solicitadas</label>
                        </div>
                    </div>
                </div>

                    
                <div class="form-floating form-floating-outline mb-6">
                    <select class="select2 form-select " id="nombre_predio" name="predios"
                        required>
                        {{--data-placeholder="selecciona un predio" <option value="" disabled selected>Seleccione un predio</option> --}}
                    </select>
                    <label>Lista de predios</label>
                </div>
                <div class="form-floating form-floating-outline mb-6">
                    <select class="select2 form-select " id="id_plantacion" name="plantacion"
                        required>
                        {{--data-placeholder="selecciona una caracteristica" <option value="" disabled selected>>Plantación del predio</option> --}}
                    </select>
                    <label>Características del predio</label>
                </div>


                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Datos para Guía de traslado</h4>
                    <p class="address-subtitle"> <b style="color: red"> (DATOS NO OBLIGATORIOS SI NO CUENTA CON
                            ELLOS DEJAR LOS ESPACIOS VACIOS)</b></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="number" placeholder="Número de plantas anterior"
                                id="num_anterior" name="anterior" oninput="calcularPlantasActualmente()" readonly />
                            <label for="num_anterior">Número de plantas anterior</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="number"
                                placeholder="Número de plantas comercializadas" id="num_comercializadas"
                                name="comercializadas" oninput="calcularPlantasActualmente()" />
                            <label for="num_comercializadas">Número de plantas comercializadas</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="number" placeholder="Mermas plantas"
                                id="mermas_plantas" name="mermas" oninput="calcularPlantasActualmente()" />
                            <label for="mermas_plantas">Mermas plantas</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="number" placeholder="Número de plantas actualmente"
                                id="numero_plantas" name="plantas" readonly />
                            <label for="numero_plantas">Número de plantas actualmente</label>
                        </div>
                    </div>
                </div>

                <!--AGREGADO NO OBLIGATORIO-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="text" placeholder="Ingrese la edad" id="edad"
                                name="edad" />
                            <label>Edad</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <input step="any" class="form-control" type="number" placeholder="%ART"
                                id="art" name="art" />
                            <label>%ART</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-5">
                            <input step="any" class="form-control" type="number"
                                placeholder="Ingrese la cantiad de maguey" id="kg_magey" name="kg_maguey" />
                            <label>KG de maguey</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="text"
                                placeholder="Ingrese un numero de lote o tapada" id="no_lote_pedido"
                                name="no_lote_pedido" />
                            <label>No. de lote o No. de tapada</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="date" class="form-control datepicker" id="fecha_corte"
                                placeholder="fecha_corte" name="fecha_corte" readonly>
                            <label>Fecha de corte</label>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <textarea name="observaciones" class="form-control h-px-100" id="observaciones"
                            placeholder="Observaciones..."></textarea>
                        <label>Observaciones</label>
                    </div>
                    
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control form-control-sm" type="file" name="url[]">
                        <input value="71" class="form-control" type="hidden" name="id_documento[]">
                        <input value="Guía de traslado de agave" class="form-control" type="hidden"
                            name="nombre_documento[]">
                        <label for="Guía de traslado de agave">Adjuntar Guia escaneada</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control form-control-sm" type="file" name="url[]">
                        <input value="132" class="form-control" type="hidden" name="id_documento[]">
                        <input value="Resultados ART" class="form-control" type="hidden"
                            name="nombre_documento[]" step="0.01">
                        <label for="Resultados ART">Adjuntar resultados de ART</label>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Datos del comprador</h4>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="text"
                                placeholder="Ingrese el nombre del cliente/comprador" id="nombre_cliente"
                                name="nombre_cliente" min="1" />
                            <label>Nombre del cliente/comprador</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="text"
                                placeholder="Ingrese el No. del cliente/comprador" id="no_cliente"
                                name="no_cliente" />
                            <label>No del cliente/comprador</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="date" class="form-control datepicker" id="fecha_ingreso"
                                placeholder="fecha_ingreso" name="fecha_ingreso"
                                readonly>
                            <label>Fecha de ingreso</label>
                        </div>
                    </div>
                </div>

                <div class="form-floating form-floating-outline mb-5">
                    <input class="form-control" type="text" placeholder="Ingrese el domicilio de entrega"
                        id="domicilio" name="domicilio" />
                    <label>Domicilio de entrega</label>
                </div>
                    
                



                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i>
                            Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Función para restar los campos
    function calcularPlantasActualmente() {
        // Obtener los valores de los inputs
        const numAnterior = parseFloat(document.getElementById('num_anterior').value) || 0;
        const numComercializadas = parseFloat(document.getElementById('num_comercializadas').value) || 0;
        const mermasPlantas = parseFloat(document.getElementById('mermas_plantas').value) || 0;
        // Calcular el número de plantas actualmente
        let plantasActualmente = numAnterior - numComercializadas - mermasPlantas;
        if (plantasActualmente < 0) {
            plantasActualmente = 0;
        }
        document.getElementById('numero_plantas').value = plantasActualmente;
    }

    //Limpia en cancelar
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#addGuias .btn-outline-secondary').addEventListener('click',
            function() {
                document.getElementById('addGuiaForm').reset();
                $('.select2').val(null).trigger('change');
            });
    });
</script>
