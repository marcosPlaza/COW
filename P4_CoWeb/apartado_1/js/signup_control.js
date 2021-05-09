// https://www.howtocreate.co.uk/referencedvariables.html
// city.observe("keyup", checkRegex(city, city_pattern)); // NOT WORKING

// Some information was extracted from https://getbootstrap.com/docs/5.0/forms/validation/

$(document).ready(function() {
    /* Form validation */
    var signupform = $("#signupform");

    $.validator.addMethod('usernamePattern', function(value) {
        return /^[a-zA-Z0-9](_(?!(\.|_))|\.(?!(_|\.))|[a-zA-Z0-9]){6,18}[a-zA-Z0-9]$/.test(value);
    }, 'Invalid username!');

    $.validator.addMethod('passwordPattern', function(value) {
        return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[\_\-\/$%&·#]).{8,32}$/.test(value);
    }, 'Invalid password!');

    signupform.validate({
        validClass: 'is-valid',
        errorClass: 'is-invalid',
        rules: {
            username: {
                required: true,
                usernamePattern: true
            },
            email: {
                required: true,
                email: true
            },
            password1: {
                required: true,
                passwordPattern: true
            },
            password2: {
                required: true,
                passwordPattern: true,
                equalTo: "#password1"
            }
        },
        messages: {
            username: "",
            email: "",
            password1: "",
            password2: ""
        }
    });

    /* Submission of the form */
    signupform.on("submit", function(event) {
        if ($(this).valid()) {
            $.ajax({
                type: "POST",
                url: "confirmation.php",
                data: signupform.serialize(),
                success: function(result) {
                    $("#signupcontainer").hide().html(result).slideDown("slow"); // Slide down at slow speed
                }
            });
            event.preventDefault();
        }
    });
});