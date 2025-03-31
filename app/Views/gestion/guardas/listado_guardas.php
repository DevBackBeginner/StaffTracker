<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
<link rel="stylesheet" href="assest/css/registro_visitante.css">
<div class="pagetitle">
    <h1>Listado de Guardas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
            <li class="breadcrumb-item">Control de Personal</li>
            <li class="breadcrumb-item active">Listado Guardas</li>
        </ol>
    </nav>
</div>

<div class="container-fluid">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body p-4">
                        <form method="GET" action="" class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label fw-bold">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nombre" class="form-control" 
                                        placeholder="Buscar por nombre" 
                                        value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="documento" class="form-label fw-bold">Documento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="documento" class="form-control" 
                                        placeholder="Buscar por documento" 
                                        value="<?= htmlspecialchars($_GET['documento'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-2"></i> Buscar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Listado de Guardas</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Tipo Documento</th>
                                        <th>N° Documento</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($guardas)): ?>
                                        <?php foreach ($guardas as $guarda): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($guarda['id_persona']) ?></td>
                                            <td><?= htmlspecialchars($guarda['nombre']) ?></td>
                                            <td><?= htmlspecialchars($guarda['apellido']) ?></td>
                                            <td data-tipo-documento="<?= htmlspecialchars($guarda['tipo_documento']) ?>">
                                                <?= match($guarda['tipo_documento']) {
                                                    'CC' => 'C.C.',
                                                    'CE' => 'C.E.',
                                                    'TI' => 'T.I.',
                                                    'PASAPORTE' => 'Pasaporte',
                                                    'NIT' => 'NIT',
                                                    default => $guarda['tipo_documento']
                                                } ?>
                                            </td>
                                            <td><?= htmlspecialchars($guarda['numero_documento']) ?></td>
                                            <td><?= htmlspecialchars($guarda['telefono'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($guarda['correo'] ?? 'N/A') ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Botón Editar con Modal -->
                                                    <button type="button" 
                                                            class="btn btn-sm btn-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editarGuardaModal" 
                                                            data-id="<?= $guarda['id_persona'] ?>"
                                                            title="Editar guarda">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    
                                                    <!-- Botón Eliminar con Formulario POST -->
                                                    <form method="POST" action="EliminarGuarda" class="d-inline">
                                                        <input type="hidden" name="id" value="<?= $guarda['id_persona'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('¿Estás seguro de eliminar este guarda?');"
                                                                title="Eliminar guarda">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                No se encontraron guardas registrados
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <?php if ($totalPaginas > 1): ?>
                        <nav aria-label="Paginación">
                            <ul class="pagination justify-content-center">
                                <?php if ($pagina > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" 
                                    href="?nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&pagina=<?= $pagina-1 ?>">
                                        &laquo; Anterior
                                    </a>
                                </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                                    <a class="page-link" 
                                    href="?nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&pagina=<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                                <?php endfor; ?>

                                <?php if ($pagina < $totalPaginas): ?>
                                <li class="page-item">
                                    <a class="page-link" 
                                    href="?nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&pagina=<?= $pagina+1 ?>">
                                        Siguiente &raquo;
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'editar-guarda.php' ?>

<script src="assets/js/modal-editar-guardas.js"></script>

<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>