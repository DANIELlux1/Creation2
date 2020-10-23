<?php 

/********************************************************
                        Web Page
*********************************************************/

    class WebPage {
        public $webPageId;
        public $webPageName;
        public $pages = [];

        private $indexing = [];

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

            if(!array_key_exists($i, $this->indexing)){
                $this->indexing[$i] = count($this->indexing);

                array_push($this->pages, new Page($id, $class, $name, $shown));
            }

            $this->pages[$this->indexing[$i]]->addFrame($fetch);
        }
    }

/********************************************************
                        Page
*********************************************************/

    class Page {
        public $pageId;
        public $pageClass;
        public $pageName;
        public $pageShown;
        public $frames = [];

        private $indexing = [];

        function __construct($id, $class, $name, $shown){
            $this->pageId       = $id;
            $this->pageClass    = $class;
            $this->pageName     = $name;
            $this->pageShown    = ($shown == '0' ? false : true);
        }

        function addFrame($fetch){
            $i        = $fetch["frame_container_id"];
            $id       = $fetch["frame_id"];
            $class    = $fetch["frame_class"];
            $type     = $fetch["frame_type"];
            $name     = $fetch["frame_name"];
            $show     = $fetch["frame_show"];

            if(!array_key_exists($i, $this->indexing)){
                $this->indexing[$i] = count($this->indexing);

                array_push($this->frames, new Frame($id, $class, $type, $name, $show, $this->indexing[$i]));
            }

            $this->frames[$this->indexing[$i]]->addPanel($fetch);
        }

    }

/********************************************************
                        Frame
*********************************************************/

    class Frame {
        public $frameId;
        public $frameClass;
        public $frameType;
        public $frameName;
        public $frameShow;
        public $position;
        public $panels = [];

        private $indexing = [];

        function __construct($id, $class, $type, $name, $show, $pos = 0){
            $this->frameId      = $id;
            $this->frameClass   = $class;
            $this->frameType    = $type;
            $this->frameName    = $name;
            $this->frameShow    = ($show == '0' ? false : true);
            $this->position    = $pos;
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

            if(!array_key_exists($i, $this->indexing)){
                $this->indexing[$i] = count($this->indexing);
                array_push($this->panels, new Panel($id, $class, $type, $name));
            }

            $this->panels[$this->indexing[$i]]->addContent($fetch);
        }
    }

/********************************************************
                        Panel
*********************************************************/

    class Panel {
        public $panelId;
        public $panelClass;
        public $panelName;
        public $panelType;
        public $contents = [];

        private $indexing = [];

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

            if(!array_key_exists($i, $this->indexing)){
                $this->indexing[$i] = count($this->indexing);

                array_push($this->contents, new Content($id, $class, $type, $value, $selected));
            }

        }
    }

/********************************************************
                        Content
*********************************************************/    

    class Content {
        public $contentId;
        public $contentType;
        public $contentClass;
        public $contentValue;
        public $contentSelected = "false";
        //var $panelId;

        function __construct($id, $class, $type, $value, $selected){
            $this->contentId        = $id;
            $this->contentType      = $type;
            $this->contentClass     = $class;
            $this->contentValue     = $value;
            $this->contentSelected  = false;
        }
    }

/************************************************************
 *                          CSS
 ************************************************************/


 class CSS {

    var $styles = [];

    function __construct($fetch)
    {
        $data = json_decode($fetch[0]["css_style"]);
        foreach($data->styles as $style)
        {
            array_push($this->styles, new StyleCSS($style->class, $style->style));
        }
    }
 }

 class StyleCSS {

    var $class;
    var $style;

    function __construct($cssClass, $cssStyle)
    {
        $this->class = $cssClass;
        $this->style = $cssStyle;
    }


 }

?>