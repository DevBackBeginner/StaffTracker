<?php
// Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>
    <!-- Enlace al archivo CSS específico para el panel -->
    <link rel="stylesheet" href="assets/css/panel.css">

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Panel de Registros</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                    <li class="breadcrumb-item"><a href="panel">Panel de Registro</a></li>
                </ol>
            </nav>
        </div>

        <!-- Card: Buscar Funcionario -->
        <div class="container-fluid bg-light">
            <div class="d-flex align-items-stretch">
                <div class="card shadow-sm rounded-lg  w-100" style="border: 1px solid #005f2f;">
                    <div class="card-header text-white" style="background-color: #005f2f;">
                        <h2 class="h5 mb-0" style="color: white;">Buscar Usuario</h2>
                    </div>
                    <div class="card-body">
                        <!-- Búsqueda por documento -->
                        <div class="col-md-12">
                            <label for="documentoInput" class="form-label">Documento</label>
                            <input 
                                type="text" 
                                name="documento" 
                                placeholder="Buscar por documento" 
                                class="form-control" 
                                id="documentoInput"
                                value="<?= htmlspecialchars($documento ?? '') ?>"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenedor de resultados -->
            <div id="tabla-resultados" class="card shadow-sm rounded-lg mt-12" style="border: 1px solid #005f2f; ">
                <div id="tabla-body" class="card-body">
                    <!-- Sección de tabs o bullet points -->
                    <ul class="nav nav-tabs">
                        <?php 
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
                                <a class="nav-link <?= ($rol === $clave) ? 'active' : '' ?>" 
                                    href="?rol=<?= urlencode($clave) ?>">
                                    <?= $valor ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Tabla de resultados -->
                    <div id="resultados">
                        <?php include "tabla_funcionarios.php"; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="assets/js/panel_registros.js"></script>
    <?php
        // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
        include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
    ?>
