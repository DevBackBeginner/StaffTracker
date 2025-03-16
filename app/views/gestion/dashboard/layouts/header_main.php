<?php
  // Verificar si el usuario está logueado y tiene el rol adecuado
  if (($_SESSION['usuario']['rol'] !== 'Admin' && $_SESSION['usuario']['rol'] !== 'Guarda')) {
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

            <li class="nav-item dropdown">

              <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <span class="badge bg-primary badge-number">4</span>
              </a><!-- End Notification Icon -->

              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                <li class="dropdown-header">
                  You have 4 new notifications
                  <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>

                <li class="notification-item">
                  <i class="bi bi-exclamation-circle text-warning"></i>
                  <div>
                    <h4>Lorem Ipsum</h4>
                    <p>Quae dolorem earum veritatis oditseno</p>
                    <p>30 min. ago</p>
                  </div>
                </li>

                <li>
                  <hr class="dropdown-divider">
                </li>

                <li class="notification-item">
                  <i class="bi bi-x-circle text-danger"></i>
                  <div>
                    <h4>Atque rerum nesciunt</h4>
                    <p>Quae dolorem earum veritatis oditseno</p>
                    <p>1 hr. ago</p>
                  </div>
                </li>

                <li>
                  <hr class="dropdown-divider">
                </li>

                <li class="notification-item">
                  <i class="bi bi-check-circle text-success"></i>
                  <div>
                    <h4>Sit rerum fuga</h4>
                    <p>Quae dolorem earum veritatis oditseno</p>
                    <p>2 hrs. ago</p>
                  </div>
                </li>

                <li>
                  <hr class="dropdown-divider">
                </li>

                <li class="notification-item">
                  <i class="bi bi-info-circle text-primary"></i>
                  <div>
                    <h4>Dicta reprehenderit</h4>
                    <p>Quae dolorem earum veritatis oditseno</p>
                    <p>4 hrs. ago</p>
                  </div>
                </li>

                <li>
                  <hr class="dropdown-divider">
                </li>
                <li class="dropdown-footer">
                  <a href="#">Show all notifications</a>
                </li>

              </ul><!-- End Notification Dropdown Items -->

            </li><!-- End Notification Nav -->

            <li class="nav-item dropdown">

              <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-chat-left-text"></i>
                <span class="badge bg-success badge-number">3</span>
              </a><!-- End Messages Icon -->

              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                <li class="dropdown-header">
                  You have 3 new messages
                  <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>

                <li class="message-item">
                  <a href="#">
                    <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                    <div>
                      <h4>Maria Hudson</h4>
                      <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                      <p>4 hrs. ago</p>
                    </div>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>

                <li class="message-item">
                  <a href="#">
                    <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                    <div>
                      <h4>Anna Nelson</h4>
                      <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                      <p>6 hrs. ago</p>
                    </div>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>

                <li class="message-item">
                  <a href="#">
                    <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                    <div>
                      <h4>David Muldon</h4>
                      <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                      <p>8 hrs. ago</p>
                    </div>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>

                <li class="dropdown-footer">
                  <a href="#">Show all messages</a>
                </li>

              </ul><!-- End Messages Dropdown Items -->

            </li><!-- End Messages Nav -->

            <li class="nav-item dropdown pe-3">
              <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="<?= htmlspecialchars($_SESSION['usuario']['foto_perfil']); ?>" alt="Foto de perfil" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2">
                    <?= htmlspecialchars($_SESSION['usuario']['nombre']); ?>
                </span>
              </a>

              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                  <li class="dropdown-header">
                      <h6> <?= htmlspecialchars($_SESSION['usuario']['nombre']); ?></h6>
                      <span>
                          <?php 
                              echo ($_SESSION['usuario']['rol'] === 'admin') ? 'Administrador' : htmlspecialchars($_SESSION['usuario']['rol']); 
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
                      <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                          <i class="bi bi-gear"></i>
                          <span>Configuraciones</span>
                      </a>
                  </li>
                  <li><hr class="dropdown-divider"></li>

                  <li>
                      <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                          <i class="bi bi-question-circle"></i>
                          <span>Soporte</span>
                      </a>
                  </li>
                  <li><hr class="dropdown-divider"></li>

                  <li>
                      <a class="dropdown-item d-flex align-items-center" href="logout">
                          <i class="bi bi-box-arrow-right"></i>
                          <span>Cerrar Session</span>
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

          <!-- Registrar Visitantes -->
          <li class="nav-item">
            <a class="nav-link collapsed" href="formulario_registro_visitante">
              <i class="bi bi-person-plus"></i>
              <span>Registrar Visitantes</span>
            </a>
          </li><!-- End Registrar Visitantes Nav -->

          <!-- Entrada/Salida -->
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#entradaSalida" role="button" aria-expanded="false" aria-controls="entradaSalida">
              <i class="bi bi-door-open"></i>
              <span>Entrada/Salida</span>
              <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="entradaSalida" class="nav-content collapse" data-bs-parent="#sidebar-nav">
              <li>
                <a href="registro_ingreso">
                  <i class="bi bi-people"></i>
                  <span>Personal</span>
                </a>
              </li>
              <li>
                <a href="Acceso_visitante">
                  <i class="bi bi-person"></i>
                  <span>Visitantes</span>
                </a>
              </li>
            </ul>
          </li><!-- End Entrada/Salida Nav -->

          <!-- Consultar Registros -->
          <li class="nav-item">
            <a class="nav-link collapsed" href="panel_ingreso">
              <i class="bi bi-list-check"></i>
              <span>Historial de registros</span>
            </a>
          </li><!-- End Consultar Registros Nav -->

          <!-- Opciones exclusivas para Administradores -->
          <?php if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === 'Admin'): ?>
            <li class="nav-heading">Administración</li>
            <li class="nav-item">
              <a class="nav-link collapsed" href="registrar_guardas">
                <i class="bi bi-person"></i>
                <span>Registrar Guardas</span>
              </a>
            </li><!-- End Registrar Guardas Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-toggle="collapse" href="#gestionUsuarios" role="button" aria-expanded="false" aria-controls="gestionUsuarios">
                  <i class="bi bi-people"></i>
                  <span>Gestión de Usuarios</span>
                  <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="gestionUsuarios" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                  <li>
                    <a href="formulario_registro_personal">
                      <i class="bi bi-plus-circle"></i>
                      <span>Crear Usuario</span>
                    </a>
                  </li>
                  <li>
                    <a href="Listado_Usuarios">
                      <i class="bi bi-list-ul"></i>
                      <span>Listado de Usuarios</span>
                    </a>
                  </li>
                </ul>
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
          <?php if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === 'Guarda'): ?>

            <li class="nav-item">
              <a class="nav-link collapsed" href="contacto.html">
                <i class="bi bi-envelope"></i>
                <span>Reportar Bugs</span>
              </a>
            </li><!-- End Contáctenos Nav -->
          <?php endif; ?>
          <!-- Cerrar Sesión -->
          <li class="nav-item">
            <a class="nav-link collapsed" href="logout">
              <i class="bi bi-box-arrow-in-right"></i>
              <span>Cerrar Sección</span>
            </a>
          </li><!-- End Cerrar Sección Nav -->
        </ul>
      </aside>
      <main id="main" class="main">
