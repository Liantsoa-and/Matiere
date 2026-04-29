CREATE DATABASE IF NOT EXISTS matiere;
USE matiere;

CREATE TABLE IF NOT EXISTS etudiant(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    annee ENUM('L2')
);

CREATE TABLE IF NOT EXISTS matiere(
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    semestre ENUM('S3', 'S4'),
    coefficient INT NOT NULL,
    parcours ENUM('developpement', 'reseau', 'web', 'tous'),
    est_optionnelle BOOLEAN NOT NULL,
    groupe VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS note(
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT,
    matiere_id INT,
    note FLOAT,
    date_saisie DATE
);

