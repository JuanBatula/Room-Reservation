<?php
include '../connect.php';
include '../includes/header.php';

$result = mysqli_query($connection,"SELECT * FROM tbroom");
?>

<h2>Rooms</h2>
<a href="add_room.php">Add Room</a>

<table border="1">
    <tr>
        <th>ID</th><th>Name</th><th>Capacity</th><th>Status</th><th>Action</th>
    </tr>

    <?php while($r=mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?php echo $r['room_id']; ?></td>
        <td><?php echo $r['room_name']; ?></td>
        <td><?php echo $r['capacity']; ?></td>
        <td><?php echo $r['status']; ?></td>
        <td><a href="edit_room.php?id=<?php echo $r['room_id']; ?>">Edit</a></td>
    </tr>
    <?php } ?>
</table>