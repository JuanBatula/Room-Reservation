<?php
include '../connect.php';
require_once '../includes/header.php';
?>

<div class="admin-body">
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-header-accent"></div>
            <h2>Dashboard</h2>
        </div>
    </div>

    <?php
    $sql = "SELECT
    (SELECT COUNT(*) FROM tbroom) AS totalRooms,
    (SELECT COUNT(*) FROM tbbooking_request) AS totalBookings,
    (SELECT COUNT(*) FROM tbuser) AS totalUsers ";

    $result = mysqli_query($connection, $sql);
    $data = mysqli_fetch_assoc($result);

    $totalRooms = $data['totalRooms'];
    $totalBookings = $data['totalBookings'];
    $totalUsers = $data['totalUsers'];

    ?>

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