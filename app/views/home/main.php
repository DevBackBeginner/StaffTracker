<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>StaffTracker</title>
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:400,500,600%7CTeko:300,400,500%7CMaven+Pro:500">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/fonts.css">
    <link rel="stylesheet" href="assets/css/style.css">
   
</head>
<body>
    <div class="ie-panel">
        <a href="http://windows.microsoft.com/en-US/internet-explorer/">
            <img src="assets/img/sena1.jpg" height="42" width="820" alt="Advertencia: Navegador obsoleto.">
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
                    <div class="swiper-slide" data-slide-bg="assets/img/sena1.jpg" style="border-radius: 15px;">
                        <div class="swiper-slide-caption section-md">
                            <div class="container">
                                <h1 class="wow fadeInLeft" data-wow-delay="0" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 5em;">Registro Ágil y Seguro</h1>
                                <p class="text-width-large wow fadeInRight" data-wow-delay="100" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">
                                    El sistema StaffTracker permite el control eficiente del ingreso y salida de instructores, administrativos y visitantes mediante escaneo de credenciales.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="swiper-slide" data-slide-bg="assets/img/sena2.jpg" style="border-radius: 15px;">
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
                    <div class="swiper-slide" data-slide-bg="assets/img/sena3.jpg" style="border-radius: 15px;">
                        <div class="swiper-slide-caption section-md">
                            <div class="container">
                                <h1 class="wow fadeInLeft" data-wow-delay="0" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 5em;">Seguridad y Control</h1>
                                <p class="text-width-large wow fadeInRight" data-wow-delay="100" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">
                                    Optimiza la supervisión del acceso a las instalaciones del Centro de desarrollo agroindustrial y empresarial, garantizando un entorno seguro y organizado para todos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </header>
        <section class="section section-sm section-first text-center" id="services" style="border-radius: 20px; overflow: hidden;">
            <div class="container">
                <div class="row row-30 justify-content-center align-items-center">
                    <div class="col-md-7 col-lg-5 col-xl-6 text-lg-left wow fadeInUp">
                        <img src="assets/img/seguridad.jpg" alt="Seguridad" class="img-fluid rounded-lg shadow-lg"/>
                    </div>
                    <div class="col-lg-7 col-xl-6">
                        <div class="row row-30">
                            <div class="col-sm-6 wow fadeInRight">
                                <article class="box-icon-modern box-icon-modern-custom">
                                    <div>
                                        <h3 class="box-icon-modern-big-title" style="font-size: 2.2em; color: #007832;">¿Qué Ofrecemos?</h3>
                                        <div class="box-icon-modern-decor" style="background-color: #007832; height: 3px; width: 60px; margin: 0 auto;"></div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-6 wow fadeInRight" data-wow-delay=".1s">
                                <article class="box-icon-modern box-icon-modern-2">
                                    <div class="box-icon-modern-icon" style="color: #007832;">
                                        <i class="fas fa-phone-alt"></i> <!-- Ícono de teléfono -->
                                    </div>
                                    <h5 class="box-icon-modern-title" style="font-size: 1.6em; color: #00304D;"><a href="#">REGISTRO AUTOMÁTICO</a></h5>
                                    <div class="box-icon-modern-decor" style="background-color: #00304D; height: 2px; width: 50px;"></div>
                                    <p class="box-icon-modern-text" style="color: #00304D; font-size: 1.3em;">
                                        El escaneo del carné permite registrar automáticamente la entrada y salida del personal.
                                    </p>
                                </article>
                            </div>
                            <div class="col-sm-6 wow fadeInRight" data-wow-delay=".2s">
                                <article class="box-icon-modern box-icon-modern-2">
                                    <div class="box-icon-modern-icon" style="color: #007832;">
                                        <i class="fas fa-headset"></i> <!-- Ícono de headset -->
                                    </div>
                                    <h5 class="box-icon-modern-title" style="font-size: 1.6em; color: #00304D;"><a href="#">CONTROL DE VISITANTES</a></h5>
                                    <div class="box-icon-modern-decor" style="background-color: #00304D; height: 2px; width: 50px;"></div>
                                    <p class="box-icon-modern-text" style="color: #00304D; font-size: 1.3em;">
                                        Los visitantes registran sus datos y motivo de ingreso de manera rápida y eficiente.
                                    </p>
                                </article>
                            </div>
                            <div class="col-sm-6 wow fadeInRight" data-wow-delay=".3s">
                                <article class="box-icon-modern box-icon-modern-2">
                                    <div class="box-icon-modern-icon" style="color: #007832;">
                                        <i class="fas fa-chart-line"></i> <!-- Ícono de informe -->
                                    </div>
                                    <h5 class="box-icon-modern-title" style="font-size: 1.6em; color: #00304D;"><a href="#">INFORMES Y SEGUIMIENTO</a></h5>
                                    <div class="box-icon-modern-decor" style="background-color: #00304D; height: 2px; width: 50px;"></div>
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
    </div>

    <style>
        /* Estilos generales para mejorar la apariencia */
        .swiper-slide {
            border-radius: 15px; /* Esquinas redondeadas en las diapositivas */
        }

        .box-icon-modern-custom,
        .box-icon-modern-2 {
            border-radius: 10px; /* Esquinas redondeadas en los artículos */
            /* Eliminamos la sombra */
        }

        .img-fluid {
            border-radius: 15px; /* Esquinas redondeadas en las imágenes */
        }

        .rounded-lg {
            border-radius: 20px; /* Esquinas redondeadas en imágenes grandes */
        }
    </style>
