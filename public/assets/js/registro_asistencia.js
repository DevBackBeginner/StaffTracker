// Escuchar el evento 'input' en el campo de "Código" para enviar el formulario automáticamente
document.getElementById('codigo').addEventListener('input', function() {
    // Si hay algún valor ingresado en el input
    if (this.value.length > 0) {
        // Enviar el formulario de escaneo
        document.getElementById('form-escaneo').submit();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let modalEl = document.getElementById('mensajeModal');
    let modal = new bootstrap.Modal(modalEl);
    modal.show();

    let tipoMensaje = "<?php echo $tipo; ?>";  // Evita confusión con "tipoComputador"

    if (tipoMensaje === "entrada") {
        const fase1 = document.getElementById("fase1");
        const fase2 = document.getElementById("fase2");
        const fase3 = document.getElementById("fase3");

        document.getElementById("btnSiComputador").addEventListener("click", () => {
            fase1.classList.add("d-none");
            fase2.classList.remove("d-none");
        });

        document.getElementById("btnNoComputador").addEventListener("click", () => {
            modal.hide();
        });

        // Botones para seleccionar tipo de computador
        document.getElementById("btnPropio").addEventListener("click", () => {
            cargarComputadores("Personal");
        });
        document.getElementById("btnSena").addEventListener("click", () => {
            cargarComputadores("Sena");
        });

        function cargarComputadores(tipoComputador) {
            console.log("Tipo de computador enviado:", tipoComputador); // Verifica en consola
            fase2.classList.add("d-none");
            fase3.classList.remove("d-none");

            fetch("obtener_computadores", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "tipoComputador=" + encodeURIComponent(tipoComputador) // Cambio de nombre aquí
            })
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById("selectComputadores");
                select.innerHTML = "";
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(pc => {
                        let option = document.createElement("option");
                        option.value = pc.id;
                        option.textContent = pc.marca + " - " + pc.codigo;
                        select.appendChild(option);
                    });
                } else {
                    let option = document.createElement("option");
                    option.value = "";
                    option.textContent = "No hay computadores disponibles";
                    select.appendChild(option);
                }
            })
            .catch(error => console.error("Error al cargar computadores:", error));
        }

        document.getElementById("btnConfirmarPC").addEventListener("click", () => {
            let pcSeleccionado = document.getElementById("selectComputadores").value;
            if (!pcSeleccionado) {
                alert("Selecciona un computador válido");
                return;
            }
            fetch("registrar_computador", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "computador_id=" + encodeURIComponent(pcSeleccionado)
            })
            .then(response => response.text())
            .then(data => {
                console.log("Respuesta:", data);
                modal.hide();
            })
            .catch(error => console.error("Error al registrar computador:", error));
        });
    }
});
