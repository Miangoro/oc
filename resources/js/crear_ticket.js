document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('formCrearTicket');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const asunto = form.querySelector('[name="asunto"]').value.trim();
    const descripcion = form.querySelector('[name="descripcion"]').value.trim();
    const categoria = form.querySelector('[name="categoria"]').value;

    let errores = [];

    if (!asunto) errores.push('El campo "Asunto" es obligatorio.');
    if (!descripcion) errores.push('La "Descripción" no puede estar vacía.');
    if (!categoria) errores.push('Selecciona una categoría.');

    if (errores.length > 0) {
      Swal.fire({
        icon: 'error',
        title: 'Validación fallida',
        html: errores.map(e => `<p>${e}</p>`).join(''),
        confirmButtonText: 'Revisar'
      });
    } else {
      // Aquí podrías enviar el formulario vía AJAX o permitir el submit
      Swal.fire({
        icon: 'success',
        title: 'Ticket creado',
        text: 'Tu ticket ha sido registrado correctamente.',
        confirmButtonText: 'Aceptar'
      }).then(() => {
        form.submit(); // Si quieres que se envíe normalmente
      });
    }
  });
});
