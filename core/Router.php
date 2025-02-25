<?php

    namespace core;

    class Router {
        // Atributos
        private static $rutas = [];

        // Método para agregar rutas tipo GET
        public static function get($url, $llamarFuncion)
        {
            $url = trim($url, "/");
            self::$rutas["GET"][$url] = $llamarFuncion;
        }

        // Método para agregar rutas tipo POST
        public static function post($url, $llamarFuncion)
        {
            $url = trim($url, "/");
            self::$rutas["POST"][$url] = $llamarFuncion;
        }

        // Método para ver las rutas que se almacenaron en el atributo rutas que es array
        public static function obtenerRuta()
        {
            $metodo = $_SERVER["REQUEST_METHOD"];
            $uri = $_SERVER["REQUEST_URI"];
            $posicionPublic = strpos($uri, "public");

            // Borramos los slashes al inicio y al final de la ruta y extraemos ruta después de la palabra "public"
            $uri = trim(substr($uri, $posicionPublic + 6), "/");

            foreach (self::$rutas[$metodo] as $ruta => $funcionCall) {
                $uri = trim($uri, "/");
                
                // inicio de paginacion en la url se mirara asi: /categorias?pagina=x
                // Extraemos "?pagina=x", para dejar la url funcional del enrutador.
                if (strpos($uri, "?")) {
                    $uri = substr($uri, 0, strpos($uri, "?"));
                }

                // Si hay ':' en la ruta, modificar la ruta
                if (strpos($ruta, ":")) {
                    // La ruta ahora tiene un subpatrón, que será comparado con la URI
                    $ruta = preg_replace("#:[a-zA-Z0-9]+#", "([a-zA-Z0-9]+)", $ruta);
                }

                // Valida la expresión regular con la URI
                if (preg_match("%^$ruta$%", $uri, $coindiceRutaUri)) {
                    // Creamos otro array desde el otro arreglo pero desde el índice 1, por si enviamos más variables por la URL
                    $misVariablesUrl = array_slice($coindiceRutaUri, 1);

                    // Comprobar si lo que se envió de rutasWeb ($funcionCall) es una función, o es un array (clase controlador, el método)
                    if (is_callable($funcionCall)) {
                        $respuesta = $funcionCall(...$misVariablesUrl); // Enviamos todo el array ($misVariablesUrl), y en rutasWeb recibirlo
                    } else {
                        // Es array, entonces -> Instanciar la clase InicioControlador
                        // $controlar = new InicioControlador[0];
                        // $controlar->inicio();
                        $controlador = new $funcionCall[0];
                        $respuesta = $controlador->{$funcionCall[1]}(...$misVariablesUrl);
                    }
                    echo (is_array($respuesta) || is_object($respuesta)) ? json_encode($respuesta) : $respuesta;
                    return;
                }
            }
            
            echo "<br><br><br>No existe la página web. Error 404<br>";
        }
    }
?>
