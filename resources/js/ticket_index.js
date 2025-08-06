document.addEventListener('DOMContentLoaded', function () {
  const btnNuevo = document.getElementById('btnNuevoTicket');
  const btnCancelar = document.getElementById('btnCancelarTicket');
  const formulario = document.getElementById('formularioTicket');

  btnNuevo.addEventListener('click', () => {
    formulario.classList.remove('d-none');
    btnNuevo.classList.add('d-none');
  });

  btnCancelar.addEventListener('click', () => {
    formulario.classList.add('d-none');
    btnNuevo.classList.remove('d-none');
  });
});
