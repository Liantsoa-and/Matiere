<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h2>Liste des étudiants</h2>
        <div class="breadcrumb">Accueil / <span>Étudiants</span></div>
    </div>
</div>

<!-- Toolbar filtres -->
<div class="toolbar">
    <div class="toolbar-left">
        <form method="GET" action="<?= site_url('etudiant') ?>" style="display:flex;gap:10px;width:100%">
            <div class="search-box" style="flex:1">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" placeholder="Rechercher un étudiant…" value="<?= esc($keyword ?? '') ?>" />
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Rechercher
            </button>
            <?php if ($keyword): ?>
                <a href="<?= site_url('etudiant') ?>" class="btn btn-ghost btn-sm">
                    <svg viewBox="0 0 24 24" width="14" height="14"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Effacer
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Tableau -->
<div class="table-card">
    <?php if (empty($etudiants)): ?>
        <div class="alert alert-info" style="margin:20px">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>Aucun étudiant trouvé.</span>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th class="sortable">Nom et prénom</th>
                    <th class="sortable">ID</th>
                    <th class="sortable">Année</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <div class="avatar-sm"><?= substr($etudiant->nom, 0, 2) ?></div>
                                <div>
                                    <div style="font-weight:600"><?= esc($etudiant->prenom . ' ' . $etudiant->nom) ?></div>
                                    <div style="font-size:11px;color:var(--c-muted)">ID: <?= esc($etudiant->id) ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--c-muted);font-family:monospace"><?= esc($etudiant->id) ?></td>
                        <td><?= esc($etudiant->annee) ?></td>
                        <td>
                            <div class="td-actions">
                                <a href="<?= site_url('etudiant/' . $etudiant->id) ?>" class="action-btn" title="Voir détails">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
