<?php
// Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>

<!-- Incluir Chart.js y el plugin de anotaciones -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@2.0.1/dist/chartjs-plugin-annotation.min.js"></script>

<div class="pagetitle">
    <h1>Reporte Gráficos</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Reporte Gráficos</li>
        </ol>
    </nav>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Tarjeta para el gráfico de roles -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div style="height: 250px;"> <!-- Contenedor con altura fija (aumentado a 250px) -->
                        <canvas id="graficoRoles"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta para el gráfico de personal SENA vs. visitantes -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div style="height: 250px;"> <!-- Contenedor con altura fija (aumentado a 250px) -->
                        <canvas id="graficoSenaVisitantes"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Gráfico de Ingreso por Hora con 5 Roles -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Ingresos por Hora</h5>
                    <canvas id="graficoIngreso"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Convertir datos de PHP a JavaScript
    const ingresosPorHora = <?php echo json_encode($ingresosPorHora, JSON_NUMERIC_CHECK); ?>;
    const totalUsuarios = <?php echo $totalUsuarios; ?>; // Total de usuarios
</script>

<script src="assets/js/reports_graficos.js"></script>


<?php
// Incluimos el footer que contiene la estructura HTML final
include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>
