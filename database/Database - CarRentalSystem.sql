CREATE DATABASE CarRentalSystem;
USE CarRentalSystem;

CREATE TABLE user (
    user_id INT not null AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('Admin', 'Customer') NOT NULL,
    address VARCHAR(255)
);

CREATE TABLE car (
    car_id INT not null AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    year VARCHAR(20)   NOT NULL,
    rental_price_per_day double NOT NULL,
    engine VARCHAR(50) NOT NULL,
    horsepower INT NOT NULL,
    torque INT NOT NULL,
    acceleration VARCHAR(20) NOT NULL,
    top_speed INT NOT NULL,
    transmission VARCHAR(100) NOT NULL,
    status ENUM('Available', 'Rented') NOT NULL
);

CREATE TABLE rental (
    rental_id INT not null AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('Active', 'Completed', 'Canceled') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (car_id) REFERENCES car(car_id)
);

create table payment(
	payment_id INT not null auto_increment primary key,
	rental_id INT not null,
	user_id INT not null,
	amount DECIMAL(10,2) not null,
	payment_date DATETIME not null,
	payment_method ENUM('Card', 'PayPal', 'Cash') not null,
	FOREIGN KEY (rental_id) REFERENCES rental(rental_id),
	FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE branch(
	branch_id INT not null auto_increment primary key,
	car_id INT not null,
	name VARCHAR(50) not null,
	email VARCHAR(100) NOT NULL,
	location ENUM('Sarajevo', 'Mostar', 'Tuzla') not null,
	contact_number VARCHAR(20) not null,
	opening_hours VARCHAR(50) not null,
	FOREIGN KEY (car_id) REFERENCES car(car_id)
);

INSERT INTO user (user_id, name, email, phone, password, user_type, address) VALUES 
(1, 'Imad Dumanjić', 'imad.dumanjic@example.com', '123456789', 'hashed_password1', 'Admin', '123 Admin St'),
(2, 'Jane Smith', 'jane.smith@example.com', '987654321', 'hashed_password2', 'Customer', '456 Oak St'),
(3, 'Mark Johnson', 'mark.johnson@example.com', '555123456', 'hashed_password3', 'Customer', '789 Pine St'),
(4, 'Emily Davis', 'emily.davis@example.com', '444987654', 'hashed_password4', 'Customer', '321 Elm St'),
(5, 'Michael Brown', 'michael.brown@example.com', '333555777', 'hashed_password5', 'Customer', '741 Cedar St'),
(6, 'Emma Wilson', 'emma.wilson@example.com', '777888999', 'hashed_password6', 'Customer', '852 Birch St'),
(7, 'Oliver Taylor', 'oliver.taylor@example.com', '666222111', 'hashed_password7', 'Customer', '963 Maple St'),
(8, 'Sophia Martinez', 'sophia.martinez@example.com', '111222333', 'hashed_password8', 'Customer', '147 Spruce St'),
(9, 'William Anderson', 'william.anderson@example.com', '888999000', 'hashed_password9', 'Customer', '258 Redwood St'),
(10, 'Isabella Thomas', 'isabella.thomas@example.com', '222444666', 'hashed_password10', 'Customer', '369 Cherry St'),
(11, 'Lucas White', 'lucas.white@example.com', '333777999', 'hashed_password11', 'Customer', '753 Oakwood St'),
(12, 'Mia Harris', 'mia.harris@example.com', '444666888', 'hashed_password12', 'Customer', '852 Willow St'),
(13, 'Benjamin Clark', 'benjamin.clark@example.com', '555111222', 'hashed_password13', 'Customer', '951 Pinewood St'),
(14, 'Charlotte Lewis', 'charlotte.lewis@example.com', '666333777', 'hashed_password14', 'Customer', '159 Birchwood St'),
(15, 'James Walker', 'james.walker@example.com', '777555111', 'hashed_password15', 'Customer', '753 Cedarwood St'),
(16, 'Amelia Hall', 'amelia.hall@example.com', '888666444', 'hashed_password16', 'Customer', '258 Fir St'),
(17, 'Ethan Allen', 'ethan.allen@example.com', '999222555', 'hashed_password17', 'Customer', '159 Redwood Ave'),
(18, 'Ava Young', 'ava.young@example.com', '111444777', 'hashed_password18', 'Customer', '357 Maple Ave'),
(19, 'Daniel King', 'daniel.king@example.com', '222555888', 'hashed_password19', 'Customer', '654 Willow Ave'),
(20, 'Harper Scott', 'harper.scott@example.com', '333666999', 'hashed_password20', 'Customer', '951 Elmwood St'),
(21, 'Henry Green', 'henry.green@example.com', '444777000', 'hashed_password21', 'Customer', '753 Oak Ave'),
(22, 'Evelyn Adams', 'evelyn.adams@example.com', '555888111', 'hashed_password22', 'Customer', '852 Cedar Ave'),
(23, 'Alexander Baker', 'alexander.baker@example.com', '666999222', 'hashed_password23', 'Customer', '159 Pine Ave'),
(24, 'Scarlett Nelson', 'scarlett.nelson@example.com', '777000333', 'hashed_password24', 'Customer', '357 Spruce Ave'),
(25, 'David Carter', 'david.carter@example.com', '888111444', 'hashed_password25', 'Customer', '654 Cherry Ave');

INSERT INTO car (brand, model, year, rental_price_per_day, engine, horsepower, torque, acceleration, top_speed, transmission, status) VALUES
('Ferrari', 'SF90', 2020, 400, '4.0L V8 Hybrid', 986, 800, '0-100 km/h in 2.5s', 340, '8-speed dual-clutch automatic', 'Available'),
('Audi', 'e-Tron GT', 2021, 250, 'Dual electric motors', 590, 830, '0-100 km/h in 3.3s', 250, '2-speed automatic', 'Available'),
('Porsche', '911', 2024, 300, '3.0L Twin-Turbo Flat-6', 473, 570, '0-100 km/h in 3.2s', 310, '8-speed PDK automatic', 'Rented'),
('Audi', 'Q7', 2024, 75, '3.0L V6 Turbo', 335, 500, '0-100 km/h in 5.7s', 250, '8-speed automatic', 'Available'),
('Bentley', 'Continental GT', 2022, 450, '6.0L W12 Twin-Turbo', 626, 900, '0-100 km/h in 3.6s', 333, '8-speed dual-clutch automatic', 'Rented'),
('Mercedes', 'AMG GT63', 2025, 320, '4.0L Twin-Turbo V8', 630, 900, '0-100 km/h in 3.2s', 315, '9-speed automatic', 'Available'),
('BMW', 'M5 Competition', 2023, 300, '4.4L Twin-Turbo V8', 617, 750, '0-100 km/h in 3.3s', 305, '8-speed automatic', 'Available'),
('Audi', 'A8', 2019, 200, '3.0L V6 Turbo', 335, 500, '0-100 km/h in 5.6s', 250, '8-speed automatic', 'Rented'),
('Range Rover', 'Sport', 2020, 220, '5.0L Supercharged V8', 518, 625, '0-100 km/h in 4.3s', 250, '8-speed automatic', 'Available'),
('Audi', 'R8', 2018, 275, '5.2L V10', 562, 560, '0-100 km/h in 3.4s', 330, '7-speed dual-clutch automatic', 'Available'),
('BMW', 'M8 Competition', 2019, 195, '4.4L Twin-Turbo V8', 617, 750, '0-100 km/h in 3.2s', 305, '8-speed automatic', 'Available'),
('Bentley', 'Bentayga', 2017, 400, '6.0L W12 Twin-Turbo', 600, 900, '0-100 km/h in 4.0s', 306, '8-speed automatic', 'Available'),
('Porsche', 'GT3 RS', 2025, 335, '4.0L Naturally Aspirated Flat-6', 518, 470, '0-100 km/h in 3.2s', 310, '7-speed PDK automatic', 'Rented'),
('Lamborghini', 'Huracan', 2015, 215, '5.2L V10', 631, 600, '0-100 km/h in 2.9s', 325, '7-speed dual-clutch automatic', 'Available'),
('Aston Martin', 'Vantage', 2016, 175, '4.0L Twin-Turbo V8', 503, 685, '0-100 km/h in 3.6s', 314, '8-speed automatic', 'Rented');

INSERT INTO rental (rental_id, user_id, car_id, start_date, end_date, total_price, status) 
VALUES 
(1, 2, 5, '2025-03-01', '2025-03-05', 90.00 * 4, 'Completed'),
(2, 3, 8, '2025-02-15', '2025-02-20', 47.99 * 5, 'Completed'),
(3, 4, 12, '2025-02-28', '2025-03-03', 120.00 * 3, 'Active'),
(4, 5, 3, '2025-03-05', '2025-03-07', 50.00 * 2, 'Completed'),
(5, 6, 7, '2025-03-10', '2025-03-15', 40.00 * 5, 'Canceled'),
(6, 7, 10, '2025-02-25', '2025-03-01', 48.00 * 4, 'Active'),
(7, 8, 14, '2025-03-02', '2025-03-08', 52.00 * 6, 'Completed'),
(8, 9, 6, '2025-03-12', '2025-03-18', 85.00 * 6, 'Canceled'),
(9, 10, 4, '2025-02-20', '2025-02-23', 75.00 * 3, 'Completed'),
(10, 11, 1, '2025-03-07', '2025-03-12', 45.99 * 5, 'Completed'),
(11, 12, 9, '2025-03-01', '2025-03-06', 44.50 * 5, 'Active'),
(12, 13, 11, '2025-02-22', '2025-02-25', 55.00 * 3, 'Completed'),
(13, 14, 15, '2025-03-09', '2025-03-14', 80.00 * 5, 'Canceled'),
(14, 15, 2, '2025-02-28', '2025-03-05', 42.50 * 7, 'Completed'),
(15, 1, 13, '2025-03-04', '2025-03-10', 43.00 * 6, 'Active');

INSERT INTO payment (payment_id, rental_id, user_id, amount, payment_date, payment_method) VALUES 
(1, 1, 2, 360.00, '2025-03-05 14:30:00', 'Card'),
(2, 2, 3, 239.95, '2025-02-20 10:15:00', 'PayPal'),
(3, 3, 4, 360.00, '2025-03-03 08:45:00', 'Card'),
(4, 4, 5, 100.00, '2025-03-07 13:20:00', 'Cash'),
(5, 5, 6, 200.00, '2025-03-15 09:00:00', 'Card'),
(6, 6, 7, 192.00, '2025-03-01 11:45:00', 'PayPal'),
(7, 7, 8, 312.00, '2025-03-08 15:00:00', 'Card'),
(8, 8, 9, 510.00, '2025-03-18 12:30:00', 'Card'),
(9, 9, 10, 225.00, '2025-02-23 17:45:00', 'PayPal'),
(10, 10, 11, 229.95, '2025-03-12 16:10:00', 'Card'),
(11, 11, 12, 222.50, '2025-03-06 14:20:00', 'Cash'),
(12, 12, 13, 165.00, '2025-02-25 10:50:00', 'Card'),
(13, 13, 14, 400.00, '2025-03-14 09:30:00', 'PayPal'),
(14, 14, 15, 297.50, '2025-03-05 18:00:00', 'Card'),
(15, 15, 1, 258.00, '2025-03-10 08:00:00', 'Cash');

INSERT INTO branch (branch_id, car_id, name, email, location, contact_number, opening_hours) 
VALUES 
(1, 1, 'Sarajevo Rent', 'sarajevorent@gmail.com', 'Sarajevo', '033-555-100', '08:00-18:00'),
(2, 2, 'Sarajevo Rent', 'sarajevorent@gmail.com', 'Sarajevo', '033-555-100', '08:00-18:00'),
(3, 3, 'Sarajevo Rent', 'sarajevorent@gmail.com', 'Sarajevo', '033-555-100', '08:00-18:00'),
(4, 4, 'Sarajevo Rent', 'sarajevorent@gmail.com', 'Sarajevo', '033-555-100', '08:00-18:00'),
(5, 5, 'Sarajevo Rent', 'sarajevorent@gmail.com', 'Sarajevo', '033-555-100', '08:00-18:00'),
(6, 1, 'Sarajevo Rent', 'sarajevorent@gmail.com', 'Sarajevo', '033-555-100', '08:00-18:00'),
(7, 2, 'Sarajevo Rent', 'sarajevorent@gmail.com', 'Sarajevo', '033-555-100', '08:00-18:00'),
(8, 3, 'Sarajevo Rent', 'sarajevorent@gmail.com', 'Sarajevo', '033-555-100', '08:00-18:00'),
(9, 6, 'Sarajevo Rent', 'sarajevorent@gmail.com', 'Sarajevo', '033-555-100', '08:00-18:00'),
(10, 7, 'Sarajevo Rent', 'sarajevorent@gmail.com', 'Sarajevo', '033-555-100', '08:00-18:00'),

(11, 4, 'Tuzla Car Rental', 'tuzlacarrental@gmail.com', 'Tuzla', '035-555-200', '07:30-19:30'),
(12, 5, 'Tuzla Car Rental', 'tuzlacarrental@gmail.com', 'Tuzla', '035-555-200', '07:30-19:30'),
(13, 6, 'Tuzla Car Rental', 'tuzlacarrental@gmail.com', 'Tuzla', '035-555-200', '07:30-19:30'),
(14, 7, 'Tuzla Car Rental', 'tuzlacarrental@gmail.com', 'Tuzla', '035-555-200', '07:30-19:30'),
(15, 8, 'Tuzla Car Rental', 'tuzlacarrental@gmail.com', 'Tuzla', '035-555-200', '07:30-19:30'),
(16, 9, 'Tuzla Car Rental', 'tuzlacarrental@gmail.com', 'Tuzla', '035-555-200', '07:30-19:30'),
(17, 10, 'Tuzla Car Rental', 'tuzlacarrental@gmail.com', 'Tuzla', '035-555-200', '07:30-19:30'),
(18, 4, 'Tuzla Car Rental', 'tuzlacarrental@gmail.com', 'Tuzla', '035-555-200', '07:30-19:30'),
(19, 11, 'Tuzla Car Rental', 'tuzlacarrental@gmail.com', 'Tuzla', '035-555-200', '07:30-19:30'),
(20, 12, 'Tuzla Car Rental', 'tuzlacarrental@gmail.com', 'Tuzla', '035-555-200', '07:30-19:30'),

(21, 8, 'Mostar Auto', 'mostarauto@gmail.com', 'Mostar', '036-555-300', '09:00-20:00'),
(22, 9, 'Mostar Auto', 'mostarauto@gmail.com', 'Mostar', '036-555-300', '09:00-20:00'),
(23, 10, 'Mostar Auto', 'mostarauto@gmail.com', 'Mostar', '036-555-300', '09:00-20:00'),
(24, 11, 'Mostar Auto', 'mostarauto@gmail.com', 'Mostar', '036-555-300', '09:00-20:00'),
(25, 12, 'Mostar Auto', 'mostarauto@gmail.com', 'Mostar', '036-555-300', '09:00-20:00'),
(26, 13, 'Mostar Auto', 'mostarauto@gmail.com', 'Mostar', '036-555-300', '09:00-20:00'),
(27, 14, 'Mostar Auto', 'mostarauto@gmail.com', 'Mostar', '036-555-300', '09:00-20:00'),
(28, 15, 'Mostar Auto', 'mostarauto@gmail.com', 'Mostar', '036-555-300', '09:00-20:00'),
(29, 5, 'Mostar Auto', 'mostarauto@gmail.com', 'Mostar', '036-555-300', '09:00-20:00'),
(30, 6, 'Mostar Auto', 'mostarauto@gmail.com', 'Mostar', '036-555-300', '09:00-20:00');
