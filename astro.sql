-- Adminer 4.8.1 MySQL 8.0.31 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `astromen` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `astromen`;

DROP TABLE IF EXISTS `astro_tab`;
CREATE TABLE `astro_tab` (
  `id` int NOT NULL AUTO_INCREMENT,
  `f_name` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_czech_ci NOT NULL,
  `l_name` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_czech_ci NOT NULL,
  `DOB` date NOT NULL,
  `skill` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

INSERT INTO `astro_tab` (`id`, `f_name`, `l_name`, `DOB`, `skill`) VALUES
(1,	'L<b>ajk</b>a',	'pes',	'1954-09-11',	'Nejdelší pobyt na oběžné dráze'),
(2,	'Homer',	'Simpson',	'1961-05-11',	'Pojídání chipsů v beztížném stavu'),
(9,	'Jurij',	'Gagarin',	'1934-03-09',	'Pěrvyj v kosmose');

DROP TABLE IF EXISTS `logger`;
CREATE TABLE `logger` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `astro_tab_id` int unsigned NOT NULL,
  `action_id` int unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `astro_tab_id` (`astro_tab_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `logger` (`id`, `astro_tab_id`, `action_id`, `date`) VALUES
(1,	12,	3,	'2025-01-26 22:32:45'),
(2,	12,	2,	'2025-01-26 22:34:30'),
(3,	13,	1,	'2025-01-26 22:34:52'),
(4,	13,	2,	'2025-01-26 22:35:03');

DROP TABLE IF EXISTS `logger_action`;
CREATE TABLE `logger_action` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `short_name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `short_name` (`short_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `logger_action` (`id`, `short_name`) VALUES
(1,	'added'),
(2,	'deleted'),
(3,	'updated');

-- 2025-01-26 22:38:04
