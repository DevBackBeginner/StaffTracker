document.addEventListener('DOMContentLoaded', function() {
    const botonesEditar = document.querySelectorAll('.editar-usuario');

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function() {
            // Obtener los datos del usuario desde los atributos data-*
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const apellidos = this.getAttribute('data-apellidos');
            const documento = this.getAttribute('data-documento');
            const telefono = this.getAttribute('data-telefono');
            const rol = this.getAttribute('data-rol');
            const curso = this.getAttribute('data-curso');
            const ubicacion = this.getAttribute('data-ubicacion');
            const area = this.getAttribute('data-area');
            const puesto = this.getAttribute('data-puesto');
            const cargo = this.getAttribute('data-cargo');
            const departamento = this.getAttribute('data-departamento');
            const areaTrabajo = this.getAttribute('data-area-trabajo');
            const asunto = this.getAttribute('data-asunto');

            // Asignar los valores a los campos del modal
            document.getElementById('usuarioId').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('apellidos').value = apellidos;
            document.getElementById('documento').value = documento;
            document.getElementById('telefono').value = telefono;
            document.getElementById('rol').value = rol;

            // Asignar valores a los campos adicionales según el rol
            if (rol === 'Instructor') {
                document.getElementById('curso').value = curso;
                document.getElementById('ubicacion').value = ubicacion;
            } else if (rol === 'Funcionario') {
                document.getElementById('area').value = area;
                document.getElementById('puesto').value = puesto;
            } else if (rol === 'Directivo') {
                document.getElementById('cargo').value = cargo;
                document.getElementById('departamento').value = departamento;
            } else if (rol === 'Apoyo') {
                document.getElementById('area_trabajo').value = areaTrabajo;
            } else if (rol === 'Visitante') {
                document.getElementById('asunto').value = asunto;
            }

            // Actualizar los campos adicionales visibles según el rol
            actualizarCamposAdicionales();
        });
    });
});

// Función para mostrar/ocultar campos adicionales según el rol seleccionado
function actualizarCamposAdicionales() {
    const rol = document.getElementById('rol').value;
    const camposAdicionales = document.querySelectorAll('.campos-adicionales');

    camposAdicionales.forEach(campo => campo.style.display = 'none');

    if (rol === 'Instructor') {
        document.querySelectorAll('#camposInstructor').forEach(campo => campo.style.display = 'block');
    } else if (rol === 'Funcionario') {
        document.querySelectorAll('#camposFuncionario').forEach(campo => campo.style.display = 'block');
    } else if (rol === 'Directivo') {
        document.querySelectorAll('#camposDirectivo').forEach(campo => campo.style.display = 'block');
    } else if (rol === 'Apoyo') {
        document.querySelectorAll('#camposApoyo').forEach(campo => campo.style.display = 'block');
    } else if (rol === 'Visitante') {
        document.querySelectorAll('#camposVisitante').forEach(campo => campo.style.display = 'block');
    }
}

function actualizarCamposAdicionales() {
    const rol = document.getElementById('rol').value;
    const camposAdicionales = document.querySelectorAll('.campos-adicionales');

    // Ocultar todos los campos adicionales
    camposAdicionales.forEach(campo => campo.style.display = 'none');

    // Mostrar los campos correspondientes al rol seleccionado
    if (rol === 'Instructor') {
        document.querySelectorAll('#camposInstructor').forEach(campo => campo.style.display = 'block');
    } else if (rol === 'Funcionario') {
        document.querySelectorAll('#camposFuncionario').forEach(campo => campo.style.display = 'block');
    } else if (rol === 'Directivo') {
        document.querySelectorAll('#camposDirectivo').forEach(campo => campo.style.display = 'block');
    } else if (rol === 'Apoyo') {
        document.querySelectorAll('#camposApoyo').forEach(campo => campo.style.display = 'block');
    } else if (rol === 'Visitante') {
        document.querySelectorAll('#camposVisitante').forEach(campo => campo.style.display = 'block');
    }
}