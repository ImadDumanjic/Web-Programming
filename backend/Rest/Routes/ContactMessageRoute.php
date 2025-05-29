<?php

/**
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT"
 * )
 */
/**
 * @OA\Get(
 * path="/contacts",
 * summary="Get all contact messages",
 * tags={"Contact Messages"},
 * security={{"bearerAuth":{}}},
 * @OA\Response(response=200, description="List of contact messages")
 * )
 */
Flight::route('GET /contacts', function(){
    Flight::auth_middleware() -> authorizeRoles([Roles::ADMIN, Roles::CUSTOMER]);
    Flight::json(Flight::contactMessageService() -> getAll());
});

/**
 * @OA\Get(
 * path="/contacts/name/{name}",
 * summary="Get contact messages by name",
 * tags={"Contact Messages"},
 * security={{"bearerAuth":{}}},
 * @OA\Parameter(
 * name="name",
 * in="path",
 * required=true,
 * @OA\Schema(type="string")
 * ),
 * @OA\Response(response=200, description="Messages found")
 * )
 */
Flight::route('GET /contacts/name/@name', function($name){
    Flight::auth_middleware() -> authorizeRoles([Roles::ADMIN, Roles::CUSTOMER]);
    Flight::json(Flight::contactMessageService() -> getByName($name));
});

/**
 * @OA\Get(
 * path="/contacts/email/{email}",
 * summary="Get contact messages by email",
 * tags={"Contact Messages"},
 * security={{"bearerAuth":{}}},
 * @OA\Parameter(
 * name="email",
 * in="path",
 * required=true,
 * @OA\Schema(type="string", format="email")
 * ),
 * @OA\Response(response=200, description="Messages found")
 * )
 */
Flight::route('GET /contacts/email/@email', function($email){
    Flight::auth_middleware() -> authorizeRoles([Roles::ADMIN, Roles::CUSTOMER]);
    Flight::json(Flight::contactMessageService() -> getByEmail($email));
});

/**
 * @OA\Get(
 * path="/contacts/phone/{phone}",
 * summary="Get contact messages by phone",
 * tags={"Contact Messages"},
 * security={{"bearerAuth":{}}},
 * @OA\Parameter(
 * name="phone",
 * in="path",
 * required=true,
 * @OA\Schema(type="string")
 * ),
 * @OA\Response(response=200, description="Messages found")
 * )
 */
Flight::route('GET /contacts/phone/@phone', function($phone){
    Flight::auth_middleware() -> authorizeRoles([Roles::ADMIN, Roles::CUSTOMER]);
    Flight::json(Flight::contactMessageService() -> getByPhone($phone));
});

/**
 * @OA\Post(
 * path="/contacts",
 * summary="Create new contact message",
 * tags={"Contact Messages"},
 * security={{"bearerAuth":{}}},
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * required={"name", "email", "phone", "message"},
 * @OA\Property(property="name", type="string"),
 * @OA\Property(property="email", type="string", format="email"),
 * @OA\Property(property="phone", type="string"),
 * @OA\Property(property="message", type="string")
 * )
 * ),
 * @OA\Response(response=200, description="Contact message created")
 * )
 */
Flight::route('POST /contacts', function(){
    Flight::auth_middleware() -> authorizeRoles([Roles::ADMIN, Roles::CUSTOMER]);

    $data = Flight::request() -> data -> getData();
    $user = Flight::get('user');
    $data['user_id'] = $user -> user_id;

    Flight::json(Flight::contactMessageService() -> saveContact($data));
});


/**
 * @OA\Put(
 * path="/contacts/{id}",
 * summary="Update contact message by ID",
 * tags={"Contact Messages"},
 * security={{"bearerAuth":{}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * @OA\Schema(type="integer")
 * ),
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * @OA\Property(property="name", type="string"),
 * @OA\Property(property="email", type="string"),
 * @OA\Property(property="phone", type="string"),
 * @OA\Property(property="message", type="string")
 * )
 * ),
 * @OA\Response(response=200, description="Contact message updated")
 * )
 */
Flight::route('PUT /contacts/@id', function($id){
    Flight::auth_middleware() -> authorizeRole(Roles::ADMIN);
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::contactMessageService() -> update($id, $data));
});

/**
 * @OA\Patch(
 *   path="/contacts/{id}",
 *   summary="Partially update contact message by ID",
 *   tags={"Contact Messages"},
 *   security={{"bearerAuth":{}}},
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
 *         "message": "Updated message content",
 *         "phone": "061123456"
 *       }
 *     )
 *   ),
 *   @OA\Response(response=200, description="Contact message updated"),
 *   @OA\Response(response=400, description="Invalid input or update failed"),
 *   @OA\Response(response=403, description="Unauthorized access")
 * )
 */
Flight::route('PATCH /contacts/@id', function($id){
    Flight::auth_middleware() -> authorizeRole(Roles::ADMIN);
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::contactMessageService() -> update($id, $data));
});


/**
 * @OA\Delete(
 * path="/contacts/{id}",
 * summary="Delete contact message by ID",
 * tags={"Contact Messages"},
 * security={{"bearerAuth":{}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * @OA\Schema(type="integer")
 * ),
 * @OA\Response(response=200, description="Contact message deleted")
 * )
 */
Flight::route('DELETE /contacts/@id', function($id){
    Flight::auth_middleware() -> authorizeRole(Roles::ADMIN);
    Flight::json(Flight::contactMessageService() -> delete($id));
});