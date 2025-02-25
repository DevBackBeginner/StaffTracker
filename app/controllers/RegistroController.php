<?php 

// Incluir el modelo que maneja las operaciones relacionadas con el registro
require_once __DIR__ . '/../models/RegistroModelo.php';
require_once __DIR__ . '/../models/PanelModelo.php';

// Iniciar la sesión para manejar la autenticación y los mensajes de error/éxito
session_start();

// Definición de la clase RegistroController
class RegistroController {
    // Propiedad privada para almacenar la instancia del modelo de registro
    private $registroModelo;
    private $panelModelo;
    // Constructor: Se instancia el modelo RegistroModelo para poder interactuar con la base de datos
    public function __construct() {
        $this->registroModelo = new RegistroModelo();
        $this->panelModelo = new PanelModelo();
    }
    
    // Método para manejar el registro de entrada de asistencia
    public function registrarAsistencia() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo = trim($_POST['codigo']);  // Elimina espacios en blanco
            $numero_identidad = $codigo; // Asumiendo que el código es el número de identidad

            if ($numero_identidad) {
                try {
                    // Buscar al aprendiz por número de identidad
                    $aprendiz = $this->panelModelo->obtenerPorIdentidad($numero_identidad);

                    if ($aprendiz) {
                        $horaActual = date('Y-m-d H:i:s');

                        if (!isset($aprendiz['hora_entrada']) || is_null($aprendiz['hora_entrada'])) {
                            // Registrar la hora de entrada
                            $this->registroModelo->registrarEntrada($aprendiz['id'], $horaActual);
                            $mensaje = 'Entrada registrada correctamente.';
                        } elseif (!isset($aprendiz['hora_salida']) || is_null($aprendiz['hora_salida'])) {
                            // Registrar la hora de salida
                            $this->registroModelo->registrarSalida($aprendiz['id'], $horaActual);
                            $mensaje = 'Salida registrada correctamente.';
                        } else {
                            $mensaje = 'Asistencia ya completada para el día de hoy.';
                        }

                        echo json_encode(['success' => true, 'message' => $mensaje]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Aprendiz no encontrado.']);
                    }
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Código no proporcionado.']);
            }
        }
    }


    // Método para registrar un computador
    public function registrarComputador() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos del formulario
            $aprendizId = $_POST['aprendiz_id'] ?? null;
            $marcaComputador = $_POST['marca'] ?? null;
            $codigoComputador = $_POST['codigo'] ?? null;
    
            // Validar los datos
            if ($aprendizId && $marcaComputador && $codigoComputador) {
                try {
                    // Registrar el computador en la base de datos
                    $resultado = $this->registroModelo->registroComputador($aprendizId, $marcaComputador, $codigoComputador);
    
                    if ($resultado) {
                        // Redirigir o mostrar un mensaje de éxito
                        $_SESSION['mensaje'] = 'Computador registrado correctamente.';
                        header('Location: panel');
                        exit;
                    } else {
                        $_SESSION['error'] = 'Error al registrar el computador.';
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = 'Error: ' . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = 'Datos incompletos.';
            }
    
            // Redirigir en caso de error
            header('Location: panel');
            exit;
        }
    }
}
