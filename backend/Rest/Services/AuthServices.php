<?php
    require_once 'BaseService.php';
    require_once __DIR__ . '/../dao/AuthDao.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    
    class AuthService extends BaseService {
       private $auth_dao;

       public function __construct() {
            $this -> auth_dao = new AuthDao();
            parent::__construct($this -> auth_dao);        
       }
    
       public function getUserByEmail($email){
           return $this -> auth_dao -> getUserByEmail($email);
       }
    
        public function register($entity){

            if (empty($entity['email'])) {
                return ['success' => false, 'error' => 'Email is required.'];
            }

            if (empty($entity['password'])) {
                return ['success' => false, 'error' => 'Password is required.'];
            }

            if (strlen($entity['password']) < 6) {
                return ['success' => false, 'error' => 'Password must be at least 6 characters long.'];
            }

            if (empty($entity['name'])) {
                return ['success' => false, 'error' => 'Name is required.'];
            }

            if (empty($entity['phone'])) {
                $entity['phone'] = null; 
            }

            if (empty($entity['address'])) {
                $entity['address'] = null;
            }

            if (empty($entity['user_type'])) {
                $entity['user_type'] = 'Customer';
            }

            //check to see if the email already exists
            $existing_email = $this -> auth_dao -> getUserByEmail($entity['email']);
            if ($existing_email) {
                return ['success' => false, 'error' => 'Email already registered.'];
            }

            $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);
          
            $inserted_id = $this -> auth_dao -> insert($entity); // create the user in DB, insert the data in db

            if (!$inserted_id) {
                return ['success' => false, 'error' => 'Database insert failed.'];
            }

            $created_user = $this -> auth_dao -> getById($inserted_id); // and then "take" the user by the previously created id

            if (!$created_user) {
                Flight::halt(500, "Newly insertedId is returned ($inserted_id), but no user found in database.");
            }

            unset($created_user['password']);

            return ['success' => true, 'data' => $created_user];
        }

    
       public function login($data){
       
            if(empty($data['email'])){
                return ['success' => false, 'error' => 'Email is a required field!'];
            }

            if(empty($data['password'])){
                return ['success' => false, 'error' => 'Password is a required field!'];
            }

            $user = $this -> auth_dao -> getUserByEmail($data['email']);

            if(!$user || !password_verify($data['password'], $user['password'])){
                return ['success' => false, 'error' => 'Invalid email or password!'];
            }

            unset($user['password']);

            $jwt_payload = [
                'user' => $user,
                'iat' => time(),
                'exp' => time() + (60 * 60 * 24)
            ];

            $token = JWT::encode($jwt_payload, Config::JWT_SECRET(), 'HS256');
            return ['success' => true, 'data' => array_merge($user, ['token' => $token])];
       }
}
?>
