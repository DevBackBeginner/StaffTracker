document.addEventListener('DOMContentLoaded', function() {
    const editarGuardaModal = document.getElementById('editarGuardaModal');
    
    editarGuardaModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const row = button.closest('tr');
        const cells = row.cells;
        
        // Llenar el formulario con los datos de la tabla
        document.getElementById('edit_guarda_id').value = button.getAttribute('data-id');
        document.getElementById('edit_guarda_nombre').value = cells[1].textContent;
        document.getElementById('edit_guarda_apellido').value = cells[2].textContent;
        
        // Obtener el valor real del tipo de documento del atributo data
        const tipoDocReal = cells[3].getAttribute('data-tipo-documento');
        document.getElementById('edit_guarda_tipo_doc').value = tipoDocReal;
        
        document.getElementById('edit_guarda_num_doc').value = cells[4].textContent;
        document.getElementById('edit_guarda_telefono').value = cells[5].textContent === 'N/A' ? '' : cells[5].textContent;
        document.getElementById('edit_guarda_correo').value = cells[6].textContent === 'N/A' ? '' : cells[6].textContent;
    });
});