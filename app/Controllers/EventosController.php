<?php
session_start();

require_once __DIR__ . '/../Models/ComputadorModelo.php';
require_once __DIR__ . '/../Models/EventosModelo.php';
require_once __DIR__ . '/../Models/PersonalModelo.php';
require_once __DIR__ . '/../Models/RegistroModelo.php';
require_once '../config/DataBase.php';

class EventosController
{
    private $eventoModelo;
    private $computadorModelo;
    private $registroModelo;
    private $db;

    public function __construct()
    {
        $this->eventoModelo = new EventosModelo();
        $this->computadorModelo = new ComputadorModelo();
        $this->registroModelo = new RegistroModelo();

        $conn = new DataBase();
        $this->db = $conn->getConnection();

        // Configuración de errores
        ini_set('display_errors', 0);
        error_reporting(E_ALL);
        ini_set('log_errors', 1);
        ini_set('error_log', __DIR__ . '/php-errors.log');
    }

    public function mostrarRegistroEvento()
    {
        $equiposDisponibles = $this->computadorModelo->obtenerComputadoresDisponibles();
        include_once __DIR__ . '/../Views/gestion/eventos/registrar_eventos.php';
    }

    public function mostrarDevolverEventos() {
        try {
            // Obtener eventos activos (sin devolución registrada)
            $eventosActivos = $this->eventoModelo->obtenerEventosActivos();
            
            // Obtener equipos prestados para cada evento
            foreach ($eventosActivos as &$evento) {
                $evento['equipos'] = $this->computadorModelo->obtenerEquiposPorEvento($evento['id_evento']);
            }
            
            include_once __DIR__ . '/../Views/gestion/eventos/registrar_regreso.php';
            
        } catch (PDOException $e) {
            error_log("Error al cargar vista de devolución: " . $e->getMessage());
            $_SESSION['error'] = "Error al cargar los eventos";
            header('Location: registrar_eventos');
            exit;
        }
    }

    public function registroEvento()
    {
        // Validar método HTTP
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['error'] = "Método no permitido";
            header('Location: registrar_eventos');
            exit;
        }

        // Validar campos obligatorios
        $camposRequeridos = ['numero_documento', 'proposito', 'equipos'];
        foreach ($camposRequeridos as $campo) {
            if (empty($_POST[$campo])) {
                $_SESSION['error'] = "El campo " . ucfirst(str_replace('_', ' ', $campo)) . " es requerido";
                header('Location: registrar_eventos');
                exit;
            }
        }

        // Validar formato del documento
        $documento = trim($_POST['numero_documento']);
        if (!preg_match('/^[0-9]{6,20}$/', $documento)) {
            $_SESSION['error'] = "Documento inválido. Debe contener solo números (6-20 dígitos)";
            header('Location: registrar_eventos');
            exit;
        }

        // Validar que el documento exista
        $persona = $this->registroModelo->obtenerUsuarioPorDocumento($documento);
        if (!$persona) {
            $_SESSION['error'] = "Documento no registrado en el sistema";
            header('Location: registrar_eventos');
            exit;
        }

        // Validar formato JSON de equipos
        $equipos = json_decode($_POST['equipos'], true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($equipos) || count($equipos) === 0) {
            $_SESSION['error'] = "Debe seleccionar al menos un equipo válido";
            header('Location: registrar_eventos');
            exit;
        }

        // Validar longitud del propósito
        $proposito = trim($_POST['proposito']);
        if (strlen($proposito) < 10 || strlen($proposito) > 200) {
            $_SESSION['error'] = "El propósito debe tener entre 10 y 200 caracteres";
            header('Location: registrar_eventos');
            exit;
        }

        // ========== REGISTRO ========== //
        try {
            $this->db->beginTransaction();
    
            // Registrar SALIDA (función normal con parámetros)
            $idRegistro = $this->eventoModelo->registrarSalida(
                $persona['id_persona'], 
                date('H:i:s')
            );
            
            // DEBUG: Verifica que se obtuvo un ID válido
            if (!$idRegistro) {
                error_log("Error: No se pudo crear el registro de salida");
                throw new Exception("Error al crear registro de salida");
            }
    
            // Crear EVENTO (función normal con parámetros)
            $idEvento = $this->eventoModelo->crearEvento(
                $idRegistro,             // Primer parámetro
                $proposito,              // Segundo parámetro
                date('Y-m-d H:i:s')      // Tercer parámetro (fecha_salida)
            );
    
            // 3. Vincular EQUIPOS (función normal con parámetros)
            foreach ($equipos as $idEquipo) {
                $this->computadorModelo->vincularEquipoAEvento(
                    $idEvento,           // Primer parámetro
                    $idEquipo            // Segundo parámetro
                );
                
                $this->computadorModelo->actualizarEstadoEquipo(
                    $idEquipo,          // ID del equipo
                    'Asignado',         // Nuevo estado
                    $persona['id_persona'], 

                );
            }
    
            $this->db->commit();
            $_SESSION['success'] = "Evento registrado exitosamente";
    
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error al registrar evento: " . $e->getMessage());
            $_SESSION['error'] = "Error al procesar el registro";
        }
    
        header('Location: registrar_eventos');
        exit;
    }

    public function registrarDevolucion() {
        // Validar método HTTP
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['error'] = "Método no permitido";
            header('Location: registrar_regreso');
            exit;
        }
    
        // Validar que se reciba el ID del evento
        if (empty($_POST['id_evento'])) {
            $_SESSION['error'] = "ID de evento no proporcionado";
            header('Location: registrar_regreso');
            exit;
        }
    
        $idEvento = (int)$_POST['id_evento'];
    
        try {
            $this->db->beginTransaction();
    
            // 1. Registrar devolución en el modelo de Eventos (marca fecha_devolucion)
            $equipos = $this->eventoModelo->registrarDevolucion($idEvento);
    
            // 2. Actualizar estado de cada equipo (a Disponible y limpiar asignado_a)
            foreach ($equipos as $idEquipo) {
                $this->computadorModelo->registrarDevolucionEquipo($idEquipo);
            }
    
            $this->db->commit();
            $_SESSION['success'] = "Devolución de equipos registrada exitosamente";
    
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error al registrar devolución: " . $e->getMessage());
            $_SESSION['error'] = "Error al procesar la devolución: " . $e->getMessage();
        }
    
        header('Location: registrar_regreso');
        exit;
    }
}