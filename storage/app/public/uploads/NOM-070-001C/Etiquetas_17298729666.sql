-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2024 a las 21:32:59
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
-- Estructura de tabla para la tabla `guias`
--

CREATE TABLE `guias` (
  `id_guia` int(11) NOT NULL,
  `id_plantacion` int(11) NOT NULL,
  `run_folio` varchar(50) DEFAULT NULL,
  `folio` varchar(50) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_predio` int(11) NOT NULL,
  `numero_plantas` int(10) DEFAULT NULL,
  `numero_guias` int(11) DEFAULT NULL,
  `num_anterior` int(11) DEFAULT NULL,
  `num_comercializadas` int(11) DEFAULT NULL,
  `mermas_plantas` int(11) DEFAULT NULL,
  `edad` varchar(255) DEFAULT NULL,
  `art` float DEFAULT NULL,
  `kg_maguey` double DEFAULT NULL,
  `no_lote_pedido` varchar(255) DEFAULT NULL,
  `fecha_corte` date DEFAULT NULL,
  `observaciones` varchar(800) DEFAULT NULL,
  `nombre_cliente` varchar(100) DEFAULT NULL,
  `no_cliente` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `guias`
--

INSERT INTO `guias` (`id_guia`, `id_plantacion`, `run_folio`, `folio`, `id_empresa`, `id_predio`, `numero_plantas`, `numero_guias`, `num_anterior`, `num_comercializadas`, `mermas_plantas`, `edad`, `art`, `kg_maguey`, `no_lote_pedido`, `fecha_corte`, `observaciones`, `nombre_cliente`, `no_cliente`, `fecha_ingreso`, `domicilio`, `created_at`, `updated_at`) VALUES
(220, 3, 'SOL-GUIA-000001/24', 'Sin asignarG001', 1, 2, 6701, 1, 8000, 1249, 50, NULL, NULL, NULL, NULL, NULL, NULL, 'Jose Emmanuel Oliva Avellaneda', NULL, NULL, NULL, '2024-09-04 03:27:47', '2024-10-06 22:52:42'),
(221, 3, 'SOL-GUIA-000002/24', 'Sin asignarG002', 1, 2, 6367, 5, 7900, 300, 1233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-04 03:32:36', '2024-09-04 03:32:36'),
(222, 3, 'SOL-GUIA-000002/24', 'Sin asignarG003', 1, 2, 6367, 5, 7900, 300, 1233, '23 meses', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-04 03:32:36', '2024-09-18 16:23:39'),
(223, 3, 'SOL-GUIA-000002/24', 'Sin asignarG004', 1, 2, 6367, 5, 7900, 300, 1233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-04 03:32:36', '2024-09-04 03:32:36'),
(224, 3, 'SOL-GUIA-000002/24', 'Sin asignarG005', 1, 2, 6367, 5, 7900, 300, 1233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-04 03:32:36', '2024-09-04 03:32:36'),
(225, 3, 'SOL-GUIA-000002/24', 'Sin asignarG006', 1, 2, 5867, 5, 7900, 800, 1233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-04 03:32:36', '2024-09-04 03:32:53'),
(226, 3, 'SOL-GUIA-000003/24', 'Sin asignarG007', 1, 1, 6000, 2, 6367, 300, 67, '4 años', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-09 03:56:17', '2024-09-18 16:24:07'),
(227, 3, 'SOL-GUIA-000003/24', 'Sin asignarG008', 1, 2, 6000, 2, 6367, 300, 67, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-09 03:56:17', '2024-09-09 03:56:17'),
(228, 1, 'SOL-GUIA-000004/24', 'Sin asignarG003', 3, 1, 29876, 1, 30000, 1, 123, '3 años', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-18 16:31:48', '2024-09-18 16:32:40'),
(229, 3, 'SOL-GUIA-000005/24', 'Sin asignarG008', 1, 2, 5921, 2, 6000, 34, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-16 19:32:36', '2024-10-16 19:32:36'),
(230, 3, 'SOL-GUIA-000005/24', 'Sin asignarG009', 1, 2, 5921, 2, 6000, 34, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-16 19:32:36', '2024-10-16 19:32:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `guias`
--
ALTER TABLE `guias`
  ADD PRIMARY KEY (`id_guia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `guias`
--
ALTER TABLE `guias`
  MODIFY `id_guia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
