<?php
session_start();
include '../connect.php';

$id = $_GET['id'];
$action = $_GET['action'];
$status = ($action=="approve") ? "approved" : "rejected";

mysqli_query($connection,"UPDATE tbbooking_request SET status='$status' WHERE booking_id=$id");

mysqli_query($connection,"INSERT INTO tbapproval(booking_id,approval_date,decision_status,admin_id)
VALUES($id,NOW(),'$status',".$_SESSION['admin_id'].")");

header("location: bookings.php");
?>