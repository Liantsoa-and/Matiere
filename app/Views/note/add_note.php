<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une note</title>
</head>

<body>
    <h1>Ajouter une note</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p><strong>✓ <?= session()->getFlashdata('success') ?></strong></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p><strong>✗ <?= session()->getFlashdata('error') ?></strong></p>
    <?php endif; ?>

    <?php if (isset($errors) && !empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="<?= site_url('note/store') ?>">
        <?= csrf_field() ?>

        <div>
            <label for="etudiant_id">Étudiant *</label>
            <select id="etudiant_id" name="etudiant_id" required>
                <option value="">-- Sélectionner un étudiant --</option>
                <?php foreach ($etudiants as $etudiant): ?>
                    <option value="<?= $etudiant->id ?>" <?= old('etudiant_id') == $etudiant->id ? 'selected' : '' ?>>
                        <?= $etudiant->prenom ?>     <?= $etudiant->nom ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="matiere_id">Matière *</label>
            <select id="matiere_id" name="matiere_id" required>
                <option value="">-- Sélectionner une matière --</option>
                <?php foreach ($matieres as $matiere): ?>
                    <option value="<?= $matiere->id ?>" <?= old('matiere_id') == $matiere->id ? 'selected' : '' ?>>
                        <?= $matiere->code ?> - <?= $matiere->nom ?> (<?= $matiere->semestre ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="note">Note (0-20) *</label>
            <input type="number" id="note" name="note" required min="0" max="20" step="0.5" value="<?= old('note') ?>"
                placeholder="Ex: 15.5">
        </div>

        <button type="submit">Ajouter la note</button>
        <a href="<?= site_url('dashboard') ?>">Retour</a>
    </form>

    <footer>
        <p>&copy; 2026 - Gestion des Notes ITU</p>
    </footer>
</body>

</html>