<?php
    require_once 'BaseDao.php';

    class AuthDao extends BaseDao{
        public function __construct(){
            parent::__construct("user", "user_id"); 
        }

        public function getUserByEmail($email){
            $stmt = $this -> connection -> prepare("SELECT * FROM user WHERE email = :email");
            $stmt -> bindParam(':email', $email);
            $stmt -> execute();
            return $stmt -> fetch();
        }
    }
?>