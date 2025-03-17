 // Función para mostrar/ocultar campos adicionales según el rol seleccionado
 function mostrarCamposAdicionales() {
    const rol = document.getElementById('rol').value;
    document.querySelectorAll('.campos-adicionales').forEach(div => div.classList.add('d-none')); // Ocultar todos los campos adicionales

    if (rol === 'Funcionario') {
        document.getElementById('camposFuncionario').classList.remove('d-none');
    } else if (rol === 'Instructor') {
        document.getElementById('camposInstructor').classList.remove('d-none');
    } else if (rol === 'Directiva') {
        document.getElementById('camposDirectiva').classList.remove('d-none');
    } else if (rol === 'Apoyo') {
        document.getElementById('camposApoyo').classList.remove('d-none');
    }
}

// Función para mostrar/ocultar campos de computador
function mostrarCamposComputador() {
    const tieneComputador = document.getElementById('tiene_computador').value;
    const camposComputador = document.getElementById('camposComputador');

    if (tieneComputador === '1') {
        camposComputador.classList.remove('d-none'); // Mostrar campos de computador
    } else {
        camposComputador.classList.add('d-none'); // Ocultar campos de computador
    }
}

// Función para validar el formulario antes de enviarlo
function validarFormulario() {
    const tieneComputador = document.getElementById('tiene_computador').value;
    const camposComputador = document.getElementById('camposComputador');

    if (tieneComputador === '1') {
        const tipoComputador = document.getElementById('tipo_computador').value;
        const marca = document.querySelector('input[name="marca"]').value;
        const codigo = document.querySelector('input[name="codigo"]').value;

        if (!tipoComputador || !marca || !codigo) {
            alert('Por favor, complete todos los campos del computador.');
            return false; // Evitar el envío del formulario
        }
    }
    return true; // Permitir el envío del formulario
}