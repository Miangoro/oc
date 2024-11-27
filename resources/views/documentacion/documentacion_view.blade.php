@extends('layouts/layoutMaster')

@section('title', 'Documentación')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
  'resources/assets/vendor/libs/select2/select2.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/select2/select2.js'
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
           
            <form id="uploadForm" enctype="multipart/form-data">
              <div class="form-floating form-floating-outline m-5 col-md-6">
                <select name="id_empresa" id="id_empresa" class="select2 form-select">
                  
                  @foreach ($empresas as $cliente)
                  <option value="{{ $cliente->id_empresa }}">{{ $cliente->empresaNumClientes[0]->numero_cliente ?? $cliente->empresaNumClientes[1]->numero_cliente }} | {{ $cliente->razon_social }}</option>
              @endforeach
                
               
                </select>
                
              </div>

              <!-- Contenedor para la barra de progreso -->

            
           
                <div class="" id="contenido"></div>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Subir documentación</button>
               
            </form>

          </div>
        </div>
      </div>
      <!--/ Orders by Countries -->
</div>

@include('_partials/_modals/modal-pdfs-frames')
<!-- /Modal -->
<script type="module">
// Check selected custom option
window.Helpers.initCustomOptionCheck();

</script>

<script>
$(document).ready(function() {

  
  initializeSelect2($('.select2'));
    // Función para cargar los datos de la normativa
    function cargarNormas(clienteId) {
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
    }

    // Cargar datos cuando el valor de #id_empresa cambia
    $('#id_empresa').change(function() {
        var clienteId = $(this).val();
        cargarNormas(clienteId);  // Llamada para cargar las normas según el cliente seleccionado
    });

    // Cargar datos al cargar la página por primera vez, usando el valor seleccionado inicialmente
    var clienteIdInicial = $('#id_empresa').val();
    cargarNormas(clienteIdInicial);  // Llamada para cargar las normas al cargar la página

});



  function abrirModal(url) {
    var id = $(this).data('id');
        var registro = $(this).data('registro');
            var iframe = $('#pdfViewer');
            iframe.attr('src', ''+url);

            //$("#titulo_modal").text("Solicitud de información del cliente");
            //$("#subtitulo_modal").text(registro);
  }

  document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita el envío normal del formulario

    let form = document.getElementById('uploadForm');
    let formData = new FormData(form);
     // Añadir el token CSRF
     formData.append('_token', '{{ csrf_token() }}');

let xhr = new XMLHttpRequest();

xhr.open('POST', '{{ route('upload') }}', true);

// Configurar SweetAlert con barra de progreso
Swal.fire({
        title: 'Subiendo...',
        html: `
            Por favor, espera mientras subimos tus documentos.
            <br><br>
            <div class="swal2-progress-bar" style="width: 0%; background: green; height: 25px;"></div>
            <b>0%</b>
        `,
        allowOutsideClick: false,
        showCancelButton: false,
        showDenyButton: false, 
        didOpen: () => {
            Swal.showLoading();

            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    let percentage = (e.loaded / e.total) * 100;
                    Swal.getContent().querySelector('b').textContent = Math.round(percentage) + '%';

                    // Actualiza la barra de progreso
                    Swal.getContent().querySelector('.swal2-progress-bar').style.width = percentage + '%';
                }
            };
        }
    });

    // Manejador de la respuesta
    xhr.onload = function() {
        if (xhr.status === 200) {
            Swal.fire({
                icon: 'success',
                title: '¡Carga exitosa!',
                text: 'Tus documentos se han subido con éxito.',
                confirmButtonText: 'OK',
                showCancelButton: false,
                showDenyButton: false, 
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: '¡Carga falló!',
                text: 'Hubo un error al subir tus documentos.',
                confirmButtonText: 'OK',
                showCancelButton: false,
                showDenyButton: false, 
            });
        }
    };

    // Manejo de errores
    xhr.onerror = function() {
        Swal.fire({
            icon: 'error',
            title: '¡Carga falló!',
            text: 'Hubo un error al subir tus documentos.'
        });
    };

    // Envía la solicitud
    xhr.send(formData);
});

function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
   
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent()
      });
    });
  }



</script>
@endsection
