<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Groupe pour la partie (Admin)
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    
    $routes->get('prefixes', 'Prefixes::index');
    $routes->post('prefixes/ajouter', 'Prefixes::ajouter');
    $routes->get('prefixes/supprimer/(:num)', 'Prefixes::supprimer/$1');

    
    $routes->get('fees', 'Fees::index');
    $routes->post('fees/modifier', 'Fees::modifier');

    
    $routes->get('gains', 'Gains::index');
    $routes->get('comptes', 'Comptes::index');
});