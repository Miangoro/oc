<!-- Modal para editar georreferenciación -->
<div class="modal fade" id="editClienteModalTipo10" tabindex="-1">
  <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
      <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body p-0">
              <div class="text-center mb-6">
                  <h4 class="address-title mb-2">Editar solicitud de georeferenciación</h4>
                  <p class="address-subtitle"></p>
              </div>
              <form id="editFormTipo10">
                  <div class="row">
                      <div class="col-md-6">
                        <input type="" name="id_solicitud" id="edit_id_solicitud">
                        <input type="hidden" name="form_type" value="georreferenciacion">
                          <div class="form-floating form-floating-outline mb-6">
                              <select onchange="obtenerPredioss(this.value);" id="edit_id_empresa" name="id_empresa" class="select2 form-select id_empresa" required>
                                  <option value="">Selecciona cliente</option>
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
                              <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" id="edit_fecha_visita" type="text" name="fecha_visita" />
                              <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-floating form-floating-outline mb-5">
                          <select onchange="obtenerDatosPredioss(this.value);" class="select2 form-select id_predio" id="edit_id_predio" name="id_predio" aria-label="id_predio"
                              required>
                              <option value="" selected>Lista de predios</option>
                          </select>
                          <label for="id_predio">Domicilio del predio a inspeccionar</label>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-floating form-floating-outline mb-5">
                              <input placeholder="Dirección del punto de reunión" id="edit_punto_reunion" class="form-control" type="text"
                                  name="punto_reunion" />
                              <label for="num_anterior">Dirección del punto de reunión</label>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-floating form-floating-outline mb-5">
                          <textarea name="info_adicional" class="form-control h-px-150 info_adicional" id="edit_info_adicional" placeholder="Información adicional sobre la actividad..."></textarea>
                          <label for="comentarios">Información adicional sobre la actividad</label>
                      </div>
                  </div>
                  <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                      <button type="submit" class="btn btn-primary">Registrar</button>
                      <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>


<script>
  function obtenerPredioss(empresa) {
      $.ajax({
          url: '/getDatos/' + empresa,
          method: 'GET',
          success: function(response) {
              console.log(response);
              // Cargar los detalles en el modal
              var contenido = "";
              for (let index = 0; index < response.predios.length; index++) {
                  contenido = '<option value="' + response.predios[index].id_predio + '">' + response
                      .predios[index].nombre_predio + ' | ' +  response
                      .predios[index].ubicacion_predio + '</option>' + contenido;
              }
              if (response.predios.length == 0) {
                  contenido = '<option value="">Sin predios registrados</option>';
              }
                  $('.id_predio').html(contenido);
              if (response.predios.length != 0) {
                  obtenerDatosPredioss($(".id_predio").val());
              }else{
                  $('.info_adicional').val("");
              }
          },
          error: function() {
              //alert('Error al cargar los lotes a granel.');
          }
      });
  }

  function obtenerDatosPredioss(id_predio) {
     $.ajax({
         url: '/domicilios-predios/' + id_predio+'/edit',
         method: 'GET',
         success: function(response) {
             console.log(response);
             var info_adicional =
                      'Predio: '+response.predio.nombre_predio + '. '+
                      'Punto de referencia: '+response.predio.puntos_referencia + '. '+
                      'Superficie: '+response.predio.superficie + 'H';
             $('.info_adicional').val(info_adicional);
         },
         error: function() {
         }
     });
 }


</script>
