-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 10 mai 2021 à 12:55
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_sortir`
--

-- --------------------------------------------------------

--
-- Structure de la table `campus`
--

DROP TABLE IF EXISTS `campus`;
CREATE TABLE IF NOT EXISTS `campus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `campus`
--

INSERT INTO `campus` (`id`, `nom`) VALUES
(1, 'St-Herblain'),
(2, 'Rennes'),
(3, 'Nantes'),
(4, 'Chartres'),
(5, 'Paris');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
(1, 'Créée'),
(2, 'Ouverte'),
(3, 'Clôturée'),
(4, 'Activité en cours'),
(5, 'Passée'),
(6, 'Annulée');

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
CREATE TABLE IF NOT EXISTS `lieu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ville_id` int NOT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2F577D59A73F0036` (`ville_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id`, `ville_id`, `nom`, `rue`, `latitude`, `longitude`) VALUES
(1, 3, 'Le Lieu Unique', '12 rue Jesais Pas', 119292, 3336),
(2, 3, 'La tour des 50 otages', '14 cours des 50 otages', 161661, 383838),
(3, 4, 'Au billard gourmand', '37 avenue du Général De Gaulle', 77.228833, -55.77689),
(4, 2, 'Damien Lucas', '37 avenue du Général De Gaulle', 161661, -55.77689);

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

DROP TABLE IF EXISTS `sortie`;
CREATE TABLE IF NOT EXISTS `sortie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `etat_id` int DEFAULT NULL,
  `campus_id` int DEFAULT NULL,
  `orga_id` int DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_debut` datetime NOT NULL,
  `duree` int NOT NULL,
  `date_limite_inscription` date NOT NULL,
  `nb_inscriptions_max` int NOT NULL,
  `infos_sortie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3C3FD3F2D5E86FF` (`etat_id`),
  KEY `IDX_3C3FD3F2AF5D55E1` (`campus_id`),
  KEY `IDX_3C3FD3F297F068A1` (`orga_id`),
  KEY `IDX_3C3FD3F26AB213CC` (`lieu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`id`, `etat_id`, `campus_id`, `orga_id`, `nom`, `date_heure_debut`, `duree`, `date_limite_inscription`, `nb_inscriptions_max`, `infos_sortie`, `lieu_id`) VALUES
(1, 1, 3, 6, 'Sortie ciné', '2016-01-01 00:00:00', 6, '2016-01-04', 5, 'coucou super sortie', 1),
(2, 2, 4, 6, 'Theatre', '2021-05-11 10:00:00', 120, '2021-05-10', 3, 'test', 2),
(3, 2, 4, 6, 'ddamiendf', '2021-05-12 10:00:00', 120, '2021-05-10', 3, 'ekhjlhk', 2),
(6, 2, 4, 2, 'Test', '2021-05-13 09:45:00', 130, '2021-05-12', 3, 'ghjgjk', 3);

-- --------------------------------------------------------

--
-- Structure de la table `sortie_utilisateur`
--

DROP TABLE IF EXISTS `sortie_utilisateur`;
CREATE TABLE IF NOT EXISTS `sortie_utilisateur` (
  `sortie_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  PRIMARY KEY (`sortie_id`,`utilisateur_id`),
  KEY `IDX_2C57C50FCC72D953` (`sortie_id`),
  KEY `IDX_2C57C50FFB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `campus_id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` decimal(10,0) NOT NULL,
  `administrateur` tinyint(1) NOT NULL,
  `actif` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1D1C63B3E7927C74` (`email`),
  KEY `IDX_1D1C63B3AF5D55E1` (`campus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `campus_id`, `email`, `roles`, `password`, `nom`, `prenom`, `telephone`, `administrateur`, `actif`) VALUES
(1, 4, 'damien.lucas44@gmail.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$VWFrMjlZaFRuN1dWblZvUw$NRAErbozOcLs/Xcx+YMPLHKSOv9TjcM5G4yS1GhV6KI', 'Lucas', 'Damien', '771811825', 1, 1),
(2, 4, 'yo@yo.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$WGdIZE9HTS5vaEh3MS55cA$qXFKdvgWeQsRYLTO4OY47NjHlPLcs1txOTZRcW0VCSI', 'YOYO', 'Youyou', '192837478', 1, 1),
(3, 2, 'pouf@pouf.fr', '[]', '$argon2id$v=19$m=65536,t=4,p=1$WEdNbkZBeThFekRsU0tHdw$wFJSdHMHM38AUk5OmQeYsjyxV5OghmHukWyXKj13dqY', 'Pouf', 'Poufpouf', '110011099', 1, 1),
(4, 4, 'jdupond@mail.fr', '[]', '$argon2id$v=19$m=65536,t=4,p=1$d1VZZndnZlA4T25rTi9BVA$R0zAaA2uW2QIzOR7xcpyaceSrcVaVwzDp+PiheQnsm0', 'Jean', 'Duduponpon', '380127724', 1, 1),
(6, 4, 'jacques@ouille.fr', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$dWhRRXdKN3pTeFN6RVY0Sg$5YKFIx4z7EVuUNkYsiTegaI1YrZwUBHfdAmPVaTna+I', 'Ouilles', 'Jacques', '600000000', 1, 1),
(7, 4, 'doudou@dindon.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$dzcxS3pCWXNUZDhHU3dWMQ$dJTAexwkg76avpny2phflyNjVVfZ1MT1PNsY3Ab1s2E', 'Ouille', 'Jacques', '600000000', 0, 1),
(8, 4, 'campus@campus.co', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$OUdTN0l1ejN2eGRILnZBNw$3AE4bW6G+4apHqMIPlUuBOeE6TkTQ9mSc4J80ntFsIs', 'Ouille', 'Jacques', '600000000', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `nom`, `code_postal`) VALUES
(1, 'Paris', '75000'),
(2, 'Paris', '75000'),
(3, 'Nantes', '44000'),
(4, 'Rennes', '35000');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD CONSTRAINT `FK_2F577D59A73F0036` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD CONSTRAINT `FK_3C3FD3F26AB213CC` FOREIGN KEY (`lieu_id`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F297F068A1` FOREIGN KEY (`orga_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2AF5D55E1` FOREIGN KEY (`campus_id`) REFERENCES `campus` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2D5E86FF` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`);

--
-- Contraintes pour la table `sortie_utilisateur`
--
ALTER TABLE `sortie_utilisateur`
  ADD CONSTRAINT `FK_2C57C50FCC72D953` FOREIGN KEY (`sortie_id`) REFERENCES `sortie` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2C57C50FFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_1D1C63B3AF5D55E1` FOREIGN KEY (`campus_id`) REFERENCES `campus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
