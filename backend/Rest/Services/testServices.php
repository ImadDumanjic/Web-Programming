// require_once __DIR__ . '/BranchService.php';
// require_once __DIR__ . '/CarService.php';
// require_once __DIR__ . '/UserService.php';
// require_once __DIR__ . '/RentalService.php';
// require_once __DIR__ . '/PaymentService.php';

// echo "<pre>";

// try {
    // $branchService = new BranchService();

    // echo "🔍 Testing BranchService...\n\n";

    // // Test 1: Get all branches
    // $allBranches = $branchService->getAll();
    // echo "✅ All branches:\n";
    // print_r($allBranches);

    // // Test 2: Get by name (change this to match a real name from DB)
    // $nameToTest = 'Sarajevo Rent'; // <-- PROMIJENI ako treba
    // $branchByName = $branchService->getByName($nameToTest);
    // echo "\n✅ Branch with name '$nameToTest':\n";
    // print_r($branchByName);

    // // Test 3: Get by location (change this to match real location)
    // $locationToTest = 'Mostar'; // <-- PROMIJENI ako treba
    // $branchByLocation = $branchService->getByLocation($locationToTest);
    // echo "\n✅ Branch with location '$locationToTest':\n";
    // print_r($branchByLocation); -->

    // $carService = new CarService();

    // echo "🔧 Testing CarService...\n\n";

    // // 1. Get all cars of a specific brand
    // $brand = 'Audi';
    // $carsByBrand = $carService->getByBrand($brand);
    // echo "✅ Cars by brand '$brand':\n";
    // print_r($carsByBrand);

    // // 2. Get available cars of a specific brand
    // $availableCars = $carService->getAvailableByBrand($brand);
    // echo "\n✅ Available cars by brand '$brand':\n";
    // print_r($availableCars);

    // // 3. Get cars by model
    // $model = 'Q7'; // promijeni u nešto što postoji u tvojoj bazi
    // $carsByModel = $carService->getByModel($model);
    // echo "\n✅ Cars by model '$model':\n";
    // print_r($carsByModel);

    // // 4. Get cars by year
    // $year = 2020;
    // $carsByYear = $carService->getByYear($year);
    // echo "\n✅ Cars by year '$year':\n";
    // print_r($carsByYear);

    // // 5. Test renting and returning a car
    // $carToRent = null;

    // foreach ($availableCars as $car) {
    //     if ($car['status'] === 'Available') {
    //         $carToRent = $car;
    //         break;
    //     }
    // }

    // if ($carToRent) {
    //     $carId = $carToRent['car_id'];

    //     try {
    //         $carService->rentCar($carId);
    //         echo "\n🚗 Car with ID $carId rented successfully.\n";

    //         $carService->returnCar($carId);
    //         echo "🔁 Car with ID $carId returned successfully.\n";
    //     } catch (Exception $e) {
    //         echo "❌ Error during rent/return: " . $e->getMessage() . "\n";
    //     }
    // } else {
    //     echo "⚠️ No available cars to test rent/return.\n";
    // }

    // $paymentService = new PaymentService();

    // echo "💳 Testing PaymentService...\n\n";

    // // Test 1: Valid payment
    // $paymentData = [
    //     'rental_id' => 2,
    //     'user_id' => 3,
    //     'amount' => 239.95,
    //     'payment_date' => date('Y-m-d'),
    //     'payment_method' => 'PayPal'
    // ];

    // $result = $paymentService->processPayment($paymentData);
    // echo "✅ Payment processed successfully:\n";
    // print_r($result);

    // // Test 2: Invalid amount
    // try {
    //     $paymentService->processPayment([
    //         'rental_id' => 1,
    //         'user_id' => 1,
    //         'amount' => 0,
    //         'payment_date' => date('Y-m-d'),
    //         'payment_method' => 'Card'
    //     ]);
    // } catch (Exception $e) {
    //     echo "\n❌ Expected error (zero amount): " . $e->getMessage() . "\n";
    // }

    // // Test 3: Invalid payment method
    // try {
    //     $paymentService->processPayment([
    //         'user_id' => 1,
    //         'rental_id' => 1,
    //         'amount' => 100,
    //         'payment_method' => 'bitcoin',
    //         'payment_date' => date('Y-m-d')
    //     ]);
    // } catch (Exception $e) {
    //     echo "\n❌ Expected error (invalid method): " . $e->getMessage() . "\n";
    // }

    // $rentalService = new RentalService();
    // $carService = new CarService();

    // echo "📦 Testing RentalService with full data...\n\n";

    // // 1. Pronađi slobodan auto
    // $availableCars = $carService->getAvailableByBrand('Aston Martin'); // promijeni brend ako treba
    // $car = $availableCars[0] ?? null;

    // if (!$car) {
    //     echo "⚠️ No available cars found.\n";
    //     exit;
    // }

    // $carId = $car['car_id']; // provjeri da li je 'car_id' u bazi
    // $userId = 1; // Postavi ID korisnika koji postoji u bazi

    // // 2. Definiši datume i cijenu
    // $startDate = date('Y-m-d');
    // $endDate = date('Y-m-d', strtotime('+3 days'));

    // $days = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
    // $pricePerDay = 100; // možeš mijenjati
    // $totalPrice = $days * $pricePerDay;

    // // 3. Pripremi podatke
    // $rentalData = [
    //     'user_id' => $userId,
    //     'car_id' => $carId,
    //     'start_date' => $startDate,
    //     'end_date' => $endDate,
    //     'total_price' => $totalPrice
    // ];

    // // 4. Start rent
    // try {
    //     $rental_id = $rentalService->startRent($rentalData);
    //     echo "✅ Rental started successfully. Rental ID: $rental_id\n";
    // } catch (Exception $e) {
    //     echo "❌ Error starting rental: " . $e->getMessage() . "\n";
    //     exit;
    // }

    // // 5. End rent
    // try {
    //     $success = $rentalService->endRent($rental_id);
    //     if ($success) {
    //         echo "✅ Rental with ID $rental_id ended successfully.\n";
    //     }
    // } catch (Exception $e) {
    //     echo "❌ Error ending rental: " . $e->getMessage() . "\n";
    // }

    // $userService = new UserService();

    // echo "👤 Testing UserService...\n\n";

    // // 1. Registracija korisnika
    // $newUser = [
    //     'name' => 'Test User',
    //     'email' => 'test.user@example.com',
    //     'phone' => '061123456',
    //     'password' => password_hash('test123', PASSWORD_DEFAULT),
    //     'user_type' => 'Customer',
    //     'address' => '123 Test Street'
    // ];

    // try {
    //     $result = $userService->registerUser($newUser);
    //     echo "✅ User registered successfully:\n";
    //     print_r($result);
    // } catch (Exception $e) {
    //     echo "⚠️ Registration skipped: " . $e->getMessage() . "\n";
    // }

    // // 2. Login sa test korisnikom
    // try {
    //     $loggedIn = $userService->login('test.user@example.com', 'test123');
    //     echo "✅ Login successful:\n";
    //     print_r($loggedIn);
    // } catch (Exception $e) {
    //     echo "❌ Login failed: " . $e->getMessage() . "\n";
    // }

    // // 3. Dohvati korisnike po imenu
    // $nameSearch = 'Imad Dumanjic'; // ili 'Test' ako si registrovao Test User
    // $usersByName = $userService->getByName($nameSearch);
    // echo "\n🔍 Users with name like '$nameSearch':\n";
    // print_r($usersByName);

    // // 4. Dohvati sve korisnike tipa 'Customer'
    // $customers = $userService->getByUserType('Customer');
    // echo "\n📋 Customers:\n";
    // print_r($customers);

    
// } catch (Exception $e) {
//     echo "❌ General Error: " . $e->getMessage() . "\n";
// }

// echo "</pre>";
