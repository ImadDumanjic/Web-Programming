let ContactService = {
    storeMessage: function(data){
        RestClient.post("contacts", data, function(){
            toastr.success("Thank you! We will contact you shortly.");
            $("#contact-form")[0].reset();
        }, function(error){
            toastr.error("Something went wrong! Check the inputs.");
        })
    },

    loadMessages: function(){
        RestClient.get("contacts", function(contacts){
            let table = $("#contactTable").DataTable();
            table.clear();

            contacts.forEach(function(contact){
                table.row.add([
                    contact.id,
                    contact.user_id,
                    contact.name,
                    contact.email,
                    contact.phone,
                    contact.message,
                    contact.created_at,
                    `
                    <button class="btn btn-sm btn-danger contact-delete-btn px-3 py-2 me-1" data-id="${contact.id}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    `
                ])
            });
            table.draw();
        }, function(error){
            toastr.error("Failed to load messages!");
        })
    },

    deleteMessage: function(id){
        RestClient.delete("contacts/" + id, null, function(){
            toastr.success("Contact message successfully deleted!")
            ContactService.loadMessages();
        }, function(error){
            toastr.error("Failed to delete contact message!");
        })
    }
}