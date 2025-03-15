
<?php
// Verificar si las variables están definidas
if (!isset($usuarios)) {
    $usuarios = []; // Inicializar como un arreglo vacío si no está definido
}
if (!isset($rol)) {
    $rol = ''; // Inicializar como una cadena vacía si no está definido
}
if (!isset($page)) {
    $page = 1; // Inicializar como 1 si no está definido
}
if (!isset($totalPaginas)) {
    $totalPaginas = 1; // Inicializar como 1 si no está definido
}
?>

<div id="tabla-body" class="card-body bg-white rounded shadow-sm p-3 mt-2">
    <!-- Sección de tabs o bullet points -->
    <ul class="nav nav-tabs mb-4">
        <?php
        // Definir los roles disponibles y sus etiquetas
        $roles = [
            'Instructor' => 'Instructores',
            'Funcionario' => 'Funcionarios',
            'Directivo' => 'Directivos',
            'Apoyo' => 'Apoyos',
            'Visitante' => 'Visitantes'
        ];
        ?>
        <?php foreach ($roles as $clave => $valor): ?>
            <li class="nav-item">
                <!-- Enlace para cada rol, activo si coincide con el rol actual -->
                <a class="nav-link <?= ($rol === $clave) ? 'active' : '' ?>" 
                    href="?rol=<?= urlencode($clave) ?>">
                    <?= $valor ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Tabla de resultados -->
    <?php include_once "informacion_tabla.php"?>

    <!-- Controles de paginación -->
    <?php
    // Verificar si hay un filtro activo
    $filtroActivo = isset($_GET['documento']) || isset($_GET['nombre']);
    if ($totalPaginas > 1 && !$filtroActivo): ?>
        <nav aria-label="Paginación">
            <ul class="pagination justify-content-center">
                <!-- Botón "Anterior" -->
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?rol=<?= urlencode($rol) ?>&page=<?= $page - 1 ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">&laquo;</span>
                    </li>
                <?php endif; ?>

                <!-- Números de página -->
                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?rol=<?= urlencode($rol) ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Botón "Siguiente" -->
                <?php if ($page < $totalPaginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?rol=<?= urlencode($rol) ?>&page=<?= $page + 1 ?>" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">&raquo;</span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
    
</div>
