<?php
    
    chdir(__DIR__); 

    require_once "BranchDao.php";
    require_once "CarDao.php";
    require_once "PaymentDao.php";
    require_once "RentalDao.php";
    require_once "UserDao.php";

    $user_dao = new UserDao();
    $rental_dao = new RentalDao();
    $payment_dao = new PaymentDao();
    $car_dao = new CarDao();
    $branch_dao = new BranchDao();

    // get all users
    // $users = $user_dao->getAll();
    // print_r($users);

    // get user by id
    // $userId = $user_dao->getById(3);
    // print_r($userId);

    // get user by name
    // $user = $user_dao->getByName("Imad Dumanjić");
    // print_r($user);

    //insert user
    // $user_dao->insert([
    //     'name' => 'Aiša Gaab',
    //     'email' => 'aisa.gaab@gmail.com',
    //     'phone' => '111 222 999',
    //     'password' => 'hashed_password26',
    //     'user_type' => 'Admin',
    //     'address' => 'Izeta Sulejmana 123'
    // ]);

    // delete user
    // $user = $user_dao->delete(29);

    // get user by type
    // $user2 = $user_dao->getByUserType("Customer");
    // print_r($user2);

    // get branch by location
    // $branch = $branch_dao->getByLocation("Sarajevo");
    // print_r($branch);

    // delete branch 
    // $branch = $branch_dao->delete(34);

    // get branch by name
    // $branch2 = $branch_dao->getByName("Tuzla Car Rental");
    // print_r($branch2);

    // get all branches
    // $branches = $branch_dao->getAll();
    // print_r($branches);

    // inserting into branches
    // $branch_dao->insert([
    //     'car_id' => 6,
    //     'name' => 'Sarajevo New Rental',
    //     'email' => 'sarajevoNew@gmail.com',
    //     'location' => "Sarajevo",
    //     'contact_number' => '033-555-666',
    //     'opening_hours' => '08:00-18:00'
    // ]);

    // get all payment 
    // $payment = $payment_dao->getAll();
    // print_r($payment);

    // get payment by id
    // $paymentId = $payment_dao->getById(6);
    // print_r($paymentId);

    // get car by brand
    // $car = $car_dao->getByBrand("Audi");
    // print_r($car);

    // get car by year
    // $car_year = $car_dao->getByYear(2020);
    // print_r($car_year);

    // get car by model
    // $car_model = $car_dao->getByModel("SF90");
    // print_r($car_model);

    // get all rentals
    // $rentals = $rental_dao->getAll();
    // print_r($rentals);

    // get rental by id
    // $rentalId = $rental_dao->getById(3);
    // print_r($rentalId);

    // update user data
    // $updateUser = $user_dao->update(4, [
    //     'name' => 'Ermina Dumanjic',
    //     'email' => 'ermina.dumanjic@example.com',
    //     'phone' => '666 222 333',
    //     'password' => 'hashed_password4',
    //     'user_type' => 'Admin',
    //     'address' => '123 Adija ST'
    // ]);    
    // print_r($updateUser);
?>