-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 18:05:03
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
-- Base de datos: `oc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `folio` char(1) NOT NULL,
  `marca` varchar(60) NOT NULL,
  `id_empresa` int(11) NOT NULL COMMENT 'Relación con la tabla empresa',
  `id_norma` int(11) NOT NULL,
  `etiquetado` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `folio`, `marca`, `id_empresa`, `id_norma`, `etiquetado`, `created_at`, `updated_at`) VALUES
(1, 'C', 'PROMESAS', 1, 0, '', '2024-08-26 22:38:24', '2024-10-16 18:06:53'),
(2, 'A', '400 Conejos', 3, 0, '', '2024-08-26 22:38:35', '2024-08-26 22:38:35'),
(3, 'C', 'Creyente', 3, 0, '', '2024-08-26 22:38:46', '2024-08-29 04:56:31'),
(8, 'E', 'CREYENTE', 1, 0, '', '2024-09-05 01:52:04', '2024-09-05 01:52:04'),
(14, 'I', 'qw', 1, 3, '{\"sku\":[\"12\"],\"id_tipo\":[\"1\"],\"presentacion\":[\"12\"],\"clase\":[\"Blanco o Joven\"],\"categoria\":[\"Receptora\"]}', '2024-10-22 19:58:45', '2024-10-23 05:17:44');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
