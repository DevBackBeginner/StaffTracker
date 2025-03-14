<?php

    session_start();

    require_once __DIR__ . '/../models/PersonalModelo.php';
    require_once __DIR__ . '/../models/ComputadorModelo.php';

    class PersonalController
    {
        private $personalModelo;
        private $computadorModelo;

        public function __construct()
        {
            $this->personalModelo = new PersonalModelo;
            $this->computadorModelo = new ComputadorModelo;
        }

        public function formularioRegistroPersonal ()
        {
            include_once __DIR__ . '/../views/gestion/personal/registrar_personal.php';
        }

        public function registrarPersonal()
        {
            // Recuperar y sanitizar los datos del formulario
            $nombre = htmlspecialchars(trim($_POST["nombre"]), ENT_QUOTES, 'UTF-8');
            $apellido = htmlspecialchars(trim($_POST["apellido"]), ENT_QUOTES, 'UTF-8');
            $numero_identidad = htmlspecialchars(trim($_POST["numero_identidad"]));
            $telefono = $_POST["telefono"];
            $rol = htmlspecialchars(trim($_POST["rol"]), ENT_QUOTES, 'UTF-8');
            $tiene_computador = $_POST["tiene_computador"]; // 1 para Sí, 0 para No

            // Recuperar datos adicionales según el rol
            $datosAdicionales = [];
            switch ($rol) {
                case 'Funcionario':
                    $datosAdicionales['area'] = htmlspecialchars(trim($_POST["area"]), ENT_QUOTES, 'UTF-8');
                    $datosAdicionales['puesto'] = htmlspecialchars(trim($_POST["puesto"]), ENT_QUOTES, 'UTF-8');
                    break;
                case 'Instructor':
                    $datosAdicionales['curso'] = htmlspecialchars(trim($_POST["curso"]), ENT_QUOTES, 'UTF-8');
                    $datosAdicionales['ubicacion'] = htmlspecialchars(trim($_POST["ubicacion"]), ENT_QUOTES, 'UTF-8');
                    break;
                case 'Directiva':
                    $datosAdicionales['cargo'] = htmlspecialchars(trim($_POST["cargo"]), ENT_QUOTES, 'UTF-8');
                    $datosAdicionales['departamento'] = htmlspecialchars(trim($_POST["departamento"]), ENT_QUOTES, 'UTF-8');
                    break;
                case 'Apoyo':
                    $datosAdicionales['area_trabajo'] = htmlspecialchars(trim($_POST["area_trabajo"]), ENT_QUOTES, 'UTF-8');
                    break;
                default:
                    // Manejar error si el rol no es válido
                    $_SESSION['mensaje'] = "Rol no válido.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: formulario_registro_personal');
                    exit();
            }

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

            // Registrar el usuario en la tabla `usuarios` y del rol seleccionado
            $usuario_id = $this->personalModelo->registrarUsuario($nombre, $apellido, $telefono, $numero_identidad, $rol, $datosAdicionales);

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
        
        public function listarUsuarios()
        {
            include_once __DIR__ . '/../views/gestion/personal/listado_usuarios.php';
        }
    }
?>