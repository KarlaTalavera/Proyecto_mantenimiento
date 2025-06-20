-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2025 a las 00:11:13
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
-- Estructura de tabla para la tabla `usuarios`
--

--la base de datos se llama mantenimiento_ascardiodb oiste negro malparido

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL UNIQUE,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('administrador','usuario') NOT NULL DEFAULT 'usuario'
) 

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `usuario`, `contrasena`, `rol`) VALUES
(1, 'karla', 'Talavera', 'maria', '$2y$10$XLGFvwPnr8gfQatv0Dm5Xe3lx/DRERAFmRR8RLql34c13keo1ASbi', 'administrador'),
(12, 'mayuya', 'peralta', 'mayuyito', '$2y$10$pSjPVKY1AFgeCa2XuP9UNuwShJPrx5UhWCvq0b5cmJ/dknfXpz7pS', 'administrador');

