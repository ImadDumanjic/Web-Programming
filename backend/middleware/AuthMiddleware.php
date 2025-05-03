<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

    class AuthMiddleware{

        public function verifyToken($token){

            if(!$token){
                Flight::halt(401, "Missing the authentication header!");
            }

            $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));

            Flight::set('user', $decoded_token -> user);
            Flight::set('jwt_token', $token);
            return true;
        }

        public function authorizeRole($requiredRole){
            $user = Flight::get('user');
            if($user -> user_type !== $requiredRole){
                Flight::halt(403, 'Access denied. You do not have permission to access this resource!');
            }
        }

        public function authorizeRoles($roles) {
            $user = Flight::get('user');
            if (!in_array($user -> user_type, $roles)) {
                Flight::halt(403, 'Forbidden: role is not allowed!');
            }
        } 
}