</body>

<style>
    .team-card {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border-radius: 15px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        text-align: center;
        transition: transform 0.3s ease-in-out;
        padding: 20px;
    }
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
    }
    .custom-team-img {  /* Cambié el nombre de la clase */
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 15px;
        border: 3px solid #007832;
    }
    .team-name {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
    }
    .team-role {
        font-size: 1rem;
        color: #555;
    }
    .team-contact {
        font-size: 0.9rem;
        color: #777;
    }
    .social-links a {
        color: #007832;
        margin: 0 8px;
        font-size: 1.2rem;
        transition: color 0.3s;
    }
    .social-links a:hover {
        color: #007832;
    }
    /* Destacando al Project Manager */
    .pm-card {
        border: 3px solid #007832;
        background: linear-gradient(135deg, #e3f2fd, #ffffff);
    }
</style>

<!-- Título de la sección -->
<h2 class="team-title">Nuestro Equipo</h2>

<!-- Project Manager -->
<div class="row justify-content-center mb-5">
    <div class="col-md-4 wow fadeInUp" data-wow-delay=".1s">
        <div class="team-card pm-card">
            <img src="assets/img/logo.png" alt="Project Manager" class="custom-team-img"> <!-- Cambié la clase aquí -->
            <div class="team-caption">
                <h4 class="team-name">Profesor - Project Manager</h4>
                <p class="team-role">Líder del Proyecto</p>
                <div class="social-links">
                    <a href="https://github.com/alex" target="_blank"><i class="fab fa-github"></i></a>
                    <a href="https://linkedin.com/in/alex" target="_blank"><i class="fab fa-linkedin"></i></a>
                    <a href="mailto:alex@example.com"><i class="fas fa-envelope"></i></a>
                </div>
                <p class="team-contact">Cel: +57 3001234567</p>
            </div>
        </div>
    </div>
</div>

<!-- Otros miembros del equipo -->
<div class="row row-30 justify-content-center" style="gap: 30px;">
    <div class="col-md-3 mb-5 wow fadeInUp" data-wow-delay=".2s">
        <div class="team-card">
            <img src="assets/img/logo.png" alt="Juan Manuel - Frontend" class="custom-team-img"> <!-- Cambié la clase aquí -->
            <div class="team-caption">
                <h4 class="team-name">Helbert - Badend</h4>
                <p class="team-role">Desarrollador Badend</p>
                <div class="social-links">
                    <a href="https://github.com/ZackerMax2003" target="_blank"><i class="fab fa-github"></i></a>
                    <a href="https://linkedin.com/in/juanmanuel" target="_blank"><i class="fab fa-linkedin"></i></a>
                    <a href="mailto:juancho73x@gmail.com"><i class="fas fa-envelope"></i></a>
                </div>
                <p class="team-contact">Cel: +57 3204374207</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-5 wow fadeInUp" data-wow-delay=".3s">
        <div class="team-card">
            <img src="assets/img/logo.png" alt="Brayan - Beta Tester" class="custom-team-img"> <!-- Cambié la clase aquí -->
            <div class="team-caption">
                <h4 class="team-name">Juan Manuel - Frontend</h4>
                <p class="team-role">Desarrollador Frontend</p>
                <div class="social-links">
                    <a href="https://github.com/yanbra31" target="_blank"><i class="fab fa-github"></i></a>
                    <a href="https://linkedin.com/in/brayan" target="_blank"><i class="fab fa-linkedin"></i></a>
                    <a href="mailto:infantebrayan22@gmail.com"><i class="fas fa-envelope"></i></a>
                </div>
                <p class="team-contact">Cel: +57 3114623033</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-5 wow fadeInUp" data-wow-delay=".4s">
        <div class="team-card">
            <img src="assets/img/logo.png" alt="Cristian - Developer" class="custom-team-img"> <!-- Cambié la clase aquí -->
            <div class="team-caption">
                <h4 class="team-name">Brayan - Beta Tester</h4>
                <p class="team-role">Desarrollador</p>
                <div class="social-links">
                    <a href="https://github.com/cristian" target="_blank"><i class="fab fa-github"></i></a>
                    <a href="https://linkedin.com/in/cristian" target="_blank"><i class="fab fa-linkedin"></i></a>
                    <a href="mailto:cristian@example.com"><i class="fas fa-envelope"></i></a>
                </div>
                <p class="team-contact">Cel: +123 456 7893</p>
            </div>
        </div>
    </div>
</div>


<!-- Asegúrate de incluir Font Awesome para los iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Últimos Proyectos -->
<section class="section section-sm section-fluid bg-light text-center" id="projects" style="padding: 50px 0;">
    <div class="container">
        <h2 class="wow fadeInLeft" style="font-size: 3em; font-weight: bold; color: #007832; margin-bottom: 20px; font-family: 'Work Sans', sans-serif;">Nuestro Propósito</h2>
        <p class="quote-jean wow fadeInRight" data-wow-delay=".1s" style="color: #00304D; font-size: 1.2em; line-height: 1.6; max-width: 800px; margin: 0 auto; font-family: 'Work Sans', sans-serif;">
            El objetivo principal de StaffTracker es simplificar y agilizar el proceso de registro de entrada y salida de las personas que ingresan al centro de desarrollo agroindustrial y empresarial. Este sistema permite escanear los carnet de los instructores, directivos y funcionarios, capturando automáticamente la fecha y hora de su ingreso. Además, se podrá registrar visitantes con su motivo de visita y datos personales para un control preciso.
        </p>
    </div>
</section>

<style>
    /* Mejorando la sección */
    #projects {
        background-color: #f9f9f9; /* Fondo claro */
        padding: 50px 0; /* Espaciado superior e inferior */
    }
    
    #projects h2 {
        font-size: 3em; /* Tamaño de fuente grande */
        font-weight: bold;
        color: #007832; /* Color del texto */
        margin-bottom: 20px;
        font-family: 'Work Sans', sans-serif; /* Fuente Work Sans */
    }
    
    #projects .quote-jean {
        color: #00304D; /* Color del texto */
        font-size: 1.2em; /* Tamaño de fuente */
        line-height: 1.6; /* Espaciado entre líneas */
        max-width: 800px; /* Ancho máximo */
        margin: 0 auto; /* Centrado */
        font-weight: bold;
        font-family: 'Work Sans', sans-serif; /* Fuente Work Sans */
    }
