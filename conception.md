Voici mon analyse du TP et une proposition de conception basée sur les 3 fichiers fournis.

## Compréhension globale du TP

Tu dois créer une application **CodeIgniter 4** qui gère les notes d’étudiants selon des règles spécifiques, avec un design personnalisé en SCSS.

### Ce que l’utilisateur doit pouvoir faire (fonctionnalités)

1. **Login** – formulaire avec valeurs par défaut déjà pré-remplies
2. **Ajouter une note** – on peut saisir plusieurs fois une note pour un étudiant/matière
3. **Liste des étudiants**
4. **Détail d’un étudiant** avec affichage des notes par :
   - S3
   - S4 option dev
   - S4 option bddres
   - S4 option web
   - L2 option dev
   - L2 option bddres
   - L2 option web

5. **Lien S3/S4** → affiche les notes par semestre
6. **Lien L2** → affiche les notes des 2 semestres (S3+S4) + une moyenne

---

## Règles de gestion métier à coder

| Règle | Explication |
|-------|-------------|
| Pour une matière, on prend la **note maximale** | Si un étudiant a plusieurs notes dans la même matière, on garde la meilleure |
| Pour les matières optionnelles, on prend la **matière qui a la meilleure note** | À l’intérieur d’un groupe d’option, une seule matière compte : celle avec la meilleure note |

---

## Structure des données (conception base de données)

D’après le fichier `Matiere.pdf`, les matières sont organisées par :
- **Semestre** (S3 ou S4)
- **Parcours** (Développement, BDD/Réseaux, Web/Design)
- **Type** (obligatoire / optionnel)

### Tables proposées

```sql
-- 1. Etudiants
id_etudiant INT PK
nom VARCHAR
prenom VARCHAR
annee ENUM('L2')  -- car S3+S4 = L2

-- 2. Matieres
id_matiere INT PK
code_matiere VARCHAR (ex: INF201)
nom_matiere VARCHAR
semestre ENUM('S3','S4')
parcours_visé ENUM('dev','bddres','web','tous')
est_optionnel BOOLEAN
groupe_option VARCHAR -- pour lier les matières optionnelles d’un même bloc

-- 3. Notes
id_note INT PK
id_etudiant INT FK
id_matiere INT FK
note DECIMAL(4,2) -- /20
date_saisie DATETIME
```

### Exemple de matières (d’après Matiere.pdf)

**S3 – tous parcours**
- INF201 (POO) – obligatoire
- INF202 (BD objets) – obligatoire
- INF203 (Prog système) – obligatoire
- INF208 (Réseaux) – obligatoire
- MTH201 (Méthodes numériques) – obligatoire
- ORG201 (Gestion) – obligatoire

**S4 – Parcours Développement**
- Option groupe 1 : INF204 / INF205 / INF206 (choix meilleure note)
- INF207 – obligatoire 
- INF210 – mini-projet (obligatoire pour ce parcours)
- Option maths : MTH204 / MTH205 / MTH206 (meilleure note)
- MTH203 – MAO (obligatoire)

---

## Conception des écrans

### 1. Login (page par défaut)
```
Email / Mot de passe
[✅ Se souvenir de moi]
[Connexion]
```
Les champs sont pré-remplis (ex: `admin@example.com` / `password`)

### 2. Dashboard après login
```
[Ajouter une note]  [Liste étudiants]
```

### 3. Ajouter une note
Formulaire avec :
- Étudiant (select)
- Matière (select, filtrée selon parcours étudiant)
- Note (input number 0-20)
- [Ajouter] → permet d’ajouter plusieurs notes à la suite sans quitter la page

### 4. Liste des étudiants
Tableau avec : Nom, Prénom, Parcours, [Détail]

### 5. Détail étudiant + S3/S4 / L2

**Onglets ou liens :**
- S3
- S4 (et ses sous-options dev/bddres/web)
- L2 (regroupe S3+S4)

**Exemple d’affichage L2 :**
```
Matière              | Note (max)
INF201 (POO)         | 14
INF202 (BD objets)   | 12
...
Moyenne générale (S3+S4) : 12.3
```

---

## Règles à coder dans la logique métier

### Règle 1 : Note maximale par matière
Quand on affiche les notes d’un étudiant, on fait un `MAX(note) GROUP BY id_matiere`.

### Règle 2 : Option avec meilleure note
Soit un groupe d’options (ex: INF204, INF205, INF206) :
- On récupère la meilleure note parmi ces 3 matières
- On ne prend que celle-là dans le calcul de la moyenne et dans l’affichage

Exemple :
```
INF204 : 10
INF205 : 15  ← meilleure
INF206 : 8

→ On garde INF205 avec 15 pour le calcul
```

---

## Organisation du code CI4

```
app/
├── Controllers/
│   ├── Auth.php (login)
│   ├── NoteController.php (ajout note)
│   ├── EtudiantController.php (liste + détail)
├── Models/
│   ├── EtudiantModel.php
│   ├── MatiereModel.php
│   ├── NoteModel.php
├── Views/
│   ├── login.php
│   ├── ajout_note.php
│   ├── liste_etudiants.php
│   ├── detail_etudiant.php
├── Database/
│   ├── Migrations/ (création tables)
│   ├── Seeders/ (données de test)
├── Config/
│   ├── Routes.php (définition des routes)
```

---

## Résumé des points bloquants à clarifier (si possible)

| Point | Problème possible |
|-------|------------------|
| **L2** | Dans ton relevé, L2 n’existe pas (S3/S4 = L2). Donc L2 = afficher S3+S4 |
| **Parcours étudiant** | Le relevé PDF ne donne pas le parcours. Il faut l’ajouter dans la table `étudiant` |
| **Notes initiales** | On part de 0 ou on importe le relevé PDF ? Le TP dit “ajouter une note”, donc probablement on commence vide ou on importe les 60 crédits |

---
