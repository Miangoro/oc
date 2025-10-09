@extends('layouts/layoutMaster')
@section('title', 'Lotes envasado')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
<script>
  window.puedeAgregarElUsuario = @json(auth()->user()->can('Registrar lotes envasados'));
  window.puedeEditarElUsuario = @json(auth()->user()->can('Editar lotes envasados'));
  window.puedeVerTrazabilidad = @json(auth()->user()->can('Trazabilidad lotes envasados'));
  window.puedeEliminarElUsuario = @json(auth()->user()->can('Eliminar lotes envasados'));
  window.puedeVerElUsuario = @json(auth()->user()->can('Modificar botellas/volumen restante envasado'));
</script>
    @vite(['resources/js/lotes_envasado.js'])
@endsection

@section('content')
<!-- Users List Table -->
<div class="card">
    <div class="card-header pb-0">
        <h3 class="card-title mb-0 fw-bold">Lotes envasados</h3>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Datos del cliente</th>
                    <th>Lotes</th>
                    <th>Marca</th>
                    <th>Numero de botellas</th>
                    <th>Presentación</th>
                    <th>%Alc. Vol</th>
                    <th>Volumen</th>
                    <th>Destino lote</th>
                    <th>Lugar de envasado</th>
                    <th>No. de pedido/SKU</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>




<!--MODAL TRAZABILIDAD-->
{{-- <div class="modal fade" id="ModalTracking" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
        
        <div class="modal-body">
          <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close">
          </button>

          <div class="text-center mb-4 pt-5">
            <h4 class="address-title mb-2">Trazabilidad del lote</h4>
            <p class="folio badge bg-primary"></p>
          </div>

          <div class="card pl-0"> 
            <div class="card-body pb-0">
              <ul id="ListTracking" class="timeline mb-0 pb-5">

              </ul>
            </div>
          </div>
          
          <!-- Botón cerrar -->
          <div class="col-12 mt-4 d-flex justify-content-center">
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>

        </div>
    </div>
  </div>
</div> --}}
<!-- MODAL TRAZABILIDAD 2-->
<div class="modal fade" id="ModalTracking" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-body">
            <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="text-center mb-4 pt-3">
               <h4 class="address-title mb-2">Trazabilidad del lote envasado</h4>
               <p class="folio badge bg-primary"></p>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="trazabilidadTabs" role="tablist">
               <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">General</button>
               </li>
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="certificados-tab" data-bs-toggle="tab" data-bs-target="#certificados" type="button" role="tab">Certificados</button>
               </li>
            </ul>

            <div class="tab-content">
               <!-- GENERAL (timeline) -->
               <div class="tab-pane fade show active" id="general" role="tabpanel">
                  <ul id="ListTrackingGeneral" class="timeline mb-0 pb-5">

                  </ul>
               </div>

               <!-- CERTIFICADOS (tabla) -->
               <div class="tab-pane fade" id="certificados" role="tabpanel">
                  <div class="table-responsive">
                     <table class="table table-striped table-bordered" id="TableCertificados">
                        <thead class="table-light">
                           <tr>
                              <th>Fecha</th>
                              {{-- <th>Tipo</th> --}}
                              <th>Certificado</th>
                              <th>Caracteristicas</th>
                           </tr>
                        </thead>
                        <tbody></tbody>
                     </table>
                  </div>
               </div>
            </div>

            <!-- Botón cerrar -->
            <div class="col-12 mt-4 d-flex justify-content-center">
               <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
         </div>
      </div>
   </div>
</div>


    <!-- Modal -->
    @include('_partials/_modals/modal-add-lotesEnvasado')
    @include('_partials._modals/modal-edit-lotesEnvasado')
    @include('_partials/_modals/modal-edit-lotesSKU')
    <!-- /Modal -->
@endsection
