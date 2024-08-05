<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->group('', ['filter' => 'auth-redirect'], static function ($routes) {
    $routes->get('login', 'AuthController::loginView', ['as' => 'auth.loginView']);
    $routes->post('login', 'AuthController::loginAction', ['as' => 'auth.loginAction']);
});

$routes->addRedirect('/', 'auth.loginView');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('logout', 'AuthController::logoutAction', ['as' => 'auth.logoutAction']);

    $routes->group('', ['filter' => 'auth-admin'], static function ($routes) {
        $routes->get('inventario/nuevo', 'ProductController::new', ['as' => 'products.new']);
        $routes->post('inventario/crear', 'ProductController::create', ['as' => 'products.create']);
        $routes->get('movimientos', 'TransactionController::index', ['as' => 'transactions.index']);
    });

    $routes->get('inventario', 'ProductController::index', ['as' => 'products.index']);
    $routes->get('inventario/editar/(:num)', 'ProductController::edit/$1', ['as' => 'products.edit']);
    $routes->post('inventario/actualizar/(:num)', 'ProductController::update/$1', ['as' => 'products.update']);
});
