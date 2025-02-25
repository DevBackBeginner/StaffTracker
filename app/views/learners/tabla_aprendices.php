
<!-- Tabla de asistencia -->
<?php if (!empty($aprendicesPorFicha)): ?>
    <?php foreach ($aprendicesPorFicha as $ficha => $aprendices): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header text-black">
                <h2 class="h5 mb-0">Ficha: <?= htmlspecialchars($ficha); ?></h2>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>Nombre</th>
                                <th>Identificación</th>
                                <th>Turno</th>
                                <th>Hora de Entrada</th>
                                <th>Hora de Salida</th>
                                <th>Entrada Computador</th>
                                <th>Salida Computador</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aprendices as $index => $aprendiz): ?>
                                <tr class="text-center">
                                    <td><?= htmlspecialchars($aprendiz['nombre']) ?></td>
                                    <td><?= htmlspecialchars($aprendiz['numero_identidad']) ?></td>
                                    <td><?= htmlspecialchars($aprendiz['turno']) ?></td>
                                    <td><?= htmlspecialchars($aprendiz['hora_entrada'] ?? 'Sin registro') ?></td>
                                    <td><?= htmlspecialchars($aprendiz['hora_salida'] ?? 'Sin registro') ?></td>
                                    <td><?= htmlspecialchars($aprendiz['entrada_computador'] ?? 'No') ?></td>
                                    <td><?= htmlspecialchars($aprendiz['salida_computador'] ?? 'No') ?></td>
                                    <td>
                                        <?php if (empty($aprendiz['hora_entrada'])): ?>
                                            <button type="button" class="btn btn-success btn-sm">Registrar Entrada</button>
                                        <?php elseif (empty($aprendiz['hora_salida'])): ?>
                                            <button type="button" class="btn btn-dark btn-sm">Registrar Salida</button>
                                        <?php else: ?>
                                            <span class="badge badge-pill badge-success">Asistencia Completa</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Controles de paginación -->
    <?php if ($totalPaginas > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($pagina > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="<?= $pagina - 1 ?>">Anterior</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                        <a class="page-link" href="#" data-page="<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagina < $totalPaginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="<?= $pagina + 1 ?>">Siguiente</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>

<?php else: ?>
    <p class="text-center no-resultados">No se encontraron resultados.</p>
<?php endif; ?>
