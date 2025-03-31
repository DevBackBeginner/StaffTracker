<?php 
    // Incluye el archivo de cabecera principal
    include_once __DIR__ . '/layouts/header_main.php'; 

    // Obtiene los datos del dashboard desde el controlador
    $datosDashboard = $this->obtenerDatosDashboard();

    // Convierte las claves del array en variables para facilitar su uso
    extract($datosDashboard); 

?>

    <link href="assets/css/tablas.css" rel="stylesheet">

    <!-- ======= Sidebar ======= -->
    <div class="pagetitle">
        <h1>Panel de Control</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item active">Panel de Control</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12" name="div_footer">
                <div class="row">
                    <!-- diario Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card diario-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filtro</h6>
                                    </li>
                                    <li><a class="dropdown-item filter-link" href="#" data-filter="diarios">Diarios</a></li>
                                    <li><a class="dropdown-item filter-link" href="#" data-filter="semanales">Semanales</a></li>
                                    <li><a class="dropdown-item filter-link" href="#" data-filter="mensuales">Mensuales</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Registros <span id="filtro-activo-registros">| Diarios</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-check"></i> 
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="total-registros"><?php echo $registrosDiarios; ?></h6>
                                        <span id="porcentaje-aumento-registros" class="text-success small pt-1 fw-bold"><?php echo round($porcentajeAumentoDiario, 2); ?>%</span>
                                        <span id="texto-aumento-registros" class="text-muted small pt-2 ps-1">
                                            <?php echo ($porcentajeAumentoDiario >= 0) ? 'aumento' : 'disminución'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End diario Card -->

                    <!-- Tarjeta de Funcionarios -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card funcionarios-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filtro</h6>
                                    </li>
                                    <li><a class="dropdown-item filter-link" href="#" data-filter="funcionarios_diarios">Diarios</a></li>
                                    <li><a class="dropdown-item filter-link" href="#" data-filter="funcionarios_semanales">Semanales</a></li>
                                    <li><a class="dropdown-item filter-link" href="#" data-filter="funcionarios_mensuales">Mensuales</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Funcionarios <span id="filtro-activo-funcionarios">| Diarios</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-badge"></i> 
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="total-funcionarios"><?php echo $registroFuncionarioDiario; ?></h6>
                                        <span id="porcentaje-aumento-funcionarios" class="text-success small pt-1 fw-bold"><?php echo round($porcentajeAumentoFuncionarioDiario, 2); ?>%</span>
                                        <span id="texto-aumento-funcionarios" class="text-muted small pt-2 ps-1">
                                            <?php echo ($porcentajeAumentoFuncionarioDiario >= 0) ? 'aumento' : 'disminución'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End funcionarios Card -->

                    <!-- Tarjeta de Visitantes -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card visitantes-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filtro</h6>
                                    </li>
                                    <li><a class="dropdown-item filter-link" href="#" data-filter="visitantes_diarios">Diarios</a></li>
                                    <li><a class="dropdown-item filter-link" href="#" data-filter="visitantes_semanales">Semanales</a></li>
                                    <li><a class="dropdown-item filter-link" href="#" data-filter="visitantes_mensuales">Mensuales</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Visitantes <span id="filtro-activo-visitantes">| Diarios</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="total-visitantes"><?php echo $registroVistanteDiario; ?></h6>
                                        <span id="porcentaje-aumento-visitantes" class="text-success small pt-1 fw-bold"><?php echo round($porcentajeAumentoVistanteDiario, 2); ?>%</span>
                                        <span id="texto-aumento-visitantes" class="text-muted small pt-2 ps-1">
                                            <?php echo ($porcentajeAumentoVistanteDiario >= 0) ? 'aumento' : 'disminución'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End visitantes Card -->
                </div>
                    <!-- Tabla de registros Generales -->
                    <?php include_once __DIR__ . "/tabla_usuarios.php"; ?>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4" style="background-color: transparent;">
        <div class="container">
            <div id="whiteCardsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
                <div class="carousel-inner">
                    <?php if ($_SESSION['usuario']['rol'] === 'Administrador'): ?>
                        <!-- Slide 1 para Admin -->
                        <div class="carousel-item active">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-home text-white"></i>
                                            </div>
                                            <h4 class="card-title">Inicio</h4>
                                            <p class="card-text text-muted">Panel de control con registros de usuarios, funcionarios y visitantes.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-user-shield text-white"></i>
                                            </div>
                                            <h4 class="card-title">Guardas</h4>
                                            <p class="card-text text-muted">Registro y gestión de guardas de seguridad.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-users text-white"></i>
                                            </div>
                                            <h4 class="card-title">Usuarios</h4>
                                            <p class="card-text text-muted">Gestión completa de usuarios del sistema.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Slide 2 para Admin -->
                        <div class="carousel-item">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                            <h4 class="card-title">Reportes</h4>
                                            <p class="card-text text-muted">Generación de reportes en diferentes formatos.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-chart-bar text-white"></i>
                                            </div>
                                            <h4 class="card-title">Gráficos</h4>
                                            <p class="card-text text-muted">Visualización de datos estadísticos.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <h4 class="card-title">Perfil</h4>
                                            <p class="card-text text-muted">Gestión de tu cuenta de usuario.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php elseif ($_SESSION['usuario']['rol'] === 'Guarda'): ?>
                        <!-- Slide 1 para Guarda -->
                        <div class="carousel-item active">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-home text-white"></i>
                                            </div>
                                            <h4 class="card-title">Inicio</h4>
                                            <p class="card-text text-muted">Resumen de actividades y registros.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-user-plus text-white"></i>
                                            </div>
                                            <h4 class="card-title">Visitantes</h4>
                                            <p class="card-text text-muted">Registro de visitantes temporales.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-sign-in-alt text-white"></i>
                                            </div>
                                            <h4 class="card-title">Entradas</h4>
                                            <p class="card-text text-muted">Control de acceso al establecimiento.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Slide 2 para Guarda -->
                        <div class="carousel-item">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-sign-out-alt text-white"></i>
                                            </div>
                                            <h4 class="card-title">Salidas</h4>
                                            <p class="card-text text-muted">Registro de salidas del personal.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-history text-white"></i>
                                            </div>
                                            <h4 class="card-title">Historial</h4>
                                            <p class="card-text text-muted">Consulta de registros históricos.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm bg-white">
                                        <div class="card-body text-center">
                                            <div class="icon-circle bg-success mb-3" style="background-color: #007832 !important; margin-top: 15px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <h4 class="card-title">Perfil</h4>
                                            <p class="card-text text-muted">Gestión de tu cuenta de usuario.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Indicadores personalizados con color #00304D -->
                <div class="text-center mt-4">
                    <div class="carousel-indicators position-static mx-auto">
                        <button type="button" 
                                data-bs-target="#whiteCardsCarousel" 
                                data-bs-slide-to="0" 
                                class="active" 
                                style="background-color: #007832; width: 10px; height: 10px; border-radius: 50%; border: none; margin: 0 5px;"></button>
                        <button type="button" 
                                data-bs-target="#whiteCardsCarousel" 
                                data-bs-slide-to="1" 
                                style="background-color: #007832; width: 10px; height: 10px; border-radius: 50%; border: none; margin: 0 5px;"></button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</main>

<script src="assets/js/main_home.js"></script>


<?php 
    // Incluye el archivo de pie de página principal
    include_once __DIR__ . '/layouts/footer_main.php'; 
?>