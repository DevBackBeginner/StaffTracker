<!-- En el <head> -->
<div class="modal fade" id="modalTieneComputador" tabindex="-1" aria-labelledby="modalTieneComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTieneComputadorLabel">Registro de Salida</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>            </div>
            <div class="modal-body">
                <p class="mb-3">¿Salida Computador?</p>
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
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTipoComputadorLabel">Tipo de Computador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">¿El computador es Personal o del Sena?</p>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success" id="btnPersonal">Personal</button>
                    <button type="button" class="btn btn-success" id="btnSena">Equipo Sena</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seleccionar el computador -->
<div class="modal fade" id="modalSeleccionarComputador" tabindex="-1" aria-labelledby="modalSeleccionarComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalSeleccionarComputadorLabel">Seleccionar Computador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Selecciona un computador:</p>
                <select id="selectComputadores" class="form-select mb-3"></select>
                
                <!-- Botón Confirmar -->
                <div class="d-grid mb-3">
                    <button type="button" class="btn btn-success" id="btnConfirmarPC">Confirmar</button>
                </div>
                
                <!-- Contenedor para botones inferiores -->
                <div class="d-flex gap-2">
                    <!-- Botón Volver -->
                    <button type="button" class="btn btn-danger flex-grow-1" id="btnVolverTipoDesdeSeleccion">Volver atrás</button>
                    
                    <!-- Botón Registrar Nuevo (se agregará dinámicamente aquí) -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar un nuevo computador -->
