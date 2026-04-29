<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.page-header > div:first-child {
    flex: 1;
}

.page-header h2 {
    font-size: 28px;
    margin: 0 0 5px 0;
    color: var(--c-text);
}

.breadcrumb {
    font-size: 13px;
    color: var(--c-muted);
}

.card-header {
    background: var(--c-surface);
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,.08);
    border-left: 4px solid var(--c-primary);
}

.student-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 12px;
    color: var(--c-muted);
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.info-value {
    font-size: 16px;
    font-weight: 600;
    color: var(--c-text);
}

.options-selector {
    background: var(--c-surface);
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,.08);
}

.options-selector label {
    display: inline-block;
    margin-right: 15px;
    font-weight: 600;
    color: var(--c-text);
}

.options-selector select {
    padding: 10px 15px;
    border: 1.5px solid var(--c-border);
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    min-width: 250px;
    background: var(--c-surface);
    color: var(--c-text);
    font-family: inherit;
}

.options-selector select:hover {
    border-color: var(--c-primary);
}

.tabs-container {
    display: flex;
    gap: 0;
    margin-bottom: 0;
    border-bottom: 2px solid var(--c-border);
    background: var(--c-surface);
    border-radius: 8px 8px 0 0;
}

.tab-btn {
    padding: 15px 25px;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    color: var(--c-muted);
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: all .2s;
}

.tab-btn:hover {
    color: var(--c-text);
    background: rgba(0,0,0,.02);
}

.tab-btn.active {
    color: var(--c-primary);
    border-bottom-color: var(--c-primary);
}

.tab-content {
    display: none;
    background: var(--c-surface);
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,.08);
    border-radius: 0 8px 8px 8px;
    border-top: 1px solid var(--c-border);
}

.tab-content.active {
    display: block;
}

.semester-section {
    margin-bottom: 30px;
}

.semester-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--c-border);
    color: var(--c-text);
}

.table-card {
    overflow-x: auto;
    border-radius: 8px;
}

.notes-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.notes-table thead {
    background: var(--c-bg);
    border-bottom: 2px solid var(--c-border);
}

.notes-table th {
    padding: 12px;
    text-align: left;
    font-weight: 600;
    font-size: 13px;
    color: var(--c-text);
}

.notes-table td {
    padding: 12px;
    border-bottom: 1px solid var(--c-border);
    font-size: 14px;
}

.notes-table tbody tr:hover {
    background: #fafbfc;
}

.note-value {
    font-weight: 700;
    color: var(--c-success);
    font-size: 15px;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: var(--c-muted);
    background: #fafbfc;
    border-radius: 8px;
}

.average-card {
    background: linear-gradient(135deg, var(--c-primary), var(--c-accent));
    color: white;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(37,99,235,.25);
}

.average-card h3 {
    font-size: 14px;
    opacity: .9;
    margin-bottom: 10px;
    font-weight: 600;
}

.average-card .value {
    font-size: 32px;
    font-weight: 700;
}
</style>

<!-- En-tête page -->
<div class="page-header">
    <div>
        <h2><?= esc($etudiant->prenom . ' ' . $etudiant->nom) ?></h2>
        <div class="breadcrumb">Étudiants / <span><?= esc($etudiant->num_etudiant) ?></span></div>
    </div>
</div>

<!-- Informations étudiant -->
<div class="card-header">
    <div class="student-info">
        <div class="info-item">
            <span class="info-label">Numéro étudiant</span>
            <span class="info-value"><?= esc($etudiant->num_etudiant) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Année</span>
            <span class="info-value">L2</span>
        </div>
        <div class="info-item">
            <span class="info-label">Nom complet</span>
            <span class="info-value"><?= esc($etudiant->prenom . ' ' . $etudiant->nom) ?></span>
        </div>
    </div>
</div>

