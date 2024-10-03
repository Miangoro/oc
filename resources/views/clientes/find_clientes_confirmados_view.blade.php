@extends('layouts/layoutMaster')

@section('title', 'Clientes confirmados')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/clientes_confirmados.js'])
@endsection

@section('content')

<div class="row g-6 mb-6">
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="me-1">
              <p class="text-heading mb-1">Clientes</p>
              <div class="d-flex align-items-center">
                <h4 class="mb-1 me-2">{{$empresas}}</h4>
                <p class="text-success mb-1">(100%)</p>
              </div>
              <small class="mb-0">Clientes totales</small>
            </div>
            <div class="avatar">
              <div class="avatar-initial bg-label-primary rounded-3">
                <div class="ri-user-line ri-26px"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="me-1">
              <p class="text-heading mb-1">Personas físicas</p>
              <div class="d-flex align-items-center">
                <h4 class="mb-1 me-1">{{$fisicas}}</h4>
                <p class="text-success mb-1">(+95%)</p>
              </div>
              <small class="mb-0">Recent analytics</small>
            </div>
            <div class="avatar">
              <div class="avatar-initial bg-label-success rounded-3">
                <div class="ri-user-follow-line ri-26px"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="me-1">
              <p class="text-heading mb-1">Personas morales</p>
              <div class="d-flex align-items-center">
                <h4 class="mb-1 me-1">{{$morales}}</h4>
                <p class="text-danger mb-1">(0%)</p>
              </div>
              <small class="mb-0">Recent analytics</small>
            </div>
            <div class="avatar">
              <div class="avatar-initial bg-label-danger rounded-3">
                <div class="ri-group-line ri-26px"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="me-1">
              <p class="text-heading mb-1">Verification Pending</p>
              <div class="d-flex align-items-center">
                <h4 class="mb-1 me-1">{{$empresas}}</h4>
                <p class="text-success mb-1">(+6%)</p>
              </div>
              <small class="mb-0">Recent analytics</small>
            </div>
            <div class="avatar">
              <div class="avatar-initial bg-label-warning rounded-3">
                <div class="ri-user-unfollow-line ri-26px"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
  </div>

<!-- Users List Table -->
<div class="card">
  <div class="card-header pb-0y">
    <h3 class="card-title mb-0">Clientes confirmados</h3>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>Id</th>
          <th>Número de cliente</th>
          <th>Cliente</th>
          <th>Domicilio fiscal</th>
          <th>Régimen</th>
          <th>Contrato para imprimir</th>
          <th>Acciones</th>
        </tr>
      </thead>
    </table>
  </div>

  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasValidarSolicitud" aria-labelledby="offcanvasValidarSolicitudLabel">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasValidarSolicitudLabel" class="offcanvas-title">Validar solicitud</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 h-100">
      <form class="add-new-user pt-0" id="addNewUserForm">
        <input type="hidden" name="id_empresa" id="empresa_id">
        <div class="row">
         
                    
                      <div class="col-md-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <span class="card-title">Se cuenta con todos los medios para realizar todas las actividades de evaluación para la
                                      Certificación</span>
                                    <p>
                                        <label>
                                            <input name="medios" type="radio" value="Si" />
                                            <span><strong>Sí</strong></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input name="medios" type="radio" value="No" />
                                            <span><strong>No</strong></span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 pt-5">
                          <div class="card mb-5">
                              <div class="card-body">
                                  <span class="card-title">El organismo de Certificación tiene la competencia para realizar la Certificación:</span>
                                  <p>
                                      <label>
                                          <input name="competencia" type="radio" value="Si" />
                                          <span><strong>Sí</strong></span>
                                      </label>
                                  </p>
                                  <p>
                                      <label>
                                          <input name="competencia" type="radio" value="No" />
                                          <span><strong>No</strong></span>
                                      </label>
                                  </p>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-12 pt-5">
                        <div class="card mb-5">
                            <div class="card-body">
                                <span class="card-title">El organismo de Certificación tiene la capacidad para llevar a cabo las actividades de
                                  certificación.</span>
                                <p>
                                    <label>
                                        <input name="capacidad" type="radio" value="Si" />
                                        <span><strong>Sí</strong></span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input name="capacidad" type="radio" value="So" />
                                        <span><strong>No</strong></span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    </div>
                        
                    <div class="form-floating form-floating-outline mb-6 mt-5">
                      <textarea name="comentarios" class="form-control h-px-100" id="exampleFormControlTextarea1" placeholder="Comentarios aquí..."></textarea>
                      <label for="exampleFormControlTextarea1">Comentarios</label>
                    </div>
                        
                   
               
        
          
        </div>
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Valiar</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
@include('_partials/_modals/modal-pdfs-frames')
@include('_partials/_modals/modal-edit-cliente_confirmado')
<!-- /Modal -->
@endsection


