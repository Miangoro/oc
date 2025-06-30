$(function () {
  const tabla = $('.datatables-aduanas');

  if (tabla.length) {
    tabla.DataTable({
      ajax: '/catalogo/aduana/data',
      columns: [
        { data: null },       // enumerador
        { data: 'id' },
        { data: 'ubicacion' },
        {
          data: null,
          render: function (data, type, row) {
            return `
              <div class="dropdown">
                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ri-settings-3-line me-1"></i> Opciones
                </button>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item edit-aduana" href="#" data-id="${row.id}">
                      <i class="ri-pencil-line me-2"></i> Editar Aduana
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item delete-aduana text-danger" href="#" data-id="${row.id}">
                      <i class="ri-delete-bin-line me-2"></i> Eliminar Aduana
                    </a>
                  </li>
                </ul>
              </div>
            `;
          }
        }
      ],
      columnDefs: [
        {
          targets: 0,
          searchable: false,
          orderable: false,
          render: function (data, type, row, meta) {
            return meta.row + 1;
          }
        }
      ]
    });
  }
});