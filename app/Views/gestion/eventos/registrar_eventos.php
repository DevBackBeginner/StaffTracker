<?php 
include_once __DIR__ . '/../dashboard/layouts/header_main.php';

$equiposDisponibles = $this->computadorModelo->obtenerComputadoresDisponibles();

?>

<link rel="stylesheet" href="/assets/css/eventos.css">

<div class="pagetitle">
    <h1>Registrar Salida de Equipos para Eventos</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
            <li class="breadcrumb-item">Eventos</li>
            <li class="breadcrumb-item active">Registrar Salida</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <!-- Mensajes de éxito/error -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form id="formEvento" action="RegistrarEvento" method="POST">
            <!-- Campo de documento -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="numero_documento" class="form-label fw-bold">Documento del responsable <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="numero_documento" 
                        name="numero_documento" 
                        placeholder="Ej: 1072745267" 
                        required
                    >
                    <div id="documento-feedback" class="invalid-feedback">Por favor ingrese un documento válido</div>
                </div>
                
                <div class="col-md-6">
                    <label for="proposito" class="form-label fw-bold">Propósito <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="proposito" 
                        name="proposito" 
                        placeholder="Ej: Taller de robótica externo" 
                        required
                    >
                </div>
            </div>

            <!-- Tabla de equipos -->
            <div class="mb-4">
                <label class="form-label fw-bold">Equipos disponibles <span class="text-danger">*</span></label>
                
                <?php if (!empty($equiposDisponibles)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50px">Seleccionar</th>
                                    <th>Modelo</th>
                                    <th>Código</th>
                                    <th>Teclado</th>
                                    <th>Mouse</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($equiposDisponibles as $equipo): ?>
                                <tr>
                                    <td>
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            value="<?= htmlspecialchars($equipo['id_computador_sena']) ?>"
                                            id="equipo_<?= $equipo['id_computador_sena'] ?>"
                                        >
                                    </td>
                                    <td>
                                        <label class="form-check-label" for="equipo_<?= $equipo['id_computador_sena'] ?>">
                                            <?= htmlspecialchars($equipo['modelo']) ?>
                                        </label>
                                    </td>
                                    <td><?= htmlspecialchars($equipo['codigo']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $equipo['teclado'] === 'Si' ? 'success' : 'secondary' ?>">
                                            <?= $equipo['teclado'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $equipo['mouse'] === 'Si' ? 'success' : 'secondary' ?>">
                                            <?= $equipo['mouse'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <small class="text-muted">Seleccione los equipos que necesita. Total disponibles: <?= count($equiposDisponibles) ?></small>
                    <input type="hidden" name="equipos" id="equiposSeleccionados">
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> No hay equipos disponibles actualmente.
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button 
                    type="submit" 
                    class="btn btn-primary px-4" 
                    id="btn-submit"
                    <?= empty($equiposDisponibles) ? 'disabled' : '' ?>
                >
                    <i class="bi bi-save me-2"></i> Registrar Salida
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script para manejar checkboxes -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.form-check-input');
    const hiddenInput = document.getElementById('equiposSeleccionados');
    
    function updateSelectedEquipos() {
        const selected = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);
        
        hiddenInput.value = JSON.stringify(selected);
        
        // Opcional: Resaltar fila seleccionada
        checkboxes.forEach(checkbox => {
            const row = checkbox.closest('tr');
            if (checkbox.checked) {
                row.classList.add('table-primary');
            } else {
                row.classList.remove('table-primary');
            }
        });
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedEquipos);
    });
});
</script>

<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>