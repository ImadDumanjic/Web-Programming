<?php
require __DIR__ . '/vendor/autoload.php';

Flight::route('/', function(){
    echo "Hello, FlightPHP!";
});

Flight::start();
