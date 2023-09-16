-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 15 sep. 2023 à 20:43
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `myblog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `published` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `body`, `created_at`, `updated_at`, `published`) VALUES
(1, 1, 8, 'alo', '2023-05-07 22:00:00', '2023-05-30 22:00:00', 1),
(3, 1, 1, 'test comment1', '2023-05-24 22:00:00', NULL, 1),
(5, 1, 1, 'test comment1', '2023-05-24 22:00:00', NULL, 1),
(6, 1, 1, 'test comment1', '2023-05-24 22:00:00', NULL, 1),
(8, 1, 8, 'commentaireUsernamda', '2023-05-26 22:00:00', NULL, 1),
(9, 1, 8, 'commentaireUsernamda', '2023-05-26 22:00:00', NULL, 1),
(10, 1, 8, 'commentaireUsernamda', '2023-05-26 22:00:00', NULL, 1),
(11, 1, 8, 'test comment', '2023-05-26 22:00:00', NULL, 1),
(19, 1, 10, 'Fait dans le cadre du projet OpenClassRoom.', '2023-06-05 22:00:00', NULL, 1),
(20, 1, 10, 'test comment', '2023-06-05 22:00:00', NULL, 1),
(22, 1, 3, 'test comment', '2023-06-05 22:00:00', NULL, 1),
(24, 1, 9, 'commentaireUsernamda', '2023-06-05 22:00:00', NULL, 1),
(25, 1, 9, 'test comment', '2023-06-05 22:00:00', NULL, 1),
(26, 1, 9, 'test123', '2023-06-05 22:00:00', NULL, 1),
(27, 1, 9, 'test123', '2023-06-05 22:00:00', NULL, 1),
(28, 1, 8, 'yuihui', '2023-06-22 16:56:45', NULL, 1),
(29, 1, 8, 'azerty', '2023-06-22 16:56:53', NULL, 1),
(30, 1, 3, 'tttt', '2023-06-22 16:57:40', NULL, 1),
(31, 1, 8, 'cccc', '2023-06-22 17:17:09', NULL, 1),
(32, 1, 3, 'tttt', '2023-06-23 08:49:23', NULL, 1),
(33, 1, 7, 'alertze', '2023-07-03 08:47:21', NULL, 1),
(34, 14, 1, 'hello', '2023-09-11 12:08:48', NULL, 1),
(35, 14, 1, 'hello', '2023-09-11 12:09:04', NULL, 1),
(36, 14, 1, 'hello', '2023-09-11 12:15:11', NULL, 1),
(37, 14, 1, 'hello', '2023-09-11 12:18:04', NULL, 1),
(38, 14, 1, 'testazerty', '2023-09-12 23:02:47', NULL, 1),
(39, 14, 1, 'testazerty', '2023-09-12 23:11:02', NULL, 1),
(40, 14, 1, 'testazerty', '2023-09-13 07:46:31', NULL, 1),
(41, 14, 1, 'testazerty', '2023-09-13 07:50:49', NULL, 1),
(42, 14, 1, 'hello', '2023-09-13 07:51:52', NULL, 1),
(43, 14, 1, 'hello test vcb', '2023-09-13 07:53:08', NULL, 1),
(44, 14, 1, 'hello test vcb', '2023-09-13 08:26:05', NULL, 1),
(45, 14, 1, 'hello test vcb', '2023-09-13 08:34:25', NULL, 1),
(46, 14, 3, 'hello test username', '2023-09-13 09:50:48', NULL, 1),
(47, 14, 1, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-13 17:29:09', NULL, NULL),
(48, 14, 1, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-13 17:29:33', NULL, NULL),
(49, 14, 1, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-13 17:29:47', NULL, NULL),
(50, 14, 3, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-14 10:10:37', NULL, NULL),
(51, 14, 3, 'hello test username', '2023-09-14 10:27:27', NULL, NULL),
(52, 14, 3, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-14 10:27:37', NULL, NULL),
(53, 14, 3, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-14 10:29:54', NULL, NULL),
(54, 14, 3, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-14 10:30:21', NULL, NULL),
(55, 14, 3, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-14 10:31:56', NULL, NULL),
(56, 14, 3, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-14 10:32:10', NULL, NULL),
(57, 14, 3, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-14 10:34:41', NULL, NULL),
(58, 14, 3, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-14 10:34:49', NULL, 1),
(59, 14, 3, 'hello test vcbzzzzzzzzzzzzzzzzz', '2023-09-14 10:36:06', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `date_updated` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `chapo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `User_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `created_at`, `user_id`, `published`, `date_updated`, `image`, `chapo`) VALUES
(1, 'start blog3', 'start blog debut du blog ?', '2023-03-16', 1, 1, '2023-06-06', '', 'projet openclassroom'),
(2, 'Blog Test1', 'je teste ce blog', '2023-03-21', 1, 1, '2023-06-06', '', 'info'),
(3, 'Creation d un site web pour une agence immobiliere.', 'Dans le cadre du projet de formation OpenClassroom j\'ai crÃ©e ce site d\'une agence de location et vente de chalets de luxe.', '2023-05-01', 1, 1, '2023-05-08', 'P2.png', 'projet openclassroom'),
(4, 'crÃ©ation de site internet cinÃ©ma pleinair', 'Dans le cadre du projet de formation OpenClassroom j\'ai crÃ©e ce site de cinÃ©ma pleinair, il permet de promouvoir et d estimer et de rÃ©server des places pour diffÃ©rents sÃ©ances de cinÃ©ma pleinair.', '2023-05-02', 1, 1, '2023-05-08', 'P4.jpg', 'lecture'),
(7, 'Dune Pilat', 'dune pilat.', '2023-06-06', 6, 0, NULL, '', '0'),
(8, 'Projet5', 'cr�er mon blog professionnel', '2023-06-09', 6, 0, '2023-06-09', 'banner.jpg', '0'),
(9, 'test', 'test text', '2023-09-12', 14, 1, NULL, NULL, 'extrait test'),
(10, 'test', 'test text', '2023-09-12', 14, 0, NULL, NULL, 'extrait test'),
(11, '', '', '2023-09-12', 14, 0, NULL, NULL, ''),
(14, '', '', '2023-09-12', 14, 0, NULL, NULL, ''),
(15, 'test123', 'test text123', '2023-09-12', 14, 0, NULL, 'P2.png', 'test123'),
(16, 'qscQSD', 'QsdQSDqsd', '2023-09-13', 14, 0, NULL, 'Capture d’écran 2023-09-12 153259.jpg', 'QsdQSD'),
(17, 'yhjyjyuj', 'yjuyujyujyujyuj', '2023-09-13', 14, 0, NULL, 'Capture d’écran 2023-09-12 153259.jpg', 'yjyjyuj'),
(18, 'dfgfgdfg', 'fgcfgcgvf', '2023-09-13', 14, 0, NULL, 'Capture d’écran 2023-09-12 153259.jpg', 'fgfgfg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` tinyint(3) UNSIGNED DEFAULT NULL,
  `role` varchar(22) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `valid` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `age`, `role`, `username`, `created_at`, `updated_at`, `valid`) VALUES
