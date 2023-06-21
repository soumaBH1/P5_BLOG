-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 06 juin 2023 à 21:45
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

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
-- Structure de la table `chapo`
--

DROP TABLE IF EXISTS `chapo`;
CREATE TABLE IF NOT EXISTS `chapo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chapo`
--

INSERT INTO `chapo` (`id`, `name`, `slug`) VALUES
(1, 'hobby', 'hobby'),
(3, 'OpenClassroom', 'openclassroom'),
(4, 'formation', 'formation'),
(2, 'jeux', 'jeux');

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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `body`, `created_at`, `updated_at`, `published`) VALUES
(1, 1, 8, 'alo', '2023-05-07 22:00:00', '2023-05-30 22:00:00', 1),
(3, 1, 1, 'test comment1', '2023-05-24 22:00:00', NULL, 0),
(5, 1, 1, 'test comment1', '2023-05-24 22:00:00', NULL, 1),
(6, 1, 1, 'test comment1', '2023-05-24 22:00:00', NULL, 1),
(8, 1, 8, 'commentaireUsernamda', '2023-05-26 22:00:00', NULL, 1),
(9, 1, 8, 'commentaireUsernamda', '2023-05-26 22:00:00', NULL, 1),
(10, 1, 8, 'commentaireUsernamda', '2023-05-26 22:00:00', NULL, 1),
(11, 1, 8, 'test comment', '2023-05-26 22:00:00', NULL, 1),
(19, 1, 10, 'Fait dans le cadre du projet OpenClassRoom.', '2023-06-05 22:00:00', NULL, 1),
(20, 1, 10, 'test comment', '2023-06-05 22:00:00', NULL, 0),
(22, 1, 3, 'test comment', '2023-06-05 22:00:00', NULL, 1),
(24, 1, 9, 'commentaireUsernamda', '2023-06-05 22:00:00', NULL, 0),
(25, 1, 9, 'test comment', '2023-06-05 22:00:00', NULL, 0),
(26, 1, 9, 'test123', '2023-06-05 22:00:00', NULL, 0),
(27, 1, 9, 'test123', '2023-06-05 22:00:00', NULL, 0);

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
  `date_deleated` date DEFAULT NULL,
  `date_updated` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `chapo_id` int(11) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `User_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `created_at`, `user_id`, `published`, `date_deleated`, `date_updated`, `image`, `views`, `chapo_id`, `slug`) VALUES
(1, 'start blog3', 'start blog debut du blog ?', '2023-03-16', 1, 0, NULL, '2023-06-06', '', 0, 1, 'start-blog3'),
(3, 'Blog Test1', 'je teste ce blog', '2023-03-21', 1, 1, NULL, '2023-06-06', '', 0, 2, 'blog-test1'),
(9, 'Creation d un site web pour une agence immobiliere.', 'Dans le cadre du projet de formation OpenClassroom j\'ai crÃ©e ce site d\'une agence de location et vente de chalets de luxe.', '2023-05-01', 1, 1, NULL, '2023-05-08', 'P2.png', 0, 3, 'Creation d un site web pour une agence immobiliere.'),
(10, 'crÃ©ation de site internet cinÃ©ma pleinair', 'Dans le cadre du projet de formation OpenClassroom j\'ai crÃ©e ce site de cinÃ©ma pleinair, il permet de promouvoir et d estimer et de rÃ©server des places pour diffÃ©rents sÃ©ances de cinÃ©ma pleinair.', '2023-05-02', 1, 1, NULL, '2023-05-08', 'P4.jpg', 0, 3, 'crÃ©ation de site internet cinÃ©ma pleinair'),
(12, 'vive', 'vive blog', '2023-05-12', 1, 1, NULL, '2023-05-12', 'log1.png', 0, 2, 'vive blog'),
(13, 'Dune Pilat', 'dune pilat.', '2023-06-06', 6, 0, NULL, NULL, '', 0, NULL, 'dune-pilat');

-- --------------------------------------------------------

--
-- Structure de la table `post_chapo`
--

DROP TABLE IF EXISTS `post_chapo`;
CREATE TABLE IF NOT EXISTS `post_chapo` (
  `chapo_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post_chapo`
--

INSERT INTO `post_chapo` (`chapo_id`, `post_id`) VALUES
(1, 0),
(1, 0),
(1, 0),
(1, 0),
(0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `age`, `role`, `username`, `created_at`, `updated_at`, `valid`) VALUES
(1, 'ibtissem', 'ben hammouda', 'ibh28031982@yahoo.fr', 'admin', 40, 'admin', 'admin', NULL, '2023-05-15', 0),
(2, 'mickalel', 'andrieux', 'm.andrieux@exemple.com', 'd41d8cd98f00b204e9800998ecf8427e', 34, 'author', 'mikand', NULL, NULL, 1),
(3, 'test', 'test', 'a.klay@exemple.com', 'd41d8cd98f00b204e9800998ecf8427e', 21, 'admin', 'aliklaysalis', NULL, '2023-05-12', 0),
(4, 'author', 'zert', 'zsoumaBH@hotmail.fr', '1b2ccf52b54ea2c9468ca24fbe164919', 32, 'author', 'zadmin', '2023-05-15', '2023-05-18', 0),
(5, 'zatestzzzza', 'zatestzzzz', 'zsoumaBH1@hotmail.fr', '02afd1b17795171d49291318d386ca90', 25, 'author', 'zadmin1', '2023-05-15', '2023-05-15', 0),
(6, 'zatesltzzzza', 'zaltestzzzz', 'zsoumaBH21@hotmail.fr', 'd9c148d1e8ad0c232ce4912160037621', 24, 'admin', 'zadmin12', '2023-05-15', '2023-05-15', 0),
(7, 'alex', 'zombi', 'usernamda@hotmail.fr', '2edfe0964ed231f4d4df2825a79856a4', 50, 'author', 'usernamda', '2023-05-25', NULL, NULL),
(8, 'test', 'test name', 'mail@test.fr', 'testpassword', 20, 'author', 'test user', '2023-06-03', NULL, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
