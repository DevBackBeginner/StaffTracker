<?php
session_start();

require_once __DIR__ . '/../models/RegistroIngresoModelo.php';
require_once __DIR__ . '/../models/HistorialRegistroModelo.php';
require_once __DIR__ . '/../controllers/ComputadorController.php';
require_once '../config/DataBase.php';

class RegistroIngresoController {
    private $registroIngresoModelo;
    private $historialModelo;
    private $computadorController;
    private $db;

    public function __construct() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $this->registroIngresoModelo = new RegistroIngresoModelo();
        $this->historialModelo = new HistorialRegistroModelo();
        $this->computadorController = new ComputadorController;
        $conn = new DataBase();
        // Asignar la conexión establecida a la propiedad $db
        $this->db = $conn->getConnection();
    }

    public function mostrarVistaRegistro() {
        $ultimosRegistros = $this->registroIngresoModelo->obtenerUltimosRegistros();
        include_once __DIR__ . '/../views/gestion/registro_ingreso/registro_ingresos.php';
    }

    public function gestionarRegistroAcceso() {
        // Configurar cabecera para respuesta JSON
        header('Content-Type: application/json');
        
        try {
            // ========= VALIDACIÓN INICIAL =========
            // Verificar método HTTP
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->jsonResponse(false, 'Método no permitido', 405);
            }

            // ========= SANITIZACIÓN DE DATOS =========
            $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $computador_id = filter_input(INPUT_POST, 'computador_id', FILTER_VALIDATE_INT) ?: null;

            // ========= REGISTRO DE COMPUTADOR =========
            if (isset($_POST['registrar_nuevo_computador'])) {
                $resultado = $this->computadorController->registrarComputador();
                if (!$resultado['success']) {
                    $this->jsonResponse(false, $resultado['message'], 400);
                }
                $computador_id = $resultado['computador_id'];
            }

            // ========= VALIDACIÓN DE DATOS =========
            if (empty(trim($codigo))) {
                $this->jsonResponse(false, 'Código no proporcionado', 400);
            }

            // ========= OBTENER USUARIO =========
            $usuario = $this->obtenerUsuario($codigo);
            if (!$usuario) {
                $this->jsonResponse(false, 'Usuario no encontrado', 404);
            }

            // ========= LÓGICA PRINCIPAL =========
            $this->db->beginTransaction(); // Iniciar transacción
            
            // Gestionar asignación computador-usuario
            $asignacion_id = $this->gestionarAsignacion(
                $usuario['id'], 
                $computador_id
            );
            
            // Verificar registro del día
            $registro = $this->registroIngresoModelo->obtenerAsistenciaDelDia(
                $asignacion_id, 
                date('Y-m-d')
            );

            // Lógica de entrada/salida
            if ($registro) {
                $this->procesarRegistroExistente($registro, $asignacion_id, $usuario);
            } else {
                $this->registrarNuevaEntrada($asignacion_id, $usuario);
            }

        } catch (Exception $e) {
            // Manejo de errores
            $this->db->rollBack();
            error_log("Error registrarAsistencia: " . $e->getMessage());
            $this->jsonResponse(false, 'Error interno del sistema', 500);
        }
    }

    // ==============================
    // MÉTODOS AUXILIARES
    // ==============================

    /**
     * Devuelve una respuesta JSON estandarizada
     * @param bool $success Estado de la operación
     * @param string $message Mensaje descriptivo
     * @param int $code Código HTTP
     */
    private function jsonResponse(bool $success, string $message, int $code = 200): void {
        http_response_code($code);
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
        exit; // Terminar ejecución
    }

    /**
     * Obtiene un usuario por su código de identificación
     * @param string $codigo Código del usuario
     * @return array|null Datos del usuario o null
     */
    private function obtenerUsuario(string $codigo): ?array {
        $usuario = $this->historialModelo->obtenerPorIdentidad($codigo);
        return ($usuario && !empty($usuario['id'])) ? $usuario : null;
    }

    /**
     * Gestiona la asignación usuario-computador
     * @param int $usuario_id ID del usuario
     * @param int|null $computador_id ID del computador (opcional)
     * @return int ID de la asignación
     */
    private function gestionarAsignacion(int $usuario_id, ?int $computador_id): int {
        // Buscar asignación existente
        $asignacion_id = $this->registroIngresoModelo->obtenerAsignacionId(
            $usuario_id, 
            $computador_id
        );
        
        // Crear nueva si no existe
        return $asignacion_id ?: $this->registroIngresoModelo->crearAsignacion(
            $usuario_id, 
            $computador_id
        );
    }

    /**
     * Procesa un registro existente (cierre de sesión)
     * @param array $registro Datos del registro
     * @param int $asignacion_id ID de asignación
     * @param array $usuario Datos del usuario
     */
    private function procesarRegistroExistente(array $registro, int $asignacion_id, array $usuario) {
        if ($registro['estado'] === 'Activo') {
            // Registrar hora de salida
            $this->registroIngresoModelo->registrarSalida(
                $asignacion_id, 
                date('Y-m-d'), 
                date('H:i:s')
            );
            $this->db->commit();
            $this->jsonResponse(true, "Salida registrada para {$usuario['nombre']}");
        }
        
        // Registro ya completado
        $this->db->commit();
        $this->jsonResponse(false, 'Asistencia ya completada hoy', 400);
    }

    /**
     * Crea un nuevo registro de entrada
     * @param int $asignacion_id ID de asignación
     * @param array $usuario Datos del usuario
     */
    private function registrarNuevaEntrada(int $asignacion_id, array $usuario) {
        // Registrar nueva entrada
        $this->registroIngresoModelo->registrarEntrada(
            date('Y-m-d'),
            date('H:i:s'),
            $asignacion_id,
            $usuario['rol'] === 'Visitante' ? 'Visitante' : 'Personal'
        );
        $this->db->commit();
        $this->jsonResponse(true, "Entrada registrada para {$usuario['nombre']}");
    }
}