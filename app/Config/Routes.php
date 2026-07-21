<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */




// Page d'accueil = gestion des préfixes
$routes->get('/', 'Admin\Prefixes::index');

// Groupe pour la partie Client
$routes->group('client', ['namespace' => 'App\Controllers\Client'], function($routes) {
    
    // Auth
    $routes->get('login', 'Auth::index');
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

    $routes->get('epargne', 'Epargne::index');
    $routes->post('epargne', 'Epargne::doepargne');
    
    // Historique
    $routes->get('historique', 'Historique::index');
});


// ROUTES ADMIN 

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    
    // Préfixes
    $routes->get('prefixes', 'Prefixes::index');
    $routes->post('prefixes/ajouter', 'Prefixes::ajouter');
    $routes->get('prefixes/supprimer/(:num)', 'Prefixes::supprimer/$1');

    // Types d'opérations 
    $routes->get('operations', 'Operations::index');
    $routes->post('operations/ajouter', 'Operations::ajouter');
    $routes->get('operations/supprimer/(:num)', 'Operations::supprimer/$1');

    // Barèmes de frais
    $routes->get('fees', 'Fees::index');
    $routes->post('fees/modifier', 'Fees::modifier');
    $routes->post('fees/ajouter', 'Fees::ajouter');

    // Commissions
    $routes->get('commissions', 'Commissions::index');
    $routes->post('commissions/ajouter', 'Commissions::ajouter');
    $routes->get('commissions/supprimer/(:num)', 'Commissions::supprimer/$1');

     // promotion
    $routes->get('promotion', 'promotion::index');
    $routes->post('promotion/ajouter', 'promotion::ajouter');
    $routes->get('prommotion/supprimer/(:num)', 'promotion::supprimer/$1');

    // Dashboards
    $routes->get('gains', 'Gains::index');
    $routes->get('comptes', 'Comptes::index');
   
});