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

    $routes->get('productos/nuevo', 'ProductoController::new', ['as' => 'productos.new']);
    $routes->post('productos/crear', 'ProductoController::create', ['as' => 'productos.create']);
    $routes->get('inventario', 'ProductoController::index', ['as' => 'productos.index']);
    $routes->get('productos/editar', 'ProductoController::edit/$1', ['as' => 'productos.edit']);

    $routes->get('movimientos', 'MovimientoController::index', ['as' => 'movimientos.index']);
});
