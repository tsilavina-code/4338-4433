<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Situation Gains</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Opérateur Panel</a>
        <div class="navbar-nav">
            <a class="nav-link" href="<?= base_url('admin/prefixes') ?>">Préfixes</a>
            <a class="nav-link" href="<?= base_url('admin/fees') ?>">Barèmes Frais</a>
            <a class="nav-link" href="<?= base_url('admin/comptes') ?>">Situation Comptes</a>
            <a class="nav-link active" href="<?= base_url('admin/gains') ?>">Situation Gains</a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-success text-white p-4 shadow-sm">
                <h1>Gains Totaux de l'Opérateur</h1>
                <h2 class="display-4 fw-bold"><?= number_format($total_gains, 2, ',', ' ') ?> Ar</h2>
            </div>
        </div>
    </div>

    <div class="card p-4 shadow-sm">
        <h5>Répartition des gains par type d'opération</h5>
        <table class="table mt-2">
            <thead><tr><th>Type d'Opération</th><th>Gains Générés</th></tr></thead>
            <tbody>
                <?php foreach($gains_details as $detail): ?>
                <tr>
                    <td class="text-uppercase fw-bold text-primary"><?= esc($detail['type']) ?></td>
                    <td class="text-success fw-bold"><?= number_format($detail['total'], 2, ',', ' ') ?> Ar</td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($gains_details)): ?>
                <tr><td colspan="2" class="text-muted text-center">Aucun frais collecté pour le moment.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>