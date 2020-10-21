<?php

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

        $data = json_decode($content, true);
        $push = mysqli_real_escape_string($connection,json_encode($data, true));

        $query = "INSERT INTO CSS (css_style, css_preset) VALUES ('$push',1);";

        $fetch_Frames = mysqli_query($connection, $query);

        if(!$fetch_Frames)
        {
            die("QUERY FAILED: " . mysqli_error($connection));
        } 
    }

?>