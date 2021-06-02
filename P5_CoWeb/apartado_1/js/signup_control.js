$(document).ready(function() {
    // GET ALL COOKIES
    var allCookies = document.cookie.split(";");

    var session_started = false;

    allCookies.forEach(element => {
        var name_value = element.split("=");
        var cookie_name = name_value[0];
        var cookie_value = name_value[1];

        if (cookie_name.trim() == "username") {
            session_started = true;
            $("#nameholder").text("Welcome! " + decodeURIComponent(cookie_value));
        }

        if (cookie_name.trim() == "rememberme") {
            if (cookie_value.trim() == "Yes") {
                $("#rememberme").prop('checked', true);
            } else {
                $("#rememberme").prop('checked', false);
            }
        }

    });

    // UPDATE VIEW
    if (session_started) {
        $("#signinbtn").hide();
        $("#signupbtn").hide();
        $("#welcome").show();
        $("#signoutbtn").on("click", function() {
            $.ajax({
                type: "GET",
                url: "signout.php",
                success: function(result) {
                    $(document.location.href = "signin.html");
                },
                failure: function(failure) {
                    console.log("Failure on sign out");
                },
                error: function(error) {
                    console.log("Error on sign out");
                }
            });
        });
    } else {
        $("#signinbtn").show();
        $("#signupbtn").show();
        $("#welcome").hide()
        $("#signoutbtn").hide();
    }

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
        console.log(signupform.serialize());
        if ($(this).valid()) {
            $.ajax({
                type: "POST",
                url: "confirmation.php",
                data: signupform.serialize(),
                success: function(result) {
                    console.log("Success");
                    $("#signupcontainer").hide().html(result).slideDown("slow"); // Slide down at slow speed
                },
                failure: function(failure) {
                    console.log("Failure on sign up");
                },
                error: function(error) {
                    console.log("Error on sign up");
                }
            });
            event.preventDefault();
        }
    });
});