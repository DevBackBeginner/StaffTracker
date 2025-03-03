
<?php
    require_once __DIR__ . '/../models/ComputadorModelo.php';

    session_start();

    class ComputadorController {
        private $computadorModelo;

        public function __construct() {
            $this->computadorModelo = new ComputadorModelo();
        }

        // Obtener lista de computadores según el tipo
        // Llamada POST: fetch("obtener_computadores", { method: "POST", body: "tipo=SENA"... })
        public function obtenerComputadores() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // El tipo de computador (Sena, Personal) que viene del front
                $tipo = $_POST['tipoComputador'] ?? '';
        
                // Tomar el ID de usuario desde la sesión
                $usuarioId = $_SESSION['usuario_id'] ?? null;
        
                // Log para depurar
                error_log("Tipo recibido en el backend: " . $tipo);
                error_log("Usuario en sesión: " . $usuarioId);
        
                // Validar
                if (!$usuarioId || ($tipo !== 'Sena' && $tipo !== 'Personal')) {
                    echo json_encode([]);
                    return;
                }
        
                // Llamar al modelo para obtener los computadores del usuario
                $computadores = $this->computadorModelo->obtenerComputadoresPorUsuario($usuarioId, $tipo);
        
                header('Content-Type: application/json');
                echo json_encode($computadores);
                exit;
            }
            // Si no es POST, devolver vacío
            echo json_encode([]);
            exit;
        }
        

        // Registrar la selección de un computador
        public function registrarComputadorSeleccionado() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                $usuarioId = $_SESSION['usuario_id'] ?? null;            
                $computadorId = $_POST['computador_id'] ?? null;

                if (!$usuarioId || !$computadorId) {
                    echo "Faltan datos para asignar el computador.";
                    exit;
                }

                $resultado = $this->computadorModelo->asignarComputador($usuarioId, $computadorId);
                if ($resultado) {
                    echo "Computador asignado correctamente.";
                } else {
                    echo "Error al asignar el computador.";
                }
                exit;
            }
        }
    }
?>