<?php
include '../connect.php';
require_once '../includes/header.php';

$totalRooms = mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) total FROM tbroom"))['total'];

$totalBookings = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) total FROM tbbooking_request"))['total'];

$totalUsers = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) total FROM tbuser"))['total'];
?>

<h2>Admin Dashboard</h2>

<pre>
Total Rooms:      <?php echo $totalRooms; ?>

Total Bookings:   <?php echo $totalBookings; ?>

Total Users:      <?php echo $totalUsers; ?>
</pre>

<?php include '../includes/footer.php'; ?>