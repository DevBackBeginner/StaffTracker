<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>

<link rel="stylesheet" href="assets/css/login.css">

<div class="login-container">
    <div class="login-card">
        <!-- Imagen arriba del título -->
        <div class="login-image" style="max-width: 450px; margin: 0 auto; padding: 20px;">
            <img src="/ControlAsistencia/public/assets/img/logo.png" alt="Login Image" style="width: 100%;">
        </div>
        
        <h2 class="login-title">Iniciar Sesión</h2>

        <!-- Mostrar mensajes flash utilizando cookies -->
        <?php
        if (isset($_COOKIE['flash_error'])) {
            echo "<p class='error-message'>" . htmlspecialchars($_COOKIE['flash_error']) . "</p>";
        }
        if (isset($_COOKIE['flash_success'])) {
            echo "<p class='success-message'>" . htmlspecialchars($_COOKIE['flash_success']) . "</p>";
        }
        ?>

        <form action="enviarLogin" method="POST">
            <!-- Correo -->
            <div class="input-group">
                <label for="correo" class="input-label" style="font-size: larger; color: #007832;">Correo Electrónico</label>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    required
                    class="custom-input"
                    placeholder="Ingrese su correo"
                />
            </div>

            <!-- Contraseña -->
            <div class="input-group">
                <label for="password" class="input-label" style="font-size: larger; color: #007832;">Contraseña</label>
                <div class="input-password-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="custom-input"
                        placeholder="Ingrese su contraseña"
                    />
                    <!-- Botón para mostrar/ocultar contraseña -->
                    <button type="button" onclick="togglePassword()" class="show-hide-button">
                        <svg id="icon-show" xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="icon-hide" xmlns="http://www.w3.org/2000/svg" class="icon d-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.056 10.056 0 013.482-4.618M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.94 17.94l-3.829-3.829M5.182 5.182l3.829 3.829" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Botón de enviar -->
            <button type="submit" class="submit-button">
                Iniciar Sesión
            </button>
        </form>
    </div>
</div>
<script src="assets/js/login.js"></script>
<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>

