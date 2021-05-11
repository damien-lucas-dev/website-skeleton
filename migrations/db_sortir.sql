-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 11 mai 2021 à 18:40
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
-- Structure de la table `annulation`
--

DROP TABLE IF EXISTS `annulation`;
CREATE TABLE IF NOT EXISTS `annulation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sortie_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `raison` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_26F7D84CC72D953` (`sortie_id`),
  KEY `IDX_26F7D84FB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annulation`
--

INSERT INTO `annulation` (`id`, `sortie_id`, `utilisateur_id`, `raison`, `datetime`) VALUES
(1, 11, 6, 'Parce que...', '2021-05-11 16:00:02'),
(2, 12, 11, 'Finalement j\'aurai piscine ce jour là...', '2021-05-11 17:41:12'),
(3, 3, 6, NULL, '2021-05-11 18:35:40');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id`, `ville_id`, `nom`, `rue`, `latitude`, `longitude`) VALUES
(1, 3, 'Le Lieu Unique', '12 rue Jesais Pas', 119292, 3336),
(2, 3, 'La tour des 50 otages', '14 cours des 50 otages', 161661, 383838),
(3, 4, 'Au billard gourmand', '37 avenue du Général De Gaulle', 77.228833, -55.77689),
(5, 4, 'Ciné l\'EMPIRE', '25 rue de l\'empire', 73.228833, -45.77689),
(6, 6, 'Eglise', '1 place de l\'église', 47.214403, 1.467094),
(7, 7, 'La Croix Jeannette', 'Place de la croix jeannette', 47.172656, 1.623697),
(8, 2, 'Parc de la Chézine', '16 rue du Mississipi', 47.224603, 1.665563),
(9, 1, 'Tour Effeil', '5 avenue Anatole France', 48.857643, 2.291763),
(10, 7, 'Piano\'cktail', 'Rue Ginsheim Gustavsburg', 47.173854, 1.608594),
(11, 8, 'Plage de Saint-Séb', '37 rue des pas enchantés', 47.173848, 1.641425);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`id`, `etat_id`, `campus_id`, `orga_id`, `nom`, `date_heure_debut`, `duree`, `date_limite_inscription`, `nb_inscriptions_max`, `infos_sortie`, `lieu_id`) VALUES
(1, 5, 3, 6, 'Sortie ciné', '2016-01-01 00:00:00', 6, '2016-01-04', 5, 'Mais ils étaient beaucoup plus rapides et plus grands. Le peu de voitures qui circulaient encore étaient ultra sécurisées. C\'est pourquoi la vitesse maximum autorisée avait été portée à 230km/h. Les gens pouvaient commencer à travailler à l’aide de leur o', 1),
(2, 3, 4, 6, 'Theatre', '2021-05-12 10:00:00', 120, '2021-05-12', 3, 'Florence avait fini de préparer le matériel demandé par Prélude. Elle était fin prête. Elle vérifia le bon fonctionnement de la liaison entre son ordinateur portable et Internet. Prélude était bien là. A peine connecté à Internet que la voix de Prélude se', 2),
(3, 6, 4, 6, 'Jeux vidéos chez oim!', '2021-05-12 10:00:00', 120, '2021-05-10', 3, 'Le général sorti un badge et se dirigea vers l’une des portes entourées de peinture jaune. Il glissa le badge dans la fente située à droite. La porte s’ouvrit. Une dizaine de militaires armées jusqu’aux dents étaient postés derrière.', 2),
(6, 6, 4, 2, 'Test', '2021-05-13 09:45:00', 130, '2021-05-12', 3, 'Le général sorti un badge et se dirigea vers l’une des portes entourées de peinture jaune. Il glissa le badge dans la fente située à droite. La porte s’ouvrit. Une dizaine de militaires armées jusqu’aux dents étaient postés derrière.', 3),
(7, 2, 3, 2, 'Pique nique au parc', '2021-05-12 12:29:00', 60, '2021-05-12', 10, 'Super gros texte explicatif plein d\'informations super explicatives Amener chips saucisson et compagnie, jambon frites et bières, un mölkky et jeu de pétanques et plein de caractères UTF-8 comme des smileys 😁😁 des (h) 😎 et même des\r\n( *^-^)ρ(*╯^╰)', 1),
(8, 2, 2, 3, 'Spider-Man 5 (ciné)', '2021-05-13 22:40:00', 125, '2021-05-13', 15, 'On va voir spider-man 5 au cinoche !', 5),
(9, 2, 1, 7, 'Molkky', '2021-05-14 13:00:00', 30, '2021-05-13', 5, 'Et si on se faisait un petit Mölkky ? Je m’en rappellerais si j’avais créé un programme capable de parler. Et puis tiens, je suis en train de taper la causette avec un ordinateur ! Je deviens vraiment cinglé ! C’est fini, j’arrête l’informatique !', 8),
(10, 6, 2, 3, 'Sortie muée', '2021-05-16 14:43:00', 180, '2021-05-14', 4, 'Dans le plancher pour savoir si quelqu\'un marchait et quel poids il faisait. Le cœur pouvait alors déterminer de quelle personne il s\'agissait. Dans les murs, des cellules photosensibles, des micro-caméras et tout un réseau de détecteurs divers (magnétiqu', 7),
(11, 2, 3, 9, 'Ma sortie', '2021-05-20 15:52:00', 120, '2021-05-19', 4, 'Beaucoup de blabla pour pas grand chose au final c\'est peut être pas utile de surchager, vous trouvez pas ?', 10),
(12, 6, 3, 11, 'Faire des châteaux de sable ensemble', '2021-05-14 16:24:00', 220, '2021-05-13', 3, 'Ammenez :\r\n* pelle\r\n* seau\r\n* paréo\r\n* (... et transats !)', 11);

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

--
-- Déchargement des données de la table `sortie_utilisateur`
--

INSERT INTO `sortie_utilisateur` (`sortie_id`, `utilisateur_id`) VALUES
(1, 2),
(2, 2),
(2, 7),
(2, 9),
(3, 2),
(6, 3),
(7, 6),
(8, 6),
(8, 10),
(11, 11);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `campus_id`, `email`, `roles`, `password`, `nom`, `prenom`, `telephone`, `administrateur`, `actif`) VALUES
(1, 4, 'damien.lucas44@gmail.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$VWFrMjlZaFRuN1dWblZvUw$NRAErbozOcLs/Xcx+YMPLHKSOv9TjcM5G4yS1GhV6KI', 'Lucas', 'Damien', '771811825', 1, 1),
(2, 4, 'yo@yo.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$WGdIZE9HTS5vaEh3MS55cA$qXFKdvgWeQsRYLTO4OY47NjHlPLcs1txOTZRcW0VCSI', 'YOYO', 'Youyou', '192837478', 1, 1),
(3, 2, 'pouf@pouf.fr', '[]', '$argon2id$v=19$m=65536,t=4,p=1$WEdNbkZBeThFekRsU0tHdw$wFJSdHMHM38AUk5OmQeYsjyxV5OghmHukWyXKj13dqY', 'Coptère', 'Amélie', '110011099', 1, 1),
(4, 4, 'jdupond@mail.fr', '[]', '$argon2id$v=19$m=65536,t=4,p=1$d1VZZndnZlA4T25rTi9BVA$R0zAaA2uW2QIzOR7xcpyaceSrcVaVwzDp+PiheQnsm0', 'Jean', 'Duduponpon', '380127724', 1, 1),
(6, 4, 'jacques@ouille.fr', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$dWhRRXdKN3pTeFN6RVY0Sg$5YKFIx4z7EVuUNkYsiTegaI1YrZwUBHfdAmPVaTna+I', 'Ouilles', 'Jacques', '600000000', 1, 1),
(7, 4, 'doudou@dindon.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$dzcxS3pCWXNUZDhHU3dWMQ$dJTAexwkg76avpny2phflyNjVVfZ1MT1PNsY3Ab1s2E', 'Kahn', 'Jerry', '600000000', 0, 1),
(8, 4, 'campus@campus.co', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$OUdTN0l1ejN2eGRILnZBNw$3AE4bW6G+4apHqMIPlUuBOeE6TkTQ9mSc4J80ntFsIs', 'Ouille', 'Jacques', '600000000', 0, 0),
(9, 2, 'gaetanroullet3@gmail.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$WWJCcFEvR0gya3BVLi9tUQ$Z0ZyDn3var98vv+bR/GXBjNjl40Xuy2RA2C2dVtNZ5g', 'ROULLET', 'Gaëtan', '769862415', 0, 1),
(10, 4, 'jean@michel.net', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$YzYyYWtHOXZPclZFR2FxeA$V4wi0oc/H4G0XWarOCK4BiFbWFWyQE00P4yiwgt9+m0', 'MICHEL', 'Jean', '110022002', 0, 0),
(11, 4, 'lara@clette.net', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$U0NMazRLaVBCMi9ueVV3bA$SHz89M77gV6ElGcFZJkf/XIH1UTBd0uwiwsKCyTBaVc', 'Clette', 'Lara', '2003399448', 0, 0),
(12, 1, 'herb@lain.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$ZTVOUWlLdHhEY3E0RzVsVw$7MYAJvHWqOKH5cJos9PYcjj6KTrUvYCNy22FdZkUMt8', 'Naoned', 'Herblain', '5445544554', 0, 0),
(13, 4, 'jean.philippe@philipe.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$NHI0NnVDLkJ2RGp1ZHNpRQ$6swSzB8lOfDR5gv3mVSZkyXPtr5CoZUAVbbBG4sSwTI', 'Phillipe', 'Jean-Philippe', '6534263547', 0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `nom`, `code_postal`) VALUES
(1, 'Paris', '75000'),
(2, 'Saint-Herblain', '44205'),
(3, 'Nantes', '44000'),
(4, 'Rennes', '35000'),
(5, 'Chartres', '28000'),
(6, 'Basse-Goulaine', '44230'),
(7, 'Bouguenais', '44340'),
(8, 'Saint-Sébastien-s/Loire', '44230');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annulation`
--
ALTER TABLE `annulation`
  ADD CONSTRAINT `FK_26F7D84CC72D953` FOREIGN KEY (`sortie_id`) REFERENCES `sortie` (`id`),
  ADD CONSTRAINT `FK_26F7D84FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

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
