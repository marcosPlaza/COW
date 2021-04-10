document.observe("dom:loaded", checkSearchBoxForm);

// Information extracted from https://getbootstrap.com/docs/5.0/forms/validation/
function checkSearchBoxForm() {
    var form = $("searchbox");

    var city = $("cityfield");
    var checkin = $("checkinfield");
    var checkout = $("checkoutfield");
    var numpeople = $("numpeoplefield");

    let city_pattern = /^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$/;
    let date_pattern = /^(20)([2-4][1-9]|50)(-)(((0)[1-9])|((1)[0-2]))(-)([0-2][0-9]|(3)[0-1])$/;
    let numpeople_pattern = /^([1-9]|[1-4]\d|50)$/;

    let citytuple = [city, city_pattern];
    let checkintuple = [checkin, date_pattern];
    let checkouttuple = [checkout, date_pattern];
    let numpeopletuple = [numpeople, numpeople_pattern];

    let checkValues_array = [citytuple, checkintuple, checkouttuple, numpeopletuple];

    form.observe("submit", function(event) {
        var was_invalid = false;

        // REGEX
        checkValues_array.forEach(element => {
            if (!element[1].match($F(element[0]))) {
                element[0].setCustomValidity("Incorrect input was introduced!");

                if (!was_invalid) {
                    was_invalid = true;
                }
            } else {
                element[0].setCustomValidity("");
            }
        });

        // DATES COMPROBATION
        checkin_date = new Date($F(checkin));
        checkout_date = new Date($F(checkout));

        if (checkin_date > checkout_date) {
            checkin.setCustomValidity("This date is incorrect!");

            if (!was_invalid) {
                was_invalid = true;
            }
        } else {

        }

        form.classList.add('was-validated');

        if (was_invalid) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
    });
}