<?php
    require_once 'BaseDao.php';

    class ContactMessageDao extends BaseDao{
        public function __construct(){
            parent::__construct("contact_message");
        }

        public function getAll(){
            $stmt = $this -> connection -> prepare("SELECT * FROM contact_message");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }

        public function getByName($name){
            $stmt = $this -> connection -> prepare("SELECT * FROM contact_message WHERE name = :name");
            $stmt -> bindParam(":name", $name);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }

        public function getByPhone($phone){
            $stmt = $this -> connection -> prepare("SELECT * FROM contact_message WHERE phone = :phone");
            $stmt -> bindParam(":phone", $phone);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }

         public function getByEmail($email){
            $stmt = $this -> connection -> prepare("SELECT * FROM contact_message WHERE email = :email");
            $stmt -> bindParam(":email", $email);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }

        public function saveContact($data){
            $stmt = $this -> connection -> prepare("INSERT INTO contact_message (user_id, name, email, phone, message) VALUES (:user_id, :name, :email, :phone, :message)");
            $stmt -> bindParam(":user_id", $data['user_id']);
            $stmt -> bindParam(":name", $data['name']);
            $stmt -> bindParam(":email", $data['email']);
            $stmt -> bindParam(":phone", $data['phone']);
            $stmt -> bindParam(":message", $data['message']);
            $stmt->execute();
        }
    }
