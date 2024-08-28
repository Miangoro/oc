-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2024 a las 23:26:23
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
(3, 'lotesgranel', 'El usuario Administrador CIDAM2 creó un registro de lotes a granel el 26/08/2024', 'App\\Models\\LotesGranel', 'created', 1, 'App\\Models\\User', 24, '{\"attributes\":{\"id_empresa\":1,\"nombre_lote\":\"JL-01-A\",\"tipo_lote\":1,\"folio_fq\":\"NNMZ-15905 y ----\",\"volumen\":96.7,\"cont_alc\":45.1,\"id_categoria\":1,\"id_clase\":1,\"id_tipo\":2,\"ingredientes\":null,\"edad\":null,\"id_guia\":null,\"folio_certificado\":null,\"id_organismo\":null,\"fecha_emision\":null,\"fecha_vigencia\":null}}', NULL, '2024-08-27 01:49:47', '2024-08-27 01:49:47');

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
('0a1eb97fdac342b99855823da06faa19', 'i:2;', 1724081707),
('0a1eb97fdac342b99855823da06faa19:timer', 'i:1724081707;', 1724081707),
('385be68248373048043127118d6ac36e', 'i:1;', 1724689340),
('385be68248373048043127118d6ac36e:timer', 'i:1724689340;', 1724689340),
('594a328cc8bf6717499389a4726333ed', 'i:1;', 1723755754),
('594a328cc8bf6717499389a4726333ed:timer', 'i:1723755754;', 1723755754),
('72c943604f1c6eab0cfe7e1708538b8a', 'i:1;', 1724355190),
('72c943604f1c6eab0cfe7e1708538b8a:timer', 'i:1724355190;', 1724355190),
('81766c31b593acd67d06e0b5f7af4a03', 'i:1;', 1723664075),
('81766c31b593acd67d06e0b5f7af4a03:timer', 'i:1723664075;', 1723664075),
('admin@argon.com|127.0.0.1', 'i:2;', 1724081708),
('admin@argon.com|127.0.0.1:timer', 'i:1724081708;', 1724081708);

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
(1, 'Mezcal', '2024-07-09 22:58:30', '2024-07-13 07:00:03');

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
  `id_empresa` int(11) NOT NULL,
  `id_domicilio` int(11) NOT NULL,
  `num_certificado` varchar(25) NOT NULL,
  `fecha_vigencia` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `maestro_mezcalero` varchar(60) NOT NULL,
  `num_autorizacion` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 4, 1, 1, 'UMC-002/2024', '2024-01-11', '2025-01-10', '[\"Blanco o Joven\"]', '[\"Blanco o Joven\"]', '2024-08-27 00:58:02', '2024-08-27 00:58:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_direccion` int(11) NOT NULL,
  `tipo_direccion` int(11) NOT NULL COMMENT '1. Exportación - 2 venta nacional 3 hologramas',
  `id_empresa` int(11) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `destinatario` varchar(100) NOT NULL,
  `aduana` varchar(150) NOT NULL,
  `pais_destino` varchar(60) NOT NULL,
  `nombre_recibe` varchar(60) NOT NULL,
  `correo_recibe` varchar(30) NOT NULL,
  `celular_recibe` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id_direccion`, `tipo_direccion`, `id_empresa`, `direccion`, `destinatario`, `aduana`, `pais_destino`, `nombre_recibe`, `correo_recibe`, `celular_recibe`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Calle progreso 250,  Morelos, Morelia, Michoacán', 'NA', 'NA', 'NA', 'Juan Pérez', 'juan@gmail.com', '435103702', '2024-08-26 16:41:18', '2024-08-26 16:41:18');

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
(34, 'Comprobante de posesión de instalaciones (Si es propietario, este documento debe estar a nombre de la persona física o moral que se inscribe) o Contrato de arrendamiento', 'Generales Productor', 'Generales Productor', 0),
(35, 'Copia de la identificación oficial vigente del arrendador y arrendatario (En caso de no ser propietario de las instalaciones)', 'Generales Productor', 'Generales Productor', 0),
(36, 'Formato 32-D Opinión de cumplimiento de obligaciones fiscales del SAT', 'Generales Comercializador', 'Generales Comercializador', 0),
(37, 'Juegos de etiquetas o constancia de cumplimiento emitida por la unidad de verificación titulo de la marca', 'Generales Comercializador', 'Generales Comercializador', 0),
(38, 'Comprobante de trámite de marca (En caso de que su marca este en trámite)', 'Generales Comercializador', 'Generales Comercializador', 0),
(39, 'Carta responsiva de trámite (En caso de que su marca este en trámite)', 'Generales Comercializador', 'Generales Comercializador', 0),
(40, 'Licencia de uso o cesión de derechos (En caso de no ser propietario de la marca)', 'Generales Comercializador', 'Generales Comercializador', 0),
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
(82, 'Convenio de corresponsabilidad inscrito ante el IMPI entre el comercializador y un productor autorizado', 'Generales Comercializador', 'Generales Comercializador', 0),
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
(107, 'Título de la marca (en caso de ser el propietario, este documento debe estar a nombre de la persona física o moral que se inscribe)', 'Generales Comercializador', 'Generales Comercializador', 0),
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
(132, 'Resultados ART', 'Generales Productor de agave', NULL, NULL);

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
(4, 58, 'Análisis fisicoquímicos: Análisis completo - NNMZ-15905', 1, 'Análisis fisicoquímicos_66ccdc5b748a8.pdf', 1, NULL, NULL, '2024-08-27 01:49:47', '2024-08-27 01:49:47');

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
(2, 'José Jesús Robledo Rodríguez', 'RORJ8006262U3', 'Cupreata, 1, Rancho Los Agaves, C.P. 39100, Mazatlán, Guerrero.', 'No aplica', '12', 'Persona física', 'mezcalrobledo@gmail.com', '747 107 9588', 1, '2024-08-26 22:16:54', 0, '2024-08-26 22:16:54'),
(3, 'Crista la Santa S.A.P.I. de C.V.', 'NCO111222NV5', 'Guillermo González Camarena No. 800 Piso 2, Santa Fe, Álvaro Obregón, Ciudad De México, C.P. 01210.', 'Sergio Rodríguez Molleda y Luis Fernando Félix Fernández', '9', 'Persona moral', 'oaragon@cristalasanta.com.mx', '333 200 9555', 2, '2024-08-26 22:21:15', 20, '2024-08-26 22:36:40');

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
(10, 4, 3, '2024-08-26 22:21:15', '2024-08-26 22:21:15');

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
(15, 3, '2024-08-26', 'NA', 'NA', 'Sociedad anónima promotora de inversión (SAPI)', '51', '2', '2017-07-25', '51', 'Povel Aurelio Oceguera Robledo', 'A2016060', 'Michoacán', NULL, '2024-08-26 22:36:40', '2024-08-26 22:36:40');

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
(6, 2, 3, '2024-08-26 22:21:15', '2024-08-26 22:21:15');

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
(4, 3, 'NOM-070-005C', 1, '2024-08-26 22:36:40', '2024-08-26 22:36:40');

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
(3, 1, 3, '2024-08-26 22:21:15', '2024-08-26 22:21:15');

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
(45, 2, 'Sin asignarG005', 1, 2, 14995, 5, 15000, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:48:54', '2024-08-27 01:48:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspecciones`
--

