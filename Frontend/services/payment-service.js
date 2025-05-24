let PaymentService = {
    createPayment: function(data, onSuccess, onError){
        RestClient.post("payment", data, function(response){
            if (onSuccess) onSuccess(response); 
        }, function(error){
            if (onError) onError(error);
        });
    },

    loadPayments: function(){
        RestClient.get("payment", function(payments){
            let table = $("#paymentTable").DataTable();
            table.clear();

            payments.forEach(function(payment){
                table.row.add([
                    payment.payment_id,
                    payment.rental_id,
                    payment.user_id,
                    payment.amount,
                    payment.payment_date,
                    payment.payment_method,
                    `
                        <button class="btn btn-sm btn-danger payment-delete-btn px-3 py-2 me-1" data-id="${payment.payment_id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `
                ]);
            });
            table.draw();
        }, function(error){
            toastr.error("Failed to load payments!");
        });
    },

    deletePayment: function(paymentId){
        RestClient.delete("payment/" + paymentId, null, function(){
            toastr.success("Payment successfully deleted!");
            PaymentService.loadPayments();
        }, function(){
            toastr.error("Failed to delete payment.");
        });
    }
};
