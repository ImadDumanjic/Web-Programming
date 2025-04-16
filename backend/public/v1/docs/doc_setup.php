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
 *     url=LOCALSERVER,
 *     description="Local API server"
 * )
 *
 * @OA\Server(
 *     url=PRODSERVER,
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