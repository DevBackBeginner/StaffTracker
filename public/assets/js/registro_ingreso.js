document.addEventListener('DOMContentLoaded', function () {
    // ==============================================
    // INICIALIZACIÓN DE COMPONENTES Y VARIABLES
    // ==============================================

    // Modales de Bootstrap
    const modalTieneComputador = new bootstrap.Modal(document.getElementById('modalTieneComputador'));
    const modalTipoComputador = new bootstrap.Modal(document.getElementById('modalTipoComputador'));
    const modalSeleccionarComputador = new bootstrap.Modal(document.getElementById('modalSeleccionarComputador'));
    const modalRegistrarComputador = new bootstrap.Modal(document.getElementById('modalRegistrarComputador'));

    // Elementos del DOM
    const selectComputadores = document.getElementById('selectComputadores');
    const btnSiComputador = document.getElementById('btnSiComputador');
    const btnNoComputador = document.getElementById('btnNoComputador');
    const btnPersonal = document.getElementById('btnPersonal');
    const btnSena = document.getElementById('btnSena');
    const btnConfirmarPC = document.getElementById('btnConfirmarPC');
    const formRegistrarComputador = document.getElementById('formRegistrarComputador');

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
    // REGISTRO DE NUEVO COMPUTADOR
    // ==============================================

    // Botón dinámico para mostrar modal de registro
    const btnRegistrarNuevoPC = document.createElement('button');
    btnRegistrarNuevoPC.textContent = 'Registrar Nuevo Computador';
    btnRegistrarNuevoPC.className = 'btn btn-warning flex-grow-1'; // Clase modificada
    btnRegistrarNuevoPC.addEventListener('click', () => {
        modalSeleccionarComputador.hide();
        modalRegistrarComputador.show();
    });

    // Agregar al contenedor flex
    document.querySelector('#modalSeleccionarComputador .d-flex').appendChild(btnRegistrarNuevoPC);

    // Manejo del formulario de registro
    formRegistrarComputador.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevenir envío tradicional

        // Obtener valores del formulario
        const marca = document.getElementById('marcaComputador').value;
        const codigoPC = document.getElementById('codigoComputador').value;
        const tieneMouse = document.getElementById('tieneMouse').checked; // true o false
        const tieneTeclado = document.getElementById('tieneTeclado').checked; // true o false

        // Validación básica
        if (!marca || !codigoPC) {
            alert('⚠️ Completa todos los campos');
            return;
        }

        // Registrar nuevo computador
        registrarNuevoComputador(marca, codigoPC, tipoComputador, tieneMouse, tieneTeclado);
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
     * Registra un nuevo computador en el sistema
     * @param {string} marca - Marca del computador
     * @param {string} codigoPC - Código único del computador
     * @param {string} tipo - Tipo de computador (Personal/Sena)
     * @param {string} tieneMouse - Indica si tiene mouse (Si/No)
     * @param {string} tieneTeclado - Indica si tiene teclado (Si/No)
     */
    function registrarNuevoComputador(marca, codigoPC, tipo, tieneMouse, tieneTeclado) {
        const formData = new FormData();
        formData.append('marca', marca);
        formData.append('codigo', codigoPC);
        formData.append('tipo', tipo);
        formData.append('tieneMouse', tieneMouse ? 'Si' : 'No'); // 'Si' si está marcado, 'No' si no
        formData.append('tieneTeclado', tieneTeclado ? 'Si' : 'No'); // 'Si' si está marcado, 'No' si no

        fetch('registrar_computador', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en el servidor');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('✅ Computador registrado');
                modalRegistrarComputador.hide();
                gestionarAcceso(data.computador_id); // Registrar acceso con nuevo ID
            } else {
                alert(`❌ Error: ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error al registrar computador');
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

        fetch('gestion_registro_acceso', {
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