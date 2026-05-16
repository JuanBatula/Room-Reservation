<?php
include '../connect.php';
include '../includes/header.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM tbroom WHERE room_id=$id"));
?>

<link rel="stylesheet" href="../styles/edit_room.css">

<div class="topbar">
    <div class="topbar-left">
        <div class="topbar-accent"></div>
        <h1>Edit Room</h1>
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
                    <label for="room">Room name</label>
                    <input type="text" id="room" name="room"
                        value="<?php echo htmlspecialchars($data['room_name']); ?>"
                        placeholder="e.g. Room 101">
                </div>

                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" id="capacity" name="capacity"
                        value="<?php echo htmlspecialchars($data['capacity']); ?>"
                        placeholder="e.g. 30">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="Available"   <?php if($data['status'] == 'Available')   echo 'selected'; ?>>Available</option>
                        <option value="Occupied"    <?php if($data['status'] == 'Occupied')    echo 'selected'; ?>>Occupied</option>
                        <option value="Unavailable" <?php if($data['status'] == 'Unavailable') echo 'selected'; ?>>Unavailable</option>
                    </select>
                </div>

            </div>

            <div class="form-card-footer">
                <a href="rooms.php" class="btn-cancel">Cancel</a>
                <input type="submit" name="btnUpdate" value="Save Changes" class="btn-submit">
            </div>
        </form>
    </div>
</div>

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

<?php include '../includes/footer.php'; ?>