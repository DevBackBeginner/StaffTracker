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

    <form action="registrar_personal" method="POST" class="container mt-4">
        <div class="mb-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="mb-3">
            <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
        </div>
        <div class="mb-3">
            <input type="text" name="numero_identidad" class="form-control" placeholder="Número de Identidad" required>
        </div>
        <div class="mb-3">
            <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
        </div>
        <div class="mb-3">
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
            <input type="text" name="area" class="form-control" placeholder="Área" required>
            <input type="text" name="puesto" class="form-control mt-2" placeholder="Puesto" required>
        </div>
        <div id="camposInstructor" class="campos-adicionales mb-3 d-none">
            <input type="text" name="curso" class="form-control" placeholder="Curso" required>
            <input type="text" name="ubicacion" class="form-control mt-2" placeholder="Ubicación" required>
        </div>
        <div id="camposDirectiva" class="campos-adicionales mb-3 d-none">
            <input type="text" name="cargo" class="form-control" placeholder="Cargo" required>
            <input type="text" name="departamento" class="form-control mt-2" placeholder="Departamento" required>
        </div>
        <div id="camposApoyo" class="campos-adicionales mb-3 d-none">
            <input type="text" name="area_trabajo" class="form-control" placeholder="Área de Trabajo" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</main>
<script>
function mostrarCamposAdicionales() {
    const rol = document.getElementById('rol').value;
    // Ocultar todos los campos adicionales
    document.querySelectorAll('.campos-adicionales').forEach(function(campo) {
        campo.classList.add('d-none');
    });

    // Mostrar los campos correspondientes al rol seleccionado
    if (rol === 'Funcionario') {
        document.getElementById('camposFuncionario').classList.remove('d-none');
    } else if (rol === 'Instructor') {
        document.getElementById('camposInstructor').classList.remove('d-none');
    } else if (rol === 'Directiva') {
        document.getElementById('camposDirectiva').classList.remove('d-none');
    } else if (rol === 'Apoyo') {
        document.getElementById('camposApoyo').classList.remove('d-none');
    }
}
</script>

<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>