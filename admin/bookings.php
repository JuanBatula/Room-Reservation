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

<div class="admin-body">

    <div class="page-header">
        <div class="page-header-left">
            <div class="page-header-accent"></div>
            <h2>Booking Requests</h2>
        </div>
    </div>

    <div class="table-card">
        <table>
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

                    // Badge class
                    if ($status === 'pending')       $badgeClass = 'badge-pending';
                    elseif ($status === 'approved')  $badgeClass = 'badge-approved';
                    else                             $badgeClass = 'badge-rejected';
                ?>
                <tr>
                    <td><span class="id-pill">#<?php echo $booking_id; ?></span></td>
                    <td>
                        <div class="meta-primary"><?php echo htmlspecialchars($full_name); ?></div>
                    </td>
                    <td>
                        <div class="meta-primary"><?php echo htmlspecialchars($row['room_name']); ?></div>
                    </td>
                    <td><?php echo $row['request_date']; ?></td>
                    <td><?php echo $time_slot; ?></td>
                    <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                    <td>
                        <span class="badge <?php echo $badgeClass; ?>"><?php echo ucfirst($status); ?></span>
                    </td>
                    <td>
                        <?php if($status == "pending"){ ?>
                            <div class="action-links">
                                <a href="approve.php?id=<?php echo $booking_id; ?>&action=approve"
                                   class="btn-action btn-approve"
                                   onclick="return confirm('Are you sure you want to approve this?')">
                                   ✓ Approve
                                </a>
                                <a href="approve.php?id=<?php echo $booking_id; ?>&action=reject"
                                   class="btn-action btn-reject"
                                   onclick="return confirm('Are you sure you want to reject this?')">
                                   ✕ Reject
                                </a>
                            </div>
                        <?php } else { ?>
                            <span class="btn-no-action">No action</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<?php include '../includes/footer.php'; ?>