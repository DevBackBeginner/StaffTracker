document.getElementById('documentoInput').addEventListener('input', function() {
    const documento = this.value;
    const rol = new URLSearchParams(window.location.search).get('rol');

    // Realizar la petición AJAX
    fetch(`filtro_usuarios?rol=${rol}&documento=${documento}`)
        .then(response => response.text())
        .then(data => {
            // Actualizar la tabla con los resultados
            document.getElementById('resultados').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
});