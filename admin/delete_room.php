<?php
include '../connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM tbroom WHERE room_id = $id";
mysqli_query($connection, $sql_update);

echo "<script language='javascript'>
            alert('Record deleted successfully.');
          </script>";

header("location: rooms.php");
?>