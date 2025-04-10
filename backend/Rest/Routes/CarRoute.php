<?php

//get all cars or by model/year/brand
Flight::route('GET /car', function(){
    $model = Flight::request() -> query['model'] ?? null;
    $year = Flight::request() -> query['year'] ?? null;
    $brand = Flight::request() -> query['brand'] ?? null;

    if($model){
        Flight::json(Flight::carService() -> getByModel($model));
    } else if($year){
        Flight::json(Flight::carService() -> getByYear($year));
    } else if($brand){
        Flight::json(Flight::carService() -> getByBrand($brand));
    } else{
        Flight::json(Flight::carService() -> getAll());
    }
});

//get car by id
Flight::route('GET /car/@id', function($id){
    Flight::json(Flight::carService() -> getById($id));
});

//create a new car
Flight::route('POST /car', function(){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::carService() -> create($data));
});

//update a specific car by id
Flight::route('PUT /car/@id', function($id){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::carService() -> update($id, $data));
});

//delete a car
Flight::route('DELETE /car/@id', function($id){
    Flight::json(Flight::carService() -> delete($id));
});

//rent a car
Flight::route('PUT /car/rent/@id', function($id){
    try {
        Flight::json(Flight::carService()->rentCar($id));
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});

//return a car
Flight::route('PUT /car/return/@id', function($id){
    try {
        Flight::json(Flight::carService()->returnCar($id));
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});
