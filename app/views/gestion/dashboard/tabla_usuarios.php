<?php
// Inicialización segura de variables
$usuarios = $usuarios ?? [];
$rol = $rol ?? '';
$page = $page ?? 1;
$totalPaginas = $totalPaginas ?? 1;
?>

<div class="card border-0 shadow-sm">
    <!-- Encabezado estilo filtros -->
    <div class="card-header bg-success text-white py-3 px-3">
        <h6 class="mb-0"><i class="bi bi-table me-1"></i> REGISTRO GENERAL</h6>
    </div>

    <!-- Navegación por roles -->
    <div class="card-body p-0">
        <ul class="nav nav-tabs nav-justified">
            <?php
            $roles = [
                'Instructor' => 'Instructores',
                'Funcionario' => 'Funcionarios', 
                'Directivo' => 'Directivos',
                'Visitante' => 'Visitantes'
            ];
            
            foreach ($roles as $clave => $valor): 
                $isActive = $rol === $clave;
            ?>
                <li class="nav-item">
                    <a class="nav-link <?= $isActive ? 'active fw-bold text-white' : 'text-success' ?> py-2 px-2"
                       href="?<?= http_build_query(array_merge($_GET, ['rol' => $clave, 'page' => 1])) ?>">
                        <?= htmlspecialchars($valor) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Contenido de la tabla -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <?php 
            $tablaPath = __DIR__ . "/../partials/informacion_tabla.php";
            if (file_exists($tablaPath)) {
                include $tablaPath;
            } else {
                echo '<div class="alert alert-warning m-2 p-2 small">Datos no disponibles</div>';
            }
            ?>
        </div>
    </div>

    <!-- Paginación -->
    <?php if ($totalPaginas > 1): ?>
        <div class="card-footer bg-white py-2 px-3">
            <ul class="pagination pagination-sm justify-content-center mb-0">
                <?php
                $queryParams = array_diff_key($_GET, ['page' => '']);
                $queryParams['rol'] = $rol;
                
                // Botón Anterior
                $prevDisabled = $page <= 1 ? 'disabled' : '';
                ?>
                <li class="page-item <?= $prevDisabled ?>">
                    <a class="page-link text-success" 
                       href="?<?= http_build_query(array_merge($queryParams, ['page' => $page - 1])) ?>">
                        &laquo;
                    </a>
                </li>

                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link <?= $i === $page ? 'bg-success text-white' : 'text-success' ?>" 
                           href="?<?= http_build_query(array_merge($queryParams, ['page' => $i])) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php // Botón Siguiente
                $nextDisabled = $page >= $totalPaginas ? 'disabled' : '';
                ?>
                <li class="page-item <?= $nextDisabled ?>">
                    <a class="page-link text-success" 
                       href="?<?= http_build_query(array_merge($queryParams, ['page' => $page + 1])) ?>">
                        &raquo;
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>