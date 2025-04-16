<?php

/**
 * @OA\Schema(
 *   schema="Payment",
 *   required={"rental_id", "user_id", "amount", "payment_date", "payment_method"},
 *   @OA\Property(property="rental_id", type="integer", example=5),
 *   @OA\Property(property="user_id", type="integer", example=2),
 *   @OA\Property(property="amount", type="number", format="float", example=149.99),
 *   @OA\Property(property="payment_date", type="string", format="date", example="2025-04-14"),
 *   @OA\Property(property="payment_method", type="string", example="Credit Card")
 * )
 */


/**
 * @OA\Get(
 *   path="/payment",
 *   summary="Get all payments",
 *   tags={"Payment"},
 *   @OA\Response(response=200, description="List of all payments")
 * )
 */
Flight::route('GET /payment', function(){
    Flight::json(Flight::paymentService() -> getAll());
});

/**
 * @OA\Get(
 *   path="/payment/{id}",
 *   summary="Get payment by ID",
 *   tags={"Payment"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Payment found"),
 *   @OA\Response(response=404, description="Payment not found")
 * )
 */
Flight::route('GET /payment/@id', function($id){
    Flight::json(Flight::paymentService() -> getById($id));
});

/**
 * @OA\Post(
 *   path="/payment",
 *   summary="Create a new payment",
 *   tags={"Payment"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Payment")
 *   ),
 *   @OA\Response(response=200, description="Payment created successfully")
 * )
 */
Flight::route('POST /payment', function(){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::paymentService() -> create($data));
});

/**
 * @OA\Put(
 *   path="/payment/{id}",
 *   summary="Update payment by ID",
 *   tags={"Payment"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Payment")
 *   ),
 *   @OA\Response(response=200, description="Payment updated successfully")
 * )
 */
Flight::route('PUT /payment/@id', function($id){
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::paymentService() -> update($id, $data));
});

/**
 * @OA\Delete(
 *   path="/payment/{id}",
 *   summary="Delete a payment by ID",
 *   tags={"Payment"},
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(type="integer")
 *   ),
 *   @OA\Response(response=200, description="Payment deleted successfully")
 * )
 */
Flight::route('DELETE /payment/@id', function($id){
    Flight::json(Flight::paymentService() -> delete($id));
});

/**
 * @OA\Post(
 *   path="/payment/process",
 *   summary="Process a payment",
 *   tags={"Payment"},
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Payment")
 *   ),
 *   @OA\Response(response=200, description="Payment processed successfully"),
 *   @OA\Response(response=400, description="Failed to process payment")
 * )
 */
Flight::route('POST /payment/process', function(){
    $data = Flight::request() -> data -> getData();

    try{
        Flight::json(Flight::paymentService() -> processPayment($data));
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    }
});
