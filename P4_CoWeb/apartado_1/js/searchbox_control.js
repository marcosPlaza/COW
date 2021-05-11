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
                dataType: "json",
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
            $.ajax({
                type: "POST",
                url: "gethotels.php",
                data: searchform.serialize(),
                success: function(result) {
                    $("#hotelsfound").hide().html(result).slideDown("slow"); // Slide down at slow speed
                },
                error: function(error) {
                    console.log(error);
                }
            });
            event.preventDefault();
        }
    });
});