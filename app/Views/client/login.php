<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Money - Connexion</title>
    <link rel="stylesheet" href="<?= base_url('css/client.css') ?>">
</head>
<body>
    <div class="auth-container">
        <div class="card auth-card">
            <h1 class="auth-title">Mobile Money</h1>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <form action="<?= base_url('client/login') ?>" method="post">
                <div class="mb-3">
                    <label class="form-label">Numéro de téléphone</label>
                    <input type="text" name="phone" class="form-control" 
                           placeholder="ex: 0341234567" required maxlength="10">
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
            
            <div class="form-hint" style="text-align: center; margin-top: 1rem;">
                Seuls les numéros Yas (034, 038) peuvent se connecter
            </div>
            
            <div style="text-align: center; margin-top: 1.5rem;">
                <a href="<?= base_url('admin/prefixes') ?>" class="btn btn-secondary" style="width: auto; padding: 0.5rem 1rem; font-size: 0.875rem;">
                    Espace Opérateur
                </a>
            </div>
        </div>
    </div>
</body>
</html>