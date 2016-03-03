$(document).ready(function() {
    
    $('form[name="user_edit"]').validate({
        
        rules: {
            display_name: {
                required: true,
                maxlength: 255
            },
            ldap_username: {
                required: true,
                maxlength: 255
            },
            cerner_username: {
                required: true,
                maxlength: 255
            },
            email: {
                required: true,
                email: true,
                maxlength: 255
            }
        },
        messages: {
            display_name: "You must enter a display name.",
            ldap_username: "You must enter a LDAP username.",
            cerner_username: "You must enter a cerner username.",
            email: {
                required: "You must enter an email address.",
                email: "Invalid email format!"
            }
        }
        
    });
});
