<?php

define('SERVER_ROOT', 'excel');
define('SITE_ROOT', 'http://localhost');
define('DB_NAME', 'excel');
define('DB_HOST','localhost');
define('DB_PORT', 3306);
define('DB_USERNAME','excel');
define('DB_PASSWORD', 'excel');

require_once 'libs/router.php';

try {
    $router = new Router();
    $router->dispach();
} catch (Exception $exc) {
    include 'view/error.php';
}
