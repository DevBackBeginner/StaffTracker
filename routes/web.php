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
Router::get("login", [LoginController::class, "mostrarLogin"]);
Router::post("enviarLogin", [LoginController::class, "procesarLogin"]);
Router::get("logout", [LoginController::class, "Logout"]);
Router::get('recuperar-contrasena', [LoginController::class, "mostrarRecuperarContrasena"]);
Router::post('procesar-recuperar-contrasena', [LoginController::class, 'procesarRecuperarContrasena']);
Router::get('restablecer-contrasena', [LoginController::class, "mostrarRestablecerContrasena"]);
Router::post('procesar-restablecer-contrasena', [LoginController::class, 'procesarRestablecerContrasena']);


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

Router::get("registrar_guardas", [GuardasController::class, "formularioRegistroGuardias"]);
Router::post("registro_guarda", [GuardasController::class, "registrarGuardas"]);
Router::get('listado_guardas', [GuardasController::class, 'listarGuardas']);
Router::post("EditarGuarda", [GuardasController::class, 'actualizarInformacionGuarda']);
Router::post("EliminarGuarda", [GuardasController::class, 'eliminarGuarda']);

// ==================================================
// Rutas para el registro de asistencia
// ==================================================

Router::get('registro_ingreso', [RegistroController::class, "mostrarRegistroAcceso"]);
Router::post('registrar_ingreso', [RegistroController::class, 'registrarEntrada']);
Router::get("registro_salida", [RegistroController::class, "mostrarRegistroSalida"]);
Router::post('registrar_salida', [RegistroController::class, "registrarSalida"]);

// ==================================================
// Rutas para el manejo de computadores
// ==================================================

Router::post("registrar_computador", [ComputadorController::class, "registrarComputadorYasignacion"]);
Router::post('obtener_computadores', [ComputadorController::class, 'obtenerComputadores']);

// ==================================================
// Rutas para el panel de asistencias
// ==================================================

Router::get('historial_registros', [HistorialRegistroController::class, "mostrarUsuarios"]);
Router::get('filtro_usuarios', [HistorialRegistroController::class, "filtroUsuarios"]);

// ==================================================
// Rutas para el registro y edicion de personal
// ==================================================

Router::get('formulario_registro_personal', [PersonalController::class, 'formularioRegistroPersonal']);
Router::post('registrar_personal', [PersonalController::class, 'registrarPersonal']);
Router::get('listado_personal', [PersonalController::class, 'listarPersonal']);
Router::post('EditarPersonal', [PersonalController::class, 'editarPersonal']);
Router::post('EliminarPersonal', [PersonalController::class, 'desactivarPersonal']);

// ==================================================
// Rutas para el registro de visitantes
// ==================================================

Router::get('formulario_registro_visitante', [VisitantesController::class, 'formulario_visitante']);
Router::post('registrar_visitante', [VisitantesController::class, 'registrarVisitante']);
Router::get('registrar-acceso-visitantes', [VisitantesController::class, 'gestionarAccesoVisitantes']);
Router::get('listado_visitantes', [VisitantesController::class, 'listarVisitantes']);

// ==================================================
// Rutas para reportes
// ==================================================

Router::get('ReporteGeneral', [ReportController::class, 'ReporteGeneral']);
Router::get('ReporteDiario', [ReportController::class, 'ReporteDiario']);
Router::get('ReporteMensual', [ReportController::class, 'ReporteMensual']);

Router::get('reporte_graficos', [ReportController::class, 'generarReporteGraficos']);

?>