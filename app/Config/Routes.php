<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes for Auth controller
$routes->get('/', 'Auth::login');
$routes->get('auth/login', 'Auth::login');
$routes->get('auth/forgot', 'Auth::forgot');
$routes->get('auth/reset/(:num)', 'Auth::reset_page/$1');
$routes->get('auth/logout', 'Auth::logout');

$routes->post('auth/authenticate', 'Auth::authenticate');
$routes->post('auth/reset-request', 'Auth::reset_request');
$routes->post('auth/reset/(:num)', 'Auth::reset/$1');



// Routes for dashboard controller
$routes->get('dashboard', 'Index::index');

// Routes for Users controller
$routes->get('users', 'Users::index');

// Routes for Equipments controller
$routes->get('equipments', 'Equipments::index');

// Routes for Borrows controller
$routes->get('borrows', 'Borrows::index');

// Routes for Returns controller
$routes->get('returns', 'Returns::index');

// Routes for Reservations controller
$routes->get('reservations', 'Reservations::index');







$routes->get('users/add', 'Users::add');
$routes->post('users/insert', 'Users::insert');

$routes->get('users/view/(:num)', 'Users::view/$1');

$routes->post('users/update/(:num)', 'Users::update/$1');
$routes->get('users/edit/(:num)', 'Users::edit/$1');

$routes->get('users/delete/(:num)', 'Users::delete/$1');

// Routes for Products controller
$routes->get('products', 'Products::index');

$routes->get('products/add', 'Products::add');
$routes->post('products/insert', 'Products::insert');

$routes->get('products/view/(:num)', 'Products::view/$1');

$routes->post('products/update/(:num)', 'Products::update/$1');
$routes->get('products/edit/(:num)', 'Products::edit/$1');

$routes->get('products/delete/(:num)', 'Products::delete/$1');
