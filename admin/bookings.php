<?php
include '../connect.php';
include '../includes/header.php';


$sql = "SELECT tbbooking_request.*, tbuser.first_name, tbroom.room_name
        FROM tbbooking_request
        JOIN tbuser ON tbbooking_request.user_id = tbuser.user_id
        JOIN tbroom ON tbbooking_request.room_id = tbroom.room_id";

$result = mysqli_query($connection, $sql);
?>

<h2>Bookings</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Room</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?php echo $row['booking_id']; ?></td>
        <td><?php echo $row['first_name']; ?></td>
        <td><?php echo $row['room_name']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td>
            <?php if($row['status']=="pending"){ ?>
            <a href="approve.php?id=<?php echo $row['booking_id']; ?>&action=approve">Approve</a> |
            <a href="approve.php?id=<?php echo $row['booking_id']; ?>&action=reject">Reject</a>
            <?php } ?>
        </td>
    </tr>
<?php } ?>
</table>