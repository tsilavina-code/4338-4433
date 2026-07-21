<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Barèmes</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
</head>
<body>
<?= $this->include('includes/navbar_admin') ?>

<div class="container">
    <div class="card">
        <div class="card-header">Gestion des Barèmes de Frais</div>
        <div class="card-body" style="padding: 0;">
            <table class="table">
                <thead>
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
                            <td><span class="badge badge-secondary"><?= esc($f['op_name']) ?></span></td>
                            <td><input type="number" step="0.01" name="min_amount" class="form-control" value="<?= $f['min_amount'] ?>" style="width: 120px;"></td>
                            <td><input type="number" step="0.01" name="max_amount" class="form-control" value="<?= $f['max_amount'] ?>" style="width: 120px;"></td>
                            <td><input type="number" step="0.01" name="fee_amount" class="form-control" value="<?= $f['fee_amount'] ?>" style="width: 100px;"></td>
                            <td><button type="submit" class="btn btn-success btn-sm">Mettre à jour</button></td>
                        </tr>
                    </form>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->include('includes/footer') ?>