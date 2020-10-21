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

        foreach($frame as $meme){
            $test->addPage($meme);
        }

        echo $test->printJSON();
    } 

    


/*


    S

    SELECT * 
    FROM Page
    INNER JOIN FrameContainer    ON FrameContainer.page_id = Page.page_id
    INNER JOIN Frame 		    ON Frame.frame_id = FrameContainer.frame_id
    INNER JOIN PanelContainer    ON PanelContainer.frame_id = Frame.frame_id
    INNER JOIN Panel 		    ON PanelContainer.panel_id = Panel.panel_id
    INNER JOIN ContentContainer  ON ContentContainer.panel_id = Panel.panel_id 
    INNER JOIN ContentField      ON ContentContainer.content_id = ContentField.content_id
    INNER JOIN PageContainer     ON Page.page_id = PageContainer.page_id
    INNER JOIN WebPage 			ON WebPage.web_id = PageContainer.web_id 
    WHERE Page.page_id = 1


    SELECT Frame.frame_id, Frame.frame_class, Frame.frame_type, Frame.frame_name, Frame.frame_show
    FROM Frame 
    INNER JOIN FrameContainer ON FrameContainer.frame_id = Frame.frame_id
    WHERE FrameContainer.page_id = 1;


    SELECT * 
    FROM Panel
    INNER JOIN PanelContainer ON Panel.panel_id = PanelContainer.panel_id
    INNER JOIN Frame ON Frame.frame_id = PanelContainer.frame_id
    INNER JOIN FrameContainer ON Frame.frame_id = FrameContainer.frame_id
    WHERE FrameContainer.page_id = 1;


    Array ( [page_id]               => 1
            [page_class]            => default-page
            [page_name]             => default_page_with_3_frames
            [page_shown]            => 1 
            [frame_container_id]    => 2 
            [frame_id]              => 1 
            [frame_class]           => default-4-panel 
            [frame_type]            => d4pFrame 
            [frame_name]            => default_4_panel_frame 
            [frame_show]            => 1 
            [panel_container_id]    => 1 
            [panel_id]              => 2 
            [panel_class]           => defaultTitle 
            [panel_name]            => default_title_panel 
            [panel_type]            => titlePanel 
            [content_container_id]  => 2 
            [content_id]            => 3 
            [content_type]          => title 
            [content_class]         => titleContent 
            [content_value]         => This is a Title 
            [content_selected]      => 0 ) 
*/

?>