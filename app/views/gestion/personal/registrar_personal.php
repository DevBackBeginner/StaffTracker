<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
    <!-- Mostrar mensajes de éxito o error -->
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert <?php echo $_SESSION['tipo_mensaje'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $_SESSION['mensaje']; ?>
        </div>
        <?php
        // Limpiar el mensaje después de mostrarlo
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
    ?>
    <?php endif; ?>
    <div class="pagetitle">
        <h1>Registro de Personal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                <li class="breadcrumb-item active">Registro de Personal</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <form action="registrar_personal" method="POST" class="container mt-4 p-4 border rounded shadow-sm bg-light" onsubmit="return validarFormulario()">
        <!-- Campos comunes -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" required>
        </div>
        <div class="mb-3">
            <label for="numero_identidad" class="form-label">Número de Identidad</label>
            <input type="text" name="numero_identidad" id="numero_identidad" class="form-control" placeholder="Número de Identidad" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required>
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-select" required onchange="mostrarCamposAdicionales()">
                <option value="">Seleccione un rol</option>
                <option value="Funcionario">Funcionario</option>
                <option value="Instructor">Instructor</option>
                <option value="Directiva">Directiva</option>
                <option value="Apoyo">Apoyo</option>
            </select>
        </div>

        <!-- Campos adicionales para cada rol -->
        <div id="camposFuncionario" class="campos-adicionales mb-3 d-none">
            <input type="text" name="area" class="form-control" placeholder="Área">
            <input type="text" name="puesto" class="form-control mt-2" placeholder="Puesto">
        </div>
        <div id="camposInstructor" class="campos-adicionales mb-3 d-none">
            <input type="text" name="curso" class="form-control" placeholder="Curso">
            <input type="text" name="ubicacion" class="form-control mt-2" placeholder="Ubicación">
        </div>
        <div id="camposDirectiva" class="campos-adicionales mb-3 d-none">
            <input type="text" name="cargo" class="form-control" placeholder="Cargo">
            <input type="text" name="departamento" class="form-control mt-2" placeholder="Departamento">
        </div>
        <div id="camposApoyo" class="campos-adicionales mb-3 d-none">
            <input type="text" name="area_trabajo" class="form-control" placeholder="Área de Trabajo">
        </div>

        <!-- Preguntar si tiene computador -->
        <div class="mb-3">
            <label for="tiene_computador">¿Tiene computador?</label>
            <select name="tiene_computador" id="tiene_computador" class="form-select" onchange="mostrarCamposComputador()" required>
                <option value="">Seleccione una opción</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>

        <!-- Campos adicionales para computador (se muestran solo si tiene computador) -->
        <div id="camposComputador" class="campos-adicionales mb-3 d-none">
            <div class="mb-3">
                <label for="tipo_computador">Tipo de computador</label>
                <select name="tipo_computador" id="tipo_computador" class="form-select">
                    <option value="">Seleccione un tipo</option>
                    <option value="Sena">Sena</option>
                    <option value="Personal">Personal</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="text" name="marca" class="form-control" placeholder="Marca del computador">
            </div>
            <div class="mb-3">
                <input type="text" name="codigo" class="form-control" placeholder="Código del computador">
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary" style="background-color: #007832; border-color: #007832;">Registrar</button>
        </div>
    </form>
    <script src="assets/js/registro_personal.js"></script>

<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>