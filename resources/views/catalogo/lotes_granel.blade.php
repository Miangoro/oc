
@extends('layouts/layoutMaster')

@section('title', 'Lotes a granel')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss','resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss','resources/assets/vendor/libs/spinkit/spinkit.scss'])
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
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',

])
@endsection

<!-- Page Scripts -->
@section('page-script')
<script>
  window.puedeAgregarElUsuario = @json(auth()->user()->can('Registrar lotes a granel'));
  window.puedeEditarElUsuario = @json(auth()->user()->can('Editar lotes a granel'));
  window.puedeVerTrazabilidad = @json(auth()->user()->can('Trazabilidad lotes a granel'));
  window.puedeEliminarElUsuario = @json(auth()->user()->can('Eliminar lotes a granel'));
  window.puedeVerElUsuario = @json(auth()->user()->can('Modificar volumen restante a granel'));
</script>
    @vite(['resources/js/catalogo_lotes.js'])
@endsection


@section('content')
<!-- Users List Table -->
<div class="card">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="card-header pb-0">
        <h3 class="card-title mb-0 fw-bold">Lotes a granel</h3>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>tipo lote</th>
                    <th>No. de lote</th>
                    <th>Características</th>
                    <th>FQs</th>
                    <th>%Alc. Vol.</th>
                    <th>Volumen restante</th>
                    <th>Certificado</th>
                    <th>estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>




<!--MODAL TRAZABILIDAD-->
<div class="modal fade" id="ModalTracking" tabindex="-1" aria-hidden="true">
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
              {{-- <li class="timeline-item timeline-item-transparent mb-8">
                <span class="timeline-point timeline-point-primary p-2"></span>

                <div class="card border border-primary p-3 ms-2 rounded">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0">
                      <i class="ri-file-text-line me-1"></i> Registro de Lote
                    </h6>
                    <small class="text-muted">2025-10-03 12:30</small>
                  </div>
                  <p class="mb-1">Folio: 12345</p>
                </div>
              </li> --}}
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
</div>


  <!-- Modal -->
  @include('_partials/_modals/modal-pdfs-frames')
  @include('_partials/_modals/modal-add-lotes-granel')
  @include('_partials/_modals/modal-edit-lotes-granel')
  <!-- /Modal -->
@endsection
