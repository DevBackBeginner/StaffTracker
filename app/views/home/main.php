<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>
<link rel="stylesheet" href="/ControlAsistencia/public/assets/css/style.css">

<section class="banner_main">
    <div id="banner1" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#banner1" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#banner1" data-bs-slide-to="1"></li>
            <li data-bs-target="#banner1" data-bs-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <?php
            $slides = [
                ["Bienvenido", "al Sistema de Registro SENA Villeta", "Registro de Ingreso y Salida", "/ControlAsistencia/public/assets/img/banner1.jpg"],
                ["Control Eficiente", "de Asistencia para Instructores, Administrativos y Visitantes", "Control de Asistencia", "/ControlAsistencia/public/assets/img/banner2.jpg"],
                ["Ingreso Seguro", "y Rápido con Tecnología de Escaneo", "Sistema de Control de Ingreso", "/ControlAsistencia/public/assets/img/banner3.jpg"]
            ];
            foreach ($slides as $index => $slide) {
                $active = $index === 0 ? "active" : "";
                echo "
                    <div class='carousel-item $active'>
                        <div class='container'>
                            <div class='carousel-caption'>
                                <div class='text-bg'>
                                    <h1><span class='blu'>{$slide[0]} <br></span> {$slide[1]}</h1>
                                    <figure><img src='{$slide[3]}' class='img-fluid' alt='{$slide[2]}'/></figure>
                                </div>
                            </div>
                        </div>
                    </div>";
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#banner1" role="button" data-bs-slide="prev">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </a>
        <a class="carousel-control-next" href="#banner1" role="button" data-bs-slide="next">
            <i class="fa fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</section>
<section class="page-section" id="services">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Nuestros Servicios</h2>
            <h3 class="section-subheading text-muted">Facilitamos el control de ingreso y asistencia en SENA Villeta.</h3>
        </div>
        <div class="row text-center">
            <?php
            $services = [
                ["fas fa-qrcode", "Registro Automatizado", "Escanea tu carné para registrar tu ingreso y salida de manera rápida y segura.", "/ControlAsistencia/public/assets/img/carnet.jpg"],
                ["fas fa-users", "Acceso para Visitantes", "Registra tu visita indicando el motivo y tus datos personales de manera sencilla.", "/ControlAsistencia/public/assets/img/visitantes.jpg"],
                ["fas fa-lock", "Seguridad y Control", "Garantizamos un control de acceso eficiente para la seguridad de todos.", "/ControlAsistencia/public/assets/img/seguridad.jpg"]
            ];
            foreach ($services as $service) {
                echo "
                    <div class='col-md-4'>
                        <img src='{$service[3]}' alt='{$service[1]}' class='img-fluid mb-3 service-image'/>
                        <span class='fa-stack fa-4x'>
                            <i class='fas fa-circle fa-stack-2x text-primary'></i>
                            <i class='{$service[0]} fa-stack-1x fa-inverse'></i>
                        </span>
                        <h4 class='my-3'>{$service[1]}</h4>
                        <p class='text-muted'>{$service[2]}</p>
                    </div>";
            }
            ?>
        </div>
    </div>
</section>

<aside class="text-center bg-gradient-primary-to-secondary">
    <div class="container px-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-xl-8">
                <div class="h2 fs-1 text-white mb-4">"Un sistema intuitivo que optimiza el control de asistencia en el SENA Villeta"</div>
                <img src="/ControlAsistencia/public/assets/img/sena1.jpg" alt="" style="height: 3rem" />
            </div>
        </div>
    </div>
</aside>

<section id="features">
    <div class="container px-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-8 order-lg-1 mb-5 mb-lg-0">
                <div class="container-fluid px-5">
                    <div class="row gx-5">
                        <?php
                        $features = [
                            ["bi-clock", "Registro en Tiempo Real", "Cada ingreso y salida se registra con fecha y hora exactas."],
                            ["bi-file-text", "Historial de Asistencia", "Consulta registros anteriores para un mejor control."],
                            ["bi-shield-lock", "Protección de Datos", "Garantizamos la confidencialidad de la información."],
                            ["bi-speedometer", "Interfaz Ágil", "Diseño optimizado para una experiencia fluida y eficiente."]
                        ];
                        foreach ($features as $feature) {
                            echo "
                                <div class='col-md-6 mb-5'>
                                    <div class='text-center'>
                                        <i class='{$feature[0]} icon-feature text-gradient d-block mb-3'></i>
                                        <h3 class='font-alt'>{$feature[1]}</h3>
                                        <p class='text-muted mb-0'>{$feature[2]}</p>
                                    </div>
                                </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>
<style>
    .service-image {
        max-height: 150px; /* Ajusta la altura máxima según sea necesario */
        width: auto; /* Mantiene la proporción de la imagen */
        display: block; /* Asegura que la imagen se comporte como un bloque */
        margin: 0 auto; /* Centra la imagen horizontalmente */
    }
    .carousel-item img {
        width: 100%; /* Asegura que la imagen ocupe todo el ancho del contenedor */
        height: auto; /* Mantiene la proporción de la imagen */
        display: block; /* Asegura que la imagen se comporte como un bloque */
    }
</style>