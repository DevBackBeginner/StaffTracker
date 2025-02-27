<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - SENA</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css">
  <link rel="icon" href="/ControlAssistance/public/assets/img/logo.png" type="image/gif" />
  <style>
    body {
      display: flex;
      margin: 0;
      font-family: Arial, sans-serif;
    }
    /* Sidebar con fondo oscuro */
    .sidebar {
      width: 250px;
      height: 100vh;
      background: #343a40;
      color: white;
      position: fixed;
      left: 0;
      top: 0;
      display: flex;
      flex-direction: column;
    }
    /* Encabezado con logo integrado (sin fondo blanco) */
    .sidebar-header {
      padding: 15px;
      text-align: center;
    }
    .sidebar-header img {
      max-width: 80%;
      height: auto;
    }
    /* Línea separadora (hr) */
    .sidebar hr {
      border-top: 1px solid #dee2e6;
      margin: 0;
    }
    /* Menú usando componentes Bootstrap (list-group) */
    .sidebar .list-group-item {
      border: none;
      padding: 15px;
      background: #343a40;
      color: white;
    }
    .sidebar .list-group-item:hover {
      background: #495057;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
      flex: 1;
    }
    /* Acento institucional */
    .accent {
      color: #fc7323;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <nav class="sidebar">
    <div class="sidebar-header">
      <a href="#">
        <img src="/ControlAssistance/public/assets/img/logo.png" alt="Logo SENA">
      </a>
    </div>
    <hr class="my-0">
    <div class="list-group list-group-flush">
      <a href="#" class="list-group-item list-group-item-action">
        <i class='bx bxs-dashboard'></i> Dashboard
      </a>
      <a href="#" class="list-group-item list-group-item-action">
        <i class='bx bxs-user'></i> Usuarios
      </a>
      <a href="#" class="list-group-item list-group-item-action">
        <i class='bx bxs-cog'></i> Configuración
      </a>
      <a href="#" class="list-group-item list-group-item-action">
        <i class='bx bx-log-out'></i> Cerrar sesión
      </a>
    </div>
  </nav>

  <!-- Contenido principal -->
  <main class="content container-fluid">
    <h1 class="mt-4 accent">Bienvenido al Panel de Administración</h1>
    <p>Aquí puedes gestionar tu sitio web siguiendo los lineamientos del Manual de Identidad Corporativa SENA.</p>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
