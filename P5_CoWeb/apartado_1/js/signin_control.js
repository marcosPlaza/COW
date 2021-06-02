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

        if (cookie_name.trim() == "email") {
            $("#email").val(decodeURIComponent(cookie_value.trim()));
        }

        if (cookie_name.trim() == "password") {
            $("#password").val(decodeURIComponent(cookie_value.trim()));
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
        if ($(this).valid()) {
            $.ajax({
                type: "POST",
                url: "signin.php",
                data: signinform.serialize(),
                success: function(result) {
                    if (result == "Incorrect password!" || result == "User do not exists!") {
                        $("#incorrect_login").text(result);
                    } else if (result == "You are already logged! Close to go to mainpage!") {
                        $("#aviso").text(result);
                        $('#exampleModal').on("hide.bs.modal", function() {
                            $(document.location.href = "index.html");
                        })
                        $('#exampleModal').modal('show');
                    } else {
                        $(document.location.href = "index.html");
                    }
                },
                failure: function(failure) {
                    console.log("Failure on sign in");
                },
                error: function(error) {
                    console.log("Error on sign in");
                }
            });
            event.preventDefault();
        }
    });
});