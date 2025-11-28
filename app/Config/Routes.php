<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes for Auth controller
// Get routes
$routes->get('/', 'Auth::login');
$routes->get('auth/login', 'Auth::login');
$routes->get('auth/forgot', 'Auth::forgot');
$routes->get('auth/reset/(:segment)', 'Auth::reset_page/$1');
$routes->get('auth/logout', 'Auth::logout');
// Post routes
$routes->post('auth/authenticate', 'Auth::authenticate');
$routes->post('auth/reset-request', 'Auth::reset_request');
$routes->post('auth/reset/(:segment)', 'Auth::reset/$1');


// Routes for dashboard controller
$routes->get('dashboard', 'Index::index');


// Routes for Users controller
// Get routes
$routes->get('users', 'Users::index');
$routes->get('users/verify/(:segment)', 'Users::verify/$1');
$routes->get('users/view/(:num)', 'Users::view/$1');
$routes->get('users/edit/(:num)', 'Users::edit/$1');
$routes->get('users/delete/(:num)', 'Users::delete/$1');

// Post routes
$routes->post('users/insert', 'Users::insert');
$routes->post('users/update/(:num)', 'Users::update/$1');


// Routes for Equipments controller
$routes->get('equipments', 'Equipments::index');


// Routes for Borrows controller
// Get routes
$routes->get('borrows', 'Borrows::index');
$routes->get('borrows/view/(:num)', 'Borrows::view/$1');
$routes->get('borrows/return/(:num)', 'Borrows::return/$1');
$routes->get('borrows/delete/(:num)', 'Borrows::delete/$1');
// Post routes
$routes->post('borrows/insert', 'Borrows::insert');


// Routes for Returns controller
$routes->get('returns', 'Returns::index');    // <-- add this
$routes->post('returns/insert', 'Returns::insert');
$routes->get('returns/clearAll', 'Returns::clearAll');
$routes->get('returns/view/(:num)', 'Returns::view/$1');



// Routes for Reservations controller
$routes->get('reservations', 'Reservations::index');











