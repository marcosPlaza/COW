<?php
$city = $_POST["city"]; // It works
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

    echo '<h3><i class="fas fa-search" style="color: gray;"></i> Check the results of your search</h3>';
    if ($result->rowCount() > 0) {
        foreach ($result as $row) {
            echo '<hr>';
            echo '<div class="card mb-3" style="margin-left: 5%; margin-right: 5%">';
            echo '<img src="';
            echo $row['img'];
            echo '" style="height: 350px; object-fit: cover;" alt="Card image cap">';
            echo '<div class="card-body" style="text-align: left">';
            echo '<h3 class="contenttitleslight">';
            echo $row['nombre'];
            echo ' on <strong>';
            echo $row['ciudad'];
            echo '</strong>   <span class="badge badge-secondary" style="margin-left: 10px;">Not rated</span></h3>';
            echo '<h5>';
            echo $row['pais'];
            echo '</h5>';
            echo '<span class="fa fa-star"></span>';
            echo '<span class="fa fa-star"></span>';
            echo '<span class="fa fa-star"></span>';
            echo '<span class="fa fa-star"></span>';
            echo '<span class="fa fa-star"></span>';
            echo '<hr>';
            echo '<p class="card-text">Accommodation for ';
            echo $num_people;
            echo ' people  located in a ';
            echo $row['zona'];
            echo ' area. </p>';
            if ($row['piscina'] == 1)
                echo '<p class="card-text" style="color: green">Swimming pool available   <i class="fas fa-swimmer" ></i></p>';
            else
                echo '<p class="card-text" style="color: darkred">Swimming pool not available   <i class="fas fa-times"></i></p>';
            echo '<div style="text-align: right">';
            echo '<a href="#" class="btn btn-primary">Show available rooms</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<hr>';
        echo '<h3><i class="fas fa-times-circle" style="color: darkred"></i> No hotels registered on <strong>';
        echo $city_name;
        echo '</strong></h3>';
    }
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$db = null;
?>