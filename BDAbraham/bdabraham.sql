-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2024 a las 07:59:07
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
-- Base de datos: `bdabraham`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catastro`
--

CREATE TABLE `catastro` (
  `id` varchar(10) NOT NULL,
  `zona` varchar(100) DEFAULT NULL,
  `Xini` decimal(10,2) DEFAULT NULL,
  `Yini` decimal(10,2) DEFAULT NULL,
  `Xfin` decimal(10,2) DEFAULT NULL,
  `Yfin` decimal(10,2) DEFAULT NULL,
  `superficie` int(11) DEFAULT NULL,
  `distrito` varchar(50) DEFAULT NULL,
  `ci` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catastro`
--

INSERT INTO `catastro` (`id`, `zona`, `Xini`, `Yini`, `Xfin`, `Yfin`, `superficie`, `distrito`, `ci`) VALUES
('10001', 'Zona 2 de El Alto', 232.00, 123.00, 111.00, 123.00, 234, 'El Alto', '8457589'),
('1001', 'Zona 16 de Julio', 232.00, 123.00, 111.00, 123.00, 234, 'Centro', '8404280'),
('10065', 'Zona 2 de El Alto', 232.00, 123.00, 111.00, 123.00, 200, 'El Alto', '8457589'),
('10078', 'Zona 16 de Julio', 232.00, 123.00, 111.00, 123.00, 234, 'Centro', '8457589'),
('20000', 'Sopocachi Centro', 232.00, 123.00, 111.00, 123.00, 234, 'Sopocachi', '8404280'),
('20009', 'Zona 1 de San Antonio', 232.00, 123.00, 111.00, 123.00, 234, 'San Antonio', '8457589'),
('3000', 'Zona 1', 232.00, 123.00, 111.00, 123.00, 234, 'El Alto', '8457589');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE `distrito` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `distrito`
--

INSERT INTO `distrito` (`id`, `nombre`) VALUES
(1, 'Centro'),
(2, 'La Zona Sur'),
(3, 'El Alto'),
(4, 'La Zona Norte'),
(5, 'San Antonio'),
(6, 'Villa Fatima'),
(7, 'Achachicala'),
(8, 'Miraflores'),
(9, 'Calacoto'),
(10, 'Sopocachi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `ci` varchar(10) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `paterno` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`ci`, `nombre`, `paterno`) VALUES
('8404280', 'Ramiro', 'Perez'),
('8457589', 'Carlos', 'Fernadez'),
('87654321', 'Samuel', 'Gomez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ci` varchar(10) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ci`, `usuario`, `contrasenia`, `rol`) VALUES
('11223344', 'pedroL', 'pedrito', 1),
('12345678', 'juanP', 'juanito', 1),
('42345678', 'mayteL', 'maisenita', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_distrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zona`
--

INSERT INTO `zona` (`id`, `nombre`, `id_distrito`) VALUES
(1, 'Zona 16 de Julio', 1),
(2, 'Zona Sur 1', 2),
(3, 'Zona 1', 3),
(4, 'Zona Norte 1', 4),
(5, 'Zona 1 de San Antonio', 5),
(6, 'Zona 2 de Villa Fatima', 6),
(7, 'Achachicala Centro', 7),
(8, 'Miraflores Centro', 8),
(9, 'Calacoto Centro', 9),
(10, 'Sopocachi Centro', 10),
(11, 'Zona 1 de Centro', 1),
(12, 'Zona San Francisco', 1),
(13, 'Zona 2 de La Paz', 1),
(14, 'Zona Sur 2', 2),
(15, 'Zona 3 de La Zona Sur', 2),
(16, 'Zona La Fontana', 2),
(17, 'Zona 2 de El Alto', 3),
(18, 'Zona 3 de El Alto', 3),
(19, 'Zona La Ceja', 3),
(20, 'Zona 2 de La Zona Norte', 4),
(21, 'Zona 3 de La Zona Norte', 4),
(22, 'Zona San Miguel', 4),
(23, 'Zona San Antonio Centro', 5),
(24, 'Zona San Antonio Sur', 5),
(25, 'Zona 3 de San Antonio', 5),
(26, 'Zona 3 de Villa Fatima', 6),
(27, 'Zona Villa El Carmen', 6),
(28, 'Zona Villa Salomé', 6),
(29, 'Zona Nueva Achachicala', 7),
(30, 'Zona 2 de Achachicala', 7),
(31, 'Zona Achachicala Sur', 7),
(32, 'Zona Miraflores Sur 2', 8),
(33, 'Zona Miraflores Este', 8),
(34, 'Zona Miraflores Oeste', 8),
(35, 'Zona Calacoto Norte 2', 9),
(36, 'Zona Calacoto Este', 9),
(37, 'Zona Calacoto Oeste', 9),
(38, 'Zona Sopocachi Sur 2', 10),
(39, 'Zona Sopocachi Este', 10),
(40, 'Zona Sopocachi Oeste', 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catastro`
--
ALTER TABLE `catastro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci` (`ci`);

--
-- Indices de la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`ci`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ci`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_distrito` (`id_distrito`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `distrito`
--
ALTER TABLE `distrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `catastro`
--
ALTER TABLE `catastro`
  ADD CONSTRAINT `catastro_ibfk_1` FOREIGN KEY (`ci`) REFERENCES `persona` (`ci`);

--
-- Filtros para la tabla `zona`
--
ALTER TABLE `zona`
  ADD CONSTRAINT `zona_ibfk_1` FOREIGN KEY (`id_distrito`) REFERENCES `distrito` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
