-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2025 a las 01:23:27
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `control_entrada_salida`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendices`
--

CREATE TABLE `aprendices` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `numero_identidad` varchar(50) NOT NULL,
  `ficha_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aprendices`
--

INSERT INTO `aprendices` (`id`, `nombre`, `numero_identidad`, `ficha_id`) VALUES
(1, 'Juan Pérez', '123456789', 1),
(2, 'Ana García', '987654321', 2),
(3, 'Carlos López', '456789123', 3),
(5, 'Juan Pablo', '1072745267', 2),
(7, 'Maria pendejo', '1172745267', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `aprendiz_id` int(11) DEFAULT NULL,
  `hora_entrada` time DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `entrada_computador` enum('si','no') NOT NULL DEFAULT 'no',
  `salida_computador` enum('si','no') NOT NULL DEFAULT 'no',
  `fecha` date NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `aprendiz_id`, `hora_entrada`, `hora_salida`, `entrada_computador`, `salida_computador`, `fecha`, `estado`) VALUES
(21, 1, '11:58:54', '11:58:58', 'no', 'no', '2025-02-23', 'activo'),
(22, 2, '13:02:41', '17:05:25', 'no', 'no', '2025-02-23', 'activo'),
(23, 5, '16:14:45', NULL, 'no', 'no', '2025-02-24', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `computadores`
--

CREATE TABLE `computadores` (
  `id` int(11) NOT NULL,
  `marca_computador` varchar(255) NOT NULL,
  `codigo_computador` varchar(50) NOT NULL,
  `aprendiz_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `computadores`
--

INSERT INTO `computadores` (`id`, `marca_computador`, `codigo_computador`, `aprendiz_id`) VALUES
(1, 'Computador 1', 'C001', 1),
(2, 'Computador 2', 'C002', 2),
(3, 'Computador 3', 'C003', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `id` int(11) NOT NULL,
  `codigo_ficha` varchar(50) NOT NULL,
  `nombre_ficha` varchar(255) NOT NULL,
  `turno` enum('mañana','tarde','noche') NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`id`, `codigo_ficha`, `nombre_ficha`, `turno`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 'F001', 'Ficha 1', 'mañana', '2023-01-01', '2023-12-31'),
(2, 'F002', 'Ficha 2', 'tarde', '2023-02-01', '2023-12-31'),
(3, 'F003', 'Ficha 3', 'noche', '2023-03-01', '2023-12-31'),
(4, 'ficha004', 'ficha0004', 'noche', '2023-01-23', '2025-04-15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_identidad` (`numero_identidad`),
  ADD KEY `ficha_id` (`ficha_id`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aprendiz_id` (`aprendiz_id`);

--
-- Indices de la tabla `computadores`
--
ALTER TABLE `computadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_computador` (`codigo_computador`),
  ADD KEY `aprendiz_id` (`aprendiz_id`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo_ficha`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aprendices`
--
ALTER TABLE `aprendices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `computadores`
--
ALTER TABLE `computadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aprendices`
--
ALTER TABLE `aprendices`
  ADD CONSTRAINT `aprendices_ibfk_1` FOREIGN KEY (`ficha_id`) REFERENCES `fichas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`aprendiz_id`) REFERENCES `aprendices` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `computadores`
--
ALTER TABLE `computadores`
  ADD CONSTRAINT `computadores_ibfk_1` FOREIGN KEY (`aprendiz_id`) REFERENCES `aprendices` (`id`) ON DELETE SET NULL;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `inactivar_asistencias_diarias` ON SCHEDULE EVERY 1 DAY STARTS '2025-02-23 00:30:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE asistencias
    SET estado = 'inactivo'
    WHERE DATE(hora_entrada) < CURDATE();
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
