// Función para cargar los datos del usuario en el modal
function cargarDatosUsuario(id, nombre, apellidos, documento, rol, telefono, infoAdicional) {
    // Asignar los valores comunes
    document.getElementById('usuarioId').value = id;
    document.getElementById('apellidos').value = apellidos; 
    document.getElementById('nombre').value = nombre;
    document.getElementById('documento').value = documento;
    document.getElementById('rol').value = rol;
    document.getElementById('telefono').value = telefono;

    // Asignar los valores adicionales
    switch (rol) {
        case 'Instructor':
            document.getElementById('curso').value = infoAdicional.curso || '';
            document.getElementById('ubicacion').value = infoAdicional.ubicacion || '';
            break;
        case 'Funcionario':
            document.getElementById('area').value = infoAdicional.area || '';
            document.getElementById('puesto').value = infoAdicional.puesto || '';
            break;
        case 'Directivo':
            document.getElementById('cargo').value = infoAdicional.cargo || '';
            document.getElementById('departamento').value = infoAdicional.departamento || '';
            break;
        case 'Apoyo':
            document.getElementById('area_trabajo').value = infoAdicional.area_trabajo || '';
            break;
        case 'Visitante':
            document.getElementById('asunto').value = infoAdicional.asunto || '';
            break;
    }

    // Actualizar los campos adicionales según el rol
    actualizarCamposAdicionales(rol);
}

// Función para mostrar u ocultar los campos adicionales
function actualizarCamposAdicionales(rol = null) {
    // Obtener el rol seleccionado (si no se pasa como parámetro)
    if (!rol) {
        rol = document.getElementById('rol').value;
    }

    // Ocultar todos los campos adicionales
    document.querySelectorAll('.campos-adicionales').forEach(function (campo) {
        campo.style.display = 'none';
    });

    // Mostrar los campos según el rol
    switch (rol) {
        case 'Instructor':
            document.getElementById('camposInstructor').style.display = 'block';
            break;
        case 'Funcionario':
            document.getElementById('camposFuncionario').style.display = 'block';
            break;
        case 'Directivo':
            document.getElementById('camposDirectivo').style.display = 'block';
            break;
        case 'Apoyo':
            document.getElementById('camposApoyo').style.display = 'block';
            break;
        case 'Visitante':
            document.getElementById('camposVisitante').style.display = 'block';
            break;
    }
}