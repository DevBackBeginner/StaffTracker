<?php

    use core\Router;

    // Incluir configuración de base de datos
    require_once '../config/DataBase.php';

    // Rutas para el manejo de autenticación y sesión

    // Ruta para mostrar la página principal después de iniciar sesión
    Router::get("Inicio", [PaginaController::class, "mostrarMain"]);

    Router::get('/', [PaginaController::class, "mostrarMain"]);

      // Ruta para mostrar el formulario de login
    Router::get("login", [PaginaController::class, "mostrarLogin"]);


    // Ruta para procesar el login
    Router::post("procesarLogin", [LoginController::class, "procesarLogin"]);

    // Ruta para cerrar sesión
    Router::post("logout", [LoginController::class, "Logout"]);

    Router::get("panel_administracion", [PaginaController::class, "mostrarAdmin"]);
    

    Router::get("registro", [PaginaController::class, "mostrarRegistro"]);

    // Rutas relacionadas con la gestión de aprendices
   
    Router::get('registro_asistencia', [RegistroAsistenciaController::class, "mostrarVistaRegistro"]);
   // Rutas relacionadas con el registro de entradas y salidas

    // Ruta para registrar la entrada de un aprendiz
    Router::post('registrar_asistencia', [RegistroAsistenciaController::class, 'registrarAsistencia']);

    Router::post('obtener_computadores', [ComputadorController::class, 'obtenerComputadores']);

    Router::post('registrar_computador', [ComputadorController::class, 'registrarComputadorSeleccionado']);

    
    // Ruta para mostrar aprendices en el panel
    Router::get('panel_asistencias', [PanelAsistenciaController::class, "mostrarFuncionarios"]);
    
    // Ruta para filtrar aprendices por algún criterio
    Router::get('filtrar_funcionarios', [PanelAsistenciaController::class, "filtrarFuncionarios"]);

    // Ruta para generar un reporte en formato PDF
    Router::get('generarReporte', [ReporteController::class, "generarPDF"]);

    
?>
