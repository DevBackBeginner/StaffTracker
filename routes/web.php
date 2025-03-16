<?php

use core\Router;

// Incluir configuración de base de datos
require_once '../config/DataBase.php';

// ==================================================
// Rutas para el manejo de autenticación y sesión
// ==================================================

Router::get("Inicio", [DashboardController::class, "mostrarDashBoard"]);
Router::get('/', [DashboardController::class, "mostrarDashBoard"]);
Router::get('Contactenos', [ContactoController::class, "mostrarContactenos"]);

// Ruta para mostrar el formulario de login
Router::get("Login", [LoginController::class, "mostrarLogin"]);

// Ruta para procesar el login (envío de formulario)
Router::post("enviarLogin", [LoginController::class, "procesarLogin"]);

// Ruta para cerrar sesión
Router::get("logout", [LoginController::class, "Logout"]);

// Ruta para obtener datos filtrados
Router::post("obtenerdatosfiltrados", [DashboardController::class, "obtenerDatosFiltrados"]);

// ==================================================
// Rutas para el perfil de usuario
// ==================================================

Router::get("perfil", [PerfilController::class, "mostrarPerfil"]);
Router::post('actualizar', [PerfilController::class, 'actualizarPerfil']);
Router::post('subir-imagen', [PerfilController::class, 'subirImagenPerfil']);
Router::post('eliminar-imagen', [PerfilController::class, 'eliminarImagenPerfil']);
Router::post('actualizar-contrasena', [PerfilController::class, 'actualizarContrasena']);

// ==================================================
// Rutas para el registro de guardias
// ==================================================

Router::get("registrar_guardas", [RegistrarGuardasController::class, "formularioRegistroGuardias"]);
Router::post("registro_guarda", [RegistrarGuardasController::class, "registrarGuardas"]);

// ==================================================
// Rutas para el registro de asistencia
// ==================================================

Router::get('registro_ingreso', [RegistroIngresoController::class, "mostrarVistaRegistro"]);
Router::post('registrar_ingreso', [RegistroIngresoController::class, 'registrarAsistencia']);

// ==================================================
// Rutas para el manejo de computadores
// ==================================================

Router::post('obtener_computadores', [ComputadorController::class, 'obtenerComputadores']);

// ==================================================
// Rutas para el panel de asistencias
// ==================================================

Router::get('panel_ingreso', [HistorialRegistroController::class, "mostrarUsuarios"]);
Router::get('filtro_usuarios', [HistorialRegistroController::class, "filtroUsuarios"]);

// ==================================================
// Rutas para el registro de personal
// ==================================================

Router::get('formulario_registro_personal', [PersonalController::class, 'formularioRegistroPersonal']);
Router::post('registrar_personal', [PersonalController::class, 'registrarPersonal']);


Router::get('Listado_Usuarios', [PersonalController::class, 'ListarUsuarios']);
Router::post('EditarUsuarios', [PersonalController::class, 'editarUsuarios']);
Router::post('EliminarUsuario', [PersonalController::class, 'eliminarUsuario']);

// ==================================================
// Rutas para el registro de visitantes
// ==================================================

Router::get('formulario_registro_visitante', [VisitantesController::class, 'formulario_visitante']);
Router::post('registrar_visitante', [VisitantesController::class, 'registrarVisitante']);

?>