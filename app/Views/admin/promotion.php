<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Commissions</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
</head>
<body>
<?= $this->include('includes/navbar_admin') ?>

<div class="container">
    <div class="row">
        <!-- Colonne gauche : Formulaire -->
        <div>
            <div class="card">
                <div class="card-header">Ajouter/Modifier une Commission</div>
                <div class="card-body">
                    <form action="<?= base_url('admin/promotion/ajouter') ?>" method="post">
                        <div class="form-group">
                            <label class="form-label">Opérateur</label>
                            <select name="operator" class="form-control" required>
                                <option value="">Sélectionner un opérateur</option>
                                    <option value="<?= esc($op['operator']) ?>"><?= esc($op['operator']) ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pourcentage (%)</label>
                            <input type="number" name="percentage" class="form-control" placeholder="Ex: 2" required min="0" max="100" step="0.1">
                            <div class="form-hint">Commission appliquée sur les transferts vers cet opérateur</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Colonne droite : Tableau -->
        <div>
            <div class="card">
                <div class="card-header">Commissions Configurées</div>
                <div class="card-body" style="padding: 0;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Opérateur</th>
                                <th>Pourcentage</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($Promotion_Commission as $pc): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><span class="badge badge-secondary"><?= esc($pc['operator']) ?></span></td>
                                <td><?= esc($c['percentage']) ?> %</td>
                                <td>
                                    <a href="<?= base_url('admin/commissions/supprimer/'.$c['id']) ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($Promotion_Commission)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">
                                    Aucune commission configurée.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?= $this->include('includes/footer') ?>
