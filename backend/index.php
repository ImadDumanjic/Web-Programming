<?php

require './vendor/autoload.php';

// services
require_once 'Rest/Services/UserService.php';
require_once 'Rest/Services/CarService.php';
require_once 'Rest/Services/RentalService.php';
require_once 'Rest/Services/BranchService.php';
require_once 'Rest/Services/PaymentService.php';

// register services
Flight::register('userService', 'UserService');
Flight::register('carService', 'CarService');
Flight::register('rentalService', 'RentalService');
Flight::register('branchService', 'BranchService');
Flight::register('paymentService', 'PaymentService');

// routes
require_once 'Rest/Routes/UserRoute.php';
require_once 'Rest/Routes/CarRoute.php';
require_once 'Rest/Routes/RentalRoute.php';
require_once 'Rest/Routes/BranchRoute.php';
require_once 'Rest/Routes/PaymentRoute.php';

Flight::route('GET /test', function() {
    echo 'Flight works!';
});

Flight::start();


