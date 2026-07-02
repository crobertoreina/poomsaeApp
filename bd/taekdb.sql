-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-07-2026 a las 05:03:00
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
-- Base de datos: `taekdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Kyorugi', 'Combate'),
(2, 'Poomsae', 'Formas'),
(3, 'Freestyle Poomsae', 'Formas Libres');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cinturon`
--

CREATE TABLE `cinturon` (
  `idCinturon` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `colorHex` varchar(10) NOT NULL,
  `nivel` varchar(20) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cinturon`
--

INSERT INTO `cinturon` (`idCinturon`, `nombre`, `colorHex`, `nivel`, `orden`) VALUES
(1, 'Blanco', '#FFFFFF', 'Principiante', 1),
(2, 'Blanco-Amarillo', '#FFFACD', 'Principiante', 2),
(3, 'Amarillo', '#FFD700', 'Principiante', 3),
(4, 'Amarillo-Verde', '#ADFF2F', 'Intermedio Bajo', 4),
(5, 'Verde', '#008000', 'Intermedio Bajo', 5),
(6, 'Verde-Azul', '#00CED1', 'Intermedio Alto', 6),
(7, 'Azul', '#0066FF', 'Intermedio Alto', 7),
(8, 'Azul-Rojo', '#8A2BE2', 'Avanzado', 8),
(9, 'Rojo', '#CC0000', 'Avanzado', 9),
(10, 'Rojo-Negro', '#4B0000', 'Experto', 10),
(11, '1er Dan', '#000000', 'Experto', 11),
(12, '2do Dan', '#000000', 'Experto', 12),
(13, '3er Dan+', '#000000', 'Experto', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_evaluacion`
--

CREATE TABLE `control_evaluacion` (
  `id` int(11) NOT NULL,
  `id_torneo` int(11) NOT NULL,
  `id_participante_actual` int(11) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `estado` varchar(20) NOT NULL DEFAULT 'evaluando'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `siglas` varchar(20) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `fecha_fundacion` date DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `instructor_nombre` varchar(200) DEFAULT NULL,
  `instructor_grado` varchar(50) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `correo` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `user` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `token` varchar(64) DEFAULT NULL,
  `token_expiracion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id`, `nombre`, `siglas`, `logo`, `fecha_fundacion`, `pais`, `departamento`, `ciudad`, `direccion`, `instructor_nombre`, `instructor_grado`, `telefono`, `correo`, `estado`, `user`, `pass`, `token`, `token_expiracion`) VALUES
(1, 'JediSae', 'TKD-J', NULL, '1981-01-01', 'Hoduras', 'Atlantida', 'La Ceiba', 'Col. Sauce', 'CRR', '5to Dan', '97897757', 'croberto.reina@gmail.com', 1, 'croberto.reina@gmail.com', '$2y$10$K2CPI6fSrZt7SATuhG5JYe9PYZvX.qdvwfFuLUTdqgkye.mjQXD4S', NULL, NULL),
(2, 'Sombae', 'SMB', NULL, NULL, NULL, NULL, 'La Ceiba', NULL, 'Mario Zuniga', '7mo Dan', '98989797', 'charycarm@gmail.com', 1, 'charycarm@gmail.com', '$2y$10$h9MbF2cT7QrML4j2ly8N8e28vMsJChokbDlaWfQJtLJUEQmR4d2PC', NULL, NULL),
(4, 'Tigres Dorados', 'TKD-TD', NULL, NULL, NULL, NULL, 'Managua', NULL, NULL, NULL, NULL, 'tigres@mail.com', 1, 'tigres@mail.com', '$2y$10$.0HYNGKXRFcervv5bXVheeoVv7GNh6DIzmHhlbnML3SbhMBvULdeK', NULL, NULL),
(9, 'Dojang de Prueba', 'TKD-PR', NULL, NULL, 'Nicaragua', NULL, 'Managua', 'Calle Principal', 'Master Test', '5to Dan', '88888888', 'nueva_prueba1782012444@mail.com', 1, '', '$2y$10$.BE8FjNttL7ARrnZqGMLa.NYx7lfpbiBw8CkW3CO1gOmo5XrlPvJ6', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE `evaluaciones` (
  `id` int(11) NOT NULL,
  `id_torneo` int(11) NOT NULL,
  `id_participante` int(11) NOT NULL,
  `id_juez` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL DEFAULT 'poomsae',
  `puntos` decimal(3,1) NOT NULL DEFAULT 0.0,
  `fecha_evaluacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(20) NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_avance`
--

CREATE TABLE `evaluacion_avance` (
  `id_torneo` int(11) NOT NULL,
  `id_participante` int(11) NOT NULL,
  `id_juez` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion_listo`
--

CREATE TABLE `evaluacion_listo` (
  `id_torneo` int(11) NOT NULL,
  `id_participante` int(11) NOT NULL,
  `id_juez` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jueces`
--

CREATE TABLE `jueces` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 2,
  `id_escuela` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jueces`
--

INSERT INTO `jueces` (`id`, `nombre`, `apellido`, `telefono`, `ciudad`, `user`, `pass`, `level`, `id_escuela`) VALUES
(1, 'Admin', 'Taekwondo', '0000-0000', 'La Ceiba', 'admin', '$2y$10$KAR/TOLm343xOmSXKGlQxeqWoyWm/pnFQMDaFuemk8vhB/qyK.KuC', 1, NULL),
(2, 'Kylo', 'Ren', '97897757', 'La Ceiba', 'karel89@gmail.com', '$2y$10$bNE7/SlvMQPM5Tg3ZF3zu.bxlEf7i62qwG8nwyPrQZxufuRR.8Kj2', 2, 1),
(5, 'Juez', 'Test', '', '', 'juez_test', '0', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes`
--

CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `sexo` enum('M','F') DEFAULT NULL,
  `edad` int(3) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `estatura` decimal(5,2) DEFAULT NULL,
  `grado` varchar(50) DEFAULT NULL,
  `correo` varchar(200) DEFAULT NULL,
  `fotografia` varchar(255) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `cinturon` varchar(50) DEFAULT NULL,
  `id_cinturon` int(11) DEFAULT NULL,
  `id_escuela` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `participantes`
--

INSERT INTO `participantes` (`id`, `nombre`, `apellido`, `telefono`, `ciudad`, `sexo`, `edad`, `fecha_nacimiento`, `peso`, `estatura`, `grado`, `correo`, `fotografia`, `categoria`, `cinturon`, `id_cinturon`, `id_escuela`) VALUES
(1, 'Kylo', 'Ren', '9878-5645', 'LCB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL),
(2, 'Ana', 'Prueba', '9999-0000', 'TestCity', 'F', 20, NULL, NULL, NULL, NULL, NULL, NULL, 'Adulto', 'Azul', NULL, 1),
(5, 'Jib', 'Su', '98987898', 'La Ceiba', 'M', 14, NULL, NULL, NULL, NULL, NULL, NULL, 'Juvenil', 'Amarillo/Verde', NULL, 1),
(6, 'Su', 'Jin', '', 'La Ceiba', 'M', 12, '0000-00-00', 56.00, 1.30, '1er KUP', '', NULL, 'Juvenil', 'Verde-Azul', 6, 1),
(12, 'Test', 'User', '', 'Managua', 'M', NULL, '2012-06-15', NULL, NULL, '', 'test@mail.com', NULL, NULL, 'Verde', 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participante_categoria`
--

CREATE TABLE `participante_categoria` (
  `id` int(11) NOT NULL,
  `id_torneo` int(11) NOT NULL,
  `id_participante` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneojueces`
--

CREATE TABLE `torneojueces` (
  `id` int(11) NOT NULL,
  `idTorneo` int(11) NOT NULL,
  `idJuez` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `torneojueces`
--

INSERT INTO `torneojueces` (`id`, `idTorneo`, `idJuez`) VALUES
(1, 3, 2),
(2, 3, 1),
(3, 7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneoparticipante`
--

CREATE TABLE `torneoparticipante` (
  `idTorneo` int(11) NOT NULL,
  `idParticipante` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `torneoparticipante`
--

INSERT INTO `torneoparticipante` (`idTorneo`, `idParticipante`, `id_categoria`) VALUES
(1, 1, NULL),
(3, 2, NULL),
(3, 6, NULL),
(7, 6, NULL),
(7, 2, 4),
(7, 12, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneos`
--

CREATE TABLE `torneos` (
  `idTorneo` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time DEFAULT NULL,
  `ciudad` varchar(100) NOT NULL,
  `lugar` varchar(200) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `id_escuela` int(11) DEFAULT NULL,
  `codigo_acceso` varchar(16) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `estado` tinyint(1) NOT NULL DEFAULT 0,
  `estado_efectivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `torneos`
--

INSERT INTO `torneos` (`idTorneo`, `nombre`, `descripcion`, `fecha`, `hora`, `ciudad`, `lugar`, `departamento`, `pais`, `id_escuela`, `codigo_acceso`, `activo`, `estado`, `estado_efectivo`) VALUES
(1, 'torneoPrueba', NULL, '2025-01-31', NULL, 'La Ceiba', NULL, NULL, NULL, NULL, NULL, 0, 0, 1),
(2, 'Torneo Verano', NULL, '2026-06-21', NULL, 'La Ceiba', NULL, NULL, NULL, NULL, NULL, 0, 0, 1),
(3, 'Torneo Test 2', NULL, '2026-12-20', NULL, 'TestCity', NULL, NULL, NULL, 1, '65BJWYMF', 1, 0, 1),
(6, 'Torneo Test', '', '2026-08-15', NULL, 'Managua', '', NULL, NULL, 2, 'POOMSAE-944BDE', 1, 0, 1),
(7, 'Test-Invitacion', '', '2026-07-15', NULL, 'La Ceiba', 'Coliseo', NULL, NULL, 1, 'POOMSAE-DC8053', 1, 0, 1),
(8, 'PROBANDO ENVIAR CODIGO', '', '2026-07-05', NULL, 'La Ceiba', 'GimSae', NULL, NULL, 1, 'POOMSAE-473F6C', 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneo_categorias`
--

CREATE TABLE `torneo_categorias` (
  `id` int(11) NOT NULL,
  `id_torneo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `sexo` enum('M','F','X') DEFAULT 'X',
  `edad_min` int(3) DEFAULT NULL,
  `edad_max` int(3) DEFAULT NULL,
  `cinturon_min` varchar(50) DEFAULT NULL,
  `cinturon_max` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `torneo_categorias`
--

INSERT INTO `torneo_categorias` (`id`, `id_torneo`, `nombre`, `sexo`, `edad_min`, `edad_max`, `cinturon_min`, `cinturon_max`, `created_at`) VALUES
(4, 7, 'Infantil', 'X', 8, 9, 'Verde', 'Verde punta azul', '2026-07-01 02:34:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneo_invitaciones`
--

CREATE TABLE `torneo_invitaciones` (
  `id` int(11) NOT NULL,
  `id_torneo` int(11) NOT NULL,
  `id_escuela` int(11) NOT NULL,
  `estado` enum('pendiente','aceptada') DEFAULT 'aceptada',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `torneo_invitaciones`
--

INSERT INTO `torneo_invitaciones` (`id`, `id_torneo`, `id_escuela`, `estado`, `created_at`) VALUES
(2, 8, 2, 'aceptada', '2026-07-01 02:10:20'),
(3, 7, 2, 'aceptada', '2026-07-01 02:11:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneo_puntajes`
--

CREATE TABLE `torneo_puntajes` (
  `id` int(11) NOT NULL,
  `id_torneo` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_participante` int(11) NOT NULL,
  `id_juez` int(11) NOT NULL,
  `puntaje` decimal(4,1) NOT NULL DEFAULT 4.0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `torneo_puntajes`
--

INSERT INTO `torneo_puntajes` (`id`, `id_torneo`, `id_categoria`, `id_participante`, `id_juez`, `puntaje`, `created_at`) VALUES
(1, 7, 4, 2, 2, 3.7, '2026-07-01 02:53:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user`, `pass`, `level`) VALUES
(1, 'admin', '1234', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cinturon`
--
ALTER TABLE `cinturon`
  ADD PRIMARY KEY (`idCinturon`),
  ADD UNIQUE KEY `uk_nombre` (`nombre`);

--
-- Indices de la tabla `control_evaluacion`
--
ALTER TABLE `control_evaluacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_torneo` (`id_torneo`),
  ADD KEY `id_participante_actual` (`id_participante_actual`);

--
-- Indices de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- Indices de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_torneo` (`id_torneo`),
  ADD KEY `id_participante` (`id_participante`),
  ADD KEY `id_juez` (`id_juez`);

--
-- Indices de la tabla `evaluacion_avance`
--
ALTER TABLE `evaluacion_avance`
  ADD PRIMARY KEY (`id_torneo`,`id_participante`,`id_juez`),
  ADD KEY `id_participante` (`id_participante`),
  ADD KEY `id_juez` (`id_juez`);

--
-- Indices de la tabla `evaluacion_listo`
--
ALTER TABLE `evaluacion_listo`
  ADD PRIMARY KEY (`id_torneo`,`id_participante`,`id_juez`),
  ADD KEY `id_participante` (`id_participante`),
  ADD KEY `id_juez` (`id_juez`);

--
-- Indices de la tabla `jueces`
--
ALTER TABLE `jueces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_escuela` (`id_escuela`);

--
-- Indices de la tabla `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participante_categoria`
--
ALTER TABLE `participante_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `torneojueces`
--
ALTER TABLE `torneojueces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idTorneo` (`idTorneo`),
  ADD KEY `idJuez` (`idJuez`);

--
-- Indices de la tabla `torneoparticipante`
--
ALTER TABLE `torneoparticipante`
  ADD UNIQUE KEY `uq_torneo_participante` (`idTorneo`,`idParticipante`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD PRIMARY KEY (`idTorneo`),
  ADD UNIQUE KEY `uk_codigo_acceso` (`codigo_acceso`),
  ADD KEY `id_escuela` (`id_escuela`);

--
-- Indices de la tabla `torneo_categorias`
--
ALTER TABLE `torneo_categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_torneo` (`id_torneo`);

--
-- Indices de la tabla `torneo_invitaciones`
--
ALTER TABLE `torneo_invitaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_torneo_escuela` (`id_torneo`,`id_escuela`),
  ADD KEY `id_escuela` (`id_escuela`);

--
-- Indices de la tabla `torneo_puntajes`
--
ALTER TABLE `torneo_puntajes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_evaluacion` (`id_participante`,`id_juez`),
  ADD KEY `id_torneo` (`id_torneo`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_juez` (`id_juez`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cinturon`
--
ALTER TABLE `cinturon`
  MODIFY `idCinturon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `control_evaluacion`
--
ALTER TABLE `control_evaluacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `jueces`
--
ALTER TABLE `jueces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `participante_categoria`
--
ALTER TABLE `participante_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `torneojueces`
--
ALTER TABLE `torneojueces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `torneos`
--
ALTER TABLE `torneos`
  MODIFY `idTorneo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `torneo_categorias`
--
ALTER TABLE `torneo_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `torneo_invitaciones`
--
ALTER TABLE `torneo_invitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `torneo_puntajes`
--
ALTER TABLE `torneo_puntajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `evaluacion_avance`
--
ALTER TABLE `evaluacion_avance`
  ADD CONSTRAINT `evaluacion_avance_ibfk_1` FOREIGN KEY (`id_torneo`) REFERENCES `torneos` (`idTorneo`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluacion_avance_ibfk_2` FOREIGN KEY (`id_participante`) REFERENCES `participantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluacion_avance_ibfk_3` FOREIGN KEY (`id_juez`) REFERENCES `jueces` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `evaluacion_listo`
--
ALTER TABLE `evaluacion_listo`
  ADD CONSTRAINT `evaluacion_listo_ibfk_1` FOREIGN KEY (`id_torneo`) REFERENCES `torneos` (`idTorneo`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluacion_listo_ibfk_2` FOREIGN KEY (`id_participante`) REFERENCES `participantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluacion_listo_ibfk_3` FOREIGN KEY (`id_juez`) REFERENCES `jueces` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `jueces`
--
ALTER TABLE `jueces`
  ADD CONSTRAINT `jueces_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `torneoparticipante`
--
ALTER TABLE `torneoparticipante`
  ADD CONSTRAINT `torneoparticipante_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `torneo_categorias` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD CONSTRAINT `torneos_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `torneo_categorias`
--
ALTER TABLE `torneo_categorias`
  ADD CONSTRAINT `torneo_categorias_ibfk_1` FOREIGN KEY (`id_torneo`) REFERENCES `torneos` (`idTorneo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `torneo_invitaciones`
--
ALTER TABLE `torneo_invitaciones`
  ADD CONSTRAINT `torneo_invitaciones_ibfk_1` FOREIGN KEY (`id_torneo`) REFERENCES `torneos` (`idTorneo`) ON DELETE CASCADE,
  ADD CONSTRAINT `torneo_invitaciones_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
