<?php
    include "db.php";
    include "db_classesv2.php";
    include "get_functions.php";

    if(isset($_GET['frame'])){
        getFrame($_GET['frame']);
    }
    if(isset($_GET['style'])){
        getStyle($_GET['style']);
    }
    if(isset($_GET['page'])){
        getPage($_GET['page']);
    }
    if(isset($_GET['frametype'])){
        getFrameTypes();
    }
?>