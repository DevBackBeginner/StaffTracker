<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>StaffTracker</title>
    <link rel="icon" href="/ControlAsistencia/public/assets/img/logo.png" type="image/x-icon">

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:400,500,600%7CTeko:300,400,500%7CMaven+Pro:500">
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/fonts.css">
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/style.css">
    <style>
        .ie-panel {
            display: none;
            background: #212121;
            padding: 10px 0;
            box-shadow: 3px 3px 5px 0 rgba(0, 0, 0, .3);
            clear: both;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        html.ie-10 .ie-panel,
        html.lt-ie-10 .ie-panel {
            display: block;
        }
        
        /* Estilo básico para imágenes responsivas */
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="ie-panel">
        <a href="http://windows.microsoft.com/en-US/internet-explorer/">
            <img src="/ControlAsistencia/public/assets/img/sena1.jpg" height="42" width="820" alt="Advertencia: Navegador obsoleto.">
        </a>
    </div>

    <div class="preloader">
        <div class="preloader-body">
            <div class="cssload-container">
                <span></span><span></span><span></span><span></span>
            </div>
        </div>
    </div>

    <div class="page">
        <header id="home">
            <!-- Swiper -->
            <section class="section swiper-container swiper-slider swiper-slider-classic" data-loop="true" data-autoplay="4859" data-simulate-touch="true" data-direction="vertical" data-nav="false">
                <div class="swiper-wrapper text-center">
                    <!-- Slide 1 -->
                    <div class="swiper-slide" data-slide-bg="/ControlAsistencia/public/assets/img/sena1.jpg" style="box-shadow: 0 8px 16px 0 #007832;">
                        <div class="swiper-slide-caption section-md">
                            <div class="container">
                                <h1 class="wow fadeInLeft" data-wow-delay="0" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 5em;">Registro Ágil y Seguro</h1>
                                <p class="text-width-large wow fadeInRight" data-wow-delay="100" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">
                                    El sistema "SENA Villeta" permite el control eficiente del ingreso y salida de instructores, administrativos y visitantes mediante escaneo de credenciales.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="swiper-slide" data-slide-bg="/ControlAsistencia/public/assets/img/sena2.jpg" style="box-shadow: 0 8px 16px 0 #007832;">
                        <div class="swiper-slide-caption section-md">
                            <div class="container">
                                <h1 class="wow fadeInLeft" data-wow-delay="0" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 5em;">Gestión de Visitantes</h1>
                                <p class="text-width-large wow fadeInRight" data-wow-delay="100" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">
                                    Registra de manera rápida y organizada los datos y motivos de visita de todas las personas externas que ingresan a las instalaciones.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="swiper-slide" data-slide-bg="/ControlAsistencia/public/assets/img/sena3.jpg" style="box-shadow: 0 8px 16px 0 #007832;">
                        <div class="swiper-slide-caption section-md">
                            <div class="container">
                                <h1 class="wow fadeInLeft" data-wow-delay="0" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 5em;">Seguridad y Control</h1>
                                <p class="text-width-large wow fadeInRight" data-wow-delay="100" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">
                                    Optimiza la supervisión del acceso a las instalaciones del SENA, garantizando un entorno seguro y organizado para todos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </header>

        <section class="section section-sm section-first bg-default text-center" id="services">
    <div class="container">
        <div class="row row-30 justify-content-center align-items-center">
            <div class="col-md-7 col-lg-5 col-xl-6 text-lg-left wow fadeInUp">
                <img src="/ControlAsistencia/public/assets/img/seguridad.jpg" alt="Seguridad" class="img-fluid"/>
            </div>
            <div class="col-lg-7 col-xl-6">
                <div class="row row-30">
                    <div class="col-sm-6 wow fadeInRight">
                        <article class="box-icon-modern box-icon-modern-custom">
                            <div>
                                <h3 class="box-icon-modern-big-title" style="font-size: 2em;">¿Qué Ofrecemos?</h3>
                                <div class="box-icon-modern-decor"></div>
                            </div>
                        </article>
                    </div>
                    <div class="col-sm-6 wow fadeInRight" data-wow-delay=".1s">
                        <article class="box-icon-modern box-icon-modern-2">
                            <div class="box-icon-modern-icon">
                                <i class="fas fa-phone-alt"></i> <!-- Ícono de teléfono -->
                            </div>
                            <h5 class="box-icon-modern-title" style="font-size: 1.5em;"><a href="#">REGISTRO AUTOMÁTICO</a></h5>
                            <div class="box-icon-modern-decor"></div>
                            <p class="box-icon-modern-text" style="color: #00304D; font-size: 1.3em;">
                                El escaneo del carné permite registrar automáticamente la entrada y salida del personal.
                            </p>
                        </article>
                    </div>
                    <div class="col-sm-6 wow fadeInRight" data-wow-delay=".2s">
                        <article class="box-icon-modern box-icon-modern-2">
                            <div class="box-icon-modern-icon">
                                <i class="fas fa-headset"></i> <!-- Ícono de headset -->
                            </div>
                            <h5 class="box-icon-modern-title" style="font-size: 1.5em;"><a href="#">CONTROL DE VISITAS</a></h5>
                            <div class="box-icon-modern-decor"></div>
                            <p class="box-icon-modern-text" style="color: #00304D; font-size: 1.3em;">
                                Los visitantes registran sus datos y motivo de ingreso de manera rápida y eficiente.
                            </p>
                        </article>
                    </div>
                    <div class="col-sm-6 wow fadeInRight" data-wow-delay=".3s">
                        <article class="box-icon-modern box-icon-modern-2">
                            <div class="box-icon-modern-icon">
                                <i class="fas fa-chart-line"></i> <!-- Ícono de informe -->
                            </div>
                            <h5 class="box-icon-modern-title" style="font-size: 1.5em;"><a href="#">INFORMES Y SEGUIMIENTO</a></h5>
                            <div class="box-icon-modern-decor"></div>
                            <p class="box-icon-modern-text" style="color: #00304D; font-size: 1.3em;">
                                Genera reportes detallados sobre el flujo de personas dentro de las instalaciones.
                            </p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- Sección del equipo -->
<section class="section section-sm bg-light text-center" id="team">
    <div class="container">
        <h2 class="wow fadeInLeft" style="font-size: 2.5em; color: #00304D; margin-bottom: 40px;">Nuestro Equipo</h2>
        <div class="row row-30 justify-content-center">
            <div class="col-md-3 mb-5 wow fadeInUp" data-wow-delay=".1s">
                <div class="team-classic team-classic-lg p-4 border rounded shadow-sm position-relative" style="padding-top: 80px; min-height: 350px;">
                    <img src="/ControlAsistencia/public/assets/img/logo.png" alt="Badend Echo - Backend" class="img-fluid rounded-circle position-absolute" 
                         style="top: 20px; left: 50%; transform: translateX(-50%); width: 120px; height: 120px;">
                    <div class="team-classic-caption mt-5">
                        <h4 class="team-classic-name">
                            <a href="#" style="color: #00304D; font-size: 1.5em;">Badend Echo - Backend</a>
                        </h4>
                        <p class="team-classic-status" style="font-size: 1.2em; color: #555;">Desarrollador Backend</p>
                        <div class="social-links mt-2">
                            <a href="https://github.com/helbert" target="_blank"><i class="fab fa-github"></i> GitHub</a> |
                            <a href="https://linkedin.com/in/helbert" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a> |
                            <a href="mailto:helbert@example.com">Correo</a>
                            <p class="mt-2" style="color: #777;">Cel: +123 456 7890</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-5 wow fadeInUp" data-wow-delay=".2s">
                <div class="team-classic team-classic-lg p-4 border rounded shadow-sm position-relative" style="padding-top: 80px; min-height: 350px;">
                    <img src="/ControlAsistencia/public/assets/img/logo.png" alt="Juan Manuel - Frontend" class="img-fluid rounded-circle position-absolute" 
                         style="top: 20px; left: 50%; transform: translateX(-50%); width: 120px; height: 120px;">
                    <div class="team-classic-caption mt-5">
                        <h4 class="team-classic-name">
                            <a href="#" style="color: #00304D; font-size: 1.5em;">Juan Manuel - Frontend</a>
                        </h4>
                        <p class="team-classic-status" style="font-size: 1.2em; color: #555;">Desarrollador Frontend</p>
                        <div class="social-links mt-2">
                            <a href="https://github.com/juanmanuel" target="_blank"><i class="fab fa-github"></i> GitHub</a> |
                            <a href="https://linkedin.com/in/juanmanuel" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a> |
                            <a href="mailto:juanmanuel@example.com">Correo</a>
                            <p class="mt-2" style="color: #777;">Cel: +123 456 7891</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-5 wow fadeInUp" data-wow-delay=".3s">
                <div class="team-classic team-classic-lg p-4 border rounded shadow-sm position-relative" style="padding-top: 80px; min-height: 350px;">
                    <img src="/ControlAsistencia/public/assets/img/logo.png" alt="Brayan - Beta Tester" class="img-fluid rounded-circle position-absolute" 
                         style="top: 20px; left: 50%; transform: translateX(-50%); width: 120px; height: 120px;">
                    <div class="team-classic-caption mt-5">
                        <h4 class="team-classic-name">
                            <a href="#" style="color: #00304D; font-size: 1.5em;">Brayan - Beta Tester</a>
                        </h4>
                        <p class="team-classic-status" style="font-size: 1.2em; color: #555;">Beta Tester</p>
                        <div class="social-links mt-2">
                            <a href="https://github.com/brayan" target="_blank"><i class="fab fa-github"></i> GitHub</a> |
                            <a href="https://linkedin.com/in/brayan" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a> |
                            <a href="mailto:brayan@example.com">Correo</a>
                            <p class="mt-2" style="color: #777;">Cel: +123 456 7892</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-5 wow fadeInUp" data-wow-delay=".4s">
                <div class="team-classic team-classic-lg p-4 border rounded shadow-sm position-relative" style="padding-top: 80px; min-height: 350px;">
                    <img src="/ControlAsistencia/public/assets/img/logo.png" alt="Cristian - Developer" class="img-fluid rounded-circle position-absolute" 
                         style="top: 20px; left: 50%; transform: translateX(-50%); width: 120px; height: 120px;">
                    <div class="team-classic-caption mt-5">
                        <h4 class="team-classic-name">
                            <a href="#" style="color: #00304D; font-size: 1.5em;">Cristian - Developer</a>
                        </h4>
                        <p class="team-classic-status" style="font-size: 1.2em; color: #555;">Desarrollador</p>
                        <div class="social-links mt-2">
                            <a href="https://github.com/cristian" target="_blank"><i class="fab fa-github"></i> GitHub</a> |
                            <a href="https://linkedin.com/in/cristian" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a> |
                            <a href="mailto:cristian@example.com">Correo</a>
                            <p class="mt-2" style="color: #777;">Cel: +123 456 7893</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Asegúrate de incluir Font Awesome para los iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Últimos Proyectos -->
        <section class="section section-sm section-fluid bg-default text-center" id="projects">
            <div class="container-fluid">
                <h2 class="wow fadeInLeft" style="font-size: 2.5em;">Nuestro Propósito</h2>
                <p class="quote-jean wow fadeInRight" data-wow-delay=".1s" style="color: #00304D; font-size: 1.2em;">
                    El objetivo principal de StaffTracker es simplificar y agilizar el proceso de registro de entrada y salida de las personas que ingresan al centro de desarrollo agroindustrial y empresarial SENA Villeta. Este sistema permite escanear los carnet de los instructores, directivos y funcionarios, capturando automáticamente la fecha y hora de su ingreso. Además, se podrá registrar visitantes con su motivo de visita y datos personales para un control preciso.
                </p>
            </div>
        </section>

        <!-- Características Clave -->
        <section class="section section-sm bg-default text-md-left">
            <div class="container">
                <div class="row row-50 align-items-center justify-content-center justify-content-xl-between">
                    <div class="col-lg-6 col-xl-5 wow fadeInLeft">
                        <h2 style="font-size: 2.5em; text-align: center;">Características Clave de Nuestro Sistema</h2>
                        <div class="tabs-custom tabs-horizontal tabs-line tabs-line-big text-center text-md-left" id="tabs-6">
                            <ul class="nav nav-tabs">
                                <li class="nav-item" role="presentation"><a class="nav-link nav-link-big active" href="#tabs-6-1" data-toggle="tab">01</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link nav-link-big" href="#tabs-6-2" data-toggle="tab">02</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link nav-link-big" href="#tabs-6-3" data-toggle="tab">03</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link nav-link-big" href="#tabs-6-4" data-toggle="tab">04</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tabs-6-1">
                                    <h5 class="font-weight-normal" style="font-size: 1.5em;">Registro de Ingreso por Carné</h5>
                                    <p style="color: #00304D; font-size: 1.2em;">
                                        El sistema permite registrar automáticamente la entrada de instructores y personal autorizado mediante el escaneo de su carné, capturando datos precisos como la fecha y hora de ingreso.
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="tabs-6-2">
                                    <h5 class="font-weight-normal" style="font-size: 1.5em;">Registro de Visitantes</h5>
                                    <p style="color: #00304D; font-size: 1.2em;">
                                        Los visitantes podrán registrar su ingreso completando un formulario con sus datos personales y el motivo de su visita, asegurando un control eficiente del acceso a las instalaciones.
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="tabs-6-3">
                                    <h5 class="font-weight-normal" style="font-size: 1.5em;">Seguridad y Control</h5>
                                    <p style="color: #00304D; font-size: 1.2em;">
                                        Gracias al registro detallado de entradas y salidas, nuestro sistema mejora la seguridad en las instalaciones del SENA, permitiendo tener un historial completo de los accesos.
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="tabs-6-4">
                                    <h5 class="font-weight-normal" style="font-size: 1.5em;">Optimización de la Administración de Accesos</h5>
                                    <p style="color: #00304D; font-size: 1.2em;">
                                        El sistema facilita la gestión de los accesos, permitiendo una administración más eficiente de los recursos humanos y un mejor control sobre el personal de seguridad y guardias.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center wow fadeInUp" data-wow-delay=".1s">
                        <div class="owl-carousel owl-style-1" data-items="2" data-stage-padding="0" data-loop="true" data-margin="0" data-mouse-drag="true" data-autoplay="true">
                            <a class="box-device" href="#"><img src="/ControlAsistencia/public/assets/img/carnet.jpg" alt="Registro por Carné" width="313" height="580" /></a>
                            <a class="box-device" href="#"><img src="/ControlAsistencia/public/assets/img/visitantes.jpg" alt="Registro de Visitantes" width="313" height="580" /></a>
                            <a class="box-device" href="#"><img src="/ControlAsistencia/public/assets/img/programacion.jpg" alt="Programación de Accesos" width="313" height="580" /></a>
                            <a class="box-device" href="#"><img src="/ControlAsistencia/public/assets/img/guarda.jpg" alt="Administración de Guardias" width="313" height="580" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-- Registro de Ingreso y Salida -->
<section class="section section-sm section-fluid bg-default" id="team" style="padding: 40px 0;">
    <div class="container-fluid">
        <h2 style="font-size: 2.5em; margin-bottom: 20px;">Registro de Ingreso y Salida</h2>
        <p style="color: #00304D; font-size: 1.2em; margin-bottom: 30px;">
           
        </p>
        <div class="row row-sm row-30 justify-content-center">
            <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInRight">
                <article class="team-classic team-classic-lg" style="margin-bottom: 30px;">
                    <a class="team-classic-figure" href="#">
                        <img src="/ControlAsistencia/public/assets/img/instructor.jpg" alt="Instructores" width="420" height="424"/>
                    </a>
                    <div class="team-classic-caption">
                        <h4 class="team-classic-name"><a href="#" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">Instructores</a></h4>
                        <p class="team-classic-status" style="font-size: 1.2em;">Registro de entrada y salida de instructores para asegurar el control de acceso.</p>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInRight" data-wow-delay=".1s">
                <article class="team-classic team-classic-lg" style="margin-bottom: 30px;">
                    <a class="team-classic-figure" href="#">
                        <img src="/ControlAsistencia/public/assets/img/directivos.jpg" alt="Funcionarios" width="420" height="424"/>
                    </a>
                    <div class="team-classic-caption">
                        <h4 class="team-classic-name"><a href="#" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">Funcionarios</a></h4>
                        <p class="team-classic-status" style="font-size: 1.2em;">Control de ingreso de personal administrativo para mantener la seguridad en las instalaciones.</p>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInRight" data-wow-delay=".2s">
                <article class="team-classic team-classic-lg" style="margin-bottom: 30px;">
                    <a class="team-classic-figure" href="#">
                        <img src="/ControlAsistencia/public/assets/img/visitantesena.jpg" alt="Visitantes" width="420" height="424"/>
                    </a>
                    <div class="team-classic-caption">
                        <h4 class="team-classic-name"><a href="#" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">Visitantes</a></h4>
                        <p class="team-classic-status" style="font-size: 1.2em;">Registro de visitantes, incluyendo motivo de visita y datos personales para garantizar el acceso adecuado.</p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>



<!-- Bottom Banner -->
<h2 style="margin: 40px 0;">Centro de desarrollo agroindustrial y empresarial SENA Villeta</h2>

<section class="section section-fluid" style="margin-top: 30px; padding-bottom: 20px;"> <!-- Ajusta el valor según necesites -->
    <a class="section-banner" href="https://www.templatemonster.com/intense-multipurpose-html-template.html" style="
        background-image: url(images/banner/banner-bg-01-1920x310.jpg); 
        background-image: -webkit-image-set(url(images/banner/banner-bg-01-1920x310.jpg) 1x, url(images/banner/banner-bg-01-3840x620.jpg) 2x);
        display: block;
        border: 5px solid rgb(255, 255, 255); /* Borde de color blanco */
        box-shadow: 0 0 30px #007832; /* Sombra verde difusa */
        border-radius: 10px; /* Bordes redondeados */
        opacity: 0.9; /* Opacidad para hacer más suave el fondo */
        transition: transform 0.3s ease, opacity 0.3s ease; /* Transiciones para el efecto hover */
    " target="_blank">
        <img src="/ControlAsistencia/public/assets/img/senaaire.jpg" alt="Centro de Desarrollo Agroindustrial" width="1600" height="310" style="display: block; margin: auto;">
    </a>
</section>


        <!-- Global Mailform Output -->
        <div class="snackbars" id="form-output-global"></div>
    </div>

    <!-- Scripts -->
    <script src="/ControlAsistencia/public/assets/js/jquery.js"></script>
    <script src="/ControlAsistencia/public/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/ControlAsistencia/public/assets/js/swiper-bundle.min.js"></script>
    <script src="/ControlAsistencia/public/assets/js/scripts.js"></script>
</body>
</html>

<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>