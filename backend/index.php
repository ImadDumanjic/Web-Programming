<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// ✅ Dozvoljene domene
$allowedOrigins = [
    "https://luxury-drive-frontent-jubf7.ondigitalocean.app",
    "http://127.0.0.1:5501"
];

// ✅ Postavi CORS prije bilo čega drugog
Flight::before('start', function () use ($allowedOrigins) {
    if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
        header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
        header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true"); // ako koristiš tokene ili cookie
    }

    // ✅ Odgovor za OPTIONS (preflight) request
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204); // No Content
        exit();
    }
});

// ✅ Učitaj servise
require_once 'Rest/Services/UserService.php';
require_once 'Rest/Services/CarService.php';
require_once 'Rest/Services/RentalService.php';
require_once 'Rest/Services/BranchService.php';
require_once 'Rest/Services/PaymentService.php';
require_once 'Rest/Services/AuthServices.php';
require_once 'Rest/Services/ContactMessageService.php';
require_once 'middleware/AuthMiddleware.php';
require_once 'data/roles.php';

// ✅ Registruj servise
Flight::register('userService', 'UserService');
Flight::register('carService', 'CarService');
Flight::register('rentalService', 'RentalService');
Flight::register('branchService', 'BranchService');
Flight::register('paymentService', 'PaymentService');
Flight::register('contactMessageService', 'ContactMessageService');
Flight::register('auth_service', 'AuthService');
Flight::register('auth_middleware', 'AuthMiddleware');

// ✅ Middleware zaštita za sve rute osim login/register
Flight::route('/*', function () {
    $url = Flight::request()->url;

    if (
        strpos($url, '/auth/login') === 0 ||
        strpos($url, '/auth/register') === 0
    ) {
        return TRUE;
    }

    try {
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? $headers['authorization'] ?? null;

        if (!$token) {
            throw new Exception("Missing Authorization header");
        }

        Flight::auth_middleware()->verifyToken($token);
        return TRUE;
    } catch (\Exception $e) {
        Flight::halt(401, "Unauthorized: " . $e->getMessage());
    }
});

// ✅ Učitaj rute
require_once 'Rest/Routes/UserRoute.php';
require_once 'Rest/Routes/CarRoute.php';
require_once 'Rest/Routes/RentalRoute.php';
require_once 'Rest/Routes/BranchRoute.php';
require_once 'Rest/Routes/PaymentRoute.php';
require_once 'Rest/Routes/ContactMessageRoute.php';
require_once 'Rest/Routes/AuthRoutes.php';

// ✅ Start aplikacije
Flight::start();

