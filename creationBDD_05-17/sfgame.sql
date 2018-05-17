-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 17 mai 2018 à 22:33
-- Version du serveur :  5.7.21
-- Version de PHP :  7.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sfgame`
--

-- --------------------------------------------------------

--
-- Structure de la table `asteroide`
--

DROP TABLE IF EXISTS `asteroide`;
CREATE TABLE IF NOT EXISTS `asteroide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taille` int(11) NOT NULL,
  `pop` int(11) NOT NULL DEFAULT '0',
  `nom` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `minerai`
--

DROP TABLE IF EXISTS `minerai`;
CREATE TABLE IF NOT EXISTS `minerai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rel_asteroide_minerai`
--

DROP TABLE IF EXISTS `rel_asteroide_minerai`;
CREATE TABLE IF NOT EXISTS `rel_asteroide_minerai` (
  `asteroide_id` int(11) NOT NULL,
  `minerai_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rel_secteur_asteroide`
--

DROP TABLE IF EXISTS `rel_secteur_asteroide`;
CREATE TABLE IF NOT EXISTS `rel_secteur_asteroide` (
  `secteur_id` int(11) NOT NULL,
  `asteroide_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rel_secteur_type`
--

DROP TABLE IF EXISTS `rel_secteur_type`;
CREATE TABLE IF NOT EXISTS `rel_secteur_type` (
  `secteur_id` int(11) NOT NULL,
  `secteur_type_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `secteur`
--

DROP TABLE IF EXISTS `secteur`;
CREATE TABLE IF NOT EXISTS `secteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pos_x` int(11) NOT NULL,
  `pos_y` int(11) NOT NULL,
  `ordre` int(11) NOT NULL DEFAULT '0',
  `nom` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `secteur_type`
--

DROP TABLE IF EXISTS `secteur_type`;
CREATE TABLE IF NOT EXISTS `secteur_type` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `image` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `secteur_type`
--

INSERT INTO `secteur_type` (`id`, `nom`, `image`) VALUES
(1, 'Astéroïdes', ''),
(2, 'Système planétaire', ''),
(3, 'Epaves', ''),
(4, 'Trou noir', ''),
(90, 'Vide', ''),
(99, 'Pop', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
