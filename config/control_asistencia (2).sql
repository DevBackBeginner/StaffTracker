-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2025 a las 03:59:16
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
-- Base de datos: `control_asistencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_computadores`
--

CREATE TABLE `asignaciones_computadores` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `computador_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaciones_computadores`
--

INSERT INTO `asignaciones_computadores` (`id`, `usuario_id`, `computador_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `computadores`
--

CREATE TABLE `computadores` (
  `id` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `tipo_computador` enum('Sena','Personal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `computadores`
--

INSERT INTO `computadores` (`id`, `marca`, `codigo`, `tipo_computador`) VALUES
(1, 'HP', 'HP001', 'Sena'),
(2, 'Lenovo', 'LN002', 'Personal'),
(3, 'Dell', 'DE003', 'Personal'),
(4, 'Asus', 'AS004', 'Sena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_asistencia`
--

CREATE TABLE `registro_asistencia` (
  `id` int(11) NOT NULL,
  `asignacion_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora_entrada` time NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `estado` enum('Activo','Finalizado') NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_asistencia`
--

INSERT INTO `registro_asistencia` (`id`, `asignacion_id`, `fecha`, `hora_entrada`, `hora_salida`, `estado`) VALUES
(37, 1, '2025-02-28', '21:01:01', NULL, 'Activo'),
(38, 2, '2025-02-28', '21:04:07', NULL, 'Activo'),
(39, 3, '2025-02-28', '21:04:21', NULL, 'Activo'),
(40, 4, '2025-02-28', '21:04:35', '21:04:42', 'Finalizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `numero_identidad` varchar(20) NOT NULL,
  `rol` enum('Instructor','Funcionario','Directiva','Apoyo','Guardas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `numero_identidad`, `rol`) VALUES
(1, 'Juan Pérez', '123456789', 'Instructor'),
(2, 'María Gómez', '987654321', 'Funcionario'),
(3, 'Carlos López', '456789123', 'Directiva'),
(4, 'Andrea Ruiz', '789123456', 'Apoyo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_apoyo`
--

CREATE TABLE `usuarios_apoyo` (
  `usuario_id` int(11) NOT NULL,
  `area_trabajo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_apoyo`
--

INSERT INTO `usuarios_apoyo` (`usuario_id`, `area_trabajo`) VALUES
(4, 'Administrativa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_directivas`
--

CREATE TABLE `usuarios_directivas` (
  `usuario_id` int(11) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `departamento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_directivas`
--

INSERT INTO `usuarios_directivas` (`usuario_id`, `cargo`, `departamento`) VALUES
(3, 'Subdirectora Administrativa', 'Departamento Administrativo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_funcionarios`
--

CREATE TABLE `usuarios_funcionarios` (
  `usuario_id` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `puesto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_funcionarios`
--

INSERT INTO `usuarios_funcionarios` (`usuario_id`, `area`, `puesto`) VALUES
(2, 'Recursos Humanos', 'Analista de RRHH');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_instructores`
--

CREATE TABLE `usuarios_instructores` (
  `usuario_id` int(11) NOT NULL,
  `curso` varchar(255) NOT NULL,
  `ubicacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_instructores`
--

INSERT INTO `usuarios_instructores` (`usuario_id`, `curso`, `ubicacion`) VALUES
(1, 'Programación Web', 'Aula 101');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones_computadores`
--
ALTER TABLE `asignaciones_computadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`computador_id`),
  ADD KEY `computador_id` (`computador_id`);

--
-- Indices de la tabla `computadores`
--
ALTER TABLE `computadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asignacion_id` (`asignacion_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_identidad` (`numero_identidad`),
  ADD KEY `idx_usuarios_rol` (`rol`);

--
-- Indices de la tabla `usuarios_apoyo`
--
ALTER TABLE `usuarios_apoyo`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `usuarios_directivas`
--
ALTER TABLE `usuarios_directivas`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `usuarios_funcionarios`
--
ALTER TABLE `usuarios_funcionarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `idx_funcionarios_area` (`area`),
  ADD KEY `idx_funcionarios_puesto` (`puesto`);

--
-- Indices de la tabla `usuarios_instructores`
--
ALTER TABLE `usuarios_instructores`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaciones_computadores`
--
ALTER TABLE `asignaciones_computadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `computadores`
--
ALTER TABLE `computadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones_computadores`
--
ALTER TABLE `asignaciones_computadores`
  ADD CONSTRAINT `asignaciones_computadores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignaciones_computadores_ibfk_2` FOREIGN KEY (`computador_id`) REFERENCES `computadores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  ADD CONSTRAINT `registro_asistencia_ibfk_1` FOREIGN KEY (`asignacion_id`) REFERENCES `asignaciones_computadores` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuarios_apoyo`
--
ALTER TABLE `usuarios_apoyo`
  ADD CONSTRAINT `usuarios_apoyo_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios_directivas`
--
ALTER TABLE `usuarios_directivas`
  ADD CONSTRAINT `usuarios_directivas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios_funcionarios`
--
ALTER TABLE `usuarios_funcionarios`
  ADD CONSTRAINT `usuarios_funcionarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios_instructores`
--
ALTER TABLE `usuarios_instructores`
  ADD CONSTRAINT `usuarios_instructores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
