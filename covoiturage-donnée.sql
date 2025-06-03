USE `covoiturage`;

INSERT INTO `agences` (`id`, `nom_ville`) VALUES
(1, 'Paris'),
(2, 'Lyon'),
(3, 'Marseille'),
(4, 'Lille'),
(5, 'Toulouse'),
(6, 'Nantes'),
(7, 'Strasbourg'),
(8, 'Nice'),
(9, 'Montpellier'),
(10, 'Bordeaux'),
(11, 'Rennes'),
(12, 'Reims');

INSERT INTO `employes` (`id`, `nom`, `prenom`, `telephone`, `email`, `mot_de_passe`, `role`) VALUES
(1, 'Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', NULL, 'utilisateur'),
(2, 'Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', NULL, 'utilisateur'),
(3, 'Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', NULL, 'utilisateur'),
(4, 'Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', NULL, 'utilisateur'),
(5, 'Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', NULL, 'utilisateur'),
(6, 'Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', NULL, 'utilisateur'),
(7, 'Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', NULL, 'utilisateur'),
(8, 'Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', NULL, 'utilisateur'),
(9, 'Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', NULL, 'utilisateur'),
(10, 'Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', NULL, 'utilisateur'),
(11, 'Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', NULL, 'utilisateur'),
(12, 'Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', NULL, 'utilisateur'),
(13, 'Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', NULL, 'utilisateur'),
(14, 'Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', NULL, 'utilisateur'),
(15, 'Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', NULL, 'utilisateur'),
(16, 'Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', NULL, 'utilisateur'),
(17, 'Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', NULL, 'utilisateur'),
(18, 'Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', NULL, 'utilisateur'),
(19, 'Masson', 'Julie', '0733445566', 'julie.masson@email.fr', NULL, 'utilisateur'),
(20, 'Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', NULL, 'utilisateur'),
(29, 'testee', 'teste', '0606060606', 'teste@teste.fr', '$2y$10$JnsrY465qmfCXd61VHVuDu54NJsEWqICJ.yhJDVxmdF.HGdjLj96K', 'utilisateur'),
(30, 'testee', 'adminteste', '0606060607', 'teste@admin.fr', '$2y$10$iqRovv0eRZS2WChK/gLv1O17a0cRLWJ9j79U4FQkJ4pBlGt.yAoyO', 'admin');


INSERT INTO `trajets` (`agence_depart_id`, `agence_arrivee_id`, `date_heure_depart`, `date_heure_arrivee`, `places_total`, `places_disponibles`, `employe_id`) VALUES
(1, 5, '2025-06-02 09:00:00', '2025-06-02 12:00:00', 4, 4, 3),
(6, 4, '2025-06-05 15:30:00', '2025-06-05 18:00:00', 5, 5, 6),
(8, 2, '2025-06-07 07:00:00', '2025-06-07 10:00:00', 3, 2, 9),
(3, 1, '2025-06-10 13:45:00', '2025-06-10 16:15:00', 6, 6, 2),
(11, 3, '2025-06-18 08:00:00', '2025-06-18 10:30:00', 4, 4, 5),
(10, 12, '2025-06-25 14:00:00', '2025-06-25 17:00:00', 5, 4, 8),
(4, 9, '2025-07-01 09:30:00', '2025-07-01 12:00:00', 4, 4, 10),
(5, 1, '2025-07-04 13:00:00', '2025-07-04 15:30:00', 6, 6, 11),
(8, 11, '2025-07-07 07:15:00', '2025-07-07 09:45:00', 3, 3, 13),
(12, 2, '2025-07-12 08:00:00', '2025-07-12 10:30:00', 4, 4, 17),
(1, 7, '2025-07-15 14:00:00', '2025-07-15 16:30:00', 5, 5, 19),
(7, 1, '2025-07-28 12:00:00', '2025-07-28 14:00:00', 3, 3, 6);

INSERT INTO `reservations` (`trajet_id`, `employe_id`, `places`, `created_at`)
VALUES (1, 29, 1, '2025-05-27 14:39:24');
