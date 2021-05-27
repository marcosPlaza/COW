<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: error_pages/405.html");
    exit("405 Method Not Allowed");
}

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

    // Solucion 2. Consiste en poner el id de la tabla simpsons>students en autoincrementable
    // $sql1 = "ALTER TABLE students MODIFY id INT AUTO_INCREMENT;";

    // $conn->exec($sql1);

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
?>