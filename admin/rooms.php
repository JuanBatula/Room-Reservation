<?php
include '../connect.php';
include '../includes/header.php';

$result = mysqli_query($connection,"SELECT * FROM tbroom");
?>

<h2>Rooms</h2>

<a href="add_room.php">Add Room</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Room</th>
        <th>Capacity</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while($row=mysqli_fetch_assoc($result)){ ?>

    <tr>
        <td><?php echo $row['room_id']; ?></td>
        <td><?php echo $row['room_name']; ?></td>
        <td><?php echo $row['capacity']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td>
        <a href="edit_room.php?id=<?php echo $row['room_id']; ?>">Edit</a> |
        <a href="delete_room.php?id=<?php echo $row['room_id']; ?>">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>