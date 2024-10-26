-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2024 a las 17:38:32
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
-- Estructura de tabla para la tabla `actas_equipo_envasado`
--

CREATE TABLE `actas_equipo_envasado` (
  `id_equipo_envasado` int(11) NOT NULL,
  `id_acta` int(11) DEFAULT NULL,
  `equipo_envasado` varchar(255) DEFAULT NULL,
  `cantidad_envasado` varchar(255) DEFAULT NULL,
  `capacidad_envasado` varchar(255) DEFAULT NULL,
  `tipo_material_envasado` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actas_equipo_envasado`
--

INSERT INTO `actas_equipo_envasado` (`id_equipo_envasado`, `id_acta`, `equipo_envasado`, `cantidad_envasado`, `capacidad_envasado`, `tipo_material_envasado`, `created_at`, `updated_at`) VALUES
(2, 2, 'lenovo', '12', '400 centilitros', 'Madera', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(5, 2, 'MEXICO', NULL, '4L', NULL, '2024-09-26 15:57:47', '2024-09-26 15:57:47'),
(6, 5, NULL, NULL, NULL, NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(7, 6, NULL, NULL, NULL, NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(8, 7, NULL, NULL, NULL, NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(9, 8, NULL, NULL, NULL, NULL, '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(10, 9, NULL, NULL, NULL, NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actas_equipo_mezcal`
--

CREATE TABLE `actas_equipo_mezcal` (
  `id_mezcal` int(11) NOT NULL,
  `id_acta` int(11) DEFAULT NULL,
  `equipo` varchar(255) DEFAULT NULL,
  `cantidad` varchar(255) DEFAULT NULL,
  `capacidad` varchar(255) DEFAULT NULL,
  `tipo_material` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actas_equipo_mezcal`
--

INSERT INTO `actas_equipo_mezcal` (`id_mezcal`, `id_acta`, `equipo`, `cantidad`, `capacidad`, `tipo_material`, `created_at`, `updated_at`) VALUES
(2, 2, 'chano', '12', '12', '12', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(5, 2, 'chelo2', '25', '1L', 'Metal', '2024-09-26 15:37:59', '2024-09-26 15:37:59'),
(6, 5, NULL, NULL, NULL, NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(7, 6, NULL, NULL, NULL, NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(8, 7, NULL, NULL, NULL, NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(9, 8, NULL, NULL, NULL, NULL, '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(10, 9, 'Horno', '1', '100', 'Metal', '2024-10-02 17:40:57', '2024-10-02 17:40:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actas_inspeccion`
--

CREATE TABLE `actas_inspeccion` (
  `id_acta` int(11) NOT NULL,
  `id_inspeccion` int(11) NOT NULL,
  `num_acta` varchar(50) NOT NULL,
  `categoria_acta` varchar(100) NOT NULL,
  `lugar_inspeccion` varchar(250) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `encargado` varchar(100) NOT NULL,
  `num_credencial_encargado` varchar(50) NOT NULL,
  `testigos` char(2) NOT NULL COMMENT 'Si o no',
  `fecha_fin` datetime NOT NULL,
  `no_conf_infraestructura` varchar(6000) NOT NULL,
  `no_conf_equipo` varchar(6000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actas_inspeccion`
--

INSERT INTO `actas_inspeccion` (`id_acta`, `id_inspeccion`, `num_acta`, `categoria_acta`, `lugar_inspeccion`, `fecha_inicio`, `id_empresa`, `encargado`, `num_credencial_encargado`, `testigos`, `fecha_fin`, `no_conf_infraestructura`, `no_conf_equipo`, `created_at`, `updated_at`) VALUES
(2, 4, '12', 'Productora', 'Albino Garcia 19 Jardines De Torremolinos 58197 Morelia, Morelia , Michoacan', '2024-09-24 16:08:00', 1, 'Jose Emmanuel Oliva', '12', '1', '2025-10-16 16:08:00', '12', '12', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(9, 4, 'Acta de productora 001', 'Productora', 'Albino Garcia 19 Jardines De Torremolinos 58197 Morelia, Morelia , Michoacan', '2024-10-02 11:00:00', 1, 'Encargado de instalaciones', '3837', '2', '2024-10-02 12:30:00', 'No tiene área de naguey bui de almacén de granaeles', 'Todo ok', '2024-10-02 17:40:57', '2024-10-02 17:40:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actas_produccion`
--

CREATE TABLE `actas_produccion` (
  `id_produccion` int(11) NOT NULL,
  `id_acta` int(11) DEFAULT NULL,
  `id_plantacion` int(11) DEFAULT NULL,
  `plagas` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actas_produccion`
--

INSERT INTO `actas_produccion` (`id_produccion`, `id_acta`, `id_plantacion`, `plagas`, `created_at`, `updated_at`) VALUES
(2, 2, 3, 'NO', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(8, 2, 3, 'SI', '2024-09-26 18:59:45', '2024-09-26 18:59:45'),
(9, 8, 3, NULL, '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(10, 9, NULL, NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actas_testigo`
--

CREATE TABLE `actas_testigo` (
  `id_acta_testigo` int(11) NOT NULL,
  `id_acta` int(11) DEFAULT NULL,
  `nombre_testigo` varchar(255) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actas_testigo`
--

INSERT INTO `actas_testigo` (`id_acta_testigo`, `id_acta`, `nombre_testigo`, `domicilio`, `created_at`, `updated_at`) VALUES
(2, 2, 'Juan Carkkos', 'EmiliANOZAPATA', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(11, 9, 'fdfdf', 'dfdf', '2024-10-02 17:40:57', '2024-10-02 17:40:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actas_unidad_comercializacion`
--

CREATE TABLE `actas_unidad_comercializacion` (
  `id_comercializacion` int(11) NOT NULL,
  `id_acta` int(11) DEFAULT NULL,
  `comercializacion` varchar(100) DEFAULT NULL,
  `respuestas_comercio` char(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actas_unidad_comercializacion`
--

INSERT INTO `actas_unidad_comercializacion` (`id_comercializacion`, `id_acta`, `comercializacion`, `respuestas_comercio`, `created_at`, `updated_at`) VALUES
(1, 2, 'Bodega o almacén', NULL, '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(2, 2, 'Tarimas', NULL, '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(3, 2, 'Bitácoras', NULL, '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(4, 2, 'Otro:', NULL, '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(5, 2, 'Otro:', 'C', '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(6, 2, 'Bodega o almacén', 'C', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(7, 2, 'Tarimas', NULL, '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(8, 2, 'Bitácoras', NULL, '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(9, 2, 'Otro:', 'NA', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(10, 2, 'Otro:', NULL, '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(21, 5, 'Bodega o almacén', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(22, 5, 'Tarimas', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(23, 5, 'Bitácoras', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(24, 5, 'Otro:', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(25, 5, 'Otro:', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(26, 6, 'Bodega o almacén', 'NC', '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(27, 6, 'Tarimas', NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(28, 6, 'Bitácoras', NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(29, 6, 'Otro:', 'NA', '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(30, 6, 'Otro:', NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(31, 7, 'Bodega o almacén', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(32, 7, 'Tarimas', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(33, 7, 'Bitácoras', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(34, 7, 'Otro:', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(35, 7, 'Otro:', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(36, 8, 'Bodega o almacén', 'C', '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(37, 8, 'Tarimas', 'C', '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(38, 8, 'Bitácoras', 'C', '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(39, 8, 'Otro:', 'C', '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(40, 8, 'Otro:', 'C', '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(41, 9, 'Bodega o almacén', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(42, 9, 'Tarimas', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(43, 9, 'Bitácoras', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(44, 9, 'Otro:', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(45, 9, 'Otro:', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actas_unidad_envasado`
--

CREATE TABLE `actas_unidad_envasado` (
  `id_envasado` int(11) NOT NULL,
  `id_acta` int(11) DEFAULT NULL,
  `areas` varchar(100) DEFAULT NULL,
  `respuestas` char(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actas_unidad_envasado`
--

INSERT INTO `actas_unidad_envasado` (`id_envasado`, `id_acta`, `areas`, `respuestas`, `created_at`, `updated_at`) VALUES
(1, 2, 'Almacén de insumos', 'C', '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(2, 2, 'Almacén a gráneles', 'NA', '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(3, 2, 'Sistema de filtrado', NULL, '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(4, 2, 'Área de envasado', NULL, '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(5, 2, 'Área de tiquetado', NULL, '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(6, 2, 'Almacén de producto terminado', NULL, '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(7, 2, 'Área de aseo personal', NULL, '2024-09-24 17:17:25', '2024-09-24 17:17:25'),
(8, 2, 'Almacén de insumos', 'C', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(9, 2, 'Almacén a gráneles', 'C', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(10, 2, 'Sistema de filtrado', 'NA', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(11, 2, 'Área de envasado', NULL, '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(12, 2, 'Área de tiquetado', NULL, '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(13, 2, 'Almacén de producto terminado', 'NC', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(14, 2, 'Área de aseo personal', 'NC', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(29, 5, 'Almacén de insumos', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(30, 5, 'Almacén a gráneles', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(31, 5, 'Sistema de filtrado', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(32, 5, 'Área de envasado', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(33, 5, 'Área de tiquetado', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(34, 5, 'Almacén de producto terminado', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(35, 5, 'Área de aseo personal', NULL, '2024-09-26 16:19:23', '2024-09-26 16:19:23'),
(36, 6, 'Almacén de insumos', NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(37, 6, 'Almacén a gráneles', NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(38, 6, 'Sistema de filtrado', NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(39, 6, 'Área de envasado', NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(40, 6, 'Área de tiquetado', NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(41, 6, 'Almacén de producto terminado', NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(42, 6, 'Área de aseo personal', NULL, '2024-09-26 17:16:34', '2024-09-26 17:16:34'),
(43, 7, 'Almacén de insumos', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(44, 7, 'Almacén a gráneles', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(45, 7, 'Sistema de filtrado', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(46, 7, 'Área de envasado', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(47, 7, 'Área de tiquetado', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(48, 7, 'Almacén de producto terminado', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(49, 7, 'Área de aseo personal', NULL, '2024-09-26 18:00:41', '2024-09-26 18:00:41'),
(50, 8, 'Almacén de insumos', NULL, '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(51, 8, 'Almacén a gráneles', NULL, '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(52, 8, 'Sistema de filtrado', NULL, '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(53, 8, 'Área de envasado', NULL, '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(54, 8, 'Área de tiquetado', NULL, '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(55, 8, 'Almacén de producto terminado', NULL, '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(56, 8, 'Área de aseo personal', NULL, '2024-09-26 22:58:58', '2024-09-26 22:58:58'),
(57, 9, 'Almacén de insumos', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(58, 9, 'Almacén a gráneles', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(59, 9, 'Sistema de filtrado', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(60, 9, 'Área de envasado', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(61, 9, 'Área de tiquetado', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(62, 9, 'Almacén de producto terminado', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(63, 9, 'Área de aseo personal', NULL, '2024-10-02 17:40:57', '2024-10-02 17:40:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acta_produccion_mezcal`
--

CREATE TABLE `acta_produccion_mezcal` (
  `id` int(11) NOT NULL,
  `area` varchar(100) DEFAULT NULL,
  `id_acta` int(11) DEFAULT NULL,
  `respuesta` char(2) DEFAULT NULL COMMENT 'C, NC, NA',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acta_produccion_mezcal`
--

INSERT INTO `acta_produccion_mezcal` (`id`, `area`, `id_acta`, `respuesta`, `created_at`, `updated_at`) VALUES
(9, 'Recepción (materia prima)', 2, 'C', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(10, 'Área de pesado', 2, 'NC', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(11, 'Área de cocción', 2, 'NA', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(12, 'Área de maguey cocido', 2, 'C', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(13, 'Área de molienda', 2, 'C', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(14, 'Área de fermentación', 2, 'C', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(15, 'Área de destilación', 2, 'C', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(16, 'Almacén a graneles', 2, 'C', '2024-09-24 22:08:55', '2024-09-24 22:08:55'),
(66, 'Recepción (materia prima)', 9, 'C', '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(67, 'Área de pesado', 9, 'C', '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(68, 'Área de cocción', 9, 'C', '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(69, 'Área de maguey cocido', 9, 'NC', '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(70, 'Área de molienda', 9, 'C', '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(71, 'Área de fermentación', 9, 'C', '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(72, 'Área de destilación', 9, 'C', '2024-10-02 17:40:57', '2024-10-02 17:40:57'),
(73, 'Almacén a graneles', 9, 'NC', '2024-10-02 17:40:57', '2024-10-02 17:40:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activar_hologramas`
--

CREATE TABLE `activar_hologramas` (
  `id` int(11) NOT NULL,
  `id_inspeccion` varchar(50) DEFAULT NULL,
  `no_lote_agranel` varchar(50) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `no_analisis` varchar(50) NOT NULL,
  `cont_neto` double NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `clase` varchar(50) NOT NULL,
  `contenido` varchar(50) NOT NULL,
  `no_lote_envasado` varchar(70) NOT NULL,
  `tipo_agave` varchar(70) NOT NULL,
  `lugar_produccion` varchar(79) NOT NULL,
  `lugar_envasado` varchar(70) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `folios` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `activar_hologramas`
--

INSERT INTO `activar_hologramas` (`id`, `id_inspeccion`, `no_lote_agranel`, `categoria`, `no_analisis`, `cont_neto`, `unidad`, `clase`, `contenido`, `no_lote_envasado`, `tipo_agave`, `lugar_produccion`, `lugar_envasado`, `id_solicitud`, `folios`, `created_at`, `updated_at`) VALUES
(1, '4', '343', 'Mezcal', '3554', 454, 'Litros', 'Blanco o Joven', '454', '4545', '4545', '45', '454', 6, '{\"folio_inicial\":[\"2\"],\"folio_final\":[\"4\"]}', '2024-10-07 22:29:33', '2024-10-07 22:29:33'),
(2, '8', '343', 'Mezcal', '3554', 454, 'Litros', 'Blanco o Joven', '454', '4545', '4545', '45', '454', 6, '{\"folio_inicial\":[\"1\",\"3\",\"5\"],\"folio_final\":[\"2\",\"4\",\"6\"]}', '2024-10-07 22:30:09', '2024-10-07 22:30:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'predios', 'El usuario Administrador CIDAM2 creó un registro de predio el 26/08/2024', 'App\\Models\\Predios', 'created', 1, 'App\\Models\\User', 24, '{\"attributes\":{\"id_predio\":1,\"id_empresa\":3,\"nombre_productor\":\"Crista la Santa\",\"nombre_predio\":\"PARCELA 262 Z-2 P1\\/1 M20063\",\"ubicacion_predio\":\"EL ALVARE\\u00d1O, VISTA HERMOSA, VISTA HERMOSA, MICHOAC\\u00c1N\",\"tipo_predio\":\"Ejidal\",\"puntos_referencia\":\"BODEGA DE VISTA HERMOSA\",\"cuenta_con_coordenadas\":\"No\",\"superficie\":\"2.50\"}}', NULL, '2024-08-27 00:08:46', '2024-08-27 00:08:46'),
(2, 'predios', 'El usuario Administrador CIDAM2 creó un registro de predio el 26/08/2024', 'App\\Models\\Predios', 'created', 2, 'App\\Models\\User', 24, '{\"attributes\":{\"id_predio\":2,\"id_empresa\":1,\"nombre_productor\":\"Miguel \\u00c1ngel G\\u00f3mez Romero\",\"nombre_predio\":\"EL RINCON\",\"ubicacion_predio\":\"Etucuaro, MADERO, 06, Michoac\\u00e1n\",\"tipo_predio\":\"Comunal\",\"puntos_referencia\":\"CENTRO DE ETUCUARO\",\"cuenta_con_coordenadas\":\"No\",\"superficie\":\"8.74\"}}', NULL, '2024-08-27 01:48:12', '2024-08-27 01:48:12'),
(3, 'lotesgranel', 'El usuario Administrador CIDAM2 creó un registro de lotes a granel el 26/08/2024', 'App\\Models\\LotesGranel', 'created', 1, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":1,\"nombre_lote\":\"JL-01-A\",\"tipo_lote\":1,\"folio_fq\":\"NNMZ-15905 y ----\",\"volumen\":96.7,\"cont_alc\":45.1,\"id_categoria\":1,\"id_clase\":1,\"id_tipo\":2,\"ingredientes\":null,\"edad\":null,\"id_guia\":null,\"folio_certificado\":null,\"id_organismo\":null,\"fecha_emision\":null,\"fecha_vigencia\":null}}', NULL, '2024-08-27 01:49:47', '2024-08-27 01:49:47'),
(4, 'lotesgranel', 'El usuario Administrador CIDAM2 creó un registro de lotes a granel el 29/08/2024', 'App\\Models\\LotesGranel', 'created', 2, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":3,\"nombre_lote\":\"GRANEL 01\",\"tipo_lote\":1,\"folio_fq\":\"Folio 001 y Folio 002\",\"volumen\":5894,\"cont_alc\":50,\"id_categoria\":1,\"id_clase\":2,\"id_tipo\":1,\"ingredientes\":null,\"edad\":\"3 Meses\",\"id_guia\":null,\"folio_certificado\":null,\"id_organismo\":null,\"fecha_emision\":null,\"fecha_vigencia\":null}}', NULL, '2024-08-30 04:16:46', '2024-08-30 04:16:46'),
(5, 'predios', 'El usuario Administrador CIDAM2 creó un registro de predio el 04/09/2024', 'App\\Models\\Predios', 'created', 3, 'App\\Models\\User', 24, '{\"attributes\":{\"id_predio\":3,\"id_empresa\":1,\"nombre_productor\":\"Miguel \\u00c1ngel G\\u00f3mez Romero\",\"nombre_predio\":\"Purechuco texas\",\"ubicacion_predio\":\"En huetamo michoac\\u00e1n\",\"tipo_predio\":\"Comunal\",\"puntos_referencia\":\"Entre purechucho y la gas\",\"cuenta_con_coordenadas\":\"No\",\"superficie\":\"8975.00\",\"estatus\":\"Vigente\"}}', NULL, '2024-09-05 04:38:39', '2024-09-05 04:38:39'),
(6, 'solicitudesmodel', 'El usuario Administrador CIDAM2 creó un registro de lotes a granel el 05/09/2024', 'App\\Models\\solicitudesModel', 'created', 4, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":3}}', NULL, '2024-09-06 05:17:58', '2024-09-06 05:17:58'),
(7, 'solicitudesmodel', 'El usuario Administrador CIDAM2 creó un registro de lotes a granel el 05/09/2024', 'App\\Models\\solicitudesModel', 'created', 5, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":3,\"id_tipo\":14,\"folio\":\"SOL-2024-00005\",\"fecha_visita\":\"2024-09-26 12:00:00\",\"id_instalacion\":6}}', NULL, '2024-09-06 05:19:25', '2024-09-06 05:19:25'),
(8, 'solicitudesmodel', 'El usuario Administrador CIDAM2 creó un registro de solicitud el 05/09/2024', 'App\\Models\\solicitudesModel', 'created', 6, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":14,\"folio\":\"SOL-2024-00006\",\"fecha_visita\":\"2024-09-10 12:00:00\",\"id_instalacion\":2}}', NULL, '2024-09-06 05:29:41', '2024-09-06 05:29:41'),
(9, 'solicitudesmodel', 'El usuario Administrador CIDAM2 creó un registro de solicitud el 05/09/2024', 'App\\Models\\solicitudesModel', 'created', 7, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":3,\"id_tipo\":14,\"folio\":\"SOL-2024-00007\",\"fecha_visita\":\"2024-09-26 12:00:00\",\"id_instalacion\":7}}', NULL, '2024-09-06 05:35:29', '2024-09-06 05:35:29'),
(10, 'solicitudesmodel', 'El usuario Karen Pérez creó un registro de solicitud el 05/09/2024', 'App\\Models\\solicitudesModel', 'created', 8, 'App\\Models\\User', 18, '{\"attributes\":{\"id_empresa\":3,\"id_tipo\":14,\"folio\":\"SOL-2024-00008\",\"fecha_visita\":\"2024-09-24 12:05:00\",\"id_instalacion\":6}}', NULL, '2024-09-05 23:49:22', '2024-09-05 23:49:22'),
(11, 'solicitudesmodel', 'El usuario Karen Pérez creó un registro de solicitud el 05/09/2024', 'App\\Models\\solicitudesModel', 'created', 9, 'App\\Models\\User', 18, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":14,\"folio\":\"SOL-2024-00009\",\"fecha_visita\":\"2024-09-17 12:00:00\",\"id_instalacion\":1}}', NULL, '2024-09-05 23:51:50', '2024-09-05 23:51:50'),
(12, 'solicitudesmodel', 'El usuario Karen Pérez creó un registro de solicitud el 06/09/2024', 'App\\Models\\solicitudesModel', 'created', 10, 'App\\Models\\User', 18, '{\"attributes\":{\"id_empresa\":3,\"id_tipo\":14,\"folio\":\"SOL-2024-00010\",\"fecha_visita\":\"2024-09-17 12:00:00\",\"id_instalacion\":7}}', NULL, '2024-09-06 16:01:13', '2024-09-06 16:01:13'),
(13, 'inspecciones', 'El usuario Karen Pérez actualizó un registro de inspecciones el 06/09/2024', 'App\\Models\\inspecciones', 'updated', 6, 'App\\Models\\User', 18, '{\"attributes\":{\"id_inspeccion\":6,\"id_solicitud\":10,\"id_inspector\":21,\"num_servicio\":\"UMS-1285\\/2023\",\"fecha_servicio\":\"2024-10-03\",\"observaciones\":\"\",\"estatus_inspeccion\":1},\"old\":{\"id_inspeccion\":6,\"id_solicitud\":10,\"id_inspector\":21,\"num_servicio\":\"UMS-1112\\/2024\",\"fecha_servicio\":\"2024-09-03\",\"observaciones\":\"Es una prueba\",\"estatus_inspeccion\":1}}', NULL, '2024-09-06 23:32:51', '2024-09-06 23:32:51'),
(14, 'certificados', 'El usuario Karen Pérez creó un registro de certificados el 06/09/2024', 'App\\Models\\Certificados', 'created', 149, 'App\\Models\\User', 18, '{\"attributes\":{\"id_dictamen\":1,\"id_firmante\":19,\"id_empresa\":null,\"num_certificado\":\"OCER 0002\",\"fecha_vigencia\":\"2024-09-18\",\"fecha_vencimiento\":\"2025-09-18\",\"maestro_mezcalero\":\"Rams\\u00e9s L\\u00f3pez P\\u00e9rez\",\"num_autorizacion\":43434}}', NULL, '2024-09-07 00:45:21', '2024-09-07 00:45:21'),
(15, 'lotesgranel', 'El usuario Administrador CIDAM2 creó un registro de lotes a granel el 09/09/2024', 'App\\Models\\LotesGranel', 'created', 3, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":3,\"nombre_lote\":\"Lote 1 de prueba de cista\",\"tipo_lote\":1,\"folio_fq\":\"Sin FQ\",\"volumen\":5000,\"cont_alc\":38.8,\"id_categoria\":1,\"id_clase\":3,\"id_tipo\":1,\"ingredientes\":null,\"edad\":null,\"id_guia\":null,\"folio_certificado\":null,\"id_organismo\":null,\"fecha_emision\":null,\"fecha_vigencia\":null}}', NULL, '2024-09-09 16:19:27', '2024-09-09 16:19:27'),
(16, 'solicitudesmodel', 'El usuario Administrador CIDAM2 creó un registro de solicitud el 09/09/2024', 'App\\Models\\solicitudesModel', 'created', 11, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":14,\"folio\":\"SOL-2024-00011\",\"fecha_visita\":\"2024-09-10 12:00:00\",\"id_instalacion\":2}}', NULL, '2024-09-09 22:53:13', '2024-09-09 22:53:13'),
(17, 'solicitudesmodel', 'El usuario Administrador CIDAM2 creó un registro de solicitud el 09/09/2024', 'App\\Models\\solicitudesModel', 'created', 12, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":3,\"id_tipo\":14,\"folio\":\"SOL-2024-00012\",\"fecha_visita\":\"2024-09-10 12:00:00\",\"id_instalacion\":8}}', NULL, '2024-09-09 23:26:03', '2024-09-09 23:26:03'),
(18, 'solicitudesmodel', 'El usuario Eva Viviana Soto Barrietos creó un registro de solicitud el 09/09/2024', 'App\\Models\\solicitudesModel', 'created', 13, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":14,\"folio\":\"SOL-2024-00013\",\"fecha_visita\":\"2024-09-09 12:00:00\",\"id_instalacion\":2}}', NULL, '2024-09-09 23:30:52', '2024-09-09 23:30:52'),
(19, 'predios', 'El usuario Eva Viviana Soto Barrietos creó un registro de predio el 09/09/2024', 'App\\Models\\Predios', 'created', 4, 'App\\Models\\User', 20, '{\"attributes\":{\"id_predio\":4,\"id_empresa\":1,\"nombre_productor\":\"dsdf\",\"nombre_predio\":\"dfdf\",\"ubicacion_predio\":\"hdfdf\",\"tipo_predio\":\"Comunal\",\"puntos_referencia\":\"dfdf\",\"cuenta_con_coordenadas\":\"No\",\"superficie\":\"44.00\",\"estatus\":\"Vigente\"}}', NULL, '2024-09-09 23:34:30', '2024-09-09 23:34:30'),
(20, 'solicitudesmodel', 'El usuario Eva Viviana Soto Barrietos creó un registro de solicitud el 10/09/2024', 'App\\Models\\solicitudesModel', 'created', 14, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":14,\"folio\":\"SOL-2024-00014\",\"fecha_visita\":\"2024-09-10 12:00:00\",\"id_instalacion\":2}}', NULL, '2024-09-10 15:27:04', '2024-09-10 15:27:04'),
(21, 'solicitudesmodel', 'El usuario Eva Viviana Soto Barrietos creó un registro de solicitud el 10/09/2024', 'App\\Models\\solicitudesModel', 'created', 15, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":3,\"id_tipo\":14,\"folio\":\"SOL-2024-00015\",\"fecha_visita\":\"2024-09-18 12:00:00\",\"id_instalacion\":8}}', NULL, '2024-09-10 15:28:58', '2024-09-10 15:28:58'),
(22, 'solicitudesmodel', 'El usuario Eva Viviana Soto Barrietos creó un registro de solicitud el 10/09/2024', 'App\\Models\\solicitudesModel', 'created', 16, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":3,\"id_tipo\":14,\"folio\":\"SOL-2024-00016\",\"fecha_visita\":\"2024-09-10 12:00:00\",\"id_instalacion\":8}}', NULL, '2024-09-10 15:38:30', '2024-09-10 15:38:30'),
(23, 'inspecciones', 'El usuario Eva Viviana Soto Barrietos creó un registro de inspecciones el 10/09/2024', 'App\\Models\\inspecciones', 'created', 7, 'App\\Models\\User', 20, '{\"attributes\":{\"id_inspeccion\":7,\"id_solicitud\":14,\"id_inspector\":14,\"num_servicio\":\"UMS-0001\\/2025\",\"fecha_servicio\":\"2025-01-01\",\"observaciones\":\"Es la primera inspecci\\u00f3n del a\\u00f1o\",\"estatus_inspeccion\":1}}', NULL, '2024-09-10 16:18:28', '2024-09-10 16:18:28'),
(25, 'dictamen_instalaciones', 'El usuario Eva Viviana Soto Barrietos creó un registro de dictamen de instalaciones el 10/09/2024', 'App\\Models\\Dictamen_instalaciones', 'created', 20, 'App\\Models\\User', 20, '{\"attributes\":{\"id_dictamen\":20,\"id_inspeccion\":7,\"tipo_dictamen\":1,\"id_instalacion\":2,\"num_dictamen\":\"OMS-0001\",\"fecha_dictamen\":null,\"fecha_vigencia\":\"2025-09-30\",\"categorias\":\"[\\\"Reposado\\\"]\",\"clases\":\"[\\\"A\\\\u00f1ejo\\\"]\"}}', NULL, '2024-09-10 17:05:32', '2024-09-10 17:05:32'),
(26, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 10/09/2024', 'App\\Models\\Documentacion_url', 'created', 18, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025_1726007077.pdf\",\"id_relacion\":14,\"id_usuario_registro\":null,\"nombre_documento\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025\",\"fecha_vigencia\":null,\"id_documento\":69}}', NULL, '2024-09-10 22:24:37', '2024-09-10 22:24:37'),
(27, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 10/09/2024', 'App\\Models\\Documentacion_url', 'created', 19, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025_1726008426.png\",\"id_relacion\":14,\"id_usuario_registro\":null,\"nombre_documento\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025\",\"fecha_vigencia\":null,\"id_documento\":69}}', NULL, '2024-09-10 22:47:06', '2024-09-10 22:47:06'),
(28, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 10/09/2024', 'App\\Models\\Documentacion_url', 'created', 20, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025_1726008522.png\",\"id_relacion\":14,\"id_usuario_registro\":null,\"nombre_documento\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025\",\"fecha_vigencia\":null,\"id_documento\":69}}', NULL, '2024-09-10 22:48:42', '2024-09-10 22:48:42'),
(29, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 10/09/2024', 'App\\Models\\Documentacion_url', 'created', 21, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025_1726008533.png\",\"id_relacion\":14,\"id_usuario_registro\":null,\"nombre_documento\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025\",\"fecha_vigencia\":null,\"id_documento\":69}}', NULL, '2024-09-10 22:48:53', '2024-09-10 22:48:53'),
(30, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 10/09/2024', 'App\\Models\\Documentacion_url', 'created', 22, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025_1726008609.pdf\",\"id_relacion\":14,\"id_usuario_registro\":null,\"nombre_documento\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025\",\"fecha_vigencia\":null,\"id_documento\":69}}', NULL, '2024-09-10 22:50:09', '2024-09-10 22:50:09'),
(31, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 10/09/2024', 'App\\Models\\Documentacion_url', 'created', 23, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025_1726008800.png\",\"id_relacion\":14,\"id_usuario_registro\":null,\"nombre_documento\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025\",\"fecha_vigencia\":null,\"id_documento\":69}}', NULL, '2024-09-10 22:53:20', '2024-09-10 22:53:20'),
(32, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 10/09/2024', 'App\\Models\\Documentacion_url', 'created', 24, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Fotos de bit\\u00e1coras_1726008800.pdf\",\"id_relacion\":14,\"id_usuario_registro\":null,\"nombre_documento\":\"Fotos de bit\\u00e1coras\",\"fecha_vigencia\":null,\"id_documento\":70}}', NULL, '2024-09-10 22:53:20', '2024-09-10 22:53:20'),
(33, 'solicitudesmodel', 'El usuario Eva Viviana Soto Barrietos creó un registro de solicitud el 11/09/2024', 'App\\Models\\solicitudesModel', 'created', 17, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":14,\"folio\":\"SOL-2024-00017\",\"fecha_visita\":\"2024-09-10 12:00:00\",\"id_instalacion\":2}}', NULL, '2024-09-11 15:45:05', '2024-09-11 15:45:05'),
(34, 'solicitudesmodel', 'El usuario Eva Viviana Soto Barrietos creó un registro de solicitud el 11/09/2024', 'App\\Models\\solicitudesModel', 'created', 18, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":14,\"folio\":\"SOL-2024-00018\",\"fecha_visita\":\"2024-09-17 12:00:00\",\"id_instalacion\":2}}', NULL, '2024-09-11 19:08:21', '2024-09-11 19:08:21'),
(35, 'solicitudesmodel', 'El usuario Eva Viviana Soto Barrietos creó un registro de solicitud el 11/09/2024', 'App\\Models\\solicitudesModel', 'created', 19, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":14,\"folio\":\"SOL-2024-00019\",\"fecha_visita\":\"2024-09-11 12:00:00\",\"id_instalacion\":2}}', NULL, '2024-09-11 20:09:36', '2024-09-11 20:09:36'),
(36, 'solicitudesmodel', 'El usuario Eva Viviana Soto Barrietos creó un registro de solicitud el 11/09/2024', 'App\\Models\\solicitudesModel', 'created', 20, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":10,\"folio\":\"SOL-2024-00020\",\"fecha_visita\":\"2024-09-17 12:00:00\",\"id_instalacion\":0}}', NULL, '2024-09-11 20:24:04', '2024-09-11 20:24:04'),
(37, 'dictamen_instalaciones', 'El usuario Eva Viviana Soto Barrietos creó un registro de dictamen de instalaciones el 13/09/2024', 'App\\Models\\Dictamen_instalaciones', 'created', 17, 'App\\Models\\User', 20, '{\"attributes\":{\"id_dictamen\":17,\"id_inspeccion\":6,\"tipo_dictamen\":3,\"id_instalacion\":7,\"num_dictamen\":\"343\",\"fecha_emision\":\"2024-09-18\",\"fecha_vigencia\":\"2025-09-17\",\"categorias\":\"[\\\"Reposado\\\"]\",\"clases\":\"[\\\"Reposado\\\"]\"}}', NULL, '2024-09-13 23:47:16', '2024-09-13 23:47:16'),
(38, 'dictamen_granel', 'El usuario Eva Viviana Soto Barrietos creó un registro de dictamen de granel el 13/09/2024', 'App\\Models\\Dictamen_Granel', 'created', 6, 'App\\Models\\User', 20, '{\"attributes\":{\"num_dictamen\":\"24343\",\"id_empresa\":1,\"id_inspeccion\":6,\"id_lote_granel\":1,\"fecha_emision\":\"2024-09-10\",\"fecha_vigencia\":\"2024-09-10\",\"fecha_servicio\":\"2024-09-17\",\"estatus\":\"Emitido\",\"observaciones\":null,\"id_firmante\":\"14\"}}', NULL, '2024-09-13 23:47:55', '2024-09-13 23:47:55'),
(39, 'lotesgranel', 'El usuario Eva Viviana Soto Barrietos creó un registro de lotes a granel el 17/09/2024', 'App\\Models\\LotesGranel', 'created', 4, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"nombre_lote\":\"LOTE de prueba 2\",\"tipo_lote\":1,\"folio_fq\":\"4545  \",\"volumen\":5000,\"cont_alc\":45,\"id_categoria\":1,\"id_clase\":2,\"id_tipo\":1,\"ingredientes\":null,\"edad\":null,\"id_guia\":null,\"folio_certificado\":null,\"id_organismo\":null,\"fecha_emision\":null,\"fecha_vigencia\":null,\"estatus\":null}}', NULL, '2024-09-17 19:13:05', '2024-09-17 19:13:05'),
(40, 'solicitudesmodel', 'El usuario Eva Viviana Soto Barrietos creó un registro de solicitud el 18/09/2024', 'App\\Models\\solicitudesModel', 'created', 21, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":14,\"folio\":\"SOL-2024-00021\",\"fecha_visita\":\"2024-09-18 12:00:00\",\"id_instalacion\":12}}', NULL, '2024-09-18 19:05:43', '2024-09-18 19:05:43'),
(41, 'inspecciones', 'El usuario Eva Viviana Soto Barrietos creó un registro de inspecciones el 18/09/2024', 'App\\Models\\inspecciones', 'created', 8, 'App\\Models\\User', 20, '{\"attributes\":{\"id_inspeccion\":8,\"id_solicitud\":21,\"id_inspector\":14,\"num_servicio\":\"UMS-1285\\/2023\",\"fecha_servicio\":\"2024-09-10\",\"observaciones\":\"todo bien\",\"estatus_inspeccion\":1}}', NULL, '2024-09-18 19:06:41', '2024-09-18 19:06:41'),
(42, 'certificados', 'El usuario Eva Viviana Soto Barrietos creó un registro de certificados el 18/09/2024', 'App\\Models\\Certificados', 'created', 1, 'App\\Models\\User', 20, '{\"attributes\":{\"id_dictamen\":5,\"id_firmante\":19,\"id_empresa\":null,\"num_certificado\":\"CErtificado 1\",\"fecha_vigencia\":\"2024-09-18\",\"fecha_vencimiento\":\"2025-09-18\",\"maestro_mezcalero\":null,\"num_autorizacion\":null}}', NULL, '2024-09-18 23:16:31', '2024-09-18 23:16:31'),
(43, 'revisor', 'El usuario Eva Viviana Soto Barrietos creó un registro de revisor el 19/09/2024', 'App\\Models\\Revisor', 'created', 6, 'App\\Models\\User', 20, '{\"attributes\":{\"tipo_revision\":2,\"id_revisor\":19,\"numero_revision\":1,\"es_correccion\":\"si\",\"observaciones\":\"\"}}', NULL, '2024-09-19 18:38:15', '2024-09-19 18:38:15'),
(44, 'inspecciones', 'El usuario Karen Velazquez creó un registro de inspecciones el 19/09/2024', 'App\\Models\\inspecciones', 'created', 9, 'App\\Models\\User', 14, '{\"attributes\":{\"id_inspeccion\":9,\"id_solicitud\":20,\"id_inspector\":21,\"num_servicio\":\"UMS-1823\\/2023\",\"fecha_servicio\":\"2024-09-17\",\"observaciones\":\"\",\"estatus_inspeccion\":1}}', NULL, '2024-09-19 21:31:39', '2024-09-19 21:31:39'),
(45, 'revisor', 'El usuario Eva Viviana Soto Barrietos creó un registro de revisor el 23/09/2024', 'App\\Models\\Revisor', 'created', 7, 'App\\Models\\User', 20, '{\"attributes\":{\"tipo_revision\":1,\"id_revisor\":18,\"numero_revision\":1,\"es_correccion\":\"no\",\"observaciones\":\"\"}}', NULL, '2024-09-23 15:41:57', '2024-09-23 15:41:57'),
(46, 'predios_inspeccion', 'El usuario Eva Viviana Soto Barrietos creó un registro de equisde el 02/10/2024', 'App\\Models\\Predios_Inspeccion', 'created', 21, 'App\\Models\\User', 20, '{\"attributes\":{\"id_predio\":2,\"no_orden_servicio\":\"3434\",\"no_cliente\":\"3434\",\"id_empresa\":3,\"id_tipo_agave\":1,\"domicilio_fiscal\":\"343434\",\"telefono\":\"4351037022\",\"ubicacion_predio\":\"En huetamo michoac\\u00e1n\",\"localidad\":\"MORELIA\",\"municipio\":\"43434sdsd\",\"distrito\":\"sdsd\",\"id_estado\":16,\"nombre_paraje\":\"sdsdsd\",\"zona_dom\":\"si\",\"id_tipo_maguey\":1,\"marco_plantacion\":\"22.00\",\"distancia_surcos\":\"3434.00\",\"distancia_plantas\":\"3434.00\",\"superficie\":\"454.00\",\"fecha_inspeccion\":\"2024-10-14\"}}', NULL, '2024-10-02 16:30:21', '2024-10-02 16:30:21'),
(47, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 02/10/2024', 'App\\Models\\Documentacion_url', 'created', 25, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":3,\"url\":\"Comprobante de posesi\\u00f3n de instalaciones (Si es propietario, este documento debe estar a nombre de la persona f\\u00edsica o moral que se inscribe) o Contrato de arrendamiento_66fd79dc6adce.pdf\",\"id_relacion\":2,\"id_usuario_registro\":null,\"nombre_documento\":\"Comprobante de posesi\\u00f3n de instalaciones (Si es propietario, este documento debe estar a nombre de la persona f\\u00edsica o moral que se inscribe) o Contrato de arrendamiento\",\"fecha_vigencia\":null,\"id_documento\":34}}', NULL, '2024-10-02 16:50:36', '2024-10-02 16:50:36'),
(48, 'predios', 'El usuario Eva Viviana Soto Barrietos actualizó un registro de predio el 02/10/2024', 'App\\Models\\Predios', 'updated', 2, 'App\\Models\\User', 20, '{\"attributes\":{\"id_predio\":2,\"id_empresa\":3,\"nombre_productor\":\"Miguel \\u00c1ngel G\\u00f3mez Romero\",\"nombre_predio\":\"Huetayork\",\"ubicacion_predio\":\"En huetamo michoac\\u00e1n\",\"tipo_predio\":\"Propiedad privada\",\"puntos_referencia\":\"Cerca dela capilla de las colonias\",\"cuenta_con_coordenadas\":\"Si\",\"superficie\":\"454.00\",\"estatus\":\"Vigente\"},\"old\":{\"id_predio\":2,\"id_empresa\":3,\"nombre_productor\":\"Miguel \\u00c1ngel G\\u00f3mez Romero\",\"nombre_predio\":\"Huetayork\",\"ubicacion_predio\":\"En huetamo michoac\\u00e1n\",\"tipo_predio\":\"Propiedad privada\",\"puntos_referencia\":\"Cerca dela capilla de las colonias\",\"cuenta_con_coordenadas\":\"No\",\"superficie\":\"454.00\",\"estatus\":\"Vigente\"}}', NULL, '2024-10-02 16:50:36', '2024-10-02 16:50:36'),
(49, 'lotesgranel', 'El usuario Eva Viviana Soto Barrietos creó un registro de lotes a granel el 02/10/2024', 'App\\Models\\LotesGranel', 'created', 88, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":3,\"nombre_lote\":\"Lote 01\",\"tipo_lote\":1,\"folio_fq\":\"Sin FQ\",\"volumen\":7500,\"cont_alc\":42.5,\"id_categoria\":1,\"id_clase\":1,\"id_tipo\":1,\"ingredientes\":null,\"edad\":null,\"id_guia\":null,\"folio_certificado\":null,\"id_organismo\":null,\"fecha_emision\":null,\"fecha_vigencia\":null,\"estatus\":\"Activo\",\"lote_original_id\":null}}', NULL, '2024-10-02 22:01:45', '2024-10-02 22:01:45'),
(50, 'dictamen_instalaciones', 'El usuario Eva Viviana Soto Barrietos creó un registro de dictamen de instalaciones el 02/10/2024', 'App\\Models\\Dictamen_instalaciones', 'created', 18, 'App\\Models\\User', 20, '{\"attributes\":{\"id_dictamen\":18,\"id_inspeccion\":4,\"tipo_dictamen\":1,\"id_instalacion\":1,\"num_dictamen\":\"5y65656\",\"fecha_emision\":\"2024-10-02\",\"fecha_vigencia\":\"2025-10-01\",\"categorias\":\"[\\\"Blanco o Joven\\\"]\",\"clases\":\"[\\\"Reposado\\\"]\"}}', NULL, '2024-10-02 22:08:10', '2024-10-02 22:08:10'),
(51, 'inspecciones', 'El usuario Eva Viviana Soto Barrietos creó un registro de inspecciones el 02/10/2024', 'App\\Models\\inspecciones', 'created', 10, 'App\\Models\\User', 20, '{\"attributes\":{\"id_inspeccion\":10,\"id_solicitud\":19,\"id_inspector\":14,\"num_servicio\":\"UMS-1823\\/2023\",\"fecha_servicio\":\"2024-10-02\",\"observaciones\":\"\",\"estatus_inspeccion\":1}}', NULL, '2024-10-02 22:11:05', '2024-10-02 22:11:05'),
(52, 'revisor', 'El usuario Eva Viviana Soto Barrietos creó un registro de Revisor el 02/10/2024', 'App\\Models\\Revisor', 'created', 1, 'App\\Models\\User', 20, '{\"attributes\":{\"tipo_revision\":1,\"id_revisor\":18,\"id_revisor2\":null,\"id_certificado\":1,\"numero_revision\":1,\"es_correccion\":\"no\",\"observaciones\":\"\"}}', NULL, '2024-10-02 22:53:38', '2024-10-02 22:53:38'),
(53, 'revisor', 'El usuario Eva Viviana Soto Barrietos creó un registro de Revisor el 02/10/2024', 'App\\Models\\Revisor', 'created', 1, 'App\\Models\\User', 20, '{\"attributes\":{\"tipo_revision\":1,\"id_revisor\":18,\"id_revisor2\":null,\"id_certificado\":1,\"numero_revision\":1,\"es_correccion\":\"no\",\"observaciones\":\"\"}}', NULL, '2024-10-02 23:05:31', '2024-10-02 23:05:31'),
(54, 'revisor', 'El usuario Eva Viviana Soto Barrietos actualizó un registro de Revisor el 02/10/2024', 'App\\Models\\Revisor', 'updated', 1, 'App\\Models\\User', 20, '{\"attributes\":{\"tipo_revision\":1,\"id_revisor\":18,\"id_revisor2\":26,\"id_certificado\":1,\"numero_revision\":1,\"es_correccion\":\"no\",\"observaciones\":\"\"},\"old\":{\"tipo_revision\":1,\"id_revisor\":18,\"id_revisor2\":null,\"id_certificado\":1,\"numero_revision\":1,\"es_correccion\":\"no\",\"observaciones\":\"\"}}', NULL, '2024-10-02 23:05:43', '2024-10-02 23:05:43'),
(55, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 04/10/2024', 'App\\Models\\Documentacion_url', 'created', 26, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Acta constitutiva (Copia simple)_1728067610.png\",\"id_relacion\":0,\"id_usuario_registro\":null,\"nombre_documento\":\"Acta constitutiva (Copia simple)\",\"fecha_vigencia\":null,\"id_documento\":1}}', NULL, '2024-10-04 18:46:50', '2024-10-04 18:46:50'),
(56, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 04/10/2024', 'App\\Models\\Documentacion_url', 'created', 27, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Acta constitutiva (Copia simple)_1728067626.png\",\"id_relacion\":0,\"id_usuario_registro\":null,\"nombre_documento\":\"Acta constitutiva (Copia simple)\",\"fecha_vigencia\":null,\"id_documento\":1}}', NULL, '2024-10-04 18:47:06', '2024-10-04 18:47:06'),
(57, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 04/10/2024', 'App\\Models\\Documentacion_url', 'created', 28, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Dict\\u00e1menes_1728067626.png\",\"id_relacion\":0,\"id_usuario_registro\":null,\"nombre_documento\":\"Dict\\u00e1menes\",\"fecha_vigencia\":null,\"id_documento\":47}}', NULL, '2024-10-04 18:47:06', '2024-10-04 18:47:06'),
(58, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 04/10/2024', 'App\\Models\\Documentacion_url', 'created', 29, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Carta de asignaci\\u00f3n de n\\u00famero de cliente_1728067656.png\",\"id_relacion\":0,\"id_usuario_registro\":null,\"nombre_documento\":\"Carta de asignaci\\u00f3n de n\\u00famero de cliente\",\"fecha_vigencia\":null,\"id_documento\":77}}', NULL, '2024-10-04 18:47:36', '2024-10-04 18:47:36'),
(59, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 04/10/2024', 'App\\Models\\Documentacion_url', 'created', 30, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Poder notarial del representante legal (Solo en caso de no estar incluido en el acta constitutiva)_1728067677.png\",\"id_relacion\":0,\"id_usuario_registro\":null,\"nombre_documento\":\"Poder notarial del representante legal (Solo en caso de no estar incluido en el acta constitutiva)\",\"fecha_vigencia\":null,\"id_documento\":2}}', NULL, '2024-10-04 18:47:57', '2024-10-04 18:47:57'),
(60, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 04/10/2024', 'App\\Models\\Documentacion_url', 'created', 31, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Copia de identificacion oficial del Titular (encaso de ser persona f\\u00edsica) o representante legal (en caso de ser persona moral)._1728067677.png\",\"id_relacion\":0,\"id_usuario_registro\":null,\"nombre_documento\":\"Copia de identificacion oficial del Titular (encaso de ser persona f\\u00edsica) o representante legal (en caso de ser persona moral).\",\"fecha_vigencia\":null,\"id_documento\":3}}', NULL, '2024-10-04 18:47:57', '2024-10-04 18:47:57'),
(61, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 04/10/2024', 'App\\Models\\Documentacion_url', 'created', 32, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Constancia de situaci\\u00f3n fiscal_1728067677.png\",\"id_relacion\":0,\"id_usuario_registro\":null,\"nombre_documento\":\"Constancia de situaci\\u00f3n fiscal\",\"fecha_vigencia\":null,\"id_documento\":76}}', NULL, '2024-10-04 18:47:57', '2024-10-04 18:47:57'),
(62, 'documentacion_url', 'El usuario Eva Viviana Soto Barrietos creó un registro de documentación el 04/10/2024', 'App\\Models\\Documentacion_url', 'created', 33, 'App\\Models\\User', 20, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Carta de asignaci\\u00f3n de n\\u00famero de cliente_1728067677.png\",\"id_relacion\":0,\"id_usuario_registro\":null,\"nombre_documento\":\"Carta de asignaci\\u00f3n de n\\u00famero de cliente\",\"fecha_vigencia\":null,\"id_documento\":77}}', NULL, '2024-10-04 18:47:57', '2024-10-04 18:47:57'),
(63, 'solicitudesmodel', 'El usuario Administrador CIDAM2 creó un registro de solicitud el 07/10/2024', 'App\\Models\\solicitudesModel', 'created', 22, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":1,\"id_tipo\":14,\"folio\":\"SOL-2024-00022\",\"fecha_visita\":\"2024-10-07 12:00:00\",\"id_instalacion\":1}}', NULL, '2024-10-07 16:58:40', '2024-10-07 16:58:40'),
(64, 'inspecciones', 'El usuario Administrador CIDAM2 creó un registro de inspecciones el 07/10/2024', 'App\\Models\\inspecciones', 'created', 11, 'App\\Models\\User', 24, '{\"attributes\":{\"id_inspeccion\":11,\"id_solicitud\":22,\"id_inspector\":14,\"num_servicio\":\"georefere\",\"fecha_servicio\":\"2024-10-07\",\"observaciones\":\"\",\"estatus_inspeccion\":1}}', NULL, '2024-10-07 16:59:23', '2024-10-07 16:59:23'),
(65, 'predios', 'El usuario Administrador CIDAM2 creó un registro de predio el 09/10/2024', 'App\\Models\\Predios', 'created', 5, 'App\\Models\\User', 24, '{\"attributes\":{\"id_predio\":5,\"id_empresa\":1,\"nombre_productor\":\"Miguel\",\"num_predio\":\"Sin asignar\",\"nombre_predio\":\"DE huetamo\",\"ubicacion_predio\":\"Huetamo\",\"tipo_predio\":\"Comunal\",\"puntos_referencia\":\"Por la capillla de las colonias\",\"cuenta_con_coordenadas\":\"Si\",\"superficie\":\"500.00\",\"estatus\":\"Vigente\",\"fecha_emision\":null,\"fecha_vigencia\":null}}', NULL, '2024-10-09 18:22:14', '2024-10-09 18:22:14'),
(66, 'documentacion_url', 'El usuario Administrador CIDAM2 creó un registro de documentación el 09/10/2024', 'App\\Models\\Documentacion_url', 'created', 34, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Comprobante de posesi\\u00f3n de instalaciones (Si es propietario, este documento debe estar a nombre de la persona f\\u00edsica o moral que se inscribe) o Contrato de arrendamiento_6706c9d6e543b.pdf\",\"id_relacion\":5,\"id_usuario_registro\":null,\"nombre_documento\":\"Comprobante de posesi\\u00f3n de instalaciones (Si es propietario, este documento debe estar a nombre de la persona f\\u00edsica o moral que se inscribe) o Contrato de arrendamiento\",\"fecha_vigencia\":null,\"id_documento\":34}}', NULL, '2024-10-09 18:22:15', '2024-10-09 18:22:15'),
(67, 'predios', 'El usuario Administrador CIDAM2 creó un registro de predio el 09/10/2024', 'App\\Models\\Predios', 'created', 130, 'App\\Models\\User', 24, '{\"attributes\":{\"id_predio\":130,\"id_empresa\":1,\"nombre_productor\":\"Miguel \\u00c1ngel G\\u00f3mez Romero\",\"num_predio\":\"Sin asignar\",\"nombre_predio\":\"La huaranga\",\"ubicacion_predio\":\"Huetamo, Michoac\\u00e1n\",\"tipo_predio\":\"Propiedad privada\",\"puntos_referencia\":\"Cerca de la capilla de las colonias\",\"cuenta_con_coordenadas\":\"Si\",\"superficie\":\"5000.00\",\"estatus\":\"Pendiente\",\"fecha_emision\":null,\"fecha_vigencia\":null}}', NULL, '2024-10-09 19:17:49', '2024-10-09 19:17:49'),
(68, 'documentacion_url', 'El usuario Administrador CIDAM2 creó un registro de documentación el 09/10/2024', 'App\\Models\\Documentacion_url', 'created', 35, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":1,\"url\":\"Comprobante de posesi\\u00f3n de instalaciones (Si es propietario, este documento debe estar a nombre de la persona f\\u00edsica o moral que se inscribe) o Contrato de arrendamiento_6706d6dd29f21.pdf\",\"id_relacion\":130,\"id_usuario_registro\":null,\"nombre_documento\":\"Comprobante de posesi\\u00f3n de instalaciones (Si es propietario, este documento debe estar a nombre de la persona f\\u00edsica o moral que se inscribe) o Contrato de arrendamiento\",\"fecha_vigencia\":null,\"id_documento\":34}}', NULL, '2024-10-09 19:17:49', '2024-10-09 19:17:49'),
(69, 'revisor', 'El usuario Administrador CIDAM2 creó un registro de Revisor el 09/10/2024', 'App\\Models\\Revisor', 'created', 2, 'App\\Models\\User', 24, '{\"attributes\":{\"tipo_revision\":2,\"id_revisor\":null,\"id_revisor2\":26,\"id_certificado\":2,\"numero_revision\":1,\"es_correccion\":\"no\",\"observaciones\":\"Es una prueba de asignaci\\u00f3n de inspector\"}}', NULL, '2024-10-09 23:49:25', '2024-10-09 23:49:25'),
(70, 'lotesgranel', 'El usuario Administrador CIDAM2 actualizó un registro de lotes a granel el 09/10/2024', 'App\\Models\\LotesGranel', 'updated', 87, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":80,\"nombre_lote\":\"chelo granel\",\"tipo_lote\":2,\"folio_fq\":\"Sin FQ\",\"volumen\":1566,\"cont_alc\":2000,\"id_categoria\":1,\"id_clase\":1,\"id_tipo\":1,\"ingredientes\":\"sin ingredientes\",\"edad\":\"sin edad\",\"id_guia\":null,\"folio_certificado\":\"fl-15\",\"id_organismo\":null,\"fecha_emision\":\"2024-09-01\",\"fecha_vigencia\":\"2024-09-02\",\"estatus\":\"Activo\",\"lote_original_id\":null},\"old\":{\"id_empresa\":80,\"nombre_lote\":\"chelo granel\",\"tipo_lote\":2,\"folio_fq\":\"Sin FQ\",\"volumen\":5000,\"cont_alc\":2000,\"id_categoria\":1,\"id_clase\":1,\"id_tipo\":1,\"ingredientes\":\"sin ingredientes\",\"edad\":\"sin edad\",\"id_guia\":null,\"folio_certificado\":\"fl-15\",\"id_organismo\":null,\"fecha_emision\":\"2024-09-01\",\"fecha_vigencia\":\"2024-09-02\",\"estatus\":\"Activo\",\"lote_original_id\":null}}', NULL, '2024-10-10 00:00:27', '2024-10-10 00:00:27'),
(71, 'lotesgranel', 'El usuario Administrador CIDAM2 creó un registro de lotes a granel el 09/10/2024', 'App\\Models\\LotesGranel', 'created', 89, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":1,\"nombre_lote\":\"35354\",\"tipo_lote\":1,\"folio_fq\":\"Sin FQ\",\"volumen\":3434,\"cont_alc\":3434,\"id_categoria\":1,\"id_clase\":1,\"id_tipo\":1,\"ingredientes\":\"4545\",\"edad\":\"4545\",\"id_guia\":null,\"folio_certificado\":null,\"id_organismo\":null,\"fecha_emision\":null,\"fecha_vigencia\":null,\"estatus\":\"Activo\",\"lote_original_id\":87}}', NULL, '2024-10-10 00:00:27', '2024-10-10 00:00:27'),
(72, 'revisor', 'El usuario Eva Viviana Soto Barrietos actualizó un registro de Revisor el 14/10/2024', 'App\\Models\\Revisor', 'updated', 2, 'App\\Models\\User', 20, '{\"attributes\":{\"tipo_revision\":2,\"id_revisor\":20,\"id_revisor2\":26,\"id_certificado\":2,\"numero_revision\":1,\"es_correccion\":\"no\",\"observaciones\":\"\"},\"old\":{\"tipo_revision\":2,\"id_revisor\":null,\"id_revisor2\":26,\"id_certificado\":2,\"numero_revision\":1,\"es_correccion\":\"no\",\"observaciones\":\"Es una prueba de asignaci\\u00f3n de inspector\"}}', NULL, '2024-10-14 22:53:51', '2024-10-14 22:53:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('0a1eb97fdac342b99855823da06faa19', 'i:1;', 1728946414),
('0a1eb97fdac342b99855823da06faa19:timer', 'i:1728946414;', 1728946414),
('385be68248373048043127118d6ac36e', 'i:1;', 1728590208),
('385be68248373048043127118d6ac36e:timer', 'i:1728590208;', 1728590208),
('4098a8625ee3d780b162089970c52c26', 'i:1;', 1726775447),
('4098a8625ee3d780b162089970c52c26:timer', 'i:1726775447;', 1726775447),
('594a328cc8bf6717499389a4726333ed', 'i:1;', 1728425927),
('594a328cc8bf6717499389a4726333ed:timer', 'i:1728425927;', 1728425927),
('72c943604f1c6eab0cfe7e1708538b8a', 'i:1;', 1728425266),
('72c943604f1c6eab0cfe7e1708538b8a:timer', 'i:1728425266;', 1728425266),
('81e272d698ae4689d9efd072fc9f1ab8', 'i:1;', 1729005174),
('81e272d698ae4689d9efd072fc9f1ab8:timer', 'i:1729005174;', 1729005174),
('admin@argon.com|127.0.0.1', 'i:1;', 1728946415),
('admin@argon.com|127.0.0.1:timer', 'i:1728946415;', 1728946415),
('fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b', 'i:1;', 1726775770),
('fa35e192121eabf3dabf9f5ea6abdbcbc107ac3b:timer', 'i:1726775770;', 1726775770);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_actividad_cliente`
--

CREATE TABLE `catalogo_actividad_cliente` (
  `id_actividad` int(11) NOT NULL,
  `actividad` varchar(100) NOT NULL,
  `id_norma` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_actividad_cliente`
--

INSERT INTO `catalogo_actividad_cliente` (`id_actividad`, `actividad`, `id_norma`, `created_at`, `updated_at`) VALUES
(1, 'Productor de Agave', 1, '2024-06-28 23:15:12', '2024-06-28 23:15:12'),
(2, 'Productor de Mezcal', 1, '2024-06-28 23:15:12', '2024-06-28 23:15:12'),
(3, 'Envasador de Mezcal', 1, '2024-06-28 23:15:45', '2024-06-28 23:15:45'),
(4, 'Comercializador de Mezcal', 1, '2024-06-28 23:15:45', '2024-06-28 23:15:45'),
(5, 'Productor de bebidas alcohólicas que contienen Mezcal', 2, '2024-07-01 22:29:02', '2024-07-01 22:29:02'),
(6, 'Envasador de bebidas alcohólicas que contienen Mezcal', 2, '2024-07-01 22:34:02', '2024-07-01 22:34:02'),
(7, 'Comercializador de bebidas alcohólicas que contienen Mezcal\r\n', 2, '2024-07-02 17:13:14', '2024-07-02 17:13:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_categorias`
--

CREATE TABLE `catalogo_categorias` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_categorias`
--

INSERT INTO `catalogo_categorias` (`id_categoria`, `categoria`, `created_at`, `updated_at`) VALUES
(1, 'Mezcal', '2024-07-09 22:58:30', '2024-07-13 07:00:03'),
(2, 'Mezcal artesanal', '2024-10-07 17:17:51', '2024-10-07 17:17:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_clases`
--

CREATE TABLE `catalogo_clases` (
  `id_clase` int(11) NOT NULL,
  `clase` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_clases`
--

INSERT INTO `catalogo_clases` (`id_clase`, `clase`, `created_at`, `updated_at`) VALUES
(1, 'Blanco o Joven', '2024-07-09 19:18:03', '2024-07-09 19:18:03'),
(2, 'Reposado', '2024-07-09 19:18:15', '2024-07-09 19:18:15'),
(3, 'Añejo', '2024-07-09 19:18:15', '2024-07-09 19:18:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_equipos`
--

CREATE TABLE `catalogo_equipos` (
  `id_equipo` int(11) NOT NULL,
  `equipo` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_equipos`
--

INSERT INTO `catalogo_equipos` (`id_equipo`, `equipo`, `created_at`, `updated_at`) VALUES
(1, 'Horno', '2024-09-06 18:06:29', '2024-09-06 18:06:29'),
(2, 'chano', '2024-10-02 18:13:21', '2024-10-02 18:13:21'),
(3, 'chelo2', '2024-10-02 18:13:21', '2024-10-02 18:13:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_norma_certificar`
--

CREATE TABLE `catalogo_norma_certificar` (
  `id_norma` int(11) NOT NULL,
  `norma` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_norma_certificar`
--

INSERT INTO `catalogo_norma_certificar` (`id_norma`, `norma`, `created_at`, `updated_at`) VALUES
(1, 'NOM-070-SCFI-2016', '2024-06-28 23:18:48', '2024-06-28 23:18:48'),
(2, 'NMX-V-052-NORMEX-2016', '2024-06-28 23:19:52', '2024-06-28 23:19:52'),
(3, 'NOM-251-SSA1-2009', '2024-06-28 23:20:01', '2024-06-28 23:20:01'),
(4, 'NOM-199-SCFI-2017', '2024-07-16 19:54:01', '2024-07-16 19:54:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_organismos`
--

CREATE TABLE `catalogo_organismos` (
  `id_organismo` int(11) NOT NULL,
  `organismo` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_organismos`
--

INSERT INTO `catalogo_organismos` (`id_organismo`, `organismo`, `created_at`, `updated_at`) VALUES
(1, 'Verificación y Certificación PAMFA A.C', '2024-07-22 16:48:56', '2024-07-22 16:48:56'),
(2, 'Consejo Mexicano Regulador de la Calidad del Mezcal A.C.', '2024-07-22 18:08:18', '2024-07-22 18:08:18'),
(3, 'Asociación de Maguey y Mezcal Artesanal A.C.', '2024-07-22 18:08:29', '2024-07-22 18:08:29'),
(4, 'Certificación Mexicana S.C.', '2024-07-22 18:08:35', '2024-07-22 18:08:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_producto_certificar`
--

CREATE TABLE `catalogo_producto_certificar` (
  `id_producto` int(11) NOT NULL,
  `producto` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_producto_certificar`
--

INSERT INTO `catalogo_producto_certificar` (`id_producto`, `producto`, `created_at`, `updated_at`) VALUES
(1, 'Mezcal', '2024-06-28 23:24:58', '2024-06-28 23:24:58'),
(2, 'Bebida alcohólica preparada que contiene', '2024-06-28 23:24:58', '2024-06-28 23:24:58'),
(3, 'Cóctel que contiene Mezcal', '2024-06-28 23:25:15', '2024-06-28 23:25:15'),
(4, 'Licor y/o crema que contiene Mezcal', '2024-06-28 23:25:29', '2024-06-28 23:25:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_tipo_agave`
--

CREATE TABLE `catalogo_tipo_agave` (
  `id_tipo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cientifico` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_tipo_agave`
--

INSERT INTO `catalogo_tipo_agave` (`id_tipo`, `nombre`, `cientifico`, `created_at`, `updated_at`) VALUES
(1, 'Maguey Cuishe', 'A. karwinskii', '2024-07-10 17:42:45', '2024-07-10 17:42:45'),
(2, 'Maguey Chino', '(A. cupreata)', '2024-08-20 00:48:06', '2024-08-20 00:48:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados`
--

CREATE TABLE `certificados` (
  `id_certificado` int(11) NOT NULL,
  `id_dictamen` int(11) NOT NULL,
  `id_firmante` int(11) NOT NULL,
  `num_certificado` varchar(25) NOT NULL,
  `fecha_vigencia` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `maestro_mezcalero` varchar(60) DEFAULT NULL,
  `num_autorizacion` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL,
  `observaciones` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certificados`
--

INSERT INTO `certificados` (`id_certificado`, `id_dictamen`, `id_firmante`, `num_certificado`, `fecha_vigencia`, `fecha_vencimiento`, `maestro_mezcalero`, `num_autorizacion`, `estatus`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 1, 14, 'cert0001', '2024-10-08', '2025-10-08', 'Juan perez', 34234, 1, 'porque salio mal', '2024-10-08 22:32:53', '2024-10-08 22:34:13'),
(2, 2, 19, 'cert0001', '2024-10-08', '2025-10-08', 'Juan perez', 34234, 2, NULL, '2024-10-08 22:34:13', '2024-10-08 22:34:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados_revision`
--

CREATE TABLE `certificados_revision` (
  `id_revision` int(11) NOT NULL,
  `tipo_revision` int(11) NOT NULL COMMENT '1. Personal 2.  Miembro ',
  `id_revisor` int(11) DEFAULT NULL,
  `id_revisor2` int(11) DEFAULT NULL,
  `id_certificado` int(11) DEFAULT NULL,
  `numero_revision` int(11) NOT NULL COMMENT '1. Primera revisión 2. Segunda revisión',
  `es_correccion` char(2) DEFAULT '0',
  `observaciones` text DEFAULT NULL,
  `respuestas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`respuestas`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certificados_revision`
--

INSERT INTO `certificados_revision` (`id_revision`, `tipo_revision`, `id_revisor`, `id_revisor2`, `id_certificado`, `numero_revision`, `es_correccion`, `observaciones`, `respuestas`, `created_at`, `updated_at`) VALUES
(1, 1, 18, 26, 1, 1, 'no', '', '', '2024-10-02 23:05:31', '2024-10-02 23:05:43'),
(2, 2, 20, 26, 2, 1, 'no', '', '', '2024-10-09 23:49:25', '2024-10-14 22:53:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dictamenes_envasado`
--

CREATE TABLE `dictamenes_envasado` (
  `id_dictamen_envasado` int(11) NOT NULL,
  `num_dictamen` varchar(40) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_inspeccion` int(11) NOT NULL,
  `id_lote_envasado` int(11) NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vigencia` date NOT NULL,
  `fecha_servicio` date NOT NULL,
  `estatus` varchar(30) NOT NULL DEFAULT 'Emitido',
  `observaciones` varchar(250) DEFAULT NULL,
  `id_firmante` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dictamenes_envasado`
--

INSERT INTO `dictamenes_envasado` (`id_dictamen_envasado`, `num_dictamen`, `id_empresa`, `id_inspeccion`, `id_lote_envasado`, `fecha_emision`, `fecha_vigencia`, `fecha_servicio`, `estatus`, `observaciones`, `id_firmante`, `created_at`, `updated_at`) VALUES
(5, 'NUM-05-45', 1, 4, 1, '2024-09-12', '2024-09-12', '2024-09-12', 'Cancelado', 'por falta de documentacion equisde no se', 21, '2024-09-13 01:20:15', '2024-10-02 23:24:51'),
(7, 'NUM-05-35', 79, 4, 12, '2024-09-11', '2024-09-11', '2024-09-26', 'Emitido', 'por falta de documentacion equisde no se', 14, '2024-09-13 03:55:26', '2024-09-13 03:58:19'),
(9, '25', 79, 4, 13, '2024-08-29', '2024-09-11', '2024-09-18', 'Emitido', NULL, 21, '2024-09-17 22:19:40', '2024-09-17 22:19:40'),
(12, 'DICT-0001-2024', 1, 4, 1, '2024-09-11', '2024-09-11', '2024-09-10', 'Emitido', NULL, 14, '2024-09-18 16:42:27', '2024-09-18 16:42:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dictamenes_granel`
--

CREATE TABLE `dictamenes_granel` (
  `id_dictamen` int(11) NOT NULL,
  `num_dictamen` varchar(40) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_inspeccion` int(11) NOT NULL,
  `id_lote_granel` int(11) NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vigencia` date NOT NULL,
  `fecha_servicio` date NOT NULL,
  `estatus` varchar(40) NOT NULL DEFAULT 'Emitido',
  `observaciones` varchar(2000) DEFAULT NULL,
  `id_firmante` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dictamenes_granel`
--

INSERT INTO `dictamenes_granel` (`id_dictamen`, `num_dictamen`, `id_empresa`, `id_inspeccion`, `id_lote_granel`, `fecha_emision`, `fecha_vigencia`, `fecha_servicio`, `estatus`, `observaciones`, `id_firmante`, `created_at`, `updated_at`) VALUES
(1, '0001', 1, 4, 1, '2024-09-03', '2024-09-04', '2024-09-05', 'Cancelado', 'Solo cancelar para prueba', '14', '2024-09-04 05:00:27', '2024-09-06 04:19:22'),
(2, '5854', 1, 4, 1, '2024-09-18', '2024-09-12', '2024-09-11', 'Cancelado', 'Cambió la vigencia', '14', '2024-09-07 01:06:17', '2024-09-07 01:07:31'),
(3, '5854', 1, 4, 1, '2024-09-07', '2024-09-06', '2024-09-11', 'Emitido', 'Cambió la vigencia', '14', '2024-09-07 01:07:31', '2024-09-07 01:07:31'),
(4, 'e545', 1, 4, 1, '2024-09-10', '2024-09-10', '2024-09-10', 'Emitido', NULL, '14', '2024-09-13 23:40:12', '2024-09-13 23:40:12'),
(5, '3434343', 1, 6, 1, '2024-09-03', '2024-09-03', '2024-09-11', 'Emitido', NULL, '21', '2024-09-13 23:45:36', '2024-09-13 23:45:36'),
(6, '24343', 1, 6, 1, '2024-09-10', '2024-09-10', '2024-09-17', 'Emitido', NULL, '14', '2024-09-13 23:47:55', '2024-09-13 23:47:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dictamenes_instalaciones`
--

CREATE TABLE `dictamenes_instalaciones` (
  `id_dictamen` int(11) NOT NULL,
  `id_inspeccion` int(11) NOT NULL,
  `tipo_dictamen` int(11) NOT NULL,
  `id_instalacion` int(11) NOT NULL,
  `num_dictamen` varchar(30) NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vigencia` date NOT NULL,
  `categorias` varchar(200) NOT NULL,
  `clases` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dictamenes_instalaciones`
--

INSERT INTO `dictamenes_instalaciones` (`id_dictamen`, `id_inspeccion`, `tipo_dictamen`, `id_instalacion`, `num_dictamen`, `fecha_emision`, `fecha_vigencia`, `categorias`, `clases`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1, '01', '2024-09-19', '2025-09-18', '[\"Reposado\"]', '[\"A\\u00f1ejo\"]', '2024-09-13 23:13:15', '2024-09-13 23:13:15'),
(2, 6, 1, 7, '01343', '2024-09-19', '2025-09-18', '[\"Reposado\"]', '[\"A\\u00f1ejo\"]', '2024-09-13 23:14:01', '2024-09-13 23:14:01'),
(3, 6, 1, 7, '01343', '2024-09-19', '2025-09-18', '[\"Reposado\"]', '[\"A\\u00f1ejo\"]', '2024-09-13 23:14:29', '2024-09-13 23:14:29'),
(4, 6, 1, 7, '01343', '2024-09-19', '2025-09-18', '[\"Reposado\"]', '[\"A\\u00f1ejo\"]', '2024-09-13 23:15:09', '2024-09-13 23:15:09'),
(5, 6, 5, 7, '45454', '2024-09-17', '2025-09-16', '[\"Reposado\"]', '[\"A\\u00f1ejo\"]', '2024-09-13 23:15:36', '2024-09-13 23:15:36'),
(6, 6, 5, 7, '45454', '2024-09-17', '2025-09-16', '[\"Reposado\"]', '[\"A\\u00f1ejo\"]', '2024-09-13 23:17:44', '2024-09-13 23:17:44'),
(7, 6, 3, 7, '5y65656', '2024-09-17', '2025-09-16', '[\"Reposado\"]', '[\"Reposado\"]', '2024-09-13 23:19:57', '2024-09-13 23:19:57'),
(8, 4, 3, 1, '434', '2024-09-24', '2025-09-23', '[\"Reposado\"]', '[\"Reposado\"]', '2024-09-13 23:20:28', '2024-09-13 23:20:28'),
(9, 4, 3, 1, '434', '2024-09-24', '2025-09-23', '[\"Reposado\"]', '[\"Reposado\"]', '2024-09-13 23:21:33', '2024-09-13 23:21:33'),
(10, 4, 3, 1, '434', '2024-09-24', '2025-09-23', '[\"Reposado\"]', '[\"Reposado\"]', '2024-09-13 23:24:29', '2024-09-13 23:24:29'),
(11, 4, 3, 1, '434', '2024-09-24', '2025-09-23', '[\"Reposado\"]', '[\"Reposado\"]', '2024-09-13 23:25:24', '2024-09-13 23:25:24'),
(12, 4, 3, 1, 'swdsd', '2024-09-15', '2025-09-14', '[\"Reposado\"]', '[\"Reposado\"]', '2024-09-13 23:32:06', '2024-09-13 23:32:06'),
(13, 4, 3, 1, '3434', '2024-09-10', '2025-09-09', '[\"Blanco o Joven\"]', '[\"Reposado\"]', '2024-09-13 23:32:43', '2024-09-13 23:32:43'),
(14, 4, 3, 1, '3434', '2024-09-10', '2025-09-09', '[\"Blanco o Joven\"]', '[\"Reposado\"]', '2024-09-13 23:37:09', '2024-09-13 23:37:09'),
(15, 6, 4, 7, '3434', '2024-09-10', '2025-09-09', '[\"Blanco o Joven\",\"Reposado\"]', '[\"Reposado\"]', '2024-09-13 23:40:29', '2024-09-13 23:40:29'),
(16, 6, 4, 7, '3434', '2024-09-10', '2025-09-09', '[\"Blanco o Joven\",\"Reposado\"]', '[\"Reposado\"]', '2024-09-13 23:40:47', '2024-09-13 23:40:47'),
(17, 6, 3, 7, '343', '2024-09-18', '2025-09-17', '[\"Reposado\"]', '[\"Reposado\"]', '2024-09-13 23:47:16', '2024-09-13 23:47:16'),
(18, 4, 1, 1, '5y65656', '2024-10-02', '2025-10-01', '[\"Blanco o Joven\"]', '[\"Reposado\"]', '2024-10-02 22:08:10', '2024-10-02 22:08:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_direccion` int(11) NOT NULL,
  `tipo_direccion` int(11) NOT NULL COMMENT '1. Exportación - 2 venta nacional 3 hologramas',
  `id_empresa` int(11) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `destinatario` varchar(100) DEFAULT NULL,
  `aduana` varchar(150) DEFAULT NULL,
  `pais_destino` varchar(60) DEFAULT NULL,
  `nombre_recibe` varchar(60) DEFAULT NULL,
  `correo_recibe` varchar(30) DEFAULT NULL,
  `celular_recibe` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id_direccion`, `tipo_direccion`, `id_empresa`, `direccion`, `destinatario`, `aduana`, `pais_destino`, `nombre_recibe`, `correo_recibe`, `celular_recibe`, `created_at`, `updated_at`) VALUES
(777, 1, 80, 'Nogales Arizona 85621, USA', 'sergio eduardo casarrubias herrera', 'México', 'USA', NULL, NULL, NULL, '2024-08-26 01:23:53', '2024-08-27 22:55:37'),
(778, 2, 84, 'Rúa Alonso, 66, 00º E', NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-26 01:24:41', '2024-08-27 22:59:30'),
(780, 1, 86, '3154 Hartmann Forges Apt. 921', 'juan carlos zarco de la torre', 'México', 'USA', NULL, NULL, NULL, '2024-08-26 23:34:52', '2024-08-27 22:58:27'),
(781, 2, 85, 'Praza Luis, 19, 57º A', NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 21:34:02', '2024-08-27 22:59:18'),
(782, 1, 3, 'VENUSTIANO CARRANZA AV. CAPITÁN CARLOS LEÓN SN 2N E, OF 11 C.P. 15520 PEÑÓN DE LOS BAÑOS, CIUDAD DE MÉXICO.', 'DUFRY MÉXICO, S.A. DE C.V.', 'AEROPUERTO INTERNACIONAL DE LA CIUDAD DE MÉXICO2', 'MÉXICO', NULL, NULL, NULL, '2024-08-28 23:45:07', '2024-08-29 01:36:08'),
(783, 3, 3, 'Av. Miguel Angel De Quevedo no. 687, Ciudad de México C.P.04320. Col. San Francisco, Delegación Coyoacán', NULL, NULL, NULL, 'IVAN DE JESUS HERNANDEZ RIVERA', 'pcervantes@cuervo.com.mx', '3312981296', '2024-08-29 01:39:09', '2024-08-29 01:39:09'),
(784, 1, 3, 'SINGAPORE WINE VAUL PTE LTD 6 FISHERY PORT ROAD, LEVEL 6 SINGAPUR 619747 SINGAPUR', 'SINGAPORE WINE VAUL PTE LTD', 'MANZANILLO, COLIMA', 'SINGAPUR', NULL, NULL, NULL, '2024-09-03 23:59:19', '2024-09-04 00:00:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacion`
--

CREATE TABLE `documentacion` (
  `id_documento` int(11) NOT NULL,
  `nombre` varchar(280) NOT NULL,
  `tipo` varchar(150) NOT NULL,
  `subtipo` varchar(50) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `documentacion`
--

INSERT INTO `documentacion` (`id_documento`, `nombre`, `tipo`, `subtipo`, `orden`) VALUES
(1, 'Acta constitutiva (Copia simple)', 'Documentos generales', 'Todas', 0),
(2, 'Poder notarial del representante legal (Solo en caso de no estar incluido en el acta constitutiva)', 'Documentos generales', 'Todas', 0),
(3, 'Copia de identificacion oficial del Titular (encaso de ser persona física) o representante legal (en caso de ser persona moral).', 'Documentos generales', 'Todas', 1),
(4, 'Comprobante del domicilio fiscal', 'Documentos generales', 'Todas', 0),
(5, 'Contrato de prestación de servicios (Proporcionado por el OCP del CIDAM)', 'Documentos generales', 'Todas', 2),
(6, 'Comprobante del domicilio (Unidad de producción, envasado o comercialización, almacén\r\n', 'Documentos generales', 'Todas', 0),
(7, 'Certificado vigente que demuestre el cumplimiento con su respectiva norma', 'Bebidas alcóholicas nacionales con denominación de origen que cuenten con persona acreditada y aprobada', 'Denominación de origen', 0),
(8, 'Revisión de la etiqueta mediante NOM-142-SSA1/SCFI-2014 y la NOM-|99-SCFI-2017', 'Bebidas alcóholicas nacionales con denominación de origen que cuenten con persona acreditada y aprobada', 'Denominación de origen', 0),
(9, 'Carta del fabricante', 'Bebidas Alcohólicas importada reconocida como indicación geográfica o producto distintivo', 'Importador', 0),
(10, 'Certificado de libre venta (Certificado o documento emitido por la autoridad competente que cumple con las especificaciones del país de origen según su legislación)', 'Bebidas Alcohólicas importada reconocida como indicación geográfica o producto distintivo', 'Importador', 0),
(11, 'Informe de resultados emitido por el laboratorio Acreditado y aprobado', 'Bebidas Alcohólicas importada reconocida como indicación geográfica o producto distintivo', 'ImportadorNO', 0),
(12, 'Revisión de la etiqueta mediante NOM-142-SSA1/SCFI-2014 y la NOM-|99-SCFI-2017', 'Bebidas Alcohólicas importada reconocida como indicación geográfica o producto distintivo', 'ImportadorNO', 0),
(13, 'Declaración de la conformidad emitido por la unidad de verificación, incluyendo el reporte de descripción general del producto y marca comercial o marca registrada/titulo marcario', 'Bebidas alcohólicas fermentadas', 'Fermentadas', 0),
(14, 'Informe de resultados emitido por ellaboratorio Acreditado y aprobado', 'Bebidas alcohólicas fermentadas', 'Fermentadas', 0),
(15, 'Aprobación e la etiqueta mediante NOM-142-SSA1/SCFI-2014 y la NOM-199-SCFI-2017', 'Bebidas alcohólicas fermentadas', 'Fermentadas', 0),
(16, 'Carta del fabricante', 'Para bebida alcohólica fermentada importada', 'Fermentadas-Importador', 0),
(17, 'Declaración de la conformidad emitido por la unidad de verificación, incluyendo el reporte de descripción general del producto y marca comercial o marca registrada/titulo marcario', 'Bebida alcohólica destilada', 'Destiladas', 0),
(18, 'Informe de resultados emitido por ellaboratorio Acreditado y aprobado', 'Bebida alcohólica destilada', 'Destiladas', 0),
(19, 'Aprobación e la etiqueta mediante NOM-142-SSA1/SCFI-2014 y la NOM-199-SCFI-2017', 'Bebida alcohólica destilada', 'Destiladas', 0),
(20, 'Dictamen técnico y autenticidad de la bebida emitido por la unidad de Verificación', 'Bebida alcohólica destilada', 'Destiladas', 0),
(21, 'Una copia del certificado (Que incluya la linea de producción)', 'Cuando se solicita la certificación mediante sistema de calidad', 'Destiladas-Calidad', 0),
(22, 'Carta del fabricante', 'Para el caso de bebida alcohólica destiladas importadas', 'Destiladas-Importador', 0),
(23, 'Certificado de libre venta (Certificado o documento emitido por la autoridad competente que cumple con las especificaciones del país de origen según su legislación)', 'Para el caso de bebida alcohólica destiladas importadas', 'Destiladas-Importador', 0),
(24, 'Traducción simple del certificado de libre venta (Si se presenta en otro idioma)', 'Para el caso de bebida alcohólica destiladas importadas', 'Destiladas-Importador', 0),
(25, 'Declaración de la conformidad emitido por la unidad de verificación, incluyendo el reporte de descripción general del producto y marca comercial o marca registrada/titulo marcario', 'Licores o cremas, cocteles, bebidas alcohólicas preparadas', 'Licores', 0),
(26, 'Informe de resultados emitido por el laboratorio Acreditado y aprobado', 'Licores o cremas, cocteles, bebidas alcohólicas preparadasa', 'Licores', 0),
(27, 'Aprobación e la etiqueta mediante NOM-142-SSA1/SCFI-2014 y la NOM-199-SCFI-2017', 'Licores o cremas, cocteles, bebidas alcohólicas preparadas', 'Licores', 0),
(28, 'Dictamen técnico y autenticidad de la bebida emitido por la unidad de Verificación', 'Licores o cremas, cocteles, bebidas alcohólicas preparadas', 'Licores', 0),
(29, 'Una copia del certificado (Que incluya la linea de producción)', 'Cuando se solicita la certificación mediante sistema de calidad', 'Licores-Calidad', 0),
(30, 'Carta del fabricante', 'Para el caso de bebida alcohólica destiladas importadas', 'Licores-Importador', 0),
(31, 'Certificado de libre venta (Certificado o documento emitido por la autoridad competente que cumple con las especificaciones del país de origen según su legislación)', 'Para el caso de bebida alcohólica destiladas importadas', 'Licores-Importador', 0),
(32, 'Traducción simple del certificado de libre venta (Si se presenta en otro idioma)', 'Para el caso de licores, cocteles,bebidas alcohólicas preparadas importadas', 'Licores-Importador', 0),
(33, 'Carta de designación de persona autorizada para realizar los trámites.', 'Documentos Generales', 'Todas', 0),
(34, 'Contrato de arrendamiento del terreno o copias de escrituras', 'Generales Productor', 'Generales Productor', 0),
(35, 'Copia de la identificación oficial vigente del arrendador y arrendatario (En caso de no ser propietario de las instalaciones)', 'Generales Productor', 'Generales Productor', 0),
(36, 'Formato 32-D Opinión de cumplimiento de obligaciones fiscales del SAT', 'Generales Comercializador', 'Generales Comercializador', 0),
(37, 'Juegos de etiquetas o constancia de cumplimiento emitida por la unidad de verificación titulo de la marca', 'Generales Comercializador', 'Generales Comercializador', 0),
(38, 'Comprobante de trámite de marca (En caso de que su marca este en trámite)', 'Marcas', 'Generales Comercializador', 0),
(39, 'Carta responsiva de trámite (En caso de que su marca este en trámite)', 'Marcas', 'Generales Comercializador', 0),
(40, 'Licencia de uso o cesión de derechos (En caso de no ser propietario de la marca)', 'Marcas', 'Generales Comercializador', 0),
(41, 'Evidencia del vinculo entre productor y/o envasador (contrato de maquila o convenio de corresponsabilidad siempre y cuando mencione el envasado)', 'Generales Comercializador', 'Generales Comercializador', 0),
(42, 'Comprobante de domicilio fiscal ', 'Generales Envasador', 'Generales Envasador', 0),
(43, 'Plano de distribución', 'Generales Envasador', 'Generales Envasador', 0),
(44, 'Identificación oficial del Responsable de la instalación', 'Generales Envasador', 'Generales Envasador', 0),
(45, 'Comprobante de posesión de las instalaciones (si es propietario, este documento debe estar a nombre de la persona física o moral) o contrato de arrendamiento o comodato', 'Generales Envasador', 'Generales Envasador', 0),
(46, 'Copia de identificación oficial del arrendador y arrendatario (en caso de no ser propietario).', 'Generales Envasador', 'Generales Envasador', 0),
(47, 'Dictámenes', 'Documentos generales', 'Todas', 0),
(48, 'Copia de los análisis de laboratorio de cada uno de los lotes', 'Solicitud', 'Hologramas', 0),
(49, 'Constancia de cumplimiento de la etiqueta emitida por UV acreditada en información comercial.', 'Solicitud', 'Hologramas', 0),
(50, 'En caso de vigilancia en producto envasado, adjuntar certificado NOM a granel y certificado de envasado.', 'Solicitud', 'Hologramas', 0),
(51, 'Comprobante de pago', 'Todas', 'Solicitudes', 0),
(52, 'Documento de No. de guía', 'Todas', 'Hologramas', 0),
(53, 'Comprobante de recibido', 'Todas', 'Holograma', 0),
(54, 'Comprobante de mermas', 'Hologramas', 'Mermas', 0),
(55, 'Factura proforma', 'Certificados / dictámenes', 'Exportación', 0),
(56, 'Fisicoquímicos', 'Certificados / dictámenes', 'Exportación', 0),
(57, 'Etiquetas', 'Certificados / dictámenes', 'Exportación', 0),
(58, 'Análisis fisicoquímicos', 'Solicitud general', 'Servicios', 0),
(59, 'Certificado de lote a granel', 'Solicitud general', 'Servicios', 0),
(60, 'Etiquetas', 'Solicitud general', 'Servicios', 0),
(61, 'Factura proforma', 'Solicitud general', 'Certificados', 0),
(62, 'Constancia de inscripción al Padrón de Bebidas Alcohólicas', 'Generales Comercializador', 'Generales Comercializador', 0),
(63, 'Constancia de alta o inscripción en el Padrón de Exportadores Sectorial del SAT (en caso de ser exportador', 'Generales Comercializador', 'Generales Comercializador', 0),
(65, 'Identificación Oficial del Responsable de la Instalación. ', 'Generales Comercializador', 'Generales Comercializador', 0),
(66, 'Comprobante de posesión (si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento o comodato', 'Generales Comercializador', 'Generales Comercializador', 0),
(67, 'Identificación oficial del arrendador y arrendatario (en el caso de no ser propietario).', 'Generales Comercializador', 'Generales Comercializador', 0),
(68, 'INE de la persona autorizada para realizar trámites.', 'Generales Productor', 'Generales Productor8273', 0),
(69, 'Acta de inspección', 'Predio', 'Inspeccion', 0),
(70, 'Fotografías', 'Predio', 'Inspeccion', 0),
(71, 'Guía de traslado de agave', 'Solicitud general', 'Servicios', 0),
(72, 'Mapa (Predio) ', 'Georreferenciacion', 'Gerente', 0),
(73, 'Evidencias', 'Georreferenciacion', 'Gerente', 0),
(74, 'Dictamen firmado y sellado', 'Solicitudes', 'Dictamen', 0),
(75, 'Corrugado', 'Solicitud general', 'Certificados', 0),
(76, 'Constancia de situación fiscal ', 'Documentos generales', 'Todas', 0),
(77, 'Carta de asignación de número de cliente', 'Documentos generales', 'Todas', 0),
(78, 'Solicitud de información al cliente', 'Documentos generales', 'Todas', 0),
(79, 'Copia de identificación oficial vigente de la persona autorizada', 'Documentos generales', 'Todas', 0),
(80, 'Autorización del uso de la DOM ', 'Generales Envasador', 'Generales Productor1111', 0),
(81, 'Registro COFEPRIS', 'Generales Comercializador', 'Generales Comercializador', 0),
(82, 'Convenio de corresponsabilidad inscrito ante el IMPI entre el comercializador y un productor autorizado', 'Marcas', 'Generales Comercializador', 0),
(83, 'Autorización del uso de la Denominación de Origen Mezcal (DOM)', 'Generales Productor', 'Generales Productor Mezcal', 0),
(84, 'Plan orgánico conforme a la actividad agropecuaria que desarrolla.', 'Documentacion organico', 'Solicitud', 0),
(85, 'Historial de campo', 'Documentacion organico', 'Solicitud', 0),
(86, 'Reglamento Interno de Producción Orgánica para grupos de productores en caso de grupos de productores cumpliendo los requisitos mínimos establecidos en el presente Acuerdo.', 'Documentacion organico', 'Solicitud', 0),
(87, 'Copia del certificado anterior, si es una ampliación de la certificación', 'Documentacion organico', 'Solicitud', 0),
(88, 'Carta Compromiso, por parte del Operador para llevar a cabo las operaciones de conformidad con las regulaciones vigentes establecidas.', 'Documentacion organico', 'Solicitud', 0),
(89, 'Mapas de todas las parcelas y|o áreas incluidas en la unidad productiva.', 'Documentacion organico', 'Solicitud', 0),
(90, 'Fotos etiquetas', 'Revisión', 'Etiquetas', 0),
(91, 'Copia del certificado actual de la certificación orgánica aplicable al cultivo o producto', 'Documentacion organico', 'Recertificación', 0),
(92, 'Carta de certificación anterior o documento que contiene los requisitos, recomendaciones y/o condiciones', 'Documentacion organico', 'Recertificación', 0),
(93, 'Cuestionarios pertinentes a la certificación del cultivo o producto', 'Documentacion organico', 'Recertificación', 0),
(94, 'Informe de inspección en sitio(s)', 'Documentacion organico', 'Recertificación', 0),
(95, 'Historial de campo para los últimos 36 meses a partir de la fecha de la cosecha en que se recogió del sitio', 'Documentacion organico', 'Recertificación', 0),
(96, 'Mapas de campo para los últimos 36 meses a partir de la fecha de la cosecha e identificar el campo de la producción para el lote en cuestión\r\n', 'Documentacion organico', 'Recertificación', 0),
(97, 'Documentación que demuestre el tamaño el tamaño de la zona búfer entre la Producción Orgánica y la no orgánica\r\n', 'Documentacion organico', 'Recertificación', 0),
(98, 'Si la zona buffers son cosechadas, muestra de la documentación que compruebe la segregación de los cultivos orgánicos y de la zona de amortiguamiento', 'Documentacion organico', 'Recertificación', 0),
(99, ' La verificación de que el inspector es independiente de la operación y no tiene vínculos financieros con el solicitante. (Una declaración jurada es suficiente).', 'Documentacion organico', 'Recertificación', 0),
(100, 'Cantidad del cultivo o producto a ser aprobado', 'Documentacion organico', 'Recertificación', 0),
(101, ' Auditoría de seguimiento documental y comprobar cómo es manejado la segregación de los productos.', 'Documentacion organico', 'Recertificación', 0),
(102, 'Documentación relativa a la ubicación de lugar de almacenamiento de la cosecha o del producto', 'Documentacion organico', 'Recertificación', 0),
(103, 'Una descripción del Sistema de Control Interno (Si forma parte de un grupo de operadores)', 'Documentacion organico', 'Recertificación', 0),
(104, 'La documentación de los reglamentos internos(Si forma parte de un grupo de operadores)', 'Documentacion organico', 'Recertificación', 0),
(105, 'Comprobante de domicilio fiscal', 'Generales Productor', 'Generales Productor Mezcal', 0),
(106, 'Plano de distribución', 'Generales Productor', 'Generales Productor Mezcal', 0),
(107, 'Título de la marca (en caso de ser el propietario, este documento debe estar a nombre de la persona física o moral que se inscribe)', 'Marcas', 'Generales Comercializador', 0),
(108, 'CURP (en caso de ser persona física).\n', 'Generales Productor', 'Generales Productor', 0),
(109, 'INE del responsable de instalaciones', 'Generales Productor', 'Generales Productor', 0),
(110, 'INE del responsable de instalaciones', 'Generales Comercializador', 'Generales Comercializador1', 0),
(111, 'INE del responsable de instalaciones', 'Generales Envasador', 'Generales Envasador1', 0),
(112, 'Plano de distribución', 'Generales Comercializador', 'Generales Comercializador', 0),
(113, 'Comprobante de posesión de las instalaciones (si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento o comodato', 'Generales Productor', 'Generales Productor mezcal', 0),
(114, 'Copia de la identificación oficial vigente del arrendador y arrendatario (En caso de no ser propietario de las instalaciones)', 'Generales Productor', 'Generales Productor mezcal', 0),
(115, 'Evidencias', 'Documentacion organico', 'Evidencias', 0),
(116, 'FQ', 'Dictámenes', 'Dictamen', 0),
(117, 'Dictamen', 'Dictámenes', 'Dictamen', 0),
(118, 'Solicitud (Ingredientes ordenados)', 'Etiquetas', 'Alimentos', 0),
(119, 'Lista de aditivos', 'Etiquetas', 'Alimentos', 0),
(120, 'Medidas del producto', 'Etiquetas', 'Alimentos', 0),
(121, 'Declaración de uso de la marca', 'Marcas', 'Trámite', 0),
(122, 'BPM ( Buenas Prácticas de Manufactura)', 'Inspecciones', 'Instalaciones', 0),
(123, 'Instrumento de Evaluación', 'Inspecciones', 'Instalaciones', 0),
(124, 'Validación de la Información', 'Inspecciones', 'Instalaciones', 0),
(125, 'Informe de los Hallazgos', 'Inspecciones', 'Instalaciones', 0),
(126, 'Requisitos a evaluar NOM-070-SCFI-2016', 'Documentos generales', 'Todas', 0),
(127, 'Certificado de Instalaciones NOM productor', 'Generales Productor', 'Certificado', 0),
(128, 'Certificado de Instalaciones NOM envasador', 'Generales Envasador', 'Certificado', 0),
(129, 'Certificado de Instalaciones NOM comercializador', 'Generales Comercializador', 'Certificado', 0),
(132, 'Resultados de %ART', 'Generales Productor de agave', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacion_url`
--

CREATE TABLE `documentacion_url` (
  `id` int(11) NOT NULL,
  `id_documento` int(11) NOT NULL,
  `nombre_documento` varchar(200) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `id_relacion` int(11) NOT NULL,
  `fecha_vigencia` date DEFAULT NULL,
  `id_usuario_registro` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentacion_url`
--

INSERT INTO `documentacion_url` (`id`, `id_documento`, `nombre_documento`, `id_empresa`, `url`, `id_relacion`, `fecha_vigencia`, `id_usuario_registro`, `created_at`, `updated_at`) VALUES
(1, 71, 'Guía de traslado de agave', 3, 'Guía de traslado de agave_1724698039.pdf', 1, NULL, NULL, '2024-08-27 00:47:20', '2024-08-27 00:47:20'),
(2, 71, 'Guía de traslado de agave', 3, 'Guía de traslado de agave_1724698147.pdf', 40, NULL, NULL, '2024-08-27 00:49:07', '2024-08-27 00:49:07'),
(3, 4, 'Comprobante del domicilio fiscal', 1, 'Comprobante del domicilio fiscal_1724700414.pdf', 0, NULL, NULL, '2024-08-27 01:26:54', '2024-08-27 01:26:54'),
(4, 58, 'Análisis fisicoquímicos: Análisis completo - NNMZ-15905', 1, 'Análisis fisicoquímicos_66ccdc5b748a8.pdf', 1, NULL, NULL, '2024-08-27 01:49:47', '2024-08-27 01:49:47'),
(5, 51, 'Comprobante de pago', 1, 'Comprobante de pago_1724780566.png', 1, NULL, NULL, '2024-08-27 23:42:46', '2024-08-27 23:42:46'),
(6, 52, 'Documento de No. de guía', 1, 'Documento de No. de guía_1724796062.pdf', 2, NULL, NULL, '2024-08-28 04:01:02', '2024-08-28 04:01:02'),
(7, 51, 'Comprobante de pago', 3, 'Comprobante de pago_1724875492.jpg', 2, NULL, NULL, '2024-08-29 02:04:53', '2024-08-29 02:04:53'),
(8, 40, 'Licencia de uso o cesión de derechos (En caso de no ser propietario de la marca)', 3, 'Licencia de uso o cesión de derechos (En caso de no ser propietario de la marca)_1724883506.png', 0, NULL, NULL, '2024-08-29 04:18:27', '2024-08-29 04:18:27'),
(9, 51, 'Comprobante de pago', 3, 'Comprobante de pago_1724958454.jpg', 2, NULL, NULL, '2024-08-30 01:07:35', '2024-08-30 01:07:35'),
(10, 1, 'Acta constitutiva (Copia simple)', 3, 'Acta constitutiva (Copia simple)_1724969630.png', 0, NULL, NULL, '2024-08-30 04:13:50', '2024-08-30 04:13:50'),
(11, 58, 'Análisis fisicoquímicos: Análisis completo - Folio 001', 3, 'Análisis fisicoquímicos_66d0f34e6be1e.png', 2, NULL, NULL, '2024-08-30 04:16:46', '2024-08-30 04:16:46'),
(12, 58, 'Análisis fisicoquímicos: Ajuste de grado - Folio 002', 3, 'Análisis fisicoquímicos_66d0f34e6fae7.png', 2, NULL, NULL, '2024-08-30 04:16:46', '2024-08-30 04:16:46'),
(13, 34, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento', 1, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento_66d8e16f9948e.pdf', 3, NULL, NULL, '2024-09-05 04:38:40', '2024-09-05 04:38:40'),
(14, 51, 'Comprobante de pago de holograma', 3, 'Comprobante de pago de holograma_1725491127.pdf', 1, NULL, NULL, '2024-09-05 05:05:27', '2024-09-05 05:05:27'),
(15, 127, 'Certificado de instalaciones', 3, 'Certificado de instalaciones_1725923261.pdf', 8, NULL, NULL, '2024-09-09 23:07:41', '2024-09-09 23:07:41'),
(16, 34, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento', 1, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento_66df860604c89.pdf', 4, NULL, NULL, '2024-09-09 23:34:30', '2024-09-09 23:34:30'),
(17, 69, 'Acta de inspección UMS-0001/2025', 1, 'Acta de inspección UMS-0001/2025_1726006737.pdf', 14, NULL, NULL, '2024-09-10 22:18:57', '2024-09-10 22:18:57'),
(18, 69, 'Acta de inspección UMS-0001/2025', 1, 'Acta de inspección UMS-0001/2025_1726007077.pdf', 14, NULL, NULL, '2024-09-10 22:24:37', '2024-09-10 22:24:37'),
(19, 69, 'Acta de inspección UMS-0001/2025', 1, 'Acta de inspección UMS-0001/2025_1726008426.png', 14, NULL, NULL, '2024-09-10 22:47:06', '2024-09-10 22:47:06'),
(20, 69, 'Acta de inspección UMS-0001/2025', 1, 'Acta de inspección UMS-0001/2025_1726008522.png', 14, NULL, NULL, '2024-09-10 22:48:42', '2024-09-10 22:48:42'),
(21, 69, 'Acta de inspección UMS-0001/2025', 1, 'Acta de inspección UMS-0001/2025_1726008533.png', 14, NULL, NULL, '2024-09-10 22:48:53', '2024-09-10 22:48:53'),
(22, 69, 'Acta de inspección UMS-0001/2025', 1, 'Acta de inspección UMS-0001/2025_1726008609.pdf', 14, NULL, NULL, '2024-09-10 22:50:09', '2024-09-10 22:50:09'),
(23, 69, 'Acta de inspección UMS-0001/2025', 1, 'Acta de inspección UMS-0001/2025_1726008800.png', 14, NULL, NULL, '2024-09-10 22:53:20', '2024-09-10 22:53:20'),
(24, 70, 'Fotos de bitácoras', 1, 'Fotos de bitácoras_1726008800.pdf', 14, NULL, NULL, '2024-09-10 22:53:20', '2024-09-10 22:53:20'),
(25, 34, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento', 3, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento_66fd79dc6adce.pdf', 2, NULL, NULL, '2024-10-02 16:50:36', '2024-10-02 16:50:36'),
(26, 1, 'Acta constitutiva (Copia simple)', 1, 'Acta constitutiva (Copia simple)_1728067610.png', 0, NULL, NULL, '2024-10-04 18:46:50', '2024-10-04 18:46:50'),
(27, 1, 'Acta constitutiva (Copia simple)', 1, 'Acta constitutiva (Copia simple)_1728067626.png', 0, NULL, NULL, '2024-10-04 18:47:06', '2024-10-04 18:47:06'),
(28, 47, 'Dictámenes', 1, 'Dictámenes_1728067626.png', 0, NULL, NULL, '2024-10-04 18:47:06', '2024-10-04 18:47:06'),
(29, 77, 'Carta de asignación de número de cliente', 1, 'Carta de asignación de número de cliente_1728067656.png', 0, NULL, NULL, '2024-10-04 18:47:36', '2024-10-04 18:47:36'),
(30, 2, 'Poder notarial del representante legal (Solo en caso de no estar incluido en el acta constitutiva)', 1, 'Poder notarial del representante legal (Solo en caso de no estar incluido en el acta constitutiva)_1728067677.png', 0, NULL, NULL, '2024-10-04 18:47:57', '2024-10-04 18:47:57'),
(31, 3, 'Copia de identificacion oficial del Titular (encaso de ser persona física) o representante legal (en caso de ser persona moral).', 1, 'Copia de identificacion oficial del Titular (encaso de ser persona física) o representante legal (en caso de ser persona moral)._1728067677.png', 0, NULL, NULL, '2024-10-04 18:47:57', '2024-10-04 18:47:57'),
(32, 76, 'Constancia de situación fiscal', 1, 'Constancia de situación fiscal_1728067677.png', 0, NULL, NULL, '2024-10-04 18:47:57', '2024-10-04 18:47:57'),
(33, 77, 'Carta de asignación de número de cliente', 1, 'Carta de asignación de número de cliente_1728067677.png', 0, NULL, NULL, '2024-10-04 18:47:57', '2024-10-04 18:47:57'),
(34, 34, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento', 1, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento_6706c9d6e543b.pdf', 5, NULL, NULL, '2024-10-09 18:22:15', '2024-10-09 18:22:15'),
(35, 34, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento', 1, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento_6706d6dd29f21.pdf', 130, NULL, NULL, '2024-10-09 19:17:49', '2024-10-09 19:17:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `rfc` varchar(22) NOT NULL,
  `domicilio_fiscal` varchar(140) NOT NULL,
  `representante` varchar(100) NOT NULL,
  `estado` varchar(60) NOT NULL,
  `regimen` varchar(100) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '1.Prospecto 2.Confirmado',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_contacto` int(11) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `razon_social`, `rfc`, `domicilio_fiscal`, `representante`, `estado`, `regimen`, `correo`, `telefono`, `tipo`, `created_at`, `id_contacto`, `updated_at`) VALUES
(1, 'MEZCALMICH S.P.R. DE R.L.', 'MEZ160722KN3', 'Albino Garcia, 19, Jardines De Torremolinos, C.P. 58197, Morelia, Morelia , Michoacan', 'Carlos Ernesto García Pérez', '16', 'Persona moral', 'ventaspuraspromesas@gmail.com', '443 236 0006', 2, '2024-08-26 22:13:07', 19, '2024-08-26 22:28:14'),
(2, 'José Jesús Robledo Rodríguez', 'RORJ8006262U3', 'Cupreata, 1, Rancho Los Agaves, C.P. 39100, Mazatlán, Guerrero.', 'No aplica', '12', 'Persona física', 'mezcalrobledo@gmail.com', '747 107 9588', 2, '2024-08-26 22:16:54', 20, '2024-09-13 17:01:27'),
(3, 'Crista la Santa S.A.P.I. de C.V.', 'NCO111222NV5', 'Guillermo González Camarena No. 800 Piso 2, Santa Fe, Álvaro Obregón, Ciudad De México, C.P. 01210.', 'Sergio Rodríguez Molleda y Luis Fernando Félix Fernández', '9', 'Persona moral', 'oaragon@cristalasanta.com.mx', '333 200 9555', 2, '2024-08-26 22:21:15', 20, '2024-08-26 22:36:40'),
(4, 'María Inés Mendoza Cisneros', 'AME1906138K7', 'Conocido morelos 250', 'No aplica', '16', 'Persona física', 'imendoza@erpcidam.com', '435 103 7022', 1, '2024-10-07 15:26:09', 0, '2024-10-07 15:26:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_actividad_cliente`
--

CREATE TABLE `empresa_actividad_cliente` (
  `id` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa_actividad_cliente`
--

INSERT INTO `empresa_actividad_cliente` (`id`, `id_actividad`, `id_empresa`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2024-08-26 22:13:07', '2024-08-26 22:13:07'),
(2, 4, 1, '2024-08-26 22:13:07', '2024-08-26 22:13:07'),
(3, 1, 2, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(4, 2, 2, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(5, 3, 2, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(6, 4, 2, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(7, 1, 3, '2024-08-26 22:21:15', '2024-08-26 22:21:15'),
(8, 2, 3, '2024-08-26 22:21:15', '2024-08-26 22:21:15'),
(9, 3, 3, '2024-08-26 22:21:15', '2024-08-26 22:21:15'),
(10, 4, 3, '2024-08-26 22:21:15', '2024-08-26 22:21:15'),
(11, 3, 4, '2024-10-07 15:26:09', '2024-10-07 15:26:09'),
(12, 5, 4, '2024-10-07 15:26:09', '2024-10-07 15:26:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_contrato`
--

CREATE TABLE `empresa_contrato` (
  `id_contrato` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `fecha_cedula` date NOT NULL,
  `idcif` varchar(50) NOT NULL,
  `clave_ine` varchar(50) NOT NULL,
  `sociedad_mercantil` varchar(100) NOT NULL,
  `num_instrumento` varchar(50) NOT NULL,
  `vol_instrumento` varchar(50) NOT NULL,
  `fecha_instrumento` date NOT NULL,
  `num_notario` varchar(50) NOT NULL,
  `nombre_notario` varchar(100) NOT NULL,
  `num_permiso` varchar(50) NOT NULL,
  `estado_notario` varchar(100) NOT NULL,
  `fecha_vigencia` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa_contrato`
--

INSERT INTO `empresa_contrato` (`id_contrato`, `id_empresa`, `fecha_cedula`, `idcif`, `clave_ine`, `sociedad_mercantil`, `num_instrumento`, `vol_instrumento`, `fecha_instrumento`, `num_notario`, `nombre_notario`, `num_permiso`, `estado_notario`, `fecha_vigencia`, `created_at`, `updated_at`) VALUES
(14, 1, '2024-08-26', 'NA', 'NA', 'Sociedad anónima promotora de inversión (SAPI)', '51', '2', '2017-07-25', '51', 'Povel Aurelio Oceguera Robledo', 'A2016060', 'Michoacán', NULL, '2024-08-26 22:28:14', '2024-08-26 22:28:14'),
(15, 3, '2024-08-26', 'NA', 'NA', 'Sociedad anónima promotora de inversión (SAPI)', '51', '2', '2017-07-25', '51', 'Povel Aurelio Oceguera Robledo', 'A2016060', 'Michoacán', NULL, '2024-08-26 22:36:40', '2024-08-26 22:36:40'),
(16, 2, '2024-09-17', '23434', '3434', 'Sociedad de responsabilidad limitada', '3434', '3434', '2024-09-25', '4545', '4545', '4545', '4545', NULL, '2024-09-13 17:01:27', '2024-09-13 17:01:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_norma_certificar`
--

CREATE TABLE `empresa_norma_certificar` (
  `id` int(11) NOT NULL,
  `id_norma` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa_norma_certificar`
--

INSERT INTO `empresa_norma_certificar` (`id`, `id_norma`, `id_empresa`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-08-26 22:13:07', '2024-08-26 22:13:07'),
(2, 2, 1, '2024-08-26 22:13:07', '2024-08-26 22:13:07'),
(3, 1, 2, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(4, 2, 2, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(5, 1, 3, '2024-08-26 22:21:15', '2024-08-26 22:21:15'),
(6, 2, 3, '2024-08-26 22:21:15', '2024-08-26 22:21:15'),
(7, 1, 4, '2024-10-07 15:26:09', '2024-10-07 15:26:09'),
(8, 2, 4, '2024-10-07 15:26:09', '2024-10-07 15:26:09'),
(9, 3, 4, '2024-10-07 15:26:09', '2024-10-07 15:26:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_num_cliente`
--

CREATE TABLE `empresa_num_cliente` (
  `id` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `numero_cliente` varchar(40) NOT NULL,
  `id_norma` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa_num_cliente`
--

INSERT INTO `empresa_num_cliente` (`id`, `id_empresa`, `numero_cliente`, `id_norma`, `created_at`, `updated_at`) VALUES
(1, 1, 'NOM-070-001C', 1, '2024-08-26 22:27:21', '2024-08-26 22:27:21'),
(2, 1, 'NOM-070-001C', 1, '2024-08-26 22:27:49', '2024-08-26 22:27:49'),
(3, 1, 'NOM-070-001C', 1, '2024-08-26 22:28:14', '2024-08-26 22:28:14'),
(4, 3, 'NOM-070-005C', 1, '2024-08-26 22:36:40', '2024-08-26 22:36:40'),
(5, 2, 'NOM-070-004C', 1, '2024-09-13 17:01:27', '2024-09-13 17:01:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_producto_certificar`
--

CREATE TABLE `empresa_producto_certificar` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa_producto_certificar`
--

INSERT INTO `empresa_producto_certificar` (`id`, `id_producto`, `id_empresa`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-08-26 22:13:07', '2024-08-26 22:13:07'),
(2, 1, 2, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(3, 1, 3, '2024-08-26 22:21:15', '2024-08-26 22:21:15'),
(4, 1, 4, '2024-10-07 15:26:09', '2024-10-07 15:26:09'),
(5, 2, 4, '2024-10-07 15:26:09', '2024-10-07 15:26:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `clave` varchar(2) NOT NULL COMMENT 'CVE_ENT - Clave de la entidad',
  `nombre` varchar(40) NOT NULL COMMENT 'NOM_ENT - Nombre de la entidad',
  `abrev` varchar(10) NOT NULL COMMENT 'NOM_ABR - Nombre abreviado de la entidad',
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Estados de la República Mexicana';

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `clave`, `nombre`, `abrev`, `activo`) VALUES
(1, '01', 'Aguascalientes', 'Ags.', 1),
(2, '02', 'Baja California', 'BC', 1),
(3, '03', 'Baja California Sur', 'BCS', 1),
(4, '04', 'Campeche', 'Camp.', 1),
(5, '05', 'Coahuila de Zaragoza', 'Coah.', 1),
(6, '06', 'Colima', 'Col.', 1),
(7, '07', 'Chiapas', 'Chis.', 1),
(8, '08', 'Chihuahua', 'Chih.', 1),
(9, '09', 'Ciudad de México', 'CDMX', 1),
(10, '10', 'Durango', 'Dgo.', 1),
(11, '11', 'Guanajuato', 'Gto.', 1),
(12, '12', 'Guerrero', 'Gro.', 1),
(13, '13', 'Hidalgo', 'Hgo.', 1),
(14, '14', 'Jalisco', 'Jal.', 1),
(15, '15', 'México', 'Mex.', 1),
(16, '16', 'Michoacán de Ocampo', 'Mich.', 1),
(17, '17', 'Morelos', 'Mor.', 1),
(18, '18', 'Nayarit', 'Nay.', 1),
(19, '19', 'Nuevo León', 'NL', 1),
(20, '20', 'Oaxaca', 'Oax.', 1),
(21, '21', 'Puebla', 'Pue.', 1),
(22, '22', 'Querétaro', 'Qro.', 1),
(23, '23', 'Quintana Roo', 'Q. Roo', 1),
(24, '24', 'San Luis Potosí', 'SLP', 1),
(25, '25', 'Sinaloa', 'Sin.', 1),
(26, '26', 'Sonora', 'Son.', 1),
(27, '27', 'Tabasco', 'Tab.', 1),
(28, '28', 'Tamaulipas', 'Tamps.', 1),
(29, '29', 'Tlaxcala', 'Tlax.', 1),
(30, '30', 'Veracruz de Ignacio de la Llave', 'Ver.', 1),
(31, '31', 'Yucatán', 'Yuc.', 1),
(32, '32', 'Zacatecas', 'Zac.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guias`
--

CREATE TABLE `guias` (
  `id_guia` int(11) NOT NULL,
  `id_plantacion` int(11) NOT NULL,
  `folio` varchar(50) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_predio` int(11) NOT NULL,
  `numero_plantas` int(10) DEFAULT NULL,
  `numero_guias` int(11) NOT NULL,
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

INSERT INTO `guias` (`id_guia`, `id_plantacion`, `folio`, `id_empresa`, `id_predio`, `numero_plantas`, `numero_guias`, `num_anterior`, `num_comercializadas`, `mermas_plantas`, `edad`, `art`, `kg_maguey`, `no_lote_pedido`, `fecha_corte`, `observaciones`, `nombre_cliente`, `no_cliente`, `fecha_ingreso`, `domicilio`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sin asignarG001', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, 'sdasdasd', NULL, NULL, NULL, NULL, '2024-08-27 00:09:24', '2024-08-27 00:47:05'),
(2, 1, 'Sin asignarG002', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:09:24', '2024-08-27 00:09:24'),
(3, 1, 'Sin asignarG003', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:09:24', '2024-08-27 00:09:24'),
(4, 1, 'Sin asignarG004', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:09:24', '2024-08-27 00:09:24'),
(5, 1, 'Sin asignarG005', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:09:24', '2024-08-27 00:09:24'),
(6, 1, 'Sin asignarG006', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:09:24', '2024-08-27 00:09:24'),
(7, 1, 'Sin asignarG007', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:09:24', '2024-08-27 00:09:24'),
(8, 1, 'Sin asignarG008', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:09:24', '2024-08-27 00:09:24'),
(9, 1, 'Sin asignarG009', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:09:24', '2024-08-27 00:09:24'),
(10, 1, 'Sin asignarG010', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:09:24', '2024-08-27 00:09:24'),
(11, 1, 'Sin asignarG011', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:18', '2024-08-27 00:43:18'),
(12, 1, 'Sin asignarG012', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:18', '2024-08-27 00:43:18'),
(13, 1, 'Sin asignarG013', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:18', '2024-08-27 00:43:18'),
(14, 1, 'Sin asignarG014', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:18', '2024-08-27 00:43:18'),
(15, 1, 'Sin asignarG015', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:18', '2024-08-27 00:43:18'),
(16, 1, 'Sin asignarG016', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:18', '2024-08-27 00:43:18'),
(17, 1, 'Sin asignarG017', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:18', '2024-08-27 00:43:18'),
(18, 1, 'Sin asignarG018', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:18', '2024-08-27 00:43:18'),
(19, 1, 'Sin asignarG019', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:19', '2024-08-27 00:43:19'),
(20, 1, 'Sin asignarG020', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:19', '2024-08-27 00:43:19'),
(21, 1, 'Sin asignarG021', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:31', '2024-08-27 00:43:31'),
(22, 1, 'Sin asignarG022', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:31', '2024-08-27 00:43:31'),
(23, 1, 'Sin asignarG023', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:31', '2024-08-27 00:43:31'),
(24, 1, 'Sin asignarG024', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:31', '2024-08-27 00:43:31'),
(25, 1, 'Sin asignarG025', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:31', '2024-08-27 00:43:31'),
(26, 1, 'Sin asignarG026', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:31', '2024-08-27 00:43:31'),
(27, 1, 'Sin asignarG027', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:31', '2024-08-27 00:43:31'),
(28, 1, 'Sin asignarG028', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:31', '2024-08-27 00:43:31'),
(29, 1, 'Sin asignarG029', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:31', '2024-08-27 00:43:31'),
(30, 1, 'Sin asignarG030', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:31', '2024-08-27 00:43:31'),
(31, 1, 'Sin asignarG031', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:48', '2024-08-27 00:43:48'),
(32, 1, 'Sin asignarG032', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:48', '2024-08-27 00:43:48'),
(33, 1, 'Sin asignarG033', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:48', '2024-08-27 00:43:48'),
(34, 1, 'Sin asignarG034', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:48', '2024-08-27 00:43:48'),
(35, 1, 'Sin asignarG035', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:48', '2024-08-27 00:43:48'),
(36, 1, 'Sin asignarG036', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:48', '2024-08-27 00:43:48'),
(37, 1, 'Sin asignarG037', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:48', '2024-08-27 00:43:48'),
(38, 1, 'Sin asignarG038', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:48', '2024-08-27 00:43:48'),
(39, 1, 'Sin asignarG039', 3, 1, 22, 10, 2322, 2300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:48', '2024-08-27 00:43:48'),
(40, 1, 'Sin asignarG040', 3, 1, 22, 10, 2322, 2300, 0, NULL, 3434340, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 00:43:48', '2024-08-27 00:48:42'),
(41, 2, 'Sin asignarG001', 1, 2, 14995, 5, 15000, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:48:54', '2024-08-27 01:48:54'),
(42, 2, 'Sin asignarG002', 1, 2, 14995, 5, 15000, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:48:54', '2024-08-27 01:48:54'),
(43, 2, 'Sin asignarG003', 1, 2, 14995, 5, 15000, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:48:54', '2024-08-27 01:48:54'),
(44, 2, 'Sin asignarG004', 1, 2, 14995, 5, 15000, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:48:54', '2024-08-27 01:48:54'),
(45, 2, 'Sin asignarG005', 1, 2, 14995, 5, 15000, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:48:54', '2024-08-27 01:48:54'),
(46, 4, 'Sin asignarG006', 1, 3, 24998, 1, 25000, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-03 22:23:22', '2024-09-07 01:04:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspecciones`
--

CREATE TABLE `inspecciones` (
  `id_inspeccion` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_inspector` int(11) NOT NULL,
  `num_servicio` varchar(40) NOT NULL,
  `fecha_servicio` date NOT NULL,
  `estatus_inspeccion` int(11) NOT NULL,
  `observaciones` varchar(6000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inspecciones`
--

INSERT INTO `inspecciones` (`id_inspeccion`, `id_solicitud`, `id_inspector`, `num_servicio`, `fecha_servicio`, `estatus_inspeccion`, `observaciones`, `created_at`, `updated_at`) VALUES
(4, 1, 21, 'UMS-1823/2023', '2024-08-21', 1, '', '2024-08-21 04:40:18', '2024-08-24 05:03:49'),
(6, 10, 21, 'UMS-1285/2023', '2024-10-03', 1, '', '2024-09-06 22:26:41', '2024-09-06 23:32:51'),
(7, 14, 14, 'UMS-0001/2025', '2025-01-01', 1, 'Es la primera inspección del año', '2024-09-10 16:18:28', '2024-09-10 16:18:28'),
(8, 21, 14, 'UMS-1285/2023', '2024-09-10', 1, 'todo bien', '2024-09-18 19:06:41', '2024-09-18 19:06:41'),
(9, 20, 21, 'UMS-1823/2023', '2024-09-17', 1, '', '2024-09-19 21:31:39', '2024-09-19 21:31:39'),
(10, 19, 14, 'UMS-1823/2023', '2024-10-02', 1, '', '2024-10-02 22:11:05', '2024-10-02 22:11:05'),
(11, 22, 14, 'georefere', '2024-10-07', 1, '', '2024-10-07 16:59:23', '2024-10-07 16:59:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instalaciones`
--

CREATE TABLE `instalaciones` (
  `id_instalacion` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `direccion_completa` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL COMMENT '1.Productora 2.Envasadora \r\n3.Comercializadora',
  `folio` varchar(100) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `id_organismo` int(11) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fecha_vigencia` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instalaciones`
--

INSERT INTO `instalaciones` (`id_instalacion`, `id_empresa`, `direccion_completa`, `estado`, `tipo`, `folio`, `responsable`, `id_organismo`, `fecha_emision`, `fecha_vigencia`, `created_at`, `updated_at`) VALUES
(1, 1, 'Albino Garcia 19 Jardines De Torremolinos 58197 Morelia, Morelia , Michoacan', 16, 'Productora', NULL, 'jaun', NULL, NULL, NULL, '2024-08-26 22:13:07', '2024-08-26 22:13:07'),
(2, 1, 'Albino Garcia 19 Jardines De Torremolinos 58197 Morelia, Morelia , Michoacan', 16, 'Comercializadora', NULL, 'pedro', NULL, NULL, NULL, '2024-08-26 22:13:07', '2024-08-26 22:13:07'),
(3, 2, 'Cupreata, 1, Rancho Los Agaves, C.P. 39100, Mazatlán, Guerrero.', 12, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(4, 2, 'Cupreata, 1, Rancho Los Agaves, C.P. 39100, Mazatlán, Guerrero.', 12, 'Envasadora', NULL, NULL, NULL, NULL, NULL, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(5, 2, 'Cupreata, 1, Rancho Los Agaves, C.P. 39100, Mazatlán, Guerrero.', 12, 'Comercializadora', NULL, NULL, NULL, NULL, NULL, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(6, 3, 'Periferico Sur, 8500, El Mante, C.P. 45609, Tlaquepaque, San Pedro Tlaquepaque, Jalisco.', 14, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-08-26 22:21:15', '2024-08-27 21:52:15'),
(7, 3, 'comercializadora de crista', 20, 'Comercializadora', NULL, NULL, NULL, NULL, NULL, '2024-08-29 04:35:12', '2024-08-29 04:35:12'),
(8, 3, 'Antigua Carretera a Pátzcuaro, otra2', 20, 'Productora', '163', NULL, 4, '2024-09-01', '2024-09-21', '2024-09-09 23:07:41', '2024-09-09 23:07:41'),
(9, 1, 'Antigua Carretera a Pátzcuaro, otra2', 1, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-09-13 20:06:46', '2024-09-13 20:06:46'),
(10, 1, 'Antigua Carretera a Pátzcuaro, otra2', 12, 'Almacén y bodega', NULL, NULL, NULL, NULL, NULL, '2024-09-13 22:22:39', '2024-09-13 22:22:39'),
(11, 1, '3434', 2, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-09-17 16:40:13', '2024-09-17 16:40:13'),
(12, 1, 'Dirección de envasadora de prueba', 20, 'Envasadora', NULL, NULL, NULL, NULL, NULL, '2024-09-17 19:14:38', '2024-09-17 19:14:38'),
(13, 4, 'Conocido morelos 250', 16, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-10-07 15:26:09', '2024-10-07 15:26:09'),
(14, 1, 'Antigua Carretera a Pátzcuaro, otra2', 2, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 19:27:56', '2024-10-09 19:27:56'),
(15, 2, 'Antigua Carretera a Pátzcuaro, otra2', 16, 'Almacén y bodega', NULL, NULL, NULL, NULL, NULL, '2024-10-09 19:28:33', '2024-10-09 19:28:33'),
(16, 2, 'otraaaaaaaaaaaaa', 2, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 19:46:56', '2024-10-09 19:46:56'),
(17, 2, 'segundaaaa', 3, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 19:50:48', '2024-10-09 19:50:48'),
(18, 2, 'Tercera', 4, 'Comercializadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:08:31', '2024-10-09 22:08:31'),
(19, 2, 'Cuarta envasadora', 3, 'Envasadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:10:06', '2024-10-09 22:10:06'),
(20, 2, 'quinta', 4, 'Comercializadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:11:18', '2024-10-09 22:11:18'),
(21, 2, 'ultia de josé', 5, 'Envasadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:18:31', '2024-10-09 22:18:31'),
(22, 2, 'ultima si', 5, 'Almacén y bodega', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:19:10', '2024-10-09 22:19:10'),
(23, 3, 'otra de crista', 5, 'Envasadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:20:28', '2024-10-09 22:20:28'),
(24, 2, 'mero ultima', 3, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:21:29', '2024-10-09 22:21:29'),
(25, 2, '345', 4, 'Comercializadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:22:16', '2024-10-09 22:22:16'),
(26, 1, 'Jorge Gómez Romero', 3, 'Envasadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:23:38', '2024-10-09 22:23:38'),
(27, 2, 'ultima', 3, 'Envasadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:29:10', '2024-10-09 22:29:10'),
(28, 2, 'asasas', 3, 'Envasadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:29:52', '2024-10-09 22:29:52'),
(29, 1, 'ultima 100', 4, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:30:56', '2024-10-09 22:30:56'),
(30, 2, 'Antigua Carretera a Pátzcuaro, otra2', 4, 'Comercializadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:31:42', '2024-10-09 22:31:42'),
(31, 1, '34343', 4, 'Productora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:32:46', '2024-10-09 22:32:46'),
(32, 2, 'sdfsd', 4, 'Comercializadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:33:37', '2024-10-09 22:33:37'),
(33, 2, '111000', 3, 'Envasadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:46:21', '2024-10-09 22:46:21'),
(34, 1, 'u', 4, 'Comercializadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:47:35', '2024-10-09 22:47:35'),
(35, 1, 'zzzz', 4, 'Envasadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:49:57', '2024-10-09 22:49:57'),
(36, 2, 'Antigua Carretera a Pátzcuaro, otra2', 3, 'Comercializadora', NULL, NULL, NULL, NULL, NULL, '2024-10-09 22:50:41', '2024-10-09 22:50:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes_envasado`
--

CREATE TABLE `lotes_envasado` (
  `id_lote_envasado` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL COMMENT 'Relación con empresas',
  `nombre_lote` varchar(100) NOT NULL,
  `tipo_lote` int(11) NOT NULL COMMENT '1. Por un solo lote a granel 2. Por más de un lote a granel',
  `sku` varchar(60) NOT NULL,
  `id_marca` int(11) NOT NULL COMMENT 'Relación con id_marca de la tabla marcas',
  `destino_lote` varchar(120) NOT NULL,
  `cant_botellas` int(11) NOT NULL,
  `presentacion` int(11) NOT NULL,
  `unidad` varchar(50) NOT NULL COMMENT 'Litros, mililitros o centilitros',
  `volumen_total` double NOT NULL,
  `lugar_envasado` int(11) NOT NULL COMMENT 'Relación con id_intalacion',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lotes_envasado`
--

INSERT INTO `lotes_envasado` (`id_lote_envasado`, `id_empresa`, `nombre_lote`, `tipo_lote`, `sku`, `id_marca`, `destino_lote`, `cant_botellas`, `presentacion`, `unidad`, `volumen_total`, `lugar_envasado`, `created_at`, `updated_at`) VALUES
(1, 1, 'ENV-001', 2, '3434', 1, 'Para venta nacional', 1000, 750, 'Mililitros', 750, 12, '2024-09-17 19:15:27', '2024-09-17 19:15:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes_envasado_granel`
--

CREATE TABLE `lotes_envasado_granel` (
  `id` int(11) NOT NULL,
  `id_lote_envasado` int(11) NOT NULL,
  `id_lote_granel` int(11) NOT NULL,
  `volumen_parcial` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lotes_envasado_granel`
--

INSERT INTO `lotes_envasado_granel` (`id`, `id_lote_envasado`, `id_lote_granel`, `volumen_parcial`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 750, '2024-09-17 19:15:27', '2024-09-17 19:15:27'),
(2, 1, 1, 750, '2024-09-17 19:15:27', '2024-09-17 19:15:27'),
(3, 1, 1, 750, '2024-09-17 19:15:27', '2024-09-17 19:15:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes_granel`
--

CREATE TABLE `lotes_granel` (
  `id_lote_granel` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `nombre_lote` varchar(70) NOT NULL,
  `tipo_lote` int(11) NOT NULL COMMENT '1. Certificación por oc cidam 2. Certificado por otro organismo',
  `folio_fq` varchar(70) NOT NULL,
  `volumen` double NOT NULL,
  `cont_alc` float NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_clase` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `ingredientes` varchar(100) DEFAULT NULL,
  `edad` varchar(30) DEFAULT NULL,
  `folio_certificado` varchar(50) DEFAULT NULL,
  `id_organismo` int(11) DEFAULT 0,
  `fecha_emision` date DEFAULT NULL,
  `fecha_vigencia` date DEFAULT NULL,
  `estatus` varchar(30) NOT NULL DEFAULT 'Activo',
  `lote_original_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lotes_granel`
--

INSERT INTO `lotes_granel` (`id_lote_granel`, `id_empresa`, `nombre_lote`, `tipo_lote`, `folio_fq`, `volumen`, `cont_alc`, `id_categoria`, `id_clase`, `id_tipo`, `ingredientes`, `edad`, `folio_certificado`, `id_organismo`, `fecha_emision`, `fecha_vigencia`, `estatus`, `lote_original_id`, `created_at`, `updated_at`) VALUES
(87, 80, 'chelo granel', 2, 'Sin FQ', 1566, 2000, 1, 1, 1, 'sin ingredientes', 'sin edad', 'fl-15', NULL, '2024-09-01', '2024-09-02', 'Activo', NULL, '2024-09-19 03:55:51', '2024-10-10 00:00:27'),
(88, 3, 'Lote 01', 1, 'Sin FQ', 7500, 42.5, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Activo', NULL, '2024-10-02 22:01:44', '2024-10-02 22:01:44'),
(89, 1, '35354', 1, 'Sin FQ', 3434, 3434, 1, 1, 1, '4545', '4545', NULL, NULL, NULL, NULL, 'Activo', 87, '2024-10-10 00:00:27', '2024-10-10 00:00:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes_granel_guias`
--

CREATE TABLE `lotes_granel_guias` (
  `id` int(11) NOT NULL,
  `id_lote_granel` int(11) NOT NULL,
  `id_guia` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lotes_granel_guias`
--

INSERT INTO `lotes_granel_guias` (`id`, `id_lote_granel`, `id_guia`, `created_at`, `updated_at`) VALUES
(1, 1, 41, '2024-08-27 01:49:47', '2024-08-27 01:49:47'),
(2, 2, 40, '2024-08-30 04:16:46', '2024-08-30 04:16:46'),
(3, 3, 38, '2024-09-09 16:19:27', '2024-09-09 16:19:27'),
(4, 4, 43, '2024-09-17 19:13:05', '2024-09-17 19:13:05'),
(5, 4, 45, '2024-09-17 19:13:05', '2024-09-17 19:13:05'),
(7, 88, 3, '2024-10-02 22:02:47', '2024-10-02 22:02:47'),
(8, 88, 5, '2024-10-02 22:02:47', '2024-10-02 22:02:47'),
(9, 89, 43, '2024-10-10 00:00:27', '2024-10-10 00:00:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `folio` char(1) NOT NULL,
  `marca` varchar(60) NOT NULL,
  `id_empresa` int(11) NOT NULL COMMENT 'Relación con la tabla empresa',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `folio`, `marca`, `id_empresa`, `created_at`, `updated_at`) VALUES
(1, 'A', 'PURAS PROMESAS', 1, '2024-08-26 22:38:24', '2024-08-26 22:38:24'),
(2, 'A', '400 Conejos', 3, '2024-08-26 22:38:35', '2024-08-26 22:38:35'),
(3, 'B', 'Creyente', 3, '2024-08-26 22:38:46', '2024-08-26 22:38:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_06_24_224311_add_two_factor_columns_to_users_table', 1),
(5, '2024_06_24_224359_create_personal_access_tokens_table', 1),
(6, '2024_06_24_224444_add_two_factor_columns_to_users_table', 2),
(7, '2024_06_24_224519_create_teams_table', 3),
(8, '2024_06_24_224520_create_team_user_table', 3),
(9, '2024_06_24_224521_create_team_invitations_table', 3),
(10, '2024_08_20_162833_create_activity_log_table', 4),
(11, '2024_08_20_162834_add_event_column_to_activity_log_table', 4),
(12, '2024_08_20_162835_add_batch_uuid_column_to_activity_log_table', 4),
(13, '2024_09_03_153428_create_notifications_table', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('017dd018-a9c6-4351-8e40-6b0bb6443965', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00020 Georreferenciaci\\u00f3n\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 20:24:04', '2024-09-11 20:24:04'),
('05f9dbb6-bd7c-47a0-84ee-d5a038e3cdd8', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00016 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-10 15:38:30', '2024-09-10 15:38:30'),
('06a2b35b-1a60-4f59-b51b-f23daa91af9e', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Adjunt\\u00f3 resultados de inspecci\\u00f3n\",\"message\":\"Fotos de bit\\u00e1coras, Acta de inspecci\\u00f3n UMS-0001\\/2025, \",\"url\":\"inspecciones\"}', NULL, '2024-09-10 22:53:20', '2024-09-10 22:53:20'),
('0923d2e0-de62-41c1-9482-e5e1b04345d1', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Adjunt\\u00f3 resultados de inspecci\\u00f3n\",\"message\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025, \",\"url\":\"inspecciones\"}', NULL, '2024-09-10 22:50:09', '2024-09-10 22:50:09'),
('0ae83047-fe27-4af4-be08-178c98c75a0a', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00021 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-18 19:05:44', '2024-09-18 19:05:44'),
('0e0cb1ba-7618-4cd3-b62c-4c3a2356c485', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-10 15:27:05', '2024-09-10 15:27:05'),
('10502981-dfeb-429f-8696-4a26cd1d6506', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-09 23:30:52', '2024-09-09 23:30:52'),
('12339ce1-f220-4206-a77c-e51054c0c7fa', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo revisor asignado\",\"message\":\"Nuevo revisor asignado: Mayra Gutierrez - Primera revisi\\u00f3n (Correcci\\u00f3n)\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-19 18:38:16', '2024-09-19 18:38:16'),
('18364f54-4308-456a-bd2c-4ef85ae87448', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00019 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 20:09:36', '2024-09-11 20:09:36'),
('1c4dd353-e95b-4761-b3ce-85991a3f941c', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Karen P\\u00e9rez) al certificado 24243\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-02 23:05:31', '2024-10-02 23:05:31'),
('250f777a-cc50-4428-b640-8ad456a04446', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-09 23:30:52', '2024-09-09 23:30:52'),
('27ca6dc0-aa1a-4b13-a940-272d571a1859', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Adjunt\\u00f3 resultados de inspecci\\u00f3n\",\"message\":\"Fotos de bit\\u00e1coras, Acta de inspecci\\u00f3n UMS-0001\\/2025, \",\"url\":\"inspecciones\"}', NULL, '2024-09-10 22:53:20', '2024-09-10 22:53:20'),
('346f0e98-7072-4935-bb3d-fbcede69dfde', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00022 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-07 16:58:41', '2024-10-07 16:58:41'),
('3634c965-3df0-4f87-9439-33ec2d9e9a1e', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00016 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-10 15:38:30', '2024-09-10 15:38:30'),
('391f2f96-3d85-4c5d-b140-833df1ea4c01', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Miguel \\u00c1ngel G\\u00f3mez Romero) al certificado cert0001\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-09 23:49:27', '2024-10-09 23:49:27'),
('421c7930-d7a2-40ac-93ce-1ff555147ab8', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Adjunt\\u00f3 resultados de inspecci\\u00f3n\",\"message\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025, \",\"url\":\"inspecciones\"}', NULL, '2024-09-10 22:50:09', '2024-09-10 22:50:09'),
('46fbbb98-0fb4-4cd3-b629-47e9b15b4ed6', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Eva Viviana Soto Barrietos) al certificado cert0001\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-14 22:53:52', '2024-10-14 22:53:52'),
('4a9daca4-6019-4bb2-8c87-4701f55dbee9', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo revisor asignado\",\"message\":\"Nuevo revisor asignado: Mayra Gutierrez - Primera revisi\\u00f3n (Correcci\\u00f3n)\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-19 18:38:16', '2024-09-19 18:38:16'),
('4b472512-0a79-4c30-a9c8-2692526d24af', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 26, '{\"title\":\"Nuevo registro de dictamen\",\"message\":\"Dictamen de instalaciones de Envasador\",\"url\":\"\\/dictamenes\\/instalaciones\"}', NULL, '2024-09-10 17:05:32', '2024-09-10 17:05:32'),
('4e135f46-5bb1-413b-ad47-db4d2fb1debe', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Adjunt\\u00f3 resultados de inspecci\\u00f3n\",\"message\":\"Fotos de bit\\u00e1coras, Acta de inspecci\\u00f3n UMS-0001\\/2025, \",\"url\":\"inspecciones\"}', NULL, '2024-09-10 22:53:20', '2024-09-10 22:53:20'),
('4e4ee212-ebfc-4642-bc96-032a171a6ec4', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Eva Viviana Soto Barrietos) al certificado cert0001\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-14 22:53:52', '2024-10-14 22:53:52'),
('4f08c41d-6583-4b17-9c48-33466b888401', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00016 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-10 15:38:30', '2024-09-10 15:38:30'),
('50c4d672-eeb4-47f4-ad16-e5bead9c9fac', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo revisor asignado\",\"message\":\"Nuevo revisor asignado: Mayra Gutierrez - Primera revisi\\u00f3n (Correcci\\u00f3n)\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-19 18:38:16', '2024-09-19 18:38:16'),
('5220ede7-1f44-4556-98fc-f71719d097e0', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00021 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-18 19:05:44', '2024-09-18 19:05:44'),
('587ef46f-77c5-494e-b871-d3981e17dbc7', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00017 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 15:45:06', '2024-09-11 15:45:06'),
('5a8f2c3e-8744-4cfb-b167-0a9bac79dfee', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Karen P\\u00e9rez) al certificado 24243\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-02 23:05:31', '2024-10-02 23:05:31'),
('5be4a9ec-c40c-4848-bd8c-eee5459f59f7', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00017 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 15:45:06', '2024-09-11 15:45:06'),
('5ca0dc3f-af26-4676-aef8-fd23c989d0f4', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de dictamen\",\"message\":\"Dictamen de instalaciones de \\u00c1rea de maduraci\\u00f3n\",\"url\":\"\\/dictamenes\\/instalaciones\"}', NULL, '2024-09-07 00:49:00', '2024-09-07 00:49:00'),
('5d24e148-8bf2-483b-a817-1dc1f61bf4b1', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Karen P\\u00e9rez) al certificado ocer 012222\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-02 22:53:39', '2024-10-02 22:53:39'),
('6a811465-6e37-4b45-af68-84da6b364d2e', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00022 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-07 16:58:41', '2024-10-07 16:58:41'),
('6b1f30c0-30c4-488b-992c-afa7a11cba46', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-05 23:51:50', '2024-09-06 16:28:54'),
('744bf629-853c-471e-9f40-996ba804c2ff', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de resultados de inspecci\\u00f3n\",\"message\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025, \",\"url\":\"inspecciones\"}', NULL, '2024-09-10 22:48:53', '2024-09-10 22:48:53'),
('790cb060-e0a5-4c33-8580-71eac5c91865', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Miguel \\u00c1ngel G\\u00f3mez Romero) al certificado 24243\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-02 23:05:43', '2024-10-02 23:05:43'),
('79c664c8-d17e-42af-b1aa-b28bd147ac5f', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo revisor asignado\",\"message\":\"Nuevo revisor asignado: Karen P\\u00e9rez - Primera revisi\\u00f3n\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-23 15:41:58', '2024-09-23 15:41:58'),
('7d1a69a8-f069-49b2-a825-346984ca61fa', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de dictamen\",\"message\":\"Dictamen de instalaciones de Envasador\",\"url\":\"\\/dictamenes\\/instalaciones\"}', NULL, '2024-09-10 17:05:32', '2024-09-10 17:05:32'),
('80aa90d1-3137-4454-9c28-65dc2b9fbb1b', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Miguel \\u00c1ngel G\\u00f3mez Romero) al certificado cert0001\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-09 23:49:27', '2024-10-09 23:49:27'),
('822d8bd0-12da-42fe-a7dc-f8755ceba7f4', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00018 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 19:08:22', '2024-09-11 19:08:22'),
('862e72c3-9566-4dd3-b11a-184c02eb2240', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Adjunt\\u00f3 resultados de inspecci\\u00f3n\",\"message\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025, \",\"url\":\"inspecciones\"}', NULL, '2024-09-10 22:50:09', '2024-09-10 22:50:09'),
('892d2cd3-9cff-479c-85c9-d9c815946d0c', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00019 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 20:09:36', '2024-09-11 20:09:36'),
('8e570c8c-926a-45a9-b489-fdc444c82949', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Miguel \\u00c1ngel G\\u00f3mez Romero) al certificado 24243\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-02 23:05:43', '2024-10-02 23:05:43'),
('8eb9e6bf-9c19-405d-9a24-d26823fe91c3', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00018 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 19:08:22', '2024-09-11 19:08:22'),
('90a21101-f714-44c2-a68b-87e8e00a31ff', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00022 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-07 16:58:41', '2024-10-07 16:58:41'),
('9467fcc5-3320-40e7-bca9-577cc6beb9dc', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00018 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 19:08:22', '2024-09-11 19:08:22'),
('97cd26eb-7994-4aad-bb20-c341b1d34e42', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-09 23:26:03', '2024-09-09 23:26:03'),
('97e1df5f-129e-4fbb-a2e2-19e99e7b7622', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 26, '{\"title\":\"Nuevo registro de dictamen\",\"message\":\"Dictamen de instalaciones de Comercializador\",\"url\":\"\\/dictamenes\\/instalaciones\"}', NULL, '2024-09-10 16:48:46', '2024-09-10 16:48:46'),
('99db24f6-1539-4b88-9658-cd1ecbeb80ec', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00015 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-10 15:28:58', '2024-09-10 15:28:58'),
('9d34be6a-499d-4c58-85a9-02911f18b1ee', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00020 Georreferenciaci\\u00f3n\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 20:24:04', '2024-09-11 20:24:04'),
('a1316b1c-063f-4a29-afe7-5326bce42d01', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 26, '{\"title\":\"Nuevo registro de dictamen\",\"message\":\"Dictamen de instalaciones de Comercializador\",\"url\":\"\\/dictamenes\\/instalaciones\"}', NULL, '2024-09-07 00:54:54', '2024-09-07 00:54:54'),
('a4f2ace1-124e-4231-9861-dcd414d825b4', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-10 15:27:05', '2024-09-10 15:27:05'),
('a56c8475-4ba6-4bdc-8934-63ef038c015f', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-06 16:01:14', '2024-09-06 16:28:57'),
('a67e5038-f874-44e5-b25d-019472d01bc5', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de dictamen\",\"message\":\"Dictamen de instalaciones de Comercializador\",\"url\":\"\\/dictamenes\\/instalaciones\"}', NULL, '2024-09-10 16:48:46', '2024-09-10 16:48:46'),
('b7366eef-1e78-4f01-9d73-2d9404c115e5', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-10 15:27:05', '2024-09-10 15:27:05'),
('bc1890f7-b9c2-47b1-80a9-f04fde743aed', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00015 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-10 15:28:58', '2024-09-10 15:28:58'),
('bc1e23b9-4322-4714-ad8a-4c5bbfa6206d', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 26, '{\"title\":\"Nuevo registro de dictamen\",\"message\":\"Dictamen de instalaciones de Almac\\u00e9n y bodega\",\"url\":\"\\/dictamenes\\/instalaciones\"}', NULL, '2024-09-10 16:50:25', '2024-09-10 16:50:25'),
('c303524d-7a87-4dbc-976f-fd1ad8273581', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo revisor asignado\",\"message\":\"Nuevo revisor asignado: Karen P\\u00e9rez - Primera revisi\\u00f3n\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-23 15:41:58', '2024-09-23 15:41:58'),
('c7cd51b3-91d8-4cf2-a72c-e4b9ffa995c0', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00015 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-10 15:28:58', '2024-09-10 15:28:58'),
('d085436c-4e11-4c9b-88b1-441f45e3f25c', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00019 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 20:09:36', '2024-09-11 20:09:36'),
('d0f9b2c8-f7e5-4060-b932-2ed328aa76d7', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00020 Georreferenciaci\\u00f3n\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 20:24:04', '2024-09-11 20:24:04'),
('d64d5064-c3dc-4b07-9845-d07e754882f9', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo revisor asignado\",\"message\":\"Nuevo revisor asignado: Karen P\\u00e9rez - Primera revisi\\u00f3n\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-23 15:41:58', '2024-09-23 15:41:58'),
('d6b611d8-0d88-42aa-922e-f2e69c571b9c', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de dictamen\",\"message\":\"Dictamen de instalaciones de Comercializador\",\"url\":\"\\/dictamenes\\/instalaciones\"}', NULL, '2024-09-07 00:54:54', '2024-09-07 00:54:54'),
('ddc0459c-d99b-4744-8e08-789b9782c0b8', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de resultados de inspecci\\u00f3n\",\"message\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025, \",\"url\":\"inspecciones\"}', '2024-09-10 22:49:55', '2024-09-10 22:48:53', '2024-09-10 22:49:55'),
('de1062dc-0409-42f6-bd97-18b066371b15', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Miguel \\u00c1ngel G\\u00f3mez Romero) al certificado 24243\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-02 23:05:43', '2024-10-02 23:05:43'),
('decff889-7ec9-409f-93f5-a324521195cc', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Karen P\\u00e9rez) al certificado 24243\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-02 23:05:31', '2024-10-02 23:05:31'),
('e32a847a-578f-4678-9963-5da634af559d', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Karen P\\u00e9rez) al certificado ocer 012222\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-02 22:53:39', '2024-10-02 22:53:39'),
('e353264b-af1f-4378-b1f4-c813fdbfdaf2', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de dictamen\",\"message\":\"Dictamen de instalaciones de \\u00c1rea de maduraci\\u00f3n\",\"url\":\"\\/dictamenes\\/instalaciones\"}', NULL, '2024-09-07 00:51:34', '2024-09-07 00:51:34'),
('e621838c-faab-4058-bfeb-20d79613ca4f', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00017 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-11 15:45:06', '2024-09-11 15:45:06'),
('e72429c6-24ce-43e6-93d6-531b3e89e527', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 20, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Miguel \\u00c1ngel G\\u00f3mez Romero) al certificado cert0001\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-09 23:49:27', '2024-10-09 23:49:27'),
('e80a2f9c-3aef-4ad6-9c69-904152532187', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-09 23:30:52', '2024-09-09 23:30:52'),
('e93dd424-9113-4707-b71e-53d65b93b55d', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de resultados de inspecci\\u00f3n\",\"message\":\"Acta de inspecci\\u00f3n UMS-0001\\/2025, \",\"url\":\"inspecciones\"}', NULL, '2024-09-10 22:48:53', '2024-09-10 22:48:53'),
('f1375b88-1b10-4fad-a440-ec21ccc58d67', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Eva Viviana Soto Barrietos) al certificado cert0001\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-14 22:53:52', '2024-10-14 22:53:52'),
('f44df51b-6f72-4881-9f6c-9eefcc66a3f2', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de dictamen\",\"message\":\"Dictamen de instalaciones de Almac\\u00e9n y bodega\",\"url\":\"\\/dictamenes\\/instalaciones\"}', NULL, '2024-09-10 16:50:25', '2024-09-10 16:50:25'),
('fa9cbe97-30c4-46ee-92af-fa61effe875a', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-09 22:53:14', '2024-09-09 22:53:14'),
('fca35887-4e8c-4c20-b4db-92be7dfabd97', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 19, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"SOL-2024-00021 Dictaminaci\\u00f3n de instalaciones\",\"url\":\"solicitudes-historial\"}', NULL, '2024-09-18 19:05:44', '2024-09-18 19:05:44'),
('ff7dd197-1108-4357-b1ef-c36a9f39ab4d', 'App\\Notifications\\GeneralNotification', 'App\\Models\\User', 18, '{\"title\":\"Nuevo registro de solicitud\",\"message\":\"Se ha asignado el revisor (Karen P\\u00e9rez) al certificado ocer 012222\",\"url\":\"solicitudes-historial\"}', NULL, '2024-10-02 22:53:39', '2024-10-02 22:53:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('mromero@cidam.org', '$2y$12$M3GNIoZZ2EONVD7YmNbN/OoG2njOLoSsnBq51X9/9ki/9IO1GbNTG', '2024-06-26 21:50:30'),
('rrojas@erpcidam.com', '$2y$12$TtsDkJKOOM0kpZdBVx0afu.kfZ8pSPzeDnyI84dM2EzOZRGxteZum', '2024-06-26 00:16:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predios`
--

CREATE TABLE `predios` (
  `id_predio` int(10) UNSIGNED NOT NULL,
  `id_empresa` int(10) UNSIGNED NOT NULL,
  `nombre_productor` varchar(255) NOT NULL,
  `num_predio` varchar(50) NOT NULL DEFAULT 'Sin asignar',
  `nombre_predio` varchar(255) NOT NULL,
  `ubicacion_predio` text DEFAULT NULL,
  `tipo_predio` enum('Comunal','Ejidal','Propiedad privada','Otro') NOT NULL,
  `puntos_referencia` text DEFAULT NULL,
  `cuenta_con_coordenadas` enum('Si','No') DEFAULT 'No',
  `superficie` decimal(10,2) NOT NULL,
  `estatus` varchar(30) NOT NULL DEFAULT 'Pendiente',
  `fecha_emision` date DEFAULT NULL,
  `fecha_vigencia` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `predios`
--

INSERT INTO `predios` (`id_predio`, `id_empresa`, `nombre_productor`, `num_predio`, `nombre_predio`, `ubicacion_predio`, `tipo_predio`, `puntos_referencia`, `cuenta_con_coordenadas`, `superficie`, `estatus`, `fecha_emision`, `fecha_vigencia`, `created_at`, `updated_at`) VALUES
(127, 80, 'chelo', 'Sin asignar', 'chelo', 'chelo', 'Ejidal', 'chelo', 'Si', 3243.00, 'Inspeccionado', NULL, NULL, '2024-09-27 04:20:07', '2024-10-07 17:58:01'),
(128, 84, 'chelo', 'chelo45262', '312', '321', 'Otro', '312', 'Si', 312.00, 'Vigente', '2024-10-07', '2025-02-27', '2024-10-07 21:56:12', '2024-10-08 01:45:17'),
(129, 80, 'chelo', 'Sin asignar', 'chelo', 'chelo', 'Ejidal', 'chelo', 'No', 2331.00, 'Pendiente', NULL, NULL, '2024-10-08 01:51:33', '2024-10-08 01:51:33'),
(130, 1, 'Miguel Ángel Gómez Romero', 'Sin asignar', 'La huaranga', 'Huetamo, Michoacán', 'Propiedad privada', 'Cerca de la capilla de las colonias', 'Si', 5000.00, 'Pendiente', NULL, NULL, '2024-10-09 19:17:48', '2024-10-09 19:17:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predios_caracteristicas_maguey`
--

CREATE TABLE `predios_caracteristicas_maguey` (
  `id_caracteristica` int(11) NOT NULL,
  `id_predio` int(11) NOT NULL,
  `id_inspeccion` int(11) NOT NULL,
  `no_planta` int(11) NOT NULL,
  `altura` decimal(5,2) NOT NULL,
  `diametro` decimal(5,2) NOT NULL,
  `numero_hojas` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `predios_caracteristicas_maguey`
--

INSERT INTO `predios_caracteristicas_maguey` (`id_caracteristica`, `id_predio`, `id_inspeccion`, `no_planta`, `altura`, `diametro`, `numero_hojas`, `created_at`, `updated_at`) VALUES
(4, 127, 32, 25, 25.00, 25.00, 25, '2024-09-27 04:23:26', '2024-09-27 04:23:26'),
(5, 2, 21, 23, 343.00, 34.00, 343, '2024-10-02 16:30:21', '2024-10-02 16:30:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predios_coordenadas`
--

CREATE TABLE `predios_coordenadas` (
  `id_coordenada` int(11) NOT NULL,
  `id_predio` int(11) DEFAULT NULL,
  `id_inspeccion` int(11) DEFAULT NULL,
  `latitud` varchar(50) NOT NULL,
  `longitud` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `predios_coordenadas`
--

INSERT INTO `predios_coordenadas` (`id_coordenada`, `id_predio`, `id_inspeccion`, `latitud`, `longitud`, `created_at`, `updated_at`) VALUES
(227, 125, NULL, '25', '25', '2024-09-26 04:18:26', '2024-09-26 04:18:26'),
(233, NULL, NULL, '30', '30', '2024-09-26 04:48:29', '2024-09-26 04:48:29'),
(234, NULL, NULL, '30', '30', '2024-09-26 04:49:19', '2024-09-26 04:49:19'),
(235, NULL, NULL, '35', '35', '2024-09-26 04:56:26', '2024-09-26 04:56:26'),
(236, 2, NULL, '455', '565', '2024-10-02 16:50:36', '2024-10-02 16:50:36'),
(237, 5, NULL, '43545', '454', '2024-10-09 18:22:14', '2024-10-09 18:22:14'),
(238, 130, NULL, '3434', '45454', '2024-10-09 19:17:49', '2024-10-09 19:17:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predios_inspeccion`
--

CREATE TABLE `predios_inspeccion` (
  `id_inspeccion` int(11) NOT NULL,
  `id_predio` int(11) DEFAULT NULL,
  `no_orden_servicio` varchar(100) DEFAULT NULL,
  `no_cliente` varchar(100) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `id_tipo_agave` int(11) DEFAULT NULL,
  `domicilio_fiscal` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `ubicacion_predio` varchar(255) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `distrito` varchar(100) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `nombre_paraje` varchar(255) DEFAULT NULL,
  `zona_dom` enum('si','no') DEFAULT NULL,
  `id_tipo_maguey` int(11) DEFAULT NULL,
  `marco_plantacion` decimal(10,2) DEFAULT NULL,
  `distancia_surcos` decimal(10,2) DEFAULT NULL,
  `distancia_plantas` decimal(10,2) DEFAULT NULL,
  `superficie` decimal(10,2) DEFAULT NULL,
  `fecha_inspeccion` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `predios_inspeccion`
--

INSERT INTO `predios_inspeccion` (`id_inspeccion`, `id_predio`, `no_orden_servicio`, `no_cliente`, `id_empresa`, `id_tipo_agave`, `domicilio_fiscal`, `telefono`, `ubicacion_predio`, `localidad`, `municipio`, `distrito`, `id_estado`, `nombre_paraje`, `zona_dom`, `id_tipo_maguey`, `marco_plantacion`, `distancia_surcos`, `distancia_plantas`, `superficie`, `fecha_inspeccion`, `created_at`, `updated_at`) VALUES
(17, 125, 'chelo', 'chelo', 80, 1, 'chelo', '44', '321', 'chelo', 'chelo', 'chelo', 2, 'chelo', 'si', 2, 312.00, 312.00, 312.00, 321.00, '2024-09-25', '2024-09-26 04:44:57', '2024-09-26 04:44:57'),
(18, 125, 'chelo', 'chelo', 80, 1, 'chelo', '44', '321', 'chelo', 'chelo', 'chelo', 2, 'chelo', 'si', 2, 312.00, 312.00, 312.00, 321.00, '2024-09-25', '2024-09-26 04:48:29', '2024-09-26 04:48:29'),
(19, 125, 'chelo', 'chelo', 80, 1, 'chelo', '44', '321', 'chelo', 'chelo', 'chelo', 2, 'chelo', 'si', 2, 312.00, 312.00, 312.00, 321.00, '2024-09-25', '2024-09-26 04:49:19', '2024-09-26 04:49:19'),
(20, 125, 'chelo', 'chelo', 80, 1, 'chelo', '321312312', '321', 'chelo', 'chelo', 'chelo', 1, 'chelo', 'si', 1, 32312.00, 312.00, 321.00, 321.00, '2024-09-18', '2024-09-26 04:56:26', '2024-09-26 04:56:26'),
(21, 2, '3434', '3434', 3, 1, '343434', '4351037022', 'En huetamo michoacán', 'MORELIA', '43434sdsd', 'sdsd', 16, 'sdsdsd', 'si', 1, 22.00, 3434.00, 3434.00, 454.00, '2024-10-14', '2024-10-02 16:30:21', '2024-10-02 16:30:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio_plantacion`
--

CREATE TABLE `predio_plantacion` (
  `id_plantacion` int(11) NOT NULL,
  `id_predio` int(11) DEFAULT NULL,
  `id_inspeccion` int(11) DEFAULT NULL,
  `id_tipo` int(11) NOT NULL COMMENT 'Relacion con catalogo_tipo',
  `num_plantas` int(11) NOT NULL,
  `anio_plantacion` int(11) NOT NULL,
  `tipo_plantacion` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `predio_plantacion`
--

INSERT INTO `predio_plantacion` (`id_plantacion`, `id_predio`, `id_inspeccion`, `id_tipo`, `num_plantas`, `anio_plantacion`, `tipo_plantacion`, `created_at`, `updated_at`) VALUES
(245, 125, NULL, 2, 25, 25, '25', '2024-09-26 04:18:26', '2024-09-26 04:18:26'),
(249, NULL, NULL, 2, 30, 30, '30', '2024-09-26 04:49:19', '2024-09-26 04:49:19'),
(250, NULL, NULL, 1, 5, 53, '3', '2024-09-26 04:56:26', '2024-09-26 04:56:26'),
(252, 2, NULL, 1, 232, 3434, '4545', '2024-10-02 16:50:36', '2024-10-02 16:50:36'),
(253, 5, NULL, 1, 54000, 2018, 'Silvestre', '2024-10-09 18:22:14', '2024-10-09 18:22:14'),
(254, 130, NULL, 1, 324, 2018, 'Silvestre', '2024-10-09 19:17:49', '2024-10-09 19:17:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revision_preguntas`
--

CREATE TABLE `revision_preguntas` (
  `id_pregunta` int(11) NOT NULL,
  `id_documento` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL,
  `filtro` varchar(20) NOT NULL,
  `tipo_revisor` int(11) NOT NULL COMMENT '1.Persona 2.Consejo',
  `tipo_certificado` int(11) NOT NULL COMMENT '1. de instalaciones 2. Granel, 3, exportación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `revision_preguntas`
--

INSERT INTO `revision_preguntas` (`id_pregunta`, `id_documento`, `pregunta`, `filtro`, `tipo_revisor`, `tipo_certificado`) VALUES
(1, 5, 'CONTRATO DE PRESTACIÓN DE SERVICIOS', '', 1, 1),
(2, 76, 'CONSTANCIA SITUACIÓN FISCAL Y RFC', '', 1, 1),
(3, 1, 'CARTA NO. CLIENTE', '', 1, 1),
(4, 5, 'NOMBRE DE LA EMPRESA O PERSONA FÍSICA', '', 1, 1),
(5, 0, 'DIRECCIÓN FISCAL', 'direccion_fiscal', 1, 1),
(6, 0, 'SOLICITUD DEL SERVICIO DE DICTAMINACIÓN DE INSTALACIONES', '', 1, 1),
(7, 0, 'NÚMERO DE CERTIFICADO DE INSTALACIONES', 'num_certificado', 1, 1),
(8, 0, 'NOMBRE DE LA EMPRESA O PERSONA FÍSICA', 'nombre_empresa', 1, 1),
(9, 0, 'DOMICILIO FISCAL DE LAS INSTALACIONES', 'domicilio_insta', 1, 1),
(10, 0, 'CORREO ELECTRÓNICO Y NÚMERO TELEFÓNICO ', '', 1, 1),
(11, 0, 'FECHA DE VIGENCIA Y VENCIMIENTO DEL CERTIFICADO', '', 1, 1),
(12, 0, 'ALCANCE DE LA CERTIFICACIÓN', '', 1, 1),
(13, 0, 'NO. DE CLIENTE', '', 1, 1),
(14, 0, 'NÚMERO DE DICTAMEN EMITIDO POR LA UVEM ', '', 1, 1),
(15, 0, 'ACTA DE LA UNIDAD DE INSPECCIÓN (FECHA DE INICIO, TÉRMINO Y FIRMAS)', '', 1, 1),
(16, 0, 'NOMBRE Y PUESTO DEL RESPONSABLE DE LA EMISIÓN DEL CERTIFICADO', '', 1, 1),
(17, 0, 'NOMBRE Y DIRECCIÓN DEL ORGANISMO CERTIFICADOR CIDAM', '', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('p7IGqB4botO0PUn6jV7iOFeZHql0Mv5wdZFBNgov', 20, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOXlkakVzYzdONW04OTBEaFZEd1lxTm4zQm4xU0dyTWxaYkc5TzY1UiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9maWxlcy9OT00tMDcwLTAwMUMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMDtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMiRzb0RZL2J2REJ1NDNuZjJUdGdTMEdPb2J2QUhvY3dnRVFReElwU1ZRQU45cG9Tb3Y2d0x1QyI7fQ==', 1729006602);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `folio` varchar(30) NOT NULL,
  `estatus` varchar(40) NOT NULL DEFAULT 'Pendiente',
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_visita` datetime NOT NULL,
  `id_instalacion` int(11) NOT NULL,
  `id_predio` int(11) NOT NULL DEFAULT -1,
  `info_adicional` varchar(10000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `id_empresa`, `id_tipo`, `folio`, `estatus`, `fecha_solicitud`, `fecha_visita`, `id_instalacion`, `id_predio`, `info_adicional`, `created_at`, `updated_at`) VALUES
(1, 1, 14, 'SOL-12064-O', 'Pendiente', '2024-08-14 16:44:18', '2024-08-15 09:33:45', 1, -1, '', '2024-08-14 22:39:23', '2024-08-14 22:39:23'),
(2, 3, 2, 'SOL-12065-O', 'Pendiente', '2024-08-15 10:46:33', '2024-08-15 18:46:17', 1, -1, '', '2024-08-15 16:46:33', '2024-08-15 16:46:33'),
(3, 1, 14, 'SOL-2024-00003', 'Pendiente', '2024-09-05 17:09:54', '2024-09-24 12:00:00', 2, -1, 'sdsds', '2024-09-06 05:09:54', '2024-09-06 05:09:54'),
(4, 3, 14, 'SOL-2024-00004', 'Pendiente', '2024-09-05 17:17:58', '2024-09-10 12:00:00', 6, -1, 'sdsfsd', '2024-09-06 05:17:58', '2024-09-06 05:17:58'),
(5, 3, 14, 'SOL-2024-00005', 'Pendiente', '2024-09-05 17:19:25', '2024-09-26 12:00:00', 6, -1, 'sdsdsd', '2024-09-06 05:19:25', '2024-09-06 05:19:25'),
(6, 1, 14, 'SOL-2024-00006', 'Pendiente', '2024-09-05 17:29:41', '2024-09-10 12:00:00', 2, -1, 'dfdf', '2024-09-06 05:29:41', '2024-09-06 05:29:41'),
(7, 3, 14, 'SOL-2024-00007', 'Pendiente', '2024-09-05 17:35:29', '2024-09-26 12:00:00', 7, -1, 'dfdf', '2024-09-06 05:35:29', '2024-09-06 05:35:29'),
(8, 3, 14, 'SOL-2024-00008', 'Pendiente', '2024-09-05 17:49:22', '2024-09-24 12:05:00', 6, -1, 'prueba de hora', '2024-09-05 23:49:22', '2024-09-05 23:49:22'),
(9, 1, 14, 'SOL-2024-00009', 'Pendiente', '2024-09-05 17:51:50', '2024-09-17 12:00:00', 1, -1, 'es una ptrubea', '2024-09-05 23:51:50', '2024-09-05 23:51:50'),
(10, 3, 14, 'SOL-2024-00010', 'Pendiente', '2024-09-06 10:01:13', '2024-09-17 12:00:00', 7, -1, NULL, '2024-09-06 16:01:13', '2024-09-06 16:01:13'),
(11, 1, 14, 'SOL-2024-00011', 'Pendiente', '2024-09-09 16:53:13', '2024-09-10 12:00:00', 2, -1, 'sdds', '2024-09-09 22:53:13', '2024-09-09 22:53:13'),
(12, 3, 14, 'SOL-2024-00012', 'Pendiente', '2024-09-09 17:26:03', '2024-09-10 12:00:00', 8, -1, NULL, '2024-09-09 23:26:03', '2024-09-09 23:26:03'),
(13, 1, 14, 'SOL-2024-00013', 'Pendiente', '2024-09-09 17:30:52', '2024-09-09 12:00:00', 2, -1, 'sdsds', '2024-09-09 23:30:52', '2024-09-09 23:30:52'),
(14, 1, 14, 'SOL-2024-00014', 'Pendiente', '2024-09-10 09:27:04', '2024-09-10 12:00:00', 2, -1, 'sdsds', '2024-09-10 15:27:04', '2024-09-10 15:27:04'),
(15, 3, 14, 'SOL-2024-00015', 'Pendiente', '2024-09-10 09:28:58', '2024-09-18 12:00:00', 8, -1, 'es de crista', '2024-09-10 15:28:58', '2024-09-10 15:28:58'),
(16, 3, 14, 'SOL-2024-00016', 'Pendiente', '2024-09-10 09:38:30', '2024-09-10 12:00:00', 8, -1, NULL, '2024-09-10 15:38:30', '2024-09-10 15:38:30'),
(17, 1, 14, 'SOL-2024-00017', 'Pendiente', '2024-09-11 09:45:05', '2024-09-10 12:00:00', 2, -1, 'fdsdf', '2024-09-11 15:45:05', '2024-09-11 15:45:05'),
(18, 1, 14, 'SOL-2024-00018', 'Pendiente', '2024-09-11 13:08:21', '2024-09-17 12:00:00', 2, -1, 'sdsds', '2024-09-11 19:08:21', '2024-09-11 19:08:21'),
(19, 1, 14, 'SOL-2024-00019', 'Pendiente', '2024-09-11 14:09:36', '2024-09-11 12:00:00', 2, -1, 'dfdfdf', '2024-09-11 20:09:36', '2024-09-11 20:09:36'),
(20, 1, 10, 'SOL-2024-00020', 'Pendiente', '2024-09-11 14:24:04', '2024-09-17 12:00:00', 0, 3, 'ssds', '2024-09-11 20:24:04', '2024-09-11 20:24:04'),
(21, 1, 14, 'SOL-2024-00021', 'Pendiente', '2024-09-18 13:05:43', '2024-09-18 12:00:00', 12, -1, 'dfdfdfdfdf', '2024-09-18 19:05:43', '2024-09-18 19:05:43'),
(22, 1, 10, 'SOL-2024-00022', 'Pendiente', '2024-10-07 10:58:40', '2024-10-07 12:00:00', 0, 1, NULL, '2024-10-07 16:58:40', '2024-10-07 16:58:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_tipo`
--

CREATE TABLE `solicitudes_tipo` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(70) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes_tipo`
--

INSERT INTO `solicitudes_tipo` (`id_tipo`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'Muestreo de agave (ART)', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(2, 'Vigilancia en producción de lote', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(3, 'Muestreo de lote a granel', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(4, 'Vigilancia en el traslado del lote', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(5, 'Inspección de envasado', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(6, 'Muestreo de lote envasado', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(7, 'Inspeccion ingreso a barrica/ contenedor de vidrio', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(8, 'Liberación de productoterminado', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(9, 'Inspección de liberación a barrica/contenedor de vidrio', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(10, 'Georreferenciación', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(11, 'Pedidos para exportación', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(12, 'Emisión de certificado NOM a granel', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(13, 'Emisión de certificado venta nacional', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(14, 'Dictaminación de instalaciones', '2024-08-20 23:04:11', '2024-08-20 23:04:11'),
(15, 'Renovación de dictaminación de instalaciones', '2024-08-20 23:04:23', '2024-08-20 23:04:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_hologramas`
--

CREATE TABLE `solicitud_hologramas` (
  `id_solicitud` int(11) NOT NULL,
  `folio` varchar(15) NOT NULL,
  `id_empresa` int(11) NOT NULL COMMENT 'Relación con tabla empresas',
  `id_solicitante` int(11) NOT NULL COMMENT 'Relación con tabla users',
  `id_marca` int(11) NOT NULL COMMENT 'Relación con tabla marcas',
  `cantidad_hologramas` int(11) NOT NULL,
  `id_direccion` int(11) NOT NULL COMMENT 'Relación con tabla direcciones',
  `folio_inicial` varchar(50) DEFAULT NULL,
  `folio_final` varchar(50) DEFAULT NULL,
  `estatus` varchar(40) NOT NULL DEFAULT 'Pendiente',
  `comentarios` varchar(900) DEFAULT NULL,
  `tipo_pago` int(11) DEFAULT NULL COMMENT '1. pago parcial / 2. pago completo',
  `fecha_envio` date DEFAULT NULL,
  `costo_envio` double DEFAULT NULL,
  `no_guia` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_hologramas`
--

INSERT INTO `solicitud_hologramas` (`id_solicitud`, `folio`, `id_empresa`, `id_solicitante`, `id_marca`, `cantidad_hologramas`, `id_direccion`, `folio_inicial`, `folio_final`, `estatus`, `comentarios`, `tipo_pago`, `fecha_envio`, `costo_envio`, `no_guia`, `created_at`, `updated_at`) VALUES
(4, 'INV-036/2021', 3, 24, 3, 101, 782, '1', '101', 'Completado', NULL, NULL, NULL, NULL, NULL, '2024-08-30 00:12:15', '2024-08-30 00:14:49'),
(5, 'INV-037/2021', 3, 24, 2, 89, 783, '101', '189', 'Completado', NULL, NULL, NULL, NULL, NULL, '2024-08-30 00:13:38', '2024-08-30 00:13:51'),
(6, 'INV-038/2024', 3, 24, 2, 1000, 783, '190', '1189', 'Asignado', 'tendría que ir del 180 al 1000', NULL, NULL, NULL, NULL, '2024-09-05 05:07:27', '2024-09-05 05:08:13'),
(7, '56565', 3, 20, 3, 6565, 783, '102', '6666', 'Pendiente', 'dfgfg', NULL, NULL, NULL, NULL, '2024-09-18 19:07:40', '2024-09-18 19:07:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_informacion`
--

CREATE TABLE `solicitud_informacion` (
  `id` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `info_procesos` varchar(2000) NOT NULL,
  `medios` char(2) DEFAULT NULL,
  `competencia` char(2) DEFAULT NULL,
  `capacidad` char(2) DEFAULT NULL,
  `comentarios` varchar(1500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_informacion`
--

INSERT INTO `solicitud_informacion` (`id`, `id_empresa`, `fecha_registro`, `info_procesos`, `medios`, `competencia`, `capacidad`, `comentarios`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-08-26 16:13:07', 'NA', 'Si', 'Si', 'Si', NULL, '2024-08-26 22:13:07', '2024-08-26 22:21:52'),
(2, 2, '2024-08-26 16:16:54', 'NA', 'Si', 'Si', 'Si', NULL, '2024-08-26 22:16:54', '2024-08-26 22:22:05'),
(3, 3, '2024-08-26 16:21:15', 'NA', 'Si', 'Si', 'Si', NULL, '2024-08-26 22:21:15', '2024-08-26 22:22:20'),
(4, 4, '2024-10-07 15:26:09', 'Soy productor de mezcal', NULL, NULL, NULL, NULL, '2024-10-07 15:26:09', '2024-10-07 15:26:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `teams`
--

INSERT INTO `teams` (`id`, `user_id`, `name`, `personal_team`, `created_at`, `updated_at`) VALUES
(1, 1, 'Administrador\'s Team', 1, '2024-06-25 05:17:15', '2024-06-25 05:17:15'),
(2, 2, 'Ramsés\'s Team', 1, '2024-06-25 06:13:35', '2024-06-25 06:13:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `team_invitations`
--

CREATE TABLE `team_invitations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `team_user`
--

CREATE TABLE `team_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT 1 COMMENT '1. Personal oc 2. Inspectores 3. Clientes',
  `id_empresa` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `password_original` varchar(100) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `tipo`, `id_empresa`, `name`, `email`, `email_verified_at`, `password`, `password_original`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(14, 2, 0, 'Karen Velazquez', 'kvelazquez@erpcidam.com', NULL, '$2y$12$PgCqh.1PI5ZkWpXSoIOrEu7dVSvkmfuk.azbdTHRTvgmginJFKjVK', 'ppUbhxIpH8', NULL, NULL, NULL, NULL, NULL, 'profile-photos/Sol8hikrfNcfWik1SlczsWSdfSOuhsBdzHAb2LHq.png', '2024-07-18 04:53:03', '2024-09-19 19:55:11'),
(18, 1, 0, 'Karen Pérez', 'kperez@erpcidam.com', NULL, '$2y$12$gES6hsJnqfceonJ.Tk9xPuD/HLdSC6k5v2p4UZGpWnNDMb.trH9Z2', 'zKWCDDKX1k', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-23 01:35:23', '2024-07-23 01:35:23'),
(19, 1, 0, 'Mayra Gutierrez', 'mgutierrez@cidam.com', NULL, '$2y$12$Jg21fqsMOj/pyVLoAIcdWeYxy48NaNWqyRjK434hIN0ljdsvu4Nia', 'Zux41ak3cQ', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-23 01:35:41', '2024-08-13 21:31:39'),
(20, 1, 0, 'Eva Viviana Soto Barrietos', 'esoto@cidam.org', NULL, '$2y$12$soDY/bvDBu43nf2TtgS0GOobvAHocwgEQQxIpSVQAN9poSov6wLuC', 'zimYKz0rMB', NULL, NULL, NULL, NULL, NULL, 'profile-photos/BhBDCJXyRW53KtSajHyLVlYYLtYAJDrmVLGOC8aR.png', '2024-07-23 01:36:02', '2024-09-19 19:28:43'),
(21, 2, 0, 'Zaida Selenia Coronado', 'zcoronado@erpcidam.com', NULL, '$2y$12$pfsXVnlo8Fo8gjEAvYeJFeCgmXFDT8vlazO6ylyr0/j/uMevj4GK.', 'upJ7uLoaVR', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-23 01:37:43', '2024-07-23 01:37:43'),
(24, 0, 0, 'Administrador CIDAM2', 'admin@erpcidam.com', NULL, '$2y$12$24OgsyklQpx0i8dFkF0rzO4SArfDxUnmpVMmG.YVhzMQHd12FdRGO', 'GPrbLS6ELk', NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-08 05:22:44', '2024-08-13 04:12:09'),
(26, 4, 0, 'Miguel Ángel Gómez Romero', 'mromero@cidam.org', NULL, '$2y$12$dJrSDpuV69Oh5MNcmsfMIO5CTGjA.J7dbuO2sPcBZdjhasXl4pC6i', 't8eJoug6FC', NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 04:30:29', '2024-08-20 04:32:52'),
(27, 3, 3, 'Oralia Aragón', 'oaragon@crista.com', NULL, '$2y$12$zt7RsjVLY5uJw3vqXMq3Qe46rdruJs.B7l6.C5MOphjSM6l68Y/Wq', '9sGyrmF5Es', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-02 21:42:48', '2024-09-02 21:42:48');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actas_equipo_envasado`
--
ALTER TABLE `actas_equipo_envasado`
  ADD PRIMARY KEY (`id_equipo_envasado`);

--
-- Indices de la tabla `actas_equipo_mezcal`
--
ALTER TABLE `actas_equipo_mezcal`
  ADD PRIMARY KEY (`id_mezcal`);

--
-- Indices de la tabla `actas_inspeccion`
--
ALTER TABLE `actas_inspeccion`
  ADD PRIMARY KEY (`id_acta`);

--
-- Indices de la tabla `actas_produccion`
--
ALTER TABLE `actas_produccion`
  ADD PRIMARY KEY (`id_produccion`);

--
-- Indices de la tabla `actas_testigo`
--
ALTER TABLE `actas_testigo`
  ADD PRIMARY KEY (`id_acta_testigo`);

--
-- Indices de la tabla `actas_unidad_comercializacion`
--
ALTER TABLE `actas_unidad_comercializacion`
  ADD PRIMARY KEY (`id_comercializacion`);

--
-- Indices de la tabla `actas_unidad_envasado`
--
ALTER TABLE `actas_unidad_envasado`
  ADD PRIMARY KEY (`id_envasado`);

--
-- Indices de la tabla `acta_produccion_mezcal`
--
ALTER TABLE `acta_produccion_mezcal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `activar_hologramas`
--
ALTER TABLE `activar_hologramas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `catalogo_actividad_cliente`
--
ALTER TABLE `catalogo_actividad_cliente`
  ADD PRIMARY KEY (`id_actividad`);

--
-- Indices de la tabla `catalogo_categorias`
--
ALTER TABLE `catalogo_categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `catalogo_clases`
--
ALTER TABLE `catalogo_clases`
  ADD PRIMARY KEY (`id_clase`);

--
-- Indices de la tabla `catalogo_equipos`
--
ALTER TABLE `catalogo_equipos`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `catalogo_norma_certificar`
--
ALTER TABLE `catalogo_norma_certificar`
  ADD PRIMARY KEY (`id_norma`);

--
-- Indices de la tabla `catalogo_organismos`
--
ALTER TABLE `catalogo_organismos`
  ADD PRIMARY KEY (`id_organismo`);

--
-- Indices de la tabla `catalogo_producto_certificar`
--
ALTER TABLE `catalogo_producto_certificar`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `catalogo_tipo_agave`
--
ALTER TABLE `catalogo_tipo_agave`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`id_certificado`);

--
-- Indices de la tabla `certificados_revision`
--
ALTER TABLE `certificados_revision`
  ADD PRIMARY KEY (`id_revision`);

--
-- Indices de la tabla `dictamenes_envasado`
--
ALTER TABLE `dictamenes_envasado`
  ADD PRIMARY KEY (`id_dictamen_envasado`);

--
-- Indices de la tabla `dictamenes_granel`
--
ALTER TABLE `dictamenes_granel`
  ADD PRIMARY KEY (`id_dictamen`);

--
-- Indices de la tabla `dictamenes_instalaciones`
--
ALTER TABLE `dictamenes_instalaciones`
  ADD PRIMARY KEY (`id_dictamen`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_direccion`);

--
-- Indices de la tabla `documentacion`
--
ALTER TABLE `documentacion`
  ADD PRIMARY KEY (`id_documento`);

--
-- Indices de la tabla `documentacion_url`
--
ALTER TABLE `documentacion_url`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `empresa_actividad_cliente`
--
ALTER TABLE `empresa_actividad_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa_contrato`
--
ALTER TABLE `empresa_contrato`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indices de la tabla `empresa_norma_certificar`
--
ALTER TABLE `empresa_norma_certificar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa_num_cliente`
--
ALTER TABLE `empresa_num_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa_producto_certificar`
--
ALTER TABLE `empresa_producto_certificar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `guias`
--
ALTER TABLE `guias`
  ADD PRIMARY KEY (`id_guia`);

--
-- Indices de la tabla `inspecciones`
--
ALTER TABLE `inspecciones`
  ADD PRIMARY KEY (`id_inspeccion`);

--
-- Indices de la tabla `instalaciones`
--
ALTER TABLE `instalaciones`
  ADD PRIMARY KEY (`id_instalacion`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lotes_envasado`
--
ALTER TABLE `lotes_envasado`
  ADD PRIMARY KEY (`id_lote_envasado`);

--
-- Indices de la tabla `lotes_envasado_granel`
--
ALTER TABLE `lotes_envasado_granel`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lotes_granel`
--
ALTER TABLE `lotes_granel`
  ADD PRIMARY KEY (`id_lote_granel`);

--
-- Indices de la tabla `lotes_granel_guias`
--
ALTER TABLE `lotes_granel_guias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `predios`
--
ALTER TABLE `predios`
  ADD PRIMARY KEY (`id_predio`);

--
-- Indices de la tabla `predios_caracteristicas_maguey`
--
ALTER TABLE `predios_caracteristicas_maguey`
  ADD PRIMARY KEY (`id_caracteristica`);

--
-- Indices de la tabla `predios_coordenadas`
--
ALTER TABLE `predios_coordenadas`
  ADD PRIMARY KEY (`id_coordenada`);

--
-- Indices de la tabla `predios_inspeccion`
--
ALTER TABLE `predios_inspeccion`
  ADD PRIMARY KEY (`id_inspeccion`);

--
-- Indices de la tabla `predio_plantacion`
--
ALTER TABLE `predio_plantacion`
  ADD PRIMARY KEY (`id_plantacion`);

--
-- Indices de la tabla `revision_preguntas`
--
ALTER TABLE `revision_preguntas`
  ADD PRIMARY KEY (`id_pregunta`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_solicitud`);

--
-- Indices de la tabla `solicitudes_tipo`
--
ALTER TABLE `solicitudes_tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `solicitud_hologramas`
--
ALTER TABLE `solicitud_hologramas`
  ADD PRIMARY KEY (`id_solicitud`);

--
-- Indices de la tabla `solicitud_informacion`
--
ALTER TABLE `solicitud_informacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_user_id_index` (`user_id`);

--
-- Indices de la tabla `team_invitations`
--
ALTER TABLE `team_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `team_invitations_team_id_email_unique` (`team_id`,`email`);

--
-- Indices de la tabla `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `empresa_user` (`id_empresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actas_equipo_envasado`
--
ALTER TABLE `actas_equipo_envasado`
  MODIFY `id_equipo_envasado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `actas_equipo_mezcal`
--
ALTER TABLE `actas_equipo_mezcal`
  MODIFY `id_mezcal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `actas_inspeccion`
--
ALTER TABLE `actas_inspeccion`
  MODIFY `id_acta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `actas_produccion`
--
ALTER TABLE `actas_produccion`
  MODIFY `id_produccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `actas_testigo`
--
ALTER TABLE `actas_testigo`
  MODIFY `id_acta_testigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `actas_unidad_comercializacion`
--
ALTER TABLE `actas_unidad_comercializacion`
  MODIFY `id_comercializacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `actas_unidad_envasado`
--
ALTER TABLE `actas_unidad_envasado`
  MODIFY `id_envasado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `acta_produccion_mezcal`
--
ALTER TABLE `acta_produccion_mezcal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `activar_hologramas`
--
ALTER TABLE `activar_hologramas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `catalogo_actividad_cliente`
--
ALTER TABLE `catalogo_actividad_cliente`
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `catalogo_categorias`
--
ALTER TABLE `catalogo_categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `catalogo_clases`
--
ALTER TABLE `catalogo_clases`
  MODIFY `id_clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `catalogo_equipos`
--
ALTER TABLE `catalogo_equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `catalogo_norma_certificar`
--
ALTER TABLE `catalogo_norma_certificar`
  MODIFY `id_norma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `catalogo_organismos`
--
ALTER TABLE `catalogo_organismos`
  MODIFY `id_organismo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `catalogo_producto_certificar`
--
ALTER TABLE `catalogo_producto_certificar`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `catalogo_tipo_agave`
--
ALTER TABLE `catalogo_tipo_agave`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `certificados`
--
ALTER TABLE `certificados`
  MODIFY `id_certificado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `certificados_revision`
--
ALTER TABLE `certificados_revision`
  MODIFY `id_revision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `dictamenes_envasado`
--
ALTER TABLE `dictamenes_envasado`
  MODIFY `id_dictamen_envasado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `dictamenes_granel`
--
ALTER TABLE `dictamenes_granel`
  MODIFY `id_dictamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `dictamenes_instalaciones`
--
ALTER TABLE `dictamenes_instalaciones`
  MODIFY `id_dictamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=785;

--
-- AUTO_INCREMENT de la tabla `documentacion`
--
ALTER TABLE `documentacion`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de la tabla `documentacion_url`
--
ALTER TABLE `documentacion_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empresa_actividad_cliente`
--
ALTER TABLE `empresa_actividad_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `empresa_contrato`
--
ALTER TABLE `empresa_contrato`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `empresa_norma_certificar`
--
ALTER TABLE `empresa_norma_certificar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `empresa_num_cliente`
--
ALTER TABLE `empresa_num_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `empresa_producto_certificar`
--
ALTER TABLE `empresa_producto_certificar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guias`
--
ALTER TABLE `guias`
  MODIFY `id_guia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `inspecciones`
--
ALTER TABLE `inspecciones`
  MODIFY `id_inspeccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `instalaciones`
--
ALTER TABLE `instalaciones`
  MODIFY `id_instalacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lotes_envasado`
--
ALTER TABLE `lotes_envasado`
  MODIFY `id_lote_envasado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `lotes_envasado_granel`
--
ALTER TABLE `lotes_envasado_granel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `lotes_granel`
--
ALTER TABLE `lotes_granel`
  MODIFY `id_lote_granel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `lotes_granel_guias`
--
ALTER TABLE `lotes_granel_guias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `predios`
--
ALTER TABLE `predios`
  MODIFY `id_predio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT de la tabla `predios_caracteristicas_maguey`
--
ALTER TABLE `predios_caracteristicas_maguey`
  MODIFY `id_caracteristica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `predios_coordenadas`
--
ALTER TABLE `predios_coordenadas`
  MODIFY `id_coordenada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT de la tabla `predios_inspeccion`
--
ALTER TABLE `predios_inspeccion`
  MODIFY `id_inspeccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `predio_plantacion`
--
ALTER TABLE `predio_plantacion`
  MODIFY `id_plantacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT de la tabla `revision_preguntas`
--
ALTER TABLE `revision_preguntas`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `solicitudes_tipo`
--
ALTER TABLE `solicitudes_tipo`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `solicitud_hologramas`
--
ALTER TABLE `solicitud_hologramas`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `solicitud_informacion`
--
ALTER TABLE `solicitud_informacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `team_invitations`
--
ALTER TABLE `team_invitations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `team_user`
--
ALTER TABLE `team_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `team_invitations`
--
ALTER TABLE `team_invitations`
  ADD CONSTRAINT `team_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
