-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2024 a las 04:58:14
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
-- Base de datos: `bd_hbmf`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `pk_actividad` int(11) NOT NULL,
  `nombre_actividad` varchar(45) NOT NULL,
  `estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `pk_area` int(11) NOT NULL,
  `nombre_area` varchar(45) NOT NULL,
  `estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `pk_empleado` int(11) NOT NULL,
  `nombres` varchar(40) NOT NULL,
  `apaterno` varchar(20) NOT NULL,
  `amaterno` varchar(20) NOT NULL,
  `contacto` varchar(35) NOT NULL,
  `estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `pk_habitacion` int(11) NOT NULL,
  `num_habitacion` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fk_area` int(11) NOT NULL,
  `estatus` int(11) NOT NULL,
  `fk_empleado` int(11) DEFAULT NULL,
  `fecha_ver` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `limpieza`
--

CREATE TABLE `limpieza` (
  `pk_limpieza` int(11) NOT NULL,
  `folio` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `fk_habitacion` int(11) DEFAULT NULL,
  `fk_area` int(11) DEFAULT NULL,
  `fk_empleado` int(11) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `tiempo` varchar(50) NOT NULL,
  `mtto` varchar(2) NOT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `limpieza_actividad`
--

CREATE TABLE `limpieza_actividad` (
  `pk_limpieza_actividad` int(11) NOT NULL,
  `fk_limpieza` int(11) NOT NULL,
  `fk_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `pk_mantenimiento` int(11) NOT NULL,
  `fecha_mant` date NOT NULL,
  `folio_mant` varchar(10) NOT NULL,
  `fk_limpieza` int(11) NOT NULL,
  `persona_cargo` varchar(200) NOT NULL,
  `hora_inicio_mant` time NOT NULL,
  `hora_fin_mant` time NOT NULL,
  `tiempo_mant` varchar(50) NOT NULL,
  `observaciones_mant` varchar(150) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`pk_actividad`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`pk_area`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`pk_empleado`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`pk_habitacion`),
  ADD KEY `fk_area` (`fk_area`),
  ADD KEY `fk_empleado` (`fk_empleado`);

--
-- Indices de la tabla `limpieza`
--
ALTER TABLE `limpieza`
  ADD PRIMARY KEY (`pk_limpieza`),
  ADD KEY `fk_habitacion` (`fk_habitacion`),
  ADD KEY `fk_area` (`fk_area`),
  ADD KEY `fk_empleado` (`fk_empleado`);

--
-- Indices de la tabla `limpieza_actividad`
--
ALTER TABLE `limpieza_actividad`
  ADD PRIMARY KEY (`pk_limpieza_actividad`),
  ADD KEY `fk_limpieza` (`fk_limpieza`),
  ADD KEY `fk_actividad` (`fk_actividad`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`pk_mantenimiento`),
  ADD KEY `fk_limpieza` (`fk_limpieza`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `pk_actividad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `pk_area` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `pk_empleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `pk_habitacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `limpieza`
--
ALTER TABLE `limpieza`
  MODIFY `pk_limpieza` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `limpieza_actividad`
--
ALTER TABLE `limpieza_actividad`
  MODIFY `pk_limpieza_actividad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `pk_mantenimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `habitacion_ibfk_1` FOREIGN KEY (`fk_area`) REFERENCES `area` (`pk_area`),
  ADD CONSTRAINT `habitacion_ibfk_2` FOREIGN KEY (`fk_empleado`) REFERENCES `empleado` (`pk_empleado`);

--
-- Filtros para la tabla `limpieza`
--
ALTER TABLE `limpieza`
  ADD CONSTRAINT `limpieza_ibfk_1` FOREIGN KEY (`fk_habitacion`) REFERENCES `habitacion` (`pk_habitacion`),
  ADD CONSTRAINT `limpieza_ibfk_2` FOREIGN KEY (`fk_area`) REFERENCES `area` (`pk_area`),
  ADD CONSTRAINT `limpieza_ibfk_3` FOREIGN KEY (`fk_empleado`) REFERENCES `empleado` (`pk_empleado`);

--
-- Filtros para la tabla `limpieza_actividad`
--
ALTER TABLE `limpieza_actividad`
  ADD CONSTRAINT `limpieza_actividad_ibfk_1` FOREIGN KEY (`fk_limpieza`) REFERENCES `limpieza` (`pk_limpieza`),
  ADD CONSTRAINT `limpieza_actividad_ibfk_2` FOREIGN KEY (`fk_actividad`) REFERENCES `actividad` (`pk_actividad`);

--
-- Filtros para la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD CONSTRAINT `mantenimiento_ibfk_1` FOREIGN KEY (`fk_limpieza`) REFERENCES `limpieza` (`pk_limpieza`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
