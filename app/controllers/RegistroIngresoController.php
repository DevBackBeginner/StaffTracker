<?php
session_start();

require_once __DIR__ . '/../models/RegistroIngresoModelo.php';
require_once __DIR__ . '/../models/PanelRegistrosModelo.php';
require_once __DIR__ . '/../models/ComputadorModelo.php';

class RegistroIngresoController {
    private $registroIngresoModelo;
    private $panelRegistroModelo;
    private $computadorModelo;

    public function __construct() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $this->registroIngresoModelo = new RegistroIngresoModelo();
        $this->panelRegistroModelo = new PanelRegistrosModelo();
        $this->computadorModelo = new ComputadorModelo();
    }

    public function mostrarVistaRegistro() {
        $ultimosRegistros = $this->registroIngresoModelo->obtenerUltimosRegistros();
        include_once __DIR__ . '/../views/gestion/registro_ingreso/registro_ingresos.php';
    }

    public function registrarAsistencia() {
        // Verificar que la solicitud sea de tipo POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido.'
            ]);
            exit;
        }
    
        // Obtener el código y el computador_id de la solicitud POST
        $codigo = trim($_POST['codigo'] ?? '');
        $computador_id = trim($_POST['computador_id'] ?? null);
    
        // Validar que el código no esté vacío
        if (empty($codigo)) {
            echo json_encode([
                'success' => false,
                'message' => 'Código no proporcionado.'
            ]);
            exit;
        }
    
        try {
            // Obtener el usuario por su número de identidad
            $personal = $this->panelRegistroModelo->obtenerPorIdentidad($codigo);
    
            // Verificar si el usuario existe
            if (!$personal) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Personal no encontrado.'
                ]);
                exit;
            }
    
            // Obtener el ID del usuario, la fecha actual y la hora actual
            $usuario_id = $personal['id'];
            $fecha = date('Y-m-d');
            $horaActual = date('H:i:s');
    
            // Determinar el tipo de usuario basado en el rol
            $tipo_usuario = ($personal['rol'] === 'Visitante') ? 'Visitante' : 'Personal';
    
            // Si no se proporciona un computador_id, usar NULL
            if (empty($computador_id)) {
                $computador_id = null; // Asignar NULL si no hay computador
            }
    
            // Verificar si ya existe una asignación para el usuario y el computador (o sin computador)
            $asignacion_id = $this->registroIngresoModelo->obtenerAsignacionId($usuario_id, $computador_id);
    
            // Si no existe una asignación, crear una nueva
            if (!$asignacion_id) {
                $asignacion_id = $this->registroIngresoModelo->crearAsignacion($usuario_id, $computador_id);
            }
    
            // Verificar si ya existe un registro de asistencia para el día actual
            $registroDelDia = $this->registroIngresoModelo->obtenerAsistenciaDelDia($asignacion_id, $fecha);
    
            if ($registroDelDia) {
                if ($registroDelDia['estado'] === 'Activo') {
                    // Registrar la salida
                    $this->registroIngresoModelo->registrarSalida($asignacion_id, $fecha, $horaActual);
                    echo json_encode([
                        'success' => true,
                        'message' => 'Salida registrada correctamente para ' . $personal['nombre']
                    ]);
                    exit;
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Asistencia ya completada para el día de hoy.'
                    ]);
                    exit;
                }
            } else {
                // Registrar la entrada con el tipo de usuario
                $this->registroIngresoModelo->registrarEntrada($fecha, $horaActual, $asignacion_id, $tipo_usuario);
                echo json_encode([
                    'success' => true,
                    'message' => 'Entrada registrada correctamente para ' . $personal['nombre']
                ]);
                exit;
            }
        } catch (Exception $e) {
            // Manejar errores y registrar en el log
            error_log("Error en registrarAsistencia: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error en el sistema: ' . $e->getMessage()
            ]);
            exit;
        }
    }
}