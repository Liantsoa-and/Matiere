INSERT INTO matiere (code, nom, semestre, coefficient, parcours, est_optionnelle, groupe) VALUES
('INF201', 'Programmation orientée objet', 'S3', 6, 'tous', 0, NULL),
('INF202', 'Bases de données objets', 'S3', 6, 'tous', 0, NULL),
('INF203', 'Programmation système', 'S3', 4, 'tous', 0, NULL),
('INF208', 'Réseaux informatiques', 'S3', 6, 'tous', 0, NULL),
('MTH201', 'Méthodes numériques', 'S3', 4, 'tous', 0, NULL),
('ORG201', 'Bases de gestion', 'S3', 4, 'tous', 0, NULL),
('INF204', 'Développement avancé 1', 'S4', 6, 'developpement', 1, 'INF20X'),
('INF205', 'Développement avancé 2', 'S4', 6, 'developpement', 1, 'INF20X'),
('INF206', 'Développement avancé 3', 'S4', 6, 'developpement', 1, 'INF20X'),
('INF207', 'Projet de développement', 'S4', 4, 'developpement', 0, NULL),
('INF210', 'Mini-projet', 'S4', 4, 'developpement', 0, NULL),
('MTH203', 'MAO', 'S4', 4, 'tous', 0, NULL),
('MTH204', 'Mathématiques avancées 1', 'S4', 6, 'developpement', 1, 'MTH20X'),
('MTH205', 'Mathématiques avancées 2', 'S4', 6, 'developpement', 1, 'MTH20X'),
('MTH206', 'Mathématiques avancées 3', 'S4', 6, 'developpement', 1, 'MTH20X');

INSERT INTO note (etudiant_id, matiere_id, note, date_saisie) VALUES
(1, 1, 12.50, '2026-04-29'),
(1, 1, 14.00, '2026-04-29'),
(1, 2, 11.00, '2026-04-29'),
(1, 3, 13.50, '2026-04-29'),
(1, 4, 10.00, '2026-04-29'),
(2, 1, 9.00, '2026-04-29'),
(2, 2, 15.50, '2026-04-29'),
(2, 5, 8.00, '2026-04-29'),
(3, 1, 16.00, '2026-04-29'),
(3, 6, 13.00, '2026-04-29');

