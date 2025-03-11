<?php

    session_start();

    require_once __DIR__ . '/../models/PersonalModelo.php';

    class PersonalController
    {
        private $personalModelo;

        public function __construct()
        {
            $this->personalModelo = new PersonalModelo;
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
                header('Location: registrar_guardas'); // Redirigir al formulario
                exit();
            }
    
            // Validar el número de documento (exactamente 10 dígitos, solo números)
            if (!preg_match('/^[0-9]{10}$/', $numero_identidad)) {
                $_SESSION['mensaje'] = "El número de documento debe tener exactamente 10 dígitos y solo contener números.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: registrar_guardas'); // Redirigir al formulario
                exit();
            }
    

            $resultado = $this->personalModelo->registrarUsuario($nombre, $apellido, $telefono, $numero_identidad, $rol, $datosAdicionales);
            
            // Manejar el resultado (éxito o error)
            if ($resultado) {
                $_SESSION['mensaje'] = "Usuario registrado correctamente.";
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = "Error al registrar el usuario.";
                $_SESSION['tipo_mensaje'] = 'error';
            }
    
            // Redirigir a la vista correspondiente
            header('Location: formulario_registro_personal');
            exit();
        }
    }
?>