// el evento onload se ejecuta una vez el html se ha cargado completamente
/*window.onload = function() { // Maybe we can name a function setup
    var form = $("searchbox");
    form.onsubmit = checkInputData;
}*/

// Alternativa a la funcion de arriba a continuación
document.observe("dom:loaded", function() {
    $("searchbox").observe("change", checkInputData);
    /*$("cityfield").observe("change", checkCity);
    $("checkinfield").observe("change", checkCheckIn);
    $("checkoutfield").observe("change", checkCheckOut);
    $("numpeoplefield").observe("change", checkNumPeople);*/
});

// Funcion para revisar que los campos sean correctos
// check this link https://getbootstrap.com/docs/5.0/forms/validation/
function checkInputData(event) {
    var city = $("cityfield");
    var checkin = $("checkinfield");
    var checkout = $("checkoutfield");
    var numpeople = $("numpeoplefield");

    let city_pattern = /^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$/;
    let date_pattern = /^(20)([2-4][1-9]|50)(-)(((0)[1-9])|((1)[0-2]))(-)([0-2][0-9]|(3)[0-1])$/;
    let numpeople_pattern = /^([1-9]|[1-4]\d|50)$/;

    if (!city_pattern.match($F(city))) {
        event.preventDefault();
        city.style.borderColor = "#FF0000";
        city.style.boxShadow = "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)";
        return false;
    } else {
        city.style.borderColor = "rgba(0, 0, 0, 0)";
        city.style.boxShadow = "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)";
    }

    if (!date_pattern.match($F(checkin))) {
        event.preventDefault();
        checkin.style.borderColor = "#FF0000";
        checkin.style.boxShadow = "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)";
        return false;
    } else {
        checkin.style.borderColor = "rgba(0, 0, 0, 0)";
    }

    if (!date_pattern.match($F(checkout))) {
        event.preventDefault();
        checkout.style.borderColor = "#FF0000";
        checkout.style.boxShadow = "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)";
        return false;
    } else {
        checkout.style.borderColor = "rgba(0, 0, 0, 0)";
    }

    if (!numpeople_pattern.match($F(numpeople))) {
        event.preventDefault();
        numpeople.style.borderColor = "#FF0000";
        numpeople.style.boxShadow = "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)";
        return false;
    } else {
        numpeople.style.borderColor = "rgba(0, 0, 0, 0)";
    }
}

/*function checkCity(event) {
    var city = $("cityfield");
    let city_pattern = /^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$/;

    if (!city_pattern.match($F(city))) {
        event.preventDefault();
        // change color
        return false;
    }
}

function checkCheckIn(event) {
    var checkin = $("checkinfield");
    let date_pattern = /^(20)([2-4][1-9]|50)(-)(((0)[1-9])|((1)[0-2]))(-)([0-2][0-9]|(3)[0-1])$/;

    if (!date_pattern.match($F(checkin))) {
        event.preventDefault();
        //change color
        return false;
    }
}

function checkCheckOut(event) {
    var checkout = $("checkoutfield");
    let date_pattern = /^(20)([2-4][1-9]|50)(-)(((0)[1-9])|((1)[0-2]))(-)([0-2][0-9]|(3)[0-1])$/;

    if (!city_pattern.match($F(city))) {
        event.preventDefault();
        //
        return false;
    }
}

function checkNumPeople(event) {
    var numpeople = $("numpeoplefield");
    let numpeople_pattern = /^([1-9]|[1-4]\d|50)$/;

    if (!city_pattern.match($F(city))) {
        event.preventDefault();
        city.style.borderColor = "red";
        return false;
    }
}*/