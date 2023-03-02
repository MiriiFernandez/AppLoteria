-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2023 a las 11:11:43
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `loteria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acomulados`
--

CREATE TABLE `acomulados` (
  `id_acomulado` int(11) NOT NULL,
  `boleto` int(5) NOT NULL,
  `fecha_sorteo` date NOT NULL,
  `premio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `acomulados`
--

INSERT INTO `acomulados` (`id_acomulado`, `boleto`, `fecha_sorteo`, `premio`) VALUES
(60, 48790, '2023-03-03', 10000),
(61, 48700, '2023-03-03', 300),
(62, 78342, '2023-03-02', 0),
(63, 12345, '2023-03-02', 0),
(64, 48001, '2023-03-03', 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprados`
--

CREATE TABLE `comprados` (
  `id_comprado` int(11) NOT NULL,
  `boleto` int(11) NOT NULL,
  `fecha_sorteo` date NOT NULL,
  `premio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comprados`
--

INSERT INTO `comprados` (`id_comprado`, `boleto`, `fecha_sorteo`, `premio`) VALUES
(1, 48790, '2023-03-03', 0),
(2, 48700, '2023-03-03', 0),
(5, 78342, '2023-03-02', 0),
(12, 12345, '2023-03-02', 0),
(17, 48001, '2023-03-03', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premios`
--

CREATE TABLE `premios` (
  `id_premio` int(11) NOT NULL,
  `boleto` int(5) NOT NULL,
  `fecha_sorteo` date NOT NULL,
  `dinero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `premios`
--

INSERT INTO `premios` (`id_premio`, `boleto`, `fecha_sorteo`, `dinero`) VALUES
(1, 48791, '2023-03-03', 600000),
(2, 48790, '2023-03-03', 10000),
(4, 48700, '2023-03-03', 300),
(5, 48091, '2023-03-03', 120),
(6, 48001, '2023-03-03', 60);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acomulados`
--
ALTER TABLE `acomulados`
  ADD PRIMARY KEY (`id_acomulado`);

--
-- Indices de la tabla `comprados`
--
ALTER TABLE `comprados`
  ADD PRIMARY KEY (`id_comprado`);

--
-- Indices de la tabla `premios`
--
ALTER TABLE `premios`
  ADD PRIMARY KEY (`id_premio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acomulados`
--
ALTER TABLE `acomulados`
  MODIFY `id_acomulado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `comprados`
--
ALTER TABLE `comprados`
  MODIFY `id_comprado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `premios`
--
ALTER TABLE `premios`
  MODIFY `id_premio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
