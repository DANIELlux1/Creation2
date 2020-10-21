<?php

    include "db_classes.php";

    class HTMLGenerator {
        
        static function generateHTML(){
            $htmlPage  = "<!DOCTYPE html>\n";
            $htmlPage .= "<html lang='en'>\n";
            $htmlPage .= "  <head lang='en'>\n";
            $htmlPage .= "      <meta charset='utf-8'>\n";
            $htmlPage .= "      <title> test </title>\n";
            $htmlPage .= "      <style> </style>\n";
            $htmlPage .= "  </head>\n";
            $htmlPage .= "</html>\n";

            file_put_contents("test.html", $htmlPage);

        }
    }

    HTMLGenerator::generateHTML();

?>