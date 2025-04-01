<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>

<div class="pagetitle">
    <h1>Registrar Devolución de Equipos</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
            <li class="breadcrumb-item">Eventos</li>
            <li class="breadcrumb-item active">Registrar Devolución</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form method="POST" action="registrarDevolucion">
            <div class="mb-3">
                <label for="id_evento" class="form-label">ID del Evento <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="id_evento" name="id_evento" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Registrar Devolución</button>
        </form>

        <!-- Listado de eventos activos (opcional) -->
        <div class="mt-4">
            <h5>Eventos Activos</h5>
            <?php 
            $eventosActivos = $this->eventoModelo->obtenerEventosActivos();
            if (!empty($eventosActivos)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Evento</th>
                            <th>Persona</th>
                            <th>Propósito</th>
                            <th>Fecha Salida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($eventosActivos as $evento): ?>
                        <tr>
                            <td><?= $evento['id_evento'] ?></td>
                            <td><?= $evento['nombre_persona'] ?></td>
                            <td><?= $evento['proposito'] ?></td>
                            <td><?= $evento['fecha_salida'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No hay eventos activos en este momento.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>