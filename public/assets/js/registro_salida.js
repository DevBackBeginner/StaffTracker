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
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    document.head.appendChild(script);

    // ==============================================
    // INICIALIZACIÓN DE COMPONENTES
    // ==============================================
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

    // Variables de estado
    let codigoEscaneado = '';
    let tipoComputador = null;

    // ==============================================
    // MANEJO DEL ESCÁNER (CON SWEETALERT2)
    // ==============================================
    function handleCodeInput(value, element) {
        codigoEscaneado = value.trim();
        
        if (codigoEscaneado.length > 0 && /^\d+$/.test(codigoEscaneado)) {
            modalTieneComputador.show();
        } else if (codigoEscaneado.length > 0) {
            Swal.fire({
                ...SwalConfig,
                title: 'Formato incorrecto',
                text: 'El código debe contener solo números',
                icon: 'error'
            });
            element.value = '';
        }
    }

    document.getElementById('codigo').addEventListener('input', (e) => handleCodeInput(e.target.value, e.target));
    document.getElementById('codigo2').addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            handleCodeInput(e.target.value, e.target);
        }
    });

    // ==============================================
    // MANEJO DE MODALES (CON ALERTAS MEJORADAS)
    // ==============================================
    btnSiComputador.addEventListener('click', () => {
        modalTieneComputador.hide();
        modalTipoComputador.show();
    });

    btnNoComputador.addEventListener('click', () => {
        modalTieneComputador.hide();
        gestionarAcceso(null);
    });

    btnPersonal.addEventListener('click', () => {
        if (!codigoEscaneado) {
            showAlert('Error', 'Escanea un código primero', 'error');
            return;
        }
        tipoComputador = 'Personal';
        modalTipoComputador.hide();
        cargarComputadores(tipoComputador, codigoEscaneado);
        modalSeleccionarComputador.show();
    });

    btnSena.addEventListener('click', () => {
        if (!codigoEscaneado) {
            showAlert('Error', 'Escanea un código primero', 'error');
            return;
        }
        tipoComputador = 'Sena';
        modalTipoComputador.hide();
        cargarComputadores(tipoComputador, codigoEscaneado);
        modalSeleccionarComputador.show();
    });

    btnConfirmarPC.addEventListener('click', () => {
        const computadorId = selectComputadores.value;
        if (computadorId) {
            gestionarAcceso(computadorId);
            modalSeleccionarComputador.hide();
        } else {
            showAlert('Error', 'Selecciona un computador de la lista', 'error');
        }
    });

    // ==============================================
    // FUNCIONES PRINCIPALES (ACTUALIZADAS)
    // ==============================================
    function showAlert(title, text, icon) {
        return Swal.fire({
            ...SwalConfig,
            title,
            text,
            icon
        });
    }

    function cargarComputadores(tipoComputador, codigo) {
        fetch("obtener_computadores", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `tipoComputador=${encodeURIComponent(tipoComputador)}&codigo=${encodeURIComponent(codigo)}`
        })
        .then(response => response.json())
        .then(data => {
            selectComputadores.innerHTML = "";
            
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(pc => {
                    const option = document.createElement("option");
                    option.value = pc.id;
                    option.textContent = `${pc.marca} - ${pc.codigo}`;
                    selectComputadores.appendChild(option);
                });
            } else {
                showAlert('Info', 'No hay computadores disponibles', 'info');
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showAlert('Error', 'Error al cargar computadores', 'error');
        });
    }

    function gestionarAcceso(computadorId) {
        const formData = new FormData();
        formData.append('codigo', codigoEscaneado);
        formData.append('computador_id', computadorId || '');
    
        fetch('gestion_registro_salida', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    ...SwalConfig,
                    title: 'Éxito',
                    text: data.message,
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('codigo').value = '';
                        window.location.reload();
                    }
                });
            } else {
                showAlert('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Error', error.message || 'Error en el servidor', 'error');
        });
    }

    // Cerrar modales
    document.querySelectorAll('.btn-cerrar-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = bootstrap.Modal.getInstance(btn.closest('.modal'));
            modal?.hide();
        });
    });
});