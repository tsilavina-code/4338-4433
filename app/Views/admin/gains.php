<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Situation Gains</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
</head>
<body>
<nav class="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Opérateur Panel</a>
        <div class="navbar-nav">
            <a class="nav-link" href="<?= base_url('admin/prefixes') ?>">Préfixes</a>
            <a class="nav-link" href="<?= base_url('admin/fees') ?>">Barèmes Frais</a>
            <a class="nav-link" href="<?= base_url('admin/comptes') ?>">Situation Comptes</a>
            <a class="nav-link active" href="<?= base_url('admin/gains') ?>">Situation Gains</a>
            <a class="nav-link text-warning" href="<?= base_url('/') ?>">Login Client</a>
        </div>
    </div>
</nav>

<div class="container">
    <!-- Stats card -->
    <div class="stats-card">
        <h1>Gains Totaux de l'Opérateur</h1>
        <h2><?= number_format($total_gains, 2, ',', ' ') ?> Ar</h2>
    </div>

    <!-- Tableau détail -->
    <div class="card">
        <div class="card-header">Répartition des gains par type d'opération</div>
        <div class="card-body" style="padding: 0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Type d'Opération</th>
                        <th>Gains Générés</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($gains_details as $detail): ?>
                    <tr>
                        <td><span class="badge badge-secondary"><?= esc($detail['type']) ?></span></td>
                        <td style="color: var(--success); font-weight: 600;"><?= number_format($detail['total'], 2, ',', ' ') ?> Ar</td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($gains_details)): ?>
                    <tr>
                        <td colspan="2" style="text-align: center; color: var(--text-muted); padding: 2rem;">Aucun frais collecté.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>