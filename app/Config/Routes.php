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

// Contact Us
$routes->get('/contact', 'Contact::index');
$routes->post('/contact', 'Contact::send');
$routes->post('/contact/send', 'Contact::send');

// Admin panel
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('dashboard', 'Admin::index');
    $routes->get('users', 'Admin::users');
    $routes->get('logs', 'Admin::logs');
    $routes->get('ip-check', 'IpCheck::index');

    // Site settings: contact details and social media
    $routes->get('settings', 'AdminSettings::index');
    $routes->post('settings', 'AdminSettings::save');

    // Camps, Learning Lab courses, Testimonials
    $routes->get('content/(:segment)', 'AdminContent::index/$1');
    $routes->get('content/(:segment)/new', 'AdminContent::form/$1');
    $routes->get('content/(:segment)/edit/(:num)', 'AdminContent::form/$1/$2');
    $routes->post('content/(:segment)/save', 'AdminContent::save/$1');
    $routes->post('content/(:segment)/delete/(:num)', 'AdminContent::delete/$1/$2');
    $routes->post('content/(:segment)/toggle/(:num)', 'AdminContent::toggle/$1/$2');

    // Home slides
    $routes->get('slides', 'AdminSlides::index');
    $routes->get('slides/new', 'AdminSlides::form');
    $routes->get('slides/edit/(:num)', 'AdminSlides::form/$1');
    $routes->post('slides/save', 'AdminSlides::save');
    $routes->post('slides/delete/(:num)', 'AdminSlides::delete/$1');
    $routes->post('slides/toggle/(:num)', 'AdminSlides::toggle/$1');
});