<?php

//get all rentals
Flight::route('GET /rent', function(){
    Flight::json(Flight::rentalService() -> getAll());
});

//get rent by specific id
Flight::route('GET /rent/@id', function($id){
    Flight::json(Flight::rentalService() -> getById($id));
});

//create a new rent
Flight::route('POST /rent', function(){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::rentalService() -> create($data));
});

//update a rent by ID
Flight::route('PUT /rent/@id', function($id){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::rentalService() -> update($id, $data));
});

//delete a rent by specific id
Flight::route('DELETE /rent/@id', function($id){
    Flight::json(Flight::rentalService() -> delete($id));
});

//start a rent
Flight::route('POST /rent', function(){
    $data = Flight::request()->data->getData();

    try{
        $rentalId = Flight::rentalService()->startRent($data);
        Flight::json(["message" => "Rental started successfully!", "rental_id" => $rentalId]);
    }catch (Exception $e){
        Flight::json(["error" => $e->getMessage()], 400);
    }
});

//end a rent
Flight::route('PUT /rent/end/@id', function($id){
    try {
        Flight::rentalService() -> endRent($id);
        Flight::json(["message" => "Rental ended successfully."]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});




