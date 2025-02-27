<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>

<!-- banner -->
<section class="banner_main">
    <div id="banner1" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#banner1" data-slide-to="0" class="active"></li>
            <li data-target="#banner1" data-slide-to="1"></li>
            <li data-target="#banner1" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container">
                    <div class="carousel-caption">
                        <div class="text-bg">
                            <h1><span class="blu">Bienvenido <br></span> al Sistema de Registro de Instructores</h1>
                            <figure><img src="/ControlAssistance/public/assets/img/banner_img.png" alt="Registro Biométrico"/></figure>
                            <a class="read_more" href="#">Ingresar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end banner -->

<!-- about section -->
<div class="about_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="about_content">
                    <h2>Sobre el Registro Biométrico</h2>
                    <p>El SENA Villeta ha implementado un avanzado sistema de registro biométrico exclusivo para instructores. Mediante huellas digitales, garantizamos un acceso seguro y un control eficiente del personal académico dentro de nuestras instalaciones.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 text-center">
                <img src="/ControlAssistance/public/assets/img/about_img.png" alt="Registro Biométrico" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="about_section alt">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 order-lg-2">
                <div class="about_content">
                    <h2>Registro con Carnet</h2>
                    <p>Además del registro biométrico, ofrecemos un sistema de acceso con carnet de código de barras para los instructores. Este método permite una verificación rápida y precisa del ingreso y salida del personal.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 order-lg-1 text-center">
                <img src="/ControlAssistance/public/assets/img/about_card.png" alt="Registro con Carnet" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- footer -->
<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>
<!-- end footer -->

<script src="/ControlAssistance/public/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/ControlAssistance/public/assets/js/custom.js"></script>
</body>
</html>
