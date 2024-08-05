<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'AuthController::loginView', ['as' => 'autenticacion.loginView']);
$routes->post('login', 'AuthController::loginAction', ['as' => 'autenticacion.loginAction']);

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('logout', 'AuthController::logoutAction', ['as' => 'autenticacion.logoutAction']);

    $routes->group('', ['filter' => 'auth-admin'], static function ($routes) {
        $routes->get('inventario/nuevo', 'ProductController::new', ['as' => 'productos.new']);
        $routes->post('inventario/crear', 'ProductController::create', ['as' => 'productos.create']);
        $routes->get('movimientos', 'TransactionController::index', ['as' => 'movimientos.index']);
    });

    $routes->get('inventario', 'ProductController::index', ['as' => 'productos.index']);
    $routes->get('inventario/editar/(:num)', 'ProductController::edit/$1', ['as' => 'productos.edit']);
    $routes->post('inventario/actualizar/(:num)', 'ProductController::update/$1', ['as' => 'productos.update']);
});
