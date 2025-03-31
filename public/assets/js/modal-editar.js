document.addEventListener('DOMContentLoaded', function() {
    const editarUsuarioModal = document.getElementById('editarUsuarioModal');
    
    editarUsuarioModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const row = button.closest('tr');
        const id = button.getAttribute('data-id');

        // Obtener datos de la fila
        const celdas = row.querySelectorAll('td');
        
        const nombre = celdas[0].innerText;
        const apellidos = celdas[1].innerText;
        const tipoDocumento = celdas[2].getAttribute('data-tipo-documento'); // Obtener del atributo data
        const documento = celdas[3].innerText;
        const telefono = celdas[4].innerText;
        const rol = celdas[5].innerText;
        const cargo = celdas[6].innerText === '---' ? '' : celdas[6].innerText;
        const tipoContrato = celdas[7].innerText === '---' ? '' : celdas[7].innerText;

        // Llenar el formulario del modal
        document.getElementById('editarId').value = id;
        document.getElementById('editarNombre').value = nombre;
        document.getElementById('editarApellidos').value = apellidos;
        
        // Establecer valores en los selects
        setSelectValue('editarTipoDocumento', tipoDocumento); // Usar el valor del atributo data
        setSelectValue('editarRol', rol);
        setSelectValue('editarTipoContrato', tipoContrato);
        
        document.getElementById('editarDocumento').value = documento;
        document.getElementById('editarTelefono').value = telefono;
        document.getElementById('editarCargo').value = cargo;
    });

    // Función auxiliar para establecer valores en selects
    function setSelectValue(selectId, value) {
        const select = document.getElementById(selectId);
        if (!select) return;
        
        // Si el valor está vacío, seleccionar la primera opción
        if (!value || value === '---') {
            select.selectedIndex = 0;
            return;
        }
        
        // Buscar la opción que coincida con el valor
        for (let option of select.options) {
            if (option.value === value) {
                option.selected = true;
                return;
            }
        } 
        
        // Si no se encontró coincidencia, seleccionar el primero
        select.selectedIndex = 0;
    }
});