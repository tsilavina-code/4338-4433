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
                           placeholder="ex: 0331234567" required maxlength="10">
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>

                <!-- À ajouter en bas du formulaire de login client -->
                <div class="text-center mt-4">
                    <a href="<?= base_url('admin/prefixes') ?>" class="btn btn-outline-secondary btn-sm">
                        Accéder à l'espace Opérateur (Admin)
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>