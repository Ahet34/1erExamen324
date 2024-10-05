-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2024 a las 05:33:05
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdalan`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catastro`
--

CREATE TABLE `catastro` (
  `id` int(11) NOT NULL,
  `zona` varchar(100) DEFAULT NULL,
  `Xini` decimal(10,2) DEFAULT NULL,
  `Yini` decimal(10,2) DEFAULT NULL,
  `Xfin` decimal(10,2) DEFAULT NULL,
  `superficie` int(11) DEFAULT NULL,
  `distrito` varchar(50) DEFAULT NULL,
  `ci` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catastro`
--

INSERT INTO `catastro` (`id`, `zona`, `Xini`, `Yini`, `Xfin`, `superficie`, `distrito`, `ci`) VALUES
(121, 'Zona B1', 40.00, 20.00, 45.00, 600, 'Distrito 2', 24681357),
(123, 'Zona A1', 10.00, 10.00, 15.00, 500, 'Distrito 1', 12345678),
(137, 'Zona H1', 140.00, 80.00, 145.00, 1500, 'Distrito 3', 25896314),
(138, 'Zona I1', 150.00, 90.00, 155.00, 1600, 'Distrito 4', 36925814),
(139, 'Zona J1', 160.00, 100.00, 165.00, 1700, 'Distrito 5', 75315948),
(142, 'Zona B2', 50.00, 20.00, 55.00, 700, 'Distrito 2', 98765432),
(143, 'Zona C1', 60.00, 30.00, 65.00, 800, 'Distrito 3', 45612378),
(221, 'Zona C2', 70.00, 30.00, 75.00, 900, 'Distrito 3', 32165487),
(232, 'Zona A2', 20.00, 10.00, 25.00, 300, 'Distrito 1', 87654321),
(240, 'Zona K1', 170.00, 110.00, 175.00, 1800, 'Distrito 1', 85296374),
(241, 'Zona L1', 180.00, 120.00, 185.00, 1900, 'Distrito 2', 32145698),
(242, 'Zona M1', 190.00, 130.00, 195.00, 2000, 'Distrito 3', 15975312),
(322, 'Zona D2', 90.00, 40.00, 95.00, 100, 'Distrito 4', 75315948),
(323, 'Zona E1', 100.00, 50.00, 105.00, 1200, 'Distrito 5', 85274163),
(324, 'Zona E2', 110.00, 50.00, 115.00, 1100, 'Distrito 5', 65432187),
(335, 'Zona F1', 120.00, 60.00, 125.00, 1300, 'Distrito 1', 14725836),
(341, 'Zona D1', 80.00, 40.00, 85.00, 200, 'Distrito 4', 15975324),
(343, 'Zona A3', 30.00, 10.00, 35.00, 400, 'Distrito 1', 13579246),
(346, 'Zona G1', 130.00, 70.00, 135.00, 1400, 'Distrito 2', 96325874),
(393, 'Zona N1', 200.00, 140.00, 205.00, 2100, 'Distrito 4', 98765412);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `ci` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `paterno` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`ci`, `nombre`, `paterno`) VALUES
(12345678, 'Juan', 'Pérez'),
(13579246, 'Luis', 'Martínez'),
(14725836, 'Javier', 'Cruz'),
(15975312, 'Tatiana', 'Rivas'),
(15975324, 'Lucía', 'López'),
(24681357, 'María', 'Rodríguez'),
(25896314, 'Roberto', 'Jiménez'),
(32145698, 'Ricardo', 'Pantoja'),
(32165487, 'Diego', 'Torres'),
(36925814, 'Marta', 'Castillo'),
(45612378, 'Laura', 'Sánchez'),
(65432187, 'Elena', 'Morales'),
(75315948, 'Fernando', 'Díaz'),
(75315949, 'Jorge', 'Rojas'),
(85274163, 'Claudia', 'Vásquez'),
(85296374, 'Gabriela', 'Salinas'),
(87654321, 'Ana', 'Gómez'),
(96325874, 'Patricia', 'Fernández'),
(98765412, 'Sergio', 'Bermúdez'),
(98765432, 'Carlos', 'Hernández');

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
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`ci`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `catastro`
--
ALTER TABLE `catastro`
  ADD CONSTRAINT `catastro_ibfk_1` FOREIGN KEY (`ci`) REFERENCES `persona` (`ci`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
