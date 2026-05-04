<?php
include 'connect.php';
include 'includes/header.php';

$total = mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) as total FROM tbbooking_requests"))['total'];
$pending = mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) as total FROM tbbooking_requests WHERE status='pending'"))['total'];
$approved = mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) as total FROM tbbooking_requests WHERE status='approved'"))['total'];
$rejected = mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) as total FROM tbbooking_requests WHERE status='rejected'"))['total'];
?>

<h2>Dashboard</h2>

<pre>
Total Requests: <?php echo $total; ?>
Pending:        <?php echo $pending; ?>
Approved:       <?php echo $approved; ?>
Rejected:       <?php echo $rejected; ?>
</pre>

<?php include 'includes/footer.php'; ?>