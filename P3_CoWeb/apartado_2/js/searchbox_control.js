// https://www.howtocreate.co.uk/referencedvariables.html
// city.observe("keyup", checkRegex(city, city_pattern)); // NOT WORKING

// Some information was extracted from https://getbootstrap.com/docs/5.0/forms/validation/

document.observe("dom:loaded", function() {
    var form = $("searchbox");

    let city_pattern = /^('|([0-9]{1,2}))?([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$/;
    let date_pattern = /^(20)([2-4][1-9]|50)(-)(((0)[1-9])|((1)[0-2]))(-)([0-2][1-9]|[1-2][0-9]|(3)[0-1])$/;
    let numpeople_pattern = /^([1-9]|[1-4]\d|50)$/;

    let pattern_array = [city_pattern, date_pattern, date_pattern, numpeople_pattern]

    $A(form).forEach((element, index) => {
        if (element.tagName === 'INPUT') {
            element.observe("keyup", function() {
                // CHECK REGEX
                if (!pattern_array[index].match($F(element))) {
                    element.setCustomValidity("Incorrect input was introduced!");
                    if (element.classList.contains('is-valid'))
                        element.classList.replace('is-valid', 'is-invalid');
                    else
                        element.classList.add('is-invalid');
                } else {
                    element.setCustomValidity("");
                    if (element.classList.contains('is-invalid'))
                        element.classList.replace('is-invalid', 'is-valid');
                    else
                        element.classList.add('is-valid');

                    if (index === 0) {
                        // NO FUNCIONA BIEN 
                        var xmlhttp = new XMLHttpRequest(); // simplified for clarity

                        xmlhttp.open("POST", "gethint.php?q=" + $F(element), true); // sending as POST
                        xmlhttp.send();

                        xmlhttp.onreadystatechange = function() { //Call a function when the state changes.
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { // complete and no errors
                                $("cityfield").innerHTML += xmlhttp.responseText;
                            }
                        };
                        /*new Ajax.Autocompleter(
                            element,
                            'autoCompleteMenu', 'gethint.php', {
                                ignoreCase: true
                            }
                        );*/
                    }
                }

                if ($F(element) === "") {
                    if (element.classList.contains('is-valid')) {
                        element.classList.remove('is-valid');
                    }
                    if (element.classList.contains('is-invalid')) {
                        element.classList.remove('is-invalid');
                    }
                }

                // DATES COMPROBATION
                if (index === 1 || index === 2) {
                    checkin = $("checkinfield");
                    checkout = $("checkoutfield");

                    checkin_date = new Date($F(checkin)); // temporal dates
                    checkout_date = new Date($F(checkout));

                    if (isValidDate(checkin_date) && isValidDate(checkout_date)) {
                        if (checkin_date > checkout_date) {
                            if (checkin.classList.contains('is-valid'))
                                checkin.classList.replace('is-valid', 'is-invalid');
                            else
                                checkin.classList.add('is-invalid');

                            if (checkout.classList.contains('is-valid'))
                                checkout.classList.replace('is-valid', 'is-invalid');
                            else
                                checkout.classList.add('is-invalid');

                            checkin.setCustomValidity("Invalid check-in");
                            checkout.setCustomValidity("Invalid check-out");
                        } else {
                            if (checkin.classList.contains('is-invalid'))
                                checkin.classList.replace('is-invalid', 'is-valid');
                            else
                                checkin.classList.add('is-valid');

                            if (checkout.classList.contains('is-invalid'))
                                checkout.classList.replace('is-invalid', 'is-valid');
                            else
                                checkout.classList.add('is-valid');

                            checkin.setCustomValidity("");
                            checkout.setCustomValidity("");
                        }
                    } else {
                        if (!isValidDate(checkin_date)) {
                            if (element.classList.contains('is-valid')) {
                                checkin.classList.replace('is-valid', 'is-invalid');
                            }
                        }
                        if (!isValidDate(checkin_date)) {
                            if (element.classList.contains('is-valid')) {
                                checkin.classList.replace('is-valid', 'is-invalid');
                            }
                        }
                    }
                }
            });
        }
    });

    form.observe("submit", function(event) {
        alert("Valid form");
        /*is_valid = true;

        $A(form).forEach(element => {
            if (element.tagName === 'INPUT') {
                if ($F(element) == "") {
                    element.classList.add('is-invalid');
                    // hint rellena campo
                    element.setCustomValidity("Fill this field!");
                }

                if (element.classList.contains('is-invalid')) {
                    is_valid = false;
                    // hint revisa el campo
                    element.setCustomValidity("Incorrect input was introduced!");
                }
            }
        });

        // STOP THE SUBMISSION AND ALSO PARENT'S EVENTS
        if (!is_valid) {
            alert("MAL");
            event.preventDefault();
            event.stopPropagation();
            return false;
        } else {
            alert("BIEN");
        }*/

    });
});

// Function to check valid date
function isValidDate(d) {
    return d instanceof Date && !isNaN(d);
}