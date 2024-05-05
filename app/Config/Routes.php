<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/form', 'Home::form');
$routes->get('/Edit', 'Home::editG');
$routes->post('/Delete', 'Home::delete');
$routes->post('/BulkDelete', 'Home::bulk');
$routes->post('/addData', 'Home::addData');
$routes->post('/update', 'Home::updateData');
