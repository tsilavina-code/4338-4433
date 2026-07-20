<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Préfixes</title>
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
            <a class="nav-link text-warning" href="<?= base_url('/') ?>">Login Client</a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5>Ajouter un Préfixe</h5>
                <form action="<?= base_url('admin/prefixes/ajouter') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label">Préfixe</label>
                        <input type="text" name="prefix" class="form-control" placeholder="Ex: 033" required maxlength="3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Opérateur</label>
                        <input type="text" name="operator" class="form-control" placeholder="Ex: Airtel" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <h5>Préfixes Valides</h5>
                <table class="table table-striped">
                    <thead><tr><th>ID</th><th>Préfixe</th><th>Opérateur</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php foreach($prefixes as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><span class="badge bg-secondary fs-6"><?= esc($p['prefix']) ?></span></td>
                            <td><?= esc($p['operator']) ?></td>
                            <td><a href="<?= base_url('admin/prefixes/supprimer/'.$p['id']) ?>" class="btn btn-danger btn-sm">Supprimer</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>