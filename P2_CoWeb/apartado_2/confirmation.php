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
            <a href="home.php">
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
                <a type="button" class="btn btn-info" href="signup.php"><i class="fas fa-user-plus" style="color: white;"></i>
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

    <?php
    function check_password($p1, $p2)
    {
        if (strcmp($p1, $p2) == 0) return true;
        return false;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Recepción de datos
        $username = htmlspecialchars($_POST["username"]);
        $email = $_POST["email"];
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];

        $mail_pattern = "/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/i";

        // We need to check input values with regex
        if (!preg_match($mail_pattern, $email) || !check_password($password1, $password2)) {
            header("Location: 400.php");
            exit("400 Bad Request");
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

            // Solucion 2. Consiste en poner el id de la tabla simpsons>students en autoincrementable
            // $sql1 = "ALTER TABLE students MODIFY id INT AUTO_INCREMENT;";

            // $conn->exec($sql1);

            $quoted_mail = $conn->quote($email);

            // mail is supposed to be a unique field
            $exists_mail = $conn->query("SELECT * FROM students WHERE email = $quoted_mail");

            // Solucion 1 - Cambiar!!! => Hecho 
            $new_id = $conn->query("SELECT * FROM students ORDER BY id DESC LIMIT 1")->fetch()['id'] + 1;

            $conn->beginTransaction();

            $sql = "INSERT INTO students (id, name, email, password) VALUES ('$new_id', '$username', '$email', '$password1')";

            $conn->exec($sql);

            if ($exists_mail->rowCount() > 0) {
                $conn->rollBack();
                echo '<div class="container" style="padding-top: 30px; padding-bottom: 30px;">';
                echo '<div class="card bg-light" style="box-shadow: 5px 5px 10px #888888;">';
                echo '<div class="content" style="padding-bottom: 100px;">';
                echo '<h4 class="card-title mt-3 text-center">Upss! You are already a member...   <i class="fas fa-times-circle" style="color: darkred"></i></h4>';
                echo '<p><a href="#">Sign in</a>';
                echo ' or ';
                echo '<a href="home.php">get back to Poké-Booking homepage</a>.</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                $conn->commit();
                echo '<div class="container" style="padding-top: 30px; padding-bottom: 30px;">';
                echo '<div class="card bg-light" style="box-shadow: 5px 5px 10px #888888;">';
                echo '<div class="content" style="padding-bottom: 100px;">';
                echo '<h4 class="card-title mt-3 text-center">Congratulations! Your account has been created successfully <i class="fas fa-check-circle" style="color: green"></i></h4>';
                echo '<a href="home.php">Back to Poké-Booking homepage</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    } else {
        header("Location: 405.php");
        exit("405 Method Not Allowed");
    }
    $conn = null;
    ?>

    <!-- Inicio footer -->
    <footer class="fixed-bottom ">
        <h7 class="navbartextlight ">Marcos Plaza González. Computació Orientada al web. Pràctica 2, apartat 2.</h7>
    </footer>
    <!-- Final footer -->

</body>

</html>