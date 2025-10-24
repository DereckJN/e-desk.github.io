-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-10-2025 a las 11:55:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
 /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
 /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 /*!40101 SET NAMES utf8mb4 */;

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

--
-- Base de datos: `e-desk`
--
CREATE DATABASE IF NOT EXISTS `e-desk` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `e-desk`;

-- --------------------------------------------------------
-- ESTRUCTURA (sin claves; se agregan al final 
-- --------------------------------------------------------

-- Tabla: rol
CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: usuario
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `correo` varchar(190) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `ultimo_inicio` datetime DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: estado_ticket
CREATE TABLE `estado_ticket` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `es_activo` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: sla
CREATE TABLE `sla` (
  `id_sla` int(11) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `horas_respuesta` int(11) NOT NULL,
  `horas_resolucion` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: categoria
CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(120) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `id_sla` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: etiqueta
CREATE TABLE `etiqueta` (
  `id_etiqueta` int(11) NOT NULL,
  `nombre_etiqueta` varchar(120) NOT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: categoria_etiqueta
CREATE TABLE `categoria_etiqueta` (
  `id_categoria` int(11) NOT NULL,
  `id_etiqueta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: especialidad
CREATE TABLE `especialidad` (
  `id_especialidad` int(11) NOT NULL,
  `nombre_especialidad` varchar(160) NOT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: tecnico
CREATE TABLE `tecnico` (
  `id_usuario` int(11) NOT NULL,
  `disponibilidad` varchar(50) DEFAULT NULL,
  `carga_actual` int(11) NOT NULL DEFAULT 0,
  `carga_maxima` int(11) NOT NULL DEFAULT 10,
  `tickets_activos` int(11) NOT NULL DEFAULT 0,
  `tickets_completados` int(11) NOT NULL DEFAULT 0,
  `tickets_pendientes` int(11) NOT NULL DEFAULT 0,
  `horas_trabajadas` decimal(10,2) NOT NULL DEFAULT 0.00,
  `eficiencia` decimal(5,2) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_actualizacion_carga` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Pivot: tecnico_especialidad
CREATE TABLE `tecnico_especialidad` (
  `id_tecnico` int(11) NOT NULL,
  `id_especialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: imagen_ticket
CREATE TABLE `imagen_ticket` (
  `id_imagen` int(11) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `tipo_archivo` varchar(50) DEFAULT NULL,
  `tamano_archivo` bigint(20) DEFAULT NULL,
  `id_usuario_subio` int(11) NOT NULL,
  `fecha_subida` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: ticket
CREATE TABLE `ticket` (
  `id_ticket` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `prioridad` varchar(50) DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_usuario_cliente` int(11) NOT NULL,
  `calificacion` tinyint(3) DEFAULT NULL,
  `comentario_valoracion` varchar(600) DEFAULT NULL,
  `fecha_valoracion` datetime DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_primera_respuesta` datetime DEFAULT NULL,
  `fecha_resolucion` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `fecha_limite_respuesta` datetime DEFAULT NULL,
  `fecha_limite_resolucion` datetime DEFAULT NULL,
  `dias_resolucion` int(11) DEFAULT NULL,
  `cumplimiento_respuesta` tinyint(1) DEFAULT NULL,
  `cumplimiento_resolucion` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: asignacion
CREATE TABLE `asignacion` (
  `id_asignacion` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_tecnico` int(11) NOT NULL,
  `metodo_asignacion` varchar(50) DEFAULT NULL,
  `fecha_asignacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: historial_estado
CREATE TABLE `historial_estado` (
  `id_historial` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_estado_anterior` int(11) DEFAULT NULL,
  `id_estado_nuevo` int(11) NOT NULL,
  `id_usuario_cambio` int(11) NOT NULL,
  `fecha_cambio` datetime NOT NULL DEFAULT current_timestamp(),
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: historial_tickets
CREATE TABLE `historial_tickets` (
  `id_historial` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_imagen` int(11) DEFAULT NULL,
  `id_estado_anterior` int(11) DEFAULT NULL,
  `id_estado_nuevo` int(11) DEFAULT NULL,
  `observaciones` varchar(600) DEFAULT NULL,
  `id_usuario_responsable` int(11) DEFAULT NULL,
  `fecha_cambio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: notificacion
CREATE TABLE `notificacion` (
  `id_notificacion` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `id_remitente` int(11) DEFAULT NULL,
  `tipo_notificacion` varchar(50) DEFAULT NULL,
  `id_ticket_relacionado` int(11) DEFAULT NULL,
  `mensaje` varchar(600) DEFAULT NULL,
  `estado_notificacion` varchar(50) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: valoracion
CREATE TABLE `valoracion` (
  `id_valoracion` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `calificacion` tinyint(3) DEFAULT NULL,
  `comentario` varchar(600) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- INSERTS (Datos semilla; >= 4 por tabla)
-- --------------------------------------------------------

-- rol
INSERT INTO `rol` (`id_rol`,`descripcion`) VALUES
(1,'Administrador'),
(2,'Técnico'),
(3,'Cliente'),
(4,'Supervisor');

-- usuario
INSERT INTO `usuario`
(`id_usuario`,`correo`,`contrasena`,`id_rol`,`estado`,`ultimo_inicio`,`fecha_creacion`,`fecha_actualizacion`)
VALUES
(1,'admin@edesk.com','$2y$10$1ueeLDj8HL5ghcusBD/byOYhlcDBSiailMADfTkQ76dgU4IevRmNK',1,'ACTIVO','2025-01-01 08:00:00','2025-01-01 08:00:00','2025-01-01 08:00:00'),
(2,'tecnico@edesk.com','$2y$10$1ueeLDj8HL5ghcusBD/byOYhlcDBSiailMADfTkQ76dgU4IevRmNK',2,'ACTIVO','2025-01-02 09:00:00','2025-01-02 09:00:00','2025-01-02 09:00:00'),
(3,'cliente1@edesk.com','$2y$10$1ueeLDj8HL5ghcusBD/byOYhlcDBSiailMADfTkQ76dgU4IevRmNK',3,'ACTIVO','2025-01-03 10:00:00','2025-01-03 10:00:00','2025-01-03 10:00:00'),
(4,'cliente2@edesk.com','$2y$10$1ueeLDj8HL5ghcusBD/byOYhlcDBSiailMADfTkQ76dgU4IevRmNK',3,'ACTIVO','2025-01-04 10:30:00','2025-01-04 10:30:00','2025-01-04 10:30:00'),
(5,'tecnico2@edesk.com','$2y$10$1ueeLDj8HL5ghcusBD/byOYhlcDBSiailMADfTkQ76dgU4IevRmNK',2,'ACTIVO',NOW(),NOW(),NOW()),
(6,'tecnico3@edesk.com','$2y$10$1ueeLDj8HL5ghcusBD/byOYhlcDBSiailMADfTkQ76dgU4IevRmNK',2,'ACTIVO',NOW(),NOW(),NOW()),
(7,'tecnico4@edesk.com','$2y$10$1ueeLDj8HL5ghcusBD/byOYhlcDBSiailMADfTkQ76dgU4IevRmNK',2,'ACTIVO',NOW(),NOW(),NOW()),
(8,'cliente3@edesk.com','$2y$10$1ueeLDj8HL5ghcusBD/byOYhlcDBSiailMADfTkQ76dgU4IevRmNK',3,'ACTIVO',NOW(),NOW(),NOW()),
(9,'cliente4@edesk.com','$2y$10$1ueeLDj8HL5ghcusBD/byOYhlcDBSiailMADfTkQ76dgU4IevRmNK',3,'ACTIVO',NOW(),NOW(),NOW()),
(10,'supervisor@edesk.com','$2y$10$1ueeLDj8HL5ghcusBD/byOYhlcDBSiailMADfTkQ76dgU4IevRmNK',4,'ACTIVO',NOW(),NOW(),NOW());

-- estado_ticket
INSERT INTO `estado_ticket`
(`id_estado`,`nombre_estado`,`descripcion`,`es_activo`,`fecha_creacion`) VALUES
(1,'Abierto','Ticket creado',1, NOW()),
(2,'En Progreso','Atendido por técnico',1, NOW()),
(3,'En Espera','Pendiente de información',1, NOW()),
(4,'Resuelto','Solución aplicada',1, NOW()),
(5,'Cerrado','Ticket cerrado',1, NOW());

-- sla
INSERT INTO `sla` (`id_sla`,`descripcion`,`horas_respuesta`,`horas_resolucion`,`estado`) VALUES
(1,'Crítico',1,4,'ACTIVO'),
(2,'Alto',2,8,'ACTIVO'),
(3,'Medio',4,24,'ACTIVO'),
(4,'Bajo',8,72,'ACTIVO');

-- categoria
INSERT INTO `categoria`
(`id_categoria`,`nombre_categoria`,`descripcion`,`id_sla`,`estado`,`fecha_creacion`,`fecha_actualizacion`) VALUES
(1,'Hardware','Incidencias de equipos',2,'ACTIVO',NOW(),NOW()),
(2,'Software','Aplicaciones y licencias',3,'ACTIVO',NOW(),NOW()),
(3,'Redes','Conectividad y VPN',1,'ACTIVO',NOW(),NOW()),
(4,'Correo','Incidencias y cuentas de email',3,'ACTIVO',NOW(),NOW());

-- etiqueta
INSERT INTO `etiqueta` (`id_etiqueta`,`nombre_etiqueta`,`estado`) VALUES
(1,'Urgente','ACTIVO'),
(2,'VPN','ACTIVO'),
(3,'Impresora','ACTIVO'),
(4,'Software','ACTIVO');

-- categoria_etiqueta
INSERT INTO `categoria_etiqueta` (`id_categoria`,`id_etiqueta`) VALUES
(1,3),
(2,1),
(3,2),
(4,1);

-- especialidad
INSERT INTO `especialidad` (`id_especialidad`,`nombre_especialidad`,`estado`) VALUES
(1,'Soporte Windows','ACTIVO'),
(2,'Redes y Seguridad','ACTIVO'),
(3,'Impresoras','ACTIVO'),
(4,'Linux/Servers','ACTIVO');

-- tecnico
INSERT INTO `tecnico`
(`id_usuario`,`disponibilidad`,`carga_actual`,`carga_maxima`,`tickets_activos`,`tickets_completados`,`tickets_pendientes`,`horas_trabajadas`,`eficiencia`,`estado`,`fecha_actualizacion_carga`)
VALUES
(2,'DISPONIBLE',1,10,1,25,0,120.50,95.00,1,NOW()),
(5,'DISPONIBLE',0,12,0,10,0,80.00,90.00,1,NOW()),
(6,'OCUPADO',2,12,2,40,1,300.00,88.50,1,NOW()),
(7,'DISPONIBLE',1,8,1,15,0,150.75,92.30,1,NOW());

-- tecnico_especialidad
INSERT INTO `tecnico_especialidad` (`id_tecnico`,`id_especialidad`) VALUES
(2,1),
(2,2),
(5,2),
(6,3),
(7,1);

-- imagen_ticket
INSERT INTO `imagen_ticket`
(`id_imagen`,`ruta_archivo`,`nombre_archivo`,`tipo_archivo`,`tamano_archivo`,`id_usuario_subio`,`fecha_subida`,`estado`)
VALUES
(1,'/upload/tickets/2025/01/img-abc123.png','img-abc123.png','image/png',204800,3,NOW(),1),
(2,'/upload/tickets/2025/01/log-error.txt','log-error.txt','text/plain',4096,3,NOW(),1),
(3,'/upload/tickets/2025/02/cap-vpn.png','cap-vpn.png','image/png',102400,8,NOW(),1),
(4,'/upload/tickets/2025/02/req-software.pdf','req-software.pdf','application/pdf',51200,9,NOW(),1);

-- ticket
INSERT INTO `ticket`
(`id_ticket`,`titulo`,`descripcion`,`prioridad`,`id_estado`,`id_categoria`,`id_usuario_cliente`,
 `calificacion`,`comentario_valoracion`,`fecha_valoracion`,`fecha_creacion`,
 `fecha_primera_respuesta`,`fecha_resolucion`,`fecha_cierre`,
 `fecha_limite_respuesta`,`fecha_limite_resolucion`,`dias_resolucion`,
 `cumplimiento_respuesta`,`cumplimiento_resolucion`)
VALUES
(1,'No imprime','La impresora HP muestra atascos', 'ALTA', 2, 1, 3, NULL,NULL,NULL,
 NOW(), DATE_ADD(NOW(), INTERVAL 30 MINUTE), NULL, NULL,
 DATE_ADD(NOW(), INTERVAL 2 HOUR), DATE_ADD(NOW(), INTERVAL 8 HOUR), NULL, NULL, NULL),
(2,'VPN no conecta','Error al autenticar en VPN', 'CRITICA', 1, 3, 4, NULL,NULL,NULL,
 NOW(), NULL, NULL, NULL,
 DATE_ADD(NOW(), INTERVAL 1 HOUR), DATE_ADD(NOW(), INTERVAL 4 HOUR), NULL, NULL, NULL),
(3,'Instalar software','Solicito instalación de VS Code','MEDIA', 1, 2, 3, NULL,NULL,NULL,
 NOW(), NULL, NULL, NULL,
 DATE_ADD(NOW(), INTERVAL 4 HOUR), DATE_ADD(NOW(), INTERVAL 24 HOUR), NULL, NULL, NULL),
(4,'Cuenta de correo bloqueada','No puedo iniciar sesión en correo corporativo','ALTA',1,4,8,
 NULL,NULL,NULL,
 NOW(), NULL, NULL, NULL,
 DATE_ADD(NOW(), INTERVAL 2 HOUR), DATE_ADD(NOW(), INTERVAL 24 HOUR), NULL, NULL, NULL);

-- asignacion
INSERT INTO `asignacion`
(`id_asignacion`,`id_ticket`,`id_tecnico`,`metodo_asignacion`,`fecha_asignacion`)
VALUES
(1,1,2,'MANUAL',NOW()),
(2,2,2,'AUTOMATICA',NOW()),
(3,3,5,'MANUAL',NOW()),
(4,4,6,'AUTOMATICA',NOW());

-- historial_estado
INSERT INTO `historial_estado`
(`id_historial`,`id_ticket`,`id_estado_anterior`,`id_estado_nuevo`,`id_usuario_cambio`,`fecha_cambio`,`observaciones`)
VALUES
(1,1,NULL,1,1, NOW(),'Ticket creado'),
(2,1,1,2,2, NOW(),'Toma de técnico'),
(3,2,NULL,1,1, NOW(),'Ticket creado'),
(4,4,NULL,1,1,NOW(),'Ticket creado (Correo)');

-- historial_tickets
INSERT INTO `historial_tickets`
(`id_historial`,`id_ticket`,`id_imagen`,`id_estado_anterior`,`id_estado_nuevo`,`observaciones`,`id_usuario_responsable`,`fecha_cambio`)
VALUES
(1,1,1,NULL,2,'Se adjunta evidencia del atasco',2,NOW()),
(2,2,2,NULL,1,'Se agrega log de error',1,NOW()),
(3,3,3,1,1,'Se adjunta captura VPN',2,NOW()),
(4,4,4,NULL,1,'Solicitud de desbloqueo de correo',1,NOW());

-- notificacion
INSERT INTO `notificacion`
(`id_notificacion`,`id_destinatario`,`id_remitente`,`tipo_notificacion`,`id_ticket_relacionado`,`mensaje`,`estado_notificacion`,`fecha_creacion`)
VALUES
(1,3,2,'ACTUALIZACION',1,'Tu ticket fue tomado por un técnico','ENVIADA',NOW()),
(2,4,1,'CREACION',2,'Se creó tu ticket de VPN','ENVIADA',NOW()),
(3,8,1,'CREACION',4,'Se creó tu ticket de correo','ENVIADA',NOW()),
(4,8,6,'ASIGNACION',4,'Tu ticket fue asignado a un técnico','ENVIADA',NOW());

-- valoracion
INSERT INTO `valoracion`
(`id_valoracion`,`id_ticket`,`id_cliente`,`calificacion`,`comentario`,`fecha_creacion`)
VALUES
(1,1,3,5,'Excelente atención',NOW()),
(2,2,4,4,'Resuelto a tiempo',NOW()),
(3,3,3,5,'Muy buen soporte',NOW()),
(4,4,8,3,'Aún pendiente, pero avanzando',NOW());

-- --------------------------------------------------------
-- ÍNDICES (como en movie_rental)
-- --------------------------------------------------------

-- Indices de la tabla `rol`
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

-- Indices de la tabla `usuario`
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `uq_usuario_correo` (`correo`),
  ADD KEY `idx_usuario_id_rol` (`id_rol`);

-- Indices de la tabla `estado_ticket`
ALTER TABLE `estado_ticket`
  ADD PRIMARY KEY (`id_estado`),
  ADD UNIQUE KEY `uq_estado_nombre` (`nombre_estado`);

-- Indices de la tabla `sla`
ALTER TABLE `sla`
  ADD PRIMARY KEY (`id_sla`);

-- Indices de la tabla `categoria`
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `idx_categoria_id_sla` (`id_sla`);

-- Indices de la tabla `etiqueta`
ALTER TABLE `etiqueta`
  ADD PRIMARY KEY (`id_etiqueta`),
  ADD UNIQUE KEY `uq_etiqueta_nombre` (`nombre_etiqueta`);

-- Indices de la tabla `categoria_etiqueta`
ALTER TABLE `categoria_etiqueta`
  ADD PRIMARY KEY (`id_categoria`,`id_etiqueta`),
  ADD KEY `idx_categoria_etiqueta_id_etiqueta` (`id_etiqueta`);

-- Indices de la tabla `especialidad`
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id_especialidad`);

-- Indices de la tabla `tecnico`
ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`id_usuario`);

-- Indices de la tabla `tecnico_especialidad`
ALTER TABLE `tecnico_especialidad`
  ADD PRIMARY KEY (`id_tecnico`,`id_especialidad`),
  ADD KEY `idx_tecnico_especialidad_id_especialidad` (`id_especialidad`);

-- Indices de la tabla `imagen_ticket`
ALTER TABLE `imagen_ticket`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `idx_imagen_usuario_subio` (`id_usuario_subio`);

-- Indices de la tabla `ticket`
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `idx_ticket_categoria` (`id_categoria`),
  ADD KEY `idx_ticket_usuario_cliente` (`id_usuario_cliente`),
  ADD KEY `idx_ticket_estado` (`id_estado`),
  ADD KEY `idx_ticket_fecha_creacion` (`fecha_creacion`),
  ADD KEY `idx_ticket_estado_prioridad` (`id_estado`,`prioridad`(10));

-- Indices de la tabla `asignacion`
ALTER TABLE `asignacion`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `idx_asignacion_id_ticket` (`id_ticket`),
  ADD KEY `idx_asignacion_id_tecnico` (`id_tecnico`);

-- Indices de la tabla `historial_estado`
ALTER TABLE `historial_estado`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `idx_historial_ticket` (`id_ticket`),
  ADD KEY `idx_historial_usuario` (`id_usuario_cambio`),
  ADD KEY `idx_historial_estado_ant` (`id_estado_anterior`),
  ADD KEY `idx_historial_estado_nue` (`id_estado_nuevo`);

-- Indices de la tabla `historial_tickets`
ALTER TABLE `historial_tickets`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `idx_historial_tickets_ticket` (`id_ticket`),
  ADD KEY `idx_historial_tickets_usuario` (`id_usuario_responsable`),
  ADD KEY `idx_historial_tickets_estado_ant` (`id_estado_anterior`),
  ADD KEY `idx_historial_tickets_estado_nue` (`id_estado_nuevo`),
  ADD KEY `idx_historial_tickets_imagen` (`id_imagen`);

-- Indices de la tabla `notificacion`
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `idx_notificacion_dest` (`id_destinatario`),
  ADD KEY `idx_notificacion_reme` (`id_remitente`),
  ADD KEY `idx_notificacion_ticket` (`id_ticket_relacionado`);

-- Indices de la tabla `valoracion`
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`id_valoracion`),
  ADD KEY `idx_valoracion_ticket` (`id_ticket`),
  ADD KEY `idx_valoracion_cliente` (`id_cliente`);

-- --------------------------------------------------------
-- AUTO_INCREMENT (como en movie_rental)
-- --------------------------------------------------------

ALTER TABLE `rol`               MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `usuario`           MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `estado_ticket`     MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `sla`               MODIFY `id_sla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `categoria`         MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `etiqueta`          MODIFY `id_etiqueta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `especialidad`      MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `imagen_ticket`     MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `ticket`            MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `asignacion`        MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `historial_estado`  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `historial_tickets` MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `notificacion`      MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `valoracion`        MODIFY `id_valoracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- --------------------------------------------------------
-- RESTRICCIONES (FK) (como en movie_rental: al final)
-- --------------------------------------------------------

-- usuario
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_fk_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON UPDATE CASCADE ON DELETE SET NULL;

-- categoria
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_fk_sla` FOREIGN KEY (`id_sla`) REFERENCES `sla` (`id_sla`) ON UPDATE CASCADE;

-- categoria_etiqueta
ALTER TABLE `categoria_etiqueta`
  ADD CONSTRAINT `categoria_etiqueta_fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categoria_etiqueta_fk_etiqueta` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiqueta` (`id_etiqueta`) ON DELETE CASCADE ON UPDATE CASCADE;

-- tecnico
ALTER TABLE `tecnico`
  ADD CONSTRAINT `tecnico_fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

-- tecnico_especialidad
ALTER TABLE `tecnico_especialidad`
  ADD CONSTRAINT `tecnico_especialidad_fk_tecnico` FOREIGN KEY (`id_tecnico`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tecnico_especialidad_fk_especialidad` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id_especialidad`) ON DELETE CASCADE ON UPDATE CASCADE;

-- imagen_ticket
ALTER TABLE `imagen_ticket`
  ADD CONSTRAINT `imagen_ticket_fk_usuario` FOREIGN KEY (`id_usuario_subio`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;

-- ticket
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_fk_usuario_cliente` FOREIGN KEY (`id_usuario_cliente`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_fk_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado_ticket` (`id_estado`);

-- asignacion
ALTER TABLE `asignacion`
  ADD CONSTRAINT `asignacion_fk_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacion_fk_tecnico` FOREIGN KEY (`id_tecnico`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;

-- historial_estado
ALTER TABLE `historial_estado`
  ADD CONSTRAINT `historial_estado_fk_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historial_estado_fk_usuario` FOREIGN KEY (`id_usuario_cambio`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `historial_estado_fk_estado_ant` FOREIGN KEY (`id_estado_anterior`) REFERENCES `estado_ticket` (`id_estado`),
  ADD CONSTRAINT `historial_estado_fk_estado_nue` FOREIGN KEY (`id_estado_nuevo`) REFERENCES `estado_ticket` (`id_estado`);

-- historial_tickets
ALTER TABLE `historial_tickets`
  ADD CONSTRAINT `historial_tickets_fk_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id_ticket`) ON DELETE CASCADE,
  ADD CONSTRAINT `historial_tickets_fk_usuario` FOREIGN KEY (`id_usuario_responsable`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `historial_tickets_fk_estado_ant` FOREIGN KEY (`id_estado_anterior`) REFERENCES `estado_ticket` (`id_estado`),
  ADD CONSTRAINT `historial_tickets_fk_estado_nue` FOREIGN KEY (`id_estado_nuevo`) REFERENCES `estado_ticket` (`id_estado`),
  ADD CONSTRAINT `historial_tickets_fk_imagen` FOREIGN KEY (`id_imagen`) REFERENCES `imagen_ticket` (`id_imagen`) ON DELETE SET NULL ON UPDATE CASCADE;

-- notificacion
ALTER TABLE `notificacion`
  ADD CONSTRAINT `notificacion_fk_dest` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `notificacion_fk_remitente` FOREIGN KEY (`id_remitente`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `notificacion_fk_ticket` FOREIGN KEY (`id_ticket_relacionado`) REFERENCES `ticket` (`id_ticket`) ON DELETE SET NULL ON UPDATE CASCADE;

-- valoracion
ALTER TABLE `valoracion`
  ADD CONSTRAINT `valoracion_fk_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `valoracion_fk_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;

-- --------------------------------------------------------
-- RESTAURAR FLAGS Y FINALIZAR
-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
