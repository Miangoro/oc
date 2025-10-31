<!-- MODAL AGREGAR MEZCAL A GRANEL-->
<div class="modal fade" id="ModalAddMezcalGranel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

        <div class="modal-header bg-primary pb-4">
            <h5 class="modal-title text-white">Nueva etiqueta para lotes de mezcal a granel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            
        <div class="modal-body">
            <form id="FormAddMezcalGranel" method="POST">
              <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input name="fecha_servicio" class="form-control flatpickr-datetime" placeholder="YYYY-MM-DD">
                        <label>Fecha del servicio</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="num_servicio" placeholder="">
                        <label>No. de servicio</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="razon_social" placeholder="">
                        <label>Razón Social</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="nombre_lote" placeholder="">
                        <label>No. de lote</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="volumen" placeholder="">
                        <label>Volumen</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="folio_fq" placeholder="">
                        <label>Análisis fisicoquímico</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="categoria" placeholder="">
                        <label>Categoría</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="clase" placeholder="">
                        <label>Clase</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="tipo_agave" placeholder="">
                        <label>Especie de agave</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="edad" placeholder="">
                        <label>Edad</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="tanque" placeholder="">
                        <label>ID de tanque</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="ingredientes" placeholder="">
                        <label>Ingredientes</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="num_certificado" placeholder="">
                        <label>Certificado</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="inspector" placeholder="">
                        <label>Inspector</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="responsable" placeholder="">
                        <label>Responsable</label>
                    </div>
                </div>
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

<!-- MODAL EDITAR MEZCAL A GRANEL -->
<div class="modal fade" id="ModalEditMezcalGranel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

        <div class="modal-header bg-primary pb-4">
            <h5 class="modal-title text-white">Editar etiqueta para lotes de mezcal a granel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            
        <div class="modal-body">
            <form id="FormEditMezcalGranel" method="POST">
              <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control flatpickr-datetime" name="fecha_servicio" placeholder="">
                        <label>Fecha del servicio</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="num_servicio" placeholder="">
                        <label>No. de servicio</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="razon_social" placeholder="">
                        <label>Razón Social</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="nombre_lote" placeholder="">
                        <label>No. de lote</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="volumen" placeholder="">
                        <label>Volumen</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="folio_fq" placeholder="">
                        <label>Análisis fisicoquímico</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="categoria" placeholder="">
                        <label>Categoría</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="clase" placeholder="">
                        <label>Clase</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="tipo_agave" placeholder="">
                        <label>Especie de agave</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="edad" placeholder="">
                        <label>Edad</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="tanque" placeholder="">
                        <label>ID de tanque</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="ingredientes" placeholder="">
                        <label>Ingredientes</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="num_certificado" placeholder="">
                        <label>Certificado</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="inspector" placeholder="">
                        <label>Inspector</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="responsable" placeholder="">
                        <label>Responsable</label>
                    </div>
                </div>
              </div>
                
                <div class="d-flex mt-6 justify-content-center">
                    <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i>
                        Editar</button>
                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                            class="ri-close-line"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>





<!------------------- AGAVE ART ------------------->
<!-- MODAL AGREGAR AGAVE ART-->
<div class="modal fade" id="ModalAddAgaveArt" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

        <div class="modal-header bg-primary pb-4">
            <h5 class="modal-title text-white">Nueva etiqueta para agave (%ART / %ARD)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            
        <div class="modal-body">
            <form id="FormAddAgaveArt" method="POST">
              <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input name="fecha_servicio" class="form-control flatpickr-datetime" placeholder="YYYY-MM-DD">
                        <label>Fecha del servicio</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="num_servicio" placeholder="">
                        <label>No. de servicio</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="razon_social" placeholder="">
                        <label>Razón Social</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="domicilio" placeholder="">
                        <label>Domicilio</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="maestro_mezcalero" placeholder="">
                        <label>Maestro Mezcalero</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="destino" placeholder="">
                        <label>Destino</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="predio" placeholder="">
                        <label>Predio</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="tapada" placeholder="">
                        <label>Tapada</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="kg_maguey" placeholder="">
                        <label>Kg maguey</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="edad" placeholder="">
                        <label>Edad</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="no_pinas" placeholder="">
                        <label>No. de piñas</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="tipo_agave" placeholder="">
                        <label>Tipo de agave</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="analisis" placeholder="">
                        <label>Análisis</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="muestra" placeholder="">
                        <label>Muestra</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="inspector" placeholder="">
                        <label>Inspector</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="responsable" placeholder="">
                        <label>Responsable</label>
                    </div>
                </div>
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

