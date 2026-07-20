<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Barèmes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Opérateur Panel</a>
        <div class="navbar-nav">
            <a class="nav-link" href="<?= base_url('admin/prefixes') ?>">Préfixes</a>
            <a class="nav-link active" href="<?= base_url('admin/fees') ?>">Barèmes Frais</a>
            <a class="nav-link" href="<?= base_url('admin/comptes') ?>">Situation Comptes</a>
            <a class="nav-link" href="<?= base_url('admin/gains') ?>">Situation Gains</a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="card p-4 shadow-sm">
        <h5 class="mb-4">Gestion des Barèmes de Frais</h5>
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Type Opération</th>
                    <th>Montant Min (Ar)</th>
                    <th>Montant Max (Ar)</th>
                    <th>Frais (Ar)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($fees as $f): ?>
                <form action="<?= base_url('admin/fees/modifier') ?>" method="post">
                    <input type="hidden" name="id" value="<?= $f['id'] ?>">
                    <tr>
                        <td><span class="text-uppercase fw-bold text-primary"><?= esc($f['op_name']) ?></span></td>
                        <td><input type="number" step="0.01" name="min_amount" class="form-control form-control-sm" value="<?= $f['min_amount'] ?>"></td>
                        <td><input type="number" step="0.01" name="max_amount" class="form-control form-control-sm" value="<?= $f['max_amount'] ?>"></td>
                        <td><input type="number" step="0.01" name="fee_amount" class="form-control form-control-sm" value="<?= $f['fee_amount'] ?>"></td>
                        <td><button type="submit" class="btn btn-success btn-sm w-100">Mettre à jour</button></td>
                    </tr>
                </form>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>