-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-08-2022 a las 04:31:07
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servicios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `MONTO` float NOT NULL,
  `NUM_CUE` char(20) NOT NULL,
  `CED_CLI` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `ID_PAG` int(11) NOT NULL,
  `VAL_PAG` float NOT NULL,
  `MET_PAG` char(10) NOT NULL,
  `EST_PAG` smallint(6) NOT NULL,
  `FEC_PAG` date NOT NULL,
  `ID_SER` decimal(8,0) NOT NULL,
  `CED_CLI` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`ID_PAG`, `VAL_PAG`, `MET_PAG`, `EST_PAG`, `FEC_PAG`, `ID_SER`, `CED_CLI`) VALUES
(1, 20, 'Debito', 1, '2022-08-11', '2', '1722786959'),
(2, 25, 'Debito', 1, '2022-08-11', '1', '1722786959');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `ID_SER` decimal(8,0) NOT NULL,
  `NOM_SER` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`ID_SER`, `NOM_SER`) VALUES
('1', 'Luz'),
('2', 'Agua'),
('3', 'Telefono');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `CED_CLI` char(10) NOT NULL,
  `NOM_CLI` char(20) DEFAULT NULL,
  `APE_CLI` char(20) DEFAULT NULL,
  `CORR_CLI` char(30) DEFAULT NULL,
  `PASSWORD` char(20) DEFAULT NULL,
  `SOCIO` smallint(6) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`CED_CLI`, `NOM_CLI`, `APE_CLI`, `CORR_CLI`, `PASSWORD`, `SOCIO`, `rol`) VALUES
('1722786959', 'David', 'Caicedo', 'david@gmail.com', '123', 1, 1),
('1727756122', 'Richard', 'Casa', 'richi@gmail.com', '123', 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`NUM_CUE`),
  ADD KEY `FK_TIENE` (`CED_CLI`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`ID_PAG`),
  ADD KEY `FK_DE` (`ID_SER`),
  ADD KEY `FK_ES` (`CED_CLI`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`ID_SER`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`CED_CLI`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `ID_PAG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `FK_TIENE` FOREIGN KEY (`CED_CLI`) REFERENCES `usuario` (`CED_CLI`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `FK_DE` FOREIGN KEY (`ID_SER`) REFERENCES `servicio` (`ID_SER`),
  ADD CONSTRAINT `FK_ES` FOREIGN KEY (`CED_CLI`) REFERENCES `usuario` (`CED_CLI`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
