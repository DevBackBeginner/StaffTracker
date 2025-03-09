<?php

  use core\Router;

  // Incluir configuración de base de datos
  require_once '../config/DataBase.php';

  // ==================================================
  // Rutas para el manejo de autenticación y sesión
  // ==================================================

  // Ruta para mostrar la página principal después de iniciar sesión
  Router::get("Inicio", [DashboardController::class, "mostrarDashBoard"]);

  Router::get('/', [DashboardController::class, "mostrarDashBoard"]);

  // Ruta para mostrar el formulario de login
  Router::get("login", [LoginController::class, "mostrarLogin"]);

  // Ruta para procesar el login (envío de formulario)
  Router::post("enviarLogin", [LoginController::class, "procesarLogin"]);

  // Ruta para cerrar sesión
  Router::get("logout", [LoginController::class, "Logout"]);

  Router::post("obtenerdatosfiltrados", [DashboardController::class, "obtenerDatosFiltrados"]);



  // ==================================================
  // Rutas para el perfil de usuario
  // ==================================================

  // Ruta para mostrar el perfil del usuario
  Router::get("perfil", [PerfilController::class, "mostrarPerfil"]);
  // Ruta para actualizar el perfil del usuario
  Router::post('actualizar', [PerfilController::class, 'actualizarPerfil']);
  // Ruta para subir una imagen de perfil
  Router::post('subir-imagen', [PerfilController::class, 'subirImagenPerfil']);
  // Ruta para elimiar una imagen de perfil
  Router::post('eliminar-imagen', [PerfilController::class, 'eliminarImagenPerfil']);
  // Ruta para actualizar la contraseña
  Router::post('actualizar-contrasena', [PerfilController::class, 'actualizarContrasena']);
  // ==================================================
  // Rutas para el registro de guardias
  // ==================================================

  // Ruta para mostrar el formulario de registro de guardias
  Router::get("registrar_guardas", [RegistrarGuardasController::class, "formularioRegistroGuardias"]);

  // Ruta para procesar el registro de guardias (envío de formulario)
  Router::post("registro_guarda", [RegistrarGuardasController::class, "registrarGuardas"]);

  // ==================================================
  // Rutas para el registro de asistencia
  // ==================================================

  // Ruta para mostrar la vista de registro de asistencia
  Router::get('registro_ingreso', [RegistroIngresoController::class, "mostrarVistaRegistro"]);

  // Ruta para procesar el registro de asistencia (envío de formulario)
  Router::post('registrar_ingreso', [RegistroIngresoController::class, 'registrarAsistencia']);

  // ==================================================
  // Rutas para el manejo de computadores
  // ==================================================

  // Ruta para obtener la lista de computadores disponibles
  Router::post('obtener_computadores', [RegistroIngresoController::class, 'obtenerComputadores']);

  // Ruta para registrar un computador seleccionado

  // ==================================================
  // Rutas para el panel de asistencias
  // ==================================================

  // Ruta para mostrar el panel de asistencias con la lista de funcionarios
  Router::get('panel_ingreso', [PanelIngresoController::class, "mostrarUsuarios"]);

  Router::get('filtro_usuarios', [PanelIngresoController::class, "filtroUsuarios"]);

?>