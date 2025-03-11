<?php 
    session_start();
    require_once __DIR__ . '/../models/VisitantesModelo.php';

    class VisitantesController
    {
        private $visitanteModelo;

        public function __construct()
        {
            $this->visitanteModelo = new VisitantesModelo;
        }

        public function formulario_visitante()
        {
            require_once __DIR__ . '/../views/gestion/visitantes/registrar_visitantes.php';
        }

        public function registrarVisitantes(){

            $nombre = htmlspecialchars(trim($_POST["nombre"]), ENT_QUOTES, 'UTF-8');
            $apellido = htmlspecialchars(trim($_POST["apellido"]), ENT_QUOTES, 'UTF-8');
            $numero_identidad = htmlspecialchars(trim($_POST["numero_identidad"]));
            $telefono = $_POST["telefono"];
            $asunto = htmlspecialchars(trim($_POST["asunto"]), ENT_QUOTES, 'UTF-8');

            $rol = 'Visitante';

            // Validar que los campos no estén vacíos
            if (empty($nombre) || empty($apellido) || empty($numero_identidad) || empty($telefono) || empty($asunto)) {
                $_SESSION['mensaje'] = "Todos los campos son obligatorios.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante'); // Redirigir al formulario
                exit();
            }
            
                // Validar el formato del teléfono (10 dígitos, comenzando con 3)
            if (!preg_match('/^3[0-9]{9}$/', $telefono)) {
                $_SESSION['mensaje'] = "El teléfono debe tener 10 dígitos y comenzar con 3 (formato colombiano).";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante'); // Redirigir al formulario
                exit();
            }
    
            // Validar el número de documento (exactamente 10 dígitos, solo números)
            if (!preg_match('/^[0-9]{10}$/', $numero_identidad)) {
                $_SESSION['mensaje'] = "El número de documento debe tener exactamente 10 dígitos y solo contener números.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante'); // Redirigir al formulario
                exit();
            }

            $resultado = $this->visitanteModelo->registroVisitante($nombre, $apellido, $numero_identidad, $telefono, $asunto, $rol);
    
        }
    }
?>