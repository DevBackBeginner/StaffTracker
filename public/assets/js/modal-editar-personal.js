document.addEventListener('DOMContentLoaded', function() {
    const editarUsuarioModal = document.getElementById('editarUsuarioModal');
    
    editarUsuarioModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const row = button.closest('tr');
        const id = button.getAttribute('data-id');

        // Obtener datos de la fila (ignorando la primera celda que es el contador)
        const celdas = row.querySelectorAll('td');
        
        // Ajustar los índices restando 1 para saltar el contador
        const nombre = celdas[1].innerText;          // Antes: 0, Ahora: 1
        const apellidos = celdas[2].innerText;        // Antes: 1, Ahora: 2
        const tipoDocumento = celdas[3].getAttribute('data-tipo-documento'); // Antes: 2, Ahora: 3
        const documento = celdas[4].innerText;        // Antes: 3, Ahora: 4
        const telefono = celdas[5].innerText;         // Antes: 4, Ahora: 5
        const rol = celdas[6].innerText;              // Antes: 5, Ahora: 6
        const cargo = celdas[7].innerText === '---' ? '' : celdas[7].innerText; // Antes: 6, Ahora: 7
        const tipoContrato = celdas[8].innerText === '---' ? '' : celdas[8].innerText; // Antes: 7, Ahora: 8

        // Llenar el formulario del modal
        document.getElementById('editarId').value = id;
        document.getElementById('editarNombre').value = nombre;
        document.getElementById('editarApellidos').value = apellidos;
        
        // Establecer valores en los selects
        setSelectValue('editarTipoDocumento', tipoDocumento);
        setSelectValue('editarRol', rol);
        setSelectValue('editarTipoContrato', tipoContrato);
        
        document.getElementById('editarDocumento').value = documento;
        document.getElementById('editarTelefono').value = telefono;
        document.getElementById('editarCargo').value = cargo;
    });

    // Función auxiliar para establecer valores en selects (se mantiene igual)
    function setSelectValue(selectId, value) {
        const select = document.getElementById(selectId);
        if (!select) return;
        
        if (!value || value === '---') {
            select.selectedIndex = 0;
            return;
        }
        
        for (let option of select.options) {
            if (option.value === value) {
                option.selected = true;
                return;
            }
        } 
        
        select.selectedIndex = 0;
    }
});