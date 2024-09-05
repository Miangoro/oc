document.addEventListener('DOMContentLoaded', function () {
    const tabs = {
        'tab-mezcal': 'mezcal',
        'tab-alcoholicas': 'alcoholicas',
        'tab-no-alcoholicas': 'no-alcoholicas'
    };

    function cargarCards(tipo) {
        fetch(`${obtenerSolicitudesTiposUrl}?tipo=${tipo}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Red no disponible');
                }
                return response.json();
            })
            .then(data => {
                const contentContainerId = Object.keys(tabs).find(key => tabs[key] === tipo) + '-content';
                const contentContainer = document.getElementById(contentContainerId);
                contentContainer.innerHTML = ''; // Limpia el contenedor antes de agregar nuevos datos
                
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(item => {
                        const card = document.createElement('div');
                        card.className = 'col-sm-12 col-md-6 col-lg-4 col-xl-3';
                        card.innerHTML = `
                            <div class="card card-hover shadow-sm border-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-wine-glass-alt fa-3x mb-3"></i> <!-- Aquí es donde agregas el ícono -->
                                    <h5 class="card-title mb-4">${item.tipo}</h5>
                                </div>
                            </div>
                        `;
                        contentContainer.appendChild(card);
                    });
                } else {
                    contentContainer.innerHTML = '<p>No se encontraron datos.</p>';
                }
            })
            .catch(error => {
                console.error('Error al obtener los datos:', error);
                const contentContainerId = Object.keys(tabs).find(key => tabs[key] === tipo) + '-content';
                document.getElementById(contentContainerId).innerHTML = '<p class="text-danger">No se pudo cargar la información.</p>';
            });
    }

    // Cargar datos para la pestaña activa por defecto
    cargarCards('mezcal');

    // Configura el cambio de pestaña
    document.querySelectorAll('#myTab a[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', (event) => {
            const tipo = tabs[event.target.id];
            cargarCards(tipo);
        });
    });
});
