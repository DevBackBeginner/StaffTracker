<?php 
    session_start();

    require_once __DIR__ . '/../Models/VisitantesModelo.php';
    require_once __DIR__ . '/../Models/ComputadorModelo.php';
    require_once '../config/DataBase.php';

    class VisitantesController
    {
        private $visitanteModelo;   
        private $computadorModelo;
        private $db;

        public function __construct()
        {
            $this->visitanteModelo = new VisitantesModelo();
            $this->computadorModelo = new ComputadorModelo();

            $conn = new DataBase;
            $this->db = $conn->getConnection();

        }

        public function formulario_visitante()
        {
            require_once __DIR__ . '/../Views/gestion/visitantes/registrar_visitantes.php';
        }

        public function registrarVisitante() {
            try {
                // Sanitizar y validar datos
                $nombre = htmlspecialchars(trim($_POST["nombre"] ?? ''), ENT_QUOTES, 'UTF-8');
                $apellido = htmlspecialchars(trim($_POST["apellidos"] ?? ''), ENT_QUOTES, 'UTF-8');
                $tipo_documento = htmlspecialchars(trim($_POST["tipo_documento"] ?? ''));
                $numero_documento = htmlspecialchars(trim($_POST["numero_identidad"] ?? ''));
                $telefono = $_POST["telefono"] ?? '';
                $asunto_visita = htmlspecialchars(trim($_POST["asunto"] ?? ''), ENT_QUOTES, 'UTF-8');
                $tiene_computador = $_POST["tiene_computador"] ?? 0;
                $registrador = $_SESSION['usuario']['id']; // ID del usuario que registra
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');

        
                // Validaciones básicas
                $errores = [];
                if (empty($nombre)) $errores[] = "El nombre es obligatorio";
                if (empty($apellido)) $errores[] = "El apellido es obligatorio";
                if (empty($numero_documento)) $errores[] = "El número de documento es obligatorio";
                if (empty($telefono)) $errores[] = "El teléfono es obligatorio";
                if (empty($tipo_documento)) $errores[] = "El tipo de documento es obligatorio";
        
                // Validar tipo de documento
                $tiposPermitidos = ['CC', 'CE', 'TI', 'PASAPORTE', 'NIT'];
                if (!in_array($tipo_documento, $tiposPermitidos)) {
                    $errores[] = "Tipo de documento no válido";
                }
        
                // Validar formato de teléfono y documento
                if (!preg_match('/^[0-9]+$/', $telefono)) {
                    $errores[] = "El teléfono debe contener solo números";
                }
        
                if (!preg_match('/^[0-9]+$/', $numero_documento)) {
                    $errores[] = "El número de documento debe contener solo números";
                }
        
                // Si hay errores, redireccionar
                if (!empty($errores)) {
                    $_SESSION['mensaje'] = implode("<br>", $errores);
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: formulario_registro_visitante');
                    exit();
                }
        
                // Registrar visitante en tabla personas
                $this->db->beginTransaction();
        
                $personaId = $this->visitanteModelo->registrarPersona($nombre, $apellido,  $tipo_documento, $numero_documento, $telefono, 'Visitante' );
        
                if (!$personaId) {
                    throw new Exception("Error al registrar la persona");
                }
        
                // Registrar visita en tabla visitantes
                $visitaId = $this->visitanteModelo->registrarVisita($personaId, $asunto_visita, $fecha, $registrador,);
        
                // Manejo de computador (si aplica)
                $computadorId = null;
                if ($tiene_computador == 1) {
                    $marca = htmlspecialchars(trim($_POST["marca"] ?? ''), ENT_QUOTES, 'UTF-8');
                    $serial = htmlspecialchars(trim($_POST["codigo"] ?? ''));
                    $teclado = isset($_POST['teclado']) ? 'Si' : 'No';
                    $mouse = isset($_POST['mouse']) ? 'Si' : 'No';
        
                    if (empty($marca) || empty($serial)) {
                        throw new Exception("Marca y serial del computador son obligatorios");
                    }
        
                    // Registrar computador personal
                    $computadorId = $this->computadorModelo->registrarComputadorPersonal($marca, $serial, $teclado, $mouse, $personaId);
        
                    // Registrar validación de equipo
                    $this->computadorModelo->registrarValidacionEquipo($computadorId, 'computador_personal');
                }

                // Registrar la entrada con todos los campos requeridos
                $this->visitanteModelo->registrarEntrada(
                    $personaId, // 1er param: id_persona
                    $fecha,
                    $hora,
                    $computadorId ? $this->computadorModelo->obtenerIdValidacionEquipo($computadorId) : null 
                );
                        
                $this->db->commit();
        
                $_SESSION['mensaje'] = "Visitante registrado correctamente";
                $_SESSION['tipo_mensaje'] = 'success';
        
            } catch (Exception $e) {
                $this->db->rollBack();
                $_SESSION['mensaje'] = "Error: " . $e->getMessage();
                $_SESSION['tipo_mensaje'] = 'error';
                error_log("Error en registrarVisitante: " . $e->getMessage());
            }
        
            header('Location: formulario_registro_visitante');
            exit();
        }

        public function listarVisitantes() {
            // Obtener parámetros de filtro
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $nombre = $this->sanitizarInput($_GET['nombre'] ?? '');
            $documento = $this->sanitizarInput($_GET['documento'] ?? '');
            
            // Validar página
            $pagina = max(1, $pagina);
            $limite = 10; // 10 registros por página
    
            // Configurar filtros
            $filtros = [];
            if (!empty($nombre)) {
                $filtros['nombre'] = $nombre;
            }
            if (!empty($documento)) {
                $filtros['documento'] = $documento;
            }
    
            // Obtener datos
            $visitantes = $this->visitanteModelo->obtenerVisitantes($pagina, $limite, $filtros);
            $totalVisitantes = $this->visitanteModelo->contarVisitantes($filtros);
            $totalPaginas = ceil($totalVisitantes / $limite);
    
            // Cargar vista
            include_once __DIR__ . '/../Views/gestion/visitantes/listado_visitantes.php';
        }
    
        private function sanitizarInput($data) {
            return htmlspecialchars(strip_tags(trim($data)));
        }

    }
?>