(1, 'ibtissem', 'ben hammouda', 'ibh28031982@yahoo.fr', 'admin', 40, 'admin', 'admin', NULL, '2023-05-15', 0),
(4, 'user', 'zert', 'zsoumaBH@hotmail.fr', '1b2ccf52b54ea2c9468ca24fbe164919', 32, 'user', 'zadmin', '2023-05-15', '2023-05-18', 0),
(9, 'FirstAdmin', 'lastAdmin', 'adminNamda@yahoo.fr', 'cc03e747a6afbbcbf8be7668acfebee5', 30, 'admin', 'adminNamda', '2023-06-09', NULL, NULL),
(14, 'test12', 'test12', 'souma@hotmail.fr', '$2y$10$x23wedqWzbLg1wWxQblQiOlTCqAhYAfVGXjz3t7bGhT3dUjjIfIkO', 21, 'admin', 'souma@hotmail.fr', '2023-09-04', '2023-09-04', NULL),
(16, 'ibtissem', 'ben hammouda', 'admin1@hotmail.fr', '$2y$10$C4HOQqKWunhPaVGtCcpZ.ekyYFvCWBxJ1KARZmM8shuIB8AHjt6vG', 40, 'author', 'admin1@hotmail.fr', '2023-09-14', '2023-09-14', NULL);
COMMIT;
