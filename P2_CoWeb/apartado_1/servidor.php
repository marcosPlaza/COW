<html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>The Poké-Booking Service | Hey trainer, where do you wanna go?</title>

    <link rel="stylesheet" href="bootstrap-4.3.1_v2/css/bootstrap.min.css" type="text/css">
    <link href="fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">

    <script src="bootstrap-4.3.1_v2/js/jquery.min.js"></script>
    <script src="bootstrap-4.3.1_v2/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1_v2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/style_apartado2.css" type="text/css">
    <link rel="shortcut icon" href="images/pokeball.png">
</head>

<body>
    <nav class="navbar">

        <!-- envoltorio del titulo -->
        <div class="titlebox" href=#>
            <h1 class="navbartextlight">The <b>Poké-B<img src="images/pokeball_small.png"><img src="images/pokeball_small.png">king</b> Service</h1>
            <h5 class="navbartextlight">Book hotels around the Poké-globe</h5>
        </div>

        <!-- botones del navbar -->
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="First group">
                <button type="button" class="btn"><i class="fa fa-question-circle" style="color: white;"></i>
                    <h7 class="navbartextlight"> Need help?</h7>
                </button>
            </div>
            <div class="btn-group mr-2" role="group" aria-label="Second group">
                <button type="button" class="btn btn-info"><i class="fas fa-user-plus" style="color: white;"></i>
                    <h7 class="navbartext"> Sign Up</h7>
                </button>
            </div>
            <div class="btn-group mr-2" role="group" aria-label="Third group">
                <button type="button" class="btn btn-info"><i class="fas fa-sign-in-alt" style="color: white;"></i>
                    <h7 class="navbartext"> Sign In</h7>
                </button>
            </div>
            <div class="btn-group mr-2" role="group" aria-label="Third group">
                <button type="button" class="btn"><i class="fab fa-github" style="color: white;"></i>
                    <h7 class="navbartextlight"> <a href="https://github.com/marcosPlaza" target="_blank" style="color: white;">About me</a></h7>
                </button>
            </div>
        </div>
    </nav>
    <!-- Fin navbar -->

    <!-- Inicio alert -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 0px;">
        <div class="alerttext">
            <i class="fas fa-meh"></i> Hey trainer! Take care of your Pokémon and before traveling, check the situation of the pandemic. For more <strong>Pokérus</strong> support <a href="https://www.serebii.net/games/pokerus.shtml">click here</a>.
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- Fin alert -->

    <div class="container-fluid wrapper">
        <div class="box">
            <div class="content">
                <!-- Server en PHP -->
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //Recepción de datos
                    $city = htmlspecialchars($_POST["city"]);
                    $trip_start = htmlspecialchars($_POST["trip_start"]);
                    $trip_end = htmlspecialchars($_POST["trip_end"]);
                    $num_people = (int)$_POST["num_people"];

                    //Patrones que deben coincidir
                    $city_pattern = "/^([a-zA-Z]+|[a-zA-Z]+\s[a-zA-Z]+)$/i";
                    $date_pattern = "/^(20)([2-4][1-9]|50)(-)(((0)[1-9])|((1)[0-2]))(-)([0-2][0-9]|(3)[0-1])$/i";
                    $num_people_pattern = "/^([1-9]|[1-4]\d|50)$/i";

                    // Checking input values with regex
                    if (!preg_match($city_pattern, $city) || !preg_match($date_pattern, $trip_start) || !preg_match($date_pattern, $trip_end) || !preg_match($num_people_pattern, $num_people)) {
                        header("Location: 400.html");
                    }

                    //Substituir por página principal
                    echo "<h3>We have found so many coincidences with the following params given:</h3>\n";
                    echo "<h5><strong>City introduced was: </strong>$city</h5>\n";
                    echo "<h5><strong>Check in introduced was: </strong>$trip_start</h5>\n";
                    echo "<h5><strong>Check out introduced was: </strong>$trip_end</h5>\n";
                    echo "<h5><strong>Number of people introduced was: </strong>$num_people</h5>\n";
                } else {
                    header("Location: 405.html");
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Inicio footer -->
    <footer class="fixed-bottom ">
        <h7 class="navbartextlight ">Marcos Plaza González. Computació Orientada al web. Pràctica 2, apartat 1.</h7>
    </footer>
    <!-- Final footer -->

</body>

</html>