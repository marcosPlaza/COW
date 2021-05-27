// https://www.howtocreate.co.uk/referencedvariables.html
// city.observe("keyup", checkRegex(city, city_pattern)); // NOT WORKING

// Some information was extracted from https://getbootstrap.com/docs/5.0/forms/validation/

$(document).ready(function() {
    // GET ALL COOKIES
    var allCookies = document.cookie.split(";");

    allCookies.forEach(element => {
        var name_value = element.split("=");
        var cookie_name = name_value[0];
        var cookie_value = name_value[1];


        if (cookie_name.trim() == "email") {
            $("#email").val(decodeURIComponent(cookie_value.trim()));
        }

        if (cookie_name.trim() == "password") {
            $("#password").val(decodeURIComponent(cookie_value.trim()));
        }

        if (cookie_name.trim() == "rememberme") {
            if (cookie_value.trim() == "Yes") {
                //$("#rememberme")[0].checked = true;
                $("#rememberme").prop('checked', true);
            } else {
                //$("#rememberme")[0].checked = false;
                $("#rememberme").prop('checked', false);
            }
        }

    });


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
                    if (result == "Incorrect password!" || result == "User do not exists!") {
                        $("#incorrect_login").text(result);
                    } else {
                        $(document.location.href = "index.html");
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
            event.preventDefault();
        }
    });
});