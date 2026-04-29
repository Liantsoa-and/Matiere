<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h2>Tableau de bord</h2>
        <div class="breadcrumb">Accueil / <span>Tableau de bord</span></div>
    </div>
</div>

<!-- KPIs -->
<div class="kpi-grid">

    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">Étudiants inscrits</div>
            <div class="kpi-icon bg-blue">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="kpi-value"><?= $total_students ?? '0' ?></div>
        <div class="kpi-delta up">
            <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" fill="none"><polyline points="18 15 12 9 6 15"/></svg>
            Gestion active
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">Matières disponibles</div>
            <div class="kpi-icon bg-green">
                <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </div>
        </div>
        <div class="kpi-value">12</div>
        <div class="kpi-delta up">
            <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" fill="none"><polyline points="18 15 12 9 6 15"/></svg>
            Semestriel
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-label">Notes enregistrées</div>
            <div class="kpi-icon bg-amber">
                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
        </div>
        <div class="kpi-value">--</div>
        <div class="kpi-delta up">
            <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" fill="none"><polyline points="18 15 12 9 6 15"/></svg>
            À jour
        </div>
    </div>

</div>

<!-- Quick Actions -->
<div class="dash-grid">

    <div class="card">
        <div class="card-header">
            <div class="card-title">Actions rapides</div>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px;">
                <a href="<?= site_url('note/create') ?>" class="btn btn-primary btn-sm">
                    <svg viewBox="0 0 24 24" width="14" height="14"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Ajouter une note
                </a>
                <a href="<?= site_url('etudiant') ?>" class="btn btn-secondary btn-sm">
                    <svg viewBox="0 0 24 24" width="14" height="14"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Voir les étudiants
                </a>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
