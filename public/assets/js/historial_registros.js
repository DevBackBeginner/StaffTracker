function realizarBusqueda() {
    const documento = document.getElementById('documentoInput').value.trim(); // Valor del campo de documento
    const nombre = document.getElementById('nombreInput').value.trim(); // Valor del campo de nombre
    const rol = new URLSearchParams(window.location.search).get('rol'); // Obtener el rol de la URL

    // Construir los parámetros de la URL dinámicamente
    const params = new URLSearchParams();
    if (rol) params.append('rol', rol); // Agregar el rol si existe
    if (documento) params.append('documento', documento); // Agregar documento solo si no está vacío
    if (nombre) params.append('nombre', nombre); // Agregar nombre solo si no está vacío

    // Si ambos campos están vacíos, hacer una solicitud sin filtros
    if (documento === '' && nombre === '') {
        fetch(`filtro_usuarios?rol=${rol}`) // Solicitud sin filtros
            .then(response => response.text())
            .then(data => {
                // Actualizar la tabla con los resultados
                document.getElementById('resultados').innerHTML = data;

                // Eliminar la paginación si existe
                const paginacion = document.querySelector('nav[aria-label="Paginación"]');
                if (paginacion) {
                    paginacion.remove();
                }
            })
            .catch(error => console.error('Error:', error));
        return; // Salir de la función
    }

    // Realizar la petición AJAX con los parámetros
    fetch(`filtro_usuarios?${params.toString()}`)
        .then(response => response.text())
        .then(data => {
            // Actualizar la tabla con los resultados
            document.getElementById('resultados').innerHTML = data;

            // Eliminar la paginación si existe
            const paginacion = document.querySelector('nav[aria-label="Paginación"]');
            if (paginacion) {
                paginacion.remove();
            }
        })
        .catch(error => console.error('Error:', error));
}

// Agregar el listener para el campo de documento
document.getElementById('documentoInput').addEventListener('input', realizarBusqueda);

// Agregar el listener para el campo de nombre
document.getElementById('nombreInput').addEventListener('input', realizarBusqueda);