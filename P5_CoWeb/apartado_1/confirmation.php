<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: error_pages/405.html");
    exit("405 Method Not Allowed");
}

// Si hacemos una nueva petición al servidor antes de todo limpiamos la sesion actual...
if(isset($_SESSION["email"])){
    include 'signout.php';
}

session_start();


if(count($_POST)>0){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password1"];
    
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
    
        // Modify password camp to allow 32 char strings (hash password)
        $sql1 = "ALTER TABLE students MODIFY password char(50);";
    
        $conn->exec($sql1);
    
        $quoted_mail = $conn->quote($email);
    
        // mail is supposed to be a unique field
        $exists_mail = $conn->query("SELECT * FROM students WHERE email = $quoted_mail");
    
        // Solucion 1 - Cambiar!!! => Hecho 
        $new_id = $conn->query("SELECT * FROM students ORDER BY id DESC LIMIT 1")->fetch()['id'] + 1;

        $conn->beginTransaction();
        $sql = "INSERT INTO students (id, name, email, password) VALUES ('$new_id', '$username', '$email', '$password')";
        $conn->exec($sql);
    
        if ($exists_mail->rowCount() > 0) {
            $conn->rollBack();
            echo '<div class="container" style="padding-top: 30px; padding-bottom: 30px;">';
            echo '<div class="card bg-light" style="box-shadow: 5px 5px 10px #888888;">';
            echo '<div class="content" style="padding-bottom: 100px;">';
            echo '<h4 class="card-title mt-3 text-center">Upss! You are already a member...   <i class="fas fa-times-circle" style="color: darkred"></i></h4>';
            echo '<p><a href="#">Sign in</a>';
            echo ' or ';
            echo '<a href="index.html">get back to Poké-Booking homepage</a>.</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            $conn->commit();
            
            // Session for the server and save PHPSESSID into Client
            $_SESSION["email"] = trim($email);
            $_SESSION["password"] = trim($password);
            $_SESSION["username"] = trim($username);

            setcookie("username", $_SESSION["username"], time()+(3600*24*7));

            if(!empty($_POST["rememberme"])){
                // Cookies for the client (7 days of duration)
                setcookie("email", $_SESSION["email"], time()+(3600*24*7)); // Si se añade un timeout, son persistentes y se almacenan en el ordenador no en la memoria del navegador
                setcookie("password", $_SESSION["password"], time()+(3600*24*7)); // md5 to hash the password ?                    
                setcookie("rememberme", "Yes", time()+(3600*24*7));
                $_SESSION["rememberme"] = "Yes";
            }else{
                if(isset($_COOKIE["email"])){ setcookie("email", "", time() - 1); }
                if(isset($_COOKIE["password"])){ setcookie("password", "", time() - 1); }
                setcookie("rememberme", "No", time()+(3600*24*7)); 
                $_SESSION["rememberme"] = "No";               
            }

            echo '<div class="container" style="padding-top: 30px; padding-bottom: 30px;">';
            echo '<div class="card bg-light" style="box-shadow: 5px 5px 10px #888888;">';
            echo '<div class="content" style="padding-bottom: 100px;">';
            echo '<h4 class="card-title mt-3 text-center">Congratulations! Your account has been created successfully <i class="fas fa-check-circle" style="color: green"></i></h4>';
            echo '<a href="index.html">Back to Poké-Booking homepage</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
}
?>