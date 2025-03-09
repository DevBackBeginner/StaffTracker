<?php
// Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>
<!-- Enlace al archivo CSS específico para el panel -->
<link rel="stylesheet" href="assets/css/registro_ingreso.css">
<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap" rel="stylesheet">
<?php
// Inicializar las variables con valores por defecto
$tipo = $_SESSION['mensaje']['tipo'] ?? 'info'; // Valor por defecto: 'info'
$texto = $_SESSION['mensaje']['texto'] ?? '';  // Valor por defecto: cadena vacía
$alertClass = 'info'; // Clase de alerta por defecto

// Asignar la clase de alerta según el tipo de mensaje
switch ($tipo) {
    case 'danger':
        $alertClass = 'danger';
        break;
    case 'warning':
        $alertClass = 'warning';
        break;
    case 'salida':
        $alertClass = 'success';
        break;
    case 'entrada':
        $alertClass = 'success';
        break;
    default:
        $alertClass = 'info';
        break;
}
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Registro Ingresos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                <li class="breadcrumb-item active">Registrar Ingresos</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <!-- Contenedor principal -->
    <div class="row">
        <!-- Fila para el formulario de registro -->
        <div class="col-12"> <!-- Ocupa el 100% del ancho -->
            <div class="card mb-4 shadow-sm custom-card">
                <div class="card-header bg-custom text-white">
                    <h2 class="h5 mb-0">Registrar Asistencia</h2>
                </div>
                <div class="card-body">
                    <form id="form-escaneo" method="POST">
                        <div class="mt-2">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" id="codigo" name="codigo" placeholder="Escanea el código aquí" class="form-control" autofocus>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Fila para la tabla de últimos registros -->
        <div class="col-12"> <!-- Ocupa el 100% del ancho -->
            <div class="card shadow-sm custom-card">
                <div class="card-header bg-custom text-white">
                    <h2 class="h5 mb-0">Últimos Registros de Ingreso</h2>
                </div>
                <div class="card-body">
                    <?php include_once "tabla_ultimos_registros.php"; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->

<!-- Modal para preguntar si tiene computador -->
<div class="modal fade" id="modalTieneComputador" tabindex="-1" aria-labelledby="modalTieneComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTieneComputadorLabel">Registro de Asistencia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">¿Tienes computador?</p>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success" id="btnSiComputador">Sí</button>
                    <button type="button" class="btn btn-danger" id="btnNoComputador">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para preguntar si el computador es Personal o del Sena -->
<div class="modal fade" id="modalTipoComputador" tabindex="-1" aria-labelledby="modalTipoComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTipoComputadorLabel">Tipo de Computador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">¿El computador es Personal o del Sena?</p>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" id="btnPersonal">Personal</button>
                    <button type="button" class="btn btn-info" id="btnSena">Sena</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seleccionar el computador -->
<div class="modal fade" id="modalSeleccionarComputador" tabindex="-1" aria-labelledby="modalSeleccionarComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalSeleccionarComputadorLabel">Seleccionar Computador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Selecciona un computador:</p>
                <select id="selectComputadores" class="form-select mb-3"></select>
                <div class="d-grid">
                    <button type="button" class="btn btn-success" id="btnConfirmarPC">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<?php
