<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>

<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>StaffTracker</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="/ControlAsistencia/public/assets/img/logo.png" type="image/x-icon">
    <!-- Stylesheets-->
     
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:400,500,600%7CTeko:300,400,500%7CMaven+Pro:500">
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/fonts.css">
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/style.css">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
  </head>
  <body>
    <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="/ControlAsistencia/public/assets/img/sena1.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <div class="preloader">
      <div class="preloader-body">
        <div class="cssload-container"><span></span><span></span><span></span><span></span>
        </div>
      </div>
    </div>
    <div class="page">
      <div id="home">
        <!-- Swiper-->
        <section class="section swiper-container swiper-slider swiper-slider-classic" data-loop="true" data-autoplay="4859" data-simulate-touch="true" data-direction="vertical" data-nav="false">
        <div class="swiper-wrapper text-center">
        <div class="swiper-slide" data-slide-bg="/ControlAsistencia/public/assets/img/sena1.jpg" style="box-shadow: 0 8px 16px 0 #007832;">
        <div class="swiper-slide-caption section-md">
        <div class="container">
          <h1 data-caption-animate="fadeInLeft" data-caption-delay="0" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 5em;">Registro Ágil y Seguro</h1>
          <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">El sistema "SENA Villeta" permite el control eficiente del ingreso y salida de instructores, administrativos y visitantes mediante escaneo de credenciales.</p>
        </div>
        </div>
        </div>
        <div class="swiper-slide" data-slide-bg="/ControlAsistencia/public/assets/img/sena2.jpg" style="box-shadow: 0 8px 16px 0 #007832;">
        <div class="swiper-slide-caption section-md">
        <div class="container">
          <h1 data-caption-animate="fadeInLeft" data-caption-delay="0" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 5em;">Gestión de Visitantes</h1>
          <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">Registra de manera rápida y organizada los datos y motivos de visita de todas las personas externas que ingresan a las instalaciones.</p>
        </div>
        </div>
        </div>
        <div class="swiper-slide" data-slide-bg="/ControlAsistencia/public/assets/img/sena3.jpg" style="box-shadow: 0 8px 16px 0 #007832;">
        <div class="swiper-slide-caption section-md">
        <div class="container">
          <h1 data-caption-animate="fadeInLeft" data-caption-delay="0" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 5em;">Seguridad y Control</h1>
          <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">Optimiza la supervisión del acceso a las instalaciones del SENA, garantizando un entorno seguro y organizado para todos.</p>
        </div>
        </div>
        </div>
        </div>
        </section>
      </div>
      <!-- See all services-->
      <section class="section section-sm section-first bg-default text-center" id="services">
        <div class="container">
          <div class="row row-30 justify-content-center align-items-center">
        <div class="col-md-7 col-lg-5 col-xl-6 text-lg-left wow fadeInUp">
          <img src="/ControlAsistencia/public/assets/img/seguridad.jpg" alt="" width="1000" height="592" class="img-fluid"/>
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
        <div class="box-icon-modern-icon linearicons-phone-in-out"></div>
        <h5 class="box-icon-modern-title" style="font-size: 1.5em;"><a href="#">REGISTRO AUTOMÁTICO</a></h5>
        <div class="box-icon-modern-decor"></div>
        <p class="box-icon-modern-text" style="color: #00304D; font-size: 1.3em;">El escaneo del carné permite registrar automáticamente la entrada y salida del personal.</p>
          </article>
        </div>
        <div class="col-sm-6 wow fadeInRight" data-wow-delay=".2s">
          <article class="box-icon-modern box-icon-modern-2">
        <div class="box-icon-modern-icon linearicons-headset"></div>
        <h5 class="box-icon-modern-title" style="font-size: 1.5em;"><a href="#">CONTROL DE VISITAS</a></h5>
        <div class="box-icon-modern-decor"></div>
        <p class="box-icon-modern-text" style="color: #00304D; font-size: 1.3em;">Los visitantes registran sus datos y motivo de ingreso de manera rápida y eficiente.</p>
          </article>
        </div>
        <div class="col-sm-6 wow fadeInRight" data-wow-delay=".3s">
          <article class="box-icon-modern box-icon-modern-2">
        <div class="box-icon-modern-icon linearicons-outbox"></div>
        <h5 class="box-icon-modern-title" style="font-size: 1.5em;"><a href="#">INFORMES Y SEGUIMIENTO</a></h5>
        <div class="box-icon-modern-decor"></div>
        <p class="box-icon-modern-text" style="color: #00304D; font-size: 1.3em;">Genera reportes detallados sobre el flujo de personas dentro de las instalaciones.</p>
          </article>
        </div>
          </div>
        </div>
          </div>
        </div>
      </section>
      <!-- Cta-->
      <section class="section section-fluid bg-default">
        <div class="parallax-container" data-parallax-img="/ControlAsistencia/public/assets/img/sena4.jpg" style="box-shadow: 0 8px 16px 0 #007832; background-size: cover; height: 600px; display: flex; align-items: center; justify-content: center;">
          <div class="parallax-content section-xl context-dark bg-overlay-68 bg-mobile-overlay">
        <div class="container">
          <div class="row row-30 justify-content-center text-center">
            <div class="col-sm-7">
          <h3 class="wow fadeInLeft" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 2.5em;">Gestión de Accesos Eficiente</h3>
          <p style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.2em;">Con nuestro sistema de control de acceso, garantizamos una entrada y salida rápida y segura para instructores, directivos, administrativos y visitantes. Optimiza la gestión y mejora la seguridad en las instalaciones del SENA.</p>
          <div class="group-sm group-middle group justify-content-center"></div>
            </div>
          </div>
        </div>
          </div>
        </div>
      </section>

      <section class="section section-sm bg-default text-center" id="team">
        <div class="container">
          <h2 class="wow fadeInLeft" style="font-size: 2.5em;">Nuestro Equipo</h2>
          <div class="row row-30 justify-content-center">
        <div class="col-md-3 mb-4 wow fadeInUp" data-wow-delay=".1s">
          <div class="team-classic team-classic-lg">
            <a class="team-classic-figure" href="#"><img src="/ControlAsistencia/public/assets/img/logo.png" alt="Badend Echo" class="img-fluid rounded-circle" style="width: 150px; height: 150px;"></a>
            <div class="team-classic-caption">
          <h4 class="team-classic-name"><a href="#" style="color: #00304D; font-size: 1.5em;">Badend Echo - Backend</a></h4>
          <p class="team-classic-status" style="font-size: 1.2em;">Desarrollador Backend</p>
          <div class="social-links">
            <a href="https://github.com/helbert" target="_blank">GitHub</a> |
            <a href="https://linkedin.com/in/helbert" target="_blank">LinkedIn</a> |
            <a href="mailto:helbert@example.com">Correo</a>
            <p>Cel: +123 456 7890</p>
          </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4 wow fadeInUp" data-wow-delay=".2s">
          <div class="team-classic team-classic-lg">
            <a class="team-classic-figure" href="#"><img src="/ControlAsistencia/public/assets/img/logo.png" alt="Juan Manuel" class="img-fluid rounded-circle" style="width: 150px; height: 150px;"></a>
            <div class="team-classic-caption">
          <h4 class="team-classic-name"><a href="#" style="color: #00304D; font-size: 1.5em;">Juan Manuel - Frontend</a></h4>
          <p class="team-classic-status" style="font-size: 1.2em;">Desarrollador Frontend</p>
          <div class="social-links">
            <a href="https://github.com/juanmanuel" target="_blank">GitHub</a> |
            <a href="https://linkedin.com/in/juanmanuel" target="_blank">LinkedIn</a> |
            <a href="mailto:juanmanuel@example.com">Correo</a>
            <p>Cel: +123 456 7891</p>
          </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4 wow fadeInUp" data-wow-delay=".3s">
          <div class="team-classic team-classic-lg">
            <a class="team-classic-figure" href="#"><img src="/ControlAsistencia/public/assets/img/logo.png" alt="Brayan" class="img-fluid rounded-circle" style="width: 150px; height: 150px;"></a>
            <div class="team-classic-caption">
          <h4 class="team-classic-name"><a href="#" style="color: #00304D; font-size: 1.5em;">Brayan - Beta Tester</a></h4>
          <p class="team-classic-status" style="font-size: 1.2em;">Beta Tester</p>
          <div class="social-links">
            <a href="https://github.com/brayan" target="_blank">GitHub</a> |
            <a href="https://linkedin.com/in/brayan" target="_blank">LinkedIn</a> |
            <a href="mailto:brayan@example.com">Correo</a>
            <p>Cel: +123 456 7892</p>
          </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4 wow fadeInUp" data-wow-delay=".4s">
          <div class="team-classic team-classic-lg">
            <a class="team-classic-figure" href="#"><img src="/ControlAsistencia/public/assets/img/logo.png" alt="Cristian" class="img-fluid rounded-circle" style="width: 150px; height: 150px;"></a>
            <div class="team-classic-caption">
          <h4 class="team-classic-name"><a href="#" style="color: #00304D; font-size: 1.5em;">Cristian - Developer</a></h4>
          <p class="team-classic-status" style="font-size: 1.2em;">Desarrollador</p>
          <div class="social-links">
            <a href="https://github.com/cristian" target="_blank">GitHub</a> |
            <a href="https://linkedin.com/in/cristian" target="_blank">LinkedIn</a> |
            <a href="mailto:cristian@example.com">Correo</a>
            <p>Cel: +123 456 7893</p>
          </div>
            </div>
          </div>
        </div>
          </div>
        </div>
      </section>

    <!-- Últimos Proyectos-->
    <section class="section section-sm section-fluid bg-default text-center" id="projects">
      <div class="container-fluid">
        <h2 class="wow fadeInLeft" style="font-size: 2.5em;">Nuestro Propósito</h2>
        <p class="quote-jean wow fadeInRight" data-wow-delay=".1s" style="color: #00304D; font-size: 1.2em;">El objetivo principal de StaffTracker es simplificar y agilizar el proceso de registro de entrada y salida de las personas que ingresan al centro de desarrollo agroindustrial y empresarial sena villeta. Este sistema permite escanear los carnet de los instructores,directivos,funcionarios, capturando automáticamente la fecha y hora de su ingreso. Además, se podra registrar visitantes con su motivo de su visita, junto con sus datos personales, para un control preciso y detallado.</p>
      </div>
    </section>

    <!-- Su Control de Acceso, Nuestra Prioridad -->
    <section class="section section-sm bg-default text-md-left">
      <div class="container">
        <div class="row row-50 align-items-center justify-content-center justify-content-xl-between">
          <div class="col-lg-6 col-xl-5 wow fadeInLeft">
            <h2 style="font-size: 2.5em; text-align: center;">Características Clave de Nuestro Sistema</h2>
            <!-- Bootstrap tabs-->
            <div class="tabs-custom tabs-horizontal tabs-line tabs-line-big text-center text-md-left" id="tabs-6">
              <!-- Nav tabs-->
              <ul class="nav nav-tabs">
                <li class="nav-item" role="presentation"><a class="nav-link nav-link-big active" href="#tabs-6-1" data-toggle="tab">01</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link nav-link-big" href="#tabs-6-2" data-toggle="tab">02</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link nav-link-big" href="#tabs-6-3" data-toggle="tab">03</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link nav-link-big" href="#tabs-6-4" data-toggle="tab">04</a></li>
              </ul>
              <!-- Tab panes-->
              <div class="tab-content">
                <div class="tab-pane fade show active" id="tabs-6-1">
                  <h5 class="font-weight-normal" style="font-size: 1.5em;">Registro de Ingreso por Carné</h5>
                  <p style="color: #00304D; font-size: 1.2em;">El sistema permite registrar automáticamente la entrada de instructores y personal autorizado mediante el escaneo de su carné, capturando datos precisos como la fecha y hora de ingreso.</p>
                  <div class="group-sm group-middle"></div>
                </div>
                <div class="tab-pane fade" id="tabs-6-2">
                  <h5 class="font-weight-normal" style="font-size: 1.5em;">Registro de Visitantes</h5>
                  <p style="color: #00304D; font-size: 1.2em;">Los visitantes podrán registrar su ingreso completando un formulario con sus datos personales y el motivo de su visita, asegurando un control eficiente del acceso a las instalaciones.</p>
                  <div class="group-sm group-middle"></div>
                </div>
                <div class="tab-pane fade" id="tabs-6-3">
                  <h5 class="font-weight-normal" style="font-size: 1.5em;">Seguridad y Control</h5>
                  <p style="color: #00304D; font-size: 1.2em;">Gracias al registro detallado de entradas y salidas, nuestro sistema mejora la seguridad en las instalaciones del SENA, permitiendo tener un historial completo de los accesos.</p>
                  <div class="group-sm group-middle"></div>
                </div>
                <div class="tab-pane fade" id="tabs-6-4">
                  <h5 class="font-weight-normal" style="font-size: 1.5em;">Optimización de la Administración de Accesos</h5>
                  <p style="color: #00304D; font-size: 1.2em;">El sistema facilita la gestión de los accesos, permitiendo una administración más eficiente de los recursos humanos y un mejor control sobre el personal de seguridad y guardias.</p>
                  <div class="group-sm group-middle"></div>
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

