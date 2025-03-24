<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="login-container">
    <div class="login-card">
        <h2 class="login-title">Recuperar Contraseña</h2>

        <!-- Mostrar mensajes flash utilizando cookies -->
        <?php
        if (isset($_COOKIE['flash_error'])) {
            echo "<p class='error-message'>" . htmlspecialchars($_COOKIE['flash_error']) . "</p>";
        }
        if (isset($_COOKIE['flash_success'])) {
            echo "<p class='success-message'>" . htmlspecialchars($_COOKIE['flash_success']) . "</p>";
        }
        ?>

        <form action="procesar-recuperar-contrasena" method="POST">
            <div class="input-group">
                <label for="correo" class="input-label">Correo Electrónico</label>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    required
                    class="custom-input"
                    placeholder="Ingrese su correo"
                />
            </div>

            <button type="submit" class="submit-button">
                Enviar Enlace de Recuperación
            </button>
        </form>

        <!-- Enlace para volver al inicio de sesión -->
        <div class="back-to-login-link">
            <a href="login">Volver al Inicio de Sesión</a>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>