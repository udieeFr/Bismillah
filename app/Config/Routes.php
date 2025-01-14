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

//authenticate student
$routes->post('login/authenticate', 'Login::authenticate');
//authenticate admin
$routes->post('admin/authenticate', 'AdminAuth::authenticate');

//email verification
$routes->get('verify-email', 'Auth::verifyEmail');
$routes->post('process-verification', 'Auth::processEmailVerification');
$routes->post('auth/processEmailVerification', 'Auth::processEmailVerification');

$routes->get('studentDashboard', 'StudentDashboard::index', ['filter' => 'auth']);
//more info on user profile
$routes->get('student/getProfile', 'Student::getProfile');

