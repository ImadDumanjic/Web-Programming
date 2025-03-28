<?php
    require_once 'BaseDao.php';

    class RentalDao extends BaseDao{
        public function __construct(){
            parent::__construct("rental", "rental_id");
        }
    }
?>