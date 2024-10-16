   {{--  modal de edicion equisde --}}
   <div class="modal fade" id="modalAddPredioInspeccion" tabindex="-1" aria-labelledby="modalAddPredioInspeccionLabel"
       aria-hidden="true">
       <div class="modal-dialog modal-xl">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 id="modalAddPredioInspeccionLabel" class="modal-title">Agregar Inspección del Predio</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form id="addAddPredioInspeccionForm">
                       @csrf
                       <input type="hidden" id="inspeccion_id_predio" name="id_predio" value="">
                       <input type="hidden" id="inspeccion_id_empresa" name="id_empresa">
                       {{--  --}}
                       <!-- Datos del Predio -->
                       <div class="mb-4 p-3 border rounded">
                           <h6 class="mb-4">Datos del Predio</h6>
                           <div class="row mb-4">
                               <div class="col-md-4">
                                   <div class="form-floating form-floating-outline mb-4">
                                       <input type="text" class="form-control" id="inspeccion_ubicacion_predio"
                                           autocomplete="off" name="ubicacion_predio"
                                           placeholder="Ubicación del predio"></input>
                                       <label for="ubicacion_predio">Ubicación del Predio</label>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-floating form-floating-outline mb-4">
                                       <input type="text" class="form-control" id="localidad" autocomplete="off"
                                           name="localidad" placeholder="Localidad">
                                       <label for="localidad">Localidad</label>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-floating form-floating-outline">
                                       <input type="text" class="form-control" id="municipio" autocomplete="off"
                                           name="municipio" placeholder="Municipio">
                                       <label for="municipio">Municipio</label>
                                   </div>
                               </div>
                           </div>
                           <div class="row mb-4">
                               <div class="col-md-6">
                                   <div class="form-floating form-floating-outline mb-4">
                                       <input type="text" class="form-control" id="distrito" autocomplete="off"
                                           name="distrito" placeholder="Distrito">
                                       <label for="distrito">Distrito</label>
                                   </div>
                               </div>
                               <div class="col-md-6">
                                   <div class="form-floating form-floating-outline">
                                       <select class="form-select select2" name="estado" id="estado">
                                           <option value="" disabled selected>Selecciona un estado</option>
                                           @foreach ($estados as $estado)
                                               <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                           @endforeach
                                       </select>
                                       <label for="estado">Estado</label>
                                   </div>
                               </div>
                           </div>
                           <div class="row mb-4">
                               <div class="col-md-6">
                                   <div class="form-floating form-floating-outline mb-4">
                                       <input type="text" class="form-control" id="nombreParaje" autocomplete="off"
                                           name="nombre_paraje" placeholder="Nombre del Paraje">
                                       <label for="nombreParaje">Nombre del Paraje</label>
                                   </div>
                               </div>
                               <div class="col-md-6">
                                   <div class="form-floating form-floating-outline">
                                       <select class="form-select" id="zonaDom" name="zona_dom" aria-label="Zona DOM">
                                           <option value="" disabled selected>Selecciona una opción</option>
                                           <option value="si">Sí</option>
                                           <option value="no">No</option>
                                       </select>
                                       <label for="zonaDom">Predio en zona DOM</label>
                                   </div>
                               </div>
                           </div>

                           <div class="row mb-4">
                               <div class="col-md-12">
                                   <table class="table table-bordered">
                                       <thead>
                                           <tr>
                                            <th>
                                               <button type="button" class="btn btn-primary" id="agregar-seccion"><i class="ri-add-line"></i></button>
                                               </th>
                                               <th colspan="2" class="text-center">Adjuntar Fotografías de la
                                                   Inspección</th>
                                           </tr>

                                           <tr>
                                               <th>Eliminar</th>
                                               <th>Título o Descripción</th>
                                               <th>Archivo</th>
                                           </tr>
                                       </thead>
                                       <tbody id="contenedor-secciones">
                                           <!-- Primera fila de ejemplo -->
                                           <tr class="seccion-foto">
                                               <td>
                                                   <button type="button" class="btn btn-danger eliminar-seccion" disabled><i
                                                           class="ri-delete-bin-5-fill" ></i></button>
                                               </td>
                                               <td>
                                                   <input type="text" class="form-control" name="titulo_foto[]"
                                                       placeholder="Título o descripción de la foto">
                                               </td>
                                               <td>
                                                   <input type="file" class="form-control"
                                                       name="fotografias_inspeccion[]" accept="image/*">
                                               </td>
                                           </tr>
                                       </tbody>
                                   </table>
                               </div>
                           </div>




                       </div>

                       <div class="mb-4 p-3 border rounded">
                           <h6 class="mb-4">Características del maguey</h6>
                           <div class="row mb-4">
                               <!-- Marco de Plantación (m2) -->
                               <div class="col-md-4">
                                   <div class="form-floating form-floating-outline">
                                       <input type="number" class="form-control" id="marcoPlantacion"
                                           autocomplete="off" name="marco_plantacion"
                                           placeholder="Marco de Plantación (m²)">
                                       <label for="marcoPlantacion">Marco de Plantación (m²)</label>
                                   </div>
                               </div>

                               <!-- Distancia entre Surcos (m) -->
                               <div class="col-md-4">
                                   <div class="form-floating form-floating-outline mb-4">
                                       <input type="number" class="form-control" id="distanciaSurcos"
                                           autocomplete="off" name="distancia_surcos"
                                           placeholder="Distancia entre Surcos (m)">
                                       <label for="distanciaSurcos">Distancia entre Surcos (m)</label>
                                   </div>
                               </div>
                               <!-- Distancia entre Plantas (m) -->
                               <div class="col-md-4">
                                   <div class="form-floating form-floating-outline">
                                       <input type="number" class="form-control" id="distanciaPlantas"
                                           autocomplete="off" name="distancia_plantas"
                                           placeholder="Distancia entre Plantas (m)">
                                       <label for="distanciaPlantas">Distancia entre Plantas (m)</label>
                                   </div>
                               </div>
                           </div>
                       </div>

                       <div class="card mb-4">
                           <table id="plant-table" class="table table-bordered table-striped">
                               <thead>
                                   <tr>
                                       <th>
                                           <button type="button" class="btn btn-primary add-row-caracteristicas"><i
                                                   class="ri-add-line"></i></button>
                                       </th>
                                       <th colspan="2" style="width: 95%">
                                           <h5 class="card-title mb-0 text-center">Características del maguey <br>Edad
                                           </h5>
                                       </th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <tr class="caracteristicas-row">
                                       <td rowspan="5">
                                           <button type="button" class="btn btn-danger remove-row-caracteristicas"
                                               disabled><i class="ri-delete-bin-5-fill"></i></button>
                                       </td>
                                   </tr>
                                   <tr class="caracteristicas-row">
                                       <td>No. planta</td>
                                       <td><input type="number" class="form-control" name="no_planta[]"
                                               placeholder="Número de planta" required></td>
                                   </tr>
                                   <tr class="caracteristicas-row">
                                       <td>Altura (m)</td>
                                       <td><input type="number" step="0.01" class="form-control" name="altura[]"
                                               placeholder="Altura (m)" required></td>
                                   </tr>
                                   <tr class="caracteristicas-row">
                                       <td>Diámetro (m)</td>
                                       <td><input type="number" step="0.01" class="form-control"
                                               name="diametro[]" placeholder="Diámetro (m)" required></td>
                                   </tr>
                                   <tr class="caracteristicas-row">
                                       <td>Número de hojas</td>
                                       <td><input type="number" class="form-control" name="numero_hojas[]"
                                               placeholder="Número de hojas" required></td>
                                   </tr>
                               </tbody>
                           </table>
                       </div>
                       <br>
                       <!-- Tipo de Predio y Puntos de Referencia -->
                       <div class="row mb-4">
                           <!-- Coordenadas -->
                           <div class="col-md-6">
                               <div class="form-floating form-floating-outline mb-4">
                                   <select class="form-select" id="inspeccion_tiene_coordenadas"
                                       name="tiene_coordenadas" aria-label="¿Cuenta con coordenadas?">
                                       <option value="" disabled selected>Seleccione una opción</option>
                                       <option value="Si">Si</option>
                                       <option value="No">No</option>
                                   </select>
                                   <label for="tiene_coordenadas">¿Cuenta con Coordenadas?</label>
                               </div>
                           </div>
                           <!-- Superficie del Predio -->
                           <div class="col-md-6">
                               <div class="form-floating form-floating-outline">
                                   <input type="number" class="form-control" id="inspeccion_superficie"
                                       autocomplete="off" name="superficie" placeholder="Superficie del predio (Ha)"
                                       step="0.01">
                                   <label for="superficie">Superficie del Predio (Ha)</label>
                               </div>
                           </div>
                       </div>
                       <!-- ¿Cuenta con Coordenadas? -->
                       <div id="inspeccion_coordenadas" class="d-none mb-4">
                           <div class="card">
                               <table class="table table-bordered">
                                   <thead>
                                       <tr>
                                           <th><button type="button"
                                                   class="btn btn-primary add-row-cordenadas-inspeccion"><i
                                                       class="ri-add-line"></i></button></th>
                                           <th colspan="2" style="width: 95%">
                                               <h5 class="card-title mb-0 text-center">Coordenadas</h5>
                                           </th>
                                       </tr>
                                   </thead>
                                   <tbody id="coordenadas-body-inspeccion">
                                       <!-- Campos de coordenadas se agregarán aquí dinámicamente -->
                                   </tbody>
                               </table>
                           </div>
                       </div>

                       <div class="inspeccion_InformacionAgave mb-4">
                           <!-- Información sobre el Agave/Maguey y Plantación combinada -->
                           <div class="card">
                               <div class="card-body">
                                   <table class="table table-bordered table-striped mb-4">
                                       <tr>
                                           <th><button type="button" class="btn btn-primary add-row-plantacion"><i
                                                       class="ri-add-line"></i></button></th>
                                           <th colspan="2" style="width: 95%">
                                               <h5 class="card-title mb-0 text-center">Información del Agave/Maguey y
                                                   Plantación</h5>
                                           </th>
                                       </tr>
                                       <tbody class="inspeccion_ContenidoPlantacion">
                                           <tr>
                                               <td rowspan="4">
                                                   <!-- El botón de eliminar estará en cada fila que se agregue -->
                                                   <button type="button" class="btn btn-danger remove-row-plantacion"
                                                       disabled><i class="ri-delete-bin-5-fill"></i></button>
                                               </td>
                                               <td>
                                                   <b>Nombre y Especie de Agave/Maguey</b>
                                               </td>
                                               <td>
                                                   <div class="form-floating form-floating-outline mb-4">
                                                       <select id="edit_id_tipo" name="id_tipo[]"
                                                           class="select2 form-select tipo_agave">
                                                           <option value="" disabled selected>Tipo de agave
                                                           </option>
                                                           @foreach ($tipos as $tipo)
                                                               <option value="{{ $tipo->id_tipo }}">
                                                                   {{ $tipo->nombre }}</option>
                                                           @endforeach
                                                       </select>
                                                       <label for="especie_agave"></label>
                                                   </div>
                                               </td>
                                           </tr>
                                           <tr>
                                               <td>
                                                   <b>Número de Plantas</b>
                                               </td>
                                               <td>
                                                   <div class="form-floating form-floating-outline">
                                                       <input type="number" class="form-control" autocomplete="off"
                                                           id="edit_numero_plantas" name="numero_plantas[]"
                                                           placeholder="Número de plantas" step="1">
                                                       <label for="numero_plantas">Número de Plantas</label>
                                                   </div>
                                               </td>
                                           </tr>
                                           <tr>
                                               <td>
                                                   <b>Edad de la Plantación (años)</b>
                                               </td>
                                               <td>
                                                   <div class="form-floating form-floating-outline">
                                                       <input type="number" class="form-control" autocomplete="off"
                                                           id="edit_edad_plantacion" name="edad_plantacion[]"
                                                           placeholder="Edad de la plantación (años)" step="1">
                                                       <label for="edad_plantacion">Edad de la Plantación
                                                           (años)</label>
                                                   </div>
                                               </td>
                                           </tr>
                                           <tr>
                                               <td>
                                                   <p>Tipo de Plantación</p>
                                               </td>
                                               <td>
                                                   <div class="form-floating form-floating-outline">
                                                       <input type="text" class="form-control" autocomplete="off"
                                                           id="edit_tipo_plantacion" name="tipo_plantacion[]"
                                                           placeholder="Tipo de plantación">
                                                       <label for="tipo_plantacion">Tipo de Plantación</label>
                                                   </div>
                                               </td>
                                           </tr>
                                       </tbody>
                                   </table>
                               </div>
                           </div>
                       </div>

                       <div class="d-flex justify-content-end mt-3">
                           <button type="submit" class="btn btn-primary me-2">Registrar</button>
                           <button type="reset" class="btn btn-outline-secondary"
                               data-bs-dismiss="modal">Cancelar</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
   <!-- Convertir tipos en una variable JavaScript -->
   <script>
       var tiposAgave = @json($tipos);
   </script>
