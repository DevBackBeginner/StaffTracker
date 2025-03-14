document.getElementById('documentoInput').addEventListener('input', function() {
    const documento = this.value; // Valor del campo de documento
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
        })
        .catch(error => console.error('Error:', error));
});

// Agregar el mismo listener para el campo de nombre
document.getElementById('nombreInput').addEventListener('input', function() {
    const nombre = this.value; // Valor del campo de nombre
    const documento = document.getElementById('documentoInput').value; // Valor del campo de documento
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
        })
        .catch(error => console.error('Error:', error));
});