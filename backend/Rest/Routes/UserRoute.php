<?php

//get all users or by name/userType
Flight::route('GET /user', function(){
    $name = Flight::request() -> query['name'] ?? null;
    $userType = Flight::request() -> query['userType'] ?? null;

    if($name){
        Flight::json(Flight::userService() -> getByName($name));
    } else if($userType){
        Flight::json(Flight::userService() -> getByUserType($userType));
    } else{
        Flight::json(Flight::userService() -> getAll());
    }
});

//get user by id
Flight::route('GET/user/@id', function($id){
    Flight::json(Flight::userService() -> getById($id));
});

//create a new user
Flight::route('POST /user', function(){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::userService() -> create($data));
});

//update a branch by ID
Flight::route('PUT /user/@id', function($id){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::userService() -> update($id, $data));
});

//delete a car
Flight::route('DELETE /user/@id', function($id){
    Flight::json(Flight::userService() -> delete($id));
});

//register user
Flight::route('POST /user/register', function(){
    $data = Flight::request()->data->getData();

    try {
        $userId = Flight::userService()->registerUser($data);
        Flight::json(["message" => "User registered successfully", "user_id" => $userId]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});

//login user
Flight::route('POST /user/login', function(){
    $data = Flight::request() -> data -> getData();

    try {
        $user = Flight::userService() -> login($data['email'], $data['password']);
        Flight::json(["message" => "Login successful", "user" => $user]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 401);
    }
});
