<?php
    echo '<title>SmartPond</title>';

    echo "<div>"; 
    include_once('view/header.php'); 
    echo "</div>";

    echo "<div>"; 
    include_once('view/sideBar.php'); 
    echo "</div>";

    echo "<div>"; 
        include_once('controller/controller.php'); 
    echo "</div>";
?>