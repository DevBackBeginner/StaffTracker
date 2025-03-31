<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
    <link href="assets/css/listado_usuarios.css" rel="stylesheet">

    <div class="pagetitle">
        <h1>Listado de Personal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item">Gestion de Personal</li>
                <li class="breadcrumb-item active">Listado de Personal</li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid">
        <section class="section register py-1">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body p-4">
                            <form method="GET" action="" class="row g-3">
                                <div class="col-md-4">
                                    <label for="nombre" class="form-label fw-bold" style="color: #007832;">Nombres</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="<?= htmlspecialchars($nombre) ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="documento" class="form-label fw-bold" style="color: #007832;">Número de Identificación</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" name="documento" id="documento" class="form-control" placeholder="Documento" value="<?= htmlspecialchars($documento) ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="rol" class="form-label fw-bold" style="color: #007832;">Rol</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                        <select name="rol" id="rol" class="form-select">
                                            <option value="">Todos los roles</option>
                                            <option value="Instructor" <?= $rol === 'Instructor' ? 'selected' : '' ?>>Instructores</option>
                                            <option value="Funcionario" <?= $rol === 'Funcionario' ? 'selected' : '' ?>>Funcionarios</option>
                                            <option value="Directivo" <?= $rol === 'Directivo' ? 'selected' : '' ?>>Directivos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="background-color: #007832; border-color: #007832;">
                                        <i class="bi bi-check-circle me-2"></i> Filtrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php if (isset($_SESSION['mensaje'])): ?>
                    <script>
                        Swal.fire({
                            title: '<?= ($_SESSION['tipo_mensaje'] === 'success') ? 'Éxito' : 'Error' ?>',
                            text: "<?= addslashes($_SESSION['mensaje']) ?>",
                            icon: '<?= $_SESSION['tipo_mensaje'] ?>',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#007832'
                        });
                    </script>
                    <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
                <?php endif; ?>
                <div class="col-12">
                    <div class="card shadow-lg mb-2">
                        <div class="card-header  text-center text-white" style="background-color: green;">
                            <h5 class="mb-0">Listado de Visitantes</h5>
                        </div>
                       
                        <div class="card-body p-4" style="background-color:rgb(255, 255, 255);">
                            <table class="table table-striped table-hover text-center mb-2">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Tipo Doc.</th>
                                        <th>Identificación</th>
                                        <th>Teléfono</th>
                                        <th>Rol</th>
                                        <th>Cargo</th>
                                        <th>Tipo Contrato</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $contador = $contadorInicial; ?>

                                    <?php foreach ($usuarios as $us): ?>
                                        <tr>
                                            <td><?= $contador++ ?></td> <!-- Contador secuencial -->

                                            <td><?= htmlspecialchars($us['nombre']) ?></td>
                                            <td><?= htmlspecialchars($us['apellido']) ?></td>
                                            <td data-tipo-documento="<?= htmlspecialchars($us['tipo_documento']) ?>">
                                                <?= 
                                                    match($us['tipo_documento']) {
                                                        'CC' => 'Cédula de Ciudadanía',
                                                        'CE' => 'Cédula de Extranjería',
                                                        'TI' => 'Tarjeta de Identidad',
                                                        'PASAPORTE' => 'Pasaporte',
                                                        'NIT' => 'Identificación Tributaria',
                                                        default => htmlspecialchars($us['tipo_documento']) // Por si hay algún valor no esperado
                                                    }
                                                ?>
                                            </td>
                                            <td><?= htmlspecialchars($us['numero_documento']) ?></td>
                                            <td><?= htmlspecialchars($us['telefono']) ?></td>
                                            <td><?= htmlspecialchars($us['rol']) ?></td>
                                            <td><?= !empty($us['cargo']) ? htmlspecialchars($us['cargo']) : '<span class="text-muted">---</span>' ?></td>
                                            <td><?= !empty($us['tipo_contrato']) ? htmlspecialchars($us['tipo_contrato']) : '<span class="text-muted">---</span>' ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Botón Editar -->
                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal" data-id="<?= $us['id_persona'] ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    
                                                    <!-- Botón Eliminar -->
                                                    <form method="POST" action="EliminarPersonal" class="d-inline">
                                                        <input type="hidden" name="id" value="<?= $us['id_persona'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            
                            <!-- Paginación -->
                            <div class="mt-2">
                                <nav aria-label="Paginación">
                                    <ul class="pagination justify-content-center mb-0">
                                        <?php if ($pagina > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" 
                                                    href="?rol=<?= urlencode($rol) ?>&nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&orden=<?= urlencode($orden) ?>&direccion=<?= urlencode($direccion) ?>&pagina=<?= $pagina - 1 ?>" 
                                                    aria-label="Anterior"
                                                    style="color: #007832;">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item disabled">
                                                <span class="page-link" aria-hidden="true" style="color: #6c757d;">&laquo;</span>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                            <li class="page-item <?= ($i === $pagina) ? 'active' : '' ?>">
                                                <a class="page-link" 
                                                    href="?rol=<?= urlencode($rol) ?>&nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&orden=<?= urlencode($orden) ?>&direccion=<?= urlencode($direccion) ?>&pagina=<?= $i ?>"
                                                    style="<?= ($i === $pagina) ? 'background-color: #007832; border-color: #007832; color: white;' : 'color: #007832;' ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($pagina < $totalPaginas): ?>
                                            <li class="page-item">
                                                <a class="page-link" 
                                                    href="?rol=<?= urlencode($rol) ?>&nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&orden=<?= urlencode($orden) ?>&direccion=<?= urlencode($direccion) ?>&pagina=<?= $pagina + 1 ?>" 
                                                    aria-label="Siguiente"
                                                    style="color: #007832;">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item disabled">
                                                <span class="page-link" aria-hidden="true" style="color: #6c757d;">&raquo;</span>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>                       
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include_once "modal-editar.php" ?>

    <script src="assets/js/modal-editar-personal.js"></script>


<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>