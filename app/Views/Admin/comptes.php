<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Situation Comptes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Opérateur Panel</a>
        <div class="navbar-nav">
            <a class="nav-link" href="<?= base_url('admin/prefixes') ?>">Préfixes</a>
            <a class="nav-link" href="<?= base_url('admin/fees') ?>">Barèmes Frais</a>
            <a class="nav-link active" href="<?= base_url('admin/comptes') ?>">Situation Comptes</a>
            <a class="nav-link" href="<?= base_url('admin/gains') ?>">Situation Gains</a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="card p-4 shadow-sm">
        <h5 class="mb-4">Situation des Comptes Clients</h5>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Numéro de Téléphone</th>
                    <th>Solde Actuel</th>
                    <th>Date de Création</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clients as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><strong class="text-secondary"><?= esc($c['phone']) ?></strong></td>
                    <td class="fw-bold text-success"><?= number_format($c['balance'], 2, ',', ' ') ?> Ar</td>
                    <td><?= $c['created_at'] ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($clients)): ?>
                <tr><td colspan="4" class="text-muted text-center">Aucun client enregistré pour le moment.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>