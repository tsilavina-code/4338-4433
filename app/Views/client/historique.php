<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique - Mobile Money</title>
    <link rel="stylesheet" href="<?= base_url('css/client.css') ?>">
</head>
<body>
    <nav class="navbar">
        <div class="container" style="display:flex; justify-content:space-between; align-items:center;">
            <span class="navbar-brand">Mobile Money</span>
            <a href="<?= base_url('client/logout') ?>" class="btn-logout">Déconnexion</a>
        </div>
    </nav>
    
    <div class="container" style="max-width:900px; margin:0 auto; padding:1.5rem;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h2 style="color:var(--primary);">📋 Historique des transactions</h2>
            <a href="<?= base_url('client/dashboard') ?>" class="btn btn-secondary" style="width:auto; padding:0.5rem 1rem;">← Retour</a>
        </div>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Frais</th>
                        <th>Total</th>
                        <th>Destinataire</th>
                        <th>Solde après</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="7" style="text-align:center; color:var(--text-light); padding:2rem;">
                                Aucune transaction pour le moment
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                            <td>
                                <?php if ($t['type'] == 'DEPOT'): ?>
                                    <span class="badge badge-depot">Dépôt</span>
                                <?php elseif ($t['type'] == 'RETRAIT'): ?>
                                    <span class="badge badge-retrait">Retrait</span>
                                <?php else: ?>
                                    <span class="badge badge-transfert">Transfert</span>
                                <?php endif; ?>
                            </td>
                            <td><?= number_format($t['amount'], 0, ',', ' ') ?> Ar</td>
                            <td><?= number_format($t['fee'], 0, ',', ' ') ?> Ar</td>
                            <td style="font-weight:600;"><?= number_format($t['total'], 0, ',', ' ') ?> Ar</td>
                            <td><?= $t['recipient'] ?: '-' ?></td>
                            <td style="font-weight:500; color:var(--primary);">
                                <?= number_format($t['balance_after'], 0, ',', ' ') ?> Ar
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>