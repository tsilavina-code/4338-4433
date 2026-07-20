<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// ROUTES CLIENT 

// Page d'accueil = login client
$routes->get('/', 'Client\Auth::index');

// Groupe pour la partie Client
$routes->group('client', ['namespace' => 'App\Controllers\Client'], function($routes) {
    
    // Auth
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
    
    // Dashboard (solde + menu)
    $routes->get('dashboard', 'Dashboard::index');
    
    // Dépôt
    $routes->get('depot', 'Depot::index');
    $routes->post('depot', 'Depot::doDepot');
    
    // Retrait
    $routes->get('retrait', 'Retrait::index');
    $routes->post('retrait', 'Retrait::doRetrait');
    
    // Transfert
    $routes->get('transfert', 'Transfert::index');
    $routes->post('transfert', 'Transfert::doTransfert');
    
    // Historique
    $routes->get('historique', 'Historique::index');
});


// ROUTES ADMIN 

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    
    // Préfixes
    $routes->get('prefixes', 'Prefixes::index');
    $routes->post('prefixes/ajouter', 'Prefixes::ajouter');
    $routes->get('prefixes/supprimer/(:num)', 'Prefixes::supprimer/$1');

    // Types d'opérations (si ton binôme en a besoin)
    $routes->get('operations', 'Operations::index');
    $routes->post('operations/ajouter', 'Operations::ajouter');
    $routes->get('operations/supprimer/(:num)', 'Operations::supprimer/$1');

    // Barèmes de frais
    $routes->get('fees', 'Fees::index');
    $routes->post('fees/modifier', 'Fees::modifier');

    // Dashboards
    $routes->get('gains', 'Gains::index');
    $routes->get('comptes', 'Comptes::index');
});