<?php
include '../connect.php';
include '../includes/header.php';

$sql = "SELECT tbbooking_request.*, 
               tbuser.first_name, 
               tbuser.last_name, 
               tbroom.room_name 
        FROM tbbooking_request
        JOIN tbuser ON tbbooking_request.user_id = tbuser.user_id
        JOIN tbroom ON tbbooking_request.room_id = tbroom.room_id";

$result = mysqli_query($connection, $sql);
?>

<h2>Booking Requests</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Room</th>
            <th>Date</th>
            <th>Time</th>
            <th>Purpose</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        while($row = mysqli_fetch_assoc($result)){ 
            $booking_id = $row['booking_id'];
            $full_name  = $row['first_name'] . " " . $row['last_name'];
            $time_slot  = $row['start_time'] . " - " . $row['end_time'];
            $status     = $row['status'];
        ?>
        <tr>
            <td><?php echo $booking_id; ?></td>
            <td><?php echo $full_name; ?></td>
            <td><?php echo $row['room_name']; ?></td>
            <td><?php echo $row['request_date']; ?></td>
            <td><?php echo $time_slot; ?></td>
            <td><?php echo $row['purpose']; ?></td>
            <td><?php echo $status; ?></td>
            <td>
                <?php if($status == "pending"){ ?>
                    <a href="approve.php?id=<?php echo $booking_id; ?>&action=approve" 
                       onclick="return confirm('Are you sure you want to approve this?')">
                       Approve
                    </a>
                    |
                    <a href="approve.php?id=<?php echo $booking_id; ?>&action=reject"
                       style="color: red;"
                       onclick="return confirm('Are you sure you want to reject this?')">
                       Reject
                    </a>
                <?php } else { ?>
                    <span>No Action</span>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>