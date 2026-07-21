<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Barèmes</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
</head>
<body>
<?= $this->include('includes/navbar_admin') ?>

<div class="container">
    <div class="card">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
            <span>Gestion des Barèmes de Frais</span>
            <button type="button" class="btn btn-primary btn-sm" onclick="openModal()" style="width:auto;">
                + Ajouter un barème
            </button>
        </div>
        <div class="card-body" style="padding: 0;">
            <!-- Tableau existant -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Type Opération</th>
                        <th>Montant Min (Ar)</th>
                        <th>Montant Max (Ar)</th>
                        <th>Frais (Ar)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($fees as $f): ?>
                    <form action="<?= base_url('admin/fees/modifier') ?>" method="post">
                        <input type="hidden" name="id" value="<?= $f['id'] ?>">
                        <tr>
                            <td><span class="badge badge-secondary"><?= esc($f['op_name']) ?></span></td>
                            <td><input type="number" step="0.01" name="min_amount" class="form-control" value="<?= $f['min_amount'] ?>" style="width: 120px;"></td>
                            <td><input type="number" step="0.01" name="max_amount" class="form-control" value="<?= $f['max_amount'] ?>" style="width: 120px;"></td>
                            <td><input type="number" step="0.01" name="fee_amount" class="form-control" value="<?= $f['fee_amount'] ?>" style="width: 100px;"></td>
                            <td><button type="submit" class="btn btn-success btn-sm">Mettre à jour</button></td>
                        </tr>
                    </form>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========== MODAL OVERLAY ========== -->
<div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3>Ajouter un barème de frais</h3>
            <button type="button" class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form action="<?= base_url('admin/fees/ajouter') ?>" method="post">
            <div class="form-group">
                <label class="form-label">Type d'opération</label>
                <select name="operation_code" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="DEPOT">Dépôt</option>
                    <option value="RETRAIT">Retrait</option>
                    <option value="TRANSFERT">Transfert</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Montant minimum (Ar)</label>
                <input type="number" step="0.01" name="min_amount" class="form-control" placeholder="Ex: 0" required>
            </div>
            <div class="form-group">
                <label class="form-label">Montant maximum (Ar)</label>
                <input type="number" step="0.01" name="max_amount" class="form-control" placeholder="Ex: 5000" required>
            </div>
            <div class="form-group">
                <label class="form-label">Frais à appliquer (Ar)</label>
                <input type="number" step="0.01" name="fee_amount" class="form-control" placeholder="Ex: 100" required>
            </div>
            <div style="display:flex; gap:0.75rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Enregistrer</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal()" style="flex:1; width:auto;">Annuler</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('modalOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(e) {
    if (!e || e.target === document.getElementById('modalOverlay')) {
        document.getElementById('modalOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
}


document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>

<?= $this->include('includes/footer') ?>