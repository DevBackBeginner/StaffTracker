
<?php

    require_once __DIR__ . '/../models/ComputadorModelo.php';
    require_once __DIR__ . '/../models/HistorialRegistroModelo.php';

    class ComputadorController {
        private $computadorModelo;
        private $historialModelo;

        public function __construct() {
            $this->computadorModelo = new ComputadorModelo();
            $this->historialModelo = new HistorialRegistroModelo();
        }

        public function registrarComputador() {
            // Verificar que la solicitud sea de tipo POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode([
                    'success' => false,
                    'message' => 'Método no permitido.'
                ]);
                exit;
            }
    
            // Obtener datos del formulario
            $marca = trim($_POST['marca'] ?? '');
            $codigo = trim($_POST['codigo'] ?? '');
            $tipo = trim($_POST['tipo'] ?? ''); // 'Personal' o 'Sena'
    
            // Validar datos
            if (empty($marca) || empty($codigo) || empty($tipo)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Todos los campos son obligatorios.'
                ]);
                exit;
            }
    
            try {
                // Registrar el computador en la base de datos
                $computador_id = $this->computadorModelo->ingresarComputador($marca, $codigo, $tipo);
    
                echo json_encode([
                    'success' => true,
                    'message' => 'Computador registrado correctamente.',
                    'computador_id' => $computador_id
                ]);
            } catch (Exception $e) {
                error_log("Error en registrarComputador: " . $e->getMessage());
                echo json_encode([
                    'success' => false,
                    'message' => 'Error en el sistema: ' . $e->getMessage()
                ]);
            }
        }

        /**
         * Método obtenerComputadores:
         * Obtiene los computadores asociados a un usuario según el tipo (Sena, Personal).
         */
        public function obtenerComputadores() {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode([]);
                exit;
            }
        
            try {
                // El tipo de computador (Sena, Personal) que viene del front
                $tipo = $_POST['tipoComputador'] ?? '';
                
                // El código (número de identidad) que viene del front
                $codigo = $_POST['codigo'] ?? '';
                
                // Log para depurar
                error_log("Tipo recibido en el backend: " . $tipo);
                error_log("Código recibido en el backend: " . $codigo);
        
                // Validar los datos recibidos
                if (empty($tipo) || empty($codigo)) {
                    throw new Exception('Faltan datos necesarios.');
                }
        
                // Obtener el usuario por su código (número de identidad)
                $personal = $this->historialModelo->obtenerPorIdentidad($codigo);
        
                if (!$personal) {
                    throw new Exception('Personal no encontrado.');
                }
        
                // Obtener el ID del usuario
                $usuarioId = $personal['id'];
        
                // Validar los datos recibidos
                $validacion = $this->validarDatos($usuarioId, $tipo);
                if ($validacion !== true) {
                    throw new Exception($validacion);
                }
        
                // Llamar al modelo para obtener los computadores del usuario
                $computadores = $this->computadorModelo->obtenerComputadoresPorUsuario($usuarioId, $tipo);
        
                header('Content-Type: application/json');
                echo json_encode($computadores);
                exit;
            } catch (Exception $e) {
                error_log("Error en obtenerComputadores: " . $e->getMessage());
                header('Content-Type: application/json');
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }

        /**
         * Método validarDatos:
         * Valida que los datos recibidos sean correctos.
         */
        private function validarDatos($usuarioId, $tipo) {
            // Validar que el tipo sea válido
            if ($tipo !== 'Sena' && $tipo !== 'Personal') {
                return 'El tipo de computador no es válido. Debe ser "Sena" o "Personal".';
            }

            // Validar que el usuarioId no esté vacío
            if (!$usuarioId) {
                return 'Falta el ID de usuario en la sesión o en la solicitud.';
            }

            // Si todo está bien, devolver true
            return true;
        }
    }
?>