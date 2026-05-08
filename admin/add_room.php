<?php
include '../connect.php';
include '../includes/header.php';
?>

<link rel="stylesheet" href="../styles/add_room.css">

<div class="topbar">
    <div class="topbar-left">
        <div class="topbar-accent"></div>
        <h1>Add room</h1>
    </div>
</div>
<div class="gold-bar"></div>

<div class="page">
    <div class="form-card">
        <div class="form-card-header">
            <h2>Room details</h2>
        </div>

        <form method="POST">
            <div class="form-card-body">

                <div class="form-group">
                    <label for="txtroom">Room name</label>
                    <input type="text" id="txtroom" name="txtroom" placeholder="e.g. Room 101">
                </div>

                <div class="form-group">
                    <label for="txtcapacity">Capacity</label>
                    <input type="number" id="txtcapacity" name="txtcapacity" placeholder="e.g. 30">
                </div>

                <div class="form-group">
                    <label for="txtstatus">Status</label>
                    <select id="txtstatus" name="txtstatus">
                        <option>Available</option>
                        <option>Unavailable</option>
                    </select>
                </div>

            </div>

            <div class="form-card-footer">
                <a href="rooms.php" class="btn-cancel">Cancel</a>
                <input type="submit" name="btnAdd" value="Add Room" class="btn-submit">
            </div>
        </form>
    </div>
</div>

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

<?php include '../includes/footer.php'; ?>