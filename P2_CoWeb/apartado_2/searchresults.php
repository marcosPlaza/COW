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
        <div class="titlebox">
            <a href="http://localhost/COW/P2_CoWeb/apartado_2/home.php">
                <h1 class="navbartextlight">The <b>Poké-B<img src="images/pokeball_small.png"><img src="images/pokeball_small.png">king</b> Service</h1>
                <h5 class="navbartextlight">Book hotels around the Poké-globe</h5>
            </a>
        </div>

        <!-- botones del navbar -->
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="First group">
                <button type="button" class="btn"><i class="fa fa-question-circle" style="color: white;"></i>
                    <h7 class="navbartextlight"> Need help?</h7>
                </button>
            </div>
            <div class="btn-group mr-2" role="group" aria-label="Second group">
                <a type="button" class="btn btn-info" href="http://localhost/COW/P2_CoWeb/apartado_2/signup.php"><i class="fas fa-user-plus" style="color: white;"></i>
                    <h7 class="navbartext"> Sign Up</h7>
                </a>
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

    <div class="container-fluid wrapper" style="padding-bottom: 10px; padding-left:15%; padding-right: 15%">
        <div class="box">
            <div class="content">
                <h3><i class="fas fa-search" style="color: gray;"></i> Check the results of your search</h3>
                <hr>
                <!-- Server en PHP -->
                <?php

                //Function to determine correctness of the check in/out dates - USAR JavaScript posteriormente?¿
                function check_dates($checkin, $checkout)
                {
                    $date1 = strtotime($checkin);
                    $date2 = strtotime($checkout);

                    if ($date1 > $date2) return false;
                    return true;
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //Recepción de datos
                    $city = htmlspecialchars($_POST["city"]);
                    $trip_start = $_POST["trip_start"];
                    $trip_end = $_POST["trip_end"];
                    $num_people = (int)$_POST["num_people"];

                    //Patrones que deben coincidir
                    $city_pattern = "/^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$/i"; // UNUSED because of names like ´s-Hertogenbosch. Using htmlspecialchars to prevent code injection
                    $date_pattern = "/^(20)([2-4][1-9]|50)(-)(((0)[1-9])|((1)[0-2]))(-)([0-2][0-9]|(3)[0-1])$/i";
                    $num_people_pattern = "/^([1-9]|[1-4]\d|50)$/i";

                    // Checking input values with regex
                    if (!preg_match($date_pattern, $trip_start) || !preg_match($date_pattern, $trip_end) || !preg_match($num_people_pattern, $num_people) || !check_dates($trip_start, $trip_end)) {
                        header("Location: 400.html");
                    }

                    $servername = "localhost";
                    $dbusername = "root";
                    $dbpassword = "";
                    $dbname = "world";
                    $dbname2 = "hoteles";

                    try {
                        //start new connection
                        $db = new PDO("mysql:host=$servername; dbname=$dbname", $dbusername, $dbpassword);
                        $db2 = new PDO("mysql:host=$servername; dbname=$dbname2", $dbusername, $dbpassword);

                        // set the PDO error mode to exception
                        $db->setAttribute(
                            PDO::ATTR_ERRMODE,
                            PDO::ERRMODE_EXCEPTION
                        );

                        $db2->setAttribute(
                            PDO::ATTR_ERRMODE,
                            PDO::ERRMODE_EXCEPTION
                        );

                        $city_name = $db->quote($city);
                        $result = $db->query("SELECT * FROM cities WHERE name = $city_name")->fetch();

                        if (!empty($result)){
                            echo '<div class="card" style="margin-left: 5%; margin-right:5%">';
                            echo '<ul class="list-group">';
                            echo '<li class="list-group-item active"><i class="fas fa-info-circle"></i> Information about: <strong>';
                            echo $city_name;
                            echo '</strong></li>';
                            echo '<li class="list-group-item"><strong>Country: </strong>';
                            echo $result['country_code'];
                            echo '</li>';
                            echo '<li class="list-group-item"><strong>District: </strong>';
                            echo $result['district'];
                            echo '</li>';
                            echo '<li class="list-group-item"><strong>Population: </strong>';
                            echo $result['population'];
                            echo '</li>';
                            echo '</ul>';
                            echo '</div>';
                            echo '<hr>';
                        }else{
                            echo '<h3><i class="fas fa-times-circle" style="color: darkred"></i> No information for <strong>';
                            echo $city;
                            echo '</strong></h3>';
                            echo '<hr>';
                        }

                        $result2 = $db2->query("SELECT * FROM hoteles WHERE ciudad = $city_name");

                        if ($result2->rowCount() > 0) {
                            foreach ($result2 as $row) {
                                echo '<div class="card mb-3" style="margin-left: 5%; margin-right: 5%">';
                                    echo '<img src="'; echo $row['img']; echo '" style="height: 350px; object-fit: cover;" alt="Card image cap">';
                                    echo '<div class="card-body" style="text-align: left">';
                                        echo '<h3 class="contenttitleslight">'; echo $row['nombre']; echo ' on <strong>'; echo $row['ciudad']; echo '</strong>   <span class="badge badge-secondary" style="margin-left: 10px;">Not rated</span></h3>';
                                        echo '<h5>'; echo $row['pais']; echo '</h5>';
                                        echo '<span class="fa fa-star"></span>';
                                        echo '<span class="fa fa-star"></span>';
                                        echo '<span class="fa fa-star"></span>';
                                        echo '<span class="fa fa-star"></span>';
                                        echo '<span class="fa fa-star"></span>';
                                        echo '<hr>';
                                        echo '<p class="card-text">Accommodation for '; echo $num_people; echo ' people  located in a '; echo $row['zona']; echo ' area. </p>';
                                        if($row['piscina'] == 1)
                                            echo '<p class="card-text" style="color: green">Swimming pool available   <i class="fas fa-swimmer" ></i></p>';
                                        else
                                            echo '<p class="card-text" style="color: darkred">Swimming pool not available   <i class="fas fa-times"></i></p>';
                                        echo '<div style="text-align: right">';
                                            echo '<a href="#" class="btn btn-primary">Show available rooms</a>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<h3><i class="fas fa-times-circle" style="color: darkred"></i> No hotels registered on <strong>';
                            echo $city_name;
                            echo '</strong></h3>';
                        }
                    } catch (PDOException $e) {
                        echo $sql . "<br>" . $e->getMessage();
                    }
                    $db = null;
                    $db2 = null;
                } else {
                    header("Location: 405.html");
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Inicio footer -->
    <footer class="fixed-bottom ">
        <h7 class="navbartextlight ">Marcos Plaza González. Computació Orientada al web. Pràctica 2, apartat 2.</h7>
    </footer>
    <!-- Final footer -->

</body>

</html>