<?php 
// Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
include_once __DIR__ . '/../../views/layouts/header.php'; 
?>

<!-- Enlace al archivo CSS específico para el panel -->
<link rel="stylesheet" href="/ControlAssistance/public/assets/css/panel.css">

<!-- Card: Buscar Ficha -->
<div class="container-fluid mb-4 bg-light" style="padding-top: 160px;">
    <div class="d-flex align-items-stretch">
        <div class="card mb-4 shadow-sm rounded-lg" style="border: 1px solid #005f2f; width: 95%; margin: 0 auto;">
            <div class="card-header text-white" style="background-color: #005f2f;">
                <h2 class="h5 mb-0" style="color: white;">Buscar Funcionario</h2>
            </div>
            <div class="card-body" style="background-color: #f5f5f5;">
                <form id="filterForm" class="row g-3">
                    <!-- Selección de tipo -->
                    <div class="col-md-6">
                        <label for="tipoSelect" class="form-label">Tipo</label>
                        <select name="tipo" class="form-control" id="tipoSelect">
                            <option value="">-- Seleccione Tipo --</option>
                            <option value="Instructor">Instructor</option>
                            <option value="Directiva">Directiva</option>
                            <option value="Funcionario">Funcionario</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="documentoInput" class="form-label">Documento</label>
                        <input 
                            type="text" 
                            name="documento" 
                            placeholder="Buscar por documento" 
                            class="form-control" 
                            id="documentoInput"
                        >
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- Contenedor de resultados -->
    <div id="tabla-resultados" class="card shadow-sm rounded-lg mt-4" style="border: 1px solid #005f2f; max-width: 95%; margin: 0 auto;">
        <div id="tabla-body" class="card-body" style="background-color: #ffffff;">
            <!-- Sección de tabs o bullet points -->
            <ul class="nav nav-tabs">
                <?php $roles = ['Instructor', 'Funcionario', 'Directiva']; ?>
                <?php foreach ($roles as $r): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($rol === $r) ? 'active' : '' ?>" 
                        href="?rol=<?= urlencode($r) ?>">
                        <?= $r ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Debajo, la tabla con $usuarios -->
            <h2>Lista de Usuarios (Rol: <?= htmlspecialchars($rol) ?>)</h2>
            <table class="table table-bordered">
                <?php include "tabla_funcionarios.php"; ?>
            </table>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const filterForm = document.getElementById("filterForm");
  const tipoSelect = document.getElementById("tipoSelect");
  const documentoInput = document.getElementById("documentoInput");

  // Evento para escuchar cambios en el formulario
  filterForm.addEventListener("change", function() {
    let tipo = tipoSelect.value;
    let documento = documentoInput.value;

    // Llamada AJAX o fetch para enviar estos filtros
    fetch(`filtrar_funcionarios?tipo=${encodeURIComponent(tipo)}&documento=${encodeURIComponent(documento)}`)
      .then(response => response.text())
      .then(html => {
        // Reemplazar contenido de la tabla con los resultados
        document.getElementById("tabla-body").innerHTML = html;
      })
      .catch(error => console.error("Error al filtrar:", error));
  });
});
</script>
