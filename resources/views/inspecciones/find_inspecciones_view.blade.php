@extends('layouts.layoutMaster')

@section('title', 'Inspecciones')

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

@section('page-script')
@vite(['resources/js/inspecciones.js'])
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const certificacionSelectAdd = document.getElementById('certificacion');
    const certificadoOtrosDivAdd = document.getElementById('certificado-otros');
    const tipoSelectAdd = document.getElementById('tipo');
    const modalAddInstalacion = document.getElementById('modalAddInstalacion');

    const certificacionSelectEdit = document.getElementById('edit_certificacion');
    const certificadoOtrosDivEdit = document.getElementById('edit_certificado_otros');
    const tipoSelectEdit = document.getElementById('edit_tipo');
    const modalEditInstalacion = document.getElementById('modalEditInstalacion');

    function toggleCertificadoOtros(selectElement, divElement) {
      if (selectElement.value === 'otro_organismo') {
        divElement.classList.remove('d-none');
      } else {
        divElement.classList.add('d-none');
      }
    }

    function updateDocumentFields(tipoSelect, divElement) {
      const hiddenIdDocumento = divElement.querySelector('input[name="id_documento[]"]');
      const hiddenNombreDocumento = divElement.querySelector('input[name="nombre_documento[]"]');
      const fileCertificado = divElement.querySelector('input[type="file"]');

      switch (tipoSelect.value) {
        case 'productora':
          hiddenIdDocumento.value = '127';
          hiddenNombreDocumento.value = 'Certificado de instalaciones';
          fileCertificado.setAttribute('id', 'file-127');
          break;
        case 'envasadora':
          hiddenIdDocumento.value = '128';
          hiddenNombreDocumento.value = 'Certificado de envasadora';
          fileCertificado.setAttribute('id', 'file-128');
          break;
        case 'comercializadora':
          hiddenIdDocumento.value = '129';
          hiddenNombreDocumento.value = 'Certificado de comercializadora';
          fileCertificado.setAttribute('id', 'file-129');
          break;
        default:
          hiddenIdDocumento.value = '';
          hiddenNombreDocumento.value = '';
          fileCertificado.removeAttribute('id');
          break;
      }
    }

    function setupEventListeners() {
      // Add modal event listeners
      certificacionSelectAdd.addEventListener('change', function () {
        toggleCertificadoOtros(certificacionSelectAdd, certificadoOtrosDivAdd);
      });

      tipoSelectAdd.addEventListener('change', function () {
        updateDocumentFields(tipoSelectAdd, certificadoOtrosDivAdd);
      });

      modalAddInstalacion.addEventListener('shown.bs.modal', function () {
        certificacionSelectAdd.value = '';
        $(certificacionSelectAdd).trigger('change');
        tipoSelectAdd.value = '';
        $(tipoSelectAdd).trigger('change');
        certificadoOtrosDivAdd.classList.add('d-none');
      });

      modalAddInstalacion.addEventListener('hidden.bs.modal', function () {
        certificacionSelectAdd.value = '';
        $(certificacionSelectAdd).trigger('change');
        tipoSelectAdd.value = '';
        $(tipoSelectAdd).trigger('change');
        certificadoOtrosDivAdd.classList.add('d-none');
      });

      // Edit modal event listeners
      certificacionSelectEdit.addEventListener('change', function () {
        toggleCertificadoOtros(certificacionSelectEdit, certificadoOtrosDivEdit);
      });

      tipoSelectEdit.addEventListener('change', function () {
        updateDocumentFields(tipoSelectEdit, certificadoOtrosDivEdit);
      });

      modalEditInstalacion.addEventListener('shown.bs.modal', function () {
        certificacionSelectEdit.value = '';
        $(certificacionSelectEdit).trigger('change');
        tipoSelectEdit.value = '';
        $(tipoSelectEdit).trigger('change');
        certificadoOtrosDivEdit.classList.add('d-none');
      });

      modalEditInstalacion.addEventListener('hidden.bs.modal', function () {
        certificacionSelectEdit.value = '';
        $(certificacionSelectEdit).trigger('change');
        tipoSelectEdit.value = '';
        $(tipoSelectEdit).trigger('change');
        certificadoOtrosDivEdit.classList.add('d-none');
      });
    }

    setupEventListeners();
  });
</script>

<style>
.text-primary {
    color: #262b43 !important;
}
</style>
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Users List Table -->
<div class="card">
    <div class="card-header pb-0">
        <h3 class="card-title mb-0">Inspecciones</h3>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th>No.</th>
                    <th>Folio</th>
                    <th>No. de servicio</th>
                    <th>Cliente</th>
                    <th>Fecha de solicitud</th>
                    <th>Solicitud</th>
                    <th>Domicilio de inspección</th>
                    <th>Fecha y hora de visita estimada</th>
                    <th>Inspector asignado</th>
                    <th>Fecha y hora de inspección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>





    <!-- Modal -->
    @include('_partials._modals.modal-pdfs-frames')
    @include('_partials._modals.modal-expediente-servicio')
    @include('_partials._modals.modal-add-asignar-inspector')
    <!-- /Modal -->

</div>
@endsection

<script>
    function abrirModal(id_empresa) {
    // Hacer una petición AJAX para obtener los detalles de la empresa
    $.ajax({
        url: '/lista_empresas/' + id_empresa,
        method: 'GET',
        success: function(response) {
            // Cargar los detalles en el modal
            var contenido = "";

          for (let index = 0; index < response.normas.length; index++) {
            contenido = '<input value="'+response.normas[index].id_norma+'" type="hidden" name="id_norma[]"/><div class="col-12 col-md-12 col-sm-12"><div class="form-floating form-floating-outline"><input type="text" id="numero_cliente'+response.normas[index].id_norma+'" name="numero_cliente[]" class="form-control" placeholder="Introducir el número de cliente" /><label for="modalAddressFirstName">Número de cliente para la norma '+response.normas[index].norma+'</label></div></div><br>' + contenido;
            console.log(response.normas[index].norma);
          }
           

         //   $('.contenido').html(contenido);
           
            // Abrir el modal
            $('#expedienteServicio').modal('show');
        },
        error: function() {
            alert('Error al cargar los detalles de la empresa.');
        }
    });
  }

  function abrirModalAsignarInspector(id_solicitud) {

     $("#id_solicitud").val(id_solicitud);
      $('#asignarInspector').modal('show');
  }
</script>

