<?php
session_start();

if(isSet($_SESSION["email"])){
    // Establecer tiempo de vida de la sesión en segundos - unos 10 minutos = 60 * 10
    $inactividad = 600;

    // Comprobar si $_SESSION["timeout"] está establecida
    if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
            session_regenerate_id();
            $_SESSION["timeout"] = time();
        }
    }
}
?>