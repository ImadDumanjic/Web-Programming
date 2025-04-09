<?php

//get all payments
Flight::route('GET /payment', function(){
    Flight::json(Flight::PaymentService() -> getAll());
});

//get payment by id
Flight::route('GET /payment/@id', function($id){
    Flight::json(Flight::PaymentService() -> getById($id));
});

//create a new payment
Flight::route('POST /payment', function(){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::PaymentService() -> create($data));
});

//update a specific payment by id
Flight::route('PUT /payment/@id', function($id){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::PaymentService() -> update($id, $data));
});

//delete a car
Flight::route('DELETE /payment/@id', function($id){
    Flight::json(Flight::PaymentService() -> delete($id));
});

//process a payment
Flight::route('POST /payment', function(){
    $data = Flight::request() -> data -> getData();

    try{
        Flight::json(Flight::PaymentService() -> processPayment($data));
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});