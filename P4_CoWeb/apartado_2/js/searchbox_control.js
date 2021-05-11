$(document).ready(function() {
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

    /* Autocomplete */
    $("#city").autocomplete({
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
                    console.log(error);
                }
            });
        },
        minlength: 1
    });

    /* Form validation */
    var searchform = $("#searchboxform");

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
        if ($(this).valid()) {
            // Convert into a JSON string
            var jsondata = JSON.stringify({ "city": $('#city').val(), "daterangepicker": $('#daterangepicker').val(), "numpeople": $('#numpeople').val() });

            $.ajax({
                type: "POST",
                url: "gethotels.php",
                data: { formData: jsondata },
                success: function(result) {
                    // Get the htmlcontent and json, on result
                    var result_array = jsonParser(result);

                    // Update the content
                    var htmlcontent = result_array[0];
                    $("#hotelsfound").hide().html(htmlcontent).slideDown("slow"); // Slide down at slow speed

                    // Here will be the parsed json objects
                    var hotels = result_array[1];

                    // Display the table inside a modal
                    var rows = $('#jsonDetails').children();
                    if (rows.length != 0) {
                        rows.remove();
                    }

                    if (hotels.length != 0) {
                        $.each(hotels, function(index) {
                            $('<tr>\
                            <td>' + hotels[index]["nombre"] + '</td>\
                            <td>' + hotels[index]["ciudad"] + '</td>\
                            <td>' + hotels[index]["pais"] + '</td>\
                            <td>' + hotels[index]["num_personas"] + '</td>\
                            <td>' + hotels[index]["zona"] + '</td>\
                            <td>' + hotels[index]["piscina"] + '</td>\
                            </tr>').appendTo($('#jsonDetails'));
                        });
                    } else {
                        $('<tr>\
                            <td>None</td>\
                            <td>None</td>\
                            <td>None</td>\
                            <td>None</td>\
                            <td>None</td>\
                            <td>None</td>\
                            </tr>').appendTo($('#jsonDetails'));
                    }

                    $('#exampleModal').modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
            event.preventDefault();
        }
    });
});

// JSON Parser
function jsonParser(result) {
    // Getting the indexes
    var startJsonIdx = result.indexOf("[");
    var lastJsonIdx = result.lastIndexOf("]");
    var jsonString = result.substring(startJsonIdx, lastJsonIdx + 1);

    // Returning the html content and then the json objects in a single array
    return [result.substring(0, startJsonIdx), JSON.parse(jsonString)];
}

/**
 * Duda:
 * Debemos implementar nosotros mismos el parser y codificar debidamente el json en php?
 */