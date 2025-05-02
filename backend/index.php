<?php

require './vendor/autoload.php';

// services
require_once 'Rest/Services/UserService.php';
require_once 'Rest/Services/CarService.php';
require_once 'Rest/Services/RentalService.php';
require_once 'Rest/Services/BranchService.php';
require_once 'Rest/Services/PaymentService.php';
require_once 'Rest/Services/AuthServices.php';


// register services
Flight::register('userService', 'UserService');
Flight::register('carService', 'CarService');
Flight::register('rentalService', 'RentalService');
Flight::register('branchService', 'BranchService');
Flight::register('paymentService', 'PaymentService');
Flight::register('auth_service', 'AuthService');


// routes
require_once 'Rest/Routes/UserRoute.php';
require_once 'Rest/Routes/CarRoute.php';
require_once 'Rest/Routes/RentalRoute.php';
require_once 'Rest/Routes/BranchRoute.php';
require_once 'Rest/Routes/PaymentRoute.php';
require_once 'Rest/Routes/AuthRoutes.php';

Flight::route('GET /test', function() {
    echo 'Flight works!';
});

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('/*', function() {
    $path = Flight::request()->url;

    if (strpos($path, '/auth/login') === 0 || strpos($path, '/auth/register') === 0 || strpos($path, '/test') === 0) {
        return;
    }

    try {
        $token = Flight::request()->getHeader('Authentication');

        if (!$token) {
            Flight::halt(401, 'Missing authentication header.');
        }

        $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));

        Flight::set('user', $decoded->user); 
    } catch (Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});

Flight::start();


