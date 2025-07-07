-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-07-2025 a las 17:16:59
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
-- Base de datos: `mantenimiento_ascardiodb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivos`
--

CREATE TABLE `dispositivos` (
  `id` int(11) NOT NULL,
  `codigo_dispositivo` varchar(20) NOT NULL,
  `tipo_dispositivo` varchar(50) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `numero_identificador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dispositivos`
--

INSERT INTO `dispositivos` (`id`, `codigo_dispositivo`, `tipo_dispositivo`, `ubicacion`, `numero_identificador`) VALUES
(21, 'ADMIMP-1', 'Impresora', 'Administración', 1),
(22, 'LABMON-12', 'Monitor', 'Laboratorio', 12),
(23, 'ALMUPS-8', 'UPS / Batería de Respaldo', 'Almacén', 8),
(24, 'MATHOS-9', 'Host/Máquina Virtual', 'Maternidad', 9),
(25, 'LABSER-9', 'Servidor', 'Laboratorio', 9),
(26, 'PEDIMP-3', 'Impresora', 'Pediatría', 3),
(27, 'QUIMON-8', 'Monitor', 'Quirófano', 8),
(28, 'MATIMP-3', 'Impresora', 'Maternidad', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fallos`
--

CREATE TABLE `fallos` (
  `id` int(11) NOT NULL,
  `id_usuario_reporta` int(11) NOT NULL,
  `id_admin_toma` int(11) DEFAULT NULL,
  `codigo_dispositivo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` enum('pendiente','tomado','atendido','resuelto','persistente','por_confirmacion') NOT NULL DEFAULT 'pendiente',
  `fecha_reporte` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_tomado` datetime DEFAULT NULL,
  `fecha_atendido` datetime DEFAULT NULL,
  `fecha_resuelto` datetime DEFAULT NULL,
  `nivel_urgencia` enum('alto','medio','bajo') NOT NULL DEFAULT 'bajo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fallos`
--

INSERT INTO `fallos` (`id`, `id_usuario_reporta`, `id_admin_toma`, `codigo_dispositivo`, `descripcion`, `estado`, `fecha_reporte`, `fecha_tomado`, `fecha_atendido`, `fecha_resuelto`, `nivel_urgencia`) VALUES
(16, 24, 13, 'LABMON-12', 'No enciende', 'resuelto', '2025-07-01 18:16:26', '2025-07-01 18:49:30', '2025-07-06 18:29:10', '2025-07-06 18:29:36', 'bajo'),
(17, 24, 13, 'ADMIMP-1', 'cartucho dañado', 'resuelto', '2025-07-01 18:17:20', '2025-07-06 18:29:14', '2025-07-06 18:29:59', '2025-07-06 18:30:46', 'alto'),
(18, 24, 13, 'LABSER-9', 'Esta caido', 'resuelto', '2025-07-06 18:33:43', '2025-07-06 18:35:09', '2025-07-06 18:36:46', '2025-07-06 19:08:24', 'medio'),
(19, 24, 13, 'LABSER-9', 'esta caido', 'persistente', '2025-07-06 19:08:36', '2025-07-06 19:08:57', '2025-07-07 10:16:07', NULL, 'alto'),
(20, 20, 23, 'ALMUPS-8', 'se acabo la bateria', 'tomado', '2025-07-07 10:37:12', '2025-07-07 10:37:32', NULL, NULL, 'medio'),
(21, 24, 13, 'PEDIMP-3', 'cartuchos quemados', 'por_confirmacion', '2025-07-07 10:38:26', '2025-07-07 10:43:17', '2025-07-07 10:43:19', NULL, 'alto'),
(22, 25, 13, 'LABSER-9', 'sigue caido', 'tomado', '2025-07-07 10:40:13', '2025-07-07 10:40:56', NULL, NULL, 'alto'),
(23, 25, NULL, 'ADMIMP-1', 'cartucho dañado', 'pendiente', '2025-07-07 10:42:30', NULL, NULL, NULL, 'medio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `id` int(11) NOT NULL,
  `codigo_dispositivo` varchar(20) NOT NULL,
  `fecha_ultimo_mantenimiento` date NOT NULL,
  `fecha_proximo_mantenimiento` date NOT NULL,
  `descripcion_proximo_mantenimiento` text DEFAULT NULL,
  `persona_asignada` int(11) DEFAULT NULL,
  `fecha_realizado` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimiento`
--

INSERT INTO `mantenimiento` (`id`, `codigo_dispositivo`, `fecha_ultimo_mantenimiento`, `fecha_proximo_mantenimiento`, `descripcion_proximo_mantenimiento`, `persona_asignada`, `fecha_realizado`) VALUES
(18, 'LABMON-12', '2025-06-10', '2025-07-10', 'limpieza', NULL, NULL),
(19, 'LABMON-12', '2025-04-03', '2025-08-02', 'necesita checkeo y limpieza', NULL, NULL),
(20, 'ALMUPS-8', '2025-03-06', '2025-07-02', 'revision del proceso de control', 13, '2025-07-07'),
(21, 'ALMUPS-8', '2025-05-01', '2025-07-07', 'revision y cambio de baterias', NULL, NULL),
(22, 'MATIMP-3', '2025-07-04', '2025-07-07', 'cambio de cartuchos', 13, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('administrador','usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `usuario`, `contrasena`, `rol`) VALUES
(13, 'karla', 'Talavera', 'eskarlatax', '$2y$10$DTHXhk9tSzBYt80DAfVR0.W/4Luw2xNL97FI3.28P9PYhYIw4PdIO', 'administrador'),
(20, 'Mengano', 'Perez', 'fulano', '$2y$10$eDdyvjhU7sfGTxy9sfab5.4EgpWWdlkA4mnRuZ0C4trN7SnpyqJsC', 'usuario'),
(23, 'Keyler', 'Carrillo', 'keylex', '$2y$10$vxOxRq9Jmg8xtJbttcpi7ePHufS7nEr3Cig/Lc/XtdQse/9ECp.eW', 'administrador'),
(24, 'laurys', 'Rivero', 'laurys', '$2y$10$ubSMs4XbEMpMjFqnRJaaLum8ftQ/FUI9r0UqiuBxV/hNPs/DRurea', 'usuario'),
(25, 'Humberto', 'Casique', 'humbe', '$2y$10$7hJIEZCogfV93dPPHYXYLeYNIWbENZLGPlbbKj1ai7jpPm2epk.Ge', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_dispositivo` (`codigo_dispositivo`);

--
-- Indices de la tabla `fallos`
--
ALTER TABLE `fallos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fallos_ibfk_1` (`id_usuario_reporta`),
  ADD KEY `fallos_ibfk_2` (`id_admin_toma`),
  ADD KEY `fallos_ibfk_3` (`codigo_dispositivo`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mantenimiento-res` (`codigo_dispositivo`),
  ADD KEY `persona-asignada` (`persona_asignada`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `fallos`
--
ALTER TABLE `fallos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fallos`
--
ALTER TABLE `fallos`
  ADD CONSTRAINT `fallos_ibfk_1` FOREIGN KEY (`id_usuario_reporta`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fallos_ibfk_2` FOREIGN KEY (`id_admin_toma`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fallos_ibfk_3` FOREIGN KEY (`codigo_dispositivo`) REFERENCES `dispositivos` (`codigo_dispositivo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD CONSTRAINT `mantenimiento-res` FOREIGN KEY (`codigo_dispositivo`) REFERENCES `dispositivos` (`codigo_dispositivo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `persona-asignada` FOREIGN KEY (`persona_asignada`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
