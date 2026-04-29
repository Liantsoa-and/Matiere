CREATE DATABASE IF NOT EXISTS matiere;
USE matiere;

CREATE TABLE IF NOT EXISTS etudiant(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    annee ENUM('L2')
);

CREATE TABLE option_etude (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_option VARCHAR(120) NOT NULL UNIQUE
);

CREATE TABLE semestre (
    id INT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE matiere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(30) NOT NULL UNIQUE,
    nom VARCHAR(150) NOT NULL,
    credit DECIMAL(5,2) DEFAULT 0,
    coefficient DECIMAL(5,2) DEFAULT 1
);
CREATE TABLE ue_groupe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_groupe VARCHAR(150) NOT NULL,
    option_id INT NOT NULL,
    semestre_id INT NOT NULL,
    nb_a_choisir INT NOT NULL DEFAULT 1,

    FOREIGN KEY (option_id)
        REFERENCES option_etude(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    FOREIGN KEY (semestre_id)
        REFERENCES semestre(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE programme_matiere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    option_id INT NOT NULL,
    semestre_id INT NOT NULL,
    matiere_id INT NOT NULL,
    groupe_id INT NULL,

    FOREIGN KEY (option_id)
        REFERENCES option_etude(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    FOREIGN KEY (semestre_id)
        REFERENCES semestre(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    FOREIGN KEY (matiere_id)
        REFERENCES matiere(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    FOREIGN KEY (groupe_id)
        REFERENCES ue_groupe(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL,

    UNIQUE KEY uq_programme (
        option_id,
        semestre_id,
        matiere_id
    )
);

CREATE TABLE IF NOT EXISTS note(
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT NOT NULL,
    matiere_id INT NOT NULL,
    note FLOAT,
    date_saisie DATE,
    
    FOREIGN KEY (etudiant_id)
        REFERENCES etudiant(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
        
    FOREIGN KEY (matiere_id)
        REFERENCES matiere(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insertion d'un utilisateur par défaut (mot de passe: password)
INSERT INTO users (email, password) VALUES 
('admindefault@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

ALTER TABLE etudiant ADD COLUMN num_etudiant VARCHAR(10) NOT NULL;

-- Insertion d'étudiants de test (5)
INSERT INTO etudiant (num_etudiant, nom, prenom, annee) VALUES 
('ETU001', 'RAKOTO', 'Jean', 'L2'),
('ETU002', 'RASOLO', 'Marie', 'L2'),
('ETU003', 'RABE', 'Faly', 'L2'),
('ETU004', 'ANDRIANINA', 'Ioly', 'L2'),
('ETU005', 'ANDRIAMASY', 'Mioty', 'L2');


-- ======================================
-- OPTIONS
-- ======================================

INSERT INTO option_etude (id, nom_option) VALUES
(1, 'Tronc Commun'),
(2, 'Développement'),
(3, 'Bases de Données et Réseaux'),
(4, 'Web et Design');

-- ======================================
-- SEMESTRES
-- ======================================

INSERT INTO semestre (id, nom) VALUES
(3, 'Semestre 3'),
(4, 'Semestre 4');

-- ======================================
-- MATIERES
-- ======================================

INSERT INTO matiere (id, code, nom, credit) VALUES

-- S3
(1,'INF201','Programmation orientée objet',6),
(2,'INF202','Bases de données objets',6),
(3,'INF203','Programmation système',4),
(4,'INF208','Réseaux informatiques',6),
(5,'MTH201','Méthodes numériques',4),
(6,'ORG201','Bases de gestion',4),

-- Choix commun S4
(7,'INF204','Système d''information géographique',6),
(8,'INF205','Système d''information',6),
(9,'INF206','Interface Homme/Machine',6),
(10,'INF207','Éléments d''algorithmique',6),

-- Développement
(11,'INF210','Mini-projet de développement',10),

-- BDR
(12,'INF211','Mini-projet de bases de données et/ou de réseaux',10),

-- Web
(13,'INF209','Web dynamique',6),
(14,'INF212','Mini-projet de Web et design',10),

-- Maths choix
(15,'MTH202','Analyse des données',4),
(16,'MTH203','MAO',4),
(17,'MTH204','Géométrie',4),
(18,'MTH205','Équations différentielles',4),
(19,'MTH206','Optimisation',4);

-- ======================================
-- GROUPES UE
-- ======================================

INSERT INTO ue_groupe (id, nom_groupe, option_id, semestre_id, nb_a_choisir) VALUES

-- Développement
(1,'Choix Informatique S4 DEV',2,4,1),
(2,'Choix Maths S4 DEV',2,4,1),

-- BDR
(3,'Choix Informatique S4 BDR',3,4,1),
(4,'Choix Maths S4 BDR',3,4,1),

-- Web
(5,'Choix Informatique S4 WEB',4,4,1),
(6,'Choix Maths S4 WEB',4,4,1);

-- ======================================
-- PROGRAMME MATIERES
-- groupe_id NULL = matière obligatoire
-- ======================================

INSERT INTO programme_matiere (option_id, semestre_id, matiere_id, groupe_id) VALUES

-- ======================================
-- SEMESTRE 3 (Tronc commun)
-- ======================================
(1,3,1,NULL),
(1,3,2,NULL),
(1,3,3,NULL),
(1,3,4,NULL),
(1,3,5,NULL),
(1,3,6,NULL),

-- ======================================
-- DEVELOPPEMENT S4
-- ======================================

-- Groupe choix informatique
(2,4,7,1),
(2,4,8,1),
(2,4,9,1),

-- Obligatoires
(2,4,10,NULL),
(2,4,11,NULL),

-- Groupe choix maths
(2,4,17,2),
(2,4,18,2),
(2,4,19,2),

-- Obligatoire
(2,4,16,NULL),

-- ======================================
-- BDR S4
-- ======================================

-- Obligatoire
(3,4,8,NULL),

-- Groupe choix info
(3,4,7,3),
(3,4,9,3),
(3,4,10,3),

-- Obligatoire
(3,4,12,NULL),

-- Groupe maths
(3,4,15,4),
(3,4,18,4),
(3,4,19,4),

-- Obligatoire
(3,4,16,NULL),

-- ======================================
-- WEB ET DESIGN S4
-- ======================================

-- Groupe info
(4,4,7,5),
(4,4,8,5),
(4,4,9,5),

-- Obligatoires
(4,4,13,NULL),
(4,4,14,NULL),

-- Groupe maths
(4,4,15,6),
(4,4,17,6),
(4,4,19,6),

-- Obligatoire
(4,4,16,NULL);