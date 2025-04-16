<?php

/**
 * @OA\Schema(
 *   schema="Rental",
 *   required={"user_id", "car_id", "start_date", "status"},
 *   @OA\Property(property="user_id", type="integer", example=2),
 *   @OA\Property(property="car_id", type="integer", example=3),
 *   @OA\Property(property="start_date", type="string", format="date", example="2025-04-14"),
 *   @OA\Property(property="end_date", type="string", format="date", example="2025-04-18"),
 *   @OA\Property(property="total_price", type="number", format="float", example=299.99),
 *   @OA\Property(property="status", type="string", example="active")
 * )
 */

/**
 * @OA\Get(
 *   path="/rent",
 *   summary="Get all rental records",
 *   tags={"Rent"},
 *   @OA\Response(response=200, description="List of all rentals")
 * )
 */
Flight::route('GET /rent', function(){
    Flight::json(Flight::rentalService() -> getAll());
});

/**
 * @OA\Get(
 *   path="/rent/{id}",
 *   summary="Get rental by ID",
 *   tags={"Rent"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Rental found"),
 *   @OA\Response(response=404, description="Rental not found")
 * )
 */
Flight::route('GET /rent/@id', function($id){
    Flight::json(Flight::rentalService() -> getById($id));
});

/**
 * @OA\Post(
 *   path="/rent/create",
 *   summary="Create a new rental",
 *   tags={"Rent"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Rental")
 *   ),
 *   @OA\Response(response=200, description="Rental created successfully")
 * )
 */
Flight::route('POST /rent/create', function(){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::rentalService() -> create($data));
});

/**
 * @OA\Put(
 *   path="/rent/{id}",
 *   summary="Update rental by ID",
 *   tags={"Rent"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Rental")
 *   ),
 *   @OA\Response(response=200, description="Rental updated successfully")
 * )
 */
Flight::route('PUT /rent/@id', function($id){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::rentalService() -> update($id, $data));
});

/**
 * @OA\Delete(
 *   path="/rent/{id}",
 *   summary="Delete rental by ID",
 *   tags={"Rent"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Rental deleted")
 * )
 */
Flight::route('DELETE /rent/@id', function($id){
    Flight::json(Flight::rentalService() -> delete($id));
});

/**
 * @OA\Post(
 *   path="/rent",
 *   summary="Start a rental",
 *   tags={"Rent"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Rental")
 *   ),
 *   @OA\Response(response=200, description="Rental started successfully"),
 *   @OA\Response(response=400, description="Bad request")
 * )
 */
Flight::route('POST /rent', function(){
    $data = Flight::request()->data->getData();

    try{
        $rentalId = Flight::rentalService()->startRent($data);
        Flight::json(["message" => "Rental started successfully!", "rental_id" => $rentalId]);
    }catch (Exception $e){
        Flight::json(["error" => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *   path="/rent/end/{id}",
 *   summary="End a rental",
 *   tags={"Rent"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Rental ended successfully"),
 *   @OA\Response(response=400, description="Bad request")
 * )
 */
Flight::route('PUT /rent/end/@id', function($id){
    try {
        Flight::rentalService() -> endRent($id);
        Flight::json(["message" => "Rental ended successfully."]);
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});
