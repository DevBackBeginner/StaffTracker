<?php

    session_start();

    require_once __DIR__ . '/../Models/GestionPersonalModelo.php';
    require_once __DIR__ . '/../Models/ComputadorModelo.php';

    class GestionPersonalController
    {

        private $personalModelo;
        private $computadorModelo;

        public function __construct()
        {
            ini_set('display_errors', 0);
            error_reporting(E_ALL);
            ini_set('log_errors', 1);
            ini_set('error_log', __DIR__ . '/php-errors.log');
            
            $this->personalModelo = new GestionPersonalModelo;
            $this->computadorModelo = new ComputadorModelo;
        }

        public function formularioRegistroPersonal ()
        {
            include_once __DIR__ . '/../Views/gestion/personal/registrar_personal.php';
        }

        public function registrarPersonal()
        {
            try {
                // Sanitizar y validar datos básicos
                $nombre = $this->sanitizarInput($_POST["nombre"]);
                $apellido = $this->sanitizarInput($_POST["apellido"]);
                $numero_identidad = $this->sanitizarInput($_POST["numero_identidad"]);
                $telefono = $this->sanitizarInput($_POST["telefono"]);
                $rol = $this->sanitizarInput($_POST["rol"]);
                $tiene_computador = $_POST["tiene_computador"]; // 1 para Sí, 0 para No
        
                // Validar campos básicos
                $this->validarCamposBasicos($nombre, $apellido, $numero_identidad, $telefono, $rol);
        
                // Validar formato del teléfono y número de documento
                $this->validarTelefono($telefono);
                $this->validarNumeroDocumento($numero_identidad);
        
                // Recuperar y validar datos adicionales según el rol
                $datosAdicionales = $this->obtenerDatosAdicionales($rol);
        
                // Registrar el usuario
                $usuario_id = $this->personalModelo->registrarUsuario($nombre, $apellido, $telefono, $numero_identidad, $rol, $datosAdicionales);
        
                if (!$usuario_id) {
                    throw new Exception("Error al registrar el usuario.");
                }
        
                // Manejar el registro del computador y la asignación
                $computador_id = null;
                
                if ($tiene_computador == 1) {
                    $computador_id = $this->registrarComputador();
                    if (!$computador_id) {
                        throw new Exception("Error al registrar el computador.");
                    }
                }
        
                // Registrar la asignación del computador
                $asignacion_resultado = $this->computadorModelo->registrarAsignacionComputador($usuario_id, $computador_id);
        
                if (!$asignacion_resultado) {
                    throw new Exception("Error al registrar la asignación del computador.");
                }
        
                // Éxito
                $_SESSION['mensaje'] = "Usuario y asignación de computador registrados correctamente.";
                $_SESSION['tipo_mensaje'] = 'success';
            } catch (Exception $e) {
                // Manejar errores
                $_SESSION['mensaje'] = $e->getMessage();
                $_SESSION['tipo_mensaje'] = 'error';
            } finally {
                // Redirigir al formulario
                header('Location: formulario_registro_personal');
                exit();
            }
        }
    
        public function listarUsuarios()
        {
            // Obtener parámetros de la URL
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $rol = $this->sanitizarInput($_GET['rol'] ?? '');
            $nombre = $this->sanitizarInput($_GET['nombre'] ?? '');
            $documento =$this->sanitizarInput( $_GET['documento'] ?? '');
            $orden = $this->sanitizarInput($_GET['orden'] ?? 'nombre');
            $direccion =$this->sanitizarInput( $_GET['direccion'] ?? 'ASC');
            // Validar la página
            $pagina = max(1, $pagina);

            // Definir el límite de usuarios por página
            $limite = 10;

            // Obtener los usuarios del modelo
            $filtros = [
                'rol' => $rol,
                'nombre' => $nombre,
                'documento' => $documento
            ];
            $usuario = $this->personalModelo->obtenerUsuarios($pagina, $limite, $filtros, $orden, $direccion);

            // Obtener el total de usuarios para la paginación
            $totalUsuarios = $this->personalModelo->contarUsuarios($filtros);
            $totalPaginas = ceil($totalUsuarios / $limite);

            // Pasar los datos a la vista
            $data = [
                'usuarios' => $usuario,
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'rol' => $rol,
                'nombre' => $nombre,
                'documento' => $documento,
                'orden' => $orden,
                'direccion' => $direccion
            ];

            // Incluir la vista
            include_once __DIR__ . '/../Views/gestion/personal/listado_usuarios.php';
        }

        public function editarUsuarios()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    // Sanitizar y validar datos básicos
                    $id = $this->sanitizarInput($_POST['id']);
                    $nombre = $this->sanitizarInput($_POST['nombre']);
                    $apellido = $this->sanitizarInput($_POST['apellidos']);
                    $documento = $this->sanitizarInput($_POST['documento']);
                    $telefono = $this->sanitizarInput($_POST['telefono']);
                    $rol = $this->sanitizarInput($_POST['rol']);
            
                    $this->validarCamposBasicos($nombre, $apellido, $documento, $telefono, $rol);
                    // Validar formato del teléfono 
                    $this->validarTelefono($telefono);
                    // Validar formato del documento
                    $this->validarNumeroDocumento($documento);
                    // Validar rol
                    $rolesPermitidos = ['Funcionario', 'Instructor', 'Directivo', 'Apoyo', 'Visitante'];
                    if (!in_array($rol, $rolesPermitidos)) {
                        throw new Exception("Rol no válido.");
                    }
                    
                    // Obtener la información adicional según el rol
                    $infoAdicional = $this->obtenerDatosAdicionales($rol);
                    // var_dump($infoAdicional);
                    // exit;
                    // Actualizar el usuario en la base de datos
                    $actualizado = $this->personalModelo-> actualizarUsuario($id, $nombre, $apellido, $documento, $rol, $telefono, $infoAdicional);
                    if (!$actualizado) {
                        throw new Exception("Error al actualizar el usuario en la base de datos.");
                    }

                    // Mensaje de éxito
                    $_SESSION['mensaje'] = "Usuario actualizado correctamente.";
                    $_SESSION['tipo_mensaje'] = "success";
                } catch (Exception $e) {
                    // Mensaje de error
                    $_SESSION['mensaje'] = $e->getMessage();
                    $_SESSION['tipo_mensaje'] = "error";
                } finally {
                    // Redirigir al listado de usuarios
                    header('Location: Listado_Usuarios');
                    exit();
                }
            }
        }

        public function eliminarUsuario()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    // Sanitizar y validar el ID del usuario
                    $id = $this->sanitizarInput($_POST['id']);
                    if (empty($id)) {
                        throw new Exception("El ID del usuario es obligatorio.");
                    }

                    // Eliminar el usuario de la base de datos
                    $eliminado = $this->personalModelo->eliminar_Usuario($id);
                    if (!$eliminado) {
                        throw new Exception("Error al eliminar el usuario de la base de datos.");
                    }

                    // Mensaje de éxito
                    $_SESSION['mensaje'] = "Usuario eliminado correctamente.";
                    $_SESSION['tipo_mensaje'] = "success";
                } catch (Exception $e) {
                    // Mensaje de error
                    $_SESSION['mensaje'] = $e->getMessage();
                    $_SESSION['tipo_mensaje'] = "error";
                } finally {
                    // Redirigir al listado de usuarios
                    header('Location: Listado_Usuarios');
                    exit();
                }
            }
        }

        /**
         * Sanitiza un valor de entrada.
         */
        private function sanitizarInput($input)
        {
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
        }
        
        /**
         * Valida que los campos básicos no estén vacíos.
         */
        private function validarCamposBasicos($nombre, $apellido, $numero_identidad, $telefono, $rol)
        {
            if (empty($nombre) || empty($apellido) || empty($numero_identidad) || empty($telefono) || empty($rol)) {
                throw new Exception("Todos los campos son obligatorios.");
            }
        }
        
        /**
         * Valida el formato del teléfono.
         */
        private function validarTelefono($telefono)
        {
            if (!preg_match('/^[0-9]+$/', $telefono)) {
                throw new Exception("El teléfono debe ser numerico.");
            }
        }
        
        /**
         * Valida el formato del número de documento.
         */
        private function validarNumeroDocumento($numero_identidad)
        {
            if (!preg_match('/^[0-9]+$/', $numero_identidad)) {
                throw new Exception("El número de documento debe tener solo numeros.");
            }
        }
        
        /**
         * Obtiene y valida los datos adicionales según el rol.
         */
        private function obtenerDatosAdicionales($rol)
        {
            $datosAdicionales = [];
            
            switch ($rol) {
                case 'Funcionario':
                    $datosAdicionales['area'] = $this->sanitizarInput($_POST["area"]);
                    $datosAdicionales['puesto'] = $this->sanitizarInput($_POST["puesto"]);
                    break;
                case 'Instructor':
                    $datosAdicionales['curso'] = $this->sanitizarInput($_POST["curso"]);
                    $datosAdicionales['ubicacion'] = $this->sanitizarInput($_POST["ubicacion"]);
                    break;
                case 'Directivo':
                    $datosAdicionales['cargo'] = $this->sanitizarInput($_POST["cargo"]);
                    $datosAdicionales['departamento'] = $this->sanitizarInput($_POST["departamento"]);
                    break;
                case 'Apoyo':
                    $datosAdicionales['area_trabajo'] = $this->sanitizarInput($_POST["area_trabajo"]);
                    break;
                case 'Visitante':
                    $datosAdicionales['asunto'] = $this->sanitizarInput($_POST['asunto']);
                    break;
                default:
                    throw new Exception("Rol no válido: " . $rol);
            }
            // Validar que los datos adicionales no estén vacíos
            foreach ($datosAdicionales as $campo => $valor) {
                if (empty($valor)) {
                    throw new Exception("El campo '$campo' es obligatorio para el rol de $rol.");
                }
            }
            return $datosAdicionales;
        }
        
        /**
         * Registra un computador y devuelve su ID.
         */
        private function registrarComputador()
        {
            $marca = $this->sanitizarInput($_POST["marca"]);
            $codigo = $this->sanitizarInput($_POST["codigo"]);
            $mouse = isset($_POST['mouse']) ? 'Sí' : 'No';
            $teclado = isset($_POST['teclado']) ? 'Sí' : 'No';
            $tipo_computador = $this->sanitizarInput($_POST["tipo_computador"]);
        
            // Validar campos del computador
            if (empty($marca) || empty($codigo) || empty($tipo_computador)) {
                throw new Exception("Todos los campos del computador son obligatorios.");
            }
        
            // Registrar el computador
            return $this->computadorModelo->ingresarComputador($marca, $codigo, $mouse, $teclado, $tipo_computador);
        }
    }
?>