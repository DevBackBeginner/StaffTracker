<?php

use core\Router;

// Incluir configuración de base de datos
require_once '../config/DataBase.php';

// ==================================================
// Rutas para el manejo de autenticación y sesión
// ==================================================

Router::get("Inicio", [DashboardController::class, "mostrarDashBoard"]);
Router::get('/', [DashboardController::class, "mostrarDashBoard"]);
Router::post("obtenerdatosfiltrados", [DashboardController::class, 'obtenerDatosFiltrados']);
Router::get("Login", [LoginController::class, "mostrarLogin"]);
Router::post("enviarLogin", [LoginController::class, "procesarLogin"]);
Router::get("logout", [LoginController::class, "Logout"]);
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

Router::get('registro_ingreso', [RegistroAccesoController::class, "mostrarRegistroAcceso"]);
Router::post('gestion_registro_acceso', [RegistroAccesoController::class, 'registrarEntrada']);
Router::get("registro_salida", [RegistroAccesoController::class, "mostrarRegistroSalida"]);
Router::post('gestion_registro_salida', [RegistroAccesoController::class, "registrarSalida"]);

// ==================================================
// Rutas para el manejo de computadores
// ==================================================

Router::post("registrar_computador", [ComputadorController::class, "registrarComputador"]);
Router::post('obtener_computadores', [ComputadorController::class, 'obtenerComputadores']);

// ==================================================
// Rutas para el panel de asistencias
// ==================================================

Router::get('panel_ingreso', [HistorialRegistroController::class, "mostrarUsuarios"]);
Router::get('filtro_usuarios', [HistorialRegistroController::class, "filtroUsuarios"]);

// ==================================================
// Rutas para el registro y edicion de personal
// ==================================================

Router::get('formulario_registro_personal', [GestionPersonalController::class, 'formularioRegistroPersonal']);
Router::post('registrar_personal', [GestionPersonalController::class, 'registrarPersonal']);
Router::get('Listado_Usuarios', [GestionPersonalController::class, 'ListarUsuarios']);
Router::post('EditarUsuarios', [GestionPersonalController::class, 'editarUsuarios']);
Router::post('EliminarUsuario', [GestionPersonalController::class, 'eliminarUsuario']);

// ==================================================
// Rutas para el registro de visitantes
// ==================================================

Router::get('formulario_registro_visitante', [GestionVisitantesController::class, 'formulario_visitante']);
Router::post('registrar_visitante', [GestionVisitantesController::class, 'registrarVisitante']);
Router::get('registrar-acceso-visitantes', [GestionVisitantesController::class, 'gestionarAccesoVisitantes']);

// ==================================================
// Rutas para reportes
// ==================================================

Router::get('reportes', [ReportController::class, 'Reportes']);
Router::get('reporte_graficos', [ReportController::class, 'generarReporteGraficos']);

?>