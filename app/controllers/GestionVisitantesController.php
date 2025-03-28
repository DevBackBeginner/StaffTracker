<?php 
    session_start();
    require_once __DIR__ . '/../Models/GestionVisitantesModelo.php';
    require_once __DIR__ . '/../Models/ComputadorModelo.php';
    require_once __DIR__ . '/../Models/RegistroAccesoModelo.php';

    class GestionVisitantesController
    {
        private $visitanteModelo;   
        private $computadorModelo;
        private $registroModelo;

        public function __construct()
        {
            $this->visitanteModelo = new GestionVisitantesModelo();
            $this->computadorModelo = new ComputadorModelo();
            $this->registroModelo = new RegistroAccesoModelo();
        }

        public function formulario_visitante()
        {
            require_once __DIR__ . '/../Views/gestion/visitantes/registrar_visitantes.php';
        }

        public function gestionarAccesoVisitantes()
        {
            require_once __DIR__ . '/../Views/gestion/visitantes/registrar-acceso-visitantes.php';
        }

        public function registrarVisitante()
        {
            // Sanitizar y validar los datos del formulario
            $nombre = htmlspecialchars(trim($_POST["nombre"]), ENT_QUOTES, 'UTF-8');
            $apellido = htmlspecialchars(trim($_POST["apellido"]), ENT_QUOTES, 'UTF-8');
            $numero_identidad = htmlspecialchars(trim($_POST["numero_identidad"]));
            $telefono = $_POST["telefono"];
            $asunto = htmlspecialchars(trim($_POST["asunto"]), ENT_QUOTES, 'UTF-8');
            $tiene_computador = $_POST["tiene_computador"]; 
            $rol = 'Visitante';
            $tipo_documento = htmlspecialchars(trim($_POST["tipo_documento"])); // Capturar tipo de documento
        
            // Validar que los campos no estén vacíos
            if (empty($nombre) || empty($apellido) || empty($numero_identidad) || empty($telefono) || empty($rol) || empty($tipo_documento)) {
                $_SESSION['mensaje'] = "Todos los campos son obligatorios.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante');
                exit();
            }
        
            // Validar que el teléfono contenga solo números
            if (!preg_match('/^[0-9]+$/', $telefono)) {
                $_SESSION['mensaje'] = "El teléfono debe contener solo números.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante');
                exit();
            }
        
            // Validar que el número de documento contenga solo números
            if (!preg_match('/^[0-9]+$/', $numero_identidad)) {
                $_SESSION['mensaje'] = "El número de documento debe contener solo números.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante');
                exit();
            }
        
            // Validar tipo de documento
            $tiposPermitidos = ['CC', 'CE', 'TI', 'PA', 'NIT', 'OTRO'];
            if (!in_array($tipo_documento, $tiposPermitidos)) {
                $_SESSION['mensaje'] = "Tipo de documento no válido.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante');
                exit();
            }
        
            // Intentar registrar al visitante (actualizado con tipo_documento)
            $usuario_id = $this->visitanteModelo->registroVisitante($nombre, $apellido, $tipo_documento, $numero_identidad, $telefono, $asunto, $rol);
        
            if (!$usuario_id) {
                $_SESSION['mensaje'] = "Error al registrar el usuario.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante');
                exit();
            }
        
            // Manejar el registro del computador y la asignación
            if ($tiene_computador == 1) {
                // Capturar datos del computador
                $marca = htmlspecialchars(trim($_POST["marca"]), ENT_QUOTES, 'UTF-8');
                $codigo = htmlspecialchars(trim($_POST["codigo"]));
                $mouse = isset($_POST['mouse']) ? 'Sí' : 'No';
                $teclado = isset($_POST['teclado']) ? 'Sí' : 'No';
                $tipo_computador = 'Personal'; // Tipo fijo para visitantes
        
                // Validar campos del computador
                if (empty($marca) || empty($codigo)) {
                    $_SESSION['mensaje'] = "Marca y código del computador son obligatorios.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: formulario_registro_visitante');
                    exit();
                }
        
                // Registrar el computador
                $computador_id = $this->computadorModelo->ingresarComputador($marca, $codigo, $mouse, $teclado, $tipo_computador);
        
                if (!$computador_id) {
                    $_SESSION['mensaje'] = "Error al registrar el computador.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: formulario_registro_visitante');
                    exit();
                }
            } else {
                $computador_id = null;
            }
        
            // Registrar la asignación del computador
            $asignacionId = $this->computadorModelo->registrarAsignacionComputador($usuario_id, $computador_id);
        
            if (!$asignacionId) {
                $_SESSION['mensaje'] = "Error al registrar la asignación del computador.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante');
                exit();
            }
        
            // Registrar la entrada del visitante
            try {
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $tipo_usuario = "Visitante";
        
                $this->registroModelo->registrarEntrada($fecha, $hora, $asignacionId, $tipo_usuario);
        
                $_SESSION['mensaje'] = "Visitante registrado correctamente.";
                $_SESSION['tipo_mensaje'] = 'success';
            } catch (Exception $e) {
                $_SESSION['mensaje'] = "Error al registrar la entrada: " . $e->getMessage();
                $_SESSION['tipo_mensaje'] = 'error';
            }
        
            header('Location: formulario_registro_visitante');
            exit();
        }
    }
?>