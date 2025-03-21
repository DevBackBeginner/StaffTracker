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
                    FROM registros 
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
                    FROM registros 
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
                    FROM registros 
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
                    FROM registros 
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
                    FROM registros 
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
                    FROM registros 
                    WHERE MONTH(fecha) = MONTH(CURDATE() - INTERVAL 1 MONTH) 
                        AND YEAR(fecha) = YEAR(CURDATE() - INTERVAL 1 MONTH)";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerFuncionariosDiarios()
        {
            // Lógica para obtener el total de funcionarios registrados hoy
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE DATE(fecha) = CURDATE()
                        and tipo_usuario = 'Personal'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerFuncionariosDiariosAnterior()
        {
            // Lógica para obtener el total de funcionarios registrados el día anterior
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE DATE(fecha) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                        AND tipo_usuario = 'Personal'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerFuncionariosSemanales()
        {
            // Lógica para obtener el total de funcionarios registrados esta semana
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE YEARWEEK(fecha, 1) = YEARWEEK(CURDATE(), 1)
                        AND tipo_usuario = 'Personal'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerFuncionariosSemanalesAnterior()
        {
            // Lógica para obtener el total de funcionarios registrados la semana anterior
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE YEARWEEK(fecha, 1) = YEARWEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK), 1)
                        AND tipo_usuario = 'Personal'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerFuncionariosMensuales()
        {
            // Lógica para obtener el total de funcionarios registrados este mes
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE MONTH(fecha) = MONTH(CURDATE())
                        AND YEAR(fecha) = YEAR(CURDATE())
                        AND tipo_usuario = 'Personal'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerFuncionariosMensualesAnterior()
        {
            // Lógica para obtener el total de funcionarios registrados el mes anterior
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE MONTH(fecha) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                        AND YEAR(fecha) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                        AND tipo_usuario = 'Personal'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerVisitantesDiarios()
        {
            // Lógica para obtener el total de visitantes registrados hoy
            $query = "SELECT COUNT(*) as total 
            FROM registros 
                    WHERE DATE(fecha) = CURDATE()
                        and tipo_usuario = 'visitante'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;       
        }

        public function obtenerVisitantesDiariosAnterior()
        {
            // Lógica para obtener el total de visitantes registrados el día anterior
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE DATE(fecha) = CURDATE() - INTERVAL 1 DAY
                        AND tipo_usuario = 'visitante'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerVisitantesSemanales()
        {
            // Lógica para obtener el total de visitantes registrados esta semana
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE YEARWEEK(fecha, 1) = YEARWEEK(CURDATE(), 1)
                        AND tipo_usuario = 'visitante'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerVisitantesSemanalesAnterior()
        {
            // Lógica para obtener el total de visitantes registrados la semana anterior
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE YEARWEEK(fecha, 1) = YEARWEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK), 1)
                        AND tipo_usuario = 'visitante'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerVisitantesMensuales()
        {
            // Lógica para obtener el total de visitantes registrados este mes
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE MONTH(fecha) = MONTH(CURDATE())
                        AND YEAR(fecha) = YEAR(CURDATE())
                        AND tipo_usuario = 'visitante'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        public function obtenerVisitantesMensualesAnterior()
        {
            // Lógica para obtener el total de visitantes registrados el mes anterior
            $query = "SELECT COUNT(*) as total 
                    FROM registros 
                    WHERE MONTH(fecha) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                        AND YEAR(fecha) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                        AND tipo_usuario = 'visitante'";
            $stmt = $this->db->query($query);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
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