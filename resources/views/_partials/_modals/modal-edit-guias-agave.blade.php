<!-- Edit Guide Modal -->
<div class="modal fade" id="editGuias" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Llenar Guía de Traslado Agave/Maguey</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="editGuiaForm">
                    <!-- Hidden field to store the ID of the guia being edited -->
                    <input type="hidden" id="edit_id_guia" name="id_guia">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="editobtenerNombrePredio(); editobtenerPlantacionPredio();"
                                    id="edit_id_empresa" name="empresa" class="select2 form-select" required>
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($empresa as $id_cliente)
                                        <option value="{{ $id_cliente->id_empresa }}">{{ $id_cliente->razon_social }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="edit_id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Número de guías solicitadas"
                                    id="edit_numero_guias" name="numero_guias" required />
                                <label for="edit_numero_guias">Número de guías solicitadas</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select" id="edit_nombre_predio" name="predios" aria-label="Predio"
                            required>
                            /*Se puede quitar*/
                            @foreach ($predios as $id_predio)
                                <option value="{{ $id_predio->id_empresa }}">{{ $id_predio->nombre_predio }}</option>
                            @endforeach
                            <option value="" selected>Lista de predios</option>
                        </select>
                        <label for="edit_nombre_predio">Lista de predios</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select" id="edit_id_plantacion" name="plantacion"
                            aria-label="Plantación" required>
                            <option value="" selected>Plantación del predio</option>
                        </select>
                        <label for="edit_id_plantacion">Características del predio</label>
                    </div>

                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Datos para Guía de Traslado</h4>
                        <p class="address-subtitle"> <b style="color: red"> (DATOS NO OBLIGATORIOS SI NO CUENTA CON
                                ELLOS DEJAR LOS ESPACIOS VACÍOS)</b></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Número de plantas anterior"
                                    id="edit_num_anterior" name="anterior" oninput="editcalcularPlantasActualmente()" />
                                <label for="edit_num_anterior">Número de plantas anterior</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number"
                                    placeholder="Número de plantas comercializadas" id="edit_num_comercializadas"
                                    name="comercializadas" oninput="editcalcularPlantasActualmente()" />
                                <label for="edit_num_comercializadas">Número de plantas comercializadas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Mermas plantas"
                                    id="edit_mermas_plantas" name="mermas"
                                    oninput="editcalcularPlantasActualmente()" />
                                <label for="edit_mermas_plantas">Mermas plantas</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Número de plantas actualmente"
                                    id="edit_numero_plantas" name="plantas" readonly />
                                <label for="edit_numero_plantas">Número de plantas actualmente</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control" type="number" placeholder="%ART"
                            id="edit_id_art" name="art" />
                        <label for="edit_id_art">%ART</label>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number"
                                    placeholder="Ingrese la cantiad de maguey" id="edit_kg_magey"
                                    name="kgmaguey" />
                                <label for="edit_kg_magey">KG de maguey</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="text"
                                    placeholder="Ingrese un numero de lote o tapada" id="edit_no_lote_pedido"
                                    name="lotepedido" />
                                <label for="edit_no_lote_pedido">No. de lote o No. de tapada</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="date" class="form-control" id="edit_fecha_corte" placeholder="fecha"
                                    name="fechacorte" aria-label="fechacorte">
                                <label for="edit_fecha_corte">Fecha de corte</label>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="text" placeholder="Ingrese observaciones"
                                id="edit_id_observaciones" name="observaciones" />
                            <label for="edit_id_observaciones">Observaciones</label>
                        </div>
{{--                         <div class="form-floating form-floating-outline">
                            <input class="form-control form-control-sm" type="file" id="file" name="url[]">
                            <input value="0" class="form-control" type="hidden" name="id_documento[]">
                            <input value="Certificado de instalaciones" class="form-control" type="hidden" name="nombre_documento[]">
                            <label for="certificado_instalaciones">Adjuntar Certificado de instalaciones</label>
                        </div>

                        <div class="form-floating form-floating-outline">
                            <input class="form-control form-control-sm" type="file" id="file" name="url[]">
                            <input value="0" class="form-control" type="hidden" name="id_documento[]">
                            <input value="Certificado de instalaciones" class="form-control" type="hidden" name="nombre_documento[]">
                            <label for="certificado_instalaciones">Adjuntar Certificado de instalaciones</label>
                        </div> --}}
                    </div>
{{-- 
                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Datos del comprador</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="text"
                                    placeholder="Número de plantas actualmente" id=""
                                    name="plantas" />
                                <label for="">Nombre del cliente/comprador</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number"
                                    placeholder="Número de plantas actualmente" id=""
                                    name="plantas" />
                                <label for="">No del cliente/comprador</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="date" class="form-control" id="" placeholder="fecha"
                                    name="fecha_emision" aria-label="Nombre">
                                <label for="">Fecha de ingreso</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control" type="text" placeholder="Número de plantas actualmente"
                            id="" name="plantas" />
                        <label for="">Domicilio de entrega</label>
                    </div>                    
                </div> --}}
                
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function editobtenerNombrePredio() {
        var empresa = $("#edit_id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);

                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.predios.length; index++) {
                    contenido = '<option value="' + response.predios[index].id_predio + '">' + response
                        .predios[index].nombre_predio + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.predios.length == 0) {
                    contenido = '<option value="">Sin predios registradas</option>';
                }
                $('#edit_nombre_predio').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }

    function editobtenerPlantacionPredio() {
        var empresa = $("#edit_id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);

                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.predio_plantacion.length; index++) {
                    contenido = '<option value="' + response.predio_plantacion[index].id_plantacion +
                        '">Número de plantas: ' + response
                        .predio_plantacion[index].num_plantas + ' | Tipo de agave: ' + response
                        .predio_plantacion[index].nombre + ' ' + response
                        .predio_plantacion[index].cientifico + ' | Año de platanción: ' + response
                        .predio_plantacion[index].anio_plantacion + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.predio_plantacion.length == 0) {
                    contenido = '<option value="">Sin predios registradas</option>';
                }
                $('#edit_id_plantacion').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }

    // Función para restar los campos
    function editcalcularPlantasActualmente() {
        // Obtener los valores de los inputs
        const numAnterior = parseFloat(document.getElementById('edit_num_anterior').value) || 0;
        const numComercializadas = parseFloat(document.getElementById('edit_num_comercializadas').value) || 0;
        const mermasPlantas = parseFloat(document.getElementById('edit_mermas_plantas').value) || 0;


        // Calcular el número de plantas actualmente
        let plantasActualmente = numAnterior - numComercializadas - mermasPlantas;

        // Evitar números negativos
        if (plantasActualmente < 0) {
            plantasActualmente = 0;
        }

        // Asignar el valor calculado al input
        document.getElementById('edit_numero_plantas').value = plantasActualmente;
    }
</script>
