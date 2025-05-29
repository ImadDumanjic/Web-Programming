<?php
require_once 'BaseDao.php';

class BranchCarDao extends BaseDao {
    public function __construct() {
        parent::__construct("branch_car", null); 
    }

    public function checkAvailability($car_id, $branch_id) {
        $stmt = $this -> connection -> prepare("SELECT * FROM branch_car WHERE car_id = :car_id AND branch_id = :branch_id");
        $stmt -> bindParam(":car_id", $car_id);
        $stmt -> bindParam(":branch_id", $branch_id);
        $stmt -> execute();
        return $stmt -> fetch(); 
    }

    public function exists($branchId, $carId){
        $stmt = $this-> connection -> prepare("SELECT 1 FROM branch_car WHERE branch_id = :branchId AND car_id = :carId");
        $stmt -> bindParam(":branchId", $branchId);
        $stmt -> bindParam(":carId", $carId);
        $stmt -> execute();
        
        // I needed to use the fetchColumn, because it fits better in the logic of this function. Because I only needed to know if the car exists or not. I didn't need to know the content of the column, just if it exists.
        return $stmt -> fetchColumn() !== false;
    }

    public function isAvailable($car_id, $branch_id) {
        $stmt = $this->connection -> prepare("SELECT 1 FROM branch_car WHERE car_id = :car_id AND branch_id = :branch_id AND available = 1");
        $stmt -> bindParam(":car_id", $car_id);
        $stmt -> bindParam(":branch_id", $branch_id);
        $stmt -> execute();
        
        //the same logic as above
        return $stmt -> fetchColumn() !== false;
    }

    public function setAvailability($car_id, $branch_id, $status) {
        $stmt = $this -> connection -> prepare("UPDATE branch_car SET available = :status WHERE car_id = :car_id AND branch_id = :branch_id");
        $stmt -> bindParam(":status", $status, PDO::PARAM_BOOL);
        $stmt -> bindParam(":car_id", $car_id);
        $stmt -> bindParam(":branch_id", $branch_id);
        $stmt -> execute();
    }

    public function updateAvailability($carId, $branchId, $availability) {
        $stmt = $this -> connection -> prepare("UPDATE branch_car SET available = :available WHERE car_id = :car_id AND branch_id = :branch_id");
        $stmt -> bindParam(":available", $available);
        $stmt -> bindParam(":car_id", $carId);
        $stmt -> bindParam(":branch_id", $branchId);
        return $stmt -> execute();
    }

}
