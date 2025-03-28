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
    const btnVerificarCodigo = document.getElementById('btnVerificarCodigo'); // Nuevo botón

    // Variables de estado
    let codigoEscaneado = '';  // Almacena el código escaneado del usuario
    let tipoComputador = null; // Almacena el tipo de computador seleccionado (Personal/Sena)

      // ==============================================
    // MANEJO DEL ESCÁNER DE CÓDIGO
    // ==============================================
    document.getElementById('codigo').addEventListener('input', function (event) {
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

    // Evento para el botón (manteniendo tu código original)
    btnVerificarCodigo.addEventListener('click', validarCodigoEscaneado);

    // Evento para tecla Enter (nueva funcionalidad)
    document.getElementById('codigo2').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            validarCodigoEscaneado();
        }
    });

    // ==============================================
    // MANEJO DE MODALES
    // ==============================================

    // ----- Modal 1: ¿Tiene computador? -----
    btnSiComputador.addEventListener('click', () => {
        modalTieneComputador.hide();
        modalTipoComputador.show(); // Mostrar modal de tipo de computador
    });

    btnNoComputador.addEventListener('click', () => {
        gestionarAcceso(null);  // Registrar acceso sin computador
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
        cargarComputadores(tipoComputador, codigoEscaneado); // Cargar computadores personales
        modalSeleccionarComputador.show();
    });

    btnSena.addEventListener('click', () => {
        if (!codigoEscaneado) {
            alert('⚠️ Escanea un código primero');
            return;
        }
        tipoComputador = 'Sena';
        modalTipoComputador.hide();
        cargarComputadores(tipoComputador, codigoEscaneado); // Cargar computadores del Sena
        modalSeleccionarComputador.show();
    });

    // ----- Modal 3: Selección de computador -----
    btnConfirmarPC.addEventListener('click', () => {
        const computadorId = selectComputadores.value;
        if (computadorId) {
            gestionarAcceso(computadorId); // Registrar acceso con computador seleccionado
            modalSeleccionarComputador.hide();
        } else {
            alert('❌ Selecciona un computador de la lista');
        }
    });

    // ----- Volver desde Selección de Computador a Tipo de Computador -----
    document.getElementById('btnVolverTipoDesdeSeleccion').addEventListener('click', () => {
        modalSeleccionarComputador.hide();
        modalTipoComputador.show(); // Muestra el modal anterior
    });

    // ==============================================
    // FUNCIONES PRINCIPALES
    // ==============================================

    /**
     * Carga computadores disponibles desde el servidor
     * @param {string} tipoComputador - Tipo de computador (Personal/Sena)
     * @param {string} codigo - Código del usuario
     */
    function cargarComputadores(tipoComputador, codigo) {
        fetch("obtener_computadores", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `tipoComputador=${encodeURIComponent(tipoComputador)}&codigo=${encodeURIComponent(codigo)}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta');
            return response.json();
        })
        .then(data => {
            selectComputadores.innerHTML = ""; // Limpiar select

            if (Array.isArray(data) && data.length > 0) {
                // Llenar con computadores disponibles
                data.forEach(pc => {
                    const option = document.createElement("option");
                    option.value = pc.id;
                    option.textContent = `${pc.marca} - ${pc.codigo}`;
                    selectComputadores.appendChild(option);
                });
            } else {
                // Opción por defecto si no hay resultados
                const option = document.createElement("option");
                option.textContent = "No hay computadores disponibles";
                selectComputadores.appendChild(option);
            }
        })
        .catch(error => {
            console.error("Error al cargar computadores:", error);
            alert('❌ Error al cargar computadores');
        });
    }

    /**
     * Gestiona el proceso completo de registro de acceso
     * @param {number|null} computadorId - ID del computador o null
     */
    function gestionarAcceso(computadorId) {
        const formData = new FormData();
        formData.append('codigo', codigoEscaneado);
        formData.append('computador_id', computadorId || '');

        fetch('gestion_registro_salida', {
            method: 'POST',
            body: formData
        })
        .then(async response => {
            // Verificar si la respuesta no es exitosa (códigos 400, 404, etc.)
            if (!response.ok) {
                // Parsear la respuesta como JSON para obtener el mensaje de error
                const errorData = await response.json();
                throw new Error(errorData.message || 'Error en la solicitud');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(`✅ ${data.message}`);
                document.getElementById('codigo').value = ''; // Resetear campo
                window.location.reload(); // Actualizar lista de registros
            } else {
                alert(`❌ ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(`❌ Error: ${error.message}`);
        });
    }

    // Cerrar modales con botones personalizados
    // Cerrar modales con botones personalizados
    document.querySelectorAll('.btn-cerrar-modal').forEach(btnCerrar => {
        btnCerrar.addEventListener('click', () => {
            // Obtener el modal asociado al botón de cierre
            const modal = btnCerrar.closest('.modal');
            // Ocultar el modal usando Bootstrap
            const modalInstance = bootstrap.Modal.getInstance(modal); // Try to get the instance
            if (modalInstance) {
                modalInstance.hide(); // Hide the modal if the instance exists
            } else {
                // If the instance doesn't exist, create a new one and hide it
                new bootstrap.Modal(modal).hide();
            }
        });
    });
});