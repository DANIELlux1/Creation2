<?php

    include "db_classes.php";

    $db['db_host'] = 'localhost';
    $db['db_user'] = 'root';
    $db['db_pass'] = '';
    $db['db_name'] = 'creation_v2';

    foreach($db as $key => $value){
        define(strtoupper($key), $value);
    }

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(!$connection){
        echo "Something Wrong with the connection...";
    }else{

        $content = file_get_contents("testStyle.json");

        $query = "SELECT css_style FROM CSS WHERE css_id = 1";

        $fetch_css = mysqli_query($connection, $query);

        

        if(!$fetch_css)
        {
            die("QUERY FAILED: " . mysqli_error($connection));
        }else{
            $css = mysqli_fetch_all($fetch_css, MYSQLI_ASSOC);
            
            $test = new CSS($css);

            echo json_encode($test);
        }
    }

?>