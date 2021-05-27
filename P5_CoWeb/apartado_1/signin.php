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


if(count($_POST)>0){
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
                session_start();
                // Session for the server and save PHPSESSID into Client
                $_SESSION["username"] = $exists_mail["name"];
                if(!empty($_POST["rememberme"])){
                    // Cookies for the client (30 days of duration)
                    setcookie("email", $exists_mail["email"], time()+(3600*24*7));
                    setcookie("password", $exists_mail["password"], time()+(3600*24*7)); // md5 to hash the password ?
                    setcookie("username", $exists_mail["name"], time()+(3600*24*7));
                    setcookie("rememberme", "Yes", time()+(3600*24*7));
                }else{
                    if(isset($_COOKIE["email"])){ setcookie("email", "", time() - 1); }
                    if(isset($_COOKIE["password"])){ setcookie("password", "", time() - 1); }
                    if(isset($_COOKIE["username"])){ setcookie("username", "", time() - 1); }
                    setcookie("rememberme", "No", time()+(3600*24*7));                
                }
            }else{
                // Contraseña incorrecta
                echo "Incorrect password!";
            }
        } else {
            // Usuario con mail no existe
            echo "User do not exists!";
        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
}
?>