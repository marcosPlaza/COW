<?php
session_start();

if(isSet($_SESSION["email"])){
    // Establecer tiempo de vida de la sesión en segundos - unos 10 minutos = 60 * 10
    $inactividad = 600; // TODO poner 600

    // https://diego.com.es/sesiones-en-php
    // Comprobar si $_SESSION["timeout"] está establecida
    if(isSet($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
            session_regenerate_id(true);
            $_SESSION["timeout"] = time();
            echo "Session restarted!";
        }
    }
}
?>