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
            <h2 class="auth-title">📤 Envoyer de l'argent</h2>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            
            <form action="<?= base_url('client/transfert') ?>" method="post" id="transfertForm">
                
                <!-- ÉTAPE 1 : Choisir les destinataires -->
                <div class="form-group">
                    <label class="form-label">Étape 1 : À qui voulez-vous envoyer ?</label>
                    
                    <div id="recipientsList">
                        <!-- Premier destinataire -->
                        <div class="recipient-box">
                            <span class="recipient-num">1</span>
                            <select name="recipients[]" class="form-control recipient-select" required>
                                <option value="">-- Sélectionner un numéro --</option>
                                <?php foreach($clients as $c): ?>
                                    <option value="<?= $c['phone'] ?>"><?= $c['phone'] ?></option>
                                <?php endforeach; ?>
                                <option value="other">+ Saisir un autre numéro</option>
                            </select>
                            <input type="text" class="form-control other-phone" 
                                   placeholder="Ex: 0321234567" style="display:none;">
                            <button type="button" class="btn-remove" onclick="removeRecipient(this)" style="display:none;">✕</button>
                        </div>
                    </div>
                    
                    <button type="button" class="btn-add" id="addRecipient">
                        + Ajouter un autre destinataire
                    </button>
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
                
                <!-- RÉCAPITULATIF -->
                <div class="recap-box" id="recapBox" style="display:none;">
                    <h4>Récapitulatif</h4>
                    <div class="recap-row">
                        <span>Montant par personne :</span>
                        <strong id="amountPerPerson">—</strong>
                    </div>
                    <div class="recap-row">
                        <span>Nombre de destinataires :</span>
                        <strong id="nbRecipients">—</strong>
                    </div>
                    <div class="recap-row" id="feeRow" style="display:none;">
                        <span>Frais de retrait prépayés :</span>
                        <strong id="withdrawFeeAmount">—</strong>
                    </div>
                    <div class="recap-row total">
                        <span>Total à débiter :</span>
                        <strong id="totalDebit">—</strong>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-info">Confirmer le transfert</button>
                <a href="<?= base_url('client/dashboard') ?>" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
    <script src="<?=base_url('js/transfert.js') ?>"></script>
    
</body>
</html>