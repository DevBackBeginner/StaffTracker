<?php
  // Verificar si el usuario está logueado y tiene el rol adecuado
  if (($_SESSION['usuario']['rol'] !== 'Administrador' && $_SESSION['usuario']['rol'] !== 'Guarda')) {
      header("Location: Inicio");
      exit();
  }

?>
<!DOCTYPE html>

    <head>
      <meta charset="utf-8"
      >
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap" rel="stylesheet">
      <meta name="google" content="notranslate">
      <title>StaffTracker</title>
      <meta content="" name="description">
      <meta content="" name="keywords">

      <!-- Favicons -->
      <link href="assets/img/logo.png" rel="icon">
      <link href="assets/img/logo.png" rel="apple-touch-icon">

      <!-- Framework base -->
      <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

      <!-- Iconos -->
      <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
      <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
      <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

      <!-- Librerías de terceros -->
      <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
      <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
      <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
      
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <!-- Estilos personalizados -->
      <link href="assets/css/header_main.css" rel="stylesheet">

      </head>
    <body>

    <!-- ======= Header ======= -->
      <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
          <a href="Inicio" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">StaffTracker</span>
          </a>
          <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
          <ul class="d-flex align-items-center">
            <li class="nav-item d-block d-lg-none">
              <a class="nav-link nav-icon search-bar-toggle " href="#">
                <i class="bi bi-search"></i>
              </a>
            </li><!-- End Search Icon-->
            <li class="nav-item dropdown pe-3">
              <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="<?= htmlspecialchars($_SESSION['usuario']['foto_perfil']); ?>" alt="Foto de perfil" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2">
                    <?= htmlspecialchars($_SESSION['usuario']['rol']); ?>
                </span>
              </a>

              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                  <li class="dropdown-header">
                      <h6> <?= htmlspecialchars($_SESSION['usuario']['nombre']); ?></h6>
                      <span>
                          <?php 
                              echo ($_SESSION['usuario']['rol'] === 'Administrador') ? 'Administrador' : htmlspecialchars($_SESSION['usuario']['rol']); 
                          ?>
                      </span>
                  </li>
                  <li><hr class="dropdown-divider"></li>

                  <li>
                      <a class="dropdown-item d-flex align-items-center" href="perfil">
                          <i class="bi bi-person"></i>
                          <span>Perfil</span>
                      </a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                      <a class="dropdown-item d-flex align-items-center" href="logout">
                          <i class="bi bi-box-arrow-right"></i>
                          <span>Cerrar Sesión </span>
                      </a>
                  </li>
              </ul>
          </li>

          </ul>
        </nav><!-- End Icons Navigation -->

      </header><!-- End Header -->
      <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
          <!-- Dashboard -->
          <li class="nav-item">
            <a class="nav-link" href="Inicio">
              <i class="bi bi-grid"></i>
              <span>Inicio</span>
            </a>
          </li><!-- End Dashboard Nav -->
          <?php if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === 'Guarda'): ?>
            <!-- Registrar Visitantes -->
            <li class="nav-heading">Administración</li>
            <li class="nav-item">
              <a class="nav-link collapsed" href="formulario_registro_visitante">
                <i class="bi bi-person-plus"></i>
                <span>Registrar Visitantes</span>
              </a>
            </li><!-- End Registrar Visitantes Nav -->

            <!-- Entrada -->
            <li class="nav-item">
              <a class="nav-link collapsed" href="registro_ingreso">
                <i class="bi bi-door-open"></i>
                <span>Registro de Entrada</span>
              </a>
            </li>

            <!-- Salida -->
            <li class="nav-item">
              <a class="nav-link collapsed" href="registro_salida">
                <i class="bi bi-door-closed"></i>
                <span>Registro de Salida</span>
              </a>
            </li>

            <!-- Consultar Registros -->
            <li class="nav-item">
              <a class="nav-link collapsed" href="historial_registros">
                <i class="bi bi-list-check"></i>
                <span>Historial de registros</span>
              </a>
            </li><!-- End Consultar Registros Nav -->
          <?php endif; ?>

          <!-- Opciones exclusivas para Administradores -->
          <?php if ($_SESSION['usuario']['rol'] === 'Administrador'): ?>
            <li class="nav-heading">Administración</li>
            <!-- 1. Gestión de Personal (existente) -->
            <li class="nav-item">
              <a class="nav-link collapsed" data-bs-toggle="collapse" href="#gestionPersonal" role="button">
                  <i class="bi bi-people"></i>
                  <span>Gestión de Personal</span>
                  <i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="gestionPersonal" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                  <!-- Items existentes -->
                  <li>
                      <a href="formulario_registro_personal">
                          <i class="bi bi-person-plus"></i>
                          <span>Registrar Personal</span>
                      </a>
                  </li>
                  <li>
                      <a href="registrar_guardas">
                          <i class="bi bi-shield-lock"></i>
                          <span>Registrar Guardas</span>
                      </a>
                  </li>
                  <li>
                      <a href="listado_personal">
                          <i class="bi bi-list-ul"></i>
                          <span>Listado de Personal</span>
                      </a>
                  </li>
                  
                  <!-- Nuevo item para listado de guardas (basado en tu estructura) -->
                  <li>
                      <a href="listado_guardas">
                          <i class="bi bi-shield-check"></i>
                          <span>Listado de Guardas</span>
                      </a>
                  </li>
              </ul>
            </li>

            <!-- 2. Control de Visitantes (nuevo pero basado en tu tabla visitantes) -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#controlVisitantes" role="button">
                    <i class="bi bi-person-badge"></i>
                    <span>Control de Visitantes</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="controlVisitantes" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <!-- Basado en tu tabla visitantes -->
                    <li>
                        <a href="formulario_registro_visitante">
                            <i class="bi bi-person-plus"></i>
                            <span>Registrar Visitante</span>
                        </a>
                    </li>
                    <li>
                        <a href="listado_visitantes">
                            <i class="bi bi-card-list"></i>
                            <span>Listado de Visitantes</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 3. Reportes (existente) -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#gestionReportes" role="button">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Reportes</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="gestionReportes" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <!-- Items existentes -->
                    <li>
                        <a href="ReporteDiario">
                            <i class="bi bi-calendar-day"></i>
                            <span>Reporte Diario</span>
                        </a>
                    </li>
                    <li>
                        <a href="ReporteMensual">
                            <i class="bi bi-calendar-month"></i>
                            <span>Reporte Mensual</span>
                        </a>
                    </li>
                    <li>
                        <a href="ReporteGeneral">
                            <i class="bi bi-graph-up"></i>
                            <span>Reporte General</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- 4. Reportes Gráficos (existente) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="reporte_graficos">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Visualizaciones</span>
                </a>
            </li>
          <?php endif; ?>
          <!-- Opciones Generales -->
          <li class="nav-heading">Ajustes</li>
            <li class="nav-item">
              <a class="nav-link collapsed" href="perfil">
                <i class="bi bi-person"></i>
                <span>Perfil</span>
              </a>
            </li><!-- End Perfil Nav -->
            <!-- Cerrar Sesión -->
            <li class="nav-item">
              <a class="nav-link collapsed" href="logout">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Cerrar Sesión</span>
              </a>
            </li><!-- End Cerrar Sección Nav -->
          </li>
        </ul>
      </aside>
      <main id="main" class="main">
