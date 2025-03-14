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
        console.log("Dato enviado (tipoComputador):", tipoComputador);
        console.log("Dato enviado (codigo):", codigo);

        fetch("obtener_computadores", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "tipoComputador=" + encodeURIComponent(tipoComputador) + 
                    "&codigo=" + encodeURIComponent(codigo)
        })
        .then(response => {
            console.log("Respuesta del servidor (computadores):", response);
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log("Datos recibidos (computadores):", data);
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
            console.error("Error al cargar computadores:", error);
            alert('Error al cargar los computadores. Inténtalo más tarde.');
        });
    }

    // Función para registrar la asistencia
    function registrarAsistencia(computadorId) {
        const formData = new FormData();
        formData.append('codigo', codigoEscaneado); // Enviar el código escaneado
        formData.append('computador_id', computadorId || ''); // Enviar el computador_id (puede ser null o vacío)

        // Depuración: Mostrar los datos que se están enviando
        console.log("Datos enviados al servidor:");
        for (let [key, value] of formData.entries()) {
            console.log(key + ": " + value);
        }

        fetch('registrar_ingreso', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log("Respuesta del servidor:", response);
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log("Datos recibidos:", data);
            if (data.success) {
                alert(data.message); // Mostrar mensaje de éxito
                document.getElementById('codigo').value = ''; // Limpiar el campo de código
                window.location.reload(); // Recargar la página
            } else {
                alert(data.message); // Mostrar mensaje de error
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert('Error en el sistema. Inténtalo más tarde.');
        });
    }
});