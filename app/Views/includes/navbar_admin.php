<?php $active_page = $active_page ?? ''; ?>
<nav class="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Opérateur Panel</a>
        <div class="navbar-nav">
            <a class="nav-link <?= $active_page == 'prefixes' ? 'active' : '' ?>" href="<?= base_url('admin/prefixes') ?>">Préfixes</a>
            <a class="nav-link <?= $active_page == 'commissions' ? 'active' : '' ?>" href="<?= base_url('admin/commissions') ?>">Commissions</a>
            <a class="nav-link <?= $active_page == 'fees' ? 'active' : '' ?>" href="<?= base_url('admin/fees') ?>">Barèmes Frais</a>
            <a class="nav-link <?= $active_page == 'comptes' ? 'active' : '' ?>" href="<?= base_url('admin/comptes') ?>">Situation Comptes</a>
            <a class="nav-link <?= $active_page == 'gains' ? 'active' : '' ?>" href="<?= base_url('admin/gains') ?>">Situation Gains</a>
            <a class="nav-link <?= $active_page == 'promotion' ? 'active' : '' ?>" href="<?= base_url('admin/promotion') ?>">promotion</a>
            <a class="nav-link text-warning" href="<?= base_url('client/login') ?>">Espace Client</a>
        </div>
    </div>
</nav>
