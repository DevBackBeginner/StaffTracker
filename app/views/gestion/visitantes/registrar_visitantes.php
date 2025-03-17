<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
    <link rel="stylesheet" href="assest/css/registro_visitante.css">

    <!-- Mostrar mensajes de éxito o error -->
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert <?php echo ($_SESSION['tipo_mensaje'] === 'success') ? 'alert-success' : 'alert-danger'; ?> text-center">
            <?php echo $_SESSION['mensaje']; ?>
        </div>
        <?php
        // Limpiar el mensaje después de mostrarlo
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
        ?>
    <?php endif; ?>
    <div class="pagetitle">
        <h1>Formulario de Registro Visitantes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                <li class="breadcrumb-item"><a href="panel">Registro Visitantes</a></li>
            </ol>
        </nav>
    </div>
    <div class="login-container">
        <form action="registrar_visitante" method="POST" class="container mt-4 p-4 border rounded shadow-sm bg-light" onsubmit="return validarFormulario()">
            <!-- Campos comunes -->
            <div class="mb-3">
                <label for="nombre" class="form-label" style="color: #007832;">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label" style="color: #007832;">Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label" style="color: #007832;">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required>
            </div>
            <div class="mb-3">
                <label for="numero_identidad" class="form-label" style="color: #007832;">Número de Identidad</label>
                <input type="text" name="numero_identidad" id="numero_identidad" class="form-control" placeholder="Número de Identidad" required>
            </div>
            <div class="mb-3">
                <label for="asunto" class="form-label" style="color: #007832;">Asunto</label>
                <input type="text" name="asunto" id="asunto" class="form-control" placeholder="Asunto" required>
            </div>

            <!-- Preguntar si tiene computador -->
            <div class="mb-3">
                <label for="tiene_computador" class="form-label" style="color: #007832;">¿Tiene computador?</label>
                <select name="tiene_computador" id="tiene_computador" class="form-select" onchange="mostrarCamposComputador()" required>
                    <option value="">Seleccione una opción</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <!-- Campos adicionales para computador (se muestran solo si tiene computador) -->
            <div id="camposComputador" class="campos-adicionales mb-3 d-none">
                <div class="mb-3">
                    <input type="hidden" name="tipo_computador" value="Personal"> <!-- Tipo fijo como "Sena" -->
                </div>
                <div class="mb-3">
                    <input type="text" name="marca" class="form-control" placeholder="Marca del computador">
                </div>
                <div class="mb-3">
                    <input type="text" name="codigo" class="form-control" placeholder="Código del computador">
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-custom" style="background-color: #007832; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Registrar</button>
            </div>
        </form>
    </div>
    <script src="assets/js/registro_visitantes.js"></script>

<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>