   {{--  modal de edicion equisde --}}
   <div class="modal fade" id="modalAddRegistroPredio" tabindex="-1" aria-labelledby="modalAddRegistroPredio"
       aria-hidden="true">
       <div class="modal-dialog modal-xl">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 id="modalAddRegistroPredio" class="modal-title">Agregar Registro del Predio</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form id="modalAddRegistroPredioForm">
                       @csrf
                       <input type="hidden" id="id_predio" name="id_predio" value="">
                       {{--  --}}
                       <!-- Datos del Predio -->

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="num_predio"
                                        autocomplete="off" name="num_predio"
                                        placeholder="Número del predio"></input>
                                    <label for="num_predio">Número del predio</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control datepicker" id="fecha_emision"
                                        name="fecha_emision" autocomplete="off"
                                        placeholder="yyyy-mm-dd">
                                    <label for="fecha_emision">Fecha de emisión</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control datepicker" id="fecha_vigencia"
                                        name="fecha_vigencia" autocomplete="off" placeholder="yyyy-mm-dd">
                                    <label for="fecha_vigencia">Fecha de vigencia</label>
                                </div>
                            </div>
                        </div>


                       <div class="d-flex justify-content-end mt-3">
                           <button type="submit" class="btn btn-primary me-2">Registro</button>
                           <button type="reset" class="btn btn-outline-secondary"
                               data-bs-dismiss="modal">Cancelar</button>
                       </div>

                   </form>
               </div>
           </div>
       </div>
   </div>
