<?php


    function escape_string($data){
        global $connection;
        return mysqli_real_escape_string($connection,$data);
    }

    function getPage($id){
        
        global $connection;

        $safeID = escape_string($id);

        $query = " SELECT * ";
        $query.= " FROM Page ";
        $query.= " INNER JOIN FrameContainer    ON FrameContainer.page_id = Page.page_id ";
        $query.= " INNER JOIN Frame 		    ON Frame.frame_id = FrameContainer.frame_id ";
        $query.= " INNER JOIN PanelContainer    ON PanelContainer.frame_id = Frame.frame_id ";
        $query.= " INNER JOIN Panel 		    ON PanelContainer.panel_id = Panel.panel_id ";
        $query.= " INNER JOIN ContentContainer  ON ContentContainer.panel_id = Panel.panel_id ";
        $query.= " INNER JOIN ContentField      ON ContentContainer.content_id = ContentField.content_id ";
        $query.= " INNER JOIN PageContainer     ON Page.page_id = PageContainer.page_id ";
        $query.= " WHERE PageContainer.page_id = $safeID;";

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

            //echo $test->printJSON();
            echo json_encode($test);
        }
    }

    function getStyle($id){
    
        global $connection;

        $safeID = escape_string($id);

        $query = "SELECT css_style FROM CSS WHERE css_id = $safeID";
    
        $fetch_css = mysqli_query($connection, $query);
    
        if(!$fetch_css){
            die("QUERY FAILED: " . mysqli_error($connection));
        }else{
            $css = mysqli_fetch_all($fetch_css, MYSQLI_ASSOC);
            
            $styles = new CSS($css);

            echo json_encode($styles);
        }
    }

    function getFrame($id){

        global $connection;
        $safeID = escape_string($id);

        $query  =  " SELECT * FROM Panel ";
        $query .=  " INNER JOIN PanelContainer ON PanelContainer.panel_id = Panel.panel_id ";
        $query .=  " INNER JOIN Frame ON Frame.frame_id = PanelContainer.frame_id ";
        $query .=  " INNER JOIN ContentContainer ON ContentContainer.panel_id = Panel.panel_id ";
        $query .=  " INNER JOIN ContentField ON ContentField.content_id = ContentContainer.content_id ";
        $query .=  " WHERE PanelContainer.frame_id = $safeID; ";
        
        $fetchedFrame = mysqli_query($connection, $query);

        if(!$fetchedFrame)
        {
            die("QUERY FAILED: " . mysqli_error($connection));
        }else{
            $frameData = mysqli_fetch_all($fetchedFrame, MYSQLI_ASSOC);

            $frame = $frameData[0];

            $frameObj = new Frame(  $frame["frame_id"],
                                    $frame["frame_class"],
                                    $frame["frame_type"],
                                    $frame["frame_name"],
                                    $frame["frame_show"] );

            foreach($frameData as $panel){
                $frameObj->addPanel($panel);
            }

            //echo $frameObj->printJSON();
            echo json_encode($frameObj);
        }
    }

    function getFrameTypes(){
        global $connection;
        
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
    }

?>