let BranchService = {
    loadBranches: function(){
        RestClient.get("branch", function(branches){
            let table = $("#branchTable").DataTable();
            table.clear();

            branches.forEach(function(branch){
                table.row.add([
                    branch.branch_id,
                    branch.name,
                    branch.email,
                    branch.location,
                    branch.contact_number,
                    branch.opening_hours,
                    `
                        <button class="btn btn-sm btn-success add-btn px-3 py-2 me-1 ms-1" data-bs-toggle="modal" data-bs-target="#addBranchModal">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-sm btn-warning edit-btn px-3 py-2 me-1 ms-1" data-id="${branch.branch_id}" data-bs-toggle="modal" data-bs-target="#editBranchModal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger user-delete-btn px-3 py-2 me-1" data-id="${branch.branch_id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `
                ]);
            });
            table.draw();
        }, function(error){
             toastr.error("Failed to load branches!");
        });
    },

    editBranch: function(branchId){
        RestClient.get("branch/" + branchId, function(branch){
            const formHtml = `
                <input type="hidden" name="branch_id" value="${branch.branch_id}">
                <div class="row g-3">
                    <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="${branch.name}" required>
                    </div>
                    <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="${branch.email}" required>
                    </div>
                    <div class="col-md-6">
                    <label>Location</label>
                    <input type="text" class="form-control" name="location" value="${branch.location}" required>
                    </div>
                    <div class="col-md-6">
                    <label>Contact Number</label>
                    <input type="text" class="form-control" name="contact_number" value="${branch.contact_number}" required>
                    </div>
                    <div class="col-md-6">
                    <label>Opening Hours</label>
                    <input type="text" class="form-control" name="opening_hours" value="${branch.opening_hours}" required>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
                `;
            $("#editBranchForm").html(formHtml);
        }, function(){
            toastr.error("Failed to load branch data!");
        });
    },

    updateBranch: function(data){
        RestClient.put("branch/" + data.branch_id, data, function(){
            toastr.success("Branch updated succesfully!");
            $("#editBranchModal").modal("hide");
            BranchService.loadBranches();
        }, function(){
            toastr.error("Failed to update branch!");
        });
    },

    deleteBranch: function(branchId){
        RestClient.delete("branch/" + branchId, null, function(){
           toastr.success("Branch deleted successfully!");
           BranchService.loadBranches();
        }, function(){
            toastr.error("Failed to delete branch!");
        });
    },

    addBranch: function(data){
        RestClient.post("branch", data, function(branch){
            toastr.success("New branch added successfully!");
            $("#addBranchModal").modal("hide");
            BranchService.loadBranches();
            $("#addBranchForm")[0].reset();
        }, function(){
            toastr.error("Failed to add a new branch!");
        })
    }
}