let CarService = {
    loadCars: function(){
        RestClient.get("car", function(cars){
            let table = $('#carTable').DataTable();
            table.clear();

            cars.forEach(function(car){
              table.row.add([
                car.car_id,
                car.brand,
                car.model,
                car.year,
                `$${car.rental_price_per_day}`,
                car.engine,
                car.horsepower,
                `${car.torque} Nm`,
                `${car.acceleration} s`,
                `${car.top_speed} km/h`,
                car.transmission,
                car.status,
                `
                  <button class="btn btn-sm btn-warning edit-btn px-3 py-2 me-1 ms-1" data-id="${car.car_id}" data-bs-toggle="modal" data-bs-target="#editCarModal">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-danger car-delete-btn px-3 py-2 me-1" data-id="${car.car_id}">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                `
            ]);
            });
            table.draw();
        }, function(error){
            toastr.error("Failed to load cars!");
        });
    },

    deleteCar: function(carId){
      RestClient.delete("car/" + carId, null,
        function(){
          toastr.success("Car deleted successfully!");
          CarService.loadCars();
        },
        function(){
          toastr.error("Failed to delete car!");
        });
    },

    editCar: function(carId){
      RestClient.get("car/" + carId, function(car){
        const formHtml = `
          <input type="hidden" name="car_id" value="${car.car_id}">
          <div class="row g-3">
            <div class="col-md-6"><input type="text" class="form-control" name="brand" value="${car.brand}" required></div>
            <div class="col-md-6"><input type="text" class="form-control" name="model" value="${car.model}" required></div>
            <div class="col-md-4"><input type="number" class="form-control" name="year" value="${car.year}" required></div>
            <div class="col-md-4"><input type="text" class="form-control" name="rental_price_per_day" value="${car.rental_price_per_day}" required></div>
            <div class="col-md-4"><input type="text" class="form-control" name="engine" value="${car.engine}" required></div>
            <div class="col-md-4"><input type="number" class="form-control" name="horsepower" value="${car.horsepower}" required></div>
            <div class="col-md-4"><input type="text" class="form-control" name="torque" value="${car.torque}" required></div>
            <div class="col-md-4"><input type="text" class="form-control" name="acceleration" value="${car.acceleration}" required></div>
            <div class="col-md-4"><input type="text" class="form-control" name="top_speed" value="${car.top_speed}" required></div>
            <div class="col-md-4"><input type="text" class="form-control" name="transmission" value="${car.transmission}" required></div>
            <div class="col-md-4">
              <select class="form-select" name="status" required>
                <option ${car.status === 'Available' ? 'selected' : ''}>Available</option>
                <option ${car.status === 'Rented' ? 'selected' : ''}>Rented</option>
              </select>
            </div>
          </div>
          <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">Save Changes</button>
          </div>
        `;
        $("#editCarForm").html(formHtml);
      }, function(){
        toastr.error("Failed to load car data.");
      });
    },

    updateCar: function(data){
        RestClient.put("car/" + data.car_id, data, function(){
        toastr.success("Car updated successfully!");
        $("#editCarModal").modal("hide");
        CarService.loadCars();
      }, function () {
        toastr.error("Failed to update car.");
      });
    },

    addCar: function(data){
        RestClient.post("car", data, function(car){
        toastr.success("Car added successfully!");
        $("#addCarModal").modal("hide");
        CarService.loadCars();
        $("#addCarForm")[0].reset();

        CarService.addCarBox(car);
      },
      function(){
        toastr.error("Failed to add car.")
      })
    },

    addCarBox: function(car, container){
        const html = 
        `
            <div class="car_box">
            <img src="./assets/img/offer-${car.car_id}.jpg">
              <h3>${car.brand} ${car.model}</h3>
              <span>${car.rental_price_per_day}€ per day</span>
              <div class="button_container">
                <a href="#rent" class="button rent-btn" data-id="${car.car_id}" data-price="${car.rental_price_per_day}"> Rent Now </a>
                <a class="details" data-id="${car.car_id}" style="cursor:pointer;">View Specification</a>
              </div>
            </div>
        `;

        container.append(html);
    },

    loadCars2: function(){
        RestClient.get("car", function(cars){
            $("#offers_container").empty(); 

            cars.forEach(function (car) {
                CarService.addCarBox(car, $("#offers_container"));
            });
        }, function(){
            toastr.error("Failed to load cars on offers page!");
        });
    },

    loadCars3: function() {
      const carId = localStorage.getItem("selectedCarId");
      const days = localStorage.getItem("days");
      const amount = localStorage.getItem("amount");

      if (!carId) {
          toastr.error("No car selected for payment!");
          return;
      }

      RestClient.get("car/" + carId, function(car) {
          $("#car-brand").text(car.brand);
          $("#car-model").text(car.model);
          $("#rental-days").text(days);
          $("#total-amount").text(`$${amount}`);
      }, function() {
          toastr.error("Failed to load car details!");
      });
    },


    showCarModal: function(car){
      $("#modal-title").text(car.brand + " " + car.model);
      $("#modal-image").attr("src", "assets/img/offer-" + car.car_id + ".jpg").on("error", function(){
        console.warn("Image not found for car: " + car.car_id);
      });
      $("#modal-brand").text(car.brand);
      $("#modal-model").text(car.model);
      $("#modal-year").text(car.year);
      $("#modal-price").text("€" + car.rental_price_per_day + " per day");
      $("#modal-engine").text(car.engine);
      $("#modal-horsepower").text(car.horsepower);
      $("#modal-torque").text(car.torque);
      $("#modal-acceleration").text(car.acceleration);
      $("#modal-top-speed").text(car.top_speed);

      $("#carModal").fadeIn();
    },

    getCarById: function(carId, onSuccess, onError){
      RestClient.get("car/" + carId, onSuccess, onError);
    },

    rentCar: function (rentalData, onSuccess, onError) {
    RestClient.post("rent", rentalData,
        function (response) {
            toastr.success("Rental started successfully!");
            if (onSuccess) onSuccess(response); 
        },
        function(error){
            toastr.error(error?.responseJSON?.error || "Failed to start rental!");
            if (onError) onError(error); 
        }
    );
}
}; 