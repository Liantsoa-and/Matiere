<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Bienvenue, <?= session()->get('userEmail') ?></h1>
            <nav>
                <a href="/dashboard" class="nav-link active">Dashboard</a>
                <a href="/etudiant" class="nav-link">Étudiants</a>
                <a href="/auth/logout" class="nav-link logout">Déconnexion</a>
            </nav>
        </header>

        <div class="dashboard-cards">
            <div class="card">
                <h3>� Ajouter une note</h3>
                <p>Saisir une nouvelle note pour un étudiant</p>
                <a href="/note/create" class="btn-primary">Ajouter une note</a>
            </div>

            <div class="card">
                <h3>�👨‍🎓 Liste des étudiants</h3>
                <p>Consultez et gérez les étudiants</p>
                <a href="/etudiant" class="btn-primary">Voir les étudiants</a>
            </div>
        </div>
    </div>
</body>

</html>