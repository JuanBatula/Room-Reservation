<?php
include '../connect.php';
include '../includes/header.php';
?>

<h2>Add Room</h2>

<form method="POST">
<pre>
Room Name: <input type="text" name="txtroom">
Capacity:  <input type="number" name="txtcapacity">
Status:
<select name="txtstatus">
<option>Available</option>
<option>Unavailable</option>
</select>
<input type="submit" name="btnAdd" value="Add Room">
</pre>

</form>

<?php

if(isset($_POST['btnAdd'])){

$room = $_POST['txtroom'];
$capacity = $_POST['txtcapacity'];  
$status = $_POST['txtstatus'];

$sql = "INSERT INTO tbroom(room_name, capacity, status) VALUES('".$room."', ".$capacity.", '".$status."')"; 
mysqli_query($connection, $sql);

echo "<script language='javascript'>
            alert('New Record saved.');
          </script>";

header("location: rooms.php");

}
?>