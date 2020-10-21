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
    }

    //SELECT frame_name, frame_id FROM Frame WHERE frame_preset = true; 

    $query =  " SELECT frame_name, frame_id ";
    $query .= " FROM Frame ";
    $query .= " WHERE frame_preset = true; ";

    $fetch_Frames = mysqli_query($connection, $query);

    if(!$fetch_Frames)
    {
        die("QUERY FAILED: " . mysqli_error($connection));
    }else{
        $frameInfo = mysqli_fetch_all($fetch_Frames, MYSQLI_ASSOC);

        echo json_encode($frameInfo);
    } 

?>