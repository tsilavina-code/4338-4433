<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Situation Comptes</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
</head>
<body>
<?= $this->include('includes/navbar_admin') ?>

<div class="container">
    <div class="card">
        <div class="card-header">Situation des Comptes Clients</div>
        <div class="card-body" style="padding: 0;">
            <table class="table">
                <thead>
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
                        <td><strong class="badge badge-secondary"><?= esc($c['phone']) ?></strong></td>
                        <td style="color: var(--success); font-weight: 600;"><?= number_format($c['balance'], 2, ',', ' ') ?> Ar</td>
                        <td><?= $c['created_at'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($clients)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">Aucun client enregistré.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->include('includes/footer') ?>