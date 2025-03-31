<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
    <link rel="stylesheet" href="assest/css/registro_visitante.css">
    <div class="pagetitle">
        <h1>Listado de Visitantes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item">Control de Visitantes</li>
                <li class="breadcrumb-item"><a href="panel">Listado Visitantes</a></li>
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
                            <h5 class="mb-0">Listado de Visitantes</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Tipo Documento</th>
                                            <th>N° Documento</th>
                                            <th>Teléfono</th>
                                            <th>Asunto Visita</th>
                                            <th>Fecha Visita</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($visitantes as $visitante): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($visitante['nombre']) ?></td>
                                            <td><?= htmlspecialchars($visitante['apellido']) ?></td>
                                            <td><?= match($visitante['tipo_documento']) {
                                                'CC' => 'C.C.',
                                                'CE' => 'C.E.',
                                                'TI' => 'T.I.',
                                                default => $visitante['tipo_documento']
                                            } ?></td>
                                            <td><?= htmlspecialchars($visitante['numero_documento']) ?></td>
                                            <td><?= htmlspecialchars($visitante['telefono']) ?></td>
                                            <td><?= htmlspecialchars($visitante['asunto_visita']) ?></td>
                                            <td><?= date('d/m/Y', strtotime($visitante['fecha_visita'])) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
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


<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>