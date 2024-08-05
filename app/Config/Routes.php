<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'AutenticacionController::loginView', ['as' => 'autenticacion.loginView']);
$routes->post('login', 'AutenticacionController::loginAction', ['as' => 'autenticacion.loginAction']);

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('logout', 'AutenticacionController::logoutAction', ['as' => 'autenticacion.logoutAction']);

    $routes->group('', ['filter' => 'auth-admin'], static function ($routes) {
        $routes->get('inventario/nuevo', 'ProductoController::new', ['as' => 'productos.new']);
        $routes->post('inventario/crear', 'ProductoController::create', ['as' => 'productos.create']);
        $routes->get('movimientos', 'MovimientoController::index', ['as' => 'movimientos.index']);
    });

    $routes->get('inventario', 'ProductoController::index', ['as' => 'productos.index']);
    $routes->get('inventario/editar/(:num)', 'ProductoController::edit/$1', ['as' => 'productos.edit']);
    $routes->post('inventario/actualizar/(:num)', 'ProductoController::update/$1', ['as' => 'productos.update']);
});
