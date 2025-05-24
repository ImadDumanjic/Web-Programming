<?php
    require_once 'BaseService.php';
    require_once __DIR__ . '/../Dao/UserDao.php';

    class UserService extends BaseService{
        public function __construct(){
            $dao = new UserDao();
            parent::__construct($dao);
        }

        public function getByName($name){
            return $this -> dao -> getByName($name); 
        }

        public function getByUserType($user_type){
            return $this -> dao -> getByUserType($user_type);
        }

        public function registerUser($data){
            $existing_user = $this -> dao -> getByEmail($data['email']);
        
            if ($existing_user) {
                throw new Exception("The email is already taken, please consider a new one.");
            }
        
            if (strlen($data['password']) < 6) {
                throw new Exception("Password must be at least 6 characters long.");
            }
        
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        
            return $this -> dao -> insert($data);
        }
        

        public function login($email, $password){
            $user = $this -> dao-> getByEmail($email);
        
            if (!$user || !password_verify($password, $user['password'])) {
                throw new Exception("Invalid email or password.");
            }
            return $user;
        }
    }
?>