<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){ // No debemos permitir que si las cookies estan habilitadas puedan entrar en el signup
    header("Location: error_pages/405.html");
    exit("405 Method Not Allowed");
}


if(count($_POST)>0){
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Si hacemos una nueva petición al servidor antes de todo limpiamos la sesion actual...
    if(isset($_SESSION["email"]) && (strcmp($_SESSION["email"], trim($email))==0) && (strcmp($_SESSION["password"], trim($password))==0)){
        echo "You are already logged! Close to go to mainpage!";
        header("Location: index.html");
        exit;
    }else{
        include 'signout.php';
    }

    session_start();
    
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
            if(strcmp(md5($password), $exists_mail["password"]) == 0){
                // Session for the server and save PHPSESSID into Client
                $_SESSION["email"] = $exists_mail["email"];
                $_SESSION["password"] = $exists_mail["password"];
                $_SESSION["username"] = $exists_mail["name"];

                setcookie("username", $exists_mail["name"], time()+(3600*24*7));
                
                if(!empty($_POST["rememberme"])){
                    // Cookies for the client (7 days of duration)
                    setcookie("email", $exists_mail["email"], time()+(3600*24*7));
                    setcookie("password", $password, time()+(3600*24*7));
                    setcookie("rememberme", "Yes", time()+(3600*24*7));
                    $_SESSION["rememberme"] = "Yes";
                }else{
                    if(isset($_COOKIE["email"])){ setcookie("email", "", time() - 1); }
                    if(isset($_COOKIE["password"])){ setcookie("password", "", time() - 1); }
                    setcookie("rememberme", "No", time()+(3600*24*7)); 
                    $_SESSION["rememberme"] = "No";               
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