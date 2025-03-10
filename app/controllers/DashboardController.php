<?php

    // Inicia la sesión para poder acceder a las variables de sesión.
    session_start();

    // Incluye el archivo del modelo DashboardModelo, que contiene la lógica para interactuar con la base de datos.
    require_once __DIR__ . '/../models/DashboardModelo.php';
    require_once __DIR__ . '/../models/PanelIngresoModelo.php';

    // Define la clase DashboardController, que maneja la lógica del controlador del dashboard.
    class DashboardController
    {
        // Propiedad privada para almacenar una instancia del modelo DashboardModelo.
        private $dashboardModelo;
        private $panelIngresoModelo;
        // Constructor de la clase. Se ejecuta automáticamente al crear una instancia de DashboardController.
        public function __construct()
        {
            // Inicializa la propiedad $dashboardModelo con una nueva instancia de DashboardModelo.
            $this->dashboardModelo = new DashboardModelo();
            $this->panelIngresoModelo = new PanelIngresoModelo();

        }

        /**
         * Verifica si el usuario tiene un rol asignado en la sesión.
         * @return bool Retorna true si el usuario tiene un rol, false en caso contrario.
         */
        private function tieneRol()
        {
            // Comprueba si la clave 'rol' existe en $_SESSION['usuario'] y no está vacía.
            return isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] !== '';
        }

        /**
         * Muestra el dashboard si el usuario tiene un rol válido.
         * Si no tiene un rol, redirige a la página de inicio de sesión.
         */
        public function mostrarDashBoard()
        {
            // Verifica si el usuario tiene un rol asignado.
            if (!$this->tieneRol()) {
                // Si no tiene un rol, incluye la vista de inicio de sesión.
                include_once __DIR__ . '/../views/home/main.php';
            } else {

                $rol = $_GET['rol'] ?? 'Instructor';  // Valor por defecto
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Convertimos a int
            
                // 2) Validamos que la página sea al menos 1
                $page = max(1, $page);
            
                // 3) Definir roles permitidos
                $rolesPermitidos = ['Instructor', 'Funcionario', 'Directivo', 'Apoyo', 'Visitante'];
                if (!in_array($rol, $rolesPermitidos)) {
                    $rol = 'Instructor'; // Si el rol no es válido, asignamos uno por defecto
                }
            
                // 4) Definir el límite de usuarios por página y el offset
                $limit = 30;
                $offset = ($page - 1) * $limit;
            
                // 5) Obtener los usuarios del rol seleccionado
                $usuarios = $this->panelIngresoModelo->obtenerUsuariosPorRol($rol, $limit, $offset);
            
                // 6) Obtener el total de usuarios con ese rol
                $totalUsuarios = $this->panelIngresoModelo->contarUsuariosPorRol($rol);
                $totalPaginas = ($totalUsuarios > 0) ? ceil($totalUsuarios / $limit) : 1;
                
                // Si tiene un rol, obtiene los datos necesarios para el dashboard.
                $datosDashboard = $this->obtenerDatosDashboard();

                // Incluye la vista del dashboard.
                include_once __DIR__ . '/../views/gestion/dashboard/main_home.php';
            }
        }

        /**
         * Obtiene los datos necesarios para el dashboard.
         * @return array Un arreglo con los datos del dashboard.
         */
        private function obtenerDatosDashboard()
        {
            // Retorna un arreglo con los datos del dashboard.
            return [
                // Registros diarios.
                'registrosDiarios' => $this->dashboardModelo->obtenerRegistroDiario(),
                // Registros del día anterior.
                'registrosDiaAnterior' => $this->dashboardModelo->obtenerRegistrosDiaAnterior(),
                // Porcentaje de aumento diario.
                'porcentajeAumentoDiario' => $this->dashboardModelo->calcularPorcentajeAumento(
                    $this->dashboardModelo->obtenerRegistroDiario(),
                    $this->dashboardModelo->obtenerRegistrosDiaAnterior()
                ),
                // Registros diarios de funcionarios.
                'registroFuncionarioDiario' => $this->dashboardModelo->obtenerFuncionariosDiarios(),
                // Registros de funcionarios del día anterior.
                'registroFuncionarioDiaAnterior' => $this->dashboardModelo->obtenerFuncionariosDiariosAnterior(),
                // Porcentaje de aumento diario de funcionarios.
                'porcentajeAumentoFuncionarioDiario' => $this->dashboardModelo->calcularPorcentajeAumento(
                    $this->dashboardModelo->obtenerFuncionariosDiarios(),
                    $this->dashboardModelo->obtenerFuncionariosDiariosAnterior()
                ),
                // Registros diarios de visitantes.
                'registroVistanteDiario' => $this->dashboardModelo->obtenerVisitantesDiarios(),
                // Registros de visitantes del día anterior.
                'registroVistanteDiaAnterior' => $this->dashboardModelo->obtenerVisitantesDiariosAnterior(),
                // Porcentaje de aumento diario de visitantes.
                'porcentajeAumentoVistanteDiario' => $this->dashboardModelo->calcularPorcentajeAumento(
                    $this->dashboardModelo->obtenerVisitantesDiarios(),
                    $this->dashboardModelo->obtenerVisitantesDiariosAnterior()
                ),
            ];
        }

        /**
         * Obtiene los datos filtrados para el dashboard basándose en un filtro enviado por una solicitud POST.
         * Devuelve los datos en formato JSON.
         */
        public function obtenerDatosFiltrados()
        {
            try {
                // Lee el cuerpo de la solicitud POST y lo convierte en un arreglo asociativo.
                $datos = json_decode(file_get_contents('php://input'), true);

                // Obtiene el filtro del cuerpo de la solicitud. Si no existe, asigna null.
                $filtro = $datos['filtro'] ?? null;

                // Lista de filtros permitidos.
                $filtrosPermitidos = [
                    'diarios', 'semanales', 'mensuales',
                    'funcionarios_diarios', 'funcionarios_semanales', 'funcionarios_mensuales',
                    'visitantes_diarios', 'visitantes_semanales', 'visitantes_mensuales'
                ];

                // Valida si el filtro está en la lista de filtros permitidos.
                if (!in_array($filtro, $filtrosPermitidos)) {
                    // Si el filtro no es válido, devuelve un mensaje de error en formato JSON.
                    echo json_encode([
                        'error' => 'Filtro no válido'
                    ]);
                    return;
                }

                // Mapea los filtros a los métodos correspondientes del modelo.
                $metodos = [
                    'diarios' => ['obtenerRegistroDiario', 'obtenerRegistrosDiaAnterior'],
                    'semanales' => ['obtenerRegistroSemanal', 'obtenerRegistrosSemanaAnterior'],
                    'mensuales' => ['obtenerRegistroMensual', 'obtenerRegistroMensualAnterior'],
                    'funcionarios_diarios' => ['obtenerFuncionariosDiarios', 'obtenerFuncionariosDiariosAnterior'],
                    'funcionarios_semanales' => ['obtenerFuncionariosSemanales', 'obtenerFuncionariosSemanalesAnterior'],
                    'funcionarios_mensuales' => ['obtenerFuncionariosMensuales', 'obtenerFuncionariosMensualesAnterior'],
                    'visitantes_diarios' => ['obtenerVisitantesDiarios', 'obtenerVisitantesDiariosAnterior'],
                    'visitantes_semanales' => ['obtenerVisitantesSemanales', 'obtenerVisitantesSemanalesAnterior'],
                    'visitantes_mensuales' => ['obtenerVisitantesMensuales', 'obtenerVisitantesMensualesAnterior'],
                ];

                // Obtiene los métodos correspondientes al filtro seleccionado.
                $metodosFiltro = $metodos[$filtro];

                // Obtiene los datos actuales usando el primer método del filtro.
                $actual = $this->dashboardModelo->{$metodosFiltro[0]}();
                // Obtiene los datos anteriores usando el segundo método del filtro.
                $anterior = $this->dashboardModelo->{$metodosFiltro[1]}();

                // Calcula el porcentaje de aumento entre los datos actuales y anteriores.
                $porcentajeAumento = $this->dashboardModelo->calcularPorcentajeAumento($actual, $anterior);

                // Devuelve los datos en formato JSON.
                echo json_encode([
                    'total' => $actual, // Datos actuales.
                    'porcentajeAumento' => round($porcentajeAumento, 2) // Porcentaje de aumento redondeado a 2 decimales.
                ]);
            } catch (Exception $e) {
                // Si ocurre un error, devuelve un mensaje de error en formato JSON.
                echo json_encode([
                    'error' => 'Error al obtener los datos: ' . $e->getMessage()
                ]);
            }
        }
    }
?>