<?php

    use core\Router;

    // Incluir configuración de base de datos
    require_once '../config/DataBase.php';

    // Rutas para el manejo de autenticación y sesión
    // Ruta para mostrar el formulario de login
    Router::get("login", [PaginaController::class, "mostrarLogin"]);
    
    // Ruta para mostrar la página principal después de iniciar sesión
    Router::get("Inicio", [PaginaController::class, "mostrarMain"]);

    // Ruta para procesar el login
    Router::post("procesarLogin", [LoginController::class, "procesarLogin"]);
    
    // Ruta para cerrar sesión
    Router::post("logout", [LoginController::class, "Logout"]);

    // Rutas relacionadas con la gestión de aprendices
    // Ruta para mostrar aprendices por ficha (cuando accede a la página principal)
    Router::get('/', [PaginaController::class, "mostrarMain"]);

    // Ruta para mostrar aprendices en el panel
    Router::get('panel', [PanelController::class, "mostralPanelPaginado"]);

    // Ruta para filtrar aprendices por algún criterio
    Router::post('filtrar_aprendices', [PanelController::class, "filtrarAprendices"]);


    // Rutas relacionadas con el registro de entradas y salidas
    // Ruta para registrar la entrada de un aprendiz
    Router::post('registrar_asistencia', [RegistroController::class, 'registrarAsistencia']);
    
    // Ruta para registrar la asignación de un computador a un aprendiz
    Router::post('registrar_computador', [RegistroController::class, "registrarComputador"]);

    // Ruta para generar un reporte en formato PDF
    Router::get('generarReporte', [ReporteController::class, "generarPDF"]);

    // Ruta para registrar un portero
    Router::post("registrarPortero", [RegistroController::class, "registrarPortero"]);

    Router::get("generar_qr", [QRController::class, "generarTodosLosQR"]);
    
?>
