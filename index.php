<?php

use App\App;

ini_set('display_errors', '1');

session_start();

include_once 'helpers.php';
include_once 'autoload.php';

$app = new App();

$app->bootstrap();