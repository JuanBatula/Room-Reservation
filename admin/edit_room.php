<?php
include '../connect.php';
include '../includes/header.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM tbroom WHERE room_id=$id"));
?>

<h2>Edit Room</h2>

<form method="POST">
<pre>
Room Name:
<input type="text" name="room"
value="<?php echo $data['room_name']; ?>">

Capacity:
<input type="number" name="capacity"
value="<?php echo $data['capacity']; ?>">

Status:
<select name="status">
    <option value="Available" <?php if($data['status'] == 'Available') echo 'selected'; ?>>Available</option>
    <option value="Occupied" <?php if($data['status'] == 'Occupied') echo 'selected'; ?>>Occupied</option>
</select>

<input type="submit" name="btnUpdate" value="Update">
</pre>
</form>

<?php
if(isset($_POST['btnUpdate'])){
    $room_name = $_POST['room'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $sql_update = "UPDATE tbroom SET room_name = '".$room_name."', capacity = ".$capacity.", status = '".$status."' WHERE room_id = $id";
    mysqli_query($connection, $sql_update);

    echo "<script language='javascript'>
            alert('Record updated successfully.');
          </script>";
    
    header("location: rooms.php");
}
?>