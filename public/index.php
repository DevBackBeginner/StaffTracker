<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once '../core/Autoloader.php';
    require_once '../core/Router.php';

    $router = new core\Router;
    
    // Cargar las rutas
    require_once '../routes/web.php';

    // Procesar la solicitud
    $router->obtenerRuta();
?>
