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
<div class="container footer-container"> <!-- Contenedor con espaciado extra -->
    <div id="carouselFooter" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <?php if ($_SESSION['usuario']['rol'] === 'Admin'): ?>
                <div class="carousel-item active">
                    <div class="carousel-content">
                        <h3><i class="fas fa-home"></i> Inicio</h3>
                        <p>Visualiza el panel de control con información clave del sistema, incluyendo registros de usuarios, funcionarios y visitantes.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-content">
                        <h3><i class="fas fa-user-shield"></i> Registrar Guardas</h3>
                        <p>Incorpora nuevos guardas al sistema ingresando sus datos personales y asignándoles acceso específico.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-content">
                        <h3><i class="fas fa-users"></i> Gestión de Usuarios</h3>
                        <p>Registra instructores y consulta información de usuarios registrados fácilmente.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-content">
                        <h3><i class="fas fa-users"></i> Reportes</h3>
                        <p>En este apartado se podran descargar los reportes generales, diarios y mensuales</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-content">
                        <h3><i class="fas fa-users"></i> Reportes Graficos</h3>
                        <p>En este apartartado se podra visualizar graficamente</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-content">
                        <h3><i class="fas fa-users"></i> Perfil</h3>
                        <p>En este apartado podras ver informacion de tu perfil.</p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($_SESSION['usuario']['rol'] === 'Guarda'): ?>
                <div class="carousel-item active">
                    <div class="carousel-content">
                        <h3><i class="fas fa-home"></i> Inicio</h3>
                        <p>Visualiza el panel de control con información clave del sistema, incluyendo registros de usuarios, funcionarios y visitantes.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-content">
                        <h3><i class="fas fa-user-plus"></i> Registrar Visitantes</h3>
                        <p>Registra visitantes con datos personales y motivo de visita para mayor control y seguridad.</p>
                    </div>
                </div>
                <div class="carousel-item">
    <div class="carousel-content">
        <h3><i class="fas fa-sign-in-alt"></i> Registro de Entrada</h3>
        <p>Registrara la entrada de instructores,administrativos mediante carnet o numero de documento.</p>
    </div>
</div>
<div class="carousel-item">
    <div class="carousel-content">
        <h3><i class="fas fa-sign-out-alt"></i> Registrar de Salida</h3>
        <p>Registrara la salida de instructores,administrativos mediante carnet o numero de documento.</p>
    </div>
</div>
<div class="carousel-item">
    <div class="carousel-content">
        <h3><i class="fas fa-history"></i> Historial de Registro</h3>
        <p>En este apartado se podra visualizar el historial de registro</p>
    </div>
</div>

                <div class="carousel-item">
                    <div class="carousel-content">
                        <h3><i class="fas fa-users"></i> Perfil</h3>
                        <p>En este apartado podras ver informacion de tu perfil.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Botones de navegación mejorados -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselFooter" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselFooter" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<style>
.footer-container {
    margin-top: 200px; /* Desplaza el contenido hacia abajo */
}

.carousel-content {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    position: relative; /* Necesario para los controles */
    padding-bottom: 40px; /* Añadido espacio para evitar superposición con los botones */
}

.carousel-content h3 {
    color: #198754;
    font-weight: bold;
    margin-bottom: 10px;
}

.carousel-content p {
    color: #6c757d;
    font-size: 16px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: #198754;
    border-radius: 50%;
    padding: 10px;
}

/* Ajuste de los botones para asegurarse que no se sobrepongan al contenido */
.carousel-control-prev,
.carousel-control-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10; /* Asegura que los botones estén encima del contenido */
}

/* Alineación de los botones */
.carousel-control-prev {
    left: 10px; /* Ajusta el margen izquierdo */
}

.carousel-control-next {
    right: 10px; /* Ajusta el margen derecho */
}

/* Responsividad: Ajuste de los botones en pantallas pequeñas */
@media (max-width: 768px) {
    .carousel-control-prev,
    .carousel-control-next {
        font-size: 1.5rem; /* Ajustar tamaño del texto */
        width: 40px; /* Ajustar tamaño de los botones */
        height: 40px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        padding: 8px; /* Ajustar el padding de los íconos */
    }
}
</style>



<?php 
    // Incluye el archivo de pie de página principal
    include_once __DIR__ . '/layouts/footer_main.php'; 
?>