-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-03-2025 a las 18:20:44
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
-- Base de datos: `control_asistencias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apoyo`
--

CREATE TABLE `apoyo` (
  `usuario_id` int(11) NOT NULL,
  `area_trabajo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `apoyo`
--

INSERT INTO `apoyo` (`usuario_id`, `area_trabajo`) VALUES
(13, 'Limpieza'),
(14, 'Mantenimiento'),
(15, 'Seguridad'),
(16, 'Logística');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_computadores`
--

CREATE TABLE `asignaciones_computadores` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `computador_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaciones_computadores`
--

INSERT INTO `asignaciones_computadores` (`id`, `usuario_id`, `computador_id`) VALUES
(1, 2, 1),
(2, 3, 2),
(3, 4, 3),
(43, 5, NULL),
(4, 5, 4),
(5, 6, 5),
(6, 7, 6),
(7, 8, 7),
(8, 9, 8),
(9, 10, 9),
(10, 11, 10),
(11, 12, 11),
(12, 13, 12),
(13, 14, 13),
(14, 15, 14),
(15, 16, 15),
(42, 17, NULL),
(16, 17, 16),
(17, 18, 17),
(18, 19, 18),
(41, 20, NULL),
(19, 20, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `computadores`
--

CREATE TABLE `computadores` (
  `id` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `tipo_computador` enum('Sena','Personal') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `computadores`
--

INSERT INTO `computadores` (`id`, `marca`, `codigo`, `tipo_computador`) VALUES
(1, 'Dell', 'DELL001', 'Sena'),
(2, 'HP', 'HP001', 'Personal'),
(3, 'Lenovo', 'LEN001', 'Sena'),
(4, 'Apple', 'MAC001', 'Personal'),
(5, 'Asus', 'ASUS001', 'Sena'),
(6, 'Acer', 'ACER001', 'Personal'),
(7, 'Dell', 'DELL002', 'Sena'),
(8, 'HP', 'HP002', 'Personal'),
(9, 'Lenovo', 'LEN002', 'Sena'),
(10, 'Apple', 'MAC002', 'Personal'),
(11, 'Asus', 'ASUS002', 'Sena'),
(12, 'Acer', 'ACER002', 'Personal'),
(13, 'Dell', 'DELL003', 'Sena'),
(14, 'HP', 'HP003', 'Personal'),
(15, 'Lenovo', 'LEN003', 'Sena'),
(16, 'Apple', 'MAC003', 'Personal'),
(17, 'Asus', 'ASUS003', 'Sena'),
(18, 'Acer', 'ACER003', 'Personal'),
(19, 'Dell', 'DELL004', 'Sena'),
(20, 'HP', 'HP004', 'Personal'),
(21, 'Lenovo', 'LEN004', 'Sena'),
(22, 'Apple', 'MAC004', 'Personal'),
(23, 'Asus', 'ASUS004', 'Sena'),
(24, 'Acer', 'ACER004', 'Personal'),
(25, 'Dell', 'DELL005', 'Sena'),
(26, 'HP', 'HP005', 'Personal'),
(27, 'Lenovo', 'LEN005', 'Sena'),
(28, 'Apple', 'MAC005', 'Personal'),
(29, 'Asus', 'ASUS005', 'Sena'),
(30, 'Acer', 'ACER005', 'Personal'),
(31, 'Dell', 'DELL006', 'Sena'),
(32, 'HP', 'HP006', 'Personal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directivos`
--

CREATE TABLE `directivos` (
  `usuario_id` int(11) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `departamento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `directivos`
--

INSERT INTO `directivos` (`usuario_id`, `cargo`, `departamento`) VALUES
(9, 'Gerente', 'Administración'),
(10, 'Director', 'Recursos Humanos'),
(11, 'Subdirector', 'Finanzas'),
(12, 'Coordinador', 'Tecnología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionarios`
--

CREATE TABLE `funcionarios` (
  `usuario_id` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `puesto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `funcionarios`
--

INSERT INTO `funcionarios` (`usuario_id`, `area`, `puesto`) VALUES
(5, 'Recursos Humanos', 'Analista'),
(6, 'Finanzas', 'Contador'),
(7, 'Tecnología', 'Desarrollador'),
(8, 'Mantenimiento', 'Técnico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guardas`
--

CREATE TABLE `guardas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `turno` enum('mañana','tarde','noche') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `guardas`
--

INSERT INTO `guardas` (`id`, `usuario_id`, `turno`) VALUES
(5, 25, 'noche');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructores`
--

CREATE TABLE `instructores` (
  `usuario_id` int(11) NOT NULL,
  `curso` varchar(255) NOT NULL,
  `ubicacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instructores`
--

INSERT INTO `instructores` (`usuario_id`, `curso`, `ubicacion`) VALUES
(2, 'Diseño Gráfico', 'Aula 102'),
(3, 'Redes', 'Aula 103'),
(4, 'Base de Datos', 'Aula 104');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_acceso`
--

CREATE TABLE `registro_acceso` (
  `id` int(11) NOT NULL,
  `asignacion_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora_entrada` time NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `estado` enum('Activo','Finalizado') NOT NULL DEFAULT 'Activo',
  `tipo_usuario` enum('Personal','Visitante') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_acceso`
--

INSERT INTO `registro_acceso` (`id`, `asignacion_id`, `fecha`, `hora_entrada`, `hora_salida`, `estado`, `tipo_usuario`) VALUES
(1, 41, '2025-03-14', '11:12:23', NULL, 'Activo', 'Visitante'),
(2, 42, '2025-03-14', '11:13:15', '11:35:27', 'Finalizado', 'Visitante'),
(3, 43, '2025-03-14', '11:36:03', '11:36:17', 'Finalizado', 'Personal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(260) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `numero_identidad` varchar(20) NOT NULL,
  `rol` enum('Instructor','Funcionario','Directivo','Apoyo','Visitante','Admin','Guarda') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `telefono`, `numero_identidad`, `rol`) VALUES
(2, 'María', 'Gómez', '3102345678', '1000000002', 'Instructor'),
(3, 'Carlos', 'López', '3103456789', '1000000003', 'Instructor'),
(4, 'Ana', 'Rodríguez', '3104567890', '1000000004', 'Instructor'),
(5, 'Luis', 'Martínez', '3105678901', '1000000005', 'Funcionario'),
(6, 'Sofía', 'Hernández', '3106789012', '1000000006', 'Funcionario'),
(7, 'Pedro', 'Sánchez', '3107890123', '1000000007', 'Funcionario'),
(8, 'Laura', 'Díaz', '3108901234', '1000000008', 'Funcionario'),
(9, 'Roberto', 'García', '3109012345', '1000000009', 'Directivo'),
(10, 'Carmen', 'Fernández', '3100123456', '1000000010', 'Directivo'),
(11, 'Jorge', 'Ramírez', '3101234567', '1000000011', 'Directivo'),
(12, 'Patricia', 'Morales', '3102345678', '1000000012', 'Directivo'),
(13, 'Miguel', 'Torres', '3103456789', '1000000013', 'Apoyo'),
(14, 'Elena', 'Vargas', '3104567890', '1000000014', 'Apoyo'),
(15, 'Ricardo', 'Castro', '3105678901', '1000000015', 'Apoyo'),
(16, 'Isabel', 'Rojas', '3106789012', '1000000016', 'Apoyo'),
(17, 'Fernando', 'Silva', '3107890123', '1000000017', 'Visitante'),
(18, 'Diana', 'Mendoza', '3108901234', '1000000018', 'Visitante'),
(19, 'Oscar', 'Guerrero', '3109012345', '1000000019', 'Visitante'),
(20, 'Lucía', 'Paredes', '3100123456', '1000000020', 'Visitante'),
(25, 'Helbert Dubler', 'Morera Hernández', '3105738706', '1072745267', 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_autenticados`
--

CREATE TABLE `usuarios_autenticados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_autenticados`
--

INSERT INTO `usuarios_autenticados` (`id`, `usuario_id`, `correo`, `foto_perfil`, `contrasena`) VALUES
(1, 25, 'morerahelbert9@gmail.com', 'assets/img/perfiles/default.png', '$2y$10$.UZpaUk0XhOeTekH3dbga.ijMnn2tUFVcN1mZFP0PUsOxK1CfGKlG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitantes`
--

CREATE TABLE `visitantes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `asunto` varchar(260) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `visitantes`
--

INSERT INTO `visitantes` (`id`, `usuario_id`, `asunto`) VALUES
(1, 17, 'Reunión de negocios'),
(2, 18, 'Entrevista de trabajo'),
(3, 19, 'Visita técnica'),
(4, 20, 'Capacitación');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apoyo`
--
ALTER TABLE `apoyo`
  ADD PRIMARY KEY (`usuario_id`);

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
-- Indices de la tabla `directivos`
--
ALTER TABLE `directivos`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `idx_funcionarios_area` (`area`),
  ADD KEY `idx_funcionarios_puesto` (`puesto`);

--
-- Indices de la tabla `guardas`
--
ALTER TABLE `guardas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `instructores`
--
ALTER TABLE `instructores`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `registro_acceso`
--
ALTER TABLE `registro_acceso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asignacion_id` (`asignacion_id`),
  ADD KEY `idx_fecha_tipo_usuario` (`fecha`,`tipo_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_identidad` (`numero_identidad`),
  ADD KEY `idx_numero_identidad` (`numero_identidad`);

--
-- Indices de la tabla `usuarios_autenticados`
--
ALTER TABLE `usuarios_autenticados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaciones_computadores`
--
ALTER TABLE `asignaciones_computadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `computadores`
--
ALTER TABLE `computadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `guardas`
--
ALTER TABLE `guardas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `registro_acceso`
--
ALTER TABLE `registro_acceso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuarios_autenticados`
--
ALTER TABLE `usuarios_autenticados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `apoyo`
--
ALTER TABLE `apoyo`
  ADD CONSTRAINT `apoyo_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignaciones_computadores`
--
ALTER TABLE `asignaciones_computadores`
  ADD CONSTRAINT `asignaciones_computadores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignaciones_computadores_ibfk_2` FOREIGN KEY (`computador_id`) REFERENCES `computadores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `directivos`
--
ALTER TABLE `directivos`
  ADD CONSTRAINT `directivos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `guardas`
--
ALTER TABLE `guardas`
  ADD CONSTRAINT `guardas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `instructores`
--
ALTER TABLE `instructores`
  ADD CONSTRAINT `instructores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_acceso`
--
ALTER TABLE `registro_acceso`
  ADD CONSTRAINT `registro_acceso_ibfk_1` FOREIGN KEY (`asignacion_id`) REFERENCES `asignaciones_computadores` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuarios_autenticados`
--
ALTER TABLE `usuarios_autenticados`
  ADD CONSTRAINT `usuarios_autenticados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD CONSTRAINT `visitantes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
