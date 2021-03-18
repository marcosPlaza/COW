<!-- Server en PHP -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Recepción de datos
    $city = $_POST["city"];
    $trip_start = $_POST["trip_start"];
    $trip_end = $_POST["trip_end"];
    $num_people = $_POST["num_people"];

    //Patrones que deben coincidir
    $city_pattern = "/^([a-zA-Z]+|[a-zA-Z]+\s[a-zA-Z]+)$/i";
    $date_pattern = "/^(20)([2-4][1-9]|50)(-)(((0)[1-9])|((1)[0-2]))(-)([0-2][0-9]|(3)[0-1])$/i";
    $num_people_pattern = "/^([1-9]|[1-4]\d|50)$/i";

    // Checking input values with regex
    if(!preg_match($city_pattern, $city) || !preg_match($date_pattern, $trip_start) || !preg_match($date_pattern, $trip_end) || !preg_match($num_people_pattern, $num_people)){
        header("Location: 400.html");
    }

    //Substituir por página principal
    echo "<h2>We have found so many coincidences with the following params given:\n";
    echo "$city\n";
    echo "$trip_start\n";
    echo "$trip_end\n";
    echo "$num_people\n";

}else{
    header("Location: 405.html");
}
?>