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
            $tiene_computador = $_POST["tiene_computador"]; // 1 para Sí, 0 para No
            $rol = 'Visitante';

            // Validar que los campos no estén vacíos
            if (empty($nombre) || empty($apellido) || empty($numero_identidad) || empty($telefono) || empty($rol)) {
                $_SESSION['mensaje'] = "Todos los campos son obligatorios.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante'); // Redirigir al formulario
                exit();
            }

            // Validar que el teléfono contenga solo números
            if (!preg_match('/^[0-9]+$/', $telefono)) {
                $_SESSION['mensaje'] = "El teléfono debe contener solo números.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante'); // Redirigir al formulario
                exit();
            }

            // Validar que el número de documento contenga solo números
            if (!preg_match('/^[0-9]+$/', $numero_identidad)) {
                $_SESSION['mensaje'] = "El número de documento debe contener solo números.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante'); // Redirigir al formulario
                exit();
            }

            // Intentar registrar al visitante
            $usuario_id = $this->visitanteModelo->registroVisitante($nombre, $apellido, $numero_identidad, $telefono, $asunto, $rol);

            if (!$usuario_id) {
                $_SESSION['mensaje'] = "Error al registrar el usuario.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante');
                exit();
            }

            // Manejar el registro del computador y la asignación
            if ($tiene_computador == 1) {
                // Si tiene computador, capturar los datos del computador
                $marca = htmlspecialchars(trim($_POST["marca"]), ENT_QUOTES, 'UTF-8');
                $codigo = htmlspecialchars(trim($_POST["codigo"]));
                $mouse = isset($_POST['mouse']) ? 'Sí' : 'No';
                $teclado = isset($_POST['teclado']) ? 'Sí' : 'No';
                $tipo_computador = htmlspecialchars(trim($_POST["tipo_computador"]), ENT_QUOTES, 'UTF-8'); // Capturar el tipo de computador

                // Validar que los campos del computador no estén vacíos
                if (empty($marca) || empty($codigo) || empty($tipo_computador)) {
                    $_SESSION['mensaje'] = "Todos los campos del computador son obligatorios.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: formulario_registro_visitante');
                    exit();
                }

                // Registrar el computador en la tabla `computadores`
                $computador_id = $this->computadorModelo->ingresarComputador($marca, $codigo, $mouse, $teclado, $tipo_computador);

                if (!$computador_id) {
                    $_SESSION['mensaje'] = "Error al registrar el computador.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: formulario_registro_visitante');
                    exit();
                }
            } else {
                // Si no tiene computador, asignar NULL
                $computador_id = null;
            }

            // var_dump($usuario_id);
            // exit;

            // Registrar la asignación en la tabla `asignaciones_computadores`
            $asignacionId = $this->computadorModelo->registrarAsignacionComputador($usuario_id, $computador_id);

            if (!$asignacionId) {
                $_SESSION['mensaje'] = "Error al registrar la asignación del computador.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_visitante');
                exit();
            }

            // Registrar la entrada del visitante en la tabla `registro_acceso`
            try {
                $fecha = date('Y-m-d'); // Fecha actual
                $hora = date('H:i:s'); // Hora actual
                $tipo_usuario = "Visitante"; // Definir el tipo de usuario en el controlador

                $this->registroModelo->registrarEntrada($fecha, $hora, $asignacionId, $tipo_usuario);

                // Si todo sale bien, mostrar mensaje de éxito
                $_SESSION['mensaje'] = "Usuario, asignación de computador y entrada registrados correctamente.";
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