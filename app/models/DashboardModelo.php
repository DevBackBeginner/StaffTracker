<?php
    require_once '../config/DataBase.php';

    class DashboardModelo
    {
        private $db;

        public function __construct()
        {
            $conn = new DataBase();
            // Obtener la conexión y asignarla a la variable $db
            $this->db = $conn->getConnection();        
        }

        /**
         * Obtener el total de registros diarios.
         * @return int Total de registros del día actual.
         */
        public function obtenerRegistroDiario()
        {
            $query = "SELECT COUNT(*) as total 
                    FROM registro_ingreso_salida 
                    WHERE DATE(fecha) = CURDATE()";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        /**
         * Obtener el total de registros del día anterior.
         * @return int Total de registros del día anterior.
         */
        public function obtenerRegistrosDiaAnterior()
        {
            $query = "SELECT COUNT(*) as total 
                    FROM registro_ingreso_salida 
                    WHERE DATE(fecha) = CURDATE() - INTERVAL 1 DAY";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        /**
         * Obtener el total de registros semanales.
         * @return int Total de registros de la semana actual.
         */
        public function obtenerRegistroSemanal()
        {
            $query = "SELECT COUNT(*) as total 
                    FROM registro_ingreso_salida 
                    WHERE WEEK(fecha) = WEEK(CURDATE()) 
                        AND YEAR(fecha) = YEAR(CURDATE())";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        /**
         * Obtener el total de registros de la semana anterior.
         * @return int Total de registros de la semana anterior.
         */
        public function obtenerRegistrosSemanaAnterior()
        {
            $query = "SELECT COUNT(*) as total 
                    FROM registro_ingreso_salida 
                    WHERE WEEK(fecha) = WEEK(CURDATE()) - 1 
                        AND YEAR(fecha) = YEAR(CURDATE())";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        /**
         * Obtener el total de registros mensuales.
         * @return int Total de registros del mes actual.
         */
        public function obtenerRegistroMensual()
        {
            $query = "SELECT COUNT(*) as total 
                    FROM registro_ingreso_salida 
                    WHERE MONTH(fecha) = MONTH(CURDATE()) 
                        AND YEAR(fecha) = YEAR(CURDATE())";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        /**
         * Obtener el total de registros del mes anterior.
         * @return int Total de registros del mes anterior.
         */
        public function obtenerRegistroMensualAnterior()
        {
            $query = "SELECT COUNT(*) as total 
                    FROM registro_ingreso_salida 
                    WHERE MONTH(fecha) = MONTH(CURDATE() - INTERVAL 1 MONTH) 
                        AND YEAR(fecha) = YEAR(CURDATE() - INTERVAL 1 MONTH)";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerFuncionariosDiarios()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE DATE(ris.fecha) = CURDATE()
                    AND p.rol NOT IN ('Administrador', 'Guarda', 'Visitante')";
            return $this->ejecutarConsultaCount($query);
        }

        public function obtenerFuncionariosDiariosAnterior()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE DATE(ris.fecha) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                    AND p.rol NOT IN ('Administrador', 'Guarda', 'Visitante')";
            return $this->ejecutarConsultaCount($query);
        }

        public function obtenerFuncionariosSemanales()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE YEARWEEK(ris.fecha, 1) = YEARWEEK(CURDATE(), 1)
                    AND p.rol NOT IN ('Administrador', 'Guarda', 'Visitante')";
            return $this->ejecutarConsultaCount($query);
        }

        public function obtenerFuncionariosSemanalesAnterior()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE YEARWEEK(ris.fecha, 1) = YEARWEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK), 1)
                    AND p.rol NOT IN ('Administrador', 'Guarda', 'Visitante')";
            return $this->ejecutarConsultaCount($query);
        }

        public function obtenerFuncionariosMensuales()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE MONTH(ris.fecha) = MONTH(CURDATE())
                    AND YEAR(ris.fecha) = YEAR(CURDATE())
                    AND p.rol NOT IN ('Administrador', 'Guarda', 'Visitante')";
            return $this->ejecutarConsultaCount($query);
        }

        public function obtenerFuncionariosMensualesAnterior()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE MONTH(ris.fecha) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                    AND YEAR(ris.fecha) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                    AND p.rol NOT IN ('Administrador', 'Guarda', 'Visitante')";
            return $this->ejecutarConsultaCount($query);
        }
        public function obtenerVisitantesDiarios()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE DATE(ris.fecha) = CURDATE()
                    AND p.rol = 'Visitante'";
            return $this->ejecutarConsultaCount($query);
        }

        public function obtenerVisitantesDiariosAnterior()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE DATE(ris.fecha) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                    AND p.rol = 'Visitante'";
            return $this->ejecutarConsultaCount($query);
        }

        public function obtenerVisitantesSemanales()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE YEARWEEK(ris.fecha, 1) = YEARWEEK(CURDATE(), 1)
                    AND p.rol = 'Visitante'";
            return $this->ejecutarConsultaCount($query);
        }

        public function obtenerVisitantesSemanalesAnterior()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE YEARWEEK(ris.fecha, 1) = YEARWEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK), 1)
                    AND p.rol = 'Visitante'";
            return $this->ejecutarConsultaCount($query);
        }

        public function obtenerVisitantesMensuales()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE MONTH(ris.fecha) = MONTH(CURDATE())
                    AND YEAR(ris.fecha) = YEAR(CURDATE())
                    AND p.rol = 'Visitante'";
            return $this->ejecutarConsultaCount($query);
        }

        public function obtenerVisitantesMensualesAnterior()
        {
            $query = "SELECT COUNT(DISTINCT ris.id_persona) as total 
                    FROM registro_ingreso_salida ris
                    INNER JOIN personas p ON ris.id_persona = p.id_persona
                    WHERE MONTH(ris.fecha) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                    AND YEAR(ris.fecha) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                    AND p.rol = 'Visitante'";
            return $this->ejecutarConsultaCount($query);
        }
        
        private function ejecutarConsultaCount($query)
        {
            try {
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                return (int)($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
            } catch (PDOException $e) {
                error_log("Error en consulta: " . $e->getMessage());
                return 0;
            }
        }
        /**
         * Calcular el porcentaje de aumento o disminución.
         * @param int $actual Valor actual.
         * @param int $anterior Valor anterior.
         * @return float Porcentaje de aumento o disminución.
         */
        public function calcularPorcentajeAumento($actual, $anterior)
        {
            if ($anterior == 0) {
                return 0; // Evitar división por cero
            }
            return (($actual - $anterior) / $anterior) * 100;
        }
    }
    
?>