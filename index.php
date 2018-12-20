<?php

use App\App;

ini_set('display_errors', '1');

session_start();

include_once 'helpers.php';
include_once 'autoload.php';

$app = new App();

try {
    $app->bootstrap();
} catch (Exception $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
    $errorMessage = $e->getMessage();
    include 'views/404.php';
    exit();
}