<!-- MODAL EDITAR AGAVE ART -->
<div class="modal fade" id="ModalEditAgaveArt" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

        <div class="modal-header bg-primary pb-4">
            <h5 class="modal-title text-white">Editar etiqueta para agave (%ART / %ARD)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            
        <div class="modal-body">
            <form id="FormEditAgaveArt" method="POST">
              <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input name="fecha_servicio" class="form-control flatpickr-datetime" placeholder="YYYY-MM-DD">
                        <label>Fecha del servicio</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="num_servicio" placeholder="">
                        <label>No. de servicio</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="razon_social" placeholder="">
                        <label>Razón Social</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="domicilio" placeholder="">
                        <label>Domicilio</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="maestro_mezcalero" placeholder="">
                        <label>Maestro Mezcalero</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="destino" placeholder="">
                        <label>Destino</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="predio" placeholder="">
                        <label>Predio</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="tapada" placeholder="">
                        <label>Tapada</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="kg_maguey" placeholder="">
                        <label>Kg maguey</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="edad" placeholder="">
                        <label>Edad</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="no_pinas" placeholder="">
                        <label>No. de piñas</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="tipo_agave" placeholder="">
                        <label>Tipo de agave</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="analisis" placeholder="">
                        <label>Análisis</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="muestra" placeholder="">
                        <label>Muestra</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="inspector" placeholder="">
                        <label>Inspector</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="responsable" placeholder="">
                        <label>Responsable</label>
                    </div>
                </div>
              </div>
                
                <div class="d-flex mt-6 justify-content-center">
                    <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i>
                        Editar</button>
                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                            class="ri-close-line"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>





<!------------------- INGRESO MADURACION ------------------->
<!-- MODAL AGREGAR INGRESO MADURACION -->
<div class="modal fade" id="ModalAddMaduracion" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header bg-primary pb-4">
        <h5 class="modal-title text-white">Nueva etiqueta para ingreso a maduración</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="FormAddMaduracion" method="POST">
          <div class="row">
            
            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input name="fecha_servicio" class="form-control flatpickr-datetime" placeholder="YYYY-MM-DD">
                <label>Fecha del servicio</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="num_servicio" placeholder="">
                <label>No. de servicio</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="razon_social" placeholder="">
                <label>Razón Social</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="nombre_lote" placeholder="">
                <label>No. de lote</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="volumen_total" placeholder="">
                <label>Volumen total</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="folio_fq" placeholder="">
                <label>Análisis fisicoquímico</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="categoria" placeholder="">
                <label>Categoría</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="clase" placeholder="">
                <label>Clase</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="tipo_agave" placeholder="">
                <label>Especie de agave</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="cont_alc" placeholder="">
                <label>Contenido alcohólico</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="num_certificado" placeholder="">
                <label>Certificado</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="maduracion" placeholder="">
                <label>Maduración</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="tipo_madera" placeholder="">
                <label>Tipo de madera</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="tipo_recipiente" placeholder="">
                <label>Tipo de recipiente</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="no_recipiente" placeholder="">
                <label>No. de recipiente</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="capacidad_recipiente" placeholder="">
                <label>Capacidad del recipiente</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="volumen_ingresado" placeholder="">
                <label>Volumen ingresado</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="inspector" placeholder="">
                <label>Inspector</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="responsable" placeholder="">
                <label>Responsable</label>
              </div>
            </div>
          </div>

          <div class="d-flex mt-6 justify-content-center">
            <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i> Registrar</button>
            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
              <i class="ri-close-line"></i> Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDITAR INGRESO MADURACION -->
