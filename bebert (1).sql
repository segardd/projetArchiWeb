-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 31 mars 2020 à 16:36
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bebert`
--

-- --------------------------------------------------------

--
-- Structure de la table `affaire`
--

DROP TABLE IF EXISTS `affaire`;
CREATE TABLE IF NOT EXISTS `affaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `affaire`
--

INSERT INTO `affaire` (`id`, `designation`) VALUES
(3, 'test'),
(4, 'une affaire');

-- --------------------------------------------------------

--
-- Structure de la table `affaire_politicien`
--

DROP TABLE IF EXISTS `affaire_politicien`;
CREATE TABLE IF NOT EXISTS `affaire_politicien` (
  `affaire_id` int(11) NOT NULL,
  `politicien_id` int(11) NOT NULL,
  PRIMARY KEY (`affaire_id`,`politicien_id`),
  KEY `IDX_BDAFF6F5F082E755` (`affaire_id`),
  KEY `IDX_BDAFF6F57C1FA7B6` (`politicien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `affaire_politicien`
--

INSERT INTO `affaire_politicien` (`affaire_id`, `politicien_id`) VALUES
(3, 5),
(4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `mairie`
--

DROP TABLE IF EXISTS `mairie`;
CREATE TABLE IF NOT EXISTS `mairie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mairie`
--

INSERT INTO `mairie` (`id`, `ville`) VALUES
(1, 'Amiens'),
(2, 'Lille');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200331145700', '2020-03-31 14:57:57');

-- --------------------------------------------------------

--
-- Structure de la table `parti`
--

DROP TABLE IF EXISTS `parti`;
CREATE TABLE IF NOT EXISTS `parti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parti`
--

INSERT INTO `parti` (`id`, `nom`) VALUES
(1, 'PCF'),
(2, 'PS');

-- --------------------------------------------------------

--
-- Structure de la table `politicien`
--

DROP TABLE IF EXISTS `politicien`;
CREATE TABLE IF NOT EXISTS `politicien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mairie_id` int(11) DEFAULT NULL,
  `parti_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D7F73E4D6C6E55B5` (`nom`),
  KEY `IDX_D7F73E4DE7A79AB` (`mairie_id`),
  KEY `IDX_D7F73E4D712547C6` (`parti_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `politicien`
--

INSERT INTO `politicien` (`id`, `mairie_id`, `parti_id`, `nom`, `sexe`, `age`) VALUES
(5, 2, 2, 'Merkel', 'F', 70),
(6, 1, 1, 'Balkany', 'M', 68);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(1, 'admin', '[\"ROLE_SUPER_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$cGZBSi5CRkxUOFVETEl5Sg$F6seUHs5wxPdUA+tgch/OTv7AGJBWHKpZj+vWKJRwvQ'),
(2, 'secretary', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$ZXNYRC5oUVJjWnBlOFlZZg$brgsh8746tYS1Y8b7ZRNMwYJRmNJ/9wS4nDTvI9/bxM'),
(3, 'user', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$L0lITW03TGlEelloQzVVcw$/UCj17lapWaqVuKG8B9yUiIRaG5jpuP9Dy2wVBb96Xc');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affaire_politicien`
--
ALTER TABLE `affaire_politicien`
  ADD CONSTRAINT `FK_BDAFF6F57C1FA7B6` FOREIGN KEY (`politicien_id`) REFERENCES `politicien` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_BDAFF6F5F082E755` FOREIGN KEY (`affaire_id`) REFERENCES `affaire` (`id`);

--
-- Contraintes pour la table `politicien`
--
ALTER TABLE `politicien`
  ADD CONSTRAINT `FK_D7F73E4D712547C6` FOREIGN KEY (`parti_id`) REFERENCES `parti` (`id`),
  ADD CONSTRAINT `FK_D7F73E4DE7A79AB` FOREIGN KEY (`mairie_id`) REFERENCES `mairie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
