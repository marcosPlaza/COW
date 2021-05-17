<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
    exit("405 Method Not Allowed");
}

$name = $_POST["minombre"];
$email = $_POST["email"];

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

    $quoted_name = $conn->quote($name);

    // mail is supposed to be a unique field
    $exists_user = $conn->query("SELECT * FROM students WHERE name = $quoted_name");

    if ($exists_user->rowCount() > 0) { // Usuario existe
        echo '<h5 style="color:green">';
        echo 'Usuario existente';
        echo '</h5>';
    } else {
        echo '<h5 style="color:red">';
        echo 'Usuario no existente';
        echo '</h5>';
    }
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>