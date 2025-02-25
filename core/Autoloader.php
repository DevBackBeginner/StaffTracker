<?php

    spl_autoload_register(function ($class) {
        // Define rutas base donde buscar clases
        $paths = [
            "../app/controllers/",
            "../app/models/",
            "../core/"
        ];

        foreach ($paths as $path) {
            $file = $path . $class . ".php";
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
        
        // Si la clase no se encuentra
        die("Error: No se pudo cargar la clase $class");
    });
?>
