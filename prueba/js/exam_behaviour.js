document.observe("dom:loaded", function() {
    var form = $("form");

    var mailpattern = /^[a-zA-Z]+@+[a-zA-Z]+\.[a-zA-Z]{3}$/;

    /* Submission of the form */
    form.observe("submit", function(event) {
        console.log($F($("minombre")))
        console.log($F($("email")).match(mailpattern))
        if ($F($("email")).match(mailpattern)) {
            console.log("Email introducido correctamente");
            new Ajax.Request("server.php", {
                method: "POST",
                parameters: {
                    minombre: $F($("minombre")),
                    email: $F($("email")),
                },
                onSuccess: successfulResponse,
                onFailure: failedResponse
            });
        } else {
            alert("Error en el formulario");
        }
        event.preventDefault(); // Evita que la página vuelva a ser cargada 
    });
});

function successfulResponse(ajax) {
    if (ajax.status === 200) {
        $("registereduser").innerHTML = ajax.responseText;
    }
}

function failedResponse(ajax) {
    alert("Failed Response");
    console.log("Failed response");
}