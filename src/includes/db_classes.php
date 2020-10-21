<?php 

/********************************************************
                        Web Page
*********************************************************/

    class WebPage {
        var $webPageId;
        var $webPageName;
        var $pages = [];

        function __construct($id, $name){
            $this->webPageId = $id;
            $this->webPageName = $name;
        }


        function addPage($fetch){
            $i        = $fetch["page_container_id"];
            $id       = $fetch["page_id"];
            $class    = $fetch["page_class"];
            $name     = $fetch["page_name"];
            $shown    = $fetch["page_shown"];

            if(!array_key_exists($i, $this->pages)){
                $this->pages[$i] = new Page($id, $class, $name, $shown);
            }

            $this->pages[$i]->addFrame($fetch);
        }

        function printJSON(){
            $i=0;
            $jsonObj  = '{ "webPageId": "'    . $this->webPageId    . '",';
            $jsonObj .=   '"webPageName": "'  . $this->webPageName  . '",';
            $jsonObj .= '"pages": [';
            foreach($this->pages as $page)
            {
                $jsonObj .= $page->printJSON();
                if($i < count($this->pages) - 1)
                {
                    $jsonObj .= ",";
                }
                $i++;
            }
            $jsonObj .= ']}';

            return $jsonObj;
        }

    }

/********************************************************
                        Page
*********************************************************/

    class Page {
        var $pageId;
        var $pageClass;
        var $pageName;
        var $pageShown;
        var $frames = [];

        function __construct($id, $class, $name, $shown){
            $this->pageId       = $id;
            $this->pageClass    = $class;
            $this->pageName     = $name;
            $this->pageShown    = ($shown == '0' ? "false" : "true");
        }

        function addFrame($fetch){
            $i        = $fetch["frame_container_id"];
            $id       = $fetch["frame_id"];
            $class    = $fetch["frame_class"];
            $type     = $fetch["frame_type"];
            $name     = $fetch["frame_name"];
            $show     = $fetch["frame_show"];

            if(!array_key_exists($i, $this->frames)){
                $this->frames[$i] = new Frame($id, $class, $type, $name, $show);
            }

            $this->frames[$i]->addPanel($fetch);
        }

        function printJSON(){
            $i=0;
            $jsonObj  = '{';
            $jsonObj .= '"pageId": "'   .   $this->pageId    . '",';
            $jsonObj .= '"pageClass": "'.   $this->pageClass . '",';
            $jsonObj .= '"pageName": "' .   $this->pageName  . '",';
            $jsonObj .= '"pageShown": ' .   $this->pageShown . ',';
            $jsonObj .= '"frames": [';

            foreach($this->frames as $frame)
            {
                $jsonObj .= $frame->printJSON();
                if($i < count($this->frames) - 1)
                {
                    $jsonObj .= ",";
                }
                $i++;
            }

            $jsonObj .= "]}";

            return $jsonObj;

        }
    }

/********************************************************
                        Frame
*********************************************************/

    class Frame {
        var $frameId;
        var $frameClass;
        var $frameType;
        var $frameName;
        var $frameShow;
        var $pos = 0;
        
        var $panels = [];

        function __construct($id, $class, $type, $name, $show){
            $this->frameId      = $id;
            $this->frameClass   = $class;
            $this->frameType    = $type;
            $this->frameName    = $name;
            $this->frameShow    = ($show == '0' ? "false" : "true");
        }

        function addPanel($fetch){
            $i         = $fetch["panel_container_id"];
            $id        = $fetch["panel_id"];
            $class     = $fetch["panel_class"];
            $type      = $fetch["panel_type"];
            if(isset($fetch["position"]))                   //PLEASE FIX SOMETIME SOON.
            {
                $this->pos = $fetch["position"];
            }
            $name      = $fetch["panel_name"];

            if(!array_key_exists($i, $this->panels)){
                $this->panels[$i] = new Panel($id, $class, $type, $name);
            }

            $this->panels[$i]->addContent($fetch);
        }

        function printJSON(){
            $i=0;
            $jsonObj  = '{';
            $jsonObj .= '"frameId": "'   .   $this->frameId    . '",';
            $jsonObj .= '"frameClass": "'.   $this->frameClass . '",';
            $jsonObj .= '"frameType": "' .   $this->frameType  . '",';
            $jsonObj .= '"frameName": "' .   $this->frameName  . '",';
            $jsonObj .= '"position": '   .   $this->pos        . ',';
            $jsonObj .= '"frameShow": '  .   $this->frameShow  . ',';
            $jsonObj .= '"panels": [';

            foreach($this->panels as $panel)
            {
                $jsonObj .= $panel->printJSON();
                if($i < count($this->panels) - 1)
                {
                    $jsonObj .= ",";
                }
                $i++;
            }

            $jsonObj .= "]}";

            return $jsonObj;

        }
    }

