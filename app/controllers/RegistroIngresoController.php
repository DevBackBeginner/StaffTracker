<?php 
    session_start();

    require_once __DIR__ . '/../models/RegistroIngresoModelo.php';
    require_once __DIR__ . '/../models/panelIngresoModelo.php';

    // Iniciar la sesión para manejar la autenticación y almacenar mensajes (feedback) entre peticiones

    /**
     * Clase RegistroAsistenciaController
     *
     * Controlador encargado de manejar las operaciones relacionadas con el registro de asistencia,
     * incluyendo la visualización de la página principal de asistencia y el registro de entradas/salidas.
     */
    class RegistroIngresoController {
        /**
         * @var RegistroModelo $registroModelo
         *      Instancia del modelo que maneja la lógica de la tabla registro_asistencia.
         */
        private $registroModelo;

        /**
         * @var panelIngresoModelo $panelIngresoModelo
         *      Instancia del modelo que maneja la lógica de la tabla de usuarios (o panel) para obtener datos de personal.
         */
        private $panelIngresoModelo;

        /**
         * Constructor:
         * Se inicializan los modelos necesarios para interactuar con la base de datos.
         */
        public function __construct() {
            // Instancia el modelo de registro de asistencia
            $this->registroModelo = new RegistroIngresoModelo();
            // Instancia el modelo para panel de asistencia (para obtener información del personal)
            $this->panelIngresoModelo = new PanelIngresoModelo();
        }

        /**
         * Método mostrarVistaRegistro:
         * Muestra la vista principal de asistencia, incluyendo el último registro de asistencia en la parte superior.
         */
        public function mostrarVistaRegistro() {
            // Se obtiene el último registro de asistencia guardado en la BD.
            $ultimosRegistros = $this->registroModelo->obtenerUltimosRegistros();

            // Se incluye la vista que muestra el formulario y la tabla de últimos registros.
            include_once __DIR__ . '/../views/gestion/registro_ingreso/registro_ingresos.php';
        }

        /**
         * Método registrarAsistencia:
         * Maneja la lógica de registrar la entrada o salida de un usuario (personal) según su número de identidad.
         */
        public function registrarAsistencia() {
            // Verificamos si la petición es POST para procesar el formulario
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtenemos el código (número de identidad) enviado desde el formulario
                $numero_identidad = trim($_POST['codigo']); // Código del usuario escaneado o ingresado
                
                // Validamos que no venga vacío
                if (!empty($numero_identidad)) {
                    try {
                        // Se busca al usuario/personal en la BD a través de su número de identidad
                        $personal = $this->panelIngresoModelo->obtenerPorIdentidad($numero_identidad);

                        // Si se encontró un usuario/personal con ese número de identidad
                        if ($personal) {
                            // Fecha y hora actual para registrar la asistencia
                            $fecha = date('Y-m-d');
                            $horaActual = date('H:i:s');

                            // Se verifica si ya hay un registro de asistencia para este usuario en el día actual
                            $registroDelDia = $this->registroModelo->obtenerAsistenciaDelDia($personal['id'], $fecha);
                            
                            // Si existe un registro para hoy
                            if ($registroDelDia) {
                                // Se valida el estado del registro (Activo o Finalizado)
                                if ($registroDelDia['estado'] === 'Activo') {
                                    // Si está 'Activo', significa que solo falta registrar la salida
                                    $this->registroModelo->registrarSalida($personal['id'], $fecha, $horaActual);

                                    // Guardamos un mensaje de retroalimentación en la sesión
                                    $_SESSION['mensaje'] = [
                                        'texto' => 'Salida registrada correctamente para ' . $personal['nombre'],
                                        'tipo'  => 'salida' // Usado en las alertas
                                    ];
                                } else {
                                    // Si el estado no es 'Activo', significa que ya se completó la asistencia
                                    $_SESSION['mensaje'] = [
                                        'texto' => 'Asistencia ya completada para el día de hoy.',
                                        'tipo'  => 'warning'
                                    ];
                                }
                            } else {
                                // Si no existe un registro para hoy, se registra la entrada
                                $this->registroModelo->registrarEntrada($personal['id'], $fecha, $horaActual);

                                $_SESSION['mensaje'] = [
                                    'texto' => 'Entrada registrada correctamente para ' . $personal['nombre'],
                                    'tipo'  => 'entrada',
                                ];
                            }

                            // Guardar el ID del usuario en la sesión (por si necesitamos referirnos a él más tarde)
                            $_SESSION['usuario_id'] = $personal['id'];

                            // Redirigimos a la misma página de registro de asistencia
                            header('Location: registro_ingreso');
                            exit;
                            
                        } else {
                            // Si no se encontró un usuario con esa cédula, se muestra un mensaje de error
                            $_SESSION['mensaje'] = [
                                'texto' => 'Personal no encontrado.',
                                'tipo'  => 'danger'
                            ];
                        }
                    } catch (Exception $e) {
                        // Si ocurre una excepción, se registra en el log y se muestra un mensaje genérico
                        error_log("Error en registrarAsistencia: " . $e->getMessage());
                        $_SESSION['mensaje'] = [
                            'texto' => 'Error en el sistema. Inténtalo más tarde.',
                            'tipo'  => 'danger'
                        ];
                    }
                } else {
                    // Si el código (número de identidad) viene vacío
                    $_SESSION['mensaje'] = [
                        'texto' => 'Código no proporcionado.',
                        'tipo'  => 'warning'
                    ];
                }

                // Redirigimos a la misma página para mostrar el mensaje (o refrescar el formulario)
                header('Location: registro_ingreso');
                exit;
            }
        }
    }
