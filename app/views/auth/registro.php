<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Portero</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Registrar Portero</h2>

        <!-- Mensajes de error -->
        <?php 
            if (isset($_SESSION['error'])) {
                echo '<div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">';
                echo '<strong>Error:</strong> ' . htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8');
                echo '</div>';
                unset($_SESSION['error']); // Limpia la variable de sesión después de mostrar el mensaje

            }
        ?>
        
        <form action="registrarPortero" method="POST" class="space-y-6">
        
        <!-- Nombre -->
        <div>
            <label for="nombre" class="block text-gray-700 font-semibold mb-1">Nombre</label>
            <input
            type="text"
            id="nombre"
            name="nombre"
            required
            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Ingrese el nombre"
            />
        </div>

        <!-- Correo -->
        <div>
            <label for="correo" class="block text-gray-700 font-semibold mb-1">Correo Electrónico</label>
            <input
            type="email"
            id="correo"
            name="correo"
            required
            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Ingrese su correo"
            />
        </div>

        <!-- Teléfono -->
        <div>
            <label for="telefono" class="block text-gray-700 font-semibold mb-1">Teléfono</label>
            <input
            type="tel"
            id="telefono"
            name="telefono"
            pattern="\d{7,15}"
            required
            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Ingrese su número de teléfono"
            />
        </div>

        <!-- Turno -->
        <div>
            <label for="turno" class="block text-gray-700 font-semibold mb-1">Turno</label>
            <select
            id="turno"
            name="turno"
            required
            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            <option value="" disabled selected>Seleccione el turno</option>
            <option value="mañana">Mañana</option>
            <option value="tarde">Tarde</option>
            <option value="noche">Noche</option>
            </select>
        </div>

        <!-- Contraseña -->
        <div>
            <label for="password" class="block text-gray-700 font-semibold mb-1">Contraseña</label>
            <div class="relative">
            <input
                type="password"
                id="password"
                name="password"
                required
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Ingrese su contraseña"
            />
            <!-- Botón para ver/ocultar contraseña -->
            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center">
                <svg id="icon-show" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg id="icon-hide" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.056 10.056 0 013.482-4.618M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.94 17.94l-3.829-3.829M5.182 5.182l3.829 3.829" />
                </svg>
            </button>
            </div>
        </div>

        <!-- Botón de enviar -->
        <button
            type="submit"
            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold"
        >
            Registrar Portero
        </button>
        </form>
    </div>

    <script>
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

    </script>


    </body>
</html>
