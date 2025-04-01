<?php
    require_once 'BaseDao.php';

    class CarDao extends BaseDao{
        public function __construct(){
            parent::__construct("car", "car_id");
        }

        public function getByModel($model){
            $stmt = $this->connection->prepare("SELECT * FROM car WHERE model = :model");
            $stmt->bindParam(':model', $model);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getByBrand($brand){
            $stmt = $this->connection->prepare("SELECT * FROM car WHERE brand = :brand");
            $stmt->bindParam(':brand', $brand);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getByYear($year){
            $stmt = $this->connection->prepare("SELECT * FROM car WHERE year = :year");
            $stmt->bindParam(':year', $year);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>