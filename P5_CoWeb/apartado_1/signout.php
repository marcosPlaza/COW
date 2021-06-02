<?php
session_start();
session_unset(); // Eliminamos todas las variables de sesion
if(isset($_COOKIE["username"])){ setcookie("username", "", time() - 1); }
session_regenerate_id(true);
?>