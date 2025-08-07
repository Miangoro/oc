document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('ticketFilterForm');
  const tablaBody = document.querySelector('#ticketsTable tbody');

  form?.addEventListener('submit', function (e) {
    e.preventDefault();

    const estado = document.getElementById('estado').value;
    const prioridad = document.getElementById('prioridad').value;
    const responsable = document.getElementById('responsable').value;

    fetch(`${filtroURL}?estado=${estado}&prioridad=${prioridad}&responsable=${responsable}`)
      .then(response => response.json())
      .then(data => {
        tablaBody.innerHTML = data.html;
      })
      .catch(error => {
        console.error('Error al filtrar:', error);
      });
  });
});
