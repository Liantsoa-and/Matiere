ALTER TABLE etudiant ADD COLUMN num_etudiant VARCHAR(10) NOT NULL;

-- Insertion d'étudiants de test (5)
INSERT INTO etudiant (num_etudiant, nom, prenom, annee) VALUES 
('ETU001', 'RAKOTO', 'Jean', 'L2'),
('ETU002', 'RASOLO', 'Marie', 'L2'),
('ETU003', 'RABE', 'Faly', 'L2'),
('ETU004', 'ANDRIANINA', 'Ioly', 'L2'),
('ETU005', 'ANDRIAMASY', 'Mioty', 'L2');