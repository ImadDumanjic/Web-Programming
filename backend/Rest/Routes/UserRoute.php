<?php

/**
 * @OA\Schema(
 *   schema="User",
 *   required={"name", "email", "phone", "password", "user_type", "address"},
 *   @OA\Property(property="name", type="string", example="John Doe"),
 *   @OA\Property(property="email", type="string", example="john@example.com"),
 *   @OA\Property(property="phone", type="string", example="+38761123456"),
 *   @OA\Property(property="password", type="string", example="securePass123"),
 *   @OA\Property(property="user_type", type="string", example="Customer"),
 *   @OA\Property(property="address", type="string", example="Main Street 12, Sarajevo")
 * )
 */

/**
 * @OA\Get(
 *   path="/user",
 *   summary="Get all users or filter by name/userType",
 *   tags={"User"},
 *   @OA\Parameter(
 *     name="name",
 *     in="query",
 *     description="Filter users by name",
 *     required=false,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *     name="userType",
 *     in="query",
 *     description="Filter users by user type",
 *     required=false,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Response(response=200, description="List of users")
 * )
 */
Flight::route('GET /user', function(){
    Flight::auth_middleware() -> authorizeRoles([Roles::ADMIN, Roles::CUSTOMER]);

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

/**
 * @OA\Get(
 *   path="/user/{id}",
 *   summary="Get user by ID",
 *   tags={"User"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="User found"),
 *   @OA\Response(response=404, description="User not found")
 * )
 */
Flight::route('GET /user/@id', function($id){
    Flight::auth_middleware() -> authorizeRoles([Roles::ADMIN, Roles::CUSTOMER]);
    Flight::json(Flight::userService() -> getById($id));
});

/**
 * @OA\Post(
 *   path="/user",
 *   summary="Create a new user",
 *   tags={"User"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/User")
 *   ),
 *   @OA\Response(response=200, description="User created successfully")
 * )
 */
Flight::route('POST /user', function(){
    Flight::auth_middleware() -> authorizeRoles(Roles::ADMIN);

    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::userService() -> create($data));
});

/**
 * @OA\Put(
 *   path="/user/{id}",
 *   summary="Update user by ID",
 *   tags={"User"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/User")
 *   ),
 *   @OA\Response(response=200, description="User updated successfully")
 * )
 */
Flight::route('PUT /user/@id', function($id){
    Flight::auth_middleware() -> authorizeRoles(Roles::ADMIN);

    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::userService() -> update($id, $data));
});

/**
 * @OA\Delete(
 *   path="/user/{id}",
 *   summary="Delete a user by ID",
 *   tags={"User"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="User deleted successfully")
 * )
 */
Flight::route('DELETE /user/@id', function($id){
    Flight::auth_middleware() -> authorizeRoles(Roles::ADMIN);
    Flight::json(Flight::userService() -> delete($id));
});

/**
 * @OA\Post(
 *   path="/user/register",
 *   summary="Register a new user",
 *   tags={"User"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/User")
 *   ),
 *   @OA\Response(response=200, description="User registered successfully"),
 *   @OA\Response(response=400, description="Validation error")
 * )
 */
Flight::route('POST /user/register', function(){
    Flight::auth_middleware() -> authorizeRoles(Roles::ADMIN);
    $data = Flight::request()->data->getData();

    try {
        $userId = Flight::userService()->registerUser($data);
        Flight::json(["message" => "User registered successfully", "user_id" => $userId]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});

/**
 * @OA\Post(
 *   path="/user/login",
 *   summary="Login user",
 *   tags={"User"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       required={"email", "password"},
 *       @OA\Property(property="email", type="string", example="john@example.com"),
 *       @OA\Property(property="password", type="string", example="securePass123")
 *     )
 *   ),
 *   @OA\Response(response=200, description="Login successful"),
 *   @OA\Response(response=401, description="Invalid credentials")
 * )
 */
Flight::route('POST /user/login', function(){
    Flight::auth_middleware() -> authorizeRoles(Roles::ADMIN);
    $data = Flight::request() -> data -> getData();

    try {
        $user = Flight::userService() -> login($data['email'], $data['password']);
        Flight::json(["message" => "Login successful", "user" => $user]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 401);
    }
});
