document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('formCrearTicket');
  const modal = document.getElementById('modalNuevoTicket');
  const evidenciasContainer = document.getElementById('evidenciasContainer');
  const btnAgregar = document.getElementById('btnAgregarEvidencia');

  // Validación con SweetAlert2
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const asunto = form.querySelector('[name="asunto"]').value.trim();
    const descripcion = form.querySelector('[name="descripcion"]').value.trim();
    const prioridad = form.querySelector('[name="prioridad"]').value;

    let errores = [];

    if (!asunto) errores.push('El campo "Asunto" es obligatorio.');
    if (!descripcion) errores.push('La "Descripción" no puede estar vacía.');
    if (!prioridad) errores.push('Selecciona una prioridad.');

    if (errores.length > 0) {
      Swal.fire({
        icon: 'error',
        title: 'Validación fallida',
        html: errores.map(e => `<p>${e}</p>`).join(''),
        confirmButtonText: 'Revisar'
      });
    } else {
      Swal.fire({
        icon: 'success',
        title: 'Ticket creado',
        text: 'Tu ticket ha sido registrado correctamente.',
        confirmButtonText: 'Aceptar'
      }).then(() => {
        form.submit(); // Envío normal
      });
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
    form.reset();
    evidenciasContainer.innerHTML = `
      <div class="input-group mb-2">
        <input type="file" name="evidencias[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
      </div>
    `;
  });
});

