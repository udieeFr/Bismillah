<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');
$routes->get('/login/register', 'Auth::register');
$routes->get('/register', 'Auth::register');
$routes->get('auth/register', 'Auth::register');
$routes->get('register', 'Auth::register');
$routes->post('auth/save_register', 'Auth::save_register');

// In Config/Routes.php
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');

$routes->get('studentDashboard', 'StudentDashboard::index', ['filter' => 'auth']);
