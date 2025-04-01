<?php
    require_once '../config/DataBase.php';

    class EventosModelo
    {
        private $db;

        public function __construct()
        {
            $conn = new DataBase();
            // Obtener la conexión y asignarla a la variable $db
            $this->db = $conn->getConnection();        
        }

        public function crearEvento($id_registro, $proposito, $fecha_salida) {
            $stmt = $this->db->prepare("
                INSERT INTO eventos_especiales 
                (id_registro_ingreso, proposito, fecha_salida)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$id_registro, $proposito, $fecha_salida]);
            return $this->db->lastInsertId();
        }

        public function obtenerEventosActivos() {
            $stmt = $this->db->prepare("
                SELECT 
                    e.id_evento,
                    p.nombre AS nombre_persona,
                    p.numero_documento,
                    e.proposito,
                    e.fecha_salida
                FROM eventos_especiales e
                JOIN registro_ingreso_salida r ON e.id_registro_ingreso = r.id_registro
                JOIN personas p ON r.id_persona = p.id_persona
                WHERE e.fecha_devolucion IS NULL
                ORDER BY e.fecha_salida DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function registrarSalida($id_persona, $hora_salida) {
            $stmt = $this->db->prepare("
                INSERT INTO registro_ingreso_salida 
                (id_persona, fecha, hora_salida, estado_presencia)
                VALUES (?, CURDATE(), ?, 'Fuera de la sede')
            ");
            
            if ($stmt->execute([$id_persona, $hora_salida])) {
                return $this->db->lastInsertId(); // Retorna el ID generado
            }
            
            return false; // Retorna false si falla
        }

        public function registrarDevolucion($idEvento) {
            // Actualizar fecha de devolución del evento
            $stmt = $this->db->prepare("
                UPDATE eventos_especiales 
                SET fecha_devolucion = NOW() 
                WHERE id_evento = ?
            ");
            $stmt->execute([$idEvento]);
            
            //  Obtener los equipos asociados a este evento
            $equipos = $this->obtenerEquiposPorEvento($idEvento);
            
            return $equipos; // Retornamos los IDs de equipos para actualizarlos
        }
        
        public function obtenerEquiposPorEvento($idEvento) {
            $stmt = $this->db->prepare("
                SELECT id_equipo_sena 
                FROM equipos_evento 
                WHERE id_evento = ?
            ");
            $stmt->execute([$idEvento]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    
    }
?>