<!-- Sélecteur d'option -->
<div class="options-selector">
    <form method="GET" style="display: flex; align-items: center;">
        <label for="option">Sélectionner une option :</label>
        <select name="option" id="option" onchange="this.form.submit()">
            <?php foreach ($options as $id => $name): ?>
                <option value="<?= $id ?>" <?= $selectedOption == $id ? 'selected' : '' ?>>
                    <?= esc($name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<!-- Onglets -->
<div class="tabs-container">
    <button class="tab-btn active" onclick="switchTab(0)">📚 S3 - Semestre 3</button>
    <button class="tab-btn" onclick="switchTab(1)">📚 S4 - Semestre 4</button>
    <button class="tab-btn" onclick="switchTab(2)">📊 L2 - Vue complète</button>
</div>

<!-- TAB 1: S3 -->
<div class="tab-content active">
    <div class="semester-section">
        <div class="semester-title">Semestre 3 - Tronc commun (obligatoire pour tous)</div>

        <?php if (!empty($notes['s3'])): ?>
            <div class="table-card">
                <table class="notes-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Code</th>
                            <th style="flex: 1;">Matière</th>
                            <th style="width: 70px; text-align: center;">Crédit</th>
                            <th style="width: 80px; text-align: right;">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notes['s3'] as $note): ?>
                            <tr>
                                <td><?= esc($note->code) ?></td>
                                <td><?= esc($note->nom) ?></td>
                                <td style="text-align: center;"><?= number_format($note->credit ?? 0, 1) ?></td>
                                <td style="text-align: right;" class="note-value"><?= number_format($note->note, 2) ?>/20</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="average-card">
                <h3>Moyenne S3</h3>
                <div class="value"><?= number_format($moyenneS3, 2) ?></div>
            </div>
        <?php else: ?>
            <div class="no-data">Aucune note disponible pour S3</div>
        <?php endif; ?>
    </div>
</div>

<!-- TAB 2: S4 -->
<div class="tab-content">
    <div class="semester-section">
        <div class="semester-title">Semestre 4 - <?= esc($options[$selectedOption]) ?></div>

        <?php if (!empty($notes['s4'])): ?>
            <div class="table-card">
                <table class="notes-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Code</th>
                            <th style="flex: 1;">Matière</th>
                            <th style="width: 70px; text-align: center;">Crédit</th>
                            <th style="width: 80px; text-align: right;">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notes['s4'] as $note): ?>
                            <tr>
                                <td><?= esc($note->code) ?></td>
                                <td><?= esc($note->nom) ?></td>
                                <td style="text-align: center;"><?= number_format($note->credit ?? 0, 1) ?></td>
                                <td style="text-align: right;" class="note-value"><?= number_format($note->note, 2) ?>/20</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="average-card">
                <h3>Moyenne S4</h3>
                <div class="value"><?= number_format($moyenneS4, 2) ?></div>
            </div>
        <?php else: ?>
            <div class="no-data">Aucune note disponible pour S4</div>
        <?php endif; ?>
    </div>
</div>

<!-- TAB 3: L2 (Vue complète) -->
<div class="tab-content">
    <div class="semester-section">
        <div class="semester-title">Semestre 3 - Tronc commun</div>

        <?php if (!empty($notes['s3'])): ?>
            <div class="table-card">
                <table class="notes-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Code</th>
                            <th style="flex: 1;">Matière</th>
                            <th style="width: 70px; text-align: center;">Crédit</th>
                            <th style="width: 80px; text-align: right;">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notes['s3'] as $note): ?>
                            <tr>
                                <td><?= esc($note->code) ?></td>
                                <td><?= esc($note->nom) ?></td>
                                <td style="text-align: center;"><?= number_format($note->credit ?? 0, 1) ?></td>
                                <td style="text-align: right;" class="note-value"><?= number_format($note->note, 2) ?>/20</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="semester-section">
        <div class="semester-title">Semestre 4 - <?= esc($options[$selectedOption]) ?></div>

        <?php if (!empty($notes['s4'])): ?>
            <div class="table-card">
                <table class="notes-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Code</th>
                            <th style="flex: 1;">Matière</th>
                            <th style="width: 70px; text-align: center;">Crédit</th>
                            <th style="width: 80px; text-align: right;">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notes['s4'] as $note): ?>
                            <tr>
                                <td><?= esc($note->code) ?></td>
                                <td><?= esc($note->nom) ?></td>
                                <td style="text-align: center;"><?= number_format($note->credit ?? 0, 1) ?></td>
                                <td style="text-align: right;" class="note-value"><?= number_format($note->note, 2) ?>/20</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="average-card">
        <h3>Moyenne Générale L2 (S3 + S4)</h3>
        <div class="value"><?= number_format($moyenneL2, 2) ?></div>
    </div>
</div>

<script>
function switchTab(index) {
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(c => c.classList.remove('active'));

    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(b => b.classList.remove('active'));

    contents[index].classList.add('active');
    buttons[index].classList.add('active');
}
</script>

<?= $this->endSection() ?>
