<?php
    require_once 'BaseService.php';
    require_once 'BranchDao.php';

    class BranchService extends BaseService{
        public function __construct(){
            $dao = new BranchDao();
            parent::__construct($dao);
        }

        public function getByName($name){
            return $this -> dao -> getByName($name);
        }

        public function getByLocation($location){
            return $this -> dao -> getByLocation($location);
        }
    }
?>