<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'AutenticacionController::loginView', ['as' => 'autenticacion.loginView']);
$routes->post('login', 'AutenticacionController::loginAction', ['as' => 'autenticacion.loginAction']);
