<?php
    $connection = new mysqli('localhost','root','','dbroombooking');

    if(!$connection){
        die (mysqli_error($mysqli));
    }
?>
