<?php include_once __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="container">
    <h1>Restablecer Contraseña</h1>
    <?php if (isset($_COOKIE['flash_error'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_COOKIE['flash_error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_COOKIE['flash_success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_COOKIE['flash_success']); ?>
        </div>
    <?php endif; ?>
    <form action="procesar-restablecer-contraseña" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">
        <div class="form-group">
            <label for="password">Nueva Contraseña:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Restablecer Contraseña</button>
    </form>
</div>

<?php include_once __DIR__ . '/../../views/layouts/footer.php'; ?>