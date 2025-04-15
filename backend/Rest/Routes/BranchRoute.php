<?php

/**
 * @OA\Schema(
 *   schema="Branch",
 *   required={"car_id", "name", "email", "location", "contact_number", "opening_hours"},
 *   @OA\Property(property="car_id", type="integer", example=3),
 *   @OA\Property(property="name", type="string", example="Downtown Office"),
 *   @OA\Property(property="email", type="string", example="branch@example.com"),
 *   @OA\Property(property="location", type="string", example="Main Street 45"),
 *   @OA\Property(property="contact_number", type="string", example="+38762123456"),
 *   @OA\Property(property="opening_hours", type="string", example="08:00 - 17:00")
 * )
 */

/**
 * @OA\Get(
 *   path="/branch",
 *   summary="Get all branches or filter by name/location",
 *   tags={"Branch"},
 *   @OA\Parameter(
 *     name="name",
 *     in="query",
 *     description="Filter branches by name",
 *     required=false,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *     name="location",
 *     in="query",
 *     description="Filter branches by location",
 *     required=false,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Response(response=200, description="List of branches")
 * )
 */
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

/**
 * @OA\Get(
 *   path="/branch/{id}",
 *   summary="Get branch by ID",
 *   tags={"Branch"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Branch found"),
 *   @OA\Response(response=404, description="Branch not found")
 * )
 */
Flight::route('GET /branch/@id', function($id){
    Flight::json(Flight::branchService() -> getById($id));
});

/**
 * @OA\Post(
 *   path="/branch",
 *   summary="Create a new branch",
 *   tags={"Branch"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Branch")
 *   ),
 *   @OA\Response(response=200, description="Branch created successfully")
 * )
 */
Flight::route('POST /branch', function(){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::branchService() -> create($data));
});

/**
 * @OA\Put(
 *   path="/branch/{id}",
 *   summary="Update branch by ID",
 *   tags={"Branch"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Branch")
 *   ),
 *   @OA\Response(response=200, description="Branch updated successfully")
 * )
 */
Flight::route('PUT /branch/@id', function($id){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::branchService() -> update($id, $data));
});

/**
 * @OA\Delete(
 *   path="/branch/{id}",
 *   summary="Delete a branch by ID",
 *   tags={"Branch"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Branch deleted successfully")
 * )
 */
Flight::route('DELETE /branch/@id', function($id){
    Flight::json(Flight::branchService() -> delete($id));
});
