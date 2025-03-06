class MessageBox 
{
    static showMessage(type, message, currentField)
    {
        let textColor;
        
        type == "error" ? textColor = "red" : textColor = "green";
        $(`#${currentField}Message`).remove();
        $(`#${currentField}Div`).after(`<div id="${currentField}Message" style="color : ${textColor}"> ${message} </div>`)

        if(type != "error")
        {
            setTimeout(() => {
                $(`#${currentField}Message`).fadeOut(500, function () {
                    $(this).remove(); // Ensures element is completely removed after fading out
                });
            }, 2000);
        }
    }
}

$(document).ready(function () 
{
    $(".update-info").click(function () 
    {
        let fieldType = $(this).data("type"); // Either 'email' or 'phone'
        let newValue = $("#" + fieldType).val(); // Get value from input
        let userId = $(this).data("user-id"); // Get user ID from button

        console.log(`Updating ${fieldType}:`, newValue); // Debugging

        if (newValue.trim() === "") 
        {

            MessageBox.showMessage("error", `Por favor, ingresa un ${fieldType} válido.`, `${fieldType}`)

            return;
        }

        $.ajax(
        {
            url: "/update-user-info",
            method: "POST",
            data: 
            {
                user_id: userId,
                [fieldType]: newValue, // Dynamically send either email or phone
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            },
            success: function (response) 
            {
                MessageBox.showMessage("success", `${fieldType.charAt(0).toUpperCase() + fieldType.slice(1)} actualizado correctamente.`, `${fieldType}`)
                $(`#user-${fieldType}`).text(newValue); // Update UI
                $("#" + fieldType).val(""); // Clear input field
            },
            error: function (xhr) {
                MessageBox.showMessage("error", xhr.responseJSON.message, `${fieldType}`)
            }
        });
    });
    
});
