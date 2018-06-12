<?php

include 'header.php';

$current_page = "";
include 'nav1.php';

echo ('<div class="column grid_12">');
        if($progress_made == true)
        {
            echo ("<h5>" . $progress_info . "</h5>");
        } 
        
        if($error_met == true)
        {
            echo ("<br><br>" . "<h5>" . $error_info . "</h5>");
        }
echo ("</div>");

include 'footer.php';

?>