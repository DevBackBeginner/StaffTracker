<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>

<!-- Contacto -->
<section class="contact_section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="contact_info">
                    <h2>Contáctanos</h2>
                    <p>Si tienes alguna duda o necesitas más información, no dudes en escribirnos o visitarnos en nuestra sede.</p>
                    <ul>
                        <li><i class="fa fa-map-marker"></i> SENA - Villeta, Cundinamarca, Colombia</li>
                        <li><i class="fa fa-phone"></i> +57 123 456 7890</li>
                        <li><i class="fa fa-envelope"></i> contacto@senavilleta.edu.co</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact_form">
                    <h2>Envíanos un mensaje</h2>
                    <form action="#" method="post">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" class="form-control" placeholder="Mensaje" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mapa -->
<section class="map_section">
    <div class="container">
        <h2>Ubicación</h2>
        <div class="map_container">
            <iframe src="https://www.google.com/maps/embed?..." width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>
