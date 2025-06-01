<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

require __DIR__ . '/../../../vendor/autoload.php';

define('LOCALSERVER', 'http://localhost/project/backend/');
define('PRODSERVER', 'https://luxury-drive-2w37n.ondigitalocean.app/index.php/');

if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    define('BASE_URL', LOCALSERVER);
} else {
    define('BASE_URL', PRODSERVER);
}

$openapi = \OpenApi\Generator::scan([
    __DIR__ . '/doc_setup.php',
    __DIR__ . '/../../../Rest/Routes'
]);

header('Content-Type: application/json');
echo $openapi->toJson();
