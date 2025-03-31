  // Función para mostrar campos de Cargo y Contrato
function mostrarCamposAdicionales() {
    const rol = document.getElementById("rol").value;
    const camposComunes = document.getElementById("camposComunes");
    
    if (rol && rol !== "") { // Si se selecciona un rol válido
        camposComunes.classList.remove("d-none");
    } else {
        camposComunes.classList.add("d-none");
    }
}

// Función para campos de computador
function mostrarCamposComputador() {
    const tieneComputador = document.getElementById("tiene_computador").value;
    const camposComputador = document.getElementById("camposComputador");
    
    if (tieneComputador === "1") {
        camposComputador.classList.remove("d-none");
    } else {
        camposComputador.classList.add("d-none");
    }
}

// Inicialización al cargar la página
document.addEventListener("DOMContentLoaded", function() {
    // Configurar eventos
    document.getElementById("rol").addEventListener("change", mostrarCamposAdicionales);
    document.getElementById("tiene_computador").addEventListener("change", mostrarCamposComputador);
    
    // Ocultar campos inicialmente
    mostrarCamposAdicionales();
    mostrarCamposComputador();
});