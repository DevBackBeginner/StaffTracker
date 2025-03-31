<?php

    session_start();

    require_once __DIR__ . '/../Models/PersonalModelo.php';
    require_once __DIR__ . '/../Models/ComputadorModelo.php';
    require_once '../config/DataBase.php';

    class PersonalController
    {

        private $personalModelo;
        private $computadorModelo;
        private $db;        // Conexión a la b

        public function __construct()
        {
            ini_set('display_errors', 0);
            error_reporting(E_ALL);
            ini_set('log_errors', 1);
            ini_set('error_log', __DIR__ . '/php-errors.log');
            
            $this->personalModelo = new PersonalModelo;
            $this->computadorModelo = new ComputadorModelo;
            $conn = new DataBase();
            $this->db = $conn->getConnection();
        }

        public function formularioRegistroPersonal ()
        {
            include_once __DIR__ . '/../Views/gestion/personal/registrar_personal.php';
        }

        public function registrarPersonal() {
            try {
                // =============================================
                //  RECEPCIÓN Y VALIDACIÓN DE DATOS
                // =============================================
                $nombre = $this->sanitizarInput($_POST["nombre"]);
                $apellido = $this->sanitizarInput($_POST["apellido"]);
                $tipo_documento = $this->sanitizarInput($_POST["tipo_documento"]);
                $numero_identidad = $this->sanitizarInput($_POST["numero_identidad"]);
                $telefono = $this->sanitizarInput($_POST["telefono"]);
                $rol = $this->sanitizarInput($_POST["rol"]);
                $tiene_computador = isset($_POST["tiene_computador"]) ? 1 : 0;
                $cargo = $this->sanitizarInput($_POST["cargo"]);
                $tipo_contrato = $this->sanitizarInput($_POST["tipo_contrato"] ?? 'Planta');
        
                // Validación básica de campos obligatorios
                if (empty($nombre) || empty($apellido) || empty($numero_identidad) || empty($rol) || empty($cargo)) {
                    throw new Exception("Todos los campos obligatorios deben estar completos");
                }
        
                // Validación de tipos de datos
                $tiposDocumentoPermitidos = ['CC', 'CE', 'TI', 'PASAPORTE', 'NIT'];
                if (!in_array($tipo_documento, $tiposDocumentoPermitidos)) {
                    throw new Exception("Tipo de documento no válido");
                }
        
                // =============================================
                // OPERACIONES DE BASE DE DATOS (TRANSACCIÓN)
                // =============================================
                $this->db->beginTransaction();
        
                // Registrar persona principal
                $persona_id = $this->personalModelo->registrarPersona($nombre, $apellido, $tipo_documento, $numero_identidad, $telefono, $rol);
                
                if (!$persona_id) {
                    throw new Exception("Error al registrar la persona");
                }
        
                //  Registrar información laboral
                $info_laboral = $this->personalModelo->registrarInformacionLaboral( $persona_id, $cargo, $tipo_contrato);
                
                if (!$info_laboral) {
                    throw new Exception("Error al registrar la información laboral");
                }
        
                // 2.3 Procesamiento opcional de computador
                if ($tiene_computador) {
                    $marca = $this->sanitizarInput($_POST["marca"]);
                    $codigo = $this->sanitizarInput($_POST["codigo"]);
                    
                    if (empty($marca) || empty($codigo)) {
                        throw new Exception("Los campos modelo y código del computador son obligatorios");
                    }
                    
                    $tiene_teclado = isset($_POST['mouse']) ? 'Si' : 'No';
                    $tiene_mouse = isset($_POST['teclado']) ? 'Si' : 'No';
                    
                    // Determinamos el tipo de computador basado en el rol

                    $tipo_computador = 'Personal';

                    $computador_id = $this->computadorModelo->registrarComputadorPersonal($marca, $codigo, $tiene_teclado, $tiene_mouse, $persona_id);

                    // $tipo_computador = (in_array($rol, ['Administrador', 'Funcionario', 'Directivo', 'Apoyo'])) 
                    //                     ? 'Personal' 
                    //                     : 'Sena';
                    
                    // // Registro según el tipo con métodos específicos
                    // if ($tipo_computador == 'Personal') {
                    //     $computador_id = $this->computadorModelo->registrarComputadorPersonal($modelo, $codigo, $tiene_teclado, $tiene_mouse, $persona_id);
                    // } else {
                    //     $computador_id = $this->computadorModelo->registrarComputadorSena($modelo, $codigo, $tiene_teclado, $tiene_mouse, 'Asignado', $persona_id);
                    // }
                    
                    if (!$computador_id) {
                        throw new Exception("Error al registrar el computador de tipo {$tipo_computador}");
                    }
                    
                    // Registro en validación de equipos (común para ambos tipos)
                    $validacion = $this->computadorModelo->registrarValidacionEquipo($computador_id, ($tipo_computador == 'Personal') ? 'computador_personal' : 'computador_sena');
                    
                    if (!$validacion) {
                        throw new Exception("Error al validar el equipo");
                    }
                }
        
                // Confirmar todas las operaciones
                $this->db->commit();
        
                // =============================================
                // 3. RESPUESTA AL USUARIO
                // =============================================
                $_SESSION['mensaje'] = "Personal registrado correctamente" . ($tiene_computador ? " con computador asignado" : "");
                $_SESSION['tipo_mensaje'] = 'success';
        
            } catch (Exception $e) {
                // Revertir en caso de error
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
        
                $_SESSION['mensaje'] = $e->getMessage();
                $_SESSION['tipo_mensaje'] = 'error';
                $_SESSION['form_data'] = $_POST; // Para repoblar el formulario
            }
        
            header('Location: formulario_registro_personal');
            exit();
        }
    
        public function listarPersonal()
        {
            // Obtener y sanitizar parámetros de la URL
            $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
            $rol = $this->sanitizarInput($_GET['rol'] ?? '');
            $nombre = $this->sanitizarInput($_GET['nombre'] ?? '');
            $documento = $this->sanitizarInput($_GET['documento'] ?? '');
            $orden = $this->sanitizarInput($_GET['orden'] ?? 'nombre');
            $direccion = strtoupper($this->sanitizarInput($_GET['direccion'] ?? 'ASC'));
            
            // Validar dirección de orden
            $direccion = in_array($direccion, ['ASC', 'DESC']) ? $direccion : 'ASC';
            
            // Definir límite por página
            $limite = 10;

            // Preparar filtros
            $filtros = [];
            if (!empty($rol)) {
                $filtros['rol'] = $rol;
            }
            if (!empty($nombre)) {
                $filtros['nombre'] = $nombre;
            }
            if (!empty($documento)) {
                $filtros['documento'] = $documento;
            }

            // Obtener datos del modelo
            $usuarios = $this->personalModelo->obtenerPersonas($pagina, $limite, $filtros, $orden, $direccion);

            // Obtener total para paginación
            $totalUsuarios = $this->personalModelo->contarPersonas($filtros);
            $totalPaginas = max(1, ceil($totalUsuarios / $limite));

            // Pasar datos a la vista
            $data = [
                'usuario' => $usuarios, // Asegúrate que coincide con el nombre en la vista
                'pagina' => $pagina,
                'totalPaginas' => $totalPaginas,
                'rol' => $rol,
                'nombre' => $nombre,
                'documento' => $documento,
                'orden' => $orden,
                'direccion' => $direccion
            ];

            // Cargar vista
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
                    $documento = $this->sanitizarInput($_POST['numero_documento']);
                    $tipo_documento = $this->sanitizarInput($_POST['tipo_documento']);
                    $telefono = $this->sanitizarInput($_POST['telefono']);
                    $rol = $this->sanitizarInput($_POST['rol']);
                    $cargo = $this->sanitizarInput($_POST['cargo'] ?? ''); // Nuevo campo
                    $tipo_contrato = $this->sanitizarInput($_POST['tipo_contrato'] ?? null); // Nuevo campo

                    // Validaciones básicas
                    $this->validarCamposBasicos($nombre, $apellido, $documento, $telefono, $rol);
                    $this->validarTelefono($telefono);
                    $this->validarNumeroDocumento($documento);
                    
                    // Validar rol
                    $rolesPermitidos = ['Funcionario', 'Instructor', 'Directivo'];
                    if (!in_array($rol, $rolesPermitidos)) {
                        throw new Exception("Rol no válido.");
                    }

                    // Validar cargo (nuevo campo obligatorio)
                    if (empty($cargo)) {
                        throw new Exception("El campo 'cargo' es obligatorio.");
                    }

                    // Preparar datos laborales
                    $datosLaborales = ['cargo' => $cargo, 'tipo_contrato' => $tipo_contrato];

                    // Actualizar el usuario en la base de datos
                    $actualizado = $this->personalModelo->actualizarUsuario($id,  $nombre,  $apellido, $tipo_documento,  $documento,  $rol,  $telefono,  $datosLaborales);

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