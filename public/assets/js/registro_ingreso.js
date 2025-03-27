document.addEventListener('DOMContentLoaded', function () {
    // ==============================================
    // CONFIGURACIÓN GLOBAL DE ALERTAS
    // ==============================================
    const SwalConfig = {
        confirmButtonColor: '#007832',
        background: '#ffffff',
        allowOutsideClick: false,
        customClass: {
            popup: 'animate__animated animate__fadeInDown'
        }
    };

    // Cargar SweetAlert2 desde CDN
    const loadSweetAlert = () => {
        return new Promise((resolve) => {
            if (typeof Swal === 'undefined') {
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                script.onload = resolve;
                document.head.appendChild(script);
            } else {
                resolve();
            }
        });
    };

    // Función para mostrar alertas consistentes
    const showAlert = async (title, text, icon, reload = false) => {
        await loadSweetAlert();
        return Swal.fire({
            ...SwalConfig,
            title,
            text,
            icon
        }).then((result) => {
            if (reload && result.isConfirmed) {
                window.location.reload();
            }
        });
    };

    // ==============================================
    // INICIALIZACIÓN DE COMPONENTES
    // ==============================================
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
    let codigoEscaneado = '';
    let tipoComputador = null;

    // ==============================================
    // MANEJO DEL ESCÁNER DE CÓDIGO
    // ==============================================
    const handleCodeInput = async (value, element) => {
        codigoEscaneado = value.trim();
        
        if (codigoEscaneado.length > 0 && /^\d+$/.test(codigoEscaneado)) {
            modalTieneComputador.show();
        } else if (codigoEscaneado.length > 0) {
            await showAlert('Formato incorrecto', 'El código debe contener solo números', 'error');
            element.value = '';
        }
    };

    document.getElementById('codigo').addEventListener('input', (e) => handleCodeInput(e.target.value, e.target));
    document.getElementById('codigo2').addEventListener('keydown', async (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            await handleCodeInput(e.target.value, e.target);
        }
    });

    // ==============================================
    // MANEJO DE MODALES
    // ==============================================
    btnSiComputador.addEventListener('click', () => {
        modalTieneComputador.hide();
        modalTipoComputador.show();
    });

    btnNoComputador.addEventListener('click', () => {
        modalTieneComputador.hide();
        gestionarAcceso(null);
    });

    btnPersonal.addEventListener('click', async () => {
        if (!codigoEscaneado) {
            await showAlert('Error', 'Escanea un código primero', 'error');
            return;
        }
        tipoComputador = 'Personal';
        modalTipoComputador.hide();
        await cargarComputadores(tipoComputador, codigoEscaneado);
        modalSeleccionarComputador.show();
    });

    btnSena.addEventListener('click', async () => {
        if (!codigoEscaneado) {
            await showAlert('Error', 'Escanea un código primero', 'error');
            return;
        }
        tipoComputador = 'Sena';
        modalTipoComputador.hide();
        await cargarComputadores(tipoComputador, codigoEscaneado);
        modalSeleccionarComputador.show();
    });

    btnConfirmarPC.addEventListener('click', async () => {
        const computadorId = selectComputadores.value;
        if (computadorId) {
            await gestionarAcceso(computadorId);
            modalSeleccionarComputador.hide();
        } else {
            await showAlert('Error', 'Selecciona un computador de la lista', 'error');
        }
    });

    // ==============================================
    // FUNCIONES PRINCIPALES
    // ==============================================
    async function cargarComputadores(tipoComputador, codigo) {
        try {
            const response = await fetch("obtener_computadores", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `tipoComputador=${encodeURIComponent(tipoComputador)}&codigo=${encodeURIComponent(codigo)}`
            });

            if (!response.ok) throw new Error('Error en la respuesta');

            const data = await response.json();
            selectComputadores.innerHTML = "";

            if (Array.isArray(data) && data.length > 0) {
                data.forEach(pc => {
                    const option = document.createElement("option");
                    option.value = pc.id;
                    option.textContent = `${pc.marca} - ${pc.codigo}`;
                    selectComputadores.appendChild(option);
                });
            } else {
                await showAlert('Información', 'No hay computadores disponibles', 'info');
            }
        } catch (error) {
            console.error("Error:", error);
            await showAlert('Error', 'Error al cargar computadores', 'error');
        }
    }

    async function registrarNuevoComputador(marca, codigoPC, tipo, tieneMouse, tieneTeclado) {
        try {
            const formData = new FormData();
            formData.append('marca', marca);
            formData.append('codigo', codigoPC);
            formData.append('tipo', tipo);
            formData.append('tieneMouse', tieneMouse ? 'Si' : 'No');
            formData.append('tieneTeclado', tieneTeclado ? 'Si' : 'No');

            const response = await fetch('registrar_computador', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Error en el servidor');

            const data = await response.json();

            if (data.success) {
                await showAlert('Éxito', 'Computador registrado', 'success');
                modalRegistrarComputador.hide();
                await gestionarAcceso(data.computador_id);
            } else {
                await showAlert('Error', data.message || 'Error al registrar', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            await showAlert('Error', 'Error en el servidor', 'error');
        }
    }

    async function gestionarAcceso(computadorId) {
        try {
            const formData = new FormData();
            formData.append('codigo', codigoEscaneado);
            formData.append('computador_id', computadorId || '');

            const response = await fetch('gestion_registro_acceso', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Error en la solicitud');
            }

            const data = await response.json();

            if (data.success) {
                document.getElementById('codigo').value = '';
                await showAlert('Éxito', data.message, 'success', true);
            } else {
                await showAlert('Error', data.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            await showAlert('Error', error.message || 'Error en el servidor', 'error');
        }
    }

    // ==============================================
    // REGISTRO DE NUEVO COMPUTADOR
    // ==============================================
    const btnRegistrarNuevoPC = document.createElement('button');
    btnRegistrarNuevoPC.textContent = 'Registrar Nuevo Computador';
    btnRegistrarNuevoPC.className = 'btn btn-warning flex-grow-1';
    btnRegistrarNuevoPC.addEventListener('click', () => {
        modalSeleccionarComputador.hide();
        modalRegistrarComputador.show();
    });
    document.querySelector('#modalSeleccionarComputador .d-flex').appendChild(btnRegistrarNuevoPC);

    formRegistrarComputador.addEventListener('submit', async (e) => {
        e.preventDefault();
        const marca = document.getElementById('marcaComputador').value;
        const codigoPC = document.getElementById('codigoComputador').value;
        
        if (!marca || !codigoPC) {
            await showAlert('Advertencia', 'Completa todos los campos', 'warning');
            return;
        }

        await registrarNuevoComputador(
            marca,
            codigoPC,
            tipoComputador,
            document.getElementById('tieneMouse').checked,
            document.getElementById('tieneTeclado').checked
        );
    });

    // ==============================================
    // MANEJO DE CIERRE DE MODALES
    // ==============================================
    document.querySelectorAll('.btn-cerrar-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = bootstrap.Modal.getInstance(btn.closest('.modal'));
            modal?.hide();
        });
    });
});