<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Eparg</title>
    <link rel="stylesheet" href="<?= base_url('css/client.css') ?>">
</head>
<body>
    <div class="auth-container">
        <div class="card auth-card">
            <h2 class="auth-title">Epargner de l'argent</h2>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            
            <form action="<?= base_url('client/epargne') ?>" method="post" id="epargneForm">
                
               
                <div class="form-group">
                    <label class="form-label"></label>
                    
                    <div id="recipientsList">
                        <!-- Premier destinataire -->
                        <div class="recipient-box">
                            <span class="recipient-num">1</span>
                            <select name="recipients[]" class="form-control recipient-select" required>
                                <option value="">Sélectionner un Pourcentage</option>
                                <?php foreach($epargne as $e): ?>
                                    <option value="<?= $c['phone'] ?>"><?= $c['phone'] ?></option>
                                <?php endforeach; ?>
                                <option value="other"></option>
                            </select>
                            <input type="text" class="form-control other-phone" 
                                   placeholder="Ex: 10%" style="display:none;">
                            <button type="button" class="btn-remove" onclick="removeRecipient(this)" style="display:none;">✕</button>
                        </div>
                    </div>
                    
                </div>
                
                <!-- ÉTAPE 2 : Combien d'argent ? -->
                <div class="form-group">
                    <label class="form-label">Étape 2 : Quel montant total ?</label>
                    <input type="number" name="amount" id="amount" class="form-control" 
                           placeholder="Ex: 30000" min="100" required>
                    <div class="form-hint">Ce montant sera divisé équitablement entre les destinataires</div>
                </div>
                
                <!-- ÉTAPE 3 : Options -->
                <div class="form-group">
                    <label class="form-label">Étape 3 : Options</label>
                    <label class="option-box">
                        <input type="checkbox" name="include_withdraw_fee" value="1" id="withdrawFee">
                        <div class="option-text">
                            <strong>Prépayer les frais de retrait</strong>
                            <small>Le destinataire pourra retirer gratuitement</small>
                        </div>
                    </label>
                </div>

                <a href="<?= base_url('client/epargne') ?>" class="btn btn-secondary" style="width: auto; padding: 0.5rem 1rem; font-size: 0.875rem;">
                    Espace Opérateur
                </a>
                
               
    <script src="<?=base_url('js/transfert.js') ?>"></script>
    
</body>
</html>