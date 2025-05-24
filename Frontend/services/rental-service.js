let RentService = {
    loadRentals: function(){
        RestClient.get("rent", function(rentals){
            let table = $("#rentalTable").DataTable();
            table.clear();

            rentals.forEach(function(rent){
                table.row.add([
                    rent.rental_id,
                    rent.user_id,
                    rent.car_id,
                    rent.start_date,
                    rent.end_date,
                    rent.total_price,
                    rent.status,
                    rent.pickup_location,
                    `
                  <button class="btn btn-sm btn-warning edit-rental-btn px-3 py-2 me-1 ms-1" data-id="${rent.rental_id}" data-bs-toggle="modal" data-bs-target="#editRentalModal">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-primary rent-end-btn px-3 py-2 me-1" data-id="${rent.rental_id}">
                    <i class="fa-solid fa-flag-checkered"></i>
                  </button>
                  <button class="btn btn-sm btn-danger rent-delete-btn px-3 py-2 me-1" data-id="${rent.rental_id}">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                `
                ]);
            });
            table.draw();
        }, function(error){
            toastr.error("Failed to load rentals!");
        });
    },

    editRental: function(rentalId) {
      RestClient.get("rent/" + rentalId, function(rent){
        const formHtml = `
          <input type="hidden" name="rental_id" value="${rent.rental_id}">
          <div class="row g-3">
            <div class="col-md-6">
              <input type="number" class="form-control" name="user_id" value="${rent.user_id}" required>
            </div>
            <div class="col-md-6">
              <input type="number" class="form-control" name="car_id" value="${rent.car_id}" required>
            </div>
            <div class="col-md-6">
              <label>Start Date</label>
              <input type="date" class="form-control" name="start_date" value="${rent.start_date}" required>
            </div>
            <div class="col-md-6">
              <label>End Date</label>
              <input type="date" class="form-control" name="end_date" value="${rent.end_date}" required>
            </div>
            <div class="col-md-6">
              <input type="number" class="form-control" name="total_price" value="${rent.total_price}" required>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" name="pickup_location" value="${rent.pickup_location}" required>
            </div>
            <div class="col-md-6">
              <select class="form-select" name="status" required>
                <option ${rent.status === 'Active' ? 'selected' : ''}> Active </option>
                <option ${rent.status === 'Completed' ? 'selected' : ''}> Completed </option>
                <option ${rent.status === 'Scheduled' ? 'selected' : ''}> Scheduled </option>
              </select>
            </div>
          </div>
          <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">Save Changes</button>
          </div>
        `;
        $("#editRentalForm").html(formHtml);
      }, function() {
        toastr.error("Failed to load rental data.");
      });
    },


    updateRental: function(data){
      RestClient.put("rent/" + data.rental_id, data, function(){
        toastr.success("Rental updated successfully!");
        $("#editRentalModal").modal("hide");
        RentService.loadRentals();
      }, function(){
        toastr.error("Failed to update rental record!");
      });
    },

    deleteRental: function(rentId){
      RestClient.delete("rent/" + rentId, null, function(){
        toastr.success("Rental deleted successfully!");
        RentService.loadRentals();
      }, function(){
        toastr.error("Failed to delete the rental!");
      });
    },

    endRent: function(rentalId){
      RestClient.put("rent/end/" + rentalId, null, function(response){
          toastr.success("Rental successfully completed.");
          RentService.loadRentals();
      }, function(error){
          toastr.error("Failed to complete rental: " + error.responseJSON?.error);
      })
    }
}