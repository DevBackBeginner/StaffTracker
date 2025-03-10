<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/style.css">
    
    <!-- banner -->
    <section class="banner_main">
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
            
    </section>
    <!-- end banner -->

<!-- Contact Section -->
<div class="contact-section py-5">
    <div class="container">
        <!-- Información de Contacto y Mapa -->
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-info h-100 p-4 border border-success rounded shadow-sm d-flex flex-column justify-content-center">
                    <h2 class="text-success text-center">Información de Contacto</h2>
                    <p><strong>Dirección:</strong> Calle 6 # 7-49, Villeta, Cundinamarca, Colombia</p>
                    <p><strong>Teléfono:</strong> +57 1 5461500 Ext. 1234</p>
                    <p><strong>Correo Electrónico:</strong> sena.villeta@misena.edu.co</p>
                    <p><strong>Horario de Atención:</strong> Lunes a Viernes, 8:00 AM - 5:00 PM</p>
                </div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="contact-map h-100 border border-success rounded overflow-hidden">
                    <iframe class="w-100 h-100" style="border:0;" loading="lazy"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3978.591726946253!2d-74.4775839852394!3d5.008446996008055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e40a68a2c5b8a7b%3A0x1a1a1c8b5b36f4b6!2sSENA%20Villeta!5e0!3m2!1ses!2sco!4v1634702729479!5m2!1ses!2sco">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Formulario de Contacto -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
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
    .contact-info, .contact-map, .contact-form {
        background-color: #fff;
        min-height: 320px; /* Mantiene ambos elementos alineados */
    }
</style>



    <?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>
