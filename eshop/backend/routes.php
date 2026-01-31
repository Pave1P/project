<?php

use Eshop\Routing\Router;
use Eshop\Controllers\ProductController;

//EXAMPLE
//Router::get('/api/ping', [new AliveController(), 'pingAction']);

Router::get('/api/products', [new ProductController(), 'listAction']);
Router::get('/api/products/:id', [new ProductController(), 'detailAction']);
