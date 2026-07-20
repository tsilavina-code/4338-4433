<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Money - Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('css/client.css') ?>">
</head>
<body>
    <nav class="navbar">
        <div class="container" style="display:flex; justify-content:space-between; align-items:center;">
            <span class="navbar-brand">Mobile Money</span>
            <a href="<?= base_url('client/logout') ?>" class="btn-logout">Déconnexion</a>
        </div>
    </nav>
    
    <div class="container" style="max-width:500px; margin:0 auto; padding:1.5rem;">
        
        <!-- Solde -->
        <div class="solde-card">
            <div class="solde-label">Votre solde</div>
            <div class="solde-montant"><?= number_format($balance, 0, ',', ' ') ?> Ar</div>
            <div class="solde-phone"><?= $phone ?></div>
        </div>
        
        <!-- Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" style="margin-bottom:1rem;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <!-- Menu -->
        <div class="menu-grid">
            <a href="<?= base_url('client/depot') ?>" class="menu-btn btn-depot">
                <span class="icon">💰</span>
                <span>Dépôt</span>
            </a>
            <a href="<?= base_url('client/retrait') ?>" class="menu-btn btn-retrait">
                <span class="icon">💸</span>
                <span>Retrait</span>
            </a>
            <a href="<?= base_url('client/transfert') ?>" class="menu-btn btn-transfert">
                <span class="icon">📤</span>
                <span>Transfert</span>
            </a>
            <a href="<?= base_url('client/historique') ?>" class="menu-btn btn-historique">
                <span class="icon">📋</span>
                <span>Historique</span>
            </a>
        </div>
    </div>
</body>
</html>