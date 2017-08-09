-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `db_silex` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `db_silex`;

DROP TABLE IF EXISTS `silex_link`;
CREATE TABLE `silex_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `silex_link` (`id`, `url`) VALUES
(25,	'https://yandex.ru'),
(24,	'https://vk.com/mcsim'),
(23,	'https://gmail.com'),
(22,	'https://vk.com/mcsim'),
(21,	'https://gmail.com'),
(20,	'https://vk.com/mcsim'),
(19,	'https://vk.ru/mcsim'),
(18,	'https://yandex.ru');

-- 2017-08-09 17:15:48
