<?php
include '../connect.php';
require_once '../includes/header.php';

$total = mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) t FROM tbbooking_request"))['t'];
$pending = mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) t FROM tbbooking_request WHERE status='pending'"))['t'];
?>

<h2>Dashboard</h2>

<pre>
Total Requests: <?php echo $total; ?>
Pending:        <?php echo $pending; ?>
</pre>

