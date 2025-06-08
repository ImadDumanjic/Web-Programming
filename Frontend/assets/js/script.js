document.addEventListener("DOMContentLoaded", function () {
    app.route({
        view: "home",
        load: "./pages/home.html",
        onReady: function(){
            loadScript("assets/js/home.js");
        }
    });

    app.route({
    view: "offers",
    load: "offers.html",
    onReady: function(){
        CarService.loadCars2(); 

        $(document).off("click", ".details").on("click", ".details", function () {
            const carId = $(this).data("id");

            if (!carId) {
                console.warn("Missing car ID!");
                return;
            }

            CarService.getCarById(carId, CarService.showCarModal, function () {
                toastr.error("Failed to load car details.");
            });
        });

        $(document).off("click", ".close").on("click", ".close", function () {
            $("#carModal").fadeOut();
        });

        $(document).off("click", ".rent-btn").on("click", ".rent-btn", function () {
            const carId = $(this).data("id");
            const price = $(this).data("price");

            if (!carId || !price) {
                console.warn("Missing car ID or price!");
                return;
            }

            localStorage.setItem("selectedCarId", carId);
            localStorage.setItem("pricePerDay", price);
        });
        }
    });


    app.route({
        view: "contact",
        load: "contact.html",
        onReady: function(){
            loadCSS("assets/css/contact.css");

            $("#contact-form").validate({
            rules: {
                name: "required",

                email: {
                    required: true,
                    email: true
                },

                phone: {
                    required: true,
                    digits: true,
                    minlength: 8,
                    maxlength: 15
                },

                message: {
                    required: true,
                    maxlength: 150
                }
            },
            messages: {
                name: "Please enter your name",

                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email"
                },

                phone: {
                    required: "Please enter your phone number",
                    digits: "Only digits are allowed",
                    minlength: "Phone number is too short",
                    maxlength: "Phone number is too long"
                },
                
                message: {
                    required: "Please enter your message",
                    maxlength: "Message is too long"
            }},

            //needed to add this function because the error messages were horrible. 
            errorPlacement: function (error, element) {
                error.addClass("error-label");
                element.parent().append(error);
            },

            submitHandler: function(form){
                const userId = localStorage.getItem("userId");

                const data = {
                user_id: parseInt(userId),
                name: $("#name").val().trim(),
                email: $("#email").val().trim(),
                phone: $("#phone").val().trim(),
                message: $("#message").val().trim()
                };

                ContactService.storeMessage(data);
                form.reset();
            },
            });
        }
    });

    app.route({
        view: "registration",
        load: "registration.html",
        onReady: function(){
        CustomerService.init();
        }
    });

    app.route({
        view: "rent",
        load: "rent.html",
        onReady: function(){
        loadCSS("assets/css/rent.css");

        $("#rent-form").validate({
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

            pickup_date: {
                required: true,
                date: true
            },
            
            rental_days: {
                required: true,
                digits: true,
                min: 1
            },

            pickup_location: {
                required: true
            }
        },
        messages: {
            name: "Please enter your name",

            email: {
                required: "Please enter your email",
                email: "Please enter a valid email"
            },

            phone: {
                required: "Please enter your phone number",
                digits: "Only numbers allowed",
                minlength: "Phone number is too short",
                maxlength: "Phone number is too long"
            },

            pickup_date: "Please choose a pickup date",

            rental_days: {
                required: "Please specify number of days",
                digits: "Only digits are allowed",
                min: "At least 1 day required"
            },

            pickup_location: "Please select pickup location"
        },

        //needed to add this function because the error messages were horrible. 
        errorPlacement: function (error, element) {
            error.addClass("error-label");
            element.parent().append(error);
        },

        submitHandler: function(form){
            $.blockUI({
            message: '<h3 style = "color: white;"><i class="fas fa-spinner fa-spin me-2"></i>Processing Data...</h3>',
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

            setTimeout(function () {
                const userId = localStorage.getItem("userId");
                const carId = localStorage.getItem("selectedCarId");
                const rentalDays = parseInt($("#rental_days").val());
                const pricePerDay = parseFloat(localStorage.getItem("pricePerDay"));
                const totalPrice = rentalDays * pricePerDay;

            const data = {
                user_id: parseInt(userId),
                car_id: parseInt(carId),
                start_date: $("#pickup_date").val(),
                end_date: calculateEndDate($("#pickup_date").val(), rentalDays),
                total_price: totalPrice,
                status: "Active",
                pickup_location: $("#pickup_location").val().trim()
            };

            CarService.rentCar(data, function (response) {
                localStorage.setItem("rental_id", response.rental_id);
                localStorage.setItem("amount", totalPrice);
                localStorage.setItem("days", rentalDays);
                localStorage.setItem("pickup_location", data.pickup_location);
                $.unblockUI();
                window.location.href = "index.html#payment";
            }, function (error) {
                toastr.error("Rent failed!");
                $.unblockUI();
            });
            }, 1500);
        }
        });

        function calculateEndDate(startDate, rentalDays) {
        const start = new Date(startDate);
        start.setDate(start.getDate() + rentalDays);
        return start.toISOString().split('T')[0];
        }
        }
    });


    // app.route({
    // view: "payment",
    // load: "payment.html",
    // onReady: function () {
    //     loadCSS("assets/css/payment.css");
    //     CarService.loadCars3();

    //     setTimeout(() => {

    //         const form = document.getElementById("payment-form");

    //         if (!form) {
    //             console.error("Form not found!");
    //             return;
    //         }

    //         form.addEventListener("submit", function(event){
    //             event.preventDefault();

    //             const rentalId = localStorage.getItem("rental_id");
    //             const amount = localStorage.getItem("amount");
    //             const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value;

    //             if (!paymentMethod) {
    //                 toastr.warning("Please select a payment method.");
    //                 return;
    //             }

    //             if (!rentalId || !amount) {
    //                 toastr.error("Missing rental or amount data.");
    //                 return;
    //             }

    //             const paymentData = {
    //                 rental_id: parseInt(rentalId),
    //                 amount: parseFloat(amount),
    //                 payment_method: paymentMethod,
    //                 payment_date: new Date().toISOString().slice(0, 19).replace('T', ' ')
    //             };

    //             PaymentService.createPayment(paymentData, function () {
    //                 toastr.success("Payment successful!");
    //                 form.reset();
    //                 ["rental_id", "amount", "days", "selectedCarId"].forEach(key => localStorage.removeItem(key));

    //                 setTimeout(() => {
    //                     window.location.href = "index.html#home";
    //                 }, 1000);
    //             }, function (error) {
    //                 console.error("Payment error:", error);
    //                 toastr.error("Payment failed!");
    //             });
    //         });
    //         }, 100);
    //     }
    // });

    app.route({
    view: "payment",
    load: "payment.html",
    onReady: function () {
        loadCSS("assets/css/payment.css");
        CarService.loadCars3();

        setTimeout(() => {
            const form = $("#payment-form");

            if (!form.length) {
                console.error("Form not found!");
                return;
            }

            form.validate({
                rules: {
                    firstName: {
                        required: true,
                        minlength: 2
                    },

                    lastName: {
                        required: true,
                        minlength: 2
                    },

                    email: {
                        required: true,
                        email: true
                    },

                    address: {
                        required: true
                    },

                    country: {
                        required: true
                    },

                    city: {
                        required: true
                    },

                    zip: {
                        required: true,
                        digits: true
                    },

                    paymentMethod: {
                        required: true
                    },

                    ccname: {
                        required: true
                    },

                    ccnumber: {
                        required: true,
                    },

                    "cc-expiration": {
                        required: true
                    },

                    "cc-cvv": {
                        required: true,
                        digits: true,
                        minlength: 3,
                        maxlength: 3
                    }
                },
                messages: {
                    firstName: "Please enter your first name",
                    lastName: "Please enter your last name",
                    email: "Please enter a valid email address",
                    address: "Please provide your address",
                    country: "Please select a country",
                    city: "Please enter your city",
                    zip: "Please enter a valid zip code",
                    paymentMethod: "Please select a payment method",
                    ccname: "Enter the cardholder name",
                    ccnumber: "Enter a valid credit card number",
                    
                    //needed to use the "" because the name contains -
                    "cc-expiration": "Enter the card expiration date",
                    "cc-cvv": "Enter the CVC code"
                },

                //found template code on website, how to style the validation, so wanted to try it out
                errorElement: "div",
                errorClass: "invalid-feedback",
                highlight: function (element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                },
                errorPlacement: function (error, element) {
                    if (element.attr("type") === "radio") {
                        error.insertAfter(element.closest(".d-block"));
                    } else {
                        error.insertAfter(element);
                    }
                },

                submitHandler: function (formElement) {
                    const rentalId = localStorage.getItem("rental_id");
                    const amount = localStorage.getItem("amount");
                    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value;

                    if (!paymentMethod) {
                        toastr.warning("Please select a payment method.");
                        return;
                    }

                    if (!rentalId || !amount) {
                        toastr.error("Missing rental or amount data.");
                        return;
                    }

                    const paymentData = {
                        rental_id: parseInt(rentalId),
                        amount: parseFloat(amount),
                        payment_method: paymentMethod,
                        payment_date: new Date().toISOString().slice(0, 19).replace('T', ' ')
                    };

                    PaymentService.createPayment(paymentData, function () {
                        toastr.success("Payment successful!");
                        form[0].reset();
                        ["rental_id", "amount", "days", "selectedCarId"].forEach(key => localStorage.removeItem(key));

                        setTimeout(() => {
                            window.location.href = "index.html#home";
                        }, 1000);
                    }, function (error) {
                        console.error("Payment error:", error);
                        toastr.error("Payment failed!");
                    });
                }
            });
            }, 100);
        }
    });

    app.route({
    view: "admin",
    load: "admin.html",
    onReady: function(){
        loadCSS("assets/css/admin.css");

        /*Car table display*/
        $('#carTable').DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            autoWidth: false,
            pageLength: 5,
            dom: 'lrtip'
        });

        $("#carTable").parent().show();
        $("#user-section").hide();
        $("#rental-section").hide();
        CarService.loadCars();

        let carIdToDelete = null;

        $(document).on("click", ".car-delete-btn", function () {
            carIdToDelete = $(this).data("id");
            $("#deleteConfirmModal").modal("show");
        });

        $("#confirmCarDeleteBtn").off("click").on("click", function () {
            if (carIdToDelete !== null) {
                CarService.deleteCar(carIdToDelete);
                carIdToDelete = null;
                $("#deleteConfirmModal").modal("hide");
            }
        });

        $(document).on("click", ".edit-btn", function () {
            const carId = $(this).data("id");
            CarService.editCar(carId);
        });

        $(document).off("submit", "#editCarForm").on("submit", "#editCarForm", function (e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this).entries());
            CarService.updateCar(data);
        });

        $(document).off("submit", "#addCarForm").on("submit", "#addCarForm", function (e){
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this).entries());
            CarService.addCar(data);
        });

        $("#admin-view-cars").on("click", function () {
            $("#carTable").parent().show();
            $("#addButton").show(); 
            $("#user-section").hide();
            $("#rental-section").hide();
            $("#branch-section").hide();
            $("#payment-section").hide();
            CarService.loadCars();
        });


        /*User table display*/
        $("#admin-view-users").on("click", function () {
            $("#carTable").parent().hide();
            $("#user-section").show();
            $("#rental-section").hide();
            $("#addButton").hide(); 
            $("#branch-section").hide();
            $("#contact-section").hide();
            $("#payment-section").hide();

            CustomerService.loadUsers();
        });

        $('#userTable').DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            autoWidth: false,
            pageLength: 5
        });

        $(document).on("click", ".edit-btn", function () {
            const userId = $(this).data("id");
            CustomerService.editUser(userId); 
        });

        $(document).off("submit", "#editUserForm").on("submit", "#editUserForm", function(e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this).entries());
            CustomerService.updateUser(data);
        });

        let userIdToDelete = null;

        $(document).on("click", ".user-delete-btn", function(){
            userIdToDelete = $(this).data("id");
            $("#deleteUserConfirmModal").modal("show");
        });

        $("#confirmUserDeleteBtn").off("click").on("click", function () {
            if (userIdToDelete !== null) {
                CustomerService.deleteUser(userIdToDelete);
                userIdToDelete = null;
                $("#deleteUserConfirmModal").modal("hide");
            }
        });

        $(document).off("submit", "#addUserForm").on("submit", "#addUserForm", function (e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this).entries());
            CustomerService.addUser(data);
        });



        /*Rental table display*/
        $("#admin-view-rentals").on("click", function () {
            $("#carTable").parent().hide();
            $("#user-section").hide();
            $("#rental-section").show();
            $("#addButton").hide(); 
            $("#branch-section").hide();
            $("#contact-section").hide();
            $("#payment-section").hide();

            RentService.loadRentals();
        });

      $('#rentalTable').DataTable({
            autoWidth: false,
            pageLength: 5,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            columnDefs: [
                { width: '50px', targets: 0 }, 
                { width: '50px', targets: 1 },  
                { width: '50px', targets: 2 },  
                { width: '80px', targets: 3 },  
                { width: '80px', targets: 4 },  
                { width: '80px', targets: 5 },  
                { width: '80px', targets: 6 },   
                { width: '70px', targets: 7 },
                { width: '100px', target: 8}   
            ]
      });

        let rentalIdToDelete = null;

        $(document).on("click", ".rent-delete-btn", function(){
            rentalIdToDelete = $(this).data("id");
            $("#deleteRentalConfirmModal").modal("show");
        });

        $("#confirmRentalDeleteBtn").off("click").on("click", function () {
            if (rentalIdToDelete !== null) {
                RentService.deleteRental(rentalIdToDelete);
                rentalIdToDelete = null;
                $("#deleteRentalConfirmModal").modal("hide");
            }
        });

        let rentalIdToEnd = null;

        $(document).on("click", ".rent-end-btn", function(){
            rentalIdToEnd = $(this).data("id");
            $("#endRentalConfirmModal").modal("show");
        });

        $(document).on("click", "#confirmRentalEndBtn", function(){
            if(rentalIdToEnd !== null){
                RentService.endRent(rentalIdToEnd);
                rentalIdToEnd = null;
                $("#endRentalConfirmModal").modal("hide");
            }
        });

        $(document).on("click", ".edit-rental-btn", function () {
            const rentalId = $(this).data("id");
            RentService.editRental(rentalId); 
        });


        $(document).off("submit", "#editRentalForm").on("submit", "#editRentalForm", function (e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this).entries());
            RentService.updateRental(data);
        });

        /*Branch table display*/
        $("#admin-view-branches").on("click", function () {
            $("#carTable").parent().hide();
            $("#user-section").hide();
            $("#rental-section").hide();
            $("#addButton").hide();
            $("#branch-section").show(); 
            $("#contact-section").hide();
            $("#payment-section").hide();

            BranchService.loadBranches();
        });

        $('#branchTable').DataTable({
            autoWidth: false,
            pageLength: 5,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            columnDefs: [
                { width: '35px', targets: 0 }, 
                { width: '85px', targets: 1 },  
                { width: '150px', targets: 2 },  
                { width: '100px', targets: 3 },  
                { width: '100px', targets: 4 },  
                { width: '100px', targets: 5 },  
                { width: '120px', targets: 6 },   
            ]
        });

        $(document).on("click", ".edit-btn", function () {
            const branchId = $(this).data("id");
            BranchService.editBranch(branchId); 
        });


        $(document).off("submit", "#editBranchForm").on("submit", "#editBranchForm", function (e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this).entries());
            BranchService.updateBranch(data);
        });

        let branchIdToDelete = null;

        $(document).on("click", ".branch-delete-btn", function(){
            branchIdToDelete = $(this).data("id");
            $("#deleteBranchConfirmModal").modal("show");
        });

        $("#confirmBranchDeleteBtn").off("click").on("click", function () {
            if (branchIdToDelete !== null) {
                BranchService.deleteBranch(branchIdToDelete);
                branchIdToDelete = null;
                $("#deleteBranchConfirmModal").modal("hide");
            }
        });

         /*ContactMessage table display*/
        $("#admin-view-messages").on("click", function () {
            $("#carTable").parent().hide();
            $("#addButton").hide(); 
            $("#user-section").hide();
            $("#rental-section").hide();
            $("#branch-section").hide();
            $("#contact-section").show();
            $("#payment-section").hide();
            ContactService.loadMessages();
        });

         $('#contactTable').DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            autoWidth: false,
            pageLength: 5
        });

        let messageIdToDelete = null;

        $(document).on("click", ".contact-delete-btn", function(){
            messageIdToDelete = $(this).data("id");
            $("#deleteContactConfirmModal").modal("show");
        });

        $("#confirmContactDeleteBtn").off("click").on("click", function () {
            if (messageIdToDelete !== null) {
                ContactService.deleteMessage(messageIdToDelete);
                messageIdToDelete = null;
                $("#deleteContactConfirmModal").modal("hide");
            }
        });

         /*Payments table display*/
        $("#admin-view-payments").on("click", function () {
            $("#carTable").parent().hide();
            $("#addButton").hide(); 
            $("#user-section").hide();
            $("#rental-section").hide();
            $("#branch-section").hide();
            $("#contact-section").hide();
            $("#payment-section").show(); 
            PaymentService.loadPayments();
        });

         $('#paymentTable').DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            autoWidth: false,
            pageLength: 5
        });

        let paymentIdToDelete = null;

        $(document).on("click", ".payment-delete-btn", function(){
            paymentIdToDelete = $(this).data("id");
            $("#deletePaymentConfirmModal").modal("show");
        });

        $("#confirmPaymentDeleteBtn").off("click").on("click", function () {
            if (paymentIdToDelete !== null) {
                PaymentService.deletePayment(paymentIdToDelete);
                paymentIdToDelete = null;
                $("#deletePaymentConfirmModal").modal("hide");
            }
        });

        $(document).off("submit", "#addBranchForm").on("submit", "#addBranchForm", function (e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this).entries());
            BranchService.addBranch(data);
        });
        }
    });

    app.route({
        view: "locations",
        load: "locations.html",
        onReady: function () {
            loadCSS("assets/css/locations.css"); 
        }
    });

    app.run();

    function loadScript(scriptUrl) {
        if (!document.querySelector(`script[src="${scriptUrl}"]`)) {
            let scriptTag = document.createElement("script");
            scriptTag.src = scriptUrl;
            scriptTag.defer = true;
            document.body.appendChild(scriptTag);
        }
    }

    function loadCSS(cssUrl) {
        document.querySelectorAll('link[data-dynamic]').forEach(link => link.remove());
    
        let linkTag = document.createElement("link");
        linkTag.rel = "stylesheet";
        linkTag.href = cssUrl;
        linkTag.setAttribute("data-dynamic", "true");
        document.head.appendChild(linkTag);
    }
});