<div class="modal fade" id="ModalEditMaduracion" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header bg-primary pb-4">
        <h5 class="modal-title text-white">Editar etiqueta para ingreso a maduración</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="FormEditMaduracion" method="POST">
          <div class="row">
            
            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input name="fecha_servicio" class="form-control flatpickr-datetime" placeholder="YYYY-MM-DD">
                <label>Fecha del servicio</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="num_servicio" placeholder="">
                <label>No. de servicio</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="razon_social" placeholder="">
                <label>Razón Social</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="nombre_lote" placeholder="">
                <label>No. de lote</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="volumen_total" placeholder="">
                <label>Volumen total</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="folio_fq" placeholder="">
                <label>Análisis fisicoquímico</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="categoria" placeholder="">
                <label>Categoría</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="clase" placeholder="">
                <label>Clase</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="tipo_agave" placeholder="">
                <label>Especie de agave</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="cont_alc" placeholder="">
                <label>Contenido alcohólico</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="num_certificado" placeholder="">
                <label>Certificado</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="maduracion" placeholder="">
                <label>Maduración</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="tipo_madera" placeholder="">
                <label>Tipo de madera</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="tipo_recipiente" placeholder="">
                <label>Tipo de recipiente</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="no_recipiente" placeholder="">
                <label>No. de recipiente</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="capacidad_recipiente" placeholder="">
                <label>Capacidad del recipiente</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="volumen_ingresado" placeholder="">
                <label>Volumen ingresado</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="inspector" placeholder="">
                <label>Inspector</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="responsable" placeholder="">
                <label>Responsable</label>
              </div>
            </div>
          </div>

          <div class="d-flex mt-6 justify-content-center">
            <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i> Editar</button>
            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
              <i class="ri-close-line"></i> Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>





<!------------------- TAPA MUESTRA ------------------->
<!-- MODAL AGREGAR TAPA MUESTRA -->
<div class="modal fade" id="ModalAddTapaMuestra" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header bg-primary pb-4">
        <h5 class="modal-title text-white">Nueva etiqueta para tapa de la muestra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="FormAddTapaMuestra" method="POST">
          <div class="row">
            
            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input name="fecha_servicio" class="form-control flatpickr-datetime" placeholder="YYYY-MM-DD">
                <label>Fecha del servicio</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="num_servicio" placeholder="">
                <label>No. de servicio</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="razon_social" placeholder="">
                <label>Razón Social</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="domicilio" placeholder="">
                <label>Domicilio</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="nombre_lote" placeholder="">
                <label>No. de lote</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="producto" placeholder="">
                <label>Producto</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="volumen" placeholder="">
                <label>Volumen</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="folio_fq" placeholder="">
                <label>Folio fisicoquímico</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="categoria" placeholder="">
                <label>Categoría</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="tipo_agave" placeholder="">
                <label>Tipo de agave</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="edad" placeholder="">
                <label>Edad</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="ingredientes" placeholder="">
                <label>Ingredientes</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="tipo_analisis" placeholder="">
                <label>Tipo de análisis</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="lote_procedencia" placeholder="">
                <label>Lote de procedencia</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="estado" placeholder="">
                <label>Estado</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="destino" placeholder="">
                <label>Destino</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="inspector" placeholder="">
                <label>Inspector</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="responsable" placeholder="">
                <label>Responsable</label>
              </div>
            </div>

          </div>

          <div class="d-flex mt-6 justify-content-center">
            <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i> Registrar
            </button>
            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
              <i class="ri-close-line"></i> Cancelar
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDITAR TAPA MUESTRA -->
<div class="modal fade" id="ModaEditTapaMuestra" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header bg-primary pb-4">
        <h5 class="modal-title text-white">Editar etiqueta para tapa de la muestra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="FormEditTapaMuestra" method="POST">
          <div class="row">
            
            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input name="fecha_servicio" class="form-control flatpickr-datetime" placeholder="YYYY-MM-DD">
                <label>Fecha del servicio</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="num_servicio" placeholder="">
                <label>No. de servicio</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="razon_social" placeholder="">
                <label>Razón Social</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="domicilio" placeholder="">
                <label>Domicilio</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="nombre_lote" placeholder="">
                <label>No. de lote</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="producto" placeholder="">
                <label>Producto</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="volumen" placeholder="">
                <label>Volumen</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="folio_fq" placeholder="">
                <label>Folio fisicoquímico</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="categoria" placeholder="">
                <label>Categoría</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="tipo_agave" placeholder="">
                <label>Tipo de agave</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="edad" placeholder="">
                <label>Edad</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="ingredientes" placeholder="">
                <label>Ingredientes</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="tipo_analisis" placeholder="">
                <label>Tipo de análisis</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="lote_procedencia" placeholder="">
                <label>Lote de procedencia</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="estado" placeholder="">
                <label>Estado</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="destino" placeholder="">
                <label>Destino</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="inspector" placeholder="">
                <label>Inspector</label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="responsable" placeholder="">
                <label>Responsable</label>
              </div>
            </div>

          </div>

          <div class="d-flex mt-6 justify-content-center">
            <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i> Editar</button>
            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
              <i class="ri-close-line"></i> Cancelar
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>