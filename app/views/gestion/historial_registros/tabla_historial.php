<?php
// Inicialización segura de variables usando null coalescing operator
$usuarios = $usuarios ?? [];
$rol = $rol ?? '';
$page = $page ?? 1;
$totalPaginas = $totalPaginas ?? 1;
?>

<div id="tabla-body" class="card-body bg-white rounded shadow-sm">
    <!-- Navegación por roles mejorada -->
    <div class="mb-4">
        <ul class="nav nav-tabs nav-justified">
            <?php
            $roles = [
                'Instructor' => 'Instructores',
                'Funcionario' => 'Funcionarios',
                'Directivo' => 'Directivos',
                'Apoyo' => 'Apoyos',
                'Visitante' => 'Visitantes'
            ];
            
            foreach ($roles as $clave => $valor): 
                $isActive = $rol === $clave;
            ?>
                <li class="nav-item">
                    <a class="nav-link <?= $isActive ? 'active fw-semibold' : 'text-success' ?>"
                       href="?<?= http_build_query(array_merge($_GET, ['rol' => $clave, 'page' => 1])) ?>">
                       <?= htmlspecialchars($valor) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Contenido de la tabla responsive -->
    <div class="table-responsive mb-4">
        <?php 
        $tablaPath = __DIR__ . "/../partials/informacion_tabla.php";
        if (file_exists($tablaPath)) {
            include $tablaPath;
        } else {
            echo '<div class="alert alert-warning">La tabla no está disponible temporalmente</div>';
        }
        ?>
    </div>

    <!-- Paginación estilo profesional -->
    <?php if ($totalPaginas > 1 && !isset($_GET['documento']) && !isset($_GET['nombre'])): ?>
        <nav aria-label="Navegación de páginas">
            <ul class="pagination justify-content-center mb-0">
                <?php
                $queryParams = array_merge($_GET, ['rol' => $rol]);
                
                // Botón Anterior
                $prevClass = $page <= 1 ? 'disabled' : '';
                ?>
                <li class="page-item <?= $prevClass ?>">
                    <a class="page-link text-success" 
                       href="?<?= http_build_query(array_merge($queryParams, ['page' => $page - 1])) ?>" 
                       aria-label="Anterior">
                       <i class="bi bi-chevron-left"></i>
                    </a>
                </li>

                <?php // Números de página
                for ($i = 1; $i <= $totalPaginas; $i++): 
                    $activeClass = $i === $page ? 'active bg-success border-success' : '';
                ?>
                    <li class="page-item <?= $activeClass ?>">
                        <a class="page-link <?= $activeClass ? 'text-white' : 'text-success' ?>" 
                           href="?<?= http_build_query(array_merge($queryParams, ['page' => $i])) ?>">
                           <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php // Botón Siguiente
                $nextClass = $page >= $totalPaginas ? 'disabled' : '';
                ?>
                <li class="page-item <?= $nextClass ?>">
                    <a class="page-link text-success" 
                       href="?<?= http_build_query(array_merge($queryParams, ['page' => $page + 1])) ?>" 
                       aria-label="Siguiente">
                       <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

