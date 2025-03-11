<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
<link rel="stylesheet" href="assest/css/registro_personal.css">

<!-- Mostrar mensajes de éxito o error -->
<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="mensaje <?php echo $_SESSION['tipo_mensaje']; ?>">
        <?php echo $_SESSION['mensaje']; ?>
    </div>
    <?php
    // Limpiar el mensaje después de mostrarlo
    unset($_SESSION['mensaje']);
    unset($_SESSION['tipo_mensaje']);
    ?>
<?php endif; ?>

<form action="registrar_personal" method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="apellido" placeholder="Apellido" required>
    <input type="text" name="numero_identidad" placeholder="Número de Identidad" required>
    <input type="text" name="telefono" placeholder="Teléfono" required>
    <select name="rol" id="rol" required onchange="mostrarCamposAdicionales()">
        <option value="">Seleccione un rol</option>
        <option value="Funcionario">Funcionario</option>
        <option value="Instructor">Instructor</option>
        <option value="Directiva">Directiva</option> 
        <option value="Apoyo">Apoyo</option>
    </select>

    <!-- Campos adicionales dinámicos -->
    <div id="camposAdicionales">
        <!-- Aquí se mostrarán los campos según el rol seleccionado -->
    </div>

    <button type="submit">Registrar</button>
</form>

<script>
function mostrarCamposAdicionales() {
    const rol = document.getElementById('rol').value;
    let campos = '';

    switch (rol) {
        case 'Funcionario':
            campos = `
                <input type="text" name="area" placeholder="Área" required>
                <input type="text" name="puesto" placeholder="Puesto" required>
            `;
            break;
        case 'Instructor':
            campos = `
                <input type="text" name="curso" placeholder="Curso" required>
                <input type="text" name="ubicacion" placeholder="Ubicación" required>
            `;
            break;
        case 'Directiva': 
            campos = `
                <input type="text" name="cargo" placeholder="Cargo" required>
                <input type="text" name="departamento" placeholder="Departamento" required>
            `;
            break;
        case 'Apoyo':
            campos = `
                <input type="text" name="area_trabajo" placeholder="Área de Trabajo" required>
            `;
            break;
        default:
            campos = ''; // No mostrar campos adicionales si no se selecciona un rol válido
    }

    document.getElementById('camposAdicionales').innerHTML = campos;
}
</script>