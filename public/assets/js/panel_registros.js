document.addEventListener("DOMContentLoaded", function () {
    function filtrarUsuarios() {
        let rol = document.getElementById("rol").value;
        let documento = document.getElementById("documento").value;

        let datos = new FormData();
        datos.append("rol", rol);
        datos.append("documento", documento);

        fetch("filtro_usuarios", {
            method: "POST",
            body: datos
        })
        .then(response => response.text())
        .then(data => {
            let contenedor = document.getElementById("tabla-body");
            if (contenedor) {
                contenedor.innerHTML = ""; // 🔥 Elimina contenido anterior
                contenedor.innerHTML = data; // 🔄 Agrega la nueva vista
            }
        })
        .catch(error => console.error("Error en la petición AJAX:", error));
    }

    // Eventos para detectar cambios y ejecutar la función
    document.getElementById("rol").addEventListener("change", filtrarUsuarios);
    document.getElementById("documento").addEventListener("input", filtrarUsuarios);
});
