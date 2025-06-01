<?php
    require_once 'BaseDao.php';

    class RentalDao extends BaseDao{
        public function __construct(){
            parent::__construct("rental", "rental_id");
        }

        public function getById($id){
            $stmt = $this-> connection -> prepare("SELECT * FROM rental WHERE rental_id = :id");
            $stmt -> bindParam(':id', $id);
            $stmt -> execute();

            // Used the PDO in fetch() because I needed the result to be as an associative array, because the keys are the names of rows
            return $stmt -> fetch(PDO::FETCH_ASSOC);
        }

        public function deleteByUserId($userId) {
            $stmt = $this -> connection -> prepare("DELETE FROM rental WHERE user_id = :id");
            $stmt -> execute(['id' => $userId]);
        }
    }
?>