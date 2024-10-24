-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-08-2024 a las 00:14:08
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
-- Estructura de tabla para la tabla `predios`
--

CREATE TABLE `predios` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_empresa` int(10) UNSIGNED NOT NULL,
  `nombre_productor` varchar(255) NOT NULL,
  `nombre_predio` varchar(255) NOT NULL,
  `ubicacion_predio` text DEFAULT NULL,
  `tipo_predio` enum('Comunal','Ejidal','Propiedad privada','Otro') NOT NULL,
  `puntos_referencia` text DEFAULT NULL,
  `cuenta_con_coordenadas` enum('Sí','No') DEFAULT 'No',
  `latitud` decimal(10,7) DEFAULT NULL,
  `longitud` decimal(10,7) DEFAULT NULL,
  `superficie` decimal(10,2) NOT NULL,
  `nombre_agave` varchar(255) DEFAULT NULL,
  `especie_agave` varchar(255) DEFAULT NULL,
  `numero_plantas` int(10) UNSIGNED DEFAULT NULL,
  `edad_plantacion` int(10) UNSIGNED DEFAULT NULL,
  `tipo_plantacion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `predios`
--

INSERT INTO `predios` (`id`, `id_empresa`, `nombre_productor`, `nombre_predio`, `ubicacion_predio`, `tipo_predio`, `puntos_referencia`, `cuenta_con_coordenadas`, `latitud`, `longitud`, `superficie`, `nombre_agave`, `especie_agave`, `numero_plantas`, `edad_plantacion`, `tipo_plantacion`, `created_at`, `updated_at`) VALUES
(2, 79, 'Carlos Gómez', 'La Hacienda Azul', 'A un kilómetro del lago', '', 'Frente a la iglesia', 'No', NULL, NULL, 8.75, 'Agave Angustifolia', 'Espadín', 450, 3, 'Plantación en terrazas', '2024-08-06 21:56:39', '2024-08-06 21:56:39'),
(3, 80, 'Luis Martínez', 'El Llano Rojo', 'Cerca de la montaña', 'Ejidal', 'Junto al puente viejo', 'Sí', 20.6596988, -103.3496092, 15.25, 'Agave Salmiana', 'Maguey Verde', 700, 7, 'Plantación en franjas', '2024-08-06 21:56:39', '2024-08-06 21:58:35'),
(4, 85, 'María López', 'Las Lomas', 'En la colina', 'Comunal', 'Junto a la torre de agua', 'No', NULL, NULL, 12.30, 'Agave Americana', 'Maguey Azul', 600, 4, 'Plantación en zigzag', '2024-08-06 21:56:39', '2024-08-06 21:58:44'),
(5, 83, 'Ana Ramírez', 'El Vergel', 'Cerca del parque nacional', '', 'Detrás de la escuela', 'Sí', 21.1619080, -86.8515270, 9.50, 'Agave Funkiana', 'Maguey Verde', 550, 6, 'Plantación en espiral', '2024-08-06 21:56:39', '2024-08-06 21:58:52');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `predios`
--
ALTER TABLE `predios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `predios`
--
ALTER TABLE `predios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
