<?php

/**
 * @OA\Schema(
 *   schema="Car",
 *   required={"brand", "model", "year", "rental_price_per_day", "engine", "horsepower", "torque", "acceleration", "top_speed", "transmission", "status"},
 *   @OA\Property(property="brand", type="string", example="BMW"),
 *   @OA\Property(property="model", type="string", example="M3"),
 *   @OA\Property(property="year", type="integer", example=2022),
 *   @OA\Property(property="rental_price_per_day", type="number", format="float", example=89.99),
 *   @OA\Property(property="engine", type="string", example="3.0L Turbo"),
 *   @OA\Property(property="horsepower", type="integer", example=473),
 *   @OA\Property(property="torque", type="integer", example=550),
 *   @OA\Property(property="acceleration", type="number", format="float", example=4.1),
 *   @OA\Property(property="top_speed", type="integer", example=250),
 *   @OA\Property(property="transmission", type="string", example="Automatic"),
 *   @OA\Property(property="status", type="string", example="Available")
 * )
 */

/**
 * @OA\Get(
 *   path="/car",
 *   summary="Get all cars or filter by model/year/brand",
 *   tags={"Car"},
 *   @OA\Parameter(
 *     name="model",
 *     in="query",
 *     description="Filter cars by model",
 *     required=false,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *     name="year",
 *     in="query",
 *     description="Filter cars by year",
 *     required=false,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Parameter(
 *     name="brand",
 *     in="query",
 *     description="Filter cars by brand",
 *     required=false,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Response(response=200, description="List of cars")
 * )
 */
Flight::route('GET /car', function(){
    Flight::auth_middleware() -> authorizeRoles([Roles::ADMIN, Roles::CUSTOMER]);

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

/**
 * @OA\Get(
 *   path="/car/{id}",
 *   summary="Get car by ID",
 *   tags={"Car"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Car found"),
 *   @OA\Response(response=404, description="Car not found")
 * )
 */
Flight::route('GET /car/@id', function($id){
    Flight::auth_middleware() -> authorizeRoles([Roles::ADMIN, Roles::CUSTOMER]);
    Flight::json(Flight::carService() -> getById($id));
});

/**
 * @OA\Post(
 *   path="/car",
 *   summary="Create a new car",
 *   tags={"Car"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Car")
 *   ),
 *   @OA\Response(response=200, description="Car created successfully")
 * )
 */
Flight::route('POST /car', function(){
    Flight::auth_middleware() -> authorizeRole(Roles::ADMIN);
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::carService() -> create($data));
});


/**
 * @OA\Put(
 *   path="/car/{id}",
 *   summary="Update car by ID",
 *   tags={"Car"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Car")
 *   ),
 *   @OA\Response(response=200, description="Car updated successfully")
 * )
 */
Flight::route('PUT /car/@id', function($id){
    Flight::auth_middleware() -> authorizeRole(Roles::ADMIN);
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::carService() -> update($id, $data));
});

/**
 * @OA\Patch(
 *   path="/car/{id}",
 *   summary="Partially update a car",
 *   tags={"Car"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       type="object",
 *       example={
 *         "engine": "3.0L Twin Turbo",
 *         "status": "Completed",
 *         "horsepower": 510
 *       }
 *     )
 *   ),
 *   @OA\Response(response=200, description="Car updated successfully"),
 *   @OA\Response(response=400, description="Invalid input or update failed"),
 *   @OA\Response(response=403, description="Unauthorized access")
 * )
 */
Flight::route('PATCH /car/@id', function($id){
    Flight::auth_middleware() -> authorizeRole(Roles::ADMIN);
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::carService() -> update($id, $data));
});


/**
 * @OA\Delete(
 *   path="/car/{id}",
 *   summary="Delete a car by ID",
 *   tags={"Car"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Car deleted successfully")
 * )
 */
Flight::route('DELETE /car/@id', function($id){
    Flight::auth_middleware() -> authorizeRole(Roles::ADMIN);
    Flight::json(Flight::carService() -> delete($id));
});

/**
 * @OA\Put(
 *   path="/car/rent/{id}",
 *   summary="Mark a car as rented",
 *   tags={"Car"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Car marked as rented"),
 *   @OA\Response(response=400, description="Rental failed")
 * )
 */
Flight::route('PUT /car/rent/@id', function($id){
    Flight::auth_middleware() -> authorizeRole(Roles::ADMIN);
    try {
        Flight::json(Flight::carService() -> rentCar($id));
    } catch (Exception $e) {
        Flight::json(["error" => $e -> getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *   path="/car/return/{id}",
 *   summary="Mark a car as returned",
 *   tags={"Car"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Car marked as returned"),
 *   @OA\Response(response=400, description="Return failed")
 * )
 */
Flight::route('PUT /car/return/@id', function($id){
    Flight::auth_middleware() -> authorizeRole(Roles::ADMIN);
    try {
        Flight::json(Flight::carService() -> returnCar($id));
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});
