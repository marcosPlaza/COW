<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: error_pages/405.html");
    exit("405 Method Not Allowed");
}

$q = $_REQUEST["q"];

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "world";

try {
    //start new connection
    $db = new PDO("mysql:host=$servername; dbname=$dbname", $dbusername, $dbpassword);

    // set the PDO error mode to exception
    $db->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $result = $db->query("SELECT name FROM cities")->fetchAll();

    $hints = array();

    if ($q !== "") {
        $q = strtolower($q);
        $len = strlen($q);
        foreach ($result as $name) {
            $name = strtolower($name["name"]);
            if (stristr($q, substr($name, 0, $len))) {
                $hint = $name;
                $hints[] = $hint;
            }
        }
    }

    $json_hints = json_encode($hints);
    echo $json_hints; # Encoding in JSON

} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$db = null;
?>
