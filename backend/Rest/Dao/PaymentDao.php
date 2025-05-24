<?php
    require_once 'BaseDao.php';

    class PaymentDao extends BaseDao{
        public function __construct(){
            parent::__construct("payment", "payment_id");
        }

        public function deleteByRentalId($rental_id) {
            $stmt = $this -> connection -> prepare("DELETE FROM payment WHERE rental_id = :rental_id");
            $stmt -> bindParam(':rental_id', $rental_id);
            return $stmt -> execute();
        }
    }
?>