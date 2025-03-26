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

<div class="container"> <!-- Contenedor agregado -->
    <div id="carouselFooter" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <!-- Carrusel para Admin -->
            <?php if ($_SESSION['usuario']['rol'] === 'Admin'): ?>
                <div class="carousel-item active">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-home"></i> Inicio</h3>
                            <p>En la sección Inicio, se muestra el panel de control, permitiendo a los usuarios visualizar información clave del sistema. Se pueden consultar los registros de los usuarios, funcionarios y visitantes.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-user-shield"></i> Registrar Guardas</h3>
                            <p>La sección Registrar Guardas permite la incorporación de nuevos guardas al sistema, ingresando sus datos personales y asignándoles acceso específico.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-users"></i> Gestión de Usuarios</h3>
                            <p>En la sección Gestión de Usuarios, se pueden registrar instructores no registrados, facilitando su integración. Ofrece opciones para consultar usuarios registrados.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-file-alt"></i> Reportes</h3>
                            <p>La sección Reportes permite obtener un seguimiento detallado de la actividad dentro del sistema, generando reportes diarios y mensuales permitiendo descargarlos en pdf y excel.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-chart-line"></i> Reportes Gráficos</h3>
                            <p>En la sección Reportes Gráficos, los usuarios visualizarán de forma interactiva los reportes generados y presentados gráficamente.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-user"></i> Perfil</h3>
                            <p>En la sección Perfil, los usuarios podrán acceder a la información detallada de su cuenta en el sistema. Aquí, podrán ver y gestionar sus datos personales. Además, tendrán la posibilidad de editar esta información en caso de que necesiten actualizarla. Esta sección también incluye una opción para cambiar la contraseña.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Carrusel para Guarda -->
            <?php if ($_SESSION['usuario']['rol'] === 'Guarda'): ?>
                <div class="carousel-item active">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-home"></i> Inicio</h3>
                            <p>En la sección Inicio, se muestra el panel de control, permitiendo a los usuarios visualizar información clave del sistema. Se pueden consultar los registros de los usuarios, funcionarios y visitantes.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-user-plus"></i> Registrar Visitantes</h3>
                            <p>En esta sección, los guardas podrán registrar visitantes, incluyendo su motivo de visita y datos personales para control y seguridad.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-id-badge"></i> Registro de Entrada</h3>
                            <p>En esta sección, los guardas podrán escanear los carnets de instructores, administrativos y directivos para registrar su hora de entrada. Si no tienen carnet, pueden usar el número de identificación.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-sign-out-alt"></i> Registro de Salida</h3>
                            <p>En esta sección, los guardas registrarán la hora de salida de los instrutores, administrativos y directivos de manera similar al registro de entrada, usando carnet o número de identificación.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-history"></i> Historial de Registros</h3>
                            <p>En esta sección, los guardas podrán acceder a un historial completo de registros de entrada y salida. También podrán filtrar por número de identificación o nombre para facilitar la búsqueda y ver las horas de entrada y salida de las personas registradas.</p>
                        </div>
                    </div>
                </div>

                                    <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-user"></i> Perfil</h3>
                            <p>En la sección Perfil, los usuarios podrán acceder a la información detallada de su cuenta en el sistema. Aquí, podrán ver y gestionar sus datos personales. Además, tendrán la posibilidad de editar esta información en caso de que necesiten actualizarla. Esta sección también incluye una opción para cambiar la contraseña.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselFooter" data-bs-slide="prev" aria-label="Previous">
            <span class="carousel-control-prev-icon bg-success" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselFooter" data-bs-slide="next" aria-label="Next">
            <span class="carousel-control-next-icon bg-success" aria-hidden="true"></span>
        </button>
    </div>
</div> <!-- Fin del contenedor -->

<?php 
    // Incluye el archivo de pie de página principal
    include_once __DIR__ . '/layouts/footer_main.php'; 
?>