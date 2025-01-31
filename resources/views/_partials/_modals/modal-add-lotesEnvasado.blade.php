<div class="modal fade" id="addlostesEnvasado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nuevo lote envasado</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addNewLoteForm">
                    <div class="col-12">
                        <div class="form-floating form-floating-outline mb-4">
                            <select id="id_empresa" name="id_empresa" class="select2 form-select">
                                <option value="">Selecciona cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id_empresa }}">
                                        {{ $cliente->empresaNumClientes[0]->numero_cliente ?? $cliente->empresaNumClientes[1]->numero_cliente }}
                                        | {{ $cliente->razon_social }}</option>
                                @endforeach
                            </select>
                            <label for="id_empresa">Cliente</label>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="nombre"
                            placeholder="Introduce el nombre del lote" name="nombre" aria-label="Nombre del lote" />
                        <label for="nombre">Nombre del lote envasado</label>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="destino_lote" name="destino_lote" class="form-select">
                                    <option value="" disabled selected>Selecciona el destino del lote</option>
                                    <option value="1">Nacional</option>
                                    <option value="2">Exportación</option>
                                    <option value="3">Stock</option>
                                </select>
                                <label for="destino_lote">Destino lote</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" id="sku" class="form-control"
                                    placeholder="No. de pedido/SKU" aria-label="No. de pedido/SKU" name="sku" />
                                <label for="sku">No. de pedido/SKU</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select id_marca" id="id_marca" name="id_marca"
                                    aria-label="Marca">
                                    <option value="" selected>Selecciona una marca</option>
                                </select>
                                <label for="id_marca">Marca</label>
                            </div>
                        </div>
                    </div>



                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th style="width: 40px"><button type="button" class="btn btn-primary btn-sm add-row"> <i
                                            class="ri-add-line"></i> </button></th>
                                <th>Lote a granel</th>
                                <th>Volumen en litros</th>
                            </tr>
                        </thead>
                        <tbody id="contenidoGraneles">
                            <tr>
                                <th>
                                    <button type="button" class="btn btn-danger btn-sm remove-row" disabled> <i
                                            class="ri-delete-bin-5-fill"></i> </button>
                                </th>
                                <td>
                                    <select class="id_lote_granel form-control form-control-sm select2" name="id_lote_granel[]"
                                        id="id_lote_granel">
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm"
                                        name="volumen_parcial[]" id="volumen_parcial"> 
                                </td>
                            </tr>
                        </tbody>
                    </table>




                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" placeholder="Ingrese un valor"
                                    id="cantidad_botellas" name="cant_botellas" min="1" required />
                                <label for="cantidad_botellas">Cantidad de botellas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" placeholder="Presentación de la botella"
                                    id="presentacion" name="presentacion" min="1" />
                                <label for="presentacion">Presentación de la botella</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" id="unidad" name="unidad" aria-label="Unidad">
                                    <option value="mL">Mililitros</option>
                                    <option value="L">Litros</option>
                                    <option value="cL">Centrilitros</option>
                                </select>
                                <label for="unidad">Unidad</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label class="form-label" for="basic-default-password42">Instalación de envasado certificada</label>
                            <div class="input-group">
                                <select placeholder="Selecciona el cliente" class="form-select id_instalacion"
                                    id="lugar_envasado" name="lugar_envasado" aria-label="Default select example">
                                    <option value="" disabled selected>Seleccione un cliente</option>
                                </select>
                               
                                <a href="/domicilios/instalaciones" class="btn btn-outline-primary waves-effect"
                                    type="button"><i class="ri-add-circle-fill"></i> Registrar instalación de
                                    envasado</a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" step="0.01" placeholder="Volumen total"
                                    id="volumen_total" name="volumen_total" readonly />
                                <label for="volumen_total">Volumen total en Litros</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" name="tipo" aria-label="tipo">
                                    <option value="Con etiqueta">Con etiqueta</option>
                                    <option value="Sin etiqueta">Sin etiqueta</option>
                                </select>
                                <label for="tipo">Etiqueta</label>
                            </div>
                        </div>
                    </div>
                  <!--  <div class="card-body table-responsive text-nowrap">
                        <h5>Datos de Etiquetas</h5>
                        <table class="table" id="tabla_marcas">
                            <thead>
                                <tr>
                                    <th>Dirección</th>
                                    <th>SKU</th>
                                    <th>Tipo</th>
                                    <th>Presentación</th>
                                    <th>Clase</th>
                                    <th>Categoría</th>
                                    <th>Documento Etiquetas</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            </tbody>
                        </table>
                    </div>-->
                    
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function calcularVolumenTotal() {
            var cantidadBotellas = parseFloat(document.getElementById('cantidad_botellas').value) || 0;
            var presentacion = parseFloat(document.getElementById('presentacion').value) || 0;
            var unidad = document.getElementById('unidad').value;
            var volumenTotal;
            if (unidad === "Litros") {
                volumenTotal = cantidadBotellas * presentacion;
            } else if (unidad === "Mililitros") {
                volumenTotal = (cantidadBotellas * presentacion) / 1000;
            } else if (unidad === "Centrilitros") {
                volumenTotal = (cantidadBotellas * presentacion) / 100;
            } else {
                volumenTotal = ''; // Limpiar el campo si la unidad no es Litros ni Mililitros
            }
            document.getElementById('volumen_total').value = volumenTotal ? volumenTotal.toFixed(2) : '';
            document.getElementById('volumen_parcial').value = volumenTotal ? volumenTotal.toFixed(2) : '';
        }
        document.getElementById('cantidad_botellas').addEventListener('input', calcularVolumenTotal);
        document.getElementById('presentacion').addEventListener('input', calcularVolumenTotal);
        document.getElementById('unidad').addEventListener('change', calcularVolumenTotal);
    });

    //Limpia en cancelar
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#addlostesEnvasado .btn-outline-secondary').addEventListener('click',
            function() {
                document.getElementById('addNewLoteForm').reset();
                $('.select2').val(null).trigger('change'); // Reset select2 fields
            });
    });
</script>
