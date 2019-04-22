-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.0.38-MariaDB-0ubuntu0.16.04.1 - Ubuntu 16.04
-- Операционная система:         debian-linux-gnu
-- HeidiSQL Версия:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных yii2basic
CREATE DATABASE IF NOT EXISTS `yii2basic` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `yii2basic`;

-- Дамп структуры для таблица yii2basic.country
CREATE TABLE IF NOT EXISTS `country` (
  `code` char(2) NOT NULL,
  `name` char(52) NOT NULL,
  `population` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2basic.country: ~12 rows (приблизительно)
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` (`code`, `name`, `population`) VALUES
	('AI', 'Azaza', 123123123),
	('AU', 'Australia', 24016400),
	('BL', 'Belarus', 9475600),
	('BR', 'Brazil', 205722000),
	('CA', 'Canada', 35985751),
	('CN', 'China', 1375210000),
	('DE', 'Germany', 81459000),
	('FR', 'France', 64513242),
	('GB', 'United Kingdom', 65097000),
	('IN', 'India', 1285400000),
	('RU', 'Russia', 146519759),
	('US', 'United States', 322976000);
/*!40000 ALTER TABLE `country` ENABLE KEYS */;

-- Дамп структуры для таблица yii2basic.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы yii2basic.migration: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1555260969),
	('m190414_163109_migrate_user', 1555270819),
	('m190414_175621_migrate_task', 1555270819),
	('m190414_181737_migrate_task_user', 1555270819),
	('m190416_213257_migrate_foreignKey', 1555522976);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

-- Дамп структуры для таблица yii2basic.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы yii2basic.product: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `name`, `price`, `created_at`) VALUES
	(1, 'TSP FASTY', '5040', '2019-04-05'),
	(2, 'Andro Temper Tech All+', '3249', '2019-04-06'),
	(3, 'Donic Ovcharov', '7380', '2019-04-07'),
	(4, 'Stiga Carbonado 45', '15120', '2019-04-08'),
	(5, 'Butterfly SK CARBON', '8910', '2019-04-09'),
	(6, 'TTSPORT ALL+', '970', '2019-04-09'),
	(9, 'Wolf Off', '', '0000-00-00'),
	(10, '111', '980', '2019-04-10'),
	(11, '222', '120', '2019-04-11'),
	(12, '333', '340', '2019-04-12'),
	(13, '222', '1652', '2019-04-14');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Дамп структуры для таблица yii2basic.task
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `creator_id` int(11) NOT NULL,
  `updater_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fx_task_user1` (`creator_id`),
  KEY `fx_task_user2` (`updater_id`),
  CONSTRAINT `fx_task_user1` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`),
  CONSTRAINT `fx_task_user2` FOREIGN KEY (`updater_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы yii2basic.task: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` (`id`, `title`, `description`, `creator_id`, `updater_id`, `created_at`, `updated_at`) VALUES
	(8, 'Title_1', 'Description_1', 9, 9, 1555874045, 1555874045),
	(9, 'Title_2', 'Description_2', 7, 7, 1555874079, 1555874079),
	(10, 'Title_3', 'Description_3', 10, 10, 1555874143, 1555874143),
	(11, 'Title_4', 'Description_4', 11, 11, 1555874172, 1555874172),
	(12, 'Title_5', 'Description_5', 12, 12, 1555874202, 1555874202),
	(13, 'Title_6', 'Description_6', 13, 7, 1555874249, 1555874898);
/*!40000 ALTER TABLE `task` ENABLE KEYS */;

-- Дамп структуры для таблица yii2basic.task_user
CREATE TABLE IF NOT EXISTS `task_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fx_taskuser_user` (`user_id`),
  KEY `fx_taskuser_task` (`task_id`),
  CONSTRAINT `fx_taskuser_task` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
  CONSTRAINT `fx_taskuser_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы yii2basic.task_user: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `task_user` DISABLE KEYS */;
INSERT INTO `task_user` (`id`, `task_id`, `user_id`) VALUES
	(17, 8, 9),
	(18, 9, 7),
	(19, 10, 11);
/*!40000 ALTER TABLE `task_user` ENABLE KEYS */;

-- Дамп структуры для таблица yii2basic.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `creator_id` int(11) NOT NULL,
  `updater_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- Дамп данных таблицы yii2basic.user: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password_hash`, `auth_key`, `creator_id`, `updater_id`, `created_at`, `updated_at`) VALUES
	(7, 'boris', '$2y$13$vSSREEBfHmwSLAma3ZOvaelV4RNTDcqvu8FWN9tlqoIwTjRM/pxoS', 'NnMmRg3kyravM4CCP39lSVjCyJL_ZTeO', 1, NULL, 1555871247, 1555871247),
	(9, 'admin', '$2y$13$uAf9uIEIrNNPttIoMurOj.k8ATvxwiOlC7hWpblH4.RcsSbTbEpZ2', 'Jxjx6bXg-xEgQL7GKIRt4Peud7B182Pd', 1, NULL, 1555873832, 1555873832),
	(10, 'demo', '$2y$13$IVoaVCfq/OyaWiwvLJ2IvuajW9MQ/I0xf.srqzd4nwTe3.UXBhwOu', 'B_JhuxMRYXuPYX9HP-Pg3oPiphxY25uu', 1, NULL, 1555873863, 1555873863),
	(11, 'adam', '$2y$13$dJNkyzISM1JAyEMImcm9buzeh1TrIc0C3QJGUKKH6w.QpMaUzRz0i', 'lzjMirwNQjJkzJ-Ox8MA0N9KGRob4iIt', 1, NULL, 1555873900, 1555873900),
	(12, 'eva', '$2y$13$Ld49R1DA3tYZTtsPaClHiORkivggcdht.nk73uwG1ZBsCVOYlIIMG', '1vPQ6O85Boti2EvCNDVP98Xs62706kZE', 1, NULL, 1555873913, 1555873913),
	(13, 'yiiUser', '$2y$13$WmW3FiBj5MviX9Pg1K9YYOa2FSCYAX5B8ebvd/7F/uaSO547C/MdC', '116SwyHzNZ7z52194Nn_-bgoNFPm-aRT', 1, NULL, 1555873922, 1555873922),
	(14, 'root', '$2y$13$3qVXg4RjFyzIwDzF5cQhFO4La7FMfwRhS/5matQqh5jyhixD8lBR6', 'v2OByYOjWaf_NbbozV_ABd_erEyxtFfd', 1, NULL, 1555874539, 1555874539),
	(15, 'newuser', '$2y$13$4eJUFSLSuFCheJftkduJgOtHArGcjxYgpbwNHDmgP0Tyy3d7hgaJO', 'GSZ666czoD9caYr326Iu6qQXjsF6nTQs', 14, 14, 1555875102, 1555875102);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
