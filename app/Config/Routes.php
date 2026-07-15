<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
    $routes->get('/', 'Auth::showLogin');
    $routes->get('/login', 'Auth::showLogin');
    $routes->post('/login', 'Auth::login');
    $routes->get('/logout', 'Auth::logout');
    $routes->get('/forgot-password', 'Auth::forgotPasswordForm');
    $routes->post('/forgot-password', 'Auth::sendResetLink');
    $routes->get('/reset-password/(:segment)', 'Auth::resetPasswordForm/$1');
    $routes->post('/reset-password', 'Auth::updatePassword');

    $routes->get('/dashboard', 'Dashboard::index', ['filter' => 'authFilter']);

    $routes->get('/tickets/create', 'Ticket::create', ['filter' => 'authFilter']);
    $routes->post('/tickets/store', 'Ticket::store', ['filter' => 'authFilter']);
    $routes->get('/tickets', 'Ticket::myTickets', ['filter' => 'authFilter']);

    $routes->group('admin', ['filter' => ['authFilter', 'adminFilter']], function ($routes) {
        $routes->get('dashboard', 'Admin\Dashboard::index');
        $routes->get('tickets/(:num)', 'Admin\TicketManage::show/$1');
        $routes->post('tickets/(:num)/update', 'Admin\TicketManage::updateStatus/$1');

        $routes->get('users', 'Admin\UserManage::index');
        $routes->get('users/create', 'Admin\UserManage::create');
        $routes->post('users/store', 'Admin\UserManage::store');
});