<?php
include '../connect.php';
require_once '../includes/header.php';

$totalRooms = mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) total FROM tbroom"))['total'];

$totalBookings = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) total FROM tbbooking_request"))['total'];

$totalUsers = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) total FROM tbuser"))['total'];
?>

<div class="admin-body">

    <div class="page-header">
        <div class="page-header-left">
            <div class="page-header-accent"></div>
            <h2>Dashboard</h2>
        </div>
    </div>

    <div class="dash-stats">
        <div class="dash-stat">
            <div class="stat-icon">🏛️</div>
            <div class="stat-label">Total Rooms</div>
            <div class="stat-value"><?php echo $totalRooms; ?></div>
        </div>
        <div class="dash-stat gold">
            <div class="stat-icon">📋</div>
            <div class="stat-label">Total Bookings</div>
            <div class="stat-value"><?php echo $totalBookings; ?></div>
        </div>
        <div class="dash-stat green">
            <div class="stat-icon">👥</div>
            <div class="stat-label">Total Users</div>
            <div class="stat-value"><?php echo $totalUsers; ?></div>
        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>