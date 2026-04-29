Voici la **TODO list complète** pour implémenter le login dans CodeIgniter 4, conformément aux exigences du TP.


## TODO Login - CodeIgniter 4

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


A la enlever de gitignore les logs sy ny tariny