<?php

/**
 * @OA\Info(
 *   title="API",
 *   description="Web programming API",
 *   version="1.0",
 *   @OA\Contact(
 *     email="imad.dumanjic@stu.ibu.edu.ba",
 *     name="Web Programming - Project"
 *   )
 * )
 *
 * @OA\Server(
 *     url=http://localhost/project/backend/,
 *     description="Local API server"
 * )
 *
 * @OA\Server(
 *     url=https://luxury-drive-2w37n.ondigitalocean.app/index.php/,
 *     description="Production API server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */