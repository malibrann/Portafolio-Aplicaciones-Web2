-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2025 a las 15:34:29
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
-- Base de datos: `chat_uni`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--
CREATE DATABASE IF NOT EXISTS chat_uni;
USE chat_uni;

-- Tabla para almacenar la información de los usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `pass` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla para almacenar la información de los grupos
CREATE TABLE IF NOT EXISTS `grupos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserción de datos iniciales en la tabla `grupos` (tomados de grupos.sql)
INSERT INTO `grupos` (`id`, `nombre`) VALUES
(1, 'General'),
(2, 'Tarea'),
(3, 'Memes')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- Tabla para almacenar los mensajes
-- 'tipo' puede ser 'global', 'grupo', o 'priv'
-- Si es 'global', 'para' se ignora o se puede dejar en 0.
-- Si es 'grupo', 'para' es el ID del grupo.
-- Si es 'priv', 'para' es el ID del usuario receptor.
CREATE TABLE IF NOT EXISTS `msj` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `de` INT(11) NOT NULL,
  `para` INT(11) NOT NULL,
  `mensaje` TEXT NOT NULL,
  `tipo` VARCHAR(10) NOT NULL,
  `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`de`) REFERENCES `usuarios`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;