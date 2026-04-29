<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// $routes->get('/', 'Home::index');

$routes->get('/', 'AuthController::login');
$routes->post('auth/authenticate', 'AuthController::authenticate');
$routes->get('auth/logout', 'AuthController::logout');

// Routes protégées par authentification
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Dashboard
    $routes->get('/dashboard', 'DashboardController::index');
    
    // Gestion des notes
    $routes->get('/note/create', 'NoteController::create');
    $routes->post('/note/store', 'NoteController::store');
    $routes->post('/note/get-matieres-by-etudiant', 'NoteController::getMatieresByEtudiant');
    $routes->get('/note/etudiant/(:num)', 'NoteController::getByEtudiant/$1');
    
    // Liste des étudiants
    $routes->get('/etudiant', 'EtudiantController::index');
    $routes->get('/etudiant/(:num)', 'EtudiantController::show/$1');
});
