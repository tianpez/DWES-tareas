-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 26-03-2024 a las 08:34:16
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `almacen`
--
CREATE DATABASE IF NOT EXISTS `almacen` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `almacen`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `art_id` int(11) NOT NULL,
  `art_nombre` varchar(50) NOT NULL,
  `art_categoria` int(11) NOT NULL,
  `art_cantidad` int(11) NOT NULL,
  `art_preciounitario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`art_id`, `art_nombre`, `art_categoria`, `art_cantidad`, `art_preciounitario`) VALUES
(1, 'iPhone 15 Pro Max', 1, 4, 0),
(2, 'Chorizo revilla', 2, 20, 0),
(7, 'iPod Nano', 1, 5, 0),
(8, 'iPod Satisfier', 4, 5, 0),
(9, 'Macbook Air', 1, 65, 0),
(10, 'Nabo electrico', 1, 65, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `cat_id` int(11) NOT NULL,
  `cat_nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`cat_id`, `cat_nombre`) VALUES
(1, 'Electrónica'),
(2, 'Alimentación'),
(3, 'Menaje'),
(4, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_venta`
--

CREATE TABLE `linea_venta` (
  `lin_id` int(11) NOT NULL,
  `lin_venta` int(11) NOT NULL,
  `lin_articulo` int(11) NOT NULL,
  `lin_cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usu_login` varchar(20) NOT NULL,
  `usu_pass` varchar(200) NOT NULL,
  `usu_name` varchar(100) NOT NULL,
  `usu_active` tinyint(1) NOT NULL
///) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usu_login`, `usu_pass`, `usu_name`, `usu_active`) VALUES
('planes', '21bd12dc183f740ee76f27b78eb39c8ad972a757', 'Usuario del IES Jose Planes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `ven_id` int(11) NOT NULL,
  `ven_fecha` date NOT NULL,
  `ven_importe` float NOT NULL,
  `ven_pagada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`art_id`),
  ADD KEY `fk_articulo_categoria` (`art_categoria`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `linea_venta`
--
ALTER TABLE `linea_venta`
  ADD PRIMARY KEY (`lin_id`),
  ADD KEY `fk_linea_compra_compra` (`lin_venta`),
  ADD KEY `fk_linea_compra_articulo` (`lin_articulo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_login`),
  ADD UNIQUE KEY `usu_name` (`usu_name`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`ven_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `art_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `linea_venta`
--
ALTER TABLE `linea_venta`
  MODIFY `lin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `ven_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `fk_articulo_categoria` FOREIGN KEY (`art_categoria`) REFERENCES `categoria` (`cat_id`);

--
-- Filtros para la tabla `linea_venta`
--
ALTER TABLE `linea_venta`
  ADD CONSTRAINT `fk_linea_compra_articulo` FOREIGN KEY (`lin_articulo`) REFERENCES `articulo` (`art_id`),
  ADD CONSTRAINT `fk_linea_compra_compra` FOREIGN KEY (`lin_venta`) REFERENCES `venta` (`ven_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
