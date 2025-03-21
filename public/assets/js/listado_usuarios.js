document.addEventListener('DOMContentLoaded', function() {
    const rolSelect = document.getElementById('editarRol');
    const camposRol = document.querySelectorAll('.camposRol');

    // Función para mostrar los campos según el rol seleccionado
    function mostrarCamposPorRol() {
        camposRol.forEach(campo => campo.style.display = 'none'); // Oculta todos los campos
        const rolSeleccionado = rolSelect.value;
        document.getElementById(`campos${rolSeleccionado}`).style.display = 'block'; // Muestra los campos del rol seleccionado
    }

    // Evento para cambiar los campos cuando se selecciona un rol
    rolSelect.addEventListener('change', mostrarCamposPorRol);

    // Llenar el modal con los datos del usuario seleccionado
    const editarUsuarioModal = document.getElementById('editarUsuarioModal');
    editarUsuarioModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Botón que activó el modal
        const row = button.closest('tr'); // Fila del usuario

        // Obtener el ID del usuario desde el atributo data-id
        const id = button.getAttribute('data-id'); // Obtener el ID del usuario

        // Obtener datos de la fila
        const nombre = row.querySelector('td:nth-child(1)').innerText;
        const apellidos = row.querySelector('td:nth-child(2)').innerText;
        const documento = row.querySelector('td:nth-child(3)').innerText;
        const rol = row.querySelector('td:nth-child(4)').innerText;
        const telefono = row.querySelector('td:nth-child(5)').innerText;
        const informacionAdicional = row.querySelector('td:nth-child(6)').innerHTML; // Usamos innerHTML para capturar <br>

        // Llenar el modal con los datos comunes
        document.getElementById('editarId').value = id; // Asignar el ID al campo oculto
        document.getElementById('editarNombre').value = nombre;
        document.getElementById('editarApellidos').value = apellidos;
        document.getElementById('editarDocumento').value = documento;
        document.getElementById('editarRol').value = rol;
        document.getElementById('editarTelefono').value = telefono;

        // Llenar los labels y inputs según el rol
        switch (rol) {
            case 'Instructor':
                const [curso, ubicacion] = informacionAdicional.split('<br>');
                document.getElementById('labelCurso').innerText = curso.replace('Curso: ', '').trim();
                document.getElementById('labelUbicacion').innerText = ubicacion.replace('Ubicación: ', '').trim();
                document.getElementById('editarCurso').value = curso.replace('Curso: ', '').trim();
                document.getElementById('editarUbicacion').value = ubicacion.replace('Ubicación: ', '').trim();
                break;
            case 'Funcionario':
                const [area, puesto] = informacionAdicional.split('<br>');
                document.getElementById('labelArea').innerText = area.replace('Área: ', '').trim();
                document.getElementById('labelPuesto').innerText = puesto.replace('Puesto: ', '').trim();
                document.getElementById('editarArea').value = area.replace('Área: ', '').trim();
                document.getElementById('editarPuesto').value = puesto.replace('Puesto: ', '').trim();
                break;
            case 'Directivo':
                const [cargo, departamento] = informacionAdicional.split('<br>');
                document.getElementById('labelCargo').innerText = cargo.replace('Cargo: ', '').trim();
                document.getElementById('labelDepartamento').innerText = departamento.replace('Departamento: ', '').trim();
                document.getElementById('editarCargo').value = cargo.replace('Cargo: ', '').trim();
                document.getElementById('editarDepartamento').value = departamento.replace('Departamento: ', '').trim();
                break;
            case 'Apoyo':
                const areaTrabajo = informacionAdicional.replace('Área de Trabajo: ', '').trim();
                document.getElementById('labelAreaTrabajo').innerText = areaTrabajo;
                document.getElementById('editarAreaTrabajo').value = areaTrabajo;
                break;
            case 'Visitante':
                const asunto = informacionAdicional.replace('Asunto: ', '').trim();
                document.getElementById('labelAsunto').innerText = asunto;
                document.getElementById('editarAsunto').value = asunto;
                break;
        }

        // Mostrar campos específicos del rol
        mostrarCamposPorRol();
    });
});