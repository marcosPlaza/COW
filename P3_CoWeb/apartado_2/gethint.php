<?php
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
        /*foreach($result as $city){
            var_dump($city["name"]);
        }*/
        //var_dump($result);
        //echo '<select class="form-control" multiple aria-label="multiple select example">';
        echo '<datalist id="citylist">';
        if ($q !== "") {
            $q = strtolower($q);
            $len=strlen($q);
            foreach($result as $name) {
                $name = strtolower($name["name"]);
                if (stristr($q, substr($name, 0, $len))) {
                    if ($hint === "") {
                        echo '<option value=';
                        $hint = $name;
                        echo $hint;
                        echo '></option>';
                    } else {
                        echo '<option value=';
                        $hint = $name;
                        echo $hint;
                        echo '></option>';
                    }
                }
            }
        }
        //echo '</select>';
        echo '</datalist>';

        /*echo '<select class="form-control" multiple aria-label="multiple select example">';
        echo '<option>';
        echo $q;
        echo '</option>';
        foreach ($result as $cityname) {
            echo '<option>';
            echo $cityname["name"];
            echo '</option>';
        }

        echo '</select>';*/


    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $db = null;
?>