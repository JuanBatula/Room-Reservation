<?php
include '../connect.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

    mysqli_query($connection,
    "DELETE FROM tbuser WHERE user_id=$id");

    header("location: users.php");
}
?>