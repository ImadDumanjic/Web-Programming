<?php
    require_once 'BaseService.php';
    require_once 'CarDao.php';

    class CarService extends BaseService{
        public function __construct(){
            $dao = new CarDao();
            parent::_construct($dao);
        }

        public function getByModel($model){
            return $this -> dao -> getByModel($model);
        }

        public function getByBrand($brand){
            return $this -> dao -> getByBrand($brand);
        }

        public function getByYear($year){
            return $this -> dao -> getByYear($year);
        }

        public function rentCar($car_id){
            $car = $this -> dao -> getById($car_id);

            if(empty($car)){
                throw new Exception("Car not found.");
            }

            if($car['status'] !== 'Available'){
                throw new Exception("Car is currently not available, as it has been already rented!");
            }

            return $this->dao->updateStatus($car_id, 'Rented');
        }

        public function returnCar($car_id){
            $car = $this->dao->getById($car_id);
        
            if (empty($car)) {
                throw new Exception("Car not found.");
            }
        
            if ($car['status'] === 'Available') {
                throw new Exception("Car is already available for rent.");
            }
        
            return $this->dao->updateStatus($car_id, 'Available');
        }
    }
?>