<!-- Editar Clientes confirmados -->
<script>
  function abrirModal(id_empresa) {
      $.ajax({
          url: '/empresa_contrato/' + id_empresa,
          method: 'GET',
          success: function(response) {
              if (response.length > 0) {
                  const contrato = response[0]; // Obtiene el primer contrato
  
                  // Llena los campos del modal con los datos del contrato
                  $('#empresaID').val(contrato.id_empresa);
                  $('#modalAddressAddress1').val(contrato.fecha_cedula);
                  $('#modalAddressAddress2').val(contrato.idcif);
                  $('#modalAddressLandmark').val(contrato.clave_ine);
                  $('#modalAddressCountry').val(contrato.sociedad_mercantil).trigger('change');
                  $('#modalAddressCity').val(contrato.num_instrumento);
                  $('#modalAddressState').val(contrato.vol_instrumento);
                  $('input[name="fecha_instrumento"]').val(contrato.fecha_instrumento);
                  $('input[name="nombre_notario"]').val(contrato.nombre_notario);
                  $('input[name="num_notario"]').val(contrato.num_notario);
                  $('input[name="estado_notario"]').val(contrato.estado_notario);
                  $('input[name="num_permiso"]').val(contrato.num_permiso);
  
                  // Obtener el número de cliente basado en el id_empresa
                  $.ajax({
                      url: '/empresa_num_cliente/' + id_empresa,
                      method: 'GET',
                      success: function(clienteResponse) {
                          if (clienteResponse.numero_cliente) {
                              $('#numero_cliente').val(clienteResponse.numero_cliente);
                          } else {
                              $('#numero_cliente').val('');
                          }
  
                          // Abre el modal
                          $('#editCliente').modal('show');
                      },
                      error: function(clienteXhr) {
                          console.log(clienteXhr.responseText);
                          alert('Error al cargar el número de cliente.');
                      }
                  });
  
              } else {
                  alert('No se encontraron contratos para esta empresa.');
              }
          },
          error: function(xhr) {
              console.log(xhr.responseText);
              var errorMsg = 'Error al cargar los detalles de la empresa.';
              if (xhr.responseJSON && xhr.responseJSON.error) {
                  errorMsg = xhr.responseJSON.error;
              }
              alert(errorMsg);
          }
      });
  }
  </script>
  

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
  $('#editClienteForm').on('submit', function(event) {
      event.preventDefault(); 
      var formData = $(this).serialize();

      $.ajax({
          url: '/actualizar-registros',
          method: 'POST',
          data: formData,
          success: function(response) {
              console.log('Success:', response);
              $('#editCliente').modal('hide');
              Swal.fire({
                  icon: 'success',
                  title: '¡Éxito!',
                  text: response.success,
                  customClass: {
                      confirmButton: 'btn btn-success'
                  }
              });

              // Actualiza la vista 
              $('.datatables-users').DataTable().ajax.reload();
          },
          error: function(xhr) {
              console.error('Error:', xhr.responseText);
              Swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: xhr.responseJSON.error || 'Error al actualizar los registros',
                  customClass: {
                      confirmButton: 'btn btn-danger'
                  }
              });
          }
      });
  });
});
</script>

