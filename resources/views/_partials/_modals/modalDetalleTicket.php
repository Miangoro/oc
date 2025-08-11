<script>
window.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modalDetalleTicket');
  const contenido = document.getElementById('detalleContenido');

  if (!modal || !contenido) {
    console.error('El modal o el contenedor no existen en el DOM.');
    return;
  }

  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    let ticket;

    try {
      ticket = JSON.parse(button.getAttribute('data-ticket'));
    } catch (e) {
      contenido.innerHTML = `<div class="alert alert-danger">Error al cargar el ticket. Revisa el formato del JSON.</div>`;
      return;
    }

    let html = `
      <div class="mb-3">
        <label class="form-label"><strong>Solicitante:</strong></label>
        <p>${ticket.nombre} (<a href="mailto:${ticket.email}">${ticket.email}</a>)</p>
      </div>

      <div class="mb-3">
        <label class="form-label"><strong>Descripción:</strong></label>
        <p>${ticket.descripcion}</p>
      </div>

      <div class="row mb-3">
        <div class="col-md-4">
          <label class="form-label"><strong>Prioridad:</strong></label>
          <p class="badge bg-${ticket.prioridad === 'alta' ? 'danger' : ticket.prioridad === 'media' ? 'warning' : 'secondary'} text-uppercase">${ticket.prioridad}</p>
        </div>
        <div class="col-md-4">
          <label class="form-label"><strong>Estado:</strong></label>
          <p class="badge bg-${ticket.estatus === 'pendiente' ? 'info' : 'success'} text-uppercase">${ticket.estatus}</p>
        </div>
        <div class="col-md-4">
          <label class="form-label"><strong>Fecha de creación:</strong></label>
          <p>${ticket.created_at}</p>
        </div>
      </div>
    `;

    if (ticket.evidencias && ticket.evidencias.length > 0) {
      html += `<div class="mb-3"><label class="form-label"><strong>Evidencias:</strong></label><ul>`;
      ticket.evidencias.forEach(ev => {
        html += `<li><a href="/storage/${ev.archivo}" target="_blank" class="text-decoration-none">📎 ${ev.nombre}</a></li>`;
      });
      html += `</ul></div>`;
    }

    if (ticket.comentario && ticket.comentario.trim() !== '') {
      html += `
        <div class="alert alert-secondary mt-3">
          <strong>Comentario del administrador:</strong><br>
          ${ticket.comentario}
        </div>
      `;
    }

    
    

    contenido.innerHTML = html;
  });
});

</script>

<div class="modal fade" id="modalDetalleTicket" tabindex="-1" aria-labelledby="modalDetalleTicketLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalDetalleTicketLabel">Detalle del Ticket</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body px-4 py-3">
        <div id="detalleContenido" class="text-sm">
          <!-- Aquí se cargará dinámicamente el contenido -->
        </div>
      </div>

      <div class="modal-footer justify-content-between px-4 py-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
