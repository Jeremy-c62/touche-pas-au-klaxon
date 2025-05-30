-- Création de la base et des tables (avec IF NOT EXISTS)

CREATE DATABASE IF NOT EXISTS `covoiturage` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `covoiturage`;

CREATE TABLE IF NOT EXISTS `agences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ville` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `employes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` enum('utilisateur','admin') DEFAULT 'utilisateur',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `trajets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agence_depart_id` int(11) NOT NULL,
  `agence_arrivee_id` int(11) NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `date_heure_arrivee` datetime NOT NULL,
  `places_total` int(11) NOT NULL,
  `places_disponibles` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agence_depart_id` (`agence_depart_id`),
  KEY `agence_arrivee_id` (`agence_arrivee_id`),
  KEY `employe_id` (`employe_id`),
  CONSTRAINT `trajets_ibfk_1` FOREIGN KEY (`agence_depart_id`) REFERENCES `agences` (`id`),
  CONSTRAINT `trajets_ibfk_2` FOREIGN KEY (`agence_arrivee_id`) REFERENCES `agences` (`id`),
  CONSTRAINT `trajets_ibfk_3` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trajet_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `places` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `trajet_id` (`trajet_id`),
  KEY `employe_id` (`employe_id`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`trajet_id`) REFERENCES `trajets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`employe_id`) REFERENCES `employes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
