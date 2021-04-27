// https://www.howtocreate.co.uk/referencedvariables.html
// city.observe("keyup", checkRegex(city, city_pattern)); // NOT WORKING

// Some information was extracted from https://getbootstrap.com/docs/5.0/forms/validation/

document.observe("dom:loaded", function() {
    var form = $("signupform");

    let username_pattern = /^[a-zA-Z0-9](_(?!(\.|_))|\.(?!(_|\.))|[a-zA-Z0-9]){6,18}[a-zA-Z0-9]$/; // Rules here https://stackoverflow.com/questions/12018245/regular-expression-to-validate-username
    let email_pattern = /^[^\s@]+@[^\s@]+$/; // Rules here https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
    let password_pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[\_\-\/$%&·#]).{8,32}$/; // Rules on https://www.section.io/engineering-education/password-strength-checker-javascript/

    let pattern_array = [username_pattern, email_pattern, password_pattern, password_pattern];

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
                }

                if ($F(element) === "") {
                    if (element.classList.contains('is-valid')) {
                        element.classList.remove('is-valid');
                    }
                    if (element.classList.contains('is-invalid')) {
                        element.classList.remove('is-invalid');
                    }
                }

                if (index === 3) {
                    passwordComprobation();
                }
            });
        }
    });

    form.observe("submit", function(event) {
        // A partir de aqui debemos recuperar los hoteles 

        // Debemos hacer una request
        new Ajax.Request("confirmation.php", {
            method: "POST",
            parameters: { username: $F($("usernamefield")), email: $F($("emailfield")), password: $F($("psw1field")) },
            onSuccess: successfulResponse,
            onFailure: failedResponse
        });

        // ES LA MANERA CORRECTA DE REALIZAR EL REFRESCO EN LA MISMA PAGINA ?
        event.preventDefault(); // Evita que la página vuelva a ser cargada 

        // Si llamamos a la function de exito fuera del ambito del handler la pagina vuelve a recargar
    });
});

// Function to check if psw1 and psw2 are equal and set validation parameters
function passwordComprobation() {
    psw1 = $("psw1field");
    psw2 = $("psw2field");

    if ($F(psw1) === $F(psw2)) {
        if (psw2.classList.contains('is-invalid'))
            psw2.classList.replace('is-invalid', 'is-valid');
        else
            psw2.classList.add('is-valid');
        psw2.setCustomValidity("");
    } else {
        if (psw2.classList.contains('is-valid'))
            psw2.classList.replace('is-valid', 'is-invalid');
        else
            psw2.classList.add('is-invalid');
        psw2.setCustomValidity("Passwords doesn't match");
    }
}

function successfulResponse(ajax) {
    if (ajax.status === 200)
        $("signupcontainer").innerHTML = ajax.responseText;
}

function failedResponse(ajax) {
    alert("Failed Response");
    console.log("Failed response");
}