-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2024 a las 23:12:30
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
-- Base de datos: `ips_vacunate_sas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `CliCodigo` int(11) NOT NULL,
  `CliNombre` varchar(50) NOT NULL,
  `CliApellido` varchar(50) NOT NULL,
  `CliTipoDeDocumento` varchar(50) NOT NULL,
  `CliNumeroDeDocumento` varchar(10) NOT NULL,
  `CliTelefono` varchar(10) NOT NULL,
  `CliFechaDeNacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`CliCodigo`, `CliNombre`, `CliApellido`, `CliTipoDeDocumento`, `CliNumeroDeDocumento`, `CliTelefono`, `CliFechaDeNacimiento`) VALUES
(1, 'Samuel', 'Ortiz Rivera', 'Cedula de ciudadania', '1110292545', '3235284667', '2006-08-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `FacCodigo` int(11) NOT NULL,
  `CliCodigo` int(11) DEFAULT NULL,
  `ProCodigo` int(11) DEFAULT NULL,
  `FacNombreDeFactura` varchar(10) NOT NULL,
  `FacNombreDeCLiente` varchar(50) NOT NULL,
  `FacNombreDeProducto` varchar(50) NOT NULL,
  `FacCantidad` varchar(10) NOT NULL,
  `FacValor` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ProCodigo` int(11) NOT NULL,
  `ProNombre` varchar(50) NOT NULL,
  `ProLote` varchar(50) NOT NULL,
  `Provalor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ProCodigo`, `ProNombre`, `ProLote`, `Provalor`) VALUES
(1, 'Pruebas de ppd', '1', 46000),
(2, 'Vacuna de Varicela', '2', 150000),
(3, 'Vacuna de Polio', '3', 210000),
(4, 'Vacuna de Neumococo', '4', 118000);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`CliCodigo`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`FacCodigo`),
  ADD KEY `FK_CliCodigo` (`CliCodigo`),
  ADD KEY `FK_ProCodigo` (`ProCodigo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ProCodigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `CliCodigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `FacCodigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ProCodigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `FK_CliCodigo` FOREIGN KEY (`CliCodigo`) REFERENCES `cliente` (`CliCodigo`),
  ADD CONSTRAINT `FK_ProCodigo` FOREIGN KEY (`ProCodigo`) REFERENCES `productos` (`ProCodigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
