document.getElementById('imagen').addEventListener('change', function(event) {
    const archivo = event.target.files[0]; // Obtener el archivo seleccionado
    if (archivo) {
        console.log("Archivo seleccionado:", archivo.name); // Verificar en la consola
        subirImagen(archivo);
    }
    });
        
    // Función para subir la imagen
    function subirImagen(archivo) {
        console.log("Subiendo imagen:", archivo.name); // Verificar en la consola
        const formData = new FormData();
        formData.append('imagen', archivo);

         // Enviar la imagen al servidor
        fetch('subir-imagen', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // No esperamos una respuesta JSON, solo redirección
            // El backend redirigirá a la página de perfil
            window.location.href = 'perfil'; // Redirigir manualmente si es necesario
        })
        .catch(error => {
            console.error('Error:', error);
            // Recargar la página incluso si hay un error
        });
    }
// Función para eliminar la imagen
function eliminarImagen() {
    if (confirm('¿Estás seguro de que deseas eliminar la imagen de perfil?')) {
        fetch('eliminar-imagen', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Recargar la página para mostrar el mensaje de éxito
                window.location.reload();
            } else {
                // Recargar la página para mostrar el mensaje de error
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.querySelector(`[onclick="togglePassword('${inputId}')"] i`);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}