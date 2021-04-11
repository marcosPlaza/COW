// https://www.howtocreate.co.uk/referencedvariables.html
// city.observe("keyup", checkRegex(city, city_pattern)); // NOT WORKING

// Some information was extracted from https://getbootstrap.com/docs/5.0/forms/validation/

document.observe("dom:loaded", function() {
    var tooltip = document.querySelector('.tooltip')

    tooltip.addEventListener('click', function() {
        if (this.classList.contains('active')) {
            this.classList.remove('active');
        } else {
            this.classList.add('active');
        }

    });
    var form = $("searchbox");

    let city_pattern = /^('|([0-9]{1,2}))?([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$/;
    let date_pattern = /^(20)([2-4][1-9]|50)(-)(((0)[1-9])|((1)[0-2]))(-)([0-2][0-9]|(3)[0-1])$/;
    let numpeople_pattern = /^([1-9]|[1-4]\d|50)$/;

    let pattern_array = [city_pattern, date_pattern, date_pattern, numpeople_pattern]

    $A(form).forEach((element, index) => {
        if (element.tagName === 'INPUT') {
            element.observe("keyup", function() {
                if (!pattern_array[index].match($F(element))) {
                    element.setCustomValidity("Incorrect input was introduced!");
                    if (element.classList.contains('is-valid'))
                        element.classList.replace('is-valid', 'is-invalid');
                    else
                        element.classList.add('is-invalid');
                } else {
                    element.setCustomValidity("Correct");
                    if (element.classList.contains('is-invalid'))
                        element.classList.replace('is-invalid', 'is-valid');
                    else
                        element.classList.add('is-valid');
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
    });

    form.observe("submit", function(event) {
        is_valid = true;

        $A(form).forEach(element => {
            if (element.tagName === 'INPUT') {
                if ($F(element) == "")
                    element.classList.add('is-invalid');

                if (element.classList.contains('is-invalid'))
                    is_valid = false;
            }
        });

        checkin = $("checkinfield");
        checkout = $("checkoutfield");

        // DATES COMPROBATION
        checkin_date = new Date($F(checkin));
        checkout_date = new Date($F(checkout));

        if (checkin_date > checkout_date) {
            checkin.setCustomValidity("This date is incorrect!");
            checkin.classList.add('is-invalid');
            is_valid = false;
        } else {
            checkin.setCustomValidity("");
        }

        // STOP THE SUBMISSION AND ALSO PARENT'S EVENTS
        if (!is_valid) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
    });
});