</style>

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
                                Gracias al registro detallado de entradas y salidas, nuestro sistema mejora la seguridad en las instalaciones del Centro de desarrollo agroindustrial y empresarial, permitiendo tener un historial completo de los accesos.
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
                    <a class="box-device" ><img src="assets/img/carnet.jpg" alt="Registro por Carné" class="carousel-img" /></a>
                    <a class="box-device" ><img src="assets/img/visitantes.jpg" alt="Registro de Visitantes" class="carousel-img" /></a>
                    <a class="box-device" ><img src="assets/img/programacion.jpg" alt="Programación de Accesos" class="carousel-img" /></a>
                    <a class="box-device" ><img src="assets/img/guarda.jpg" alt="Administración de Guardias" class="carousel-img" /></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Estilos CSS -->
<style>
    .owl-carousel .carousel-img {
        width: 100%; /* Ajusta el ancho automáticamente */
        height: 400px; /* Altura fija para todas las imágenes */
        object-fit: cover; /* Evita la distorsión y mantiene la proporción */
        border-radius: 10px; /* Opcional: bordes redondeados para mejor apariencia */
        
    }
</style>

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
                        <img src="assets/img/instructor.jpg" alt="Instructores" class="team-img"/>
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
                        <img src="assets/img/directivos.jpg" alt="Funcionarios" class="team-img"/>
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
                        <img src="assets/img/visitantesena.jpg" alt="Visitantes" class="team-img"/>
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

<!-- Estilos CSS -->
<style>
    .team-img {
        width: 100%; /* Ajusta el ancho automáticamente */
        height: 400px; /* Altura fija para todas las imágenes */
        object-fit: cover; /* Mantiene la proporción sin distorsionar */
        border-radius: 10px; /* Opcional: bordes redondeados para mejor apariencia */
    }
</style>



</section>
        <!-- Global Mailform Output -->
        <div class="snackbars" id="form-output-global"></div>
    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>

<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>