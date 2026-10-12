<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::login', [
    'filter' => ['authvalidate:login', 'loginlog']
]);

$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::register', [
    'filter' => 'authvalidate:register'
]);

// Forgot / reset password
$routes->get('/forgot-password', 'PasswordReset::forgotForm');
$routes->post('/forgot-password', 'PasswordReset::sendLink');
$routes->get('/reset-password/(:segment)', 'PasswordReset::resetForm/$1');
$routes->post('/reset-password', 'PasswordReset::updatePassword');

// Logout
$routes->get('/logout', 'AuthController::logout');

// Dashboard
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Camp enrollment
$routes->get('/enroll', 'Enrollment::index', ['filter' => 'auth']);
$routes->post('/enroll', 'Enrollment::save', ['filter' => 'auth']);

// Login activity
$routes->get('/login-logs', 'LoginLogs::index', ['filter' => 'auth']);

// Public pages
$routes->get('/learn', 'Pages::learn');
$routes->get('/camps', 'Pages::camps');
$routes->get('/events', 'Pages::events');
$routes->get('/about', 'Pages::about');
$routes->get('/stories', 'Pages::stories');

// Contact Us: display form and submit to the existing send() method
$routes->get('/contact', 'Contact::index');
$routes->post('/contact', 'Contact::send');
$routes->post('/contact/send', 'Contact::send');

// Admin panel
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('users', 'Admin::users');
    $routes->get('logs', 'Admin::logs');

    // Site settings: contact details and social media
    $routes->get('settings', 'AdminSettings::index');
    $routes->post('settings', 'AdminSettings::save');
});