<div class="modal fade" id="modalRegistrarComputador" tabindex="-1" aria-labelledby="modalRegistrarComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalRegistrarComputadorLabel"> Registrar Nuevo Computador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarComputador">
                    <div class="mb-3">
                        <label for="marcaComputador" class="form-label"><i class="bi bi-tag"></i> Marca</label>
                        <input type="text" class="form-control" id="marcaComputador" required>
                    </div>
                    <div class="mb-3">
                        <label for="codigoComputador" class="form-label"><i class="bi bi-keyboard"></i> Código</label>
                        <input type="text" class="form-control" id="codigoComputador" required>
                    </div>
                    <!-- Checkbox para "Tiene mouse" -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="tieneMouse">
                        <label class="form-check-label" for="tieneMouse"><i class="bi bi-mouse"></i> Tiene mouse</label>
                    </div>
                    <!-- Checkbox para "Tiene teclado" -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="tieneTeclado">
                        <label class="form-check-label" for="tieneTeclado"><i class="bi bi-keyboard-fill"></i> Tiene teclado</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ==============================================
        // INICIALIZACIÓN DE COMPONENTES Y VARIABLES
        // ==============================================

        // Modales de Bootstrap
        const modalTieneComputador = new bootstrap.Modal(document.getElementById('modalTieneComputador'));
        const modalTipoComputador = new bootstrap.Modal(document.getElementById('modalTipoComputador'));
        const modalSeleccionarComputador = new bootstrap.Modal(document.getElementById('modalSeleccionarComputador'));

        // Elementos del DOM
        const selectComputadores = document.getElementById('selectComputadores');
        const btnSiComputador = document.getElementById('btnSiComputador');
        const btnNoComputador = document.getElementById('btnNoComputador');
        const btnPersonal = document.getElementById('btnPersonal');
        const btnSena = document.getElementById('btnSena');
        const btnConfirmarPC = document.getElementById('btnConfirmarPC');
        const btnVerificarCodigo = document.getElementById('btnVerificarCodigo');

        // Variables de estado
        let codigoEscaneado = '';  // Almacena el código escaneado del usuario
        let tipoComputador = null; // Almacena el tipo de computador seleccionado (Personal/Sena)

        // ==============================================
        // MANEJO DEL ESCÁNER DE CÓDIGO
        // ==============================================
        document.getElementById('codigo').addEventListener('input', function () {
            // Limpiar y validar código escaneado
            codigoEscaneado = this.value.trim();

            // Expresión regular: solo números
            if (codigoEscaneado.length > 0 && /^\d+$/.test(codigoEscaneado)) {
                modalTieneComputador.show(); // Mostrar modal inicial
            } else {
                alert('⚠️ El código debe contener solo números');
                this.value = ''; // Limpiar el campo
            }
        });
        
        // Función reutilizable para validación
        function validarCodigoEscaneado() {
            const codigoInput = document.getElementById('codigo2');
            codigoEscaneado = codigoInput.value.trim();

            if (codigoEscaneado.length > 0 && /^\d+$/.test(codigoEscaneado)) {
                modalTieneComputador.show();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'El código debe contener solo números',
                    icon: 'error',
                    confirmButtonColor: '#007832'
                });
                codigoInput.value = '';
                codigoInput.focus();
            }
        }

        // Evento para el botón
        btnVerificarCodigo.addEventListener('click', validarCodigoEscaneado);

        // Evento para tecla Enter
        document.getElementById('codigo2').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                validarCodigoEscaneado();
            }
        });

        // ==============================================
        // MANEJO DE MODALES PARA SALIDAS
        // ==============================================

        // ----- Modal 1: ¿Tiene computador? -----
        btnSiComputador.addEventListener('click', () => {
            modalTieneComputador.hide();
            modalTipoComputador.show(); // Mostrar modal de tipo de computador
        });

        btnNoComputador.addEventListener('click', () => {
            registrarSalida(null);  // Registrar salida sin computador
            modalTieneComputador.hide();
        });

        // ----- Modal 2: Tipo de computador -----
        btnPersonal.addEventListener('click', () => {
            if (!codigoEscaneado) {
                alert('⚠️ Escanea un código primero');
                return;
            }
            tipoComputador = 'Personal';
            modalTipoComputador.hide();
            cargarComputadoresAsignados(tipoComputador, codigoEscaneado); // Cargar computadores asignados
            modalSeleccionarComputador.show();
        });

        btnSena.addEventListener('click', () => {
            if (!codigoEscaneado) {
                alert('⚠️ Escanea un código primero');
                return;
            }
            tipoComputador = 'Sena';
            modalTipoComputador.hide();
            cargarComputadoresAsignados(tipoComputador, codigoEscaneado); // Cargar computadores asignados
            modalSeleccionarComputador.show();
        });

        // ----- Modal 3: Selección de computador -----
        btnConfirmarPC.addEventListener('click', () => {
            const computadorId = selectComputadores.value;
            if (computadorId) {
                registrarSalida(computadorId); // Registrar salida con computador seleccionado
                modalSeleccionarComputador.hide();
            } else {
                alert('❌ Selecciona un computador de la lista');
            }
        });

        // ----- Volver desde Selección de Computador a Tipo de Computador -----
        document.getElementById('btnVolverTipoDesdeSeleccion').addEventListener('click', () => {
            modalSeleccionarComputador.hide();
            modalTipoComputador.show();
        });

        // ==============================================
        // FUNCIONES PRINCIPALES PARA SALIDAS
        // ==============================================

        /**
         * Carga computadores asignados al usuario para seleccionar cuál devolver
         * @param {string} tipoComputador - Tipo de computador (Personal/Sena)
         * @param {string} codigoUsuario - Código del usuario
         */
        function cargarComputadoresAsignados(tipoComputador, codigoUsuario) {
            console.log(`Cargando computadores asignados tipo: ${tipoComputador}`);
            
            fetch("obtener_computadores", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `tipoComputador=${encodeURIComponent(tipoComputador)}&codigo=${encodeURIComponent(codigoUsuario)}`
            })
            .then(response => {
                if (!response.ok) throw new Error('Error en la respuesta del servidor');
                return response.json();
            })
            .then(data => {
                console.log("Datos recibidos:", data);
                
                const select = document.getElementById('selectComputadores');
                const btnConfirmar = document.getElementById('btnConfirmarPC');
                
                // Limpiar select
                select.innerHTML = '';

                if (data.success && data.data && data.data.length > 0) {
                    // Opción por defecto
                    const defaultOption = new Option(`Seleccione el computador a devolver (${data.data.length})`, "", true, true);
                    defaultOption.disabled = true;
                    select.add(defaultOption);

                    // Agregar opciones
                    data.data.forEach(pc => {
                        const textoMostrar = `${pc.modelo}${pc.codigo ? ` - ${pc.codigo}` : ''}`;
                        const option = new Option(textoMostrar, pc.id);
                        select.add(option);
                    });

                    select.disabled = false;
                    btnConfirmar.disabled = true;
                    
                    // Habilitar/deshabilitar botón según selección
                    select.addEventListener('change', function() {
                        btnConfirmar.disabled = this.value === "";
                    });
                } else {
                    const option = new Option("No tienes computadores asignados", "", true, true);
                    option.disabled = true;
                    select.add(option);
                    select.disabled = true;
                    btnConfirmar.disabled = true;
                    
                    // Cerrar modal después de 2 segundos
                    setTimeout(() => {
                        modalSeleccionarComputador.hide();
                        modalTipoComputador.show();
                    }, 2000);
                }
            })
            .catch(error => {
                console.error("Error al cargar computadores asignados:", error);
                const select = document.getElementById('selectComputadores');
                select.innerHTML = '';
                const errorOption = new Option("Error al cargar datos", "", true, true);
                errorOption.disabled = true;
                select.add(errorOption);
                select.disabled = true;
                document.getElementById('btnConfirmarPC').disabled = true;
            });
        }

        /**
         * Registra la salida del usuario (con o sin computador)
         * @param {number|null} computadorId - ID del computador a devolver (null si no tiene)
         */
        function registrarSalida(computadorId) {
            const formData = new FormData();
            formData.append('codigo', codigoEscaneado);
            
            if (computadorId) {
                formData.append('computador_id', computadorId);
                formData.append('tipo_computador', tipoComputador);
            }

            // Mostrar datos en consola antes de enviar
            console.log("Datos a enviar:");
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }


            fetch('registrar_salida', {
                method: 'POST',
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Error al registrar salida');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Salida registrada!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#007832'
                    }).then(() => {
                        document.getElementById('codigo').value = '';
                        document.getElementById('codigo2').value = '';
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#007832'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: error.message,
                    icon: 'error',
                    confirmButtonColor: '#007832'
                });
            });
        }

        // Cerrar modales con botones personalizados
        document.querySelectorAll('.btn-cerrar-modal').forEach(btnCerrar => {
            btnCerrar.addEventListener('click', () => {
                const modal = btnCerrar.closest('.modal');
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                } else {
                    new bootstrap.Modal(modal).hide();
                }
            });
        });
    });
</script>