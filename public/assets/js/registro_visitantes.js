function mostrarCamposComputador() {
    const tieneComputador = document.getElementById('tiene_computador').value;
    const camposComputador = document.getElementById('camposComputador');
    const checkboxes = camposComputador.querySelectorAll('input[type="checkbox"]');

    if (tieneComputador === '1') {
        camposComputador.classList.remove('d-none');
        // Agregar required solo a marca y código
        document.querySelector('input[name="marca"]').setAttribute('required', true);
        document.querySelector('input[name="codigo"]').setAttribute('required', true);
    } else {
        camposComputador.classList.add('d-none');
        // Remover required de marca y código
        document.querySelector('input[name="marca"]').removeAttribute('required');
        document.querySelector('input[name="codigo"]').removeAttribute('required');
        // Remover required de checkboxes (por si acaso)
        checkboxes.forEach(checkbox => checkbox.removeAttribute('required'));
    }
}

function validarFormulario() {
    const tieneComputador = document.getElementById('tiene_computador').value;
    const camposComputador = document.getElementById('camposComputador');

    // Validar solo si el usuario selecciona "Sí" en "Ingresar Computador?"
    if (tieneComputador === '1') {
        const marca = document.querySelector('input[name="marca"]').value;
        const codigo = document.querySelector('input[name="codigo"]').value;

        if (!marca || !codigo) {
            alert('Por favor, complete todos los campos del computador.');
            return false; // Evitar el envío del formulario
        }
    }

    // Obtener los valores de los checkboxes (opcional)
    const traeMouse = document.getElementById('mouse').checked;
    const traeTeclado = document.getElementById('teclado').checked;

    // Ejemplo: Mostrar un mensaje si el usuario trae mouse o teclado
    if (traeMouse) {
        console.log('El visitante trae mouse.');
    }
    if (traeTeclado) {
        console.log('El visitante trae teclado.');
    }

    return true; // Permitir el envío del formulario
}