<?php

require './vendor/autoload.php';

// services
require_once 'Rest/Services/UserService.php';
require_once 'Rest/Services/CarService.php';
require_once 'Rest/Services/RentalService.php';
require_once 'Rest/Services/BranchService.php';
require_once 'Rest/Services/PaymentService.php';
require_once 'Rest/Services/AuthServices.php';
require_once 'middleware/AuthMiddleware.php';
require_once 'data/roles.php';



// register services
Flight::register('userService', 'UserService');
Flight::register('carService', 'CarService');
Flight::register('rentalService', 'RentalService');
Flight::register('branchService', 'BranchService');
Flight::register('paymentService', 'PaymentService');
Flight::register('authService', 'AuthService');
Flight::register('authMiddleware', 'AuthMiddleware');


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
    if(
        strpos(Flight::request() -> url, '/auth/login') === 0 ||
        strpos(Flight::request() -> url, '/auth/register') === 0
    ){
        return TRUE;
    } else{
        try{
            $token = Flight::request()->getHeader("Authentication");
            if(Flight::auth_middleware()->verifyToken($token))
                return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
 });
 
Flight::start();


