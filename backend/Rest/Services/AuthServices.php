<?php
    require_once 'BaseService.php';
    require_once __DIR__ . '/../dao/AuthDao.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    
    class AuthService extends BaseService {
       private $auth_dao;

       public function __construct() {
            $this->auth_dao = new AuthDao();
            parent::__construct($this->auth_dao);        
       }
    
       public function getUserByEmail($email){
           return $this->auth_dao->getUserByEmail($email);
       }
    
       public function register($entity) {
            if (empty($entity['email']) || empty($entity['password'])) {
                return ['success' => false, 'error' => 'Email and password are required.'];
            }
    
        $email_exists = $this->auth_dao->getUserByEmail($entity['email']);
            if ($email_exists) {
                return ['success' => false, 'error' => 'Email already registered.'];
            }
    
        $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);
    
        $inserted_id = parent::create($entity);
        $created_user = $this->auth_dao->getById($inserted_id);
    
        unset($created_user['password']);
    
        return ['success' => true, 'data' => $created_user];
    }
    
    
    
       public function login($entity) {  
           if (empty($entity['email']) || empty($entity['password'])) {
               return ['success' => false, 'error' => 'Email and password are required.'];
           }
    
           $user = $this->auth_dao->getUserByEmail($entity['email']);

           if(!$user){
               return ['success' => false, 'error' => 'Invalid username or password.'];
           }
    
           if(!$user || !password_verify($entity['password'], $user['password'])){
               return ['success' => false, 'error' => 'Invalid username or password.'];
           }

           unset($user['password']);
          
           $jwt_payload = [
               'user' => $user,
               'iat' => time(),
               'exp' => time() + (60 * 60 * 24) 
           ];
    
           $token = JWT::encode(
               $jwt_payload,
               Config::JWT_SECRET(), 'HS256'
           );
    
           return ['success' => true, 'data' => array_merge($user, ['token' => $token])];             
       }    
}
?>
