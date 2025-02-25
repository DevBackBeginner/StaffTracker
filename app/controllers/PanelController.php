<?php
    // Se importa el modelo 'PanelModelo' para poder interactuar con la base de datos
    require_once __DIR__ . '/../models/PanelModelo.php';

    class PanelController {

        // Se declara la propiedad para almacenar la instancia del modelo de aprendiz
        private $panelModelo;

        // Constructor de la clase
        public function __construct() {
            // Se inicializa la propiedad $modeloAprendiz con una nueva instancia del modelo 'PanelModelo'
            $this->panelModelo = new PanelModelo();
        }

        // Método para mostrar los aprendices organizados por ficha
        public function mostralPanelPaginado() {
            // Definir la cantidad de fichas por página
            $limite = 3;
            // Obtener la página actual
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $offset = ($pagina - 1) * $limite;
            
            // Obtener los aprendices agrupados por ficha de forma paginada
            $aprendicesPorFicha = $this->panelModelo->obtenerTodosPorFichaPaginadas($limite, $offset);
        
            // Calcular el total de fichas para la paginación
            // Ajusta el método para que cuente únicamente las fichas activas, si es tu caso.
            $totalFichas = $this->panelModelo->contarFichas();
            $totalPaginas = ceil($totalFichas / $limite);
        
            // Opcional: método para detectar si es una petición AJAX
            if ($this->esAjax()) {
                // Si es AJAX, solo cargamos la vista parcial (tabla_aprendices.php)
                // Asegúrate de que estas variables estén disponibles en la vista
                include_once __DIR__ . '/../views/learners/tabla_aprendices.php';
            } else {
                // Si NO es AJAX, cargamos la vista completa (panel.php)
                include_once __DIR__ . '/../views/learners/panel.php';

                // Dentro de panel.php, puedes tener un contenedor (div) para inyectar la tabla vía AJAX
            }
        }
        
        /**
         * Verifica si la petición es AJAX revisando el encabezado X-Requested-With
         */
        private function esAjax() {
            return (
                isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
            );
        }
        

        public function filtrarAprendices() {
            // Filtros
            $ficha = $_POST['ficha'] ?? '';
            $documento = $_POST['documento'] ?? '';
        
            // Paginación
            // Podrías recibir la página desde un input hidden o por JS (por ejemplo, 'pagina' en el FormData).
            // Si no la recibes, asume página = 1.
            $pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
            $limite = 3;
            $offset = ($pagina - 1) * $limite;
        
            // Consulta al modelo: versión filtrada + paginación
            $aprendicesPorFicha = $this->panelModelo->obtenerAprendicesFiltrados($ficha, $documento, $limite, $offset);
        
            // Contar cuántos resultados hay en total (versión filtrada)
            $totalFiltrados = $this->panelModelo->contarFichas($ficha, $documento);
            $totalPaginas = ceil($totalFiltrados / $limite);
        
            // Incluir la vista parcial
            // Allí tendrás acceso a $aprendicesPorFicha, $pagina, $totalPaginas, etc.
            include_once __DIR__ . '/../views/learners/tabla_aprendices.php';
        }
        
        
    }
?>

