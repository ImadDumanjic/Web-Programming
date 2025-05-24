<?php
    require_once 'BaseService.php';
    require_once __DIR__ . '/../Dao/ContactMessageDao.php';

    class ContactMessageService extends BaseService{
        public function __construct(){
            $dao = new ContactMessageDao();
            parent::__construct($dao);
        }

        public function saveContact($data){
            $this -> dao -> saveContact($data);
        }

        public function getAll(){
            return $this -> dao -> getAll();
        }

        public function getByName($name){
            return $this -> dao -> getByName($name);
        }

        public function getByEmail($email){
            return $this -> dao -> getByEmail($email);
        }

        public function getByPhone($phone){
            return $this -> dao -> getByPhone($phone);
        }
    }