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
                <div class="cssload-container"><span></span><span></span><span></span><span></span></div>
            </div>
        </div>
        <div class="page">
            <div id="home">
            <!-- banner -->
            <section class="banner_main mb-5">
                <div id="banner1" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#banner1" data-slide-to="0" class="active"></li>
                        <li data-target="#banner1" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="container">
                                <div class="carousel-caption">
                                    <div class="text-bg">
                                        <h1><span class="blu">Contacto <br></span> SENA Villeta</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="container">
                                <div class="carousel-caption">
                                    <div class="text-bg">
                                        <h1><span class="blu">Ubicación <br></span> y Medios de Contacto</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <!-- end banner -->

        <!-- Contact Section -->
        <div class="contact-section py-5">
            <div class="container">
                <div class="row">
                    <!-- Información de contacto y formulario -->
                    <div class="col-lg-6 mb-4">
                        <div class="contact-info p-4 border border-success rounded shadow-sm">
                            <h2 class="text-success text-center">Información de Contacto</h2>
                            <div class="contact-map border border-success rounded overflow-hidden mb-3">
                                <iframe class="w-100" style="border:0; height: 250px;" loading="lazy"
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3978.591726946253!2d-74.4775839852394!3d5.008446996008055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e40a68a2c5b8a7b%3A0x1a1a1c8b5b36f4b6!2sSENA%20Villeta!5e0!3m2!1ses!2sco!4v1634702729479!5m2!1ses!2sco">
                                </iframe>
                            </div>
                            <p><strong>Dirección:</strong> Calle 6 # 7-49, Villeta, Cundinamarca, Colombia</p>
                            <p><strong>Teléfono:</strong> +57 1 5461500 Ext. 1234</p>
                            <p><strong>Correo Electrónico:</strong> sena.villeta@misena.edu.co</p>
                            <p><strong>Horario de Atención:</strong> Lunes a Viernes, 8:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                    
                    <!-- Formulario de contacto -->
                    <div class="col-lg-6 mb-4">
                        <div class="contact-form p-4 border border-success rounded shadow-sm">
                            <h2 class="text-success text-center">Formulario de Contacto</h2>
                            <form action="/ControlAsistencia/public/forms/contact_form.php" method="POST">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo Electrónico:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="mensaje">Mensaje:</label>
                                    <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success px-4">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contact Section -->

        <!-- Estilos adicionales -->
        <style>
                .contact-section {
                        background-color: #f8f9fa;
                }
                .contact-info, .contact-form {
                        background-color: #fff;
                        height: 100%;
                }
        </style>

                <!-- Global Mailform Output-->
                <div class="snackbars" id="form-output-global"></div>
                <!-- Javascript-->
                <script src="/ControlAsistencia/public/assets/js/core.min.js"></script>
                <script src="/ControlAsistencia/public/assets/js/script.js"></script>
                <!-- coded by Himic-->
            </body>
        </html>

<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>