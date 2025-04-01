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

    const btnVerificarCodigo = document.getElementById('btnVerificarCodigo');

    // Variables de estado
    let codigoEscaneado = '';
    let tipoComputador = null;
    
    // ==============================================
    // MANEJO DEL ESCÁNER DE CÓDIGO (Versión optimizada)
    // ==============================================

    function validarCodigo(inputElement, usarSweetAlert = false) {
        codigoEscaneado = inputElement.value.trim();

        if (codigoEscaneado.length > 0 && /^\d+$/.test(codigoEscaneado)) {
            modalTieneComputador.show();
            return true;
        } else {
            if (usarSweetAlert) {
                Swal.fire({
                    title: 'Error',
                    text: 'El código debe contener solo números',
                    icon: 'error',
                    confirmButtonColor: '#007832'
                });
            } else {
                alert('⚠️ El código debe contener solo números');
            }
            inputElement.value = '';
            inputElement.focus();
            return false;
        }
    }

    document.getElementById('codigo').addEventListener('input', function(event) {
        validarCodigo(this);
    });

    document.getElementById('codigo2').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            validarCodigo(this);
        }
    });

    btnVerificarCodigo.addEventListener('click', function() {
        const codigoInput = document.getElementById('codigo2');
        validarCodigo(codigoInput, true);
    });

    // ==============================================
    // MANEJO DE MODALES 
    // ==============================================

    btnSiComputador.addEventListener('click', () => {
        modalTieneComputador.hide();
        modalTipoComputador.show();
    });

    btnNoComputador.addEventListener('click', () => {
        gestionarAcceso(null);
        modalTieneComputador.hide();
    });


    btnPersonal.addEventListener('click', () => {
        if (!codigoEscaneado) {
            alert('⚠️ Escanea un código primero');
            return;
        }
        tipoComputador = 'Personal';
        modalTipoComputador.hide();

        btnConfirmarPC.disabled = true;
        cargarComputadores(tipoComputador, codigoEscaneado);

        modalSeleccionarComputador.show();
    });

    btnSena.addEventListener('click', () => {
        if (!codigoEscaneado) {
            alert('⚠️ Escanea un código primero');
            return;
        }
        tipoComputador = 'Sena';
        modalTipoComputador.hide();
        btnConfirmarPC.disabled = true;
        cargarComputadores(tipoComputador, codigoEscaneado);
        modalSeleccionarComputador.show();
    });

    // MEJORA CLAVE: Manejo mejorado del botón de confirmación
    btnConfirmarPC.addEventListener('click', () => {
        console.group("🔍 Validación de selección");
        
        const selectedIndex = selectComputadores.selectedIndex;
        const selectedOption = selectComputadores.options[selectedIndex];
        
        console.log("Índice seleccionado:", selectedIndex);
        console.log("Opción seleccionada:", {
            value: selectedOption.value,
            text: selectedOption.text,
            disabled: selectedOption.disabled
        });

        // Validación mejorada
        if (selectedIndex > 0 && selectedOption.value !== "" && !isNaN(parseInt(selectedOption.value))) {
            const computadorId = parseInt(selectedOption.value);
            console.log("ID válido detectado:", computadorId);
            
            // Mostrar confirmación con el nombre del equipo
            const nombreEquipo = selectedOption.text.split(' (')[0]; // Remover estado si existe
            if (confirm(`¿Confirmar registro con el equipo: ${nombreEquipo}?`)) {
                gestionarAcceso(computadorId);
                modalSeleccionarComputador.hide();
            }
        } else {
            console.error("Selección no válida");
            
            // Feedback visual
            selectComputadores.classList.add('is-invalid');
            setTimeout(() => {
                selectComputadores.classList.remove('is-invalid');
            }, 2000);
            
            alert('❌ Por favor selecciona un computador válido de la lista');
        }
        console.groupEnd();
    });
    document.getElementById('btnVolverTipoDesdeSeleccion').addEventListener('click', () => {
        modalSeleccionarComputador.hide();
        modalTipoComputador.show();
    });

    selectComputadores.addEventListener('change', function() {
        btnConfirmarPC.disabled = this.value === "";
    });

    // ==============================================
    // REGISTRO DE NUEVO COMPUTADOR 
    // ==============================================

    const btnRegistrarNuevoPC = document.createElement('button');
    btnRegistrarNuevoPC.textContent = 'Registrar Computador';
    btnRegistrarNuevoPC.className = 'btn btn-success flex-grow-1';

    btnRegistrarNuevoPC.addEventListener('click', () => {
        modalSeleccionarComputador.hide();
        modalRegistrarComputador.show();
    });


    document.querySelector('#modalSeleccionarComputador .d-grid').appendChild(btnRegistrarNuevoPC);

    formRegistrarComputador.addEventListener('submit', function (event) {
        event.preventDefault();

        const marca = document.getElementById('marcaComputador').value;
        const codigoPC = document.getElementById('codigoComputador').value;
        const tieneMouse = document.getElementById('tieneMouse').checked;
        const tieneTeclado = document.getElementById('tieneTeclado').checked;


        if (!marca || !codigoPC) {
            alert('⚠️ Completa todos los campos');
            return;
        }



        registrarNuevoComputador(marca, codigoPC, tipoComputador, tieneMouse, tieneTeclado);
    });

    // ==============================================

    // FUNCIONES PRINCIPALES 
    // ==============================================

    function cargarComputadores(tipoComputador, codigoUsuario) {
        console.log(`Cargando computadores tipo: ${tipoComputador}`);
        
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
            
            // Limpiar select completamente
            select.innerHTML = '';

            if (data.success && data.data && data.data.length > 0) {
                // Opción por defecto (placeholder)
                const defaultOption = new Option(`Seleccione un computador (${data.data.length} disponibles)`, "", true, true);
                defaultOption.disabled = true;
                select.add(defaultOption);

                // Agregar opciones con ID como valor y texto descriptivo
                data.data.forEach(pc => {
                    // Crear texto descriptivo para mostrar
                    const textoMostrar = `${pc.modelo}${pc.codigo ? ` - ${pc.codigo}` : ''}${pc.estado ? ` (${pc.estado})` : ''}`;
                    
                    // Crear opción con ID como valor y texto descriptivo
                    const option = new Option(textoMostrar, pc.id);
                    select.add(option);
                    
                    console.log("Opción agregada:", {
                        id: pc.id,
                        texto: textoMostrar,
                        value: option.value,
                        text: option.text
                    });
                });

                select.disabled = false;
                btnConfirmar.disabled = true;
            } else {
                const option = new Option("No hay computadores disponibles", "", true, true);
                option.disabled = true;
                select.add(option);
                select.disabled = true;
                btnConfirmar.disabled = true;

            }
        })
        .catch(error => {
            console.error("Error al cargar computadores:", error);

            const select = document.getElementById('selectComputadores');
            select.innerHTML = '';
            const errorOption = new Option("Error al cargar datos", "", true, true);
            errorOption.disabled = true;
            select.add(errorOption);
            select.disabled = true;
            document.getElementById('btnConfirmarPC').disabled = true;
        });
    }

    async function registrarNuevoComputador(marca, codigoPC, tipo, tieneMouse, tieneTeclado) {
        try {
            // Validaciones básicas
            if (!marca || !codigoPC || !tipo || !codigoEscaneado) {
                throw new Error('Todos los campos son obligatorios (incluyendo código escaneado)');
            }

            // 1. Registrar computador
            const formData = new FormData();
            formData.append('marca', marca.trim());
            formData.append('codigo', codigoPC.trim());
            formData.append('tipo', tipo);
            formData.append('mouse', tieneMouse ? 'Si' : 'No');
            formData.append('teclado', tieneTeclado ? 'Si' : 'No');
            formData.append('codigo_escaneado', codigoEscaneado.trim());

            const registroResponse = await fetch('registrar_computador', {
                method: 'POST',
                body: formData
            });

            if (!registroResponse.ok) {
                const error = await registroResponse.json();
                throw new Error(error.message || 'Error al registrar computador');
            }

            const registroData = await registroResponse.json();
            
            if (!registroData.success) {
                throw new Error(registroData.message || 'Error en el registro');
            }

            // 2. Registrar ingreso/asignación
            const ingresoResponse = await fetch('registrar_ingreso', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    computador_id: registroData.data.computador_id,
                    tipo_computador: registroData.data.tipo,
                    codigo: codigoEscaneado
                })
            });

            if (!ingresoResponse.ok) {
                throw new Error('Error al registrar ingreso/asignación');
            }

            const ingresoData = await ingresoResponse.json();

            if (!ingresoData.success) {
                throw new Error(ingresoData.message || 'Error en asignación');
            }

            // Éxito - mostrar mensaje y recargar
            alert('✅ Computador registrado y asignado correctamente');
            
            // Cerrar modal si existe
            if (window.modalRegistrarComputador?.hide) {
                modalRegistrarComputador.hide();
            }
            
            // Recargar la página después de 1 segundo
            window.location.reload();

        } catch (error) {
            console.error('Error:', error);
            alert(`❌ ${error.message}`);
        }
    }

    // MEJORA CLAVE: Función gestionarAcceso mejorada
    function gestionarAcceso(computadorId) {
        console.group("🚀 Ejecutando gestionarAcceso");
        console.log("Parámetro computadorId recibido:", computadorId);
        console.log("Tipo de computadorId:", typeof computadorId);
        console.log("Código escaneado:", codigoEscaneado);

        const formData = new FormData();
        formData.append('codigo', codigoEscaneado);
        
        if (computadorId && tipoComputador) {
            formData.append('computador_id', computadorId);
            formData.append('tipo_computador', tipoComputador);
            console.log(`Enviando computador ${computadorId} (${tipoComputador})`);
        } else {
            console.log("No se enviará información de computador");
        }
        // Verificación del contenido de FormData
        console.log("Contenido de FormData:");
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value} (tipo: ${typeof value})`);
        }

        fetch('registrar_ingreso', {

            method: 'POST',
            body: formData
        })
        .then(async response => {

            console.log("🔍 Respuesta HTTP:", response.status, response.statusText);
            
            if (!response.ok) {
                const errorData = await response.json();
                console.error("Error del servidor:", errorData);

                throw new Error(errorData.message || 'Error en la solicitud');
            }
            return response.json();
        })
        .then(data => {

            console.log("📥 Respuesta del backend:", data);
            if (data.success) {
                alert(`✅ ${data.message}`);
                document.getElementById('codigo').value = '';
                window.location.reload();

            } else {
                alert(`❌ ${data.message}`);
            }
        })
        .catch(error => {

            console.error("💥 Error completo:", error);
            console.error("Stack trace:", error.stack);
            alert(`❌ Error: ${error.message}`);
        })
        .finally(() => {
            console.groupEnd();

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