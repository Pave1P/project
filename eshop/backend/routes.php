<?php
declare(strict_types=1);

use Eshop\Routing\Router;
use Eshop\Controllers\OrderController;
use Eshop\Controllers\ProductController;
use Eshop\Controllers\LoginAdminController;

//EXAMPLE
//Router::get('/api/ping', [new AliveController(), 'pingAction']);

Router::get('/api/products', [new ProductController(), 'listAction']);
Router::get('/api/products/:id', [new ProductController(), 'detailAction']);

Router::post('/api/login/admin', [new LoginAdminController(), 'loginAction']);

Router::post('/api/orders', [new OrderController(), 'createAction']);
Router::get('/api/orders', [new OrderController(), 'listAction']);