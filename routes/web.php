<?php

    use core\Router;

    // Incluir configuración de base de datos
    require_once '../config/DataBase.php';

    // Rutas para el manejo de autenticación y sesión

    // Ruta para mostrar la página principal después de iniciar sesión
    Router::get("Inicio", [PaginaController::class, "mostrarHome"]);

    Router::get('/', [PaginaController::class, "mostrarHome"]);

      // Ruta para mostrar el formulario de login
    Router::get("login", [PaginaController::class, "mostrarLogin"]);

    // Ruta para procesar el login
    Router::post("enviarLogin", [LoginController::class, "procesarLogin"]);

    // Ruta para cerrar sesión
    Router::get("logout", [LoginController::class, "Logout"]);


    Router::get("panel_administracion", [PaginaController::class, "mostrarDashBoard"]);
    

    Router::get("registrar_guardas", [PaginaController::class, "mostrarRegistro"]);

    Router::post("registro_guarda", [RegistrarGuardasController::class, "registrarGuardas"]);


    

    Router::get('registro_asistencia', [RegistroAsistenciaController::class, "mostrarVistaRegistro"]);

    Router::post('registrar_asistencia', [RegistroAsistenciaController::class, 'registrarAsistencia']);

    Router::post('obtener_computadores', [ComputadorController::class, 'obtenerComputadores']);

    Router::post('registrar_computador', [ComputadorController::class, 'registrarComputadorSeleccionado']);

    
    Router::get('panel_asistencias', [PanelAsistenciaController::class, "mostrarFuncionarios"]);
    
    Router::get('filtrar_funcionarios', [PanelAsistenciaController::class, "filtrarFuncionarios"]);


    
?>
