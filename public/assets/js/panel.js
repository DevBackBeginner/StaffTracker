// Esperar a que todo el DOM se haya cargado
document.addEventListener('DOMContentLoaded', function() {
    // Obtener el contenedor donde se mostrarán las fichas
    const tablaBody = document.getElementById('tabla-body');

    /**
     * Función para cargar fichas mediante AJAX.
     * @param {number} pagina - Número de página a cargar (por defecto 1).
     * @param {boolean} actualizarHistorial - Determina si se debe actualizar el historial del navegador.
     */
    function cargarFichas(pagina = 1, actualizarHistorial = true) {
        // Construir la URL con el parámetro de página
        const url = `/ControlAssistance/public/panel?pagina=${pagina}`;

        // Si se requiere, actualizamos la URL en el historial del navegador sin recargar la página
        if (actualizarHistorial) {
            history.pushState({ pagina }, '', url);
        }

        // Realizar una petición AJAX usando fetch
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text()) // Convertir la respuesta en texto
            .then(html => {
                // Reemplazar el contenido del contenedor con el HTML obtenido
                tablaBody.innerHTML = html;
            })
            .catch(error => console.error('Error al cargar fichas:', error));
    }

    // Delegación de eventos en el contenedor de la tabla para manejar la paginación
    tablaBody.addEventListener('click', function(e) {
        // Verificar si el elemento clickeado es un enlace de paginación
        if (e.target.matches('.pagination .page-link')) {
            e.preventDefault(); // Evitar el comportamiento por defecto del enlace
            // Obtener el número de página desde el atributo 'data-page'
            const pagina = e.target.getAttribute('data-page');
            if (pagina) {
                // Cargar la página seleccionada
                cargarFichas(pagina);
            }
        }
    });

    // Escuchar el evento 'popstate' para manejar el botón "Atrás" del navegador
    window.addEventListener('popstate', function(event) {
        // Si el estado del evento contiene un número de página, cargar esa página sin actualizar el historial
        if (event.state && event.state.pagina) {
            cargarFichas(event.state.pagina, false);
        }
    });

    // Cargar inicialmente la primera página de fichas
    cargarFichas();
});


// Escuchar el evento 'input' en el formulario de búsqueda para realizar búsquedas en tiempo real
document.getElementById('filterForm').addEventListener('input', function(event) {
    event.preventDefault(); // Evitar que se recargue la página al modificar el formulario

    // Crear un objeto FormData que contiene los datos del formulario
    const formData = new FormData(this);

    // Realizar una solicitud AJAX usando fetch para filtrar aprendices
    fetch('filtrar_aprendices', {
        method: 'POST', // Usar el método POST para enviar los datos
        body: formData  // Enviar los datos del formulario
    })
    .then(response => response.text()) // Convertir la respuesta en texto
    .then(data => {
        // Actualizar el contenido del contenedor de resultados con los datos recibidos
        document.getElementById('tabla-body').innerHTML = data;
    })
    .catch(error => console.error('Error al filtrar aprendices:', error));
});


// Función para abrir un modal de Bootstrap, recibiendo el ID del modal a abrir
function abrirModal(modalId) {
    // Obtener el elemento modal por su ID
    var modalElement = document.getElementById(modalId);
    if (modalElement) {
        // Remover el atributo aria-hidden para mejorar la accesibilidad
        modalElement.removeAttribute('aria-hidden');

        // Crear una instancia del modal usando la clase Modal de Bootstrap y mostrarlo
        var modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();
    } else {
        // Mostrar error en la consola si no se encuentra el modal con el ID proporcionado
        console.error("No se encontró el modal con el ID: " + modalId);
    }
}

/**
 * Función para cerrar el modal activo.
 * Realiza varias tareas:
 *  - Busca y oculta el modal activo.
 *  - Remueve el backdrop (fondo oscuro) generado por Bootstrap.
 *  - Restaura el scroll en el body.
 *  - Dispara eventos para imitar el comportamiento estándar de Bootstrap.
 *  - Finalmente, recarga la página.
 */
function closeActiveModal() {
    // Buscar el modal que está activo (con la clase "show")
    const activeModal = document.querySelector('.modal.show');
    if (activeModal) {
        // Disparar un evento "beforeClose" para que otros scripts puedan reaccionar antes de cerrar
        activeModal.dispatchEvent(new Event('beforeClose'));

        // Remover todos los elementos de backdrop creados por Bootstrap
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.parentNode.removeChild(backdrop);
        });

        // Ocultar el modal removiendo la clase "show" y ajustando estilos
        activeModal.classList.remove('show');
        activeModal.style.display = 'none';
        activeModal.setAttribute('aria-hidden', 'true');

        // Restaurar el scroll del body, eliminando la clase que bloquea el scroll y reseteando el overflow
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';

        // Disparar un evento "hidden.bs.modal" para imitar el comportamiento de Bootstrap al ocultar el modal
        activeModal.dispatchEvent(new Event('hidden.bs.modal'));

        // Recargar la página después de cerrar el modal
        location.reload();
    } else {
        console.error('No hay un modal activo para cerrar.');
    }
}

// Escuchar el evento 'input' en el campo de "Código" para enviar el formulario automáticamente
document.getElementById('codigo').addEventListener('input', function() {
    // Si hay algún valor ingresado en el input
    if (this.value.length > 0) {
        // Enviar el formulario de escaneo
        document.getElementById('form-escaneo').submit();
    }
});

