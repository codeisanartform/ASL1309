<?php 

class View{

    function printHeader() {
         header("Content-type: text/html");
    }

    function getView($file='', $data='') {
        $fullPath = "/Users/bradbeltowski/Sites/php.ssl1306.com/views/$file.php";

            if (file_exists($fullPath)) {
                include($fullPath);
            } else {
		echo $fullPath;
	    }
    }
} 
?>
