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
    }


    $id = mysqli_real_escape_string($connection, $_GET['id']);


    $query =  " SELECT * FROM Panel ";
    $query .=  " INNER JOIN PanelContainer ON PanelContainer.panel_id = Panel.panel_id ";
    $query .=  " INNER JOIN Frame ON Frame.frame_id = PanelContainer.frame_id ";
    $query .=  " INNER JOIN ContentContainer ON ContentContainer.panel_id = Panel.panel_id ";
    $query .=  " INNER JOIN ContentField ON ContentField.content_id = ContentContainer.content_id ";
    $query .=  " WHERE PanelContainer.frame_id = $id; ";
     
    $frame = mysqli_query($connection, $query);

    if(!$frame)
    {
        die("QUERY FAILED: " . mysqli_error($connection));
    }else{
        $frame = mysqli_fetch_all($frame, MYSQLI_ASSOC);

        $temp = $frame[0];

        $test = new Frame(  $temp["frame_id"],
                            $temp["frame_class"],
                            $temp["frame_type"],
                            $temp["frame_name"],
                            $temp["frame_show"] );

        foreach($frame as $data){
            $test->addPanel($data);
        }

        echo $test->printJSON();
    } 


    /*
    
    SELECT * FROM Panel 
    INNER JOIN PanelContainer ON PanelContainer.panel_id = Panel.panel_id
    INNER JOIN Frame ON Frame.frame_id = PanelContainer.frame_id
    INNER JOIN ContentContainer ON ContentContainer.panel_id = Panel.panel_id
    INNER JOIN ContentField ON ContentField.content_id = ContentContainer.content_id
    WHERE PanelContainer.frame_id = 0;
    
    */

?>