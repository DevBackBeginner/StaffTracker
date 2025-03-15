function realizarBusqueda() {
    const documento = document.getElementById('documentoInput').value; // Valor del campo de documento
    const nombre = document.getElementById('nombreInput').value; // Valor del campo de nombre
    const rol = new URLSearchParams(window.location.search).get('rol');

    // Validar que al menos uno de los campos (documento o nombre) tenga un valor
    if (documento.trim() === '' && nombre.trim() === '') {
        // Si ambos campos están vacíos, no hacer la solicitud
        return;
    }

    // Realizar la petición AJAX
    fetch(`filtro_usuarios?rol=${rol}&documento=${documento}&nombre=${nombre}`)
        .then(response => response.text())
        .then(data => {
            // Actualizar la tabla con los resultados
            document.getElementById('resultados').innerHTML = data;

            // Eliminar la paginación si existe
            const paginacion = document.querySelector('nav[aria-label="Paginación"]'); // Selecciona el nav de paginación
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