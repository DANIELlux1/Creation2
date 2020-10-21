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



$query = " SELECT * ";
$query.= " FROM Page ";
$query.= " INNER JOIN FrameContainer    ON FrameContainer.page_id = Page.page_id ";
$query.= " INNER JOIN Frame 		    ON Frame.frame_id = FrameContainer.frame_id ";
$query.= " INNER JOIN PanelContainer    ON PanelContainer.frame_id = Frame.frame_id ";
$query.= " INNER JOIN Panel 		    ON PanelContainer.panel_id = Panel.panel_id ";
$query.= " INNER JOIN ContentContainer  ON ContentContainer.panel_id = Panel.panel_id ";
$query.= " INNER JOIN ContentField      ON ContentContainer.content_id = ContentField.content_id ";
$query.= " INNER JOIN PageContainer     ON Page.page_id = PageContainer.page_id ";
$query.= " WHERE PageContainer.page_id = 1;";

$generate_Frame = mysqli_query($connection, $query);

if(!$generate_Frame)
{
    die("QUERY FAILED: " . mysqli_error($connection));
}else{
    $frame = mysqli_fetch_all($generate_Frame, MYSQLI_ASSOC);

    $test = new WebPage("1", "TestWebPage");

    foreach($frame as $data){
        $test->addPage($data);
    }

    echo json_encode($test);
} 

?>