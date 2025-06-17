-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-08-2024 a las 20:12:28
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Base de datos: `special_keychains`
  CREATE DATABASE IF NOT EXISTS `special_keychains`;
  USE `special_keychains`;

-- Estructura de tabla para la tabla `administrador`
CREATE TABLE `administrador` (
  `registrar_administrador` int(16) NOT NULL,
  `actualizar_administrador` int(12) NOT NULL,
  `consultar_administrador` int(30) NOT NULL,
  `inactivar_administrador` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Estructura de tabla para la tabla `factura`
CREATE TABLE `factura` (
  `crear` int(11) NOT NULL,
  `tipo_de_factura` int(11) NOT NULL,
  `tipos_de_productos` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `cancelar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Estructura de tabla para la tabla `menu`
CREATE TABLE `menu` (
  `manipular` int(11) NOT NULL,
  `insertar` int(11) DEFAULT NULL,
  `consultar` int(11) NOT NULL,
  `obtener` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Estructura de tabla para la tabla `pedido`
CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `hora_pedido` datetime NOT NULL,
  `valor_pedido` decimal(10,0) NOT NULL,
  `subtotal_pedido` decimal(10,0) NOT NULL,
  `total_pedido` decimal(10,0) NOT NULL,
  `estado_pedido` int(11) NOT NULL,
  `registrar_pedido` int(11) NOT NULL,
  `consultar_pedido` int(11) NOT NULL,
  `actualizar_pedido` int(11) NOT NULL,
  `anular_pedido` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Estructura de tabla para la tabla `usuario`
CREATE TABLE `usuario` (
  `id` INT(5) AUTO_INCREMENT PRIMARY KEY,
  `rol` VARCHAR(20) NOT NULL,
  `nombre` VARCHAR(50) NOT NULL,
  `tp` VARCHAR(20) NOT NULL,
  `cc` INT(10) NOT NULL,
  `correo` VARCHAR(50) NOT NULL,
  `clave` VARCHAR(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
