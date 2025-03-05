setTimeout(() => {
    let alerta = document.getElementById("mensajeAlerta");
    if (alerta) {
        alerta.classList.remove("show");
        alerta.classList.add("fade");
        setTimeout(() => alerta.remove(), 500); // Remueve el div después de la animación
    }
}, 5000);

function togglePassword(inputId, iconId) {
    let input = document.getElementById(inputId);
    let icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}
// Validación en tiempo real para el número de identidad
document.getElementById('numero_identidad').addEventListener('input', function () {
    if (!this.checkValidity()) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});

// Validación en tiempo real para el teléfono
document.getElementById('telefono').addEventListener('input', function () {
    if (!this.checkValidity()) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});