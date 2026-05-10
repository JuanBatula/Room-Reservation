<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("location: ../auth/login.php");
}
?>

<h2>User Dashboard</h2>

<hr>

<a href="request_booking.php">Request Booking</a> |
<a href="../logout.php">Logout</a>

<hr>

<p>Welcome User!</p>