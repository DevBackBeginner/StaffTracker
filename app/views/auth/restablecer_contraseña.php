<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>
<!-- Vincula el archivo de estilos -->
<link rel="stylesheet" href="assets/css/recuperacion.css">
<title>StaffTracker</title>
<div class="login-container">
    <div class="login-card">
        <!-- Contenedor circular para el logo -->
        <div class="login-image-container">
            <img src="assets/img/logo.png" alt="Logo" class="login-image">
        </div>

        <h1 class="login-title">Restablecer Contraseña</h1>

        <!-- Mostrar mensajes de error o éxito -->
        <?php if (isset($_COOKIE['flash_error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_COOKIE['flash_error']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_COOKIE['flash_success'])): ?>
            <div class="error-message" style="background-color: #4CAF50;">
                <?php echo htmlspecialchars($_COOKIE['flash_success']); ?>
            </div>
        <?php endif; ?>

        <form action="procesar-restablecer-contrasena" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">

            <div class="input-group">
                <label for="password" class="input-label">Nueva Contraseña:</label>
                <input type="password" id="password" name="password" class="custom-input" required>
            </div>

            <button type="submit" class="submit-button">Restablecer Contraseña</button>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>
