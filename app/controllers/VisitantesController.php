<?php 
    session_start();
    require_once __DIR__ . '/../models/VisitantesModelo.php';
    require_once __DIR__ . '/../models/ComputadorModelo.php';

    class VisitantesController
    {
        private $visitanteModelo;   
        private $computadorModelo;
        public function __construct()
        {
            $this->visitanteModelo = new VisitantesModelo;
            $this->computadorModelo = new ComputadorModelo;
        }

        public function formulario_visitante()
        {
            require_once __DIR__ . '/../views/gestion/visitantes/registrar_visitantes.php';
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
                header('Location: formulario_registro_personal'); // Redirigir al formulario
                exit();
            }

            // Validar el formato del teléfono (10 dígitos, comenzando con 3)
            if (!preg_match('/^3[0-9]{9}$/', $telefono)) {
                $_SESSION['mensaje'] = "El teléfono debe tener 10 dígitos y comenzar con 3 (formato colombiano).";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_personal'); // Redirigir al formulario
                exit();
            }

            // Validar el número de documento (exactamente 10 dígitos, solo números)
            if (!preg_match('/^[0-9]{10}$/', $numero_identidad)) {
                $_SESSION['mensaje'] = "El número de documento debe tener exactamente 10 dígitos y solo contener números.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_personal'); // Redirigir al formulario
                exit();
            }

                // Intentar registrar al visitante
            $usuario_id = $this->visitanteModelo->registroVisitante($nombre, $apellido, $numero_identidad, $telefono, $asunto, $rol);

            if (!$usuario_id) {
                $_SESSION['mensaje'] = "Error al registrar el usuario.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_personal');
                exit();
            }

             // Manejar el registro del computador y la asignación
            if ($tiene_computador == 1) {
                // Si tiene computador, capturar los datos del computador
                $marca = htmlspecialchars(trim($_POST["marca"]), ENT_QUOTES, 'UTF-8');
                $codigo = htmlspecialchars(trim($_POST["codigo"]));
                $tipo_computador = htmlspecialchars(trim($_POST["tipo_computador"]), ENT_QUOTES, 'UTF-8'); // Capturar el tipo de computador

                // Validar que los campos del computador no estén vacíos
                if (empty($marca) || empty($codigo) || empty($tipo_computador)) {
                    $_SESSION['mensaje'] = "Todos los campos del computador son obligatorios.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: formulario_registro_personal');
                    exit();
                }

                // Registrar el computador en la tabla `computadores`
                $computador_id = $this->computadorModelo->registrarComputador($marca, $codigo, $tipo_computador);

                if (!$computador_id) {
                    $_SESSION['mensaje'] = "Error al registrar el computador.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: formulario_registro_personal');
                    exit();
                }
            } else {
                // Si no tiene computador, asignar NULL
                $computador_id = null;
            }
            // Registrar la asignación en la tabla `asignaciones_computadores`
            $asignacion_resultado = $this->computadorModelo->registrarAsignacionComputador($usuario_id, $computador_id);

            if (!$asignacion_resultado) {
                $_SESSION['mensaje'] = "Error al registrar la asignación del computador.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: formulario_registro_personal');
                exit();
            }

            // Si todo sale bien, mostrar mensaje de éxito
            $_SESSION['mensaje'] = "Usuario y asignación de computador registrados correctamente.";
            $_SESSION['tipo_mensaje'] = 'success';
            header('Location: formulario_registro_personal');
            exit();
        }
    }
?>