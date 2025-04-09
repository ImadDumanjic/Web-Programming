<?php

//get all branches or by name/location
Flight::route('GET /branch', function(){
    $name = Flight::request()->query['name'] ?? null;
    $location = Flight::request()->query['location'] ?? null;

    if ($name) {
        Flight::json(Flight::branchService()->getByName($name));
    } else if ($location) {
        Flight::json(Flight::branchService()->getByLocation($location));
    } else {
        Flight::json(Flight::branchService()->getAll());
    }
});

//get branch by id
Flight::route('GET/branch/@id', function($id){
    Flight::json(Flight::branchService() -> getById($id));
});

//create a new branch
Flight::route('POST /branch', function(){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::branchService() -> create($data));
});

//update a branch by ID
Flight::route('PUT /branch/@id', function($id){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::branchService() -> update($id, $data));
});

//delete a car
Flight::route('DELETE /branch/@id', function($id){
    Flight::json(Flight::branchService() -> delete($id));
});