-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-03-2025 a las 17:13:37
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
-- Base de datos: `control_acceso`
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
(16, 'Logísticas');

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
(111, 2, NULL),
(1, 2, 1),
(104, 3, NULL),
(2, 3, 2),
(3, 4, 3),
(112, 5, NULL),
(4, 5, 4),
(6, 7, 6),
(7, 8, 7),
(8, 9, 8),
(109, 10, NULL),
(9, 10, 9),
(11, 12, 11),
(12, 13, 12),
(13, 14, 13),
(15, 16, 15),
(16, 17, 16),
(108, 19, NULL),
(18, 19, 18),
(19, 20, 19),
(85, 25, 71),
(86, 25, 72),
(107, 26, NULL),
(105, 32, NULL),
(106, 34, NULL),
(101, 34, 74),
(103, 34, 76),
(110, 35, 77);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `computadores`
--

CREATE TABLE `computadores` (
  `id` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `tipo_computador` enum('Sena','Personal') DEFAULT NULL,
  `mouse` enum('Si','No') NOT NULL,
  `teclado` enum('Si','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `computadores`
--

INSERT INTO `computadores` (`id`, `marca`, `codigo`, `tipo_computador`, `mouse`, `teclado`) VALUES
(1, 'Dell', 'DELL001', 'Sena', 'Si', 'Si'),
(2, 'HP', 'HP001', 'Personal', 'Si', 'Si'),
(3, 'Lenovo', 'LEN001', 'Sena', 'Si', 'Si'),
(4, 'Apple', 'MAC001', 'Personal', 'Si', 'Si'),
(5, 'Asus', 'ASUS001', 'Sena', 'Si', 'Si'),
(6, 'Acer', 'ACER001', 'Personal', 'Si', 'Si'),
(7, 'Dell', 'DELL002', 'Sena', 'Si', 'Si'),
(8, 'HP', 'HP002', 'Personal', 'Si', 'Si'),
(9, 'Lenovo', 'LEN002', 'Sena', 'Si', 'Si'),
(10, 'Apple', 'MAC002', 'Personal', 'Si', 'Si'),
(11, 'Asus', 'ASUS002', 'Sena', 'Si', 'Si'),
(12, 'Acer', 'ACER002', 'Personal', 'Si', 'Si'),
(13, 'Dell', 'DELL003', 'Sena', 'Si', 'Si'),
(14, 'HP', 'HP003', 'Personal', 'Si', 'Si'),
(15, 'Lenovo', 'LEN003', 'Sena', 'Si', 'Si'),
(16, 'Apple', 'MAC003', 'Personal', 'Si', 'Si'),
(17, 'Asus', 'ASUS003', 'Sena', 'Si', 'Si'),
(18, 'Acer', 'ACER003', 'Personal', 'Si', 'Si'),
(19, 'Dell', 'DELL004', 'Sena', 'Si', 'Si'),
(20, 'HP', 'HP004', 'Personal', 'Si', 'Si'),
(21, 'Lenovo', 'LEN004', 'Sena', 'Si', 'Si'),
(22, 'Apple', 'MAC004', 'Personal', 'Si', 'Si'),
(23, 'Asus', 'ASUS004', 'Sena', 'Si', 'Si'),
(24, 'Acer', 'ACER004', 'Personal', 'Si', 'Si'),
(25, 'Dell', 'DELL005', 'Sena', 'Si', 'Si'),
(26, 'HP', 'HP005', 'Personal', 'Si', 'Si'),
(27, 'Lenovo', 'LEN005', 'Sena', 'Si', 'Si'),
(28, 'Apple', 'MAC005', 'Personal', 'Si', 'Si'),
(29, 'Asus', 'ASUS005', 'Sena', 'Si', 'Si'),
(30, 'Acer', 'ACER005', 'Personal', 'Si', 'Si'),
(31, 'Dell', 'DELL006', 'Sena', 'Si', 'Si'),
(32, 'HP', 'HP006', 'Personal', 'Si', 'Si'),
(71, 'dsgdf', 'ewferew', 'Sena', 'Si', 'No'),
(72, 'grrgr', 'efqeeqs', 'Sena', 'No', 'Si'),
(73, 'ewfewwd', 'ewfewfewfwe', 'Personal', 'No', 'Si'),
(74, 'asfasfsa', 'fasfagded', 'Personal', 'Si', 'No'),
(75, 'ewgwegew', 'fewd', 'Personal', 'Si', 'No'),
(76, 'egergref', '1312wqed', 'Sena', 'Si', 'No'),
(77, 'wqdqw', 'efdcs', 'Personal', 'No', 'No');

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
(2, 'Director', 'Administracions'),
(8, 'Asistente', 'Finanzas'),
(9, 'SudAlterno', 'Administración'),
(10, 'Director', 'Recursos Humana'),
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
(7, 'Tecnología', 'Desarrollador');

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
(3, 'Redes', 'Aula 104'),
(4, 'Base de Dato', 'Aula 142'),
(19, 'ADSI', '4000'),
(26, 'ADSO', 'Aula 206');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `asignacion_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora_entrada` time NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `estado` enum('Activo','Finalizado') NOT NULL DEFAULT 'Activo',
  `tipo_usuario` enum('Personal','Visitante') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`id`, `asignacion_id`, `fecha`, `hora_entrada`, `hora_salida`, `estado`, `tipo_usuario`) VALUES
(120, 111, '2025-03-22', '18:45:47', '19:30:00', 'Activo', 'Personal'),
(121, 104, '2025-03-21', '18:45:54', NULL, 'Activo', 'Personal'),
(122, 112, '2025-02-13', '18:46:00', '19:35:11', 'Activo', 'Personal'),
(123, 106, '2025-03-22', '18:46:07', NULL, 'Activo', 'Visitante'),
(124, 104, '2025-03-24', '11:03:52', NULL, 'Activo', 'Personal');

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
(2, 'Andres', 'Morera Hernández', '2412432532245', '1000000002', 'Directivo'),
(3, 'Carlos Andres', 'López', '3103456789', '1000000032', 'Instructor'),
(4, 'Ana', 'Rodríguez', '3104567890', '1000000036', 'Instructor'),
(5, 'Luis', 'Martínez', '3105678901', '1000000005', 'Funcionario'),
(7, 'Pedro', 'Sánchez', '3107890123', '1000000007', 'Funcionario'),
(8, 'Laura', 'Díaz', '3108901234', '1000000001', 'Directivo'),
(9, 'Roberto', 'García', '3109012345', '1000000009', 'Directivo'),
(10, 'Carmen', 'Fernández', '3100123456', '1000000010', 'Directivo'),
(12, 'Patricia', 'Morales', '3102345678', '1000000012', 'Directivo'),
(13, 'Miguel', 'Torres', '3103456789', '1000000013', 'Apoyo'),
(14, 'Elena', 'Vargas', '3104567890', '1000000014', 'Apoyo'),
(16, 'Isabel', 'Rojas', '3106789012', '1000000016', 'Apoyo'),
(17, 'Fernando', 'Silva', '3107890123', '1000000017', 'Visitante'),
(19, 'Oscar', 'Guerrero', '3109012321', '1000000019', 'Instructor'),
(20, 'Lucía', 'Paredes', '3100123456', '1000000020', 'Visitante'),
(25, 'Helbert Dubler', 'Morera Hernández', '3105738706', '1072745267', 'Admin'),
(26, 'Felipe', 'Restrepo', '3212439492', '1234567899', 'Instructor'),
(30, 'Andres', 'Morera Hernández', '2412432532245', '1072745263', 'Guarda'),
(31, 'ewgweff', 'fewgfewgfw', '414325325234', '323432431', 'Guarda'),
(32, 'Nike Air Max 270sfas', 'fewfew', '214124133', '341234214131', 'Visitante'),
(34, 'Andressfsafas', 'gsdgsfd', '412252314', '21523533', 'Visitante'),
(35, 'Fernandos', 'qegwgwwa', '3105748723', '192301902', 'Visitante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_autenticados`
--

CREATE TABLE `usuarios_autenticados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_autenticados`
--

INSERT INTO `usuarios_autenticados` (`id`, `usuario_id`, `correo`, `foto_perfil`, `contrasena`, `reset_token`, `reset_token_expiry`) VALUES
(1, 25, 'morerahelbert9@gmail.com', 'assets/img/perfiles/default.webp', '$2y$10$vhq6XFdiAFCNqhaCfmNvquRA75CXBIbaEuzUsVoF6WzgAdAbGxI0.', NULL, NULL),
(2, 30, 'kindred@gmail.com', 'assets/img/perfiles/default.webp', '$2y$10$L.qBUpLE8.URQa0NEy70d.CiFuumkxxUXYzIyQgIWNlD2F9zB1afO', NULL, NULL),
(3, 31, 'mkwfow@gmail.com', 'assets/img/perfiles/default.png', '$2y$10$0YVdOJAExEn6frI2AQ3hhuN/xj0jZrOFqd21NzcprdxZoG5psOJTi', NULL, NULL);

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
(12, 20, 'Prueba'),
(13, 32, 'ewfewd'),
(15, 34, 'dawsasfs'),
(16, 35, 'wqdw');

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
-- Indices de la tabla `instructores`
--
ALTER TABLE `instructores`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `computadores`
--
ALTER TABLE `computadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `usuarios_autenticados`
--
ALTER TABLE `usuarios_autenticados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
-- Filtros para la tabla `instructores`
--
ALTER TABLE `instructores`
  ADD CONSTRAINT `instructores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`asignacion_id`) REFERENCES `asignaciones_computadores` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuarios_autenticados`
--
ALTER TABLE `usuarios_autenticados`
  ADD CONSTRAINT `usuarios_autenticados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD CONSTRAINT `visitantes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
