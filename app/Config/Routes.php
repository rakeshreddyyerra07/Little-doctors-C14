<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::login');

$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::register');

// Logout
$routes->get('/logout', 'AuthController::logout');

// Dashboard (only for logged-in users)
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Camp enrollment (only for logged-in users)
$routes->get('/enroll', 'Enrollment::index', ['filter' => 'auth']);
$routes->post('/enroll', 'Enrollment::save', ['filter' => 'auth']);