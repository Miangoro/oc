-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 22:54:21
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
-- Estructura de tabla para la tabla `documentacion_url`
--

CREATE TABLE `documentacion_url` (
  `id` int(11) NOT NULL,
  `id_documento` int(11) NOT NULL,
  `nombre_documento` varchar(200) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `id_relacion` int(11) NOT NULL,
  `fecha_vigencia` date NOT NULL,
  `id_usuario_registro` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentacion_url`
--

INSERT INTO `documentacion_url` (`id`, `id_documento`, `nombre_documento`, `id_empresa`, `url`, `id_relacion`, `fecha_vigencia`, `id_usuario_registro`, `created_at`, `updated_at`) VALUES
(32, 51, 'Comprobante de pago', 3, 'Comprobante de pago_1729701696.png', 1, '0000-00-00', NULL, '2024-10-23 16:41:37', '2024-10-23 16:41:37'),
(33, 60, 'Etiquetas', 1, 'Etiquetas_1729701788.sql', 14, '0000-00-00', NULL, '2024-10-23 16:43:08', '2024-10-23 16:43:08'),
(34, 75, 'Corrugado', 1, 'Corrugado_1729701788.sql', 14, '0000-00-00', NULL, '2024-10-23 16:43:08', '2024-10-23 16:43:08'),
(35, 60, 'Etiquetas', 1, 'Etiquetas_1729701842.sql', 8, '0000-00-00', NULL, '2024-10-23 16:44:02', '2024-10-23 16:44:02'),
(36, 75, 'Corrugado', 1, 'Corrugado_1729701842.sql', 8, '0000-00-00', NULL, '2024-10-23 16:44:02', '2024-10-23 16:44:02'),
(37, 38, 'Comprobante de trámite de marca (En caso de que su marca este en trámite)', 3, 'Comprobante de trámite de marca (En caso de que su marca este en trámite)_1729703114.sql', 19, '2024-10-25', NULL, '2024-10-23 17:05:14', '2024-10-23 17:05:14'),
(38, 39, 'Carta responsiva de trámite (En caso de que su marca este en trámite)', 3, 'Carta responsiva de trámite (En caso de que su marca este en trámite)_1729703114.sql', 19, '2024-10-26', NULL, '2024-10-23 17:05:14', '2024-10-23 17:05:14'),
(39, 60, 'Etiquetas', 3, 'Etiquetas_1729703477.sql', 19, '0000-00-00', NULL, '2024-10-23 17:11:17', '2024-10-23 17:11:17'),
(40, 75, 'Corrugado', 3, 'Corrugado_1729703477.sql', 19, '0000-00-00', NULL, '2024-10-23 17:11:17', '2024-10-23 17:11:17'),
(41, 51, 'Comprobante de pago', 3, 'Comprobante de pago_1729703477.sql', 19, '0000-00-00', NULL, '2024-10-23 17:11:17', '2024-10-23 17:11:17'),
(42, 51, 'Comprobante de pago', 3, 'Comprobante de pago_1729703477.sql', 19, '0000-00-00', NULL, '2024-10-23 17:11:17', '2024-10-23 17:11:17'),
(43, 60, 'Etiquetas', 1, 'Etiquetas_1729715871.xlsx', 1, '0000-00-00', NULL, '2024-10-23 17:14:37', '2024-10-23 20:37:51'),
(44, 75, 'Corrugado', 1, 'Corrugado_1729715871.sql', 1, '0000-00-00', NULL, '2024-10-23 17:14:37', '2024-10-23 20:37:51'),
(45, 60, 'Etiquetas', 1, 'Etiquetas_1729703677.png', 1, '0000-00-00', NULL, '2024-10-23 17:14:37', '2024-10-23 17:14:37'),
(46, 75, 'Corrugado', 1, 'Corrugado_1729703677.png', 1, '0000-00-00', NULL, '2024-10-23 17:14:37', '2024-10-23 17:14:37'),
(47, 60, 'Etiquetas', 1, 'Etiquetas_1729704297.sql', 8, '0000-00-00', NULL, '2024-10-23 17:24:57', '2024-10-23 17:24:57'),
(48, 75, 'Corrugado', 1, 'Corrugado_1729704297.sql', 8, '0000-00-00', NULL, '2024-10-23 17:24:57', '2024-10-23 17:24:57'),
(49, 60, 'Etiquetas', 1, 'Etiquetas_1729704297.sql', 8, '0000-00-00', NULL, '2024-10-23 17:24:57', '2024-10-23 17:24:57'),
(50, 75, 'Corrugado', 1, 'Corrugado_1729704297.sql', 8, '0000-00-00', NULL, '2024-10-23 17:24:57', '2024-10-23 17:24:57'),
(51, 60, 'Etiquetas', 1, 'Etiquetas_1729704360.sql', 8, '0000-00-00', NULL, '2024-10-23 17:26:00', '2024-10-23 17:26:00'),
(52, 75, 'Corrugado', 1, 'Corrugado_1729704360.sql', 8, '0000-00-00', NULL, '2024-10-23 17:26:00', '2024-10-23 17:26:00'),
(53, 60, 'Etiquetas', 1, 'Etiquetas_1729704360.sql', 8, '0000-00-00', NULL, '2024-10-23 17:26:00', '2024-10-23 17:26:00'),
(54, 75, 'Corrugado', 1, 'Corrugado_1729704360.sql', 8, '0000-00-00', NULL, '2024-10-23 17:26:00', '2024-10-23 17:26:00'),
(55, 38, 'Comprobante de trámite de marca (En caso de que su marca este en trámite)', 1, 'Comprobante de trámite de marca (En caso de que su marca este en trámite)_1729704449.sql', 1, '2024-10-18', NULL, '2024-10-23 17:27:29', '2024-10-23 17:27:29'),
(56, 60, 'Etiquetas', 1, 'Etiquetas_1729704481.xlsx', 1, '0000-00-00', NULL, '2024-10-23 17:28:01', '2024-10-23 17:28:01'),
(57, 75, 'Corrugado', 1, 'Corrugado_1729704481.xlsx', 1, '0000-00-00', NULL, '2024-10-23 17:28:01', '2024-10-23 17:28:01'),
(58, 60, 'Etiquetas', 1, 'Etiquetas_1729704481.sql', 1, '0000-00-00', NULL, '2024-10-23 17:28:01', '2024-10-23 17:28:01'),
(59, 75, 'Corrugado', 1, 'Corrugado_1729704481.sql', 1, '0000-00-00', NULL, '2024-10-23 17:28:01', '2024-10-23 17:28:01'),
(60, 60, 'Etiquetas', 1, 'Etiquetas_1729704516.xlsx', 1, '0000-00-00', NULL, '2024-10-23 17:28:36', '2024-10-23 17:28:36'),
(61, 75, 'Corrugado', 1, 'Corrugado_1729704516.xlsx', 1, '0000-00-00', NULL, '2024-10-23 17:28:36', '2024-10-23 17:28:36'),
(62, 60, 'Etiquetas', 1, 'Etiquetas_1729704516.sql', 1, '0000-00-00', NULL, '2024-10-23 17:28:36', '2024-10-23 17:28:36'),
(63, 75, 'Corrugado', 1, 'Corrugado_1729704516.sql', 1, '0000-00-00', NULL, '2024-10-23 17:28:36', '2024-10-23 17:28:36'),
(64, 60, 'Etiquetas', 1, 'Etiquetas_1729707227.png', 1, '0000-00-00', NULL, '2024-10-23 18:13:47', '2024-10-23 18:13:47'),
(65, 75, 'Corrugado', 1, 'Corrugado_1729707228.png', 1, '0000-00-00', NULL, '2024-10-23 18:13:48', '2024-10-23 18:13:48'),
(66, 60, 'Etiquetas', 1, 'Etiquetas_1729712742.sql', 1, '0000-00-00', NULL, '2024-10-23 19:45:42', '2024-10-23 19:45:42'),
(67, 60, 'Etiquetas', 1, 'Etiquetas_1729715698.sql', 1, '0000-00-00', NULL, '2024-10-23 20:34:58', '2024-10-23 20:34:58'),
(68, 60, 'Etiquetas', 1, 'Etiquetas_1729715713.sql', 1, '0000-00-00', NULL, '2024-10-23 20:35:13', '2024-10-23 20:35:13'),
(69, 75, 'Corrugado', 1, 'Corrugado_1729715713.sql', 1, '0000-00-00', NULL, '2024-10-23 20:35:13', '2024-10-23 20:35:13'),
(70, 60, 'Etiquetas', 3, 'Etiquetas_1729715920.sql', 2, '0000-00-00', NULL, '2024-10-23 20:38:40', '2024-10-23 20:38:40'),
(71, 60, 'Etiquetas', 1, 'Etiquetas_1729716118.png', 3, '0000-00-00', NULL, '2024-10-23 20:41:58', '2024-10-23 20:41:58'),
(72, 75, 'Corrugado', 1, 'Corrugado_1729716118.png', 3, '0000-00-00', NULL, '2024-10-23 20:41:58', '2024-10-23 20:41:58'),
(73, 60, 'Etiquetas', 1, 'Etiquetas_1729716285.xlsx', 3, '0000-00-00', NULL, '2024-10-23 20:44:45', '2024-10-23 20:44:45'),
(74, 75, 'Corrugado', 1, 'Corrugado_1729716285.pdf', 3, '0000-00-00', NULL, '2024-10-23 20:44:45', '2024-10-23 20:44:45'),
(75, 60, 'Etiquetas', 1, 'Etiquetas_1729716385.sql', 3, '0000-00-00', NULL, '2024-10-23 20:46:25', '2024-10-23 20:46:25'),
(76, 75, 'Corrugado', 1, 'Corrugado_1729716385.sql', 3, '0000-00-00', NULL, '2024-10-23 20:46:25', '2024-10-23 20:46:25'),
(77, 60, 'Etiquetas', 1, 'Etiquetas_1729716401.png', 3, '0000-00-00', NULL, '2024-10-23 20:46:41', '2024-10-23 20:46:41'),
(78, 60, 'Etiquetas', 1, 'Etiquetas_1729716666.sql', 3, '0000-00-00', NULL, '2024-10-23 20:51:06', '2024-10-23 20:51:06'),
(79, 60, 'Etiquetas', 1, 'Etiquetas_1729716704.sql', 3, '0000-00-00', NULL, '2024-10-23 20:51:44', '2024-10-23 20:51:44');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `documentacion_url`
--
ALTER TABLE `documentacion_url`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `documentacion_url`
--
ALTER TABLE `documentacion_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
