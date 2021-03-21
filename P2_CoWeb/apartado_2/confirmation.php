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

    <?php
    function check_password($p1, $p2)
    {
        if (strcasecmp($p1, $p2) == 0) return false;
        return true;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //Recepción de datos
        $username = $_GET["username"];
        $email = $_GET["email"];
        $password1 = $_GET["password1"];
        $password2 = $_GET["password2"];

        // Checking input values with regex
        if (!check_password($password1, $password2)) {
            header("Location: 400.html");
        }

        $servername = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "simpsons";

        try {
            //start new connection
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $dbusername, $dbpassword);


            // set the PDO error mode to exception
            $conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            /*            $sql = "INSERT INTO students (id, name, email, password) VALUES ( '$username', '$email', '$password1')";
            $conn->exec($sql);*/
            $stmt = $conn->prepare("INSERT INTO students(id, name, email, password) VALUES(?,?,?,?);");
            $last_id = $conn->lastInsertId();
            $stmt->execute([$last_id+1, $username, $email, $password]);

        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    } else {
        header("Location: 405.html");
    }

    $conn = null;
    ?>

    <div class="container" style="padding-top: 30px; padding-bottom: 30px;">
        <div class="card bg-light" style="box-shadow: 5px 5px 10px #888888;">
            <div class="content" style="padding-bottom: 100px;">
                <h4 class="card-title mt-3 text-center">Congratulations! Your account has been created successfully <i class="fas fa-check-circle" style="color: green"></i></h4>
                <a href="http://localhost/COW/P2_CoWeb/apartado_2/home.php">Back to Poké-Booking homepage</a>
            </div>
        </div> <!-- card.// -->
    </div>
    <!--container end.//-->

    <!-- Inicio footer -->
    <footer class="fixed-bottom ">
        <h7 class="navbartextlight ">Marcos Plaza González. Computació Orientada al web. Pràctica 2, apartat 1.</h7>
    </footer>
    <!-- Final footer -->

</body>

</html>