<?php
session_start();

require_once __DIR__ . '/../models/RegistroIngresoModelo.php';
require_once __DIR__ . '/../models/PanelIngresoModelo.php';
require_once __DIR__ . '/../models/ComputadorModelo.php';

/**
 * Clase RegistroAsistenciaController
 *
 * Controlador encargado de manejar las operaciones relacionadas con el registro de asistencia,
 * incluyendo la visualización de la página principal de asistencia y el registro de entradas/salidas.
 */
class RegistroIngresoController {
    /**
     * @var RegistroModelo $registroModelo
     *      Instancia del modelo que maneja la lógica de la tabla registro_asistencia.
     */
    private $registroIngresoModelo;

    /**
     * @var panelIngresoModelo $panelIngresoModelo
     *      Instancia del modelo que maneja la lógica de la tabla de usuarios (o panel) para obtener datos de personal.
     */
    private $panelIngresoModelo;

    private $computadorModelo;

    /**
     * Constructor:
     * Se inicializan los modelos necesarios para interactuar con la base de datos.
     */
    public function __construct() {
        // Iniciar la sesión en el constructor
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Instancia el modelo de registro de asistencia
        $this->registroIngresoModelo = new RegistroIngresoModelo();
        // Instancia el modelo para panel de asistencia (para obtener información del personal)
        $this->panelIngresoModelo = new PanelIngresoModelo();
        $this->computadorModelo = new ComputadorModelo();
    }

    /**
     * Método mostrarVistaRegistro:
     * Muestra la vista principal de asistencia, incluyendo el último registro de asistencia en la parte superior.
     */
    public function mostrarVistaRegistro() {
        // Se obtiene el último registro de asistencia guardado en la BD.
        $ultimosRegistros = $this->registroIngresoModelo->obtenerUltimosRegistros();

        // Se incluye la vista que muestra el formulario y la tabla de últimos registros.
        include_once __DIR__ . '/../views/gestion/registro_ingreso/registro_ingresos.php';
    }

    /**
     * Método registrarAsistencia:
     * Maneja la lógica de registrar la entrada o salida de un usuario (personal) según su número de identidad.
     */
    public function registrarAsistencia() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido.'
            ]);
            exit;
        }
    
        $numero_identidad = trim($_POST['codigo'] ?? '');
        $computador_id = trim($_POST['computador_id'] ?? null);
    
        if (empty($numero_identidad)) {
            echo json_encode([
                'success' => false,
                'message' => 'Código no proporcionado.'
            ]);
            exit;
        }

        
    
        try {
            $personal = $this->panelIngresoModelo->obtenerPorIdentidad($numero_identidad);
    
            if (!$personal) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Personal no encontrado.'
                ]);
                exit;
            }

            $asignacion_id = null;
    
            if ($computador_id) {
                $asignacion_id = $this->registroIngresoModelo->obtenerAsignacionId($personal['id'], $computador_id);

                if (!$asignacion_id) {
                    throw new Exception("No se encontró una asignación válida para el computador seleccionado.");
                }
            }
            
            $fecha = date('Y-m-d');
            $horaActual = date('H:i:s');
            

            $registroDelDia = $this->registroIngresoModelo->obtenerAsistenciaDelDia($asignacion_id, $fecha);
    
            if ($registroDelDia) {
                if ($registroDelDia['estado'] === 'Activo') {
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
                
                $this->registroIngresoModelo->registrarEntrada($fecha, $horaActual, $asignacion_id);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Entrada registrada correctamente para ' . $personal['nombre']
                ]);
                exit;
            }
        } catch (Exception $e) {
            error_log("Error en registrarAsistencia: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error en el sistema: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    
}