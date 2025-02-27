// Escuchar el evento 'input' en el campo de "Código" para enviar el formulario automáticamente
document.getElementById('codigo').addEventListener('input', function() {
    // Si hay algún valor ingresado en el input
    if (this.value.length > 0) {
        // Enviar el formulario de escaneo
        document.getElementById('form-escaneo').submit();
    }
});

