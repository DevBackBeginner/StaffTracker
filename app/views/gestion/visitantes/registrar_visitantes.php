<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php';?>
    <link rel="stylesheet" href="assest/css/registro_visitante.css">

        <div class="login-container">
            <h2 class="text-center mb-4">Registro de Visitantes</h2>
            <form action="registrar_visitante" method="POST">
                <div class="mb-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="numero_identidad" class="form-control" placeholder="Número de Identidad" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="asunto" class="form-control" placeholder="Asunto" required>
                </div>
                <button type="submit" class="btn btn-custom">Registrar</button>
            </form>
        </div>
    </main>
<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php';?>
