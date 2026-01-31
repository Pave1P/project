<?php

define('BACKEND_ROOT', __DIR__);
define('PROJECT_ROOT', dirname(__DIR__));
define('FRONTEND_ROOT', PROJECT_ROOT . '/frontend');

define('APP_START_TIME', true);

require_once BACKEND_ROOT . '/vendor/autoload.php';
require_once BACKEND_ROOT . '/routes.php';