/********************************************************
                        Panel
*********************************************************/

    class Panel {
        var $panelId;
        var $panelClass;
        var $panelName;
        var $panelType;
        var $contents = [];

        function __construct($id, $class, $type, $name){
            $this->panelId      =   $id;
            $this->panelClass   =   $class;
            $this->panelName    =   $type;
            $this->panelType    =   $name;
        }

        function addContent($fetch){
            $i        = $fetch["content_container_id"];
            $id       = $fetch["content_id"];
            $class    = $fetch["content_class"];
            $type     = $fetch["content_type"];
            $value    = $fetch["content_value"];
            $selected = $fetch["content_selected"];
            $contents = [];

            if(!array_key_exists($i, $this->contents)){
                $this->contents[$i] = new Content($id, $class, $type, $value, $selected);
            }

        }

        function printJSON(){
            $i=0;
            $jsonObj  = '{';
            $jsonObj .=     '"panelId": "'   .   $this->panelId    . '",';
            $jsonObj .=     '"panelClass": "'.   $this->panelClass . '",';
            $jsonObj .=     '"panelName": "' .   $this->panelName  . '",';
            $jsonObj .=     '"panelType": "' .   $this->panelType  . '",';
            $jsonObj .=     '"contents": [';

            foreach($this->contents as $content)
            {
                $jsonObj .= $content->printJSON();
                if($i < count($this->contents) - 1)
                {
                    $jsonObj .= ",";
                }
                $i++;
            }

            $jsonObj .= "]}";

            return $jsonObj;

        }
    }

/********************************************************
                        Content
*********************************************************/    

    class Content {
        var $contentId;
        var $contentType;
        var $contentClass;
        var $contentValue;
        var $contentSelected;
        //var $panelId;

        function __construct($id, $class, $type, $value, $selected){
            $this->contentId        = $id;
            $this->contentType      = $type;
            $this->contentClass     = $class;
            $this->contentValue     = $value;
            $this->contentSelected  = "false";
        }

        function printJSON(){

            $jsonObj  = '{';
            $jsonObj .=     '"contentId": "'        .   $this->contentId        . '",';
            $jsonObj .=     '"contentType": "'      .   $this->contentType      . '",';
            $jsonObj .=     '"contentClass": "'     .   $this->contentClass     . '",';
            $jsonObj .=     '"contentValue": "'     .   $this->contentValue     . '",';
            $jsonObj .=     '"contentSelected": '   .   $this->contentSelected  . '';
            $jsonObj .= '}';

            return $jsonObj;

        }
    }

/************************************************************
 *                          CSS
 ************************************************************/


 class CSS {

    var $styles = [];

    function __construct($fetch)
    {
        $temp = json_decode($fetch[0]["css_style"]);
        foreach($temp->styles as $style)
        {
            array_push($this->styles, new StyleCSS($style->class, $style->style));
        }
    }

    function printJSON(){
        $i = 0;
        $jsonObj = '{ "styles": [';

        foreach($this->styles as $style)
        {
            $jsonObj .= $style->printJSON();
            if($i++ < count($this->styles)-1)
            {
                $jsonObj .= ",";
            }
        }

        $jsonObj .= "]}";
        return $jsonObj;
    }
 }

 class StyleCSS {

    var $cssClass;
    var $cssStyle;

    function __construct($cssClass, $cssStyle)
    {
        $this->cssClass = $cssClass;
        $this->cssStyle = $cssStyle;
    }

    function printJSON(){

        $i = 0;
        $jsonObj  = '{';
        $jsonObj .= '"class": "' . $this->cssClass . '",';
        $jsonObj .= '"style": [';
        foreach($this->cssStyle as $value)
        {
            $jsonObj .= '"'. $value .'"';
            if($i++ < count($this->cssStyle)-1)
            {
                $jsonObj .= ",";
            }
        }
        $jsonObj .= "]}";

        return $jsonObj;
    }
 }

?>