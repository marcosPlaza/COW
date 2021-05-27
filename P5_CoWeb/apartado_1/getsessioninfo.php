<?php
session_start();
if(isset($_SESSION["username"])){
    echo "Sesion de "+$_SESSION["username"];
}else{
    echo "No hay sesion";
}
?>