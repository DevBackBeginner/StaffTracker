function mostrarCamposComputador() {
    const tieneComputador = document.getElementById('tiene_computador').value;
    const camposComputador = document.getElementById('camposComputador');

    if (tieneComputador === '1') {
        camposComputador.classList.remove('d-none'); // Mostrar campos de computador
        camposComputador.querySelectorAll('input').forEach(input => input.setAttribute('required', 'true')); // Agregar required
    } else {
        camposComputador.classList.add('d-none'); // Ocultar campos de computador
        camposComputador.querySelectorAll('input').forEach(input => input.removeAttribute('required')); // Eliminar required
    }
}

// Función para validar el formulario antes de enviarlo
function validarFormulario() {
    const tieneComputador = document.getElementById('tiene_computador').value;
    const camposComputador = document.getElementById('camposComputador');

    if (tieneComputador === '1') {
        const marca = document.querySelector('input[name="marca"]').value;
        const codigo = document.querySelector('input[name="codigo"]').value;

        if (!marca || !codigo) {
            alert('Por favor, complete todos los campos del computador.');
            return false; // Evitar el envío del formulario
        }
    }
    return true; // Permitir el envío del formulario
}