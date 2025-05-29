let CustomerService = {
  init: function(){
    const token = localStorage.getItem("user_token");

    CustomerService.updateAuthButton();

    $("#login-form").validate({
      rules: {
        email: {
          required: true,
          email: true
        },

        password: "required"
      },

      messages: {

        email: {
          required: "Please enter your email",
          email: "Please enter a valid email address"
        },

        password: "Please enter your password"
      },

      submitHandler: function(form){
        const entity = Object.fromEntries(new FormData(form).entries());
        CustomerService.login(entity);
      }
    });

    $("#register-form").validate({
      rules: {
        name: "required",

        email: {
          required: true,
          email: true
        },

        phone: {
          required: true,
          digits: true,
          minlength: 6,
          maxlength: 15
        },

        password: {
          required: true,
          minlength: 8,
          maxlength: 20
        },

        address: "required"
      },

      messages: {
        name: "Please enter your full name",
        email: {
          required: "Please enter your email",
          email: "Please enter a valid email address"
        },

        phone: {
          required: "Please enter your phone number",
          digits: "Phone number can only contain digits",
          minlength: "Phone number is too short",
          maxlength: "Phone number is too long"
        },

        password: {
          required: "Please enter a password",
          minlength: "Password must be at least 8 characters",
          maxlength: "Password must be at most 20 characters"
        },

        address: "Please enter your address"
      },

      submitHandler: function(form){
        const entity = Object.fromEntries(new FormData(form).entries());
        CustomerService.register(entity);
      }
    });

    $("#auth-link").on("click", function (e) {
      const token = localStorage.getItem("user_token");

      if(token) {
        e.preventDefault(); 
        CustomerService.logout();
      }
    });
  },

  login: function(entity){
      $.blockUI({
          message: '<h3 style = "color: white;"><i class="fas fa-spinner fa-spin me-2"></i>Logging In...</h3>',
          css: {
              border: 'none',
              padding: '15px',
              backgroundColor: 'black',
              '-webkit-border-radius': '10px',
              '-moz-border-radius': '10px',
              opacity: 0.7,
              color: '#fff'
          }
      });

      setTimeout(function(){
          RestClient.post("auth/login", entity, function(result){
              $.unblockUI();
              localStorage.setItem("user_token", result.data.token);
              localStorage.setItem("userRole", result.data.user_type);
              localStorage.setItem("userId", result.data.user_id); 
              toastr.success("Welcome " + result.data.name + "!");
              $("#login-form")[0].reset();

              CustomerService.updateAuthButton();

              if (result.data.user_type === "Admin") {
                  window.location.hash = "#admin";
              } else {
                  window.location.href = "index.html#home";
              }
          }, function (err) {
              $.unblockUI();
              toastr.error(err.responseJSON?.error || "Login failed!");
          });
      }, 1500); 
  },


  register: function(entity){
      $.blockUI({
            message: '<h3 style = "color: white;"><i class="fas fa-spinner fa-spin me-2"></i>Registering...</h3>',
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: 'black',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: 0.7,
                color: '#fff'
            }
        });

      setTimeout(function(){
          RestClient.post("auth/register", entity, function () {
              $.unblockUI();
              toastr.success("Registration successful! You can now log in.");
          }, function (err) {
              $.unblockUI();
              toastr.error(err.responseJSON?.error || "Registration failed!");
          });
      }, 1500); 
    },


    logout: function(){
      localStorage.clear();
      CustomerService.updateAuthButton();
      window.location.href = "index.html#home";
    },
    	
    //logout/join us button change
    updateAuthButton: function(){
      const token = localStorage.getItem("user_token");
      const btnText = document.getElementById("auth-btn-text");
      const authLink = document.getElementById("auth-link");

      if(token) {
        btnText.textContent = "Logout";
        authLink.setAttribute("href", "#"); 
      } else {
        btnText.textContent = "Join Us";
        authLink.setAttribute("href", "#registration");
      }
  },

  addUser: function(data){
    RestClient.post("auth/register", data, function(user){
      toastr.success("User added successfully!");
      $("#addUserModal").modal("hide");
      CustomerService.loadUsers();
      $("#addUserForm")[0].reset();
    }, function(){
      toastr.error("Failed to add user!");
    });
  },

  loadUsers: function(){
    RestClient.get("user", function(users){
      let table = $("#userTable").DataTable();
      table.clear();

      users.forEach(function(user){
        table.row.add([
          user.user_id,
          user.name,
          user.email,
          user.phone,
         "••••••••••",
          user.user_type,
          user.address,
          `
            <button class="btn btn-sm btn-success edit-btn px-3 py-2 me-1 ms-1" data-bs-toggle="modal" data-bs-target="#addUserModal">
              <i class="fas fa-plus"></i>
            </button>
            <button class="btn btn-sm btn-warning edit-btn px-3 py-2 me-1 ms-1" data-id="${user.user_id}" data-bs-toggle="modal" data-bs-target="#editUserModal">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger user-delete-btn px-3 py-2 me-1" data-id="${user.user_id}">
              <i class="fas fa-trash-alt"></i>
            </button>
          `
        ]);
      });
      table.draw();
    }, function(error){
      toastr.error("Failed to load users!");
    })
  },

  editUser: function(userId){
    RestClient.get("user/" + userId, function(user){
      const formHtml = `
          <input type="hidden" name="user_id" value="${user.user_id}">
          <div class="row g-3">
            <div class="col-md-6"><input type="text" class="form-control" name="name" value="${user.name}" required></div>
            <div class="col-md-6"><input type="text" class="form-control" name="email" value="${user.email}" required></div>
            <div class="col-md-4"><input type="number" class="form-control" name="phone" value="${user.phone}" required></div>
            <div class="col-md-4">
              <select class="form-select" name="user_type" required>
                <option ${user.user_type === 'Admin' ? 'selected' : ''}>Admin</option>
                <option ${user.user_type === 'Customer' ? 'selected' : ''}>Customer</option>
              </select>
            </div>
            <div class="col-md-4"><input type="text" class="form-control" name="address" value="${user.address}" required></div>
          </div>
          <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">Save Changes</button>
          </div>
        `;
        $("#editUserForm").html(formHtml);
      }, function(){
        toastr.error("Failed to load user data!");
      });
    },

    updateUser: function(data){
       RestClient.put("user/" + data.user_id, data, function(){
        toastr.success("User updated successfully!");
        $("#editUserModal").modal("hide");
        CustomerService.loadUsers();
      }, function(){
        toastr.error("Failed to update user!");
      });
    },

    deleteUser: function(userId){
      RestClient.delete("user/" + userId, null, 
        function(){
            toastr.success("User deleted successfully!");
            CustomerService.loadUsers();
      }, function(userId){
            toastr.error("Failed to delete user!");
      });
    }
};
