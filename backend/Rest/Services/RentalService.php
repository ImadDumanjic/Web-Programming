<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../Dao/RentalDao.php';
require_once __DIR__ . '/../Dao/CarDao.php';
require_once __DIR__ . '/../Dao/BranchCarDao.php';
require_once __DIR__ . '/../Dao/BranchDao.php';

class RentalService extends BaseService {
    private $carDao;
    private $branchCarDao;
    private $branchDao;
    private $paymentDao;

    public function __construct() {
        $dao = new RentalDao();
        parent::__construct($dao);
        $this -> carDao = new CarDao();
        $this -> branchCarDao = new BranchCarDao();
        $this -> branchDao = new BranchDao(); 
        $this -> paymentDao = new PaymentDao(); 
    }

    public function startRent($data) {
        // get branchId by the pickup location from form
        $data['pickup_location'] = trim($data['pickup_location']);
        $branch = $this -> branchDao -> getByLocation($data['pickup_location']);
        if (!$branch || !isset($branch['branch_id'])) {
            throw new Exception("Branch not found for selected location.");
        }

        $branchId = $branch['branch_id'];

        // check if this car exists in that branch
        $exists = $this -> branchCarDao -> exists($branchId, $data['car_id']);
        if (!$exists) {
            throw new Exception("Selected car is not available at the chosen location.");
        }

        // check if the car is generally free
        $car = $this -> carDao -> getById($data['car_id']);
        if (empty($car) || $car['status'] !== 'Available') {
            throw new Exception("Car is already rented!");
        }

        // determine rental status based on the start date
        $currentDate = date('Y-m-d');
        if ($data['start_date'] <= $currentDate) {
            $data['status'] = 'Active';
        } else {
            $data['status'] = 'Scheduled';
        }
        
        // insert rental record
        $rental_id = $this -> dao -> insert($data);

        // update the car status and branch availability
        $this -> carDao-> updateStatus($data['car_id'], 'Rented');
        $this -> branchCarDao-> updateAvailability($data['car_id'], $branchId, 0);

        return $rental_id;
    }


    public function endRent($rental_id){
        //get the rental
        $rental = $this -> dao -> getById($rental_id);

        //check if there isn't rental or if it is completed
        if (empty($rental) || $rental['status'] !== 'Active' && $rental['status'] !== 'Scheduled') {
            throw new Exception("Rental not found or already completed.");
        }

        //we take the car id and pickup location so that we could find the right branch
        $carId = $rental['car_id'];
        $pickupLocation = $rental['pickup_location'];

        //we take the branch by the previous location, from above
        $branch = $this -> branchDao -> getByLocation($pickupLocation);
        
        if (!$branch) {
            throw new Exception("Branch not found for location: " . $pickupLocation);
        }

        //extract the branch_id from previously initialized branch
        $branchId = $branch['branch_id'];

        //do neccessary updated
        $this -> dao -> update($rental_id, ['status' => 'Completed']);
        $this -> carDao -> updateStatus($rental['car_id'], 'Available');
        $this -> branchCarDao-> updateAvailability($carId, $branchId, 1);

        return true;
    }

     public function delete($rental_id) {
        //first, I had to delete the payment, because of the foreign keys in DB. It didn't let me delete the rent first, because of the payment.
        $this -> paymentDao -> deleteByRentalId($rental_id);

        //then call the parent delete, from BaseService on the rental
        parent::delete($rental_id); 
    }
}
