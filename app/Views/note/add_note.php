<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h2>Ajouter une note</h2>
        <div class="breadcrumb">Accueil / Notes / <span>Nouvelle</span></div>
    </div>
    <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary btn-sm">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Retour
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<form method="POST" action="<?= site_url('note/store') ?>" class="form-card section-gap">
    <?= csrf_field() ?>

    <div class="form-section-title">Informations de la note</div>

    <div class="form-grid cols-2">
        <div>
            <label class="field-label">Étudiant <span class="required">*</span></label>
            <select name="etudiant_id" required class="<?= isset($errors['etudiant_id']) ? 'input-error' : '' ?>">
                <option value="">— Sélectionner un étudiant —</option>
                <?php foreach ($etudiants as $etudiant): ?>
                    <option value="<?= $etudiant->id ?>" <?= old('etudiant_id') == $etudiant->id ? 'selected' : '' ?>>
                        <?= $etudiant->prenom ?> <?= $etudiant->nom ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['etudiant_id'])): ?>
                <div class="field-hint" style="color: var(--c-danger);"><?= $errors['etudiant_id'] ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label class="field-label">Matière <span class="required">*</span></label>
            <select name="matiere_id" required class="<?= isset($errors['matiere_id']) ? 'input-error' : '' ?>">
                <option value="">— Sélectionner une matière —</option>
                <?php foreach ($matieres as $matiere): ?>
                    <option value="<?= $matiere->id ?>" <?= old('matiere_id') == $matiere->id ? 'selected' : '' ?>>
                        <?= $matiere->code ?> - <?= $matiere->nom ?> (S<?= $matiere->semestre ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['matiere_id'])): ?>
                <div class="field-hint" style="color: var(--c-danger);"><?= $errors['matiere_id'] ?></div>
            <?php endif; ?>
        </div>

        <div>
            <label class="field-label">Note (0-20) <span class="required">*</span></label>
            <input type="number" name="note" required min="0" max="20" step="0.5" 
                   value="<?= old('note') ?>" placeholder="Ex: 15.5"
                   class="<?= isset($errors['note']) ? 'input-error' : '' ?>" />
            <?php if (isset($errors['note'])): ?>
                <div class="field-hint" style="color: var(--c-danger);"><?= $errors['note'] ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <svg viewBox="0 0 24 24" width="14" height="14"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5"/><path d="M12 13v8m-4-4h8"/></svg>
            Enregistrer
        </button>
        <a href="<?= site_url('dashboard') ?>" class="btn btn-outline">Annuler</a>
    </div>
</form>

<?= $this->endSection() ?>
