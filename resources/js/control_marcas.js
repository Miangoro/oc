// resources/js/control_marcas.js
$(document).ready(function () {
  const editButtons = document.querySelectorAll('.edit-record');

  editButtons.forEach(button => {
      button.addEventListener('click', function () {
          const id = this.getAttribute('data-id');
          fetch(`/catalogo/marcas/${id}/edit`)
              .then(response => response.json())
              .then(data => {
                  document.getElementById('user_id').value = data.id_marca;
                  document.getElementById('cliente').value = data.id_empresa;
                  document.getElementById('add-user-company').value = data.marca;
                  document.getElementById('add-user-folio').value = data.folio;

                  // Cambia el título del formulario y el botón de submit
                  document.getElementById('offcanvasAddUserLabel').innerText = 'Editar registro';
                  document.querySelector('.data-submit').innerText = 'Actualizar';

                  // Cambia la acción del formulario y el método a PUT
                  document.getElementById('addNewUserForm').action = `/catalogo/marcas/update/${data.id_marca}`;
                  document.getElementById('formMethod').value = 'PUT';
              })
              .catch(error => console.error('Error:', error));
      });
  });

  // Otros códigos relevantes que ya tenías en tu archivo
  $('.datepicker').datepicker({
      format: 'yyyy-mm-dd'
  });

  $(document).on('click', '#openUploadModal', function (e) {
      e.preventDefault();
      $('#uploadModal').modal('show');
  });

  var dt_user_table = $('.datatables-users');
  if (dt_user_table.length) {
      // Tu configuración existente de DataTables
  }

  // Otros códigos relevantes que ya tenías en tu archivo
});
