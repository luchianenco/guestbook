--
-- Table structure for table `posts`
--
CREATE DATABASE IF NOT EXISTS guestbook;
USE guestbook;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text,
  `is_image` int(1) NOT NULL DEFAULT '0',
  `status` enum('draft','published','deleted') DEFAULT 'draft',
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `user_id_idx` (`user_id`),
  KEY `status_idx` (`status`),
  CONSTRAINT `user_id_fk_idx` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;


INSERT INTO `users` VALUES (1,'test','123',0),(2,'admin','123',1);
INSERT INTO `posts` VALUES (1,'Hello World!!! Helooooooo!!',0,'published',1,'2018-11-20 21:35:12',NULL),(2,'We are here!!!',0,'published',1,'2018-11-21 13:13:22',NULL),(3,'Juuhuuuu 5000',0,'published',1,'2018-11-20 21:30:51',NULL),(4,'Juuhuuuu 100001',0,'published',1,'2018-11-20 21:33:34',NULL),(5,'Nice!!! Nice!!!',0,'published',1,'2018-11-21 13:31:08',NULL),(6,'Good Night! Sleep Well !!!!!!',0,'deleted',1,'2018-11-18 23:23:51','2018-11-21 16:47:50'),(7,'Juuhuuuu!!! 20220',0,'published',2,'2018-11-20 21:22:32',NULL),(8,'https://media.giphy.com/media/26BRL9kaRin5yu1ji/giphy.gif',1,'published',2,'2018-11-21 15:48:09','2018-11-21 16:35:07');
