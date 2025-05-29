<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * @OA\Post(
 *     path="/auth/register",
 *     summary="Register new user.",
 *     description="Add a new user to the database.",
 *     tags={"auth"},
 *     @OA\RequestBody(
 *         description="Add new user",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"password", "email"},
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
 *                     example="some_password",
 *                     description="User password"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     example="demo@gmail.com",
 *                     description="User email"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User has been added."
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request."
 *     )
 * )
 */
Flight::route("POST /auth/register", function () {
    $data = Flight::request() -> data -> getData();
    $response = Flight::auth_service() -> register($data);

    if ($response['success']) {
        Flight::json([
            'message' => 'User registered successfully',
            'data' => $response['data']
        ]);
    } else {
        Flight::halt(400, $response['error']);
    }
});

/**
 * @OA\Post(
 *      path="/auth/login",
 *      tags={"auth"},
 *      summary="Login to system using email and password",
 *      @OA\RequestBody(
 *          description="Credentials",
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email","password"},
 *              @OA\Property(property="email", type="string", example="demo@gmail.com", description="User email address"),
 *              @OA\Property(property="password", type="string", example="some_password", description="User password")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Student data and JWT"
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request."
 *      )
 * )
 */
Flight::route('POST /auth/login', function() {
    $data = Flight::request() -> data -> getData();
    $response = Flight::auth_service() -> login($data);

    if ($response['success']) {
        Flight::json([
            'message' => 'User logged in successfully',
            'data' => $response['data']
        ]);
    } else {
        Flight::halt(400, $response['error']);
    }
});
?>
