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
            element.observe("keyup", function() { // change supports firefox datepicker but no chrome datepicker
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

                    // Ajax Autocomplete only for city input
                    if (index === 0) {
                        var xmlhttp = new XMLHttpRequest(); // simplified for clarity

                        xmlhttp.onreadystatechange = function() { //Call a function when the state changes.
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { // complete and no errors
                                // DEVUELVE LOS VALORES A LA PRIMERA DE MANERA CORRECTA
                                $("cityfield").innerHTML += xmlhttp.responseText;
                                // POR OTRO LADO NO SE ACTUALIZAN LOS VALORES HASTA INTRODUCIDA LA SEGUNDA LETRA
                            }
                        };

                        xmlhttp.open("POST", "gethint.php?q=" + $F(element), true); // sending as POST
                        xmlhttp.send();
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
            });
        }

        if (index === 1 || index === 2) {
            element.observe("change", datesComprobation);
        }
    });

    // EXTRA COMPROBATION
    form.observe("submit", function(event) {
        // CODIGO INUTIL
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
            alert("Check out the values submitted!");
            event.preventDefault();
            event.stopPropagation();
            return false;
        } else {
            alert("BIEN");
        }*/

        // A partir de aqui debemos recuperar los hoteles 


        // Primero debemos hacer una request
        new Ajax.Request("gethotels.php", {
            method: "POST",
            parameters: { city: $F($("cityfield")), checkin: $F($("checkinfield")), checkout: $F($("checkoutfield")), numpeople: $F($("numpeoplefield")) },
            onSuccess: successfulResponse,
            onFailure: failedResponse,
            onException: exceptionResponse
        });

        event.preventDefault();

        // Si llamamos a la function de exito fuera del ambito del handler la pagina vuelve a recargar
        /*event.preventDefault();
        event.stopPropagation();
        return false;*/
    });
});

// Function to check valid date
function isValidDate(d) {
    return d instanceof Date && !isNaN(d);
}

// Function to check if checkin and checkout are valid
function datesComprobation() {
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
            if (checkin.classList.contains('is-valid')) {
                checkin.classList.replace('is-valid', 'is-invalid');
            }
        }
        if (!isValidDate(checkout_date)) {
            if (checkout.classList.contains('is-valid')) {
                checkout.classList.replace('is-valid', 'is-invalid');
            }
        }
    }
}


function successfulResponse(ajax) {
    // EN LLAMAR ESTA FUNCION LA PAGINA PARECE RECARGARSE RAPIDAMENTE Y NO LLEGAMOS A VER LOS RESULTADOS
    if (ajax.status === 200)
        $("hotelsfound").innerHTML = ajax.responseText;
}

function failedResponse(ajax) {
    alert("Failed response");
}

function exceptionResponse(ajax, exception) {
    alert("Exception response");
}

/**
 * ===================
 *      SUMMARY
 * ===================
 * 
 * FIREFOX
 * Autocomplete - Only with the first character introduced
 * Date picker - Works fine
 * 
 * SAFARI
 * Autocomplete - Works fine
 * Date picker - Works fine
 * 
 * CHROME
 * Autocomplete - Works fine
 * Date picker - Works fine
 * 
 *  ===================
 *      QUESTIONS
 *  ===================
 * ¿Debe funcionar con todos los navegadores obligatoriamente?
 * ¿Existe alguna forma más eficiente de cargar una única vez la base de datos y hacer la query (solo necesito el nombre de todas las ciudades)?
 */