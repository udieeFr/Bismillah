<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //initial page = login
$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');

//register if new user
$routes->get('/login/register', 'Auth::register');
$routes->get('/register', 'Auth::register');

//register authentication
$routes->get('auth/register', 'Auth::register');
$routes->get('register', 'Auth::register');
$routes->post('auth/save_register', 'Auth::save_register');

//authenticate student
$routes->post('login/authenticate', 'Login::authenticate');
//authenticate admin
$routes->post('admin/authenticate', 'AdminAuth::authenticate');

//student :
$routes->get('studentDashboard', 'StudentDashboard::index', ['filter' => 'auth']);
//more info on user profile
$routes->get('student/getProfile', 'Student::getProfile');

// Admin 
$routes->post('admin/authenticate', 'AdminAuth::authenticate');  // For admin login form submission
$routes->get('AdminDashboard', 'AdminDashboard::index', ['filter' => 'adminAuth']); // Dashboard with auth filter
$routes->post('verify-email', 'Auth::processEmailVerification'); // For processing verification
$routes->get('admin/dashboard', 'AdminDashboard::index');
$routes->match(['get', 'post'], 'admin/search-student', 'AdminDashboard::searchStudent');
$routes->post('admin/register-fine', 'AdminDashboard::registerFine');
$routes->post('admin/register-payment', 'AdminDashboard::registerPayment');
$routes->post('adminDashboard/searchStudent', 'AdminDashboard::searchStudent');
$routes->get('admin/dashboard', 'AdminDashboard::index');
$routes->match(['get', 'post'], 'admin/search-student', 'AdminDashboard::searchStudent');

//email verification
$routes->get('verify-email', 'Auth::verifyEmail');
$routes->post('process-verification', 'Auth::processEmailVerification');
$routes->post('auth/processEmailVerification', 'Auth::processEmailVerification');

//logout
$routes->get('/logout', 'login::logout'); //logout and terminate session





