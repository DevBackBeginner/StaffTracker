 // Ocultar el mensaje después de 3 segundos
window.onload = function() {
    const errorMessage = document.getElementById('error-message');
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.transition = 'opacity 1s ease-out';
            errorMessage.style.opacity = '0';
            setTimeout(() => errorMessage.style.display = 'none', 1000); // Ocultar después de la transición
        }, 3000); // Espera de 3 segundos antes de iniciar la transición
    }
};

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