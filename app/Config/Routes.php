<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes for Auth controller
$routes->get('/', 'Auth::login');
$routes->get('auth/login', 'Auth::login');
$routes->get('auth/forgot', 'Auth::forgot');
$routes->post('auth/authenticate', 'Auth::authenticate');
$routes->get('auth/logout', 'Auth::logout');


// Routes for Home controller
$routes->get('home', 'Index::index');


// Routes for Users controller
$routes->get('users', 'Users::index');

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
