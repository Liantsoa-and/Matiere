<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Gestion des notes</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="container">
        <!-- Header avec navigation -->
        <header class="header">
            <h1><?= $title ?></h1>
            <nav>
                <a href="/dashboard" class="nav-link">Dashboard</a>
                <a href="/etudiant" class="nav-link active">Étudiants</a>
                <a href="/note/create" class="nav-link">Ajouter une note</a>
                <a href="/auth/logout" class="nav-link logout">Déconnexion</a>
            </nav>
        </header>

        <!-- Barre de recherche -->
        <div class="search-bar">
            <form method="GET" action="/etudiant">
                <input type="text" name="search" placeholder="Rechercher par nom ou prénom..."
                    value="<?= esc($keyword ?? '') ?>" class="search-input">
                <button type="submit" class="btn btn-secondary">Rechercher</button>
                <?php if ($keyword): ?>
                    <a href="/etudiant" class="btn-clear">Effacer</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Tableau des étudiants -->
        <div class="table-container">
            <?php if (empty($etudiants)): ?>
                <div class="alert alert-info">
                    Aucun étudiant trouvé.
                </div>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Année</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($etudiants as $etudiant): ?>
                            <tr>
                                <td><?= esc($etudiant->id) ?></td>
                                <td><?= esc($etudiant->nom) ?></td>
                                <td><?= esc($etudiant->prenom) ?></td>
                                <td><?= esc($etudiant->annee) ?></td>
                                <td class="actions">
                                    <a href="/etudiant/<?= $etudiant->id ?>" class="btn-detail">
                                        Voir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination simple -->
                <?php if ($total > $perPage): ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= ceil($total / $perPage); $i++): ?>
                            <a href="?page=<?= $i ?><?= $keyword ? '&search=' . urlencode($keyword) : '' ?>"
                                class="page-link <?= $i == $currentPage ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>