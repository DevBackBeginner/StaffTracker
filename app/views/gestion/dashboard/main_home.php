<?php 
    // Incluye el archivo de cabecera principal
    include_once __DIR__ . '/layouts/header_main.php'; 

    // Obtiene los datos del dashboard desde el controlador
    $datosDashboard = $this->obtenerDatosDashboard();

    // Convierte las claves del array en variables para facilitar su uso
    extract($datosDashboard); 
?>

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
                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
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
                </div><!-- End Sales Card -->

                <!-- Tarjeta de Funcionarios -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card revenue-card">
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
                </div><!-- End Revenue Card -->

                <!-- Tarjeta de Visitantes -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card customers-card">
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
                </div><!-- End Customers Card -->
            </div>

            <!-- Incluye la tabla de usuarios -->
            <?php include_once __DIR__ . "/../partials/tabla_usuarios.php"; ?>
        </div>
    </div>
</section>

<!-- Incluye el archivo JavaScript principal -->
<script src="assets/js/main_home.js"></script>

<?php 
    // Incluye el archivo de pie de página principal
    include_once __DIR__ . '/layouts/footer_main.php'; 
?>