// Incluimos el footer que contiene la estructura HTML final
include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>
<script>
 document.addEventListener('DOMContentLoaded', function () {
    const modalTieneComputador = new bootstrap.Modal(document.getElementById('modalTieneComputador'));
    const modalTipoComputador = new bootstrap.Modal(document.getElementById('modalTipoComputador'));
    const modalSeleccionarComputador = new bootstrap.Modal(document.getElementById('modalSeleccionarComputador'));
    const selectComputadores = document.getElementById('selectComputadores');
    const btnSiComputador = document.getElementById('btnSiComputador');
    const btnNoComputador = document.getElementById('btnNoComputador');
    const btnPersonal = document.getElementById('btnPersonal');
    const btnSena = document.getElementById('btnSena');
    const btnConfirmarPC = document.getElementById('btnConfirmarPC');

    let codigoEscaneado = ''; // Almacena el código escaneado
    let tipoComputador = null; // Almacena si el computador es Personal o del Sena

    // Escuchar el evento 'input' en el campo de "Código"
    document.getElementById('codigo').addEventListener('input', function (event) {
        codigoEscaneado = this.value.trim(); // Asignar el valor escaneado
        console.log("Código escaneado:", codigoEscaneado); // Depuración
        if (codigoEscaneado.length > 0 && /^[a-zA-Z0-9]+$/.test(codigoEscaneado)) {
            modalTieneComputador.show(); // Muestra el modal para preguntar si tiene computador
        }
    });

    // Manejar la selección de "Sí" o "No" en el primer modal
    btnSiComputador.addEventListener('click', () => {
        modalTieneComputador.hide(); // Ocultar el primer modal
        modalTipoComputador.show(); // Mostrar el modal para preguntar el tipo de computador
    });

    btnNoComputador.addEventListener('click', () => {
        // Registrar asistencia sin computador (computador_id = null)
        registrarAsistencia(null);
        modalTieneComputador.hide();
    });

    // Manejar la selección de "Personal" o "Sena" en el segundo modal
    btnPersonal.addEventListener('click', () => {
        if (!codigoEscaneado) {
            alert('Por favor, escanea un código válido.');
            return;
        }
        tipoComputador = 'Personal';
        modalTipoComputador.hide(); // Ocultar el modal de tipo de computador
        cargarComputadores(tipoComputador, codigoEscaneado); // Cargar computadores personales
        modalSeleccionarComputador.show(); // Mostrar el modal para seleccionar computador
    });

    btnSena.addEventListener('click', () => {
        if (!codigoEscaneado) {
            alert('Por favor, escanea un código válido.');
            return;
        }
        tipoComputador = 'Sena';
        modalTipoComputador.hide(); // Ocultar el modal de tipo de computador
        cargarComputadores(tipoComputador, codigoEscaneado); // Cargar computadores del Sena
        modalSeleccionarComputador.show(); // Mostrar el modal para seleccionar computador
    });

    // Manejar la confirmación del computador en el tercer modal
    btnConfirmarPC.addEventListener('click', () => {
        const computadorId = selectComputadores.value;
        if (computadorId) {
            registrarAsistencia(computadorId);
            modalSeleccionarComputador.hide();
        } else {
            alert('Por favor, selecciona un computador.');
        }
    });

    // Función para cargar los computadores disponibles
    function cargarComputadores(tipoComputador, codigo) {
        // Mostrar los datos que se están enviando
        console.log("Dato enviado (tipoComputador):", tipoComputador);
        console.log("Dato enviado (codigo):", codigo);

        // Realizar la solicitud fetch
        fetch("obtener_computadores", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "tipoComputador=" + encodeURIComponent(tipoComputador) + 
                  "&codigo=" + encodeURIComponent(codigo) // Agregar el código al cuerpo de la solicitud
        })
        .then(response => {
            console.log("Respuesta del servidor (computadores):", response); // Depura la respuesta
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log("Datos recibidos (computadores):", data); // Depura los datos recibidos
            const selectComputadores = document.getElementById("selectComputadores");
            selectComputadores.innerHTML = ""; // Limpiar el select

            if (Array.isArray(data) && data.length > 0) {
                data.forEach(pc => {
                    let option = document.createElement("option");
                    option.value = pc.id;
                    option.textContent = pc.marca + " - " + pc.codigo;
                    selectComputadores.appendChild(option);
                });
            } else {
                let option = document.createElement("option");
                option.value = "";
                option.textContent = "No hay computadores disponibles";
                selectComputadores.appendChild(option);
            }
        })
        .catch(error => {
            console.error("Error al cargar computadores:", error); // Depura el error
            alert('Error al cargar los computadores. Inténtalo más tarde.');
        });
    }

    // Función para registrar la asistencia
    function registrarAsistencia(computadorId) {
        const formData = new FormData();
        formData.append('codigo', codigoEscaneado); // Enviar el código escaneado
        if (computadorId) {
            formData.append('computador_id', computadorId); // Enviar el computador_id (puede ser null)
        }

        fetch('registrar_ingreso', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log("Respuesta del servidor:", response); // Depura la respuesta
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.json(); // Parsea la respuesta como JSON
        })
        .then(data => {
            console.log("Datos recibidos:", data); // Depura los datos recibidos
            if (data.success) {
                alert(data.message); // Mostrar mensaje de éxito
                document.getElementById('codigo').value = ''; // Limpiar el campo de código
            } else {
                alert(data.message); // Mostrar mensaje de error
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error); // Depura el error
            alert('Error en el sistema. Inténtalo más tarde.');
        });
    }
});
</script>