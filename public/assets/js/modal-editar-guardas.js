document.addEventListener('DOMContentLoaded', function() {
    const editarGuardaModal = document.getElementById('editarGuardaModal');
    
    editarGuardaModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const row = button.closest('tr');
        const cells = row.cells;
        
        // Ajustamos los índices para saltar la primera celda (contador)
        document.getElementById('edit_guarda_id').value = button.getAttribute('data-id');
        document.getElementById('edit_guarda_nombre').value = cells[1].textContent; // Antes: 0, Ahora: 1
        document.getElementById('edit_guarda_apellido').value = cells[2].textContent; // Antes: 1, Ahora: 2
        
        // Obtener el valor real del tipo de documento del atributo data
        const tipoDocReal = cells[3].getAttribute('data-tipo-documento'); // Antes: 2, Ahora: 3
        document.getElementById('edit_guarda_tipo_doc').value = tipoDocReal;
        
        document.getElementById('edit_guarda_num_doc').value = cells[4].textContent; // Antes: 3, Ahora: 4
        document.getElementById('edit_guarda_telefono').value = cells[5].textContent === 'N/A' ? '' : cells[5].textContent; // Antes: 4, Ahora: 5
        document.getElementById('edit_guarda_correo').value = cells[6].textContent === 'N/A' ? '' : cells[6].textContent; // Antes: 5, Ahora: 6
    });
});