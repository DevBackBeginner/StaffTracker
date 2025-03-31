
<?php

    require_once __DIR__ . '/../Models/ComputadorModelo.php';
    require_once __DIR__ . '/../Models/HistorialRegistroModelo.php';
    require_once '../config/DataBase.php';

    class ComputadorController {
        private $computadorModelo;
        private $historialModelo;
        private $db;

        public function __construct() {
            $this->computadorModelo = new ComputadorModelo();
            $this->historialModelo = new HistorialRegistroModelo();

            $conn = new DataBase();
            $this->db = $conn->getConnection();
        }

        /**
         * Método obtenerComputadores:
         * Obtiene los computadores asociados a un usuario según el tipo (Sena, Personal).
         */
        public function obtenerComputadores() {
            // Configurar el tipo de contenido primero
            header('Content-Type: application/json');
            
            try {
                // Verificar método HTTP
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    throw new Exception("Método no permitido", 405);
                }
        
                // Obtener y validar parámetros
                $tipo = strtolower($_POST['tipoComputador'] ?? '');
                $codigoUsuario = $_POST['codigo'] ?? '';
                
                if (empty($tipo) || empty($codigoUsuario)) {
                    throw new Exception("Parámetros incompletos", 400);
                }
        
                // Normalizar tipo
                if ($tipo === 'personal') $tipo = 'computador_personal';
                if ($tipo === 'sena') $tipo = 'computador_sena';
        
                // Validar tipo
                if (!in_array($tipo, ['computador_personal', 'computador_sena'])) {
                    throw new Exception("Tipo de computador no válido", 400);
                }
        
                // Obtener información del usuario
                $usuario = $this->historialModelo->obtenerPorIdentidad($codigoUsuario);
                if (!$usuario || !isset($usuario['id_persona'])) {
                    throw new Exception("Usuario no encontrado", 404);
                }
        
                // Obtener computadores
                $computadores = [];
                if ($tipo === 'computador_personal') {
                    $computadores = $this->computadorModelo->obtenerComputadoresPersonales($usuario['id_persona']);
                } else {
                    $computadores = $this->computadorModelo->obtenerComputadoresSena($usuario['id_persona']);
                }
        
                // Construir respuesta
                $response = [
                    'success' => true,
                    'data' => $computadores,
                    'tipo' => $tipo
                ];
                
                if (empty($computadores)) {
                    $response['message'] = 'No se encontraron computadores';
                }
        
                echo json_encode($response);
                exit;
        
            } catch (PDOException $e) {
                // Manejo específico de errores de base de datos
                error_log("Error PDO: " . $e->getMessage());
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error en la base de datos',
                    'error_code' => 'DB_ERROR'
                ]);
                exit;
            } catch (Exception $e) {
                // Manejo de otros errores
                $code = is_numeric($e->getCode()) && $e->getCode() >= 100 ? $e->getCode() : 500;
                http_response_code($code);
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error_code' => $code
                ]);
                exit;
            }
        }

        public function registrarComputadorYasignacion() {
            // Verificar que la solicitud sea de tipo POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode([
                    'success' => false,
                    'message' => 'Método no permitido.'
                ]);
                exit;
            }
        
            // Obtener y sanitizar datos del formulario
            $modelo = trim($_POST['marca'] ?? '');
            $codigo = trim($_POST['codigo'] ?? '');
            $tipo = trim($_POST['tipo'] ?? ''); // 'Personal' o 'Sena'
            $teclado = isset($_POST['teclado']) && $_POST['teclado'] === 'Si' ? 'Si' : 'No';
            $mouse = isset($_POST['mouse']) && $_POST['mouse'] === 'Si' ? 'Si' : 'No';
            $codigoEscaneado = trim($_POST['codigo_escaneado'] ?? '');
        
            // Normalizar tipo de computador para la base de datos
            $tipoTabla = ($tipo === 'Sena') ? 'computador_sena' : 'computador_personal';
        
            // Validar datos
            $errores = [];
            if (empty($modelo)) $errores[] = 'El modelo es obligatorio';
            if (empty($codigo)) $errores[] = 'El código es obligatorio';
            if (empty($codigoEscaneado)) $errores[] = 'El código escaneado es obligatorio';
            if (!in_array($tipo, ['Personal', 'Sena'])) {
                $errores[] = 'Tipo de computador no válido';
            }
        
            if (!empty($errores)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error en los datos',
                    'errors' => $errores
                ]);
                exit;
            }
        
            try {
                // Iniciar transacción
                $this->db->beginTransaction();
        
                // 1. Obtener ID de la persona primero
                $persona_id = $this->computadorModelo->obtenerIdPersonaPorDocumento($codigoEscaneado);
                
                if (!$persona_id) {
                    throw new Exception('No se encontró usuario con el documento proporcionado', 404);
                }
        
                // 2. Registrar el computador según el tipo (ya con la asignación)
                if ($tipo === 'Personal') {
                    $computador_id = $this->computadorModelo->registrarComputadorPersonal($modelo,  $codigo,  $teclado,  $mouse, $persona_id );
                } else {
                    $computador_id = $this->computadorModelo->registrarComputadorSena($modelo, $codigo, $teclado, $mouse,'Asignado', $persona_id);
                }
        
                // 3. Registrar en validación_equipos (si es necesario en tu flujo)
                $validacion_id = $this->computadorModelo->registrarValidacionEquipo($computador_id, $tipoTabla);
        
                // Confirmar transacción
                $this->db->commit();
        
                // Respuesta exitosa
                http_response_code(201);
                echo json_encode([
                    'success' => true,
                    'message' => 'Computador registrado y asignado correctamente',
                    'data' => [
                        'computador_id' => $computador_id,
                        'tipo' => $tipo,
                        'validacion_id' => $validacion_id,
                        'asignado_a' => $persona_id,
                        'modelo' => $modelo,
                        'codigo' => $codigo
                    ]
                ]);
            } catch (Exception $e) {
                // Revertir transacción en caso de error
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                
                error_log("Error en registrarComputador: " . $e->getMessage());
                http_response_code($e->getCode() ?: 500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al registrar el computador: ' . $e->getMessage(),
                    'error_code' => $e->getCode()
                ]);
            }
        }

    }
?>