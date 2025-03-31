// Mostrar/ocultar contraseña
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const iconShow = document.getElementById('icon-show');
    const iconHide = document.getElementById('icon-hide');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        iconShow.classList.add('hidden');
        iconHide.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        iconShow.classList.remove('hidden');
        iconHide.classList.add('hidden');
    }
}

console.log("login.js cargado");

document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM fully loaded");
    setTimeout(function() {
        console.log("Intentando remover mensajes flash");
        const errorMsg = document.querySelector('.error-message');
        const successMsg = document.querySelector('.success-message');
        if (errorMsg) {
            errorMsg.remove();
            console.log("Mensaje de error removido");
        }
        if (successMsg) {
            successMsg.remove();
            console.log("Mensaje de éxito removido");
        }
        // Opcional: Limpiar la URL
        history.replaceState(null, "", window.location.pathname);
    }, 2000);
});
