<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: error_pages/405.html");
    exit("405 Method Not Allowed");
}

$city = $_POST["city"]; 
$num_people = $_POST["numpeople"];

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "hoteles";

try {
    //start new connection
    $db = new PDO("mysql:host=$servername; dbname=$dbname", $dbusername, $dbpassword);

    // set the PDO error mode to exception
    $db->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $city_name = $db->quote($city);

    $result = $db->query("SELECT * FROM hoteles WHERE ciudad = $city_name");

    $items = array();
    if ($result->rowCount() > 0) {
        foreach ($result as $row) {
            $items[] = array('imagen' => $row['img'], 'nombre' => $row['nombre'], 'ciudad' => $row['ciudad'], 'pais' => $row['pais'], 'num_personas' => $num_people, 'zona' => $row['zona'], 'piscina' => $row['piscina']);
        }
    }
    echo json_encode($items);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$db = null;
?>