@extends('layouts/layoutMaster')

@section('title', 'Cards Advance- UI elements')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('page-script')
@vite([
  'resources/assets/js/cards-advance.js',
  'resources/assets/js/modal-add-new-cc.js'
])
@endsection

@section('content')
<div class="row g-6">

    <div class="col-md-12 col-xxl-12">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h2 class="m-0 me-2">Requisitos documentales</h2>
              
            </div>
            
            
          </div>
          <div class="card-body p-0">
           
              <div class="form-floating form-floating-outline m-5 col-md-6">
                <select name="id_empresa" id="id_empresa" class="select2 form-select">
                  <option value="">Select</option>
                  
                  @foreach ($empresas as $empresa)
                  <option value="{{$empresa->id_empresa}}">{{$empresa->razon_social}}</option>
                  @endforeach
                
               
                </select>
                <label for="country">Cliente</label>
              </div>
            
            <div class="" id="contenido"></div>
          </div>
        </div>
      </div>
      <!--/ Orders by Countries -->
</div>

@include('_partials/_modals/modal-add-new-cc')
@include('_partials/_modals/modal-upgrade-plan')
<!-- /Modal -->
<script type="module">
// Check selected custom option
window.Helpers.initCustomOptionCheck();

</script>

<script>
  $(document).ready(function() {
      $('#id_empresa').change(function() {
          var clienteId = $(this).val();
          if (clienteId) {
              $.ajax({
                  url: '{{ route('documentacion.getNormas') }}',
                  method: 'GET',
                  data: { cliente_id: clienteId },
                  success: function(data) {
                      $('#contenido').html(data.tabs); // Insertar pestañas
                     

                      
                      
                  }
              });
          } else {
              $('#contenido').empty(); // Limpiar pestañas anteriores
            
          }
      });
  });
</script>
@endsection
