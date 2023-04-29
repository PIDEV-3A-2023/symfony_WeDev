-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 29 avr. 2023 à 20:42
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecobike`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230410210644', '2023-04-10 23:07:03', 3509),
('DoctrineMigrations\\Version20230410211149', '2023-04-10 23:12:01', 1125),
('DoctrineMigrations\\Version20230410211942', '2023-04-10 23:19:57', 81851),
('DoctrineMigrations\\Version20230410215059', '2023-04-10 23:51:06', 3003),
('DoctrineMigrations\\Version20230410232819', '2023-04-11 01:28:31', 532),
('DoctrineMigrations\\Version20230410234619', '2023-04-11 01:46:23', 447),
('DoctrineMigrations\\Version20230410234656', '2023-04-11 01:47:00', 795),
('DoctrineMigrations\\Version20230411001039', '2023-04-11 02:10:46', 764),
('DoctrineMigrations\\Version20230411091621', '2023-04-11 11:19:13', 2230),
('DoctrineMigrations\\Version20230424213536', '2023-04-25 05:55:22', 3026),
('DoctrineMigrations\\Version20230425034217', '2023-04-25 05:59:35', 960),
('DoctrineMigrations\\Version20230425040153', '2023-04-25 06:02:02', 296),
('DoctrineMigrations\\Version20230425040357', '2023-04-25 06:04:18', 1045);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) NOT NULL,
  `date_rec` date NOT NULL,
  `description_rec` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_rec` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `admin_reply` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reclamation`
--

INSERT INTO `reclamation` (`id`, `date_rec`, `description_rec`, `etat_rec`, `type_id`, `admin_reply`) VALUES
(7, '2018-01-01', 'sdsdf', 1, NULL, ''),
(9, '2018-01-01', 'sdsdf', 1, NULL, ''),
(10, '2018-01-01', 'vvv', 0, 3, ''),
(11, '2022-01-01', 'tasss', 1, 2, ''),
(12, '2018-01-01', 'aa', 0, 2, ''),
(13, '2018-01-01', '444', 0, 4, ''),
(14, '2018-01-01', 'Je veux reclamer sur une roue', 0, 4, ''),
(15, '2018-01-01', 'je vex reclamaer sur', 1, 5, NULL),
(16, '2018-01-01', 'test classe', 1, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id` int(11) NOT NULL,
  `rec_id` int(11) DEFAULT NULL,
  `reponse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`id`, `rec_id`, `reponse`) VALUES
(1, 7, 'c\'est traitée'),
(5, 12, 'MERCI POUR'),
(6, 14, 'Mercii');

-- --------------------------------------------------------

--
-- Structure de la table `type_rec`
--

CREATE TABLE `type_rec` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_rec`
--

INSERT INTO `type_rec` (`id`, `nom`) VALUES
(2, 'Velo'),
(3, 'TestCLasseType'),
(4, 'stattion'),
(5, 'stattion'),
(6, 'Event');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CE606404C54C8C93` (`type_id`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_5FB6DEC71669B19B` (`rec_id`);

--
-- Index pour la table `type_rec`
--
ALTER TABLE `type_rec`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `type_rec`
--
ALTER TABLE `type_rec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `FK_CE606404C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type_rec` (`id`);

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `FK_5FB6DEC71669B19B` FOREIGN KEY (`rec_id`) REFERENCES `reclamation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
