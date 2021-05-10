// Some information was extracted from https://getbootstrap.com/docs/5.0/forms/validation/

$(document).ready(function() {
    // Implement Accordion-Sortable
    var regionlist = $("#elements");

    regionlist.sortable({
        update: function() {
            if (regionlist.sortable('toArray').join('') == '12345678')
                confetti.start(5000);
        }
    });

    /* Autocomplete */
    $("#city").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "gethint.php",
                type: "POST",
                dataType: "json", // JSON Parser will be used
                data: { q: request.term },
                success: function(data) {
                    response(data);
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
        var city = $(this).children().first().children().last().val();

        if ($(this).valid()) {
            $.ajax({
                type: "POST",
                url: "gethotels.php",
                data: searchform.serialize(),
                success: function(result) {
                    // Get the json on result and then parse
                    var hotels = jsonParser(result);
                    if (hotels.length != 0) {
                        alert('The JSON Object obtained is ' + hotels);
                        $.each(hotels, function(index) {
                            var htmlcontent = '<h3><i class="fas fa-search" style="color: gray;"></i> Check the results of your search</h3>\
                            <hr><div class="card mb-3" style="margin-left: 5%; margin-right: 5%"><img src="' + hotels[index]["imagen"] + '" style="height: 350px; object-fit: cover;" alt="Card image cap">\
                            <div class="card-body" style="text-align: left"><h3 class="contenttitleslight">' + hotels[index]["nombre"] + ' on <strong>' + hotels[index]["ciudad"] + '\
                            </strong>   <span class="badge badge-secondary" style="margin-left: 10px;">Not rated</span></h3><h5>' + hotels[index]["pais"] + '</h5>\
                            <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>\
                            <hr><p class="card-text">Accommodation for ' + hotels[index]["num_personas"] + ' people  located in a ' + hotels[index]["zona"] + ' area. </p>';

                            if (hotels[index]["piscina"] == 1) {
                                htmlcontent.concat('<p class="card-text" style="color: green">Swimming pool available   <i class="fas fa-swimmer" ></i></p>');
                            } else {
                                htmlcontent.concat('<p class="card-text" style="color: darkred">Swimming pool not available   <i class="fas fa-times"></i></p>');
                            }

                            htmlcontent.concat('<div style="text-align: right"><a href="#" class="btn btn-primary">Show available rooms</a></div></div></div>');

                            $("#hotelsfound").hide().html(htmlcontent).slideDown("slow"); // Slide down at slow speed
                        });
                    } else {
                        alert('The JSON Object obtained is empty');
                        var htmlcontent = '<h3><i class="fas fa-search" style="color: gray;"></i> Check the results of your search</h3><hr><h3><i class="fas fa-times-circle" style="color: darkred"></i> No hotels registered on <strong>\
                        ' + city + '</strong></h3>';
                        $("#hotelsfound").hide().html(htmlcontent).slideDown("slow"); // Slide down at slow speed
                    }

                }
            });
            event.preventDefault();
        }
    });
});

/* Envelope JSON.parse */
function jsonParser(json_encoded) {
    return JSON.parse(json_encoded);
}

/**
 * Duda:
 * Debemos implementar nosotros mismos el parser y codificar debidamente el json en php?
 */