-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-03-2025 a las 19:53:29
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
(112, 5, NULL),
(4, 5, 4),
(120, 7, NULL),
(6, 7, 6),
(7, 8, 7),
(8, 9, 8),
(109, 10, NULL),
(9, 10, 9),
(121, 12, NULL),
(11, 12, 11),
(12, 13, 12),
(13, 14, 13),
(122, 14, 78),
(15, 16, 15),
(16, 17, 16),
(108, 19, NULL),
(18, 19, 18),
(19, 20, 19),
(119, 25, NULL),
(85, 25, 71),
(86, 25, 72),
(125, 25, 81),
(107, 26, NULL),
(105, 32, NULL),
(124, 32, 80),
(127, 32, 83),
(118, 44, NULL),
(123, 46, 79),
(126, 47, 82),
(130, 55, 85);

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
(77, 'wqdqw', 'efdcs', 'Personal', 'No', 'No'),
(78, 'vdssvsvdsv', 'xvbff', 'Sena', 'Si', 'Si'),
(79, 'ñasñ', '33545', 'Sena', 'Si', 'No'),
(80, 'thntybrgvfcdsx', 'adfdfgdsf', 'Personal', 'Si', 'Si'),
(81, 'Asus', '424242', 'Sena', 'Si', 'No'),
(82, 'Nico', '1251151054', 'Personal', 'Si', 'Si'),
(83, 'Asus', '5662115', 'Sena', 'Si', 'Si'),
(84, 'gterfcsdx', 'ehthgd24', 'Personal', 'Si', 'Si'),
(85, 'fasdx', 'csdcdsxs', 'Personal', 'Si', 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_laboral`
--

CREATE TABLE `informacion_laboral` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `tipo_contrato` enum('Planta','Contratista') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `informacion_laboral`
--

INSERT INTO `informacion_laboral` (`id`, `usuario_id`, `cargo`, `tipo_contrato`) VALUES
(1, 55, 'Tecnico', 'Planta'),
(2, 14, 'hipno', 'Contratista'),
(3, 46, 'QJWJIDKL', 'Planta'),
(4, 51, 'Administrador', 'Contratista'),
(5, 2, 'dass', 'Contratista');

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
(134, 4, '2025-03-27', '10:07:02', '10:07:08', 'Finalizado', 'Personal'),
(135, 120, '2025-03-27', '10:07:42', '10:07:46', 'Finalizado', 'Personal'),
(136, 121, '2025-03-27', '10:08:51', '10:08:54', 'Finalizado', 'Personal'),
(137, 122, '2025-03-27', '10:12:03', '10:12:17', 'Finalizado', 'Personal'),
(138, 124, '2025-03-27', '15:19:04', NULL, 'Activo', 'Visitante'),
(139, 105, '2025-03-27', '15:25:17', NULL, 'Activo', 'Visitante'),
(140, 125, '2025-03-27', '16:03:01', '16:11:51', 'Finalizado', 'Personal'),
(141, 119, '2025-03-27', '16:27:49', '21:09:06', 'Finalizado', 'Personal'),
(142, 126, '2025-03-27', '17:16:14', '17:25:05', 'Finalizado', 'Visitante'),
(143, 127, '2025-03-27', '17:23:13', NULL, 'Activo', 'Visitante'),
(144, NULL, '2025-03-28', '10:20:24', NULL, 'Activo', 'Visitante'),
(145, NULL, '2025-03-28', '10:28:57', '10:38:12', 'Finalizado', 'Visitante');

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
  `rol` enum('Instructor','Funcionario','Directivo','Apoyo','Visitante','Admin','Guarda') DEFAULT NULL,
  `tipo_documento` enum('CC','CE','TI','PA','NIT','OTRO') NOT NULL DEFAULT 'CC' COMMENT 'CC=Cédula de Ciudadanía, CE=Cédula de Extranjería, TI=Tarjeta de Identidad, PA=Pasaporte, NIT=Número de Identificación Tributaria, OTRO=Otro tipo de documento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `telefono`, `numero_identidad`, `rol`, `tipo_documento`) VALUES
(2, 'Andres', 'Morera Hernández', '2412432532245', '1000000002', 'Apoyo', 'CC'),
(3, 'Carlos Andres', 'López', '3103456789', '1000000032', 'Instructor', 'CC'),
(5, 'Luis', 'Martínez', '3105678901', '1000000005', 'Funcionario', 'CC'),
(7, 'Pedro', 'Sánchez', '3107890123', '1000000007', 'Funcionario', 'CC'),
(8, 'Laura', 'Díaz', '3108901234', '1000000001', 'Directivo', 'CC'),
(9, 'Roberto', 'García', '3109012345', '1000000009', 'Funcionario', 'CC'),
(10, 'Carmen', 'Fernández', '3100123456', '1000000010', 'Directivo', 'CC'),
(12, 'Patricia', 'Morales', '3102345678', '1000000012', 'Directivo', 'CC'),
(13, 'Miguel', 'Torres', '3103456789', '1000000013', 'Apoyo', 'CC'),
(14, 'Elena', 'Vargas', '41242413123', '1000000014', 'Directivo', 'CC'),
(16, 'Isabel', 'Rojas', '3106789012', '1000000016', 'Apoyo', 'CC'),
(17, 'Fernando', 'Silva', '3107890123', '1000000017', 'Instructor', 'CC'),
(19, 'Oscar', 'Guerrero', '3109012321', '1000000019', 'Instructor', 'CC'),
(20, 'Lucía', 'Paredes', '3100123456', '1000000020', 'Visitante', 'CC'),
(25, 'Helbert Dubler', 'Morera Hernández', '3105738706', '1072745267', 'Admin', 'CC'),
(26, 'Felipe', 'Restrepo', '3212439492', '1234567899', 'Instructor', 'CC'),
(32, 'Nike Air Max 270sfas', 'fewfew', '214124133', '341234214131', 'Visitante', 'CC'),
(44, 'dgsdcs', 'vsdcsdf', '13435', '24124214', 'Instructor', 'CC'),
(45, 'juan', 'castillo', '320413137', '1007153188', 'Guarda', 'CC'),
(46, 'Ana', 'dapda', '212345', '313141412', 'Directivo', 'CC'),
(47, 'dubler', 'jcjxjjx', '321451234', '1201114121', 'Visitante', 'CC'),
(48, 'Helbert', 'Morera', '3105738706', '123456789', 'Guarda', 'CC'),
(51, 'Andressfsf', 'dgdsfds', '2412412', '2411253', 'Funcionario', 'CC'),
(55, 'fdsfsdff', 'dscsdcxscs', '3524352344', '3524352344', 'Apoyo', 'CE');

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
(1, 25, 'morerahelbert9@gmail.com', 'assets/img/perfiles/default.webp', '$2y$10$JYY2wragjqShLEhdmdNgtOfCUTF1F4ewzpNQtfNXnG8fVmSNhXh42', NULL, NULL),
(8, 45, 'juancho73x@gmail.com', 'assets/img/perfiles/default.webp', '$2y$10$wYqT3WgxN/Ff.o9jBzFdtOR/hsgqWIHBx6dnEuz6VSjrNgTB63up6', NULL, NULL),
(9, 48, 'helbertmorera05@gmail.com', 'assets/img/perfiles/default.webp', '$2y$10$tBModFRatPVWV/OlBUUlGOEZbCeAWtflkNfPPAcWgzhZYkehc9SZ.', NULL, NULL),
(12, 51, 'kindred@gmail.com', 'assets/img/perfiles/default.webp', '$2y$10$3d7L6uQ/GNgIyWWlfGcrne3Cm4caot9YsKtSXTZsG7hnM95mCCuOG', NULL, NULL);

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
(12, 20, 'Prueba'),
(13, 32, 'ewfewda'),
(20, 47, 'Reunión de negocioss');

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
-- Indices de la tabla `informacion_laboral`
--
ALTER TABLE `informacion_laboral`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT de la tabla `computadores`
--
ALTER TABLE `computadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `informacion_laboral`
--
ALTER TABLE `informacion_laboral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `usuarios_autenticados`
--
ALTER TABLE `usuarios_autenticados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
-- Filtros para la tabla `informacion_laboral`
--
ALTER TABLE `informacion_laboral`
  ADD CONSTRAINT `informacion_laboral_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

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
