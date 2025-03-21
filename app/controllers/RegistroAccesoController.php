<?php
    session_start();
    require_once __DIR__ . '/../Models/RegistroAccesoModelo.php';
    require_once __DIR__ . '/../Models/HistorialRegistroModelo.php';
    require_once __DIR__ . '/../Controllers/ComputadorController.php';
    require_once '../config/DataBase.php';

    class RegistroAccesoController {
        private $registroAcceso;
        private $historialModelo;
        private $db;

        public function __construct() {
            // Configurar manejo de errores
            ini_set('display_errors', 0);
            error_reporting(E_ALL);
            ini_set('log_errors', 1);
            ini_set('error_log', __DIR__ . '/php-errors.log');
    
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
    
            $this->registroAcceso = new RegistroAccesoModelo();
            $this->historialModelo = new HistorialRegistroModelo();
    
            $conn = new DataBase();
            $this->db = $conn->getConnection();
        }
        
        public function mostrarRegistroAcceso() {
            // Obtener los últimos registros de acceso
            $ultimosRegistros = $this->registroAcceso->obtenerUltimosRegistros();
        
            // Incluir la vista
            include_once __DIR__ . '/../Views/gestion/registro_ingreso/registro_ingresos.php';
        }

        public function mostrarRegistroSalida() {
            // Obtener los últimos registros de acceso
            $ultimosRegistros = $this->registroAcceso->obtenerUltimosRegistrosSalida();
        
            // Incluir la vista
            include_once __DIR__ . '/../Views/gestion/registro_salida/registro_salida.php';
        }

        public function registrarEntrada() {
            // Limpiar el buffer de salida
            ob_clean();
        
            // Establecer cabecera JSON
            header('Content-Type: application/json');
        
            try {
                // Validar método HTTP
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    throw new Exception('Método no permitido', 405);
                }
        
                // Sanitizar y validar datos
                $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $computador_id = filter_input(INPUT_POST, 'computador_id', FILTER_VALIDATE_INT) ?: null;
        
                if (empty(trim($codigo))) {
                    throw new Exception('Código no proporcionado', 400);
                }
        
                // Obtener usuario
                $usuario = $this->obtenerUsuario($codigo);
                if (!$usuario) {
                    throw new Exception('Usuario no encontrado', 404);
                }
        
                // Iniciar transacción
                $this->db->beginTransaction();
        
                // Gestionar asignación
                $asignacion_id = $this->gestionarAsignacion($usuario['id'], $computador_id);
        
                // Verificar si ya tiene un registro de entrada
                $registro = $this->registroAcceso->obtenerAsistenciaDelDia($asignacion_id, date('Y-m-d'));
                if ($registro && $registro['hora_entrada']) {
                    throw new Exception('Este usuario ya ha registrado su entrada', 400);
                }
        
                // Registrar nueva entrada
                $this->registroAcceso->registrarEntrada(
                    date('Y-m-d'),
                    date('H:i:s'),
                    $asignacion_id,
                    $usuario['rol'] === 'Visitante' ? 'Visitante' : 'Personal'
                );
        
                // Confirmar transacción
                $this->db->commit();
        
                // Respuesta JSON exitosa
                echo json_encode([
                    'success' => true,
                    'message' => "Entrada registrada para {$usuario['nombre']}"
                ]);
            } catch (Exception $e) {
                // Revertir transacción si está activa
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
        
                error_log("Error en registrarEntrada: " . $e->getMessage());
        
                // Respuesta JSON de error
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ]);
            }
            exit; // Terminar la ejecución del script
        }

        public function registrarSalida() {
            // Limpiar el buffer de salida
            ob_clean();
            
            // Establecer cabecera JSON
            header('Content-Type: application/json');
            
            // Iniciar transacción
            $this->db->beginTransaction();
            
            try {
                // Validar método HTTP
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Método no permitido'
                    ]);
                    return;
                }
                
                // Sanitizar y validar datos
                $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $computador_id = filter_input(INPUT_POST, 'computador_id', FILTER_VALIDATE_INT) ?: null;
        
                if (empty(trim($codigo))) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Código no proporcionado'
                    ]);
                    return;
                }
                
                // Obtener usuario
                $usuario = $this->obtenerUsuario($codigo);
                if (!$usuario) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Usuario no encontrado'
                    ]);
                    return;
                }
                
                // Validar si el usuario tiene una asignación activa
                $asignacion_id = $this->registroAcceso->obtenerAsignacionId($usuario['id'], $computador_id);
                if (!$asignacion_id) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'El usuario no tiene una asignación activa'
                    ]);
                    return;
                }
                
                // Verificar si tiene un registro de entrada sin salida
                $registro = $this->registroAcceso->obtenerAsistenciaDelDia($asignacion_id, date('Y-m-d'));
                if (!$registro) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'No se encontró un registro de entrada para hoy'
                    ]);
                    return;
                }
                
                // Verificar si ya se registró la salida
                if ($registro['hora_salida']) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'La salida ya ha sido registrada'
                    ]);
                    return;
                }
                
                // Verificar si no hay hora de entrada
                if (!$registro['hora_entrada']) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'No se puede registrar la salida sin una entrada previa'
                    ]);
                    return;
                }
                
                // Registrar salida
                $this->registroAcceso->registrarSalida($asignacion_id, date('Y-m-d'), date('H:i:s'));
                
                // Confirmar la transacción
                $this->db->commit();
                
                // Respuesta JSON exitosa
                echo json_encode([
                    'success' => true,
                    'message' => "Salida registrada para {$usuario['nombre']}"
                ]);
            } catch (Exception $e) {
                // Revertir la transacción si hay un error
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                
                // Log del error
                error_log("Error en registrarSalida: " . $e->getMessage());
                
                // Respuesta JSON de error
                echo json_encode([
                    'success' => false,
                    'message' => 'Error interno del sistema'
                ]);
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
            http_response_code($code); // Establece el código de respuesta HTTP
            echo json_encode([
                'success' => $success,
                'message' => $message
            ]);
            exit; // Termina la ejecución del script
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
            $asignacion_id = $this->registroAcceso->obtenerAsignacionId($usuario_id, $computador_id);
            // Crear nueva si no existe
            return $asignacion_id ?: $this->registroAcceso->crearAsignacion($usuario_id, $computador_id);
        }

    }
?>