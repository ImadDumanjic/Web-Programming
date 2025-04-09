<?php
    require_once 'BaseService.php';
    require_once __DIR__ . '/../Dao/RentalDao.php';
    require_once __DIR__ . '/../Dao/CarDao.php';

    class RentalService extends BaseService{
        public function __construct(){
            $dao = new RentalDao();
            parent::__construct($dao);
            $this -> carDao = new CarDao();
        }

        public function startRent($data){
            if(strtotime($data['start_date']) > strtotime($data['end_date'])){
                throw new Exception("Chose carefully the date. Start date must be before the end date!");
            }

            $car = $this -> carDao -> getById($data['car_id']);

            if(empty($car) || $car['status'] !== 'Available'){
                throw new Exception("Car is already rented!");
            }

            $data['status'] = 'Active';
            $rental_id = $this -> dao -> insert($data);
            $this->carDao->updateStatus($data['car_id'], 'Rented');

            return $rental_id;
        }

        public function endRent($rental_id){
            $rental = $this -> dao -> getById($rental_id);

            if(empty($rental) || $rental['status'] !== 'Active'){
                throw new Exception("Rental is not found, or it has already been completed");
            }

            $this -> dao -> update($rental_id, ['status' => 'Completed']);
            $this -> carDao -> updateStatus($rental['car_id'], 'Available');

            return true;
        }
    }
?>