<!-- Conoce al Equipo-->
<section class="section section-sm section-fluid bg-default" id="team">
  <div class="container-fluid">
    <h2 style="font-size: 2.5em;">Registro de Ingreso y Salida</h2>
    <p style="color: #00304D; font-size: 1.2em;">El equipo encargado de garantizar el correcto registro de los ingresos y salidas en el SENA está compuesto por profesionales dedicados al control y la seguridad. Nuestro sistema permite a los guardias de seguridad gestionar el acceso de instructores, administrativos y visitantes de manera eficiente y precisa.</p>
    <div class="row row-sm row-30 justify-content-center">
      <div class="col-md-6 col-lg-5 col-xl-3 wow fadeInRight">
        <article class="team-classic team-classic-lg"><a class="team-classic-figure" href="#"><img src="/ControlAsistencia/public/assets/img/instructor.jpg" alt="" width="420" height="424"/></a>
          <div class="team-classic-caption">
          <h4 class="team-classic-name"><a href="#" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">Instructores</a></h4>
            <p class="team-classic-status" style="font-size: 1.2em;">Registro de entrada y salida de instructores para asegurar el control de acceso.</p>
          </div>
        </article>
      </div>
      <div class="col-md-6 col-lg-5 col-xl-3 wow fadeInRight" data-wow-delay=".1s">
        <article class="team-classic team-classic-lg"><a class="team-classic-figure" href="#"><img src="/ControlAsistencia/public/assets/img/directivos.jpg" alt="" width="420" height="424"/></a>
          <div class="team-classic-caption">
          <h4 class="team-classic-name"><a href="#" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">Funcionarios</a></h4>
            <p class="team-classic-status" style="font-size: 1.2em;">Control de ingreso de personal administrativo para mantener la seguridad en las instalaciones.</p>
          </div>
        </article>
      </div>
      <div class="col-md-6 col-lg-5 col-xl-3 wow fadeInRight" data-wow-delay=".2s">
        <article class="team-classic team-classic-lg"><a class="team-classic-figure" href="#"><img src="/ControlAsistencia/public/assets/img/visitantesena.jpg" alt="" width="420" height="424"/></a>
          <div class="team-classic-caption">
            <h4 class="team-classic-name"><a href="#" style="color: white; text-shadow: 2px 2px 4px #007832; font-size: 1.5em;">Visitantes</a></h4>
            <p class="team-classic-status" style="font-size: 1.2em;">Registro de visitantes, incluyendo motivo de visita y datos personales para garantizar el acceso adecuado.</p>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>



<h2>Centro de desarrollo agroindustrial y empresarial sena villeta</h2>
<!-- Bottom Banner-->
<section class="section section-fluid"><a class="section-banner" href="https://www.templatemonster.com/intense-multipurpose-html-template.html" style="background-image: url(images/banner/banner-bg-01-1920x310.jpg); background-image: -webkit-image-set( url(images/banner/banner-bg-01-1920x310.jpg) 1x, url(images/banner/banner-bg-01-3840x620.jpg) 2x )" target="_blank"><img src="/ControlAsistencia/public/assets/img/senaaire.jpg" srcset="/ControlAsistencia/public/assets/img/senaaire.jpg 1x, senaaire.jpg" alt="" width="1600" height="310"></a></section>
<!-- Global Mailform Output-->
<div class="snackbars" id="form-output-global"></div>


</body>
</html>

<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>
