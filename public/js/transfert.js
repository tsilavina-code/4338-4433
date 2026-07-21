        
        const clientsOptions = `<?php foreach($clients as $c): ?><option value="<?= $c['phone'] ?>"><?= $c['phone'] ?></option><?php endforeach; ?>`;
        let recipientCount = 1;
        
      
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
