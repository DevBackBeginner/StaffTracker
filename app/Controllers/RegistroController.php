<?php
    // Iniciar sesión para mantener estado del usuario
    session_start();

    // Cargar dependencias necesarias
    require_once __DIR__ . '/../Models/registroModelo.php';
    require_once '../config/DataBase.php';

    class RegistroController {
        
        private $registroModelo;  // Instancia del modelo de registro
        private $db;        // Conexión a la base de datos

        public function __construct() {
            /**
             * Configuración inicial para manejo de errores:
             * - Desactivar visualización de errores en producción
             * - Registrar todos los errores
             * - Especificar archivo de log para errores PHP
             */
            ini_set('display_errors', 0);
            error_reporting(E_ALL);
            ini_set('log_errors', 1);
            ini_set('error_log', __DIR__ . '/php-errors.log');

            // Inicializar modelo y conexión a base de datos
            $this->registroModelo = new registroModelo();
            $conn = new DataBase();
            $this->db = $conn->getConnection();
        }
        
        /**
         * Muestra la vista para registrar ingresos
         */
        public function mostrarRegistroAcceso() {
            
            include_once __DIR__ . '/../Views/gestion/registro_ingreso/registro_ingresos.php';
        }

        /**
         * Muestra la vista para registrar salidas
         */
        public function mostrarRegistroSalida() {
            include_once __DIR__ . '/../Views/gestion/registro_salida/registro_salida.php';
        }

        /**
         * Procesa el registro de entrada de usuarios
         * 
         * Método que maneja:
         * - Validación de datos de entrada
         * - Verificación de usuario
         * - Gestión de equipos asociados
         * - Registro en base de datos
         * 
         * @return JSON Respuesta con resultado de la operación
         */
        public function registrarEntrada() {
            // Limpiar buffer de salida y establecer cabecera JSON
            ob_clean();
            header('Content-Type: application/json');
            
            try {
                // --- VALIDACIONES INICIALES ---
                
                // Asegurar que sea una petición POST
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    throw new Exception('Método no permitido', 405);
                }
                
                // Sanitizar y validar datos de entrada
                $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $computador_id = filter_input(INPUT_POST, 'computador_id', FILTER_VALIDATE_INT) ?: null;
                $tipo_computador = filter_input(INPUT_POST, 'tipo_computador', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
                // Normalizar valores de tipo de computador
                if ($tipo_computador === 'Personal') $tipo_computador = 'computador_personal';
                if ($tipo_computador === 'Sena') $tipo_computador = 'computador_sena';

                // Validar que se haya proporcionado un código
                if (empty(trim($codigo))) {
                    throw new Exception('Código no proporcionado', 400);
                }
                
                // Validar tipo de computador si se proporcionó
                if ($computador_id && $tipo_computador) {
                    if (!in_array($tipo_computador, ['computador_personal', 'computador_sena'])) {
                        throw new Exception('Tipo de computador no válido', 400);
                    }
                }
                
                // --- OBTENER INFORMACIÓN DEL USUARIO ---
                
                // Buscar usuario en base de datos
                $usuario = $this->registroModelo->obtenerUsuarioPorDocumento($codigo);
                if (!$usuario) {
                    throw new Exception('Usuario no encontrado', 404);
                }
                
                // --- GESTIÓN DE TRANSACCIÓN EN BASE DE DATOS ---
                
                // Iniciar transacción para asegurar integridad de los datos
                $this->db->beginTransaction();
                
                // --- VALIDACIÓN DE EQUIPO (SI APLICA) ---
                $validacion_equipo_id = null;
                
                if ($computador_id && $tipo_computador) {
                    /**
                     * Verificar que el computador esté asignado al usuario:
                     * - Previene registrar equipos no autorizados
                     */
                    if (!$this->registroModelo->verificarAsignacionComputador($computador_id, $tipo_computador, $usuario['id_persona'])) 
                    {
                        throw new Exception('El computador no está asignado a este usuario', 403);
                    }
                    
                    /**
                     * Obtener o crear registro de validación de equipo:
                     * - Evita duplicados en la tabla validacion_equipos
                     * - Reutiliza validaciones existentes
                     */
                    $validacion_equipo_id = $this->registroModelo->obtenerIdValidacionEquipo( $computador_id,  $tipo_computador);
                }
                
                // --- VERIFICAR REGISTRO EXISTENTE ---
                
                // Buscar registros de entrada del día para este usuario
                $registroExistente = $this->registroModelo->obtenerRegistroDelDia($usuario['id_persona'], date('Y-m-d'));
                
                // Validación específica para evitar duplicados con el mismo equipo
                if ($validacion_equipo_id && $registroExistente) {
                    // Verificar si ya tiene un registro activo con este mismo equipo
                    if ($registroExistente['id_validacion_equipo'] == $validacion_equipo_id &&  $registroExistente['hora_ingreso'] && !$registroExistente['hora_salida']) 
                    {
                        throw new Exception
                        (
                            'Ya tienes un registro activo con este computador (desde ' . $registroExistente['hora_ingreso'] . '). Debes registrar la salida primero.',400
                        );
                    }
                }
                
                // --- REGISTRAR NUEVA ENTRADA ---
                $this->registroModelo->registrarNuevaEntrada($usuario['id_persona'], $validacion_equipo_id);
                
                // Confirmar todas las operaciones en la base de datos
                $this->db->commit();
                
                // --- PREPARAR RESPUESTA EXITOSA ---
                echo json_encode([
                    'success' => true,
                    'message' => "Entrada registrada para {$usuario['nombre']}",
                    'datos' => [
                        'usuario' => $usuario,
                        'equipo' => $computador_id ? [
                            'id' => $computador_id,
                            'tipo' => $tipo_computador,
                            'validacion_id' => $validacion_equipo_id
                        ] : null,
                        'hora_entrada' => date('H:i:s')
                    ]
                ]);
                
            } catch (Exception $e) {
                // --- MANEJO DE ERRORES ---
                
                // Revertir transacción si hay algún error
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                
                // Registrar error en archivo de log
                error_log("Error en registrarEntrada: " . $e->getMessage());
                
                // Preparar respuesta de error
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ]);
            }
            exit;
        }
        
        public function registrarSalida() {
            ob_clean();
            header('Content-Type: application/json');
            
            try {
                // Validar método HTTP
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    throw new Exception('Método no permitido', 405);
                }
        
                // Obtener y validar datos de entrada
                $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $computador_id = filter_input(INPUT_POST, 'computador_id', FILTER_VALIDATE_INT);
                $tipo_computador = filter_input(INPUT_POST, 'tipo_computador', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
                // Convertir tipo de computador si es necesario
                if ($tipo_computador === 'Personal') $tipo_computador = 'computador_personal';
                if ($tipo_computador === 'Sena') $tipo_computador = 'computador_sena';
        
                if (empty($codigo)) {
                    throw new Exception('Código no proporcionado', 400);
                }
        
                // Obtener usuario
                $usuario = $this->registroModelo->obtenerUsuarioPorDocumento($codigo);
                if (!$usuario) {
                    throw new Exception('Usuario no encontrado', 404);
                }
        
                // Iniciar transacción
                $this->db->beginTransaction();
        
                // Determinar si tiene computador (manejo explícito de valores vacíos)
                $tieneComputador = ($computador_id !== false && $computador_id !== null && $tipo_computador !== null);
        
                // Obtener registro activo SIN FILTRAR por computador primero
                $registroActivo = $this->registroModelo->obtenerRegistroActivoUsuario(
                    $usuario['id_persona'],
                    date('Y-m-d')
                );
        
                if (!$registroActivo) {
                    throw new Exception('No se encontró registro de entrada activo', 400);
                }
        
                // Validación CLAVE: Coherencia computador entrada/salida
                $registroTieneComputador = ($registroActivo['id_validacion_equipo'] !== null);
                
                if ($tieneComputador != $registroTieneComputador) {
                    if ($registroTieneComputador) {
                        $equipo = $this->registroModelo->obtenerDescripcionEquipo($registroActivo['id_validacion_equipo']);
                        throw new Exception("Debes registrar la salida del equipo usado en la entrada: $equipo", 400);
                    } else {
                        throw new Exception('El registro original no tenía computador asignado', 400);
                    }
                }
        
                // Si tiene computador, validar que sea el correcto
                if ($tieneComputador) {
                    $id_validacion = $this->registroModelo->obtenerIdValidacionEquipo($computador_id, $tipo_computador);
                    
                    if (!$id_validacion) {
                        throw new Exception('Equipo no encontrado en validación', 404);
                    }
        
                    if ($id_validacion != $registroActivo['id_validacion_equipo']) {
                        throw new Exception('El equipo no coincide con el registro original', 400);
                    }
                }
        
                if (!empty($registroActivo['hora_salida'])) {
                    throw new Exception('La salida ya fue registrada', 400);
                }
        
                // Registrar hora de salida
                $this->registroModelo->registrarSalida($registroActivo['id_registro'], date('H:i:s'));
        
                // Confirmar cambios
                $this->db->commit();
        
                // Respuesta exitosa
                echo json_encode([
                    'success' => true,
                    'message' => "Salida registrada para {$usuario['nombre']}",
                    'data' => [
                        'hora_salida' => date('H:i:s'),
                        'usuario' => $usuario,
                        'equipo' => $tieneComputador ? [
                            'id' => $computador_id,
                            'tipo' => $tipo_computador
                        ] : null
                    ]
                ]);
        
            } catch (Exception $e) {
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                
                error_log("Error en registrarSalida: " . $e->getMessage());
                
                http_response_code($e->getCode() ?: 500);
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ]);
            }
            exit;
        }
    }
?>