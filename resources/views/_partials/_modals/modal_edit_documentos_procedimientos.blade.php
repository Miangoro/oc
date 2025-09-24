       <!-- Modal Registrar Documento -->
       <div class="modal fade" id="modalEditDoc" tabindex="-1" data-bs-keyboard="false" aria-labelledby="modalEditDocLabel"
           aria-hidden="true">
           <div class="modal-dialog modal-xl">
               <div class="modal-content">

                   <!-- Header -->
                   <div class="modal-header bg-primary pb-4">
                       <h5 class="modal-title text-white" id="modalAddDocLabel">Historial procedimientos</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                   </div>

                   <!-- Body -->
                   <div class="modal-body py-8">
                       <!-- Spinner -->
                       <div id="cargando" class="text-center my-3"
                           style="display: none; height: 10vh; justify-content: center; align-items: center;">
                           <div class="sk-wave sk-primary">
                               <div class="sk-wave-rect"></div>
                               <div class="sk-wave-rect"></div>
                               <div class="sk-wave-rect"></div>
                               <div class="sk-wave-rect"></div>
                               <div class="sk-wave-rect"></div>
                           </div>
                       </div>
                       <!-- Contenido dinámico -->
                       <div id="historialContent"></div>
                   </div>
               </div>
           </div>
       </div>



       <!-- Modal editar Documento -->
       <div class="modal fade" id="modalEditHistorial" tabindex="-1" aria-labelledby="modalEditHistorialLabel"
           aria-hidden="true">
           <div class="modal-dialog modal-xl">
               <div class="modal-content">

                   <!-- Header -->
                   <div class="modal-header bg-primary pb-4">
                       <h5 class="modal-title text-white" id="modalEditHistorialLabel">Registrar nuevos procedimientos</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                   </div>

                   <!-- Body -->
                   <div class="modal-body py-8">
                       <form id="formEditHistorial" enctype="multipart/form-data">
                           @csrf
                           <div class="card-body">
                               <div class="row g-3">
                                   <!-- Nombre -->
                                   <input type="hidden" name="id_doc_calidad" id="edit_id_doc_calidad">
                                   <div class="col-md-6">
                                       <div class="form-floating form-floating-outline">
                                           <input type="text" class="form-control" id="edit_nombre" name="nombre"
                                               placeholder="Sistema de gestión" required>
                                           <label for="doc_nombre">Nombre del documento</label>
                                       </div>
                                   </div>

                                   <!-- Identificación -->
                                   <div class="col-md-3">
                                       <div class="form-floating form-floating-outline">
                                           <input type="text" class="form-control" id="edit_identificacion"
                                               name="identificacion" placeholder="SGC-01" required>
                                           <label for="doc_identificacion">Identificación</label>
                                       </div>
                                   </div>
                                   <div class="col-md-3">
                                       <div class="form-floating form-floating-outline">
                                           <select class="form-select" id="edit_area" name="area">
                                               <option value="">Seleccione el área</option>
                                              <option value="1">OC</option>
                                                <option value="2">UI</option>
                                           </select>
                                           <label for="Área">Área</label>
                                       </div>
                                   </div>

                                   <!-- Edición -->
                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <input type="text" class="form-control" id="edit_edicion" name="edicion"
                                               placeholder="0" >
                                           <label for="doc_edicion">Edición</label>
                                       </div>
                                   </div>

                                   <!-- Fecha -->
                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <input type="text" class="form-control flatpickr" id="edit_fecha_edicion"
                                               name="fecha_edicion">
                                           <label for="doc_fecha">Fecha de edición</label>
                                       </div>
                                   </div>

                                   <!-- Estatus -->
                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <select class="form-select" id="edit_estatus" name="estatus">
                                               <option value="">Seleccione</option>
                                               <option value="Vigente">Vigente</option>
                                               <option value="Obsoleto">Obsoleto</option>
                                               <option value="Descontinuado">Descontinuado</option>
                                           </select>
                                           <label for="doc_estatus">Estatus</label>
                                       </div>
                                   </div>


                                   <!-- Archivo -->
                                   <div class="col-md-12">
                                       <div class="form-floating form-floating-outline">

                                           <input class="form-control" type="file" id="edit_archivo" name="archivo"
                                               required>
                                           <label for="doc_archivo">Archivo</label>
                                       </div>
                                   </div>

                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <input type="text" class="form-control" id="edit_modifico"
                                               name="modifico" placeholder="Administrador CIDAM"
                                               value="{{ $tipo_usuario }}" readonly>
                                           <label for="doc_modifico">Modificó</label>
                                       </div>
                                   </div>

                                   <!-- Revisó -->
                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <select class="select2 form-select" id="edit_reviso" name="reviso"
                                               required>
                                               <option value="">Seleccione un usuario</option>
                                               <option value="0">Sin asignar</option>
                                               @foreach ($usuarios as $usuario)
                                                   <option value="{{ $usuario->id }}"
                                                     data-tipo="{{ $usuario->tipo == 1 ? 'OC' : 'UI' }}">
                                                       {{ $usuario->name }} ({{ $usuario->puesto }})
                                                   </option>
                                               @endforeach
                                           </select>
                                           <label for="doc_reviso">Revisó</label>
                                       </div>
                                   </div>

                                   <!-- Aprobó -->
                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <select class="select2 form-select" id="edit_aprobo" name="aprobo"
                                               required>
                                               <option value="">Seleccione un usuario</option>
                                               <option value="0">Sin asignar</option>
                                               @foreach ($usuarios as $usuario)
                                                   <option value="{{ $usuario->id }}"
                                                     data-tipo="{{ $usuario->tipo == 1 ? 'OC' : 'UI' }}">
                                                       {{ $usuario->name }} ({{ $usuario->puesto }})
                                                   </option>
                                               @endforeach
                                           </select>
                                           <label for="doc_aprobo">Aprobó</label>
                                       </div>
                                   </div>



                               </div>
                           </div>

                           <!-- Botones -->
                           <div class="d-flex justify-content-center mt-3">
                               <button disabled class="btn btn-primary me-2 d-none" type="button" id="loadingEdit">
                                   <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                   Registrando...
                               </button>
                               <button type="submit" class="btn btn-primary me-2" id="btnEditDoc">
                                   <i class="ri-pencil-fill me-1"></i> Registrar
                               </button>
                               <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                   <i class="ri-close-line me-1"></i> Cancelar
                               </button>
                           </div>
                       </form>
                   </div>

               </div>
           </div>
       </div>




      <!-- Modal editar historial Documento -->
       <div class="modal fade" id="modalEditHistorialEdit" tabindex="-1" aria-labelledby="modalEditHistorialEditLabel"
           aria-hidden="true">
           <div class="modal-dialog modal-xl">
               <div class="modal-content">

                   <!-- Header -->
                   <div class="modal-header bg-primary pb-4">
                       <h5 class="modal-title text-white" id="modalEditHistorialEditLabel">Editar procedimientos</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                   </div>

                   <!-- Body -->
                   <div class="modal-body py-8">
                       <form id="formEditHistorialEdit" enctype="multipart/form-data">
                           @csrf
                           <div class="card-body">
                               <div class="row g-3">
                                   <!-- Nombre -->
                                   <input type="hidden" name="id" id="edit_id">
                                   <div class="col-md-6">
                                       <div class="form-floating form-floating-outline">
                                           <input type="text" class="form-control" id="edit_edit_nombre" name="nombre"
                                               placeholder="Sistema de gestión" required>
                                           <label for="doc_nombre">Nombre del documento</label>
                                       </div>
                                   </div>

                                   <!-- Identificación -->
                                   <div class="col-md-3">
                                       <div class="form-floating form-floating-outline">
                                           <input type="text" class="form-control" id="edit_edit_identificacion"
                                               name="identificacion" placeholder="SGC-01" required>
                                           <label for="doc_identificacion">Identificación</label>
                                       </div>
                                   </div>
                                   <div class="col-md-3">
                                       <div class="form-floating form-floating-outline">
                                           <select class="form-select" id="edit_edit_area" name="area">
                                               <option value="">Seleccione el área</option>
                                               <option value="1">OC</option>
                                                <option value="2">UI</option>
                                           </select>
                                           <label for="Área">Área</label>
                                       </div>
                                   </div>

                                   <!-- Edición -->
                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <input type="text" class="form-control" id="edit_edit_edicion" name="edicion"
                                               placeholder="0" >
                                           <label for="doc_edicion">Edición</label>
                                       </div>
                                   </div>

                                   <!-- Fecha -->
                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <input type="text" class="form-control flatpickr" id="edit_edit_fecha_edicion"
                                               name="fecha_edicion">
                                           <label for="doc_fecha">Fecha de edición</label>
                                       </div>
                                   </div>

                                   <!-- Estatus -->
                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <select class="form-select" id="edit_edit_estatus" name="estatus">
                                               <option value="">Seleccione</option>
                                               <option value="Vigente">Vigente</option>
                                               <option value="Obsoleto">Obsoleto</option>
                                               <option value="Descontinuado">Descontinuado</option>
                                           </select>
                                           <label for="doc_estatus">Estatus</label>
                                       </div>
                                   </div>


                                   <!-- Archivo -->
                                   <div class="col-md-12">
                                       <div class="form-floating form-floating-outline">

                                           <input class="form-control" type="file" id="edit_edit_archivo" name="archivo"
                                               required>
                                           <label for="doc_archivo">Archivo</label>
                                       </div>
                                   </div>

                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <input type="text" class="form-control" id="edit_edit_modifico"
                                               name="modifico" placeholder="Administrador CIDAM"
                                               {{-- value="{{ $tipo_usuario }}" --}}>
                                           <label for="doc_modifico">Modificó</label>
                                       </div>
                                   </div>

                                   <!-- Revisó -->
                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <select class="select2 form-select" id="edit_edit_reviso" name="reviso"
                                               required>
                                               <option value="">Seleccione un usuario</option>
                                               <option value="0">Sin asignar</option>
                                               @foreach ($usuarios as $usuario)
                                                   <option value="{{ $usuario->id }}"
                                                     data-tipo="{{ $usuario->tipo == 1 ? 'OC' : 'UI' }}">
                                                       {{ $usuario->name }} ({{ $usuario->puesto }})
                                                   </option>
                                               @endforeach
                                           </select>
                                           <label for="doc_reviso">Revisó</label>
                                       </div>
                                   </div>

                                   <!-- Aprobó -->
                                   <div class="col-md-4">
                                       <div class="form-floating form-floating-outline">
                                           <select class="select2 form-select" id="edit_edit_aprobo" name="aprobo"
                                               required>
                                               <option value="">Seleccione un usuario</option>
                                               <option value="0">Sin asignar</option>
                                               @foreach ($usuarios as $usuario)
                                                   <option value="{{ $usuario->id }}"
                                                     data-tipo="{{ $usuario->tipo == 1 ? 'OC' : 'UI' }}">
                                                       {{ $usuario->name }} ({{ $usuario->puesto }})
                                                   </option>
                                               @endforeach
                                           </select>
                                           <label for="doc_aprobo">Aprobó</label>
                                       </div>
                                   </div>



                               </div>
                           </div>

                           <!-- Botones -->
                           <div class="d-flex justify-content-center mt-3">
                               <button disabled class="btn btn-primary me-2 d-none" type="button" id="loadingEditHistorial">
                                   <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                   Actualizando...
                               </button>
                               <button type="submit" class="btn btn-primary me-2" id="btnEditHistorial">
                                   <i class="ri-pencil-fill me-1"></i> Editar
                               </button>
                               <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                   <i class="ri-close-line me-1"></i> Cancelar
                               </button>
                           </div>
                       </form>
                   </div>

               </div>
           </div>
       </div>
