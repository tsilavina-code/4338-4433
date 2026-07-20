<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Opérateur - Situation Gains V2</title>
     <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>">
   
</head>
<body>

<!-- Barre de navigation espace Admin -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Opérateur Panel</a>
        <div class="navbar-nav">
            <a class="nav-link" href="<?= base_url('admin/prefixes') ?>">Préfixes</a>
            <a class="nav-link" href="<?= base_url('admin/fees') ?>">Barèmes Frais</a>
            <a class="nav-link" href="<?= base_url('admin/comptes') ?>">Situation Comptes</a>
            <a class="nav-link active" href="<?= base_url('admin/gains') ?>">Situation Gains</a>
            <a class="nav-link text-warning" href="<?= base_url('/') ?>">Login Client</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark m-0">Suivi Financier &amp; Interconnexions</h2>
       
    </div>

    <!-- Section 1 : Séparation des gains (Interne vs Externe) -->
    <div class="row g-3 mb-4 text-center">
        <div class="col-md-4">
            <div class="card card-stats bg-primary text-white p-4 h-100 shadow-sm">
                <h6 class="text-white-50 text-uppercase fw-bold small">Gains Internes</h6>
                <p class="small m-0">Frais standards collectés sur notre réseau</p>
                <h3 class="fw-bold mt-3 mb-0"><?= number_format($gains_interne, 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats bg-warning text-dark p-4 h-100 shadow-sm">
                <h6 class="text-muted text-uppercase fw-bold small">Gains Autres Opérateurs</h6>
                <p class="small m-0">Commissions supplémentaires perçues (2 %)</p>
                <h3 class="fw-bold mt-3 mb-0"><?= number_format($gains_inter, 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats bg-success text-white p-4 h-100 shadow-sm">
                <h6 class="text-white-50 text-uppercase fw-bold small">Total Global des Profits</h6>
                <p class="small m-0">Cumul net de l'ensemble des frais</p>
                <h3 class="fw-bold mt-3 mb-0"><?= number_format($total_gains, 2, ',', ' ') ?> Ar</h3>
            </div>
        </div>
    </div>

    <!-- Section 2 : Situation des montants à envoyer à chaque opérateur tiers -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-danger mb-2">Situation des montants à envoyer à chaque opérateur</h5>
            <p class="text-muted small mb-4">
                Montants totaux collectés auprès de nos clients devant être reversés aux réseaux externes (Orange, Telma, etc.), déduction faite de nos commissions de routage.
            </p>
            
            <div class="table-responsive">
                <table class="table table-striped align-middle m-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Opérateur Destinataire</th>
                            <th>Montant Total à lui Envoyer</th>
                            <th>Commissions que nous avons Gagnées</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($montants_par_operateur as $op): ?>
                        <tr>
                            <td>
                               <span class="badge bg-dark text-white px-3 py-2 text-uppercase fs-6">
                                    <?= esc($op['operator']) ?>
                                </span>
                            </td>
                            <td class="fw-bold text-danger fs-5">
                                <?= number_format($op['total_envoye'], 2, ',', ' ') ?> Ar
                            </td>
                            <td class="fw-bold text-success fs-5">
                                <?= number_format($op['commissions_generees'], 2, ',', ' ') ?> Ar
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($montants_par_operateur)): ?>
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">
                                Aucune transaction vers des opérateurs externes n'a encore été simulée.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>