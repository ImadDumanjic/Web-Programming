<?php
    require_once 'BaseDao.php';

    class UserDao extends BaseDao{
        public function __construct(){
            parent::__construct("user", "user_id");
        }

        public function getByName($name){
            $stmt = $this->connection->prepare("SELECT * FROM user WHERE name = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getByUserType($user_type){
            $stmt = $this->connection->prepare("SELECT * FROM user WHERE user_type = :user_type");
            $stmt->bindParam(':user_type', $user_type);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>