CREATE TABLE `inspecciones` (
  `id_inspeccion` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL COMMENT 'Relación consolicitudes_tipo',
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

INSERT INTO `inspecciones` (`id_inspeccion`, `id_solicitud`, `id_tipo`, `id_inspector`, `num_servicio`, `fecha_servicio`, `estatus_inspeccion`, `observaciones`, `created_at`, `updated_at`) VALUES
(4, 1, 14, 21, 'UMS-1823/2023', '2024-08-21', 1, '', '2024-08-21 04:40:18', '2024-08-24 05:03:49');

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
  `id_organismo` int(11) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fecha_vigencia` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instalaciones`
--

INSERT INTO `instalaciones` (`id_instalacion`, `id_empresa`, `direccion_completa`, `estado`, `tipo`, `folio`, `id_organismo`, `fecha_emision`, `fecha_vigencia`, `created_at`, `updated_at`) VALUES
(1, 1, 'Albino Garcia 19 Jardines De Torremolinos 58197 Morelia, Morelia , Michoacan', 16, 'Envasadora', NULL, NULL, NULL, NULL, '2024-08-26 22:13:07', '2024-08-26 22:13:07'),
(2, 1, 'Albino Garcia 19 Jardines De Torremolinos 58197 Morelia, Morelia , Michoacan', 16, 'Comercializadora', NULL, NULL, NULL, NULL, '2024-08-26 22:13:07', '2024-08-26 22:13:07'),
(3, 2, 'Cupreata, 1, Rancho Los Agaves, C.P. 39100, Mazatlán, Guerrero.', 12, 'Productora', NULL, NULL, NULL, NULL, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(4, 2, 'Cupreata, 1, Rancho Los Agaves, C.P. 39100, Mazatlán, Guerrero.', 12, 'Envasadora', NULL, NULL, NULL, NULL, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(5, 2, 'Cupreata, 1, Rancho Los Agaves, C.P. 39100, Mazatlán, Guerrero.', 12, 'Comercializadora', NULL, NULL, NULL, NULL, '2024-08-26 22:16:54', '2024-08-26 22:16:54'),
(6, 3, 'Periferico Sur, 8500, El Mante, C.P. 45609, Tlaquepaque, San Pedro Tlaquepaque, Jalisco.', 14, 'Envasadora', NULL, NULL, NULL, NULL, '2024-08-26 22:21:15', '2024-08-26 22:21:15');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lotes_granel`
--

INSERT INTO `lotes_granel` (`id_lote_granel`, `id_empresa`, `nombre_lote`, `tipo_lote`, `folio_fq`, `volumen`, `cont_alc`, `id_categoria`, `id_clase`, `id_tipo`, `ingredientes`, `edad`, `folio_certificado`, `id_organismo`, `fecha_emision`, `fecha_vigencia`, `created_at`, `updated_at`) VALUES
(1, 1, 'JL-01-A', 1, 'NNMZ-15905 y ----', 96.7, 45.1, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-27 01:49:47', '2024-08-27 01:49:47');

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
(1, 1, 41, '2024-08-27 01:49:47', '2024-08-27 01:49:47');

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
(12, '2024_08_20_162835_add_batch_uuid_column_to_activity_log_table', 4);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `predios`
--

INSERT INTO `predios` (`id_predio`, `id_empresa`, `nombre_productor`, `num_predio`, `nombre_predio`, `ubicacion_predio`, `tipo_predio`, `puntos_referencia`, `cuenta_con_coordenadas`, `superficie`, `created_at`, `updated_at`) VALUES
(1, 3, 'Crista la Santa', 'Sin asignar', 'PARCELA 262 Z-2 P1/1 M20063', 'EL ALVAREÑO, VISTA HERMOSA, VISTA HERMOSA, MICHOACÁN', 'Ejidal', 'BODEGA DE VISTA HERMOSA', 'No', 2.50, '2024-08-27 00:08:46', '2024-08-27 00:08:46'),
(2, 1, 'Miguel Ángel Gómez Romero', 'Sin asignar', 'EL RINCON', 'Etucuaro, MADERO, 06, Michoacán', 'Comunal', 'CENTRO DE ETUCUARO', 'No', 8.74, '2024-08-27 01:48:12', '2024-08-27 01:48:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predios_coordenadas`
--

CREATE TABLE `predios_coordenadas` (
  `id_coordenada` int(11) NOT NULL,
  `id_predio` int(11) NOT NULL,
  `latitud` varchar(50) NOT NULL,
  `longitud` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio_plantacion`
--

CREATE TABLE `predio_plantacion` (
  `id_plantacion` int(11) NOT NULL,
  `id_predio` int(11) NOT NULL,
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

INSERT INTO `predio_plantacion` (`id_plantacion`, `id_predio`, `id_tipo`, `num_plantas`, `anio_plantacion`, `tipo_plantacion`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2322, 2016, 'Comercial', '2024-08-27 00:08:46', '2024-08-27 00:08:46'),
(2, 2, 2, 15000, 2017, 'Cultivado', '2024-08-27 01:48:12', '2024-08-27 01:48:12'),
(3, 2, 2, 25000, 2018, 'Cultivado', '2024-08-27 01:48:12', '2024-08-27 01:48:12');

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
('XwvaYNkYpcd6qJdtlljYv6njREknLEfwMpN787mf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidFNXa2ZvMzdpUFdTMk9rUXhCS2VCdHlCUU5zWm9UQWpiZVF6NE5qMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fX0=', 1724706792);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solicitud` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `folio` varchar(30) NOT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_visita` datetime NOT NULL,
  `id_instalacion` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id_solicitud`, `id_empresa`, `id_tipo`, `folio`, `fecha_solicitud`, `fecha_visita`, `id_instalacion`, `created_at`, `updated_at`) VALUES
(1, 1, 14, 'SOL-12064-O', '2024-08-14 16:44:18', '2024-08-15 09:33:45', 1, '2024-08-14 22:39:23', '2024-08-14 22:39:23'),
(2, 3, 2, 'SOL-12065-O', '2024-08-15 10:46:33', '2024-08-15 18:46:17', 1, '2024-08-15 16:46:33', '2024-08-15 16:46:33');

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
  `comentarios` varchar(900) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_hologramas`
--

INSERT INTO `solicitud_hologramas` (`id_solicitud`, `folio`, `id_empresa`, `id_solicitante`, `id_marca`, `cantidad_hologramas`, `id_direccion`, `comentarios`, `created_at`, `updated_at`) VALUES
(1, 'INV-036/2021', 1, 24, 1, 210, 1, 'NA', '2024-08-26 22:44:12', '2024-08-26 22:44:12');

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
(3, 3, '2024-08-26 16:21:15', 'NA', 'Si', 'Si', 'Si', NULL, '2024-08-26 22:21:15', '2024-08-26 22:22:20');

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
(14, 2, 0, 'Karen Velazquez', 'kvelazquez@erpcidam.com', NULL, '$2y$12$PgCqh.1PI5ZkWpXSoIOrEu7dVSvkmfuk.azbdTHRTvgmginJFKjVK', 'ppUbhxIpH8', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-18 04:53:03', '2024-07-23 01:37:01'),
(18, 1, 0, 'Karen Pérez', 'kperez@erpcidam.com', NULL, '$2y$12$gES6hsJnqfceonJ.Tk9xPuD/HLdSC6k5v2p4UZGpWnNDMb.trH9Z2', 'zKWCDDKX1k', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-23 01:35:23', '2024-07-23 01:35:23'),
(19, 1, 0, 'Mayra Gutierrez', 'mgutierrez@cidam.com', NULL, '$2y$12$Jg21fqsMOj/pyVLoAIcdWeYxy48NaNWqyRjK434hIN0ljdsvu4Nia', 'Zux41ak3cQ', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-23 01:35:41', '2024-08-13 21:31:39'),
(20, 1, 0, 'Eva Viviana Soto Barrietos', 'esoto@cidam.org', NULL, '$2y$12$soDY/bvDBu43nf2TtgS0GOobvAHocwgEQQxIpSVQAN9poSov6wLuC', 'zimYKz0rMB', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-23 01:36:02', '2024-07-23 01:36:02'),
(21, 2, 0, 'Zaida Selenia Coronado', 'zcoronado@erpcidam.com', NULL, '$2y$12$pfsXVnlo8Fo8gjEAvYeJFeCgmXFDT8vlazO6ylyr0/j/uMevj4GK.', 'upJ7uLoaVR', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-23 01:37:43', '2024-07-23 01:37:43'),
(24, 0, 0, 'Administrador CIDAM2', 'admin@erpcidam.com', NULL, '$2y$12$24OgsyklQpx0i8dFkF0rzO4SArfDxUnmpVMmG.YVhzMQHd12FdRGO', 'GPrbLS6ELk', NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-08 05:22:44', '2024-08-13 04:12:09'),
(26, 4, 0, 'Miguel Ángel Gómez Romero', 'mromero@cidam.org', NULL, '$2y$12$dJrSDpuV69Oh5MNcmsfMIO5CTGjA.J7dbuO2sPcBZdjhasXl4pC6i', 't8eJoug6FC', NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-20 04:30:29', '2024-08-20 04:32:52');

--
-- Índices para tablas volcadas
--

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
-- Indices de la tabla `predios_coordenadas`
--
ALTER TABLE `predios_coordenadas`
  ADD PRIMARY KEY (`id_coordenada`);

--
-- Indices de la tabla `predio_plantacion`
--
ALTER TABLE `predio_plantacion`
  ADD PRIMARY KEY (`id_plantacion`);

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
-- AUTO_INCREMENT de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `catalogo_actividad_cliente`
--
ALTER TABLE `catalogo_actividad_cliente`
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `catalogo_categorias`
--
ALTER TABLE `catalogo_categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `catalogo_clases`
--
ALTER TABLE `catalogo_clases`
  MODIFY `id_clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id_certificado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dictamenes_instalaciones`
--
ALTER TABLE `dictamenes_instalaciones`
  MODIFY `id_dictamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `documentacion`
--
ALTER TABLE `documentacion`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de la tabla `documentacion_url`
--
ALTER TABLE `documentacion_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empresa_actividad_cliente`
--
ALTER TABLE `empresa_actividad_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `empresa_contrato`
--
ALTER TABLE `empresa_contrato`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `empresa_norma_certificar`
--
ALTER TABLE `empresa_norma_certificar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `empresa_num_cliente`
--
ALTER TABLE `empresa_num_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empresa_producto_certificar`
--
ALTER TABLE `empresa_producto_certificar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guias`
--
ALTER TABLE `guias`
  MODIFY `id_guia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `inspecciones`
--
ALTER TABLE `inspecciones`
  MODIFY `id_inspeccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `instalaciones`
--
ALTER TABLE `instalaciones`
  MODIFY `id_instalacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lotes_envasado`
--
ALTER TABLE `lotes_envasado`
  MODIFY `id_lote_envasado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lotes_envasado_granel`
--
ALTER TABLE `lotes_envasado_granel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lotes_granel`
--
ALTER TABLE `lotes_granel`
  MODIFY `id_lote_granel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `lotes_granel_guias`
--
ALTER TABLE `lotes_granel_guias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `predios`
--
ALTER TABLE `predios`
  MODIFY `id_predio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `predios_coordenadas`
--
ALTER TABLE `predios_coordenadas`
  MODIFY `id_coordenada` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `predio_plantacion`
--
ALTER TABLE `predio_plantacion`
  MODIFY `id_plantacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitudes_tipo`
--
ALTER TABLE `solicitudes_tipo`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `solicitud_hologramas`
--
ALTER TABLE `solicitud_hologramas`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `solicitud_informacion`
--
ALTER TABLE `solicitud_informacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
