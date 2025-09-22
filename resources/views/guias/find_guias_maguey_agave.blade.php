@extends('layouts/layoutMaster')

@section('title', 'Guias maguey/agave')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
  'resources/assets/vendor/libs/spinkit/spinkit.scss',
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss'

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
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',

])
@endsection

<!-- Page Scripts -->
@section('page-script')
<script>
  window.puedeAgregarElUsuario = @json(auth()->user()->can('Registrar guías de traslado'));
  window.puedeEditarElUsuario = @json(auth()->user()->can('Editar guías de traslado'));
  window.puedeSubirGuiaEscaneada = @json(auth()->user()->can('Subir guía escaneada'));
  window.puedeEliminarElUsuario = @json(auth()->user()->can('Eliminar guías de traslado'));
</script>
@vite(['resources/js/guias_maguey_agave.js'])
@endsection

@section('content')

{{-- <meta name="csrf-token" content="{{ csrf_token() }}">
 --}}
<!-- Users List Table -->
<div class="card">
    <div class="card-header pb-0">
      <h3 class="card-title mb-0">Solicitudes de guía de traslado de maguey o agave</h3>
    </div>
    <div class="card-datatable table-responsive">
      <table class="datatables-users table">
        <thead class="table-dark">
          <tr>
            <th></th>
            {{-- <th>#</th> --}}
            <th>Predio</th>
            <th>Cliente</th>
            <th>Folio</th>
            <th>Folio de solicitud</th>
            {{-- <th>Cantidad guias</th> --}}
            <th>Guias</th>
            {{--<th>Plantas actuales</th>
            <th>No. anterior</th>
            <th>Comercializadas</th>
            <th>No. mermas</th> --}}
            <th>Caracteristicas</th>
            <th>Doc. Adjuntos</th>
            <th>Acciones</th>
          </tr>
        </thead>
      </table>
    </div>
</div>



<!--MODAL SUBIR GUIA ESCANEADA Y RESULTADOS ART-->
<div class="modal fade" id="ModalSubirPDF" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary pb-4">
          <h5 class="modal-title text-white">Subir archivos PDF</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
        <form id="formSubirPDF" method="POST">
            <input type="hidden" id="id_guia" name="id_guia">
            <div class="row">
                <div class="form-floating form-floating-outline mb-5">
                    <input class="form-control form-control-sm" type="file" name="documento[71]">
                    <label for="Guía de traslado de agave">Adjuntar Guia escaneada</label>

                    <div id="docActual_71"></div>
                    <div id="EliminarDoc_71"></div>
                </div>
                <div class="form-floating form-floating-outline mb-5">
                    <input class="form-control form-control-sm" type="file" name="documento[132]">
                    <label for="Resultados ART">Adjuntar resultados de ART</label>

                    <div id="docActual_132"></div>
                    <div id="EliminarDoc_132"></div>
                </div>
            </div>

            <div class="d-flex mt-6 justify-content-center">
                <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i>
                    Registrar</button>
                {{-- <button id="btnCancelModal" type="reset" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal" aria-label="Close">
                  <i class="ri-arrow-go-back-line"> </i> Regresar</button> --}}
                  <button type="reset" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
@include('_partials/_modals/modal-pdfs-frames')
@include('_partials/_modals/modal-add-guias-agave')

@include('_partials/_modals/modal-ver-guias-registardas')
<!-- /Modal -->


@endsection
