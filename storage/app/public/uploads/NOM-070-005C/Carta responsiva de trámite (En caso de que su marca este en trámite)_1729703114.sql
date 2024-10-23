-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2024 a las 23:21:43
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
-- Estructura de tabla para la tabla `lotes_envasado`
--

CREATE TABLE `lotes_envasado` (
  `id_lote_envasado` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL COMMENT 'Relación con empresas',
  `nombre_lote` varchar(100) NOT NULL,
  `tipo_lote` varchar(45) NOT NULL COMMENT '1. Por un solo lote a granel 2. Por más de un lote a granel',
  `sku` varchar(60) NOT NULL,
  `id_marca` int(11) NOT NULL COMMENT 'Relación con id_marca de la tabla marcas',
  `destino_lote` varchar(120) NOT NULL,
  `cant_botellas` int(11) NOT NULL,
  `presentacion` int(11) NOT NULL,
  `unidad` varchar(50) NOT NULL COMMENT 'Litros, mililitros o centilitros',
  `volumen_total` double NOT NULL,
  `lugar_envasado` int(11) DEFAULT NULL COMMENT 'Relación con id_intalacion',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lotes_envasado`
--

INSERT INTO `lotes_envasado` (`id_lote_envasado`, `id_empresa`, `nombre_lote`, `tipo_lote`, `sku`, `id_marca`, `destino_lote`, `cant_botellas`, `presentacion`, `unidad`, `volumen_total`, `lugar_envasado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Crista la Santa S.A.P.I. de C.V.', 'Por más de un lote a granel', '567', 8, 'Venta nacional', 68, 600, 'Mililitros', 40.8, 2, '2024-10-16 19:43:24', '2024-10-16 21:14:35'),
(2, 1, 'qwe', 'Por más de un lote a granel', '234', 8, 'Mexico', 45, 45, 'Mililitros', 2.02, 1, '2024-10-16 19:44:50', '2024-10-16 19:44:50'),
(3, 1, 'qwd', 'Por un solo lote a granel', 'eqw', 8, '2', 12, 12, 'Litros', 144, 1, '2024-10-16 20:02:12', '2024-10-16 20:02:12'),
(4, 1, 'c', 'Por más de un lote a granel', 'sda', 8, 'Mexico', 78, 700, 'Centrilitros', 546, 1, '2024-10-16 21:16:45', '2024-10-16 21:16:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lotes_envasado`
--
ALTER TABLE `lotes_envasado`
  ADD PRIMARY KEY (`id_lote_envasado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lotes_envasado`
--
ALTER TABLE `lotes_envasado`
  MODIFY `id_lote_envasado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
