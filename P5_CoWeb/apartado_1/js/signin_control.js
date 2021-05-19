// https://www.howtocreate.co.uk/referencedvariables.html
// city.observe("keyup", checkRegex(city, city_pattern)); // NOT WORKING

// Some information was extracted from https://getbootstrap.com/docs/5.0/forms/validation/

$(document).ready(function() {
    /* Form validation */
    var signinform = $("#signinform");

    $.validator.addMethod('passwordPattern', function(value) {
        return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[\_\-\/$%&·#]).{8,32}$/.test(value);
    }, 'Invalid password!');

    signinform.validate({
        validClass: 'is-valid',
        errorClass: 'is-invalid',
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                passwordPattern: true
            }
        },
        messages: {
            email: "",
            password: ""
        }
    });

    var checkbox = $('#rememberme');

    checkbox.on("change", function() {
        console.log($(this).val());
    });

    /* Submission of the form */
    signinform.on("submit", function(event) {
        console.log(signinform.serialize());
        if ($(this).valid()) {
            $.ajax({
                type: "POST",
                url: "signin.php",
                data: signinform.serialize(),
                success: function(result) {
                    // Cambiar los botones de la página principal
                    // A continuación redirigir a la página principal
                    $(document.location.href = "home.html");
                    $("#ejemplo").html(result); // Must contain only the name
                    //$("#exampleModal").modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
            event.preventDefault();
        }
    });
});