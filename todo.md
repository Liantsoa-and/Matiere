# TODO Login - CodeIgniter 4

## Login

### 1. Base de données [ok]

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insertion d'un utilisateur par défaut (mot de passe: password)
-- Le mot de passe sera haché avec password_hash()
INSERT INTO users (email, password) VALUES 
('admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
```


### 2. Configuration (`app/Config/`)
- Fichier `Routes.php` [ok]


### 3. Filtre d'authentification (`app/Filters/`) [ok]

- Fichier `AuthFilter.php`
- Enregistrer le filtre (`app/Config/Filters.php`)



### 4. Modèle (`app/Models/`)

- Fichier `UserModel.php`

### 5. Contrôleur (`app/Controllers/`)
- Fichier `AuthController.php`



### 6. Vues (`app/Views/auth/`)
- Fichier `login.php`



### 7. Contrôleur Dashboard (exemple protégé)

- Fichier `DashboardController.php`
- Vue `dashboard.php` (minimale)


## Liste etudiants

### 1. Base de données

```sql
CREATE TABLE IF NOT EXISTS etudiant(
    id INT AUTO_INCREMENT PRIMARY KEY,
    num_etudiant VARCHAR(255) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    annee ENUM('L2')
);

-- Insertion d'étudiants de test (d'après le relevé PDF)
INSERT INTO etudiant (num_etudiant, nom, prenom, annee) VALUES 
('ETU001', 'RAKOTO', 'Jean', 'L2'),
('ETU002', 'RASOLO', 'Marie', 'L2'),
('ETU003', 'RABE', 'Faly', 'L2'),
('ETU004', 'ANDRIANINA', 'Ioly', 'L2'),
('ETU005', 'ANDRIAMASY', 'Mioty', 'L2');
```

### 2. Modèle (`app/Models/`)
- Fichier `EtudiantModel.php`


### 3. Contrôleur (`app/Controllers/`)
- Fichier `EtudiantController.php`


### 4. Routes (`app/Config/Routes.php`)


### 5. Vues
- Fichier `app/Views/etudiants/liste.php`

### 6. Mettre à jour le Dashboard
- `app/Views/dashboard.php`

### 7. Améliorer le contrôleur Dashboard
- `app/Controllers/DashboardController.php`

## Ajouter note

### 1. Base de données [ok]

```sql
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
```

### 2. Modèles (`app/Models/`) [ok]
- Fichier `EtudiantModel.php` [ok]
- Fichier `MatiereModel.php` [ok]
- Fichier `NoteModel.php` [ok]

### 3. Contrôleur (`app/Controllers/`) [ok]
- Fichier `NoteController.php` [ok]
  - Méthode `create()` (affiche le formulaire)
  - Méthode `store()` (traite l'ajout)
  - Méthode `getMatieresByEtudiant()` (filtre AJAX)
  - Méthode `getByEtudiant()` (affiche les notes)

### 4. Routes (`app/Config/Routes.php`) [ok]
- GET `/note/create` → formulaire
- POST `/note/store` → validation et sauvegarde
- POST `/note/get-matieres-by-etudiant` → filtre AJAX
- GET `/note/etudiant/(:num)` → affiche notes étudiant

### 5. Vues [ok]
- Fichier `app/Views/note/add_note.php` [ok]
  - Formulaire d'ajout
  - Select étudiant
  - Select matière (dynamique)
  - Input note (0-20)
  - Messages de succès/erreur

### 6. Données de test [ok]
- Insertion d'étudiants [ok]
- Insertion de matières S3 et S4 [ok]
- Parcours associés (developpement, reseau, web) [ok]

### 7. Mettre à jour le Dashboard [ok]
- `app/Views/dashboard.php` [ok]
- Ajouter lien vers "Ajouter une note" [ok]