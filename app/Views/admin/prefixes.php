<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Préfixes</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
</head>
<body>
<?= $this->include('includes/navbar_admin') ?>

<div class="container">
    <div class="row">
        <!-- Colonne gauche : Formulaire -->
        <div>
            <div class="card">
                <div class="card-header">Ajouter un Préfixe</div>
                <div class="card-body">
                    <form action="<?= base_url('admin/prefixes/ajouter') ?>" method="post">
                        <div class="form-group">
                            <label class="form-label">Préfixe</label>
                            <input type="text" name="prefix" class="form-control" placeholder="Ex: 033" required maxlength="3">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Opérateur</label>
                            <input type="text" name="operator" class="form-control" placeholder="Ex: Airtel" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Colonne droite : Tableau -->
        <div>
            <div class="card">
                <div class="card-header">Préfixes Valides</div>
                <div class="card-body" style="padding: 0;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Préfixe</th>
                                <th>Opérateur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($prefixes as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><span class="badge badge-secondary"><?= esc($p['prefix']) ?></span></td>
                                <td><?= esc($p['operator']) ?></td>
                                <td>
                                    <a href="<?= base_url('admin/prefixes/supprimer/'.$p['id']) ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('includes/footer') ?>