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
    
    <script>
        // Données clients pour le template
        const clientsOptions = `<?php foreach($clients as $c): ?><option value="<?= $c['phone'] ?>"><?= $c['phone'] ?></option><?php endforeach; ?>`;
        let recipientCount = 1;
        
        // Ajouter un destinataire
        document.getElementById('addRecipient').addEventListener('click', function() {
            recipientCount++;
            const container = document.getElementById('recipientsList');
            const div = document.createElement('div');
            div.className = 'recipient-box';
            div.innerHTML = `
                <span class="recipient-num">${recipientCount}</span>
                <select name="recipients[]" class="form-control recipient-select" required>
                    <option value="">-- Sélectionner un numéro --</option>
                    ${clientsOptions}
                    <option value="other">+ Saisir un autre numéro</option>
                </select>
                <input type="text" class="form-control other-phone" 
                       placeholder="Ex: 0321234567" style="display:none;">
                <button type="button" class="btn-remove" onclick="removeRecipient(this)">✕</button>
            `;
            container.appendChild(div);
            attachListener(div.querySelector('.recipient-select'));
            updateRecap();
            
            // Montrer le bouton supprimer sur tous
            document.querySelectorAll('.btn-remove').forEach(b => b.style.display = 'flex');
        });
        
        // Supprimer un destinataire
        function removeRecipient(btn) {
            const boxes = document.querySelectorAll('.recipient-box');
            if (boxes.length > 1) {
                btn.closest('.recipient-box').remove();
                // Renumber
                document.querySelectorAll('.recipient-num').forEach((span, i) => {
                    span.textContent = i + 1;
                });
                recipientCount = boxes.length - 1;
                updateRecap();
            }
            if (document.querySelectorAll('.recipient-box').length === 1) {
                document.querySelector('.btn-remove').style.display = 'none';
            }
        }
        
        // Gérer le select "Autre numéro"
        function attachListener(select) {
            select.addEventListener('change', function() {
                const otherInput = this.nextElementSibling;
                if (this.value === 'other') {
                    otherInput.style.display = 'block';
                    otherInput.name = 'recipients[]';
                    otherInput.required = true;
                    this.name = '';
                } else {
                    otherInput.style.display = 'none';
                    otherInput.name = '';
                    otherInput.required = false;
                    otherInput.value = '';
                }
                updateRecap();
            });
        }
        
        document.querySelectorAll('.recipient-select').forEach(attachListener);
        
        // Mise à jour du récapitulatif
        function updateRecap() {
            const boxes = document.querySelectorAll('.recipient-box');
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const includeFee = document.getElementById('withdrawFee').checked;
            const nb = boxes.length;
            
            const recapBox = document.getElementById('recapBox');
            
            if (amount > 0 && nb > 0) {
                const perPerson = amount / nb;
                document.getElementById('amountPerPerson').textContent = perPerson.toLocaleString('fr-FR') + ' Ar';
                document.getElementById('nbRecipients').textContent = nb + ' personne' + (nb > 1 ? 's' : '');
                
                // Frais de retrait estimés (simplifié : 100 Ar par personne)
                const withdrawFee = includeFee ? (100 * nb) : 0;
                document.getElementById('withdrawFeeAmount').textContent = withdrawFee.toLocaleString('fr-FR') + ' Ar';
                document.getElementById('feeRow').style.display = includeFee ? 'flex' : 'none';
                
                // Total estimé
                const total = amount + withdrawFee;
                document.getElementById('totalDebit').textContent = total.toLocaleString('fr-FR') + ' Ar';
                
                recapBox.style.display = 'block';
            } else {
                recapBox.style.display = 'none';
            }
        }
        
        document.getElementById('amount').addEventListener('input', updateRecap);
        document.getElementById('withdrawFee').addEventListener('change', updateRecap);
        
        // Validation
        document.getElementById('transfertForm').addEventListener('submit', function(e) {
            const selects = document.querySelectorAll('.recipient-select');
            const values = [];
            
            selects.forEach(select => {
                if (select.value === 'other') {
                    const input = select.nextElementSibling;
                    if (input.value) values.push(input.value);
                } else if (select.value) {
                    values.push(select.value);
                }
            });
            
            const unique = [...new Set(values)];
            if (unique.length !== values.length) {
                e.preventDefault();
                alert('Vous avez sélectionné deux fois le même numéro');
                return false;
            }
        });
    </script>
</body>
</html>