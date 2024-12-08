-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2024 a las 05:33:45
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
-- Base de datos: `bdnautico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barco`
--

CREATE TABLE `barco` (
  `matricula` int(11) NOT NULL,
  `cedsocio` varchar(15) DEFAULT NULL,
  `nombre_barco` varchar(50) DEFAULT NULL,
  `numamarre` int(11) DEFAULT NULL,
  `cuota` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `barco`
--

INSERT INTO `barco` (`matricula`, `cedsocio`, `nombre_barco`, `numamarre`, `cuota`) VALUES
(1001, '8-954-566', 'Santorini', 12, 500),
(1002, '4-102-347', 'La Perla Negra', 23, 700),
(1003, '3-555-222', 'El Corsario', 34, 650);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conductor_patron`
--

CREATE TABLE `conductor_patron` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `conductor_patron`
--

INSERT INTO `conductor_patron` (`codigo`, `nombre`, `telefono`, `direccion`) VALUES
(2001, 'Mario Castillo', '65812255', 'Panamá, San Francisco'),
(2002, 'Ana Rodriguez', '61002233', 'Panamá, Casco Viejo'),
(2003, 'Carlos De León', '67889900', 'Panamá, Bella Vista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `cedula` varchar(15) NOT NULL,
  `nombre_completo` varchar(50) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`cedula`, `nombre_completo`, `telefono`, `correo`) VALUES
('3-555-222', 'Luis Gonzales', '69001122', 'luis.gonzales@hotmail.com'),
('4-102-347', 'Carla Lopez', '67112233', 'carla.lopez@gmail.com'),
('8-954-566', 'Johny Medina', '65878899', 'joeenm@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje`
--

CREATE TABLE `viaje` (
  `numero` int(11) NOT NULL,
  `matribarco` int(11) DEFAULT NULL,
  `codpatron` int(11) DEFAULT NULL,
  `fecha` varchar(10) DEFAULT NULL,
  `hora` varchar(5) DEFAULT NULL,
  `destino` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`numero`, `matribarco`, `codpatron`, `fecha`, `hora`, `destino`) VALUES
(3001, 1001, 2001, '2024-11-01', '08:00', 'Isla Contadora'),
(3002, 1002, 2002, '2024-11-02', '09:30', 'Isla Taboga'),
(3003, 1003, 2003, '2024-11-03', '10:00', 'Isla San José'),
(3004, 1001, 2002, '2024-11-05', '07:45', 'Isla Viveros');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `barco`
--
ALTER TABLE `barco`
  ADD PRIMARY KEY (`matricula`),
  ADD KEY `cedsocio` (`cedsocio`);

--
-- Indices de la tabla `conductor_patron`
--
ALTER TABLE `conductor_patron`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `matribarco` (`matribarco`),
  ADD KEY `codpatron` (`codpatron`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `barco`
--
ALTER TABLE `barco`
  ADD CONSTRAINT `barco_ibfk_1` FOREIGN KEY (`cedsocio`) REFERENCES `socio` (`cedula`);

--
-- Filtros para la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD CONSTRAINT `viaje_ibfk_1` FOREIGN KEY (`matribarco`) REFERENCES `barco` (`matricula`),
  ADD CONSTRAINT `viaje_ibfk_2` FOREIGN KEY (`codpatron`) REFERENCES `conductor_patron` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
