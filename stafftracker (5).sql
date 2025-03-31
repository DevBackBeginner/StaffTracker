-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-03-2025 a las 03:31:50
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
-- Base de datos: `stafftracker`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `computadores`
--

CREATE TABLE `computadores` (
  `id_computador` int(10) UNSIGNED NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `teclado` enum('Si','No') NOT NULL DEFAULT 'Si',
  `mouse` enum('Si','No') NOT NULL DEFAULT 'Si',
  `asignado_a` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `computadores`
--

INSERT INTO `computadores` (`id_computador`, `modelo`, `codigo`, `teclado`, `mouse`, `asignado_a`) VALUES
(21, 'dx', 'wqe', 'No', 'Si', 29),
(22, 'fef', 'safas', 'Si', 'No', 30),
(24, 'Nicosf', '1074fd', 'No', 'Si', 33),
(25, 'DFDS', 'G3W', 'Si', 'No', 34),
(26, 'wefew', '31232', 'No', 'Si', 35),
(27, 'gewgew', 'gwe', 'Si', 'Si', 36),
(28, 'ewfefwe', 'cdcd', 'No', 'Si', 37),
(29, 'scs', 'eweqws21', 'Si', 'Si', 39);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `computadores_sena`
--

CREATE TABLE `computadores_sena` (
  `id_computador_sena` int(10) UNSIGNED NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `teclado` enum('Si','No') NOT NULL DEFAULT 'Si',
  `mouse` enum('Si','No') NOT NULL DEFAULT 'Si',
  `estado` enum('Disponible','Asignado') NOT NULL DEFAULT 'Disponible',
  `asignado_a` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `computadores_sena`
--

INSERT INTO `computadores_sena` (`id_computador_sena`, `modelo`, `codigo`, `teclado`, `mouse`, `estado`, `asignado_a`) VALUES
(2, 'Lenovo ThinkPad', 'SNLEN001', 'Si', 'Si', 'Asignado', NULL),
(4, 'Asus', 'Pruebas3', 'Si', 'No', 'Asignado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_laboral`
--

CREATE TABLE `informacion_laboral` (
  `id` int(10) UNSIGNED NOT NULL,
  `persona_id` int(10) UNSIGNED NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `tipo_contrato` enum('Planta','Contratista') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `informacion_laboral`
--

INSERT INTO `informacion_laboral` (`id`, `persona_id`, `cargo`, `tipo_contrato`) VALUES
(3, 33, 'Limpieza', 'Planta'),
(4, 34, 'Administradords', 'Contratista'),
(5, 35, 'f3e', 'Planta'),
(6, 36, '2r23efe', 'Contratista'),
(7, 37, 'dfss', 'Contratista'),
(8, 39, '4f4e', 'Contratista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_administrativo`
--

CREATE TABLE `personal_administrativo` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `correo` varchar(100) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_administrativo`
--

INSERT INTO `personal_administrativo` (`id`, `usuario_id`, `correo`, `foto_perfil`, `contrasena`, `reset_token`, `reset_token_expiry`) VALUES
(2, 6, 'morerahelbert9@gmail.com', 'assets/img/perfiles/default.webp', '$2y$10$r/569KvLwZY7NVUXLmw6fuCVvWIMrC/lnNjWxYVzmgH2g4MoxtOKa', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `tipo_documento` enum('CC','CE','TI','PASAPORTE','NIT') NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `telefono` varchar(15) DEFAULT '',
  `rol` enum('Administrador','Guarda','Instructor','Visitante','Funcionario','Directivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `nombre`, `apellido`, `tipo_documento`, `numero_documento`, `telefono`, `rol`) VALUES
(6, 'Helbert Dubler', 'Morera Hernández', 'CC', '1072745267', '3105738706', 'Guarda'),
(29, 'wx', 'sx', 'CC', '12345670', '2312', 'Instructor'),
(30, 'ewfe', 'dvsf', 'TI', '41243', '3232', 'Visitante'),
(33, 'sdgdfsdcsx', 'fwefed', 'PASAPORTE', '43352', '434', 'Instructor'),
(34, 'rgefr', 'ege', 'CC', '35234221', '34232', 'Directivo'),
(35, 'fewd', 'fwfe', 'CC', '1242142', '23123', 'Instructor'),
(36, 'few', 'dsfsd', 'CE', '1232', '31241', 'Funcionario'),
(37, 'fwfewf', 'wfdx', 'CE', '3221', '23124', 'Funcionario'),
(39, 'weefee', 'wedcxwx', 'CE', '41353', '2112411', 'Directivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_ingreso_salida`
--

CREATE TABLE `registro_ingreso_salida` (
  `id_registro` int(10) UNSIGNED NOT NULL,
  `id_persona` int(10) UNSIGNED NOT NULL,
  `id_validacion_equipo` int(10) UNSIGNED DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora_ingreso` time NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `estado_presencia` enum('En la sede','Fuera de la sede') NOT NULL DEFAULT 'En la sede'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `registro_ingreso_salida`
--

INSERT INTO `registro_ingreso_salida` (`id_registro`, `id_persona`, `id_validacion_equipo`, `fecha`, `hora_ingreso`, `hora_salida`, `estado_presencia`) VALUES
(35, 29, 25, '2025-03-30', '11:49:13', NULL, 'En la sede'),
(36, 30, 26, '2025-03-30', '11:49:32', NULL, 'En la sede');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `validacion_equipos`
--

CREATE TABLE `validacion_equipos` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_equipo` int(10) UNSIGNED NOT NULL,
  `tipo_equipo` enum('computador_personal','computador_sena') NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `validacion_equipos`
--

INSERT INTO `validacion_equipos` (`id`, `id_equipo`, `tipo_equipo`, `fecha_registro`) VALUES
(25, 21, 'computador_personal', '2025-03-30 16:49:13'),
(26, 22, 'computador_personal', '2025-03-30 16:49:32'),
(28, 24, 'computador_personal', '2025-03-30 18:59:50'),
(29, 25, 'computador_personal', '2025-03-30 20:05:14'),
(30, 26, 'computador_personal', '2025-03-30 22:47:26'),
(31, 27, 'computador_personal', '2025-03-30 22:51:28'),
(32, 28, 'computador_personal', '2025-03-30 23:00:04'),
(33, 29, 'computador_personal', '2025-03-30 23:18:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitantes`
--

CREATE TABLE `visitantes` (
  `id_visitante` int(10) UNSIGNED NOT NULL,
  `id_persona` int(10) UNSIGNED NOT NULL,
  `asunto_visita` varchar(100) NOT NULL,
  `fecha_visita` date NOT NULL,
  `registrado_por` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `visitantes`
--

INSERT INTO `visitantes` (`id_visitante`, `id_persona`, `asunto_visita`, `fecha_visita`, `registrado_por`) VALUES
(22, 29, 'fd', '2025-03-30', 6),
(23, 30, 'Pruebas', '2025-03-30', 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `computadores`
--
ALTER TABLE `computadores`
  ADD PRIMARY KEY (`id_computador`),
  ADD KEY `asignado_a` (`asignado_a`);

--
-- Indices de la tabla `computadores_sena`
--
ALTER TABLE `computadores_sena`
  ADD PRIMARY KEY (`id_computador_sena`),
  ADD KEY `asignado_a` (`asignado_a`);

--
-- Indices de la tabla `informacion_laboral`
--
ALTER TABLE `informacion_laboral`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_id` (`persona_id`);

--
-- Indices de la tabla `personal_administrativo`
--
ALTER TABLE `personal_administrativo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`);

--
-- Indices de la tabla `registro_ingreso_salida`
--
ALTER TABLE `registro_ingreso_salida`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_validacion_equipo` (`id_validacion_equipo`);

--
-- Indices de la tabla `validacion_equipos`
--
ALTER TABLE `validacion_equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_equipo` (`id_equipo`,`tipo_equipo`);

--
-- Indices de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD PRIMARY KEY (`id_visitante`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `registrado_por` (`registrado_por`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `computadores`
--
ALTER TABLE `computadores`
  MODIFY `id_computador` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `computadores_sena`
--
ALTER TABLE `computadores_sena`
  MODIFY `id_computador_sena` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `informacion_laboral`
--
ALTER TABLE `informacion_laboral`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `personal_administrativo`
--
ALTER TABLE `personal_administrativo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `registro_ingreso_salida`
--
ALTER TABLE `registro_ingreso_salida`
  MODIFY `id_registro` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `validacion_equipos`
--
ALTER TABLE `validacion_equipos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `id_visitante` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `computadores`
--
ALTER TABLE `computadores`
  ADD CONSTRAINT `computadores_ibfk_1` FOREIGN KEY (`asignado_a`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `computadores_sena`
--
ALTER TABLE `computadores_sena`
  ADD CONSTRAINT `computadores_sena_ibfk_1` FOREIGN KEY (`asignado_a`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `informacion_laboral`
--
ALTER TABLE `informacion_laboral`
  ADD CONSTRAINT `informacion_laboral_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `personal_administrativo`
--
ALTER TABLE `personal_administrativo`
  ADD CONSTRAINT `personal_administrativo_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_ingreso_salida`
--
ALTER TABLE `registro_ingreso_salida`
  ADD CONSTRAINT `registro_ingreso_salida_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `registro_ingreso_salida_ibfk_2` FOREIGN KEY (`id_validacion_equipo`) REFERENCES `validacion_equipos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD CONSTRAINT `visitantes_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE,
  ADD CONSTRAINT `visitantes_ibfk_2` FOREIGN KEY (`registrado_por`) REFERENCES `personas` (`id_persona`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
