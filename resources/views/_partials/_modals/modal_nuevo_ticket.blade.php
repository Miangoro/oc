@php use Illuminate\Support\Facades\Auth; @endphp

@php

  $usuario = $usuario ?? Auth::user();
@endphp

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formCrearTicket');
    const modal = document.getElementById('modalNuevoTicket');
    const evidenciasContainer = document.getElementById('evidenciasContainer');
    const btnAgregar = document.getElementById('btnAgregarEvidencia');

    // Validación con SweetAlert2
    form.addEventListener('submit', function (e) {
      const asunto = form.querySelector('[name="asunto"]').value.trim();
      const descripcion = form.querySelector('[name="descripcion"]').value.trim();
      const prioridad = form.querySelector('[name="prioridad"]').value;

      let errores = [];

      if (!asunto) errores.push('El campo "Asunto" es obligatorio.');
      if (!descripcion) errores.push('La "Descripción" no puede estar vacía.');
      if (!prioridad) errores.push('Selecciona una prioridad.');

      if (errores.length > 0) {
        e.preventDefault(); // Solo si hay errores
        Swal.fire({
          icon: 'error',
          title: 'Validación fallida',
          html: errores.map(e => `<p>${e}</p>`).join(''),
          confirmButtonText: 'Revisar'
        });
      } else {
      }
    });


    // Agregar campo de evidencia con botón de eliminación
    btnAgregar.addEventListener('click', () => {
      const grupo = document.createElement('div');
      grupo.classList.add('input-group', 'mb-2');

      const input = document.createElement('input');
      input.type = 'file';
      input.name = 'evidencias[]';
      input.classList.add('form-control');
      input.accept = '.pdf,.jpg,.jpeg,.png';

      const btnEliminar = document.createElement('button');
      btnEliminar.type = 'button';
      btnEliminar.classList.add('btn', 'btn-outline-danger');
      btnEliminar.textContent = '✕';
      btnEliminar.title = 'Eliminar evidencia';
      btnEliminar.addEventListener('click', () => grupo.remove());

      const wrapper = document.createElement('div');
      wrapper.classList.add('input-group-append');
      wrapper.appendChild(btnEliminar);

      grupo.appendChild(input);
      grupo.appendChild(wrapper);

      evidenciasContainer.appendChild(grupo);
    });

    // Limpiar formulario al cerrar modal
    modal.addEventListener('hidden.bs.modal', function () {
      // Guardamos los valores precargados antes del reset
      const nombreInput = form.querySelector('[name="nombre"]');
      const emailInput = form.querySelector('[name="email"]');
      const nombreInicial = nombreInput.value;
      const emailInicial = emailInput.value;

      // Reset del formulario
      form.reset();

      // Restaurar los valores precargados
      nombreInput.value = nombreInicial;
      emailInput.value = emailInicial;

      // Restaurar el campo de evidencias
      evidenciasContainer.innerHTML = `
    <div class="input-group mb-2">
      <input type="file" name="evidencias[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
    </div>
  `;
    });

  });
</script>
<div class="modal fade" id="modalNuevoTicket" tabindex="-1" aria-labelledby="modalNuevoTicketLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h2 class="modal-title text-white fw-bold" id="modalNuevoTicketLabel">Crear nuevo ticket</h2>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="formCrearTicket" method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row mb-3">
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Nombre</label>
                <input type="text" class="form-control" name="nombre" value="{{ $usuario->name }}" readonly required>
              </div>
              <div class="col-md-6">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{ $usuario->email }}" readonly required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label>Asunto del ticket</label>
                <input type="text" class="form-control" name="asunto" required>
              </div>
              <div class="col-md-6">
                <label>Prioridad</label>
                <select class="form-select" name="prioridad" required>
                  <option value="">Selecciona</option>
                  <option value="Alta">Alta</option>
                  <option value="Media">Media</option>
                  <option value="Baja">Baja</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label>Descripción detallada</label>
              <textarea class="form-control" name="descripcion" rows="4" required></textarea>
            </div>

            <div id="evidenciasContainer">
              <div class="input-group mb-2">
                <input type="file" name="evidencias[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
              </div>
            </div>

            <button type="button" id="btnAgregarEvidencia" class="btn btn-outline-primary mb-3">
              Agregar evidencia
            </button>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Registrar</button>
          </div>
      </form>
    </div>
  </div>
</div>