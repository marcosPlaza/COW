$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: "checksession.php",
        success: function(result) {
            if (result === "Session restarted!") {
                $("#exampleModalLabel").text(result);
                $('#exampleModal').on("hide.bs.modal", function() {
                    location.reload();
                });
                $('#exampleModal').modal('show');
            }
        },
        failure: function(failure) {
            console.log("Failure on checking session");
        },
        error: function(error) {
            console.log("Error on checking session");
        }
    });

    // GET ALL COOKIES
    var allCookies = document.cookie.split(";");

    var session_started = false;

    // LOOK IF THERE'S A "username" COOKIE
    allCookies.forEach(element => {
        var name_value = element.split("=");
        var cookie_name = name_value[0];
        var cookie_value = name_value[1];

        if (cookie_name.trim() == "username") {
            session_started = true;
            $("#nameholder").text("Welcome! " + decodeURIComponent(cookie_value));
            $("#username").text(decodeURIComponent(cookie_value));
        }
    });

    // SET THE CORRECT VIEW
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
        $("#welcome").hide()
        $("#signoutbtn").hide();
        $("#userinfo").hide();
        $("#signinbtn").show();
        $("#signupbtn").show();
    }

    // Implement Accordion-Sortable
    var regionlist = $("#elements");

    regionlist.accordion({
        collapsible: true,
        active: false,
        height: 'fill',
        header: 'h5'
    }).sortable({
        items: '.s_panel',
        update: function() {
            if (regionlist.sortable('toArray').join('') == '12345678')
                confetti.start(5000);
        }
    });

    regionlist.on('accordionactivate', function(event, ui) {
        if (ui.newPanel.length) {
            $('#accordion').sortable('disable');
        } else {
            $('#accordion').sortable('enable');
        }
    });

    var searchform = $("#searchboxform");

    /* Autocomplete */
    searchform.children().first().children().last().autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "gethint.php",
                type: "POST",
                dataType: "json", // JSON Parser will be used for retrieved data
                data: { q: request.term },
                success: function(data) {
                    response(data);
                },
                error: function(error) {
                    console.log("Error on getting hint");
                }
            });
        },
        minlength: 1
    });

    /* Form validation */
    $.validator.addMethod('cityNamePattern', function(value) {
        return /^('|([0-9]{1,2}))?([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$/.test(value);
    }, 'Invalid name!');

    $.validator.addMethod('dateRangePattern', function(value) {
        return /^(((0)[1-9])|((1)[0-2]))(\/)((0)[1-9]|(1)[0-9]|(2)[0-9]|(3)[0-1])(\/)((20)([2-4][1-9]|50)) - (((0)[1-9])|((1)[0-2]))(\/)((0)[1-9]|(1)[0-9]|(2)[0-9]|(3)[0-1])(\/)((20)([2-4][1-9]|50))$/.test(value);
    }, 'Invalid date!');

    $.validator.addMethod('numPeoplePattern', function(value) {
        return /^([1-9]|[1-4]\d|50)$/.test(value);
    }, 'Invalid number of people!');

    searchform.validate({
        validClass: "is-valid",
        errorClass: "is-invalid",
        rules: {
            city: {
                required: true,
                cityNamePattern: true
            },
            daterangepicker: {
                required: true,
                dateRangePattern: true
            },
            numpeople: {
                required: true,
                numPeoplePattern: true
            }
        },
        messages: {
            city: "",
            daterangepicker: "",
            numpeople: ""
        }
    });

    /* Date range picker */
    $('#daterangepicker').daterangepicker();

    /* Submission of the form */
    searchform.on("submit", function(event) {
        // Cliente - Servidor
        // Creacion de la string XML
        var xmlstring = '<?xml version="1.0" encoding="UTF-8"?><form><city>' + $('#city').val() + '</city><date>' + $('#daterangepicker').val() + '</date><numpeople>' + $('#numpeople').val() + '</numpeople></form>';

        if ($(this).valid()) {
            $.ajax({
                type: "POST",
                url: "gethotels.php",
                // Pasamos la string directamente
                data: { formData: xmlstring },
                success: function(result) {
                    // Get the htmlcontent and json, on result
                    var result_array = xmlParser(result);

                    // Update the content
                    var htmlcontent = result_array[0];
                    $("#hotelsfound").hide().html(htmlcontent).slideDown("slow"); // Slide down at slow speed
                },
                error: function(error) {
                    console.log("Error on getting hotels");
                }
            });
            event.preventDefault();
        }
    });
});

// XML Parser
function xmlParser(response) {
    // Getting the indexes
    var startXmlIdx = response.indexOf("<?xml");
    var lastXmlIdx = response.lastIndexOf(">");
    var xmlString = response.substring(startXmlIdx, lastXmlIdx + 1);

    // Returning the html content and then the xml objects in a single array
    return [response.substring(0, startXmlIdx), xmlString];
}