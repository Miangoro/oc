document.addEventListener('DOMContentLoaded', function () {
    const tabs = {
        'tab-mezcal': 'mezcal',
        'tab-alcoholicas': 'alcoholicas',
        'tab-no-alcoholicas': 'no-alcoholicas'
    };

// Función Icono por ID
function obtenerIcono(id_tipo) {
    const id_tipoStr = id_tipo.toString();
    console.log('ID recibido:', id_tipoStr); 
    switch (id_tipoStr) {
        case '1': 
            return 'assets/img/icons/brands/asana.png';
        case '2': 
            return 'assets/img/icons/brands/behance.png'; 
        case '3': 
            return 'assets/img/icons/brands/cent.png'; 
        case '4': 
            return 'assets/img/icons/brands/chrome.png'; 
        case '5': 
            return 'assets/img/icons/brands/edge.png'; 
        case '6': 
            return 'assets/img/icons/brands/facebook.png'; 
        case '7': 
            return 'assets/img/icons/brands/github.png'; 
        case '8': 
            return 'assets/img/icons/brands/google.png'; 
        case '9': 
            return 'assets/img/icons/brands/mac.png'; 
        case '10': 
            return 'assets/img/icons/brands/opera.png'; 
        case '11': 
            return 'assets/img/icons/brands/python.png'; 
        case '12': 
            return 'assets/img/icons/brands/slack.png'; 
        case '13': 
            return 'assets/img/icons/brands/windows.png'; 
        case '14': 
            return 'assets/img/icons/brands/safari.png'; 
        case '15': 
            return 'assets/img/icons/brands/vue.png'; 
        default:
            return 'assets/img/icons/brands/reddit-rounded.png'; 
    }
}
    
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
                contentContainer.innerHTML = ''; 

                var solicitudesMap = {
                    1: "#addSolicitudMuestreoAgave",
                    10: "#addSolicitudGeoreferenciacion",
                    14: "#addSolicitudDictamen",    
                    3: "#addSolicitudOtroTipo",         
                  
                };

                
                
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(item => {
                        const solicitud = solicitudesMap[item.id_tipo] || "#defaultSolicitud";
                        const icono = obtenerIcono(item.id_tipo); 
                        console.log('Ícono asignado:', icono);
                        const card = document.createElement('div');
                        card.className = 'col-sm-12 col-md-6 col-lg-4 col-xl-3';
                        card.innerHTML = ` 
                            <div data-bs-target="${solicitud}" data-bs-toggle="modal" data-bs-dismiss="modal"  class="card card-hover shadow-sm border-light">
                                <div class="card-body text-center d-flex flex-column align-items-center">
                                    <img src="${icono}" alt="Icono" class="img-fluid mb-3" style="max-width: 50px;"/>
                                    <h5 class="card-title mb-4">${item.tipo || 'Tipo no disponible'}</h5> <!-- Manejo de casos donde tipo puede ser undefined -->
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

    document.querySelectorAll('#myTab a[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', (event) => {
            const tipo = tabs[event.target.id];
            cargarCards(tipo);
        });
    });

    // Escuchar el clic en el botón de cancelar
$(".btnCancelar").on('click', function () {
    // Al cerrar el modal actual, abrir el anterior
    $("#verSolicitudes").modal('show');
});
});