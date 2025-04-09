<?php

//get all cars or by model/year/brand
Flight::route('GET /car', function(){
    $model = Flight::request() -> query['model'] ?? null;
    $year = Flight::request() -> query['year'] ?? null;
    $brand = Flight::request() -> query['brand'] ?? null;

    if($model){
        Flight::json(Flight::CarService() -> getbyModel($model));
    } else if($year){
        Flight::json(Flight::CarService() -> getbyYear($year));
    } else if($brand){
        Flight::json(Flight::CarService() -> getByBrand($brand));
    } else{
        Flight::json(Flight::CarService() -> getAll());
    }
});

//get car by id
Flight::route('GET /car/@id', function($id){
    Flight::json(Flight::CarService() -> getById($id));
});

//create a new car
Flight::route('POST /car', function(){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::CarService() -> create($data));
});

//update a specific car by id
Flight::route('PUT /car/@id', function($id){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::CarService() -> update($id, $data));
});

//delete a car
Flight::route('DELETE /car/@id', function($id){
    Flight::json(Flight::CarService() -> delete($id));
});