<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert - Mobile Money</title>
    <link rel="stylesheet" href="<?= base_url('css/client.css') ?>">
</head>
<body>
    <div class="auth-container">
        <div class="card auth-card">
            <h2 class="auth-title">📤 Faire un transfert</h2>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            
            <form action="<?= base_url('client/transfert') ?>" method="post">
                <div class="mb-3">
                    <label class="form-label">Numéro destinataire</label>
                    <input type="text" name="recipient" class="form-control" 
                           placeholder="ex: 0337654321" required maxlength="10">
                </div>
                <div class="mb-3">
                    <label class="form-label">Montant (Ar)</label>
                    <input type="number" name="amount" class="form-control" min="100" required>
                    <div class="form-hint">Des frais seront appliqués selon le barème</div>
                </div>
                <button type="submit" class="btn btn-info">Valider le transfert</button>
                <a href="<?= base_url('client/dashboard') ?>" class="btn btn-secondary" style="margin-top:0.75rem;">Annuler</a>
            </form>
        </div>
    </div>
</body>
</html>