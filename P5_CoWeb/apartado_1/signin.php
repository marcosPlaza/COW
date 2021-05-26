<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: error_pages/405.html");
    exit("405 Method Not Allowed");
}

/**
 * La idea es que si el usuario mantiene una sesion abierta cargue otro home diferente con sus datos presentes
 * De otra manera el usuario al registrarse o loguearse establecerá una session/cookie 
 * 
 * Duda. No se si es necesario establecer cookie o session. ¿Que diferencia existe entre una y otra?
 */

session_start();

$email = $_POST["email"];
$password = $_POST["password"];

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

    $quoted_mail = $conn->quote($email);

    // mail is supposed to be a unique field
    $exists_mail = $conn->query("SELECT * FROM students WHERE email = $quoted_mail")->fetch();

    if ($exists_mail != false) {
        if(strcmp($password, $exists_mail["password"]) == 0){
            $_SESSION["username"] = $exists_mail["name"];
            setcookie("username", $exists_mail["name"]);
            echo $_SESSION["username"];
        }else{
            echo "incorrect password";
            // Contraseña incorrecta
        }
    } else {
        echo "unexistent user";
        // Usuario con mail no existe
    }
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>